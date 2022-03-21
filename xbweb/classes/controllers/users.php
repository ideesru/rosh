<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.ru
     *
     * @description  User controller
     * @category     Core controllers
     * @link         https://xbweb.ru/doc/dist/classes/controllers/users
     */

    namespace xbweb\Controllers;

    use xbweb\ErrorForbidden;
    use xbweb\ErrorNotFound;

    use xbweb\lib\Roles      as LibRoles;
    use xbweb\Entities\Users as LibUsers;

    use xbweb\Config;
    use xbweb\Mailer;
    use xbweb\Request;
    use xbweb\Session;
    use xbweb\Model;
    use xbweb\User;

    use xbweb\DB;
    use xbweb\DB\Where;

    /**
     * User controller class
     */
    class Users extends Entity {
        const MODEL  = '/users';
        const ENTITY = 'user';

        /**
         * Constructor
         * @param string $path   Controller path
         * @param string $model  Model path
         */
        protected function __construct($path, $model) {
            parent::__construct($path, $model);
            $where = $this->_fused_where();
            $rmask = ~ LibRoles::toInt('moderator,admin,root');
            $r_val = "(`role` & {$rmask})";
            foreach (array('moderator', 'admin', 'root', 'user') as $k) {
                $value = "({$r_val} | ".(LibRoles::toInt($k)).')';
                $this->_queries['make'.$k] = array(
                    'title'   => 'Confirm make '.$k,
                    'success' => 'User is '.$k.' now',
                    'error'   => 'Error making user '.$k,
                    'confirm' => 'Change user role to '.$k.'?',
                    'query'   => "update `[+table+]` set `flags` = ({$value}) where " . $where
                );
            }
            $this->_queries['activate'] = array(
                'title'   => 'Confirm activate user',
                'success' => 'User is activated',
                'error'   => 'Error activate user',
                'confirm' => 'Activate user?',
                'query'   => "update `[+table+]` set `activated` = now() where " . $where
            );
        }

        /**
         * onConstruct
         * @throws \xbweb\Error
         * @throws \xbweb\ErrorNotFound
         * @throws \xbweb\NodeError
         */
        protected function onConstruct() {
            $model = Model::create($this->_model);
            $this->_fuse = Where::create($model);
            switch (User::current()->role) {
                case 'user'     : $this->_fuse->condition($model->primary, User::current()->id); break;
                case 'moderator': $this->_fuse->condition('role', 'moderator,admin,root', 'isnot'); break;
                case 'admin'    : $this->_fuse->condition('role', 'admin,root', 'isnot'); break;
                case 'root'     : $this->_fuse->condition('role', 'root', 'isnot'); break;
                default         : $this->_fuse->condition($model->primary, 0); break;
            }
        }

        /**
         * Login
         * @action /users/login
         * @return array
         * @throws \xbweb\Error
         */
        public function do_login() {
            if (User::current()->authorized) static::redirectBack();
            if (Request::isPost()) {
                $errors = array();
                if (empty($_POST['login']))    $errors['login']    = 'empty';
                if (empty($_POST['password'])) $errors['password'] = 'empty';
                if (!empty($errors)) return static::error($errors);
                try {
                    $user = LibUsers::getByLogin($_POST['login']);
                } catch (\Exception $e) {
                    return static::error($e->getMessage());
                }
                if ($user['password'] != \xbweb\password($_POST['password'])) {
                    Session::instance()->failed();
                    return static::error('Incorrect password');
                }
                User::current($user, !empty($_POST['safe']));
                if (Request::isAJAX()) return self::success($user);
                return static::redirectBack();
            }
            $ret = static::success();
            return $ret;
        }

        /**
         * Logout
         * @action /users/logout
         * @throws \xbweb\Error
         */
        public function do_logout() {
            if (!User::current()->authorized) \xbweb::redirect('/');
            User::current(false);
            if (Request::isAJAX()) return self::success();
            return static::redirectBack();
        }

        /**
         * Register user
         * @action /users/register
         * @return array
         * @throws \xbweb\Error
         */
        public function do_register() {
            if (User::current()->authorized) static::redirectBack();
            $model = Model::create($this->_model);
            $errors = null;
            if (Request::isPost()) {
                list($request, $errors) = $model->request('create', 'register', true);
                $request['key'] = true;
                if (!Config::get('users/activation', false)) $request['activated'] = true;
                if (empty($errors)) {
                    if ($result = $model->add($request)) {
                        $user = LibUsers::getByID($result);
                        if (Config::get('users/activation', false)) {
                            $key = $this->_gkey($user, 'activation');
                            $url = Request::canonical('/activation?user=' . $user['id'] . '&key=' . $key);
                            if (!$this->_mail($user, array('url' => $url))) return self::error('Cannot sent registration mail');
                            return self::message('Registration successfull! Check your email for activation');
                        } else {
                            if (!$this->_mail($user)) return self::error('Cannot sent registration mail');
                            $this->_logged($user);
                        }
                    }
                    $errors = 'Unable to register user';
                }
            }
            return self::form($model->form('create'), $errors);
        }

        /**
         * User activation
         * @action /users/activation
         * @return array
         * @throws ErrorForbidden
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         */
        public function do_activation() {
            if (empty($_GET['user']) || empty($_GET['key'])) throw new ErrorForbidden('No key or user for activation');
            $user = LibUsers::getByID(intval($_GET['user']));
            if (empty($user)) throw new ErrorNotFound('User not found');
            $key = $this->_gkey($user, 'activation');
            if ($key != $_GET['key']) throw new ErrorForbidden('Invalid activation key');
            $sql = 'update `[+prefix+]users` set `activated` = now() where `id` = '.$user['id'];
            if ($result = DB::query($sql)) if ($result->success) $this->_logged($user, 'User activated successfully');
            return self::error('Error user activation');
        }

        /**
         * Remain password
         * @action /users/remainpass
         * @return array
         * @throws \xbweb\Error
         */
        public function do_remainpass() {
            if (Request::isPost()) {
                if (empty($_POST['email'])) return self::error('Email not sent');
                $user = LibUsers::getByLogin($_POST['email']);
                if (empty($user)) throw new ErrorNotFound('User not found');
                $key = $this->_gkey($user, 'password');
                $url = Request::canonical('/changepass?user=' . $user['id'] . '&key=' . $key);
                if (!Mailer::create()
                    ->from(Request::mailbox('no-reply'))
                    ->to($user['email'])
                    ->send('remainpass', 'Change password', array(
                        'user' => $user,
                        'url'  => $url
                    ))) return self::error('Cannot sent registration mail');
                return self::message('Check your email for reset password link');
            } else {
                return self::form();
            }
        }

        /**
         * Change password
         * @action /users/changepass
         * @return array
         * @throws ErrorForbidden
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         */
        public function do_changepass() {
            if (empty($_REQUEST['user']) || empty($_REQUEST['key'])) throw new ErrorForbidden('No key or user for change password');
            $user = intval($_REQUEST['user']);
            $user = LibUsers::getByID($user);
            if (empty($user)) throw new ErrorNotFound('User not found');
            $key = $this->_gkey($user, 'password');
            if ($key != $_REQUEST['key']) throw new ErrorForbidden('Invalid key');
            if (Request::isPost()) {
                if (empty($_REQUEST['password'])) return self::error('Password not set');
                $k = \xbweb::key();
                $p = \xbweb\password($_REQUEST['password']);
                $q = <<<sql
update `[+prefix+]users` set `key` = '{$k}', `password` = '{$p}' where `id` = '{$user['id']}'
sql;
                if ($result = DB::query($q, true)) {
                    if ($result->success) {
                        return $this->_logged($user, 'Password changed successfully');
                    }
                }
                return self::error('Password change error');
            } else {
                return self::form(array(
                    'user' => intval($_GET['user']),
                    'key'  => $_GET['key'],
                ));
            }
        }

        /**
         * @param $id
         * @return bool
         */
        protected function _ckey($id) {
            $k = \xbweb::key();
            $q = "update `[+prefix+]users` set `key` = '{$k}' where `id` = '{$id}'";
            if ($result = DB::query($q, true)) return $result->success;
            return false;
        }

        /**
         * @param $user
         * @param $name
         * @return string
         */
        protected function _gkey($user, $name) {
            return md5($name.': '.$user['id'].'/'.$user['key']);
        }

        /**
         * @param $user
         * @param null $data
         * @return mixed
         * @throws \xbweb\Error
         */
        protected function _mail($user, $data = null) {
            $vars = array();
            if (is_array($data)) foreach ($data as $k => $v) $vars[$k] = $v;
            $vars['user'] = $user;
            return Mailer::create()
                ->from(Request::mailbox('no-reply'))
                ->to($user['email'])
                ->send('register', 'Registration', $vars);
        }

        /**
         * Autologin and redirect
         * @param array  $user  User
         * @param string $msg   Message
         * @return array
         * @throws \xbweb\Error
         */
        protected function _logged($user, $msg = null) {
            $url = '/';
            if (Config::get('users/autologin', false)) {
                User::current($user);
                $url = Config::get('users/autologin_url', '/');
            }
            if ($msg) return self::message($msg, $url);
            \xbweb::redirect($url);
            return array(); // Fix for IDE
        }
    }