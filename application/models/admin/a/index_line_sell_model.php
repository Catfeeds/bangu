<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_Line_Sell_model extends MY_Model
{
	private $table_name = 'cfg_index_line_sell';

	function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取特价线路
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getLineSellData($whereArr=array())
	{

		$sql = 'select ils.*,l.linename,l.status as line_status,s.cityname from cfg_index_line_sell as ils left join u_line as l on l.id=ils.line_id left join u_startplace as s on s.id=ils.startplaceid ';
		return $this ->getCommonData($sql ,$whereArr ,'ils.id desc');
	}
	/**
	 * @method  获取特价线路详情
	 * @param unknown $id
	 */
	public function getDetailData($id)
	{
		$sql = 'select cfg.*,l.linename,s.pid as province,(select us.pid from u_startplace as us where us.id=s.pid) as country from cfg_index_line_sell as cfg left join u_line as l on l.id=cfg.line_id left join u_startplace as s on s.id = cfg.startplaceid where cfg.id='.$id;
		return $this ->db ->query($sql)->result_array();
	}
}