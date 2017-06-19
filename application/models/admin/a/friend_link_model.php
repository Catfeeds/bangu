<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Friend_link_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_friend_link';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ($this->table_name );
	}
	
	/**
	 * @method 获取友情链接
	 * @author 贾开荣
	 * @since  2015-06-30
	 * @param array $whereArr 查询条件
	 * @param intval $number 每页条数
	 * @param intval $page_new 第几页
	 * @param intval $is_page 是否分页，主要用于统计条数
	 */
	public function get_friend_link_data($whereArr ,$page_new = 1 ,$number = 10 ,$like = array() ,$is_page = 1) {
		$this->db->select ( "*" );
		$this->db->from ( $this->table_name );
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->like($key,$val);
			}
		}
		$this ->db ->order_by('id' ,'desc');
	
		if ($is_page == 1) {
			$number = empty ( $number ) ? 10 : $number;
			$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
			$this->db->limit ( $number, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
}