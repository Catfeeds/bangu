<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Contract_pdf extends MY_Controller
{
	public function __construct()
	{
		parent::__construct ();  
		$this->load->model ( 'member_model' );
		$this->load->library ( 'callback' );
	}  

	public function createHtmlPdf($html ,$fileData,$filename='旅游合同.pdf' ,$expertData=array())
	{
		$this->load->library('pdf');
		
		
		//require_once('tcpdf_include.php');
		
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 042');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 042', PDF_HEADER_STRING);
		
		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		
// 		// set default monospaced font
// 		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
// 		// set margins
// 		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// 		$pdf->SetHeaderMargin(2);
// 		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
// 		// set auto page breaks
// 		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
// 		// set image scale factor
// 		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// set some language-dependent strings (optional)
// 		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
// 			require_once(dirname(__FILE__).'/lang/eng.php');
// 			$pdf->setLanguageArray($l);
// 		}
		
		
		
		
		
		
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		
		// ---------------------------------------------------------
		
		// set JPEG quality
		//$pdf->setJPEGQuality(75);
		
		$pdf->SetFont('stsongstdlight', '', 12);
		
		// add a page
		$pdf->AddPage();
		
		//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		
		// create background text
		//$background_text = str_repeat('TCPDF test PNG Alpha Channel ', 50);
	
		$pdf->writeHTML($html, true, false, true, false, '');
		
// 		if (file_exists('./file/back.png'))
// 		{
// 			$pdf->Image('./file/back.png', 100, 0, 80, 40, 'png', 'xxx', '', true, 150, '', false, false, 0, false, false, false);
// 		}
		
		// create columns content
		$left_column = '<div>旅游者代表签字：</div><div>签约代表签字：</div><div>证件号码：</div><div></div>';
		$right_column = '<div>旅行社盖章：</div><div>帮游网盖章：</div><div>签字：</div><div>日期： '.date('Y-m-d' ,strtotime($fileData['gs_time'])).'</dt><dt><img src="" /></div>';
		
		
		// get current vertical position
		$y = $pdf->getY();
		
		// set color for background
		$pdf->SetFillColor(255, 255, 255);
		
		// set color for text
// 		$pdf->SetTextColor(0, 63, 127);
		// write the first column
		$pdf->writeHTMLCell(94, '', '', $y, $left_column, 0,0, 0, true, 'J', true);
		// set color for background
		$pdf->SetFillColor(255, 255, 255);
		// set color for text
// 		$pdf->SetTextColor(127, 31, 0);
		// write the second column
		$pdf->writeHTMLCell(94, '', '', '', $right_column, 0, 10, 0, true, 'J', true);
		
		if (file_exists('.'.$fileData['union_sign']))
		{
			$suffix = substr($fileData['union_sign'] ,strrpos($fileData['union_sign'] ,'.')+1);
			//echo $suffix;
			$pdf->Image('.'.$fileData['union_sign'], 120, 200, 30, 30, $suffix, 'xxx', '', true, 150, '', false, false, 0, false, false, false);
		}
		//exit;
		if (file_exists('.'.$expertData['sign_pic']))
		{
			$pdf->Image('.'.$expertData['sign_pic'], 140, 230, 30, 20, 'png', 'xxx', '', true, 150, '', false, false, 0, false, false, false);
		}
		if (file_exists('.'.$fileData['guest_sign']))
		{
			$pdf->Image('.'.$fileData['guest_sign'], 40, 200, 50, 30, 'png', 'xxx', '', true, 150, '', false, false, 0, false, false, false);
		}
		// reset pointer to the last page
// 		$right_column = '<div>帮游网盖章：</div><div>签字：</div><div>日期： </dt><dt></div>';
// 		$pdf->writeHTMLCell(94, '', '', $y+43, $right_column, 0, 10, 0, true, 'J', true);
		
		if (file_exists('.'.$fileData['bangu_sign'])) 
		{
			$suffix = substr($fileData['bangu_sign'] ,strrpos($fileData['bangu_sign'] ,'.')+1);
			$pdf->Image('.'.$fileData['bangu_sign'], 150, 200, 30, 30, $suffix, 'xxx', '', true, 150, '', false, false, 0, false, false, false);
		}
		
		$pdf->lastPage();
		$pdf->Output('contract.pdf', 'D'); //D下载
		
		
		
	}
	
	/**
	 * @method 生成合同PDF版
	 * @author jkr
	 */
	public function createContractPdf()
	{
		$this ->load_model('admin/t33/b_contract_launch_model' ,'contract_model');
		$contractId = intval($this ->input ->get('id'));
		//$contractId = 8;
		//获取合同
		$contractData = $this ->contract_model ->row(array('id' =>$contractId));
		if (empty($contractData))
		{
			$this ->callback ->setJsonCode(4000 ,'合同不存在');
		}
// 		if ($contractData['status'] != 2 && $contractData['status'] != 3)
// 		{
// 			$this ->callback ->setJsonCode(4000 ,'合同未签署或已作废');
// 		}
		
		//获取合同内容
		if ($contractData['type'] == 1)
		{
			//出境游合同
			$detailArr = $this ->contract_model ->getAbroadContract($contractData['contract_code']);
			$filename = '出境旅游合同.pdf';
		}
		else
		{
			//国内游合同
			$detailArr = $this ->contract_model ->getDomesticContract($contractData['contract_code']);
			$filename = '国内旅游合同.pdf';
		}
		
		$expertData= $this ->db ->where('id' ,$contractData['expert_id']) ->get('u_expert') ->row_array();
			
		$time = strtotime($detailArr['start_time']);
		$detailArr['start_year'] = date('Y' ,$time);
		$detailArr['start_month'] = date('m' ,$time);
		$detailArr['start_day'] = date('d' ,$time);
			
		$hour = date('H:i:s' ,$time);
		if ($hour == '23:59:59') {
			$detailArr['start_time'] = 24;
		} else {
			$detailArr['start_time'] = date('H' ,$time);
		}
			
			
		$time = strtotime($detailArr['end_time']);
		$detailArr['end_year'] = date('Y' ,$time);
		$detailArr['end_month'] = date('m' ,$time);
		$detailArr['end_day'] = date('d' ,$time);
			
		$hour = date('H:i:s' ,$time);
		if ($hour == '23:59:59') {
			$detailArr['end_time'] = 24;
		} else {
			$detailArr['end_time'] = date('H' ,$time);
		}
		$detailArr['pay_time'] = date('Y-m-d' ,strtotime($detailArr['pay_time']));
			
		$fileData = $this ->contract_model ->getContractFile($contractData['id']);
		
		if (!empty($fileData)) {
			if (file_exists(BANGU_URL.$fileData['guest_sign'])) {
				$fileData['str'] = file_get_contents(BANGU_URL.$fileData['guest_sign']);
			} else {
				$fileData['str'] = '';
				//$fileData['str'] = file_get_contents('../bangu'.$fileData['guest_sign']);
			}
		}
		
		//获取模板contract-template
		$template = file_get_contents('./file/contract-template/domestic_contract.html');
		
		//替换变量
		$template = str_replace('{#code#}', $contractData['contract_code'] , $template);
		$template = str_replace('{#travelman#}',$detailArr['travelman'], $template);
		$template = str_replace('{#travelnum#}',$detailArr['travelnum'], $template);
		$template = str_replace('{#travel_agency#}',$detailArr['travel_agency'], $template);
		$template = str_replace('{#business_code#}',$detailArr['business_code'], $template);
		$template = str_replace('{#start_year#}',$detailArr['start_year'], $template);
		$template = str_replace('{#start_month#}',$detailArr['start_month'], $template);
		$template = str_replace('{#start_day#}',$detailArr['start_day'], $template);
		$template = str_replace('{#start_time#}',$detailArr['start_time'], $template);
		$template = str_replace('{#end_year#}',$detailArr['end_year'], $template);
		$template = str_replace('{#end_month#}',$detailArr['end_month'], $template);
		$template = str_replace('{#end_day#}',$detailArr['end_day'], $template);
		$template = str_replace('{#end_time#}',$detailArr['end_time'], $template);
		$template = str_replace('{#days#}',$detailArr['days'], $template);
		$template = str_replace('{#nights#}',$detailArr['nights'], $template);
		$template = str_replace('{#adultprice#}',$detailArr['adultprice'], $template);
		$template = str_replace('{#childprice#}',$detailArr['childprice'], $template);
		$template = str_replace('{#serverprice#}',$detailArr['serverprice'], $template);
		$template = str_replace('{#total_travel#}',$detailArr['total_travel'], $template);
		$template = str_replace('{#pay_way#}',$detailArr['pay_way'], $template);
		$template = str_replace('{#pay_time#}',$detailArr['pay_time'], $template);
		if ($detailArr['is_buy'] == 1) {
			$template = str_replace('{#is_buy1#}','checked="checked"', $template);
			$template = str_replace('{#is_buy2#}','', $template);
			$template = str_replace('{#is_buy3#}','', $template);
		} elseif ($detailArr['is_buy'] == 2) {
			$template = str_replace('{#is_buy2#}','checked="checked"', $template);
			$template = str_replace('{#is_buy1#}','', $template);
			$template = str_replace('{#is_buy3#}','', $template);
		} else {
			$template = str_replace('{#is_buy3#}','checked="checked"', $template);
			$template = str_replace('{#is_buy2#}','', $template);
			$template = str_replace('{#is_buy1#}','', $template);
		}
		
		$template = str_replace('{#insurance_name#}',$detailArr['insurance_name'], $template);
		$template = str_replace('{#min_num#}',$detailArr['min_num'], $template);
		$template = str_replace('{#is_agree_contract#}',$detailArr['is_agree_contract'], $template);
		$template = str_replace('{#is_agree_delay#}',$detailArr['is_agree_delay'], $template);
		$template = str_replace('{#is_agree_change#}',$detailArr['is_agree_change'], $template);
		$template = str_replace('{#is_agree_relieve#}',$detailArr['is_agree_relieve'], $template);
		$template = str_replace('{#is_agree_group#}',$detailArr['is_agree_group'], $template);
		$template = str_replace('{#group_travel#}',$detailArr['group_travel'], $template);
		$template = str_replace('{#other_matter#}',$detailArr['other_matter'], $template);
		$template = str_replace('{#mutual_copie#}',$detailArr['mutual_copie'], $template);
		$template = str_replace('{#copie#}',$detailArr['copie'], $template);
		$template = str_replace('{#travel_agency#}',$detailArr['travel_agency'], $template);
		$template = str_replace('{#union_sign#}',$fileData['union_sign'], $template);
		$template = str_replace('{#bangu_sign#}',$fileData['bangu_sign'], $template);
		$template = str_replace('{#guest_sign#}',$fileData['guest_sign'], $template);
		
		
		$this ->createHtmlPdf($template ,$fileData,$filename ,$expertData);
		
// 		return $template;
 		//echo $template;
// 	  	exit;
	}
}