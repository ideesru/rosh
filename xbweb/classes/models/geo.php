<?php
    namespace xbweb\models;

    use xbweb\DB;
    use xbweb\Config;

    use xbweb\vendors\VKAPI;

    class Geo {
        protected static function _entity($table) {
            switch ($table) {
                case 'countries': return 'country';
                case 'regions'  : return 'region';
                case 'cities'   : return 'city';
            }
            return false;
        }

        public static function add($table, $data) {
            if (empty($data['id'])) return false;
            $fl = array();
            $vl = array();
            foreach ($data as $k => $v) {
                $v    = DB::escape($v);
                $fl[] = "`{$k}`";
                $vl[] = "'{$v}'";
            }
            $fl  = implode(',', $fl);
            $vl  = implode(',', $vl);
            $sql = <<<sql
insert into `[+prefix+]geo_{$table}` ({$fl}) values ({$vl})
on duplicate key update `name` = values(`name`)
sql;
            if ($result = DB::query($sql, self::table($table))) if ($result->success) return $data;
            return false;
        }

        public static function get($table, $id) {
            if (empty($id)) return false;
            $sql = "select * from `[+prefix+]geo_{$table}` where `id` = {$id}";
            if ($rows = DB::query($sql, true)) if ($row = $rows->row()) return $row;
            $VKAPI = new VKAPI(Config::get('vk/token'));
            $m = 'get'.ucfirst($table).'ById';
            $e = self::_entity($table).'_ids';
            if ($resp = $VKAPI->db($m, array($e => $id))) {
                $row = null;
                foreach ($resp['response'] as $item) {
                    $row = array('id' => $id, 'lang' => 'ru', 'name' => $item['title']);
                    break;
                }
                if (empty($row)) return false;
                return self::add($table, $row);
            }
            return false;
        }

        public static function table($table) {
            switch ($table) {
                case 'countries':
                    return <<<sql
create table `[+prefix+]geo_countries` (
  `id`   int not null,
  `lang` char(2) not null default '',
  `name` varchar(200),
  primary key (`id`)
) engine = InnoDB
sql;
                case 'regions':
                    return <<<sql
create table `[+prefix+]geo_regions` (
  `id`      int not null,
  `lang`    char(2) not null default '',
  `name`    varchar(200),
  primary key (`id`)
) engine = InnoDB
sql;
                case 'cities':
                    return <<<sql
create table `[+prefix+]geo_cities` (
  `id`     int not null,
  `lang`   char(2) not null default '',
  `name`   varchar(200),
  primary key (`id`)
) engine = InnoDB
sql;
            }
            return false;
        }

        public static function getCountries($lang) {
            static $rows = null;
            if (empty($rows)) {
                $sql  = "select * from `[+prefix+]geo_countries` where `lang` = '{$lang}'";
                $rows = DB::rows($sql, 'id');
            }
            return $rows;
        }

        public static function getCountry() {
            $country = empty($_POST['country']) ? 0 : intval($_POST['country']);
            if ($row = self::get('countries', $country)) return $row;
            return false;
        }

        public static function getRegion() {
            $region  = empty($_POST['region'])      ? 0  : intval($_POST['region']);
            $cname   = empty($_POST['region_name']) ? '' : $_POST['region_name'];
            $country = empty($_POST['country'])     ? 0  : intval($_POST['country']);
            $sql = "select * from `[+prefix+]geo_regions` where `id` = {$region}";
            if ($rows = DB::query($sql, true)) if ($row = $rows->row()) return $row;
            if (empty($cname) || empty($region) || empty($country)) return false;
            $VKAPI = new VKAPI(Config::get('vk/token'));
            if ($resp = $VKAPI->db('getRegions', array(
                'country_id' => $country,
                'q'          => $cname,
                'count'      => 1000
            ))) {
                if (empty($resp['response']['items'])) return false;
                $row = null;
                foreach ($resp['response']['items'] as $item) {
                    if (intval($item['id']) == $region) {
                        $row = array(
                            'id'   => $region,
                            'lang' => 'ru',
                            'name' => $item['title']
                        );
                        break;
                    }
                }
                if (empty($row)) return false;
                return self::add('regions', $row);
            }
            return false;
        }

        public static function getCity() {
            $city = empty($_POST['city']) ? 0 : intval($_POST['city']);
            if ($row = self::get('cities', $city)) return $row;
            return false;
        }
    }