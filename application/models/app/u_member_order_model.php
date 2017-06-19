<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月23日11:59:53
 * @author		汪晓烽
 *
 */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_member_order_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'u_member_order' );
	}
	/**
	 * @method 下载合同,获取订单及线路信息
	 * @param unknown $orderId 订单ID
	 * @param intval $mid 用户ID
	 */
	public function getOrderLine($orderId ,$mid)
	{
		$sql = 'select mo.id,mo.usedate,mo.ordersn,mo.confirmtime_supplier,mo.settlement_price,mo.price,mo.childprice,mo.suitnum,mo.childnobedprice,mo.oldprice,mo.dingnum,mo.jifenprice,mo.couponprice,mo.childnum,mo.childnobednum,mo.oldnum,mo.suitid,mo.total_price,mo.linkmobile,mo.linkemail,mo.isbuy_insurance,l.feenotinclude,l.lineday,l.linenight,l.overcity,l.linename,s.linkman as supplier_name,c.name as country,p.name as province,a.name as city,s.company_name,s.link_mobile as supplier_mobile,s.brand,s.email as supplier_email,s.licence_img_code,s.kind,od.addtime as paytime,od.pay_way,ls.unit from u_member_order as mo left join u_line as l on l.id=mo.productautoid left join u_supplier as s on s.id=mo.supplier_id left join u_order_detail as od on od.order_id = mo.id left join u_area as c on c.id = s.country left join u_area as p on p.id=s.province left join u_area as a on a.id=s.city left join u_line_suit as ls on ls.id=mo.suitid where mo.id='.$orderId.' and mo.memberid='.$mid;
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 订单的第一个出游人信息，用于合同下载
	 * @param unknown $orderId 订单ID
	 */
	public function getOrderTraver($orderId)
	{
		$sql = 'select mt.* from u_member_traver as mt left join u_member_order_man as om on mt.id=om.traver_id where om.order_id ='.$orderId.' order by om.id asc limit 1';
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 获取订单的保险，用于合同下载
	 * @param unknown $orderId
	 */
	public function getOrderInsurance($orderId)
	{
		$sql = 'select ti.insurance_name from u_order_insurance as oi left join u_travel_insurance as ti on ti.id=oi.insurance_id where oi.order_id='.$orderId;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 会员下单
	 * @param unknown $orderArr  订单信息
	 * @param unknown $traverArr  出游人信息
	 * @param unknown $insuranceArr  保险信息
	 * @param unknown $jifen  使用的积分
	 * @param intval  $member_coupon_id  用户关联优惠券的ID
	 */
	function userCreateOrder($orderArr ,$traverArr ,$insuranceArr ,$jifen ,$member_coupon_id) {
		$this->db->trans_start();
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		//写入订单
		$this ->db ->insert('u_member_order' ,$orderArr);
		$order_id = $this ->db ->insert_id();
		
		$this->order_status_model->update_order_status_cal($order_id);
		//写入订单日志表
		$logArr = array(
				'order_id' =>$order_id,
				'op_type' => 0,
				'userid' =>$orderArr['memberid'],
				'content' =>'用户自己下单',
				'addtime' => $time
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//会员积分更改
		if (!empty($jifen)) {
			$sql = 'select jifen from u_member where mid = '.$orderArr['memberid'].' for update';
			$memberData = $this ->db ->query($sql) ->result_array();
			$sql = 'update u_member set jifen = jifen -'.$jifen.' where mid = '.$orderArr['memberid'];
			$this ->db ->query($sql);
			//写入会员积分变动表
			$pointArr = array(
					'member_id' =>$orderArr['memberid'],
					'point_before' =>$memberData[0]['jifen'],
					'point_after' =>$memberData[0]['jifen'] - $jifen,
					'point' =>$jifen,
					'content' =>'下单支付积分',
					'addtime' =>$time
			);
			$this ->db ->insert('u_member_point_log' ,$pointArr);
		}
		//更改优惠券状态
		if ($member_coupon_id > 0)
		{
			$sql = 'update cou_member_coupon set status = 1 where id ='.$member_coupon_id;
			$this ->db ->query($sql);
		}
		
		//写入出游人表
		foreach($traverArr as $val) {
			$val['member_id'] = $orderArr['memberid'];
			$this ->db ->insert('u_member_traver' ,$val);
			$traverId = $this ->db ->insert_id();
			//出游人，订单关联表
			$orderManArr = array(
					'order_id' =>$order_id,
					'traver_id' =>$traverId
			);
			$this ->db ->insert('u_member_order_man' ,$orderManArr);
			//出游人保险表
			if (!empty($insuranceArr))
			{
				foreach($insuranceArr as $val)
				{
					$itArr = array(
							'order_id' =>$order_id,
							'traver_id' =>$traverId,
							'insurance_id' =>$val['insurance_id'],
							'is_down' =>0
					);
					$this ->db ->insert('u_insurance_traver' ,$itArr);
				}
			}
		}
		//写入保险表
		if (!empty($insuranceArr)) {
			foreach($insuranceArr as &$val) {
				$val['order_id'] = $order_id;
				$this ->db ->insert('u_order_insurance' ,$val);
			}
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return $order_id;
		}
	}
	/**
	 * @method 获取订单关联发票信息
	 * @param unknown $orderid
	 */
	public function getOrderInvoice($orderid)
	{
		$sql = 'select * from u_member_order_invoice where order_id='.$orderid;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 订单发票
	 * @author jiakairong
	 * @since  2015-11-25
	 * @param unknown $invoiceArr
	 * @param unknown $orderid
	 */
	public function orderInvoiceInsert($invoiceArr ,$orderid)
	{
		$this->db->trans_start();
		//更改订单的发票状态
		$sql = 'update u_member_order set isneedpiao = 1 where id='.$orderid;
		$this ->db ->query($sql);
		//写入发票信息表
		$this ->db ->insert('u_member_invoice' ,$invoiceArr);
		$invoiceid = $this ->db ->insert_id();
		//写入订单发票关联表
		$oiArr = array(
				'order_id' =>$orderid,
				'invoice_id' =>$invoiceid
		);
		$this ->db ->insert('u_member_order_invoice' ,$oiArr);
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * @method 会员支付，更改订单状态
	 * @param unknown $userid  会员ID
	 * @param unknown $detailArr 付款详情信息
	 */
	public function orderPay($userid ,$detailArr)
	{
		$this->db->trans_start();
		//更改订单付款状态
		$sql = 'update u_member_order set ispay = 1,first_pay='.$detailArr['amount'].',final_pay=0 where id = '.$detailArr['order_id'];
		$this ->db ->query($sql);
		//写入订单日志
		$logArr = array(
				'order_id' =>$detailArr['order_id'],
				'op_type' =>0,
				'userid' =>$userid,
				'content' =>'会员自己付款',
				'addtime' =>$detailArr['addtime']
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//写入付款详情表
		$this ->db ->insert('u_order_detail' ,$detailArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 订单改团，支付差价
	 * @param  $userid 会员ID
	 * @param  $detailArr 付款信息
	 */
	public function orderPayFinal($userid ,$detailArr)
	{
		$this->db->trans_start();
		//更改订单付款状态
		$sql = 'update u_member_order set final_pay='.$detailArr['amount'].' where id = '.$detailArr['order_id'];
		$this ->db ->query($sql);
		//写入订单日志
		$logArr = array(
				'order_id' =>$detailArr['order_id'],
				'op_type' =>0,
				'userid' =>$userid,
				'content' =>'订单改团，支付差价',
				'addtime' =>$detailArr['addtime']
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//写入付款详情表
		$this ->db ->insert('u_order_detail' ,$detailArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	//获得所有的线路订单
	function get_all_line_order($whereArr, $page = 1, $num = 10){
		$this->db->select('
				mb_od.id AS order_id,
				mb_od.supplier_id as supplier_id ,
				l.linename,
				l.overcity,
				ls.unit,
				mb_od.ordersn AS order_sn,
				mb_od.memberid AS member_sn,
				mb_od.productname AS product_title,
				(mb_od.dingnum+mb_od.childnum+mb_od.childnobednum+mb_od.oldnum) AS people_num,
				mb_od.total_price AS order_amount,
				mb_od.usedate AS usedate,
				mb_od.status as status,
				mb_od.ispay,
				mb_od.dingnum,
				mb_od.settlement_price,
				mb_od.diff_price,
				mb_od.addtime AS addtime,
				mb_od.productautoid as line_id,
				mb_od.expert_id as expert_id,
				mb_od.linkmobile as mobile,
				mb_od.trun_status,
				 mb.mobile as m_mobile,
				 co.id as commentid');
		$this->db->from('u_member_order AS mb_od');
		$this->db->join('u_member AS mb', 'mb_od.memberid = mb.mid', 'left');
		$this->db->join('u_line AS l', 'mb_od.productautoid = l.id', 'left');
		$this->db->join('u_order_detail AS or_de', 'or_de.order_id = mb_od.id', 'left');
		$this->db->join('u_line_suit AS ls', 'ls.id = mb_od.suitid', 'left');
		$this->db->join('u_comment AS co', 'mb_od.id = co.orderid and co.status=1', 'left');
		$this->db->where($whereArr);
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
        		$this->db->order_by('mb_od.addtime DESC,mb_od.status asc');
        		$this->db->group_by('mb_od.id');
		$query = $this->db->get();
		//print_r($this->session->userdata('userid'));exit();
		$ret_arr = array();
		$ret_arr = $query->result_array();
		array_walk($ret_arr, array($this, '_fetch_list'));

		return $ret_arr;
	}


	//进度追踪
	function get_progress_tracking($order_id){
		$this->db->select("id,addtime,content");
		$this->db->from("u_member_order_log");
		$where['order_id'] = $order_id;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;
	}

	//联系人信息
	function get_contact($order_id){
		$this->db->select("id,linkman,linkmobile ,linktel,linkemail AS 'E-mail'");
		$this->db->from("u_member_order");
		$where['id'] = $order_id;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;

	}

	//出游人信息
	function get_travel($order_id){
		$this->db->select("mt.id,mt.name,dict.description as certificate_type,mt.certificate_no,
		mt.endtime,mt.country ,mt.telephone ,mt.sex,mt.enname,mt.sign_place,mt.sign_time,
		mt.birthday");
		$this->db->from("u_member_traver AS mt");
		$this->db->join('u_member_order_man AS mom','mt.id=mom.traver_id','left');
		$this->db->join('u_dictionary AS dict','dict.dict_id=mt.certificate_type','left');
		$where['mom.order_id'] = $order_id;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;

	}

	//修改游客信息
	function updata_travel($id,$data){

		$this->db->where('id', $id);
	   $re= $this->db->update('u_member_traver', $data);
	   return $re;

	}
	//发票信息
	function get_invoice($order_id){
		$this->db->select("mi.id,mi.invoice_name ,mi.invoice_detail ,mo.total_price ,mi.telephone,mi.receiver,mi.address");
		$this->db->from("u_member_order_invoice AS moi");
		$this->db->join('u_member_invoice AS mi','moi.invoice_id=mi.id','left');
		$this->db->join('u_member_order AS mo','moi.order_id=mo.id','left');
		$where['mo.id'] = $order_id;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;


	}
	//用户保险
	function get_insurance($order_id){
/* 		$this->db->select("id,sum(num) as mun ,amount as free");
		$this->db->from("u_order_insurance ");
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr; */
		$sql = "select id,sum(amount) as 'amount',order_id from u_order_insurance where order_id=".$order_id;
		return $this ->db ->query($sql) ->result_array();
	}
	//保存发票信息
	function updata_invoice($id,$data){
		$this->db->where('id', $id);
		$re= $this->db->update('u_member_invoice', $data);
		return $re;

	}
	//修改联系人
	function updata_concact($id,$data){
		$this->db->where('id', $id);
		$re= $this->db->update('u_member_order', $data);
		return $re;

	}
	//修改用户积分
	function update_member_jifen($member_id,$jifen){
		$sql = "UPDATE u_member SET jifen = jifen+$jifen WHERE mid= {$member_id}";
		return $this->db->query($sql);
	}
     //会员信息
     function get_member_data($where){
     	$this->db->select("mb.mid,mb.litpic,mb.nickname,mb.truename,mb.mobile,mb.jifen,mb.loginname ");
     	$this->db->from("u_member as mb");
     	$this->db->where($where);
     	$query = $this->db->get();
     	$ret_arr=$query->result_array();
     	return $ret_arr[0];
     }
     //我的消息
     function get_member_message($where){
     	$this->db->select("COUNT(*) as num");
     	$this->db->from(" u_message as me");
     	$this->db->join('u_member as m','me.receipt_id=m.mid','left');
     	$this->db->where($where);
     	$this->db->where(array('me.msg_type'=>0));
     	$query = $this->db->get();
     	$ret_arr=$query->result_array();
     	return $ret_arr[0];
     }
	/**
	 * @param 订单id号 $order_id
	 * @param 操作的内容 $log_content
	 */
	function order_log($order_id,$log_content,$order_status){
		$log_data['order_id'] = $order_id;
		$log_data['op_type'] = 0;
		$log_data['userid'] = $this->session->userdata('c_userid');
		$log_data['content'] = $log_content;
		$log_data['order_status']=$order_status;
		$log_data['addtime'] = date('Y-m-d H:i:s');
		$this->db->insert('u_member_order_log',$log_data);
	}

	//修改游客信息
	function updata_Stock($where,$data){

		$this->db->where($where);
		$re= $this->db->update('u_line_suit_price', $data);
		return $re;

	}



protected function _fetch_list(&$value, $key) {
	switch($value['status']){
		case -4:
			$value['status_opera'] = '-4';
			if($value['ispay']==0){
				$value['status']='已取消';
			}elseif($value['ispay']==4){
				$value['status']='已退订';
			}
			break;
		case -3:
			$value['status_opera'] = '-3';
			$value['status'] = '退订中';
			break;
		case -2:
			$value['status'] = '平台拒绝';
			$value['status_opera'] = '-2';
			break;
		case -1:
			$value['status'] = '供应商拒绝';
			$value['status_opera'] = '-1';
			break;
		case 0:

			$value['status'] = '待留位';
			$value['status_opera'] = '0';
			break;

		case 1:
			$value['status'] = '已留位';
			$value['status_opera'] = '1';
			if($value['ispay']==2){
				if(!empty($value['order_id'])){
				   $refuse_reason = $this->select_refund_reason($value['order_id']);
				}
				if(!empty($refuse_reason)){
					$value['refuse_reason'] =  $refuse_reason['beizhu'];
				}
			}
			break;
		case 2:
			$value['status'] = '待确认收款';
			$value['status_opera'] = '2';
			break;
		case 3:
			$value['status'] = '已支付';
			$value['status_opera'] = '3';
			break;
		case 4:
			$value['status'] = '已确认';
			$value['status_opera'] = '4';
			break;
		case 5:
			$value['status'] = '已出行';
			$value['status_opera'] = '5';
			break;
		case 6:
			$value['status'] = '已点评';
			$value['status_opera'] = '6';
			break;
		case 7:
			$value['status'] = '已投诉';
			$value['status_opera'] = '7';
			break;
		default: $value['status'] = '订单状态';break;
	}

	switch($value['ispay']){
		case 0:
			$date=$this->get_time($value['addtime']);
	/* 		if(!empty($date['time'])){    //订单时间已经超过24小时；
			 	if($date['time']>24 || $value['status']==-4 ){
					//$value['status'] = '已经失效';
			 		$value['status'] = '已取消';
					$value['status_opera'] = '-4';
					$value['ispay'] = '未付款';
					$value['ispay_code']=0;
					break;
				}else{
					$value['ispay'] = '未付款';
					$value['ispay_code']=0;
					break;
				}
			}else */
		/* 	if(strtotime($value['usedate'])<time()){  //出行时间已过期；
				//$value['status'] = '已经失效';
				$value['status'] = '已取消';
				$value['status_opera'] = '-4';
				$value['ispay'] = '未付款';
				$value['ispay_code']=0;
				break;
			}else{ */
				$value['ispay'] = '未付款';
				$value['ispay_code']=0;
				break;
		//	}
		case 1:
			//判断是否退款,退款成功,支付状态为空
			$value['ispay'] = '确认中';
			$value['ispay_code'] = 1;
			break;
		case 2:
			//判断是否退款,退款成功,支付状态为空
			$value['ispay'] = '已付款';
			$value['ispay_code'] = 2;

			break;
		case 3:
			$value['ispay'] = '退款中';
			$value['ispay_code'] = 3;
		break;
		case 4:
			$value['ispay'] = '已退款';
			$value['ispay_code'] = 4;
		break;

		default: $value['ispay'] = '支付状态';$value['ispay_code'] = '';break;
	}

}
	/*
	 * 获取订单信息
	 * 贾开荣
	 */
	public function get_order_data($where) {
		$this ->db ->select('mo.expert_id,mo.status,mo.id,mo.ordersn,mo.addtime,mo.usedate,l.lineday,mo.ispay,mo.first_pay,s.cityname,mo.productname,l.first_pay_rate,mo.linkman,l.overcity,mo.total_price');
		$this ->db ->from('u_member_order as mo');
		$this ->db ->join('u_line as l','l.id = mo.productautoid' ,'left');
		$this ->db ->join('u_startplace as s' ,'l.startcity = s.id' ,'left');
		$this ->db ->where($where);
		$query = $this ->db ->get();
		$data = $query ->result_array();
		if (empty($data))
			return false;
		else
			return $data[0];
	}

	public function get_order_message($where) {
		$this ->db ->select('mo.settlement_price,mo.expert_id,mo.status,mo.suitnum,mo.id,mo.ordersn,mo.addtime,mo.usedate,l.lineday,mo.ispay,mo.first_pay,s.cityname,mo.productname,l.first_pay_rate,mo.linkman,l.overcity,mo.total_price');
		$this ->db ->from('u_member_order as mo');
		$this ->db ->join('u_line as l','l.id = mo.productautoid' ,'left');
		$this ->db ->join('u_startplace as s' ,'l.startcity = s.id' ,'left');
		$this ->db ->where($where);
		$query = $this ->db ->get();
		$data = $query ->result_array();

		array_walk($data, array($this, '_fetch_list'));


		if (empty($data))
			return false;
		else
			return $data[0];
	}
	/**
	 * @method 根据线路的目的地ID获取目的地
	 * @author 贾开荣
	 */
	public function get_dest_line ($overcity) {
		$sql = "select * from u_dest_base where id in ({$overcity})";
		$query = $this ->db ->query($sql);
		$data = $query ->result_array();
		return $data;
	}
	/*
	 * 获取产品信息
	*/
	public function get_product_data($where) {
		$this ->db ->select('mo.id,mo.settlement_price,mo.suitnum,mo.ordersn,ls.unit,ls.suitname,l.id as lineid,mo.jifen,mo.jifenprice,mo.couponprice,mo.addtime ,mo.usedate,s.cityname , mo.productname ,mo.price ,mo.dingnum ,mo.childnum ,mo.childnobednum ,mo.childnobedprice,mo.total_price,mo.childprice ,l.linedocname,l.linedoc,mo.oldnum,mo.oldprice,i.amount,(mo.jifenprice+mo.couponprice) as saveprice,l.overcity');
		$this ->db ->from('u_member_order as mo');
		$this ->db ->join('u_line as l ','mo.productautoid = l.id' ,'left');
		$this ->db ->join('u_startplace as s' ,'l.startcity = s.id' ,'left');
		$this ->db ->join('u_order_insurance as i' ,'i.order_id = mo.id' ,'left');
		$this->db->join('u_line_suit AS ls', 'ls.id = mo.suitid', 'left');
		$this ->db ->where($where);
		$query = $this ->db ->get();
		$data = $query ->result_array();
		if (empty($data))
			return false;
		else
			return $data[0];
	}
	public function select_data($type){
	   	$query = $this->db->query('SELECT dict_id,description FROM  u_dictionary WHERE pid IN (SELECT dict_id FROM  u_dictionary WHERE dict_code ="'.$type.'" ) ORDER BY showorder ASC');
	   	$rows = $query->result_array();
	   	return $rows;
	}
	//查询表的数据
	public function select_table($order_id){
	   	$query = $this->db->query("select r.status from  u_refund AS r where r.order_id=$order_id order by modtime desc limit 1");
	   	$rows = $query->row_array();
	   	return $rows;
	}
	//查询退款被拒绝的理由
	public function select_refund_reason($order_id){
	   	$query = $this->db->query('SELECT r.order_id,r.beizhu FROM u_refund AS r WHERE r.status=2 AND order_id='.$order_id.' order by modtime desc limit 1');
	   	$rows = $query->row_array();
	   	return $rows;
	}
	//查询时间
	public function get_time($data){
	   	$query = $this->db->query('select TIMESTAMPDIFF(HOUR,"'.$data.'",NOW()) as time');
	   	$rows = $query->row_array();
	   	return $rows;
	}
	//修改订单的状态位
	public function updata_order_stutas($where,$data){
	   	 $this->db->where($where);
	     	return   $this->db->update('u_member_order', $data);
	}
	   /**
	    * 订单退款
	    * @param  int      $order_id   订单ID
	    * @param string    $reason     退款原因
	    * @param string    $mobile     用户手机号码
	    * @return bool    
	    */
	   public  function insert_order_refund($order_id,$reason,$mobile,$userid){
		   	$insert_refund_sql = "insert into u_refund(order_id,reason,bankcard,bankname,mobile,modtime,addtime,amount_apply,status,refund_type,refund_id) select $order_id,'$reason',bankcard,bankname,'$mobile',NOW(),NOW(),SUM(amount) AS amount,0,0,'$userid' from u_order_detail where order_id=$order_id";
		    return	$this->db->query($insert_refund_sql);
	   }
	   //查询订单的状态
	   public function select_order_stutas($id){
	   	$query = $this->db->query('select status from u_member_order where id=.'.$id);
	   	$rows = $query->row_array();
	   	return $rows;
	   }
	   //查询单个订单的信息
	   function get_alldata($table,$where){
	   	$this->db->select('*');
	   	$this->db->where($where);
	   	return  $this->db->get($table)->row_array();
	   }
	   //插入表
	   public function insert_tabledata($table,$data){
	   	  $this->db->insert($table, $data);
	   	 return $this->db->insert_id();
	   }
	   public function get_ordermessage($where){
		   	$this ->db ->select('mo.expert_id,l.linename,mo.ordersn,mo.status,mo.id,mo.ordersn,mo.addtime,mo.usedate,l.lineday,mo.ispay,mo.first_pay,mo.productname,l.first_pay_rate,mo.linkman,l.overcity,mo.total_price');
		   	$this ->db ->from('u_member_order as mo');
		   	$this ->db ->join('u_line as l','l.id = mo.productautoid' ,'left');
		   	$this ->db ->where($where);
		   	$query = $this ->db ->get();
		   	return $query ->row_array();

	   }
	   //修改线路评论的数量
	   public function update_comment_count($lineid){
		   	$query = $this->db->query('update u_line set comment_count=comment_count+1 where id='.$lineid);
		   	return $query;
	   }
	   //修改管家评论线路的数量
	   public function update_expert_comment_count($expert_id){
		   	$query = $this->db->query('update u_expert set comment_count=comment_count+1 where id='.$expert_id);
		   	return $query;
	   }

	   //获取线路出发地
	   function  select_startplace($likeArr){
	   	$this->db->select('ls.id,ls.line_id,ls.startplace_id,st.cityname');
	   	$this->db->from('u_line_startplace AS ls ');
	   	$this->db->join('u_startplace AS st','st.id = ls.startplace_id','left');
	   	$this ->db ->where($likeArr);
	   	$query = $this->db->get ();
	   	return $query->result_array ();
	   }

   	  //删除线路评价
	  public  function updata_comment($id,$orderid){
	  	$this->db->trans_start();

	  	//修改评论状态
	  	$this->db->where('id', $id)->update('u_comment', array('status'=>0));

	  	//修改订单状态
	  	$order=$this->db->select('status')->where(array('id'=>$orderid))->get('u_member_order')->row_array();
	  	if(!empty($order)){
	  		if($order['status']==6){
	  			$this->db->where('id', $orderid)->update('u_member_order', array('status'=>5));
	  		}
	  	}
	  	//$member=$this->db->select('*')->from('u_comment') ->where(array('id'=>$id))->get ()->row_array ();
	  	$member = $this->db->query("select c.jifen as cjifen,c.memberid,m.jifen as jifen from u_comment as c left join u_member as m on c.memberid=m.mid where c.id={$id}")->row_array ();
	  	//回滚积分
	  	$integral='-'.$member['cjifen'];
	  	$jifenArr['member_id']=$member['memberid'];
		$jifenArr['point_before']=$member['jifen'];
		$jifenArr['point_after']=$member['jifen']+$integral;
		$jifenArr['point']=$member['cjifen'];
		$jifenArr['content']='删除评论减去的积分';
		$jifenArr['addtime']=date('Y-m-d H:i:s',time());
		$this->db->insert('u_member_point_log',$jifenArr);

		//减去用户积分
		$sql = "UPDATE u_member SET jifen = jifen-{$member['cjifen']} WHERE mid= {$member['memberid']}";
	          $this->db->query($sql);		

  		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			return true;
		}	

	  }
	 //查询今天的订单评价表
	  function get_today_complain($order_id){
	  	$date=date('Y-m-d',time());
	  	$query = $this->db->query("SELECT id from u_complain where  date_format(addtime ,'%Y-%m-%d')='{$date}' and order_id={$order_id}");
		$rows = $query->row_array();
	   	return $rows;
	  } 

}

