<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		用于统计地区对应的线路，管家，供应商数量
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Statistics_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ();
	}
	//统计管家
	public function getAreaExpertCount(array $whereArr = array())
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.$val.' and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'SELECT COUNT(*) as count,a.name FROM u_area AS a LEFT JOIN u_expert AS e ON a.id=e.city '.$whereStr.' GROUP BY e.city';
		return $this ->db ->query($sql) ->result_array();
	}
	//统计供应商
	public function getAreaSupplierCount(array $whereArr = array())
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.$val.' and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'SELECT COUNT(*) as count,a.name FROM u_area AS a LEFT JOIN u_supplier AS s ON a.id=s.city '.$whereStr.' GROUP BY s.city';
		return $this ->db ->query($sql) ->result_array();
	}
	//统计线路城市
	public function getStartCityLineCount(array $whereArr = array())
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.$val.' and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		
		$sql = 'SELECT COUNT(*) as count,s.cityname as name FROM u_startplace AS s left join u_line_startplace as ls on ls.startplace_id = s.id LEFT JOIN u_line AS l ON ls.line_id=l.id '.$whereStr.' GROUP BY s.id';
		return $this ->db ->query($sql) ->result_array();
	}
	//统计线路省份
	public function getStartProvinceLineCount(array $whereArr = array())
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.$val.' and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'SELECT (select us.cityname from u_startplace as us where us.id=s.pid) as name,s.pid as province,l.id as lineid FROM u_line as l left join u_line_startplace as ls on ls.line_id=l.id left join u_startplace AS s on ls.startplace_id = s.id '.$whereStr;
		return $this ->db ->query($sql) ->result_array();
	}
	//全国出发线路数量
	public function getCountryLineCount()
	{
		$sql = 'select count(*) as count from u_line as l left join u_line_startplace as ls on l.id=ls.line_id left join u_startplace as s on s.id=ls.startplace_id where s.cityname="全国出发"';
		return $this ->db ->query($sql) ->result_array();
	}
}