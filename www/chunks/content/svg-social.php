<?php
    $sn = array(1 => '', 2 => '', 3, '', 4 => '');
    foreach ($sn as $k => $v) {
        ?><a class="socials__link" href="<?=$v?>"><svg class="svgsprite _socials-<?=$k?>">
                <use xlink:href="/www/img/sprites/svgsprites.svg#socials-<?=$k?>"></use>
            </svg></a><?php
    }