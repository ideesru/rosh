<div class="popup --reg">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Регистрация Личного кабинета</div>
        <div class="form-title__description">Для регистрации личного кабинета введите свой email адрес, пароль будет выслан на указанную почту</div>
        <form class="popup__form">
            <div class="input input--grey">
                <input class="input__control" type="email" placeholder="Ваш е-мейл">
                <div class="input__placeholder">Ваш е-мейл</div>
            </div>
            <div class="form__alert text-small">Адрес уже используется, хотите&nbsp;<a class="link link--medium" href="">восстановить пароль</a>?
                <svg class="svgsprite _alert">
                    <use xlink:href="/www/img/sprites/svgsprites.svg#alert"></use>
                </svg>
            </div>
            <div class="form__description">Нажимая на кнопку "Зарегистрироваться", Вы даете согласие на обработку своих персональных данных на основании <a href="policy.html">Политики конфиденциальности</a></div>
            <div class="form-bottom --flex">
                <button class="btn btn--black form__submit --switchpopup" type="submit">Зарегистрироваться</button>
                <button class="btn btn--white form__submit --switchpopup" type="button" data-popup="--enter-number">Войти</button>
            </div>
        </form>
    </div>
    <div class="popup__panel --succed">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Регистрация Личного кабинета</div>
        <h3 class="h3">Успешно !</h3>
        <p class="text-grey">Ваш Личный кабинет создан, сейчас вы будете в него автоматически перенаправлены</p>
    </div>
</div>
