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
         * @param string $folder  Folder name
         * @param string $module  Module name
         * @return string
         */
        public static function path($folder, $module = null) {
            $ctx = Request::get('context');
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
            if (is_array($file)) {
                foreach ($paths as $path) foreach ($file as $fn) {
                    $list[] = $path.$fn;
                    if (file_exists($path.$fn)) return $path.$fn;
                }
            } else {
                foreach ($paths as $path) {
                    $list[] = $path.$file;
                    if (file_exists($path.$file)) return $path.$file;
                }
            }
            return false;
        }
    }