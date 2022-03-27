<?php
    namespace xbweb;

    use xbweb\modules\Rosh\HTML;
?>
<div class="mainfilter" id="mainfilter">
    <div class="mainfilter__close --closefilter">
        <svg class="svgsprite _close">
            <use xlink:href="/www/img/sprites/svgsprites.svg#close"></use>
        </svg>
    </div>
    <div class="mainfilter__wrap row">
        <div class="col-lg-9 col-md-8">
            <div class="mainfilter__left">
                <div class="mainfilter__tab-list">
                    <div class="mainfilter__tab-item data-tab-link active" data-tab="services" data-tabs="mainfilter">Услуги</div>
                    <div class="mainfilter__tab-item data-tab-link" data-tab="problems" data-tabs="mainfilter">Проблемы</div>
                    <div class="mainfilter__tab-item data-tab-link" data-tab="sympthoms" data-tabs="mainfilter">Симптомы</div>
                </div>
                <div class="mainfilter__tabs data-tab-wrapper" data-tabs="mainfilter">
                    <div class="mainfilter__tab data-tab-item active" data-tab="services">
                        <div class="accardeon">
                            <div class="accardeon__main accardeon__click">
                                <div class="accardeon__name --yellow">Лицо</div>
                            </div>
                            <div class="accardeon__list">
                                <?=HTML::checkboxes(array(
                                    'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                ))?>
                            </div>
                        </div>
                        <div class="accardeon">
                            <div class="accardeon__main accardeon__click">
                                <div class="accardeon__name --green">Тело</div>
                            </div>
                            <div class="accardeon__list">
                                <?=HTML::checkboxes(array(
                                    'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                ))?>
                            </div>
                        </div>
                        <div class="accardeon">
                            <div class="accardeon__main accardeon__click">
                                <div class="accardeon__name --red">Волосы</div>
                            </div>
                            <div class="accardeon__list">
                                <?=HTML::checkboxes(array(
                                    'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                ))?>
                            </div>
                        </div>
                        <div class="accardeon">
                            <div class="accardeon__main accardeon__click">
                                <div class="accardeon__name --blue">Гинекология</div>
                            </div>
                            <div class="accardeon__list">
                                <?=HTML::checkboxes(array(
                                    'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                ))?>
                            </div>
                        </div>
                        <div class="accardeon">
                            <div class="accardeon__main accardeon__click">
                                <div class="accardeon__name --purple">Лаборатория</div>
                            </div>
                            <div class="accardeon__list">
                                <?=HTML::checkboxes(array(
                                    'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                ))?>
                            </div>
                        </div>
                    </div>
                    <div class="mainfilter__tab data-tab-item" data-tab="problems">
                        <div class="accardeon-group">
                            <div class="accrdeon__title">Дерматовенерология</div>
                            <div class="accardeon">
                                <div class="accardeon__main accardeon__click">
                                    <div class="accardeon__name --yellow">Лицо</div>
                                </div>
                                <div class="accardeon__list">
                                    <?=HTML::checkboxes(array(
                                        'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    ))?>
                                </div>
                            </div>
                            <div class="accardeon">
                                <div class="accardeon__main accardeon__click">
                                    <div class="accardeon__name --green">Тело</div>
                                </div>
                                <div class="accardeon__list">
                                    <?=HTML::checkboxes(array(
                                        'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    ))?>
                                </div>
                            </div>
                            <div class="accardeon">
                                <div class="accardeon__main accardeon__click">
                                    <div class="accardeon__name --red">Волосы</div>
                                </div>
                                <div class="accardeon__list">
                                    <?=HTML::checkboxes(array(
                                        'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    ))?>
                                </div>
                            </div>
                        </div>
                        <div class="accardeon-group">
                            <div class="accrdeon__title">Эстетика</div>
                            <div class="accardeon">
                                <div class="accardeon__main accardeon__click">
                                    <div class="accardeon__name --yellow">Лицо</div>
                                </div>
                                <div class="accardeon__list">
                                    <?=HTML::checkboxes(array(
                                        'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    ))?>
                                </div>
                            </div>
                            <div class="accardeon">
                                <div class="accardeon__main accardeon__click">
                                    <div class="accardeon__name --green">Тело</div>
                                </div>
                                <div class="accardeon__list">
                                    <?=HTML::checkboxes(array(
                                        'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    ))?>
                                </div>
                            </div>
                            <div class="accardeon">
                                <div class="accardeon__main accardeon__click">
                                    <div class="accardeon__name --red">Волосы</div>
                                </div>
                                <div class="accardeon__list">
                                    <?=HTML::checkboxes(array(
                                        'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                        'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                    ))?>
                                </div>
                            </div>
                        </div>
                        <div class="accardeon-group no-border">
                            <div class="accrdeon__title">Гинекология</div>
                            <?=HTML::checkboxes(array(
                                'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                                'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service-l'),
                            ))?>
                        </div>
                    </div>
                    <div class="mainfilter__tab data-tab-item" data-tab="sympthoms">
                        <div class="accrdeon__title">Симптомы</div>
                        <?=HTML::checkboxes(array(
                            'gyne[1]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[2]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[3]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[4]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[5]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[6]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[7]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[8]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[9]'  => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[10]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[11]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                            'gyne[12]' => array('title' => 'Консультация врача', 'url' => '/landing', 'popup' => '--service'),
                        ))?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 mainfilter__right">
            <div class="mainfilter__choice">
                <h5 class="h5">Ваш выбор</h5>
                <div class="mainfilter__tags">
                    <?php
                        $tpl = <<<html
<div class="mainfilter-tag">
    <div class="mainfilter-tag__name">
        <div class="mainfilter-tag__delete">
            <svg class="svgsprite _delete">
                <use xlink:href="/www/img/sprites/svgsprites.svg#delete"></use>
            </svg>
        </div> <a class="mainfilter-tag__link" href="/landing">[+title+]</a>
    </div>
    <div class="mainfilter-tag__group --[+color+]">[+letter+]</div>
</div>
html;
                        echo View::rows(array(
                            array('title' => 'Аллергия на коже', 'color' => 'yellow', 'letter' => 'Л'),
                            array('title' => 'Аллергия на коже', 'color' => 'green', 'letter' => 'Л'),
                            array('title' => 'Аллергия на коже', 'color' => 'red', 'letter' => 'Л'),
                            array('title' => 'Аллергия на коже', 'color' => 'blue', 'letter' => 'Л'),
                            array('title' => 'Аллергия на коже', 'color' => 'purple', 'letter' => 'Л')
                        ), $tpl);
                    ?>
                </div>
            </div>
            <div class="mainfilter__bottom">
                <form class="mainfilter__form">
                    <div class="mainfilter__form-top">
                        <h5 class="h5">Ваш выбор</h5>
                        <div class="input input--grey">
                            <input class="input__control" type="text" placeholder="ФИО">
                            <div class="input__placeholder">ФИО</div>
                        </div>
                        <div class="input input--grey">
                            <input class="input__control" type="tel" placeholder="Номер телефона" data-inputmask="'mask': '+7 (999) 999-99-99'">
                            <div class="input__placeholder">Номер телефона</div>
                        </div>
                        <div class="input input--grey">
                            <input class="input__control" type="email" placeholder="Ваш е-мейл">
                            <div class="input__placeholder">Ваш е-мейл</div>
                        </div>
                        <div class="form__description">Нажимая на кнопку "Записаться", Вы даете согласие на обработку своих персональных данных  на основании <a href="/policy">Политики конфиденциальности</a></div>
                        <button class="form__submit btn btn--black">Записаться</button>
                    </div>
                    <div class="mainfilter__form-bottom">После отправки заявки для Вас будет создан Личный кабинет, в который можно попасть через кнопку "Войти" в верхнем меню сайта</div>
                </form>
                <div class="mainfilter__succed"></div>
            </div>
        </div>
    </div>
</div>
