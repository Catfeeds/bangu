<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Startplace_model extends MY_Model {

	private $table_name = 'u_startplace';

	function __construct() {
		parent::__construct ( $this->table_name );
	}

	/**
	 * @method 获取出发城市数据
	 * @author jiakairong
	 * @since  2016-01-14
	 * @param unknown $whereArr
	 */
	public function getStartplaceData(array $whereArr) {
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			if ($key == 'pid')
			{
				$whereStr .= ' (s.id = '.$val.' or s.pid = '.$val.') and';
			}
			else 
			{
				$whereStr .= ' '.$key.'"'.$val.'" and';
			}
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select s.*,sp.cityname as parent from u_startplace as s left join u_startplace as sp on s.pid = sp.id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by s.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	
	/**
	 * @method 获取出发城市 ,用于出发城市插件选择
	 * @author jiakairong
	 * @since  2015-11-17
	 */
	public function getStartAllData()
	{
		$sql = 'select id,cityname as name,enname,simplename,pid,level,ishot from u_startplace where level <= 4 and isopen = 1 order by pid asc,displayorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
}