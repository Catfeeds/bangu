<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_hot_line_model extends MY_Model {

	private $table_name = 'cfgm_hot_line';

	public function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取手机端热门线路
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getMHotLineData($whereArr=array())
	{
		$sql = 'select hl.*,l.linename,s.cityname,l.status as line_status from cfgm_hot_line as hl left join u_line as l on l.id=hl.line_id left join u_startplace as s on s.id=hl.startplaceid';
		return $this ->getCommonData($sql ,$whereArr ,'hl.id desc');
	}
	/**
	 * @method 获取数据详细
	 * @author jiakairong
	 * @param unknown $id
	 */
	public function getHotLineDetail($id)
	{
		$sql = 'select cfg.*,l.linename,s.pid as province,(select us.pid from u_startplace as us where us.id = s.pid) as country from cfgm_hot_line as cfg left join u_line as l on l.id=cfg.line_id left join u_startplace as s on s.id=cfg.startplaceid where cfg.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}