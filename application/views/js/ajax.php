<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 29/05/15
 * Time: 22:13
 */

?>
<script type="text/javascript">
    $("#ajaxShowModuleContenu").click(function(e){
        e.preventDefault();
        var base_url = '<?php echo base_url()?>';
        var controler = "admin";
        $.ajax({
            url : base_url+'index.php/'+controler+'/getModuleContenus',
            type : 'GET',
            data : 'module='+$("#selectModuleShowContenu").val(),
            cache: false,
            'success':
                function(data){
                    var array = JSON.parse(data);
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
                }
        });
    });
</script>