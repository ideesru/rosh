<?php /** @noinspection PhpUnhandledExceptionInspection */
    /**
     * XBWeb CMF
     * @author     Xander Bass
     * @copyright  Copyright (c) Xander Bass
     * @license    https://opensource.org/licenses/mit-license.php MIT License
     * @link       https://xbweb.org
     *
     * @description Main framework loader
     */

    /**** BACKWARD COMPATIBILITY ****/
    namespace {
        defined('JSON_PRETTY_PRINT')      or define('JSON_PRETTY_PRINT', 128);
        defined('JSON_UNESCAPED_SLASHES') or define('JSON_UNESCAPED_SLASHES', 64);

        if (!function_exists('http_response_code')) {
            function http_response_code($response_code = 0) {
                static $code = null;
                if (empty($code)) $code = 200;
                if (!empty($response_code)) $code = intval($response_code);
                return $code;
            }
        }
    }

    /**** FOLDERS NAME ****/
    namespace xbweb\Folders {
        /**** Core folder name ****/
        defined(__NAMESPACE__.'\\CORE') or define(__NAMESPACE__.'\\CORE', 'xbweb');

        /**** Modules folder name ****/
        defined(__NAMESPACE__.'\\MODULES') or define(__NAMESPACE__.'\\MODULES', 'modules');

        /**** Project content folder name ****/
        defined(__NAMESPACE__.'\\CONTENT') or define(__NAMESPACE__.'\\CONTENT', 'www');

        /**** Project admin panel content folder name ****/
        defined(__NAMESPACE__.'\\ADMIN') or define(__NAMESPACE__.'\\ADMIN', 'admin');
    }

    /**** PATHS ****/
    namespace xbweb\Paths {
        /**** Root path where core folder is located ****/
        if (!defined(__NAMESPACE__.'\\ROOT')) {
            $root = rtrim(strtr(realpath(rtrim(strtr(dirname(__FILE__), '\\', '/'), '/').'/..'), '\\', '/'), '/').'/';
            define(__NAMESPACE__.'\\ROOT', $root);
        }

        /**** Root path where public (content) files and folders are located ****/
        if (!defined(__NAMESPACE__.'\\WEBROOT')) {
            $root = rtrim(strtr($_SERVER['DOCUMENT_ROOT'], '\\', '/'), '/').'/';
            define(__NAMESPACE__.'\\WEBROOT', $root);
        }

        /**** Path where project content files and folders are located ****/
        define(__NAMESPACE__.'\\COREINWEB', ROOT == WEBROOT);

        /**** Path where runtime files and folders are located ****/
        defined(__NAMESPACE__.'\\RUNTIME') or define(__NAMESPACE__.'\\RUNTIME', WEBROOT.'var/');

        /**** Path where core files and folders are located ****/
        defined(__NAMESPACE__.'\\CORE') or define(__NAMESPACE__.'\\CORE', ROOT.(\xbweb\Folders\CORE).'/');

        /**** Path where core files and folders are located ****/
        defined(__NAMESPACE__.'\\CLASSES') or define(__NAMESPACE__.'\\CLASSES', ROOT.(\xbweb\Folders\CORE).'/classes/');

        /**** Path where core files and folders are located ****/
        defined(__NAMESPACE__.'\\LIB') or define(__NAMESPACE__.'\\LIB', CLASSES.'lib/');

        /**** Path where modules folders are located ****/
        defined(__NAMESPACE__.'\\MODULES') or define(__NAMESPACE__.'\\MODULES', ROOT.(\xbweb\Folders\MODULES).'/');

        /**** Path where project content files and folders are located ****/
        defined(__NAMESPACE__.'\\CONTENT') or define(__NAMESPACE__.'\\CONTENT', WEBROOT.(\xbweb\Folders\CONTENT).'/');

        /**** Path where project content files and folders are located ****/
        defined(__NAMESPACE__.'\\ADMIN') or define(__NAMESPACE__.'\\ADMIN', WEBROOT.(\xbweb\Folders\ADMIN).'/');
    }

    namespace xbweb\URLs {
        /**** Login URL ****/
        defined(__NAMESPACE__.'\\LOGIN') or define(__NAMESPACE__.'\\LOGIN', '/users/login');
    }

    namespace xbweb {
        defined(__NAMESPACE__.'\\CACHE_JSON_FLAGS') or define(__NAMESPACE__.'\\CACHE_JSON_FLAGS', (
            \JSON_UNESCAPED_SLASHES | \JSON_PRETTY_PRINT
        ));
    }

    /**** MAIN CLASS ****/
    namespace {
        class xbweb {
            const EMERGENCY_COUNTER = 30;
            const RANDOM_SYMBOLS    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            const REX_PHONE = '~^([\-\+]?)(\d{11})$~si';
            const REX_EMAIL = '~^([\w\.\-]+)\@([\w\.\-]+)$~siu';
            const REX_LOGIN = '~^([\p{Latin}])([\p{Latin}\d\_\-\.\s]+)([\p{Latin}\d])$~si';

            /**
             * Convert any argument to array
             * @param mixed $v  Input argument
             * @param bool  $i  Return integer values
             * @return array
             */
            public static function arg($v, $i = false) {
                if (empty($v)) return array();
                $r = is_array($v) ? $v : explode(',', strval($v));
                $r = array_map('trim', $r);
                if ($i) $r = array_map('intval', $r);
                return $r;
            }

            /**
             * Simple switch-case
             * @param array $l  Variants
             * @param mixed $v  Value
             * @param mixed $d  Default
             * @return mixed
             */
            public static function v(array $l, $v, $d) {
                foreach ($l as $k => $kv) if ($v == $k) return $kv;
                return $d;
            }

            /**
             * Regexp valid
             * @param string $v  Regexp
             * @param int    $e  Error code
             * @return bool
             */
            public static function rexValid($v, &$e = 0) {
                try {
                    preg_match($v, null);
                    $e = preg_last_error();
                    return (PREG_NO_ERROR == $e);
                } catch (\Exception $e) {
                    $e = preg_last_error();
                    return false;
                }
            }

            /**
             * Generates string of random symbols
             * @param int $c  Symbols count
             * @return string
             */
            public static function key($c = 32) {
                $sym = self::RANDOM_SYMBOLS;
                for ($_ = 0, $r = ''; $_ < $c; $_++) $r.= $sym[mt_rand(0, 61)];
                return $r;
            }

            /**
             * Generate string-based unique ID
             * @param string $s  Input string
             * @return string
             */
            public static function id($s = '') {
                return md5($s.(\xbweb::now()).(\xbweb::key()));
            }

            /**
             * Correct any slashes in string
             * @param string $v  Input string
             * @return string
             */
            public static function slash($v) {
                return preg_replace('~([\/]{2,})~', '/', strtr($v, '\\', '/'));
            }

            /**
             * Correct path string
             * @param string $v  Input string
             * @param bool   $l  To lower case
             * @return string
             */
            public static function path($v, $l = true) {
                $v = rtrim(self::slash($v), '/').'/';
                return $l ? strtolower($v) : $v;
            }

            /**
             * Converts rights string to integer value
             * @param string $s  Rights string
             * @return int
             */
            public static function rights($s) {
                if (strlen($s) < 3) return 0;
                $z = floor(strlen($s) / 3);
                $v = 0;
                for ($g = 0; $g < $z; $g++) {
                    $r  = substr($s, -3 - (3 * $g), 3);
                    $v += (($r{2} == 'r' ? 4 : 0) + ($r{1} == 'w' ? 2 : 0) + ($r{0} == 'x' ? 1 : 0)) << (3 * $g);
                }
                return $v;
            }

            /**
             * Get NOW datetime string
             * @return string
             */
            public static function now() {
                $dto = new DateTime();
                return $dto->format('Y-m-d H:i:s');
            }

            /**
             * Redirect to URL
             * @param string $url   URL
             * @param bool   $h301  Send 301
             */
            public static function redirect($url, $h301 = false) {
                if ($h301) header($_SERVER['SERVER_PROTOCOL'].' 301 Moved Permanently');
                header('Location: '.$url);
                exit;
            }

            /**
             * Get HTTP status string by HTTP status code
             * @param int $key  HTTP code
             * @return string
             */
            public static function HTTPStatus($key) {
                static $data = null;
                if (empty($data)) $data = self::data_('http');
                return empty($data[$key]) ? 'Unknown' : $data[$key];
            }

            /**
             * Get MIME-type by file extension
             * @param string $key  Extension
             * @return string
             */
            public static function MIMEType($key) {
                static $data = null;
                if (empty($data)) $data = self::data_('mime');
                return empty($data[$key]) ? 'application/octet-stream' : $data[$key];
            }

            /**
             * Get CMF icon
             * @param bool $base64  Return base64 data
             * @return string
             */
            public static function icon($base64 = null) {
                if ($base64 === null) $base64 = xbweb\Paths\COREINWEB;
                if ($base64) return 'data:image/png;base64,'.base64_encode(file_get_contents(xbweb\Paths\CORE.'content/logo.png'));
                return '/xbweb/content/logo.png';
            }

            /**
             * @param bool $reload
             * @return array|null
             */
            public static function modules($reload = false) {
                static $modules = null;
                if (($modules === null) || $reload) {
                    defined('xbweb\\CONFIG\\Modules') or define('xbweb\\CONFIG\\Modules', true);
                    $path = xbweb\Paths\MODULES;
                    if (empty($path) || !is_dir($path)) return array();
                    $ML   = xbweb\CONFIG\Modules;
                    $incl = ($ML === true) ? true : array_map('trim', explode(',', $ML));
                    $modules = array();
                    if ($files = scandir($path)) foreach ($files as $i) {
                        if (is_file($path.'/'.$i) || ($i == '.') || ($i == '..')) continue;
                        if (is_array($incl)) if (!in_array($i, $incl)) continue;
                        $modules[] = $i;
                    }
                }
                return $modules;
            }

            /**
             * Get controllers for module or system
             * @param string $module  Name of module. NULL for system
             * @return array
             */
            public static function controllers($module = null) {
                return self::nodes('controller', $module, (empty($module) ? array(
                    'entity', 'table', 'fields', 'fieldsets'
                ) : array(
                    'entity', 'table'
                )));
            }

            /**
             * Get class name by node path and include class
             * @param string $path  Node path
             * @param string $type  Node type
             * @return string
             * @throws Exception
             */
            public static function uses($path, $type = null) {
                $cn = self::realClass($path, $type, $fn);
                if (!class_exists($cn, false)) {
                    if (!file_exists($fn)) {
                        http_response_code(500);
                        throw new Exception("No class file for '{$cn}' in '{$fn}'");
                    }
                    require $fn;
                    if (!class_exists($cn, false)) {
                        http_response_code(500);
                        throw new Exception("No class '{$cn}' in '{$fn}'");
                    }
                }
                return $cn;
            }

            public static function realClass($path, $type = null, &$fn = false) {
                static $cache = null;
                if ($cache === null) $cache = array();
                $type = empty($type) ? 'Controller' : $type;
                if (!empty($cache[$type][$path])) {
                    $fn = $cache[$type][$path][1];
                    return $cache[$type][$path][0];
                }
                $P = explode('/', $path);
                $mn   = array_shift($P);
                $fn   = (empty($mn) ? xbweb\Paths\CORE : xbweb\Paths\MODULES.strtolower($mn).'/').'classes/';
                $cn   = array('xbweb');
                if (!empty($mn)) {
                    $cn[] = 'Modules';
                    $cn[] = $mn;
                }
                if (empty($P)) {
                    $fn  .= strtolower($type).'.php';
                    $cn[] = ucfirst($type);
                } else {
                    if (strtolower($P[0]) == strtolower($type)) {
                        $fn  .= strtolower($type).'.php';
                        $cn[] = ucfirst($type);
                    } else {
                        $fn  .= strtolower($type.'s/'.implode('/', $P)).'.php';
                        $cn[] = ucfirst($type).'s';
                        foreach ($P as $i) $cn[] = $i;
                    }
                }
                $cache[$type][$path] = array('\\'.implode('\\', $cn), $fn);
                return $cache[$type][$path][0];
            }

            /**
             * Get nodes for module or system
             * @param string $type     Node type
             * @param string $module   Module name or NULL for system
             * @param array  $exclude  Exclude list
             * @return array
             */
            public static function nodes($type, $module = null, $exclude = array()) {
                $path = (empty($module) ? xbweb\Paths\CORE : xbweb\Paths\MODULES.strtolower($module).'/').'classes/';
                $type = strtolower($type);
                if (!is_dir($path)) return array();
                $ret = array();
                if (file_exists($path.$type.'.php')) $ret[$type] = true;
                if (is_dir($path.$type.'s')) {
                    $nodes = self::nodes_($path.$type.'s', $exclude);
                    foreach ($nodes as $k => $v) $ret[$k] = $v;
                }
                return $ret;
            }

            /**
             * Internal function for getNodes
             * @param string $path     Root path
             * @param array  $exclude  Exclude list
             * @return array
             */
            protected static function nodes_($path, $exclude = array()) {
                $nodes = array();
                if ($files = scandir($path)) foreach ($files as $i) {
                    if (($i == '.') || ($i == '..')) continue;
                    $n = strtr($i, array('.php' => ''));
                    if (!empty($exclude) && is_array($exclude)) if (in_array($n, $exclude)) continue;
                    if (is_dir($path.'/'.$i)) {
                        $nodes[$n] = self::nodes_($path.'/'.$i);
                    } else {
                        if (isset($nodes[$n])) continue;
                        $nodes[$n] = true;
                    }
                }
                return $nodes;
            }

            /**
             * Get data file content
             * @param string $name  Name of data file
             * @return mixed
             */
            protected static function data_($name) {
                $filename = xbweb\Paths\CORE . 'data/' . $name . '.json';
                if (!file_exists($filename)) return false;
                return json_decode(file_get_contents($filename), true);
            }
        }
    }

    /**** ERRORS ****/
    namespace xbweb {
        /**
         * Standart exception
         */
        class Error extends \Exception {
            const T_PHP_ERROR        = 0x00000001;
            const T_PHP_EXCEPTION    = 0x00000001;
            const T_XBWEB_ERROR      = 0x00010001;
            const T_XBWEB_ERROR_PAGE = 0x00010002;
            const T_XBWEB_DB_ERROR   = 0x00020001;
            const T_XBWEB_NO_TABLE   = 0x00020002;
            const T_XBWEB_DUPLICATE  = 0x00040003;
            const T_XBWEB_NODE_ERROR = 0x00080001;
            const T_XBWEB_DATA_ERROR = 0x00080002;

            protected $httpCode = 500;
            protected $data     = array();
            protected $type     = 0;

            /**
             * Constructor
             * @param mixed $msg   Message string or full error data array
             * @param int   $code  Integer code
             * @param int   $lvl   Trace level
             */
            public function __construct($msg, $code = 0, $lvl = null) {
                if (empty($this->type)) $this->type = static::T_XBWEB_ERROR;
                if (is_array($msg)) {
                    if (isset($msg['type'])) $this->type = $msg['type'];
                    if (isset($msg['code'])) $this->code = $msg['code'];
                    if (isset($msg['file'])) $this->file = $msg['file'];
                    if (isset($msg['line'])) $this->line = $msg['line'];
                    $this->data = $msg;
                    $msg = empty($msg['message']) ? 'Error occured' : $msg['message'];
                }
                if ($lvl !== null) {
                    $lvl = intval($lvl);
                    $trace = $this->getTrace();
                    if (!empty($trace[$lvl])) {
                        $this->line = $trace['line'];
                        $this->file = $trace['file'];
                    }
                }
                $this->data['message'] = $msg;
                http_response_code($this->httpCode);
                parent::__construct($msg, $code);
            }

            /**
             * Get HTTP code
             * @return int
             */
            public function getHTTPCode() { return $this->httpCode; }

            /**
             * Get full data
             * @return array
             */
            public function getData() { return $this->data; }

            /**
             * Get error type
             * @return int
             */
            public function getType() { return $this->type; }

            /**
             * Get result array
             * @param \Exception $e  Any Exception
             * @return array
             */
            public static function getResponse(\Exception $e) {
                $ret = array(
                    'status'        => 'error',
                    'type'          => self::T_PHP_ERROR,
                    'message'       => $e->getMessage(),
                    'code'          => $e->getCode(),
                    'file'          => $e->getFile(),
                    'line'          => $e->getLine(),
                    'trace'         => $e->getTrace(),
                    'traceAsString' => $e->getTraceAsString(),
                    'data'          => array(),
                    'HTTPCode'      => 500
                );
                if ($e instanceof Error) {
                    $ret['type']       = $e->getType();
                    $ret['HTTPCode']   = $e->getHTTPCode();
                    $ret['data']       = $e->getData();
                }
                return $ret;
            }
        }

        class DataError extends Error {
            /**
             * Constructor
             * @param mixed $msg Error data, full data array or string
             * @param $data
             * @param int $code Integer code
             */
            public function __construct($msg, $data = array(), $code = 0) {
                $this->type = static::T_XBWEB_DATA_ERROR;
                parent::__construct(array(
                    'message' => $msg,
                    'data'    => $data
                ), $code);
            }
        }

        class NodeError extends Error {
            /**
             * Constructor
             * @param mixed $msg Error data, full data array or string
             * @param $path
             * @param int $code Integer code
             */
            public function __construct($msg, $path, $code = 0) {
                $this->type = static::T_XBWEB_NODE_ERROR;
                parent::__construct(array(
                    'message' => $msg,
                    'path'    => $path
                ), $code);
            }
        }

        class FieldError extends DataError {
            /**
             * Constructor
             * @param mixed  $msg    Error data, full data array or string
             * @param string $field  Field name
             */
            public function __construct($msg, $field) {
                parent::__construct($msg, array('name' => $field), 0);
            }
        }

        /**
         * Database error
         */
        class DBError extends Error {
            /**
             * Constructor
             * @param mixed $msg   Error data, full data array or string
             * @param int   $code  Integer code
             */
            public function __construct($msg, $code = 0) {
                $this->type = static::T_XBWEB_DB_ERROR;
                parent::__construct($msg, $code);
            }
        }

        /**
         * Database error
         */
        class NoTableError extends DBError {
            /**
             * Constructor
             * @param mixed $msg   Error data, full data array or string
             * @param int   $code  Integer code
             */
            public function __construct($msg, $code = 0) {
                $this->type = static::T_XBWEB_NO_TABLE;
                parent::__construct($msg, $code);
            }
        }

        class DuplicateError extends Error {
            /**
             * Constructor
             * @param mixed $msg   Error data, full data array or string
             * @param int   $code  Integer code
             */
            public function __construct($msg, $code = 0) {
                $this->type = static::T_XBWEB_DUPLICATE;
                parent::__construct($msg, $code);
            }
        }

        /**
         * HTTP error page
         */
        class ErrorPage extends Error {
            /**
             * Constructor
             * @param mixed $msg   Message string or full error data array
             * @param int   $code  Integer code
             */
            public function __construct($msg, $code = 0) {
                $this->type     = static::T_XBWEB_ERROR_PAGE;
                $this->httpCode = intval($code);
                parent::__construct($msg, $this->httpCode);
            }
        }

        /**
         * HTTP/403 Forbiddeb
         */
        class ErrorForbidden extends ErrorPage {
            /**
             * Constructor
             * @param mixed $msg  Message string or full error data array
             * @param null  $id   ID or URL
             */
            public function __construct($msg, $id = null) {
                $this->data['id'] = $id;
                parent::__construct($msg, 403);
            }
        }

        /**
         * HTTP/404 Not Found
         */
        class ErrorNotFound extends ErrorPage {
            /**
             * Constructor
             * @param mixed $msg  Message string or full error data array
             * @param null  $id   ID or URL
             */
            public function __construct($msg, $id = null) {
                $this->data['id'] = $id;
                parent::__construct($msg, 404);
            }
        }

        /**
         * HTTP/410 Gone
         */
        class ErrorDeleted extends ErrorPage {
            /**
             * Constructor
             * @param mixed $msg  Message string or full error data array
             * @param null  $id   ID or URL
             */
            public function __construct($msg, $id = null) {
                $this->data['id'] = $id;
                parent::__construct($msg, 410);
            }
        }
    }

    /**** MAIN SECTION ****/
    namespace {
        // Load primary libraries
        require 'classes/lib/arrays.php';
        require 'classes/lib/flags.php';
        require 'classes/lib/access.php';
        require 'classes/lib/files.php';
        // Load primary classes
        require 'classes/config.php';
        require 'classes/events.php';
        require 'classes/pipeline.php';
        require 'classes/request.php';
        require 'classes/db/provider.php';
        require 'classes/db/result.php';
        require 'classes/db.php';
        require 'classes/node.php';

        set_error_handler(function($en, $es, $ef, $el, $ec = null){
            throw new \xbweb\Error(array(
                'type'    => $en,
                'message' => $es,
                'file'    => $ef,
                'line'    => $el,
                'vars'    => $ec
            ));
        });

        spl_autoload_register(function($classname){
            $cn = explode('/', strtolower(strtr($classname, '\\', '/')));
            if (array_shift($cn) != 'xbweb') return true;
            if (empty($cn)) return true;
            switch ($cn[0]) {
                case 'modules':
                    array_shift($cn);
                    if (count($cn) < 2) {
                        http_response_code(500);
                        throw new Exception("Invalid module class '{$classname}'");
                    }
                    $mn = array_shift($cn);
                    $fn = xbweb\Paths\MODULES.$mn.'/classes/'.implode('/', $cn).'.php';
                    break;
                case 'www':
                case 'admin':
                    $mn = array_shift($cn);
                    if (empty($cn)) {
                        http_response_code(500);
                        throw new Exception("Invalid module class '{$classname}'");
                    }
                    $fn = xbweb\Paths\WEBROOT.$mn.'/classes/'.implode('/', $cn).'.php';
                    break;
                default:
                    $fn = xbweb\Paths\CORE.'classes/'.implode('/', $cn).'.php';
            }
            if (!file_exists($fn)) {
                http_response_code(500);
                throw new Exception("No class file for '{$classname}' in '{$fn}'");
            }
            require $fn;
            if (!class_exists($classname, false)) {
                http_response_code(500);
                throw new Exception("No class '{$classname}' in '{$fn}'");
            }
            return true;
        });
    }

    namespace xbweb {
        function password($v, $t = null) {
            if ($t === null) $t = Config::get('password_method', 'md5');
            switch ($t) {
                default: return md5($v);
            }
        }
    }

    namespace xbweb\Credits {
        define(__NAMESPACE__.'\\PRODUCT', 'XBWeb CMF');
        define(__NAMESPACE__.'\\VERSION', '0.1');
        define(__NAMESPACE__.'\\CORE'   , 'Lyta');
        define(__NAMESPACE__.'\\DBTYPE' , 'MySQL');
    }