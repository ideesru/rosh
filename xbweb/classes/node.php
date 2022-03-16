<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  CMF node prototype
     * @category     Prototypes
     * @link         https://xbweb.org/doc/dist/classes/node
     */

    namespace xbweb;

    /**
     * CMF node prototype class
     * @property-read string $path
     */
    abstract class Node {
        const NODE_TYPE = '';

        protected $_path = null;

        /**
         * Constructor
         * @param string $path  Node path
         */
        protected function __construct($path) {
            $this->_path = $path;
        }

        /**
         * Getter
         * @param string $name  Parameter name
         * @return mixed
         */
        function __get($name) {
            return property_exists($this, '_'.$name) ? $this->{'_'.$name} : null;
        }

        /**
         * Setter
         * @param string $name   Parameter name
         * @param mixed  $value  Parameter value
         * @return mixed
         */
        function __set($name, $value) {
            if (method_exists($this, "set_{$name}")) return $this->{"set_{$name}"}($value);
            return null;
        }

        /**
         * Pipe name
         * @param $name
         * @return string
         */
        public function pipeName($name) {
            return PipeLine::name($name, $this->_path);
        }

        /**
         * Create node
         * @param string $path  Real node path
         * @return Node
         * @throws \Exception
         */
        public static function create($path) {
            $cn = \xbweb::uses($path, static::NODE_TYPE);
            return new $cn($path);
        }
    }