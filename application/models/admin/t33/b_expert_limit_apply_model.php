<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_expert_limit_apply_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_expert_limit_apply' );
	}

	/**
	 * @method 获取管家申请的信用额度，未使用的，管家下订单
	 * @param unknown $expertId
	 * @param unknown $supplierId
	 */
	public function getOrderApplyRow($expertId ,$supplierId)
	{
		$sql = 'select be.*,bl.supplier_id from  b_expert_limit_apply as be left join b_limit_apply as bl on bl.id = be.apply_id where be.status = 0 and be.expert_id = '.$expertId.' and (bl.union_id >0 or bl.supplier_id = '.$supplierId.')';
		return $this ->db ->query($sql) ->row_array();
	}
	
}