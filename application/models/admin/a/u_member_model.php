<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_member_model extends MY_Model {
	private $table_name = 'u_member';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 给用户退回积分
	 * @param $mid 		用户id
	 * @param intval $jifen 	退回的积分
	 */
	public function backJifen($mid ,$jifen) {
		$sql = "update u_member set jifen=jifen+{$jifen} where mid = $mid";
		return $this ->db ->query($sql);
	}
}