<!DOCTYPE html>
<html>
	<head>
		<title>支付测试</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<form action="<?php echo site_url('pay/order_pay/alipay_notify')?>" method = "post">
			订单号：<input type="text" name="out_trade_no"> <br></br>
			支付宝交易号：<input type="text" name="trade_no"><br></br>
			交易金额：<input type="text" name="total_fee"><br></br>
			买家支付宝账号：<input type="text" name="buyer_email"><br></br>
			交易状态：<input type="text" name="trade_status"><br></br>
			<input type="submit" value="提交">
		</form>
	</body>
</html>