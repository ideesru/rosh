<?php /** @noinspection PhpUnhandledExceptionInspection */

    /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\DB;
    use xbweb\Field;
    use xbweb\FieldError;
    use xbweb\Model;

    class Str extends Field {
        const ATTRIBUTES  = 'primary, isnull, binary, index, node, fixed, system';

        protected static function __correct($data) {
            $data = parent::__correct($data);
            $data['base_type'] = in_array('fixed', $data['attributes']) ? self::T_STR : self::T_VAR;
            if (!empty($data['data']['regexp'])) if (!\xbweb::rexValid($data['data']['regexp']))
                throw new FieldError('Invalid regular expression', $data['name']);

            $data['data']['length'] = empty($data['data']['length']) ? 0 : intval($data['data']['length']);
            $data['data']['min']    = empty($data['data']['min'])    ? 0 : intval($data['data']['min']);
            if ($data['data']['length'] > 250) $data['data']['length'] = 250;
            if ($data['data']['length'] < $data['data']['min']) $data['data']['min'] = 0;
            return $data;
        }

        protected static function __pack(array $data, $value) {
            $value = DB::escape($value);
            return "'{$value}'";
        }

        protected static function __unpack(array $data, $value) {
            return $value;
        }

        protected static function __valid(array $data, $value) {
            if (in_array('unique', $data['flags']))
                if ($data['model'] instanceof Model)
                    if ($data['model']->exists($data['name'], $value)) return 'exists';
            if (!empty($data['data']['length'])) if (strlen($value) > $data['data']['length']) return 'long';
            if (strlen($value) < $data['data']['min']) return 'short';
            if (empty($data['data']['regexp'])) return true;
            if (preg_match($data['data']['regexp'], $value)) return true;
            return 'invalid';
        }

        protected static function __value(array $data, $value) {
            if (!empty($data['type']['strip'])) $value = preg_replace($data['type']['strip'], '', $value);
            return $value;
        }
    }