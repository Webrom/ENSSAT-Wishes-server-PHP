/**
 * Cache tous les panels au chargement de l'administration et affiche le panel
 * qui se trouve dans $('#affiche').text()
 */
$(function(){
    hideAll();
    var show = $('#affiche').text();
    $(show).removeClass('customHide');
    activeRefresh();
    $('.adminChoice').click(function(e){
        hideAll();
        removeBTN();
        $(this).addClass('btn');
        $(this.parentElement).addClass('active');
        $($(this).attr('href')).addClass('animated bounceInDown').removeClass('customHide');
    });
});

/**
 * Permet de cacher tous les panels
 */
function hideAll(){
    $('.col-md-10 .row').each(function(e){
        $(this).addClass('customHide').removeClass('animated bounceInDown');
    });
};

/**
 * Supprime le btn de la dom
 */
function removeBTN(){
    $('.adminChoice').each(function(){
        $(this).removeClass('btn');
    });
    $('.nav-pills li').removeClass('active');
}

/**
 * Lorsqu'on envoit un formulaire, on envoit aussi des variables qui
 * permettent d'ouvrir l'adminisatration à l'état t-1 avant l'envoit du formulaire.
 * Grosso modo le panel d'avant (suppression contenu/modification/....) reste affiché.
 */
function activeRefresh(){
    $('.adminChoice').each(function(){
        if($(this).attr('href')==$('#affiche').text()){
            $(this).addClass('btn');
            $(this.parentElement).addClass('active');
        }else{
            $(this).removeClass('btn');
            $(this.parentElement).removeClass('active');
        }

    });
    $('.panel-collapse').each(function(){
        if($(this).hasClass($('#affiche').text())){
            $(this).fadeIn().removeClass('collapse').addClass('collapse in');
        }else{
            $(this).removeClass('in');
        }
    });
}