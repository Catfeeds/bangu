<?php
require_once("alipay/lib/alipay_core.function.php");
require_once("alipay/lib/alipay_md5.function.php");
require_once("alipay/alipay.config.php");
require_once("alipay/lib/alipay_submit.class.php");
require_once("alipay/lib/alipay_notify.class.php");
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * @method 支付宝支付
 * @version 1.0
 * @author 贾开荣
 */
class Alipay_api {
	public $notify_url = ''; //服务器异步通知页面路径    	需http://格式的完整路径，不能加?id=123这类自定义参数
	public $return_url = ''; //页面跳转同步通知页面路径	需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
	public $out_trade_no = ''; //商户订单号 	商户网站订单系统中唯一订单号，必填
	public $subject = ''; //订单名称
	public $total_fee = ''; //付款金额
	public $show_url = ''; //商品展示地址 (可选) 需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
	public $body = ''; //订单描述 (可选)
	public $paymethod = '';//支付方式(直接使用支付宝支付则不需要，使用支付宝网银支付则需要：bankPay)
	public $defaultbank = '';//银行简码，使用支付宝网银支付需要
	
	function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->$key)){
					$this->$key = trim($val);
				}
			}
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