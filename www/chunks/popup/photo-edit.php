<div class="popup --photo-edit">
    <div class="popup__overlay"></div>
    <div class="popup__panel">
        <button class="popup__close">
            <svg class="svgsprite _close">
                <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
            </svg>
        </button>
        <div class="popup__name text-bold">Редактор фото</div>
        <form class="popup__form">
            <div class="edit-photo">
                <div class="--flex --aicn">
                    <div class="edit-photo__pic"><img src=".//www/img/popup/photo.png" alt=""></div>
                    <div class="edit-photo__info">
                        <div class="edit-photo__name">Мартынова Александра Михайловна</div>
                        <div class="edit-photo__date">22.10.2021</div>
                    </div>
                </div>
                <div class="edit-photo__delete">
                    <svg class="svgsprite _delete">
                        <use xlink:href="/www/img/sprites/svgsprites.svg#delete"></use>
                    </svg>
                </div>
            </div>
            <div class="search-form input">
                <input class="input__control" type="text" placeholder="Выбрать пациента">
                <div class="input__placeholder">Выбрать пациента</div>
            </div>
            <div class="input calendar mb-20">
                <input class="input__control datepickr" type="text" placeholder="Выбрать дату посещения">
                <div class="input__placeholder">Выбрать дату посещения</div>
            </div>
            <div class="popup-title__checkbox">
                <p class="mb-10">Выбрать статус</p>
                <label class="checkbox mb-10">
                    <input type="checkbox"><span></span>
                    <div class="checbox__name">Продолжительное лечение</div>
                </label>
            </div>
            <div class="radios --flex">
                <label class="text-radio">
                    <input type="radio" name="status233"><span>В клинике</span>
                </label>
                <label class="text-radio">
                    <input type="radio" name="status233"><span>Онлайн</span>
                </label>
            </div>
            <label class="file-photo">
                <input type="file">
                <div class="file-photo__ico">
                    <svg class="svgsprite _file">
                        <use xlink:href="/www/img/sprites/svgsprites.svg#file"></use>
                    </svg>
                </div>
                <div class="file-photo__text text-grey">Для загрузки фото заполните все поля <br>Фото не должно превышать 10 мб</div>
            </label>
            <button class="btn btn--white">Сохранить</button>
        </form>
    </div>
</div>