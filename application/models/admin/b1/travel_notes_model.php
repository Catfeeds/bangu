<?php
/***
*深圳海外国际旅行社
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Travel_notes_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}
    //最新游记
    function get_travel_data($param,$page){
    	//启用session
    	$this->load->library('session');
    	$arr=$this->session->userdata ( 'loginSupplier' );
    	$login_id=$arr['id'];
    	
    	$query_sql='';
    	$query_sql.= 'SELECT tn.id,	tn.addtime ,tn.title,(mo.childnum + mo.dingnum) AS "num",mo.memberid,';
		$query_sql.=' CASE WHEN tn.usertype = 0 THEN	m.truename WHEN tn.usertype = 1 THEN e.realname END "name",mo.usedate ,mo.addtime as "moaddtime",';
		$query_sql.=' CASE WHEN tn.id IN (	SELECT	tnc.travel_note_id	FROM	travel_note_complain AS tnc WHERE	tnc. STATUS = 0 ) THEN "申诉中" ';
		$query_sql.=' WHEN tn.id NOT IN (	SELECT	tnc.travel_note_id	FROM	travel_note_complain AS tnc ) THEN	"可申诉"   END  "opera" ';
		$query_sql.=' FROM	travel_note AS tn LEFT JOIN u_member_order AS mo ON tn.order_id = mo.id ';
		$query_sql.=' LEFT JOIN u_member AS m ON mo.memberid = m.mid LEFT JOIN u_expert AS e ON mo.expert_id = e.id ';
		$query_sql.='WHERE	mo.supplier_id ='.$login_id.' AND TIMESTAMPDIFF(HOUR, tn.addtime, NOW()) < 48';
    	if($param!=null){
	    	if(null!=array_key_exists('line_name', $param)){
		    	$query_sql.=' AND tn.title LIKE ? ';
		    	$param['line_name'] = '%'.trim($param['line_name']).'%';
			}
	    	if(null!=array_key_exists('startdatetime', $param)){
	    		$query_sql.=' AND tn.addtime BETWEEN ? AND ?';
					//$param['startdatetime'] = $param['startdatetime'];
	    	}
    	}
    	$query_sql.=' ORDER BY tn.addtime desc';
    	return $this->queryPageJson( $query_sql , $param ,$page);
    }
    
    function get_over_travel($param,$page){
    	//启用session
    	$this->load->library('session');
    	$arr=$this->session->userdata ( 'loginSupplier' );
    	$login_id=$arr['id'];
    	 
    	$query_sql='';
    	$query_sql.= 'SELECT tn.id,	tn.addtime ,tn.title,(mo.childnum + mo.dingnum) AS "num",';
    	$query_sql.=' CASE WHEN tn.usertype = 0 THEN	m.truename WHEN tn.usertype = 1 THEN e.realname END "name",mo.usedate ,mo.addtime as "moaddtime",';
    	$query_sql.=' CASE WHEN tn.id IN (	SELECT	tnc.travel_note_id	FROM	travel_note_complain AS tnc WHERE	tnc. STATUS = 0 ) THEN "申诉中" ';
    	$query_sql.=' WHEN tn.id NOT IN (	SELECT	tnc.travel_note_id	FROM	travel_note_complain AS tnc ) THEN	"可申诉"   END  "opera" ';
    	$query_sql.=' FROM	travel_note AS tn LEFT JOIN u_member_order AS mo ON tn.order_id = mo.id ';
    	$query_sql.=' LEFT JOIN u_member AS m ON mo.memberid = m.mid LEFT JOIN u_expert AS e ON mo.expert_id = e.id ';
    	$query_sql.='WHERE	mo.supplier_id ='.$login_id.' AND TIMESTAMPDIFF(HOUR, tn.addtime, NOW()) > 48';
    	if($param!=null){
    	 	if(null!=array_key_exists('line_name', $param)){
		    	$query_sql.=' AND tn.title LIKE ? ';
		    	$param['line_name'] = '%'.trim($param['line_name']).'%';
			}
    		if(null!=array_key_exists('startdatetime', $param)){
    			$query_sql.=' AND tn.addtime BETWEEN ? AND ?';
    			//$param['startdatetime'] = $param['startdatetime'];
    		}
    	}
    	$query_sql.=' ORDER BY tn.addtime desc';
    	return $this->queryPageJson( $query_sql , $param ,$page);
    	
    }
    
    //插入数据
    function insert_data($table,$data){
    	//插入线路行程
    	$this->db->insert($table,$data);
    	return $this->db->insert_id();
    }
    //查询数据
    function select_rowData($table,$where){
    	$this->db->select('*');
    	$this->db->where($where);
    	return  $this->db->get($table)->row_array();
    }
    //修改游记读的状态
    function update_teval_read($data,$where){
    	$this->db->where ( $where );
    	return $this->db->update ( 'travel_note', $data );
    }
}