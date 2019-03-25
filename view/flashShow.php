<?php
if (isset($_SESSION['success'])) { ?>
    <div id="success" class="modal" style="display: block;">
        <?php $show->viewflashShow(); ?>
    </div>
    <script>
        setTimeout(function () {
            document.querySelector('#success').remove();
        }, 3000);
    </script>
<?php } ?>
<?php if (isset($_SESSION['error'])) { ?>
    <div id="error" class="modal" style="display: block;">
        <?php $show->viewflashShow(); ?>
    </div>
    <script>
        setTimeout(function () {
            document.querySelector('#error').remove();
        }, 3000);
    </script>
<?php } ?>