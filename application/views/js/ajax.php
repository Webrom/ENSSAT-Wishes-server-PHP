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
            "method": $(this).attr('method'),
            "gData": "#" + $(this).attr('class').substring(0, 10)
        };
        console.log(param);
        $.ajax({
            url : param["base_url"]+'index.php/'+param["controler"]+'/'+param["method"],
            type : 'GET',
            data : 'gData='+$(param["gData"]).val(),
            cache: false,
            'success':
                function(data){
                    switch (param["method"]){
                        case "getModuleContenus":
                            $("#display"+param["method"]).addClass('animated bounceInUp').removeClass('customHide');
                            array = JSON.parse(data);
                            $(".ajaxContenuModule").each(function(){
                                $(this).remove();
                            });
                            for(var i = 0; i<JSON.parse(data).length;i++){
                                var mytext = array[i].partie;
                                var option = document.createElement('option');
                                $(option).attr('value',mytext);
                                $(option).addClass('ajaxContenuModule');
                                $(option).text(mytext);
                                $("#selectContenuModule").append($(option));
                            }
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

