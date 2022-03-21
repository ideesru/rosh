<?php
    namespace xbweb;
?>
<div class="popup --create-appoint">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Записать пациента на прием</div>
        <form class="popup__form">
            <p class="text-bold text-big mb-20">Мартынова Александра Михайловна</p>
            <div class="select-form">
                <div class="select">
                    <div class="select__main">
                        <div class="select__placeholder">Услуга</div>
                        <div class="select__values"> </div>
                    </div>
                    <div class="select__list">
                        <?php
                            $tpl = <<<html
<div class="select__item select__item--checkbox">
    <label class="checkbox checkbox--record">
        <input type="checkbox" name="[+name+]"><span> </span>
        <div class="checbox__name --flex --aic --jcsb">
            <div class="select__name">[+title+]</div>
            <div>[+price+] ₽</div>
        </div>
    </label>
</div>
html;
                            echo View::rows(array(
                                'service[1]' => array('title' => 'Внутривенное введение лекарственных препаратов - капельница (Антиоксидантная)', 'price' => '6 000'),
                                'service[2]' => array('title' => 'Дерматологический пилинг Cosmedix Purity ретиноевый', 'price' => '7 000'),
                                'service[3]' => array('title' => 'Дерматологический пилинг Enerpeel Jessners салициловый-резорциновый', 'price' => '6 000'),
                                'service[4]' => array('title' => 'Дерматологический пилинг для кожи с гиперпигментацией "SC Pigment Balancing Peel"', 'price' => '8 000'),
                            ), $tpl)
                        ?>
                    </div>
                </div>
            </div>
            <p class="mb-10">Тип события</p>
            <div class="radios --flex">
                <label class="text-radio">
                    <input type="radio" name="status233"><span>В клинике</span>
                </label>
                <label class="text-radio">
                    <input type="radio" name="status233"><span>Онлайн</span>
                </label>
            </div>
            <div class="select-form">
                <div class="select">
                    <div class="select__main">
                        <div class="select__placeholder">Выберите специалиста</div>
                        <div class="select__values"> </div>
                    </div>
                    <div class="select__list">
                        <?php
                            $tpl = <<<html
<div class="select__item select__item--checkbox">
    <label class="checkbox checkbox--record">
        <input type="checkbox" name="[+name+]"><span> </span>
        <div class="checbox__name">
            <div class="select__name">[+title+]</div>
        </div>
    </label>
</div>
html;
                            echo View::rows(array(
                                'expert[1]' => array('title' => 'Хачатурян Любовь Андреева 1'),
                                'expert[2]' => array('title' => 'Хачатурян Любовь Андреева 2'),
                                'expert[3]' => array('title' => 'Хачатурян Любовь Андреева 3'),
                                'expert[4]' => array('title' => 'Хачатурян Любовь Андреева 4'),
                                'expert[5]' => array('title' => 'Хачатурян Любовь Андреева 5'),
                            ), $tpl)
                        ?>
                    </div>
                </div>
            </div>
            <div class="calendar input mb-30">
                <input class="input__control datetimepickr" type="text" placeholder="Выбрать дату и время">
                <div class="input__placeholder">Выбрать время и дату</div>
            </div>
            <button class="btn btn--black">Продолжить</button>
        </form>
    </div>
</div>
