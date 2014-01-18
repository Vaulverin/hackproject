$(function() {
    $('#main_table').dataTable({
        "oLanguage": {
            "sLengthMenu": "Показывать _MENU_ записей на странице",
            "sZeroRecords": "Ничего не найдено",
            "sInfo": "Показано с _START_ по _END_ из _TOTAL_ записей",
            "sInfoEmpty": "Показано с 0 по 0 из 0 записей",
            "sInfoFiltered": "(выбрано из _MAX_ записей)",
            "sSearch": "Поиск :",
            "sPrevious": "Предыдущая"
        }
    });
    $('#main_table').css({
        width: "100%"
    });
    $(".check").click(function(){
        var parent = $(this).parent().parent();
        if(parent.hasClass("actv")) parent.removeClass("actv");
        else parent.addClass("actv");
    });
    $("#del").click(function(){
        var arrDel = [];
        $.each($(".check"), function(){
            if($(this).attr("checked") == "checked"){
                arrDel.push($(this).val());
            }
        });
        if(confirm("Вы действительно хотите удалить "+arrDel.length+" записей?")){
            delt(arrDel, function(){
                location="/admin/main/show/"+page;
            });
        }
    });
} );
function delt(arrDel, callback){
    for(var id in arrDel){
        $.ajax({
            type: "GET",
            async: false,
            url: "/admin/data/delete/"+page+"/"+arrDel[id] ,

        });
    }
    callback();
}