<?php
/**
 * Fichier réalisant les requetes ajax du panel admin
 * Created by PhpStorm.
 * User: zahead
 * Date: 29/05/15
 * Time: 22:13
 */

?>
<script type="text/javascript">
    $(".ajaxFunction").click(function(e){
        e.preventDefault();
        /* param permet d'uiliser une meme fonction plusieurs fois la methode est l'id du bouton sur
         lequel on a cliqué, le gData permet de recuperer le champ qui nous interesse. Le champ est connu
         car il a la meme id que la permiere classe du bouton
         */
        var param = {
            "base_url": '<?php echo base_url()?>',
            "controler": "admin",
            "method": $(this).attr('id'),
            "gData": "#" + $(this).attr('class').substring(0, 10)
        };
        console.log(param);
        if (!$("#display" + param["method"]).hasClass('customHide')){
            $("#display" + param["method"]).addClass('customHide');
        }
        if (!$('#noContenuRemove').hasClass('customHide')){
            $('#noContenuRemove').addClass('customHide');
        }
        if (!$('#noContenuModify').hasClass('customHide')){
            $('#noContenuModify').addClass('customHide');
        }
        if (!$('#displaysetModuleContenus').hasClass('customHide')){
            $('#displaysetModuleContenus').addClass('customHide');
        }
        $.ajax({
            url : param["base_url"]+'index.php/'+param["controler"]+'/'+param["method"],
            type : 'GET',
            data : 'gData='+$(param["gData"]).val()+'&bData='+$('#obtContenu').val(),
            cache: false,
            'success':
                function(data){
                    if(data.length>2) {
                        $("#display" + param["method"]).addClass('animated bounceInUp').removeClass('customHide');
                    }
                    var array = JSON.parse(data);
                    switch (param["method"]){
                        case "getModuleContenus":
                            if (data.length>2) {
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
                                $('#selectContenuModule').addClass('chosen-select');
                                $('#selectContenuModule').trigger("chosen:updated");
                            }
                            else{
                                $('#noContenuRemove').removeClass('customHide');
                            }
                            break;
                        case "setModuleContenusType":
                            if (data.length>2) {
                                $(".ajaxContenuType").each(function () {
                                    $(this).remove();
                                });
                                for (var i = 0; i < array.length; i++) {
                                    var mytext = array[i].partie;
                                    var option = document.createElement('option');
                                    $(option).attr('value', mytext);
                                    $(option).addClass('ajaxContenuType');
                                    $(option).text(mytext);
                                    $("#dtcContenu").append($(option));
                                }
                                $('#dtcContenu').addClass('chosen-select');
                                $('#dtcContenu').trigger("chosen:updated");
                            }
                            else{
                                $('#noContenuModify').removeClass('customHide');
                            }
                            break;
                        case "setModuleContenus":
                            console.log('aze');
                            $("#modulePartieAjax").val(array[0].partie);
                            $("#selectTypeAjax").val(array[0].type);
                            $("#teacherModuleAjax").val(array[0].enseignant);
                            $("#teacherModuleAjax").text((array[0].enseignant!=null)?array[0].enseignant:"aucun");
                            $("#moduleHedAjax").val(array[0].hed);
                            $('#selectTeacher').trigger("chosen:updated");
                            break;
                        case 'modifyModuleAjax':
                            $('#displayModuleContentModify').addClass('fadeOut');
                            $('#selectResponsableModifyModule').val(array[0].responsable);
                            $('#inputLibelleModifyModule').val(array[0].libelle);
                            $('#selectResponsableModifyModule').addClass('chosen-select');
                            $('#selectResponsableModifyModule').chosen();
                            $('#selectResponsableModifyModule').trigger("chosen:updated");
                            $('#displayModuleContentModify').addClass('animated fadeIn').removeClass('customHide fadeOut');
                            break;
                    }
                    reChosenselect();
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

    $("#supprimer_news").change(function(e){
            if($(this).val()!='no'){
                var date = $(this).val();
                var base_url = '<?php echo base_url()?>';
                var controler = "admin";
                var method = "getInformationNews";
                $.ajax({
                    url : base_url+'index.php/'+controler+'/'+method,
                    type : 'GET',
                    data : 'DATE='+date,
                    cache: false,
                    'success':
                        function(data){
                            $("#informationNews").text(data);
                            $("#afficheInformation").removeClass('customHide');
                        }
                });
            }
            else{
                $("#afficheInformation").addClass('customHide');
            }
        }
    );

    $("#modifier_news").change(function(e){
            if($(this).val()!='no'){
                var date = $(this).val();
                var base_url = '<?php echo base_url()?>';
                var controler = "admin";
                var method = "getInformationNews";
                $.ajax({
                    url : base_url+'index.php/'+controler+'/'+method,
                    type : 'GET',
                    data : 'DATE='+date,
                    cache: false,
                    'success':
                        function(data){
                            $("#informationNewstoModify").text(data);
                            $("#afficheInformationtoModify").removeClass('customHide');
                        }
                });
            }
            else{
                $("#afficheInformationtoModify").addClass('customHide');
            }
        }
    );

    $("#modifyUser").click(function(e){
            $('#displayUserInfoModify').addClass('animated bounceInUp').removeClass('customHide');
            var login = $('#enseignantsModify').val();
            var base_url = '<?php echo base_url()?>';
            var controler = "admin";
            var method = "getUserToModify";
            $.ajax({
                url  : base_url+'index.php/'+controler+'/'+method,
                type : 'GET',
                data : 'login='+login,
                cache: false,
                'success':
                    function(data){
                        var array = JSON.parse(data);
                        $("#loginModify").val(array['0'].login);
                        $("#actifModify").val(array['0'].actif);
                        //$("#select_statutModify").val(array['0'].statut);
                        $("#heuresModify").val(array['0'].statutaire);
                        $("#nameModify").val(array['0'].nom);
                        $("#dechargeModify").val((array['0'].decharge)?array['0'].decharge:0);
                        $("#prenomModify").val(array['0'].prenom);
                        $('#select_statutModify option[value="'+array['0'].statut+'"]').prop('selected', true);
                        $('#select_admin option[value="'+array['0'].administrateur+'"]').prop('selected', true);
                    }
            });
        }
    );

    function reChosenselect(){
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    };
</script>

