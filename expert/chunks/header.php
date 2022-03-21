<?php
    namespace xbweb;
?>
<header class="header header--transparent --unfilter">
    <div class="container --flex --jcsb --aicn"><a class="header__logo" href="/"> <img src="/www/img/logo.svg"></a>
        <div class="header__left --flex --aicn">
            <div class="header__contacts"> <a class="header__contact" href="tel:+74951320169"> 8 (495) <b>132-01-69</b></a>
                <div class="header__contact header__contact--small">Пн-Сб, с <b>10:00</b> до <b>21:00</b> </div>
            </div>
        </div>
        <div class="header__right --flex --aicn">
            <?=View::chunk('www:/menu/profile')?>
            <button class="burger"></button>
        </div>
    </div>
</header>

