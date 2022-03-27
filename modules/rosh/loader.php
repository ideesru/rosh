<?php
    namespace xbweb\modules\Rosh;

    use xbweb\PipeLine;
    use xbweb\Request;

    define(__NAMESPACE__.'\\MODULE_NAME', 'Rosh');

    PipeLine::handler(MODULE_NAME, 'getContexts', function(){
        return array(Request::CTX_WWW, Request::CTX_ADMIN, 'administrator', 'expert');
    });

    class HTML {
        public static function phone($n, $c) {
            $n = preg_replace('~([^\d\+\-]+)~si', '', $n);
            return str_replace(array(
                '{s}', '{n}', '{c}'
            ), array(
                preg_replace(
                    '~(\d)(\d{3})(\d{3})(\d{2})(\d{2})~',
                    '\1 (\2) <b>\3-\4-\5</b>',
                    preg_replace('~^\+7(\d{10})$~si', '8\1', $n)
                ),
                preg_replace('~8(\d{10})~si', '+7\1', $n),
                $c
            ), '<a class="{c}" href="tel:{n}">{s}</a>');
        }

        public static function checkboxes(array $data) {
            $ret  = array();
            $rc   = ceil(count($data) / 3);
            $rows = array();
            foreach ($data as $name => $cb) {
                $rows[] = <<<html
<label class="checkbox mainfilter__checkbox">
    <input type="checkbox" name="{$name}"><span> </span>
    <div class="checbox__name">{$cb['title']}</div><a class="checbox__link --openpopup" data-popup="{$cb['popup']}" href="{$cb['url']}">Подробнее</a>
</label>
html;
                if (count($rows) >= $rc) {
                    $rows  = implode("\r\n", $rows);
                    $ret[] = <<<html
<div class="col-lg-4">
{$rows}
</div>
html;
                    $rows  = array();
                }
            }
            if (count($rows)) {
                $rows  = implode("\r\n", $rows);
                $ret[] = <<<html
<div class="col-lg-4">
{$rows}
</div>
html;
            }
            return '<div class="row">'.implode("\r\n", $ret).'</div>';
        }

        public static function selectListCB(array $data) {
            $ret = array();
            foreach ($data as $name => $cb) {
                $ret[] = <<<html
<div class="select__item select__item--checkbox">
    <label class="checkbox checkbox--record">
        <input type="checkbox" name="{$name}"><span> </span>
        <div class="checbox__name --flex --aic --jcsb">
            <div class="select__name">{$cb['title']}</div>
            <div>{$cb['price']} ₽</div>
        </div>
    </label>
</div>
html;
            }
            return implode("\r\n", $ret);
        }
    }