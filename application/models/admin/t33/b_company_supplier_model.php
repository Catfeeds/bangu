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

class B_company_supplier_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'b_company_supplier';
	
	public function __construct() 
	{
		parent::__construct($this->table_name);
	}
	
	/**
	 * @method 获取旅行社的所有供应商
	 * @author jkr
	 */
	public function getSupplierAll($whereArr)
	{
		$sql = 'select s.company_name,s.id,s.brand from u_supplier as s left join b_company_supplier as cs on cs.supplier_id=s.id'.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array(); 
	}
	
	/**
	 * 获取当前旅行社下的所有供应商
	 * @param:  联盟单位id
	 *        
	 * */
	public function get_supplier($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
		
		//where条件
		$where_str="";
		if(isset($where['supplier_name']))
			$where_str.=" and s.company_name like '%{$where['supplier_name']}%'";
		if(isset($where['brand']))
			$where_str.=" and s.brand like '%{$where['brand']}%'";
		if(isset($where['supplier_code']))
			$where_str.=" and s.code like '%{$where['supplier_code']}%'";
		if(isset($where['mobile']))
			$where_str.=" and (s.mobile like '%{$where['mobile']}%' or s.login_name like '%{$where['mobile']}%')";
		if(isset($where['email']))
			$where_str.=" and s.email like '%{$where['email']}%'";
		if(isset($where['country']))
			$where_str.=" and s.country='{$where['country']}'";
		if(isset($where['province']))
			$where_str.=" and s.province='{$where['province']}'";
		if(isset($where['city']))
			$where_str.=" and s.city='{$where['city']}'";
		if(isset($where['supplier_id']))
			$where_str.=" and s.id='{$where['supplier_id']}'";
		
		if(isset($where['status']))
			$where_str.=" and cs.status='{$where['status']}'";
		
		
		$sql="
				select 
						s.*,a.name as countryname,a1.name as provincename,a2.name as cityname,cs.status as supplier_status
				from 
						b_company_supplier as cs
				        left join u_supplier as s on s.id=cs.supplier_id
				        left join u_area as a on s.country=a.id
				        left join u_area as a1 on s.province=a1.id
				        left join u_area as a2 on s.city=a2.id
				        
				where  
						cs.union_id='{$where['union_id']}' {$where_str}
			 ";
		
		$sql.="order by cs.addtime desc";
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from))
			$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
		
		return $return;
	}
	/**
	 * 获取平台所有的供应商
	 * @param:  联盟单位id
	 *
	 * */
	public function get_import_supplier($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['kind']))
			$where_str.=" and s.kind='{$where['kind']}'";
		if(isset($where['country']))
			$where_str.=" and s.country='{$where['country']}'";
		if(isset($where['province']))
			$where_str.=" and s.province='{$where['province']}'";
		if(isset($where['city']))
			$where_str.=" and s.city='{$where['city']}'";
		if(isset($where['company_name']))
			$where_str.=" and s.company_name like'%{$where['company_name']}%'";
		if(isset($where['brand']))
			$where_str.=" and s.brand like '%{$where['brand']}%'";
		if(isset($where['realname']))
			$where_str.=" and s.realname like'%{$where['realname']}%'";
		
		$sql="
		select
		s.*,a.name as countryname,a1.name as provincename,a2.name as cityname
		from
        u_supplier as s 
		left join u_area as a on s.country=a.id
		left join u_area as a1 on s.province=a1.id
		left join u_area as a2 on s.city=a2.id
	
		where
		(s.status=2 or s.status=1) and s.id not in (select supplier_id from b_company_supplier where union_id='{$where['union_id']}') {$where_str}
		";
	
		$sql.="order by s.line_count desc,s.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	
	/**
	 * 供应商的银行账户信息
	 * 
	 * */
	public function supplier_bank($supplier_id)
	{
		$supplier_id=$this->sql_check($supplier_id);
		$sql="
				select 
						*
				from 
						u_supplier_bank
				where 
						supplier_id='{$supplier_id}'
			 ";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	
	/**
	 * @method 获取旅行社下的所有供应商
	 * @author jkr
	 */
	public function getUnionSupplierAll($unionId)
	{
		$sql = 'select cs.supplier_id,s.company_name as supplier_name from b_company_supplier as cs left join u_supplier as s on s.id = cs.supplier_id where cs.status=1 and s.status=2 and cs.union_id ='.$unionId;
		return $this ->db ->query($sql) ->result_array();
	}
	
}