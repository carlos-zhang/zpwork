<?php
$this->load->helper('url');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?php echo $title ?> </title>
    <script type="text/javascript" src="http://127.0.0.1/zpwork/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://127.0.0.1/zpwork/js/highcharts.js"></script>

    <link href="http://127.0.0.1/zpwork/css/index.css" type="text/css" rel="stylesheet"/>
</head>
<script>


</script>
<body>
<div class="header">
    <h1>广播电视增值业务广告投放系统</h1>
</div>
<div class="content">
    <div class="left-menu">
        <ul>
            <h2>收视数据图表分析</h2> 
            <h3>开机广告</h3>
            <ul>
               
            <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/byday">每日开机</a></li>
            <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/bytime">每时开机</a></li>
            <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/byweek">每周开机</a></li>
            <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/comparebyday">每日对比</a></li>
            <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/comparebytime">每时对比</a></li>
            </ul> 
            <h3>EPG广告</h3>
            <ul>
               
                <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/epgview">EPG频道收视</a></li>
                <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/epgrank">EPGrank</a></li>
                <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/epgfocus">EPGfocus</a></li>
            </ul>

        </ul>
        <ul>
            <h2>广告投放推荐</h2>
            <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/openrecomment">开机广告</a></li>
            <li><a href="http://127.0.0.1/zpwork/index.php/watchrecord/epgrecommentview">EPG广告</a></li>
            
        </ul>

    </div>

  
