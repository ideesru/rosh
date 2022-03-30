<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\DB;

    class Password extends Str {
        const FLAGS = 'required';

        protected static function __correct($data) {
            if (empty($data['name'])) $data['name'] = 'password';
            $data = parent::__correct($data);
            if (empty($data['data']['length'])) $data['data']['length'] = 64;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            $value = DB::escape(\xbweb\password($value));
            return "'{$value}'";
        }
    }