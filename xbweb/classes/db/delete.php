<?php
    namespace xbweb\DB;

    use xbweb\DB;
    use xbweb\Model;

    class Delete extends Conditioned {
        public function __construct(Model $model, $name = null) {
            $this->_opts = array(
                'low_priority' => false,
                'quick'        => false
            );
            parent::__construct($model, $name);
        }

        /**
         * Define fields to add
         * @param[] mixed  Field name(s)
         * @return $this
         */
        public function fields() {
            return $this;
        }

        public function sql() {
            $A     = $this->_model->alias;
            $opts  = $this->_opts('low_priority', 'quick');
            $where = $this->_where();
            $order = $this->_order();
            $limit = empty($this->_limit) ? '' : " limit {$this->_limit}";
            return <<<sql
delete {$opts} from `{$this->_table}` as {$A} {$where}{$order}{$limit}
sql;
        }

        public function execute() {
            return DB::query($this->sql());
        }
    }