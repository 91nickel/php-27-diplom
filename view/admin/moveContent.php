<div class="modal3">
    <span id="closeQuestion3">&times;</span>
    <h3>
        Переместить
    </h3>
    <form action="" method="post">
        <input type="hidden" name="action" value="MoveContent">
        <input type="hidden" name="id_theme" value="">
        <div>
            <select name="theme">
                <?php foreach ($array as $key => $value) {
                    if (count($value['data']) > 0) { ?>
                        <option value="<?php echo $key; ?>">
                            <?php echo $value['name']; ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>

        </div>
        <div>
            <button class="button" type="submit">
                Добавить
            </button>
        </div>
    </form>
</div>