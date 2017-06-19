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

class Common_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'b_employee';
	
	public function __construct() 
	{
		parent::__construct($this->table_name);
	}
	/**
	 * 获取指定层级的area数据列表
	 * @param   $pid 父级id
	 * */
	public function areaList($pid)
	{
		$pid=$this->sql_check($pid);
		$sql="
				select * from u_area where pid='{$pid}' and isopen=1
			
		 	";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/**
	 * 获取指定area详情
	 * @param   $id 父级id
	 * */
	public function area_detail($id)
	{
		$pid=$this->sql_check($pid);
		$sql="
		select * from u_area where id='{$id}'
			
		";
		$result=$this->db->query($sql)->row_array();
		return $result;
	}
	/**
	 * 获取所有的目的地：api
	 *
	 * */
	public function tree_destData($where=array())
	{
	    //select id,pid as pId,kindname as name,level,case when level=1 then 1 when level=2 then 1 else 0 end as open from u_dest_base where isopen=1
		$sql="
				select id,pid as pId,kindname as name,level, 0 as open from u_dest_base where isopen=1
		    ";
		if(!empty($where['level']))
			$sql.=" and level<='{$where['level']}'";
		if(!empty($where['content']))
			$sql.=" and kindname like '%{$where['content']}%'";
		$result=$this->db->query($sql)->result_array();
		  //加上“周边游”
		  array_push($result, array('id'=>'3','pId'=>'0','name'=>'周边游','level'=>'1','open'=>'0'));
		 if(!empty($where['city']))
		 {
		 	//这里的id会与国内的相同的目的地id重复，所以这里在的id前拼接一个数字0
		 	$zb_sql="select concat(0,d.id) as id,3 as pId,d.kindname as name,d.level,0 as open from cfg_round_trip as t inner join u_dest_base as d on d.id=t.neighbor_id and t.startplaceid={$where['city']}";
		 	$zb=$this->db->query($zb_sql)->result_array();
		 	if(!empty($zb))
		 	{
		 		foreach ($zb as $key=>$value)
		 		{
		 			array_push($result,$value);
		 		}
		 	}
		 }
		 
	    //3级
		$result_3=array();
		$pid_in="";
		if(!empty($result))
		{
			foreach ($result as $k=>$v)
			{
				$pid_in=$v['pId'].",".$pid_in;
			}
			$pid_in=substr($pid_in, 0,-1);
			$pid_in="(".$pid_in.")";
			$sql_3="select distinct id,pid as pId,kindname as name,level, 1 as open from u_dest_base where level=3 and id in".$pid_in;
			$result_3=$this->db->query($sql_3)->result_array();
		}
		 
		//上级
		$result2=array();
		$pid_in="";
		if(!empty($result_3))
		{
			foreach ($result_3 as $k=>$v)
			{
				$pid_in=$v['pId'].",".$pid_in;
			}
			$pid_in=substr($pid_in, 0,-1);
			$pid_in="(".$pid_in.")";
			$sql2="select distinct id,pid as pId,kindname as name,level, 1 as open from u_dest_base where level=2 and id in".$pid_in;
			$result2=$this->db->query($sql2)->result_array();
		}
		
		//第一级
		$result3=array();
		$ppid_in="";
		if(!empty($result2))
		{
			foreach ($result2 as $k2=>$v2)
			{
				$ppid_in=$v2['pId'].",".$ppid_in;
			}
			$ppid_in=substr($ppid_in, 0,-1);
			$ppid_in="(".$ppid_in.")";
			$sql3="select distinct id,pid as pId,kindname as name,level, 1 as open from u_dest_base where level=1 and id in".$ppid_in;
			$result3=$this->db->query($sql3)->result_array();
		}
		
		if(empty($where['content']))   return array_merge($result);
		else return array_merge($result,$result2,$result3,$result_3);
	}
	/**
	 * 获取所有的出发地：api
	 *
	 * */
	public function tree_startplaceData($where=array())
	{
	
		$sql="
				select id,pid as pId,cityname as name,level,case when level=1 then 1 when level=2 then 1 else 0 end as open from u_startplace where isopen=1 order by id
				
		    ";
		if(!empty($where['level']))
			$sql.=" and level<='{$where['level']}'";
	
		$result=$this->db->query($sql)->result_array();
	
		return $result;
	}
	/**
	 * 获取目的地表一二级目的地
	 * @param   $pid 父级id
	 * */
	public function destList($pid="1")
	{
	
		$sql="
		select * from u_dest_base where level='{$pid}' and isopen=1
			
		";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/**
	 * 获取目的地表一二级目的地
	 * @param   $pid 父级id
	 * */
	public function dest_detail($where=array())
	{
	
		$sql="
		      select * from u_dest_base where isopen=1
		";
		$result=array();
		if(!empty($where['id']))
		{
			$sql.=" and id='{$where['id']}'";
			$result=$this->db->query($sql)->row_array();
		}
		if(!empty($where['pid']))
		{
			$sql.=" and pid='{$where['pid']}'";
			$result=$this->db->query($sql)->result_array();
		}
		
		return $result;
	}
	/**
	 * 获取指定城市的上门服务
	 * @param   $pid 父级id
	 * */
	public function get_visit_service($pid)
	{
		$sql="
		select * from u_area where pid='{$pid}' and isopen=1
			
		";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/**
	 * 证件类型列表 （国内外）
	 * @param   $pid 父级id
	 * */
	public function idcardtype_list($pid)
	{
		$sql="
		select * from u_dictionary where pid='{$pid}' and isdelete=0
			
		";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/**
	 * 证件类型详情
	 * @param   $id 父级id
	 * */
	public function idcardtype_detail($description)
	{
		$sql="
		select * from u_dictionary where description='{$description}'
			
		";
		$result=$this->db->query($sql)->row_array();
		return $result;
	}
	

	
	
}