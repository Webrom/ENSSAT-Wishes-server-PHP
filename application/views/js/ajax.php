<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 29/05/15
 * Time: 22:13
 */

?>
<script type="text/javascript">
    $(".ajaxFunction").click(function(e){
        e.preventDefault();
        var param = {
            "base_url": '<?php echo base_url()?>',
            "controler": "admin",
            "method": $(this).attr('id'),
            "gData": "#" + $(this).attr('class').substring(0, 10)
        };
        console.log(param);
        $.ajax({
            url : param["base_url"]+'index.php/'+param["controler"]+'/'+param["method"],
            type : 'GET',
            data : 'gData='+$(param["gData"]).val()+'&bData='+$('#obtContenu').val(),
            cache: false,
            'success':
                function(data){
                    console.log(data);
                    $("#display"+param["method"]).addClass('animated bounceInUp').removeClass('customHide');
                    var array = JSON.parse(data);
                    switch (param["method"]){
                        case "getModuleContenus":
                            $(".ajaxContenuModule").each(function(){
                                $(this).remove();
                            });
                            for(var i = 0; i<array.length;i++){
                                var mytext = array[i].partie;
                                var option = document.createElement('option');
                                $(option).attr('value',mytext);
                                $(option).addClass('ajaxContenuModule');
                                $(option).text(mytext);
                                $("#selectContenuModule").append($(option));
                            }
                            break;
                        case "setModuleContenusType":
                            $(".ajaxContenuType").each(function(){
                                $(this).remove();
                            });
                            for(var i = 0; i<array.length;i++){
                                var mytext = array[i].partie;
                                var option = document.createElement('option');
                                $(option).attr('value',mytext);
                                $(option).addClass('ajaxContenuType');
                                $(option).text(mytext);
                                $("#dtcContenu").append($(option));
                            }
                            break;
                        case "setModuleContenus":
                            $("#modulePartieAjax").val(array[0].partie);
                            $("#selectTypeAjax").val(array[0].type);
                            $("#teacherModuleAjax").val(array[0].enseignant);
                            $("#teacherModuleAjax").text((array[0].enseignant!=null)?array[0].enseignant:"aucun");
                            $("#moduleHedAjax").val(array[0].hed);
                            break;
                    }
                }
        });
    });
    $(".valide_user").click(function(e){
        var login = $(this).attr('id');
        var classe = "."+$(this).attr('id');
        var base_url = '<?php echo base_url()?>';
        var controler = "admin";
        var method = "acceptUsers";
        $.ajax({
            url : base_url+'index.php/'+controler+'/'+method,
            type : 'GET',
            data : 'login='+login,
            cache: false,
            'success':
                function(data){
                    if(data){
                        $(classe).remove();
                    }
                }
        });
    });

    $(".refuse_user").click(function(e){
        var login = $(this).attr('id');
        var classe = "."+$(this).attr('id');
        var base_url = '<?php echo base_url()?>';
        var controler = "admin";
        var method = "refuseUsers";
        $.ajax({
            url : base_url+'index.php/'+controler+'/'+method,
            type : 'GET',
            data : 'login='+login,
            cache: false,
            'success':
                function(data){
                    if(data){
                        $(classe).remove();
                    }
                }
        });
    });
</script>

