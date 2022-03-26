<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\lib\Flags as LibFlags;

    use xbweb\Field;

    class Flags extends Field {
        const BASE_TYPE = self::T_INT;

        const FLAGS       = 'required, empties';
        const ATTRIBUTES  = 'isnull, unsigned';

        protected static function __correct($data) {
            if (empty($data['name'])) $data['name'] = 'flags';
            $data = parent::__correct($data);
            if (empty($data['default'])) $data['default'] = 0;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            return self::__value($data, $value);
        }

        protected static function __unpack(array $data, $value) {
            if (empty($data['data']['values'])) return array();
            return LibFlags::toArray($data['data']['values'], $value, in_array('empties', $data['flags']));
        }

        protected static function __valid(array $data, $value) { return true; }

        protected static function __value(array $data, $value) {
            if (empty($data['data']['values'])) return 0;
            return LibFlags::toInt($data['data']['values'], $value, in_array('empties', $data['flags']));
        }
    }