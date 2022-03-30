<?php /** @noinspection PhpUnhandledExceptionInspection */
    namespace xbweb;

    use xbweb\modules\Rosh\HTML;
?>
<header class="header header--transparent header--fixed --unfilter">
    <div class="container --flex --jcsb --aicn"><a class="header__logo" href="/"><img src="/www/img/logo.svg"></a>
        <div class="header__left --flex --aicn">
            <div class="header__contacts">
                <?=HTML::phone(Config::get('site/phone'), 'header__contact')?>
                <div class="header__contact header__contact--small">Пн-Сб, с <b>10:00</b> до <b>21:00</b> </div>
            </div>
            <a class="btn btn--white --openfilter" href="#mainfilter">Подобрать услугу</a>
        </div>
        <div class="header__right --flex --aicn">
            <button class="btn btn-link --openpopup --mobile-fade" data-popup="--fast">Записаться на прием</button>
            <?php
                if (User::current()->authorized) {
                    echo View::chunk('www:/menu/profile');
                } else {
                    echo '<button class="btn btn-link enter --openpopup --mobile-fade" data-popup="--enter-number">Войти</button>';
                }
            ?>
            <button class="burger"></button>
        </div>
    </div>
</header>
