<?php
/**
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Order_people extends UC_NL_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'order_model', 'order');
		$this->load_model( 'member_model', 'member');
		$this->load_model ( 'line_model', 'line_model' );
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
	}
             //导入游客
	function index(){
		if(!file_exists("./file/c/people")){
			mkdir("./file/c/people",0777,true);//原图路径
		}

		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$this->load->helper ( 'url' );
		$this->load->helper ( array('form', 'url'));
		$order_id = $this->input->post ( 'excel_order_id' );
		$number = $this->input->post ( 'number' ); //出游人数
		$linetype = $this->input->post ( 'linetype' ); //1,境外 2.境内
		$config['upload_path'] = './file/c/people/';
		$config['allowed_types'] = 'xls|xlsx|docx|pptx|xlsm';
		$config['max_size'] = '40000';
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file_name = $g_session . '.xlsx';
		$config['file_name'] = $file_name;
		
		//var_dump($_FILES);exit;
		$suffix = substr($_FILES['upfile']['name'],strrpos($_FILES['upfile']['name'] ,'.')+1);
		if (stripos($config['allowed_types'] ,$suffix) === false) {
			echo json_encode(array('code' => -1,'msg' =>'请上传xls|xlsx|docx|pptx|xlsm类型的文件'));
			exit;
		}

		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		$upload_status = $this->upload->do_upload ( 'upfile' );

		if (!$upload_status) {
			echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
		             exit;
		}else{

			$file_info = array( 'upload_data' => $this->upload->data () );
			$file_path = './file/c/people/' . $file_info['upload_data']['file_name'];
			
			$objReader = IOFactory::createReader ( 'Excel2007' );
			
			$PHPExcel = $objReader->load ( $file_path );
			$sheet = $PHPExcel->getSheet ( 0 ); // 读取第一個工作表
			$highestRow = $sheet->getHighestRow (); // 取得总行数
			$highestColumm = $sheet->getHighestColumn (); // 取得总列数

			if (($highestRow-1) <= $number) {
			             $mun=$highestRow-1;
				for($row = 2; $row <= $highestRow; $row ++) { // 行数是以第1行开始,但是只取从第二行开始的数据
					if($linetype==1){  //境外
					             $insert_data = array(
							'name' => $sheet->getCell ( 'A' . $row )->getValue (),
							'enname' => $sheet->getCell ( 'B' . $row )->getValue (),
							'sex' => $sheet->getCell ( 'C' . $row )->getValue (),
							'card_type' => $sheet->getCell ( 'D' . $row )->getValue (),
							'card_num' => $sheet->getCell ( 'E' . $row )->getValue (),
							'birthday' => gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell ( 'F' . $row )->getValue ())),
							//'birthday' => $sheet->getCell ( 'F' . $row )->getValue (),
							'sign_place'=> $sheet->getCell ( 'G' . $row )->getValue (),
							'sign_time'=> gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell ( 'H' . $row )->getValue ())),
							'endtime' => gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell ( 'I' . $row )->getValue ())),
							'phone_number' => $sheet->getCell ( 'J' . $row )->getValue (),

					             );
					}else{   //境内
						$insert_data = array(
							'name' => $sheet->getCell ( 'A' . $row )->getValue (),
							'sex' => $sheet->getCell ( 'B' . $row )->getValue (),
							'card_type' => $sheet->getCell ( 'C' . $row )->getValue (),
							'card_num' => $sheet->getCell ( 'D' . $row )->getValue (),
							//'birthday' =>gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell ( 'E' . $row )->getValue ())),
							'birthday' =>$sheet->getCell ( 'E' . $row )->getValue (),
							'tel' => $sheet->getCell ( 'F' . $row )->getValue (),
					             );
					}
					$people[]=$insert_data;	
				}
		
				echo json_encode(array('code' => 200,'people' =>$people,'mun'=>$mun));
			             exit;
			} else {
				echo json_encode(array('code' => -1,'msg' =>'添加的人数超过出行人数上限了'));
			             exit;
			}
	    	}
	}
}