<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert_upgrade_model extends MY_Model {
	private $table_name = 'u_expert_upgrade';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	public  function get_expertUpgrade_list($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql  = 'SELECT l.linename AS line_title,(l.agent_rate_int+l.agent_rate_child) as agent_rate,l.id as lid,l.overcity,s.company_name AS supplier_name,e.realname AS expert_name,eu.grade_after,eu.grade_before,l.agent_rate_child,';
		$query_sql.=' eu. STATUS,eu.id AS upgrade_id,eu.expert_id,eu.line_id,eu.apply_remark,eu.refuse_remark,eu.supplier_reason,group_concat(sp.cityname) AS cityname ';
		$query_sql.=' FROM (SELECT *  FROM	u_expert_upgrade AS en ORDER BY en.addtime DESC) AS eu ';
		$query_sql.=' LEFT JOIN u_line AS l ON eu.line_id = l.id';
		$query_sql.=' LEFT JOIN u_line_startplace AS ls ON ls.line_id = l.id';
		$query_sql.=' LEFT JOIN u_startplace AS sp ON sp.id = ls.startplace_id';
		$query_sql.=' LEFT JOIN u_expert AS e ON eu.expert_id = e.id';
		$query_sql.=' LEFT JOIN u_supplier AS s ON l.supplier_id = s.id';
		$query_sql.=' where s.id='.$login_id;

		if(null!=array_key_exists('status', $param)){
			$query_sql.=' AND eu.status  = ? ';
			$param['status'] = trim($param['status']);
		}
		if(null!=array_key_exists('linename', $param)){
			$query_sql.=' AND l.linename  like ? ';
			$param['linename'] = '%'.trim($param['linename']).'%';
		}
		if(null!=array_key_exists('startcity_id', $param)){
			$query_sql.=' AND sp.id  = ? ';
			//$query_sql.=' AND FIND_IN_SET(?,l.overcity)>0 ';
			$param['startcity_id'] = trim($param['startcity_id']);
		}
		if(null!=array_key_exists('destcity', $param)){
			//$query_sql.=' AND sp.id  = ? ';
			$query_sql.=' AND FIND_IN_SET(?,l.overcity)>0 ';
			$param['destcity'] = trim($param['destcity']);
			unset($param['cityName']);
		}else if(null != array_key_exists ( 'cityName', $param )){
			$dest=$this->get_destname(trim($param['cityName']));
			if(!empty($dest)){
				$param['cityName']=$dest['id'];
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['cityName'] =trim($param['cityName']) ;
			}else{
				$param['cityName'] =0 ;
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['cityName'] =trim($param['cityName']) ;
			}
		}
		
		if(null!=array_key_exists('expert_id', $param)){
			//$query_sql.=' AND sp.id  = ? ';
			$query_sql.=' AND e.id=?  ';
			$param['expert_id'] = trim($param['expert_id']);
		}
		$query_sql.=' GROUP BY	eu.line_id,eu.expert_id ORDER BY eu.id DESC ';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//模糊目的地搜索
	function get_destname($destname){
		$data=$this->db->query("select id,kindname from u_dest_base  where kindname = '{$destname}'")->row_array();
		return $data;
	}

}