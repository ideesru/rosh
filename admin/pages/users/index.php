<?php
    namespace xbweb;

    if (empty($result)) $result = array();
?>
<section>
    <h2><?=Language::translate('users-index')?></h2>
    <table class="data-table">
        <thead>
            <tr>
                <th class="checker id sortable">
                    <input type="hidden" name="table_all_checked" value="0">
                    <span>ID</span>
                </th>
                <th class="sortable"><?=Language::translate('field-login')?></th>
                <th class="sortable"><?=Language::translate('field-email')?></th>
                <th class="sortable"><?=Language::translate('field-phone')?></th>
                <th class="actions"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td class="checker">
                    <input type="hidden" name="table[<?=$row['id']?>][checked]" value="0">
                    <span><?=$row['id']?></span>
                </td>
                <td><?=$row['login']?></td>
                <td><?=$row['email']?></td>
                <td><?=$row['phone']?></td>
                <td class="actions">
                    <a href="/admin/users/edit/<?=$row['id']?>" class="icon action"></a>
                    <a href="/admin/users/delete/<?=$row['id']?>" class="icon action modal"></a>
                    <a href="/admin/users/remove/<?=$row['id']?>" class="icon action modal"></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>