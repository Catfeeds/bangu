<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_member_order_invoice_model extends MY_Model {
	
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_member_order_invoice';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取订单发票信息
	 * @author jiakairong
	 */
	public function getOrderInvoice($whereArr) {
		$this ->db ->select('mi.*');
		$this ->db ->from($this->table.' as oi');
		$this ->db ->join('u_member_invoice as mi' ,'mi.id = oi.invoice_id' ,'left');
		$this ->db ->where($whereArr); 
		return $this ->db ->get() ->result_array();
	}
}