<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_month_account_model extends MY_Model {
	protected  $table= 'b_month_account';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取旅行社佣金结算数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getMonthAccount(array $whereArr=array() ,$orderBy = 'ma.id desc')
	{
		$sql = 'select ma.*,s.company_name as supplier_name from b_month_account as ma left join u_supplier as s on s.id= ma.supplier_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}

	/**
	 * @method 获取供应商结算信息
	 * @param unknown $id
	 */
	public function getMonthAccountRow($id)
	{
		$sql = 'select ma.*,s.company_name as supplier_name from b_month_account as ma left join u_supplier as s on s.id= ma.supplier_id where ma.id='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取结算单对应的订单
	 * @author jkr
	 */
	public function getAccountOrderData(array $whereArr=array() ,$orderBy = 'ma.id desc')
	{
		$sql = 'select ma.order_id,mo.ordersn,mo.total_price,mo.supplier_name,mo.supplier_cost,mo.balance_money,u.union_name,ea.real_amount,ea.status as apply_status from b_month_account_order as ma left join u_member_order as mo on mo.id = ma.order_id left join b_union as u on u.id = mo.platform_id left join  b_expert_limit_apply as ea on ea.order_id = mo.id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取结算单的所有订单
	 * @param unknown $agentId
	 */
	public function getAccountOrderAll($accountId)
	{
		$sql = 'select ma.order_id,mo.balance_status,mo.balance_complete from b_month_account_order as ma left join u_member_order as mo on mo.id = ma.order_id where ma.month_account_id ='.$accountId;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 拒绝结算申请
	 * @author jkr
	 */
	public function refuseAccount($accountArr ,$orderIds ,$accountId)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$accountId) ->update('b_month_account' ,$accountArr);
		//更改订单供应商结算状态
		$sql = 'update u_member_order set balance_status = 0 where id in ('.$orderIds.')';
		$this ->db ->query($sql);
		
		$this->db->trans_complete();
		return $this->db->trans_status() ;
	}
	
	/**
	 * @method 通过结算申请
	 * @author jkr
	 */
	public function throughAccount($accountArr ,$orderIds ,$accountId)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$accountId) ->update('b_month_account' ,$accountArr);
		//更改订单旅行社结算状态
		$sql = 'update u_member_order set balance_status = 2,balance_money=supplier_cost,balance_complete=2 where id in ('.$orderIds.')';
		$this ->db ->query($sql);
	
		$this->db->trans_complete();
		return $this->db->trans_status() ;
	}
	
}