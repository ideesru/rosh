<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Common view functions
     * @category     Template systems libraries
     * @link         https://xbweb.org/doc/dist/classes/lib/content
     */

    namespace xbweb\lib;

    use xbweb\Request;

    /**
     * Common view functions
     */
    class Content {
        const EXT_PAGE = 'php';
        const EXT_TPL  = 'php';

        /**
         * Get folder for current context
         * @param string $folder Folder name
         * @param string $module Module name
         * @param null $ctx
         * @return string
         */
        public static function path($folder, $module = null, $ctx = null) {
            if ($ctx === null) $ctx = Request::get('context');
            $ret = empty($module) ? \xbweb\Paths\WEBROOT : \xbweb\Paths\MODULES.$module.'/';
            return $ret.$ctx.'/'.$folder.'/';
        }

        /**
         * Get file from content folder
         * @param mixed  $file    Relative filename or array of filenames
         * @param string $folder  Template type folder
         * @param string $module  Module
         * @param bool   $sys     Include system content folder
         * @param array  $list    List of processed files
         * @return mixed
         */
        public static function file($file, $folder, $module = null, $sys = true, &$list = array()) {
            $paths   = empty($module) ? array() : array(self::path($folder, $module));
            $paths[] = self::path($folder).(empty($module) ? '' : $module.'/');
            if ($sys) $paths[] = \xbweb\Paths\CORE.'content/'.$folder.'/';
            if (!is_array($file)) $file = array($file);
            foreach ($file as $fn) {
                foreach ($paths as $path) {
                    $list[] = $path.$fn;
                    if (file_exists($path.$fn)) return $path.$fn;
                }
            }
            return false;
        }

        /**
         * Get chunk
         * @param string $path  Chunk path
         * @param bool   $sys   Include system path
         * @param array  $list  File search list
         * @return mixed
         */
        public static function chunk($path, $sys = true, &$list) {
            $fn = explode(':', $path);
            $fc = count($fn) > 1 ? array_shift($fn) : Request::get('context');
            $fn = explode('/', implode('', $fn));
            $mn = array_shift($fn);
            $fn = implode('/', $fn);
            $paths   = empty($mn) ? array() : array(self::path('chunks', $mn, $fc));
            $paths[] = self::path('chunks', null, $fc).(empty($mn) ? '' : $mn.'/');
            if ($sys) $paths[] = \xbweb\Paths\CORE.'content/chunks/';
            foreach ($paths as $p) {
                $list[] = $p.$fn.'.'.self::EXT_TPL;
                if (file_exists($p.$fn.'.'.self::EXT_TPL)) return $p.$fn.'.'.self::EXT_TPL;
            }
            return false;
        }

        /**
         * Render template part
         * @param string $__path   Path
         * @param mixed  $__data   Variables
         * @param mixed  $__files  Debug files
         * @return string
         */
        public static function render($__path, $__data = null, $__files = null) {
            if (!empty($__path) && file_exists($__path)) {
                ob_start();
                if (is_array($__data)) extract($__data);
                unset($__data);
                include $__path;
                return ob_get_clean();
            } else {
                return '<!-- File not found: '.var_export($__files, true).' -->'.'<!-- '.var_export($__data, true).' -->';
            }
        }
    }