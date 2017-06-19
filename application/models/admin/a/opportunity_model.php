<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Opportunity_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_opportunity';
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * 获取培训公告列表
	 * @param array $whereArr 查询条件
	 * @param number $page 当前页
	 * @param number $num  每页数
	 * @param array $like  模糊搜索条件
	 * @param intval $is_page 是否需要分页
	 */
	public function get_line_list($whereArr, $page = 1, $num = 10 ,$like = array() ,$is_page = 1) {
		$this->db->select ('*');
		$this->db->from ( $this->table_name .' as a');
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->or_like($key,$val);
			}
		}
		$this->db->order_by("a.id", "desc");
		if ($is_page == 1) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
	/**
	 * @method 获取以条数据
	 */
	public function get_one_data ($whereArr) {
		$this ->db ->select('o.*,(select count(oa.id) from u_opportunity_apply as oa where oa.opportunity_id = o.id and status = 0) as apply');
		$this ->db ->from($this ->table_name .' as o');
		$this->db->where ( $whereArr );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	/**
	 * @method 获取已报名的人
	 * @author jiakairong
	 * @param intval $id 培训公告的id
	 */
	public function get_opp_apply_data($id){
		$sql = "select * from u_opportunity_apply where opportunity_id = {$id} and status = 1";
		return $this ->db ->query($sql) ->result_array();
	}
	
}