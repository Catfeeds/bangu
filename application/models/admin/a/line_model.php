<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_model extends MY_Model {
	private $table_name = 'u_line';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * 获取线路数据,用于线路配置
	 * @param unknown $whereArr
	 */
	public function getCfgData($whereArr,$type='',$cityid=0)
	{
		$time = date('Y-m-d' ,time());
		$sql = 'select distinct l.linename,sp.cityname,s.company_name,l.mainpic,l.id as lineid,(select ls.adultprice from u_line_suit_price as ls where ls.lineid=l.id and ls.day>"'.$time.'" limit 1) as s_price from u_line as l left join u_supplier as s on s.id=l.supplier_id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id=ls.startplace_id';
		if ($type == 1)
		{
			$sql .= $this ->getWhereStr($whereArr).'AND (select dl.id from cfg_index_kind_dest_line as dl where dl.startplaceid = '.$cityid.' and dl.line_id=l.id limit 1) is null order by l.id desc '.$this ->getLimitStr();
		}
		else 
		{
			$sql .= $this ->getWhereStr($whereArr).' order by l.id desc '.$this ->getLimitStr();
		}
		
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * 获取线路总数，配合getCfgData方法使用，只是查询总数，所以无需获取价格
	 * @param unknown $whereArr
	 */
	public function getCfgDataCount($whereArr,$type='',$cityid=0)
	{
		$sql = 'select count(distinct l.id) as count from u_line as l left join u_supplier as s on s.id=l.supplier_id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id=ls.startplace_id';
		if ($type == 1)
		{
			$sql .= $this ->getWhereStr($whereArr).'AND (select dl.id from cfg_index_kind_dest_line as dl where dl.startplaceid = '.$cityid.' and dl.line_id=l.id limit 1) is null ';
		}
		else
		{
			$sql .= $this ->getWhereStr($whereArr);
		}
		$data = $this ->db ->query($sql) ->row_array();
		return $data['count'];
	}
	
	/**
	 * @method 获取线路数据,用于线路配置
	 * @param unknown $whereArr
	 * @param intval  $destId 目的地
	 */
	public function getCfgLineData($whereArr ,$page=1 ,$num=10 ,$destArr=array())
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($destArr))
		{
			$whereStr .= ' (';
			foreach($destArr as $v)
			{
				$whereStr .= ' find_in_set('.$v.' ,l.overcity) or';
			}
			$whereStr = rtrim($whereStr ,'or').' ) ';
		}
		$limieStr = ' limit '.($page - 1) * $num.','.$num;
		$sql = 'select l.linename,sp.cityname,s.company_name,l.mainpic,l.id as lineid,l.overcity from u_line as l left join u_supplier as s on s.id=l.supplier_id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id=ls.startplace_id where '.rtrim($whereStr ,'and').' order by l.id desc '.$limieStr;
		$linedata=$this ->db ->query($sql) ->result_array();
		return $linedata;
	}	
	/**
	 * @method 获取线路数据,用于线路配置  用于b1促销线路的选择
	 * @param unknown $whereArr
	 * @param intval  $destId 目的地
	 */
	public function getCfgB1LineData($whereArr ,$page=1 ,$num=10 ,$destArr=array())
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($destArr))
		{
			$whereStr .= ' (';
			foreach($destArr as $v)
			{
				$whereStr .= ' find_in_set('.$v.' ,l.overcity) or';
			}
			$whereStr = rtrim($whereStr ,'or').' ) ';
		}
		$limieStr = ' limit '.($page - 1) * $num.','.$num;
		$sql = 'select l.linename,sp.cityname,s.company_name,l.mainpic,l.id as lineid,l.overcity from u_line as l left join u_supplier as s on s.id=l.supplier_id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id=ls.startplace_id';
		$sql .= ' left join u_sales_line as sl on l.id=sl.lineId where '.rtrim($whereStr ,'and').'and sl.lineId is null  group by l.id order by l.id desc '.$limieStr;
		$linedata=$this ->db ->query($sql) ->result_array();
		return $linedata;
	}
	/**
	 * @method 获取线路数据(关联目的地)
	 * @param unknown $whereArr
	 * @param intval  $destId 目的地
	 */
	public function getCfgLinesData($whereArr ,$page=1 ,$num=10 ,$destid=0,$lineid=0)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($destid))
		{
			$whereStr .= ' (';
			$whereStr .= ' find_in_set('.$destid.' ,l.overcity) ';
			$whereStr .= ' ) ';
		}
		
		if (!empty($lineid))
		{
			$whereStr .=" and l.id=".intval($lineid);
		}
		$limieStr = ' limit '.($page - 1) * $num.','.$num;
		$sql = "select l.linename,sp.kindname as cityname,s.company_name,l.mainpic,l.id as lineid,l.overcity 
				from u_line as l left join u_supplier as s on s.id=l.supplier_id 
				left join u_line_dest as ls on ls.line_id = l.id 
				left join u_dest_base as sp on sp.id=".$destid." where ".rtrim($whereStr ,'and')." GROUP BY ls.line_id order by l.id desc ".$limieStr;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取管家升级数据
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 * @param unknown $likeArr
	 */
	public function get_expert_upgrade_data ($whereArr ,$page=1 ,$num =10 ,$likeArr = array() ,$orderBy = "order by eu.id desc") {
		$whereStr = '';
		$likeStr = '';
		$limitStr = '';
		if (!empty($whereArr) && is_array($whereArr)) {
			foreach($whereArr as $key =>$val) {
				if (empty($val)) {
					continue;
				}
				if ($key == 'l.startcity') {
					$whereStr .= " l.startcity in ({$val}) and";
				}
				elseif ($key == 's.id') {
					$whereStr .= " s.id in ({$val}) and";
				}
				elseif ($key == 'l.overcity') {
					$findStr = '(';
					foreach($val as $v) {
						$findStr .= " find_in_set($v ,l.overcity) or";
					}
					$findStr = rtrim($findStr ,'or');
					$whereStr .= $findStr.') and';
				}
				elseif ($key == 'e.id') {
					$whereStr .= " e.id in ($val) and";
				}
				else {
					$whereStr .= " $key = '$val' and";
				}
			}
		}
		if (!empty($likeArr) && is_array($likeArr)) {
			foreach($likeArr as $key =>$val) {
				$likeStr = " $key like '%{$val}%' and";
			}
		}
		if ($page > 0) {
			$page = empty($page) ? 1: $page;
			$num = empty($num) ? 10 :$num;
			$offset = ($page - 1) * $num;
			$limitStr = " limit $offset ,$num";
		}
		if (!empty($whereStr) && !empty($likeStr)) {
			$wl = $whereStr . rtrim($likeStr ,'and');
		} else {
			$wl = rtrim($whereStr ,'and');
		}

		$sql = "select l.linecode AS line_sn,l.linename AS line_title,l.agent_rate,s.company_name AS supplier_name,e.realname AS expert_name,eu.grade_after AS grade,eu.grade_before,eu.status,eu.id as euid,eu.expert_id,eu.line_id,eu.apply_remark,eu.refuse_remark,group_concat(sp.cityname) as cityname from (SELECT * FROM u_expert_upgrade AS en ORDER BY en.addtime DESC) AS eu left join u_line as l on eu.line_id = l.id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id = ls.startplace_id left join u_expert as e on eu.expert_id = e.id left join u_supplier as s on l.supplier_id = s.id where $wl GROUP BY eu.line_id,eu.expert_id $orderBy $limitStr ";
		$result=$this->db->query($sql)->result_array();
		//echo $this ->db ->last_query();exit;
		return $result;
	}
	/**
	 *@method B端系统的线路
	 * 
	 */
	 function b_line_list(array $whereArr=array() ,$specialSql){
	 	$groupBy='group by pl.line_id ';
	 	$sql = 'select l.id,l.linecode,pl.online_time,pl.employee_name,l.modtime as lmodtime,pl.confirm_time ,pl.modtime ,a.realname as admin_name,l.lineprice,pl.supplier_id,pl.id as pl_id,pl.remark,l.linename,';
	 	$sql .= 's.brand,s.company_name,s.linkman,pl.status,l.lineday,l.linebefore,l.linetitle,s.realname as s_name,u.union_name,group_concat(DISTINCT sp.cityname) AS startplace ';
	 	//$sql .= '(select group_concat(us.cityname) from	u_line_startplace as ls	left join u_startplace as us on ls.startplace_id = us.id	WHERE	ls.line_id = l.id) as startplace ';
	 	$sql .= 'from b_union_approve_line as pl ';
	 	$sql .= 'left join u_line as l on pl.line_id = l.id ';
	 	$sql .= 'left join u_line_startplace as ls on ls.line_id = l.id ';
	 	$sql .= 'left join u_startplace as sp on sp.id = ls.startplace_id ';
	 	$sql .= 'left join b_union as u on pl.union_id = u.id ';
	 	$sql .=' left join b_company_supplier as bs on bs.supplier_id=l.supplier_id ';
	 	$sql .= 'left join u_supplier as s on pl.supplier_id = s.id ';
	 	$sql .= 'left join u_admin as a on a.id = l.admin_id ';	 	 	
	 	return $this ->getCommonData($sql ,$whereArr ,'pl.modtime desc ',$groupBy,$specialSql);
	 }
}