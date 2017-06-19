<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:31:44
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Messages_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}
	//平台公告列表
	public function get_messages($param ,$page){
		//启用session
 
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		
		$query_sql  = 'SELECT	`m`.`id`,	`m`.`title`,`m`.`addtime`,`m`.`notice_type`,`m`.`id` ';
		$query_sql.=' IN (SELECT nr.notice_id FROM	u_notice_read AS nr	WHERE	nr.notice_type = 2	AND nr.userid ='.$login_id.' and ( nr.read=1 or nr.status!=-1)) AS "isread" ';
		$query_sql.='from (`u_notice` AS m) ';
		$query_sql.=' where `m`.`id` NOT IN (SELECT nr.notice_id FROM  u_notice_read AS nr	WHERE nr.notice_type=2 AND nr.userid ='.$login_id.' and nr.status=-1)  and  FIND_IN_SET("2",m.notice_type) > 0  ';
		if($param!=null){
			if(null!=array_key_exists('title', $param)){
				$query_sql.=' AND m.title LIKE ? ';
				$param['title'] = '%'.trim($param['title']).'%';
			}
		 	 if(null!=array_key_exists('addtime', $param)){
		 		
				$query_sql.=' AND m.addtime BETWEEN ? AND ?';
				//$param['startdatetime'] = $param['startdatetime'];
			} 
		}
		$query_sql.=' GROUP BY m.id ORDER BY m.addtime DESC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	//业务通知
	public function get_service_messages($param ,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql  = 'SELECT id,m.title, m.addtime  ,m.admin_id,m.read';
		$query_sql.=' FROM u_message AS m';
		$query_sql.=' where  m.msg_type = 2 and (m.read=0 or m.read=1) and m.receipt_id='.$login_id;
		if($param!=null){
			if(null!=array_key_exists('title', $param)){
				$query_sql.=' AND m.title LIKE ? ';
				$param['title'] = '%'.trim($param['title']).'%';
			}
			if(null!=array_key_exists('addtime', $param)){
				 
				$query_sql.=' AND m.addtime BETWEEN ? AND ?';
				//$param['startdatetime'] = $param['startdatetime'];
			}
		}
		$query_sql.=' ORDER BY m.addtime DESC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	public function messages_row( $id){
	    $this->db->select('u_notice.title,u_notice.addtime,u_admin.realname,u_notice.content,u_notice.attachment');
	    $this->db->from('u_notice');
	    $this->db->join('u_admin', 'u_notice.admin_id = u_admin.id', 'left');
		$this->db->where('u_notice.id',$id);
		$query = $this->db->get();
		return $query->row_array(); 
	}
	
	public function service_messages_row( $id){
		$this->db->select('*');
		$this->db->from('u_message');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	//修改表
	public function update_table_data($table,$where,$data){
		$this->db->where($where);
		return $this->db->update($table,$data);
	}
	//遍历表
	public function sel_data($table,$where){	
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get($table)->row_array();
		return $query;
	}
	//未读的系统通知
	function sys_msg_data($supplierid){
		$this->db->select('count(*) AS sys_msg_count');
		$this->db->from('u_notice AS n');
		$this->db->where('n.notice_type like "%2%"');
		$this->db->where('n.id NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE nr.notice_type like "%2%" AND nr.userid='.$supplierid.')');
		$sys_msg_unread = $this->db->get()->result_array();
		return $sys_msg_unread;
	}
	//未读的业务通知
	function buniess_msg_data($supplierid){
		$this->db->select('count(*) AS buniess_msg_count');
		$this->db->from('u_message AS m');
		$this->db->where('m.msg_type like "%2%" AND m.read=0 AND m.receipt_id='.$supplierid);
		$buniess_msg_unread = $this->db->get()->result_array();
		return $buniess_msg_unread;
	}
}