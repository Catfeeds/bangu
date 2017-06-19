<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 * @method 用于消息发送的各种信息获取
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Get_data_model extends MY_Model {
	protected  $table= '';

	public function __construct()
	{
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取线路信息
	 * @author jkr
	 * @param unknown $id 线路ID
	 */
	public function getLineData($id)
	{
		$sql = 'select l.linecode,bl.*,l.supplier_id from u_line as l left join b_union_approve_line as bl on bl.line_id = l.id where l.id='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取旅行社消息接收角色
	 * @author jkr
	 */
	public function getUnionRole()
	{
		$sql = 'select * from b_employee_role ';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取退款信息 
	 * @param unknown $id
	 */
	public function getRefundData($id)
	{
		$sql = 'select uo.*,mo.supplier_id,mo.depart_id,mo.ordersn,s.linkman,s.link_mobile,e.is_dm,yf.s_remark from u_order_refund as uo left join u_member_order as mo on mo.id=uo.order_id left join u_supplier as s on s.id=mo.supplier_id left join u_order_bill_yf as yf on yf.id=uo.yf_id left join u_expert as e on e.id=uo.expert_id where uo.id ='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取付款信息，用于联盟审核付款
	 * @param unknown $ids
	 */
	public function getPayableData($ids)
	{
		$sql = 'select po.*,pa.u_reply,pa.supplier_id,pa.union_id,mo.ordersn from u_payable_order as po left join u_payable_apply as pa on pa.id=po.payable_id left join u_member_order as mo on mo.id=po.order_id where po.id in ('.$ids.')';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取付款信息，用于供应商申请付款
	 * @param unknown $id
	 */
	public function getPayableApplyData($id)
	{
		$sql = 'select * from u_payable_apply where id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取交款信息
	 * @param unknown $ids
	 */
	public function getReceivableData($ids)
	{
		$sql = 'select uo.*,d.name as depart_name,mo.supplier_id from u_order_receivable as uo left join b_depart as d on d.id=uo.depart_id left join u_member_order as mo on mo.id=uo.order_id where uo.id in ('.$ids.') order by uo.id desc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取订单信息
	 * @param unknown $ids
	 */
	public function getOrderData($id)
	{
		$sql = 'select mo.id,mo.ordersn,mo.depart_id,mo.expert_id,mo.supplier_id,mo.platform_id as union_id,mo.productname as linename,mo.total_price,mo.usedate,mo.dingnum,mo.childnum,mo.childnobednum,mo.expert_name,d.name as depart_name,el.real_amount from u_member_order as mo left join b_depart as d on d.id=mo.depart_id left join b_expert_limit_apply as el on el.order_id=mo.id where mo.id = '.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取外交佣金数据
	 * @param unknown $ids
	 */
	public function getBillWjData($ids)
	{
		$sql = 'select wj.*,mo.supplier_id,mo.depart_id,mo.platform_id as union_id,mo.expert_id,mo.ordersn from u_order_bill_wj as wj left join u_member_order as mo on mo.id=wj.order_id where wj.id in ('.$ids.')';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取平台佣金数据
	 * @param unknown $ids
	 */
	public function getBillYjData($ids)
	{
		$sql = 'select yj.*,mo.supplier_id,mo.depart_id,mo.ordersn from u_order_bill_yj as yj left join u_member_order as mo on mo.id=yj.order_id where yj.id in ('.$ids.')';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 修改应付账单，数据获取
	 * @param unknown $ids 应付ID
	 */
	public function getBillYfData($ids)
	{
		$sql = 'select yf.amount,yf.order_id,yf.m_remark,yf.s_remark,yf.status,yf.id,mo.expert_name,mo.ordersn,mo.supplier_id,mo.platform_id as union_id,mo.expert_id,mo.depart_id,d.name as depart_name,d.finance_id from u_order_bill_yf as yf left join u_member_order as mo on mo.id=yf.order_id left join b_depart as d on d.id=mo.depart_id where yf.id in ('.$ids.')';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取营业部经理
	 * @author jkr
	 */
	public function getDepartManager($depart_id)
	{
		$sql = 'select id,realname from u_expert where is_dm=1 and depart_id='.$depart_id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 修改应收账单，数据获取
	 * @param unknown $ids 应收ID
	 */
	public function getBillYsData($ids)
	{
		$sql = 'select ys.*,mo.expert_name,mo.ordersn,mo.supplier_id,mo.platform_id as union_id,d.name as departName,mo.expert_id as eid from u_order_bill_ys as ys left join u_member_order as mo on mo.id=ys.order_id left join b_depart as d on d.id=ys.depart_id where ys.id in ('.$ids.')';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取额度申请的信息，用于额度消息发送
	 * @param unknown $ids 额度申请表的ID组
	 */
	public function getApplyQuota($ids)
	{
		$sql = 'select la.*,mo.ordersn from b_limit_apply as la left join u_member_order as mo on mo.id=la.order_id where la.id in ('.$ids.')';
		return $this ->db ->query($sql) ->result_array();
	}
}