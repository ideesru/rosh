<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    class User extends Link {
        const BASE_TYPE = self::T_INT_BIG;

        protected static function __correct($data) {
            $data['link']['table'] = 'users';
            $data['link']['field'] = 'id';
            $data = parent::__correct($data);
            return $data;
        }
    }