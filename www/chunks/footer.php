<?php
    namespace xbweb;
?>
<div class="footer">
    <div class="container">
        <div class="container-fluid">
            <div class="row footer__top">
                <div class="footer__item col-lg-2">
                    <div class="socials"><?=View::chunk('www:/content/svg-social')?></div>
                </div>
                <div class="footer__item col-lg-3"><a class="footer__contact text-small text-grey" href="mailto:<?=Config::get('site/email')?>"><?=Config::get('site/email')?></a></div>
                <div class="footer__item col-lg-7"><a class="footer__contact text-small text-grey" href="/contacts"><?=Config::get('site/address')?></a></div>
            </div>
            <div class="row footer__bottom">
                <div class="footer__item col-lg-2"><a class="text-small" href="/">&copy; ROSH, 2021</a></div>
                <div class="footer__item col-lg-3"><a class="text-small policy" href="/policy">Политика конфиденциальности</a></div>
                <div class="footer__item col-lg-7 --flex --jcsb"><a class="text-small map-site" href="/site-map">Карта сайта</a>
                    <p class="text-small">Лицензия №ЛО-77-01-002172 от 12.01.2010</p><a class="develop" href="http://idees.ru/">
                        <svg class="svgsprite _develop">
                            <use xlink:href="/www/img/sprites/svgsprites.svg#develop"></use>
                        </svg></a>
                </div>
            </div>
        </div>
    </div>
</div>
