<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月1日16:31:27
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expert_dest_model extends UB2_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	private $table_name = 'u_expert_dest';
	
	public function __construct() {
		parent::__construct($this->table_name);
	}

	public function get_expert_dest_list($whereArr, $page = 1, $num = 10) {
		
		$this->db->select('a.addtime, b.kindname, a.status');
		$this->db->from($this->table_name . ' as a');
		$this->db->join('u_dest_base as b', 'a.dest_id = b.id', 'left');
		$this->db->where($whereArr);
		$this->db->order_by('a.addtime', 'desc');
		
		if ($page > 0) {
			$offset = ($page -1) * $num;
			$this->db->limit($num, $offset);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
}