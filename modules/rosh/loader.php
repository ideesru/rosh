<?php
    namespace xbweb;

    View::fn_set('phone', function($n, $c){
        $n = preg_replace('~([^\d\+\-]+)~si', '', $n);
        return str_replace(array(
            '{s}', '{n}', '{c}'
        ), array(
            preg_replace(
                '~(\d)(\d{3})(\d{3})(\d{2})(\d{2})~',
                '\1\2 (\3) <b>\4-\5-\6</b>',
                preg_replace('~^\+7(\d{10})$~si', '8\1', $n)
            ),
            preg_replace('~8(\d{10})~si', '+7\1', $n),
            $c
        ), '<a class="{c}" href="tel:{n}">{s}</a>');
    });

    View::fn_set('checkboxes', function($data){
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
    });

    View::fn_set('select-list-cb', function($data){
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
    });