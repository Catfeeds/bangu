<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Gross_profit_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_member_order';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ($this->table_name );
	}

	function get_data_list($whereArr, $page = 1, $num = 10){
		$this->db->select('mo.id,
				    mo.usedate AS usedate,
				    mo.ordersn AS ordersn,
				    mo.productname AS order_name,
				    mo.order_price AS total_price,
				     (mo.total_price-mo.agent_fee-(mo.order_price*mo.agent_rate))  AS cost,
				    ((mo.first_pay+mo.final_pay)*mo.agent_rate)  AS gross_profit,
				    (mo.first_pay+mo.final_pay) AS yishou,
				    (mo.jifenprice+mo.couponprice) AS zhekou,
				    e.realname AS expert_name,
				    mo.agent_fee AS agent_fee');
		$whereArr['mo.status >= ']=5;
		$this->db->from('u_member_order AS mo');
		$this->db->join('u_expert AS e','mo.expert_id=e.id','left');
		$this->db->order_by('id','desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$this->db->where($whereArr);
		$result=$this->db->get()->result_array();
		//array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	protected function _fetch_list(&$value, $key) {

	}

	function get_expert(){
		$this->db->select('id,realname');
		$this->db->from('u_expert');
		$result=$this->db->get()->result_array();
		return $result;
	}

}