<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style type="text/css">
#chart{
    overflow: scroll;
}
</style>
<script>
   
    $(function() {
        $('#add').click(function() {
            var line=$('.line').first().clone(true);
            $('.lines').append(line);
            
           $('.line-name').each(function(index){
               $(this).text("条柱"+(index+1)+":");
           });
        
           var cancel=$("<button class='line-cancel'>取消条柱</button>");
            $('.line-name').last().after(cancel);
            $('.line-cancel').click(function() {            
            $(this).parents('.line').remove(); 
             $('.line-name').each(function(index){
               $(this).text("条柱"+(index+1)+":");
           });
             
            
        });
        });
        
        
        
         $("#submit").click(function(){
         var req={};
         $('.line').each(function(index){          
             req[index]=$(this).serializeArray();           
         });
         
        $.ajax({
        url:'http://127.0.0.1/zpwork/index.php/watchrecord/epgstatics',
        data:req,
        type:"get",
        dataType:"json",
        success:function(data){
            
        $('#chart').highcharts({
            chart: {
                type: 'bar',
                marginRight: 130,
                height:12000
              
            },
            title: {
                text: 'epg统计图',
                x: -20 //center
            },
            
          
            xAxis: {
                categories: <?php echo json_encode($channels);?>,
                minpadding:0.05
            },
            yAxis: {
                title: {
                    text: '收看小时'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '小时'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: data
        });
        }}
   );
   });
      
    })

</script>
<div class="main">
    <div id="options">
            <div class="lines">
                <form class="line" onsubmit="return false">
                    <div class="line-name" >条柱1：</div>
                    
                    <div>收入：
                        <select name="Ppl_Incomenum">
                            <option value="1">1000元以下</option>
                            <option value="2">1001-2000元</option>
                            <option value="3">2001-3000元</option>
                            <option value="4">3001-5000元</option>
                            <option value="5">5001-8000元</option>
                            <option value="6">8000元以上</option>
                            <option value="7">不限</option>
                            <option value="-1">其它</option>
                        </select>
                    </div>
                    <div>
                        年龄范围:
                        <input name="age-low" type="number"/>
                        <input name="age-high" type='number'/>
                    </div>
                    <div>
                        性别:
                        <input name='Ppl_Sex[]' type='checkbox' value='男'/>男
                        <input name='Ppl_Sex[]' type='checkbox' value='女'/>女
                    </div>
                    <div>
                        职业类别：
                        <input name='job[]' type='checkbox' value='1'>媒体/广告/咨询
                        <input name='job[]' type='checkbox' value='2'>交通/运输
                        <input name='job[]' type='checkbox' value='3'>农业/水产
                        <input name='job[]' type='checkbox' value='4'>政府机关
                        <input name='job[]' type='checkbox' value='5'>教育/培训
                        <input name='job[]' type='checkbox' value='6'>医疗/保健/制药
                        <input name='job[]' type='checkbox' value='7'>服务业
                        <input name='job[]' type='checkbox' value='8'>酒店/旅游/餐饮
                        <input name='job[]' type='checkbox' value='9'>金融(银行/证券/保险)
                        <input name='job[]' type='checkbox' value='10'>工业/地质
                        <input name='job[]' type='checkbox' value='11'>房地产/建筑
                        <input name='job[]' type='checkbox' value='12'>贸易/进出口
                        <input name='job[]' type='checkbox' value='13'>计算机(IT/互联网)
                        <input name='job[]' type='checkbox' value='14'>交通运输/邮电通信
                        <input name='job[]' type='checkbox' value='15'>广播电视/文化艺术
                        <input name='job[]' type='checkbox' value='16'>其它
                    </div>
               
                </form>
            </div>
            <div>
                <button id='submit'>执行</button>
                <button id='add'>增加条柱</button>
            </div>
    

    </div>

    <div id="chart"></div>

</div>