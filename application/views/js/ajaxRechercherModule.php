<?php /**
 *
 *  Fichier réalisant les requetes ajax du reporting du panel module
 */
?>
<script type="text/javascript">
    //Permet de recuperer le contenu pour afficher les graphiques
    $('.ajaxReporting').click(function(e){
        e.preventDefault();
        /* param permet d'uiliser une meme fonction plusieurs fois la methode est l'id du bouton sur
           lequel on a cliqué, le gData permet de recuperer le champ qui nous interesse. Le champ est connu
           car il a la meme id que la permiere classe du bouton
         */
        var param = {
            "base_url": '<?php echo base_url()?>',
            "controller": "modules",
            "method": $(this).attr('id'),
            "gData": "#" + $(this).attr('class').substring(0, 10)
        };
        $.ajax({
            url : param["base_url"]+'index.php/'+param["controller"]+'/'+param["method"],
            type : 'GET',
            data : 'gData='+$(param["gData"]).val(),
            cache: false,
            'success':
                function(data){
                    if(data){
                        var idChart = (param['gData']+'Chart').substr(1);
                        if(data.length>2){
                            data=JSON.parse(data);
                            switch (idChart){
                                case 'selectModuChart':
                                    var chart = new CanvasJS.Chart(idChart,
                                        {
                                            animationEnabled: true,
                                            exportEnabled: true,
                                            theme: "theme2",
                                            title:{
                                                text: "Detail module: "+data[0].module,
                                                fontFamily: "Opensans",
                                                fontSize: 20,
                                                fontWeight: "bold"
                                            },
                                            legend: {
                                                fontFamily: "Opensans",
                                                maxWidth: 350,
                                                itemWidth: 120
                                            },
                                            theme: "theme2",
                                            data: [
                                                {
                                                    type: "pie",
                                                    fontFamily: "Opensans",
                                                    showInLegend: true,
                                                    toolTipContent: "{y} - HED",
                                                    yValueFormatString: "",
                                                    legendText: "{indexLabel}, HETD : {y}",
                                                    dataPoints: [
                                                    ]
                                                }
                                            ]
                                        });
                                    data.forEach(function(v){
                                        var te = (v.enseignant!=null)?v.enseignant:"aucun";
                                        chart.options.data[0].dataPoints.push({y:v.hed,indexLabel:v.partie +" prof : "+ te });
                                    });
                                    break;
                                case 'selectTeacChart':
                                    var chart = new CanvasJS.Chart(idChart,
                                        {
                                            animationEnabled: true,
                                            exportEnabled: true,
                                            theme: "theme2",
                                            title:{
                                                text: "Detail du professeur : "+data[0].enseignant,
                                                fontFamily: "Opensans",
                                                fontSize: 20,
                                                fontWeight: "bold"
                                            },
                                            legend: {
                                                fontFamily: "Opensans",
                                                maxWidth: 350,
                                                itemWidth: 150
                                            },
                                            data: [{
                                                type: "pie",
                                                showInLegend: true,
                                                toolTipContent: "{y} - HED",
                                                yValueFormatString: "",
                                                legendText: "{indexLabel} : {y} HETD",
                                                dataPoints: [
                                                ]
                                            }]
                                        });
                                    data.forEach(function(v){
                                        chart.options.data[0].dataPoints.push({y:v.hed,indexLabel: v.module+" "+v.partie});
                                    });
                                    break;
                                case 'selectSemeChart':
                                    var chart = new CanvasJS.Chart(idChart,
                                        {
                                            animationEnabled: true,
                                            exportEnabled: true,
                                            theme: "theme2",
                                            title:{
                                                text: "Detail du semestre : "+data[0].semestre,
                                                fontFamily: "Opensans",
                                                fontSize: 20,
                                                fontWeight: "bold"
                                            },
                                            legend: {
                                                fontFamily: "Opensans"
                                            },
                                            data: [
                                                {
                                                    type:'column',
                                                    toolTipContent: "{promotion} - {y} HED ",
                                                    dataPoints: []
                                                }
                                            ]
                                        });
                                    var x = 0;
                                    var i=0;
                                    var ident;
                                    data.forEach(function(v){
                                        if(v.module == ident){
                                            chart.options.data[0].dataPoints[i-1].y= chart.options.data[0].dataPoints[i-1].y + parseInt(v.hed);
                                        }else{
                                            x=x+10;
                                            chart.options.data[0].dataPoints.push({
                                                x:x,
                                                y: parseInt(v.hed),
                                                label: v.module,
                                                promotion: v.public
                                            });
                                            i++;
                                        }
                                        ident = v.module;

                                    });
                                    break;
                            }
                        }
                        if(chart){
                            $("#"+idChart).addClass('animated fadeIn').removeClass('customHide');
                            chart.render();
                        }else{
                            $("#"+idChart).removeClass('animated fadeIn').addClass('customHide');
                            alert("Il n'y a pas de donnée à afficher.");
                        }

                    }
                }
        });
    });
</script>