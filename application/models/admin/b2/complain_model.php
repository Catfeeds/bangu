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
		if($page > 0){
                        	 $res_str = "	c.user_name AS complain_name,
					c.addtime AS complain_time,
					c.reason AS complain_content,
					mo.productname AS proc_name,
					mo.expert_name AS expert_name,
					c.status,
					c.attachment,
					c.mobile AS mobile,
					c.remark AS advice";
                        }else{
                        	   $res_str = 'count(*) AS num';
                        }
		$this->db->select($res_str);
		$this->db->from('u_complain AS c');
		$this->db->join('u_member_order AS mo', 'c.order_id=mo.id', 'inner');
		$this->db->where($whereArr);
		$this->db->where("FIND_IN_SET(1,c.complain_type)>0");
		
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
			$query = $this->db->get();
			if($type=='obj')return $query->result();
			elseif($type=='arr')return $query->result_array();
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}
	}

}
