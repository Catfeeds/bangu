<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:55:53
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class App_line_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
		
	}
	/*线路申请管理分页查询*/
	public function get_app_line($param,$page,$city=''){
    	//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
 		$query_sql='';
		$query_sql.= 'SELECT la.id,	l.id as linecode,l.linecode as linecodeid,l.linename,e.satisfaction_rate ,la.expert_id ,l.overcity,l.agent_rate_int,';
		$query_sql.='(SELECT COUNT(*) FROM u_member_order AS mo WHERE	mo.expert_id = e.id	AND mo.productautoid = l.id  AND mo.status >4 ) AS "ordernum", ';
		$query_sql.='(SELECT SUM(mo.total_price) FROM u_member_order AS mo WHERE mo.expert_id = e.id AND mo.productautoid = l.id  AND mo.status >4 ) AS "ordermoney",';
		$query_sql.='l.agent_rate,s.company_name,e.realname, CASE WHEN la.grade = 1 THEN "管家" WHEN la.grade = 2 THEN "初级专家" WHEN la.grade = 3 THEN "中级专家" WHEN la.grade = 4 THEN "高级专家" WHEN la.grade = 5 THEN "明星专家" ELSE "管家" END "grade" ,';	
		$query_sql.='( SELECT SUM(sj.id) from u_expert_upgrade as sj where sj.expert_id=e.id and sj.line_id=l.id  and sj.status=-2)as "refuse",group_concat(sp.cityname) AS cityname ';
	//	$query_sql.='( SELECT grade_after FROM u_expert_upgrade AS sj WHERE sj.expert_id = e.id AND sj.line_id = l.id AND sj. STATUS =- 2 ORDER BY sj.addtime limit 1) AS "grade_after" ,';
	//	$query_sql.='( SELECT refuse_remark FROM u_expert_upgrade AS sj WHERE sj.expert_id = e.id AND sj.line_id = l.id AND sj. STATUS =- 2 ORDER BY sj.addtime desc limit 0,1) AS "refuse_remark" ';
		$query_sql.='FROM u_line_apply AS la ';
		$query_sql.='LEFT JOIN u_line AS l ON la.line_id = l.id ';
		$query_sql.='LEFT JOIN u_expert AS e ON la.expert_id = e.id ';
		$query_sql.='LEFT JOIN u_supplier AS s ON l.supplier_id = s.id ';
		$query_sql.='LEFT JOIN u_line_startplace AS ls ON ls.line_id = l.id ';
		$query_sql.='LEFT JOIN u_startplace AS sp ON sp.id = ls.startplace_id ';
		$query_sql.=' WHERE l.status=2 and e.status=2 and s.id = '.$login_id.' AND la.status = ?';

		if(!empty($city)){
			$citydata=$this->db->select('id')->from('u_startplace')->where('cityname',$city)->get()->row_array();
			if(!empty($citydata)){
				$query_sql.=' AND ls.startplace_id= '.$citydata['id'];
			}	
		}
	 	if($param!=null){

			if(null!=array_key_exists('expertid', $param)){
				$query_sql.=' AND e.id = ? ';
				$param['expertid'] = trim($param['expertid']);
			}
			if(null!=array_key_exists('overcity', $param)){
				$query_sql.=' AND FIND_IN_SET(?, l.overcity) ';
				$param['overcity'] = trim($param['overcity']);
			}

			if(null!=array_key_exists('formcity', $param)){
				$query_sql.=' AND ls.startplace_id= ? ';
				$param['formcity'] = trim($param['formcity']);
			}
		
			if(null!=array_key_exists('linename', $param)){
				$query_sql.=' AND l.linename LIKE ? ';
				$param['linename'] = '%'.trim($param['linename']).'%';
			}
			if(null!=array_key_exists('expert_grade', $param)){
				$query_sql.=' AND la.grade = ? ';
				$param['expert_grade'] = $param['expert_grade'];
			}
			
		} 
		$query_sql.=' GROUP BY la.id ORDER BY la.addtime desc';

		return $this->queryPageJson( $query_sql , $param ,$page); 
			
	}

	/*改变状态*/
	public function update_status($data,$id){
		$this->db->where('id', $id);
		return $this->db->update('u_line_apply', $data);	
	}
	/*专家查询*/
	public function updata_expert($id){
		$this->db->select('*');
		$this->db->from('u_line_apply');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	/*插入专家升级记录*/
   public function insert_expert_upgrade($table,$data){
      return	$this->db->insert($table, $data);
   }
   /*拒绝升级的原因*/
   public function insert_refuse($data,$id){
   		$this->db->where('id', $id);
   		return $this->db->update('u_line_apply', $data);
   }
   /* 目的地*/
   public function get_destinations($id){
	   	$this->db->select('*');
	   	$this->db->from('u_dest_base');
	   	$this->db->where('pid',$id);
	   	$this->db->order_by('id');
	   	$query = $this->db->get();
	   	return $query->result_array();
   }
   /*专家*/
   public function get_expert($id){
	   	$query_sql='SELECT la.id as lid,e.id,e.realname,e.nickname,mobile ';
	   	$query_sql.= 'FROM	u_line_apply AS la ';
	   	$query_sql.='LEFT JOIN u_line AS l ON la.line_id = l.id ';
	   	$query_sql.='LEFT JOIN u_expert AS e ON la.expert_id = e.id ';
	   	$query_sql.='WHERE	l. STATUS = 2 AND l.supplier_id='.$id.' AND la.STATUS = 2 ';
	   	$query_sql.='GROUP BY e.id ORDER BY id desc ';
	   	$query = $this->db->query($query_sql);
	   	$rows = $query->result_array();
	   	return $rows;
   }
   public function get_expert_msg($where){
	   	$this->db->select('grade_after,refuse_remark');
	   	$this->db->from('u_expert_upgrade');
	   	$this->db->where($where);
	   	$this->db->order_by("addtime", "asc");
	   	$query = $this->db->get();
	   	return $query->row_array();
   }
   /*供应商*/
   public function get_supplier(){
	   	$this->db->select('*');
	   	$this->db->from('u_supplier');
	   	$this->db->order_by('id');
	   	$query = $this->db->get();
	   	return $query->result_array();
   }
   /*专家*/
   public function get_expert_id($id,$line_id){
	   	$query = $this->db->query('select id,grade from u_line_apply where expert_id='.$id.' and line_id='.$line_id);
	   	$rows = $query->result_array();
	   	return $rows;
   }
   
}
