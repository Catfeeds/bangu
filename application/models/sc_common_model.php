<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_common_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'sc_common_problem' );
	}
	//资讯分页
	function get_common_list($whereArr ,$page = 1,$num =10){
		$whereStr = ' where ';
		foreach($whereArr as $key =>$val)
		{
			if (!empty($val) || $val === 0)
			{
				$whereStr .= " $key = '$val' and";
			}
			else
			{
				continue;
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		if($page>0){
			$limitStr = ' limit '.($page-1)*$num.','.$num;
		}else{  //计算总数
			$limitStr='';
		}
		$sql='SELECT cp.id,cp.title,cp.addtime,cp.is_show,cp.index_kind_id,cp.modtime,cpd.content FROM sc_common_problem AS cp ';
		$sql .= ' LEFT JOIN sc_common_problem_detail AS cpd ON cp.id = cpd.sc_common_problem_id '. $whereStr;
		$data['count'] = $this ->getCount($sql ,array());
		$sql = $sql.' order by cp.addtime desc '.$limitStr;
		$data['consultData'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}
	//获取表的数据
	function get_tableData($table,$where='',$type=0){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($where)){
			$this->db->where($where);
		}	
		if($type==1){
			return $this->db->get()->row_array();
		}else{
			return $this->db->get()->result_array();
		}
	}
	//根据类型查询游记
	function get_trave_data($where,$limit=11){
		$this->db->select('tn.title,tn.id,tn.addtime,tn.cover_pic,tn.expert_id');
		$this->db->from('u_expert AS e');
		$this->db->join('travel_note as tn ', 'e.id = tn.userid', 'left');
		$this->db->join('u_line AS l ', 'tn.line_id = l.id', 'left');
		$this->db->where('tn.status =1');
		$this->db->order_by('tn.addtime desc');
		$this->db->limit($limit);
		if(!empty($where)){
			$this->db->where($where);
		}
		$data = $this ->db->get()->result_array();
		return $data;
	}
	//根据类型查询线路
	function get_line_data($where,$limit=11){
		$this->db->select('l.linename,l.addtime,l.mainpic,l.id,l.overcity,l.lineprice');
		$this->db->from('u_line AS l');
		$this->db->where('l.status =2');
		$this->db->order_by('l.addtime desc');
		
		$this->db->limit($limit);
		if(!empty($where)){
			$this->db->where($where);
		}
		$data = $this ->db->get()->result_array();
		return $data;
	}
	//游记 前十条的访问总数
	function get_hot_consult($where){
		$this ->db ->select('sum(tn.shownum) as shownum ');
		$this->db->from('travel_note as tn');
		$this->db->join('u_line AS l ', 'tn.line_id = l.id', 'left');
		$this->db->where('tn.status =1');
		$this->db->order_by('tn.addtime desc');
		$this->db->limit(11);
		if(!empty($where)){
			$this->db->where($where);
		}
		$query = $this->db->get ();
		return $query->row_array ();
	}
	//常见问题的详情页
	 function get_common_detail($where=''){
	 	$this ->db ->select('cp.*, scp.content');
	 	$this->db->from('sc_common_problem as cp');
	 	$this->db->join('sc_common_problem_detail AS scp ', 'cp.id = scp.sc_common_problem_id', 'left');
	 	if(!empty($where)){
	 		$this->db->where($where);
	 	}
	 	$query = $this->db->get ();
	 	return $query->row_array ();
	 }
	 //常见问题的上一条
	 function get_prev_data($id,$where){
	 	$sql="SELECT cp.id,cp.title,cp.addtime,cp.is_show,cp.index_kind_id,cp.modtime,cpd.content FROM sc_common_problem AS cp ";
	 	$sql .= " LEFT JOIN sc_common_problem_detail AS cpd ON cp.id = cpd.sc_common_problem_id where cp.is_show=1 and cp.id>{$id} {$where}";
	 	$sql .=" order by cp.addtime desc";
	 //	$query_sql="select * from u_consult where id>{$id} {$where} order by addtime asc  LIMIT 1";
	 	$query = $this->db->query($sql);
	 	$rows = $query->row_array();
	 	return $rows; 
	 }
	 //常见问题的下一条
	 function get_next_data($id,$where){

	 	$sql="SELECT cp.id,cp.title,cp.addtime,cp.is_show,cp.index_kind_id,cp.modtime,cpd.content FROM sc_common_problem AS cp ";
	 	$sql .= " LEFT JOIN sc_common_problem_detail AS cpd ON cp.id = cpd.sc_common_problem_id where cp.is_show=1 and cp.id<{$id} {$where}";
	 	$sql .=" order by cp.addtime desc";
	 	//	$query_sql="select * from u_consult where id>{$id} {$where} order by addtime asc  LIMIT 1";
	 	$query = $this->db->query($sql);
	 	$rows = $query->row_array();
	 	return $rows;
	 }
	 //深窗的旅游的详情页
	 function get_travel_article($where=''){
	 	$this ->db ->select('scp.*, cp.content');
	 	$this->db->from('sc_index_travel_article AS scp');
	 	$this->db->join('sc_travel_article_detail as cp', 'cp.sc_index_travel_article_id = scp.id', 'left');
	 	if(!empty($where)){
	 		$this->db->where($where);
	 	}
	 	$query = $this->db->get ();
	 	return $query->row_array ();
	 }
	 //深窗的旅游的详情页的上一条
	 function get_prev_travedata($id,$where){
	 	$sql="SELECT scta.*, atd.content FROM sc_index_travel_article AS scta ";
	 	$sql .= " LEFT JOIN sc_travel_article_detail AS atd ON scta.id = atd.sc_index_travel_article_id where scta.is_show=1 and scta.id>{$id} {$where}";
	 	$sql .=" order by scta.addtime desc";
	 	$query = $this->db->query($sql);
	 	$rows = $query->row_array();
	 	return $rows;
	 }
	 //深窗的旅游的详情页的下一条
	 function get_next_travedata($id,$where){
	 	$sql="SELECT scta.*, atd.content FROM sc_index_travel_article AS scta ";
	 	$sql .= " LEFT JOIN sc_travel_article_detail AS atd ON scta.id = atd.sc_index_travel_article_id where scta.is_show=1 and scta.id<{$id} {$where}";
	 	$sql .=" order by scta.addtime desc";
	 	$query = $this->db->query($sql);
	 	$rows = $query->row_array();
	 	return $rows;
	 }
	 //深窗曝光台文章详情的前5条的热门游记
	 function get_travel_hot(){
	 	$sql="SELECT tn.id,tn.title,tn.praise_count,tn.comment_count,me.status AS mestatus,m.litpic,";
	 	$sql.='tn.shownum,tn.cover_pic,tn.usertype,tn.userid,tn.addtime,me.id AS meid ';
	 	$sql.='FROM	travel_note AS tn ';
	 	$sql.='LEFT JOIN u_expert AS e ON tn.userid = e.id ';
	 	$sql.='LEFT JOIN u_member AS m ON tn.userid = m.mid ';
	 	$sql.='LEFT JOIN u_member_experience AS me ON m.mid = me.member_id ';
	 	$sql.='LEFT JOIN u_line AS l ON tn.line_id = l.id ';
	 	$sql.='WHERE tn. STATUS = 1 AND tn.is_show = 1 ';
	 	$sql.='ORDER BY	tn.shownum DESC LIMIT 0,5';
	 	$query = $this->db->query($sql);
	 	$rows = $query->result_array();
	 	return $rows;
	 }
}
