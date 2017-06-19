<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_dest_model extends MY_Model {
	private $table_name = 'u_dest_base';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method   用于线路目的地修改
	 * @param array $whereArr 搜索条件
	 */
	public function getlineDestData($whereArr ,$orderBy='l.id desc')
	{
		$sql = 'select l.id as line_id,l.linecode,l.linename,l.overcity,l.overcity2,l.addtime,sup.realname,l.status,sup.mobile from u_line as l left join u_supplier as sup on l.supplier_id=sup.id ';
		$sql .= $this ->getWhereStr($whereArr).' order by '.$orderBy.$this->getLimitStr();
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取目的地配置总数
	 * @param array $whereArr 搜索条件
	 */
	public function getDestNum($whereArr)
	{
		$sql = 'select  count(l.id) as count from u_line as l left join u_supplier as sup on l.supplier_id=sup.id';
		$sql .= $this ->getWhereStr($whereArr);
		$countArr = $this ->db ->query($sql) ->row_array();
		return $countArr['count'];
	}
	//查询表
	public function select_rowData($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		return  $this->db->get($table)->row_array();
	}

    //获取线路出发地
    function  select_startplace($likeArr){
    	$this->db->select('ls.id,ls.line_id,ls.startplace_id,st.cityname');
    	$this->db->from('u_line_startplace AS ls ');
    	$this->db->join('u_startplace AS st','st.id = ls.startplace_id','left');
    	$this ->db ->where($likeArr);
    	$query = $this->db->get ();
    	return $query->result_array ();
    }
    //修改线路目的地
    function update_lineDest($line_id,$overcity){
    	$this->db->trans_start();
    	$pdest='';
    	$pdestArrData='';
    
    	foreach ($overcity as $k=>$v){
    		if(!empty($v)){
    			//目的地的父级
    			$destA= $this ->select_rowData('u_dest_base',array('id'=>$v));
    			if(!empty($destA['list'])){
    				if(empty($pdest)){
    					$pdest=$destA['list'].$v;
    				}else{
    					$pdest=$pdest.','.$destA['list'].$v;
    				}
    			}
    			if(!empty($pdest)){
    				$pdestArr=explode(",",$pdest);
    				$pdestArr=array_unique($pdestArr);
    				$pdestArrData=implode(',', $pdestArr);
    			}
    		}	
    	}
    	
    	//线路目的地表
    	if(!empty($pdestArr)){
    		$this->db->where(array('line_id'=>$line_id))->delete('u_line_dest');//删除之前的数据
    		foreach ($pdestArr as $k=>$v){
    			$destdata=array(
    					'line_id'=>$line_id,
    					'dest_id'=>$v,
    			);
    			$this->db->insert('u_line_dest', $destdata);
    		}
    	}
    	
    	//线路主表
    	$overcityArr=implode(',', $overcity);
    	$this->db->where(array('id'=>$line_id))->update('u_line', array('overcity'=>$pdestArrData,'overcity2'=>$overcityArr));
   	
    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		return false;
    	}else{
    		return true;
    	}
    }
}
