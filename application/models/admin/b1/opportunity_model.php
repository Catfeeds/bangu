<?php
	/***
	 *深圳海外国际旅行社

	****/
	if (!defined('BASEPATH')) exit('No direct script access allowed');
 Class Opportunity_model extends MY_Model{
 	    private $table_name = 'u_opportunity';
		function __construct()
		{

			parent::__construct ( $this->table_name );
		}
		
	
	function get_opportunity_list($param, $page){	
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = 'SELECT op.id,op.begintime,op.starttime,op.addtime,op.spend,op.address,op.title,op.modtime,op.endtime,op.sponsor,';
		$query_sql.='op.STATUS,op.people,op.description FROM	u_opportunity AS op WHERE op.publisher_type=2 and op.publisher_id='.$login_id;
		
 		if ($param != null) {
 			if (null != array_key_exists ( 'status', $param )) {
 				$query_sql .= '  AND op.status=? ';
 				$param ['status'] = $param ['status'];
 			}
  			if (null != array_key_exists ( 'op_title', $param )) {
 				$query_sql .= ' AND op.title like ? ';
 				$param['op_title'] = '%'.trim($param['op_title']).'%';
 			} 
 		}

		$query_sql .=' ORDER BY op.id,op.modtime desc';

		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	
	public function get_line_list($whereArr, $page = 1, $num = 10 ,$like = array() ,$is_page = 1) {
		$this->db->select ('*');
		$this->db->from ( $this->table_name .' as a');
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->or_like($key,$val);
			}
		}
		$this->db->order_by("a.id", "desc");
		if ($is_page == 1) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
	public function get_opp_apply_data($id){
		$sql = "select * from u_opportunity_apply where opportunity_id = {$id} and status = 1";
		return $this ->db ->query($sql) ->result_array();
	}
}
