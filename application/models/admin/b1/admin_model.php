<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午2:22:17
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Admin_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	public function get_expert($login_name= FALSE){
		if ($login_name === FALSE)
		{
			$query = $this->db->get('u_expert');
			return $query->result_array();
		}
		$query = $this->db->get_where('u_expert', array('login_name' => $login_name));
		return $query->row_array();
	}
}
