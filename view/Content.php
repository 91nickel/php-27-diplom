<div class="cd-faq-items">
    <?php //var_dump($array); ?>
    <?php foreach ($array as $key => $value) { ?>
        <?php if (is_array($value['data']) && count($value['data']) > 0) { ?>
            <ul id="theme<?php echo $key; ?>" class="cd-faq-group">
                <li class="cd-faq-title">
                    <h2>
                        <?php echo $value['name']; ?>
                    </h2>
                </li>
                <?php foreach ($value['data'] as $key2 => $value2) { ?>
                    <li>
                        <a class="cd-faq-trigger" href="#0">
                            <?php echo $value2['question']; ?>
                        </a>
                        <div class="cd-faq-content">
                            <p>
                                <?php echo $value2['answer']; ?>
                            </p>
                        </div> <!-- cd-faq-content -->
                    </li>
                <?php } ?>

            </ul> <!-- cd-faq-group -->
        <?php } ?>
    <?php } ?>
</div> <!-- cd-faq-items -->
<a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->
</div>
