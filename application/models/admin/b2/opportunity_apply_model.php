<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:11
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opportunity_apply_model extends MY_Model {

	public function __construct() {
		//parent::__construct('u_opportunity_apply');
		parent::__construct('u_opportunity');
	}


	public function get_opportunity_apply_list($whereArr, $page = 1, $num = 10) {
		 if($page > 0){
                        	 $res_str = 'op.id as id ,op.begintime,op.starttime ,op.addtime ,op.spend,op.address ,op.title,op.modtime ,op.endtime, op.people ,op.description  , opa.expert_id ,opa.status as  mystatus,op.sponsor,op.status, op.people ,op.description ,opa.id as opid, opa.expert_id ';
                        }else{
                        	   $res_str = 'count(*) AS num';
                        }

		$this->db->select($res_str);
		$this->db->from($this->table.' as op' );
		$this->db->join('u_opportunity_apply as opa', 'op.id = opa.opportunity_id', 'left');
        $this->db->where('op.publisher_type = 3 or (op.publisher_type = 2 and (1 in (SELECT  la.expert_id FROM u_line AS l  LEFT JOIN u_line_apply AS la ON la.line_id = l.id where l.supplier_id=op.publisher_id and l.`status`=2))) and (op.`status`=1 OR op.`status`=2 OR op.`status`=0 ) ');
		$this->db->where($whereArr);
		$this->db->order_by('op.addtime','desc');
		if ($page > 0) {
			$offset = ($page - 1) * $num;
			$this->db->limit($num, $offset);
			$query = $this->db->get();
			return $query->result_array();
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}
	}

	public function opportunity_row($id,$where){
		$query_sql  ='UPDATE u_opportunity_apply ';
		$query_sql.= 'SET STATUS = '.$where ;
		$query_sql.=' WHERE id ='.$id;
		$query = $this->db->query($query_sql);
		return $query->row_array();

	}
	public function opportunity_insert($data){
		return $this->db->insert('u_opportunity_apply', $data);
	}
	//修改
	public function update_opportunity($id){
		$query_sql  ='UPDATE u_opportunity ';
		$query_sql.= 'SET apply_count =apply_count+1' ;
		$query_sql.=' WHERE id ='.$id;
		return  $query = $this->db->query($query_sql);
	}
	//修改
	public function dis_opportunity($id){
		$query_sql  ='UPDATE u_opportunity ';
		$query_sql.= 'SET apply_count =apply_count-1' ;
		$query_sql.=' WHERE id ='.$id;
		return  $query = $this->db->query($query_sql);
	}
}