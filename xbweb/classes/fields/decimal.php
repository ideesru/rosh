<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\Field;

    class Decimal extends Field {
        const BASE_TYPE = self::T_FLOAT;
        const FLAGS     = 'required';

        protected static function __correct($data) {
            $data = parent::__correct($data);
            if (empty($data['data']['type'])) $data['data']['type'] = 'float';
            switch ($data['data']['type']) {
                case 'double' : $data['base_type'] = self::T_DOUBLE; break;
                case 'decimal': $data['base_type'] = self::T_DECIMAL; break;
                default       : $data['base_type'] = self::T_FLOAT; break;
            }
            $data['data']['min'] = empty($data['data']['min']) ? 0 : floatval($data['data']['min']);
            $data['data']['max'] = empty($data['data']['max']) ? 0 : floatval($data['data']['max']);
            if (empty($data['default'])) $data['default'] = 0;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            return self::__value($data, $value);
        }

        protected static function __unpack(array $data, $value) {
            return floatval($value);
        }

        protected static function __valid(array $data, $value) {
            $value = floatval($value);
            if (!empty($data['data']['min'])) if ($value < $data['data']['min']) return 'small';
            if (!empty($data['data']['max'])) if ($value > $data['data']['max']) return 'big';
            return true;
        }

        protected static function __value(array $data, $value) {
            return floatval($value);
        }
    }