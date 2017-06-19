<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Article_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_article_attr';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	//取多条数据
	function all_article($table,$whereArr=array(), $page = 1, $num = 10)
	{
		$this->db->where($whereArr);
	 	if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		} 
		$this->db->from ($table);
		$result=$this->db->get()->result_array();
		return $result;
	}
	//文章列表
	function art_list($whereArr=array(), $page = 1, $num = 10){
		$this->db->select ('art.id,art.title,art.content,art.addtime,art.modtime,art.showorder,art.admin_id,cate.attr_name');
		$this->db->from ( 'u_article AS art');
		$this->db->join ( 'u_article_attr AS cate', 'art.attrid=cate.id', 'left' );
		$this->db->where($whereArr);
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$this->db->order_by('art.addtime desc');
		$result=$this->db->get()->result_array();
		return $result;
	}

	//修改表
	function updata_table($table,$data,$where){
		$this->db->where($where);
		return $this->db->update($table,$data);

	}

}