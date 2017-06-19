<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_model extends MY_Model {

	function __construct() {
		parent::__construct ( 'u_line' );
	}
	/**
	 * @method 获取线路信息，现用于c端下订单
	 * @param unknown $where
	 */
	public function getLineOrder(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'="'.$val.'" and';
		}
		$sql = 'select id,linename,linetitle,overcity,lineday,book_notice,mainpic,feeinclude,feenotinclude,visa_content,agent_rate_int,agent_rate_child,supplier_id,safe_alert,special_appointment,line_beizhu from u_line where '.rtrim($whereStr,'and');
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 用于平台的线路审核管理
	 * @author jiakairong
	 * @since  2016-03-15
	 * @param array $whereArr
	 */
	public function getALineData(array $whereArr = array() ,$specialSql = '')
	{
		//GROUP_CONCAT group by count(distinct l.id)
		$sql = 'select l.linecode,l.linename,l.modtime,l.addtime,s.linkman,s.company_name,l.id as line_id,l.status,l.agent_rate_int,l.overcity,l.online_time,a.realname as username,group_concat(sp.cityname) as cityname from u_line as l left join u_supplier as s on l.supplier_id = s.id left join u_admin as a on l.admin_id = a.id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id=ls.startplace_id';
		return $this ->getCommonData($sql ,$whereArr ,'l.modtime desc' ,'group by l.id',$specialSql);
	}
	
	
	/**
	 * @method 线路排序
	 * @author jiakairong
	 * @since  2015-11-12
	 */
	public function lineSortData($whereArr ,$page=1 ,$num =10 ,$orderBy = 'id desc') {
		$whereStr = '';
		foreach($whereArr as $k=>$v)
		{
			switch($k)
			{
				case 'ls.startplace_id':
					$whereStr .= ' ls.startplace_id in ('.$v.') and';
					break;
				case 'overcity':
					$whereStr .= ' (';
					foreach($v as $i)
					{
						$whereStr .= ' find_in_set ('.$i.' , l.overcity) > 0 or';
					}
					$whereStr =rtrim($whereStr ,'or'). ') and';
					break;
				case 'l.themeid':
					$whereStr .= ' l.themeid >0 and';
					break;
				default:
					$whereStr .= " $k = '$v' and";
					break;
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		$limitStr = ' limit '.(($page-1)*$num).','.$num;
		
		$sql = 'select l.id,l.linename,l.lineprice,l.mainpic,l.overcity from u_line as l left join u_line_startplace as ls on ls.line_id = l.id where '.$whereStr.' order by '.$orderBy.$limitStr;
		return $this ->db ->query($sql) ->result_array($sql);
	}
	
	/**
	 * 获取满足条件的线路
	 * @author 贾开荣
	 * @param array $where  条件
	 * @param intval $page		当前页
	 * @param intval $num	每页数量
	 * @param string $order_by	排序
	 * @return array
	 */
	public function getLineData($whereArr,$page = 1, $num = 10 ,$orderBy = 'l.displayorder asc') {
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			if (empty($val) && $val !== 0)
			{
				continue;
			}
			if ($key == 'l.linetype' || $key == 'l.overcity') //线路属性 or 线路目的地，多选
			{
				$whereStr .= ' (';
				foreach($val as $i)
				{
					$whereStr .= ' find_in_set ('.$i.' , '.$key.') > 0 or';
				}
				$whereStr =rtrim($whereStr ,'or'). ') and';
			}
			elseif ($key == 'l.themeid')
			{
				$whereStr .= ' l.themeid in ('.$val.') and';
			}
			elseif ($key == 'theme')
			{
				$whereStr .= ' l.themeid > 0 and';
			}
			elseif ($key == 'keyword') //关键词
			{
				$whereStr .= ' (l.linename like "%'.$val.'%" or l.linetitle like "%'.$val.'%") and';
			}
			elseif ($key == 'l.startcity' || $key == 'la.expert_id')
			{
				//$whereStr .= ' ls.startplace_id in ('.$val.') and';
			}
			else
			{
				$whereStr .= " $key='$val' and";
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		
		$limitStr = 'LIMIT '.(($page-1) * $num).','.$num;

// 		$sql = 'select l.id as lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start from u_line as l where ';
		
		$join = " INNER JOIN u_line_startplace AS ls ON ls.line_id = l.id AND ls.startplace_id IN (".$whereArr["l.startcity"].") ";
		if ($whereArr['la.expert_id'] > 0){
			$join .= ' INNER JOIN u_line_apply AS la ON la.line_id = l.id AND la.status=2 AND la.expert_id = '.$whereArr['la.expert_id'].' ';
		}
		
		
		//获取总数
		$count_sql="SELECT COUNT(l.id) AS num FROM u_line AS l  WHERE $whereStr ";
// 		echo $count_sql;
		$query = $this->db->query($count_sql, $param);
		$result = $query->result();
		$data['count'] = $result[0]->num;
		//$sql = "select l.id as lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start,count(distinct l.id) from u_line as l left join u_line_apply as la on la.line_id = l.id left join u_line_startplace as ls on ls.line_id = l.id where $whereStr group by l.id ";
		//$data['count'] = $this ->getCount($sql ,array());
		//获取列表
		$sql = "SELECT l.id AS lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start";
		$sql.=" FROM u_line AS l  ";
// 			$sql.=" INNER JOIN ( SELECT l.id  FROM u_line AS l  " ;//.$join;
			$sql.=" WHERE $whereStr"; // GROUP BY l.id
			$sql.=" ORDER BY ".$orderBy.' '.$limitStr;
// 		$sql.=" )va ON l.id=va.id ";
// 		$sql = $sql..$whereStr.' ORDER BY '.$orderBy.' '.$limitStr;
		$data['list'] = $this ->db ->query($sql) ->result_array();
		return  $data;
		
	}
	
	/**
	 * 搜索线路接口
	 */
	public function get_line_list($where,$order_by,$from,$page_size){
		$sql = "SELECT l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,ceil(l.satisfyscore* 100) as satisfyscore,l.comment_count as comments,l.peoplecount as bookcount,(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume FROM u_line AS l WHERE l. STATUS = 2 {$where}{$order_by} LIMIT {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$data['line_list']= $query->result_array ();
		return $data['line_list'];
	}	
		/**
	 * 查询总记录数
	 */
	public function get_line_list_total_rows($where,$order_by){
		$sql = "select count(*) as cont FROM (SELECT l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,l.satisfyscore,(SELECT COUNT(*) FROM u_comment AS c WHERE c.line_id = l.id ) AS comments,(SELECT	SUM(mo.dingnum + mo.childnum+mo.childnobednum+mo.oldnum) FROM u_member_order AS mo WHERE	l.id = mo.productautoid AND mo. STATUS > 4) AS people,(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume FROM u_line AS l WHERE l. STATUS = 2  {$where}{$order_by} ) temp";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
/*
*
*        do     add order 
*
*        by     zhy
*
*        at     2015年12月30日 15:30:04
*
*/
	public function add_order_expert($ll_id,$ee_id){
		$sql = "select e.realname AS expert_name,e.expert_type,l.supplier_id,s.company_name AS supplier_name,l.linename AS productname,l.mainpic AS litpic from u_line AS l left join u_line_apply AS la on la.line_id=l.id left join u_expert AS e on e.id=la.expert_id left join u_supplier AS s on s.id=l.supplier_id where e.id={$ee_id} and l.id={$ll_id}";
		$query = $this->db->query ( $sql );
		$info = $query->result_array ();
		return ($info);
	}
/*
*
*        do     add order 		rate
*
*        by     zhy
*
*        at     2015年12月30日 15:32:00
*
*/
	public function add_order_agent_rate($ll_id){
		$sql = "select agent_rate from u_line where id = {$ll_id}";
		$query = $this->db->query ( $sql );
		$agent_rate = $query->result_array ();
		return ($agent_rate);
	}
/*
*
*        do     add order 				othen
*
*        by     zhy
*
*        at     2015年12月30日 15:32:51
*
*/
	public function add_order_info($ll_id,$ee_id){
		$sql = "select e.realname AS expert_name,l.supplier_id,s.company_name AS supplier_name,l.linename AS productname,l.mainpic AS litpic from u_line AS l left join u_line_apply AS la on la.line_id=l.id left join u_expert AS e on e.id=la.expert_id left join u_supplier AS s on s.id=l.supplier_id where e.id={$ee_id} and l.id={$ll_id}";
		$query = $this->db->query ( $sql );
		$info = $query->result_array ();
		return ($info);
	}
}