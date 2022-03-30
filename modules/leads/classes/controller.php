<?php
    namespace xbweb\modules\Leads;

    use xbweb\Controllers\Entity;
    use xbweb\Model;

    class Controller extends Entity {
        const MODEL  = 'leads';
        const ENTITY = 'lead';

        /**
         * @throws \xbweb\Error
         * @throws \xbweb\ErrorNotFound
         */
        public function do_install() {
            $r = array();
            $m = Model::create('leads/payments');
            $r[] = $m->tableSQL();
            $m = Model::create('leads/statuses');
            $r[] = $m->tableSQL();
            $m = Model::create('leads/services');
            $r[] = $m->tableSQL();
            $m = Model::create('leads');
            $r[] = $m->tableSQL();
            $r = implode("\r\n\r\n", $r);
            header('Content-type: text/plain; charset=utf-8');
            die($r);
        }
    }