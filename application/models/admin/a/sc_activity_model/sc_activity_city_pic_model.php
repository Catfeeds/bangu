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
class Sc_activity_city_pic_model extends MY_Model {

	private $table_name = 'sc_activity_city_pic';

	function __construct() {
		parent::__construct ($this->table_name );
	}


	public function getPicData($whereArr = array()) {
		$whereArr[' acp.status= '] = 1;
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select acp.*,act.name AS city_name from sc_activity_city_pic AS acp left join sc_activity_city AS act on act.id=acp.activity_city_id  '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by acp.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
}