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

class B_employee_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'b_employee';
	
	public function __construct() 
	{
		parent::__construct($this->table_name);
	}
	/**
	 * 获取用户所在的旅行社
	 *@author xml
	 * */
	public function detail($employee_id){
		$employee_id=$this->sql_check($employee_id);
		$sql="select e.*,n.union_name,n.bankname,n.bankcard,n.city,role.rolename from b_employee as e  left join b_union  as n on e.union_id=n.id left join b_role as role on role.roleid=e.role_id where e.id='{$employee_id}'";
		$result=$this->db->query($sql)->row_array();
		return $result;
	}
	/**
	 * 获取指定角色id的菜单导航
	 * @param:
	 *         array(
	 *         'role_id'=>     
	 *         )
	 * */
	public function get_role_menu($where)
	{
		$where=$this->sql_check($where);
		$sql="select d.*,r.roleid from b_role_directory as r left join b_directory as d on r.directory_id=d.directory_id where d.isopen=1";
		if(isset($where['role_id']))
		   $sql.=" and r.roleid='{$where['role_id']}'";
		$sql.="order by d.showorder";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}

	/**
	 * 获取用户所在的旅行社
	*@author xml
	 * */
	public function get_employee_union($where=array()){
		$where=$this->sql_check($where);
		$sql="select uon.*,s.cityname,s.pid as province_id,s2.cityname as province_name from b_employee as emp  left join b_union  as uon on emp.union_id=uon.id left join u_startplace as s on s.id=uon.city left join u_startplace as s2 on s2.id=s.pid where emp.id > 0 ";
		if(isset($where['employee_id']))
		   $sql.=" and emp.id='{$where['employee_id']}'";
		$result=$this->db->query($sql)->row_array();
		return $result;
	} 
	/**
	*@method 获取员工数据
	*/
	public function get_employee_data($where='',$from="",$page_size="10"){
		$where=$this->sql_check($where);
		$sql = 'SELECT em.*,ro.rolename from b_employee as em LEFT JOIN b_role as ro on em.role_id=ro.roleid where em.id >0 ';
		if(isset($where['union_id'])){

		           $sql.=" and em.union_id='{$where['union_id']}'";
		}
		if(!empty($where['name'])){
			$sql.=" and em.realname like '%{$where['name']}%'";
		}
		if(!empty($where['moblie'])){
			$sql.=" and em.mobile='{$where['moblie']}'";
		}
		$sql .=' order by em.id  desc ';
		$data['count'] = $this ->getCount($sql, array());
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$data['data'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}
	
}