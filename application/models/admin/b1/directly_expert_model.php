<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Directly_expert_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	public  function get_expert_list($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		//	var_dump($arr);exit;
		$query_sql  = 'SELECT	e.id as expert_id,e.realname,e.mobile,e.email,e.idcard,e.addtime,c.NAME AS country,pro.name as province,ci.name as city ';
		$query_sql.=' FROM u_expert AS e LEFT JOIN u_area AS c ON e.country = c.id ';
		$query_sql.=' LEFT JOIN u_area AS pro ON e.province = pro.id LEFT JOIN u_area AS ci ON e.city = ci.id   ';
		$query_sql.=' where e.supplier_id='.$login_id;

		if(null!=array_key_exists('status', $param)){
			$query_sql.=' AND e.status  = ? ';
			$param['status'] = trim($param['status']);
		}
		if(null!=array_key_exists('realname', $param)){
			$query_sql.=' AND e.realname  like ? ';
			$param['realname'] = '%'.trim($param['realname']).'%';
		}

		if(null!=array_key_exists('mobile', $param)){
			$query_sql.=' AND e.mobile  = ? ';
			$param['mobile'] = trim($param['mobile']);
		}
		if(null!=array_key_exists('country', $param)){
			$query_sql.=' AND e.country  = ? ';
			$param['country'] = trim($param['country']);
		}
		if(null!=array_key_exists('province_id', $param)){
			$query_sql.=' AND e.province  = ? ';
			$param['province_id'] = trim($param['province_id']);
		}
		if(null!=array_key_exists('city_id', $param)){
			$query_sql.=' AND e.city  = ? ';
			$param['city_id'] = trim($param['city_id']);
		}
		$query_sql.=' order by e.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	public function get_cityName($cityName) {
		$sql = "select name,id from u_area as a where pid = (select id from u_area as ua where ua.name like '{$cityName}%'  order by ua.id desc limit 1) and level = 4 and isopen = 1";
		$areaData = $this ->db ->query($sql) ->result_array();
		return $areaData;
	}
	/**
	 * 添加直属管家
	 * @param array $insertArr   直属管家信息
	 * @param array $insertC     荣誉证书
	 * @param array $insertR     个人简历
	 * @param int   $supplier_id 供应商ID
	 * @return bool 
	 */
	public function insert_directly_expert($insertArr,$insertC,$insertR,$supplier_id,$expert_dest,$visit){
		$this->db->trans_start();
		
		$insertArr['status']=1;
		$insertArr['supplier_id']=$supplier_id;
		$insertArr['addtime']=date('Y-m-d H:i:s');
		
  		$this->db->insert('u_expert',$insertArr);
		$expert_id=$this->db->insert_id();
		
		if(!empty($insertC['certificate'])){  //荣誉证书
			foreach ($insertC['certificate'] as $k=>$v){
				if(!empty($v)){
					$insertCer=array(
						'certificate'=>$v,
						'certificatepic'=>$insertC['certificatepic'][$k],
						'status'=>1,
						'expert_id'=>$expert_id
					);
					$this->db->insert('u_expert_certificate',$insertCer);
				}
				
			}
		}

		if(!empty($insertR['company_name'])){ //添加从业经历
			foreach ($insertR['company_name'] as $key=>$val){
				if(!empty($val)){
					$insertRes=array(
						'starttime'=>$insertR['starttime'][$key],
						'endtime'=>$insertR['endtime'][$key],
						'job'=>$insertR['job'][$key],
						'description'=>$insertR['description'][$key],
						'company_name'=>$insertR['company_name'][$key],
						'status'=>1,
						'expert_id'=>$expert_id
					);
					$this->db->insert('u_expert_resume',$insertRes);
				}
			}
		}
		//添加申请的线路
		$lineData = $this ->db ->query("select id from u_line where  producttype=0 and supplier_id=".$supplier_id) ->result_array();
		if(!empty($lineData)){
			foreach ($lineData as $k=>$v){
				$lineApply['line_id']=$v['id'];
				$lineApply['grade']=1;
				$lineApply['addtime']=date('Y-m-d H:i:s');
				$lineApply['modtime']=date('Y-m-d H:i:s');
				$lineApply['expert_id']=$expert_id;
				$lineApply['status']=2;
				$this->db->insert('u_line_apply',$lineApply);
			}
		}
		
		 //擅长目的地
                    	if(!empty($expert_dest)){ 
                                     $expert_destArr=explode(',', $expert_dest) ;
                                     foreach ($expert_destArr as $key => $value) {
                                                     if(!empty($value)){
                                                               $destinsert['expert_id']=$expert_id;
                                                               $destinsert['dest_id']=$value;
                                                               $this->db->insert('u_expert_good_dest',$destinsert);
                                                     }
                                     }
                   	 }
                   	//上门服务
                    	if(!empty($visit)){
                                     $visitArr=explode(',', $visit) ;
                                     foreach ($visitArr as $key => $value) {
                                                     if(!empty($value)){
                                                               $visitinsert['expert_id']=$expert_id;
                                                               $visitinsert['service_id']=$value;
                                                               $this->db->insert('u_expert_visit_service',$visitinsert);
                                                     }
                                     }         
                    	}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			
			return $expert_id;
		}
		
	}
	/*管家信息*/
	function get_expert_msg($where){
		$this->db->select('id');
		$this->db->where($where);
		$this->db->where('(status=0 or status=1 or status=2)');
		return  $this->db->get('u_expert')->row_array();
	}
	/*管家信息*/
	function get_expert_data($where){
		$query_sql  = 'SELECT	e.*,c.NAME AS country1,pro.name as province1,ci.name as city1 ';
		$query_sql.=' FROM u_expert AS e LEFT JOIN u_area AS c ON e.country = c.id ';
		$query_sql.=' LEFT JOIN u_area AS pro ON e.province = pro.id LEFT JOIN u_area AS ci ON e.city = ci.id   ';
		$query_sql.=' where e.id='.$where;
		return  $this ->db ->query($query_sql) ->row_array();
	}
	/*管家荣誉证书*/
	function get_expert_resume($where){
		$this->db->select('*');
		$this->db->where($where);
		return  $this->db->get('u_expert_resume')->result_array();
	}
	/*管家荣誉证书*/
	function get_expert_certificate($where){
		$this->db->select('*');
		$this->db->where($where);
		return  $this->db->get('u_expert_certificate')->result_array();
	}
	/*管家状态*/
	function update_status($id,$object){
		$this->db->where('id', $id);
		return $this->db->update('u_expert', $object);
	}
	/*出发地*/
	function sel_city($pid){
		$sql = "select id,name from u_area where pid = {$pid}";
		$query = $this ->db ->query($sql);
		$data = $query ->result_array();
		if (!empty($data))
			return $data;
		else
			return false;
	}
	
}