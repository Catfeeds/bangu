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

class Month_account_model extends MY_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	private $table_name = 'u_month_account';

	public function __construct() {
		parent::__construct($this->table_name);
	}


	function get_account_linfo($expert_id,$order_id){
  		$this->db->select("ex.realname AS creator,
  					ma.startdatetime AS start_time,
  					ma.enddatetime AS end_time,
		 			ma.addtime AS create_time,
		 			ma.beizhu AS beizhu");
		$this->db->from("u_month_account_order AS mao");
		$this->db->join('u_month_account AS ma', 'mao.month_account_id = ma.id', 'left');
		$this->db->join('u_expert AS ex', 'ma.userid = ex.id', 'left');
  		$where['ma.account_type'] = 1;
  		$where['ex.id'] = $expert_id;
  		$where['mao.id'] = $order_id;
  		$this->db->where($where);
  		$query = $this->db->get();
  		//return $this->db->last_query();
  		return $query->result_array();



	}

	function get_order_list($order_id){
	 $this->db->select("mao.id AS order_id,
		mo.id AS order_id,
		mo.ordersn AS order_sn,
		mo.productname AS proc_title,
		(mo.childnum + mo.dingnum) AS  people_count,
		mo.usedate AS use_date,
		mo.total_price AS order_amount,
		mo.agent_fee AS set_amount,
		l.agent_rate_int AS agent_rate_int
		");
		$this->db->from("u_month_account_order AS mao");
		$this->db->join('u_member_order AS mo', 'mao.order_id=mo.id', 'left');
		$this->db->join('u_line AS l', 'mo.productautoid=l.id', 'left');
  		$where['mao.month_account_id'] = $order_id;
  		$this->db->where($where);
  		$query = $this->db->get();
  		return $query->result_array();
	}

	function get_account_statement($whereArr, $page = 1, $num = 10){
            $this->db->select("ma.id AS id,
		mao.order_id AS order_id,
		startdatetime AS startdatetime,
		enddatetime AS enddatetime,
		ma.addtime AS addtime,
		ma.account_mode AS account_mode,
           		ma.amount AS amount,
           		ma.real_amount AS real_amount,
           		ma.beizhu AS beizhu,
		ma.status AS ma_status
           		");
		$this->db->from("u_month_account_order AS mao");
		$this->db->join('u_month_account AS ma', 'mao.month_account_id = ma.id', 'left');
		$whereArr['ma.account_type']=1;
  		$this->db->where($whereArr);
  		$this->db->order_by('addtime','desc');
  		$this->db->group_by('id');
  		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
  		$query = $this->db->get();
  		return $query->result_array();

	}
}