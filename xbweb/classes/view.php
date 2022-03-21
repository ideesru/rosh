<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Basic view system
     * @category     View components
     * @link         https://xbweb.org/doc/dist/classes/view
     */

    namespace xbweb;

    use xbweb\lib\Content;
    use xbweb\lib\Template;

    /**
     * Basic view system class
     */
    class View {
        /**
         * Get template file
         * @param string $path  Request path
         * @param mixed  $data  Data
         * @param bool   $sys   Include system content folder
         * @return string
         */
        public static function template($path = null, $data = null, $sys = false) {
            $req = ($path === null) ? Request::get() : Request::route($path);
            if (empty($data['template'])) {
                $fn  = empty($req['template']) ? 'index' : $req['template'];
                $mod = $req['module'];
            } else {
                $fn  = explode('/', $data['template']);
                $mod = array_shift($fn);
                $fn  = implode('/', $fn);
            }
            $fn  = Content::file($fn.'.'.Content::EXT_TPL, 'templates', $mod, $sys, $_fl);
            return Content::render($fn, $data, $_fl);
        }

        /**
         * Get template file
         * @param string $path  Request path
         * @param mixed  $data  Data
         * @param bool   $sys   Include system content folder
         * @return string
         */
        public static function content($path = null, $data = null, $sys = false) {
            if (CMF::isError()) return self::_error();
            $req = ($path === null) ? Request::get() : Request::route($path);
            $fn  = empty($req['page']) ? 'index' : $req['page'];
            $dlg = array($fn.'.'.Content::EXT_PAGE);
            if (!empty($data['window'])) {
                $tpl = $data['window'] === true ? (
                    empty($data['status']) ? 'success' : $data['status']
                ) : $data['window'];
                $dlg[] = $tpl.'.'.Content::EXT_PAGE;
            }
            $fn  = Content::file($dlg, 'pages', $req['module'], $sys, $_fl);
            return Content::render($fn, $data, $_fl);
        }

        /**
         * Get template file
         * @param string $path  Request path
         * @param mixed  $data  Data
         * @param bool   $sys   Include system content folder
         * @return string
         */
        public static function chunk($path, $data = null, $sys = false) {
            $nodes  = explode('/', $path);
            $module = array_shift($nodes);
            $fn     = Content::file(implode('/', $nodes).'.'.Content::EXT_TPL, 'chunks', $module, $sys, $_fl);
            return Content::render($fn, $data, $_fl);
        }

        /**
         * @param string $place  Menu placement
         * @param mixed  $tpls   Templates
         * @return string
         * @throws Error
         */
        public static function menu($place, $tpls = null) {
            $data = array();
            switch ($place) {
                case 'adminleft':
                case 'userprofile':
                    $fn = Paths\CORE.'data/menu/'.$place.'.json';
                    if (file_exists($fn)) $data = json_decode(file_get_contents($fn), true);
                    break;
            }
            if (empty($data)) return '';
            return Template::menu($data, $tpls, $place);
        }

        /**
         * Render view
         * @param mixed  $data  Variables
         * @param string $path  Render path
         * @return string
         */
        public static function render($data = null, $path = null) {
            if (CMF::isError()) {
                // Template
                $fnt = Content::file(array(
                    'errors/'.http_response_code().'.'.Content::EXT_TPL,
                    'errors/500.'.Content::EXT_TPL,
                    'error.'.Content::EXT_TPL
                ), 'templates', Request::get('module'), true, $_fl_tpl);
                $tpl = ($fnt === false) ? Paths\CORE.'content/templates/error.'.Content::EXT_TPL : $fnt;
                // Content
                $content = self::_error($data);
                if (Request::isAJAX()) {
                    return $content;
                } else {
                    $data['content'] = $content;
                    return Content::render($tpl, $data, $_fl_tpl);
                }
            } else {
                $content = self::content($path, $data, true);
                if (Request::isAJAX()) {
                    return $content;
                } else {
                    $data['content'] = $content;
                    return self::template($path, $data, true);
                }
            }
        }

        /**
         * Converts seconds to other units
         * @param mixed  $v  Input value
         * @param string $u  Units
         * @return string
         */
        public static function seconds($v, $u = '') {
            $v = floatval($v);
            switch ($u) {
                case 'ms': $v *= 1000; break;
                case 'us': $v *= 1000000; break;
                case 'ns': $v *= 1000000000; break;
            }
            return strval(round($v, 2));
        }

        /**
         * Converts bytes to more higher units
         * @param mixed  $v  Input value
         * @param string $u  Units
         * @return string
         */
        public static function bytes($v, $u = '') {
            $v = intval($v);
            switch ($u) {
                case 'kb': $v /= 1024; break;
                case 'mb': $v /= 1048576; break;
                case 'gb': $v /= 1073741824; break;
            }
            return strval(round($v, 2));
        }

        protected static function _error($data = null) {
            // Current vars
            $fnc = Content::file(array(
                'errors/'.http_response_code().'.'.Content::EXT_PAGE,
                'errors/500.'.Content::EXT_PAGE,
                'error.'.Content::EXT_PAGE
            ), 'pages', Request::get('module'), true, $_fl_cnt);
            $cnt = ($fnc === false) ? Paths\CORE.'content/pages/error.'.Content::EXT_PAGE : $fnc;
            return Content::render($cnt, $data, $_fl_cnt);
        }
    }