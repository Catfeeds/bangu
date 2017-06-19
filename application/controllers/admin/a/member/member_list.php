<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @method 		会员列表
 */
if (! defined ( 'BASEPATH' ))
exit ( 'No direct script access allowed' );

class Member_list extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/member_model', 'member_model' );
	}
	//会员列表
	public function index()
	{
		$data['pageData']=$this->member_model->get_member_data(array(),$this->getPage ());
	//	echo $this->db->last_query();
		$this->load_view ('admin/a/ui/member/member_list',$data);
	}
	//会员列表的分页
	 function memberData(){
	 	$param = $this->getParam(array('loginname','mobile','member_name' ,'city' ,'province' ,'register_channel'));
	 	$data = $this->member_model->get_member_data( $param , $this->getPage ());
	 	echo  $data ;
	 } 
	 //导出会员信息
	 function derive_memberData(){
	 	
	 	$this->load->library('PHPExcel');
	 	$this->load->library('PHPExcel/IOFactory');
	 	$param = $this->getParam(array('loginname','mobile','member_name'));
	 	
	 	//会员数据
	 	$member=$this->member_model->derive_member_data($param);
	 	
	 	$objPHPExcel = new PHPExcel();
	 	$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
	 	$objPHPExcel->setActiveSheetIndex(0);
	 	
	 	$objActSheet = $objPHPExcel->getActiveSheet ();
	 	$objActSheet->getColumnDimension('A')->setWidth(5);
	 	$objActSheet->getColumnDimension('B')->setWidth(15);
	 	$objActSheet->getColumnDimension('C')->setWidth(15);
	 	$objActSheet->getColumnDimension('D')->setWidth(20);
	 	$objActSheet->getColumnDimension('E')->setWidth(20);
	 	$objActSheet->getColumnDimension('F')->setWidth(20);
	 	
	 	$objActSheet->setCellValue("A1",'注册账号');
	 	$objActSheet->getStyle('A1')->applyFromArray(array( 'font' => array( 'bold' => true),
	 			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ) ) );
	 	
	 	$objActSheet->setCellValue('B1', '昵称');
	 	$objActSheet->getStyle('B1')->applyFromArray(array( 'font' => array( 'bold' => true),
	 			'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 	
	 	$objActSheet->setCellValue('C1', '真实姓名');
	 	$objActSheet->getStyle('C1')->applyFromArray(array( 'font' => array( 'bold' => true),
	 			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 	
	 	$objActSheet->setCellValue('D1', '手机号码');
	 	$objActSheet->getStyle('D1')->applyFromArray(array( 'font' => array( 'bold' => true),
	 			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 	
	 	$objActSheet->setCellValue('E1', '邮箱号');
	 	$objActSheet->getStyle('E1')->applyFromArray(array( 'font' => array( 'bold' => true),
	 			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 		
	 	$objActSheet->setCellValue('F1', '注册时间');
	 	$objActSheet->getStyle('F1')->applyFromArray(array( 'font' => array( 'bold' => true),
	 			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 		
	 	if(!empty($member)){
	 		$i=0;
	 		foreach ($member as $key => $value) {
	 	
	 			$objActSheet->setCellValueExplicit('A'.($i+2),$value['loginname'],PHPExcel_Cell_DataType::TYPE_STRING);
	 			$objActSheet->getStyle('A'.($i+2))->applyFromArray(array(
	 					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 	
	 			$objActSheet->setCellValueExplicit('B'.($i+2),$value['nickname'],PHPExcel_Cell_DataType::TYPE_STRING);
	 			$objActSheet->getStyle('B'.($i+2))->applyFromArray(array(
	 					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 	
	 			$objActSheet->setCellValueExplicit('C'.($i+2), $value['truename'],PHPExcel_Cell_DataType::TYPE_STRING);
	 			$objActSheet->getStyle('C'.($i+2))->applyFromArray(array(
	 					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 	
	 			$objActSheet->setCellValueExplicit('D'.($i+2), $value['mobile'],PHPExcel_Cell_DataType::TYPE_STRING);
	 			$objActSheet->getStyle('D'.($i+2))->applyFromArray(array(
	 					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 			
	 			$objActSheet->setCellValueExplicit('E'.($i+2), $value['email'],PHPExcel_Cell_DataType::TYPE_STRING);
	 			$objActSheet->getStyle('E'.($i+2))->applyFromArray(array(
	 					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	 				
	 			$objActSheet->setCellValueExplicit('F'.($i+2), $value['jointime'],PHPExcel_Cell_DataType::TYPE_STRING);
	 			$objActSheet->getStyle('F'.($i+2))->applyFromArray(array(
	 					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
 				
	 			$i++;
	 		}
	 	}

	 	$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
	 	list($ms, $s) = explode(' ',microtime());
	 	$ms = sprintf("%03d",$ms*1000);
	 	$g_session = date('YmdHis')."_".$ms."_".rand(1000, 9999);
	 	$file="file/a/upload/member".$g_session.".xlsx";
	 	$objWriter->save($file);
	 	echo json_encode($file);
	 }
	 
}
