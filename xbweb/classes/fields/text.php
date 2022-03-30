<?php /** @noinspection PhpUnhandledExceptionInspection */

    /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\DB;
    use xbweb\Field;
    use xbweb\FieldError;
    use xbweb\Model;

    class Text extends Str {
        protected static function __correct($data) {
            $data = parent::__correct($data);
            if (empty($data['data']['type'])) $data['data']['type'] = '';
            switch ($data['data']['type']) {
                case 'tiny'  : $data['base_type'] = self::T_TEXT_TINY; break;
                case 'medium': $data['base_type'] = self::T_TEXT_MEDIUM; break;
                case 'long'  : $data['base_type'] = self::T_TEXT_LONG; break;
                default      : $data['base_type'] = self::T_TEXT; break;
            }
            return $data;
        }
    }