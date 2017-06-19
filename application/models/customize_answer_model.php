<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Customize_answer_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_customize_answer' );
	}
	
	
	
	
	/**
	 * @method 推荐定制单
	 * @param array $whereArr 查询条件
	 * @param number $page_new 当前分页
	 * @param number $number 每页条数
	 * @param number $is_page 是否分页
	 */
	public function get_custom_data ($whereArr ,$page_new =1 ,$number =10 ) {
		$this ->db ->select('ca.id,c.id as cid,c.pic,e.small_photo,e.realname,e.grade,e.id as eid,e.satisfaction_rate,e.total_score,e.expert_theme');
		$this ->db ->from('u_customize_answer as ca');
		$this ->db ->join( 'u_customize  as c' ,'ca.customize_id=c.id' ,'left');
		$this ->db ->join( 'u_expert   as e' ,'ca.expert_id=e.id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('ca.id' ,'desc');
		
		if ($page_new > 0) {
			$number = empty($number) ? 10 :$number;
			$page_new = empty($page_new) ? 1 : $page_new;
			$offect = ($page_new - 1) * $number;
			$this ->db ->limit ($number ,$offect);
		}
		$query = $this->db->get();
		return $query->result_array();
	}
}