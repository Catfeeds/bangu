<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月26日10:50:53
 * @author		汪晓烽
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supplier_secret_key_model extends MY_Model {

	private $table_name = 'u_supplier_secretKey';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	function get_supplier_key($supplier_id){
		$sql = "SELECT sk.*,s.realname from u_supplier_secretKey as sk left join u_supplier as s on sk.supplierId=s.id where sk.supplierId={$supplier_id}";
		$countArr = $this ->db ->query($sql) ->row_array();
		return $countArr;
	}
	

	/**
	 * @method 获取消息
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getSupplierKeyData(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select sk.*,s.* from u_supplier_secretKey as sk left join u_supplier as s on sk.supplierId=s.id  ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	/**
	 * @method 供应商数据，用于平台供应商对接管理
	 * @author xml
	 * @param unknown $whereArr
	 * @param string $orderBy
	 */
	public function getSupplierApiData(array $whereArr ,$orderBy='s.id desc' ,$num=false)
	{
		// where s.id not in (SELECT supplierId FROM u_supplier_secretKey)
		$sql = 'select s.id,s.expert_business,s.addtime,s.link_mobile,a.realname as username,s.modtime,s.agent_rate,s.brand,s.company_name,s.refuse_reason,s.linkman,s.realname,s.mobile,s.email,c.name as country,p.name as province,uc.name as city from u_supplier as s left join u_area as c on c.id = s.country left join u_area as p on p.id = s.province left join u_area as uc on uc.id = s.city left join u_admin as a on a.id=s.admin_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'' ,'' ,$num);
	}
}
