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
class Sc_index_recommend_line_model extends MY_Model {

	private $table_name = 'sc_index_recommend_line';

	function __construct() {
		parent::__construct ($this->table_name );
	}


	public function getRecommData($whereArr = array()) {
		$whereArr[' sr.status= '] = 1;
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select sr.*,l.linename  from sc_index_recommend_line AS sr  left join u_line AS l on l.id=sr.line_id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by sr.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
}