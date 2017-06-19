<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_limit_apply_model extends MY_Model {
	protected  $table= 'b_limit_apply';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取申请中的申请，用于管家下单
	 * @author jkr
	 */
	public function getOrderApplyRow($expert_id)
	{
		$sql = 'select id from b_limit_apply where (status = 0 or status = 1) and expert_id='.$expert_id;
		return $this ->db ->query($sql) ->result_array();
	}
}