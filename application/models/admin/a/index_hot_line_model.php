<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_hot_line_model extends MY_Model
{
	private $table_name = 'cfg_index_line_hot';
	public function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取首页热门线路
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getHotLineData(array $whereArr=array())
	{
		$sql = 'select lh.*,l.linename,s.cityname,l.status from cfg_index_line_hot as lh left join u_line as l on l.id = lh.line_id left join u_startplace as s on s.id = lh.startplaceid';
		return $this ->getCommonData($sql ,$whereArr ,'lh.id desc');
	}
	/**
	 * @method 获取详细
	 * @param unknown $id
	 */
	public function getHotLineDetail($id)
	{
		$sql = 'select lh.*,l.linename,s.pid as province,(select sp.pid from u_startplace as sp where sp.id=s.pid) as country from cfg_index_line_hot as lh left join u_line as l on l.id=lh.line_id left join u_startplace as s on s.id=lh.startplaceid where lh.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}