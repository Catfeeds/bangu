<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sale_model extends MY_Model {

	function __construct() {
		parent::__construct ( 'u_sales_type' ); //默认数据表
	}
	
	/**
	 * @method 大促销活动：线路列表
	 * @author wwb
	 * @since  2017-03-15
	 * @param array $whereArr
	 */
	public function getALineData(array $whereArr = array() ,$specialSql = '' ,$num=false ,$orderBy='l.modtime desc')
	{
		
		$sql = 'select 
						l.displayorder, ula.collect_num_vr,l.linecode,l.confirm_time,sl.lineName as linename,l.modtime,l.addtime,
						s.linkman,s.company_name,l.id as line_id,l.status,l.agent_rate_int,l.overcity,l.online_time,
						a.realname as username,group_concat(sp.cityname) as cityname,
				        st.typeName,sl.sort,sl.off_reason
				from 
						u_sales_line as sl 
						left join u_line as l on sl.lineId=l.id
						left join u_supplier as s on l.supplier_id = s.id 
						left join u_admin as a on l.admin_id = a.id 
						left join u_line_startplace as ls on ls.line_id = l.id 
						left join u_startplace as sp on sp.id=ls.startplace_id 
						left join u_line_affiliated as ula on ula.line_id = l.id
						left join u_sales_type as st on st.typeId=sl.typeId
				';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'group by sl.lineId desc',$specialSql ,$num);
	}
  /*
   * 线路详情
   * */
	public function getOneLine($lineid)
	{
		$sql="select sl.*,st.typeName from u_sales_line as sl left join u_sales_type as st on st.typeId=sl.typeId where lineId=".$lineid;
		return $this->db->query($sql)->row_array();
		
	}
    //保存促销线路售卖管家
    function saveLineSaleExpert($lineId,$expertId){
    	$this->db->trans_start ();
    	
    	$this->db->where (array('line_id'=>$lineId))->update ('u_line_apply',array('status'=>4) );
    	
    	foreach ($expertId as $k=>$v){
    		if(!empty($v)){
    			
    			$aplly=$this->db->query("select * from u_line_apply where line_id={$lineId} and expert_id={$v}")->row_array();
    		   
    		    if(empty($aplly)){  //插入售卖线路表
    		    	$data=array(
    		    		'grade'=>1,
    		    		'addtime'=>date("Y-m-d H:i:s",time()),
    		    		'modtime'=>date("Y-m-d H:i:s",time()),
    		    		'line_id'=>$lineId,
    		    		'expert_id'=>$v,
    		    		'status'=>2
    		    	);
    		    	$this->db->insert('u_line_apply',$data);
    		    }else{  //修改售卖线路表
    		    	$this->db->where (array('line_id'=>$lineId,'expert_id'=>$v))->update ('u_line_apply',array('status'=>2) );
    		    }
    		}
    	}
    	
    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		return false;
    	}else{
    	
    		return true;
    	}
    }
    //线路售卖管家
    function get_saleExpert($lineid){
    	$sql="select lap.*,e.realname from u_line_apply as lap left join u_expert as e on lap.expert_id=e.id where line_id={$lineid} and lap.status=2 ";
    	return $this->db->query($sql)->result_array();
    }
    
}