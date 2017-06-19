<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:49:26
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class User_admin_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	public function get_expert($id= FALSE){
		if ($id === FALSE)
		{
			$query = $this->db->get('u_expert');
			return $query->result_array();
		}
		$query = $this->db->get_where('u_expert', array('id' => $id));
		return $query->row_array();
	}
}