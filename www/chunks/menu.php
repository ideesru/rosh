<?php
    namespace xbweb;

    $menu = array(
        'Услуги'           => '/services',
        'Проблемы'         => '/problems',
        'Магазин'          => '/shop',
        'Блог'             => '/blog',
        'Libi & Daughters' => '/l-n-d',
        'О клинике'        => array(
            'О клинике'    => '/about',
            'Оборудование' => '/equipment',
            'Галерея'      => '/gallery',
            'Специалисты'  => '/experts',
        ),
        'Контакты'         => '/contacts'
    );
    $current = '/'.Request::get('path');
?>
<div class="menu" id="mainmenu">
    <nav class="nav">
        <?php
            foreach ($menu as $title => $link) {
                $m = array();
                if (is_array($link)) {
                    $o = in_array($current, $link) ? ' active' : '';
                    $l = array();
                    foreach ($link as $stitle => $slink) {
                        $a = $current == $link ? ' active' : '';
                        $l[] = '<div class="nav__link'.$a.'"><a href="'.$slink.'">'.$stitle.'</a></div>';
                    }
                    $l = implode("\r\n", $l);
                    $m[] = <<<html
<div class="nav__link ddl{$o}"><a href="/about">О клинике</a> <svg class="svgsprite _drop">
    <use xlink:href="assets/img/sprites/svgsprites.svg#drop"></use>
</svg></div>
<div class="nav__group ddm">
{$l}  
</div>
html;
                } else {
                    $a = $current == $link ? ' active' : '';
                    $m[] = '<div class="nav__link'.$a.'"><a href="'.$link.'">'.$title.'</a></div>';
                }
                echo implode("\r\n", $m);
            }
        ?>
    </nav>
    <div class="mobile-btns">
        <!-- button class="btn btn--white --openfilter mb-10">Подобрать услугу</button -->
        <div class="--flex">
            <button class="btn btn-link --openpopup pl-0" data-popup="--fast">Записаться на прием</button>
            <button class="btn btn-link enter --openpopup" data-popup="--enter-number">Войти</button>
        </div>
    </div>
    <?=View::chunk('www:/content/svg-social')?>
    <div class="menu__contacts">
        <a class="text-small text-grey" href="/contacts"><?=Config::get('site/address')?></a>
        <a class="text-small text-grey" href="mailto:<?=Config::get('site/email')?>"><?=Config::get('site/email')?></a>
    </div>
    <a class="en-version" href="/en">
        <svg class="svgsprite _web">
            <use xlink:href="/www/img/sprites/svgsprites.svg#web"></use>
        </svg>English version
        <svg class="svgsprite _arrow-link">
            <use xlink:href="/www/img/sprites/svgsprites.svg#arrow-link"></use>
        </svg>
    </a>
</div>