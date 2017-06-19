<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		供应商收客统计
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supplier_people_count extends UA_Controller
{
	public $pagesize = 10;
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
			$like = " and s.company_name like '%{$name}%'";
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
		
		$sql .= ' s.company_name as supplier_name from u_member_order as mo left join u_supplier as s on s.id= mo.supplier_id';
		$sql .= ' where mo.status >=4 and mo.status <=8 '.$like.' group by mo.supplier_id limit '.(($page-1)*$this->pagesize).','.$this->pagesize;
		//echo $sql;
		$countData = $this ->db ->query($sql) ->result_array();
		
		//获取总数量
		$sql = 'select count(*) as count from (select mo.id from u_member_order as mo left join u_supplier as s on s.id=mo.supplier_id where mo.status >=4 and mo.status <=8 '.$like.' group by mo.supplier_id) as a';
		$countArr = $this ->db ->query($sql) ->row_array();
		//var_dump($countArr);
		//分页
		$this->load->library('page');
		$config = array(
				'pagesize' =>$this->pagesize,
				'pagecount' =>$countArr['count'],
				'page_now' =>$page,
				'base_url' =>'/admin/a/statistics/supplier_people_count/index?'.$search.'&page='
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
		
		$this ->view('admin/a/statistics/supplier_people_count' ,$dataArr);
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
}