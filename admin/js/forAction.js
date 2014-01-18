$(function () {
    $('#datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        autoSize: true
    });
    $("#save").click(function () {
        /*$.each($(".snglPht").children(), function () {
            var input = $("<input>", {
                type: "hidden",
                name: $(this).attr("id")
            });
            input.val($(this).attr("src").substr(8));
            $("form").append(input);
        });

        var input = $("<input>", {
            type: "hidden",
            name: "gallery"
        });
        $.each($("#files_gall").children(), function () {
            input.val(input.val()+"|"+$(this).attr("id"));
        });
        $("form").append(input);*/
        $.each($(".editor"), function(){
            var txt = $(this).find(".txt");
            var editor = $(this).find(".nicEdit-main");
            $(txt).html($(editor).html());
        });
        /*if($("#tags").length != 0){
            $("#tags").val('');
            $.each($("#added").children(), function(){
                if($(this).attr("id") != null)$("#tags").val($("#tags").val()+$(this).attr("id")+'/');
            });
        }      */
        /*if(checkFields())*/ $("form").submit();
    });
    $("#chkb").change(function(){
        if($(this).is(":checked")){
            $("#show_in_slide").val("1");
        }
        else $("#show_in_slide").val("0");
    });
});
function checkFields() {
    var flag = true;
    $.each($(".inpt"), function() {
        if( $.trim( $(this).val()) == "") {
            alert("Не все поля заполнены!");
            flag = flag & false;
            return false;
        }
    });

    return flag;
}
function uploadImage(fName) {
    var btnUpload = $('#pht' + fName);
    var status = $('#status' + fName);
    new AjaxUpload(btnUpload, {
        action: '/admin/data/upload_image/' + fName,
        name: fName,
        onSubmit: function(file, ext) {
            if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                // extension is not allowed
                status.text('Only JPG, PNG or GIF files are allowed');
                return false;
            }
            status.text('Загрузка...');
        },
        onComplete: function(file, response){
            //On completion clear the status
            status.text('');
            //Add uploaded file to list
            $("#files" + fName).html('<img class="preview" onclick="delete_image(this);" src="/temp/'+response+'" id="'+fName+'"/>');
            $("#post" + fName).val(response);
        }
    });
    return false;
}

function delete_image(img) {
    if(confirm('Удалить картинку?')){
        var image = $(img);
        var name = image.attr('id');
        image.remove();
        $("#post" + name).val('');
    }
}