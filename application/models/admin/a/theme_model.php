<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Theme_model extends MY_Model {
	
	private $table_name = 'u_theme';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取主题数据，用于平台主题管理
	 * @since  2015-12-14
	 * @author jiakairong
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getThemeData(array $whereArr ,$page=1 ,$num=10)
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			if ($key == 'name')
			{
				$whereStr .= ' '.$key.' like "%'.$val.'%" and';
			} 
			else 
			{
				$whereStr .= ' '.$key.'="'.$val.'" and';
			}
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$limitStr = ' limit '.($page-1)*$num.','.$num;
		$sql = 'select * from u_theme '.$whereStr.' order by id desc '.$limitStr;
		return $this ->db ->query($sql) ->result_array();
	}
}