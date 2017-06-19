<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Member_traver_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_member_traver' );
	}
	
	public function get_traver_data ($whereArr) {
		$this ->db ->select ('mt.*,mom.order_id');
		$this ->db ->from('u_member_order_man as mom');
		$this ->db ->join('u_member_traver as mt' ,'mt.id = mom.traver_id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('mom.id');
		return $this ->db ->get() ->result_array();
	}
}