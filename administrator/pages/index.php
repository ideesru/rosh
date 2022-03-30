<div class="account admin">
    <form class="search">
        <div class="container">
            <div class="crumbs"><a class="crumbs__arrow" href="#">
                    <svg class="svgsprite _crumbs-back">
                        <use xlink:href="assets/img/sprites/svgsprites.svg#crumbs-back"></use>
                    </svg></a><a class="crumbs__link" href="#">Главная</a><a class="crumbs__link" href="#">Кабинет администратора</a>
            </div>
            <div class="title-flex --flex --jcsb">
                <div class="title">
                    <h1 class="h1 mb-10">Кабинет администратора</h1>
                </div><a class="btn btn--black --openpopup" href="#" data-popup="--create">Создать карточку пациента</a>
            </div>
            <div class="search__block --flex --aicn">
                <div class="input">
                    <input class="search__input" type="text" placeholder="Поиск">
                </div>
                <button class="btn btn--white">Найти</button>
            </div>
        </div>
    </form>
    <div class="container data-tab-wrapper" data-tabs="lk-leads">
        <div class="account__tab-items">
            <div class="account__tab-item data-tab-link active" data-tab="leads" data-tabs="lk-leads">Заявки</div>
            <div class="account__tab-item data-tab-link" data-tab="events" data-tabs="lk-leads">События</div>
            <div class="buttons">
                <label class="checkbox">
                    <input type="checkbox"><span> </span>
                </label>
                <button class="flag-date__ico">
                    <svg class="svgsprite _flag">
                        <use xlink:href="assets/img/sprites/svgsprites.svg#flag"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div class="account__tab data-tab-item active" data-tab="leads">
            <div class="account-scroll">
                <div class="account__table">
                    <div class="account__table-head">
                        <div class="admin-events-item">
                            <button class="flag-date__ico">
                                <svg class="svgsprite _flag">
                                    <use xlink:href="assets/img/sprites/svgsprites.svg#flag"></use>
                                </svg>
                            </button><span>Заявка</span>
                        </div>
                        <div class="admin-events-item">Приём</div>
                        <div class="admin-events-item">ФИО</div>
                        <div class="admin-events-item">Телефон</div>
                        <div class="admin-events-item">Специалист</div>
                        <div class="admin-events-item">Тип</div>
                        <div class="admin-events-item">Услуга</div>
                        <div class="admin-events-item">Оплата</div>
                        <div class="admin-events-item">Статус</div>
                        <div class="admin-events-item">Комментарии</div>
                    </div>
                    <div class="account__table-body">
                        {{lk/admin/main/lead
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`yellow`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                        {{lk/admin/main/lead
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`red`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                        {{lk/admin/main/lead
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`purple`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                    </div>
                </div>
            </div>
        </div>
        <div class="account__tab data-tab-item" data-tab="events">
            <div class="account-scroll">
                <div class="account__table">
                    <div class="account__table-head">
                        <div class="admin-events-item">
                            <button class="flag-date__ico">
                                <svg class="svgsprite _flag">
                                    <use xlink:href="assets/img/sprites/svgsprites.svg#flag"></use>
                                </svg>
                            </button><span>Заявка</span>
                        </div>
                        <div class="admin-events-item">Приём</div>
                        <div class="admin-events-item">ФИО</div>
                        <div class="admin-events-item">Телефон</div>
                        <div class="admin-events-item">Специалист</div>
                        <div class="admin-events-item">Тип</div>
                        <div class="admin-events-item">Услуга</div>
                        <div class="admin-events-item">Оплата</div>
                        <div class="admin-events-item">Статус</div>
                        <div class="admin-events-item">Комментарии</div>
                    </div>
                    <div class="account__table-body">
                        {{lk/admin/main/event
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`yellow`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                        {{lk/admin/main/event
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`green`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                        {{lk/admin/main/event
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`blue`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                        {{lk/admin/main/event
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`light-blue`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                        {{lk/admin/main/event
                        &lead_date=`16.10.2021` &lead_time=`08:45` &color=`ocean`
                        &lead_status=`Не дозвонился` &lead_pay=`Ожидает оплаты`
                        &rec_date=`17.10.2021` &rec_time=`10:42` &rec_type=`В клинике`
                        &patient_fio=`Цветкова Дарья Михайловна`
                        &spec_fio=`Хачатурян Любовь Андреева`
                        &patient_phone=`+7 (939) 333-33-33`
                        &services=`Уходы и маски<br>Фотолечение BBL`
                        &comments=`Прием (осмотр, консультация) врача-дерматовенеролога КМН`
                        &fio=`Меркушева Эля Евгеньевна` &phone=`+7 (927) 124-99-68` &birthday=`08.10.1999`
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>