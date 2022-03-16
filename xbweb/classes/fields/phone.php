<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\Field;

    class Phone extends Field {
        const BASE_TYPE  = self::T_INT_BIG;
        const ATTRIBUTES = 'primary, isnull, index, node';

        protected static function __correct($data) {
            return parent::__correct($data);
        }

        protected static function __valid($data, $value, &$error) {
            if (preg_match(\xbweb::REX_PHONE, $value)) return true;
            $error = 'incorrect';
            return false;
        }

        protected static function __value($data, $value) {
            $value = preg_replace('~([^\-\+\d]+)~si', '', $value);
            return intval($value);
        }
    }