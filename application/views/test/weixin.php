<html>
<head>
	<title>支付</title>
	<style>
		*{margin:0px;padding:0px;}
		.main{
			width: 500px;
			margin: 100px auto;
		}
		.list li{
			list-style: none;
			float: left;
			margin-right: 20px;
			margin-top: 20px;
			width: 100%;
		}
		.list .title{
			float: left;
			width: 120px;
		}
		.list .content{
			float: left;
		}
		.list label{cursor:pointer;margin-right: 20px;}
	</style>
</head>
<body>
	<div class="main">
		<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url);?>" style="width:150px;height:150px;"/>
	</div>
</body>
</html>