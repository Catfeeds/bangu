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

class Comment_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_comment';
	
	public function __construct() {
		parent::__construct($this->table_name);
	}
	
	/**
	 * 获取客人评论信息集合
	 */
	public function get_customer_comments($whereArr, $page = 1, $num = 10) {
		
		$this->db->select('c.linename, d.nickname, a.content, a.orderid, a.line_id, a.addtime, score5');
		$this->db->from($this->table_name . ' as a');
		
		$this->db->join('u_member_order as b', 'a.orderid = b.ordersn', 'left');
		$this->db->join('u_line as c', 'a.line_id = c.id', 'left');
		$this->db->join('u_member as d', 'a.memberid = d.mid', 'left');
		$this->db->where($whereArr);
		
		$this->db->order_by('a.addtime', 'desc');
		
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		
		
		$query = $this->db->get();
		
		//$res_arr = array();
		# 遍历结果，将同一路线下的所有评论放在一个子数组下
// 		foreach ($query->result_array() as $key => $value) {
				
// 			$res_arr[$value['line_id']]['linename'] = $value['linename'];
				
// 			$res_arr[$value['line_id']]['child'][] = array(
// 					'nickname' => $value['nickname'],
// 					'content' => $value['content']);
// 		}
		
		return $query->result_array();
	}
}