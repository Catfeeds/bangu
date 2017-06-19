<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Search_condition_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'cfg_search_condition' );
	}
	//根据标志码获取其下级
	public function get_search_data($code ,$order_by='') {
		$sql = "select sc.* from cfg_search_condition as sc where pid = (select s.id from cfg_search_condition as s where s.code = '{$code}') {$order_by}";
		return $this ->db ->query($sql) ->result_array();
	}
	
}