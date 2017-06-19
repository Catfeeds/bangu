<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年7月7日11:52:32
 * @author
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Essay_model extends MY_Model {

	public function __construct() {
		parent::__construct('u_expert_essay');
	}

	public function essay_row( $whereArr,$page = 1, $num = 10){
		 if($page > 0){
                        	 $res_str ='e.expert_id,e.id,e.content,e.addtime,e.praise_count,e.popularity, (SELECT pic FROM u_expert_essay_pic AS pic	WHERE	pic.expert_essay_id = e.id) AS "picnum"';
                     	  }else{
                        	   $res_str = 'count(*) AS num';
                          }
		$this->db->select($res_str);
		$this->db->from('u_expert_essay' . ' as e');
		$this->db->where($whereArr);
		$this->db->order_by('e.addtime', 'desc');
		if ($page > 0) {
			$offset = ($page -1) * $num;
			$this->db->limit($num, $offset);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}
	}

	//插入表
	public function insert_data($table,$data){
		$this->db->insert($table, $data);
		return  $this->db->insert_id();
	}
	//查询表
	public function select_essayData($where){
		$this->db->select('e.id,e.content, pic.pic, pic.id as "picid"');
		$this->db->from('u_expert_essay' . ' as e');
		$this->db->join('u_expert_essay_pic as pic', 'pic.expert_essay_id=e.id', 'left');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	//修改表
	public function update_rowdata($table,$object,$where){
		$this->db->where($where);
		$this->db->update($table, $object);
	}
}
