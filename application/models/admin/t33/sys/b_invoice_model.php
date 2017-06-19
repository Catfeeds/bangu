<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_invoice_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_invoice' );
	}


	//未领取数据
	function not_received_data($whereArr,$from="",$page_size="10"){
		$whereStr = "";
		$sql = 'SELECT 
						i.id,il.id AS il_id,i.addtime AS addtime,i.invoice_name AS invoice_name,i.prefix AS prefix,
						i.start_code AS start_code,i.end_code AS end_code,i.num AS num, i.use_num AS use_num,
						(SELECT SUM(iu.use_num) from b_invoice_use iu where iu.invoice_id = i.id) AS iu_use_num,
						i.employee_name AS employee_name,i.remark AS remark 
				FROM 
						b_invoice AS i 
						LEFT JOIN b_invoice_list AS il ON i.id=il.invoice_id AND il.use_status=0 AND il.cancel_status=0 ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$sql = $sql.' GROUP BY i.id';
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
						i.id, iu.id AS use_id,iu.addtime AS addtime,i.invoice_name AS invoice_name,i.prefix AS prefix,
				        i.start_code,i.end_code,
						iu.start_code AS use_start_code,iu.end_code AS use_end_code,i.num AS total_num, iu.num AS receive_num,
						iu.expert_name AS expert_name,iu.depart_name AS depart_name,iu.employee_name AS employee_name,
						iu.use_num AS use_num,iu.cancel_num AS cancel_num,i.remark,iu.is_recover
				FROM 
						b_invoice_use AS iu 
						LEFT JOIN b_invoice AS i ON iu.invoice_id=i.id AND iu.is_recover=0 ';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		//$sql = $sql.' GROUP BY i.id';
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from)){
			$sql.=" limit {$from},{$page_size}";
		}
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
		return $return;
	}

	//未核销, 已核销, 已作废的列表数据
	function invoice_list($whereArr,$from="",$page_size="10"){
		$whereStr = "";
		$sql = 'SELECT il.id,i.batch AS batch,il.ordersn AS ordersn,i.prefix,i.invoice_name AS invoice_name,il.invoice_code AS invoice_code,il.use_time AS use_time,il.expert_name AS expert_name, il.depart_name AS depart_name,iu.employee_name AS assign_people,il.employee_name AS write_off_people,il.modtime AS modtime, il.employee_name AS cancle_people,il.modtime AS cancle_time,il.confirm_status,il.cancel_status,il.use_id FROM b_invoice_list AS il LEFT JOIN b_invoice_use AS iu ON il.use_id=iu.id LEFT JOIN b_invoice AS i ON il.invoice_id=i.id ';
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

	//查看发票列表
	function get_invoice_list($whereArr){
		$whereStr = "";
		$sql = 'SELECT 
						il.id,i.batch AS batch,il.ordersn AS ordersn,i.prefix,i.invoice_name AS invoice_name,
						il.invoice_code AS invoice_code,il.use_time AS use_time,il.expert_name AS expert_name, 
						il.depart_name AS depart_name,iu.employee_name AS assign_people,il.employee_name AS write_off_people,
						il.modtime AS modtime, il.employee_name AS cancle_people,il.modtime AS cancle_time,il.confirm_status,
						il.cancel_status,il.use_id,il.cancel_remark 
				FROM 
						b_invoice_list AS il 
						LEFT JOIN b_invoice_use AS iu ON il.use_id=iu.id 
						LEFT JOIN b_invoice AS i ON il.invoice_id=i.id ';
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

	//查看使用发票列表
	function get_use_invoice($whereArr){
		$whereStr = "";
		$sql = 'SELECT iu.*,i.prefix FROM b_invoice_use as iu left join b_invoice as i on i.id=iu.invoice_id';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$sql.=" order by iu.id desc";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}

	//查看发票列表
	function get_one_invoice($whereArr){
		$whereStr = "";
		$sql = 'SELECT * FROM b_invoice ';
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
	function get_can_use_invoice($whereArr){
		$whereStr = "";
		$sql = 'SELECT count(*) AS can_use_count FROM b_invoice_list ';
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
	function get_no_use_invoice($whereArr){
		$whereStr = "";
		$sql = 'SELECT * FROM b_invoice_list ';
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