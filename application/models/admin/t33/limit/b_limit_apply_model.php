<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_limit_apply_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_limit_apply' );
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
			$where_str.=" and a.expert_name like '%{$where['expert_name']}%'";
		if(isset($where['manager_name']))
			$where_str.=" and a.manager_name like '%{$where['manager_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";
	
	
		$sql="
		select
				a.*,s.company_name,e.realname,mo.ordersn,
				(select sum(money) from u_order_receivable where (status=2 or status=1) and order_id=mo.id)as receive_price
		from 
				b_limit_apply as a
				left join u_supplier as s on s.id=a.supplier_id
				left join b_employee as e on e.id=a.employee_id
				left join u_member_order as mo on mo.id=a.order_id
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
	 * 信用额度申请列表
	 * @param:  联盟单位id
	 *
	 * */
	public function detail($id)
	{
		$sql="select 
					    a.*,d.name as departname,be.realname as employee_name,e.realname as expert_name,s.company_name,
					    mo.ordersn,u.union_name
			  from 
			  			b_limit_apply as a 
						left join u_expert as e on e.id=a.expert_id 
						left join u_supplier as s on s.id=a.supplier_id
						left join b_depart as d on d.id=a.depart_id
						left join b_employee as be on be.id=a.employee_id
						left join u_member_order as mo on a.order_id=mo.id
						left join b_union as u on u.id=a.union_id
						where a.id='{$id}'
				";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
}