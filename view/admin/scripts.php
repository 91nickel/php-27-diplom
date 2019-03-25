<?php
if (isset($_SESSION['success'])) { ?>
    <div id="success" class="modal" style="display: block;">
        <?php $indexController->flash_show(); ?>
    </div>
    <script>
        setTimeout(function () {
            document.querySelector('#success').remove();
        }, 6000);
    </script>
<?php } ?>
<?php if (isset($_SESSION['error'])) { ?>
    <div id="error" class="modal" style="display: block;">
        <?php $indexController->flash_show(); ?>
    </div>
    <script>
        setTimeout(function () {
            document.querySelector('#error').remove();
        }, 6000);
    </script>
<?php } ?>

<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mobile.custom.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
<script type="text/javascript" src="js/script.js"></script>
<script>
$('.cd-faq-categories a').on('click', function () {
    var id = $(this).attr('href');

    $('.cd-faq-categories a').removeClass('selected');
    $(this).addClass('selected');
    $('.cd-faq-items').css('display', 'none');
    $(id).css('display', 'block');
});
    $(document).ready(function () {

        $('input[name="cache"]').val($('#scrf input[name="cache"]').val());
        $('input[name="page"]').val($('#scrf input[name="page"]').val());
    });

    function add(id) {
        $('input[name="id_theme"]').val(id);
        $('.modal').css('display', 'block');
        $('.wrapper').css('filter', 'blur(0px)');
    }

    function edit(id, question, answer, name) {
        $('input[name="id_theme"]').val(id);
        $('input[name="name"]').val(name);
        $('textarea[name="question"]').val(question);
        $('textarea[name="answer"]').val(answer);
        $('.modal2').css('display', 'block');
        $('.wrapper').css('filter', 'blur(0px)');
    }

    function move(id) {
        $('input[name="id_theme"]').val(id);
        $('.modal3').css('display', 'block');
        $('.wrapper').css('filter', 'blur(0px)');
    }

    function answer(id, question) {
        $('.modal4').css('display', 'block');
        $('input[name="question"]').val(question);
        $('input[name="id"]').val(id);
        $('.wrapper').css('filter', 'blur(0px)');
    }

    function answerPublish(id, question) {
        $('.modal6').css('display', 'block');
        $('input[name="question"]').val(question);
        $('input[name="id"]').val(id);
        $('.wrapper').css('filter', 'blur(0px)');
    }

    function editAnswer(id, name, email, question) {
        $('.modal5').css('display', 'block');
        $('textarea[name="question"]').val(question);
        $('input[name="email"]').val(email);
        $('input[name="name"]').val(name);
        $('input[name="id"]').val(id);
        $('.wrapper').css('filter', 'blur(0px)');
    }

    $('#closeQuestion4').on('click', function () {

        $('.modal4').css('display', 'none');

        $('.wrapper').css('filter', 'blur(0px)');
    });

    $('#closeQuestion5').on('click', function () {

        $('.modal5').css('display', 'none');
        $('.wrapper').css('filter', 'blur(0px)');
    });
    $('#closeQuestion6').on('click', function () {

        $('.modal6').css('display', 'none');
        $('.wrapper').css('filter', 'blur(0px)');
    });

</script>
</body>
</html>