<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-07-27
 * @author		xml
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class B_role_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'b_role';
	
	public function __construct() {
		parent::__construct($this->table_name);
	}

	/**
	 * @method 获取角色表
	 * @param  where
	 * @return Arrary
	 * @author xml
	 */
	public function get_b_role($where='',$from="",$page_size="10"){
		$where=$this->sql_check($where);
		$sql = 'select  roleid,rolename,remark,union_id from b_role where roleid>0  ';
		if(!empty($where['name'])){
			$sql.=" and  rolename like '%{$where['name']}%'";
		}
		if(!empty($where['union_id'])){
			$sql.=" and (union_id = '{$where['union_id']}' or (roleid=1 and union_id=0))";
		}
		$sql.=' order by roleId desc';
		$data['count'] = $this ->getCount($sql, array());
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$data['data'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}

	/**
	*@method 获取角色菜单
	* @author xml
	*/
	public function getRoleDirectory($where=''){

		$where=$this->sql_check($where);
		$sql = 'select dt.name,rd.directory_id from b_role_directory as rd left join b_directory as dt on rd.directory_id=dt.directory_id where dt.isopen=1 ';
		if(isset($where['roleid']))
		{
		   $sql.=" and rd.roleid='{$where['roleid']}'";
		}

		$data= $this ->db ->query($sql) ->result_array();
		return $data;
	}
	/**
	*@method 获取角色员工
	* @author xml
	*/
	public function getRoleEmployee($where=''){
		$where=$this->sql_check($where);
		$sql = 'select ey.realname from  b_role as ro left join b_employee as ey  on ro.roleid=ey.role_id where ey.status=1 ';
		if(isset($where['role_id']))
		{
		   $sql.=" and ro.roleid='{$where['role_id']}'";
		}
		 if(isset($where['union_id'])){
		 	$sql.=" and ey.union_id='{$where['union_id']}'";
		 }
		$data= $this ->db ->query($sql) ->result_array();
		return $data;
	}
	/**
	*@method 获取菜单表
	* @author xml
	*/
	public function get_b_directory($where='',$from="",$page_size="10"){
		$where=$this->sql_check($where);
		$sql = 'select dr.directory_id,dr.code,dr.name,dr.url,dr.description,dr.pid,dr.showorder,dr.isopen,pdr.name as pname ';
		$sql .='  from b_directory as dr left join b_directory as pdr on dr.pid =pdr.directory_id where dr.directory_id>0 ';
		if(!empty($where['directory_id']))
		{
		   $sql.=" and (dr.directory_id={$where['directory_id']} or dr.pid={$where['directory_id']})";
		}
		 if(!empty($where['name'])){
		 	$sql.=" and dr.name like '%{$where['name']}%'";
		 }
		$sql .=' order by showorder asc ';
		

		$data['count'] = $this ->getCount($sql, array());
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		//$data['data'] = $this ->db ->query($sql.$this ->getLimitStr()) ->result_array();
		$data['data'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}
	
	/**
	*@method 获取菜单的角色
	* @author xml
	*/
	public function  get_directory_role($where=''){
		$where=$this->sql_check($where);
		$sql = 'select ro.rolename,ro.roleid from b_role_directory as rd left join b_role as ro on rd.roleid = ro.roleid where rd.id>0 ';
		if(isset($where['directory_id']))
		{
		   $sql.=" and rd.directory_id='{$where['directory_id']}'";
		}

		$data= $this ->db ->query($sql) ->result_array();
		return $data;
	}

	/**
	*@method 添加表
	*@author xml
	*/
	public function insert_table($table,$dataArr){
		$this->db->insert($table, $dataArr);
		return $this->db->insert_id();
	}
	/**
	 *	删除数据
	 *  $whereArr:(array)删除的条件
	 *  return:删除的数据条数
	 */
	function delete_table($table,$whereArr)
	{
		$this->db->where($whereArr);
		$this->db->delete($table); 
		return $this->db->affected_rows();
	}	
	
	/*
	 * 指定某营业部下：所有的角色
	 * */
	public function all_role($union_id)
	{
		$sql="select * from b_role where union_id='{$union_id}' or roleid=1";  //旅行社下的角色+统一管理员角色
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/*
	 * 消息提醒下的角色
	* */
	public function all_msg_role()
	{
		$sql="select * from b_employee_role";  //旅行社下的角色+统一管理员角色
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/**
	 *@method 获取菜单的角色
	 * @author xml
	 */
	public function directory_list($where='',$from="",$page_size="10"){
		$where=$this->sql_check($where);
		$where_str="";
		if(!empty($where['pid']))
			$where_str.=" and d.pid='{$where['pid']}'";
		if(!empty($where['name']))
			$where_str.=" and d.name='{$where['name']}'";
		$sql = "select 
					   d.*,d2.name as pname
				from 
						b_directory as d 
				        left join b_directory as d2 on d.pid =d2.directory_id 
				where 
					   d.isopen=1 {$where_str}
		        order by
		        		d.pid,d.showorder
				";
		if(!empty($page_size))
			$sql_page=$sql." limit {$from},{$page_size}";
		$data['total_rows']= $this ->db ->query($sql) ->num_rows();
		$data['result']= $this ->db ->query($sql_page) ->result_array();
		return $data;
	}
}