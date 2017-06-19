<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		营业部收客统计
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Depart_p_count extends UA_Controller
{
	public $pagesize = 10;
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
	}
	public function index()
	{
		$type = empty($_REQUEST['type']) ? 1 : $_REQUEST['type'];
		$starttime = empty($_REQUEST['starttime']) ? '' : trim($_REQUEST['starttime']);
		$endtime = empty($_REQUEST['endtime']) ? '' : trim($_REQUEST['endtime']);
		$start_quarter = empty($_REQUEST['start_quarter']) ? '' : trim($_REQUEST['start_quarter']);
		$end_quarter = empty($_REQUEST['end_quarter']) ? '' : trim($_REQUEST['end_quarter']);
		$start_year = empty($_REQUEST['start_year']) ? '' : trim($_REQUEST['start_year']);
		$end_year = empty($_REQUEST['end_year']) ? '' : trim($_REQUEST['end_year']);
		$name = trim($this ->input ->get('name' ,true));
		$page = intval($this ->input ->get('page'));
		$page = empty($page) ? 1 : $page;
		
		$search = '';
		if($type != 1 && $type !=2 && $type !=3)
		{
			$type = 1;
		}
		$search .= 'type='.$type;
		
		$like = '';
		if (!empty($name))
		{
			$like = " and d.name like '%{$name}%'";
		}
		
		//var_dump($page);exit;
		$sql = 'SELECT ';
		if ($type == 1)//按月分组
		{
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
			
			$search .= '&starttime='.$starttime.'&endtime='.$endtime;
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
			
		}
		elseif ($type == 2)//按季度分组
		{
			$now = date('Y',time()).'-'.ceil(date('n' ,time()) /3);
			$start_quarter = empty($start_quarter) ? $now : $start_quarter;
			$end_quarter = empty($end_quarter) ? $now : $end_quarter;
			if ($start_quarter > $end_quarter) {
				$time = $end_quarter;
				$end_quarter = $start_quarter;
				$start_quarter = $time;
			}	
			
			$search .= '&start_quarter='.$start_quarter.'&end_quarter='.$end_quarter;
			
			$squarterArr = explode('-', $start_quarter);
			$equarterArr = explode('-', $end_quarter);
			$syear = $squarterArr[0];
			$eyear = $equarterArr[0];
			//结束年份和开始年份的差
			$yearDifference = $eyear - $syear;
			
			if ($yearDifference == 0) {
				//在同一年
				
				$infoArr = $this ->getTypeQuarterSql($squarterArr[1] ,$equarterArr[1] ,$syear);
				$titleArr = $infoArr['titleArr'];
				$sql .= $infoArr['sql'];
			}
			else 
			{
				//跨越了年份
				$infoArr = $this ->getTypeQuarterSql($squarterArr[1], 4, $syear);
				$titleArr = $infoArr['titleArr'];
				$sql .= $infoArr['sql'];
				
				$year = $syear;
				if ($yearDifference >1) {
					$i = 1;
					for($i ;$i <$yearDifference ;$i++)
					{
						$year++;
						$infoArr = $this ->getTypeQuarterSql(1, 12, $year);
						$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
						$sql .= $infoArr['sql'];
					}
				}
				
				$infoArr = $this ->getTypeQuarterSql(1, $equarterArr[1], $eyear);
				$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
				$sql .= $infoArr['sql'];
			}
		}
		else//按年分组
		{
			$start_year = empty($start_year) ? date('Y' ,time()) : $start_year;
			$end_year = empty($end_year) ? date('Y' ,time()) : $end_year;
			if ($start_year > $end_year) {
				$time = $end_year;
				$end_year = $start_year;
				$start_year = $time;
			}
			$search .= '&end_year='.$end_year.'&start_year='.$start_year;
			$yearSql = $this ->getTypeYearSql($start_year ,$end_year);
			$titleArr = $yearSql['titleArr'];
			$sql .= $yearSql['sql'];
		}
		
		$sql .= ' d.name as depart_name,mo.depart_id,d.pid from u_member_order as mo left join b_depart as d on d.id= mo.depart_id';
		$childSql = $sql;
		
		$sql .= ' where mo.status >=4 and mo.status <=8 and mo.depart_id>0 and d.pid=0 '.$like.' group by mo.depart_id limit '.(($page-1)*$this->pagesize).','.$this->pagesize;
		//echo $sql;
		$countData = $this ->db ->query($sql) ->result_array();
		//var_dump($countData);
		//获取总数量
		$sql = 'select count(*) as count from (select mo.id from u_member_order as mo left join b_depart as d on d.id=mo.depart_id where mo.status >=4 and mo.status <=8 and d.pid=0 and mo.depart_id>0 '.$like.' group by mo.depart_id) as a';
		$countArr = $this ->db ->query($sql) ->row_array();
		//var_dump($countArr);
		
		//获取下级销售人数
		$ids = '';
		foreach($countData as $k =>$v)
		{
			$ids .= $v['depart_id'].',';
		}
		$sql = $childSql.' where mo.status >=4 and mo.status <=8 and d.pid in ('.trim($ids ,',').') group by d.pid';
		
		$childData = $this ->db ->query($sql) ->result_array();
		
		if (!empty($childData))
		{
			$childArr = array();
			foreach($childData as $v) {
				$childArr[$v['pid']] = $v;
			}
			foreach($titleArr as $i)
			{
				foreach($countData as $k=>$v)
				{
					if (array_key_exists($v['depart_id'], $childArr)) {
						$countData[$k][$i['key']] = $countData[$k][$i['key']]+$childArr[$v['depart_id']][$i['key']];
					}
				}
			}
		}
		
		//分页
		$this->load->library('page');
		$config = array(
				'pagesize' =>$this->pagesize,
				'pagecount' =>$countArr['count'],
				'page_now' =>$page,
				'base_url' =>'/admin/a/statistics/depart_p_count/index?'.$search.'&page='
		);
		$this ->page ->initialize($config);
		//echo $sql;
		$dataArr = array(
				'type' =>$type,
				'starttime' =>$starttime,
				'endtime' =>$endtime,
				'statisticsArr' =>$countData,
				'titleArr' =>$titleArr,
				'start_year' =>$start_year,
				'end_year' =>$end_year,
				'start_quarter' =>$start_quarter,
				'end_quarter' =>$end_quarter,
				'name' =>$name
		);
		
		$this ->view('admin/a/statistics/depart_p_count' ,$dataArr);
	}
	
	//按季度sql组成
	public function getTypeQuarterSql($start ,$end ,$year)
	{
		$titleArr = array();
		$quarteArr = array(1=>'一季度',2=>'二季度',3=>'三季度',4=>'四季度');
		$sql = '';
		for($start; $start<=$end ;$start++)
		{
			$quarte = $quarteArr[$start];
			$titleArr[] = array(
					'title' =>$quarte.'/'.$year,
					'key' =>$year.'-'.$start
			);
			switch($start) {
				case 1:
					$start_usedate = '01';
					$end_usedate = '03-32';
					break;
				case 2:
					$start_usedate = '04';
					$end_usedate = '06-32';
					break;
				case 3:
					$start_usedate = '07';
					$end_usedate = '09-32';
					break;
				case 4:
					$start_usedate = '10';
					$end_usedate = '12-32';
					break;
			}

			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$start}',";
		}
		return array(
				'sql' =>$sql,
				'titleArr' =>$titleArr
		);
	}
	
	//按年份sql组成
	public function getTypeYearSql($start ,$end)
	{
		$titleArr = array();
		$sql = '';
		for($start; $start<=$end ;$start++)
		{
			$titleArr[] = array(
					'title' =>$start.'年',
					'key' =>$start
			);
	
			//12月份特殊对待
	
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' then dingnum+childnobednum+childnum+oldnum end) as '{$start}',";
		}
		return array(
				'sql' =>$sql,
				'titleArr' =>$titleArr
		);
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
		
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$month}',";
		}
		return array(
				'sql' =>$sql,
				'titleArr' =>$titleArr
		);
	}
	
	
	//按月份查看营业部销售人数统计
	public function wholeExcel()
	{
		
		$departId = intval($this ->input ->get('id'));
		$time = trim($this ->input ->get('time' ,true));
		$name = trim($this ->input ->get('name' ,true));
		
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
				'mo.usedate <' =>$endtime
		);
		$sql = " (d.id ={$departId} or d.pid ={$departId}) ";
		$allData = $this ->depart_model ->countDepartPeople($whereArr ,$sql);
		//echo $this ->db ->last_query();
		
		$expertData = array();
		$expertAll = array();
		
		
		foreach($allData as $k=>$v)
		{
			$num = $v['dingnum']+$v['childnum']+$v['childnobednum']+$v['oldnum'];
			if ($num <= 0) {
				unset($allData[$k]);
				continue;
			}
			
			if (!array_key_exists($v['expert_id'], $expertData))
			{
				$expertData[$v['expert_id']] = array(
						'title' =>$v['depart_name'].$v['expert_name'].$timeArr[1].'月份人数统计'
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
		//$expertAll = $this ->depart_model ->getDepartExpert($departId);
		
		$dataArr = array(
			'allData' =>$allData,
			'expertData' =>$expertData,
			'expertAll' =>$expertAll,
			'time' =>$time,
			'departId' =>$departId,
			'name' =>$name
		);
		
		$this ->view('admin/a/statistics/wholeExcel' ,$dataArr);
	}
	
	//php excel导出两个工作表
	//导出营业部人数统计
	public function exportExcelAll()
	{
		$time = trim($this ->input ->post('time' ,true));
		$departId = intval($this ->input ->post('departId'));
		//$name = trim($this ->input ->post('name'));
		
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
				'mo.usedate <' =>$endtime
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
		$objActSheet->setCellValue ( 'C1', '人数' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'D1', '专线名称' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		
		if (! empty ( $allData )) {
			$i = 0;
			$count = 0;
			foreach ( $allData as $key => $val ) {
				$num = $val['dingnum']+$val['childnum']+$val['childnobednum']+$val['oldnum'];
				if ($num == 0) {
					continue;
				}
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
				'mo.usedate <' =>$endtime
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
			$num = $v['dingnum']+$v['childnum']+$v['childnobednum']+$v['oldnum'];
			if ($num <= 0) {
				unset($allData[$k]);
				continue;
			}
				
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
				$objActSheet->setCellValue ( 'C'.$i, '人数' );
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