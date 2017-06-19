<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Union_model extends MY_Model {
	protected  $table= 'b_union';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取旅行社的订单
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getUnionOrderData(array $whereArr=array() ,$orderBy = 'mo.id desc')
	{
		$sql = 'select mo.id as order_id,mo.ordersn,mo.platform_fee,mo.diplomatic_agent,mo.usedate,mo.supplier_cost,mo.total_price,mo.settlement_price,mo.item_code from u_member_order as mo ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取旅行社数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getUnionData(array $whereArr=array() ,$orderBy = 'u.id desc')
	{
		$sql = 'select u.*,a.realname as username,be.loginname from b_union as u left join u_admin as a on a.id = u.admin_id left join b_employee as be on be.union_id=u.id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'group by u.id');
	}
	/**
	 * @method 获取旅行社的供应商
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getUnionSupplierData(array $whereArr=array() ,$orderBy = 's.id desc')
	{
		$sql = 'select s.addtime,s.brand,s.company_name,s.realname,s.mobile,s.email,c.name as country,p.name as province,uc.name as city from b_company_supplier as cs left join u_supplier as s on s.id = cs.supplier_id left join u_area as c on c.id = s.country left join u_area as p on p.id = s.province left join u_area as uc on uc.id = s.city';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取旅行社的营业部
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getUnionDepartData(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select * from b_depart ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 判断旅行社员工登录账号
	 * @author jkr
	 */
	public function getUnionEmployee($loginname)
	{
		$sql = 'select id from b_employee where loginname = "'.$loginname.'"';
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取旅行社的所有营业部
	 * @author jkr
	 * @param unknown $unionId
	 */
	public function getUnionDepaAll($unionId)
	{
		$sql = 'select id from b_depart where status = 1 and union_id ='.$unionId;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 添加旅行社
	 * @author jkr
	 */
	public function addUnion($unionArr ,$employeeArr)
	{
		$this->db->trans_start();
		//添加旅行社
		$this->db->insert('b_union', $unionArr);
		$unionId = $this->db->insert_id();
		//添加旅行社管理员
		$employeeArr['union_id'] = $unionId;
		$this->db->insert('b_employee', $employeeArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 修改旅行社下营业部的所有管家
	 * @author jkr
	 */
	public function updateUnion($unionArr ,$unionId ,$departIds)
	{
		$this->db->trans_start();
		//修改旅行社
		$this ->db ->where('id' ,$unionId) ->update('b_union' ,$unionArr);
		if (!empty($departIds))
		{
			$time = date('Y-m-d H:i:s',time());
			//修改营业部
			$this ->db ->where('union_id' ,$unionId) ->update('b_depart' ,array('union_name' =>$unionArr['union_name'] ,'modtime' =>$time));
			//修改营业部管家
			$sql = 'update u_expert set union_name = "'.$unionArr['union_name'].'",modtime ="'.$time.'" where depart_id in ('.$departIds.') and union_id ='.$unionId;
			$this ->db ->query($sql);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 停用旅行社下营业部的所有管家
	 * @author jkr
	 */
	public function disableUnion($unionArr ,$unionId ,$departIds)
	{
		$this->db->trans_start();
		//停用旅行社
		$this ->db ->where('id' ,$unionId) ->update('b_union' ,$unionArr);
		if (!empty($departIds))
		{
			$time = date('Y-m-d H:i:s',time());
			//停用营业部
			$this ->db ->where('union_id' ,$unionId) ->update('b_depart' ,array('status' =>-1 ,'modtime' =>$time));
			//停用营业部管家
			$sql = 'update u_expert set status = -1,modtime ="'.$time.'" where depart_id in ('.$departIds.') and union_id ='.$unionId.' and status =2';
			$this ->db ->query($sql);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}