<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_order_refund_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_order_refund' );
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
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and yf.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and yf.addtime<='{$where['endtime']}'";
		if(isset($where['status']))
			$where_str.=" and r.status ='{$where['status']}'";
	
	
		$sql="
		select
				r.*,e.realname,d.name as depart_name,mo.ordersn,ys.addtime,mo.total_price,
				 (select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price
				 
		from
				u_order_refund as r
				left join u_expert as e on e.id=r.expert_id
				left join b_depart as d on e.depart_id=d.id
				left join u_order_bill_ys as ys on ys.id=r.ys_id
			
				left join u_member_order as mo on mo.id=r.order_id
				
		where
		(r.status=2 or r.status=3) and e.union_id='{$where['union_id']}' {$where_str}
				";
	
	    $sql.="order by r.id desc";
	
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
				r.*,e.realname,d.name as depart_name,mo.ordersn,yf.addtime,mo.total_price,
				mo.platform_fee,mo.supplier_cost-mo.platform_fee as jiesuan_price,
				 (mo.platform_fee+mo.diplomatic_agent) as all_platform_fee,
				 mo.supplier_cost-mo.platform_fee-mo.balance_money-mo.diplomatic_agent as nopay_money,
				 (select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
		
				 (select sum(apply_amount) from b_expert_limit_apply where order_id=r.order_id)as apply_amount,
				 mo.usedate,mo.balance_money,mo.supplier_id,mo.dingnum,mo.oldnum,mo.childnum,mo.childnobednum,
				 mo.productautoid as line_id,mo.productname as line_name,sp.company_name,mo.suitnum,
				 sr.refund_money,sr.id as supplier_refund_id,srp.core_pic
				 
		from
				u_order_refund as r
				left join u_expert as e on e.id=r.expert_id
				left join b_depart as d on e.depart_id=d.id
				left join u_order_bill_yf as yf on yf.id=r.yf_id
				left join u_member_order as mo on mo.id=r.order_id
				left join u_supplier_refund as sr on sr.yf_id=r.yf_id
				left join u_supplier_refund_pic as srp on srp.refund_id=sr.id
				left join u_supplier as sp on sp.id=mo.supplier_id
				
		where
		r.id='{$where['id']}' 
				";

		$return=$this->db->query($sql)->row_array();
		return $return;
	}

}