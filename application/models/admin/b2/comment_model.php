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
		 if($page > 0){
                        	 $res_str ="	c.id AS comment_id,
					l.linename AS line_name,
					mb.truename AS member_name,
					c.expert_content AS content,
					c.reply1 AS s_reply,
					c.reply2 AS a_reply,
					c.addtime AS addtime,
					c.avgscore2 AS score";
                        }else{
                        	   $res_str = 'count(*) AS num';
                        }
		$this->db->select($res_str);
		$this->db->from('u_comment AS c');
		$this->db->join('u_line AS l', 'c.line_id = l.id', 'left');
		$this->db->join('u_member AS mb', 'c.memberid = mb.mid', 'left');
		$this->db->order_by('c.addtime','desc');
		$this->db->where($whereArr);
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
			$query = $this->db->get();
			return $query->result_array();
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}

	}

	function reply_comment($comment_content,$comment_id){
		$comment_sql = "UPDATE u_comment SET reply='$comment_content' where id=" . $comment_id;
		$status = $this->db->query ( $comment_sql );
		return $status;
	}
}