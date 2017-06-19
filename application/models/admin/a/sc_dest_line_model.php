<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_dest_line_model extends MY_Model {

	private $table_name = 'sc_index_dest_line';

	function __construct() {
		parent::__construct ( $this->table_name );
	}

	/**
	 * @method 获取分类目的地
	 * @author jiakairong
	 * @since  2015-06-11
	 * @param array $whereArr 查询条件
	 */
	public function getDestLineData($whereArr = array()) {
		$whereStr = '';
		foreach ($whereArr as $key=>$val){
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr)){
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select l.linename,dest.kindname,sc_ld.* from sc_index_dest_line AS sc_ld left join u_line AS l on l.id=sc_ld.line_id left join u_dest_base AS dest on dest.id=sc_ld.dest_id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by sc_ld.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
}