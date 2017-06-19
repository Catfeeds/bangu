<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		营业部人头统计
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Depart_people_count extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
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
		$name = empty($_REQUEST['depart_name']) ? '' : trim($_REQUEST['depart_name']);
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

				$monthSql = $this ->getTypeMonthSql($startMonth, $endMonth, $startYear);
				$titleArr = $monthSql['titleArr'];
				$sql .= $monthSql['sql'];
			}
			else 
			{
				//开始和结束跨越了年份
				
				$monthSql = $this ->getTypeMonthSql($startMonth, 12, $startYear);
				$titleArr = $monthSql['titleArr'];
				$sql .= $monthSql['sql'];
				
				$year = $startYear;
				if ($yearDifference >1) {
					$i = 1;
					for($i ;$i <$yearDifference ;$i++)
					{
						$year++;
						$monthSql = $this ->getTypeMonthSql(1, 12, $year);
						$titleArr = array_merge($titleArr ,$monthSql['titleArr']);
						$sql .= $monthSql['sql'];
					}
				}
				
				$monthSql = $this ->getTypeMonthSql(1, $endMonth, $endYear);
				$titleArr = array_merge($titleArr ,$monthSql['titleArr']);
				$sql .= $monthSql['sql'];
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
		
		$sql .= ' d.name as depart_name,mo.depart_id,d.pid from b_depart as d left join u_member_order as mo on d.id=mo.depart_id left join u_line as l on l.id=mo.productautoid';
		$childSql = $sql;
		
		$sql .= ' where mo.status >=4 and mo.status <=8 and mo.depart_id >0 and d.pid=0 '.$like.' group by mo.depart_id limit '.(($page-1)*10).',10';
		//echo $sql;
		$countData = $this ->db ->query($sql) ->result_array();
		
		if (!empty($countData)) 
		{
			$ids = '';
			foreach($countData as $v) {
				$ids .= $v['depart_id'].',';
			}
			$sql = $childSql.' where mo.status >=4 and mo.status <=8 and d.pid in ('.trim($ids ,',').') group by d.pid ';
			$childData = $this ->db ->query($sql) ->result_array();
			
			//var_dump($titleArr);
			if (!empty($childData))
			{
				$childArr = array();
				foreach($childData as $v) {
					$childArr[$v['pid']] = $v;
				}
				//var_dump($childArr);
				foreach($titleArr as $i)
				{
					foreach($i['key'] as $val) {
						
						foreach($countData as $k=>$v)
						{
							if (array_key_exists($v['depart_id'], $childArr)) {
								
								$num = $countData[$k][$val]+$childArr[$v['depart_id']][$val];
								if ($num >0) {
									//echo $v['depart_id'].'--'.$val.'---'.$childArr[$v['depart_id']][$val].'|<br/>';
									$countData[$k][$val] = $num;
								}
							}
						}
					}
					
				}
			}
			//var_dump($titleArr);
		}
		
		//获取总数量
		$sql = 'select count(*) as count from (select mo.id from b_depart as d left join u_member_order as mo on d.id=mo.depart_id  where mo.status >=4 and mo.status <=8 and d.pid=0 and mo.depart_id >0 '.$like.' group by mo.depart_id) as a';
		$countArr = $this ->db ->query($sql) ->row_array();
		//var_dump($countArr);
		//分页
		$this->load->library('page');
		$config = array(
				'pagesize' =>10,
				'pagecount' =>$countArr['count'],
				'page_now' =>$page,
				'base_url' =>'/admin/a/statistics/depart_people_count/index?'.$search.'&page='
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
		
		$this ->view('admin/a/statistics/depart_people_count' ,$dataArr);
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
					'key' =>array(
							'出' =>"{$year}-{$start}_1_num",
							'国' =>"{$year}-{$start}_2_num",
							'周' =>"{$year}-{$start}_3_num"
					)
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

			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' and l.line_classify=1 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$start}_1_num',";
			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' and l.line_classify=2 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$start}_2_num',";
			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' and l.line_classify=3 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$start}_3_num',";
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
					'key' =>array(
							'出' =>"{$start}_1_num",
							'国' =>"{$start}_2_num",
							'周' =>"{$start}_3_num"
					)
			);
	
			//12月份特殊对待
	
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' and l.line_classify=1 then dingnum+childnobednum+childnum+oldnum end) as '{$start}_1_num',";
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' and l.line_classify=2 then dingnum+childnobednum+childnum+oldnum end) as '{$start}_2_num',";
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' and l.line_classify=3 then dingnum+childnobednum+childnum+oldnum end) as '{$start}_3_num',";
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
					'key' =>array(
							'出' =>"{$year}-{$month}_1_num",
							'国' =>"{$year}-{$month}_2_num",
							'周' =>"{$year}-{$month}_3_num"
					)
					);
		
			//12月份特殊对待
			$nextMonth = $month == 12 ? '12-32' : $monthArr[$startNum+1];
		
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' and l.line_classify=1 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$month}_1_num',";
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' and l.line_classify=2 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$month}_2_num',";
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' and l.line_classify=3 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$month}_3_num',";
		}
		return array(
				'sql' =>$sql,
				'titleArr' =>$titleArr
		);
	}
}