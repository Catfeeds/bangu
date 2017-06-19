<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_nav_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'cfg_index_nav' );
	}
	
	public function get_nav_data() {
		$whereArr = array('is_show' =>1);
		$data = $this ->all($whereArr ,'showorder');
		return $data;
	}
}