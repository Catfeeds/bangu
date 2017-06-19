<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Finance_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_order_detail';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取订单收款记录
	 * @author 贾开荣
	 * @since  2015-06-11
	 * @param array $whereArr 查询条件
	 * @param intval $number 每页条数
	 * @param intval $page_new 第几页
	 * @param intval $is_page 是否分页，主要用于统计条数
	 * @param array  $order_by 排序
	 */
	public function get_order_detail_data($whereArr ,$number = 10 ,$page_new = 1 ,$like = array() ,$is_page = 1 ,$order_by = array()) {
		$datafield = "od.bankname,od.id,od.receipt_pic,od.receipt,od.addtime,od.amount,od.approvetime,od.status,od.beizhu,od.refuse_reason,od.bankcard,mo.id as moid,mo.ordersn,mo.productname,sp.cityname,m.truename,mo.supplier_name,mo.expert_name,a.username,m.mobile as tel";
		$this->db->select ( $datafield );
		$this->db->from ( $this->table_name . ' as od' );
		$this->db->join ( 'u_member_order AS mo', 'mo.id = od.order_id', 'left' );
		$this->db->join ( 'u_line AS l', 'mo.productautoid = l.id', 'left' );
		$this->db->join ( 'u_startplace AS sp', 'l.startcity = sp.id', 'left' );
		$this->db->join ( 'u_member AS m', 'mo.memberid = m.mid', 'left' );
		$this ->db ->join( 'u_admin as a' ,'od.admin_id = a.id' ,'left' );
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->like($key,$val);
			}
		}
		if (!empty($order_by) && is_array($order_by)) {
			foreach($order_by as $key =>$val) {
				$this ->db ->order_by($key ,$val);
			}
		}
		if ($is_page == 1) {
			$number = empty ( $number ) ? 10 : $number;
			$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
			$this->db->limit ( $number, $offset );
		}
		$query = $this->db->get ();
		//echo $this ->db ->last_query();exit;
		return $query->result_array ();
	}
	/**
	 * 新增退款的订单列表
	 */

	public function get_apply_order($whereArr, $page = 1, $num = 10, $like = array()) {
		$datafield = "mo.ordersn, mo.id,productname,mo.addtime, (mo.first_pay+mo.final_pay) as money,m.truename,mo.supplier_name,usedate,(mo.dingnum+mo.childnum+mo.oldnum) as number";
		$this->db->select ( $datafield );
		$this->db->from ( 'u_member_order as mo' );
		$this->db->join ( 'u_member as m', 'mo.memberid = m.mid', 'left' );
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->like($key,$val);
			}
		}
		$this->db->order_by("mo.id", "desc");
		$number = empty ( $num ) ? 10 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$this->db->limit ( $num, $offset );
		$query = $this->db->get ();

		//echo $this ->db ->last_query();exit;
		return $query->result_array ();
	}

	public function get_apply_order_count($whereArr,$like = array()) {
		$datafield = "mo.id";
		$this->db->select ( $datafield );
		$this->db->from ( 'u_member_order as mo' );
		$this->db->join ( 'u_member as m', 'mo.memberid = m.mid', 'left' );
		$this->db->where ( $whereArr );
		//多条件模糊搜索查询
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->like($key,$val);
			}
		}
		$query = $this ->db ->get();
		return $query->num_rows();
	}


/**
 * 获取专家订单数据
 * @author 汪晓烽
 */
	function expert_month_account_list($whereArr, $page = 1, $num = 10,$status=0){
			$this->db->select("	ZJJS.id as id,
						ZJJS.userid  AS userid,
						mb_od.ordersn AS ordersn,
						ZJJS.startdatetime AS startdatetime,
						 ZJJS.enddatetime AS enddatetime,
						 ZJJS.addtime AS addtime,
						 ZJJS.amount AS amount,
 						ZJJS.real_amount AS real_amount,
 						ex.realname AS realname,
 						ZJJS.beizhu AS  beizhu,
 						ad.realname AS realname_operator");
			$whereArr['ZJJS.status'] = $status;
			$whereArr['ZJJS.account_type'] = 1;
			$this->db->from("u_month_account AS ZJJS");
			$this->db->join('u_month_account_order AS JSXD','ZJJS.id = JSXD.month_account_id','left');
			$this->db->join('u_member_order AS mb_od','JSXD.order_id=mb_od.id','left');
			$this->db->join('u_expert AS ex','mb_od.expert_id = ex.id','left');
			$this->db->join('u_admin AS ad','ZJJS.admin_id = ad.id','left');
			$this->db->where($whereArr);
			$this->db->group_by('id');
			$this->db->order_by ( "ZJJS.id", "desc" );
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}
			$result=$this->db->get()->result_array();
			return $result;

	}

/**
 * 获取供应商账单数据
 * @author 汪晓烽
 */

	function supplier_month_account_list($whereArr, $page = 1, $num = 10,$status=0){

  		 $this->db->select("
  		 			ZJJS.id as id,
  		 			ZJJS.userid  AS userid,
  		 			mb_od.ordersn AS ordersn,
  		 			ZJJS.startdatetime AS startdatetime,
  		 			ZJJS.enddatetime AS enddatetime,
					ZJJS.addtime AS addtime,
					ZJJS.modtime AS modtime,
					ZJJS.amount AS amount,
 					real_amount AS real_amount,
 					sup.company_name AS company_name,
 					sup.brand AS brand,
 					ZJJS.beizhu AS  beizhu,
 					ad.realname AS realname");
			$whereArr['ZJJS.status'] = $status;
			$whereArr['ZJJS.account_type'] = 2;
			$this->db->from("u_month_account AS ZJJS");
			$this->db->join('u_month_account_order AS JSXD','ZJJS.id = JSXD.month_account_id','left');
			$this->db->join('u_member_order AS mb_od','JSXD.order_id=mb_od.id','left');
			$this->db->join('u_supplier AS sup','mb_od.supplier_id =sup.id','left');
			$this->db->join('u_admin AS ad','ZJJS.admin_id = ad.id','left');
			$this->db->where($whereArr);
			$this->db->group_by('id');
			$this->db->order_by ( "ZJJS.id", "desc" );
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}
			$result=$this->db->get()->result_array();
			//print_r($this->db->last_query());exit();
			return $result;
	}




	/*
	 * 获取详细列表
	 * @author 汪晓烽
	 */
	function get_detail_info($id){
		 $this->db->select("
		 	mo.id AS order_id,
		 	mo.ordersn AS ordersn,
		 	mo.productname AS productname,
		 	(mo.childnum+mo.dingnum+mo.oldnum+mo.childnobednum) AS people_num,
			mo.usedate AS usedate,
			mo.order_price AS order_price,
			mo.total_price AS total_price,
			mo.platform_fee AS platform_fee,
			mo.agent_fee AS agent_fee,
			mo.agent_rate AS agent_rate,
			ma.id AS ma_id,
			mao.id AS mao_id,
			dict.description AS invoice_entity,
			mao.remark AS beizhu
			");
			$whereArr['ma.id'] = $id;
			$this->db->from("u_member_order AS mo");
			$this->db->join('u_month_account_order AS mao','mo.id=mao.order_id','left');
			$this->db->join('u_month_account AS ma','ma.id=mao.month_account_id','left');
			$this->db->join('u_order_detail AS md','mo.id=md.order_id','left');
			$this->db->join('u_dictionary AS dict','md.invoice_entity=dict.dict_id','left');
			$this->db->where($whereArr);
			$this->db->order_by ( "mo.id", "desc" );
			$result=$this->db->get()->result_array();
			return $result;
	}

	/**
	 * [get_sum_price 统计各种价格总金额]
	 * @param  [type] $id [结算表的id字段]
	 * @return [type]     [返回计算出来各种价格总金额]
	 */
	function get_sum_price($id){
		$sum_sql = "SELECT sum(mo.total_price)  AS sum_total_price, (SELECT SUM(rf.amount)  FROM u_refund AS rf  WHERE  rf.order_id = mo.id) AS total_refund_amount,sum(mo.agent_fee)  AS sum_agent_fee, sum(mo.platform_fee) AS sum_platform_price, ma.real_amount AS sum_amount FROM ( u_member_order  AS mo) LEFT JOIN  u_month_account_order  AS mao ON  mo.id = mao.order_id  LEFT JOIN  u_month_account  AS ma ON  ma.id = mao. month_account_id   WHERE  ma.id  = {$id}";
		$result=$this->db->query($sum_sql)->result_array();
		//$sql2 = ""
		$result[0]['sum_total_price'] = $result[0]['sum_total_price']-$result[0]['total_refund_amount'];
		return $result[0];
	}


	function get_account_remark($id){
		$sql = "SELECT remark AS beizhu FROM u_month_account_order WHERE id={$id}";
		$res = $this->db->query($sql)->result_array();
		return $res;
	}
	/**
	 * 获取结算单的创建人数据
	 */
	function get_creator($account_month_id){
		$get_account_type_sql = 'SELECT userid,account_type,bank,bankname,brand,openman FROM u_month_account where id='.$account_month_id;
		$account_res = $this->db->query($get_account_type_sql)->result_array();
		if($account_res[0]['account_type']==1){
			$get_creator_sql = 'SELECT nickname AS creator FROM u_expert WHERE id='.$account_res[0]['userid'];
		}else{
			$get_creator_sql = 'SELECT company_name AS creator  FROM u_supplier WHERE id='.$account_res[0]['userid'];
		}
		$creator_res = $this->db->query($get_creator_sql)->result_array();
		$creator_res[0]['bank'] = $account_res[0]['bank'];
		$creator_res[0]['bankname'] = $account_res[0]['bankname'];
		$creator_res[0]['brand'] = $account_res[0]['brand'];
		$creator_res[0]['openman'] = $account_res[0]['openman'];
		$creator_res[0]['account_type'] = $account_res[0]['account_type'];
		return $creator_res[0];
	}




/**
 * 获取供应商的未结算订单数据
 * @author 汪晓烽
 */
function supplier_unsettled_order($whereArr,$page = 1, $num = 10,$supplier_id,$order_id=array(),$order_status){
			$select_res = "
		 			mo.id AS order_id,
		 			mo.ordersn as ordersn,
					me.truename AS truename,
					mo.productname AS productname,
					(mo.childnum+mo.dingnum+mo.oldnum) AS people_num,
					mo.usedate AS usedate,
					mo.status AS mo_status,
					mo.ispay AS mo_ispay,
					mo.expert_id,
					mo.order_price AS order_price,
					mo.total_price AS total_price,
					mo.agent_fee AS agent_fee,
					mo.agent_rate AS agent_rate,
					e.realname AS 'expert_name',
					mo.addtime AS addtime
			";
	 		if(!empty($order_id)){
				$this->db->where_in('mo.id',$order_id);
	 		}
	 		if($order_status==1){//已出行
				$whereArr['mo.status >='] = 5;
	 		}else if($order_status==2){//已确定
	 			$whereArr['mo.status'] = 4;
	 			$whereArr['mo.ispay'] = 2;
	 		}else if($order_status==3){
	 			$select_res = $select_res.", fu.amount AS real_refund_amount ";
	 			$this->db->join('u_refund AS fu','mo.id=fu.order_id','left');
				$this->db->where(" fu.amount<mo.total_price and fu.status=1 AND mo.status=-4 AND mo.ispay=4",NULL, FALSE);
	 		}
	 		$this->db->select($select_res);


			$whereArr['mo.supplier_id'] = $supplier_id;
			$whereArr['mo.balance_status'] = 0;
			$this->db->where($whereArr);

			$this->db->where(" mo.id not in (SELECT mao.order_id from u_month_account_order AS mao left join u_month_account AS ma on mao.month_account_id=ma.id where ma.userid=$supplier_id AND ma.account_type=2) ",NULL, FALSE);



			$this->db->from("u_member_order AS mo");
			$this->db->join('u_member AS me','mo.memberid=me.mid','left');
			$this->db->join('u_expert AS e','mo.expert_id=e.id','left');




			$this->db->order_by('mo.addtime','DESC');
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}
			$result=$this->db->get()->result_array();
			return $result;
}


/**
 * 增加供应商结算单
 * @author 汪晓烽
 */
	function add_supplier_order($admin_id,$supplier_id,$start_time,$end_time,$biezhu,$order_ids,$order_status,$bank_info=array()){
		$real_amount = 0;
		if($order_status==3){//已退款
			$this->db->select(' sum(total_price) as total_price,sum(agent_fee) as total_agent_fee,sum(platform_fee) AS admin_fee');
			$this->db->from("u_member_order");
			$this->db->where_in('id',$order_ids);
			$total_price = $this->db->get()->result_array();
			$this->db->select(' sum(amount) as total_amount');
			$this->db->from("u_refund");
			$this->db->where_in('order_id',$order_ids);
			$refund_price = $this->db->get()->result_array();
			$real_amount = $total_price[0]['total_price'] - $refund_price[0]['total_amount']-$total_price[0]['total_agent_fee']-$total_price[0]['admin_fee'];
		}else{
			$this->db->select(' sum(total_price) as total_price,sum(agent_fee) as total_agent_fee,sum(platform_fee) AS admin_fee');
			$this->db->from("u_member_order");
			$this->db->where_in('id',$order_ids);
			$total_price = $this->db->get()->result_array();
			$real_amount = $total_price[0]['total_price']-$total_price[0]['total_agent_fee']-$total_price[0]['admin_fee'];
		}
		$insert_data['account_type'] = 2;
		$insert_data['userid'] = $supplier_id;
		$insert_data['amount'] =  $total_price[0]['total_price'];
		$insert_data['before_amount'] = 0;
		$insert_data['after_amount'] = 0;
		$insert_data['addtime'] = date('Y-m-d H:i:s');
		$insert_data['startdatetime'] = $start_time ? $start_time:date('Y-m-d H:i:s');
		$insert_data['enddatetime'] = $end_time ? $end_time : date('Y-m-d H:i:s');
		$insert_data['beizhu'] = $biezhu;
		$insert_data['real_amount'] = $real_amount;
		$insert_data['status'] = 0;
		$insert_data['account_mode'] = '月结';
		$insert_data['admin_id'] = $admin_id;
		$insert_data['openman'] = $bank_info['openman'];
		$insert_data['bank'] = $bank_info['bank'];
		$insert_data['bankname'] = $bank_info['bankname'];
		$insert_data['brand'] = $bank_info['brand'];
		$this->db->insert('u_month_account',$insert_data);
		$insert_id = $this->db->insert_id();
		foreach($order_ids as $key=>$val){
			$insert_data_order['month_account_id'] = $insert_id;
			$insert_data_order['order_id'] = $val;
			$this->db->insert('u_month_account_order',$insert_data_order);
		}
}
	/**
	 * 专家未结算订单数据
	 * @author 汪晓烽
	 */
	function expert_unsettled_order($whereArr,$page = 1, $num = 10,$expert_id, $order_ids=array(),$is_manage=0,$depart_id=0){
		if($page > 0){
			$res_str = "
				mo.id AS order_id,
		 		mo.ordersn as ordersn,
				me.truename AS truename,
				e.realname AS real_name,
				mo.productname AS productname,
				(mo.childnum+mo.dingnum+mo.oldnum+mo.childnobednum) AS people_num,
				mo.usedate AS usedate,
				mo.status,
				mo.expert_id,
				mo.order_price AS order_price,
				mo.total_price AS total_price,
				mo.agent_fee AS agent_fee,
				mo.agent_rate AS agent_rate,
				e.realname AS 'expert_name',
				mo.addtime AS addtime
				";
			}else{
				 $res_str = 'count(*) AS num';
			}

	 		$this->db->select($res_str);
	 		$whereArr['mo.status >='] = 5;
	 		if($is_manage!=1){
	 			$whereArr['mo.expert_id'] = $expert_id;
	 			$whereArr['mo.user_type'] = 0;
	 		}else{
	 			$this->db->where(" FIND_IN_SET($depart_id, e.depart_list) AND mo.user_type=0 ",NULL, FALSE);
	 		}
			$this->db->where($whereArr);
			if(!empty($order_ids)){
				$this->db->where_in('mo.id',$order_ids);
	 		}
			$this->db->where(" mo.id not in (SELECT mao.order_id from u_month_account_order AS mao left join u_month_account AS ma on mao.month_account_id=ma.id where ma.userid=$expert_id AND ma.account_type=1) ",NULL, FALSE);
			$this->db->from("u_member_order AS mo");
			$this->db->join('u_member AS me','mo.memberid=me.mid','left');
			$this->db->join('u_expert AS e','mo.expert_id=e.id','left');
			if ($page > 0) {
				$this->db->order_by('mo.addtime','DESC');
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
				$result=$this->db->get()->result_array();
				return $result;
			}else{
				$query = $this->db->get();
				$ret_arr = $query->result_array();
				return $ret_arr[0]['num'];
			}

	}


	/**
	 * 增加专家结算单
	 * @author 汪晓烽
	 */
	function add_expert_order($admin_id,$expert_id,$start_time,$end_time,$biezhu,$order_ids,$bank_info=array()){
		$this->db->select(' sum(total_price) as total_price,sum(agent_fee) as total_agent_fee,sum(platform_fee) AS admin_fee');
		$this->db->from("u_member_order");
		$this->db->where_in('id',$order_ids);
		$total_price = $this->db->get()->result_array();
		$real_amount = $total_price[0]['total_agent_fee'];
		//$order_id_str = implode(',', $order_ids);
		$insert_data['account_type'] = 1;
		$insert_data['userid'] = $expert_id;
		$insert_data['amount'] =  $total_price[0]['total_price'];
		$insert_data['before_amount'] = 0;
		$insert_data['after_amount'] = 0;
		$insert_data['addtime'] = date('Y-m-d H:i:s');
		$insert_data['startdatetime'] = $start_time ? $start_time:date('Y-m-d H:i:s');
		$insert_data['enddatetime'] = $end_time ? $end_time : date('Y-m-d H:i:s');
		$insert_data['beizhu'] = $biezhu;
		$insert_data['real_amount'] = $real_amount;
		$insert_data['status'] = 0;
		$insert_data['account_mode'] = '月结';
		$insert_data['admin_id'] = $admin_id;

		$insert_data['openman'] = $bank_info['openman'];
		$insert_data['bank'] = $bank_info['bank'];
		$insert_data['bankname'] = $bank_info['bankname'];
		$insert_data['brand'] = $bank_info['brand'];
		$this->db->insert('u_month_account',$insert_data);
		$insert_id = $this->db->insert_id();
		foreach($order_ids as $key=>$val){
			$insert_data_order['month_account_id'] = $insert_id;
			$insert_data_order['order_id'] = $val;
			$this->db->insert('u_month_account_order',$insert_data_order);
		}
		return true;
		/*$this->db->trans_begin();
		$update_amount_sql = "update u_expert set amount=amount+{$real_amount},beizhu='已结算' where id=" . $expert_id;
		$this->db->query ( $update_amount_sql );
		$sql = "update u_month_account set status=1,beizhu='已结算' where id=" . $insert_id;
		$this->db->query ( $sql );
		$settle_sql = "UPDATE u_member_order SET balance_status=2 WHERE id IN($order_id_str)";
		$this->db->query ( $settle_sql );
		if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				return true;
		}else{
				return false;
		}*/
}

/**
 * [get_edit_record 获得修改记录数据]
 * @param  [type] $month_id [description]
 * @return [type]           [description]
 */
function get_edit_record($month_id){
	$get_record_sql = "SELECT mau.*, ad.realname AS ad_name FROM  u_month_account_update_record AS mau left join u_admin AS ad on ad.id=mau.admin_id WHERE mau.month_account_id=$month_id order by mau.id DESC";
	$record_res = $this->db->query($get_record_sql)->result_array();
	return $record_res;
}

/**
 * 下拉选择专家的时候,提供数据
 * @author 汪晓烽
 */
function get_expert(){
	$this->db->select('id,realname');
	$this->db->from("u_expert");
	$this->db->where(array('status'=>0,'status'=>1,'status'=>2));
	return  $this->db->get()->result_array();
}

/**
 * 下拉选择供应商,提供数据
 * @author 汪晓烽
 */
function get_supplier(){
	$this->db->select('id,company_name AS realname');
	$this->db->where(array('status'=>2));
	$this->db->from("u_supplier");
	return  $this->db->get()->result_array();
}
}