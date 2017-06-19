<html>
<head>
	<title>支付</title>
	<style>
		.content{
			width: 500px;
			margin: 100px auto;
		}
		li{
			list-style-type: none;
			height: 45px;
		}
		li span{
			display: inline-block;
			width: 80px;
		}
		li input {
			
		}
	</style>
</head>
<body>

	<div class="content">
		<form method="post" action="/api/v2_3_2/z/live_alipay">
			<ul>
				<li>
					<span>订单号</span>
					<input type="text" name="out_trade_no">
				</li>
				<li>
					<span>流水号</span>
					<input type="text" name="trade_no">
				</li>
				<li>
					<span>支付金额</span>
					<input type="text" name="total_fee">
				</li>
				<li>
					<span>交易状态</span>
					<input type="text" name="trade_status">
				</li>
				<li>
					<span></span>
					<input type="submit" value="提交">
				</li>
			</ul>
		</form>
	</div>

</body>
</html>