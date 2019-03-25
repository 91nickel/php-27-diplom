<div class="cd-faq-items" id="">
    <ul class="cd-faq-group">
        <?php foreach ($users as $item) { ?>
            <?php if ($item['login'] !== 'admin') { ?>

                <li class="content-visible">
                    <a class="cd-faq-trigger" href="#0">
                        <?= 'Редактировать администратора ' . $item['login']; ?>
                    </a>
                    <div class="cd-faq-content" style="display: flex; justify-content: space-between">
                        <div>
                            <form method="post" action="" style="display: flex;">
                                <input type="hidden" name="action" value="UpdateAdmin">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <div>
                                    <button class="button">
                                        Сменить
                                    </button>
                                </div>
                                <div style="padding:4px 0px 0px 4px;">
                                    <input type="text" name="password" required placeholder="пароль администратора"/>
                                </div>
                            </form>

                        </div>
                        <div>
                            <form method="post" action="">
                                <input type="hidden" name="action" value="DeleteAdmin">
                                <div>
                                    <button class="button" name="id" value="<?php echo $item['id']; ?>">
                                        Удалить
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
