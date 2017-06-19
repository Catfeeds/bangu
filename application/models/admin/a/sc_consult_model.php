<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_consult_model extends MY_Model {

	private $table_name = 'sc_consult';

	function __construct() {
		parent::__construct ( $this->table_name );
	}

	/**
	 * @method 获取首页分类主题线路数据
	 * @author 汪晓烽
	 * @param unknown $whereArr
	 */
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
		$sql = ' select tl.*,cu.title,ck.name AS ck_name from sc_consult as tl left join u_consult AS cu on cu.id=tl.consult_id left join cfg_index_kind AS ck on ck.id=tl.index_kind_id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$result = $this ->db ->query($sql.' order by tl.id desc '.$this ->getLimitStr()) ->result_array();
		//array_walk($result, array($this, '_fetch_list'));
		$data['data'] = $result;
		return $data;
	}


	 public function get_consult($whereArr=array()) {
	 		$whereStr = '';
			foreach ($whereArr as $key=>$val)
			{
				$whereStr .= ' '.$key.'"'.$val.'" and';
			}
			if (!empty($whereStr))
			{
				$whereStr = ' where '.rtrim($whereStr ,'and');
			}
			$dest_sql = " SELECT *  FROM u_consult ".$whereStr;
			$dest_res = $this ->db ->query($dest_sql) ->result_array();
			return $dest_res;
	}
}