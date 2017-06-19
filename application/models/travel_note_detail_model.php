<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Travel_note_detail_model extends MY_Model {

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}


	/**
	 * 获取游记详情数据
	 */
	public function get_travel_detail($whereArr=array(),$page=1,$num=4){
		/*SELECT
	me.id AS '体验师id',m.mid AS '用户id',m.litpic AS '用户头像',m.sex AS '性别',
	m.nickname AS '用户名字',me.consult_count AS '咨询次数',m.travel_count AS '旅行次数',
	m.talk AS '个性独白',tn.title AS '游记主题',mo.productname AS '游记线路',
	(SELECT COUNT(*) FROM travel_note_praise AS tnp WHERE tn.id=tnp.note_id) AS '赞',
	(SELECT COUNT(*) FROM travel_note_reply AS tnr WHERE tn.id=tnr.note_id) AS '评论数',
	tn.content AS '内容'	FROM u_member_experience AS me LEFT JOIN travel_note AS tn ON me.member_id=tn.userid
	LEFT JOIN u_member AS m ON me.member_id=m.mid
	LEFT JOIN u_member_order AS mo ON tn.order_id=mo.id
	WHERE tn.id=1*/
		$this->db->select('
				me.id AS me_id,
				m.mid AS mid,
				m.litpic AS litpic,
				m.sex AS m_sex,
				m.nickname AS nickname,
				me.consult_count AS consult_count,
				m.travel_count AS travel_count,
				m.talk AS talk,
				tn.title AS title,
				l.linename AS productname,
				l.id as lineid,
				tn.travel_impress AS travel_impress,
				(SELECT COUNT(*) FROM travel_note_praise AS tnp WHERE tn.id=tnp.note_id) AS praise_count,
				(SELECT COUNT(*) FROM travel_note_reply AS tnr WHERE tn.id=tnr.note_id) AS comment_count,
				tn.content AS content
			');
		$this->db->from('u_member_experience AS me');
		$this->db->join('travel_note AS tn','me.member_id=tn.userid','left');
		$this->db->join('u_member AS m','me.member_id=m.mid','left');
		$this->db->join('u_line AS l','l.id=tn.line_id','left');
		$this->db->where($whereArr);
		$result=$this->db->get()->result_array();
		return $result;
	}


	/**
	 * 获取游记的图片和图片描述数据
	 */
	function get_pic_data($travel_note_id,$page=1,$num=4){
		$sql = 'SELECT
			tn.id AS tn_id,
			CASE
			WHEN tnp.pictype=1 THEN tn.content1
			WHEN tnp.pictype=2 THEN tn.content2
			WHEN tnp.pictype=3 THEN tn.content3
			WHEN tnp.pictype=4 THEN tn.content4
			END pic_content,
			tnp.pic AS trip_pic
			FROM travel_note AS tn LEFT JOIN travel_note_pic AS tnp ON tn.id=tnp.note_id
			WHERE tn.id='.$travel_note_id;
		$result = $this->db->query($sql)->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}



	/**
	 * 获取游记评论数据
	 */
	public function get_comment_data($whereArr=array(),$page=1,$num=4){
		/*SELECT
	m.mid AS '用户id',tn.id AS '游记id',m.litpic AS '头像',m.nickname AS '昵称',
	tnr.reply_content AS '评论内容',tnr.addtime AS '发表时间'
	FROM travel_note_reply AS tnr LEFT JOIN travel_note AS tn ON tnr.note_id=tn.id
	LEFT JOIN u_member AS m ON tnr.member_id=m.mid
	WHERE tn.id=1*/

		$this->db->select ( '	m.mid AS mid,
					tn.id AS tid,
					m.litpic AS litpic,
					m.nickname AS nickname,
					tnr.reply_content AS reply_content,
					tnr.addtime AS addtime
					' );
		$this->db->from ( 'travel_note_reply AS tnr' );
		$this->db->join ( 'travel_note AS tn', 'tnr.note_id=tn.id', 'left' );
		$this->db->join ( 'u_member AS m', 'tnr.member_id=m.mid', 'left' );
		$this->db->where ( $whereArr );
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		//array_walk($result, array($this, '_fetch_list'));
		return $result;
	}


	/**
	 * 相关游记
	 */
	function get_about_travel($whereArr=array(),$page=1,$num=3){
		/*SELECT
	tn.id AS '游记id',tn.cover_pic AS '游记封面图',m.litpic AS '头像',
	m.nickname AS '昵称',tn.title AS '游记标题'
	FROM cfg_travel_note AS ctn LEFT JOIN travel_note AS tn ON ctn.note_id=tn.id
	LEFT JOIN u_member_experience AS me ON tn.userid=me.member_id
	LEFT JOIN u_member AS m ON me.member_id=m.mid*/
		$this->db->select('
				tn.id AS tid,
				tn.cover_pic AS cover_pic,
				m.litpic AS litpic,
				m.nickname AS nickname,
				tn.title AS title
			');
		$this->db->from('cfg_travel_note AS ctn');
		$this->db->join ( 'travel_note AS tn', 'ctn.note_id=tn.id', 'left' );
		$this->db->join ( 'u_member_experience AS me', 'tn.userid=me.member_id', 'left' );
		$this->db->join ( 'u_member AS m', 'me.member_id=m.mid', 'left' );
		$this->db->where ( $whereArr );
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;
	}

	/**
	 * 添加评论
	 */
	public function add_comment($insert_data=array()) {
		$this->db->insert('travel_note_reply',$insert_data);
		return $this->db->insert_id();
	}


	/**
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		if(!empty($value['trip_pic'])){
			$trip_pic = trim($value['trip_pic'],';');
			$value['trip_pic_arr']  = explode(';',$trip_pic);
		}
	}
}
