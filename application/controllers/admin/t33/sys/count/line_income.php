<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		线路收入统计
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_income extends T33_Controller
{
	public $pagesize = 10;
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->library ( 'callback' );
	}
	public function index($excel='')
	{
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee = $this->b_employee_model->row(array('id'=>$employee_id));
			$unionId = $employee['union_id'];
			
			$starttime = empty($_REQUEST['starttime']) ? '' : trim($_REQUEST['starttime']);
			$endtime = empty($_REQUEST['endtime']) ? '' : trim($_REQUEST['endtime']);
			$linename = trim($this ->input ->get('linename' ,true));
			$linecode = trim($this ->input ->get('linecode' ,true));
			
			$by_time = empty($_REQUEST['by_time']) ? 'total' : intval($_REQUEST['by_time']); //排序时间段，默认总计排序
			$by_type = empty($_REQUEST['by_type']) ? 'desc' : trim($_REQUEST['by_type']);//排序方式 desc asc
			
			$like = '';
			if (!empty($linename))
			{
				$like = " and l.linename like '%{$linename}%'";
			}
			if (!empty($linecode))
			{
				$like = " and l.linecode like '%{$linecode}%'";
			}
			
			//var_dump($page);exit;
			$sql = 'SELECT ';
			//当前月
			$nowMonth = date('Y-m' ,time());
			if (empty($endtime)) {
				$endtime = $nowMonth;
			}
		
			if (empty($starttime)) {
				$starttime = date('Y-m' ,strtotime("-5 month" ,strtotime($endtime)));
			}
				
			if ($starttime > $endtime)
			{
				$time = $endtime;
				$endtime = $starttime;
				$starttime = $time;
			}
				
			$monthArr = array(1=>'01',2=>'02',3=>'03',4=>'04',5=>'05',6=>'06',7=>'07',8=>'08',9=>'09',10=>'10',11=>'11',12=>'12');
				
			//表格title
			$titleArr = array();
				
			$startMonth = ltrim(date('m' ,strtotime($starttime)),'0');
			$endMonth = ltrim(date('m' ,strtotime($endtime)),'0');
			$endYear = date('Y',strtotime($endtime));
			$startYear = date('Y',strtotime($starttime));
			//开始年和结束年的差值
			$yearDifference = $endYear - $startYear;
			if ($yearDifference == 0)
			{
				//开始和结束月份在同一年
		
				$infoArr = $this ->getTypeMonthSql($startMonth, $endMonth, $startYear);
				$titleArr = $infoArr['titleArr'];
				$sql .= $infoArr['sql'];
			}
			else
			{
				//开始和结束跨越了年份
		
				$infoArr = $this ->getTypeMonthSql($startMonth, 12, $startYear);
				$titleArr = $infoArr['titleArr'];
				$sql .= $infoArr['sql'];
		
				$year = $startYear;
				if ($yearDifference >1) {
					$i = 1;
					for($i ;$i <$yearDifference ;$i++)
					{
						$year++;
						$infoArr = $this ->getTypeMonthSql(1, 12, $year);
						$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
						$sql .= $infoArr['sql'];
					}
				}
		
				$infoArr = $this ->getTypeMonthSql(1, $endMonth, $endYear);
				$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
				$sql .= $infoArr['sql'];
			}
			$sql .= 'SUM(CASE WHEN usedate>="'.$starttime.'-01" AND usedate<="'.$endtime.'-31" THEN total_price ELSE 0 END) AS total,';
			
			$sql .= ' l.linename,l.linecode from u_member_order as mo left join u_line as l on l.id=mo.productautoid ';
			$sql .= ' where mo.status >=4 and mo.status <=8 and mo.platform_id='.$unionId.$like.' group by l.id  ORDER BY total '.$by_type;
			//echo $sql;
			$countData = $this ->db ->query($sql) ->result_array();
			
			//echo $sql;
			if ($excel == 'excel')
			{
				return $countData;
			}
			else 
			{
				$dataArr = array(
						'starttime' =>$starttime,
						'endtime' =>$endtime,
						'statisticsArr' =>$countData,
						'titleArr' =>$titleArr,
						'linename' =>$linename,
						'linecode' =>$linecode,
						'by_type' =>$by_type,
						'by_time' =>$by_time
				);
				$this ->load ->view('admin/t33/count/line_income' ,$dataArr);
			}
		}
	}
	
	//按月份sql组成
	public function getTypeMonthSql($startNum ,$endNum ,$year)
	{
		$titleArr = array();
		$monthArr = array(1=>'01',2=>'02',3=>'03',4=>'04',5=>'05',6=>'06',7=>'07',8=>'08',9=>'09',10=>'10',11=>'11',12=>'12');
		$sql = '';
		for($startNum; $startNum<=$endNum ;$startNum++)
		{
			$month = $monthArr[$startNum];
			$titleArr[] = array(
					'title' =>$year.'-'.$month,
					'key' =>$year.'-'.$month
				);
		
			//12月份特殊对待
			$nextMonth = $month == 12 ? '12-32' : $monthArr[$startNum+1];
		
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' then total_price end) as '{$year}-{$month}',";
		}
		return array(
				'sql' =>$sql,
				'titleArr' =>$titleArr
		);
	}
	
	//导出excel
	public function exportExcel()
	{
		$countData = $this ->index('excel');
		if (empty($countData))
		{
			$this ->callback ->setJsonCode(4000 ,'没有数据');
		}
	
		//生成excel
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
	
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 30 );
		$objActSheet->setCellValue ( "A1", '线路名称' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 30 );
		$objActSheet->setCellValue ( "B1", '线路编号' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
	
		//用于获取导航头
		$firstLine = $countData[0];
		$letterArr = range('C','Z');
	
		unset($firstLine['linename']);
		unset($firstLine['linecode']);
		unset($firstLine['total']);
		$i = 0;
	
		foreach($firstLine as $k=>$v)
		{
			$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
			$objActSheet->setCellValue ( $letterArr[$i].'1', $k );
			$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
			$i ++;
		}
		
		$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
		$objActSheet->setCellValue ( $letterArr[$i].'1', '总收入' );
		$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
	
		$i = 0;
		$count = 0;//总收入
		$columnArr = array();//统计每列的总数
		foreach ( $countData as $key => $val )
		{
			$rowNum = 0;//统计一行
	
			$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['linename'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $val['linecode'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
	
			unset($val['linename']);
			unset($val['linecode']);
			unset($val['total']);
	
			$j = 0;
			foreach($val as $k =>$item)
			{
				$rowNum += $item;
				$count += $item;
				if (array_key_exists($k, $columnArr))
				{
					$columnArr[$k] = $columnArr[$k] + $item;
				}
				else
				{
					$columnArr[$k] = $item;
				}
	
				$objActSheet->setCellValueExplicit ( $letterArr[$j] . ($i + 2), $item, PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle (  $letterArr[$j] . ($i + 2) )->applyFromArray ($one_style_array);
				$j ++ ;
			}
	
			$objActSheet->setCellValueExplicit ( $letterArr[$j] . ($i + 2), $rowNum, PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( $letterArr[$j] . ($i + 2) )->applyFromArray ($one_style_array);
			$i ++;
		}
	
		$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), '总计', PHPExcel_Cell_DataType::TYPE_STRING );
		$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
		$j = 0;
		foreach($columnArr as $val)
		{
			$objActSheet->setCellValueExplicit ( $letterArr[$j] . ($i + 2), $val, PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( $letterArr[$j] . ($i + 2) )->applyFromArray ($one_style_array);
			$j ++ ;
		}
	
		$objActSheet->setCellValueExplicit ( $letterArr[$j] . ($i + 2), $count, PHPExcel_Cell_DataType::TYPE_STRING );
		$objActSheet->getStyle ( $letterArr[$j] . ($i + 2) )->applyFromArray ($one_style_array);
	
	
		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file = "file/b2/upload/" . $g_session . ".xlsx";
		$objWriter->save ( $file );
		$this ->callback ->setJsonCode(2000 ,'/'.$file);
	}
}