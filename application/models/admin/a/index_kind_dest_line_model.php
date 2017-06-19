<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind_dest_line_model extends MY_Model
{
	private $table_name = 'cfg_index_kind_dest_line';
	public function __construct()
	{
		parent::__construct ( $this->table_name );
	}

	/**
	 * 获取首页目的地线路数据
	 * @param array $whereArr 查询条件
	 * @param string $orderBy 排序
	 */
	public function getData($whereArr,$orderBy='ikdl.id  desc')
	{
		$sql = 'select ikdl.*,l.linename,l.status as line_status,s.cityname,ikd.name pname from cfg_index_kind_dest_line as ikdl left join u_line as l on l.id=ikdl.line_id left join u_startplace as s on s.id=ikdl.startplaceid left join cfg_index_kind_dest as ikd on ikd.id=ikdl.index_kind_dest_id';
		$sql .= $this ->getWhereStr($whereArr).' order by '.$orderBy.$this->getLimitStr();
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * 获取满足查询条件的数据总条数
	 * @param array $whereArr 查询条件
	 */
	public function getTotal($whereArr)
	{
		$sql = 'select count(*) as count from cfg_index_kind_dest_line as ikdl left join u_line as l on l.id=ikdl.line_id left join u_startplace as s on s.id=ikdl.startplaceid left join cfg_index_kind_dest as ikd on ikd.id=ikdl.index_kind_dest_id';
		$sql .= $this ->getWhereStr($whereArr);
		$data = $this ->db ->query($sql) ->row_array();
		return $data['count'];
	}
	
	/**
	 * @method 获取数据详细
	 * @author jiakairong
	 * @param unknown $id
	 */
	public function getDestLineDetail($id)
	{
		$sql = 'select cfg.*,kd.index_kind_id,l.linename,s.pid as province,(select us.pid from u_startplace as us where us.id =s.pid) as country from cfg_index_kind_dest_line as cfg left join u_line as l on l.id = cfg.line_id left join cfg_index_kind_dest as kd on kd.id = cfg.index_kind_dest_id left join u_startplace as s on s.id=cfg.startplaceid where cfg.id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}