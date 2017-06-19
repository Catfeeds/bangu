<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Consult_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'u_consult' );
	}
	//资讯配置表
	function get_cgf_consult($whereArr){
		$this ->db ->select('cf.*,c.title,c.id as consultid');
		$this ->db ->from('cfg_consult as cf');
		$this ->db ->join('u_consult as c' ,'c.id = cf.consult_id' ,'left');
		$this ->db ->where($whereArr);
		$this->db->order_by('cf.showorder asc,c.addtime desc');
		$this->db->limit(3);
		$query = $this->db->get ();
		return $query->result_array ();
	}
	/*资讯数据
	 * $whereArr Array 查询条件
	 * $limit       限制查询的条数
	 */
	function get_consult_data($whereArr,$limit){
		$this ->db ->select('c.title,c.content,c.id as consultid,c.addtime,c.pic');
		$this ->db ->from('u_consult as c');

		$this ->db ->where($whereArr);
		$this->db->order_by('c.addtime desc');
		$this->db->limit($limit);
		$query = $this->db->get ();
		return $query->result_array ();
	}
	//热门资讯 前十条的访问总数
	function get_hot_consult(){
		$this ->db ->select('sum(shownum) as shownum ');
		$this ->db ->from('u_consult');
		$this ->db ->where( 'type = 1 and ishot = 1 ');
		$this->db->order_by('addtime desc');
		$this->db->limit(10);
		$query = $this->db->get ();
		return $query->row_array ();
	}
	//某条资讯的点赞总数
	function  point_sum($id){
		$this ->db ->select('count(id) as sum ');
		$this ->db ->from('u_consult_praise');
		$this ->db ->where(array('consult_id'=>$id));
		$query = $this->db->get ();
		return $query->row_array ();
	}
	//某条资讯的上一条
	function get_prev_data($id,$where){
		$query_sql="select * from u_consult where id>{$id} {$where} order by addtime asc  LIMIT 1";
		$query = $this->db->query($query_sql);
		$rows = $query->row_array();
		return $rows;
	}
	//某条资讯的下一条
	function get_next_data($id,$where){
		$query_sql="select * from u_consult where id<{$id} {$where} order by addtime DESC  LIMIT 1";
		$query = $this->db->query($query_sql);
		$rows = $query->row_array();
		return $rows;
	}
	//获取表的数据
	function get_rowdata($table,$where){
		$this ->db ->select('*');
		$this ->db ->from($table);
		$this ->db ->where($where);
		$query = $this->db->get ();
		return $query->row_array ();
	}
	//插入表的数据
	function insert_tableData($table,$data){
		$this->db->insert($table, $data); 
		$id=$this->db->insert_id();
		return  $id;
	} 
	//修改表的数据
	function update_tableDate($table,$data,$where){
		$this->db->where($where);
		return $this->db->update($table, $data);
	}
	//删除表数据
	function delete_table($table,$where){
		$this->db->where($where);
		return $this->db->delete($table);
	}
	//根据目的地获取相应的线路
	function get_line_data($dest){
		$line='';
		$str='';
		$destArr=explode(',', $dest);
		foreach ($destArr as $k=>$v){
			$cityid=$this ->db ->select('id')->from('u_dest_base')->where(array('level'=>3,'id'=>$v))->get()->result_array ();
			if(!empty($v)){
				if(!empty($cityid)){
					if(!empty($str)){
						$str='FIND_IN_SET('.$v.',overcity)>0  or '.$str;
					}else{
						$str='FIND_IN_SET('.$v.',overcity)>0';
					}	
				}
			}
		}
 		$this ->db ->select('id,linename,mainpic,lineprice');
		$this ->db ->from('u_line');
		if(!empty($str)){
			$this ->db ->where('('.$str.')');
		}
	    $this ->db ->where('status = 2');
		$this->db->limit(5);
		$this->db->order_by('addtime desc');
		$query=$this->db->get ();
		$line=$query->result_array (); 
		return $line;
	}
	//根据目的地获取相应的资讯
	function get_match_consult($dest,$id){
		$line='';
		$str='';
		$destArr=explode(',', $dest);
		foreach ($destArr as $k=>$v){
			$cityid=$this ->db ->select('id')->from('u_dest_base')->where(array('level'=>3,'id'=>$v))->get()->result_array ();
			if(!empty($v)){
				if(!empty($cityid)){
					if(!empty($str)){
						$str='FIND_IN_SET('.$v.',dest_id)>0  or '.$str;
					}else{
						$str='FIND_IN_SET('.$v.',dest_id)>0';
					}
				}
			}
		}
		$this ->db ->select('*');
		$this ->db ->from('u_consult');
		if(!empty($str)){
			$this ->db ->where('('.$str.')');
		}
		$this ->db ->where('id != '.$id);
		$this->db->limit(16);
		$this->db->order_by('addtime desc');
		$query=$this->db->get ();
		$line=$query->result_array ();
		return $line;
	}
	//资讯分页
	function get_consult_page($whereArr ,$page = 1,$num =10){
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
		$sql = 'SELECT id,user_name,dest_id,title,content,addtime,pic from u_consult'. $whereStr;
		$data['count'] = $this ->getCount($sql ,array());
		$sql = $sql.' order by addtime desc '.$limitStr;
		$data['consultData'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}

}
