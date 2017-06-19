<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Insurance_order extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->database();
		$this->load->model ( 'admin/a/insure_model','insure_model');
	}
	public function index()
	{
	           $page = $this->getPage ();
	   	$param['starttime']=date("Y-m-d",strtotime("+1 day"));
		$data['pageData'] = $this->insure_model->get_insure_order($param,$page);
   		//echo $this->db->last_query();
		$this ->load_view('admin/a/ui/insurance/insurance_order' ,$data);
	}
	/*分页查询*/
	public function indexData(){
		$param = $this->getParam(array('if_insurance','is_buy','line_name','ordersn','starttime'));
	
		$page = $this->getPage ();
		$data = $this->insure_model->get_insure_order( $param,$page );
		//echo $this->db->last_query();
		echo  $data ;
	}
	//编辑出游人
	function order_people(){
		$id=$this->input->post('id',true);
		if($id>0){
			$data=$this->insure_model->select_rowData('u_member_traver',array('id'=>$id));
			if(!empty($data)){
				echo json_encode(array('status'=>1,'travel'=>$data));
			}else{
			 	echo json_encode(array('status'=>-1,'msg'=>'没有该条记录!'));
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败!'));
		}
	}
	//导出订单保险信息
	function derive_orderData(){
		 
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		
		$param = $this->getParam(array('if_insurance','line_name','ordersn','starttime','is_buy'));
		 
		//订单保险数据
		$order_insure=$this->insure_model->derive_insurance_order($param);

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
		 
		$objActSheet->setCellValue("A1",'线路名称');
		$objActSheet->getStyle('A1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ) ) );
		 
		$objActSheet->setCellValue('B1', '出团日期');
		$objActSheet->getStyle('B1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		 
		$objActSheet->setCellValue('C1', '姓名');
		$objActSheet->getStyle('C1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		 
		$objActSheet->setCellValue('D1', '性别');
		$objActSheet->getStyle('D1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		 
		$objActSheet->setCellValue('E1', '出生日期');
		$objActSheet->getStyle('E1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
		$objActSheet->setCellValue('F1', '手机号码');
		$objActSheet->getStyle('F1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		$objActSheet->setCellValue('G1', '证件类型');
		$objActSheet->getStyle('G1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		$objActSheet->setCellValue('H1', '证件号码');
		$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		$objActSheet->setCellValue('I1', '保险名称');
		$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		if(!empty($order_insure)){
			$i=0;
			foreach ($order_insure as $key => $value) {
				if($value['sex']==0){
				      $sex='女';
				}else if($value['sex']==1){
					  $sex='男';
				}else{
					$sex='';
				}
				if($value['name']!=''){
					$name=$value['name'];
				}else{
					$name=$value['enname'];
				}
				$objActSheet->setCellValueExplicit('A'.($i+2),$value['productname'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('A'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				 
				$objActSheet->setCellValueExplicit('B'.($i+2),$value['usedate'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('B'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				 
				$objActSheet->setCellValueExplicit('C'.($i+2), $name,PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('C'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				 
				$objActSheet->setCellValueExplicit('D'.($i+2), $sex,PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('D'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					
				$objActSheet->setCellValueExplicit('E'.($i+2), $value['birthday'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('E'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$objActSheet->setCellValueExplicit('F'.($i+2), $value['telephone'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('F'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->setCellValueExplicit('G'.($i+2), $value['certificate'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('G'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->setCellValueExplicit('H'.($i+2), $value['certificate_no'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('G'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->setCellValueExplicit('I'.($i+2), $value['insurance_name'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('G'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				$i++;
			}
		}
	
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		list($ms, $s) = explode(' ',microtime());
		$ms = sprintf("%03d",$ms*1000);
		$g_session = date('YmdHis')."_".$ms."_".rand(1000, 9999);
		$file="file/a/upload/insurance".$g_session.".xlsx";
		$objWriter->save($file);
		echo json_encode($file);
		if(!empty($objWriter)){
			//修改导出保险的状态
			foreach ($order_insure as $k=>$v){
				$where['traver_id']=$v['id'];
				$where['insurance_id']=$v['insurance_id'];
				//$this->db->where($where)->update('u_insurance_traver', array('is_down'=>1));
				$this->insure_model->update_rowdata('u_insurance_traver',array('is_down'=>1),$where);
			}
		}
	}
}
