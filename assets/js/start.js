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
    $('.nav-custom a').click(function(e){
        e.preventDefault();
        $('.nav-custom a').each(function(){
            $(this.parentElement).removeClass('active');
            $(this).removeClass('btn');
        });
        if($(this).attr('href')=="#searchByModule"){
            $("#searchByPromo").stop().slideUp('fast',function(){
                $('#searchByModule').stop().slideDown();
            });
            $('#selectModule').val("");
            $('#searchType').val('module');
        }else{
            $("#searchByModule").stop().slideUp('fast',function(){
                $('#searchByPromo').stop().slideDown();
            });
            $('#selectPromotion').val("noProm");
            $('#searchType').val('promo');
        }
        $(this.parentElement).addClass('active');
        $(this).addClass('btn');
    });
});