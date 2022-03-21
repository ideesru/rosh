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
        <?=$content?>
        <?=View::chunk('/footer')?>
        <?=View::chunk('/content/mainfilter')?>
    </main>
</div>
<?=View::chunk('/popup')?>
<?=View::chunk('/content/sliders/main')?>
</body></html>