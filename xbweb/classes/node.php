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
    abstract class Node extends BasicObject {
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