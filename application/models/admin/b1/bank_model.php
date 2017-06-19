<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:55:53
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Bank_model extends MY_Model{
	function __construct()
	{
		parent::__construct('u_supplier_bank');
	}
	public function get_bank_info($id){
			$this->db->select('*');
			$this->db->from('u_supplier_bank');
			$this->db->where(array('supplier_id'=>$id));
			$query = $this->db->get();
			$res = $query->row_array();
		
			return $res;
			
	}


	public function update_bank_info($data=array(),$bank_info_id=''){
		if(empty($bank_info_id)){
				$this->db->insert('u_supplier_bank', $data);
				return $this->db->insert_id();
		}else{
				$status = $this->db->update('u_supplier_bank', $data, array('id' => $bank_info_id));
				return $status;
		}
	}

}