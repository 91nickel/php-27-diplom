<div class="modal2">
    <span id="closeQuestion2">&times;</span>
    <h3>
        Редактировать вопрос
    </h3>
    <form action="" method="post">
        <input type="hidden" name="action" value="EditContent">
        <input type="hidden" name="id_theme" value="">
        <div>
            <input name="name" required placeholder="Имя автора"/>
        </div>
        <div>
            <textarea rows="6" name="question" required placeholder="Введите  вопрос"></textarea>
        </div>
        <div>
            <textarea rows="6" name="answer" required placeholder="Введите  ответ"></textarea>
        </div>
        <div>
            <button class="button" type="submit">
                Изменить
            </button>
        </div>
    </form>
</div>