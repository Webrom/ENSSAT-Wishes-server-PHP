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
        $("#modules_result").addClass("animated zoomOut");
        $('.form-control').each(function () {
            $(this).val("");
        });
    });
    $('.navbar-nav li a').each(function(){
        if($(this).text()==$('#activePage').text()){
            console.log($(this).text());
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