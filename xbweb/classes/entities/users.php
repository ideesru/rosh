<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Users library
     * @category     Entities libraries
     * @link         https://xbweb.org/doc/dist/classes/entities/users
     */

    namespace xbweb\Entities;

    use xbweb\lib\Flags as LibFlags;
    use xbweb\lib\Roles as LibRoles;

    use xbweb\Error;
    use xbweb\ErrorDeleted;
    use xbweb\ErrorNotFound;

    use xbweb\DB;
    use xbweb\Config;

    /**
     * Users library
     */
    class Users {
        const FLAGS = ',moderator,admin,root,neo';
        const ROLES = ',moderator,admin,root,neo';

        /**
         * Correct users data
         * @param array $row  User data array
         * @return array
         */
        public static function correct($row = array()) {
            return array(
                'id'        => empty($row['id'])        ? 0       : intval($row['id']),
                'login'     => empty($row['login'])     ? ''      : $row['login'],
                'email'     => empty($row['email'])     ? ''      : $row['email'],
                'phone'     => empty($row['phone'])     ? ''      : $row['phone'],
                'created'   => empty($row['created'])   ? null    : $row['created'],
                'activated' => empty($row['activated']) ? null    : $row['activated'],
                'deleted'   => empty($row['deleted'])   ? null    : $row['deleted'],
                'role'      => empty($row['role'])      ? array() : LibRoles::toArray($row['role']),
                'flags'     => empty($row['flags'])     ? array() : LibFlags::toArray(static::FLAGS, $row['flags']),
                'blocks'    => empty($row['blocks'])    ? array() : $row['blocks'],
                'sessions'  => empty($row['sessions'])  ? array() : $row['sessions'],
                'settings'  => empty($row['settings'])  ? array() : $row['settings'],
                'acl'       => empty($row['acl'])       ? array() : $row['acl'],
                'values'    => empty($row['values'])    ? array() : $row['values'],
            );
        }

        /**
         * Get basic user group
         * @param array $data User data array
         * @return string
         */
        public static function role($data) {
            if (empty($data['id'])) return 'anonimous';
            $flags = empty($data['role']) ? 0 : LibRoles::toInt($data['role']);
            if (LibRoles::is('root', $flags))  return 'root';
            if (static::isDeleted($data))      return 'deleted';
            if (!empty($data['blocks']))       return 'blocked';
            if (empty($data['activated']))     return 'inactive';
            if (LibRoles::is('admin', $flags)) return 'admin';
            $R = LibRoles::is('moderator', $flags) ? 'moderator' : 'user';
            return $R;
        }

        /**
         * Check user is deleted
         * @param array $data  User data array
         * @return bool
         */
        public static function isDeleted($data) {
            return !empty($data['deleted']);
        }

        /**
         * Get user by login
         * @param string $login  Login
         * @return array
         * @throws Error
         */
        public static function getByLogin($login) {
            if (preg_match(\xbweb::REX_EMAIL, $login)) {
                $f = 'email';
            } else {
                $l = preg_replace('~([^\-\+\d]+)~si', '', $login);
                if (preg_match(\xbweb::REX_PHONE, $l)) {
                    $login = $l;
                    $f = 'phone';
                } else {
                    $f = 'login';
                }
            }
            return self::getBy_($f, $login, true);
        }

        /**
         * Get user by ID
         * @param int $id  User ID
         * @return array
         * @throws Error
         * @throws ErrorNotFound
         */
        public static function getByID($id) {
            if (empty($id)) throw new Error('User ID is empty');
            return self::getBy_('id', intval($id));
        }

        /**
         * Get user by field
         * @param string $key Field name
         * @param mixed $value Value
         * @param bool $m MD5 field value
         * @return array
         * @throws Error
         * @throws ErrorDeleted
         * @throws ErrorNotFound
         * @throws \Exception
         */
        protected static function getBy_($key, $value, $m = false) {
            if (empty($value)) throw new Error('User value is empty');
            // Entity
            $P = null;
            $key = $m ? "md5(`{$key}`)" : "`{$key}`";
            $val = $m ? md5($value)     : $value;
            $tf  = DB::table('users');
            $sql = "select * from `{$tf}` where {$key} = '{$val}'";
            if ($data = DB::row($sql, __METHOD__)) {
                $P = $data['password'];
                $data = self::correct($data);
                if (self::isDeleted($data)) {
                    if (Config::get('users/allow_410', true)) {
                        throw new ErrorDeleted('User deleted', $value);
                    } else {
                        throw new ErrorNotFound('User not found', $value);
                    }
                }
            } else {
                throw new ErrorNotFound('User not found', $value);
            }
            if (empty($data)) throw new ErrorNotFound('User not found', $value);
            $data['password'] = $P;
            // Return data
            return $data;
        }
    }