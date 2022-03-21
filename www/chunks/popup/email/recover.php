<div class="popup --email-recover">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Восстановление пароля</div>
        <div class="form-title__description form-title__description--small">Для восстановления пароля введите email, который Вы указывали при регистрации</div>
        <form class="popup__form">
            <div class="input input--grey">
                <input class="input__control" type="email" placeholder="Ваш е-мейл">
                <div class="input__placeholder">Ваш е-мейл</div>
            </div><a class="form__link --switchpopup" type="button" data-popup="--enter-number"> Войти по номеру телефона</a>
            <div class="form-bottom --flex">
                <button class="btn btn--black form__submit">Восстановить</button>
            </div>
        </form>
    </div>
    <div class="popup__panel --succed">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Восстановление пароля</div>
        <h3 class="h3">Письмо отправлено!</h3>
        <p class="text-grey">На Ваш почтовый ящик выслана ссылка для восстановления пароля. Пожалуйста, проверьте почту</p>
    </div>
</div>
