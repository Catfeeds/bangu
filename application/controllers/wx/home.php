<?php
define("TOKEN", "Aa11223344");
/**
 *
 * @copyright 深圳海外国际旅行社有限公司
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Home extends MY_Controller {
	
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