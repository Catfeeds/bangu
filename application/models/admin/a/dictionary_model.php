<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Dictionary_model extends MY_Model {
	
	/**
	 * 获取数据字典
	 * @param unknown $code 第一层Code编码
	 * @return unknown
	 */
	public function get_dict_data($code){
		$query = $this->db->query('SELECT dict_id,description FROM  u_dictionary WHERE pid = (SELECT dict_id FROM  u_dictionary WHERE dict_code ="'.$code.'" ) ORDER BY showorder ASC');
		$rows = $query->result_array();
		return $rows;
	}
	
	/**
	 * 根据 ids 获取数据字典 可以单个 可以多个
	 * @param unknown $ids 
	 * @return unknown
	 */
	public function get_dict_detail($ids){
// 		$query = $this->db->query('SELECT dict_id,description FROM  u_dictionary WHERE pid IN (SELECT dict_id FROM  u_dictionary WHERE dict_code ="'.$type.'" ) ORDER BY showorder ASC');
// 		$rows = $query->result_array();
		return $rows;
	}
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_dictionary';
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @author 贾开荣
	 * @method 获取数据字典的列表信息
	 * @since 2015-05-27
	 * @param unknown $where 查询条件
	 * @param number $page 当前分页
	 * @param number $num 每页条数
	 * @param string $like 模糊查询
	 */
	public function get_list_data($where, $page = 1, $num = 10, $like = array()) {
		$this->db->select ( '*' );
		$this->db->from ( $this->table_name );
		$this->db->where ( $where );
		if (! empty ( $like ) && is_array ( $like )) {
			foreach ( $like as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$this->db->order_by ( "pid", "asc" );
		$num = empty ( $num ) ? 10 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$this->db->limit ( $num, $offset );
		$query = $this->db->get ();
		
		return $query->result_array ();
	}
	/**
	 * @method 获取总条数
	 * @author 贾开荣
	 * @since 2015-05-27
	 * @param unknown $whereArr
	 * @param unknown $like
	 */
	public function get_count($where, $like = array()) {
		$this->db->select ( '*' );
		$this->db->from ( $this->table_name );
		$this->db->where ( $where );
		if (! empty ( $like ) && is_array ( $like )) {
			foreach ( $like as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$query = $this->db->get ();
		$data = $query->result_array ();
		return count($data);
	}
	
}