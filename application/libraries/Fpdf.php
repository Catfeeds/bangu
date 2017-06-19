<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require APPPATH.'third_party/dompdf/dompdf_config.inc.php';

/**
 * fpdf类:将html页面生成PDF文件，进行在线预览或者下载
 * @param: $html 要生成pdf的html内容
 * @param: $name  pdf文件名称
 * @param: $option  选项（在线预览 或者 下载）  为true时，在线预览，为false时下载
 *
 * */

class Fpdf{
	
	function Outpdf($html,$name,$option=true)
	{
		//$html = "<meta http-equiv='Content-Type' content='text/html; charset=utf8'><p style='font-family:SimSun;'>我就是中文</p><img src='lo.png' style='position:absolute;top:0;opacity:0.7;' />";
		$pdf_obj = new DOMPDF();
		$pdf_obj->load_html($html);
		$pdf_obj->render();
		if($option)
		{
		$pdf_obj->stream($name,array("Attachment" => false));//在线预览
		}
		else 
		{
			$pdf_obj->stream($name);//下载
		}//if end
	}
	
}