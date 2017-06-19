<?php

/*
 * 订单: 平台管理费(旅行社账单)
 * */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_order_bill_yj_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_order_bill_yj' );
	}
	/**
	 * 按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function bill_yj($where,$from="",$page_size="10")
	{
		//where条件
		$where_str="";
		if(isset($where['user_name']))
			$where_str.=" and b.user_name like '%{$where['user_name']}%'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['starttime']))
			$where_str.=" and b.addtime >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and b.addtime <='{$where['endtime']}'";
		if(isset($where['status']))
			$where_str.=" and b.status ='{$where['status']}'";
		
		$sql="select 
					 b.*,mo.ordersn
				from 
					u_order_bill_yj as b
					left join u_member_order as mo on mo.id=b.order_id
					
				where
				     b.union_id='{$where['union_id']}' and b.user_type=2 and b.status!=1 and b.status!=3 {$where_str}
				order by 
					 b.addtime desc
				";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 
	 * @param:  联盟单位id
	 *
	 * */
	public function detail($where)
	{
	
		$sql="select
						b.*,mo.ordersn
				from
						u_order_bill_yj as b
						left join u_member_order as mo on mo.id=b.order_id
			
				where
						b.id='{$where['id']}'
	
		";
	
		$return=$this->db->query($sql)->row_array();
	    return $return;
	}
	
	
}