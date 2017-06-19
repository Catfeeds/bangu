<?php
define("TOKEN", "Aa11223344");
/**
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @method 订单支付
 * @author 贾开荣
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Check extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
	}
	
	public function index() {
		$echoStr = $_GET["echostr"];
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
		
		$token = TOKEN;
		$tmpArr = array(
				$token, 
				$timestamp, 
				$nonce 
		);
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		
		if ($tmpStr == $signature) {
			echo $echoStr;
			return true;
		} else {
			return false;
		}
	}
}