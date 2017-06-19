<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_payable_apply_model extends MY_Model {
	protected  $table= 'u_payable_apply';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取付款数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getPayableApplyData(array $whereArr=array() ,$orderBy = 'pa.id desc')
	{
		$sql = 'select pa.*,s.company_name as supplier_name from u_payable_apply as pa left join u_supplier s on s.id = pa.supplier_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}

	/**
	 * @method 获取供应商付款申请信息
	 * @param unknown $id
	 */
	public function getPayableApplyRow($id)
	{
		$sql = 'select pa.*,s.company_name as supplier_name from u_payable_apply as pa left join u_supplier s on s.id = pa.supplier_id where pa.id='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取付款单对应的订单信息
	 * @author jkr
	 */
	public function getPayableOrderData(array $whereArr=array() ,$orderBy = 'po.id desc')
	{
		$sql = 'select po.amount_apply,mo.ordersn,mo.supplier_cost,mo.balance_money,mo.balance_complete,mo.id as order_id,mo.productname as linename,mo.usedate,mo.item_code,mo.balance_status from u_payable_order as po left join u_member_order as mo on mo.id = po.order_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取一个付款申请的订单信息
	 * @param unknown $payable_id
	 */
	public function getPayableOrderAll($payable_id)
	{
		$sql = 'select po.amount_apply,po.order_id,mo.ordersn,(mo.supplier_cost-mo.balance_money) as balance,mo.balance_status,mo.balance_complete from u_payable_order as po left join u_member_order as mo on mo.id = po.order_id where po.payable_id ='.$payable_id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 拒绝付款申请
	 * @param unknown $payable_id
	 * @param unknown $applyArr
	 * @param unknown $payableOrder
	 */
	public function refuseApply($payable_id ,$applyArr ,$orderIds)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$payable_id) ->update('u_payable_apply' ,$applyArr);
		//更改订单供应商结算状态
		$sql = 'update u_member_order set balance_status = 0 where id in ('.$orderIds.')';
		$this ->db ->query($sql);
		
		$this->db->trans_complete();
		return $this->db->trans_status() ;
	}
	
	
	public function throughApply($payable_id ,$applyArr ,$payableOrder)
	{
		$this->db->trans_start();
		$this ->db ->where('id' ,$payable_id) ->update('u_payable_apply' ,$applyArr);
		//修改订单
		foreach($payableOrder as $v)
		{
			$balance = round($v['balance'] - $v['amount_apply'],3);
			if ($balance == 0)
			{
				//全部结算完成
				$balance_complete =  2;
				$balance_status = 2;
			} else {
				$balance_complete = 1;
				$balance_status = 0;
			}
			$sql = 'update u_member_order set balance_money=balance_money+'.$v['amount_apply'].',balance_complete ='.$balance_complete.',balance_status='.$balance_status.' where id = '.$v['order_id'];
			$this ->db ->query($sql);
		}
		
		$this->db->trans_complete();
		
		return $this->db->trans_status() ;
	}
}