<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Array functions library
     * @category     Basic libraries
     * @link         https://xbweb.org/doc/dist/classes/lib/arrays
     */

    namespace xbweb\lib;

    /**
     * Array functions library
     */
    class Arrays {
        /**
         * Get the value from array by path
         * @param array  $a  Input array
         * @param string $k  Key
         * @param mixed  $d  Default value
         * @return mixed
         */
        public static function get(array $a, $k, $d = null) {
            $k = trim($k, '/');
            if (empty($k)) return $a;
            $k = explode('/', $k);
            $_ = $a;
            foreach ($k as $i) {
                if (!isset($_[$i])) return $d;
                $_ = $_[$i];
            }
            return $_;
        }

        /**
         * Set the value to array by path
         * @param array  $a  Input array
         * @param string $k  Key
         * @param mixed  $v  Value
         * @return mixed
         */
        public static function set(array &$a, $k, $v = null) {
            $k = trim($k, '/');
            if (empty($k)) {
                $a = $v;
            } else {
                $k = explode('/', $k);
                if (count($k) < 1) return false;
                $_ = &$a;
                $l = count($k) - 1;
                foreach ($k as $c => $i) {
                    if (!isset($_[$i]) || !is_array($_[$i])) $_[$i] = array();
                    if (($c === $l) && ($v === null)) {
                        unset($_[$i]);
                        unset($_);
                        return null;
                    }
                    $_ = &$_[$i];
                }
                $_ = $v;
                unset($_);
            }
            return $v;
        }
    }