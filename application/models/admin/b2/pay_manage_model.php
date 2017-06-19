<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:00:11
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pay_manage_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}


	public function get_pay_list($whereArr,$page = 1, $num = 10){
		$sql = 'SELECT e.realname,e.depart_name,rev.way,rev.order_sn,rev.bankcard,rev.bankname,md.productname,sum(rev.money) AS toal_money,app.* FROM u_item_apply  AS  app LEFT JOIN u_item_receivable AS ir ON ir.item_id=app.id LEFT JOIN u_order_receivable AS rev ON rev.id=ir.receivable_id LEFT JOIN u_member_order AS md ON md.id=app.order_id LEFT JOIN u_expert AS e ON e.id=app.expert_id WHERE FIND_IN_SET('.$this->session->userdata('depart_id').',e.depart_list)>0';
        $sql .=" and (rev.way='转账' or rev.way='现金' or (rev.way='账户余额' and (md.status=4 or md.status=5 or md.status=6 or md.status=7 or md.status=8)))";
			 $whereStr = '';
			if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' AND '.$whereStr;
			}
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." GROUP BY app.id ORDER BY app.addtime DESC";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$sql = $sql." GROUP BY app.id ORDER BY app.addtime DESC";
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}



	//获得交款记录的数据 WHERE rev.depart_id='.$this->session->userdata('depart_id').'
	public function get_pay_order_data($whereArr,$page = 1, $num = 10) {
		$sql = 'SELECT e.realname,e.depart_name,md.total_price,rev.* FROM u_order_receivable AS  rev LEFT JOIN u_member_order AS md ON md.id=rev.order_id LEFT JOIN u_expert AS e ON e.id=rev.expert_id WHERE FIND_IN_SET('.$this->session->userdata('depart_id').',e.depart_list)>0';
        $sql .=" and (rev.way='转账' or rev.way='现金' or (rev.way='账户余额' and (md.status=4 or md.status=5 or md.status=6 or md.status=7 or md.status=8)))";
			 $whereStr = '';
			if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' AND '.$whereStr;
			}
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY rev.id DESC";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}

	//获得一条交款记录详情
	public function get_pay_one_data($receive_id) {
		$sql = 'SELECT e.realname,e.depart_name,md.total_price,rev.* FROM u_order_receivable AS  rev LEFT JOIN u_member_order AS md ON md.id=rev.order_id LEFT JOIN u_expert AS e ON e.id=rev.expert_id WHERE  rev.id='.$receive_id;
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result[0];
	}

	public function get_pay_data($whereArr=array()) {
		$where_str = '';
		$sql = 'SELECT e.realname,e.depart_name,rev.* FROM u_order_receivable AS  rev LEFT JOIN u_item_receivable AS ir ON ir.receivable_id = rev.id LEFT JOIN u_member_order AS md ON md.id=rev.order_id  LEFT JOIN  u_expert AS e ON e.id=rev.expert_id ';
			if(!empty($whereArr)){
		 		foreach ($whereArr as $key => $value) {
		 			if($key!="filter_data"){
		 				$where_str .= $key.'=\''.$value.'\' AND ';
		 			}else{
		 				$where_str .= " (rev.way='转账' or rev.way='现金' or (rev.way='账户余额' and (md.status=4 or md.status=5 or md.status=6 or md.status=7 or md.status=8)))";
		 			}
		 		}
	 			$where_str = rtrim($where_str,' AND ');
	 			$sql .= ' WHERE '.$where_str;
	 		}
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
	}

	public function get_sum_money($receive_ids){
		$sql = 'SELECT SUM(money) AS sum_money FROM u_order_receivable WHERE id IN ('.$receive_ids.')';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}


	public function get_receive_ids($apply_id){
		$sql = 'SELECT GROUP_CONCAT(receivable_id) AS receive_ids FROM u_item_receivable WHERE item_id IN('.$apply_id.')';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}



	//获取营业部信息
 	function get_depart_bank($whereArr=array()){
 		/*$where_str = '';
 		$sql = 'SELECT db.bankcard,db.bankname,db.id AS bank_id FROM  b_depart_bank AS db  ';
 		if(!empty($whereArr)){
	 		foreach ($whereArr as $key => $value) {
	 			$where_str .= $key.'='.$value.' AND ';
	 		}
 			$where_str = rtrim($where_str,' AND ');
 			$sql .= ' WHERE '.$where_str;
 		}
		$depart = $this->db->query($sql)->result_array();
		return $depart;*/
		$sql = 'SELECT bankcard ,bankname  FROM  b_union WHERE  id='.$this->session->userdata('union_id');
		$bank_info = $this->db->query($sql)->result_array();
		return $bank_info[0];
 	}

 	//获取营业部信息
 	function get_depart($whereArr=array()){
 		$where_str = '';
 		$sql = 'SELECT dep.* FROM b_depart AS dep  ';
 		if(!empty($whereArr)){
	 		foreach ($whereArr as $key => $value) {
	 			$where_str .= $key.'='.$value.' AND ';
	 		}
 			$where_str = rtrim($where_str,' AND ');
 			$sql .= ' WHERE '.$where_str;
 		}

		$depart = $this->db->query($sql)->result_array();
		return $depart[0];
 	}

}