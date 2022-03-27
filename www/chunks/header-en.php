<?php
    namespace xbweb;

    use xbweb\modules\Rosh\HTML;
?>
<header class="header header--transparent header--fixed --unfilter">
    <div class="container --flex --jcsb --aicn"><a class="header__logo" href="/en"><img src="/www/img/logo.svg" alt=""></a>
        <div class="header__left --flex --aicn">
            <div class="header__contacts">
                <?=HTML::phone(Config::get('site/phone'), 'header__contact')?>
                <div class="header__contact header__contact--small">Mon-Sat, <b>10am</b> - <b>9pm</b> </div>
            </div>
        </div>
        <div class="header__right --flex --aicn">
            <button class="burger"></button>
        </div>
    </div>
</header>
