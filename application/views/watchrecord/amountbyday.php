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
        $('#chart').highcharts({
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
                categories: ['2', '3', '4', '5', '6',
                    '7', '8', '9', '10', '11', '12','13','14','15','16','17','18'
                ,'19','20','21','22','23','24','25','26','27','28','29','30']
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
        <div id="options">
            <form>
                <div>曲线特征：</div>
                <div>收入：
                    <select name="incomegroup">
                        <option>1000元以下</option>
                        <option>1001-2000元</option>
                        <option>2001-3000元</option>
                        <option>3001-5000元</option>
                        <option>5001-8000元</option>
                        <option>8000元以上</option>
                        <option>其它</option>
                    </select>
                </div>
                <div>
                    年龄范围:
                    <input name="age-low" type="number"/>
                    <input name="age-high" type='number'/>
                </div>
                <div>
                性别:
                    <input name='gendar' type='checkbox' value='male'/>男
                    <input name='gendar' type='checkbox' value='female'/>女
                </div>
                <div>
                职业类别：
                <input name='job' type='checkbox'>媒体/广告/咨询
                <input name='job' type='checkbox'>交通/运输
                 <input name='job' type='checkbox'>农业/水产
                 <input name='job' type='checkbox'>政府机关
                 <input name='job' type='checkbox'>教育/培训
                 <input name='job' type='checkbox'>医疗/保健/制药
                 <input name='job' type='checkbox'>服务业
                 <input name='job' type='checkbox'>酒店/旅游/餐饮
                 <input name='job' type='checkbox'>金融(银行/证券/保险)
                 <input name='job' type='checkbox'>工业/地质
                 <input name='job' type='checkbox'>房地产/建筑
                 <input name='job' type='checkbox'>贸易/进出口
                 <input name='job' type='checkbox'>计算机(IT/互联网)
                 <input name='job' type='checkbox'>交通运输/邮电通信
                 <input name='job' type='checkbox'>广播电视/文化艺术
                </div>
                <div>
                 <input type='submit' value='执行'>
                </div>
             </form>
            
        </div>
        <div id="chart"></div>
        
    </div>
