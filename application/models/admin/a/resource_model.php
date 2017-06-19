<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Resource_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'pri_resource';
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	
	function get_resource($whereArr){		
		$datafield = "r.resourceId AS '资源ID', 	r.code AS '编号', 	r.name AS '资源', 	r.uri AS '访问URL', r.description AS '描述',r.pid AS '父ID' ";
		$this->db->select ( $datafield );
		$this->db->from ( $this->table_name . ' as r ' );
		$this->db->join ( 'pri_roleresource as rs ', 'r.resourceId=rs.resourceId', 'left' );
		$this->db->join ( 'pri_adminrole as ar ', 'ar.roleId =rs.roleId', 'left' );
		$this->db->where ( $whereArr );
		$query = $this->db->get ();		
		return $query->result_array ();		
	}
}