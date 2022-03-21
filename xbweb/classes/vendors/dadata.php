<?php
    namespace xbweb\vendors;

    use xbweb\Config;

    class Dadata {
        protected $headers   = array();
        protected $lastError = null;
        protected $token     = null;
        protected $secret    = null;

        function __construct($token, $secret = false) {
            $this->token   = $token;
            $this->secret  = $secret;
            $this->headers = array(
                'Content-type: application/json',
                'Accept: application/json',
                'Authorization: Token '.$token
            );
            if ($secret) $this->headers[] = 'X-Secret: '.$secret;
        }

        protected function _curl($url, $data = null) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
            if (!empty($data)) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            $responseBody = curl_exec($curl);
            $this->lastError = array(
                'status' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
                'errno'  => curl_errno($curl),
                'error'  => curl_error($curl),
            );
            curl_close($curl);
            return json_decode($responseBody, true);
        }

        public function getError() {
            return $this->lastError;
        }

        public function suggest($query) {
            $result = $this->_curl(
                'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
                array(
                    'query'     => $query,
                    'locations' => array(array('country' => '*'))
                )
            );
            return empty($result['suggestions']) ? array() : $result['suggestions'];
        }

        public function ip($ip) {
            $result = $this->_curl(
                'https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address',
                array('ip' => $ip)
            );
            if ($result['location'] === null) {
                $this->lastError = array('City not defined: '.var_export($result, true));
                $result['location']['ip'] = $ip;
            }
            $result['location']['ip'] = $ip;
            return $result['location'];
        }

        public static function client() {
            static $client = null;
            if (is_null($client)) $client = new Dadata(
                Config::get('dadata/key'),
                Config::get('dadata/secret')
            );
            return $client;
        }
    }