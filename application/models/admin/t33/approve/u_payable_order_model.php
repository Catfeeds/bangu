<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_payable_order_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_payable_order' );
	}
	/*
	 * 申请中、已通过、已付款
	* */
	public function apply_order($order_id)
	{
		$sql="select sum(amount_apply) as amount_apply from u_payable_order where order_id={$order_id} and (status=1 or status=2 or status=4)";
		
		$result=$this->db->query($sql)->row_array();
		return $result;
	}
}