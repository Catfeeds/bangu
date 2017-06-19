<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_supplier_refund_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_supplier_refund' );
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
		
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['company_name']))
			$where_str.=" and s.company_name like '%{$where['company_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and r.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and r.addtime<='{$where['endtime']}'";
		if(isset($where['shen_start']))
			$where_str.=" and r.modtime>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and r.modtime<='{$where['shen_end']}'";
		if(isset($where['status']))
			$where_str.=" and r.status ='{$where['status']}'";
	
	
		$sql="
		select
				r.*,mo.ordersn,mo.productname,mo.item_code,mo.total_price,mo.platform_fee,mo.supplier_cost-mo.platform_fee as jiesuan_price,
		        mo.usedate,(mo.dingnum+mo.oldnum+mo.childnum+mo.childnobednum)as total_num,l.lineday,e.realname,d.name as depart_name,
		        (select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
		        mo.productautoid,s.company_name,mo.balance_money as mo_balance_money
		from
				u_supplier_refund as r
				left join u_member_order as mo on mo.id=r.order_id
				left join u_supplier as s on s.id=r.supplier_id
				left join u_line as l on mo.productautoid=l.id
				left join u_expert as e on e.id=mo.expert_id
				left join b_depart as d on e.depart_id=d.id
				
		where
		r.union_id='{$where['union_id']}' {$where_str}
				";
	
	    $sql.="order by r.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 详情
	 * @param:  联盟单位id
	 *
	 * */
	public function detail($where)
	{
		$where=$this->sql_check($where);
		$sql="
		select
				r.*,mo.ordersn,mo.productname,mo.item_code,mo.total_price,mo.platform_fee,mo.supplier_cost-mo.platform_fee as jiesuan_price,
				mo.usedate,(mo.dingnum+mo.oldnum+mo.childnum+mo.childnobednum)as total_num,l.lineday,e.realname,d.name as depart_name,
				(select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
				mo.productautoid,s.company_name,mo.balance_money as mo_balance_money,rp.core_pic
		from
				u_supplier_refund as r
				left join u_member_order as mo on mo.id=r.order_id
				left join u_supplier as s on s.id=r.supplier_id
				left join u_line as l on mo.productautoid=l.id
				left join u_expert as e on e.id=mo.expert_id
				left join b_depart as d on e.depart_id=d.id
				left join u_supplier_refund_pic as rp on rp.refund_id=r.id
		where
				r.id='{$where['id']}'
		";

		$return=$this->db->query($sql)->row_array();
		return $return;
	}

}