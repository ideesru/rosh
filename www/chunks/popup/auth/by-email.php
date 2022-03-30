<div class="popup --email-enter">
    <div class="popup__overlay"></div>
    <form class="popup__panel" action="/login">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Войдите или зарегистрируйтесь</div>
        <form class="popup__form">
            <div class="input input--grey">
                <input class="input__control" type="email" placeholder="Ваш е-мейл">
                <div class="input__placeholder">Ваш е-мейл</div>
            </div>
            <div class="text-right mb-10"><a class="form__link --switchpopup" data-popup="--email-recover">Забыли пароль?</a></div>
            <div class="input input--grey">
                <input class="input__control" type="password" placeholder="Пароль">
                <div class="input__placeholder">Пароль</div>
            </div><a class="form__link --switchpopup" type="button" data-popup="--enter-number"> Войти по номеру телефона</a>
            <div class="form-bottom --flex">
                <button class="btn btn--black form__submit" type="submit">Войти</button>
                <button class="btn btn--white form__submit --switchpopup" type="button" data-popup="--reg">Зарегистрироваться</button>
            </div>
        </form>
    </form>
</div>
