
$('#question').on('click', function(){
   $('.modal').css('display', 'block');
    $('.wrapper').css('filter', 'blur(3px)');
});

$('#closeQuestion').on('click', function(){

    $('.modal').css('display', 'none');
    $('.wrapper').css('filter', 'blur(0px)');
});

$('#closeQuestion2').on('click', function(){

    $('.modal2').css('display', 'none');
    $('.wrapper').css('filter', 'blur(0px)');
});

$('#closeQuestion3').on('click', function(){

    $('.modal3').css('display', 'none');
    $('.wrapper').css('filter', 'blur(0px)');
});