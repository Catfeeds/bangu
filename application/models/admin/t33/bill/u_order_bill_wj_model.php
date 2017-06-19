<?php

/*
 * 订单: 应收客人表
 * */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_order_bill_wj_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_order_bill_wj' );
	}
	/**
	 * 按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function order_list($where,$from="",$page_size="10")
	{
		
		$sql.="order by A.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	
	
}