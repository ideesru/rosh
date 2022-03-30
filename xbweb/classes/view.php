<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Basic view system
     * @category     View components
     * @link         https://xbweb.org/doc/dist/classes/view
     */

    namespace xbweb;

    use xbweb\lib\Content;
    use xbweb\lib\Template;

    /**
     * Basic view system class
     */
    class View {
        protected static $_fn = null;

        /**
         * Register function
         * @param string   $name  Function method
         * @param callable $fn    Function
         * @return bool
         */
        public static function fn_set($name, $fn) {
            if (self::$_fn === null) self::$_fn = array();
            if (!is_callable($fn)) return false;
            self::$_fn[$name] = $fn;
            return true;
        }

        /**
         * Execute function
         * @return mixed
         */
        public static function fn() {
            $args = func_get_args();
            if (count($args) < 1) return false;
            $name = array_shift($args);
            if (!isset(self::$_fn[$name])) return false;
            if (!is_callable(self::$_fn[$name])) return false;
            return call_user_func_array(self::$_fn[$name], $args);
        }

        /**
         * Get template file
         * @param string $path  Request path
         * @param mixed  $data  Data
         * @param bool   $sys   Include system content folder
         * @return string
         */
        public static function template($path = null, $data = null, $sys = false) {
            $req = ($path === null) ? Request::get() : Request::route($path);
            if (empty($data['template'])) {
                $fn  = empty($req['template']) ? 'index' : $req['template'];
                $mod = $req['module'];
            } else {
                $fn  = explode('/', $data['template']);
                $mod = array_shift($fn);
                $fn  = implode('/', $fn);
            }
            $fn  = Content::file($fn.'.'.Content::EXT_TPL, 'templates', $mod, $sys, $_fl);
            return Content::render($fn, $data, $_fl);
        }

        /**
         * Get template file
         * @param string $path  Request path
         * @param mixed  $data  Data
         * @param bool   $sys   Include system content folder
         * @return string
         */
        public static function content($path = null, $data = null, $sys = false) {
            if (CMF::isError()) return self::_error();
            $req = ($path === null) ? Request::get() : Request::route($path);
            $fn  = empty($req['page']) ? 'index' : $req['page'];
            $dlg = array($fn.'.'.Content::EXT_PAGE);
            if (!empty($data['window'])) {
                $tpl = $data['window'] === true ? (
                    empty($data['status']) ? 'success' : $data['status']
                ) : $data['window'];
                $dlg[] = $tpl.'.'.Content::EXT_PAGE;
            }
            $fn  = Content::file($dlg, 'pages', $req['module'], $sys, $_fl);
            return Content::render($fn, $data, $_fl);
        }

        /**
         * Get template file
         * @param string $path  Request path
         * @param mixed  $data  Data
         * @param bool   $sys   Include system content folder
         * @return string
         */
        public static function chunk($path, $data = null, $sys = false) {
            $fn  = Content::chunk($path, $sys, $_fl);
            return Content::render($fn, $data, $_fl);
        }

        /**
         * Rows
         * @param array  $rows  Rows
         * @param string $tpl   Template
         * @return string
         */
        public static function rows($rows, $tpl) {
            $ret = array();
            foreach ($rows as $name => $row) {
                $r = str_replace('[+name+]', $name, $tpl);
                foreach ($row as $k => $v) $r = str_replace('[+'.$k.'+]', $v, $r);
                $ret[] = $r;
            }
            return implode("\r\n", $ret);
        }

        /**
         * @param string $place  Menu placement
         * @param mixed  $tpls   Templates
         * @return string
         * @throws Error
         */
        public static function menu($place, $tpls = null) {
            $data = array();
            switch ($place) {
                case 'adminleft':
                case 'userprofile':
                    $fn = Paths\CORE.'data/menu/'.$place.'.json';
                    if (file_exists($fn)) $data = json_decode(file_get_contents($fn), true);
                    $mods = \xbweb::modules();
                    foreach ($mods as $m) {
                        $fn = Paths\MODULES.$m.'/data/menu/'.$place.'.json';
                        if (!file_exists($fn)) continue;
                        $menu = json_decode(file_get_contents($fn), true);
                        if (empty($menu)) continue;
                        $data = array_merge_recursive($data, $menu);
                    }
                    break;
            }
            if (empty($data)) return '';
            $data = PipeLine::invoke('menu', $data, $place);
            return Template::menu($data, $tpls, $place);
        }

        public static function form($action, $form, $values = null, $errors = null) {
            $caption = Language::action($action);
            $url     = Request::URL($action);
            $action  = explode('/', $action);
            $module  = array_shift($action);
            $cats    = array();
            $tabs    = array();
            $f       = true;
            foreach ($form as $cat => $fields) {
                if (empty($fields)) continue;
                $a   = $f ? 'active' : '';
                $f   = false;
                $tab = array();
                $c   = count($form) > 1 ? 'tab '.$a : 'single-tab';
                foreach ($fields as $fid => $field) {
                    $fc    = explode('/', $field['class']);
                    $mn    = array_shift($fc);
                    $fp    = $mn.'/fields/'.implode('/', $fc);
                    $key   = 'field-'.(empty($module) ? '' : $module.'-').$fid;
                    $field = Language::field($key, $field);
                    $field['value'] = isset($values[$fid]) ? $values[$fid] : null;
                    $tab[] = self::chunk($fp, $field, true);
                }
                $tab    = implode("\r\n", $tab);
                $cats[] = '<a href="#form-category-'.$cat.'" class="'.$a.'">'.Language::translate('category-'.$cat).'</a>';
                $tabs[] = <<<html
<section id="form-category-{$cat}" class="{$c}">
    {$tab}
</section>
html;
            }
            if (count($cats) > 1) {
                $cats = implode("\r\n", $cats);
                $cats = <<<html
<nav class="tabs">
    {$cats}
</nav>
html;
            } else {
                $cats = '';
            }
            $tabs = implode("\r\n", $tabs);
            $buttons = array(
                'edit'  => Language::translate('edit'),
                'save'  => Language::translate('save'),
                'reset' => Language::translate('reset'),
            );
            $errs = array();
            if (!empty($errors)) foreach ($errors as $k => $v) {
                if (is_int($k)) {
                    $errs[] = '<li class="error">'.$v.'</li>';
                } else {
                    $f = Language::translate('field-'.(empty($module) ? '' : $module.'-').$k);
                    $e = Language::translate('error-'.$v);
                    $errs[] = '<li class="error">'.$f.': '.$e.'</li>';
                }
            }
            if (!empty($errs)) {
                $errs = implode("\r\n", $errs);
                $errs = <<<html
<ul class="messages">
{$errs}
</ul> 
html;
            } else {
                $errs = '';
            }
            return <<<html
<form action="{$url}" method="post" enctype="multipart/form-data">
    <h2>{$caption}</h2>
    {$errs}
    {$cats}
    {$tabs}
    <div class="buttons">
        <button type="submit" name="action" value="edit" class="ok">{$buttons['edit']}</button>
        <button type="submit" name="action" value="save" class="ok">{$buttons['save']}</button>
        <button type="reset">{$buttons['reset']}</button>
    </div>
</form> 
html;
        }

        /**
         * Render view
         * @param mixed  $data  Variables
         * @param string $path  Render path
         * @return string
         */
        public static function render($data = null, $path = null) {
            if (CMF::isError()) {
                // Template
                $fnt = Content::file(array(
                    'errors/'.http_response_code().'.'.Content::EXT_TPL,
                    'errors/500.'.Content::EXT_TPL,
                    'error.'.Content::EXT_TPL
                ), 'templates', Request::get('module'), true, $_fl_tpl);
                $tpl = ($fnt === false) ? Paths\CORE.'content/templates/error.'.Content::EXT_TPL : $fnt;
                // Content
                $content = self::_error($data);
                if (Request::isAJAX()) {
                    return $content;
                } else {
                    $data['content'] = $content;
                    return Content::render($tpl, $data, $_fl_tpl);
                }
            } else {
                $content = self::content($path, $data, true);
                if (Request::isAJAX()) {
                    return $content;
                } else {
                    $data['content'] = $content;
                    return self::template($path, $data, true);
                }
            }
        }

        /**
         * Converts seconds to other units
         * @param mixed  $v  Input value
         * @param string $u  Units
         * @return string
         */
        public static function seconds($v, $u = '') {
            $v = floatval($v);
            switch ($u) {
                case 'ms': $v *= 1000; break;
                case 'us': $v *= 1000000; break;
                case 'ns': $v *= 1000000000; break;
            }
            return strval(round($v, 2));
        }

        /**
         * Converts bytes to more higher units
         * @param mixed  $v  Input value
         * @param string $u  Units
         * @return string
         */
        public static function bytes($v, $u = '') {
            $v = intval($v);
            switch ($u) {
                case 'kb': $v /= 1024; break;
                case 'mb': $v /= 1048576; break;
                case 'gb': $v /= 1073741824; break;
            }
            return strval(round($v, 2));
        }

        protected static function _error($data = null) {
            // Current vars
            $fnc = Content::file(array(
                'errors/'.http_response_code().'.'.Content::EXT_PAGE,
                'errors/500.'.Content::EXT_PAGE,
                'error.'.Content::EXT_PAGE
            ), 'pages', Request::get('module'), true, $_fl_cnt);
            $cnt = ($fnc === false) ? Paths\CORE.'content/pages/error.'.Content::EXT_PAGE : $fnc;
            return Content::render($cnt, $data, $_fl_cnt);
        }
    }