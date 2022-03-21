<?php
    namespace xbweb\DB;

    use xbweb\Model;

    /**
     * Class Conditioned
     * @property-read Where $where
     * @property-read array $order
     * @property-read int   $limit
     * @property-read int   $offset
     */
    abstract class Conditioned extends Query {
        protected $_where  = null;
        protected $_order  = array();
        protected $_limit  = null;
        protected $_offset = 0;

        public function __construct(Model $model, $name = null) {
            parent::__construct($model, $name);
        }

        public function order($field, $dir = 'asc') {
            if (!$this->_model->hasField($field)) return $this;
            if ($dir != 'desc') $dir = 'asc';
            $this->_order[$field] = $dir;
            return $this;
        }

        public function where(Where $where) {
            $this->_where = $where;
            return $this;
        }

        public function limit($limit, $offset = null) {
            $this->_limit  = intval($limit);
            $this->_offset = intval($offset);
            return $this;
        }

        protected function _order() {
            $order = array();
            foreach ($this->_order as $fn => $dir) $order[] = "`{$fn}` {$dir}";
            $order = implode(',', $order);
            return empty($order) ? '' : ' order by '.$order;
        }

        protected function _where() {
            $where = ($this->_where instanceof Where) ? strval($this->_where) : '';
            return empty($where) ? '' : ' where '.$where;
        }
    }