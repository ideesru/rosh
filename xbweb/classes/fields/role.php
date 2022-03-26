<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\lib\Roles as LibRoles;

    use xbweb\Field;

    class Role extends Field {
        const BASE_TYPE = self::T_BYTE;
        const FLAGS     = 'required';

        protected static function __correct($data) {
            if (empty($data['name'])) $data['name'] = 'role';
            $data = parent::__correct($data);
            if (empty($data['default'])) $data['default'] = 0;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            return self::__value($data, $value);
        }

        protected static function __unpack(array $data, $value) {
            return LibRoles::toArray($value);
        }

        protected static function __valid(array $data, $value) {
            return true;
        }

        protected static function __value(array $data, $value) {
            return LibRoles::toInt($value);
        }
    }