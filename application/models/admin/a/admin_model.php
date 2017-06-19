<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Admin_model extends MY_Model {

	private $table_name = 'u_admin';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取管理员数据，用于平台管理员管理
	 * @since  2015-01-07
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getAdminData(array $whereArr)
	{
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select * from u_admin '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 获取管理员的角色
	 * @param unknown $adminid
	 */
	public function getAdminRole($adminid)
	{
		$sql = 'select roleName,r.roleId from pri_adminrole as ar left join pri_role as r on ar.roleId = r.roleId where ar.adminId ='.$adminid;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取管理员可以操作的模块
	 * @author jiakairong
	 * @since  2016-01-13
	 */
	public function getAdminResource($adminId)
	{
		$sql = 'select r.name,r.pid,r.uri as url,r.resourceId as id from pri_adminrole as ar left join pri_roleresource as pr on ar.roleId = pr.roleId left join pri_resource as r on r.resourceId = pr.resourceId where (ar.adminId ='.$adminId.' or r.pid =0) and r.isopen =1 order by r.showorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method t33系统管理员
	 */
	function get_employee(){
		$data=array();
		$employee=array();
 		$sql=" SELECT id as union_id,union_name from b_union ";
		$union=$this ->db ->query($sql) ->result_array();
		if(!empty($union)){
			foreach ($union as $k=>$v){
				$mysql="SELECT em.realname,em.id as id from b_employee as em where union_id ={$v['union_id']}";
				$employee=$this ->db ->query($mysql) ->result_array();
				$data[$k]['union_name']=$v['union_name'];
				$data[$k]['employee']=$employee;
			}
		} 
		
		/* $mysql="SELECT em.realname,em.id as id from b_employee as em ";
		$employee=$this ->db ->query($mysql) ->result_array(); */
		//return $employee;
		return $data;
	}
	function get_employee_list(){
		 $mysql="SELECT em.realname,em.id as id from b_employee as em ";
		 $employee=$this ->db ->query($mysql) ->result_array(); 
		 return $employee;
	}
}