<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:42:59
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Gift_manage_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_gift_list($param,$where='',$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql  = 'select g.id,g.supplier_id,g.gift_name,g.logo,g.description,g.account,g.worth,g.`status`,g.starttime,g.modtime,g.endtime ';
		$query_sql.=' from luck_gift as g where  g.supplier_id='.$login_id;
//( g.status=0 or g.status=1) and
        if(!empty($where)){
        	$query_sql.=$where;
        } 
	 	if(null!=array_key_exists('status', $param)){
			$query_sql.=' AND g.status  = ? ';
				$param['status'] = $param['status'];
		}  
		if(null!=array_key_exists('title', $param)){
			$query_sql.=' AND g.gift_name  like ? ';
			$param['title'] = '%'.$param['title'].'%';
		}
		if(null!=array_key_exists('endtime', $param)){
			$query_sql.=' AND UNIX_TIMESTAMP(g.endtime)  > ? ';
			$param['endtime'] = $param['endtime'];
		}
/* 		if(null!=array_key_exists('lineGiftListID', $param)){
			$query_sql.=' AND g.id not in( ? )';
			$param['lineGiftListID'] = $param['lineGiftListID'];
		} */
		
	 	if(isset($param['linelistID']) && !empty($param['linelistID'])){ //线路刷选礼品
		 	if(null!=array_key_exists('linelistID', $param)){
				$query_sql.=' AND g.id  not in (select l.gift_id from luck_gift_line as l where l.status !=-1 and l.line_id = ? )  ';
				$param['linelistID'] = $param['linelistID'];
			}
	 		
		}  

		$query_sql.=' order by g.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//已发放
	public  function up_gift_data($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		$query_sql  = 'SELECT l.overcity,lg.id,lg.gift_num,lg.gift_id,g.gift_name,g.logo,g.description,g.account,g.worth,g.starttime,g.status,g.endtime,l.linename,l.id as lineid ';
		$query_sql.=' FROM	luck_gift_line AS lg LEFT JOIN luck_gift AS g ON lg.gift_id = g.id';
		$query_sql.=' LEFT JOIN u_line AS l ON lg.line_id = l.id where g.supplier_id='.$login_id.' and (g.status>0 or g.status=0)and lg.status=1 ';
    	if(null!=array_key_exists('title', $param)){
			$query_sql.=' AND g.gift_name  like ? ';
			$param['title'] = '%'.$param['title'].'%';
		}
		if(null!=array_key_exists('endtime', $param)){
			$query_sql.=' AND UNIX_TIMESTAMP(g.endtime)  > ? ';
			$param['endtime'] = $param['endtime'];
		}
	
		$query_sql.=' order by lg.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//插入表
	public function insert_data($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	//修改
	public function update_rowdata($table,$object,$where){
		$this->db->where($where);
		return $this->db->update($table, $object);
	}
	//线路礼品信息
	public function get_line_gift($lineid,$gid){
		$query_sql = "SELECT lg.gift_num,g.gift_name,g.logo,g.description,g.account,g.worth,g.starttime,g.STATUS,mg.member_id,";
		$query_sql .= "g.endtime,mg.status as mgstatus,mg.addtime as mgaddtime";
		$query_sql .= " FROM luck_gift_line AS lg LEFT JOIN luck_gift AS g ON lg.gift_id = g.id LEFT";
		$query_sql .= " JOIN u_line AS l ON lg.line_id = l.id LEFT JOIN luck_gift_member as mg on mg.gift_id=g.id";
		$query_sql .= "  where l.id=".$lineid." and g.id=".$gid;
		$query=$this->db->query($query_sql);
		$result = $query->row_array();
		return $result;
	}
	//会员中奖信息
	public function get_gift_member($lineid,$gid){
		$query_sql = "select id,gift_num,addtime,channel,gift_id,member_id,m.nickname,m.mobile,gm.status  from luck_gift_member as gm ";
		$query_sql .= " LEFT JOIN u_member as m on gm.member_id=m.mid  where gm.line_id=".$lineid.' and gift_id='.$gid;
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		return $result;
	}
}
