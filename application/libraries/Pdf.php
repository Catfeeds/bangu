<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * fpdf类:将html页面生成PDF文件，进行在线预览或者下载
 * @param: $html 要生成pdf的html内容
 * @param: $name  pdf文件名称
 * @param: $option  选项（在线预览 或者 下载）  为true时，在线预览，为false时下载
 *
 * */
require_once('tcpdfmaster/examples/tcpdf_include.php');
require_once('tcpdfmaster/tcpdf.php');
class Pdf{
	
	function Outpdf($html,$name,$option=true)
	{
		
	}
}