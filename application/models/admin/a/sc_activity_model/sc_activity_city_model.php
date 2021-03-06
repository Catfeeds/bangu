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
class Sc_activity_city_model extends MY_Model {

	private $table_name = 'sc_activity_city';

	function __construct() {
		parent::__construct ($this->table_name );
	}


	public function getCityData($whereArr = array()) {
		$whereArr[' sac.status= '] = 1;
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select sac.*,ac.name AS act_name,st.cityname from sc_activity_city AS sac left join sc_activity AS ac on ac.id=sac.act_id left join u_startplace AS st on st.id=sac.startcityid '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by ac.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
}