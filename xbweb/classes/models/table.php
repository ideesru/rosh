<?php
    namespace xbweb\models;

    use xbweb\PipeLine;
    use xbweb\DB;
    use xbweb\Model;

    use xbweb\DB\Select as QuerySelect;
    use xbweb\DB\Insert as QueryInsert;
    use xbweb\DB\Update as QueryUpdate;
    use xbweb\DB\Table  as QueryTable;
    use xbweb\DB\Where  as Where;

    class Table extends Model {
        /**
         * @param $id
         * @param bool $acl
         * @return array|bool
         * @throws \xbweb\Error
         * @throws \xbweb\NodeError
         */
        public function getOne($id, $acl = true) {
            $table = DB::table($this->_table);
            $pkey  = $this->primary;
            $sql   = "select * from `{$table}` where `{$pkey}` = '{$id}'";
            if ($rows = DB::query($sql, true)) {
                if ($row = $rows->row()) {
                    $result = $acl ? $this->row($row) : $row;
                    return PipeLine::invoke($this->pipeName('row'), $result, 'one');
                }
            }
            return false;
        }

        /**
         * @param string $name
         * @param bool $acl
         * @return array|bool
         * @throws \xbweb\Error
         * @throws \xbweb\NodeError
         */
        public function get($name = '', $acl = true) {
            /** @var QuerySelect $query */
            $query = new QuerySelect($this);
            $query = PipeLine::invoke($this->pipeName('select'), $query, $name);
            $old   = $query->where;
            $op    = ($name == 'trash') ? 'not null' : 'null';
            $where = Where::create($this)->condition('deleted', null, $op);
            if ($old instanceof Where) $where->condition($old);
            $query->where($where);
            $result = array();
            if ($rows = $query->execute()) {
                while ($row = $rows->row()) {
                    $id          = $row[$this->primary];
                    $result[$id] = $acl ? $this->row($row) : $row;
                    $result[$id] = PipeLine::invoke($this->pipeName('row'), $result[$id], 'many');
                }
                return PipeLine::invoke($this->pipeName('rows'), $result);
            }
            return false;
        }

        /**
         * @param $row
         * @return array|bool
         * @throws \Exception
         */
        public function add($row) {
            $query = new QueryInsert($this);
            $query->row($row);
            if ($result = $query->execute()) {
                if (empty($result['ids'])) return false;
                return array_shift($result['ids']);
            }
            return false;
        }

        /**
         * @param $row
         * @param $id
         * @return bool
         * @throws \xbweb\NodeError
         * @throws \xbweb\DBError
         */
        public function update($row, $id) {
            $query = new QueryUpdate($this);
            $query->row($row, $id);
            if ($result = $query->execute()) return $result->success;
            return false;
        }

        /**
         * @return bool
         */
        public function table() {
            $query = new QueryTable($this);
            return $query->execute();
        }
    }