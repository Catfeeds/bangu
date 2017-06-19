<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Travel_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'travel_note' );
	}
	
		/**
		 *游记的列表
		 * */
		function get_travel_list($id, $page = 1, $num = 10){		
			$query_sql ='';
			$query_sql .= 'SELECT tn.is_show,tn.id,tn.order_id,tn.line_id,tn.addtime,tn.title,l.linename ,tn.status,tn.shownum,l.overcity,';
			//$query_sql .= '(SELECT COUNT(*) FROM travel_note_browse AS tnb	WHERE	tnb.travel_note_id = tn.id) AS "hit",';
			$query_sql .= '(SELECT	COUNT(*) FROM travel_note_reply AS tnr WHERE tnr.note_id = tn.id) AS "comment_count" ';
			$query_sql .= 'FROM travel_note AS tn ';
			$query_sql .= 'LEFT JOIN u_line AS l ON tn.line_id = l.id ';
			$query_sql .= 'WHERE  tn.usertype = 0 AND tn.STATUS !=-1 AND tn.userid = '.$id;
			$query_sql .=' order by tn.id desc ';
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$query_sql .=' limit '.$offset.','.$num;
			}
			
			$query = $this->db->query($query_sql)->result_array();
			return $query;
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
		function order_message($userid){
			$query_sql ='';
			$query_sql .= 'select od.id as orderid,l.id as lineid,l.linename,od.usedate from u_member_order as od ';
			$query_sql .= 'LEFT JOIN u_line as l on od.productautoid=l.id';
			$query_sql .= ' where od.memberid='.$userid.' AND od.status>=5  ORDER BY od.usedate DESC ';
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
