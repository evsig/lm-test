
$(document).ready(function () {
    var inpMin = '<input class="input-mini">',
        butMin = '<button visibility: hidden type="submit" class="save">save</button>';
        
    $('.hide_city').hide();
    
    $('div.table').on('click', 'div.td_name', function (e) {
        var $that = $(this);
      
        if ($that.hasClass('edited'))    return false;
        var saveName = $('.edited').children('.input-mini').val();
        console.log('one, my name is'+saveName);
        $('button').remove();
        $('.edited').text(saveName);
        $('input.input-mini').remove();
        $('div.td_name').removeClass('edited');
        $that.html($(inpMin).val($that.text())).append(butMin)
                .addClass('edited');
    });
    
$('.hide_list').hide();
$('.hide_city').show();
    $('div.table').on('click', 'div.td_city', function () { 
        var $that = $(this);   
    if ($that.hasClass('current')) {
//        console.log('city is visible'); 
        $('.hide_city').hide();
        $('.hide_list').show();
    }
    else    {$('.hide_city').show();
            $('.hide_list').hide();}
//        $that.html($(.hide_city).val($that.text())
//                .addClass('current');
    });
    
   
    $('div.td_name').on('click', '.save', function () {
        var $that = $(this);
        var id = $('.edited').parents('.tr').find('.td_id').text();
        var name = $that.siblings('.input-mini').val();
//      var name = $('.edited').parents('.tr').children('.td_name').val();
        $('.edited').mouseleave(function () {
            console.log('Элемент потерял фокус.');
        });
        $that.parent('div.td_name').text(name)
                .removeClass('edited');
        console.log(id);
        console.log('имя' + name);
        $.ajax({
            type: 'POST',
            url: '/index.php',
            data: {'jname': name,
                'jid': id,
                'action': 'UpdName'},
            success: function (responce) {
                if (responce = 'ok')
                    return
                console.log('Data is getting' + responce);
            }

        });

    });





    $('div.td_name').keypress(function (e) {
        if (e.which === 13) {
            $('.save').click();
        }
    });

});