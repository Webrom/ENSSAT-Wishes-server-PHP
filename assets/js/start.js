// start functions boostraps js

(function(){
	$('.bp-component [data-toggle="tooltip"]').tooltip();

	$('[data-toggle="popover"]').popover('hide')

	$('#loading-example-btn').click(function () {
	  var btn = $(this);
	  btn.button('loading')
	});

})();

$(function(){

    $('.alert-dismissable').each(function(){
        $(this).delay(6000).slideUp();
    });
    $("a#linkHelp").click(function(e){
        $("#helpDisplay").fadeToggle();
    });
    $("#helpDisplay").click(function(e){
        $("#helpDisplay").fadeToggle();
    });
    $("#status_select").change(function(e){
        if ($("#status_select").val() == "autre"){
            $("#StatusPerso").fadeIn();
        }
        else{
            $("#StatusPerso").fadeOut();
        }
    });
    $("#resetFormSearch").click(function(e){
        $("#modules_result").remove();
        $('.form-control').each(function () {
            $(this).val("");
            if($(this).attr("id")=="selectTeacher")
                $(this).val("no");
            if($(this).attr('id')=='selectSemester')
                $(this).val("noSemester");
            if($(this).attr('id')=='selectPromotion')
                $(this).val("noProm");
        });
    });
    $('a#displayMyModules').click(function(){
        $("#modules_result").remove();
    });
    $('.navbar-nav li a').each(function(){
        if($(this).text()==$('#activePage').text()){
            $(this).addClass("active");
        }
    });
    $("#checkboxSansEnseignant").click(function(e){
        if($("#checkboxSansEnseignant").prop('checked')){
            $("#selectTeacher").prop('disabled', true);
        }
        else{
            $("#selectTeacher").prop('disabled', false);
        }
    });
});