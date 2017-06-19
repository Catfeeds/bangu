<?php
/**
 * 评论管理
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月27日11:59:53
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Comment_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_comment';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}



	//获取新申诉数据
	function get_new_comment($whereArr, $page = 1, $num = 10){
		/*SELECT
	cc.id,c.id AS '评论id',s.company_name AS '供应商名称',l.linename AS '线路名称',
	m.truename AS '会员',c.content AS '评论内容',
	CASE
	WHEN ISNULL(c.reply1)=0 THEN c.reply1
	END '供应商回复',
	c.addtime AS '评论时间',c.avgscore1 AS '线路评分',cc.reason
	FROM u_comment_complain AS cc LEFT JOIN u_comment AS c ON cc.comment_id=c.id
	LEFT JOIN u_supplier AS s ON cc.supplier_id=s.id
	LEFT JOIN u_line AS l ON c.line_id=l.id
	LEFT JOIN u_member AS m ON c.memberid=m.mid
	WHERE cc.status=0 ;*/
		$this->db->select (
      				'cc.id AS cmp_id,
      				c.id AS cm_id,
      				s.company_name AS supplier_name,
      				l.linename AS linename,
				m.truename AS m_name,
				c.content AS content,
				c.reply1 AS s_reply,
				c.reply2 AS a_reply,
				c.addtime AS comment_time,
				c.avgscore1 AS line_score,
				cc.reason AS cmp_reason,
				l.id AS line_id,
				ord.expert_id'
      			 );
		$this->db->from ( 'u_comment_complain AS cc');
		$this->db->join('u_comment AS c','cc.comment_id=c.id','left');
		$this->db->join('u_supplier AS s','cc.supplier_id=s.id','left');
		$this->db->join('u_line AS l','c.line_id=l.id','left');
		$this->db->join('u_member AS m','c.memberid=m.mid','left');
		$this->db->join('u_member_order AS ord','ord.id=c.orderid','left');
		$whereArr['cc.status'] = 0;
		$whereArr['c.status'] = 1;
		$this->db->where($whereArr);
		$this ->db ->order_by('c.addtime' ,'desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;


	}

	//获取通过申诉数据
	function get_pass_comment($whereArr, $page = 1, $num = 10){
		/*SELECT
	cc.id,c.id AS '评论id',s.company_name AS '供应商名称',l.linename AS '线路名称',
	m.truename AS '会员',c.content AS '评论内容',c.reply1 AS '供应商回复',c.reply2 AS '平台回复',
	c.addtime AS '评论时间',c.avgscore1 AS '线路评分',cc.reason AS '供应商申诉'
	FROM u_comment_complain AS cc LEFT JOIN u_comment AS c ON cc.comment_id=c.id
	LEFT JOIN u_supplier AS s ON cc.supplier_id=s.id
	LEFT JOIN u_line AS l ON c.line_id=l.id
	LEFT JOIN u_member AS m ON c.memberid=m.mid
	WHERE cc.status=1*/
	$this->db->select (
      				'cc.id AS cmp_id,
      				c.id AS cm_id,
      				s.company_name AS supplier_name,
      				l.linename AS linename,
				m.truename AS m_name,
				c.content AS content,
				c.reply1 AS s_reply,
				c.reply2 AS a_reply,
				c.addtime AS comment_time,
				c.avgscore1 AS line_score,
				cc.reason AS cmp_reason'
      			 );
		$this->db->from ( 'u_comment_complain AS cc');
		$this->db->join('u_comment AS c','cc.comment_id=c.id','left');
		$this->db->join('u_supplier AS s','cc.supplier_id=s.id','left');
		$this->db->join('u_line AS l','c.line_id=l.id','left');
		$this->db->join('u_member AS m','c.memberid=m.mid','left');
		$whereArr['cc.status'] = 1;
		$whereArr['c.status'] = 1;
		$this->db->where($whereArr);
		$this ->db ->order_by('c.addtime' ,'desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;

	}

	//获取拒绝申诉数据
	function get_refuse_comment($whereArr, $page = 1, $num = 10){
		/*SELECT
	cc.id,c.id AS '评论id',s.company_name AS '供应商名称',l.linename AS '线路名称',
	m.truename AS '会员',c.content AS '评论内容',c.reply1 AS '供应商回复',c.reply2 AS '平台回复',
	c.addtime AS '评论时间',c.avgscore1 AS '线路评分',cc.reason AS '供应商申诉'
	FROM u_comment_complain AS cc LEFT JOIN u_comment AS c ON cc.comment_id=c.id
	LEFT JOIN u_supplier AS s ON cc.supplier_id=s.id
	LEFT JOIN u_line AS l ON c.line_id=l.id
	LEFT JOIN u_member AS m ON c.memberid=m.mid
	WHERE cc.status=2*/
	$this->db->select (
      				'cc.id AS cmp_id,
      				c.id AS cm_id,
      				s.company_name AS supplier_name,
      				l.linename AS linename,
				m.truename AS m_name,
				c.content AS content,
				c.reply1 AS s_reply,
				c.reply2 AS a_reply,
				c.addtime AS comment_time,
				c.avgscore1 AS line_score,
				cc.reason AS cmp_reason'
      			 );
		$this->db->from ( 'u_comment_complain AS cc');
		$this->db->join('u_comment AS c','cc.comment_id=c.id','left');
		$this->db->join('u_supplier AS s','cc.supplier_id=s.id','left');
		$this->db->join('u_line AS l','c.line_id=l.id','left');
		$this->db->join('u_member AS m','c.memberid=m.mid','left');
		$whereArr['cc.status'] = 2;
		$whereArr['c.status'] = 1;
		$this->db->where($whereArr);
		$this ->db ->order_by('c.addtime' ,'desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;

	}

	//获取删除申诉数据
	function get_delete_comment($whereArr, $page = 1, $num = 10){
		/*SELECT
	c.id AS '评论id',s.company_name AS '供应商名称',l.linename AS '线路名称',
	m.truename AS '会员',c.content AS '评论内容',c.reply1 AS '供应商回复',c.reply2 AS '平台回复',
	c.addtime AS '评论时间',c.avgscore1 AS '线路评分'
	FROM u_comment AS c
	LEFT JOIN u_line AS l ON c.line_id=l.id
	LEFT JOIN u_supplier AS s ON l.supplier_id=s.id
	LEFT JOIN u_member AS m ON c.memberid=m.mid
	WHERE c.isshow=0*/
			$this->db->select (
      				'c.id AS cm_id,
      				s.company_name AS supplier_name,
      				l.linename AS linename,
				m.truename AS m_name,
				c.content AS content,
				c.reply1 AS s_reply,
				c.reply2 AS a_reply,
				c.addtime AS comment_time,
				c.avgscore1 AS line_score'
      			 );
		$this->db->from ( 'u_comment AS c');
		$this->db->join('u_line AS l','c.line_id=l.id','left');
		$this->db->join('u_supplier AS s','l.supplier_id=s.id','left');
		$this->db->join('u_member AS m','c.memberid=m.mid','left');
		$whereArr['c.isshow'] = 0;
		$whereArr['c.status'] = 0;
		$this->db->where($whereArr);
		$this ->db ->order_by('c.addtime' ,'desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;

	}


	/**
	 * 获取全部申诉数据
	 */
	public function get_all_comment($whereArr, $page = 1, $num = 10, $status=1) {
		/*SELECT
	c.id AS '评论id',s.company_name AS '供应商名称',l.linename AS '线路名称',
	m.truename AS '会员',c.content AS '评论内容',c.reply1 AS '供应商回复',c.reply2 AS '平台回复',
	c.addtime AS '评论时间',c.avgscore1 AS '线路评分'
	FROM  u_comment AS c LEFT JOIN u_line AS l ON c.line_id=l.id
	LEFT JOIN u_supplier AS s ON l.supplier_id=s.id
	LEFT JOIN u_member AS m ON c.memberid=m.mid
	ORDER BY c.isshow DESC ,c.addtime DESC*/

  			$this->db->select (
      				'c.id AS cm_id,
      				s.company_name AS supplier_name,
      				l.linename AS linename,
				m.truename AS m_name,
				c.content AS content,
				c.reply1 AS s_reply,
				c.reply2 AS a_reply,
				c.addtime AS comment_time,
				c.avgscore1 AS line_score'
      			 );
		$this->db->from ( 'u_comment AS c');
		$this->db->join('u_line AS l','c.line_id=l.id','left');
		$this->db->join('u_supplier AS s','l.supplier_id=s.id','left');
		$this->db->join('u_member AS m','c.memberid=m.mid','left');
		$this->db->where($whereArr);
		$this ->db ->order_by('c.isshow' ,'desc');
		$this ->db ->order_by('c.addtime' ,'desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;
	}











	/**
	 * 获取会员数据
	 */
	function  get_member_data(){
		$this->db->select('mid,truename');
		$this->db->from('u_member');
		return $this->db->get()->result_array();
	}


	/**
	 * 获取专家
	 */
	function get_expert_data(){
		$this->db->select('id,realname');
		$this->db->from('u_expert');
		return $this->db->get()->result_array();
	}

	/**
	 * 获取供应商
	 */
	function get_supplier_data(){
		$this->db->select('id,company_name');
		$this->db->where(array('status'=>2));
		$this->db->from('u_supplier');
		return $this->db->get()->result_array();
	}




}