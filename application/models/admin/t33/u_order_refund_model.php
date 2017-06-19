<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_order_refund_model extends MY_Model {
	protected  $table= 'u_order_refund';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取退款数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getOrderRefundData(array $whereArr=array() ,$sqlWhere= '' ,$orderBy = 'r.id desc')
	{
		$sql = 'select r.*,mo.ordersn,mo.item_code,mo.usedate,mo.platform_fee,mo.total_price,mo.dingnum,mo.childnum,mo.childnobednum,mo.oldnum,l.linename,l.lineday,e.realname as expert_name,e.depart_name,mo.balance_money,mo.supplier_cost from u_order_refund as r left join u_member_order as mo on mo.id=r.order_id left join u_line as l on l.id=mo.productautoid left join u_expert as e on e.id = r.expert_id left join u_line_startplace as ls on ls.line_id = l.id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'group by r.id',$sqlWhere);
	}
	
	/**
	 * @method 获取一条信息
	 * @param unknown $refundId
	 */
	public function getOrderRefundRow($refundId)
	{
		$sql = 'select r.*,mo.ordersn,mo.productname as linename,mo.dingnum,mo.childnum,mo.childnobednum,mo.oldnum,mo.total_price,mo.balance_money,mo.supplier_cost,mo.platform_fee from u_order_refund as r left join u_member_order as mo on mo.id=r.order_id where r.id ='.$refundId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取供应商退款申请
	 * @param unknown $id
	 */
	public function getSupplierRefund($id)
	{
		$sql = 'select * from u_supplier_refund where id = '.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 通过退团退款审核
	 * @author jkr
	 */
	public function through($refundId ,$refundArr ,$orderArr ,$orderId)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$refundId) ->update('u_order_refund' ,$refundArr);
		
		$this ->db ->where('id' ,$orderId) ->update('u_member_order' ,$orderArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}