<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\DB;

    class Key extends Str {
        protected static function __correct($data) {
            if (empty($data['name'])) $data['name'] = 'key';
            $data = parent::__correct($data);
            if (empty($data['data']['length'])) $data['data']['length'] = 32;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            $value = DB::escape(self::__value($data, $value));
            return "'{$value}'";
        }

        protected static function __value(array $data, $value) {
            if ($value === true) return \xbweb::key($data['data']['length']);
            return parent::__value($data, $value);
        }
    }