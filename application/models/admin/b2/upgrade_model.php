<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月7日14:50:01
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upgrade_model extends MY_Model {

	public function __construct() {
		parent::__construct('u_expert_upgrade');
	}

	public function get_expert_data($whereArr,$where='', $page = 1, $num = 10){
		 if($page > 0){
                        		 $res_str = 'l.linecode ,l.linename ,eu.addtime ,e.realname ,eu.grade_after , e.mobile ,eu.status';
                	}else{
                        	               $res_str = 'count(*) AS num';
                         }
		$this->db->select($res_str);
		$this->db->from('u_expert_upgrade ' . 'AS eu');
		$this->db->join('u_line as l', 'l.id = eu.line_id', 'left');
		$this->db->join('u_expert AS e', 'eu.expert_id = e.id', 'left');
	       	if(!empty($where)){
	        	    $this->db->where($where);
	      	}
		$this->db->where($whereArr);
		$this->db->order_by('eu.addtime desc, eu.status asc');
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

	public function get_expert_info($whereArr=array()){
	 //   $string='case  when eu.grade_after=0 then "低级专家" when eu.grade_after=1 then "中级专家"  when eu.grade_after=2 then "高级专家" end "grade_after"';
		$this->db->select('realname,small_photo,grade');
		$this->db->from('u_expert' );
		$this->db->where($whereArr);
		/*if ($page > 0) {
			$offset = ($page - 1) * $num;
			$this->db->limit($num, $offset);
		}*/
		$query = $this->db->get();
		return $query->result_array();
	}

}