<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  CMF class
     * @category     Global classes
     * @link         https://xbweb.org/doc/dist/classes/cmf
     */

    namespace xbweb;

    /**
     * Main CMF class
     */
    class CMF {
        /**
         * Get custom routes
         * @return array
         */
        public static function routes() {
            static $routes = null;
            if ($routes === null) {
                $routes = PipeLine::invoke('getRoutes', array(
                    'login'  => '/users/login',
                    'logout' => '/users/logout'
                ));
            }
            return $routes;
        }

        public static function init() {
            $modules = \xbweb::modules(true);
            foreach ($modules as $module) {
                $l = Paths\MODULES.'/'.$module.'/loader.php';
                if (file_exists($l)) require $l;
            }
        }

        /**
         * Get corrected route
         * @param string $page  Page path
         * @return array
         * @throws ErrorNotFound
         */
        public static function route($page) {
            $routes = static::routes();
            if (!isset($routes[$page])) throw new ErrorNotFound('Route not found');
            if (is_array($routes[$page])) {
                $routes[$page] = array_values($routes[$page]);
                if (empty($routes[$page][0])) throw new ErrorNotFound('Invalid route (empty)');
                $route = $routes[$page][0];
                $data  = empty($routes[$page][1]) ? null : $routes[$page][1];
            } else {
                if (empty($routes[$page])) throw new ErrorNotFound('Invalid route (empty)');
                $route = $routes[$page];
                $data  = array('context' => Request::get('context'));
            }
            return array(
                'route' => $route,
                'data'  => $data
            );
        }

        /**
         * Execute request
         * @return array
         * @throws \Exception
         */
        public static function execute() {
            Session::init();
            $file = Request::get('file');
            if ($file !== false) {
                if (empty($file)) throw new ErrorNotFound('XBWeb file not set');
                if ((trim($file) == 'css/xbvcl') || (trim($file) == 'css/xbvcl/index.php')) {
                    /** @noinspection PhpUnusedLocalVariableInspection */
                    $fontroot = '/xbweb/css/xbvcl/';
                    require Paths\CORE.'content/css/xbvcl/index.php';
                    exit;
                }
                $file = Paths\CORE.'content/'.$file;
                $mime = lib\Files::getMIMEByExt($file);
                if (!file_exists($file)) throw new ErrorNotFound('XBWeb file not found', Request::get('file'));
                header("Content-type: {$mime}; charset=".Config::get('charset', 'utf-8'));
                readfile($file);
                exit;
            }
            if (Config::get('debug') && Config::get('503')) {
                $ips = \xbweb::arg(Config::get('debug_ips'));
                if (!in_array('127.0.0.1', $ips)) $ips[] = '127.0.0.1';
                $cip = empty($_SERVER['REMOTE_HOST']) ? '127.0.0.1' : $_SERVER['REMOTE_HOST'];
                if (!in_array($cip, $ips)) throw new ErrorPage('Service is unavailable', 503);
            }
            $controller = Request::get('controller');
            if (empty($controller)) {
                if (Request::get('context') == Request::CTX_ADMIN) {
                    if (Request::get('page') == '') User::checkAdminAllowed();
                }
                $page = Request::get('page');
                $routes = static::routes();
                if (empty($routes[$page])) return self::page();
                $route = static::route($page);
                Request::current($route['route'], $route['data']);
                return Controller::action(Request::get('node'), Request::get('action'));
            } else {
                return Controller::action();
            }
        }

        /**
         * "Static" page processing
         * @param string $path  Page path
         * @param bool   $sys   Include system path
         * @return array
         * @throws ErrorNotFound
         */
        public static function page($path = null, $sys = false) {
            $page   = empty($path) ? Request::get('page') : $path;
            $module = Request::get('module');
            if (empty($page)) $page = 'index';
            $fn = lib\Content::file($page.'.'.lib\Content::EXT_PAGE, 'pages', $module, $sys);
            if (empty($fn)) {
                $fd = PipeLine::invoke('pageNotFound', array(), $page);
                if (empty($fd)) throw new ErrorNotFound('Page not found', $page);
                return $fd;
            }
            return array(
                'module' => $module,
                'page'   => $page,
                'status' => 'success'
            );
        }

        /**
         * @return bool
         */
        public static function isError() {
            return (http_response_code() > 399);
        }

        /**
         * Invoke magic method
         * @return array
         * @throws \Exception
         */
        public function __invoke() {
            return static::execute();
        }
    }