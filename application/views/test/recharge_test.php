<html>
<head>
	<title>用户充值</title>
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
		<form method="post" action="/tests/pay/weixin_pay">
			<ul class="list">
				<li>
					<div class="title">充值金额:</div>
					<div class="content">
						<input type="text" name="money">
					</div>
				</li>
				<li>
					<div class="title">支付方式:</div>
					<div class="content">
						<label><input type="radio" name="type" checked="checked" value="1">微信支付</label>
<!-- 						<label><input type="radio" name="type" value="2">支付宝支付</label> -->
					</div>
				</li>
				<li>
					<div class="title"></div>
					<div class="content">
						<input type="submit" value="确认">
					</div>
				</li>
			</ul>
			
		</form>
	</div>
</body>
</html>