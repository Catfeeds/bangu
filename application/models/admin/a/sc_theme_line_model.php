<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_theme_line_model extends MY_Model {

	private $table_name = 'sc_index_theme_line';

	function __construct() {
		parent::__construct ( $this->table_name );
	}

	/**
	 * @method 获取首页分类主题线路数据
	 * @author 汪晓烽
	 * @param unknown $whereArr
	 */
	public function getThemeLineData ($whereArr) {
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = ' select tl.*,t.name as theme_name,l.linename from sc_index_theme_line as tl left join u_line as l on l.id=tl.line_id  left join u_theme as t on t.id=tl.theme_id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by tl.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}


	public function get_cfg_theme(){
		$sql = "select name AS theme_name , theme_id from cfg_index_kind_theme group by theme_id";
		$res = $this ->db ->query($sql) ->result_array();
		return $res;
	}
}