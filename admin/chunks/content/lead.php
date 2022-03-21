<?php
    namespace xbweb;

    /**
     * @var string $color
     * @var string $created
     * @var string $updated
     * @var array  $patient
     * @var array  $expert
     * @var array  $type
     * @var array  $payment
     * @var array  $status
     * @var array  $services
     * @var array  $comments
     */
    $dto = new \DateTime($created);
    $created_date = $dto->format('Y-m-d');
    $created_time = $dto->format('H:i:s');
    $dto = new \DateTime($updated);
    $updated_date = $dto->format('Y-m-d');
    $updated_time = $dto->format('H:i:s');
    $services_l = array();
    foreach ($services as $service) $services_l[] = $service['name'];
    $comments_l = array();
    foreach ($comments as $comment) $comments_l[] = $comment['text'];
?>
<div class="acount__table-accardeon accardeon --<?=$color?> acount__table-accardeon--pmin">
    <div class="acount__table-main accardeon__main acount__table-auto">
        <div class="admin-events-item heap">
            <div class="accardeon__click"></div>
            <div class="flag-date">
                <label class="checkbox">
                    <input type="checkbox"><span> </span>
                </label>
                <button class="flag-date__ico">
                    <svg class="svgsprite _flag">
                        <use xlink:href="/www/img/sprites/svgsprites.svg#flag"></use>
                    </svg>
                </button>
                <span class="dt"><strong class="title">Заявка: </strong><?=$created_date?> <br><?=$created_time?></span>
            </div>
        </div>
        <div class="admin-events-item">
            <p>Приём</p>
            <span class="dt"><?=$updated_date?> <br><?=$updated_time?></span>
        </div>
        <div class="admin-events-item">
            <p>ФИО</p><a href="#"><?=$patient['fio']?></a>
        </div>
        <div class="admin-events-item">
            <p>Телефон</p><?=$patient['phone']?>
        </div>
        <div class="admin-events-item">
            <p>Специалист</p><?=$expert['fio']?>
        </div>
        <div class="admin-events-item">
            <p>Тип</p><?=$type['name']?>
        </div>
        <div class="admin-events-item">
            <p>Услуга</p><?=implode("\r\n", $services_l)?>
        </div>
        <div class="admin-events-item">
            <p>Оплата</p><?=$payment['name']?>
        </div>
        <div class="admin-events-item">
            <p>Статус</p><?=$status['name']?>
        </div>
        <div class="admin-events-item">
            <p>Комментарии</p><?=implode("\r\n", $comments_l)?>
        </div>
    </div>
    <div class="acount__table-list accardeon__list admin-editor">
        <div class="admin-editor__top">
            <div class="admin-editor__top-info">
                <div class="lk-title">Редактировать профиль</div>
                <div class="admin-editor__name user__edit"><?=$patient['fio']?>
                    <button class="user__edit">
                        <svg class="svgsprite _edit">
                            <use xlink:href="/www/img/sprites/svgsprites.svg#edit"></use>
                        </svg>
                    </button>
                </div>
                <div class="admin-editor__iser-contacts">
                    <p>Дата рождения: <span><?=$patient['birthday']?></span></p>
                    <p>Телефон: <span><?=$patient['phone']?></span></p>
                </div>
            </div>
            <div class="admin-editor__top-status">
                <div class="admin-editor__top-date">Заявка сформирована <?=$created_date?> / <?=$created_time?></div>
                <div class="admin-editor__top-select">
                    <?=View::chunk('/inputs/pay')?>
                    <?=View::chunk('/inputs/status')?>
                </div>
            </div>
        </div>
        <div class="admin-editor__edit-profile">
            <?=View::chunk('/content/form')?>
        </div>
        <div class="admin-editor__events">
            <div class="row">
                <div class="col-md-7">
                    <div class="lk-title">Редактировать заявку</div>
                    <div class="admin-editor__event mb-20">
                        <div class="search__block --flex --aicn">
                            <div class="input">
                                <input class="search__input" type="text" placeholder="Поиск">
                            </div>
                            <button class="btn btn--black">Найти</button>
                        </div>
                    </div>
                    <div class="admin-editor__event mb-20">
                        <?=View::chunk('/inputs/services')?>
                    </div>
                    <div class="admin-editor__type-event">
                        <p class="mb-10">Тип события</p>
                        <div class="text-radios">
                            <label class="text-radio">
                                <input type="radio" name="status" checked><span>В клинике</span>
                            </label>
                            <label class="text-radio">
                                <input type="radio" name="status"><span>Онлайн</span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?=View::chunk('/inputs/spec')?>
                            </div>
                            <div class="col-md-6">
                                <div class="input input-lk-calendar input--grey">
                                    <input class="input__control datetimepickr" type="text" placeholder="Выбрать дату и время">
                                    <div class="input__placeholder">Выбрать дату и время</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="admin-editor__patient">
                        <div class="lk-title">Выбраны услуги</div>
                        <div class="search__drop-item">
                            <div class="search__drop-name">
                                <div class="search__drop-delete">
                                    <svg class="svgsprite _delete">
                                        <use xlink:href="/www/img/sprites/svgsprites.svg#delete"></use>
                                    </svg>
                                </div>
                                <div class="search__drop-tags">
                                    <div class="search__drop-tag --yellow">Л</div>
                                </div>Прием (осмотр, консультация врача-дерматовенеролога главного врача первичный (включает составление плана лечения).
                            </div>
                            <label class="search__drop-right">
                                <div class="search__drop-summ">7 000 ₽</div>
                            </label>
                        </div>
                    </div>
                    <div class="admin-editor__summ">
                        <p>Всего</p>
                        <p>7 000 ₽ </p>
                    </div>
                    <button class="btn btn--white">Сохранить</button>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4 --jcfe --flex">
                    <textarea class="admin__editor-textarea" placeholder="Добавить комментарий"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
