<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfgm_hot_dest_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'cfgm_hot_dest' );
	}
	
	/**
	 * 获取目的地列表数据
	 * 1、国内游、周边游、出境游排名第一的目的地必定进入前三
	 * 2、peoplecount是交易量
	 * 3、国内交易量=国内交易量/3;周边交易量=交易量/6;出境游交易量不做换算处理，采实际数据
	 *   每个目的地的交易量：
	 *   (select sum((select count(1) as peoplecount from u_member_order as mo left join u_line as l on mo.productautoid=l.id where mo.ispay=2 and FIND_IN_SET(d.id,l.overcity)>0)) as total from u_dest_base as d where id=cd.dest_id or pid=cd.dest_id) as peoplecount,	
		 
		 (select count(1) from u_member_order as mo left join u_line as l on mo.productautoid=l.id where mo.ispay=2 and FIND_IN_SET(cd.dest_id,l.overcity)>0) as peoplecount,	
		 
		 (select case when cd.dest_type=1 then SUM(l.peoplecount) when cd.dest_type=2 then SUM(l.peoplecount)/3 else SUM(l.peoplecount)/6 end as total from u_member_order as mo left join u_line as l on mo.productautoid=l.id where mo.ispay=2 and FIND_IN_SET(cd.dest_id,l.overcity)>0) as peoplecount,
		
		每个目的地下的线路数量：
		(select count(1) from u_line as l where l.status='2' and FIND_IN_SET(cd.dest_id,l.overcity)>0) as num,
	 * */
	function hot_dest_list($con=array(),$from,$page_size)
	{
		
		$where="";
		$order="peoplecount desc,num desc"; //默认排序
		if(!empty($con['dest_id']))
		{
			$dest_id=$con['dest_id'];
			$where = " and cd.dest_id in ({$dest_id})";
		}
		
		if(!empty($con['dest_type']))
			$where .= " and cd.dest_type={$con['dest_type']}";
		
		if(!empty($con['startplaceid']))
			$where .= " and cd.startplaceid={$con['startplaceid']}";
		
		if(!empty($con['not_in']))
			$where .= " and cd.dest_id not in ({$con['not_in']})";
		
		if(!empty($con['content']))
			$where .= " and ud.kindname like '%{$con['content']}%'";
		
		$order="cd.showorder";
		if(!empty($con['sort']))
		{
			if($con['sort']=="2")
				$order = " num desc ";
			else if($con['sort']=="3")
				$order = " peoplecount desc ";
		}
		
		$sql="select
				cd.dest_id as id,cd.name,cd.showorder, ud.kindname as destname,cd.name as description, cd.pic as pic,cd.linenum as num,
				(select case when cd.dest_type=1 then SUM(l.peoplecount) when cd.dest_type=2 then SUM(l.peoplecount)/3 else SUM(l.peoplecount)/6 end as total from u_member_order as mo left join u_line as l on mo.productautoid=l.id where mo.ispay=2 and FIND_IN_SET(cd.dest_id,l.overcity)>0) as peoplecount
				
				from
				cfgm_hot_dest as cd
				left join u_dest_base as ud on ud.id=cd.dest_id
				where
				cd.is_show='1' and cd.status=1 {$where}
				order by {$order}
				limit {$from},{$page_size}
				";
		
		$reDataArr = $this->db->query ($sql)->result_array ();
		return $reDataArr;
	}
	
}