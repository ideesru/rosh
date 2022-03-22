<?php
    namespace xbweb;

    if (empty($title))       $title       = '';
    if (empty($description)) $description = '';
    $title = 'Rosh'.(empty($title) ? '' : ' | '.$title);
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<title><?=$title?></title>
<meta name="description" content="<?=$description?>">
<meta property="og:url" content="<?=Request::canonical()?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$title?>">
<meta property="twitter:title" content="<?=$title?>">
<meta property="og:description" content="<?=$description?>">
<meta property="twitter:description" content="<?=$description?>">
<meta property="og:image" content="assets/share.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="/www/css/common.css">
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAT3JOvpJuMXozLKY-hPfjCDdEgo78vZok"></script>
<script src="/www/js/jquery-1.12.4.min.js"></script>
<script src="/www/js/jquery.autocomplete.min.js"></script>
<script src="/www/js/air-datepicker.js"></script>
<script src="/www/js/jquery.inputmask.min.js"></script>
<script src="/www/js/swiper-bundle.min.js"></script>
<script src="/www/js/main.js"></script>
