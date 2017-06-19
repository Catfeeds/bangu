<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Round_trip_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'cfg_round_trip' );
	}
	/**
	 * @method 获取分类目的地
	 * @author 贾开荣
	 * @since  2015-06-11
	 * @param array $whereArr 查询条件
	 * @param intval $number 每页条数
	 * @param intval $page_new 第几页
	 * @param intval $is_page 是否分页，主要用于统计条数
	 */
	public function get_round_trip_data($whereArr ,$page_new = 1 ,$number = 10 ,$is_page = 1,$like = array() ) {
		$this->db->select ( "*" );
		$this->db->from ( 'cfg_round_trip');
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->like($key,$val);
			}
		}
		$this ->db ->order_by('id' ,'desc');
	
		if ($is_page == 1) {
			$number = empty ( $number ) ? 10 : $number;
			$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
			$this->db->limit ( $number, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
}