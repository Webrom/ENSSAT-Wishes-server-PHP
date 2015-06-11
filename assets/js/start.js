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
        $("#selectTeacher").prop('disabled', false);
        $("#checkboxSansEnseignant").removeProp('checked');
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
    $("#resetAdminFields").click(function(e){
        $('.stuffToReinit').each(function () {
            $(this).val("");
            if($(this).attr("id")=="selectSemestre")
                $(this).val("S1");
            if($(this).attr("id")=="selectPublic")
                $(this).val("IMR1");
        })
        console.log("here");
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
            $('#selectTeacher_chosen').addClass("customHide");
            $('#reveal-without-teacher').removeClass("customHide");
        }
        else{
            $("#selectTeacher").prop('disabled', false);
            $('#reveal-without-teacher').addClass("customHide");
            $('#selectTeacher_chosen').removeClass("customHide");
        }
    });
    $('.nav-custom a').click(function(e){
        e.preventDefault();
        $('.nav-custom a').each(function(){
            $(this.parentElement).removeClass('active');
            $(this).removeClass('btn');
        });
        if($(this).attr('href')=="#searchByModule"){
            $("#searchByPromo").stop().fadeOut('fast',function(){
                $('#searchByModule').stop().fadeIn();
            });
            $('#selectModule').val("");
            $('#searchType').val('module');
        }else{
            console.log($("#searchByModule"));
            $("#searchByModule").stop().fadeOut('fast',function(){
                $('#searchByPromo').stop().fadeIn();
            });
            $('#selectPromotion').val("noProm");
            $('#searchType').val('promo');
        }
        $(this.parentElement).addClass('active');
        $(this).addClass('btn');
    });
});