<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月7日14:50:01
 * @author		wangxiaofeng
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expert_service_model extends MY_Model {

	public function __construct() {
		parent::__construct('u_expert_service_record');
	}

	public function get_service_list($expert_id,$status,$page = 1, $num = 10){
		$sql = "SELECT sr.id AS sr_id,sr.address,sr.addtime,sr.`comment`,sr.score,sr.progress,sr.refuse,sr.service_time,m.nickname FROM u_expert_service_record AS sr LEFT JOIN u_member AS m ON m.mid=sr.member_id WHERE sr.expert_id={$expert_id} AND  sr.progress={$status}";
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY sr.addtime DESC";
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