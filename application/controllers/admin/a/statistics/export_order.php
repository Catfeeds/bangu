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
class Export_order extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('order_model');
	}
	
	public function index()
	{
		$data = array(
				'starttime' =>date('Y-m-01',time()),
				'endtime' =>date('Y-m-t',time())
		);
		$this ->view('admin/a/statistics/export_order' ,$data);
	}
	
	public function getOrderData()
	{
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		
		$whereArr = array(
				'mo.user_type =' =>0,
				's.id !=' =>299
		);
		
		if (!empty($starttime))
		{
			$whereArr['mo.usedate >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['mo.usedate <='] = $endtime;
		}
		
		$data = $this ->order_model ->getExportOrderData($whereArr);
		echo json_encode($data);
	}
	
	//导出excel
	public function exportExcel()
	{
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		
		if (empty($starttime) || empty($endtime))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择出团日期');
		}
		
		
		$whereArr = array(
				'mo.user_type =' =>0,
				's.id !=' =>299,
				'mo.usedate >=' =>$starttime,
				'mo.usedate <=' =>$endtime
		);
		
		
		$data = $this ->order_model ->getExportOrderData($whereArr ,'mo.id desc' ,'all');
		
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
		$objActSheet->getColumnDimension ( 'K' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'L' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'M' )->setWidth ( 40 );
		$objActSheet->getColumnDimension ( 'N' )->setWidth ( 70 );
		
		$objActSheet->setCellValue ( "A1", '订单编号' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'B1', '出团日期' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'C1', '出发城市' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'D1', '订单金额' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'E1', '保险金额' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'F1', '管家佣金' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'G1', '平台佣金' );
		$objActSheet->getStyle ( 'G1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'H1', '供应商结算金额' );
		$objActSheet->getStyle ( 'H1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'I1', '人数' );
		$objActSheet->getStyle ( 'I1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'J1', '订单状态' );
		$objActSheet->getStyle ( 'J1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'K1', '管家' );
		$objActSheet->getStyle ( 'K1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'L1', '审核人' );
		$objActSheet->getStyle ( 'L1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'M1', '供应商' );
		$objActSheet->getStyle ( 'M1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'N1', '线路名称' );
		$objActSheet->getStyle ( 'N1' )->applyFromArray ($style_array);
		
		
		if (! empty ( $data )) {
			$i = 0;
			foreach ( $data as $key => $val ) {
				
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['ordersn'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $val['usedate'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $val['cityname'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $val['total_price'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), $val['settlement_price'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $val['agent_fee'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $val['platform_fee'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'H' . ($i + 2), $val['settlement_fee'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'H' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'I' . ($i + 2), $val['num'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'I' . ($i + 2) )->applyFromArray ($one_style_array);
				
				if ($val['status'] == -4) {
					$status = $val['ispay'] == 0 ? '已取消' : '已退团';
				} elseif($val['status'] == -3) {
					$status = '退订中';
				} elseif ($val['status'] == 0) {
					if ($val['ispay'] == 0) {
						$status = '未付款';
					} elseif ($val['ispay'] == 1) {
						$status = '付款审核中';
					} elseif ($val['ispay'] == 2) {
						$status = '已付款待确认';
					} else{
						$status = '未知';
					}
				} elseif ($val['status'] == 4) {
					$status = '已确认';
				} elseif ($val['status'] == 5) {
					$status = '出团中';
				} elseif ($val['status'] == 6) {
					$status = '已评论';
				} elseif ($val['status'] == 7) {
					$status = '已投诉';
				} elseif ($val['status'] == 8) {
					$status = '出团结束';
				} else {
					$status = '未知';
				}
				$objActSheet->setCellValueExplicit ( 'J' . ($i + 2), $status, PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'J' . ($i + 2) )->applyFromArray ($one_style_array);
				
				$objActSheet->setCellValueExplicit ( 'K' . ($i + 2), $val['expert_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'K' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'L' . ($i + 2), $val['admin_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'L' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'M' . ($i + 2), $val['supplier_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'M' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'N' . ($i + 2), $val['linename'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'N' . ($i + 2) )->applyFromArray ($one_style_array);
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