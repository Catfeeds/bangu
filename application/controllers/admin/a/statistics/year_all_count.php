<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		全年营销统计
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Year_all_count extends UA_Controller
{
	public $pagesize = 10;
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
		$departAll = $this ->depart_model ->getDepartTop();
		
		$departArr = array();
		
		foreach($departAll as $val)
		{
			if (!array_key_exists($val['union_id'], $departArr))
			{
				$departArr[$val['union_id']] = array(
						'union_name' =>$val['union_name']
				);
			}
			$departArr[$val['union_id']]['depart'][] = array(
					'depart_id' =>$val['depart_id'],
					'depart_name' =>$val['depart_name']
			);
		}
		//var_dump($departArr);
		$dataArr = array(
				'departArr' =>$departArr
		);
		$this ->view('admin/a/statistics/year_all_count' ,$dataArr);
	}
	
	public function year_all_detail()
	{
		$year = intval($this ->input ->get('year'));
		$ids = trim($this ->input ->get('ids' ,true));
		
		$data = array(
				'dataArr' =>$this ->getCountData($year, $ids),
				'year' =>$year,
				'ids' =>$ids
		);
		
		$this ->view('admin/a/statistics/year_all_detail' ,$data);
	}
	
	//导出excel
	public function exportExcel()
	{
		$year = intval($this ->input ->post('year'));
		$ids = trim($this ->input ->post('ids' ,true));
		
		//获取销售数据
		$data = $this ->getCountData($year, $ids);
		
		//生成excel
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 35 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 20 );
		
		$objActSheet->setCellValue ( "A1", '营业部' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'B1', '成团人数' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'C1', '营业额' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		
		var_dump($data);exit;
		if (! empty ( $data )) {
			$i = 1;
			foreach ( $data as $key => $val ) {
				++$i;
				$objActSheet->setCellValueExplicit ( 'A' . $i, $val['depart_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'A' . $i )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'B' . $i, $val['num'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'B' . $i )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'C' . $i, $val['price'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'C' . $i )->applyFromArray ($one_style_array);
				
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
	
	public function getCountData ($year ,$ids) 
	{
		$nextYear = $year+1;
		
		$whereStr = '';
		if (!empty($ids))
		{
			$whereStr = ' and (';
			$idArr = explode(',', trim($ids ,','));
			foreach($idArr as $v)
			{
				$whereStr .= ' mo.depart_id='.$v.' or d.pid ='.$v.' or';
			}
			$whereStr = rtrim($whereStr ,'or').') ';
		}
		
		$sql = 'select d.name as depart_name,d.id as depart_id,d.pid,';
		$sql .= "sum(case when usedate>='{$year}' and usedate<'{$nextYear}' then dingnum+childnobednum+childnum+oldnum end) as num,";
		$sql .= "sum(case when usedate>='{$year}' and usedate<'{$nextYear}' then mo.total_price end) as price ";
		$sql .= 'from u_member_order as mo left join b_depart as d on d.id=mo.depart_id ';
		$sql .= 'where mo.status>=4 and mo.status<=8 and mo.depart_id>0 '.$whereStr.' group by d.id order by d.pid asc';
		
		//echo $sql;
		$yearData = $this ->db ->query($sql) ->result_array();
		
		$dataArr = array();
		
		foreach($yearData as $k=>$v)
		{
			if ($v['pid'] == 0) {
				$dataArr[$v['depart_id']] = $v;
			} else {
				if (array_key_exists($v['pid'], $dataArr)) {
					$dataArr[$v['pid']]['num'] = round($dataArr[$v['pid']]['num']+$v['num']);
					$dataArr[$v['pid']]['price'] = round($dataArr[$v['pid']]['price']+$v['price'] ,2);
				}
			}
		}
		return $dataArr;
	}
	
}