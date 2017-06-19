<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_union_agent_apply_model extends MY_Model {
	protected  $table= 'b_union_agent_apply';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取旅行社佣金结算数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getUnionAgentData(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select * from b_union_agent_apply';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}

	/**
	 * @method 获取供应商付款申请信息
	 * @param unknown $id
	 */
	public function getUnionAgentRow($id)
	{
		$sql = 'select * from b_union_agent_apply where id='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取结算单对应的订单
	 * @author jkr
	 */
	public function getAgentOrderData(array $whereArr=array() ,$orderBy = 'bo.id desc')
	{
		$sql = 'select mo.id as order_id,mo.ordersn,mo.platform_fee,mo.diplomatic_agent,mo.usedate,mo.supplier_cost,mo.total_price,mo.settlement_price,mo.item_code,bo.money,mo.union_balance from b_union_agent_apply_order as bo left join u_member_order as mo on mo.id = bo.order_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取结算单的所有订单
	 * @param unknown $agentId
	 */
	public function getAgentOrderAll($agentId)
	{
		$sql = 'select bo.order_id,bo.money,mo.platform_fee,mo.diplomatic_agent,mo.union_balance from b_union_agent_apply_order as bo left join u_member_order as mo on mo.id = bo.order_id where bo.apply_id ='.$agentId;
		return $this ->db ->query($sql) ->result_array();
	}
	
	public function getRowData($applyId)
	{
		$sql = 'select ua.*,u.linkmobile from b_union_agent_apply as ua left join b_union as u on u.id=ua.union_id where ua.id='.$applyId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取结算总金额
	 * @param unknown $agent_id
	 * @author jkr
	 */
	public function getAgentAmount($agent_id)
	{
		$sql = 'select sum()';
	}
	
	/**
	 * @method 拒绝结算申请
	 * @author jkr
	 */
	public function refuseAgentApply($applyArr ,$agentId)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$agentId) ->update('b_union_agent_apply' ,$applyArr);

		
		$this->db->trans_complete();
		return $this->db->trans_status() ;
	}
	
	/**
	 * @method 通过结算申请
	 * @author jkr
	 */
	public function throughAgentApply($applyArr ,$orderAll ,$agentId ,$agentData)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$agentId) ->update('b_union_agent_apply' ,$applyArr);
		//更改订单旅行社结算金额
		foreach($orderAll as $v)
		{
			$sql = 'update u_member_order set union_balance = union_balance+'.$v['money'].' where id ='.$v['order_id'];
			$this ->db ->query($sql);
		}
		
		//更改旅行社佣金结算额
		$sql = 'update b_union set not_settle_agent = not_settle_agent -'.$agentData['amount'].',settle_agent=settle_agent+'.$applyArr['real_amount'].' where id ='.$agentData['id'];
		$this ->db ->query($sql);
	
		$this->db->trans_complete();
		return $this->db->trans_status() ;
	}
	
}