<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月19日17:41:18
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Line_apply_model extends UB2_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	private $table_name = 'u_line_apply';

	public function __construct() {
		parent::__construct($this->table_name);
	}

	/**
	 * 获取管家申请的线路|或者未申请的
	 * @param array $whereArr
	 * @param intval $expert_id 管家ID
	 * @param string $specialSql
	 */
	public function getLineApplyData($whereArr ,$expert_id ,$specialSql='')
	{
		$sql = 'select l.id as lineid,l.linecode,l.linename,l.all_score,l.agent_rate,l.satisfyscore,l.comment_count,l.peoplecount,l.sell_direction,s.company_name,s.brand,group_concat(sp.cityname) AS cityname,la.id as apply_id,lf.sati_vr from u_line as l left join u_supplier as s on s.id=l.supplier_id left join u_line_startplace as ls on ls.line_id=l.id left join u_startplace as sp on sp.id=ls.startplace_id left join u_line_affiliated as lf on lf.line_id=l.id left join u_line_apply as la on la.line_id=l.id and la.expert_id='.$expert_id;
		$sql .= $this ->getWhereStr($whereArr ,$specialSql).'group by l.id order by l.id desc'.$this ->getLimitStr();
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * 获取管家申请的线路|或者未申请的,总数
	 * @param array $whereArr
	 * @param intval $expert_id 管家ID
	 * @param string $specialSql
	 */
	public function getLineApplyCount($whereArr ,$expert_id ,$specialSql='')
	{
		$sql = 'select count(distinct l.id) AS count from u_line as l left join u_supplier as s on s.id=l.supplier_id left join u_line_startplace as ls on ls.line_id=l.id left join u_startplace as sp on sp.id=ls.startplace_id left join u_line_apply as la on la.line_id=l.id and la.expert_id='.$expert_id;
		$sql .= $this ->getWhereStr($whereArr ,$specialSql);
		$data = $this ->db ->query($sql) ->row_array();
		return $data['count'];
	}
	
	/**
	 * 获得专家未申请线路详情
	 *
	 * @param array $whereArr	查询条件
	 * @param number $page		分页数
	 * @param number $num		单面显示数
	 * @return array
	 */
	public function get_line_no_apply_detail($whereArr, $page = 1, $num = 10) {
		$location_city = $this->session->userdata('location_city');
		$whereStr = "";
		if (!empty($whereArr) && is_array($whereArr)) {
			 // l.overcity 和 l.startcity组合的顺序不能轻易改变,要配合controller一起改变
			foreach($whereArr as $key =>$val) {
				if ($key == "l.overcity") {

					$findStr = '(';
					foreach($val as $v) {
						$findStr .= " find_in_set($v ,l.overcity) or";
					}
					$findStr = rtrim($findStr ,"or");
					$whereStr .= $findStr.") ";
				}

				if ($key == "l.startcity") {
					if(array_key_exists("l.overcity", $whereArr)){
						$whereStr .= "and l.startcity in ({$val}) ";
					}else{
						$whereStr .= "l.startcity in ({$val}) ";
					}

				}

			}
			unset($whereArr["l.overcity"]);
			unset($whereArr["l.startcity"]);
		}


			   if($page > 0){
                        			$res_str ="l.id AS line_id,
   			 		        l.linecode AS line_sn,
   			 		        l.linename AS line_title,
                        		  l.agent_rate_int AS agent_rate_int,
   			 		        l.all_score AS all_score,
   			 		        group_concat(st.cityname) AS start_city,
   			 		        l.overcity AS overcity,
					        l.agent_rate AS agent_rate,
					        l.satisfyscore AS satisfyscore,
					        l.comment_count AS comment_count,
					        l.peoplecount AS peoplecount,
					        l.sell_direction AS sell_direction,
					        s.company_name AS company_name,
					        s.mobile AS mobile";
		                        }else{
		                        	  // $res_str = 'count(*) AS num';
		                        		$res_str=" l.id AS line_id ";
		                        }
   			 $this->db->select( $res_str);
   			 if(!empty($whereStr)){
				$this->db->where($whereStr);
			}
   			$this->db->where("( l.id NOT IN( SELECT line_id FROM u_line_apply as la WHERE  la.expert_id =$this->expert_id and  la.status=2) ) AND (ls.startplace_id IN (SELECT sc.startplace_child_id FROM u_startplace AS st left JOIN u_startplace_child sc ON sc.startplace_id=st.id WHERE areaid=$location_city) OR ls.startplace_id=$location_city OR ls.startplace_id=391) ");
   			//$this->db->where("  ");
   			$whereArr['l.status'] = 2;
   			$whereArr['l.producttype'] = 0;
			$whereArr['l.line_kind'] = 1;


   			$this->db->where($whereArr);

			$this->db->from('u_line as l');
			$this->db->join('u_supplier  as s', 'l.supplier_id =s.id', 'left');
			$this->db->join('u_line_startplace  as ls', 'ls.line_id=l.id', 'left');
			$this->db->join('u_startplace  as st', 'ls.startplace_id=st.id', 'left');

			$this->db->order_by('l.addtime','desc');
			$this->db->group_by('ls.line_id');
   			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
				$result=$this->db->get()->result_array();
				array_walk($result, array($this, '_fetch_list'));
				return $result;
			}else{
				$query = $this->db->get();
				$ret_arr = $query->result_array();

				if(!empty($ret_arr)){
					$data=$ret_arr;
				}else{
					$data='';
				}
				return $data;
				
			}

	}

	/**
	 * 获得专家已申请线路详情
	 *
	 * @param array $whereArr	查询条件
	 * @param number $page		分页数
	 * @param number $num		单面显示数
	 * @return array
	 */
	public function get_line_apply_detail($whereArr, $page = 1, $num = 10) {
		$whereStr = "";
		if (!empty($whereArr) && is_array($whereArr)) {
			foreach($whereArr as $key =>$val) {
				if ($key == "l.overcity") {
					$findStr = '(';
					foreach($val as $v) {
						$findStr .= " find_in_set($v ,l.overcity) or";
					}
					$findStr = rtrim($findStr ,"or");
					$whereStr .= $findStr.") ";
				}

				if ($key == "l.startcity") {
					if(array_key_exists("l.overcity", $whereArr)){
						$whereStr .= "and l.startcity in ({$val}) ";
					}else{
						$whereStr .= "l.startcity in ({$val}) ";
					}

				}

			}
			unset($whereArr["l.overcity"]);
			unset($whereArr["l.startcity"]);
		}
		if($page > 0){
                        				 $res_str ='l.id AS line_id,l.linecode AS line_sn,l.linename AS line_title,
                      	s.company_name AS supplier_name,la.grade,la.expert_id,st.cityname AS cityname,l.overcity AS overcity,
		l.agent_rate AS agent_rate,l.satisfyscore AS satisfyscore,l.comment_count AS comment_count,
		l.peoplecount AS peoplecount,l.lineprice AS lineprice,l.agent_rate_int AS agent_rate_int,s.mobile AS mobile,l.status';
		                        }else{
		                        	   $res_str = 'count(*) AS num';
		                        }
                      $this->db->select($res_str);
		$this->db->from('u_line_apply AS la');
		$this->db->join('u_line AS l', 'la.line_id = l.id', 'left');
		$this->db->join('u_supplier AS s', 'l.supplier_id = s.id', 'left');
		$this->db->join('u_startplace  as st', 'l.startcity=st.id', 'left');
		$this->db->order_by('la.addtime','desc');
		//$this->db->where_not_in('l.id', 'SELECT line_id FROM u_line_apply la WHERE  la.expert_id ='.$this->expert_id);
		if(!empty($whereStr)){
				$this->db->where($whereStr);
			}
		$whereArr['la.status'] = 2;
		$whereArr['l.producttype'] = 0;
		$whereArr['la.expert_id'] =$this->expert_id;
		$this->db->where($whereArr);
     		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
			$result=$this->db->get()->result_array();
			array_walk($result, array($this, '_fetch_list'));
			return $result;
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}

	}

	/**
	 * 最新线路,就是没有任何管家申请过的线路
	 */
	public function get_new_line($whereArr, $page = 1, $num = 10){
		$whereStr = "";
		if (!empty($whereArr) && is_array($whereArr)) {
			foreach($whereArr as $key =>$val) {
				if ($key == 'l.overcity') {
					foreach ($val as $k => $v) {
						$whereStr .= "find_in_set($v,l.overcity)>0 OR ";
					}
					$whereStr = rtrim($whereStr,' OR ');
					$whereStr .= ' AND ';
				}
				if($key == 'l.startcity'){
					foreach ($val as $k => $v) {
						$whereStr .= "find_in_set($v,l.startcity)>0 OR ";
					}
					$whereStr = rtrim($whereStr,' OR ');
				}
			}
			unset($whereArr['l.overcity']);
			unset($whereArr['l.startcity']);
		}
		if($page > 0){
                        				 $res_str ="l.id AS line_id,
   			 		        l.linecode AS line_sn,
   			 		        l.linename AS line_title,
   			 		        st.cityname AS start_city,
					        l.agent_rate AS agent_rate,
					        l.sell_direction AS sell_direction,
					        l.overcity AS overcity,
					        s.company_name AS company_name,
					        s.mobile AS mobile";
		                        }else{
		                        	   $res_str = 'count(*) AS num';
		                        }
                      		$this->db->select($res_str);
   			 $this->db->select();
   			$this->db->where("l.id NOT IN( SELECT line_id FROM u_line_apply AS la where la.status=2)");
   			if(!empty($whereStr)){
				$this->db->where($whereStr);
			}
   			$whereArr['l.status'] = 2;
   			$whereArr['l.producttype'] = 0;
   			$this->db->where($whereArr);
			$this->db->from('u_line as l');
			$this->db->join('u_supplier  as s', 'l.supplier_id =s.id', 'left');
			$this->db->join('u_startplace  as st', 'l.startcity=st.id', 'left');
			$this->db->order_by('l.addtime','desc');
   			if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
			$result=$this->db->get()->result_array();
			array_walk($result, array($this, '_fetch_list'));
			return $result;
			}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
			}

	}

	/**
	 * 根据线路ID插入 expert_dest 管家服务目的地表
	 */
	function insert_expert_dest($line_id,$expert_id){
		$overcity = array();
		$get_line_dest_sql = 'SELECT overcity2 FROM u_line WHERE id='.$line_id;
		$line_query = $this->db->query($get_line_dest_sql);
		$line_res = $line_query->result_array();
		if(!empty($line_res)){
		     $overcity = explode(',',rtrim($line_res[0]['overcity2'],','));
		     foreach ($overcity as $key => $value) {
		     	$is_exist_sql = 'select count(*) isexist from u_expert_dest where dest_id='.$value.' and expert_id='.$expert_id;
		     	$is_exist_res = $this->db->query($is_exist_sql)->result_array();
		     	if($is_exist_res[0]['isexist']<=0){
		     		$get_dest_pid_sql = 'SELECT pid FROM u_dest_base WHERE id='.$value;
		     		$result = $this->db->query($get_dest_pid_sql)->result_array();
					if(empty($result[0]['pid'])){	$pid='2'	;}else{	$pid=$result[0]['pid'];	}
		     		$insert_expert_dest_sql = 'INSERT INTO u_expert_dest(expert_id,dest_id,dest_pid,status) VALUES('.$expert_id.','.$value.','.$pid.',1)';
		     		$this->db->query($insert_expert_dest_sql);
		     	}
		     }
		}
	}

	/**
	 * 获取全部的目的地
	 */

          public function get_destinations(){
                   $this->db->select('id,kindname');
                   $this->db->from('u_dest_base');
                   $result=$this->db->get()->result_array();
                   return $result;
          }


          /**
           * 获取全部供应商
           */

          public function get_suppliers(){
          		$this->db->select('id,company_name as realname');
          		$this->db->where(array('status'=>2));
                   $this->db->from('u_supplier');
                   $result=$this->db->get()->result_array();
                   return $result;
          }

           /**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
			if(isset($value['agent_rate']) && !empty($value['agent_rate'])){
				$value['agent_rate']=$value['agent_rate']*100;
				$value['agent_rate']=$value['agent_rate'].'%';
			}

			if(isset($value['satisfyscore']) && !empty($value['satisfyscore'])){
				$value['satisfyscore']=$value['satisfyscore']*100;
				$value['satisfyscore']=$value['satisfyscore'].'%';
			}

			if(empty($value['comment_count'])){
				$value['comment_count']=0;
			}
			if(empty($value['peoplecount'])){
				$value['peoplecount']=0;
			}
	}
    /**
     *@author xml
     *@method 供应商制定管家的定制团线路
     */
	function get_group_line_detail($whereArr, $page = 1, $num = 10){
		$whereStr = "";
		if (!empty($whereArr) && is_array($whereArr)) {
			foreach($whereArr as $key =>$val) {
				if ($key == "l.overcity") {
					$findStr = '(';
					foreach($val as $v) {
						$findStr .= " find_in_set($v ,l.overcity) or";
					}
					$findStr = rtrim($findStr ,"or");
					$whereStr .= $findStr.") ";
				}

				if ($key == "l.startcity") {
					if(array_key_exists("l.overcity", $whereArr)){
						$whereStr .= "and l.startcity in ({$val}) ";
					}else{
						$whereStr .= "l.startcity in ({$val}) ";
					}

				}

			}
			unset($whereArr["l.overcity"]);
			unset($whereArr["l.startcity"]);
		}
		if($page > 0){
			$res_str ='l.id AS line_id,l.linecode AS line_sn,l.linename AS line_title,l.agent_rate_int,
                      	s.company_name AS supplier_name,la.grade,la.expert_id,st.cityname AS cityname,l.overcity AS overcity,
		l.agent_rate AS agent_rate,l.satisfyscore AS satisfyscore,l.comment_count AS comment_count,
		l.peoplecount AS peoplecount,l.lineprice AS lineprice,s.mobile AS mobile,l.status';
		}else{
			$res_str = 'count(*) AS num';
		}
		$this->db->select($res_str);
		$this->db->from('u_line_apply AS la');
		$this->db->join('u_line AS l', 'la.line_id = l.id', 'left');
		$this->db->join('u_supplier AS s', 'l.supplier_id = s.id', 'left');
		$this->db->join('u_startplace  as st', 'l.startcity=st.id', 'left');
		$this->db->order_by('la.addtime','desc');
		//$this->db->where_not_in('l.id', 'SELECT line_id FROM u_line_apply la WHERE  la.expert_id ='.$this->expert_id);
		if(!empty($whereStr)){
			$this->db->where($whereStr);
		}
		$whereArr['la.status'] = 2;
		$whereArr['l.producttype'] = 1;
		$whereArr['la.expert_id'] =$this->expert_id;
		$this->db->where($whereArr);
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
			$result=$this->db->get()->result_array();
			array_walk($result, array($this, '_fetch_list'));
			return $result;
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}
	}

	//保存定制线路推送表
	function save_recommend_line($insertArr){

		$this->db->trans_start();

		 $this->db->insert('u_customize_recommend_line',$insertArr);
		 $lineid= $this->db->insert_id();

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return $lineid;
		}
	}
	//查询表
	 function select_data($table,$where){
	 	$this->db->select('*');
	 	$this->db->from($table);
	 	$this->db->where($where);
	 	$result=$this->db->get()->row_array();
	 	return $result;
	 }
}