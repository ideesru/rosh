<?php
    namespace xbweb;

    use xbweb\lib\Access as LibAccess;
    use xbweb\lib\Flags  as LibFlags;

    /**
     * Class Field
     * @method static correct(array $data) array
     * @method static pack(array $data, $value) mixed
     * @method static unpack(array $data, $value) mixed
     * @method static valid(array $data, $value) bool
     * @method static value(array $data, $value) mixed
     */
    abstract class Field {
        const T_SERIAL      = 0x01;
        const T_BOOL        = 0x02;
        const T_TIME        = 0x04;
        const T_DATE        = 0x05;
        const T_DATETIME    = 0x06;
        const T_BYTE        = 0x10;
        const T_WORD        = 0x11;
        const T_INT         = 0x12;
        const T_INT_BIG     = 0x13;
        const T_FLOAT       = 0x14;
        const T_DOUBLE      = 0x15;
        const T_DECIMAL     = 0x16;
        const T_STR         = 0x20;
        const T_VAR         = 0x21;
        const T_TEXT_TINY   = 0x30;
        const T_TEXT        = 0x31;
        const T_TEXT_MEDIUM = 0x32;
        const T_TEXT_LONG   = 0x33;
        const T_BLOB_TINY   = 0x34;
        const T_BLOB        = 0x35;
        const T_BLOB_MEDIUM = 0x36;
        const T_BLOB_LONG   = 0x37;

        const FLAGS       = 'required, unique';
        const ATTRIBUTES  = 'primary, auto_increment, isnull, binary, unsigned, index, node';

        const REX_CLASS   = '~^([\w\/]+)$~si';
        const DEF_CLASS   = '/str';

        const BASE_TYPE   = self::T_VAR;


        /**
         * @param $data
         * @return mixed
         * @throws Error
         */
        public static function field($data) {
            $data['base_type'] = static::BASE_TYPE;
            if (empty($data['name'])) throw new DataError('No field name');
            if (!preg_match('~^(\w+)$~si', $data['name'])) throw new DataError('Invalid field name');
            if (empty($data['class'])) $data['class'] = self::DEF_CLASS;
            if (!preg_match(static::REX_CLASS, $data['class'])) throw new FieldError('Invalid class', $data['name']);
            foreach (array('default', 'title', 'description', 'unique', 'index') as $k)
                $data[$k] = isset($data[$k]) ? $data[$k] : null;
            foreach (array('access', 'attributes', 'flags') as $k)
                $data[$k] = empty($data[$k]) ? 0 : $data[$k];
            $data['access']     = LibAccess::CRUSToArray($data['access']);
            $data['attributes'] = LibFlags::toArray(static::ATTRIBUTES, $data['attributes']);
            $data['flags']      = LibFlags::toArray(static::FLAGS, $data['flags']);
            $data['nullable']   = $data['default'] === null;
            $data['data']       = empty($data['data']) ? array() : (
                is_array($data['data']) ? $data['data'] : json_decode($data['data'], true)
            );
            $data['link'] = isset($data['link']) ? $data['link'] : null;
            if (is_array($data['link'])) {
                $data['link'] = array(
                    'table' => empty($data['link']['table']) ? '' : $data['link']['table'],
                    'field' => empty($data['link']['field']) ? '' : $data['link']['field'],
                );
                foreach (array('update', 'delete') as $k) {
                    $data['link'][$k] = empty($data['link'][$k]) ? 'set null' : (
                    $data['link'][$k] == in_array($data['link'][$k], array(
                        'cascade', 'restrict'
                    )) ? $data['link'][$k] : 'set null'
                    );
                    if ($data['link'][$k] == 'set null') {
                        $data['nullable'] = true;
                        $data['default']  = null;
                    }
                }
            }
            return $data;

        }

        /**
         * @param $data
         * @return mixed
         * @throws Error
         */
        protected static function __correct($data) {
            return self::field($data);
        }

        /**
         * @param $name
         * @param $args
         * @return mixed
         * @throws Error
         * @throws \Exception
         */
        public static function __callStatic($name, $args) {
            if (empty($args[0]))     throw new Error('No field data', $name);
            if (!is_array($args[0])) throw new Error('Invalid field data', $name);
            $path = empty($args[0]['class']) ? self::DEF_CLASS : $args[0]['class'];
            if (empty($args[0]['classname'])) {
                if ($c = \xbweb::uses($path, 'field')) {
                    $args[0]['classname'] = $c;
                } else {
                    throw new Error('Error loading field class', $path);
                }
            }
            return call_user_func_array(array($args[0]['classname'], '__'.$name), $args);
        }

        /**
         * @param $std
         * @return array|bool
         */
        public static function std($std) {
            switch ($std) {
                case 'created': return array(
                    'name'       => 'created',
                    'class'      => '/datetime',
                    'access'     => 'create,read',
                    'default'    => true,
                    'attributes' => 'system'
                );
                case 'updated': return array(
                    'name'       => 'deleted',
                    'class'      => '/datetime',
                    'access'     => 'read,update',
                    'attributes' => 'system,isnull'
                );
                case 'deleted': return array(
                    'name'       => 'deleted',
                    'class'      => '/datetime',
                    'access'     => 'read',
                    'attributes' => 'system,isnull'
                );
            }
            return false;
        }
    }