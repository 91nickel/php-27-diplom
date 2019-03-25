<div class="cd-faq-items" id="">
    <ul class="cd-faq-group">
        <?php
        foreach ($quest as $item) {
            //var_dump($quest);
            ?>
            <li>
                <a class="cd-faq-trigger" href="#0">
                    <?php echo $item['name']; ?>
                </a>
                <div class="cd-faq-content">
                    <div style="display: flex; justify-content: space-between;">
                        <?php echo '<div> Email: ' . $item['email'] . ' </div>' ?>
                        <?php echo '<div> Тема: ' . $item['themeName'] . ' </div>' ?>
                        <?php echo '<div> Вопрос: ' . $item['question'] . ' </div>' ?>
                    </div>
                    <br>
                    <br>
                    <form method="post" action="" style="float:right;">
                        <input type="hidden" name="action" value="DeleteQuestion">
                        <div>
                            <button class="button button2" name="id" value="<?php echo $item['id']; ?>">
                                Удалить
                            </button>
                        </div>
                    </form>
                    <button style="float:right; margin:0px 10px;" class="button button2"
                            value="<?php echo $item['id']; ?>"
                            onclick="answer(this.value,'<?php echo $item['question']; ?>')">
                        Ответить и не публиковать
                    </button>
                    <button style="float:right; margin:0px 10px;" class="button button2"
                            value="<?php echo $item['id']; ?>"
                            onclick="answerPublish(this.value,'<?php echo $item['question']; ?>')">
                        Ответить и опубликовать
                    </button>

                    <button style="float:right; margin:0px 10px;" class="button button2"
                            value="<?php echo $item['id']; ?>"
                            onclick="editAnswer(this.value,' <?php echo $item['name']; ?>', '<?php echo $item['email']; ?>','<?php echo $item['question']; ?>')">
                        Редактировать
                    </button>

                </div> <!-- cd-faq-content -->
            </li>
        <?php } ?>
    </ul>
</div>
