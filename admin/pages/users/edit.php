<?php
    namespace xbweb;

    if (empty($form))   $form   = array();
    if (empty($values)) $values = array();
    if (empty($errors)) $errors = array();
?>
<section class="form">
    <?=View::form('/users/edit', $form, $values, $errors)?>
</section>