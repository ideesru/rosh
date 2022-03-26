<?php
    namespace xbweb\DB;

    use xbweb\DB;
    use xbweb\Model;

    class Select extends Conditioned {
        public function __construct(Model $model, $name = null) {
            $this->_opts = array(
                'straight_join'       => false,
                'sql_small_result'    => false,
                'sql_big_result'      => false,
                'sql_buffer_result'   => false,
                'sql_cache'           => false,
                'sql_no_cache'        => false,
                'sql_calc_found_rows' => false,
                'high_priority'       => false,
                'distinct'            => false,
                'disctinctrow'        => false,
                'ignore_no_table'     => false,
                'get_total_rows'      => false
            );
            parent::__construct($model, $name);
        }

        /**
         * Define fields to add
         * @param[] mixed  Field name(s)
         * @return $this
         */
        public function fields() {
            $fl = func_get_args();
            if (count($fl) == 1) {
                if (is_array($fl[0])) {
                    $fl = $fl[0];
                } elseif ($fl[0] == '*') {
                    $fl = array_keys($this->_model->fields);
                } else {
                    $fl = explode(',', $fl[0]);
                }
            }
            $this->_fields = empty($fl) ? null : $fl;
            return $this;
        }

        public function sql() {
            $A    = $this->_model->alias;
            $opts = $this->_opts(
                'straight_join',
                'sql_small_result', 'sql_big_result', 'sql_buffer_result',
                'sql_cache', 'sql_no_cache', 'sql_calc_found_rows',
                'high_priority', 'distinct', 'disctinctrow'
            );
            $fl    = empty($this->_fields) ? "{$A}.*" : "{$A}.`".implode("`,{$A}.`", $this->_fields)."`";
            $joins = $this->_joins();
            $where = $this->_where();
            $order = $this->_order();
            $limit = empty($this->_limit) ? '' : ' limit '.$this->_offset.','.$this->_limit;
            return <<<sql
select {$opts} {$fl} from `{$this->_table}` as {$A} {$joins} {$where}{$order}{$limit}
sql;
        }

        public function sql_count() {
            $A    = $this->_model->alias;
            $opts = $this->_opts(
                'straight_join',
                'sql_small_result', 'sql_big_result', 'sql_buffer_result',
                'sql_cache', 'sql_no_cache',
                'high_priority', 'distinct', 'disctinctrow'
            );
            $joins = $this->_joins();
            $where = $this->_where();
            return <<<sql
select {$opts} count(*) as `total` from `{$this->_table}` as {$A} {$joins} {$where}
sql;
        }

        public function execute() {
            $iq = empty($this->_opts['ignore_no_table']) ? null : true;
            return DB::query($this->sql(), $iq);
        }
    }