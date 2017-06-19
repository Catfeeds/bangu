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

class Credit_approval_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}
	public function get_data_list($whereArr=array(), $page = 1, $num = 10) {
		$sql = 'SELECT e.realname,s.company_name,unn.union_name,elp.id AS ep_id,elp.status AS ep_status,  elp.real_amount,app.*,md.ordersn,elp.return_amount FROM b_limit_apply AS  app LEFT JOIN b_expert_limit_apply AS elp ON elp.apply_id=app.id LEFT JOIN u_member_order AS md ON md.id=app.order_id LEFT JOIN u_supplier AS s ON s.id=app.supplier_id LEFT JOIN b_union AS unn ON unn.id=app.union_id LEFT JOIN u_expert AS e ON e.id=app.manager_id LEFT JOIN u_expert AS e2 ON e2.id = app.expert_id ';
		$whereStr = '';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				if($key!="app.depart_id"){
					$whereStr .= ' '.$key.'"'.$val.'" and';
				}else{
					$whereStr .= ' FIND_IN_SET('.$val.',e2.depart_list)>0 and';
				}

			}
			$whereStr = rtrim($whereStr ,'and');
			$sql = $sql.' WHERE '.$whereStr;
		}

		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." GROUP BY app.id ORDER BY app.id DESC";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$sql = $sql." GROUP BY app.id ORDER BY app.id DESC";
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}

	public function get_one_data($whereArr=array()) {
		$sql = 'SELECT e.realname,s.company_name,unn.union_name,elp.id AS ep_id,elp.status AS ep_status, elp.order_id, elp.real_amount,app.* FROM b_limit_apply AS  app LEFT JOIN b_expert_limit_apply AS elp ON elp.apply_id=app.id LEFT JOIN u_member_order AS md ON md.id=elp.order_id LEFT JOIN u_supplier AS s ON s.id=app.supplier_id LEFT JOIN b_union AS unn ON unn.id=app.union_id LEFT JOIN u_expert AS e ON e.id=app.manager_id';
		$whereStr = '';
			if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				if($key!="id_in"){
					$whereStr .= ' '.$key.'"'.$val.'" and';
				}else{
					$whereStr .= ' id in('.$val.') and';
				}

			}
			$whereStr = rtrim($whereStr ,'and');
			$sql = $sql.' WHERE '.$whereStr;
		}
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
	}

	public function is_using_data($expert_id){
		$sql = 'SELECT elp. id  FROM  b_expert_limit_apply AS elp WHERE  elp.expert_id='.$expert_id.' AND elp.status=0  limit 1';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result)){
			return $result[0];
		}else{
			return array();
		}
	}
	public function is_applying_data($expert_id){
		$sql = 'SELECT app. id  FROM  b_limit_apply AS app WHERE  app.expert_id='.$expert_id.' AND (app.status=0 OR app.status=1 )  limit 1';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result)){
			return $result[0];
		}else{
			return array();
		}
	}

	public function get_debit_data($whereArr=array()){
		$sql = 'SELECT *  FROM  	u_order_debit ';
		$whereStr = '';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
					$whereStr .= ' '.$key.'"'.$val.'" and';
			}
			$whereStr = rtrim($whereStr ,'and');
			$sql = $sql.' WHERE '.$whereStr;
		}
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
}