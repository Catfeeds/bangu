<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Area_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_area' );
	}
	/**
	 * @method 以一组ID获取地区
	 * @param unknown $areaIds
	 */
	public function getAreaIN($areaIds ,$orderBy = '')
	{
		$sql = 'select * from u_area where id in ('.$areaIds.') '.$orderBy;
		return $this ->db ->query($sql) ->result_array();
	}

	public function getAreaData(array $whereArr=array() ,$fields='*')
	{
		$sql = 'select '.$fields.' from u_area ';
		return $this ->queryCommon($sql ,$whereArr);
	}
}