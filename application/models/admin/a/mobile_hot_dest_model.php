<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_hot_dest_model extends MY_Model {

	private $table_name = 'cfgm_hot_dest';

	public function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取手机端热门目的地
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getHotDestData($whereArr = array())
	{
		$sql = 'select cfg.*,s.cityname,d.kindname from cfgm_hot_dest as cfg left join u_startplace as s on s.id=cfg.startplaceid left join u_dest_base as d on d.id = cfg.dest_id';
		return $this ->getCommonData($sql ,$whereArr ,'cfg.id desc');
	}
	/**
	 * @method 获取数据详细
	 * @author jiakairong
	 * @param unknown $id
	 */
	public function getHotDestDetail($id)
	{
		$sql = 'select cfg.*,s.pid as province,d.kindname,(select us.pid from u_startplace as us where us.id =s.pid) as country from cfgm_hot_dest as cfg left join u_dest_base as d on d.id = cfg.dest_id left join u_startplace as s on s.id=cfg.startplaceid where cfg.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}