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
date_default_timezone_set('Asia/Shanghai');
class Grab_custom_order_model extends MY_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	private $table_name = 'u_customize';

	public function __construct() {
		parent::__construct($this->table_name);
	}

	/**
	 * 获取专家抢定制订单据列表
	 *
	 * @param $aray $whereArr
	 * @param number $page
	 * @param number $num
	 * @return array
	 */
	public function get_grab_custom_list($page = 1, $num = 10,$expert_id) {
		$sql = "SELECT e.id AS e_id,e.status AS e_status,(select ca.id from u_customize_answer as ca where ca.customize_id=c.id and ca.expert_id={$expert_id} and ca.enquiry_grab_id=0 ORDER BY ca.addtime desc limit 1) AS ca_id,ca.expert_id,c.id AS c_id,c.startdate AS startdate,c.estimatedate AS estimatedate,c.budget AS budget,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace, (SELECT GROUP_CONCAT(d.kindname) FROM u_dest_base AS d WHERE FIND_IN_SET(d.id,c.endplace)>0 AND d.level=3) AS dest, c.days AS days,c.total_people AS total_people,c.trip_way AS trip_way,c.another_choose AS another_choose, c.custom_type AS custom_type,c.addtime AS addtime, ca.is_allow,c.linkname,c.linkphone FROM u_customize AS c LEFT JOIN u_customize_answer AS ca ON (c.id=ca.customize_id AND ca.expert_id={$expert_id}) LEFT JOIN u_customize_dest AS cd ON c.id=cd.customize_id LEFT JOIN u_enquiry AS e ON (c.id=e.customize_id AND e.expert_id={$expert_id}) WHERE (c.status=0 AND TIMESTAMPDIFF(HOUR , c.addtime,NOW())<24) AND c.user_type=0 AND (c.id NOT IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ISNULL(ca.replytime)=0 AND ca.expert_id={$expert_id}) AND c.id NOT IN (SELECT cr.customize_id FROM u_customize_reply AS cr WHERE cr.expert_id={$expert_id})) AND((c.is_assign=0 AND (cd.dest_id IN (SELECT ed.dest_id FROM u_expert_dest AS ed WHERE ed.expert_id={$expert_id}) OR cd.dest_id IN (SELECT ed.dest_pid FROM u_expert_dest AS ed WHERE ed.expert_id={$expert_id}))) OR ( c.is_assign=1 AND c.expert_id={$expert_id})) GROUP BY c.id ";
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY c.addtime DESC";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}



	/**
	 * 已投标
	 */
	function get_reply_list($page = 1, $num = 10,$expert_id){
	$sql = "SELECT e.id AS e_id,e.status AS e_status,c.status AS c_status,(select ca.id from u_customize_answer as ca where ca.customize_id=c.id and ca.expert_id={$expert_id} and ca.enquiry_grab_id=0 ORDER BY ca.addtime desc limit 1) AS ca_id,c.id AS c_id,c.startdate AS startdate,c.estimatedate AS estimatedate,c.budget AS budget,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace, (SELECT GROUP_CONCAT(d.kindname) FROM u_dest_base AS d WHERE FIND_IN_SET(d.id,c.endplace)>0 AND d.level=3) AS dest,c.days AS days,c.total_people AS total_people,c.trip_way AS trip_way,c.service_range AS service_range,c.another_choose AS another_choose,c.custom_type AS custom_type,rpy.is_allow,c.linkname,c.linkphone FROM u_customize_answer AS ca LEFT JOIN u_customize AS c ON ca.customize_id=c.id LEFT JOIN u_customize_reply AS rpy ON rpy.customize_id = c.id LEFT JOIN u_enquiry AS e ON (c.id=e.customize_id AND e.expert_id={$expert_id})  WHERE ca.expert_id={$expert_id} AND c.user_type=0 AND ca.isuse=0 AND c.id NOT IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ca.customize_id=c.id AND ca.expert_id={$expert_id} AND ca.isuse=1) AND ISNULL(ca.replytime)=0  GROUP BY c.id ORDER BY c.addtime desc";
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			array_walk($result, array($this, '_fetch_list'));
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}

	/**
	 * 已中标数据列表
	 */
	function get_grab_order( $page = 1, $num = 10,$expert_id){
		$sql = "SELECT e.id AS e_id,e.status AS e_status,c.id AS c_id,m.qq AS qq,ca.expert_id,m.truename AS truename,m.mobile AS mobile,ca.id AS ca_id,c.member_id AS member_id,c.startdate AS startdate,c.estimatedate AS estimatedate,c.budget AS budget,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace, (SELECT GROUP_CONCAT(d.kindname) FROM u_dest_base AS d WHERE FIND_IN_SET(d.id,c.endplace)>0 AND d.level=3) AS dest,c.days AS days,c.total_people AS total_people,c.trip_way AS trip_way,c.another_choose AS another_choose,c.service_range AS service_range,c.custom_type AS custom_type,c.addtime AS addtime  FROM u_customize_answer AS ca LEFT JOIN u_customize AS c ON ca.customize_id=c.id LEFT JOIN u_member AS m ON c.member_id=m.mid LEFT JOIN u_enquiry AS e ON (c.id=e.customize_id AND e.expert_id={$expert_id}) WHERE ca.expert_id={$expert_id} AND c.user_type=0 AND ca.isuse=1 AND c.is_assign=1 AND ISNULL(ca.replytime)=0 and (c.`status`=1 or c.`status`=3) ";
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." GROUP BY c.id ORDER BY c.addtime desc";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			array_walk($result, array($this, '_fetch_list'));
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}


	}


	//获取总体描述
	function get_travel_design($whereArr){
		$this->db->select("plan_design,attachment,oldprice,childprice,childnobedprice,price,price_description");
	 	$this->db->where($whereArr);
	 	$this->db->from('u_customize_answer');
	 	$result=$this->db->get()->result_array();
		return $result;

	}
	/**
	 * 已过期数据
	 */
	function get_expired_order($whereArr, $page = 1, $num = 10){
		$sql = "SELECT c.id AS c_id,c.startdate AS startdate,c.estimatedate AS estimatedate,c.budget AS budget,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace, (SELECT GROUP_CONCAT(d.kindname) FROM u_dest_base AS d WHERE FIND_IN_SET(d.id,c.endplace)>0 AND d.level=3) AS dest,c.days AS days,c.total_people AS total_people,c.trip_way AS trip_way,c.another_choose AS another_choose,c.service_range AS service_range,c.custom_type AS custom_type,c.addtime AS addtime FROM u_customize AS c WHERE (c.status=-2 OR c.status=-3) AND c.user_type=0";
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." order by c.addtime desc";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}

	}


	/**
	 * 已回复的数据
	 */
	function get_replyed_order($whereArr, $page = 1, $num = 10,$expert_id){
		$sql = "SELECT c.id AS c_id,c.startdate AS startdate,c.estimatedate AS estimatedate,c.budget AS budget,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace, (SELECT GROUP_CONCAT(d.kindname) FROM u_dest_base AS d WHERE FIND_IN_SET(d.id,c.endplace)>0 AND d.level=3) AS dest,c.days AS days,c.total_people AS total_people,c.trip_way AS trip_way,c.another_choose AS another_choose,c.service_range AS service_range,c.custom_type AS custom_type,c.addtime AS addtime,cr.answer_id AS cr_answer_id,cr.reply AS cr_reply FROM u_customize AS c  LEFT JOIN u_customize_reply AS cr ON cr.customize_id=c.id WHERE  c.user_type=0 AND cr.expert_id={$expert_id}";
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." order by c.addtime desc";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}

	}


	/**
	 * 获取定制单的数据
	 */
	function get_one_customize($customize_id){
		$sql = "SELECT c.id  AS c_id,c.endplace,e.id AS e_id,e.status AS e_status,e.supplier_id AS supplier_id,concat_ws('-',s.company_name,s.brand) AS s_name,c.member_id AS member_id,c.addtime  AS addtime,c.startdate AS startdate, c.budget AS budget,
		(SELECT concat_ws('|',st.cityname,st.id)  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace,
		(SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,c.endplace)>0 and de.level=2) AS endplace_two,
		(SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,c.endplace)>0 and de.level=3) AS endplace_three, c.estimatedate AS estimatedate,c.days AS days,c.people AS people,c.childnum AS childnum,c.childnobednum AS childnobednum,c.oldman AS oldman,c.linkname AS linkname,c.linkphone AS linkphone,c.linkweixin AS linkweixin,c.service_range AS service_range,c.custom_type AS custom_type,c.status AS status,c.total_people AS total_people,c.another_choose AS another_choose,c.trip_way AS trip_way,c.roomnum AS roomnum,c.hotelstar AS hotelstar,c.catering AS catering,c.isshopping AS isshopping,c.room_require AS room_require,c.catering AS catering,e.extra AS extra FROM u_customize AS c LEFT JOIN u_enquiry AS e ON c.id=e.customize_id LEFT JOIN u_supplier AS s ON s.id=e.supplier_id WHERE c.id={$customize_id}";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
	}

	/**
	 * 汪晓烽
	 * 获取已经回复了的供应商方案
	 * $customize_id, 定制单ID
	 * $expert_id  管家ID
	 * @return [type] [description]
	 */
	function get_supplier_reply($customize_id, $expert_id){
		$sql = "SELECT eg.id AS eg_id,eg.isuse AS isuse,eg.title AS eg_title,eg.price AS price,eg.childprice AS childprice,eg.childnobedprice AS childnobedprice,eg.oldprice AS oldprice,CONCAT(s.company_name,s.brand) AS brand,s.linkman AS linkman,s.link_mobile AS link_mobile,s.realname AS realname,s.mobile AS mobile,ca.enquiry_grab_id AS c_eg_id,ca.status AS ca_status FROM u_customize AS c LEFT JOIN u_enquiry AS e ON (c.id=e.customize_id AND e.expert_id={$expert_id}) LEFT JOIN u_enquiry_grab AS eg ON e.id=eg.enquiry_id LEFT JOIN u_supplier AS s ON eg.supplier_id=s.id LEFT JOIN u_customize_answer as ca on eg.id=ca.enquiry_grab_id WHERE c.id={$customize_id}";
		  $query = $this->db->query($sql);
		  $result=$query->result_array();
		  return $result;
	}

	/**
	 * 供应商回复方案的详情
	 * $eg_id 询价单ID
	 * [get_supplier_reply_detail description]
	 * @return [type] [description]
	 */
	function get_supplier_reply_detail($eg_id){
	$sql = "SELECT eg.id AS eg_id,ej.id,ej.day AS day,ej.title AS title,ej.transport AS transport,ej.breakfirsthas AS breakfirsthas,ej.breakfirst AS breakfirst, ej.lunchhas AS lunchhas,ej.lunch AS lunch,ej.supperhas AS supperhas,ej.supper AS supper,ej.hotel AS hotel, ej.jieshao AS jieshao,ej.pic AS c_pic FROM u_enquiry_jieshao AS ej LEFT JOIN u_enquiry_grab AS eg ON ej.enquiry_grab_id=eg.id WHERE eg.id={$eg_id} order by day ASC";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}


	function is_choose_supply($customize_id){
		$sql = 'SELECT group_concat(id) AS ca_id,group_concat(enquiry_grab_id) AS s_reply_id FROM u_customize_answer WHERE customize_id='.$customize_id.' AND enquiry_grab_id!=0';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result[0]['ca_id'])){
		  $id_arr['s_reply_id'] = explode(',', $result[0]['s_reply_id']);
		  $id_arr['s_ca_id'] = explode(',', $result[0]['ca_id']);
		  return $id_arr;
		}else{
		   $id_arr['s_reply_id'] = array();
		   $id_arr['s_ca_id'] = array();
		   return $id_arr;
		}


	}
	/**
	 * [insert_reply_from_supplier 从供应商那里获取回复方案插入到管家这里]
	 * @param  [type] $eg_id [description]
	 * @return [type]        [description]
	 */
	function insert_reply_from_supplier($insert_data,$enquiry_grab_id){
		$sql="select title from u_enquiry_grab where id=".$enquiry_grab_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$insert_data['title'] = $result[0]['title'];
		$this ->db ->insert('u_customize_answer',$insert_data);
		$customize_answer_id = $this->db->insert_id();
		$get_data_sql = 'SELECT * FROM u_enquiry_jieshao WHERE id='.$enquiry_grab_id;
		$data_query = $this->db->query($get_data_sql);
		$data_result=$data_query->result_array();
		$data_count = count($data_result);
		for ($i=0; $i < $data_count; $i++) {
			$insert_js_data['customize_answer_id'] =  $customize_answer_id;
			$insert_js_data['day'] =  $data_result[$i]['day'];
			$insert_js_data['title'] =  $data_result[$i]['title'];
			$insert_js_data['breakfirsthas'] =  $data_result[$i]['breakfirsthas'];
			$insert_js_data['breakfirst'] =  $data_result[$i]['breakfirst'];
			$insert_js_data['transport'] =  $data_result[$i]['transport'];
			$insert_js_data['hotel'] =  $data_result[$i]['hotel'];
			$insert_js_data['jieshao'] =  $data_result[$i]['jieshao'];
			$insert_js_data['lunchhas'] =  $data_result[$i]['lunchhas'];
			$insert_js_data['lunch'] =  $data_result[$i]['lunch'];
			$insert_js_data['supperhas'] =  $data_result[$i]['supperhas'];
			$insert_js_data['supper'] =  $data_result[$i]['supper'];
			$this ->db ->insert('u_customize_jieshao',$insert_js_data);
			$jieshao_id = $this->db->insert_id();
			$insert_pic_data['customize_jieshao_id'] = $jieshao_id;
			$insert_pic_data['pic'] = $data_result[$i]['pic'];
			$insert_pic_data['addtime'] = date('Y-m-d H:i:s');
			$this ->db ->insert('u_customize_jieshao_pic',$insert_pic_data);
		}
	}

	/**
	 * [del_supplier_reply 去掉选中的供应商方案]
	 * @param  [type] $ca_id [description]
	 * @return [type]        [description]
	 */
	function update_supplier_reply($ca_id,$is_submit=false){
		if($is_submit){
			 $sql = 'update u_customize_answer set status=if(status=0,1,0) where id='.$ca_id;
		}else{
			$sql = 'update u_customize_answer set status=if(status=0,1,0),replytime='.date('Y-m-d H:i:s').' where id='.$ca_id;
		}
		$status = $this->db->query($sql);
		return $status;
	}

	/**
	 * [get_expert_custom 转询价单的时候获取管家修改过的定制信息]
	 * @param  [type] $customize_id [description]
	 * @param  [type] $expert_id    [description]
	 * @return [type]               [description]
	 */
	function get_expert_custom($enquiry_id){
		$sql = "SELECT c.id  AS c_expert_id,c.endplace,e.id AS e_id,e.status AS e_status,e.supplier_id AS supplier_id,s.company_name AS s_name,c.addtime  AS addtime,c.startdate AS startdate, c.budget AS budget,(SELECT concat_ws('|',st.cityname,st.id)  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace,(SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,c.endplace)>0 and de.level=2) AS endplace_two,(SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,c.endplace)>0 and de.level=3) AS endplace_three,c.estimatedate AS estimatedate,c.days AS days,c.people AS people,c.childnum AS childnum,c.childnobednum AS childnobednum,c.oldman AS oldman,c.service_range AS service_range,c.custom_type AS custom_type,c.total_people AS total_people,c.another_choose AS another_choose,c.trip_way AS trip_way,c.roomnum AS roomnum,c.hotelstar AS hotelstar,c.catering AS catering,c.isshopping AS isshopping,c.room_require AS room_require FROM u_customize_expert AS c LEFT JOIN u_enquiry AS e ON c.customize_id=e.customize_id LEFT JOIN u_supplier AS s ON s.id=e.supplier_id WHERE c.enquiry_id={$enquiry_id}";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;

	}
	/**
	 * [update_custom 更新定制单的数据]
	 * @param  [type] $update_arr   [description]
	 * @param  [type] $customize_id [description]
	 * @return [type]               [description]
	 */
	function update_custom($update_arr,$customize_id,$expert_id,$expert_c_id){
		/*$get_start_place_sql = 'select cityname from u_startplace WHERE id='.$update_arr['startplace'];
		$query = $this->db->query($get_start_place_sql);
		$startplace=$query->result_array();
		$get_end_place_sql = 'SELECT GROUP_CONCAT(kindname) AS dest_name FROM u_dest_base WHERE id IN ('.$update_arr['endplace'].')';
		$query = $this->db->query($get_end_place_sql);
		$endplace=$query->result_array();
		$update_arr['question'] = $startplace[0]['cityname'].' 到 '.$endplace[0]['dest_name'].$update_arr['days'].' 日游';*/
		$update_arr['question'] = "转询价单";
		if(!empty($expert_c_id) && $expert_c_id!=-1){
			$this ->db ->update('u_customize_expert',$update_arr,array('id'=>$expert_c_id));
			return -1;
		}else{
			$this ->db ->insert('u_customize_expert',$update_arr);
			return $this->db->insert_id();
		}
	}
	/**
	 * 获取管家报价,回复方案的价格
	 */
	function get_expert_price($ca_id){
		$sql = "SELECT ca.id AS  ca_id,ca.title AS ca_title,ca.price AS price,ca.childprice AS childprice,ca.childnobedprice AS childnobedprice,ca.oldprice AS oldprice,ca.price_description,ca.plan_design,ca.attachment FROM  u_customize_answer AS ca WHERE ca.id=$ca_id";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	/**
	 * 获取管家报价,转询价单的价格
	 */
	function get_enqury_price($e_id){
		$sql = "SELECT ue.id AS  e_id,ue.price AS price,ue.childprice AS childprice,ue.childnobedprice AS childnobedprice,ue.oldprice AS oldprice,ca.title AS ca_title,ca.price_description,ca.plan_design,ca.attachment FROM  u_enquiry AS ue LEFT JOIN u_customize_answer AS ca on ue.customize_answer_id=ca.id WHERE ue.id=$e_id";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	/**
	 * 选择一个供应商的方案作为询价单的已中标方案
	 * [choose_supplier description]
	 * @param  [type] $eg_id [description]
	 * @return [type]        [description]
	 */
	function choose_supplier($eg_id){
		$get_supplier_price_sql = "SELECT enquiry_id AS eid,supplier_id,childprice,childnobedprice,price,oldprice FROM u_enquiry_grab WHERE id={$eg_id}";
		$query = $this->db->query($get_supplier_price_sql);
		$get_supplier_price_res=$query->result_array();
		$update_sql = "UPDATE u_enquiry SET STATUS=3,is_assign=1,price={$get_supplier_price_res[0]['price']},childprice={$get_supplier_price_res[0]['childprice']},childnobedprice={$get_supplier_price_res[0]['childnobedprice']},oldprice={$get_supplier_price_res[0]['oldprice']},supplier_id={$get_supplier_price_res[0]['supplier_id']} WHERE id={$get_supplier_price_res[0]['eid']}";
		$this->db->query($update_sql);
		$update_sql2 = "UPDATE u_enquiry_grab SET isuse=1 WHERE id=".$eg_id;
		$this->db->query($update_sql2);
		$this->db->close();
	}
	/**
	 * 获取定制单行程数据
	 */
	function get_customize_trip($whereArr, $page = 1, $num = 10){
		$this->db->select(
                      	"ca.id AS ca_id,
                      	ca.replytime AS replytime,
                      	ca.enquiry_grab_id AS eg_id,
                      	ca.title AS ca_title,
                      	eg.title AS eg_title,
                      	cj.id AS cj_id,
                      	cjp.id AS cjp_id,
                      	cj.title AS cj_title,
                      	cj.jieshao AS cj_jieshao,
                      	cjp.pic AS c_pic,
                      	cj.day AS cj_day,
                      	cj.breakfirsthas AS breakfirsthas,
                      	cj.breakfirst AS breakfirst,
                      	cj.lunchhas AS lunchhas,
                      	cj.lunch AS lunch,
                      	cj.supperhas AS supperhas,
                      	cj.supper AS supper,
                      	cj.transport AS transport,
                      	cj.hotel AS hotel
		"
               );
	 $this->db->where($whereArr);
	 $this->db->join('u_customize_answer AS ca','cj.customize_answer_id=ca.id','left');
	 $this->db->join('u_customize_jieshao_pic AS cjp','cj.id=cjp.customize_jieshao_id','left');
	 $this->db->join('u_enquiry_grab AS eg','ca.enquiry_grab_id=eg.id','left');
	 $this->db->from('u_customize_jieshao AS cj');
	 $this->db->order_by('cj_day','ASC');
	$result=$this->db->get()->result_array();
	array_walk($result, array($this, '_fetch_list'));
	return $result;
	}



	/**
	 * [get_msg_template 获取发短信的时候获取短信模版]
	 * @param  [type] $msgtype  [模版类型]
	 * @param  [type] $nickname [用户昵称]
	 * @return [type]           [返回一个string类型]
	 */
	function get_msg_template($msgtype,$nickname){
		$message = "";
		$sql = "SELECT msg FROM u_sms_template WHERE msgtype='{$msgtype}'";;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$message = str_replace('{#NAME#}', $nickname, $result[0]['msg']);
		return $message;
	}
	/**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	 protected function _fetch_list(&$value, $key) {
		if(isset($value['c_pic'])&&$value['c_pic']!=''){
			$c_pic = trim($value['c_pic'], ';');
			$pic_arr = explode(';', $c_pic);
			$value['pic_arr'] = $pic_arr;
		}else{
			$value['pic_arr'] = array();
		}
		if(isset($value['c_id'])&&$value['c_id']!=''){
			//启用session
			$this->load->library('session');
			$expert_id=$this->session->userdata('expert_id');

			$sql = 'SELECT ca.isuse,ca.id AS ca_id,ca.replytime,ca.isuse FROM u_customize_answer AS ca LEFT JOIN u_customize AS c ON ca.customize_id=c.id WHERE ISNULL(ca.replytime)=0 AND c.id='.$value['c_id'].' AND ca.expert_id='.$expert_id;
			$query = $this->db->query($sql);
			$res=$query->result_array();
			$value['plan'] = $res;
		}
	}

}
