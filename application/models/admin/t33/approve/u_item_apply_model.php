<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_item_apply_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_item_apply' );
	}

	/**
	 * 交款列表：  u_item_receivable主表
	 * @param:  联盟单位id
	 * 版本一
	 * */
	public function apply_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['depart_id']))
			$where_str.=" and a.depart_id='{$where['depart_id']}'";
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['shen_start']))
			$where_str.=" and a.modtime>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and a.modtime<='{$where['shen_end']}'";
		if(isset($where['price_start']))
			$where_str.=" and a.amount>='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and a.amount<='{$where['price_end']}'";
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";
	
	
		if(isset($where['list']))
			$where_str.=" and a.id in ({$where['list']})";
	
	
		$sql="
		select
				a.*,e.realname as expert_name,em.realname,d.name as depart_name
		from
				u_item_apply as a
				left join u_expert as e on a.expert_id=e.id
				left join b_employee as em on em.id=a.employee_id
				left join b_depart as d on d.id=a.depart_id
		where
		         a.union_id='{$where['union_id']}' {$where_str}
		";
	
		$sql.="order by a.id desc";
	    //var_dump($sql);
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 交款列表：  u_item_receivable主表
	 * @param:  联盟单位id
	 * 版本二: 按批次号group by
	 * 修改日志： 直接充值的交款不显示了，即order_id=0的交款不显示
	 * */
	public function apply_list2($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['depart_id']))
			$where_str.=" and a.depart_id='{$where['depart_id']}'";
		
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['list']))
			$where_str.=" and a.id in ({$where['list']})";
		
		$receive_where="";
		if(isset($where['ordersn']))
			$receive_where.=" and r.order_sn like '%{$where['ordersn']}%'";
		if(isset($where['shen_start']))
			$receive_where.=" and r.modtime>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$receive_where.=" and r.modtime<='{$where['shen_end']}'";
		
		
		$mo_str="";
		if(isset($where['team_code']))
			$mo_str.=" and mo.item_code like '%{$where['team_code']}%'";
		
		//having
		$having_str="";
		if(isset($where['price_start']))
			$having_str.=" and total_amount>='{$where['price_start']}'";
		if(isset($where['price_end']))
			$having_str.=" and total_amount<='{$where['price_end']}'";
		
		$expert_str="";
		if(isset($where['expert_name']))
			$expert_str.=" where e.realname like '%{$where['expert_name']}%'";
		
		$orderby="order by a.addtime desc";
		if(isset($where['status'])&&$where['status']!="1")
			$orderby="order by r.modtime desc";

		//基础where条件  batch不为空
		$sql="
		select
				a.*,e.realname as expert_name,em.realname,d.name as depart_name,r.status as approve_status,
				r.order_sn,sum(r.money)as total_amount,sum(is_urgent) as total_is_urgent,mo.item_code as team_code,
				r.batch
		from
				u_item_receivable AS ir
				INNER JOIN u_item_apply as a ON a.id=ir.item_id and a.union_id='{$where['union_id']}' {$where_str}
                INNER JOIN  u_order_receivable AS r ON r.id=ir.receivable_id and r.kind=1 and r.status={$where['status']} and r.order_id!=0 {$receive_where}
                INNER join u_member_order as mo on mo.id=r.order_id {$mo_str}
				left join u_expert as e on a.expert_id=e.id
				left join b_employee as em on em.id=a.employee_id
				left join b_depart as d on d.id=a.depart_id
				
		{$expert_str}
		GROUP BY r.batch,r.order_id
		HAVING LENGTH(r.batch)>0 {$having_str}
		{$orderby}
		
		";
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/*
	 * 交款下的交款组合
	 * */
	public function receivable_list($id,$status,$order_id)
	{
		$sql="select ir.receivable_id,item_id from u_item_receivable as ir left join u_order_receivable as r on r.id=ir.receivable_id where r.kind=1 and r.status={$status}";
		if(!empty($id))
		{
			$sql.=" and r.batch in ({$id})";
			
			if($order_id!="")
				$sql.=" and r.order_id={$order_id}";
			$return=$this->db->query($sql)->result_array();
		}
		else 
		{
			$return=array();
		}
		
	    return $return;
	}
	/*
	 * 交款下的交款组合数
	* */
	public function receivable_num($id,$status)
	{
		$return=$this->db->query("select re.* from u_item_receivable as r left join u_order_receivable as re on re.id=r.receivable_id where r.item_id='{$id}' and re.status='{$status}'")->num_rows();
		return $return;
	}
}