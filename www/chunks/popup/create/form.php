<div class="popup --create">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Создать карточку пациента</div>
        <form class="popup__form">
            <div class="input">
                <input class="input__control" type="text" placeholder="ФИО">
                <div class="input__placeholder">ФИО</div>
            </div>
            <div class="input">
                <input class="input__control datebirthdaypickr" type="text" placeholder="Дата рождения">
                <div class="input__placeholder">Дата рождения</div>
            </div>
            <div class="input mb-30">
                <input class="input__control" type="tel" placeholder="Номер телефона" data-inputmask="'mask': '+7 (999) 999-99-99'">
                <div class="input__placeholder">Номер телефона</div>
            </div>
            <button class="btn btn--black form__submit --switchpopup" data-popup="--code">Создать</button>
            <div class="form-bottom">После отправки заявки для пациента будет создан Личный кабинет, в&nbsp;который можно попасть через кнопку &laquo;Войти&raquo; в&nbsp;верхнем меню сайта</div>
        </form>
    </div>
</div>