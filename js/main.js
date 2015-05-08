/**
 * Created by Aleksey on 08.05.15.
 */
$(document).ready(function() {
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
});

//взять значение атрибута href
function get_val (str) {
    var arr = Array();
    arr = str.toString().split('#'.toString() );
    return arr[1];
}
