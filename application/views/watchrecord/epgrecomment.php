<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    #result{
        float: left;
    }
    #result div{
        margin: 30px;
    } 
    
</style>
<script>
   
    $(function() {
        $("#submit").click(function() {

               $.ajax({
                    url: "http://127.0.0.1/zpwork/index.php/watchrecord/epgrecomment",
                   //url:'http://127.0.0.1/zpwork/index.php/watchrecord/bytimeandoptions/',
                   //url:'http://127.0.0.1/zpwork/index.php/watchrecord/byoptions',
                   data: $('form').serialize(),
                   type: "get",
                   
                   success:function(data){
                       console.log("success");
                    $("#best_channel").text(data);
                      
                
                   }
                    
               });
           })
    })
</script>

<div class="main">

    <form onsubmit="return false" >
        <div class="feature" id="options">
            <div>人群特征：</div>
            <div>收入：
                <select name="Ppl_Incomenum">
                    <option value="7">不限</option>
                    <option value="1">1000元以下</option>
                    <option value="2">1001-2000元</option>
                    <option value="3">2001-3000元</option>
                    <option value="4">3001-5000元</option>
                    <option value="5">5001-8000元</option>
                    <option value="6">8000元以上</option>                     
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
        </div>
        <div class="statistic">
<!--            支持度：<input name='support' type="text">
            置信度：<input name="confidence" type="text">-->
            <button id="submit"> 执行 </button>
        </div>

    </form>


    <div id="result">
        <div>推荐投放频道:<span id="best_channel"></span></div>
        
    </div>

</div>
