<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('customError'))
{
	function customError($errno, $errstr ,$fileName ,$line)
	{
		//$errorStr = '错误级别：'.$errno.';错误描述：'.$errstr.';错误发生文件：'.$fileName.';错误发生行号：'.$line;
		
		//写日志
		$logPath = './errorlog/';
		if (!file_exists($logPath)) {
			@mkdir($logPath ,0777 ,true);	
		}
		
		if(!file_exists($logPath.date('Y-m-d' ,time()).'.html'))
		{
			$errorStr = '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>错误记录</title></head><body>';
		}
		else 
		{
			$errorStr = '';
		}
		//打开文件
		$file = fopen($logPath.date('Y-m-d' ,time()).'.html' ,'a+');

		$errorStr  .= '<p>';
		$errorStr .= '时间：'.date('Y-m-d H:i:s' ,time()).'<br />';
		$errorStr .= '错误级别:'.$errno.'<br />';
		$errorStr .= '错误描述:'.$errstr.'<br />';
		$errorStr .= '错误发生文件:'.$fileName.'<br />';
		$errorStr .= '错误发生行号:'.$line.'<br />';
		$errorStr .= '</p>';
		
		
		if ($file != false) {
			fwrite($file,$errorStr);
			fclose($file);
		}
// 		if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
// 			// ajax 请求的处理方式
// 			echo json_encode(array('code' =>'-1' ,'msg' =>'请稍后再试'));
// 			die();
// 		}else{
// 			// 正常请求的处理方式
// 			//var_dump($errorStr);
// 		};
		
	}
}