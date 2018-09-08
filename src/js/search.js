// $('document').ready(
//     select_country()
// );

// function select_country() {
    $('#search_country_select').change(function () {
        var val = $('#search_country_select').val();
        if(val == 0){
            $('#search_city_select').html('');
            $('#search_city_select').append('<option value="0">...</option>');
        }else{
            $.ajax({
                url: '/search/getcity',
                type: 'post',
                data: {val: val},
                success: function (response) {
                    var response2 = JSON.parse(response);
                    $('#search_city_select').html('');
                    $.each(response2, function (k, v) {
                        $('#search_city_select').append('<option value="'+v.id+'">'+v.title+'</option>');
                    })
                }
            });
        }
    });
// }

function go_search() {

    var line_err = $('#search_err');
    var err = [];

    line_err.html('');

    if ($('#search_country_select').val() == '') err.push('You must enter country');
    if ($('#search_city_select').val() == '') err.push('You must enter city');

    if (err.length != 0) {
        $.each(err, function (k, v) {
            line_err.append('<p>' + v + '</p>');
        })
    } else {
        var x = $('#search_form').serializeArray();
        $.ajax({
            url: '/search/search',
            type: 'post',
            data: x,
            success: function (response) {
                var response2 = JSON.parse(response);
                $.each(response2, function (k,v) {
                    line_err.append('<img class="img_result" src="'+v.link+'">');
                    // console.log(v);
                })
            }
        })
    }
}