<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年5月4日11:22:54
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Personal_page_model extends UB2_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @method 通过唯一识别码查询其下级
	 * @param string $code 唯一识别码
	 */
    public function get_dictionary_data ($code) {
    	$sql = "select d.* from u_dictionary as d where pid = (select ud.dict_id from u_dictionary as ud where ud.dict_code = '{$code}')";
    	return $this ->db ->query($sql) ->result_array();
    }

    /**
	 * @method 获取地区数据，用于平台管理
	 * @param array $whereArr
	 */
	public function get_area_data($whereArr=array()){
		$whereStr = '';
		if(!empty($whereArr)){
			foreach ($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'='.$val.' and';
		    	}
		   	 $whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select * from u_area '.$whereStr;
		$res= $this->db->query($sql)->result_array();
		return $res;
	}


	//获取个人主页的数据
	function get_page_data($table,$where){
		$this->db->select('*');
		if(!empty($where)){
			$this->db->where($where);
		}
		return  $this->db->get($table)->result_array();
	}

	//修改多项选择的数据
	function edit_page_data($operator,$table,$where_data=array()){
		if($operator=="add"){
			$status = $this->db->insert($table,$where_data);
		}else{
			$status = $this->db->delete($table, $where_data);
		}
		return $status;
	}

}