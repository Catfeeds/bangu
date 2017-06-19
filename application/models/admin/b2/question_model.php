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
		 if($page > 0){
                        	 $res_str ='que.id AS id,
					 mb.nickname AS truename,
					 l.linename AS linename,
					 que.addtime AS addtime,
		 			que.content AS content,
					que.email,
					que.replycontent AS replycontent';
                        }else{
                        	   $res_str = 'count(*) AS num';
                        }

		$this->db->select($res_str);
		$this->db->from('u_line_question AS que');
		$this->db->join('u_line AS l', 'que.productid=l.id', 'left');
		$this->db->join('u_member AS mb', 'que.memberid = mb.mid', 'left');
		$this->db->order_by('que.addtime','desc');
		$this->db->where($whereArr);

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
	/*未回复*/
	public function get_expert_noquestions($whereArr, $page = 1, $num = 10,$expert_id) {
		 if($page > 0){
                        	 $res_str ='que.id AS id,
					 mb.nickname AS truename,
					 l.linename AS linename,
					 que.addtime AS addtime,
				     que.email,
		 			que.content AS content,
					que.replycontent AS replycontent';
                        }else{
                        	   $res_str = 'count(*) AS num';
                        }


		$this->db->select($res_str);
		$this->db->from('u_line_apply as la');
		$this->db->join('u_line_question AS que','que.productid = la.line_id','right');
		$this->db->join('u_line AS l', 'que.productid=l.id', 'left');
		$this->db->join('u_member AS mb', 'que.memberid = mb.mid', 'left');
		$this->db->order_by('que.addtime','desc');

		$this->db->where("((la.expert_id=$expert_id AND que.reply_id=0) OR (que.reply_id=$expert_id AND reply_type=1) ) AND ISNULL(que.replytime) > 0");
		//$whereArr['la.status'] = 2;
		$this->db->where($whereArr);
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

	function reply_question($reply_content,$expert_id,$question_id){
		$sql = "UPDATE u_line_question SET replycontent ='$reply_content',replytime=now(),reply_type = 1,reply_id = $expert_id WHERE id = $question_id";
		$status = $this->db->query($sql);
		return $status;
	}
}