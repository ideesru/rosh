<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Entity controller prototype
     * @category     Controllers prototypes
     * @link         https://xbweb.org/doc/dist/classes/controllers/entity
     */

    namespace xbweb\Controllers;

    use xbweb\ErrorPage;
    use xbweb\Model;
    use xbweb\PipeLine;
    use xbweb\Request;
    use xbweb\Controller;

    use xbweb\ErrorNotFound;

    /**
     * Entity controller prototype class
     */
    class Entity extends Controller {
        const MODEL = '/table';

        protected function __construct($path, $model) {
            if ($model === null) $model = static::MODEL;
            parent::__construct($path, $model);
            $this->_queries['delete'] = array(
                'title'   => 'Confirm delete',
                'success' => 'Entity deleted successfully',
                'error'   => 'Error deleting entity',
                'confirm' => 'Delete entity?',
                'query'   => 'upd' . 'ate `[+table+]` set `deleted` = now() where `[+primary+]` [+ids+]'
            );
            $this->_queries['restore'] = array(
                'title'   => 'Confirm restore',
                'success' => 'Entity restored successfully',
                'error'   => 'Error restoring entity',
                'confirm' => 'Restore entity?',
                'query'   => 'upd' . 'ate `[+table+]` set `deleted` = null where `[+primary+]` [+ids+]'
            );
            $this->_queries['remove'] = array(
                'title'   => 'Confirm remove',
                'success' => 'Entity removed successfully',
                'error'   => 'Error removing entity',
                'confirm' => 'Remove entity?',
                'query'   => 'del' . 'ete from `[+table+]` where `[+primary+]` [+ids+]'
            );
            $this->_queries['clean'] = array(
                'title'   => 'Confirm clean trash',
                'success' => 'Trash cleaned successfully',
                'error'   => 'Error cleaning trash',
                'confirm' => 'Clean trash?',
                'query'   => 'del' . 'ete from `[+table+]` where `deleted` is not null'
            );
        }

        /**
         * Get multiple entities
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         */
        public function do_index() {
            $model = Model::create($this->_model);
            $name  = empty($_REQUEST['index_filter']) ? '' : $_REQUEST['index_filter'];
            $rows  = $model->get($name);
            if ($rows === false) throw new ErrorPage('No rows', 204);
            $rows = PipeLine::invoke($this->pipeName('data'), $rows, 'index');
            return self::success($rows);
        }

        /**
         * Get one entity
         * @return array
         * @throws \xbweb\Error
         * @throws \xbweb\ErrorNotFound
         */
        public function do_get() {
            $model = Model::create($this->_model);
            $item  = $model->getOne(Request::get('id'));
            if ($item === false) throw new ErrorNotFound('Row not found', $this->_path);
            $item = PipeLine::invoke($this->pipeName('data'), $item, 'get');
            return self::success($item);
        }

        /**
         * Create new entity
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         * @throws \Exception
         */
        public function do_create() {
            $model = Model::create($this->_model);
            $request = $model->request('create', $errors);
            $request = PipeLine::invoke($this->pipeName('request'), $request, 'create');
            if (!empty($errors)) return self::error($errors);
            if ($result = $model->add($request)) return self::success($result);
            return self::error('Unable to create row');
        }

        /**
         * Edit existing entity
         * @return array
         * @throws ErrorNotFound
         * @throws \xbweb\Error
         * @throws \xbweb\NodeError
         */
        public function do_edit() {
            $model = Model::create($this->_model);
            $request = $model->request('update', $errors);
            $request = PipeLine::invoke($this->pipeName('request'), $request, 'update');
            if (!empty($errors)) return self::error($errors);
            if ($result = $model->edit($request, Request::get('id'))) return self::success();
            return array('status' => 'success');
        }

        /**
         * Get "deleted" entities
         * @return array
         * @throws ErrorNotFound
         * @throws ErrorPage
         * @throws \xbweb\Error
         */
        public function do_trash() {
            $model = Model::create($this->_model);
            $rows  = $model->get('trash');
            if ($rows === false) throw new ErrorPage('No rows', 204);
            $rows = PipeLine::invoke($this->pipeName('data'), $rows, 'trash');
            return self::success($rows);
        }
    }