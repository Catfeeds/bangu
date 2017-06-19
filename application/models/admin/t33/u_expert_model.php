<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:11
 * @author		温文斌
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class U_expert_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_expert';
	
	public function __construct() 
	{
		parent::__construct($this->table_name);
	}
	/**
	 * 获取当前旅行社下的所有管家
	 * @param:  联盟单位id
	 *        
	 * */
	public function get_expert($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
		
		//where条件
		$where_str="";
		if(isset($where['realname']))
			$where_str.=" and e.realname like '%{$where['realname']}%'";
		if(isset($where['nickname']))
			$where_str.=" and e.nickname like '%{$where['nickname']}%'";
		if(isset($where['mobile']))
			$where_str.=" and e.mobile like '%{$where['mobile']}%'";
		if(isset($where['email']))
			$where_str.=" and e.email like '%{$where['email']}%'";
		if(isset($where['country']))
			$where_str.=" and e.country='{$where['country']}'";
		if(isset($where['province']))
			$where_str.=" and e.province='{$where['province']}'";
		if(isset($where['city']))
			$where_str.=" and e.city='{$where['city']}'";
		if(isset($where['depart_id']))
			$where_str.=" and e.depart_id='{$where['depart_id']}'";
		if(isset($where['union_status']))
			$where_str.=" and e.union_status='{$where['union_status']}'";
		
		
		$sql="
				select 
						e.*,d.name as depart_name,a.name as countryname,a1.name as provincename,a2.name as cityname
				from 
						u_expert as e
				        left join b_depart as d on d.id=e.depart_id
				        left join u_area as a on e.country=a.id
				        left join u_area as a1 on e.province=a1.id
				        left join u_area as a2 on e.city=a2.id
				        
				where  
						e.union_status!=0 and e.union_id='{$where['union_id']}' {$where_str}
			 ";
		
		$sql.="order by e.addtime desc";
		
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
			$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
		
		return $return;
	}
	/*
	 * 指定管家的部门： 所有一级管家
	 * */
	public function depart_list($expert_id)
	{
		$sql="select is_dm,depart_id from  u_expert where id={$expert_id}";
		$row=$this->db->query($sql)->row_array();
		$expert_list['is_dm']=$row['is_dm'];
		if(!empty($row))
		{
			$expert_list['list']=$this->db->query("select * from u_expert where is_dm=0 and id!={$expert_id} and depart_id={$row['depart_id']}")->result_array();
		}
		return $expert_list;
	}
	/**
	 * 获取经理
	 * @param:
	 *         array(
	 *         'role_id'=>
	 *         )
	 * */
	public function get_manager($depart_list)
	{
		$depart_list="(".$depart_list.")";
		$sql="select id,realname,is_dm from u_expert where is_dm=1 and depart_id in".$depart_list;
		$result=$this->db->query($sql)->row_array();
		return $result;
	}
	/**
	 * @method 恢复与管家的合作
	 * @author jiakairong
	 * @since  2015-12-02
	 */
	public function recoveryExpert($expert_id)
	{
		$this->db->trans_start();
		//更新供应商表
		$sql = 'update u_expert set status = 2 ,modtime ="'.date('Y-m-d H:i:s').'" where id='.$expert_id;
		$this ->db ->query($sql);
		//更新黑名单
		$sql = 'update u_platform_refuse set status = -1 where userid ='.$expert_id.' and refuse_type = 1';
		$this ->db ->query($sql);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 获取管家详细
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function getExpertDetail($expertId)
	{
		$sql = 'select 
						e.*,bd.name as depart_name,
				       (select GROUP_CONCAT(name) from u_area where FIND_IN_SET(id,e.visit_service) >0 )as visit_service_ch,  
					   (select GROUP_CONCAT(d.kindname) as expert_dest from u_dest_base as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_dest_ch, 
						a.name as country_name,b.name as province_name,c.name as city_name,d.name as region_name
				 from 
						u_expert as e 
				        left join b_depart as bd on bd.id=e.depart_id
						left join u_area as a on a.id = e.country 
						left join u_area b on b.id=e.province 
						left join u_area as c on c.id = e.city 
						left join u_area as d on d.id = e.region 
				where 
						e.id ='.$expertId;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取管家从业简历
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function getExpertResume($expertId)
	{
		$sql = 'select * from u_expert_resume where expert_id='.$expertId.' and status = 1 order by id asc';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取管家证书
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function getExpertCertificate($expertId)
	{
		$sql = 'select * from u_expert_certificate where expert_id='.$expertId.' and status = 1 order by id asc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	
	/**
	 * 获取平台所有的管家（自家旅行社下管家除外）
	 * @param:  联盟单位id
	 *
	 *
	 *     (select GROUP_CONCAT(name) from u_area where FIND_IN_SET(id,e.visit_service) >0 )as visit_service_ch,  
		   (select GROUP_CONCAT(d.kindname) as expert_dest from u_dest_base as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_dest_ch, 
	 *
	 * */
	public function import_expert_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	   
		//where条件
		$where_str="";
		if(isset($where['type']))
			$where_str.=" and e.type='{$where['type']}'";
		if(isset($where['realname']))
			$where_str.=" and e.realname like '%{$where['realname']}%'";
		if(isset($where['mobile']))
			$where_str.=" and e.mobile like '%{$where['mobile']}%'";
		if(isset($where['province']))
			$where_str.=" and e.province='{$where['province']}'";
		if(isset($where['city']))
			$where_str.=" and e.city='{$where['city']}'";

		$sql="
			select
					e.id,e.nickname,e.realname,e.mobile,e.big_photo,e.small_photo,e.satisfaction_rate,e.addtime,e.people_count,
					a.name as countryname,a1.name as provincename,a2.name as cityname
			from
					u_expert as e
					left join u_area as a on e.country=a.id
					left join u_area as a1 on e.province=a1.id
					left join u_area as a2 on e.city=a2.id
		   where
					(((e.status=2 and e.union_id=0) or (e.union_id!=0 and e.union_status!=1)) {$where_str})
		"; // and e.union_status=0 and e.union_id=0   
		
		$sql.="order by e.satisfaction_rate desc,e.addtime desc";
	    
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * @method 指定旅行社下的管家
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function union_expert($union_id,$content="")
	{
		$sql = "select 
					   e.id,e.realname,e.depart_id,d.name as depart_name
				from
					   u_expert as e 
				       left join b_depart as d on d.id=e.depart_id
				where 
					   e.union_id='{$union_id}' and e.union_status=1 and e.realname like '%{$content}%'
			    order by 
			    		e.addtime desc
				";
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 管家详情
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function expert_row($expert_id)
	{
		$sql = "select
					    e.*,d.name as depart_name
				from
					    u_expert as e
		        		left join b_depart as d on d.id=e.depart_id
		        where
					    e.id='{$expert_id}'
			    
		";
		return $this ->db ->query($sql) ->row_array();
	}
	//供应商指定旅行社下的管家
	public function supplier_union_expert($supplier_id){
	        	$sql ="select union_id from b_company_supplier where supplier_id={$supplier_id} and status=1 "; 
	        	$union=$this ->db ->query($sql ) ->result_array();
	        	$expert=array();
	        	$where ='';
	       	  if(!empty($union[0])){
	       	  	foreach ($union as $key => $value) {
	       	  		$where=$where." e.union_id={$value['union_id']}  or";

	       	  	}
	       	  	if(!empty($where)){
	       	  		$where=substr($where,0,strlen($where)-2); 
	       	  	}
	       	  	$mysql="select  e.id,e.realname,e.depart_id,d.name as depart_name ";
			$mysql.="from u_expert as e ";
			$mysql.="left join b_depart as d on d.id = e.depart_id ";
			$mysql.="where {$where} and e. status = 2 ORDER BY e.addtime DESC ";
			return $this ->db ->query($mysql) ->result_array();	
	        	 }else{
	        	 	return '';	
	        	 }
	
	}
	//供应商指定旅行社的服务类型
	public function  get_server_range($supplier_id){
		$sql ="select union_id from b_company_supplier where supplier_id={$supplier_id} and status=1 "; 
	        	$union=$this ->db ->query($sql) ->result_array();
	       // 	echo $this->db->last_query();
	        	$expert=array();
	        	$where ='';
	       	  if(!empty($union[0])){
	       	  	foreach ($union as $key => $value) {
	       	  		$where=$where." e.union_id={$value['union_id']}  or";

	       	  	}
	       	  	if(!empty($where)){
	       	  		$where=substr($where,0,strlen($where)-2); 
	       	  	}
	       	  	 $mysql="select  e.* ";
			$mysql.="from b_server_range as e ";
			$mysql.="where {$where} and e. status =1 ORDER BY e.addtime DESC ";
			return $this ->db ->query($mysql) ->result_array();
			
	        	 }else{
	        	 	return '';	
	        	 }
	
	        	
	}
}