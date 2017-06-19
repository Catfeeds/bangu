<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_depart_settlement_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_depart_settlement' );
	}
	/**
	 * 信用额度申请列表
	 * @param:  联盟单位id
	 *
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
			$where_str.=" and a.a_time>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and a.a_time<='{$where['shen_end']}'";
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";
	
	
		$sql="
		select
				a.*,e.realname as expert_name,em.realname,d.name as depart_name
		from 
				b_depart_settlement as a
				left join u_expert as e on a.expert_id=e.id
				left join b_employee as em on em.id=a.employee_id
				left join b_depart as d on d.id=a.depart_id
		where
		a.union_id='{$where['union_id']}' {$where_str}
		";
	
		$sql.="order by a.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 结算单队员的订单列表
	 * @param:  联盟单位id
	 *
	 * */
	public function settlement_order($where,$from="",$page_size="")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn='{$where['ordersn']}'";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'";

		$sql="
		select 
				so.order_id,s.status,mo.ordersn,mo.productname,mo.order_price,mo.total_price,mo.supplier_cost,mo.diplomatic_agent,mo.settlement_price,
				mo.agent_fee,mo.usedate,
				mo.item_code,e.realname as expert_name
	    from 
				b_depart_settlement_order as so
				left join b_depart_settlement as s on s.id=so.settlement_id
				left join u_member_order as mo on mo.id=so.order_id
				left join u_expert as e on e.id=mo.expert_id
		where
				so.settlement_id='{$where['id']}' {$where_str}
				";
	
		$sql.="order by so.id desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	
	
}