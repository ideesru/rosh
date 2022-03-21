<?php
    namespace xbweb;
?>
<header class="header header--transparent header--admin">
    <div class="container --flex --jcsb --aicn">
        <div class="header__admin --flex --aicn">
            <span class="lower-deck"><button class="btn btn--white loaddata --openpopup" data-popup="--download-data">
                <svg class="svgsprite _xl">
                    <use xlink:href="/www/img/sprites/svgsprites.svg#xl"></use>
                </svg>Выгрузить данные
            </button><a class="btn btn-link" href="/admin/photos">Медиатека</a></span><a class="btn btn-link" href="/admin/changes">Журнал изменений</a>
        </div>
        <div class="header__right --flex --aicn">
            <?=View::chunk('/menu/profile')?>
            <button class="burger"></button>
        </div>
    </div>
</header>
