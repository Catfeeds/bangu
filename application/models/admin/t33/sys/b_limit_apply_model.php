<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_limit_apply_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_limit_apply' );
	}
	/**
	 * 信用额度申请列表
	 * @param:  联盟单位id
	 *
	 * */
	public function apply_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['depart_id']))
			$where_str.=" and a.depart_id='{$where['depart_id']}'";
		if(isset($where['expert_name']))
			$where_str.=" and a.expert_name like '%{$where['expert_name']}%'";
		if(isset($where['manager_name']))
			$where_str.=" and a.manager_name like '%{$where['manager_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";
	
	
		$sql="
		select
				a.*,s.company_name
		from 
				b_limit_apply as a
				left join u_supplier as s on s.id=a.supplier_id
		where
		a.union_id='{$where['union_id']}' {$where_str}
		";
	
		$sql.="order by a.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
}