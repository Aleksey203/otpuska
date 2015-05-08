/**
 * Created by Aleksey on 08.05.15.
 */
$(document).ready(function() {
    //добавление АКБ в 1 клик
    $('td.active').live('click', function(){
        middle = $('#page').offset();
        diff = middle.left - 15;
        var pos = $(this).offset();
        var top = pos.top  + 23;
        var left = pos.left - diff + 353;

        var order= $(this).closest('tr').data('order');
        var one = $('#one-click');
        one.attr("name",order);
        one.toggleClass('active');
        one.css({'top' : top, 'left' : left}).toggle();
        //one.toggle();
        if (one.hasClass('active')) {
            if ($("#one_click_input").val()=='') $('#one_click_input').focus();
            $('#modal').show();
        }
        return false;
    });

    $('#modal').live('click',function(){
        var one = $('#one-click');
        one.removeClass('active').hide();
        $('#modal').hide();
        return false;
    });

    $('#modal').width($('body').width());
    $('#modal').height($('body').height());

    $('.button').live('click', function(){
        var one = $('#one-click');
        var order = one.attr('name');
        if ($(this).hasClass('approve')) var status = 1;
        if ($(this).hasClass('decline')) var status = -1;
        var month = $('.current').attr('name');
        $.ajax({
            url: document.location,
            type: "GET",
            data: {order: order, status: status, month: month},
            dataType: 'json',
            success: function (data) {
                console.log('data=');
                console.log(data);
                if (data.success) {
                    $('#calend').html(data.html);
                    one.find('.button').hide(); /*alert(data.html);*/
                    one.find('.text').html(data.thx).show(); /*alert(data.html);*/
                    setTimeout(function(){$('#modal').trigger('click'); one.find('.button').show(); one.find('.text').hide();},1500);
                }
                if (data.message) $(".help").after(data.message);
            }
        });
        return false;
    });

    $('.month a').live('click', function(){
        month = get_val($(this).attr('href'));
        $.ajax({
            url: document.location,
            type: "GET",
            data: {month: month},
            dataType: 'json',
            success: function (data) {
                console.log('data=');
                console.log(data);
                if (data.success) {$('#calend').html(data.html); /*alert(data.html);*/}
                if (data.message) $(".help").after(data.message);
            }
        });
    });
    return false;
});

//взять значение атрибута href
function get_val (str) {
    var arr = Array();
    arr = str.toString().split('#'.toString() );
    return arr[1];
}
