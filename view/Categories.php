<ul class="cd-faq-categories">
    <?php
    $i = 0;
    //var_dump($array);
    foreach ($array as $key => $value) { ?>
        <li>
            <a class="<?php echo $i === 0 ? 'selected' : ''; ?>" href="#theme<?php echo (int)$key; ?>">
                <?php echo $value['name']; ?>
            </a>
        </li>
        <?php $i++;
    } ?>

    <?php
    if (!$controller->isLogin()) {
        echo '<li><a  href="?view=LoginForm" target="_parent">Вход</a></li>';
    }
    if ($controller->isLogin()) {
        echo '<li><a  href="admin.php" target="_parent">Админка</a></li>';
    }
    ?>
</ul> <!-- cd-faq-categories -->
