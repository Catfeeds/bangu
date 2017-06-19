<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月15日11:35:53
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_index_app_model extends MY_Model {

	private $table_name = 'sc_index_application';

	function __construct() {
		parent::__construct ($this->table_name );
	}

	public function getData ($whereArr) {
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = ' SELECT * FROM sc_index_application '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$result = $this ->db ->query($sql.' order by id desc '.$this ->getLimitStr()) ->result_array();
		$data['data'] = $result;
		return $data;
	}
}