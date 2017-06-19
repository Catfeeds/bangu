<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Fix_desc_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct ( 'u_fix_desc' );
	}
	
	/**
	 * @method 获取广告数据，用于平台管理
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getFixDescData(array $whereArr ,$page=1 ,$num=10)
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			if (empty($val)) continue;
			$whereStr .= ' '.$key.'="'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$limitStr = ' limit '.($page-1)*$num.','.$num ;
		$sql = 'select * from u_fix_desc '.$whereStr.' order by id desc '.$limitStr;
		return $this ->db ->query($sql) ->result_array();
	}
}