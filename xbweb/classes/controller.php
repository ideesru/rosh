<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Controller prototype
     * @category     Controller prototypes
     * @link         https://xbweb.org/doc/dist/classes/controller
     */

    namespace xbweb;

    /**
     * Controller prototype class
     * @property-read string $modelPath
     */
    abstract class Controller extends Node {
        const NODE_TYPE      = 'Controller';
        const DEFAULT_ACTION = 'index';

        protected static $_map = array();

        protected $_queries   = array();
        protected $_modelPath = null;
        protected $_allowed   = array();

        protected function __construct($path, $model = null) {
            parent::__construct($path);
            $this->_modelPath = empty($model) ? $this->_path : $model;
        }

        /**
         * Execute action
         * @param string $action  Action (NULL for current)
         * @param string $method  Request method
         * @return mixed
         * @throws Error
         * @throws ErrorForbidden
         */
        public function execute($action = null, $method = null) {
            // Prepare params
            if ($action === null) {
                $action = Request::get('action');
                $method = strtolower($_SERVER['REQUEST_METHOD']);
            } else {
                if (empty($method)) $method = 'get';
            }
            $method = strtolower($method);
            if (empty($action)) $action = static::DEFAULT_ACTION;
            // Execute
            if (method_exists($this, 'do_'.$action) && $this->_a($action)) return $this->{'do_'.$action}();
            if (!empty($this->_queries[$action]) && $this->_a($action)) {
                $Q = $this->_queries[$action];
                if ($method != 'post') return self::dialog('confirm', $Q);
                if (method_exists($this, 'query_'.$action)) {
                    try {
                        return $this->{"query_{$action}"}();
                    } catch (\Exception $e) {
                        return self::error($e->getMessage());
                    }
                } elseif (!empty($Q['query'])) {
                    $T = empty($Q['table']) ? true : $Q['table'];
                    if ($sql = $this->_q($Q['query'])) {
                        if ($R = DB::query($sql, $T)) {
                            if ($R->success) return self::dialog('success', $Q);
                        }
                    }
                }
                return self::dialog('error', $Q);
            }
            throw new ErrorNotFound('Action not found', $this->_path.'/'.$action);
        }

        /**
         * Check if action is allowed and drop exception or redirect
         * @param string $action  Action (only action)
         * @return bool
         * @throws Error
         * @throws ErrorForbidden
         */
        protected function _a($action) {
            if (in_array($action, $this->_allowed)) return true;
            $a = $this->_path.'/'.$action;
            if (!ACL::granted($a)) {
                if (User::checkAuthorized())
                    throw new ErrorForbidden('You have no rights for this action', $a);
            }
            return true;
        }

        /**
         * Generic SQL query
         * @param string $sql  Input SQL query string
         * @return string
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         */
        protected function _q($sql) {
            $model = Model::create($this->_modelPath);
            $ids   = empty($_POST['id']) ? Request::get('id') : $_POST['id'];
            $ret   = array();
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if (!$model->validate($model->primary, $id)) continue;
                    $ret[] = $id;
                }
            } else {
                if ($model->validate($model->primary, $ids)) $ret[] = $ids;
            }
            $ids = empty($ret) ? false : (count($ret) > 1 ? " in ('".implode("','", $ret)."')" : " = '{$ret[0]}'");
            return empty($ids) ? false :  strtr($sql, array(
                '[+table+]'   => DB::table($model->table),
                '[+primary+]' => $model->primary,
                '[+ids+]'     => $ids,
                '[+id+]'      => Request::get('id')
            ));
        }

        /**
         * Return "ERROR" result
         * @param mixed $e  Errors array or error string
         * @return array
         */
        public static function error($e) {
            return array(
                'status' => 'error',
                'errors' => is_array($e) ? $e : array($e)
            );
        }

        /**
         * Return form
         * @param array $form
         * @param null $values
         * @param array $errors
         * @return array
         */
        public static function form($form = null, $values =  null, $errors = null) {
            $ret = array(
                'form'   => $form,
                'values' => $values,
                'status' => 'success'
            );
            if (!empty($errors)) {
                $ret['errors'] = $errors;
                $ret['status'] = 'error';
            }
            return $ret;
        }

        /**
         * Return "OK" result
         * @param mixed $data  Result data
         * @return array
         */
        public static function success($data = null) {
            $ret = array('status' => 'success');
            if ($data !== null) $ret['result'] = $data;
            return $ret;
        }

        public static function message($msg, $url = null) {
            return array(
                'status'   => 'redirect',
                'template' => '/message',
                'message'  => $msg,
                'url'      => $url
            );
        }

        /**
         * Return dialog
         * @param string $status  Status
         * @param array  $query   Query
         * @return array
         */
        public static function dialog($status, $query) {
            return array(
                'status'  => $status,
                'window'  => empty($query['window']) ? true             : $query['window'],
                'title'   => empty($query['title'])  ? ucfirst($status) : $query['title'],
                'content' => empty($query[$status])  ? ucfirst($status) : $query[$status]
            );
        }

        /**
         * Redirect to previous URL
         * @return null
         */
        public static function redirectBack() {
            \xbweb::redirect(Request::CTX_ADMIN == Request::get('context') ? '/admin' : '/'); // TODO
            return null; // Fix for IDE
        }

        /**
         * Create controller and execute some action
         * @param string $controller  Controller path
         * @param string $action      Action
         * @param string $method      Request method
         * @return array
         * @throws \Exception
         */
        public static function action($controller = null, $action = null, $method = null) {
            if ($controller === null) $controller = Request::get('node');
            /** @var Controller $obj */
            $obj = self::create($controller);
            return $obj->execute($action, $method);
        }

        /**
         * Create controller object
         * @param string $path Controller path
         * @param null $model
         * @return mixed
         * @throws ErrorNotFound
         */
        public static function create($path, $model = null) {
            try {
                $cn  = \xbweb::uses($path, static::NODE_TYPE);
                $obj = new $cn($path, $model);
            } catch (\Exception $e) {
                if (empty(self::$_map[$path])) {
                    throw new ErrorNotFound($e->getMessage(), $path);
                }
                try {
                    $cn  = '\\xbweb\\Controllers\\'.ucfirst(self::$_map[$path]['type']);
                    $obj = new $cn($path, self::$_map[$path]['model']);
                } catch (\Exception $ee) {
                    throw new ErrorNotFound('Generic controller not created', $path);
                }
            }
            return $obj;
        }

        /**
         * Register generic controller route
         * @param string $path   Virtual path
         * @param string $type   Generic type
         * @param string $model  Model path
         * @return bool
         */
        public static function registerGeneric($path, $type, $model = null) {
            $allowed = array('entity');
            if (!in_array($type, $allowed)) return false;
            self::$_map[$path] = array(
                'type'  => $type,
                'model' => empty($model) ? $path : $model
            );
            return true;
        }

        public static function map() {
            return self::$_map;
        }
    }