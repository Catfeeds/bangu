<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_limit_log_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_limit_log' );
	}
	/**
	 * 额度使用日志
	 * @param:  联盟单位id
	 *
	 * */
	public function log_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		
		if(isset($where['starttime']))
			$where_str.=" and l.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and l.addtime<='{$where['endtime']}'";
		if(isset($where['ordersn']))
			$where_str.=" and l.order_sn like '%{$where['ordersn']}%'";
	
	
		$sql="
		select
				l.*,e.realname as expert_name
	    from
	    		b_limit_log as l
	    		left join b_depart as d on d.id=l.depart_id
	    		left join u_expert as e on e.id=l.expert_id
		where
			     l.depart_id='{$where['depart_id']}' {$where_str}
		";
	
		$sql.="order by l.addtime desc,id desc";
	    //var_dump($sql);
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
	    return $return;
	}
}