<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\Field;

    class Integer extends Field {
        const BASE_TYPE = self::T_INT;
        const FLAGS     = 'required';

        protected static function __correct($data) {
            $data = parent::__correct($data);
            if (empty($data['data']['type'])) $data['data']['type'] = 'int';
            switch ($data['data']['type']) {
                case 'byte': $data['base_type'] = self::T_BYTE; break;
                case 'word': $data['base_type'] = self::T_WORD; break;
                case 'big' : $data['base_type'] = self::T_INT_BIG; break;
                default    : $data['base_type'] = self::T_INT; break;
            }
            $data['data']['min'] = empty($data['data']['min']) ? 0 : intval($data['data']['min']);
            $data['data']['max'] = empty($data['data']['max']) ? 0 : intval($data['data']['max']);
            if (empty($data['default'])) $data['default'] = 0;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            return self::__value($data, $value);
        }

        protected static function __unpack(array $data, $value) {
            return intval($value);
        }

        protected static function __valid(array $data, $value) {
            $value = intval($value);
            if (!empty($data['data']['min'])) if ($value < $data['data']['min']) return 'small';
            if (!empty($data['data']['max'])) if ($value > $data['data']['max']) return 'big';
            return true;
        }

        protected static function __value(array $data, $value) {
            return intval($value);
        }
    }