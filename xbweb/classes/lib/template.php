<?php
    namespace xbweb\lib;

    use xbweb\ACL;
    use xbweb\Request;

    class Template {
        const TPL_MENU_BLOCK = <<<HTML
<nav class="[+classes+]">
  <h2>[+title+]</h2>
  <ul>
    [+items+]
  </ul>
</nav>
HTML;
        const TPL_MENU_CATEGORY = <<<HTML
<li class="[+classes+]">
  <span>[+title+][+counter+]</span>
  <ul>
    [+items+]
  </ul>
</li>
HTML;
        const TPL_MENU_ITEM = <<<HTML
<li class="[+classes+]"><a href="[+url+]">[+title+][+counter+]</a></li>
HTML;

        /**
         * @param null $data
         * @param null $tpls
         * @param null $place
         * @return string
         * @throws \xbweb\Error
         * @throws \xbweb\ErrorNotFound
         */
        public static function menu($data = null, $tpls = null, $place = null) {
            static $level = -1;

            if (empty($data))     $data  = array();
            if (empty($place))    $place = 'main';
            if (!is_array($tpls)) $tpls  = array();
            if (empty($tpls['block']))    $tpls['block']    = static::TPL_MENU_BLOCK;
            if (empty($tpls['category'])) $tpls['category'] = static::TPL_MENU_CATEGORY;
            if (empty($tpls['item']))     $tpls['item']     = static::TPL_MENU_ITEM;

            $ret = array();
            $level++;
            foreach ($data as $key => $item) {
                $type = empty($item['type']) ? 'item' : $item['type'];
                if (empty($tpls[$type])) continue;
                if (in_array($type, array('block', 'category'))) {
                    if (empty($item['items']) || !is_array($item['items'])) continue;
                    $item['items'] = self::menu($item['items'], $tpls);
                    $a = trim($item['items']);
                    if (empty($a)) continue;
                } else {
                    $a = empty($item['action']) ? '' : $item['action'];
                    if (!empty($a)) if (!ACL::granted($item['action'], null, false)) continue;
                }
                $item['key'] = $key;
                $tpl = $tpls[$type];
                if (empty($item['title']))  $item['title']  = ucfirst($key);
                if (empty($item['action'])) $item['action'] = '';
                $action = empty($item['id']) ? $item['action'] : $item['action'].'/'.$item['id'];
                if (empty($item['url']))    $item['url']    = Request::URL($action);
                if (empty($item['action'])) $item['action'] = $item['url'];
                $classes = array('menu-'.$type, 'key-'.$key);
                if ($type == 'block') $classes[] = 'place-'.$place;
                foreach ($item as $k => $v) {
                    if (is_array($v)) continue;
                    switch ($k) {
                        case 'modal' :
                            if (!empty($v)) $classes[] = 'modal';
                            break;
                        case 'newtab':
                            if (!empty($v)) $tpl = str_replace('<a ', '<a target="_blank" ', $tpl);
                            break;
                        case 'counter':
                            if ($v === false) continue;
                            $a = intval($v) > 0 ? ' active' : '';
                            if (isset($item['counter-url'])) {
                                $cnt = '<a class="counter'.$a.'" href="'.$item['counter-url'].'">'.$v.'</a>';
                            } else {
                                $cnt = '<span class="counter'.$a.'">'.$v.'</span>';
                            }
                            $tpl = str_replace('[+counter+]', $cnt, $tpl);
                            break;
                        default:
                            $tpl = str_replace("[+{$k}+]", $v, $tpl);
                    }
                }
                $ret[] = str_replace(array(
                    '[+classes+]', '[+level+]', '[+counter+]'
                ), array(
                    implode(' ', $classes), $level, ''
                ), $tpl);
            }
            $level--;
            return implode("\r\n", $ret);
        }
    }