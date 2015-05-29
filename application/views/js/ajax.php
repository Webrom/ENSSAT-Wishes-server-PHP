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
    $("#myimgid").click(function(e){
        var classe = "."+$(this).attr('id');
        $(classe).remove();
    })
</script>

