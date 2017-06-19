<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

  class Experience_model extends MY_Model {

	private $table_name = 'u_member_experience';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	//体验师列表
	public function get_experience_list($param,$page){
		$query_sql='';
		$query_sql.=' SELECT me.id,me.member_id,me.order_id,m.mobile,m.nickname,me.status,m.truename,mo.productname,mo.productaid,mo.ordersn ';
		$query_sql.=' from u_member_experience as me ';
		$query_sql.=' LEFT JOIN u_member as m on me.member_id=m.mid ';
		$query_sql.=' LEFT JOIN u_member_order as mo on mo.id=me.order_id ';
 		if($param!=null){
			if(null!=array_key_exists('status', $param)){
				$query_sql.=' where me.status = ? ';
				$param['status'] = $param['status'];
			}
			if(null!=array_key_exists('nickname', $param)){
				$query_sql.=' AND m.nickname  like ? ';
				$param['nickname'] = '%'.$param['nickname'].'%';
			}
			if(null!=array_key_exists('linename', $param)){
				$query_sql.=' AND mo.productname  like ? ';
				$param['linename'] = '%'.$param['linename'].'%';
			}
		} 
		$query_sql.=' ORDER BY me.id desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	//获取体验师会员
	public function get_member_list($whereArr ,$page_new = 1, $number = 10 ,$is_page = 1 ,$likeArr = array()){
		$this ->db ->select('m.loginname,m.nickname,m.mid');
		$this ->db ->from(' u_member as m');
		$this ->db ->where('m.mid not in (SELECT member_id from u_member_experience where status!=-1)');
		$this ->db ->where('m.mid in(SELECT memberid from u_member_order where status>4)');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('m.mid' ,'desc');
		
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
	//获取会员订单
	public function get_member_order($where){
		$this ->db ->select('mo.*');
		$this ->db ->from(' u_member_order as mo');
		$this ->db ->where('status > 4 ');
		$this ->db ->where($where);
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
}
