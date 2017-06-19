<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_contract_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_contract' );
	}


	//未领取数据
	function not_received_data($whereArr,$from="",$page_size="10"){
		$whereStr = "";
		$sql = 'SELECT 
						c.id,cl.id AS cl_id,c.batch AS batch,c.addtime AS addtime,c.contract_name AS contract_name,
						c.prefix AS prefix,c.start_code AS start_code,c.end_code AS  end_code,c.num AS num, 
						c.use_num AS use_num,c.employee_name AS employee_name,  
						(SELECT SUM(cu.use_num) from b_contract_use cu where cu.contract_id = c.id) AS cu_use_num ,
						c.remark AS remark 
			 	FROM 
						b_contract AS c 
						LEFT JOIN b_contract_use AS cu ON cu.contract_id=c.id 
						LEFT JOIN b_contract_list AS cl ON c.id=cl.contract_id AND cl.use_status=0 AND cl.cancel_status=0 ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$sql = $sql.' GROUP BY c.id';
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size)){
			$sql.=" limit {$from},{$page_size}";
		}
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
		return $return;
	}


		//已经领取数据
	function received_data($whereArr,$from="",$page_size="10"){
		$whereStr = "";
		$sql = 'SELECT 
						c.id, cu.id AS use_id,c.batch AS batch,cu.addtime AS addtime,c.contract_name AS contract_name,
				        c.start_code,c.end_code,
						c.prefix AS prefix,cu.start_code AS use_start_code,cu.end_code AS use_end_code,c.num AS total_num, 
						c.use_num AS receive_num,cu.expert_name AS expert_name,cu.depart_name AS depart_name,
						cu.employee_name AS employee_name,cu.use_num AS use_num,cu.cancel_num AS cancel_num,c.remark 
				FROM 
						b_contract_use AS cu 
						LEFT JOIN b_contract AS c ON cu.contract_id=c.id AND cu.is_recover=0 ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		//$sql = $sql.' GROUP BY c.id';
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from)){
			$sql.=" limit {$from},{$page_size}";
		}
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
		return $return;
	}

	//未核销, 已核销, 已作废的列表数据
	function contract_list($whereArr,$from="",$page_size="10"){
		$whereStr = "";

		$sql = 'SELECT cl.id,c.batch AS batch,cl.ordersn AS ordersn,c.prefix,c.contract_name AS contract_name,cl.contract_code AS contract_code,cl.use_time AS use_time,cl.expert_name AS expert_name, cl.depart_name AS depart_name,cu.employee_name AS assign_people,cl.employee_name AS write_off_people,cl.modtime AS modtime, cl.employee_name AS cancle_people,cl.modtime AS cancle_time,cl.confirm_status,cl.cancel_status,cl.use_id FROM b_contract_list AS cl LEFT JOIN b_contract_use AS cu ON cl.use_id=cu.id LEFT JOIN b_contract AS c ON cl.contract_id=c.id ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}

		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size)){
			$sql.=" limit {$from},{$page_size}";
		}
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
		return $return;
	}

	//查看合同列表
	function get_contract_list($whereArr){
		$whereStr = "";
		$sql = 'SELECT cl.id,c.batch AS batch,cl.ordersn AS ordersn,c.prefix,c.contract_name AS contract_name,cl.contract_code AS contract_code,cl.use_time AS use_time,cl.expert_name AS expert_name, cl.depart_name AS depart_name,cu.employee_name AS assign_people,cl.employee_name AS write_off_people,cl.modtime AS modtime, cl.employee_name AS cancle_people,cl.modtime AS cancle_time,cl.confirm_status,cl.cancel_status,cl.use_id,cl.cancel_remark FROM b_contract_list AS cl LEFT JOIN b_contract_use AS cu ON cl.use_id=cu.id LEFT JOIN b_contract AS c ON cl.contract_id=c.id ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$result=$this->db->query($sql)->result_array();
		return $result;
	}

	//查看使用合同列表
	function get_use_contract($whereArr){
		$whereStr = "";
		$sql = 'SELECT cu.*,c.prefix FROM b_contract_use as cu left join b_contract as c on c.id=cu.contract_id ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$sql.=" order by cu.id desc";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}

	//查看合同列表
	function get_one_contract($whereArr){
		$whereStr = "";
		$sql = 'SELECT * FROM b_contract ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$result=$this->db->query($sql)->result_array();
		return $result[0];
	}

	//获取实际可用的合同数量
	function get_can_use_contract($whereArr){
		$whereStr = "";
		$sql = 'SELECT count(*) AS can_use_count FROM b_contract_list ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$result=$this->db->query($sql)->result_array();
		return $result[0];
	}

	//获取实际可用的发票数量
	function get_no_use_contract($whereArr){
		$whereStr = "";
		$sql = 'SELECT * FROM b_contract_list ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$sql = $sql.' ORDER BY id ASC';
		$result=$this->db->query($sql)->result_array();
		return $result;
	}

}