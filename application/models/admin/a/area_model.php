<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Area_model extends MY_Model
{
	private $table_name = 'u_area';
	
	function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取地区数据，用于平台管理 
	 * @param array $whereArr
	 */
	public function getAreaData(array $whereArr)
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
		$sql = 'select a.*,ua.name as parent_name from u_area as a left join u_area as ua on a.pid = ua.id'.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	
	/**
	 * @method 获取上级
	 * @param unknown $id
	 */
	public function getParents($id) {
		$sql = 'select a.id,ua.id as parentid from u_area as a left join u_area as ua on ua.id = a.pid where a.id = '.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取所有的城市，用于地区联动
	 * @author jkr
	 * @since  2016-05-19
	 */
	public function getSelectAreaAll()
	{
		$sql = 'select id,name,enname,pid,isopen,simplename,level,ishot from u_area order by pid asc,displayorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
}