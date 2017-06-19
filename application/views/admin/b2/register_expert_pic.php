<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
<title>拍照已完成</title>
<style type="text/css">
*{ margin:0;padding:0;}
html,body { -webkit-touch-callout:none;-webkit-text-size-adjust:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);-webkit-user-select:none;}
body { font:12px/1.5 'Microsoft Yahei','Simsun';  color:#000;background:#fff;-webkit-text-size-adjust: none; min-width:320px;}
.clearfix:after { content: ' '; display: block; clear: both; visibility: hidden; line-height: 0; height: 0}
header { height:45px;line-height:45px; width: 100%;text-align:center;background:#f2f2f2;border-bottom:1px solid #eee;font-size:1.4em;color:#8f9c00;}

.main div { float:left;width:100%;text-align:center;margin-top:100px;margin-bottom:20px;height:50px;line-height:50px;font-size:1.4em;}
.main div img { width:50px; height:50px;vertical-align:middle;}
.main p { float:left;width:100%;text-align:center;font-size:1.4em;}
.main p span { padding-right: 5px;color:#39C;}
</style>
</head>
<body>
<header>帮游网</header>
<div class="main clearfix">
	<div ><img src="/assets/img/success_ico.png"/>操作成功</div>
    <p><span><?php if(!empty($expert)){echo $expert['realname'];} ?></span> 拍照已完成</p>
</div>
</body>
</html>

