<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @since		2015年5月2日
 * @author		贾开荣
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_recommend_model extends MY_Model
{
	public $table_name = "cfg_list_line_recommend";
	
	function __construct() {
		parent::__construct ( $this ->table_name );
	}
	
	/**
	 * @method 获取首页热门线路
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getRecommendData(array $whereArr=array()) {
		$sql = 'select lr.*,l.linename,s.cityname from cfg_list_line_recommend as lr left join u_line as l on l.id=lr.line_id left join u_startplace as s on s.id=lr.startplaceid';
		return $this ->getCommonData($sql ,$whereArr ,'lr.id desc');
	}
	/**
	 * @method 获取详细
	 * @param unknown $id
	 */
	public function getRecommendDetail($id)
	{
		$sql = 'select lr.*,l.linename,s.pid as province,(select sp.pid from u_startplace as sp where sp.id=s.pid) as country from cfg_list_line_recommend as lr left join u_line as l on l.id=lr.line_id left join u_startplace as s on s.id=lr.startplaceid where lr.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}