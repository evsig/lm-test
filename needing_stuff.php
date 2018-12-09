<?php
//репорт ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

//вставка в таблицу, создание инпута

html:

HTML5Выделить код
1
<tr id='1'><td id='ip' class='edit'>1231412411</td></tr>
ajax:

                $('.edit').click(function(e) {
                    e.preventDefault();
                    $(this).html("<input type='text' value='"+$(this).text()+"'/>");
                }).click(function(e) {
                    e.preventDefault();
                    return false;
                }).blur(function(e) {
                    var send_id = $(this).closest('tr');
                    var tag = $(this).attr('id');
                    var info = $(this).text();
                    function funcSuccess(data)
                    {
                        if(data=='ok')
                        {
                            tag.text($(this).val());
                        }
                    }
                    e.preventDefault();
                        $.ajax ({
                        url: "edit.php",
                        type: "POST",
                        data: ({id: send_id, type: tag, value: info}),
                        dataType: "html",
                        success: funcSuccess
                    });
                });
и собственно PHP:


<?php
include('connect_db.php');
if(isset($_POST['id'])&&isset($_POST['type'])&&isset($_POST['value'])){
    $id = $_POST['id'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    if(mysql_query ("UPDATE dashboard SET '$type' = '$value' WHERE id = '$id'"))
        echo 'ok';
    }
    else {
        echo 'error';
    }
}
else {
    echo 'error';
}
$(function asd() {
   
    $("table").on('click', "td", function() {
        var var2 = $(this).text();
        $(this).html('<input class="input-mini" autofocus="autofocus" value="'+var2.trim()+'" /><br><br><button type="submit">save</button>');
        $('button', this).click(function() {
            var var22 = $(this).parent().children('input').val();
            $(this).parent().html(var22);
        });
    });
 
})
        ?>