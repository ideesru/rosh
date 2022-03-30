<?php
    namespace xbweb;

    PipeLine::handler('cmf', 'rowUsers', function($data){
        unset($data['password']);
        return $data;
    });

    PipeLine::handler('cmf', 'requestUsers', function($data, $operation){
        switch ($operation) {
            case 'update':
                if (empty($data['request']['password'])) unset($data['errors']['password']);
                break;
        }
        return $data;
    });

    PipeLine::handler('cmf', 'formUsers', function($data, $operation){
        switch ($operation) {
            case 'update':
                $data['main']['password']['flags'] = array();
                break;
        }
        return $data;
    });