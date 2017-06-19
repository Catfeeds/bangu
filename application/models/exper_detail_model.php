<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Exper_detail_model extends MY_Model {

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 获取体验师去过的地方数据
	 */
	public function get_experience_trip_data($whereArr=array(),$page=1,$num=4){
		/*SELECT
	tn.id AS '游记id',tn.title AS '游记标题',mo.total_price AS '订单金额',tn.content AS '标题下内容',
	tn.praise_count AS '赞数量',tn.comment_count AS '评论数量',tnp.pic AS '游记图片',
	tn.content1 AS '吃说明',tn.content2 AS '住说明',tn.content3 AS '行说明',tn.content4 AS '购说明'
	FROM travel_note AS tn LEFT JOIN u_member_order AS mo ON tn.order_id=mo.id
	LEFT JOIN travel_note_pic AS tnp ON tn.id=tnp.note_id
	WHERE tn.usertype=0 AND tn.userid=4*/

	/*SELECT
	tn.id AS '游记id',tn.title AS '游记标题',mo.total_price AS '订单金额',tn.content AS '标题下内容',
	tn.praise_count AS '赞数量',tn.comment_count AS '评论数量',
	(SELECT GROUP_CONCAT(tnp.pic SEPARATOR '') FROM travel_note_pic AS tnp WHERE tnp.note_id=tn.id) AS '游记图片'
	FROM travel_note AS tn LEFT JOIN u_member_order AS mo ON tn.order_id=mo.id
	WHERE tn.usertype=0 AND tn.userid=4*/

		$this->db->select ( "	tn.id AS tid,
					tn.title AS title,
					mo.total_price AS total_price,
					tn.line_id,
					tn.praise_count AS praise_count,
					tn.comment_count AS comment_count,
					(SELECT GROUP_CONCAT(tnp.pic SEPARATOR '') FROM travel_note_pic AS tnp WHERE tnp.note_id=tn.id) AS trip_pic,
					tn.content AS content
					" );
		$this->db->from ( 'travel_note AS tn' );
		$this->db->join ( 'u_member_order AS mo', 'tn.order_id=mo.id', 'left' );
		//$this->db->join ( 'travel_note_pic AS tnp', 'tn.id=tnp.note_id', 'left' );
		$whereArr['tn.usertype'] = 0;
		$this->db->where ( $whereArr );
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}



	/**
	 * 获取体验师数据
	 */
	public function get_experience_data($whereArr=array(),$page=1,$num=10) {
		/*SELECT
	me.id AS '体验师id',m.mid AS '用户id',m.litpic AS '用户头像',m.sex AS '性别',
	m.nickname AS '用户名字',me.consult_count AS '咨询次数',m.travel_count AS '旅行次数',
	m.talk AS '个性独白'
	FROM u_member_experience AS me LEFT JOIN u_member AS m ON me.member_id=m.mid
	WHERE m.mid=4*/
		$this->db->select ( '	me.id AS me_id,
					m.mid AS mid,
					m.litpic AS m_pic,
					m.sex AS m_sex,
					me.consult_count AS consult_count,
					m.nickname AS m_name,
					m.travel_count AS trip_count,
					m.talk AS m_talk
					' );
		$this->db->from ( 'u_member_experience AS me' );
		$this->db->join ( 'u_member AS m', 'me.member_id=m.mid', 'left' );
		$this->db->where ( $whereArr );
		$result=$this->db->get()->result_array();
		//array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	/**
	 * 获取体验师最新动态
	 */
	public function get_experience_news($whereArr=array(),$num=1,$offset=6){
		/*SELECT
	m.mid AS '用户id',tn.id AS '游记id',m.litpic AS '体验师头像',m.nickname AS '体验师名字',tn.title AS '游记标题'
	FROM u_member_experience AS me LEFT JOIN travel_note AS tn ON me.member_id=tn.userid
	LEFT JOIN u_member AS m ON me.member_id=m.mid
	ORDER BY tn.addtime DESC */
		$this->db->select ( '	m.mid AS mid,
					tn.id AS tid,
					m.litpic AS litpic,
					m.nickname AS nickname,
					tn.title AS title
					' );
		$this->db->from ( 'u_member_experience AS me' );
		$this->db->join ( 'travel_note AS tn', 'me.member_id=tn.userid', 'left' );
		$this->db->join ( 'u_member AS m', 'me.member_id=m.mid', 'left' );
		$this->db->where ( $whereArr );
		$this->db->limit($num, $offset);
		$this->db->order_by('tn.addtime','DESC');
		$result=$this->db->get()->result_array();
		return $result;
	}
	/**
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		if(!empty($value['trip_pic'])){
			$trip_pic = trim($value['trip_pic'],';');
			$value['trip_pic_arr']  = array_slice(explode(';',$trip_pic),0,3);
		}
	}
}
