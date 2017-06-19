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
class People_count extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$type = intval($this ->input ->post('type'));
		$starttime = trim($this ->input ->post('starttime'));
		$endtime = trim($this ->input ->post('endtime'));
		$start_quarter = trim($this ->input ->post('start_quarter'));
		$end_quarter = trim($this ->input ->post('end_quarter'));
		$start_year = trim($this ->input ->post('start_year'));
		$end_year = trim($this ->input ->post('end_year'));
		if($type != 1 && $type !=2 && $type !=3)
		{
			$type = 1;
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
			
			$monthArr = array(1=>'01',2=>'02',3=>'03',4=>'04',5=>'05',6=>'06',7=>'07',8=>'08',9=>'09',10=>'10',11=>'11',12=>'12');
			
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
						$sql .= $infoArr['sql'];
						$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
					}
				}
				
				$infoArr = $this ->getTypeMonthSql(1, $endMonth, $endYear);
				$sql .= $infoArr['sql'];
				$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
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
			
			$yearSql = $this ->getTypeYearSql($start_year ,$end_year);
			$titleArr = $yearSql['titleArr'];
			$sql .= $yearSql['sql'];
		}
		
		$sql =rtrim($sql ,',').' from u_member_order as mo left join u_line as l on l.id=mo.productautoid';
		$sql .= ' where mo.status >=4 and mo.status <=8 ';
		//echo $sql;
		$data = $this ->db ->query($sql) ->row_array();
		//组合数据
		$statisticsArr = array(
				'1' =>array('name' =>'出境游') ,
				'2' =>array('name' =>'国内游') ,
				'3' =>array('name' =>'周边游')
		);
		foreach($data as $k =>$v)
		{
			$keyArr = explode('_' ,$k);
			$statisticsArr[$keyArr[1]][$keyArr[0]] = $v;
		}
		//var_dump($statisticsArr);
		$dataArr = array(
				'type' =>$type,
				'starttime' =>$starttime,
				'endtime' =>$endtime,
				'statisticsArr' =>$statisticsArr,
				'titleArr' =>$titleArr,
				'start_year' =>$start_year,
				'end_year' =>$end_year,
				'start_quarter' =>$start_quarter,
				'end_quarter' =>$end_quarter
		);
		
		$this ->view('admin/a/statistics/people_count' ,$dataArr);
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

			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' and l.line_classify=1 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$start}_1',";
			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' and l.line_classify=2 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$start}_2',";
			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' and l.line_classify=3 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$start}_3',";
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
	
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' and l.line_classify=1 then dingnum+childnobednum+childnum+oldnum end) as '{$start}_1',";
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' and l.line_classify=2 then dingnum+childnobednum+childnum+oldnum end) as '{$start}_2',";
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' and l.line_classify=3 then dingnum+childnobednum+childnum+oldnum end) as '{$start}_3',";
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
		
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' and l.line_classify=1 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$month}_1',";
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' and l.line_classify=2 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$month}_2',";
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' and l.line_classify=3 then dingnum+childnobednum+childnum+oldnum end) as '{$year}-{$month}_3',";
		}
		
		return array(
				'sql' =>$sql,
				'titleArr' =>$titleArr
		);
	}
}