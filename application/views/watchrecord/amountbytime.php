<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//$data=array();
//foreach($days as $day=>$amount){
// $data[]=$amount;
//}

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
                categories: ['0:00-1:00', '1:00:2:00', '2:00-3:00','3:00-4:00', '4:00-5：00', '5:00-6:00','6:00-7:00',
                    '7:00-8:00', '8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00','13:00-14:00','14:00-15:00','15:00-16:00','16:00-17:00','17:00-18:00','18:00-19:00'
                ,'19:00-20:00','20:00-21:00','21:00-22:00','22:00-23:00','23:00-24:00']
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
                data: <?php echo json_encode($time); ?>
            }
            ]
        });
    });
    </script>
    <div class="main">
        <div id="container"></div>
        
    </div>
