<div class="modal">
    <span id="closeQuestion">&times;</span>
    <h3>
        Добавить вопрос
    </h3>
    <form action="" method="post">
        <input type="hidden" name="action" value="AddContent">
        <input type="hidden" name="id_theme" value="">
        <div>
            <textarea rows="6" name="question" required placeholder="Введите  вопрос"></textarea>
        </div>
        <div>
            <textarea rows="6" name="answer" required placeholder="Введите  ответ"></textarea>
        </div>
        <div>
            <button class="button" type="submit">
                Добавить
            </button>
        </div>
    </form>
</div>