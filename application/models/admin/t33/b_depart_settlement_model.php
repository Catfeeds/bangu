<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_depart_settlement_model extends MY_Model {
	protected  $table= 'b_depart_settlement';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取付款数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getDepartSettlement(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select * from b_depart_settlement';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取结算单对应的订单
	 * @author jkr
	 */
	public function getSettlementOrder(array $whereArr=array() ,$orderBy = 'bo.id desc')
	{
		$sql = 'select mo.ordersn,mo.productname as linename,mo.id as orderid,mo.usedate,mo.total_price,mo.supplier_cost,mo.diplomatic_agent,mo.settlement_price,mo.expert_name,mo.agent_fee,mo.item_code from b_depart_settlement_order as bo left join u_member_order as mo on mo.id = bo.order_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取结算单的所有订单
	 * @author jkr
	 * @param unknown $settlementId
	 */
	public function getSettlementOrderAll($settlementId)
	{
		$sql = 'select mo.id as order_id,mo.agent_fee,mo.diplomatic_agent,mo.depart_status,mo.expert_id from b_depart_settlement_order as bo left join u_member_order as mo on mo.id = bo.order_id where bo.settlement_id ='.$settlementId;
		return $this ->db ->query($sql) ->result_array();
	}
	
	
	/**
	 * @method 拒绝付款申请
	 * @param unknown $settlementId
	 * @param unknown $applyArr
	 * @param unknown $payableOrder
	 */
	public function refuseApply($settlementId ,$applyArr ,$orderIds)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$settlementId) ->update('b_depart_settlement' ,$applyArr);
		//更改订单供应商结算状态
		$sql = 'update u_member_order set depart_status = 3 where id in ('.$orderIds.')';
		$this ->db ->query($sql);
		
		$this->db->trans_complete();
		return $this->db->trans_status() ;
	}
	
	
	public function throughApply($settlementId ,$applyArr ,$orderIds)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$settlementId) ->update('b_depart_settlement' ,$applyArr);
		//修改订单
		$sql = 'update u_member_order set depart_status = 2 where id in ('.$orderIds.')';
		$this ->db ->query($sql);
		
		$this->db->trans_complete();
		
		return $this->db->trans_status() ;
	}
}