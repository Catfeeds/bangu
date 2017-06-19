<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfg_round_trip_model extends MY_Model 
{
	private $table_name = 'cfg_round_trip';
	public function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * 获取周边游数据，用于定制游下单
	 * @param array $whereArr 搜索条件
	 */
	public function getRoundTripCustom($whereArr)
	{
		$sql = 'select d.id,d.kindname as name from cfg_round_trip as cfg left join u_dest_base as d on d.id=cfg.neighbor_id'.$this->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * 获取周边游数据
	 * @param array $whereArr 搜索条件
	 */
	public function getRoundTripAll($whereArr ,$orderBy='cfg.id desc' ,$specialSql='')
	{
		$sql = 'select cfg.*,d.kindname,s.cityname,d.id as dest_id from cfg_round_trip as cfg left join u_startplace as s on s.id=cfg.startplaceid left join u_dest_base as d on d.id=cfg.neighbor_id';
		$sql .= $this ->getWhereStr($whereArr ,$specialSql).' order by '.$orderBy;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * 获取目的地配置数据
	 * @param array $whereArr 搜索条件
	 */
	public function getRoundTripData($whereArr ,$orderBy='id desc')
	{
		$sql = 'select cfg.*,d.kindname,s.cityname from cfg_round_trip as cfg left join u_startplace as s on s.id=cfg.startplaceid left join u_dest_base as d on d.id=cfg.neighbor_id';
		$sql .= $this ->getWhereStr($whereArr).' order by '.$orderBy.$this->getLimitStr();
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * 获取目的地配置总数
	 * @param array $whereArr 搜索条件
	 */
	public function getRripNum($whereArr)
	{
		$sql = 'select count(*) as count from cfg_round_trip as cfg left join u_startplace as s on s.id=cfg.startplaceid left join u_dest_base as d on d.id=cfg.neighbor_id';
		$sql .= $this ->getWhereStr($whereArr);
		$countArr = $this ->db ->query($sql) ->row_array();
		return $countArr['count'];
	}
}