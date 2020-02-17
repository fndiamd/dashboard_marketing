/*ajax loading*/
var loading = $(".loading");
$(document).ajaxStart(function () {
    loading.show();
});

$(document).ajaxStop(function () {
    loading.hide();
});
$("#dropdownItemOkr .dropdown-item").click(function(){
    var panel = ($(this).data('panel'));
    var paneltitle = ($(this).html());
    $("#panel").load("fragment/"+panel+".php");
    $("#dropdownOkr").html(paneltitle);
});
