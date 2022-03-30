<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\Field;

    class Link extends Field {
        const BASE_TYPE = self::T_INT_BIG;

        protected static function __correct($data) {
            $data = parent::__correct($data);
            $data['base_type'] = self::T_INT_BIG;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            return self::__value($data, $value);
        }

        protected static function __unpack(array $data, $value) {
            return intval($value);
        }

        protected static function __valid(array $data, $value) {
            return true;
        }

        protected static function __value(array $data, $value) {
            return intval($value);
        }
    }