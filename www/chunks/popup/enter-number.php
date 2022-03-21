<div class="popup --enter-number">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Войдите или зарегистрируйтесь</div>
        <form class="popup__form">
            <div class="input input--grey">
                <input class="input__control" type="tel" placeholder="Номер телефона" data-inputmask="'mask': '+7 (999) 999-99-99'">
                <div class="input__placeholder">Номер телефона</div>
            </div><a class="form__link --switchpopup" href="#" data-popup="--email-enter"> Войти по почте</a>
        </form>
        <div class="form-bottom">
            <button class="btn btn--black form__submit --switchpopup" data-popup="--code">Получить код</button>
        </div>
    </div>
</div>
