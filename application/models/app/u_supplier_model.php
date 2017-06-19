<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_supplier_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'u_supplier' );
	}
	/**
	 * @method 供应商数据，用于平台管理
	 * @author jkr
	 * @param unknown $whereArr
	 * @param string $orderBy
	 */
	public function getSupplierData(array $whereArr ,$orderBy='s.id desc')
	{
		$sql = 'select s.id,s.addtime,s.link_mobile,a.realname as username,s.modtime,s.agent_rate,s.brand,s.company_name,s.refuse_reason,s.linkman,s.realname,s.mobile,s.email,c.name as country,p.name as province,uc.name as city from u_supplier as s left join u_area as c on c.id = s.country left join u_area as p on p.id = s.province left join u_area as uc on uc.id = s.city left join u_admin as a on a.id=s.admin_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	/**
	 * @method 获取供应商详细信息
	 * @author jkr
	 * @param unknown $id
	 */
	public function getSupplierDetail($id)
	{
		$sql = 'select s.*,c.name as country_name,p.name as province_name,ct.name as city_name from u_supplier as s left join u_area as c on c.id=s.country left join u_area as p on p.id=s.province left join u_area as ct on ct.id=s.city where s.id='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 通过供应商审核验证手机号唯一
	 * @author jkr
	 * @param unknown $mobile
	 * @param unknown $id
	 */
	public function throughSupplierMobile($mobile ,$id)
	{
		$sql = 'select id from u_supplier where (login_name = "'.$mobile.'" or mobile = "'.$mobile.'") and status != 3 and status != 1 and id != '.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 管家审核通过时，查询邮箱是否存在
	 * @author jkr
	 * @param unknown $mobile
	 * @param unknown $id  审核记录ID
	 */
	public function throughSupplierEmail($email ,$id)
	{
		$sql = 'select id from u_supplier where email = "'.$email.'" and status != 3 and status != 1 and id != '.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 冻结供应商
	 * @author jiakairong
	 * @since  2015-12-01
	 */
	public function frozenSupplier($suppplier_id ,$supplierArr ,$platformArr)
	{
		$this->db->trans_start();
		//更新供应商表
		$this ->db ->where(array('id' =>$suppplier_id));
		$this ->db ->update('u_supplier' ,$supplierArr);
		//下线所有线路
		$sql = 'update u_line set status=3,modtime="'.$supplierArr['modtime'].'",refuse_remark="平台终止与供应商合作，下线线路" where supplier_id='.$suppplier_id.' and status = 2';
		$this ->db ->query($sql);
		//写入黑名单
		$this ->db ->insert('u_platform_refuse' ,$platformArr);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 恢复与供应商的合作
	 * @author jiakairong
	 * @since  2015-12-02
	 */
	public function recoverySupplier($supplier_id)
	{
		$this->db->trans_start();
		//更新供应商表
		$sql = 'update u_supplier set status = 2 ,modtime ="'.date('Y-m-d H:i:s').'" where id='.$supplier_id;
		$this ->db ->query($sql);
		//更新黑名单
		$sql = 'update u_platform_refuse set status = -1 where userid ='.$supplier_id.' and refuse_type = 2';
		$this ->db ->query($sql);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
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
}