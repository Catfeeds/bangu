<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class consult_model extends MY_Model {

	private $table_name = 'u_consult';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	//获取资讯数据
	function get_consult_data($param,$page){
		
		$query_sql='';
		$query_sql.=' SELECT c.id,c.title,c.pic,c.addtime,c.shownum,c.praisetnum,c.ishot,c.type, ';
		$query_sql.=' (select COUNT(cp.id) from u_consult_praise as cp where cp.consult_id=c.id) as "hitpraise"';
		$query_sql.=' from u_consult as c  ';
		$query_sql.=' LEFT JOIN cfg_consult as cf on c.id=cf.consult_id where  c.id>0 ';
		if($param!=null){
			if(null!=array_key_exists('status', $param)){
				$query_sql.=' and c.type = ? ';
				$param['status'] = $param['status'];
			}
	 	   if(null!=array_key_exists('consultType', $param)){
				$query_sql.=' and c.type = ? ';
				$param['consultType'] = $param['consultType'];
			}  
			if(null!=array_key_exists('title', $param)){
				$query_sql.=' and c.title  like ? ';
				$param['title'] = '%'.$param['title'].'%';
			}
		}
		$query_sql.=' ORDER BY c.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
		
	}
	/**
	 * @method 添加资讯表
	 * @param  Array  $insertCon  资讯主表信息
	 * @return int
	 */
 	public function insert_consult($insertCon){
 		$this->db->trans_start();
 		//资讯主表
 		$this->db->insert('u_consult',$insertCon);
 		$consultId=$this->db->insert_id();
 		
 		$this->db->trans_complete();
 		if ($this->db->trans_status() === FALSE)
 		{
 			return false;
 		}else{
 			return $consultId;
 		}		
 	}
 	//资讯配置表
 	function get_cfg_consult($param,$page){
 	
 		$query_sql='';
 		$query_sql.=' SELECT cf.id,c.title,c.pic,c.addtime,c.shownum,c.praisetnum,c.ishot,c.type,cf.location,cf.pic as cfpic,cf.is_modify,cf.is_show,cf.showorder ';
 		$query_sql.=' from cfg_consult as cf ';
 		$query_sql.=' LEFT JOIN u_consult as c on c.id=cf.consult_id where  c.id>0 ';
 		if($param!=null){
 			if(null!=array_key_exists('consultType', $param)){
 				$query_sql.=' and c.type = ? ';
 				$param['consultType'] = $param['consultType'];
 			}
 			if(null!=array_key_exists('title', $param)){
 				$query_sql.=' and c.title  like ? ';
 				$param['title'] = '%'.$param['title'].'%';
 			}
 		}
 		$query_sql.=' ORDER BY c.addtime desc';
 		return $this->queryPageJson( $query_sql , $param ,$page);
 	
 	}
 	/**
 	 * @method 获取资讯
 	 * @param unknown $whereArr
 	 * @param number $page_new 当前页
 	 * @param number $number 每页条数
 	 * @param number $is_page 是否需要分页
 	 * @param array $likeArr 模糊搜索条件
 	 */
 	public function get_cfg_consult_data ($whereArr ,$page_new = 1, $number = 10 ,$is_page = 1 ,$likeArr = array()) {
 		$this ->db ->select('*');
 		$this ->db ->from('u_consult');
 		$this ->db ->where($whereArr);
 		$this ->db ->where('id not in(SELECT cf.consult_id from cfg_consult as cf)');
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
 	//插入表的数据
 	public function insert_table_data($table,$data){
 		//资讯主表
 		$this->db->insert($table,$data);
 		$id=$this->db->insert_id();
 		return $id;
 	}
 	//修改表的数据
 	public function update_table($table,$whereArr,$dataArr){
 		$this->db->where($whereArr);
 		$this->db->update($table, $dataArr);
 		return $this->db->affected_rows();
 	}
 	//获取表的数据
 	function get_rowdata($table,$whereArr){
 		$this ->db ->select('*');
 		$this ->db ->from($table);
 		$this ->db ->where($whereArr);
 		$query = $this->db->get ();
 		return $query->result_array ();
 	}
 	//获取咨询的数据
    public function get_cfg_rowdata($whereArr){
    	$this ->db ->select('cf.*,c.title');
    	$this ->db ->from('cfg_consult as cf');
    	$this ->db ->join('u_consult as c' ,'c.id = cf.consult_id' ,'left');
    	$this ->db ->where($whereArr);
    	$query = $this->db->get ();
    	return $query->row_array ();
    }
    //资讯数据
    function get_consult_listData($whereArr){
    	$this ->db ->select('c.*,t.id as themeid ,t.name as themename');
    	$this ->db ->from('u_consult as c');
    	$this ->db ->join('u_theme as t' ,'c.theme_id=t.id' ,'left');
    	$this ->db ->where($whereArr);
    	$query = $this->db->get ();
    	return $query->row_array ();
    }
 }
