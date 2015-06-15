// Jquery pour rajouter un peu de dynamisme à l'application

$(function(){
	$('.bp-component [data-toggle="tooltip"]').tooltip();

	$('[data-toggle="popover"]').popover('hide')

	$('#loading-example-btn').click(function () {
	  var btn = $(this);
	  btn.button('loading')
	});

});

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
    $("#select_statutModify").change(function(e){
        if ($("#select_statutModify").val() == "autre"){
            $("#StatusPersoModify").fadeIn();
        }
        else{
            $("#StatusPersoModify").fadeOut();
        }
    });
    $('.search-choice-close').click(function(){
    });
    $("#resetAdminFields").click(function(e){
        $('.stuffToReinit').each(function () {
            $(this).val("");
            if($(this).attr("id")=="selectSemestre")
                $(this).val("S1");
            if($(this).attr("id")=="selectPublic")
                $(this).val("IMR1");
        })
    });

    $('a#displayMyModules').click(function(){
        $(".piiiich").remove();
    });
    $('a#displayReporting').click(function(){
        $(".piiiich").remove();
    });
    $('.navbar-nav li a').each(function(){
        if($(this).text()==$('#activePage').text()){
            $(this).addClass("active");
        }
    });
    $("#checkboxSansEnseignant").click(function(e){
        if($("#checkboxSansEnseignant").prop('checked')){
            $("#selectTeacher").prop('disabled', true);
            $('#selectTeacher_chosen').addClass("customHidePulginChosen");
            $('#reveal-without-teacher').removeClass("customHide");
        }
        else{
            $("#selectTeacher").prop('disabled', false);
            $('#reveal-without-teacher').addClass("customHide");
            $('#selectTeacher_chosen').removeClass("customHidePulginChosen");
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
            $("#searchByModule").stop().fadeOut('fast',function(){
                $('#searchByPromo').stop().fadeIn();
            });
            $('#selectPromotion').val("noProm");
            $('#searchType').val('promo');
        }
        $(this.parentElement).addClass('active');
        $(this).addClass('btn');
    });

    if($('#reveal-without-teacher').is(":visible")){
        $("#selectTeacher").prop('disabled', true);
        $('#selectTeacher_chosen').addClass("customHidePulginChosen");
    }



});