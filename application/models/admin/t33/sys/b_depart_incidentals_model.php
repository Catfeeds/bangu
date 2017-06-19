<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_depart_incidentals_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_depart_incidentals' );
	}
	/**
	 * 杂费列表
	 * @param:  联盟单位id
	 *
	 * */
	public function zafei_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['depart_id']))
			$where_str.=" and i.depart_id='{$where['depart_id']}'";
		if(isset($where['depart_pid']))
			$where_str.=" and i.depart_pid='{$where['depart_pid']}'";
		if(isset($where['employee_name']))
			$where_str.=" and i.employee_name like '%{$where['employee_name']}%'";
		if(isset($where['item']))
			$where_str.=" and i.item like '%{$where['item']}%'";
		
		if(isset($where['starttime']))
			$where_str.=" and i.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and i.addtime<='{$where['endtime']}'";
		
		if(isset($where['price_start']))
			$where_str.=" and i.amount>='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and i.amount<='{$where['price_end']}'";

		$sql="
		select
				i.*,d.name as depart_name,d2.name as depart_pname
		from
				b_depart_incidentals as i
				left join b_depart as d on i.depart_id=d.id
				left join b_depart as d2 on i.depart_pid=d2.id
		where
				 i.union_id='{$where['union_id']}' {$where_str}
		";
	
		$sql.="order by i.id desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	
	
	
}