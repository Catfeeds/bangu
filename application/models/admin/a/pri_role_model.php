<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Pri_role_model extends MY_Model {
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	private $table_name = 'pri_role';
	
	public function get_pri_role_data (array $where = array()){
		$this ->db ->select('*');
		$this ->db ->from('pri_role');
		$this ->db ->where($where);
		$this ->db ->order_by('roleId' ,'desc');
		$query  = $this ->db ->get();
		return $query ->result_array();
	}
	/**
	 * @method 获取管理员角色数据，用于平台管理
	 * @author jiakairong
	 * @since  2016-01-11
	 */
	public function getRoleData()
	{
		$sql = 'select * from pri_role ';
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by roleId desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 获取角色涉及的管理员
	 * @since  2016-01-11
	 * @author jiakairong
	 */
	public function getRoleAdmin($roleId) 
	{
		$sql = 'select a.realname,a.id from pri_adminrole as ar left join u_admin as a on a.id=ar.adminId where ar.roleId ='.$roleId;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取角色功能数据，不返回总条数
	 * @param array $whereArr
	 */
	public function getRoleResource(array $whereArr)
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
		$sql = 'select r.name,r.resourceId from  pri_resource as r left join pri_roleresource as pr on pr.resourceId = r.resourceId '.$whereStr;
		return $this ->db ->query($sql) ->result_array();
	}
}