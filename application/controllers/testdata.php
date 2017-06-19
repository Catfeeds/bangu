<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Testdata extends UC_NL_Controller {
	public function __construct()
	{
		parent::__construct ();
	}
	
	//测试接口
	public function index() {

		//构造xml	
		$xmldata= file_get_contents('testdata.xml');
		$url = 'https://61.138.246.87:6002/LifeServiceUat';  //接收xml数据的文件
		$header[] = "Content-Type: text/xml; charset=GBK";        //定义content-type为xml,注意是数组
 		$header[]="GW_CH_TX: 1021";
		$header[]="GW_CH_CODE: SZHWGL";
	 	$header[]="GW_CH_USER: SZHWGL";
		$header[]="GW_CH_PWD:SZHWGL "; 
		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmldata);
		
		$response = curl_exec($ch);
		if(curl_errno($ch)){
			print curl_error($ch);
		}
		header('Content-Type:text/xml; charset=GBK');
		curl_close($ch);
		echo $response;			
	}
	
}
