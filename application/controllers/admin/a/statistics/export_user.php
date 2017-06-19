<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		C端订单导出
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Export_user extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
//		$this ->load_model('order_model');
	}
	
	public function index()
	{
		$data = array(
				'starttime' =>date('Y-m-01',time()),
				'endtime' =>date('Y-m-t',time())
		);
		$this ->view('admin/a/statistics/export_user' ,$data);
	}
        
        /**
         * 获取注册用户数据
         */
        public function get_user_data(){
            $starttime = trim($this ->input ->get_post('starttime' ,true));
            $endtime = trim($this ->input ->get_post('endtime' ,true));
            $data = $this->getUserData($starttime, $endtime);
            echo json_encode($data);
        }
        
        /**
         * 获取注册用户数据
         * 私有方法
         */
        private function getUserData($starttime, $endtime)
	{
		if (!empty($starttime))
		{
			$whereArr['mo.usedate >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['mo.usedate <='] = $endtime;
		}
                $sql = "SELECT w.flownums, CASE w.status WHEN 1 THEN '已激活' ELSE '未激活' END AS activate_status, CASE w.utype WHEN 1 THEN '直推人' ELSE '普通用户' END AS user_type,m.loginname,m.nickname,m.truename,m.mobile,m.email,m.jointime,m.register_channel
                    FROM u_member AS m
                    LEFT JOIN wx_flow_activity_member AS w ON(w.member_id=m.mid)
                    WHERE m.jointime>'{$starttime}' AND m.jointime<'{$endtime}'
                    ORDER BY w.`status` DESC,w.utype DESC";
                $query = $this->db->query($sql);
                $data['count'] = $query->num_rows();
                $data['data'] = $query->result_array();
                return $data;
	}
	
        
	
	//导出excel
	public function exportExcel()
	{
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		
		if (empty($starttime) || empty($endtime))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择用户注册日期');
		}
		
		$data = $this->getUserData($starttime, $endtime);
		
		//生成excel
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'G' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'H' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'I' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'J' )->setWidth ( 15 );
		
		$objActSheet->setCellValue ( "A1", '流量' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'B1', '激活状态' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'C1', '用户类型' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'D1', '账号' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'E1', '昵称' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'F1', '真实姓名' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'G1', '手机号码' );
		$objActSheet->getStyle ( 'G1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'H1', '邮箱' );
		$objActSheet->getStyle ( 'H1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'I1', '注册时间' );
		$objActSheet->getStyle ( 'I1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'J1', '渠道' );
		$objActSheet->getStyle ( 'J1' )->applyFromArray ($style_array);
		
		if (! empty ( $data )) {
			$i = 0;
			foreach ( $data['data'] as $val ) {
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['flownums'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $val['activate_status'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $val['user_type'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $val['loginname'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), $val['nickname'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $val['truename'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $val['mobile'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'H' . ($i + 2), $val['email'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'H' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'I' . ($i + 2), $val['jointime'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'I' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'J' . ($i + 2), $val['register_channel'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'J' . ($i + 2) )->applyFromArray ($one_style_array);
				$i ++;
			}
		}
		
		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file = "file/b2/upload/" . $g_session . ".xlsx";
		$objWriter->save ( $file );
		$this ->callback ->setJsonCode(2000 ,'/'.$file);
		
		
	}
}