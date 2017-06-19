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

class Answer_model extends MY_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */	
	private $table_name = 'u_test_answer';
	
	public function __construct() {
		parent::__construct($this->table_name);
	}
	
	/**
	 * 获取专家申请线路答案,where条件中必须要有线路id
	 * 
	 * @param $aray $whereArr
	 * @param number $page
	 * @param number $num
	 * @return array
	 */
	public function get_line_apply_answers($whereArr, $page = 1, $num = 10) {
		
		$this->db->select('a.id, b.question, a.answer, a.addtime');
		$this->db->from($this->table_name . ' as a');
		$this->db->join('u_topic as b', 'a.topic_id = b.id', 'left');
		$this->db->where($whereArr);
		$this->db->order_by('a.addtime', 'desc');
		
		if($page == 0) $page = 1;
		$offset = ($page-1) * $num;
		$this->db->limit($num, $offset);
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
}