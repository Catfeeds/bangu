<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月26日10:50:53
 * @author		汪晓烽
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supplier_model extends MY_Model {

	private $table_name = 'u_supplier';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取供应商数量
	 * @param unknown $status
	 */
	public function getSupplierCount($status)
	{
		$sql = 'select count(*) as count from u_supplier where status = '.$status;
		$countArr = $this ->db ->query($sql) ->result_array();
		return $countArr[0]['count'];
	}
	/**
	 * @method 添加管家时验证手机
	 * @param unknown $mobile
	 */
	public function uniqueMobileAdd($mobile)
	{
		$sql = 'select id from u_supplier where (login_name="'.$mobile.'" or mobile = "'.$mobile.'") and status !=3';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 添加管家时验证邮箱
	 * @param unknown $email
	 */
	public function uniqueEmailAdd($email)
	{
		$sql = 'select id from u_supplier where email="'.$email.'" and status !=3';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 *  @method 添加管家时验证邮箱
	 *  @param supplier_id
	 *  @method xml
	 */
	function get_supplier_secret(){
		$sql = 'SELECT sk.*,s.* from u_supplier_secretKey as sk left join u_supplier as s on sk.supplierId=s.id ';
		return $this ->db ->query($sql) ->result_array();
	}

}