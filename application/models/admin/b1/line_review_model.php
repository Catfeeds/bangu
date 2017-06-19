<?php
/***
*深圳海外国际旅行社

*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Line_review_model extends MY_Model{

	private $table_name = 'u_comment';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
 	public function get_line_comment($param,$page){
 		//启用session
 		$this->load->library('session');
 		$arr=$this->session->userdata ( 'loginSupplier' );
 		$login_id=$arr['id'];

 		$query_sql='';
 		$query_sql.= 'SELECT  l.overcity ,l.id as line_id,c.id AS comment_id,l.linename AS line_name,mb.truename AS member_name,c.content as content1, left(c.content,15) as content,left(c.reply1,15) as "reply1",c.reply1 as "reply2",c.addtime AS addtime,c.level AS score ,c.avgscore1,mb.loginname,';
		$query_sql.='	CASE	WHEN `c`.`id` IN (SELECT tnc.comment_id FROM u_comment_complain  AS tnc WHERE tnc.status=0) THEN "0"';
		$query_sql.='	 WHEN `c`.`id` IN (SELECT tnc.comment_id FROM u_comment_complain  AS tnc WHERE tnc.status=2) THEN "2" ';
		$query_sql.='	 WHEN `c`.`id` IN (SELECT tnc.comment_id FROM u_comment_complain AS tnc WHERE tnc.status=1) THEN "1" END "opare" ';
 		$query_sql.=' FROM (`u_comment` AS c) ';
		$query_sql.=' LEFT JOIN `u_line` AS l ON `c`.`line_id` = `l`.`id` ';
		$query_sql.=' LEFT JOIN `u_member` AS mb ON `c`.`memberid` = `mb`.`mid`';
		$query_sql.=' WHERE c.status=1 and `l`.`supplier_id` = '.$login_id;
 		
 		if($param!=null){
	 		if(null!=array_key_exists('productname', $param)){
	 		$query_sql.=' AND l.linename LIKE ? ';
	 		$param['productname'] = '%'.trim($param['productname']).'%';
				}
 		}
 		$query_sql.=' ORDER BY	`c`.`addtime` DESC ';
		return $this->queryPageJson( $query_sql , $param ,$page);
			
	} 
	//插入数据
	function insert_data($table,$data){
		//插入线路行程
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	//修改数据
	function update_data($table,$data,$where){
		$this->db->where($where);
		return $this->db->update($table, $data);
	}
}
