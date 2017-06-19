<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line_custom_detail_model extends MY_Model {

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 获取定制的专家和线路数据
	 */
	public function get_expert_line_data($cid){


		$sql = "SELECT c.pic AS c_pic,c.question AS question,c.addtime AS addtime,c.budget AS budget,e.small_photo AS small_photo,e.nickname AS expert_name,e.people_count AS people_count,e.avg_score AS avg_score,e.total_score AS total_score,eg.title AS e_grade,(SELECT GROUP_CONCAT(d.kindname SEPARATOR ',')  FROM u_dest_base AS d WHERE  FIND_IN_SET(d.id,e.expert_dest)>0) AS good_dest
			FROM u_customize AS c LEFT JOIN u_customize_answer AS ca ON c.id=ca.customize_id
			LEFT JOIN u_expert AS e ON ca.expert_id=e.id
			LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade
			WHERE c.id=$cid AND ca.isuse=1";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		/*$this->db->select ( "	c.id,
					c.pic AS c_pic,
					c.question AS question,
					c.addtime AS addtime,
					c.budget AS budget,
					e.small_photo AS small_photo,
					e.realname AS expert_name,
					e.people_count AS people_count,
					e.avg_score AS avg_score,
					eg.title AS e_grade,
					(SELECT GROUP_CONCAT(d.kindname SEPARATOR ',')  FROM u_dest_base AS d WHERE  FIND_IN_SET(d.id,e.expert_dest)>0) AS good_dest
					" );
		$this->db->from ( 'u_customize AS c' );
		$this->db->join ( 'u_customize_answer AS ca', 'c.id=ca.customize_id', 'left' );
		$this->db->join ( 'u_expert AS e', 'ca.expert_id=e.id', 'left' );
		$this->db->join ( 'u_expert_grade AS eg', 'e.grade=eg.grade', 'left' );
		$whereArr['ca.isuse'] = 1;
		$this->db->where ( $whereArr );
		$query = $this->db->get ();*/
		return $result;
	}



	/**
	 * 获取定制详情数据
	 */
	public function get_custom_data($whereArr=array(),$page=1,$num=10) {
		$this->db->select ( '	c.id AS cid,
					ca.id AS ca_id,
					cj.id AS cj_id,
					cj.day AS day,
					cj.title AS title,
					cj.jieshao AS jieshao,
					cjp.pic AS trip_pic
					' );
		$this->db->from ( 'u_customize AS c' );
		$this->db->join ( 'u_customize_answer AS ca', 'c.id=ca.customize_id', 'left' );
		$this->db->join ( 'u_customize_jieshao AS cj', 'ca.id=cj.customize_answer_id', 'left' );
		$this->db->join ( 'u_customize_jieshao_pic AS cjp', 'cj.id=cjp.customize_jieshao_id', 'left' );
		$whereArr['ca.isuse'] = 1;
		$this->db->where ( $whereArr );
		$result=$this->db->get()->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}


	/**
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		if(!empty($value['trip_pic'])){
			$trip_pic = trim($value['trip_pic'],';');
			$value['trip_pic_arr']  =	explode(';',$trip_pic);
		}
	}
}
