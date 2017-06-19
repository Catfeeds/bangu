<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		联盟佣金统计
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Union_fee_count extends UA_Controller
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
		$name = empty($_REQUEST['name']) ? '' : trim($_REQUEST['name']);
		$code = empty($_REQUEST['code']) ? '' : trim($_REQUEST['code']);
		$page = intval($this ->input ->get('page'));
		$page = empty($page) ? 1 : $page;
		
		//统计类型
		$countType = empty($_REQUEST['countType']) ? 1 : $_REQUEST['countType'];
		
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
		if (!empty($code))
		{
			$like = ' and mo.item_code = "'.$code.'" ';
		}
		
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
		
		$sql .= ' d.name as depart_name,mo.depart_id,d.pid,mo.item_code from u_member_order as mo left join b_depart as d on d.id=mo.depart_id ';
		$childSql = $sql;
		
		$unionId = 15;
		
		$groupStr = $countType == 1 ? ' group by mo.item_code ' : ' group by mo.depart_id ';
		
		$sql .= ' where mo.status >=4 and mo.status <=8 and mo.platform_id='.$unionId.' and d.pid=0 '.$like.$groupStr.' limit '.(($page-1)*10).',10';
		
		//echo $sql;
		$countData = $this ->db ->query($sql) ->result_array();
		
		if ($countType == 2) {
			//获取营业部子级的佣金，目前营业部2级
			$ids = '';
			foreach($countData as $k =>$v)
			{
				$ids .= $v['depart_id'].',';
			}
			if(!empty($ids))
			{
				$sql = $childSql.' where mo.status >=4 and mo.status <=8 and mo.platform_id='.$unionId.' and d.pid in ('.trim($ids ,',').') group by d.pid';
				$childData = $this ->db ->query($sql) ->result_array();
			}
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
		}
		
		$sql = 'select count(*) as count from (select mo.id from u_member_order as mo left join b_depart as d on d.id=mo.depart_id  where mo.status >=4 and mo.status <=8 and d.pid=0 and mo.platform_id='.$unionId.' '.$like.$groupStr.') as a';
		//获取总数量
		$countArr = $this ->db ->query($sql) ->row_array();
		//var_dump($countArr);
		//分页
		$this->load->library('page');
		$config = array(
				'pagesize' =>10,
				'pagecount' =>$countArr['count'],
				'page_now' =>$page,
				'base_url' =>'/admin/a/statistics/union_fee_count/index?'.$search.'&page='
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
				'name' =>$name,
				'countType' =>$countType,
				'code' =>$code
		);
		
		$this ->view('admin/a/statistics/union_fee_count' ,$dataArr);
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

			$sql .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' then diplomatic_agent+platform_fee end) as '{$year}-{$start}',";
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
			$sql .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' then diplomatic_agent+platform_fee end) as '{$start}',";
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
		
			$sql .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' then diplomatic_agent+platform_fee end) as '{$year}-{$month}',";
		}
		return array(
				'sql' =>$sql,
				'titleArr' =>$titleArr
		);
	}
}