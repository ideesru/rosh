<div class="popup --fast-make">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Быстрая запись</div>
        <form class="popup__form">
            <div class="input input--grey">
                <input class="input__control" type="text" placeholder="ФИО">
                <div class="input__placeholder">ФИО</div>
            </div>
            <div class="input input--grey">
                <input class="input__control" type="tel" placeholder="Номер телефона" data-inputmask="'mask': '+7 (999) 999-99-99'">
                <div class="input__placeholder">Номер телефона</div>
            </div>
            <label class="checkbox mainfilter__checkbox hider-checkbox" data-hide-input="expert">
                <input class="checkbox-hidden-next-form" type="checkbox"><span></span>
                <div class="checbox__name text-grey">Я не знаю, кого выбрать</div>
            </label>
            <div class="select-form" data-hide="expert">
                <div class="select">
                    <div class="select__main">Хачатурян Любовь Андреева</div>
                    <div class="select__list">
                        <div class="select__item active">Хачатурян Любовь Андреева</div>
                        <div class="select__item">Хачатурян Любовь Андреева</div>
                        <div class="select__item">Хачатурян Любовь Андреева</div>
                        <div class="select__item">Хачатурян Любовь Андреева</div>
                    </div>
                </div>
            </div>
            <p class="text-grey text-grey mb-10">Необязательно</p>
            <div class="input input--grey">
                <textarea class="input__control" placeholder="Причина обращения"></textarea>
                <div class="input__placeholder">Причина обращения</div>
            </div>
            <div class="form__description">Нажимая на кнопку "Перезвонить мне", Вы даете согласие на обработку своих персональных данных на основании <a href="policy.html">Политики конфиденциальности</a></div>
            <button class="btn btn--black form__submit">Перезвонить мне</button>
            <div class="form-bottom">После отправки заявки для Вас будет создан Личный кабинет, в&nbsp;который можно попасть через кнопку &laquo;Войти&raquo; в&nbsp;верхнем меню сайта</div>
        </form>
    </div>
    <div class="popup__panel --succed">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Быстрая запись</div>
        <h3 class="h3">Успешно !</h3>
        <p class="text-grey">Мы перезвоним Вам в ближайшее время</p>
    </div>
</div>
