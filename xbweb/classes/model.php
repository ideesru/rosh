<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Model prototype
     * @category     Models
     * @link         https://xbweb.org/doc/dist/classes/model
     */

    namespace xbweb;

    use xbweb\lib\Flags as LibFlags;

    use xbweb\DB\Table;

    /**
     * Model prototype class
     * @property-read array  $fields   Model fields
     * @property-read string $table    Main table
     * @property-read string $alias    Main table alias
     * @property-read int    $limit    Limit per page
     * @property-read mixed  $primary  Primary key
     * @property-read array  $options  Model options
     */
    abstract class Model extends Node {
        const NODE_TYPE = 'Model';
        const OPTIONS   = 'deleted410,norows204';
        const LIMIT     = 20;

        protected static $_models = array();

        protected $_fields  = array();
        protected $_table   = null;
        protected $_alias   = null;
        protected $_limit   = self::LIMIT;
        protected $_primary = null;
        protected $_options = array();

        /**
         * Constructor
         * @param string $path Model path
         * @param array $data Fields data
         * @throws NodeError
         * @throws FieldError
         */
        protected function __construct($path, array $data = null) {
            parent::__construct($path);
            if (!is_array($data))      throw new NodeError('Model data incorrect', $path);
            if (empty($data['table'])) throw new NodeError('No table specified', $path);
            $this->_table   = $data['table'];
            $this->_options = empty($data['options']) ? array() : LibFlags::toArray(static::OPTIONS, $data['options']);
            $this->_limit   = empty($data['limit']) ? static::LIMIT : intval($data['limit']);
            $rows = empty($data['fields']) ? false : $data['fields'];
            $rows = PipeLine::invoke($this->pipeName('fields'), $rows);
            if (empty($rows)) throw new NodeError('There are no valid fields', $path);
            foreach ($rows as $fid => $field) {
                if (!empty($field['std'])) $field = Field::std($field['std']);
                $field = Field::correct($field);
                $field['model'] = $this;
                if (empty($field['name'])) throw new FieldError('Empty field name', $fid);
                $this->_fields[$field['name']] = $field;
                if (in_array('primary', $field['attributes'])) $this->_primary = $field['name'];
            }
            $this->_alias = 't_'.ucwords($this->_table, '_');
        }

        /**
         * Check field exists
         * @param string $name  Field name
         * @return bool
         */
        public function hasField($name) {
            return !empty($this->_fields[$name]);
        }

        /**
         * @return string
         */
        public function tableSQL() {
            $query = new Table($this);
            return $query->sql();
        }

        /**
         * @param $field
         * @param $value
         * @param bool $error
         * @return mixed
         * @throws NodeError
         */
        public function validate($field, $value, &$error = false) {
            if (empty($this->_fields[$field])) throw new NodeError('No field ', $field);
            $value = Field::value($this->_fields[$field], $value);
            if (empty($value)) {
                if (!in_array('required', $this->_fields[$field]['flags'])) return true;
                $error = 'empty';
            } else {
                $error = Field::valid($this->_fields[$field], $value);
                if ($error === true) {
                    $error = false;
                    return true;
                }
            }
            return false;
        }

        /**
         * @param $field
         * @param $value
         * @return mixed
         * @throws NodeError
         */
        public function pack($field, $value) {
            if (empty($this->_fields[$field])) throw new NodeError('No field ', $field);
            $value = Field::value($this->_fields[$field], $value);
            return Field::pack($this->_fields[$field], $value);
        }

        /**
         * @param $field
         * @param $value
         * @return mixed
         * @throws NodeError
         */
        public function unpack($field, $value) {
            if (empty($this->_fields[$field])) throw new NodeError('No field ', $field);
            return Field::unpack($this->_fields[$field], $value);
        }

        /**
         * @param $field
         * @param $value
         * @return mixed
         * @throws NodeError
         */
        public function value($field, $value) {
            if (empty($this->_fields[$field])) throw new NodeError('No field ', $field);
            return Field::value($this->_fields[$field], $value);
        }

        /**
         * @param string $field
         * @param string $operation
         * @return bool
         * @throws Error
         * @throws NodeError
         */
        public function allowed($field, $operation) {
            if (empty($this->_fields[$field])) throw new NodeError('No field ', $field);
            $ug = User::current()->role;
            if (in_array('system', $this->_fields[$field]['attributes']) && ($operation != 'read')) return false;
            if ($ug == 'root') return true;
            return lib\Access::CRUSGranted($ug, $operation, $this->_fields[$field]['access']);
        }

        /**
         * @param string $operation
         * @param null $action
         * @param bool $forlist
         * @return array
         * @throws Error
         * @throws NodeError
         */
        public function request($operation, $action = null, $forlist = false) {
            if ($action === null) $action = $operation;
            $errors = array();
            $fields = array();
            foreach ($this->_fields as $key => $field) {
                if (!$this->allowed($key, $operation)) continue;
                if (!isset($_POST[$key]) && ($operation == 'update')) continue;
                $value = isset($_POST[$key]) ? $_POST[$key] : null;
                $error = false;
                if ($this->validate($key, $value, $error)) {
                    $fields[$key] = $value;
                } else {
                    $errors[$key] = $error;
                }
            }
            if ($operation == 'update') {
                if (empty($fields[$this->_primary])) $fields[$this->_primary] = $this->getID();
            }
            $ret = PipeLine::invoke($this->pipeName('request'), array(
                'request' => $fields,
                'errors'  => $errors
            ), $operation, $action);
            return $forlist ? array_values($ret) : $ret;
        }

        /**
         * @return mixed
         * @throws NodeError
         */
        public function getID() {
            if (empty($_POST[$this->_primary])) return Request::get('id');
            $value = $_POST[$this->_primary];
            return $this->value($this->_primary, $value);
        }

        /**
         * @param $operation
         * @param null $row
         * @return array
         * @throws Error
         * @throws NodeError
         */
        public function form($operation, $row = null) {
            $fields = array('main' => array());
            foreach ($this->_fields as $key => $field) {
                if (!$this->allowed($key, $operation)) continue;
                $field['value']     = isset($row[$key]) ? $row[$key] : null;
                $field['operation'] = $operation;
                unset($field['model']);
                $fields['main'][$key] = $field;
            }
            return PipeLine::invoke($this->pipeName('form'), $fields, $operation);
        }

        /**
         * @param $row
         * @param bool $unpack
         * @return array
         * @throws Error
         * @throws NodeError
         */
        public function row($row, $unpack = true) {
            $data = array();
            foreach ($this->_fields as $key => $field) {
                if (!$this->allowed($key, 'read')) continue;
                $value = isset($row[$key]) ? $row[$key] : null;
                if ($unpack) {
                    $data[$key] = Field::unpack($field, $value);
                } else {
                    $data[$key] = Field::value($field, $value);
                }
            }
            return $data;
        }

        /**
         * Check if value exists
         * @param $field
         * @param $value
         * @return bool
         * @throws NodeError
         */
        public function exists($field, $value) {
            $value = $this->value($field, $value);
            $table = DB::table($this->_table);
            $curid = $this->getID();
            $priid = $this->_primary;
            $sql   = "select * from `{$table}` where (`{$field}` = '{$value}') and ({$priid} <> {$curid})";
            if ($rows = DB::query($sql)) if ($row = $rows->row()) return true;
            return false;
        }

        /**
         * Get full field
         * @param $field
         * @return string
         * @throws NodeError
         */
        public function field($field) {
            if (empty($this->_fields[$field])) throw new NodeError('No field ', $field);
            return $this->_alias.".`{$field}`";
        }

        abstract public function getOne($id, $acl = true);
        abstract public function get($name = '', $acl = true);
        abstract public function add($row);
        abstract public function update($row, $id);

        public function save($row, $n = null) {
            $id = empty($row[$this->_primary]) ? null : $row[$this->_primary];
            if (empty($id) || $n) return $this->add($row);
            return $this->update($row, $id) ? $id : false;
        }

        /**
         * Creates instance of Model by path or data
         * @param mixed $data  Initialization data or path
         * @return Model
         * @throws Error
         * @throws ErrorNotFound
         */
        public static function create($data) {
            try {
                $cn   = \xbweb::uses($data, static::NODE_TYPE);
                $path = $data;
                $data = null;
            } catch (\Exception $e) {
                $cn = '\\xbweb\\models\\Table';
                if (is_array($data)) {
                    if (empty($data['path'])) throw new Error('Model has no path');
                    $path = $data['path'];
                } else {
                    $fn = static::file($data);
                    if (!file_exists($fn)) throw new ErrorNotFound('Model not found', $data);
                    $path = $data;
                    $data = json_decode(file_get_contents($fn), true);
                }
            }
            if (empty(self::$_models[$path])) self::$_models[$path] = new $cn($path, $data);
            return self::$_models[$path];
        }

        /**
         * Model file
         * @param string $path  Model path
         * @return string
         */
        public static function file($path) {
            $_      = explode('/', $path);
            $module = array_shift($_);
            $model  = empty($_) ? 'table' : implode('/', $_);
            return (empty($module) ? Paths\CORE : Paths\MODULES.$module.'/').'data/tables/'.$model.'.json';
        }
    }