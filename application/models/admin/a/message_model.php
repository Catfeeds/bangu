<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Message_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_message';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * 获取消息列表
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 * @param string $type
	 * @param array $like
	 */
	public function get_line_list($whereArr, $page = 1, $num = 10, $type = 'arr' ,$like = array()) {
		$datafield="id,title,addtime,modtime";
		$this->db->select ($datafield);
		$this->db->from ( $this->table_name );
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->or_like($key,$val);
			}
		}
		$this->db->order_by("id", "desc");
		$num = empty ( $num ) ? 10 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$this->db->limit ( $num, $offset );
		$query = $this->db->get ();
		//echo $this->db->last_query();
		if ($type == 'obj')
			return $query->result ();
		elseif ($type == 'arr')
		return $query->result_array ();
	}
	
	/**
	 * 获取满足条件的记录条数
	 * @param unknown $where
	 * @param array $like
	 */
	public function num_rows_total($where ,$like = array())
	{
		$datafield="id";
		$this->db->select ($datafield);
		$this->db->from ( $this->table_name );
		$this->db->where($where);
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->or_like($key,$val);
			}
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

}