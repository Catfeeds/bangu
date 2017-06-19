<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_member_order_log_model extends MY_Model {
	
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_member_order_log';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取订单跟踪日志
	 * @param unknown $order_id 订单id
	 */
	public function get_order_log_data($order_id) {
		$this ->db ->select("mol.*,m.truename,m.nickname,e.realname,s.company_name,a.username");
		$this ->db ->from('u_member_order_log as mol');
		$this ->db ->join('u_member as m','m.mid = mol.userid' ,'left');
		$this ->db ->join('u_expert as e','e.id = mol.userid' ,'left');
		$this ->db ->join('u_supplier as s','s.id = mol.userid' ,'left');
		$this ->db ->join('u_admin as a','a.id = mol.userid' ,'left');
		$this ->db ->where('order_id' ,$order_id);
		return $this ->db ->get() ->result_array();
	}
}