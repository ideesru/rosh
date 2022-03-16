<form method="post" action="/<?=\xbweb\Request::get('path')?>">
    <input type="hidden" name="id" value="<?=\xbweb\Request::get('id')?>">
    <h2><?=(empty($title) ? 'Confirm?' : $title)?></h2>
    <p class="modal-text">
        <?=(empty($content) ? 'Confirm?' : $content)?>
    </p>
    <div class="buttons">
        <button class="delete" type="submit" name="action" value="<?=\xbweb\Request::get('action')?>">Delete</button>
        <button class="close">Cancel</button>
    </div>
</form>