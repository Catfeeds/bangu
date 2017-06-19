<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Member_experience_model extends MY_Model {

	private $table_name = 'u_member_experience';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取体验师
	 * @author 贾开荣
	 * @since  2015-06-30
	 * @param array $whereArr 查询条件
	 * @param intval $number 每页条数
	 * @param intval $page_new 第几页
	 * @param intval $is_page 是否分页，主要用于统计条数
	 */
	public function get_member_experience_data($whereArr ,$page_new = 1 ,$number = 10 ,$like = array() ,$is_page = 1) {
		$this->db->select ( "m.mid,m.nickname,m.litpic,m.mobile" );
		$this->db->from ( $this->table_name . ' as me' );
		$this->db->join ( 'u_member AS m', 'm.mid = me.member_id', 'left' );
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->like($key,$val);
			}
		}
		$this ->db ->order_by('me.id' ,'desc');
	
		if ($is_page == 1) {
			$number = empty ( $number ) ? 10 : $number;
			$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
			$this->db->limit ( $number, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	/**
	 * @method 获取体验师数据(用于首页体验师和最美体验师配置)
	 * @author 贾开荣
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 * @param array  $keywordArr 关键字搜索
	 */
	public function getExperienceCfgData (array $whereArr ,$page = 1, $num = 10 ,$keywordArr = array()) {
		$this ->db ->select ( 'a.name as cityname,m.mid,m.truename,m.nickname,m.mobile,m.litpic,(select count(tn.id) from travel_note as tn left join u_line as l on l.id=tn.line_id where tn.usertype=0 and tn.userid = m.mid and tn.status = 1 and tn.is_show = 1 and l.status=2 and l.producttype = 0) as number' );
		$this ->db ->from ( $this->table_name.' as me');
		$this ->db ->join ('u_member as m' ,'m.mid = me.member_id' ,'left');
		$this ->db ->join ('u_area as a' ,'a.id = m.city' ,'left');
		$this ->db ->where ( $whereArr );
	
		if (! empty ( $keywordArr ) && is_array ( $keywordArr )) {
			foreach ( $keywordArr as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$this->db->order_by ( 'me.id', "desc" );
		if ($page > 0) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		return $this->db->get ()->result_array ();
	}
	
}