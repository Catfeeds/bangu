<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Invite_service_model extends MY_Model {

	function __construct() {
		parent::__construct ( 'u_expert_service_record' );
	}

	public function get_service_data ($where_str, $page = 1, $num = 10) {
		$sql = 'SELECT sr.id AS sr_id,sr.refuse,sr.score,sr.comment,sr.expert_id,e.nickname,sr.address,sr.addtime,sr.progress,sr.service_time FROM u_expert_service_record AS sr LEFT JOIN u_expert AS e ON sr.expert_id=e.id '.$where_str;
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



	public function get_service_info($service_id){
		$sql = "SELECT sr.address,sr.addtime,sr.service_time,m.nickname FROM u_expert_service_record AS sr LEFT JOIN u_member AS m ON m.mid=sr.member_id WHERE id={$service_id}";
		$result = $this->db->query($sql)->result_array();
		return $result;
	}
}