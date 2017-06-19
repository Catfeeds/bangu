<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Insure_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	//保险
	function get_insure_list($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql=' select insure.id,insure.supplier_id,insure.insurance_type,insure.settlement_price,insure.insurance_name,insure.insurance_company,insure.insurance_date,insure.insurance_price,insure.insurance_clause as insurance_clause1, ';
		$query_sql.=' left(insure.simple_explain,15) as "simple_explain",insure.simple_explain as "simple_explain1", left(insure.description,15) as "description",insure.description as "description1",left(insure.insurance_clause,15) as "insurance_clause",insure.modtime ,insure.status ';
		$query_sql.=' FROM  u_travel_insurance AS insure where insure.status=1 and insure.supplier_id='.$login_id;	

		$query_sql.=' by insure.modtime desc';
		
		return $this->queryPageJson( $query_sql , $param ,$page );
		
	}
	//插入表
	public function insert_data($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	//查询表
	public function select_data($table,$where){
		$this->db->select('*');
		if(!empty($where)){
			$this->db->where($where);
		}
		 
		return  $this->db->get($table)->result_array();
	}
	//查询表
	public function select_rowData($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		return  $this->db->get($table)->row_array();
	}
	//修改
	public function update_rowdata($table,$object,$where){
		$this->db->where($where);
		return $this->db->update($table, $object);
	}
	//保险种类
	public function get_insurance_kind($code){
		$sql_rout="SELECT chird.* FROM u_dictionary AS chird LEFT JOIN u_dictionary AS parent ON parent.dict_id = chird.pid ";
		$sql_rout.="where parent.dict_code='{$code}'";
		$query_rout = $this->db->query($sql_rout);
		$rows = $query_rout->result_array();
		return $rows;
	}

}
