<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_model extends MY_Model {

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
		$startplace_where='';
		$join_dest = '';
		foreach($whereArr as $k=>$v)
		{
			switch($k){
				case 'ls.startplace_id':
					$startplace_where .= ' ls.startplace_id in ('.$v.') ';
					break;
				case 'overcity':
					$join_dest .= ' INNER JOIN `u_line_dest` ld ON l.id=ld.line_id  AND dest_id IN (';
					foreach($v as $i){
						$join_dest .= ' '.$i.' or';
					}
					$join_dest =rtrim($join_dest ,'or'). ') ';
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
		$limitStr = ' LIMIT '.(($page-1)*$num).','.$num;
		
		$sql = 'SELECT l.id,l.linename,l.lineprice,l.mainpic,l.overcity FROM u_line as l INNER JOIN u_line_startplace AS ls ON ls.line_id = l.id AND '.$startplace_where.$join_dest.' WHERE '.$whereStr.' ORDER BY '.$orderBy.$limitStr;
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
		$join = '';
		foreach($whereArr as $key =>$val)
		{
			if (empty($val) && $val !== 0)
			{
				continue;
			}
			if ($key == 'overcity') //线路属性 or 线路目的地，多选
			{
				$join.= ' INNER JOIN `u_line_dest` ld ON l.id=ld.line_id AND dest_id IN(';
				$idx=0;
				foreach($val as $i)
				{
					$join .= ($idx>0?',':'').$i;
					$idx++;
				}
				$join.= ') ';
				
			}else if ($key == 'linetype' ){ //线路属性 or 线路目的地，多选
				
				$join.= ' INNER JOIN u_line_type lt ON l.id=lt.line_id AND attr_id IN(';
				$idx=0;
				foreach($val as $i)
				{
					$join .= ($idx>0?',':'').$i;
					$idx++;
				}
				$join.= ') ';	
			}
			elseif ($key == 'themeid')
			{
				$themeids = implode(',', $val);
				$whereStr .= ' l.themeid in ('.$themeids.') and';
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
			elseif ($key == 'status' || $key == 'producttype')
			{
				$whereStr .= " l.$key='$val' and";
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		$limitStr = 'LIMIT '.(($page-1) * $num).','.$num;

// 		$sql = 'select l.id as lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start from u_line as l where ';
		
// 		$join .= " INNER JOIN u_line_startplace AS ls ON ls.line_id = l.id AND ls.startplace_id IN (".$whereArr["l.startcity"].") ";
// 		if ($whereArr['la.expert_id'] > 0){
// 			$join .= ' INNER JOIN u_line_apply AS la ON la.line_id = l.id AND la.status=2 AND la.expert_id = '.$whereArr['la.expert_id'].' ';
// 		}
		//获取总数
		$count_sql="SELECT COUNT(l.id) AS num FROM u_line AS l ".$join." WHERE $whereStr ";
// 		echo $count_sql;
		$query = $this->db->query($count_sql, $param);
		$result = $query->result();
		$data['count'] = $result[0]->num;
		//$sql = "select l.id as lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start,count(distinct l.id) from u_line as l left join u_line_apply as la on la.line_id = l.id left join u_line_startplace as ls on ls.line_id = l.id where $whereStr group by l.id ";
		//$data['count'] = $this ->getCount($sql ,array());
		//获取列表
		
		$sub_sql = "SELECT l.id  FROM u_line AS l " .$join." WHERE ".$whereStr;
		//当没有JOIN的时候 不需要分组
		if(!empty($join)){
			$sub_sql.=" GROUP BY l.id ";
		}
		$sub_sql.=" ORDER BY ".$orderBy.' '.$limitStr;
		
// 		echo $sub_sql;
		
		$lineIds = $this ->db ->query($sub_sql) ->result_array();
		
		$sql = "SELECT l.id AS lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start";
		$sql.=" FROM u_line AS l  WHERE ";
// 			$sql.="  INNER JOIN ( SELECT l.id  FROM u_line AS l  " .$join;//.$join;
// 			$sql.=" WHERE $whereStr"; // 
// 			$sql.=" GROUP BY l.id ORDER BY ".$orderBy.' '.$limitStr." )va ON l.id=va.id ";
		$sql.="  ";
		if(!empty($lineIds)){
			$idx=0;
			foreach($lineIds as $key =>$val){
				if($idx>0){
					$sql.=" OR ";
				}
				$sql.=" l.id=".$val["id"];
				$idx++;
			}
		}else{
			//为空的时候
			$sql = $sql.' l.id=-1 ';
		}
// 		$sql = $sql.' LIMIT 10 ';
// 		echo $sql;
		$data['list'] = $this ->db ->query($sql) ->result_array();
		return  $data;
		
	}
	/**
	 * @abstract: 新版线路搜索【使用sphinx全文搜索】
	 * @param:  $whereArr=array(
				'status'=>'2',  //线路状态
				'producttype'=>'0',  //线路类型
				'linename'=>'',  //线路名称（模糊搜索内容）
				'overcity'=>array('10328','10342'),  //目的地
				'linetype'=>array('158','193'),  //线路标签
				'expert_ids'=>array('1'),   //管家
				'startplace_ids'=>array('391'),   //出发城市
				'min_price'=>'2.1', //最低价格
				'max_price'=>'1000.2', //最高价格
				'themeid'=>$themeid,  //主题id  情况一:$themeid值是一整形值，表示>$themeid；情况二:$themeid是数组，表示=$themeid数组里的值
				'lineday'=>array('min'=>$min,'max'=>$max)   //天数,范围值：$min是最小天数，$max是最大天数
		);
	 *
	 * @param: $page=当前页
	 * @param: $num=每页显示记录数
	 * @param: $orderBy=排序,如  $orderBy = 'addtime desc';  或者 $orderBy="addtime desc,status asc,producttype asc";
	 * */
	public function line_list_sphinx($whereArr,$page = 1, $num = 10 ,$orderBy = 'displayorder asc')
	{
		$this->environment_sphinx();
		$s = new SphinxClient;
		$this->load->model ( 'common/cfg_web_model','cfg_web_model');
		$data=$this->cfg_web_model->row(array('id'=>'1'));
		$s->setServer($data['serverIp'], 9312);
		//设置
		$s->setMatchMode(SPH_MATCH_ALL);
		$s->setMaxQueryTime(30);
		//where条件
		if(isset($whereArr['status']))
		{
			$where_status[]=$whereArr['status'];
			$s->SetFilter("status",$where_status);  //对应 sql_attr_uint 配置 ，条件是字符串
		}
		if(isset($whereArr['producttype']))
		{
			$where_producttype[]=$whereArr['producttype'];
			$s->SetFilter("producttype",$where_producttype);  //对应 sql_attr_uint 配置，条件是字符串
		}
		if(isset($whereArr['themeid']))
		{
			if(is_array($whereArr['themeid']))
			{
				$s->SetFilter("themeid",$whereArr['themeid']); //对应 sql_attr_uint 配置，条件是字符串
			}
			else 
			{
				$s->SetFilterRange("themeid",$whereArr['themeid'],10000);
			}
			 
		}
		if(isset($whereArr['lineday']['min'])&&isset($whereArr['lineday']['max']))
		{
			$s->SetFilterRange("lineday",$whereArr['lineday']['min'],$whereArr['lineday']['max']); //对应 sql_attr_uint 配置，条件是字符串
		}
		if(isset($whereArr['overcity']))
		{
			if(!empty($whereArr['overcity']))
			$s->SetFilter("overcity",$whereArr['overcity']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['linetype']))
		{
			if(!empty($whereArr['linetype']))
				$s->SetFilter("linetype",$whereArr['linetype']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['expert_ids']))
		{
			if(!empty($whereArr['expert_ids']))
				$s->SetFilter("expert_ids",$whereArr['expert_ids']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['startplace_ids']))
		{
			if(!empty($whereArr['startplace_ids']))
				$s->SetFilter("startplace_ids",$whereArr['startplace_ids']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['min_price'])&&isset($whereArr['max_price']))
		{
				$s->SetFilterFloatRange("lineprice",$whereArr['min_price'],$whereArr['max_price']);  //最低价、最高价
		}
		$content="";
		if(isset($whereArr['linename']))
		{
			if(!empty($whereArr['linename']))
				$content=$whereArr['linename'];   // 模糊搜索
			else 
				$content="";
		}
		
		//分页
		$from=($page-1) * $num;
		$s->SetLimits($from,$num,50000); //0-9条   5000是设置控制搜索过程中 searchd 在内存中所保持的匹配项数目
		$s->SetSortMode(SPH_SORT_EXTENDED,$orderBy);
		$res = $s->query($content,'*');//$content="古迹遗址";
		if(!empty($res['matches']))
			$ids = array_keys($res['matches']);
		//var_dump($ids);
		$str=join(",",$ids);
		$orderBy_arr="(id,".$str.")";
		
		//总记录数，用于分页
		$s->SetLimits(0,20000,50000);
		$total_result = $s->query($content,'*');//$content="古迹遗址";
		if(!empty($total_result['matches']))
			$total_ids = array_keys($total_result['matches']);
		$total_rows=count($total_ids);
		//var_dump($total_rows);
		
		if(!empty($ids)) //若全文检索结果为空
		{
		$data['list']=$this->db->query("select id AS lineid,linename,mainpic,overcity,peoplecount,all_score,comment_count,linetitle,lineprice,satisfyscore,features,comment_score,bookcount AS sales,transport,lineday,hotel_start from u_line where id in ({$str}) order by FIELD {$orderBy_arr}")->result_array();
		$data['count']=$total_rows;
		}
		else 
		{
			$data['list']=array();
			$data['count']="0";
		}
		//var_dump($data);
		return $data;
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