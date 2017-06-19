<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		jiakairong
 * @method 供应商导出
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supplier_export extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'supplier_model');
	}
	public function index()
	{
		$this->view ( 'admin/a/statistics/supplier_export');
	}
	//获取供应商数据
	public function getSupplierData()
	{
		$whereArr = array();
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$country = intval($this ->input ->post('country'));
		
		//所在地搜索
		if ($city)
		{
			$whereArr ['s.city='] = $city;
		}
		elseif ($province)
		{
			$whereArr ['s.province='] = $province;
		}
		elseif ($country)
		{
			$whereArr ['s.country='] = $country;
		}
		$data = $this ->supplier_model ->getSupplierExport ($whereArr ,'(s.status=2 or cs.status=1)');
		echo json_encode($data);
	}
	
	//导出excel
	public function exportExcel()
	{
		$whereArr = array(
				'or' =>array(
						's.status =' =>2,
						'cs.status =' =>1
				)
		);
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$country = intval($this ->input ->post('country'));
		
		//所在地搜索
		if ($city)
		{
			$whereArr ['s.city='] = $city;
		}
		elseif ($province)
		{
			$whereArr ['s.province='] = $province;
		}
		elseif ($country)
		{
			$whereArr ['s.country='] = $country;
		}
		$data = $this ->supplier_model ->getSupplierExportAll ($whereArr);
	
		//生成excel
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
	
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 45 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 45 );
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 30 );
		$objActSheet->getColumnDimension ( 'G' )->setWidth ( 40 );
	
		$objActSheet->setCellValue ( "A1", '供应商名称' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'B1', '品牌名称' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'C1', '主营业务' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'D1', '负责人' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'E1', '负责人电话' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'F1', '所在地' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'G1', '所属联盟' );
		$objActSheet->getStyle ( 'G1' )->applyFromArray ($style_array);
	
	
		if (! empty ( $data )) {
			$i = 0;
			foreach ( $data as $key => $val ) {
				$address = $val['country_name'].$val['province_name'].$val['city_name'];
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['company_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $val['brand'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $val['expert_business'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $val['realname'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), $val['mobile'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $address, PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $val['union_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ($one_style_array);
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