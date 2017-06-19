<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_cfg_banner_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'b_cfg_banner' );
	}
	
	/**
	 * 获取最后一条数据
	 */
	public function getLastData()
	{
		$sql = 'select * from b_cfg_banner order by id desc limit 1';
		return $this ->db ->query($sql) ->result_array();
	}
}