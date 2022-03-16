<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    class Email extends Str {
        protected static function __correct($data) {
            if (empty($data['data']['regexp'])) $data['data']['regexp'] = \xbweb::REX_EMAIL;
            return parent::__correct($data);
        }
    }