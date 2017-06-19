<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_expert_limit_apply_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_expert_limit_apply' );
	}
	/**
	 * 信用额度使用情况
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
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";
	
	
		$sql="
		select
				a.*,la.addtime as apply_time,la.id as apply_id,
				mo.ordersn
		from
				b_expert_limit_apply as a
				left join b_limit_apply as la on a.apply_id=la.id
				left join u_member_order as mo on mo.id=a.order_id
		where
				la.union_id='{$where['union_id']}' {$where_str}
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
	 * 信用额度来源
	 * @param: id
	 * */
	public function limit_apply_detail($id)
	{
		$sql="
				select
						la.*,s.company_name,n.union_name
				from
						b_expert_limit_apply as a
						left join b_limit_apply as la on a.apply_id=la.id
						left join u_supplier as s on la.supplier_id=s.id
						left join b_union as n on n.id=la.union_id
				where
						a.id='{$id}'
		";
		
		$data=$this->db->query($sql)->row_array();
		return $data;
	}
	/**
	 * 信用额度来源
	 * @param: order_id
	 * */
	public function limit_apply_detail2($order_id)
	{
		$sql="
		select
				a.*,s.company_name,n.union_name,la.union_id,la.supplier_id,la.manager_id,
				la.addtime as limit_addtime
		from
				b_expert_limit_apply as a
				left join b_limit_apply as la on a.apply_id=la.id
				left join u_supplier as s on la.supplier_id=s.id
				left join b_union as n on n.id=la.union_id
		where
				a.status=1 and a.order_id='{$order_id}'
		";
	
		$data=$this->db->query($sql)->row_array();
		return $data;
	}
}