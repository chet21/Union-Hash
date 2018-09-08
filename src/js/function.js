function slow_form() {
    loader_window_mini('on');
    $('.form_2').css({display: 'block'});
    $('.line')
        .animate({width: 275}, 1500);
    $('.form_2')
        .animate({height: 375}, 1500);
    setTimeout(function () {
        $('.hide').css("display", "block")
    }, 1550)
}

function slow_form_back() {
    setTimeout(function () {
        $('.hide').css("display", "none")
    }, 100);
    $('.form_2').animate({height: 0}, 1500);
    $('.line')
        .animate({width: 0}, 1500);
    setTimeout(function () {
        $('.form_2').css({display: 'none'});
        loader_window_mini('off');
    }, 1490);




    // $('.form_2').css({display: 'block'});
    // $('.line')
    //     .animate({width: 275}, 1500);
    // $('.form_2')
    //     .animate({height: 375}, 1500);
    // setTimeout(function () {
    //     $('.hide').css("display", "none")
    // }, 1550)
}

function load_enter_form()
{
    $('#enter_form').css('display', 'block');
}

function load_reg_form()
{
    $('#reg_form').css('display', 'block');
}

function author() {
    $('.err').html('');
    var err =[];
    var login = $('#enter_form input:eq(0)').val();
    var password = $('#enter_form input:eq(1)').val();
    if (login == '') err.push('Введите логин');
    if (password == '') err.push('Введите пароль');
    if (err.length > 0){
        $.each(err, function (k, v) {
            $('.err').append('<p>'+v+'</p>');
        })
    }else{
        var data = $('#enter_form_data').serializeArray();
        $.ajax({
            url: '/enter',
            type: 'post',
            data: data,
            success: function (response) {
                if(response == 1){
                    location.replace('/dashboard');
                }else{
                    $('.err').append('<p>Пароль или логин введен не правильно</p>');
                }
            }
        });
    }
}

function check_login_on_server(login) {
    var res;
    $.ajax({
        url: '/reg',
        type: 'post',
        async: false,
        data: {'check':login},
        success: function (response) {
            // if(response) err.push('Пользователь с таким логином уже существует');
            res = response;
        },
        error: function (data) {
            console.log('error', data)
        }
    });
    return res;
}

function reg() {
    $('.err').html('');
    var err =[];
    var login = $('#reg_form_data input:eq(0)').val();
    var password1 = $('#reg_form_data input:eq(1)').val();
    var password2 = $('#reg_form_data input:eq(2)').val();
    if (!login){
        err.push('Введите логин');
    }else{
        if(check_login_on_server(login) == 1) err.push('Логин занят');
    }
    if (!password1) err.push('Введите пароль');
    if (password2 != password1) err.push('Пароли не совпадают');
    if (err.length > 0){
        $.each(err, function (k, v) {
            $('.err').append('<p>'+v+'</p>');
        });
    }else{
        var data = $('#reg_form_data').serializeArray();
        $.ajax({
            url: '/reg',
            type: 'post',
            data: data,
            success: function (response) {
                $('#reg_form_block').html('');
                $('#reg_form_block').append('<p>Регистрация пройшла спешно</p>')
            },
            error: function (data) {
                console.log('error', data)
            }
        });
    }
}

function new_contract(a) {
    $('#err_buy').html('');
    var form = $('#new_contract').serializeArray();
    var sum_usd = $('#sum_in_usd').val();
    sum_usd = sum_usd.replace('$', '');
    form.push({sum: sum_usd});
    var err = [];
    var mh = form[0]['value'];
    if(mh === '') err.push('Введите данные');
    if(mh <= 0) err.push('Введите число больше нуля');
    if( a === 0 && mh > a) err.push('Свободной мощности нет... Ждите');
    if( mh > a && a != 0) err.push('Максимальная мощность для покупки '+a+'МХ');
    if(form[2]['value'] !== 'on') err.push('Нужно принять соглашение');
    if(err.length > 0){
        $.each(err, function (k, v) {
            $('#err_buy').append('<p style="color: red;">'+'*'+v+'</p>');
        });
    }else{
        loader_window('on');
            $.ajax({
            url: '/buy',
            type: 'post',
            data: {'data':form},
            success: function (response) {
                setTimeout(location.reload(), 3000);
            }
        });
    }
}

function loader_window(status) {
    if(status === 'on'){
        $('.loader').css({
            display: 'block'
        })
    }
    if(status === 'off'){
        $('.loader').css({
            display: 'none'
        })
    }
}

function loader_window_mini(status) {
    if(status === 'on'){
        $('.loader_mini').css({
            display: 'block'
        })
    }
    if(status === 'off'){
        $('.loader_mini').css({
            display: 'none'
        })
    }
}

// function sale_hash(a) {
//     $('#err_sale').html('');
//     var err = [];
//     var data = $('#sale_hash_form input:eq(0)').val();
//     if( data <= 0 || data > a) err.push('Введите данные правильно');
//     if(err.length > 0) {
//         $.each(err, function (k, v) {
//             $('#err_sale').append('<p>' + v + '</p>');
//         });
//     }else{
//         $.ajax({
//             url: '/sale',
//             type: 'post',
//             data: {data: data},
//             success: function (response) {
//                 location.reload();
//             }
//         });
//     }
// }

function out() {
    $.ajax({
        url: '/out',
        type: 'post',
        data:  {stat: 1},
        success: function () {
            location.replace('/');
        }
    })
}

function deposit_run() {
    $('#err_deposit').html('');
    var sum = $('#deposit').val();
    if(sum > 0 ){
        $.ajax({
            url: '/create',
            type: 'post',
            data: {usd: sum},
            success: function (response) {
                var responses = JSON.parse(response);
                location.replace('/pay/'+responses['invoice_id']);
            }
        });
    }else{
        $('#err_deposit').append('<span style="color: red">Введите правильное знчение</span>');
    }

function slow_window($id) {
    $('#enter_form').animate({
        display: block
    });
}
}