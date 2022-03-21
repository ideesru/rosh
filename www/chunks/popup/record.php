<div class="popup --record">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Запись на прием</div>
        <div class="text-bold mb-10">Разделы услуг</div>
        <div class="popups__text-chexboxs">
            <label class="text-radio"><input type="radio" name="status"><span>Лицо</span></label>
            <label class="text-radio switch-blocks"><input type="radio" name="status"><span>Тело</span></label>
            <label class="text-radio switch-blocks"><input type="radio" name="status"><span>Волосы</span></label>
            <label class="text-radio switch-blocks"><input type="radio" name="status"><span>Гинекология</span></label>
            <label class="text-radio switch-blocks"><input type="radio" name="status"><span>Лаборатория</span></label>
        </div>
        <div class="input">
            <input class="search__input" type="text" placeholder="Поиск по услугам" id="popup-services-list">
            <button class="search__btn" type="button">
                <svg class="svgsprite _search">
                    <use xlink:href="/www/img/sprites/svgsprites.svg#search"></use>
                </svg>
            </button>
        </div>
        <label class="checkbox checkbox--record show-checkbox" data-show-input="service">
            <input class="checkbox-visible-next-form" type="checkbox"><span></span>
            <div class="checbox__name">Консультация врача</div>
        </label>
        <div class="select-form" style="display: none;" data-show="service">
            <div class="text-bold mb-20">Тип события</div>
            <div class="popups__text-chexboxs">
                <label class="text-radio"><input type="radio" name="status-service"><span>В клинике</span></label>
                <label class="text-radio switch-blocks"><input type="radio" name="status-service"><span>Онлайн</span></label>
            </div>
        </div>
        <label class="checkbox checkbox--record hider-checkbox" data-hide-input="service">
            <input class="checkbox-hidden-next-form" type="checkbox"><span></span>
            <div class="checbox__name">Мне лень искать в списке, скажу администратору</div>
        </label>
        <div class="select-form" data-hide="service">
            <div class="select">
                <div class="select__main">
                    <div class="select__placeholder">Услуга</div>
                    <div class="select__values"> </div>
                </div>
                <div class="select__list">
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name --flex --aic --jcsb">
                                <div class="select__name">Внутривенное введение лекарственных препаратов - капельница (Антиоксидантная)</div>
                                <div>6 000 ₽</div>
                            </div>
                        </label>
                    </div>
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name --flex --aic --jcsb">
                                <div class="select__name">Дерматологический пилинг Cosmedix Purity ретиноевый</div>
                                <div>7 000 ₽</div>
                            </div>
                        </label>
                    </div>
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name --flex --aic --jcsb">
                                <div class="select__name">Дерматологический пилинг Enerpeel Jessners салициловый-резорциновый</div>
                                <div>7 000 ₽</div>
                            </div>
                        </label>
                    </div>
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name --flex --aic --jcsb">
                                <div class="select__name">Дерматологический пилинг для кожи с гиперпигментацией "SC Pigment Balancing Peel"</div>
                                <div>7 000 ₽</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="service-checkboxs">
            <label class="search__drop-item">
                <div class="search__drop-name">Прием (осмотр, консультация врача-дерматовенеролога главного врача первичный (включает составление плана лечения).</div>
                <div class="search__drop-right">
                    <div class="search__drop-tags"></div>
                    <div class="search__drop-summ">7 000 ₽</div>
                    <div class="search__drop-check">
                        <div class="checkbox">
                            <input type="checkbox"><span></span>
                        </div>
                    </div>
                </div>
            </label>
        </div>
        <label class="checkbox checkbox--record hider-checkbox" data-hide-input="expert">
            <input class="checkbox-hidden-next-form" type="checkbox"><span></span>
            <div class="checbox__name">Я не знаю, кого выбрать</div>
        </label>
        <div class="select-form" data-hide="expert">
            <div class="select">
                <div class="select__main">
                    <div class="select__placeholder">Выберите специалиста</div>
                    <div class="select__values"> </div>
                </div>
                <div class="select__list">
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name">
                                <div class="select__name">Хачатурян Любовь Андреева 1</div>
                            </div>
                        </label>
                    </div>
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name">
                                <div class="select__name">Хачатурян Любовь Андреева 2</div>
                            </div>
                        </label>
                    </div>
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name">
                                <div class="select__name">Хачатурян Любовь Андреева 3</div>
                            </div>
                        </label>
                    </div>
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name">
                                <div class="select__name">Хачатурян Любовь Андреева 4</div>
                            </div>
                        </label>
                    </div>
                    <div class="select__item select__item--checkbox">
                        <label class="checkbox checkbox--record">
                            <input type="checkbox"><span> </span>
                            <div class="checbox__name">
                                <div class="select__name">Хачатурян Любовь Андреева 5</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-editor__patient">
            <div class="text-bold mb-10">Выбраны услуги</div>
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
            <p>7 000 ₽</p>
        </div>
        <button class="btn btn--black form__submit"> Записаться</button>
    </div>
    <div class="popup__panel --succed">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Запись на прием</div>
        <h3 class="h3">Успешно !</h3>
        <p class="text-grey">Мы перезвоним Вам в ближайшее время</p>
    </div>
</div>
<!--suppress JSUnresolvedFunction -->
<script type="text/javascript">
    var servicesList = [
        {
            "value" : 'Прием (осмотр, консультация врача-дерматовенеролога главного врача первичный (включает составление плана лечения)',
            "data"  : {
                "tags" : [
                    {"color": "yellow", "tag": "Л"},
                    {"color": "green", "tag": "Т"}
                ],
                "price" : 7000
            }
        },
        {
            "value" : 'Дерматологический пилинг Cosmedix Purity ретиноевый',
            "data"  : {
                "tags" : [
                    {"color": "yellow", "tag": "Л"},
                ],
                "price" : 7000
            }
        },
        {
            "value" : 'Дерматологический пилинг Enerpeel Jessners салициловый-резорциновый',
            "data"  : {
                "tags" : [
                    {"color": "yellow", "tag": "Л"},
                    {"color": "green", "tag": "Т"}
                ],
                "price" : 7000
            }
        },
        {
            "value" : 'Дерматологический пилинг для кожи с гиперпигментацией "SC Pigment Balancing Peel"',
            "data"  : {
                "tags" : [
                    {"color": "yellow", "tag": "Л"},
                    {"color": "green", "tag": "Т"}
                ],
                "price" : 7000
            }
        }
    ];

    $(function(){
        $('#popup-services-list').autocomplete({
            noCache      : true,
            minChars     : 1,
//            delimiter    : ',',
            lookup       : servicesList,
            beforeRender : function(container, suggestions) {
                var CNT = $(container);
                $(container).addClass('search__drop').html('');
                $(suggestions).each(function(index){
                    var PRICE = new Intl.NumberFormat('ru-RU').format(this.data.price);
                    var TAGS  = $('<div></div>').addClass('search__drop-tags');
                    $(this.data.tags).each(function(){
                        TAGS.append(
                            $('<div></div>').addClass('search__drop-tag --' + this.color).text(this.tag)
                        );
                    });
                    CNT.append(
                        $('<label></label>').addClass('search__drop-item autocomplete-suggestion').attr({"data-index" : index}).append(
                            $('<div></div>').addClass('search__drop-name').text(this.value)
                        ).append(
                            $('<div></div>').addClass('search__drop-right').append(TAGS).append(
                                $('<div></div>').addClass('search__drop-summ').text(PRICE + ' ₽')
                            )
                                /*.append(
                                $('<div></div>').addClass('search__drop-check').append(
                                    $('<div></div>').addClass('checkbox').append(
                                        $('<input type="checkbox">')
                                    ).append(
                                        $('<span></span>')
                                    )
                                )
                            ) */
                        )
                    )
                });
            },
            onSelect : function(suggestion) {
                console.log(suggestion.value);
            }
        });
    });
</script>