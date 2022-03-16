<?php
    namespace xbweb\DB;

    use xbweb\lib\Flags as LibFlags;

    use xbweb\DB;
    use xbweb\Model;

    class Where {
        protected $_conditions = array();
        protected $_model      = null;
        protected $_operation  = 'and';

        /**
         * Where constructor.
         * @param Model $model
         * @param string $operation
         * @param array $conditions
         * @throws \xbweb\NodeError
         */
        public function __construct(Model $model, $operation = 'and', $conditions = array()) {
            $this->_model     = $model;
            $this->_operation = $operation;
            if (!empty($conditions)) {
                foreach ($conditions as $cond) {
                    if (empty($cond['field'])) continue;
                    $o = empty($cond['operation']) ? '='  : $cond['operation'];
                    $v = empty($cond['value'])     ? null : $cond['value'];
                    $this->condition($cond['field'], $v, $o);
                }
            }
        }

        /**
         * @param string $field
         * @param mixed  $value
         * @param string $operation
         * @return $this
         * @throws \xbweb\NodeError
         */
        public function condition($field, $value = null, $operation = '=') {
            if ($field instanceof Where) {
                $this->_conditions[] = $field;
                return $this;
            }
            if (!$this->_model->hasField($field)) return $this;
            switch ($operation) {
                case 'is':
                    return $this->_bit($field, $value, '=', false);
                case 'is_not':
                case 'isnot':
                    return $this->_bit($field, $value, '=', true);
                case 'oneof':
                case 'one_of':
                    return $this->_bit($field, $value, '<>', true);
            }
            $operation = DB::operation($operation, '=');
            if (is_array($value)) {
                switch ($operation) {
                    case '=' : $operation = 'in'; break;
                    case '<>': $operation = 'not in'; break;
                    default  : $operation = 'in';
                }
            } else {
                if ($value === null) {
                    if ($operation == '=')  $operation = 'is null';
                    if ($operation == '<>') $operation = 'is not null';
                }
            }
            switch ($operation) {
                case 'in':
                case 'not in':
                    $value = is_array($value) ? $value : explode(',', $value);
                    $value_a = array();
                    foreach ($value as $value_i) $value_a[] = $this->_model->pack($field, $value_i);
                    $value = '('.implode(',', $value_a).')';
                    break;
                default:
                    $value = $this->_model->pack($field, $value);
            }
            $this->_conditions[] = array(
                'field'     => "`{$field}`",
                'value'     => $value,
                'operation' => $operation
            );
            return $this;
        }

        protected function _bit($f, $v, $o, $n = false) {
            $fd = $this->_model->fields[$f];
            $fk = empty($fd['data']['values']) ? array() : $fd['data']['values'];
            $fv = LibFlags::keyValue($fk, $v);
            $this->_conditions[] = array(
                'field'     => "(`{$f}` & {$fv})",
                'value'     => $n ? 0 : $fv,
                'operation' => $o
            );
            return $this;
        }

        public function __toString() {
            $ret = array();
            foreach ($this->_conditions as $cond) {
                if ($cond instanceof Where) {
                    $cond = strval($cond);
                    $ret[] = "({$cond})";
                } else {
                    $ret[] = "({$cond['field']} {$cond['operation']} {$cond['value']})";
                }
            }
            return implode(" {$this->_operation} ", $ret);
        }

        /**
         * @param Model $model
         * @param string $operation
         * @param array $conditions
         * @return Where
         * @throws \xbweb\NodeError
         */
        public function create(Model $model, $operation = 'and', $conditions = array()) {
            return new self($model, $operation, $conditions);
        }
    }