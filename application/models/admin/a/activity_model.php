<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class activity_model extends MY_Model {

	private $table_name = 'act_activity';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取活动
	 * @author xml
	 */
 	public function get_act_activity($param,$page){
		$query_sql='';
		$query_sql.=' SELECT act.id AS act_id,act.name,	act.description,act.starttime,act.endtime,act.addtime,a.username ';
		$query_sql.=' FROM	act_activity AS act ';
		$query_sql.=' LEFT JOIN u_admin as a ON a.id=act.adminid ';
		if($param!=null){
			if(null!=array_key_exists('adminid', $param)){
				$query_sql.=' where act.adminid = ? ';
				$param['adminid'] = $param['adminid'];
			}
			if(null!=array_key_exists('name', $param)){
				$query_sql.=' AND act.name  like ? ';
				$param['name'] = '%'.$param['name'].'%';
			}
		}
		$query_sql.=' ORDER BY act.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	} 
	/**
	 * @method 添加活动
	 * @author xml
	 * @param  Array  $insert  活动信息
	 * @param  string $city    活动城市信息
	 * @return bool
	 */
	function save_activity($insert,$city){	
		$this->db->trans_start();
		
		//添加活动主表act_code
		$this->db->insert('act_activity',$insert);
		$act_id=$this->db->insert_id();		

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{		
			return true;
		}
	}
	/**
	 * @method 活动详情
	 * @author xml
	 * @param  int $actid 活动ID  
	 */
	function activity_data($actid){
		$query_sql='';
		$query_sql.=' SELECT act.id AS act_id,act.name,act.description,act.starttime,act.endtime,act.addtime,a.username ';
		$query_sql.=' FROM	act_activity AS act ';
		$query_sql.=' LEFT JOIN u_admin as a ON a.id=act.adminid ';
		$query_sql.=' where  act.id='.$actid;
		$data=$this ->db ->query($query_sql) ->row_array();
		return $data;
	}
	/**
	 * @method 活动相关的城市
	 * @author xml
	 * @param  int $actid 活动ID
	 */
	function activity_city($actid){
		$query_sql='';
		$query_sql.=' SELECT sta.cityname,aty.startcityid ';
		$query_sql.=' FROM	act_activity AS act ';
		$query_sql.=' LEFT JOIN act_activity_city as aty on aty.act_id=act.id ';
		$query_sql.=' LEFT JOIN u_startplace as sta on sta.id= aty.startcityid';
		$query_sql.=' where aty.isopen=1 and act.id='.$actid.' ORDER BY aty.id ASC';
		$data=$this ->db ->query($query_sql) ->result_array();
		return $data;
	}
	/**
	 * @method 修改活动
	 * @author xml
	 * @param  Array  $insert  活动信息
	 * @param  int     $actid    活动ID
	 * @return bool
	 */
	function update_activity($insert,$actid){
		$this->db->where ( 'id', $actid );
		return $this->db->update ( 'act_activity', $insert );
	}
	/**
	 * @method 活动城市列表
	 * @author xml
	 */
	function get_act_city($param=array(),$city=array(),$page){
		$query_sql='';
		$query_sql.=' SELECT sta.cityname,act.id AS act_id,aty.id as cityid,act.name,aty.showorder,act.description,act.starttime,act.endtime,act.addtime,aty.isopen';
		$query_sql.=' FROM	act_activity AS act ';
		$query_sql.=' LEFT JOIN act_activity_city as aty on aty.act_id=act.id ';
		$query_sql.=' LEFT JOIN u_startplace as sta on sta.id= aty.startcityid ';
		if($param!=null){
			if(null!=array_key_exists('actid', $param)){
				$query_sql.=' where act.id = ? ';
				$param['actid'] = $param['actid'];
			}
			if(null!=array_key_exists('adminid', $param)){
				$query_sql.=' and act.adminid = ? ';
				$param['adminid'] = $param['adminid'];
			}
		
			if(null!=array_key_exists('name', $param)){
				$query_sql.=' AND act.name  like ? ';
				$param['name'] = '%'.$param['name'].'%';
			}
		}
		//地区搜索
		if($city!=''){
			
 			if(!empty($city['act_startcityid'])){
				$query_sql.=' and aty.startcityid ='.$city['act_startcityid'];
			}else{
				if(!empty($city['cityname'])){
					$citySql="select id FROM u_startplace where cityname LIKE '%{$city['cityname']}%'";
					$cityquery= $this->db->query($citySql);
					$cityid=$cityquery->row_array();
					if($cityid['id']>0){
						$query_sql.=' and aty.startcityid ='.$cityid['id'];
					}
				}
			} 
		}
		$query_sql.=' ORDER BY aty.showorder ASC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	/**
	 * @method 活动分类列表
	 * @author xml
	 */
	function get_act_tab($param,$page){
		$query_sql='';
		$query_sql.=' select a.name as actname,atb.id as tabid,a.id as actid,acty.id as ctyid ,sta.cityname ,atb.name,atb.showorder';
		$query_sql.=' from act_tab as atb ';
		$query_sql.=' LEFT JOIN act_activity_city  as acty  on atb.aac_id=acty.id ';
		$query_sql.=' LEFT JOIN  act_activity as a  on  acty.act_id=a.id ';
		$query_sql.=' LEFT JOIN u_startplace as sta on sta.id=acty.startcityid ';
		if($param!=null){
			if(null!=array_key_exists('actid', $param)){
				$query_sql.=' where a.id = ? ';
				$param['actid'] = $param['actid'];
			}
		
			if(null!=array_key_exists('name', $param)){
				$query_sql.=' AND atb.name  like ? ';
				$param['name'] = '%'.$param['name'].'%';
			}	
			if(null!=array_key_exists('adminid', $param)){
				$query_sql.=' and a.adminid = ? ';
				$param['adminid'] = $param['adminid'];
			}
		}
		$query_sql.=' ORDER BY acty.showorder ASC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	/**
	 * @method 活动线路列表
	 * @author xml
	 */
	function get_act_line($param,$page){
		$query_sql='';
		$query_sql.=' SELECT al.*, tab. NAME AS tabname,l.linename,l.id as lineid,sta.cityname,l.status as lstatus';
		$query_sql.=' FROM	act_tab_line AS al ';
		$query_sql.=' LEFT JOIN act_tab AS tab ON al.tab_id = tab.id ';
		$query_sql.=' LEFT JOIN act_activity_city AS acty ON acty.id = tab.aac_id ';
		$query_sql.=' LEFT JOIN u_line as l on l.id=al.line_id ';
		$query_sql.=' LEFT JOIN u_startplace as sta on sta.id=acty.startcityid where al.status=1 ';
		if($param!=null){
			if(null!=array_key_exists('actid', $param)){
				$query_sql.=' and acty.act_id = ? ';
				$param['actid'] = $param['actid'];
			}
			if(null!=array_key_exists('name', $param)){
				$query_sql.=' AND tab.name  like ? ';
				$param['name'] = '%'.$param['name'].'%';
			}
			if(null!=array_key_exists('act_line', $param)){
				$query_sql.=' AND l.linename  like ? ';
				$param['act_line'] = '%'.$param['act_line'].'%';
			}
		}
		$query_sql.=' ORDER BY al.id desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	
	/**
	 * @method 添加表信息
	 * @author xml
	 */
	function save_Actdata($table,$insert){
		$this->db->insert($table,$insert);
		$act_id=$this->db->insert_id();
		if($act_id>0){
			return  true;
		}else{
			return  false;
		}
	}
	/**
	 * @method 获取活动城市信息
	 * @author xml
	 */
	function get_ActCity($where){	
		$this->db->select('acy.* ,sta.cityname,sta.id as cityid ');
		$this->db->from('act_activity_city as acy');
		$this->db->join('u_startplace as sta','acy.startcityid=sta.id','left');
		$this->db->where($where);
		$query =$this->db->get();
		return $query->result_array();
	}
	/**
	 * @method 活动城市相关的活动分类
	 * @author xml
	 */
	function get_ActName($where){
		$this->db->select(' atb.*');
		$this->db->from('act_tab as atb');
		$this->db->where($where);
		$query =$this->db->get();
		return $query->result_array();
	}
	
	/**
	 * @method 编辑活动城市信息
	 * @author xml
	 */
	//function update_ActCity($id,$insert){ //'act_activity_city'
	function update_table($id,$insert,$table){
		$this->db->where ( 'id', $id );
		return $this->db->update ($table, $insert );
	}
	/**
	 * @method 获取某个表信息
	 * @author xml
	 */
	function get_rowData($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		return  $this->db->get($table)->row_array();
	}
	/**
	 * @method 修改活动线路
	 * @author xml
	 * @return bool
	 */
	function update_actline($insert,$actid){
		$this->db->where ( 'id', $actid );
		return $this->db->update ( 'act_tab_line', $insert );
	}
}