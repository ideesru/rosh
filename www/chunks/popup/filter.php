<div class="popup --filter">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Расшифровка анализов</div>
        <form class="popup__form">
            <div class="radios --flex">
                <label class="text-radio">
                    <input type="radio" name="status2"><span>Заявка</span>
                </label>
                <label class="text-radio">
                    <input type="radio" name="status2"><span>Событие</span>
                </label>
            </div>
            <div class="input">
                <input class="input__control" type="text" placeholder="ФИО">
                <div class="input__placeholder">ФИО</div>
            </div>
            <div class="select-form">
                <div class="select">
                    <div class="select__main">Все услуги</div>
                    <div class="select__list">
                        <div class="select__item">Все услуги</div>
                        <div class="select__item">Все услуги</div>
                        <div class="select__item">Все услуги</div>
                        <div class="select__item">Все услуги</div>
                    </div>
                </div>
            </div>
            <div class="input">
                <input class="input__control" type="tel" placeholder="Телефон" data-inputmask="'mask': '+7 (999) 999-99-99'">
                <div class="input__placeholder">Телефон</div>
            </div>
            <div class="select-form">
                <div class="select">
                    <div class="select__main">Все услуги</div>
                    <div class="select__list">
                        <div class="select__item">Все специалисты</div>
                        <div class="select__item">Все специалисты</div>
                        <div class="select__item">Все специалисты</div>
                        <div class="select__item">Все специалисты</div>
                    </div>
                </div>
            </div>
            <div class="select-form">
                <div class="select">
                    <div class="select__main">Статус</div>
                    <div class="select__list">
                        <div class="select__item">Статус</div>
                        <div class="select__item">Статус</div>
                        <div class="select__item">Статус</div>
                        <div class="select__item">Статус</div>
                    </div>
                </div>
            </div>
            <div class="popup__block">
                <p class="text-bold mb-10">Тип события</p>
            </div>
            <div class="radios --flex">
                <label class="text-radio">
                    <input type="radio" name="status22"><span>В клинике</span>
                </label>
                <label class="text-radio">
                    <input type="radio" name="status22"><span>Онлайн</span>
                </label>
            </div>
            <div class="calendar input mb-30">
                <input class="input__control daterangepickr" type="text" placeholder="За весь период">
                <div class="input__placeholder">За весь период</div>
            </div>
            <button class="btn btn--black">Найти</button>
        </form>
    </div>
</div>