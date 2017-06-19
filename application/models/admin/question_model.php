<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月17日12:17:00
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_line_question';
	
	public function __construct() {
		parent::__construct($this->table_name);
	}
	
	public function get_expert_questions($whereArr, $page = 1, $num = 10) {
		$this->db->select('q.nickname, q.addtime, l.linename, q.content,q.replycontent');
		$this->db->from($this->table_name . ' as q');
		$this->db->join('u_line as l', 'q.productid = l.id', 'left');
		$this->db->where($whereArr);
		
		if ($page > 0) {
			$offset = ($page - 1) * $num;
			$this->db->limit($num, $offset);
		}
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
}