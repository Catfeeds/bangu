<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Search_condition_model extends MY_Model {

	private $table_name = 'cfg_search_condition';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取订单收款记录
	 * @author 贾开荣
	 * @since  2015-06-11
	 * @param array $whereArr 查询条件
	 * @param intval $number 每页条数
	 * @param intval $page_new 第几页
	 * @param intval $is_page 是否分页，主要用于统计条数
	 * @param array  $order_by 排序
	 */
	public function get_data($whereArr ,$number = 10 ,$page_new = 1) {
		$this->db->select ( 'sc.*,csc.description as top_name' );
		$this->db->from ( $this->table_name . ' as sc' );
		$this->db->join ( 'cfg_search_condition AS csc', 'sc.pid = csc.id', 'left' );
		$this->db->where ( $whereArr );
		$this ->db ->order_by('id','desc');
		if ($page_new > 0) {
			$number = empty ( $number ) ? 10 : $number;
			$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
			$this->db->limit ( $number, $offset );
		}
		$query = $this->db->get ();
		//echo $this ->db ->last_query();exit;
		return $query->result_array ();
	}
}