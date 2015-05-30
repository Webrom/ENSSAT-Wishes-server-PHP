$(function(){
    hideAll();
    $('.classeUnique').removeClass('customHide');
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