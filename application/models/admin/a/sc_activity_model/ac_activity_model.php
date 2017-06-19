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
class Ac_activity_model extends MY_Model {

	private $table_name = 'sc_activity';

	function __construct() {
		parent::__construct ($this->table_name );
	}


	public function getAcData($whereArr = array()) {
		$whereArr[' ac.status= '] = 1;
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select ac.*,ad.realname from sc_activity AS ac left join u_admin AS ad on ad.id=ac.adminid '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by ac.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
}