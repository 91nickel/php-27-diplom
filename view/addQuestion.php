<div class="modal">
    <span id="closeQuestion">&times;</span>
    <h3>
        Задайте вопрос
    </h3>
    <form action="" method="post">
        <input type="hidden" name="action" value="AddQuestion">
        <div>
            <input name="name" required type="text" placeholder="Введите  имя"/>
        </div>
        <div>
            <input name="email" required type="email" placeholder="Введите  email"/>
        </div>
        <div>
            <select name="theme">
                <?php foreach ($array as $key => $value) {
                    if (count($value['data']) >= 0) { ?>
                        <option value="<?php echo $key; ?>">
                            <?php echo $value['name']; ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div>
            <textarea rows="6" name="question" required placeholder="Введите  вопрос"></textarea>
        </div>
        <div>
            <button class="button" type="submit">
                Отправить
            </button>
        </div>
    </form>
</div>