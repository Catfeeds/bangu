<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午2:35:22
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class User_line_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}
	public function get_line(){
			$this->db->select('u_member.nickname,u_complain.addtime,u_complain.reason,u_line.linename,
					u_supplier.login_name,u_complain.approve_status,u_member.mobile,u_complain.die_reason');
			$this->db->from('u_complain');
			$this->db->join('u_member_order','u_member_order.id=u_complain.order_id');
			$this->db->join('u_member','u_member.mid=u_complain.member_id');
			$this->db->join('u_line','u_line.id=u_member_order.productautoid');
			$this->db->join('u_supplier','u_supplier.id=u_member_order.supplier_id');
			$query =$this->db->get();
			return $query->result_array();
	}
	public function get_line_where($id){
		$query = $this->db->get_where('u_line', array('id' =>$id));
		return $query->row_array();
	}

	
	public function get_user_line($param,$page){

		$query_sql  = '	SELECT	c.supplier_reply,l.overcity,c.id,m.nickname as truename,c.addtime,c.reason,mo.productname,mo.productautoid as lid,mo.expert_name,CASE WHEN c.status=0 THEN "未处理"	WHEN c.status=1 THEN "已处理"	ELSE "" END "status" ,c.mobile,c.remark,c.attachment';
		$query_sql.=' FROM u_complain AS c';
		$query_sql.=' left JOIN u_member_order AS mo ON c.order_id=mo.id ';
		$query_sql.='left JOIN u_line as l on l.id=mo.productautoid ';
		$query_sql.=' left JOIN u_member AS m ON mo.memberid=m.mid WHERE c.order_id>0 and FIND_IN_SET(2,c.complain_type)>0 ';
		if($param!=null){

			if(null!=array_key_exists('productname', $param)){
				$query_sql.=' AND mo.productname LIKE ? ';
				$param['productname'] = '%'.trim($param['productname']).'%';
			}
			if(null!=array_key_exists('truename', $param)){
				$query_sql.=' AND m.nickname LIKE ? ';
				$param['truename'] = '%'.trim($param['truename']).'%';
			}
			if(null!=array_key_exists('status', $param)){
				$query_sql.=' AND c.status = ? ';
			}
			if(null!=array_key_exists('supplier_id', $param)){
				$query_sql.=' AND mo.supplier_id = ?';
			
			}
		}
		$query_sql.=' ORDER BY c.status asc , c.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	public function insert_replay($table,$object,$where){
		$this->db->where($where);
		return $this->db->update($table, $object);
	}
}