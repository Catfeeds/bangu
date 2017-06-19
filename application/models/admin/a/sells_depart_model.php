<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sells_depart_model extends MY_Model {
	
	private $table_name = 'sp_sells_depart';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取营业部
	 * @param unknown $whereArr 
	 * @param number $page_new 当前页
	 * @param number $number 每页条数
	 * @param number $is_page 是否需要分页
	 * @param array $likeArr 模糊搜索条件
	 */
	public function get_sells_depart_data ($whereArr ,$page_new = 1, $number = 10 ,$is_page = 1 ,$likeArr = array()) {
		$this ->db ->select('sd.id,sd.name,sd.beizhu,sd.addtime,sd.agent_id');
		$this ->db ->from($this ->table_name .' as sd');
		$this ->db ->where($whereArr);
		//$this ->db ->join('sp_travel_agent as ta' ,'ta.id = sd.agent_id');
		$this ->db ->order_by('sd.addtime' ,'desc');
		
		if (!empty($likeArr) && is_array($likeArr)) {
			foreach($likeArr  as $key =>$val) {
				$this ->db ->like($key ,$val);
			}
		}
		if ($is_page == 1) {
			$number = empty ( $number ) ? 10 : $number;
			$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
			$this->db->limit ( $number, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
}