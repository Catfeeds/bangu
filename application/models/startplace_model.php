<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Startplace_model extends MY_Model {
	public $table = 'u_startplace';
	
	function __construct() {
		parent::__construct ( 'u_startplace' );
	}
	
	/**
	 * 获取出发城市数据，用于树结构显示
	 * @author jkr
	 */
	public function getStartplaceTree($whereArr)
	{
		$sql = 'select id,cityname as name,enname,simplename,pid as pId,level from u_startplace '.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	public function getStartcityId($name)
	{
		$sql = 'select * from u_startplace where cityname like "%'.$name.'%"';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取出发城市的上级
	 * @param unknown $cityid 城市ID
	 */
	public function getCityParent($cityid)
	{
		$sql = 'select s.id,s.pid,(select c.pid from u_startplace as c where c.id=s.pid) as parent_id from u_startplace as s where s.id='.$cityid;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取线路的出发城市
	 * @author jiakairong
	 * @since  2016-03-16
	 */
	public function getLineStartCity($lineid)
	{
		$sql = 'select s.cityname as name from u_line_startplace as ls left join u_startplace as s on s.id = ls.startplace_id where ls.line_id ='.$lineid;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取全国出发
	 * @author jkr
	 * @since  2016-03-30
	 */
	public function getCountryStart()
	{
		$sql = 'select * from u_startplace where cityname="全国出发"';
		return $this ->db ->query($sql) ->result_array();
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