<?php /** @noinspection PhpUnhandledExceptionInspection */
    namespace xbweb;
?>
<a class="phone --openpopup" href="#" data-popup="--fast"><svg class="svgsprite _phone">
    <use xlink:href="/www/img/sprites/svgsprites.svg#phone"></use>
</svg></a>
<?php
    if (User::current()->authorized) {

    } else {
        foreach (array('by-email', 'by-phone', 'recover', 'sent', 'recovered') as $k) {
            echo View::chunk('www:/popup/auth/'.$k);
        }
    }
?>
<?=View::chunk('www:/popup/analyze-type')?>
<?=View::chunk('www:/popup/code')?>
<?=View::chunk('www:/popup/download')?>
<?=View::chunk('www:/popup/download-data')?>
<?=View::chunk('www:/popup/eq')?>
<?=View::chunk('www:/popup/fast')?>
<?=View::chunk('www:/popup/fast-make')?>
<?=View::chunk('www:/popup/filter')?>
<?=View::chunk('www:/popup/pay')?>
<?=View::chunk('www:/popup/pay-one')?>
<?=View::chunk('www:/popup/photo')?>
<?=View::chunk('www:/popup/photo-edit')?>
<?=View::chunk('www:/popup/problems')?>
<?=View::chunk('www:/popup/record')?>
<?=View::chunk('www:/popup/reg')?>
<?=View::chunk('www:/popup/sent')?>
<?=View::chunk('www:/popup/service')?>
<?=View::chunk('www:/popup/service-l')?>
<?=View::chunk('www:/popup/create/form')?>
<?=View::chunk('www:/popup/create/recover')?>
<?=View::chunk('www:/popup/create/appoint')?>