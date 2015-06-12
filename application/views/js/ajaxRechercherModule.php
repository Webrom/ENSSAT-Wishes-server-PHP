<script type="text/javascript">
    $('.ajaxReporting').click(function(e){
        e.preventDefault();
        var param = {
            "base_url": '<?php echo base_url()?>',
            "controller": "modules",
            "method": $(this).attr('id'),
            "gData": "#" + $(this).attr('class').substring(0, 10)
        };
        console.log(param);
        $.ajax({
            url : param["base_url"]+'index.php/'+param["controller"]+'/'+param["method"],
            type : 'GET',
            data : 'gData='+$(param["gData"]).val(),
            cache: false,
            'success':
                function(data){
                    console.log(data);
                    if(data){
                        var idChart = (param['gData']+'Chart').substr(1);
                        data=JSON.parse(data);
                        console.log(data);
                        switch (idChart){
                            case 'selectModuChart':
                                var chart = new CanvasJS.Chart(idChart,
                                    {
                                        title:{
                                            text: "Detail module: "+data[0].module
                                        },
                                        theme: "theme2",
                                        data: [
                                            {
                                                type: "pie",
                                                showInLegend: true,
                                                toolTipContent: "{y} - HED",
                                                yValueFormatString: "",
                                                legendText: "{indexLabel} : {y} HETD",
                                                dataPoints: [
                                                ]
                                            }
                                        ]
                                    });
                                data.forEach(function(v){
                                    chart.options.data[0].dataPoints.push({y:v.hed,indexLabel:v.partie});
                                });
                                break;
                            case 'selectTeacChart':
                                var chart = new CanvasJS.Chart(idChart,
                                    {
                                        title:{
                                            text: "Detail du professeur : "+data[0].enseignant
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
                                        title:{
                                            text: "Detail du semestre : "+data[0].semestre
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
                                var ident = data[0].module;
                                data.forEach(function(v){
                                    if(v.module == ident){
                                        chart.options.data[0].dataPoints.y= chart.options.data[0].dataPoints.y + parseInt(v.hed);
                                        console.log(chart.options.data[0].dataPoints.y);
                                    }else{
                                        x=x+10;
                                        chart.options.data[0].dataPoints.push({
                                            x:x,
                                            y: parseInt(v.hed),
                                            label: v.module,
                                            promotion: v.public
                                        });
                                    }
                                    ident = v.module;
                                });
                                break;
                        }
                        if(chart)
                            chart.render();
                    }
                }
        });
    });
</script>