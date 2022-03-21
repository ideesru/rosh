<div class="popup --download-data">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Выгрузить данные</div>
        <form class="popup__form">
            <div class="select-form">
                <div class="select">
                    <div class="select__main">Все услуги</div>
                    <div class="select__list">
                        <div class="select__item">Консультация врача</div>
                        <div class="select__item">Консультация врача</div>
                        <div class="select__item">Консультация врача</div>
                        <div class="select__item">Консультация врача</div>
                    </div>
                </div>
            </div>
            <div class="select-form">
                <div class="select">
                    <div class="select__main">Все специалисты</div>
                    <div class="select__list">
                        <div class="select__item">Специалист</div>
                        <div class="select__item">Специалист</div>
                        <div class="select__item">Специалист</div>
                    </div>
                </div>
            </div>
            <div class="select-form">
                <div class="select">
                    <div class="select__main">Все администраторы</div>
                    <div class="select__list">
                        <div class="select__item">Администратор</div>
                        <div class="select__item">Администратор</div>
                        <div class="select__item">Администратор</div>
                    </div>
                </div>
            </div>
            <div class="calendar input">
                <input class="input__control daterangepickr" type="text" placeholder="За весь период">
                <div class="input__placeholder">За весь период</div>
            </div>
            <div class="select-form">
                <label class="checkbox mainfilter__checkbox mb-10">
                    <input type="checkbox"><span></span>
                    <div class="checbox__name text-grey">Выгрузить только список номеров</div>
                </label>
                <div class="calendar input">
                    <input class="input__control" type="tel" placeholder="Номер телефона" data-inputmask="'mask': '+7 (999) 999-99-99'">
                    <div class="input__placeholder">Номер телефона</div>
                </div>
            </div>
            <div class="select-form mb-30">
                <label class="checkbox mainfilter__checkbox mb-10">
                    <input type="checkbox"><span></span>
                    <div class="checbox__name text-grey">Введите только список е-мейлов</div>
                </label>
                <div class="calendar input">
                    <input class="input__control" type="email" placeholder="Введите е-мейл">
                    <div class="input__placeholder">Введите е-мейл</div>
                </div>
            </div>
            <button class="btn btn--black">Скачать</button>
        </form>
    </div>
</div>