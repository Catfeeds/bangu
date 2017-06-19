<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_item_apply_model extends MY_Model {
	protected  $table= 'u_item_apply';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取交款数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getItemApplyData(array $whereArr=array() ,$orderBy = 'ia.id desc')
	{
		$sql = 'select ia.*,u.union_name,d.name as depart_name,e.realname as expert_name from u_item_apply as ia left join b_union as u on u.id=ia.union_id left join b_depart as d on d.id= ia.depart_id left join u_expert as e on e.id=ia.expert_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}

	/**
	 * @method  获取交款信息
	 * @author jkr
	 * @param unknown $itemid
	 */
	public function getItemApplyRow($itemid)
	{
		$sql = 'select ia.*,u.union_name,d.name as depart_name,e.realname as expert_name from u_item_apply as ia left join b_union as u on u.id=ia.union_id left join b_depart as d on d.id= ia.depart_id left join u_expert as e on e.id=ia.expert_id where ia.id ='.$itemid;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取交款单的付款信息
	 * @author jkr
	 */
	public function getItemReceivableData(array $whereArr=array() ,$orderBy = 'ir.id desc')
	{
		$sql = 'select r.*,mo.ordersn,e.realname as expert_name,mo.total_price,mo.settlement_price,mo.item_code from u_item_receivable as ir left join u_order_receivable as r on r.id=ir.receivable_id left join u_member_order as mo on mo.id = r.order_id left join u_expert as e on e.id = r.expert_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
}