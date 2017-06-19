<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Startplace_child_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_startplace_child' );
	}
	
	/**
	 * @method 获取站点的子站点，用于平台配置子站点 & 线路列表子站点查询
	 * @param unknown $startid
	 */
	public function getChildStartData($startid)
	{
		$sql = 'select s.cityname,s.id from u_startplace_child as sc left join u_startplace as s on s.id = sc.startplace_child_id where sc.startplace_id ='.$startid;
		return $this ->db ->query($sql) ->result_array();
	}
}