<?php
    namespace xbweb;
    /**
     * @var string $content
     */
?><!DOCTYPE html>
<html class="no-js" lang="ru"><head>
    <?=View::chunk('/head')?>
</head><body class="body">
<div class="scroll-container" data-scroll-container>
    <main class="page">
        <?=View::chunk('/header')?>
        <?=View::chunk('/menu')?>
        <div class="main-wrapper">
            <div class="container">
                <div class="crumbs"><a class="crumbs__arrow" href="#">
                        <svg class="svgsprite _crumbs-back">
                            <use xlink:href="/www/img/sprites/svgsprites.svg#crumbs-back"></use>
                        </svg></a><a class="crumbs__link" href="/">Главная</a>
                </div>
                <?=$content?>
            </div>
        </div>
        <?=View::chunk('/footer')?>
        <?=View::chunk('/content/mainfilter')?>
    </main>
</div>
<?=View::chunk('/popup')?>
</body></html>