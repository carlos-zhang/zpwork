<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$data=array();
foreach($days as $day=>$amount){
 $data[]=$amount;
}

?>
<script>
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '每日开机人数图',
                x: -20 //center
            },
          
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6',
                    '7', '8', '9', '10', '11', '12','13','14','15','16','17','18'
                ,'19','20','21','22','23','24','25','26','27','28','29','30','31']
            },
            yAxis: {
                title: {
                    text: '开机人数'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '人'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: '人数',
                data: <?php echo json_encode($data); ?>
            }
            ]
        });
    });
    </script>
    <div class="main">
        <div id="container"></div>
        
    </div>
