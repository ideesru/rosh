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
        protected $_joins  = array();
        protected $_groups = array();

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

        public function limitFromRequest() {
            $page  = empty($_REQUEST['page']) ? 1 : intval($_REQUEST['page']);
            $limit = empty($_REQUEST['limit']) ? $this->_model->limit : intval($_REQUEST['limit']);
            $this->_limit  = $limit;
            $this->_offset = $page * $limit;
            return $this;
        }

        public function join($model, $on = array()) {
            $join = new Join($this->_model, $model, $on);
            $this->_joins[] = $join;
            return $join;
        }

        /**
         * @param $field
         * @return $this
         * @throws \xbweb\NodeError
         */
        public function group($field) {
            $this->_groups[] = $this->_model->field($field);
            return $this;
        }

        protected function _order() {
            $A     = $this->_model->alias;
            $order = array();
            foreach ($this->_order as $fn => $dir) $order[] = "{$A}.`{$fn}` {$dir}";
            $order = implode(',', $order);
            return empty($order) ? '' : ' order by '.$order;
        }

        protected function _where() {
            $where = ($this->_where instanceof Where) ? strval($this->_where) : '';
            return empty($where) ? '' : ' where '.$where;
        }

        protected function _joins() {
            $joins = array();
            foreach ($this->_joins as $join) {
                $joins[] = strval($join);
            }
            return implode("\r\n", $joins);
        }
    }