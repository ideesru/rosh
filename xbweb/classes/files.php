<?php
    namespace xbweb;

    use xbweb\lib\Files as LibFiles;

    class Files {
        const FLAGS = '';

        public static function get($ids, $table = null) {
            $ids = implode(',', \xbweb::arg($ids, true));
            $tab = self::tableName($table);
            return DB::query("select * from `{$tab}` where `id` in ({$ids})", true);
        }

        public static function find($path, $table = null) {
            $table = self::tableName($table);
            $path  = explode('/', trim($path, '/'));
            $last  = count($path) - 1;
            $sql   = '';
            foreach ($path as $path_k => $path_i) {
                $f   = $path_k == $last ? '*'       : '`id`';
                $p   = empty($path_k)   ? 'is null' : "in ({$sql})";
                $sql = "select {$f} from `{$table}` where (`parent` {$p}) and (`alias` = '{$path_i}')";
            }
            if ($row = DB::row($sql, 'files:findByPath')) return $row;
            return false;
        }

        public static function upload($tmp, $id, $table = null) {
            $table = self::tableName($table);
            $fname = self::fileName($id, $table);
            if (LibFiles::dir(Paths\CONTENT.$table, LibFiles::R_CREATED, true))
                if (LibFiles::dir(dirname($fname))) return move_uploaded_file($tmp, $fname);
            return false;
        }

        public static function deleted($parent = null, $table = null) {
            $table = self::tableName($table);
            $where = $parent === null ? '' : " and (`parent` = {$parent})";
            $sql   = "select `id`,`parent` from `{$table}` where (`deleted` is not null){$where}";
            $ret   = array();
            if ($rows = DB::rows($sql, 'id', function($row){
                $row['id']     = intval($row['id']);
                $row['parent'] = intval($row['parent']);
                return $row;
            })) {
                foreach ($rows as $r) {
                    $ret[] = $r['id'];
                    if ($c = self::deleted($r['id'], $table)) foreach ($c as $id) $ret[] = $id;
                }
            }
            return empty($ret) ? false : $ret;
        }

        public static function clear($parent = null, $table = null) {
            $table = self::tableName($table);
            $where = $parent === null ? '' : " and (`parent` = {$parent})";
            $dl    = self::deleted($parent, $table);
            $sql   = "delete from `{$table}` where (`deleted` is not null){$where}";
            if ($result = DB::query($sql, true, 'files:clearTrash')) if ($result->success) {
                foreach ($dl as $dli) unlink(self::fileName($dli, $table));
                return true;
            }
            return false;
        }

        public static function table($table = null) {
            $table = self::tableName($table);
            return <<<sql
create table if not exists `{$table}` (
  `id`          bigint not null auto_increment,
  `parent`      bigint null,
  `alias`       varchar (64) null,
  `mime`        varchar (64) null,
  `charset`     varchar (16) null,
  `title`       tinytext null,
  `description` text null,
  `access`      tinyint null,
  `flags`       int not null default '0',
  `created`     datetime not null,
  `deleted`     datetime null,
  primary key (`id`),
  unique index `node` (`parent`,`alias`),
  foreign key (`parent`) references `{$table}`(`id`) on update set null on delete cascade 
) Engine = InnoDB
sql;
        }

        public static function tableName($table = null) {
            if ($table === null) $table = 'files';
            return DB::table($table);
        }

        public static function fileName($id, $table = null) {
            return Paths\CONTENT.self::tableName($table).'/'.implode('/', str_split(str_pad(dechex($id), 16, '0'), 2));
        }
    }