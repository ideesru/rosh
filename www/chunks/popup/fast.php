<div class="popup --fast">
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
