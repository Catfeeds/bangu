<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_exchange_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_exchange' );
	}
	/**
	 * 信用额度申请列表
	 * @param:  联盟单位id
	 *
	 * */
	public function exchange_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
	
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
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";
	
	
		$sql="
		select
				a.*,e.realname as expert_name
		from 
				u_exchange as a
				left join u_expert as e on a.userid=e.id
				
		where
				a.exchange_type=1 and a.approve_type='{$where['union_id']}' {$where_str}
		";
	
		$sql.="order by a.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/*详情*/
	public function exchange_detail($where=array())
	{
		$sql="select 
						a.*,e.realname as expert_name,be.realname as employee_name 
			  from 
						u_exchange as a 
						left join u_expert as e on e.id=a.userid 
						left join u_admin as ua on ua.id=a.admin_id
						left join b_employee as be on e.id=a.admin_id
			  where 
						a.id='{$where['id']}'";
		$result=$this->db->query($sql)->row_array();
		return $result;
	}
	/*详情：u_exchange_depart表关联   */
	public function exchange_depart($id)
	{
		$sql="
				select 
						*
				from   
						u_exchange_depart
				where 
						exchange_id='{$id}'
				";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/**
	 * 结算单队员的订单列表
	 * @param:  联盟单位id
	 *
	 * */
	public function settlement_order($where,$from="",$page_size="10")
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
				so.order_id,mo.ordersn,mo.productname,mo.order_price,mo.supplier_cost,mo.diplomatic_agent,mo.settlement_price,
				mo.agent_fee,mo.usedate,
				mo.item_code,e.realname as expert_name
	    from 
				b_depart_settlement_order as so
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