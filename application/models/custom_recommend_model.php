<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Custom_recommend_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'cfg_custom_recommend' );
	}
	
	/**
	 * @method 推荐定制单
	 * @param array $whereArr 查询条件
	 * @param number $page_new 当前分页
	 * @param number $number 每页条数
	 */
	public function get_custom_recommend_data ($whereArr ,$page_new =1 ,$number =10 ) {
		$this ->db ->select('c.id as cid,e.small_photo,e.realname,e.talk,e.satisfaction_rate,e.total_score,e.id as eid,c.startplace,c.endplace,c.days,c.theme,c.budget,c.startplace,c.endplace,c.people,c.days,
c.isshopping,dh.description as hotelstar,dt.description as trip_way,c.other_service');
		$this ->db ->from( 'cfg_custom_recommend as cr');
		$this ->db ->join( 'u_customize  as c' ,'c.id = cr.customize_id' ,'left');
		$this ->db ->join( 'u_customize_answer   as ca' ,'ca.customize_id = c.id' ,'left');
		$this ->db ->join( 'u_expert as e' ,'ca.expert_id = e.id' ,'left');
		$this ->db ->join( 'u_dictionary as dh' ,'c.hotelstar = dh.dict_id' ,'left');
		$this ->db ->join( 'u_dictionary as dt' ,'c.trip_way = dt.dict_id' ,'left');
		
		$this ->db ->where($whereArr);
		$this ->db ->order_by('cr.showorder' ,'asc');
		
		$number = empty($number) ? 10 :$number;
		$page_new = empty($page_new) ? 1 : $page_new;
		$offect = ($page_new - 1) * $number;
		$this ->db ->limit ($number ,$offect);
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
}