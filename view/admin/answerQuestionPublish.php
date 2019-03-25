<div class="modal6">
    <span id="closeQuestion6">&times;</span>
    <h3>
        Ответить на вопрос
    </h3>
    <form action="" method="post">
        <input type="hidden" name="action" value="AnswerQuestionPublish">
        <input type="hidden" name="question">
        <input type="hidden" name="id">
        <div>
            <input name="name" required placeholder="Имя автора"/>
        </div>
        <div>
            <input name="email" required placeholder="Email автора"/>
        </div>
        <div>
            <select name="id_theme">
                <?php foreach ($array as $key => $value) {
                    if (count($value['data']) > 0 || !count($value['data']) <> 0) { ?>
                        <option value="<?php echo $key; ?>">
                            <?php echo $value['name']; ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div>
            <textarea rows="6" name="answer" required placeholder="Введите  ответ"></textarea>
        </div>
        <div>
            <button class="button" type="submit">
                Опубликовать
            </button>
        </div>
    </form>
</div>