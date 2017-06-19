<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_startplace_model extends MY_Model {

	private $table_name = 'u_startplace';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取出发城市 ,用于出发城市插件选择
	 * @author jiakairong
	 * @since  2015-11-17
	 */
	public function getStartAllData($isopen=1)
	{
		$sql = 'select id,cityname as name,enname,simplename,pid,level,ishot from u_startplace where level <= 4 and isopen = '.$isopen.' order by pid asc,displayorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	
	/**
	 * @method 获取出发城市的上级，(国家&&省)
	 * @param unknown $cityid 城市的id
	 */
	public function getCityParent($cityid) {
		$sql = 'select id,pid,(select us.pid from u_startplace as us where us.id=s.pid) as parentid from u_startplace as s where id='.$cityid;
		return $this ->db->query($sql) ->result_array();
	}
	
	
	/**
	 * @method 通过名称获取数据,用于线路列表
	 * @author jiakairong
	 * @since  2015-11-14
	 * @param unknown $ids
	 */
	public function getStartNameData($name)
	{
		$sql = 'select id from u_startplace where cityname = "'.$name.'"';
		return $this ->db ->query($sql) ->result_array();
	}
}