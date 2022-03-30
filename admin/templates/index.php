<?php
    namespace xbweb;
    /** @noinspection PhpUnhandledExceptionInspection */
?><!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <title>XBWeb CMF<?=(empty($title) ? '' : ' | '.$title)?></title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon" href="/favicon.png">
    <link rel="stylesheet" href="/admin/css/style.css">
    <link rel="stylesheet" href="/admin/css/themes/<?=Config::get('view/themes/admin', 'default')?>.css">
    <script type="text/javascript" src="/admin/js/jquery.js"></script>
    <script type="text/javascript" src="/admin/js/jquery.form.js"></script>
    <script type="text/javascript" src="/admin/js/ui.js"></script>
    <script type="text/javascript" src="/admin/js/scrollBar.js"></script>
    <script type="text/javascript" src="/admin/js/main.js"></script>
</head><body class="xbweb-ui">
<aside id="menu-main">
    <nav class="toggler">
        <a class="do-toggle" href="#"></a>
        <h2><a href="/">XBWeb (Lyta)</a></h2>
    </nav>
    <section class="content">
        <?=View::menu('adminleft')?>
    </section>
</aside>
<main>
    <header>
        <div class="widgets">
            <?=View::chunk('/page/widgets', array('placement' => 'left'))?>
        </div>
        <?=View::chunk('/page/menu/user')?>
    </header>
    <div id="content">
        <?=View::content()?>
    </div>
</main>
</body></html>