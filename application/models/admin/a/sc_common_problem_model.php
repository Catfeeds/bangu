<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_common_problem_model extends MY_Model {

	private $table_name = 'sc_common_problem';

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
		$sql = ' select tl.*,ad.realname,p_detail.content AS p_content,p_detail.id AS p_detail_id,i_kind.name AS kind_name,i_kind.id AS kind_id from sc_common_problem AS tl left join sc_common_problem_detail AS p_detail on p_detail.sc_common_problem_id=tl.id left join cfg_index_kind AS i_kind on i_kind.id=tl.index_kind_id left join u_admin AS ad on ad.id=tl.admin_id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$result = $this ->db ->query($sql.' order by tl.id desc '.$this ->getLimitStr()) ->result_array();
		array_walk($result, array($this, '_fetch_list'));
		$data['data'] = $result;
		return $data;
	}


	function get_problem_kind(){
		$sql = "SELECT * FROM cfg_index_kind";
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	 protected function _fetch_list(&$value, $key) {
		if(isset($value['dest_id'])&&$value['dest_id']!=''){
			$dest_sql = "SELECT GROUP_CONCAT(kindname) AS dest_name  FROM u_dest_base WHERE id IN ({$value['dest_id']})";

			$dest_str_sql = "SELECT GROUP_CONCAT(CONCAT_WS('|',id,kindname)) AS dest_name_str  FROM u_dest_base WHERE id IN ({$value['dest_id']})";

			$dest_res = $this ->db ->query($dest_sql) ->result_array();
			$value['dest_name'] = $dest_res[0]['dest_name'];
			$dest_res = $this ->db ->query($dest_str_sql) ->result_array();
			$value['dest_name_str'] = $dest_res[0]['dest_name_str'];
		}else{
			$value['dest_name'] = '无';
			$value['dest_name_str']= '';
		}

	}
}