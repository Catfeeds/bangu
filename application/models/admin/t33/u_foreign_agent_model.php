<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_foreign_agent_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_foreign_agent' );
	}
	/**
	 * 目的地列表
	 * @param:  联盟单位id
	 *
	 * */
	public function dest_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['dest_name']))
			$where_str.=" and B.kindname like '%{$where['dest_name']}%'";
		if(isset($where['pid']))
			$where_str.=" and d2.pid = '{$where['pid']}'";
		if(isset($where['type'])&&$where['type']=="1") //未设置
			$where_str.=" and (A.adult_agent is null or A.child_agent is null or A.childnobed_agent is null or A.old_agent is null)";
		if(isset($where['type'])&&$where['type']=="2") //已设置
			$where_str.=" and A.adult_agent is not null and A.child_agent is not null and A.childnobed_agent is not null and A.old_agent is not null";
		
	
	
		$sql="
		select
		      B.id,B.kindname,A.adult_agent,A.child_agent,A.childnobed_agent,A.old_agent,A.id as agent_id,d2.pid
		from 
			  (select * from u_dest_base where level=3)B
			  left join (select * from u_foreign_agent where union_id='{$where['union_id']}')A on A.dest_id=B.id
			  left join u_dest_base as d2 on d2.id=B.pid
		where
		       1=1 {$where_str}
		";
	
		$sql.="order by d2.pid desc,B.id";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
}