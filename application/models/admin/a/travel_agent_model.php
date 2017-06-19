<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Travel_agent_model extends MY_Model {
	
	private $table_name = 'sp_travel_agent';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取旅行社
	 * @param unknown $whereArr 
	 * @param number $page_new 当前页
	 * @param number $number 每页条数
	 * @param number $is_page 是否需要分页
	 * @param array $likeArr 模糊搜索条件
	 */
	public function get_travel_agent_data ($whereArr ,$page_new = 1, $number = 10 ,$is_page = 1 ,$likeArr = array()) {
		$this ->db ->select('*');
		$this ->db ->from($this ->table_name);
		$this ->db ->where($whereArr);
		$this ->db ->order_by('id' ,'desc');
		
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
	/**
	 * @method 获取营业管家
	 * @author xml
	 * @param  $param 
	 * @param  $page
	 * @return json
	 */
	public function get_expert_depart($param,$page){
		$query_sql='';
		$query_sql.=' SELECT e.id as expert_id,e.realname,e.mobile,e.email,e.idcard,e.addtime,a.name as country,c.name as city,p.name as province,s.name ';
		$query_sql.=' FROM	u_expert AS e ';
		$query_sql.=' LEFT JOIN sp_sells_depart AS s ON e.depart_id = s.id LEFT JOIN u_area as a on a.id=e.country';
		$query_sql.=' LEFT JOIN u_area as c on c.id=e.city LEFT JOIN u_area as p on p.id=e.province WHERE expert_type = 1';
		if($param!=null){
			if(null!=array_key_exists('status', $param)){
				$query_sql.=' and e.status = ? ';
				$param['status'] = $param['status'];
			}
			if(null!=array_key_exists('expertname', $param)){
				$query_sql.=' AND e.realname  like ? ';
				$param['expertname'] = '%'.$param['expertname'].'%';
			}
			if(null!=array_key_exists('departtname', $param)){
				$query_sql.=' AND s.name like ? ';
				$param['departtname'] = '%'.$param['departtname'].'%';
			}
		}
		$query_sql.=' ORDER BY e.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
}