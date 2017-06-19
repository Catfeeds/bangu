<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月17日15:30:51
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Complain_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_complain';
	
	public function __construct() {
		parent::__construct($this->table_name);
	}
	
	/**
	 * 查询专家相关的投诉记录
	 */
	public function get_expert_complain($whereArr, $page = 1, $num = 10, $type='arr') {
		
		$this->db->select('a.reason, a.addtime, c.nickname, a.approve_status, a.mobile, b.productname, a.die_reason');
		$this->db->from($this->table_name . ' as a');
		$this->db->join('u_member_order as b', 'a.order_id = b.id', 'left');
		$this->db->join('u_member as c', 'a.member_id = c.mid', 'left');
		$this->db->where($whereArr);
		
		$this->db->order_by('a.addtime', 'desc');
		
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		
		$query = $this->db->get();
		
		if($type=='obj')return $query->result();
		elseif($type=='arr')return $query->result_array();
	}
	
}
