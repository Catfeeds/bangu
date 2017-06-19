<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月28日14:46:53
 * @author		何俊
 */
class Index_nav_model extends MY_Model {
	
	private $table_name = 'cfg_index_nav';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取导航数据,用于平台管理
	 * @param unknown $whereArr
	 */
	public function getNavData($whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'select * from cfg_index_nav '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 查询除自己之外的名称数据
	 * @param intval $id 自己的id
	 * @param string $name 查询的名称
	 */
	public function uniqueNav($id ,$name) {
		$sql = 'select id from '.$this->table_name.' where name = "'.$name.'" and id != '.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}