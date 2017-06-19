<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_Member_Point_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'cfg_member_point';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ($this->table_name );
	}

	function get_data_list($whereArr, $page = 1, $num = 10){
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->order_by('id','desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$this->db->where($whereArr);
		$result=$this->db->get()->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	protected function _fetch_list(&$value, $key) {
		if($value['isopen']=='1'){
			$value['isopen']='开启';
			$value['isopen_code']=1;
		}else{
			$value['isopen']='关闭';
			$value['isopen_code']=0;
		}
	}

}