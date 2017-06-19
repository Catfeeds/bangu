<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_order_insurance_model extends MY_Model {
	private $table_name = 'u_order_insurance';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	
	/**
	 * @method 获取订单关联的保险(目前用于订单详情)
	 * @author jiakairong
	 * @since  2015-10-12
	 */
	public function getOrderInsurance($whereArr) {
		$this->db->select('oi.*,ti.insurance_name,ti.insurance_company,ti.insurance_date,ti.settlement_price,ti.simple_explain');
		$this->db->from($this->table_name.' as oi');
		$this->db->join('u_travel_insurance as ti','ti.id=oi.insurance_id','left');
		$this->db->where($whereArr);
		return $this->db->get()->result_array();
	}
}