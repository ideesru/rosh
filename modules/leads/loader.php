<?php
    namespace xbweb\modules\Leads;

    use xbweb\Controller;
    use xbweb\PipeLine;

    define(__NAMESPACE__.'\\MODULE_NAME', 'leads');

    Controller::registerGeneric('leads/services', 'entity', 'leads/services');
    Controller::registerGeneric('leads/statuses', 'entity', 'leads/statuses');
    Controller::registerGeneric('leads/payments', 'entity', 'leads/payments');

    PipeLine::handler(MODULE_NAME, 'controllers', function($data, $module){
        if ($module == 'leads') {
            $data['statuses'] = true;
            $data['services'] = true;
            $data['payments'] = true;
        }
        return $data;
    });