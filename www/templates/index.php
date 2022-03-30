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
    <?=View::chunk('/header')?>
    <?=View::chunk('/menu')?>
    <main class="page">
        <?=$content?>
    </main>
    <?=View::chunk('/footer')?>
</div>
<?=View::chunk('/content/mainfilter')?>
<?=View::chunk('/popup')?>
<?=View::chunk('/content/sliders/main')?>
</body></html>