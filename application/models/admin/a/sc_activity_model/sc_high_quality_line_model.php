<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月21日11:35:53
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_high_quality_line_model extends MY_Model {

	private $table_name = 'sc_high_quality_line';

	function __construct() {
		parent::__construct ($this->table_name );
	}


	public function getQuaData($whereArr = array()) {
		$whereArr[' sl.status= '] = 1;
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select sl.*,act.name AS city_name,l.linename  from sc_high_quality_line AS sl left join sc_activity_city AS act on act.id=sl.activity_city_id left join u_line AS l on l.id=sl.line_id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by sl.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
}