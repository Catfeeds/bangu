<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Pri_resource_model extends MY_Model {
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	private $table_name = 'pri_resource';
	
	/**
	 * @method 获取角色的功能数据
	 * @author jiakairong
	 * @since  2016-01-11
	 */
	public function getResourceData(array $whereArr)
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
		$sql = 'select pr.*,p.name as parent from pri_resource as pr left join  pri_resource p on p.resourceId = pr.pid'.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by pr.resourceId desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 获取模块涉及的角色
	 * @param unknown $resourceId
	 */
	public function getRoleResource($resourceId)
	{
		$sql = 'select r.roleName,r.roleId from pri_roleresource as pr left join pri_role as r on r.roleId = pr.roleId where pr.resourceId='.$resourceId;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 功能权限
	 * @author 贾开荣
	 * @since  2015-06-11
	 * @param array $whereArr 查询条件
	 * @param intval $number 每页条数
	 * @param intval $page_new 第几页
	 * @param intval $is_page 是否分页，主要用于统计条数
	 */
	public function get_pri_data($whereArr ,$page_new = 1 ,$number = 10 ,$is_page = 1 ,$like= array()) {
		$this->db->select ( "*" );
		$this->db->from ( 'pri_resource' );
		$this->db->where ( $whereArr );
		$this ->db ->order_by('code' ,'asc');
		if (!empty($like) && is_array($like)) {
			foreach($like as $key =>$val) {
				$this ->db ->like($key ,$val ,'after');
			}
		}
		if ($is_page == 1) {
			$number = empty ( $number ) ? 10 : $number;
			$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
			$this->db->limit ( $number, $offset );
		}
		$query = $this->db->get ();
		//echo $this ->db ->last_query();
		return $query->result_array ();
	}
}