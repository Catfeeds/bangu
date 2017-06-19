<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_union_agent_apply_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_union_agent_apply' );
	}

	/**
	 * 佣金结算申请列表
	 *
	 * */
	public function yj_balance_apply($where,$from="",$page_size="")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate <='{$where['endtime']}'";
		if(isset($where['item_code']))
			$where_str.=" and mo.item_code like '%{$where['item_code']}%'";
		
		if(isset($where['status']))
			$where_str.=" and aa.status = '{$where['status']}'";
	
		/* 订单状态:
		 *     status: 1预留位(待留位)
		*             2已留位（B1已确认留位）
		*             3已确认
		*             4出团中
		*             5行程结束
		*             6已取消
		*             7改价退团
		*             left join b_union_agent_apply_order as aao on aao.order_id=r.order_id
		left join b_union_agent_apply as aa on aa.id=aao.apply_id
		**/
		$sql="
		select
				mo.*,mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,l.lineday,
				mo.supplier_cost-mo.platform_fee-mo.balance_money as nopay_money,mo.supplier_cost-mo.platform_fee as jiesuan_money,
				(select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
				(mo.platform_fee+mo.diplomatic_agent-mo.union_balance) as platform_fee_jiesuan,
				(mo.platform_fee+mo.diplomatic_agent) as all_platform_fee,aa.amount as apply_money,aa.status as apply_status
		from
				b_union_agent_apply_order as aao
				left join b_union_agent_apply as aa on aa.id=aao.apply_id
				left join u_member_order as mo on mo.id=aao.order_id
				left join u_line as l on l.id=mo.productautoid
				
	
		where
		        aa.union_id='{$where['union_id']}' {$where_str}
	
		";
	
		$sql.="order by aa.modtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
	    return $return;
	}
	
	
}