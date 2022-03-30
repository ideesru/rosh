<?php /** @noinspection PhpUnusedParameterInspection */

    namespace xbweb\Fields;

    use xbweb\Field;

    class Datetime extends Field {
        const BASE_TYPE = self::T_DATETIME;

        protected static function __correct($data) {
            $data = parent::__correct($data);
            if (empty($data['data']['type'])) $data['data']['type'] = 'datetime';
            $data['base_type'] = \xbweb::v(array(
                'date' => self::T_DATE,
                'time' => self::T_TIME
            ), $data['data']['type'], self::T_DATETIME);
            return $data;
        }

        protected static function __pack(array $data, $value) {
            if ($value === true) switch ($data['base_type']) {
                case self::T_TIME: return 'current_date()';
                case self::T_DATE: return 'current_date()';
                default          : return 'now()';
            }
            return "'{$value}'";
        }

        protected static function __unpack(array $data, $value) {
            return $value;
        }

        protected static function __valid(array $data, $value) {
            try {
                new \DateTime($value);
                return true;
            } catch (\Exception $e) {
                return 'invalid';
            }
        }

        protected static function __value(array $data, $value) {
            if ($value === true) $value = 'now';
            $dtz = empty($data['data']['timezone']) ? null : new \DateTimeZone($data['date']['timezone']);
            $dto = new \DateTime($value, $dtz);
            switch ($data['base_type']) {
                case self::T_TIME: return $dto->format('H:i:s');
                case self::T_DATE: return $dto->format('Y-m-d');
                default          : return $dto->format('Y-m-d H:i:s');
            }
        }
    }