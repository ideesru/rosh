<?php
    namespace xbweb\models;

    use xbweb\DB;

    class Geo {
        public static function row($table, $data) {
            if (empty($data['id'])) return false;
            $id  = intval($data['id']);
            $sql = "select * from `[+prefix+]geo_{$table}` where `id` = {$id}";
            if ($rows = DB::query($sql, true)) if ($row = $rows->row()) return $row;
            $fl = array();
            $vl = array();
            foreach ($data as $k => $v) {
                $v = DB::escape($v);
                $fl[] = "`{$k}`";
                $vl[] = "'{$v}'";
            }
            $fl = implode(',', $fl);
            $vl = implode(',', $vl);
            $sql = <<<sql
insert into `[+prefix+]geo_{$table}` ({$fl}) values ({$vl})
on duplicate key update `name` = values(`name`)
sql;
            if ($result = DB::query($sql, self::table($table))) {
                if ($result->success) return $data;
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
  `country` int not null,
  `lang`    char(2) not null default '',
  `name`    varchar(200),
  primary key (`id`),
  foreign key (`country`) references `[+prefix+]geo_countries`(`id`) on update cascade on delete cascade
) engine = InnoDB
sql;
                case 'cities':
                    return <<<sql
create table `[+prefix+]geo_cities` (
  `id`     int not null,
  `region` int not null,
  `lang`   char(2) not null default '',
  `name`   varchar(200),
  primary key (`id`),
  foreign key (`region`) references `[+prefix+]geo_regions`(`id`) on update cascade on delete cascade
) engine = InnoDB
sql;
            }
            return false;
        }
    }