<?php
    namespace xbweb\vendors;

    class VKAPI {
        const HOST    = 'https://api.vk.com/method/';
        const VERSION = '5.131';

        const LANG_RU = 0;
        const LANG_UK = 1;
        const LANG_BE = 2;
        const LANG_EN = 3;
        const LANG_ES = 4;
        const LANG_FI = 5;
        const LANG_DE = 6;
        const LANG_IT = 7;

        protected $_token = false;
        protected $_error = false;

        public function __construct($token) {
            $this->_token = $token;
        }

        public function _Q($url, $data) {
            $this->_error  = false;
            $data['v']            = self::VERSION;
            $data['access_token'] = $this->_token;
            if (!isset($data['lang'])) $data['lang'] = 'ru';
            $query = http_build_query($data);
            if (!empty($query)) $url.= '?'.$query;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            $resp = curl_exec($curl);
            if (curl_errno($curl)) {
                $this->_error = curl_getinfo($curl, CURLINFO_HTTP_CODE).'/'.curl_error($curl);
            }
            curl_close($curl);
            if (!empty($this->_error)) return false;
            $resp = json_decode($resp, true);
            if (empty($resp['error']['error_msg'])) return $resp;
            $this->_error = $resp['error']['error_msg'];
            return false;
        }

        public function getError() {
            return $this->_error;
        }

        public function db($method, $data) {
            $data['need_all'] = 1;
            $url = self::HOST.'database.'.$method;
            return $this->_Q($url, $data);
        }

        public function items($resp) {
            $ret = array();
            if (!empty($resp['response']['items']))
                foreach ($resp['response']['items'] as $item) $ret[intval($item['id'])] = $item;
            ksort($ret);
            return array_values($ret);
        }

        public static function langs() {
            return array(
                static::LANG_RU => 'ru',
                static::LANG_UK => 'uk',
                static::LANG_BE => 'be',
                static::LANG_EN => 'en',
                static::LANG_ES => 'es',
                static::LANG_FI => 'fi',
                static::LANG_DE => 'de',
                static::LANG_IT => 'it',
            );
        }
    }