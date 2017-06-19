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
class Union_fee_count extends T33_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_depart_model','depart_model');
		$this->load->library ( 'callback' );
	}
	
	public function index()
	{
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			//统计类型
			$countType = empty($_REQUEST['countType']) ? 1 : $_REQUEST['countType'];
			if ($countType ==1)
			{
				$this ->groupCodeData($employee_id ,$countType);
			}
			else 
			{
				$this ->groupDepartData($employee_id ,$countType);
			}
		}
	}
	//按营业部统计
	public function groupDepartData($employee_id ,$countType ,$excel='')
	{
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$unionId = $employee['union_id'];
			
		$type = empty($_REQUEST['type']) ? 1 : $_REQUEST['type'];
		$starttime = empty($_REQUEST['starttime']) ? '' : trim($_REQUEST['starttime']);
		$endtime = empty($_REQUEST['endtime']) ? '' : trim($_REQUEST['endtime']);
		$start_quarter = empty($_REQUEST['start_quarter']) ? '' : trim($_REQUEST['start_quarter']);
		$end_quarter = empty($_REQUEST['end_quarter']) ? '' : trim($_REQUEST['end_quarter']);
		$start_year = empty($_REQUEST['start_year']) ? '' : trim($_REQUEST['start_year']);
		$end_year = empty($_REQUEST['end_year']) ? '' : trim($_REQUEST['end_year']);
		$by_type = empty($_REQUEST['by_type']) ? 'desc' : trim($_REQUEST['by_type']);
		$by_time = empty($_REQUEST['by_time']) ? 'total' : trim($_REQUEST['by_time']);
		$name = empty($_REQUEST['name']) ? '' : trim($_REQUEST['name']);
		$code = empty($_REQUEST['code']) ? '' : trim($_REQUEST['code']);
		
		if($type != 1 && $type !=2 && $type !=3)
		{
			$type = 1;
		}
		
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
				$infoArr = $this ->getTypeMonthSql1($startMonth, $endMonth, $startYear);
				$titleArr = $infoArr['titleArr'];
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
			}
			else
			{
				//开始和结束跨越了年份
				$infoArr = $this ->getTypeMonthSql1($startMonth, 12, $startYear);
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
						$infoArr = $this ->getTypeMonthSql1(1, 12, $year);
						$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
						$sql1 .= $infoArr['sql1'];
						$sql2 .= $infoArr['sql2'];
						$sql3 .= $infoArr['sql3'];
					}
				}
				
				$infoArr = $this ->getTypeMonthSql1(1, $endMonth, $endYear);
				$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
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
		
				$infoArr = $this ->getTypeQuarterSql1($squarterArr[1] ,$equarterArr[1] ,$syear);
				$titleArr = $infoArr['titleArr'];
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
			}
			else
			{
				//跨越了年份
				$infoArr = $this ->getTypeQuarterSql1($squarterArr[1], 4, $syear);
				$titleArr = $infoArr['titleArr'];
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
		
				$year = $syear;
				if ($yearDifference >1) {
					$i = 1;
					for($i ;$i <$yearDifference ;$i++)
					{
						$year++;
						$infoArr = $this ->getTypeQuarterSql1(1, 12, $year);
						$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
						$sql1 .= $infoArr['sql1'];
						$sql2 .= $infoArr['sql2'];
						$sql3 .= $infoArr['sql3'];
					}
				}
		
				$infoArr = $this ->getTypeQuarterSql1(1, $equarterArr[1], $eyear);
				$titleArr = array_merge($titleArr ,$infoArr['titleArr']);
				$sql1 .= $infoArr['sql1'];
				$sql2 .= $infoArr['sql2'];
				$sql3 .= $infoArr['sql3'];
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
			$infoArr = $this ->getTypeYearSql1($start_year ,$end_year);
			$titleArr = $infoArr['titleArr'];
			$sql1 .= $infoArr['sql1'];
			$sql2 .= $infoArr['sql2'];
			$sql3 .= $infoArr['sql3'];
		}
			
		$sql = $sql1.rtrim($sql2,'+').') as total,depart_name,item_code from('.$sql3;
		$sql .= ' d.name AS depart_name,mo.depart_id,d.pid,mo.item_code';
		$sql .= ' FROM u_member_order AS mo LEFT JOIN b_depart AS d ON d.id= mo.depart_id';
		$sql .= ' WHERE mo.status >=4 AND mo.status <=8 AND mo.platform_id='.$unionId.' AND d.pid=0 ';
		$sql .= empty($ids) ? ' AND mo.depart_id>0' : ' and mo.depart_id in ('.$ids.')' ;
		$sql .= ' GROUP BY mo.depart_id';
		$sql .= ' UNION ALL '.$sql3;
		$sql .= ' d.name AS depart_name,d.pid AS depart_id,d.pid,mo.item_code ';
		$sql .= ' FROM u_member_order AS mo LEFT JOIN b_depart AS d ON d.id= mo.depart_id ';
		$sql .= ' WHERE mo.status >=4 AND mo.status <=8 AND mo.platform_id='.$unionId;
		$sql .= empty($ids) ? ' AND d.pid>0' : ' and d.pid in ('.$ids.')';
		$sql .= ' GROUP BY d.pid) va';
		$sql .= ' GROUP BY va.depart_id ORDER BY '.$by_time.' '.$by_type;
		
		if (!empty($name) && empty($ids))
		{
			$dataArr = array(
					'type' =>$type,
					'starttime' =>$starttime,
					'endtime' =>$endtime,
					'statisticsArr' =>array(),
					'titleArr' =>array(),
					'start_year' =>$start_year,
					'end_year' =>$end_year,
					'start_quarter' =>$start_quarter,
					'end_quarter' =>$end_quarter,
					'name' =>$name,
					'countType' =>$countType,
					'code' =>'',
					'by_type' =>$by_type,
					'by_time' =>$by_time
			);
		}
		else 
		{
			$countData = $this ->db ->query($sql) ->result_array();
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
					'code' =>'',
					'by_type' =>$by_type,
					'by_time' =>$by_time
			);
		}
		if ($excel == 'excel')
		{
			return $dataArr['statisticsArr'];
		}
		else 
		{
			$this ->load ->view('admin/t33/count/union_fee_count' ,$dataArr);
		}
		
	}
	//按团号统计
	public function groupCodeData($employee_id ,$countType ,$excel='')
	{
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$unionId = $employee['union_id'];
			
		$type = empty($_REQUEST['type']) ? 1 : $_REQUEST['type'];
		$starttime = empty($_REQUEST['starttime']) ? '' : trim($_REQUEST['starttime']);
		$endtime = empty($_REQUEST['endtime']) ? '' : trim($_REQUEST['endtime']);
		$start_quarter = empty($_REQUEST['start_quarter']) ? '' : trim($_REQUEST['start_quarter']);
		$end_quarter = empty($_REQUEST['end_quarter']) ? '' : trim($_REQUEST['end_quarter']);
		$start_year = empty($_REQUEST['start_year']) ? '' : trim($_REQUEST['start_year']);
		$end_year = empty($_REQUEST['end_year']) ? '' : trim($_REQUEST['end_year']);
		$name = empty($_REQUEST['name']) ? '' : trim($_REQUEST['name']);
		$code = empty($_REQUEST['code']) ? '' : trim($_REQUEST['code']);
			
		$by_time = empty($_REQUEST['by_time']) ? 'total' : intval($_REQUEST['by_time']); //排序时间段，默认总计排序
		$by_type = empty($_REQUEST['by_type']) ? 'desc' : trim($_REQUEST['by_type']);//排序方式 desc asc
			
		if($type != 1 && $type !=2 && $type !=3)
		{
			$type = 1;
		}
			
		$like = '';
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
			$sql .= 'SUM(CASE WHEN usedate>="'.$starttime.'-01" AND usedate<="'.$endtime.'-31" THEN diplomatic_agent+platform_fee ELSE 0 END) AS total,';
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
			
			$monthArr = array(1=>3,2=>6,3=>9,4=>12);
			$sql .= 'SUM(CASE WHEN usedate>="'.$syear.$monthArr[$squarterArr[1]].'-01" AND usedate<="'.$eyear.$monthArr[$equarterArr[1]].'-31" THEN diplomatic_agent+platform_fee ELSE 0 END) AS total,';
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
			$sql .= 'SUM(CASE WHEN usedate>="'.$start_year.'" AND usedate<="'.$end_year.'-12-31" THEN diplomatic_agent+platform_fee ELSE 0 END) AS total,';
		}
			
		$sql .= ' mo.item_code,d.name as depart_name from u_member_order as mo left join b_depart as d on d.id=mo.depart_id';
		$sql .= ' where mo.status >=4 and mo.status <=8 and mo.platform_id='.$unionId.$like.' group by mo.item_code order by total '.$by_type;
		
		$countData = $this ->db ->query($sql) ->result_array();
		if ($excel == 'excel')
		{
			return $countData;
		}
		else 
		{
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
					'code' =>$code,
					'by_type' =>$by_type,
					'by_time' =>$by_time
			);
			$this ->load ->view('admin/t33/count/union_fee_count' ,$dataArr);
		}
	}
	
	
	//按月份sql组成
	public function getTypeMonthSql1($startNum ,$endNum ,$year)
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
	
			$sql3 .= "sum(case when usedate>='{$year}-{$month}' and usedate<'{$year}-{$nextMonth}' then diplomatic_agent+platform_fee ELSE 0 end) as c{$year}{$month},";
		}
	
		return array(
				'sql1' =>$sql1,
				'sql2' =>$sql2,
				'sql3' =>$sql3,
				'titleArr' =>$titleArr
		);
	}
	
	//按季度sql组成
	public function getTypeQuarterSql1($start ,$end ,$year)
	{
		$titleArr = array();
		$quarteArr = array(1=>'一季度',2=>'二季度',3=>'三季度',4=>'四季度');
		$sql1 = '';
		$sql2 = '';
		$sql3 = '';
		for($start; $start<=$end ;$start++)
		{
			$quarte = $quarteArr[$start];
			$titleArr[] = array(
					'title' =>$quarte.'/'.$year,
					'key' =>'c'.$year.$start
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
			$sql1 .= "sum(c{$year}{$start}) as c{$year}{$start},";
			$sql2 .= "c{$year}{$start}+";
			$sql3 .= "sum(case when usedate>='{$year}-{$start_usedate}' and usedate<'{$year}-{$end_usedate}' then diplomatic_agent+platform_fee ELSE 0 end) as c{$year}{$start},";
		}
		return array(
				'sql1' =>$sql1,
				'sql2' =>$sql2,
				'sql3' =>$sql3,
				'titleArr' =>$titleArr
		);
	}
	
	//按年份sql组成
	public function getTypeYearSql1($start ,$end)
	{
		$titleArr = array();
		$sql1 = '';
		$sql2 = '';
		$sql3 = '';
		for($start; $start<=$end ;$start++)
		{
			$titleArr[] = array(
					'title' =>$start.'年',
					'key' =>'c'.$start
			);
			$sql1 .= "sum(c{$start}) as c{$start},";
			$sql2 .= "c{$start}+";
				
			//12月份特殊对待
			$sql3 .= "sum(case when usedate>='{$start}-01' and usedate<'{$start}-12-32' then diplomatic_agent+platform_fee ELSE 0 end) as c{$start},";
		}
		return array(
				'sql1' =>$sql1,
				'sql2' =>$sql2,
				'sql3' =>$sql3,
				'titleArr' =>$titleArr
		);
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
	
	//导出excel
	public function exportExcel()
	{
		$employee_id=$this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$countType = empty($_REQUEST['countType']) ? 1 : $_REQUEST['countType'];
		$type = empty($_REQUEST['type']) ? 1 : $_REQUEST['type'];
		
		if ($countType ==1)
		{
			$countData = $this ->groupCodeData($employee_id ,$countType ,'excel');
		}
		else
		{
			$countData = $this ->groupDepartData($employee_id ,$countType ,'excel');
		}
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
		if ($countType == 1)
		{
			$objActSheet->setCellValue ( "A1", '团号' );
		}
		else 
		{
			$objActSheet->setCellValue ( "A1", '营业部名称' );
		}
		
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
	
		//用于获取导航头
		$firstLine = $countData[0];
		$letterArr = range('B','Z');
	
		unset($firstLine['depart_name']);
		unset($firstLine['total']);
		unset($firstLine['item_code']);
		$i = 0;
	
		$quarterArr = array(1=>'一季度',2=>'二季度',3=>'三季度',4=>'四季度');
		foreach($firstLine as $k=>$v)
		{
			if ($type == 1)
			{
				$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
				$objActSheet->setCellValue ( $letterArr[$i].'1', $k );
				$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
			}
			else if ($type == 2)
			{
				$keyArr = explode('-', $k);
	
				$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
				$objActSheet->setCellValue ( $letterArr[$i].'1', $quarterArr[$keyArr[1]].'/'.$keyArr[0] );
				$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
			}
			else
			{
				$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
				$objActSheet->setCellValue ( $letterArr[$i].'1', $k.'年' );
				$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
			}
			$i ++;
		}
		$objActSheet->getColumnDimension ( $letterArr[$i] )->setWidth ( 20 );
		$objActSheet->setCellValue ( $letterArr[$i].'1', '佣金总计' );
		$objActSheet->getStyle ( $letterArr[$i].'1' )->applyFromArray ($style_array);
	
		$i = 0;
		$count = 0;//总人数
		$columnArr = array();//统计每列的总数
		
		foreach ( $countData as $key => $val )
		{
			$item_code = $val['item_code'];
			$depart_name = $val['depart_name'];
			unset($val['depart_name']);
			unset($val['total']);
			unset($val['item_code']);
			
			$rowNum = 0;//统计一行
			foreach($val as $k =>$item)
			{
				$rowNum += $item;
			}
			if ($rowNum == 0)
			{
				continue;
			}
			
			if ($countType == 1)
			{
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $item_code, PHPExcel_Cell_DataType::TYPE_STRING );
			}
			else
			{
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $depart_name, PHPExcel_Cell_DataType::TYPE_STRING );
			}
			
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
	
			$j = 0;
			foreach($val as $k =>$item)
			{
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