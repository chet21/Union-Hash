$('#smart_top_side').on('click', function () {
    var sh = $('#smart_top_side').css('height');
    if( parseInt(sh) > 45 ){
        $('.smart_top_menu').css('display', 'none');
        $('#smart_top_side').css('height', '40px');
    }
});

$('#smart_top_side img').on('click', function () {
    var sh = $('#smart_top_side').css('height');
    if( parseInt(sh) < 45  ){
        $('#smart_top_side').animate({
            height: '200px'
        }, 500);
        setTimeout(function () {
            $('.smart_top_menu').css('display', 'block');
        }, 510)
    }else{
        $('.smart_top_menu').css('display', 'none');
        $('#smart_top_side').animate({
            height: '40px'
        }, 50);
    }
});

$('.li').hover(function () {
    $(this).animate({
        fontSize: '30px'
    }, 500);
}, function () {
    $(this).animate({
        fontSize: '24px'
    }, 500);
});

$('#select_lang').change(function () {

    var lang = $('#select_lang').val();
    var date = new Date();

    $.cookie('444', 444);

    location.reload();
});

$('.close_ico').on('click', function () {
    slow_form_back();
    // $('#test').css('display', 'none');
    // $('#enter_form').css('display', 'none');
    // $('#enter_form input:eq(0)').val('');
    // $('#enter_form input:eq(1)').val('');
    // $('#enter_form input:eq(2)').val('');
    // $('.err').html('');
});

$('#buy_mh_input').change(function () {
    var mh_input = $('#buy_mh_input').val();
    var cours_usd = $('#cours_usd').val();
    var sum_in_usd = $('#sum_in_usd').val('');
    var val = '';
    sum = mh_input * cours_usd;
    val = sum + "$";
    sum_in_usd.val(val);
});



// $('document').ready(function () {
//     setTimeout(function () {
//         $('#test').animation({
//             background: white
//         })
//     }, 300)
// });

$('document').ready(function () {
    // setTimeout(function () {
    //
        $("#test1").fadeIn(2500);
        $("#test2").fadeIn(5000);
    // }, 900)
});





