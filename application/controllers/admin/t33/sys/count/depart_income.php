<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		营业部收入统计
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Depart_income extends T33_Controller
{
	public $pagesize = 10;
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
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
			$name = empty($_REQUEST['name']) ? '' : trim($_REQUEST['name']);
			$by_type = empty($_REQUEST['by_type']) ? 'desc' : trim($_REQUEST['by_type']);
			$by_time = empty($_REQUEST['by_time']) ? 'total' : trim($_REQUEST['by_time']);
			
			$ids = '';
			if (!empty($name))
			{
				//获取营业部
				$departData = $this ->depart_model ->getDepartLike($name);
				if (!empty($departData))
				{
					foreach($departData as $v)
					{
						$ids .= $v['id'].',';
					}
					$ids = trim($ids ,',');
				}
			}
			
			$sql1 = 'select ';
			$sql2 = 'sum( ';
			$sql3 = 'select ';
			
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
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
			}
			else
			{
				//开始和结束跨越了年份
				$infoArr = $this ->getTypeMonthSql($startMonth, 12, $startYear);
				$titleArr = $infoArr['titleArr'];
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
				
				$year = $startYear;
				if ($yearDifference >1) {
					$i = 1;
					for($i ;$i <$yearDifference ;$i++)
					{
						$year++;
						$infoArr = $this ->getTypeMonthSql(1, 12, $year);
						$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
						$sql1 .= $infoArr['sql1'];
						$sql2 .= $infoArr['sql2'];
						$sql3 .= $infoArr['sql3'];
					}
				}
		
				$infoArr = $this ->getTypeMonthSql(1, $endMonth, $endYear);
				$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
			}
					
			$sql = $sql1.rtrim($sql2,'+').') as total,depart_name,depart_id from('.$sql3;
			$sql .= ' d.name AS depart_name,mo.depart_id,d.pid';
			$sql .= ' FROM u_member_order AS mo LEFT JOIN b_depart AS d ON d.id= mo.depart_id';
			$sql .= ' WHERE mo.status >=4 AND mo.status <=8 AND mo.platform_id='.$unionId.' AND d.pid=0 ';
			$sql .= empty($ids) ? ' AND mo.depart_id>0' : ' and mo.depart_id in ('.$ids.')' ;
			$sql .= ' GROUP BY mo.depart_id';
			$sql .= ' UNION ALL '.$sql3;
			$sql .= ' d.name AS depart_name,d.pid AS depart_id,d.pid ';
			$sql .= ' FROM u_member_order AS mo LEFT JOIN b_depart AS d ON d.id= mo.depart_id ';
			$sql .= ' WHERE mo.status >=4 AND mo.status <=8 AND mo.platform_id='.$unionId;
			$sql .= empty($ids) ? ' AND d.pid>0' : ' and d.pid in ('.$ids.')';
			$sql .= ' GROUP BY d.pid) va';
			$sql .= ' GROUP BY va.depart_id ORDER BY '.$by_time.' '.$by_type;
			
			//echo $sql;
			$countData = $this ->db ->query($sql) ->result_array();
			if ($excel == 'excel')
			{
				return array(
						'titleArr' =>$titleArr,
						'countData' =>$countData
				);
			}
			else 
			{
				$dataArr = array(
						'starttime' =>$starttime,
						'endtime' =>$endtime,
						'statisticsArr' =>$countData,
						'titleArr' =>$titleArr,
						'name' =>$name,
						'by_type' =>$by_type,
						'by_time' =>$by_time
				);
				$this ->load ->view('admin/t33/count/depart_income' ,$dataArr);
			}
		}
	}
	
	//按月份sql组成
	public function getTypeMonthSql($startNum ,$endNum ,$year)
	{
		$titleArr = array();
		$monthArr = array(1=>'01',2=>'02',3=>'03',4=>'04',5=>'05',6=>'06',7=>'07',8=>'08',9=>'09',10=>'10',11=>'11',12=>'12');
		$sql1 = '';
		$sql2 = '';
		$sql3 = '';
		for($startNum; $startNum<=$endNum ;$startNum++)
		{
			$month = $monthArr[$startNum];
			$titleArr[] = array(
					'title' =>$year.'-'.$month,
					'key' =>'c'.$year.$month
			);
	
			$sql1 .= "sum(c{$year}{$month}) as c{$year}{$month},";
			$sql2 .= "c{$year}{$month}+";
				
			//12月份特殊对待
			$nextMonth = $month == 12 ? '12-32' : $monthArr[$startNum+1];
	
			$sql3 .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' then agent_fee ELSE 0 end) as c{$year}{$month},";
		}
	
		return array(
				'sql1' =>$sql1,
				'sql2' =>$sql2,
				'sql3' =>$sql3,
				'titleArr' =>$titleArr
		);
	}
	
	//导出excel
	public function exportExcel()
	{
		$type = empty($_REQUEST['type']) ? 1 : $_REQUEST['type'];
		
		$data = $this ->index('excel');
		$countData = $data['countData'];
		$titleArr = $data['titleArr'];
		
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
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "A1", '营业部名称' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
	
		//用于获取导航头
		$firstLine = $countData[0];
		$letterArr = range('B','Z');
	
		unset($firstLine['depart_name']);
		unset($firstLine['depart_id']);
		unset($firstLine['pid']);
		unset($firstLine['total']);
		$i = 0;
		
		$quarterArr = array(1=>'一季度',2=>'二季度',3=>'三季度',4=>'四季度');
		
		foreach($titleArr as $k=>$v)
		{
			$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
			$objActSheet->setCellValue ( $letterArr[$i].'1', $v['title'] );
			$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
			$i ++;
		}
		
		$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
		$objActSheet->setCellValue ( $letterArr[$i].'1', '总人数' );
		$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
	
		$i = 0;
		$count = 0;//总人数
		$columnArr = array();//统计每列的总数
		foreach ( $countData as $key => $val )
		{
			$rowNum = 0;//统计一行
				
			$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['depart_name'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
				
			unset($val['depart_id']);
			unset($val['depart_name']);
			unset($val['pid']);
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
	
	//按月份查看营业部销售人数统计
	public function wholeExcel()
	{
		$departId = intval($this ->input ->get('id'));
		$time = trim($this ->input ->get('time' ,true));
		$name = trim($this ->input ->get('name' ,true));
		$employee_id=$this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$unionId = $employee['union_id'];
		
		if (empty($departId) || empty($time))
		{
			
		}
	
		$timeArr = explode('-', $time);
		if ($timeArr[1] == 12)
		{
			$endtime = $timeArr[0].'-12-32';
		}
		else
		{
			$month = $timeArr[1]+1;
			$month = $month < 10 ? '0'.$month : $month;
			$endtime = $timeArr[0].'-'.$month;
		}
			
		$whereArr = array(
				'mo.status >=' =>4,
				'mo.status <=' =>8,
				'mo.usedate >=' =>$time,
				'mo.usedate <' =>$endtime,
				'mo.platform_id =' =>$unionId
		);
		$sql = " (d.id ={$departId} or d.pid ={$departId}) ";
		$allData = $this ->depart_model ->countDepartPeople($whereArr ,$sql);
		//echo $this ->db ->last_query();exit;
		$expertData = array();
		$expertAll = array();
		
		
		foreach($allData as $k=>$v)
		{
			$num = $v['agent_fee'];
			
			if (!array_key_exists($v['expert_id'], $expertData))
			{
				$expertData[$v['expert_id']] = array(
						'title' =>$v['depart_name'].$v['expert_name'].$timeArr[1].'月份收入统计'
				);
				
				$expertAll[] = array(
						'expert_id' =>$v['expert_id'],
						'expert_name' =>$v['expert_name']
				);
			}
			$expertData[$v['expert_id']]['lower'][] = array(
					'name' =>$v['depart_name'].'['.$v['expert_name'].']',
					'item_code' =>$v['item_code'],
					'num' =>$num,
					'linename' =>$v['linename']
			);
		}
		
		//获取营业部销售人员
		
		$dataArr = array(
			'allData' =>$allData,
			'expertData' =>$expertData,
			'expertAll' =>$expertAll,
			'time' =>$time,
			'departId' =>$departId,
			'name' =>$name
		);
		
		$this ->load ->view('admin/t33/count/depart_income_excel' ,$dataArr);
	}
	
	//php excel导出两个工作表
	//导出营业部人数统计
	public function exportExcelAll()
	{
		$time = trim($this ->input ->post('time' ,true));
		$departId = intval($this ->input ->post('departId'));
		//$name = trim($this ->input ->post('name'));
		$employee_id=$this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$unionId = $employee['union_id'];
		
		if (empty($time) || $departId < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'缺少参数');
		}
		$timeArr = explode('-', $time);
		if ($timeArr[1] == 12)
		{
			$endtime = $timeArr[0].'-12-32';
		}
		else
		{
			$month = $timeArr[1]+1;
			$month = $month < 10 ? '0'.$month : $month;
			$endtime = $timeArr[0].'-'.$month;
		}
		
		$whereArr = array(
				'mo.status >=' =>4,
				'mo.status <=' =>8,
				'mo.usedate >=' =>$time,
				'mo.usedate <' =>$endtime,
				'mo.platform_id =' =>$unionId
		);
		$sql = " (d.id ={$departId} or d.pid ={$departId}) ";
		$allData = $this ->depart_model ->countDepartPeople($whereArr ,$sql);
		
		//生成excel
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 25 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 50 );
		
		$objActSheet->setCellValue ( "A1", '部门' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'B1', '团号' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'C1', '收入' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'D1', '专线名称' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		
		if (! empty ( $allData )) {
			$i = 0;
			$count = 0;
			foreach ( $allData as $key => $val ) {
				$num = $val['agent_fee'];
				
				$count = $count +$num;
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['depart_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $val['item_code'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $num, PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $val['linename'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
				$i ++;
			}
			
			$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), '总计', PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), '', PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $count, PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), '', PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
		}
		
		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file = "file/b2/upload/" . $g_session . ".xlsx";
		$objWriter->save ( $file );
		$this ->callback ->setJsonCode(2000 ,'/'.$file);
		
		
	}
	
	//按管家分组导出营业部数据统计
	public function exportExcelExpert()
	{
		$time = trim($this ->input ->post('time' ,true));
		$departId = intval($this ->input ->post('departId'));
		$ids = trim($this ->input ->post('ids' ,true)); //管家ID
		$employee_id=$this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$unionId = $employee['union_id'];
		
		$timeArr = explode('-', $time);
		if ($timeArr[1] == 12)
		{
			$endtime = $timeArr[0].'-12-32';
		}
		else
		{
			$month = $timeArr[1]+1;
			$month = $month < 10 ? '0'.$month : $month;
			$endtime = $timeArr[0].'-'.$month;
		}
			
		$whereArr = array(
				'mo.status >=' =>4,
				'mo.status <=' =>8,
				'mo.usedate >=' =>$time,
				'mo.usedate <' =>$endtime,
				'mo.platform_id =' =>$unionId
		);
		
		if (empty($ids))
		{
			$sql = " (d.id ={$departId} or d.pid ={$departId}) ";
		}
		else 
		{
			$sql = ' e.id in ('.trim($ids ,',').') and '."(d.id ={$departId} or d.pid ={$departId}) ";
		}
		
		
		$allData = $this ->depart_model ->countDepartPeople($whereArr ,$sql);
		
		$expertData = array();
		
		foreach($allData as $k=>$v)
		{
			$num = $v['agent_fee'];
				
			if (!array_key_exists($v['expert_id'], $expertData))
			{
				$expertData[$v['expert_id']] = array(
						'title' =>$v['depart_name'].$v['expert_name'].$timeArr[1].'月份人数统计'
				);
			}
			$expertData[$v['expert_id']]['lower'][] = array(
					'name' =>$v['depart_name'].'['.$v['expert_name'].']',
					'item_code' =>$v['item_code'],
					'num' =>$num,
					'linename' =>$v['linename']
			);
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
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 25 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 10 );
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 50 );
		
		if (! empty ( $expertData )) {
			$i = 0;
			foreach($expertData as $v)
			{
				++$i;
				
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
				$objActSheet->setCellValue ( "A".$i, $v['title'] );
				$objActSheet->getStyle ( 'A'.$i )->applyFromArray ($style_array);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				++$i;
				$objActSheet->setCellValue ( "A".$i, '部门' );
				$objActSheet->getStyle ( 'A'.$i )->applyFromArray ($style_array);
				$objActSheet->setCellValue ( 'B'.$i, '团号' );
				$objActSheet->getStyle ( 'B'.$i )->applyFromArray ($style_array);
				$objActSheet->setCellValue ( 'C'.$i, '收入' );
				$objActSheet->getStyle ( 'C'.$i )->applyFromArray ($style_array);
				$objActSheet->setCellValue ( 'D'.$i, '专线名称' );
				$objActSheet->getStyle ( 'D'.$i )->applyFromArray ($style_array);
				
				if (!empty($v['lower'])) {
					$count = 0; //总计 
					foreach($v['lower'] as $item)
					{
						$count = $count + $item['num'];
						++$i;
						
						$objActSheet->setCellValueExplicit ( 'A' . $i, $item['name'], PHPExcel_Cell_DataType::TYPE_STRING );
						$objActSheet->getStyle ( 'A' . $i )->applyFromArray ($one_style_array);
						$objActSheet->setCellValueExplicit ( 'B' . $i, $item['item_code'], PHPExcel_Cell_DataType::TYPE_STRING );
						$objActSheet->getStyle ( 'B' . $i )->applyFromArray ($one_style_array);
						$objActSheet->setCellValueExplicit ( 'C' . $i, $item['num'], PHPExcel_Cell_DataType::TYPE_STRING );
						$objActSheet->getStyle ( 'C' . $i )->applyFromArray ($one_style_array);
						$objActSheet->setCellValueExplicit ( 'D' . $i, $item['linename'], PHPExcel_Cell_DataType::TYPE_STRING );
						$objActSheet->getStyle ( 'D' . $i )->applyFromArray ($one_style_array);
					}
					
					++$i;
					$objActSheet->setCellValueExplicit ( 'A' . $i, '总计', PHPExcel_Cell_DataType::TYPE_STRING );
					$objActSheet->getStyle ( 'A' . $i )->applyFromArray ($one_style_array);
					$objActSheet->setCellValueExplicit ( 'B' .$i, '', PHPExcel_Cell_DataType::TYPE_STRING );
					$objActSheet->getStyle ( 'B' .$i )->applyFromArray ($one_style_array);
					$objActSheet->setCellValueExplicit ( 'C' . $i, $count, PHPExcel_Cell_DataType::TYPE_STRING );
					$objActSheet->getStyle ( 'C' . $i )->applyFromArray ($one_style_array);
					$objActSheet->setCellValueExplicit ( 'D' . $i, '', PHPExcel_Cell_DataType::TYPE_STRING );
					$objActSheet->getStyle ( 'D' . $i )->applyFromArray ($one_style_array);
				}
				
				++$i;
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
				$objActSheet->setCellValue ( "A".$i, '' );
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