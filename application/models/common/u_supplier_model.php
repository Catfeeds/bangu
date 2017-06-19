<?php
/**
 * 供应商模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_supplier_model extends MY_Model {
	
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_supplier';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	//查询登录账号是否唯一
	public function uniqueLoginname($whereArr)
	{
		$sql = 'select id from u_supplier '.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 登录通过用户名获取数据
	 * @author jiakairong
	 * @param unknown $loginname 登录名
	 */
	public function getLoginData($loginname)
	{
		$sql = "select s.brand,s.password,s.id,s.status,s.login_name,s.logindatetime,s.linkman,s.realname,bs.status as bs_status from u_supplier as s left join b_company_supplier as bs on bs.supplier_id = s.id where s.login_name = '{$loginname}' order by s.id desc";
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取手机号除去已拒绝的之外的数据(一般用于注册，审核)
	 * @param unknown $mobile
	 */
	public function uniqueMobile($mobile) {
		$sql = "select link_mobile,status,id from u_supplier where (login_name='{$mobile}' or link_mobile ='{$mobile}') and status != 3";
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取邮箱号除去已拒绝的之外的数据(一般用于注册，审核)
	 * @param unknown $mobile
	 */
	public function uniqueEmail($email) {
		$sql = "select linkemail,id from u_supplier where linkemail = '{$email}' and status != 3";
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取手机号除去已拒绝和自己的之外的数据(一般用于平台拒绝后完善信息)
	 * @param unknown $mobile
	 */
	public function uniqueNoMobile($mobile ,$id) {
		$sql = "select mobile,status,id from u_supplier where (login_name='{$mobile}' or link_mobile ='{$mobile}') and status != 3 and id != {$id}";
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取邮箱号除去已拒绝和自己的之外的数据(一般用于平台拒绝后完善信息)
	 * @param unknown $mobile
	 */
	public function uniqueNoEmail($email ,$id) {
		$sql = "select linkemail,id from u_supplier where linkemail = '{$email}' and status != 3 and id != {$id}";
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 联盟合作的供应商表
	 * @param unknown 
	 */
	public function company_supplier($id) {
		$sql = "select id from b_company_supplier where supplier_id = '{$id}' ";
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 联盟合作的供应商信息 
	 */
	function get_supplier_msg($whereArr){
		$this->db->select('s.brand,s.password,s.id,s.status,s.login_name,s.logindatetime,s.linkman,s.realname,bs.status as bs_status');
		$this->db->from('u_supplier as s');
		$this->db->join('b_company_supplier AS bs', 'bs.supplier_id = s.id', 'left');
		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

}
