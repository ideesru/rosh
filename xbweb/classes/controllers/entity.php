<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.ru
     *
     * @description  Entity controller prototype
     * @category     Controllers prototypes
     * @link         https://xbweb.ru/doc/dist/classes/controllers/entity
     */

    namespace xbweb\Controllers;

    use xbweb\ErrorDeleted;
    use xbweb\ErrorPage;
    use xbweb\ErrorNotFound;

    use xbweb\PipeLine;
    use xbweb\Request;
    use xbweb\Model;
    use xbweb\Controller;

    use xbweb\DB\Where;

    /**
     * Entity controller prototype class
     * @property-read Where $fuse
     */
    class Entity extends Controller {
        const MODEL  = '/table';
        const ENTITY = 'entity';

        protected $_fuse = null;

        /**
         * Constructor
         * @param string $path   Controller path
         * @param string $model  Model path
         */
        protected function __construct($path, $model) {
            if ($model === null) $model = static::MODEL;
            parent::__construct($path, $model);
            if (method_exists($this, 'onConstruct')) $this->onConstruct();
            $where = $this->_fused_where();
            $this->_queries['delete'] = array(
                'title'   => 'Confirm delete',
                'success' => ucfirst(static::ENTITY).' deleted successfully',
                'error'   => 'Error deleting '.static::ENTITY,
                'confirm' => 'Delete '.static::ENTITY.'?',
                'query'   => 'update `[+table+]` set `deleted` = now() where ' . $where
            );
            $this->_queries['restore'] = array(
                'title'   => 'Confirm restore',
                'success' => ucfirst(static::ENTITY).' restored successfully',
                'error'   => 'Error restoring '.static::ENTITY,
                'confirm' => 'Restore '.static::ENTITY.'?',
                'query'   => 'update `[+table+]` set `deleted` = null where ' . $where
            );
            $this->_queries['remove'] = array(
                'title'   => 'Confirm remove',
                'success' => ucfirst(static::ENTITY).' removed successfully',
                'error'   => 'Error removing '.static::ENTITY,
                'confirm' => 'Remove '.static::ENTITY.'?',
                'query'   => 'delete from `[+table+]` where ' . $where
            );
            $where = $this->_fused_where('`deleted` is not null');
            $this->_queries['clean'] = array(
                'title'   => 'Confirm clean trash',
                'success' => 'Trash cleaned successfully',
                'error'   => 'Error cleaning trash',
                'confirm' => 'Clean trash?',
                'query'   => 'delete from `[+table+]` where ' . $where
            );
        }

        /**
         * Get multiple entities
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         * @action ./index
         */
        public function do_index() {
            $model = Model::create($this->_model);
            $name  = empty($_POST['index-filter']) ? '' : $_POST['index-filter'];

            $rows  = $model->get($name);
            if (!$rows) if (in_array('norows204', $model->options)) throw new ErrorPage('No rows', 204);
            return self::success(PipeLine::invoke($this->pipeName('data'), $rows, 'index'));
        }

        /**
         * Get one entity
         * @return array
         * @throws \xbweb\Error
         * @throws \xbweb\ErrorNotFound
         * @action ./get
         */
        public function do_get() {
            $model = Model::create($this->_model);
            $item  = $model->getOne(Request::get('id'));
            if ($item === false) $this->_notfound();
            if (!empty($item['deleted'])) {
                if (in_array('deleted410', $model->options)) {
                    throw new ErrorDeleted(ucfirst(static::ENTITY).' deleted', Request::get('id'));
                } else {
                    $this->_notfound();
                }
            }
            return self::success(PipeLine::invoke($this->pipeName('data'), $item, 'get'));
        }

        /**
         * Create new entity
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         * @throws \Exception
         * @action ./create
         */
        public function do_create() {
            return $this->_form('create', false);
        }

        /**
         * Edit existing entity
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         * @throws \xbweb\NodeError
         * @action ./edit
         */
        public function do_edit() {
            return $this->_form('update', false);
        }

        /**
         * Edit existing entity
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         * @throws \xbweb\NodeError
         * @action ./edit
         */
        public function do_save() {
            $id = Request::get('id');
            $op = empty($id) ? 'create' : 'update';
            return $this->_form($op, true);
        }

        /**
         * Get "deleted" entities
         * @return array
         * @throws ErrorNotFound
         * @throws ErrorPage
         * @throws \xbweb\Error
         * @action ./trash
         */
        public function do_trash() {
            $model = Model::create($this->_model);
            $rows  = $model->get('trash');
            if (!$rows) if (in_array('norows204', $model->options)) throw new ErrorPage('No rows', 204);
            return self::success(PipeLine::invoke($this->pipeName('data'), $rows, 'trash'));
        }

        /**
         * Handlde form
         * @param string $op  Operation
         * @param bool   $rf  Return form
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         * @throws \xbweb\NodeError
         */
        protected function _form($op = 'update', $rf = false) {
            $model = Model::create($this->_model);
            if ($op == 'update') {
                $row = $model->getOne(Request::get('id'), false);
                if (empty($row)) $this->_notfound();
            } else {
                $row = null;
            }
            $errors = null;
            if (Request::isPost()) {
                list($request, $errors) = $model->request($op, null, true);
                if (empty($errors)) {
                    if ($op == 'update') {
                        $id      = $model->add($request);
                        $success = !empty($id);
                    } else {
                        $id      = Request::get('id');
                        $success = $model->save($request, $id);
                    }
                    if ($success) {
                        if ($rf) {
                            $row = $model->getOne($id, false);
                            return self::form($model->form('update', $row));
                        } else {
                            $url = '/'.trim($this->_path, '/').'/index';
                            \xbweb::redirect(Request::URL($url));
                        }
                    }
                    $errors = 'Unable to save ' . static::ENTITY;
                }
            }
            return self::form($model->form($op, $row), $errors);
        }

        /**
         * Not found exception
         * @param mixed $id  ID
         * @throws ErrorNotFound
         */
        protected function _notfound($id = null) {
            if ($id === null) $id = Request::get('id');
            throw new ErrorNotFound(ucfirst(static::ENTITY).' not found', $id);
        }

        protected function _fused_where($w = '`[+primary+]` [+ids+]') {
            $where = '('.$w.')';
            if ($this->_fuse instanceof Where) $where.= ' and ('.strval($this->_fuse).')';
            return $where;
        }
    }