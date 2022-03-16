<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  User controller
     * @category     Core controllers
     * @link         https://xbweb.org/doc/dist/classes/controllers/users
     */

    namespace xbweb\Controllers;

    use xbweb\Config;
    use xbweb\PipeLine;
    use xbweb\Request;
    use xbweb\Session;
    use xbweb\User;

    use xbweb\Entities\Users as LibUsers;

    /**
     * User controller class
     */
    class Users extends Entity {
        const MODEL = '/users';

        protected $_entity = 'user';

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
         * @return array
         * @throws \xbweb\Error
         */
        public function do_register() {
            if (User::current()->authorized) static::redirectBack();
            if (Request::isPost()) {
                $_POST  = PipeLine::invoke('beforeUserRegisterPOST', $_POST);
                $fields = array(
                    'login' => array(
                        'required' => Config::get('users/login_required', true),
                        'regexp'   => Config::get('users/login_regexp'  , \xbweb::REX_LOGIN),
                    ),
                    'phone' => array(
                        'required' => Config::get('users/phone_required', false),
                        'regexp'   => \xbweb::REX_PHONE,
                        'strip'    => '~([^\-\+\d]+)~si',
                    ),
                    'email' => array(
                        'required' => Config::get('users/email_required', true),
                        'regexp'   => \xbweb::REX_EMAIL,
                    ),
                );
                $errors = array();
                foreach ($fields as $k => $v) {
                    if (empty($_POST[$k])) {
                        if ($v['required']) $errors[$k] = 'empty';
                    } else {

                    }
                }
            }
            return array();
        }

        /**
         * @return array
         */
        public function do_remainpass() {
            return array();
        }
    }