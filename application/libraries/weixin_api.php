<?php
require_once "weixin/lib/WxPay.Api.php";
require_once 'weixin/log.php';
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * @method 微信支付
 * @version 1.0
 * @author 贾开荣
 */
class Weixin_api {
	public $body = '帮游网用户充值'; //设置商品或支付单简要描述 body
	public $attach = '';//设置附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据 attach
	public $out_trade_no = '';//订单号
	public $total_fee = 0; //订单金额，单位分，只能为整数
	public $notify_url = '';//设置接收微信支付异步通知回调地址
	public $trade_type = 'NATIVE';//设置取值如下：JSAPI，NATIVE，APP，详细说明见参数规定
	public $product_id = '';//设置trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义。
	//public $time_start = date("YmdHis");//设置订单生成时间
	//public $time_expire = date("YmdHis", time() + 600);//设置订单失效时间
	
	public function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->$key)){
					$this->$key = trim($val);
				}
			}
		}
	}
	
	
	
	/**
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	public function GetPayUrl()
	{
		$input = new WxPayUnifiedOrder();
		$input->SetBody($this->body); 
		$input->SetAttach($this->attach); 
		$input->SetOut_trade_no($this->out_trade_no); 
		$input->SetTotal_fee($this->total_fee);
		$input->SetTime_start(date("YmdHis"));//设置订单生成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。其他详见时间规则
		$input->SetTime_expire(date("YmdHis", time() + 3600));//设置订单失效时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。其他详见时间规则
		//$input->SetGoods_tag($);
		$input->SetNotify_url($this->notify_url);
		$input->SetTrade_type($this->trade_type);
		$input->SetProduct_id($this->product_id);
		if($input->GetTrade_type() == "NATIVE")
		{
			$result = WxPayApi::unifiedOrder($input);
			return $result["code_url"];
		}
	}
	
	
	
	
	/*请求支付宝*/
	public  function api() {
		$alipay_config = new alipay_config();
		$alipay_config = $alipay_config ->config();
        //支付类型
        $payment_type = "1";
        //必填，不能修改
   
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = $_SERVER['REMOTE_ADDR'];
        //非局域网的外网IP地址，如：221.0.0.1

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"seller_email" => trim($alipay_config['seller_email']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $this ->notify_url,
				"return_url"	=> $this ->return_url,
				"out_trade_no"	=> $this ->out_trade_no,
				"subject"	=> $this ->subject,
				"total_fee"	=> $this ->total_fee,
				"body"	=> $this ->body,
				"show_url"	=> $this ->show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		return $html_text;
	}
	
	/*支付宝的网银支付*/
	public function alipayBankPay()
	{
		$alipay_config = new alipay_config();
		$alipay_config = $alipay_config ->config();
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		 
		//防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数
		
		//客户端的IP地址
		$exter_invoke_ip = $_SERVER['REMOTE_ADDR'];
		//非局域网的外网IP地址，如：221.0.0.1
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"seller_email" => trim($alipay_config['seller_email']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $this ->notify_url,
				"return_url"	=> $this ->return_url,
				"out_trade_no"	=> $this ->out_trade_no,
				"subject"	=> $this ->subject,
				"total_fee"	=> $this ->total_fee,
				"body"	=> $this ->body,
				"paymethod"	=> $this ->paymethod,
				"defaultbank"	=> $this ->defaultbank,
				"show_url"	=> $this ->show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		return $html_text;
	}
	
	/*获得支付宝同步返回结果*/
	public function get_verifyReturn() {
		$alipay_config = new alipay_config();
		$alipay_config = $alipay_config ->config();
		$alipayNotify = new AlipayNotify($alipay_config);
		return $alipayNotify->verifyReturn();
	}
	/*获得支付宝异步返回结果*/
	public function get_verifyNotify() {
		$alipay_config = new alipay_config();
		$alipay_config = $alipay_config ->config();
		$alipayNotify = new AlipayNotify($alipay_config);
		return $alipayNotify->verifyNotify();
	}
}