<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年7月22日15:50:11
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends MY_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	public function __construct() {
		parent::__construct();
	}
	/**
	 * 获取专家信息
	 *
	 * @param $aray $whereArr
	 * @param number $page
	 * @param number $num
	 * @return array
	 */
	public function get_expert_info($expert_id) {
	/*	 "SELECT e.small_photo AS '管家头像',e.amount AS '账户余额',e.realname AS '管家名称',	e.login_name AS '管家账户名',e.logindatetime AS '最后登陆时间'	FROM u_expert AS e WHERE e.id=".$expert_id*/
	$whereArr = array();
	$whereArr['e.id'] = $expert_id;
	 $this->db->select("
	 	e.small_photo AS small_photo,
	 	e.bankcard AS bankcard,
	 	e.bankname AS bankname,
	 	e.cardholder AS cardholder,
	 	e.amount AS amount,
	 	e.realname AS realname,
	 	e.login_name AS login_name,
	 	e.logindatetime AS logindatetime,
	 	e.mobile AS mobile
	 	"
               );
	 $this->db->where($whereArr);
	 $this->db->from('u_expert AS e');
	$result=$this->db->get()->result_array();
	//array_walk($result, array($this, '_fetch_list'));
	return $result;
	}


	/**
	 * [get_cust_amount 定制单统计]
	 * @param  [type] $whereArr [description]
	 * @return [type]           [description]
	 */
	function get_cust_amount($expert_id){
		/*SELECT	COUNT(*)
				FROM u_customize AS c LEFT JOIN u_dictionary AS d ON c.trip_way=d.dict_id
				WHERE c.status=0 AND c.is_assign=0 AND c.id NOT IN
				(SELECT cg.customize_id FROM u_customize_grab AS cg WHERE cg.expert_id=?)
				AND TIMESTAMPDIFF(HOUR,c.addtime,NOW())<24*/
	$whereArr = array();
	$whereArr['c.status'] = 0;
	$whereArr['c.is_assign'] = 0;
	 $this->db->select("COUNT(*) AS cus_count");
	 $this->db->where($whereArr);
	 $this->db->where('c.id NOT IN (SELECT cg.customize_id FROM u_customize_answer AS cg WHERE cg.expert_id='.$expert_id.')');
	 $this->db->where('TIMESTAMPDIFF(HOUR,c.addtime,NOW())<24');
	  $this->db->from('u_customize AS c');
	$this->db->join('u_dictionary AS d','c.trip_way=d.dict_id','left');
	$result=$this->db->get()->result_array();
	//array_walk($result, array($this, '_fetch_list'));
	return $result;
	}


	/**
	 * 统计系统消息
	 */
	function get_sys_msg($expert_id){
	/*	SELECT COUNT(*) '系统通知未读'
				FROM u_notice AS n
				WHERE n.notice_type=1 AND n.id NOT IN
				(SELECT nr.notice_id FROM u_notice_read AS nr WHERE nr.notice_type=1 AND nr.userid= ? )*/
	$whereArr = array();
	$whereArr['n.notice_type'] = 1;
	$this->db->select("COUNT(*) sys_msg_count");
	 $this->db->where($whereArr);
	 $this->db->where('n.id NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE nr.notice_type=1 AND nr.userid='.$expert_id.')');
	 $this->db->from('u_notice AS n');
	$result=$this->db->get()->result_array();
	//array_walk($result, array($this, '_fetch_list'));
	return $result;
	}

	/**
	 * 统计业务消息
	 */
	function get_bus_msg($expert_id){
		/*SELECT	COUNT(*) '业务消息未读'	FROM u_message AS m
				WHERE m.msg_type=1 AND m.receipt_id= ? AND m.read=0 */
		$whereArr = array();
		$whereArr['m.msg_type'] = 1;
		$whereArr['m.read'] = 0;
		$whereArr['m.receipt_id'] = $expert_id;
		$this->db->where($whereArr);
		$this->db->select('COUNT(*) AS bus_msg_count');
		$this->db->from('u_message AS m');
		$result=$this->db->get()->result_array();
		return $result;

	}

	/**
	 * [get_statis_data 统计投诉率和满意度]
	 * @return [type] [description]
	 */
	function get_statis_data($expert_id){
	/*	SELECT	e.satisfaction_rate AS '满意度',e.complain_rate AS '投诉率'
			FROM u_expert AS e WHERE e.id=?*/
		$whereArr = array();
		$whereArr['e.id'] = $expert_id;
		$this->db->where($whereArr);
		$this->db->select('e.satisfaction_rate AS s_rate,e.complain_rate AS c_rate');
		$this->db->from('u_expert AS e');
		$result=$this->db->get()->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	/**
	 * [get_line_level 统计线路的级别]
	 * @return [type] [description]
	 */
	function get_line_level($expert_id,$level=1){
		/*SELECT	COUNT(*) AS '初级专家'
			FROM u_expert AS e LEFT JOIN u_line_apply AS la ON e.id=la.expert_id
			WHERE e.id=? AND la.grade=2 AND la.status=2*/
		$whereArr = array();
		$whereArr['e.id'] = $expert_id;
		$whereArr['la.grade'] = $level;
		$whereArr['la.status'] = 2;
		$this->db->where($whereArr);
		$this->db->select('COUNT(*) AS e_level');

		$this->db->join('u_line_apply AS la','e.id=la.expert_id','left');
		$this->db->from('u_expert AS e');
		$result=$this->db->get()->result_array();
		return $result;

	}

	/**
	 * 获取订单状态配置表的数据
	 * [get_order_status description]
	 * @return [type] [description]
	 */
	function get_order_status(){
		$sql = "select * from cfg_status_definition where type=1";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	/**
	 * 获取b2个人主页的数据
	 * @param  [type] $expert_id [description]
	 * @return [type]            [description]
	 */
	function get_home_data($expert_id){
		$sql = "SELECT
	e.id,e.small_photo AS small_photo,e.realname AS realname,e.nickname AS nickname,e.login_name AS login_name,e.logindatetime AS logindatetime,e.people_count AS people_count,
	e.total_score AS total_score,e.satisfaction_rate AS satisfaction_rate,e.complain_rate AS complain_rate,
	COALESCE((SELECT SUM(mo.total_price) FROM u_member_order AS mo WHERE mo.status>=5 AND mo.expert_id=e.id) ,0) total_turnover,
	-- 平台公告
	(SELECT COUNT(*) FROM u_notice AS n WHERE FIND_IN_SET(1,n.notice_type)>0 AND n.id NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE nr.userid=e.id AND nr.notice_type=1)) AS unread_sys_msg,
	-- 客人提问
	(SELECT COUNT(*) FROM u_line_question AS lq LEFT JOIN u_line_apply AS la ON lq.productid=la.line_id WHERE ((la.expert_id=e.id AND la.status=2 AND lq.reply_id=0) OR (lq.reply_type=1 AND lq.reply_id=e.id)) AND ISNULL(lq.replytime)>0) AS client_ask,
	-- 总消息数量,暂时放着
	((SELECT COUNT(*) FROM u_notice AS n WHERE FIND_IN_SET(1,n.notice_type)>0 AND n.id NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE nr.notice_type=1 AND nr.userid=e.id))+
	(SELECT COUNT(*) FROM u_message AS m WHERE m.msg_type=1 AND m.receipt_id=e.id AND m.read=0)) AS unread_bus_msg,
	-- 抢定制单
	(SELECT count(DISTINCT c.id) FROM u_customize AS c LEFT JOIN u_customize_dest AS cd ON c.id=cd.customize_id WHERE (c.status=0 AND TIMESTAMPDIFF(HOUR , c.addtime,NOW())<24)  AND c.user_type=0  AND c.id NOT IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ISNULL(ca.replytime)=0 AND ca.expert_id=e.id)  AND((c.is_assign=0 AND (cd.dest_id IN (SELECT ed.dest_id FROM u_expert_dest AS ed WHERE ed.expert_id=e.id) OR cd.dest_id IN (SELECT ed.dest_pid FROM u_expert_dest AS ed WHERE ed.expert_id=e.id))) OR ( c.is_assign=1 AND c.expert_id=e.id)) )  AS guest_order,
	-- 客人回单
	(SELECT COUNT(*) FROM u_customize AS c LEFT JOIN u_customize_answer AS ca ON c.id=ca.customize_id WHERE ca.isuse=1 AND ca.expert_id=e.id AND c.status=1) AS guest_awser_order,
	-- 供应商回单
	(SELECT COUNT(*) FROM u_enquiry AS ey LEFT JOIN u_enquiry_grab AS eg ON ey.id=eg.enquiry_id WHERE ey.expert_id=e.id AND ey.status=2) AS supplier_awser_order,
	-- 订单信息
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=0 AND cal.order_status=-4 AND cal.isread=0) cancel_order, 	-- 客人已取消
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=0 AND cal.order_status=0 AND cal.isread=0) client_kongwei,	-- 客人已下单
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=0 AND cal.order_status=1 AND cal.isread=0) supplier_kongwei,  -- 供应商已预留位
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=1 AND cal.order_status=1 AND cal.isread=0) client_pay,	-- 客人已付款
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=2 AND cal.order_status=1 AND cal.isread=0) admin_receive,	-- 平台确认收款
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=2 AND cal.order_status=4 AND cal.isread=0) supplier_confirm,  -- 供应商已确认
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=2 AND cal.order_status=5 AND cal.isread=0) go_start,		-- 客人已出行
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=2 AND cal.order_status=6 AND cal.isread=0) client_comment,    -- 客人已评价
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=2 AND cal.order_status=7 AND cal.isread=0) client_complain,   -- 客人投诉
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=3 AND cal.order_status=-3 AND cal.isread=0) tuiding ,		-- 客人申请退款
	(SELECT COUNT(*) FROM cal_expert_order_status AS cal WHERE cal.expert_id=e.id AND cal.order_ispay=4 AND cal.order_status=-4 AND cal.isread=0) yituiding,	-- 平台已退款
	(SELECT COUNT(*) FROM travel_note AS tn LEFT JOIN u_member_order AS mo ON tn.order_id=mo.id WHERE mo.expert_id=e.id AND tn.e_isread=0 and tn.usertype=0) tiyan ,			-- 客人发体验
	-- 售卖级别
	(SELECT COUNT(*) FROM u_expert_upgrade AS eg WHERE eg.expert_id=e.id AND eg.grade_after=2 AND eg.status=2 AND eg.isread=0) AS level_count_2,			-- 初级专家
	(SELECT COUNT(*) FROM u_expert_upgrade AS eg WHERE eg.expert_id=e.id AND eg.grade_after=3 AND eg.status=2 AND eg.isread=0) AS level_count_3,			-- 中级专家
	(SELECT COUNT(*) FROM u_expert_upgrade AS eg WHERE eg.expert_id=e.id AND eg.grade_after=4 AND eg.status=2 AND eg.isread=0) AS level_count_4			-- 高级专家
	FROM u_expert AS e WHERE  e.id={$expert_id}";
	$query = $this->db->query($sql);
	$result=$query->result_array();
	return $result;
	}
	/**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
			$value['s_rate']=$value['s_rate']*100;
			$value['c_rate']=$value['c_rate']*100;
	}
	/**
	 *@param int  $photo_shop  相馆地址id
	 *@param string  $qrcodes  二维码
	 *@param int $expert_id  管家id
	 *@return  int
	 */
	function insert_expert_museum($photo_shop,$qrcodes,$expert_id){
		$this->db->trans_start();
		//插入管家关联相馆表
		$museumArr=array(
			'expert_id'=>$expert_id,
			'museum_id'=>$photo_shop,
			'qrcode'=>$qrcodes,
			'addtime'=>date('Y-m-d H:i:s'),
			'status'=>0
		);
		$this->db->insert('u_expert_museum',$museumArr);
		$museumid=$this->db->insert_id();

		//插入管家关联二维码表
		$qrcodeArr=array(
			'expert_id'=>$expert_id,
			'expert_museum_id'=>$museumid,
			'qrcode'=>$qrcodes,
			'status'=>0
		);
		$this->db->insert('u_expert_qrcode',$qrcodeArr);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return $museumid;
		}
	}
}