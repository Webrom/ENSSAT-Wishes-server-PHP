$(function(){
    hideAll();
    console.log($('#affiche').text());
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

function hideAll(){
    $('.col-md-10 .row').each(function(e){
        $(this).addClass('customHide').removeClass('animated bounceInDown');
    });
};

function removeBTN(){
    $('.adminChoice').each(function(){
        $(this).removeClass('btn');
    });
    $('.nav-pills li').removeClass('active');
}

function activeRefresh(){
    $('.adminChoice').each(function(){
        if($(this).attr('href')==$('#affiche').text()){
            $(this).addClass('btn');
            $(this.parentElement).addClass('active');
            console.log($(this));
        }else{
            $(this).removeClass('btn');
            $(this.parentElement).removeClass('active');
        }

    });
    $('.panel-collapse').each(function(){
        if($(this).hasClass($('#affiche').text())){
            $(this).fadeIn().removeClass('collapse').addClass('collapse in');
        }else{
            console.log($(this));
            $(this).removeClass('in');
        }
    });
}