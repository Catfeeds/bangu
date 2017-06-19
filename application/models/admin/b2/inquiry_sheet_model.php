<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月22日15:50:11
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inquiry_sheet_model extends MY_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	private $table_name = 'u_enquiry';

	public function __construct() {
		parent::__construct($this->table_name);
	}

	/**
	 * 获取专家抢定制订单询价数据列表
	 *
	 * @param $aray $whereArr
	 * @param number $page
	 * @param number $num
	 * @return array
	 */
	public function get_inquiry_list($page = 1, $num = 10,$expert_id) {
	$sql = "SELECT ce.id AS ce_id,ey.status AS e_status,ey.customize_answer_id AS ca_id ,c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace)  AS startplace,(SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people FROM u_enquiry AS ey LEFT JOIN   u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (c.id=ce.customize_id AND ey.id=ce.enquiry_id) WHERE (ey.status=1 OR ey.status=2) AND ey.expert_id=$expert_id   AND ey.id NOT IN (SELECT eg.enquiry_id FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) order by eid desc";
	          if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}

	}

	//已回复询价单数据
	function get_inquiry_reply_list($page = 1, $num = 10,$expert_id){
		$sql="	SELECT ce.id AS ce_id,ey.status AS e_status,ey.customize_answer_id AS ca_id,c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace)  AS startplace,(SELECT GROUP_CONCAT(de.kindname)  AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people,(SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS comment_count FROM u_enquiry AS ey LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (c.id=ce.customize_id AND ey.id=ce.enquiry_id) WHERE ey.status=2 AND ey.expert_id=$expert_id  AND ey.id IN (SELECT eg.enquiry_id FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) order by eid desc";
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}

	}

	//询价单已完成
	function get_inquiry_complete_list($page = 1, $num = 10,$expert_id){
		$sql=" SELECT ey.supplier_id AS s_id,ce.id AS ce_id,ey.status AS e_status,ey.customize_answer_id AS ca_id,c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace)  AS startplace,(SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people,(SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS comment_count FROM u_enquiry AS ey LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (c.id=ce.customize_id AND ey.id=ce.enquiry_id)  WHERE ey.status=3  AND ey.expert_id=$expert_id  order by eid desc";
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}

	//询价单已取消数据
	function get_inquiry_cancle_list($page = 1, $num = 10,$expert_id){
		$sql="SELECT ce.id AS ce_id,ey.status AS e_status,ey.customize_answer_id AS ca_id,c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate, (SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace)  AS startplace,(SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people,(SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS comment_count FROM u_enquiry AS ey LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (c.id=ce.customize_id AND ey.id=ce.enquiry_id) WHERE ey.status=-2 AND ey.expert_id=$expert_id  order by eid desc";
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}

	//管家回复方案的内容
	function get_inquiry_reply($whereArr){

	 $this->db->select(
                      	"eg.id,
                      	s.id AS s_id,
                      	ey.id AS eid,
                      	s.company_name,
                      	s.brand AS brand,
                      	s.realname AS realname,
                      	s.link_mobile AS mobile,
		s.linkman AS linkman,
		s.link_mobile AS link_mobile,
                      	eg.reply,
                      	eg.price AS supplier_price,
                      	eg.childprice AS childprice,
                      	eg.childnobedprice AS childnobedprice,
                      	eg.oldprice AS oldprice,
                      	eg.attachment,
                      	eg.agent_rate
                      	"
               );
	 $this->db->where($whereArr);
	  $this->db->from('u_enquiry AS ey');
	$this->db->join('u_enquiry_grab AS eg','ey.id=eg.enquiry_id','left');
	$this->db->join('u_supplier AS s','eg.supplier_id=s.id','left');
	$result=$this->db->get()->result_array();
	array_walk($result, array($this, '_fetch_list'));
	return $result;
	}


	/**
	 * 获取定制单的数据
	 */
	function get_one_customize($ce_id){
	$sql = "SELECT ce.id AS ce_id,c.id AS id,e.status AS e_status,ce.startdate AS startdate,ce.estimatedate AS estimatedate,e.supplier_id AS supplier_id,s.company_name AS s_name, (SELECT concat_ws('|',st.cityname,st.id)  FROM u_startplace AS st  WHERE st.id=ce.startplace) AS startplace, (SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=2) AS endplace_two, (SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace_three, ce.days AS days,ce.trip_way AS trip_way,ce.another_choose AS another_choose,ce.total_people AS total_people, ce.people AS people,ce.childnum AS childnum,ce.childnobednum AS childnobednum,ce.oldman AS oldman,ce.roomnum AS roomnum, ce.custom_type AS custom_type,ce.isshopping AS isshopping,ce.budget AS budget,ce.service_range AS service_range, ce.hotelstar AS hotelstar,e.extra AS extra,ce.room_require AS room_require,ce.catering AS catering FROM u_customize_expert AS ce LEFT JOIN u_customize AS c ON ce.customize_id=c.id LEFT JOIN u_enquiry AS e ON c.id=e.customize_id LEFT JOIN u_supplier AS s ON s.id=e.supplier_id WHERE ce.id=$ce_id";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		//array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	/**
	 * 获取定制单行程数据
	 */

	function get_customize_trip($ca_id){
		$sql = "SELECT ca.id AS ca_id,cj.id AS cj_id,cjp.id AS cjp_id,cj.transport AS transport, cj.day AS cj_day,cj.title AS cj_title,cj.jieshao AS cj_jieshao,cjp.pic AS c_pic, cj.breakfirsthas AS breakfirsthas,cj.breakfirst AS breakfirst,cj.lunchhas AS lunchhas, cj.lunch AS lunch,cj.supperhas AS supperhas,cj.supper AS supper,cj.hotel AS hotel FROM u_customize AS c LEFT JOIN u_customize_answer AS ca ON c.id=ca.customize_id LEFT JOIN u_customize_jieshao AS cj ON cj.customize_answer_id=ca.id LEFT JOIN u_customize_jieshao_pic AS cjp ON cj.id=cjp.customize_jieshao_id WHERE ca.id=$ca_id";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	//获取供应商的回复方案
	function get_supplier_customize($eid,$supplier_id){
		$query_sql = "SELECT ey.id,eg.id,eg.title AS ca_title,eg.plan_description,eg.price,eg.childprice,eg.childnobedprice,eg.oldprice,eg.agent_rate,eg.attachment,eg.reply FROM u_enquiry AS ey LEFT JOIN u_enquiry_grab AS eg ON ey.id=eg.enquiry_id WHERE ey.id={$eid} AND eg.supplier_id={$supplier_id}";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		return $result;
	}

	//供应商设计的行程
	function get_supplier_trip($eid,$supplier_id){
		$query_sql = "SELECT ey.id,ej.day AS cj_day,ej.title AS cj_title,ej.transport AS transport,ej.hotel AS hotel, ej.breakfirsthas AS breakfirsthas,ej.breakfirst AS breakfirst,ej.lunchhas AS lunchhas,ej.lunch AS lunch, ej.supperhas AS supperhas,ej.supper AS supper,ej.jieshao AS cj_jieshao,ej.pic AS c_pic FROM u_enquiry AS ey LEFT JOIN u_enquiry_grab AS eg ON ey.id=eg.enquiry_id LEFT JOIN u_enquiry_jieshao AS ej ON ej.enquiry_grab_id=.eg.id WHERE ey.id={$eid} AND eg.supplier_id={$supplier_id} order by cj_day ASC";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	/**
	 * 获取管家报价
	 */
	function get_expert_price($ca_id){
		$sql = "SELECT ca.id ca_id,ca.title AS ca_title,ca.price AS price,ca.childprice AS childprice,ca.childnobedprice AS childnobedprice,ca.oldprice AS oldprice, ca.price_description,ca.plan_design FROM u_enquiry AS ey LEFT JOIN u_customize_answer AS ca ON ey.customize_answer_id=ca.id LEFT JOIN u_customize AS c ON ca.customize_id=c.id WHERE ca.id=$ca_id";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}

	/**
	 * [get_question 获取插入数据库的question字段的字符串]
	 * @param  [type] $update_arr   [description]
	 */
	function get_question($update_arr){
		$get_start_place_sql = 'select cityname from u_startplace WHERE id='.$update_arr['startplace'];
		$query = $this->db->query($get_start_place_sql);
		$startplace=$query->result_array();
		$get_end_place_sql = 'SELECT GROUP_CONCAT(kindname) AS dest_name FROM u_dest_base WHERE id IN ('.$update_arr['endplace'].')';
		$query = $this->db->query($get_end_place_sql);
		$endplace=$query->result_array();
		$question = $startplace[0]['cityname'].' 到 '.$endplace[0]['dest_name'].$update_arr['days'].' 日游';
		return $question;
	}




	/**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		$endplace_str = "";

		if(isset($value['c_pic'])&&$value['c_pic']!=''){
			$c_pic = trim($value['c_pic'], ';');
			$pic_arr = explode(';', $c_pic);
			$value['pic_arr'] = $pic_arr;
		}
	}
}