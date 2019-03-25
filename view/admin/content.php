<?
//var_dump($counter);

?>

<div class="cd-faq-items" id="">

    <?php

    foreach ($array as $key => $value) {
        ?>

        <br>
        <br>

        <div style="display: flex; width:50%; margin:20px auto;">
            <p style="margin-right:20px;">Всего: <?= $counter[$key]['all']; ?></p>
            <p style="margin-right:20px;"> Опубликовано: <?= $counter[$key]['published']; ?></p>
            <p> Не опубликованно: <?= $counter[$key]['noPublished']; ?></p>
        </div>

        <ul id="theme<?php echo $key; ?>" class="cd-faq-group">
            <li class="cd-faq-title" style="display: flex; justify-content: space-between">
                <h2 style="font-size: 18px; padding-top:10px;">
                    <?php echo $value['name']; ?>
                </h2>
                <button class="button" onclick="add(this.value);" value="<?php echo $key; ?>">
                    Добавить вопрос
                </button>

                <form method="post" action="">
                    <input type="hidden" name="action" value="DeleteTheme">
                    <div>
                        <button class="button" name="id" value="<?php echo $key; ?>">
                            Удалить
                        </button>
                    </div>
                </form>
            </li>
            <?php if (is_array($value['data']) && count($value['data']) > 0) { ?>
                <?php foreach ($value['data'] as $key2 => $value2) {
                    if ((int)$value2['status'] === 1) {
                    }
                    ?>
                    <li class="<?php echo (int)$value2['status'] === 0 ? 'content-visible' : ''; ?>">
                        <a class="cd-faq-trigger" href="#0"
                           style="justify-content: space-between; display: flex;">
                               <span>
                                   <?php echo $value2['question']; ?>
                               </span>
                            <span style="font-size: 12px">
                                    Статус: <?php echo (int)$value2['status'] === 0 ? 'Неопубликован' : 'Опубликован'; ?>
                                <br>
                                    <span>
                                    Дата добавления: <?php echo date("m-d-Y", $value2['date']) ?>
                                </span>
                                </span>

                        </a>
                        <div class="cd-faq-content" <?php echo (int)$value2['status'] === 0 ? 'style="display:block;"' : ''; ?>>
                            <p>
                                <?php echo $value2['answer']; ?>
                            </p>
                            <form method="post" action="" style="float:right;">
                                <input type="hidden" name="action" value="DeleteContent">
                                <div>
                                    <button class="button button2" name="id"
                                            value="<?php echo $value2['id']; ?>">
                                        Удалить
                                    </button>
                                </div>
                            </form>
                            <form method="post" action=""
                                  style="float:right; margin:0px 20px;">
                                <input type="hidden" name="action" value="ChangeStatusContent">
                                <input type="hidden" name="id" value="<?php echo $value2['id']; ?>">
                                <div>
                                    <?php if ((int)$value2['status'] === 0) { ?>
                                        <button class="button button2" name="status" value="1">
                                            Опубликовать
                                        </button>
                                    <?php } else { ?>
                                        <button class="button button2" name="status" value="0">
                                            Снять с публикации
                                        </button>
                                    <?php } ?>
                                </div>
                            </form>
                            <button class="button button2" style="float:right; margin:0px 20px;"
                                    onclick="edit(this.value,'<?php echo $value2['question']; ?>','<?php echo $value2['answer']; ?>', '<?php echo trim($value2['name']) === '' ? $_SESSION['login'] : $value2['name']; ?>');"
                                    value="<?php echo $value2['id']; ?>">
                                Отредактировать
                            </button>
                            <button class="button button2" style="float:right; margin:0px 20px;"
                                    onclick="move(this.value);" value="<?php echo $value2['id']; ?>">
                                Переместить
                            </button>
                        </div> <!-- cd-faq-content -->
                    </li>

                <?php } ?>
            <?php } ?>
        </ul> <!-- cd-faq-group -->
        <br>
        <br>
        <br>
    <?php } ?>
</div>
