<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_dest_love_model extends MY_Model
{
	private $table_name = 'cfg_index_dest_love';
	public function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取首页热门线路
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getDestLoveData(array $whereArr=array())
	{
		$sql = 'select dl.*,s.cityname,d.kindname from cfg_index_dest_love as dl left join u_startplace as s on s.id=dl.startplaceid left join u_dest_base as d on d.id=dl.dest_id';
		return $this ->getCommonData($sql ,$whereArr ,'dl.id desc');
	}
	/**
	 * @method 获取数据详细
	 * @author jiakairong
	 * @param unknown $id
	 */
	public function getDetailData($id)
	{
		$sql = 'select dl.*,s.pid as province,d.kindname,(select us.pid from u_startplace as us where us.id=s.pid) as country from cfg_index_dest_love as dl left join u_startplace as s on s.id=dl.startplaceid left join u_dest_base as d on d.id=dl.dest_id where dl.id='.$id;
		return $this ->db->query($sql) ->result_array();
	}
}