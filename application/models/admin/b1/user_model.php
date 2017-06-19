<?php
/****
 * 深圳海外国际旅行社
 * 艾瑞可
 * 2015-3-18
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class User_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_last_ten_supplier($login_name){			//查询数据
					$this->db->select('*');
					$this->db->from('u_supplier');
					$this->db->where('login_name',$login_name);//这里要用session
		$query = $this->db->get();
		return $query->result();
	}
	function insert_supplier($supplier){					//插入数据
		$this->db->insert('u_supplier',$supplier);
	}
	
	function upload_supplier($data,$where){
		$this->db->trans_start();

		$this->db->where($where);
	   	 $this->db->update('u_supplier', $data);

		$this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		return false;
	    	}else{
	    		return true;
	    	}

	} 
	function upload_expert($data,$where){
		$this->db->where($where);
		$this->db->update('u_expert', $data);
	}
	function get_expert_service($login_name){
		$this->db->select('visit_service');
		$this->db->from('u_expert	');
		$this->db->where('login_name',$login_name);//这里要用session
		$query = $this->db->get();
		return $query->result();
	}
	//遍历交通方式表
	public function description_data($type){
		$query = $this->db->query('SELECT dict_id,description FROM  u_dictionary WHERE pid IN (SELECT dict_id FROM  u_dictionary WHERE dict_code ="'.$type.'" ) ORDER BY showorder ASC');
		$rows = $query->result_array();
		return $rows;
	}
	public function get_last_user($where,$userid){
		$this->db->select('id');
		$this->db->from('u_supplier');
		$this->db->where($where);//这里要用session
		$this->db->where('id !='.$userid);
		$query = $this->db->get();
		return $query->row_array();
	}
}