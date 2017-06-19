
<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年7月23日15:50:11
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Travel_model extends MY_Model {

	public function __construct() {}

	/**
		 *游记的列表
		 * */
		function get_travel_list($whereArr = array(), $page = 1, $num = 10){
			 if($page > 0){
                        			 $res_str ="
		                      	tn.id AS tn_id,
		                      	tn.order_id AS order_id,
		                      	tn.line_id AS line_id,
				tn.addtime AS addtime,
				tn.title AS title,
				l.linename AS linename,
				tn.shownum AS shownum,
				tn.comment_count AS comment_count,
				tn.is_show AS is_show
				";
                     		}else{
                        	   		$res_str = 'count(*) AS num';
                        		}
			 $this->db->select($res_str);
			 $whereArr['tn.usertype'] = 1;
			  $whereArr['tn.status >= '] = 0;
			 $this->db->where($whereArr);
			  $this->db->from('travel_note AS tn');
			$this->db->join('u_line AS l','tn.line_id=l.id','left');

			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->order_by('tn.addtime','DESC');
				$this->db->limit($num, $offset);
				$result=$this->db->get()->result_array();
				return $result;
			}else{
				$query = $this->db->get();
				$ret_arr = $query->result_array();
				return $ret_arr[0]['num'];
			}
		}

		/**
		 * 获取一条数据
		 * */
		function get_alldata($table,$where){
			$this->db->select('*');
			$this->db->where($where);
			return  $this->db->get($table)->row_array();
		}
		/**
		 * select all table
		 * */
		function get_data($table,$where,$order=''){
			$this->db->select('*');
			$this->db->where($where);
			if(!empty($order)){
				$this->db->order_by($order.' asc');
			}
			return  $this->db->get($table)->result_array();
		}
		function line_message($userid){
			$query_sql ="SELECT l.id AS lineid,l.linename,l.linetype FROM u_line_apply AS app LEFT JOIN u_line AS l ON l.id=app.line_id WHERE app.`status`=2 AND app.expert_id={$userid} AND l.`status`=2";
			$query = $this->db->query($query_sql)->result_array();
			return $query;
		}
		/**
		 * insert table
		 *
		 * */
		function insert_data($table,$data){
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		function updata_alldata($table,$where,$data){
			$this->db->where($where);
			return	$this->db->update($table, $data);
		}
		//线路属性
		public function select_attr_data($where){
			$this->db->select('*');
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->order_by('displayorder');
			return  $this->db->get('u_line_attr')->result_array();
		}
		//删除数据
		public function del_imgdata($table,$where){
			$this->db->where($where);
			return   $this->db->delete($table);
		}
		//选择线路属性
		public function sel_line_attr(){
			$query_sql='SELECT id,attrname from u_line_attr where pid=0 ORDER BY displayorder ASC';
			$c_attr=$this->db->query($query_sql)->result_array();
			if(!empty($c_attr)){
				foreach ($c_attr as $k=>$v){
					$attrsql=' SELECT id,attrname from u_line_attr where pid='.$v['id'].' ORDER BY displayorder ASC';
					$attrArr=$this->db->query($attrsql)->result_array();
					$c_attr[$k]['two']=$attrArr;
				}
			}
			return $c_attr;
		}
			//某一线路的产品标签
		function line_attr_row($tagesArr){
			if(!empty($tagesArr)){
				foreach ($tagesArr as $k=>$v){
					if(!empty($v)){
						$attrsql=' SELECT id,attrname from u_line_attr where id='.$v;
						$attrArr[]=$this->db->query($attrsql)->row_array();
					}
				}
			}else{
				$attrArr='';
			}
			if(!empty($attrArr)){
				foreach ($attrArr as $k=>$v){
					$data['tagesStr'][$k]['id']=$v['id'];
					$data['tagesStr'][$k]['attrname']=$v['attrname'];
				}
			}
			return $data['tagesStr'];
		}
}