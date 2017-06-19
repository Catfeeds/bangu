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

class Credit_record_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}
	public function get_record_list($whereArr=array(),$page = 1, $num = 10,$depart_in="") {
		$sql = "
				SELECT 
						bl.*,md.ordersn,md.total_price,e.realname
				 FROM 
						b_limit_log AS  bl 
						LEFT JOIN u_member_order AS md ON md.id=bl.order_id  
						LEFT JOIN u_expert AS e ON e.id = bl.expert_id
				WHERE   
			            bl.depart_id in ({$depart_in})
				";
		/*if(array_key_exists('bl_depart_id', $whereArr)){
			$sql .= ' OR bl.depart_id='.$whereArr['bl_depart_id'];
			unset($whereArr['bl_depart_id']);
		}*/
		$whereStr = '';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				if($key!="bl.depart_id IN"){
					$whereStr .= ' '.$key.'"'.$val.'" AND';
				}else{
					$whereStr .= ' '.$key.'("'.$val.'") AND';
				}
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' AND '.$whereStr;
		}
		
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY bl.addtime DESC";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
		
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}

}