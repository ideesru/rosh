<?php
    namespace xbweb;

    if (empty($form))   $form   = array();
    if (empty($values)) $values = array();
    if (empty($errors)) $errors = array();
?>
<section class="form">
    <?=View::form('/leads/statuses/create', $form, $values, $errors)?>
</section>
