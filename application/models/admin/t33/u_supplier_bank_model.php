<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:11
 * @author		温文斌
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class U_supplier_bank_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_supplier_bank';
	
	public function __construct() 
	{
		parent::__construct($this->table_name);
	}
	
	public function supplier_info($supplier_id)
	{
		$sql="select 
				    sb.*,s.company_name,s.brand as supplier_brand
				from 
				     u_supplier as s 
				     left join u_supplier_bank as sb on sb.supplier_id=s.id
				where s.id={$supplier_id}";
		$result=$this->db->query($sql)->row_array();
		return $result;
	}
	
}