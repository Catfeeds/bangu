<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_model extends MY_Model {

	private $table_name = 'u_member_order';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 更改订单应付价格
	 * @param unknown $orderid 订单信息
	 * @param unknown $orderArr 更改信息
	 * @param unknown $yfArr 应付信息
	 */
	public function updateOrderYj($orderid ,$orderArr ,$yjArr ,$logArr)
	{
		$this->db->trans_start();
		//更改订单信息
		$this ->db ->where('id' ,$orderid) ->update('u_member_order' ,$orderArr);
		//写入订单日志
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//写入佣金账单
		$this ->db ->insert('u_order_bill_yj' ,$yjArr);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 更改订单应付价格
	 * @param unknown $orderid 订单信息
	 * @param unknown $orderArr 更改信息
	 * @param unknown $yfArr 应付信息
	 */
	public function updateOrderYf($orderid ,$orderArr ,$yfArr ,$logArr)
	{
		$this->db->trans_start();
		//更改订单信息
		$this ->db ->where('id' ,$orderid) ->update('u_member_order' ,$orderArr);
		//写入订单日志
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//写入应付账单
		$this ->db ->insert('u_order_bill_yf' ,$yfArr);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 更改订单应收价格
	 * @param unknown $orderid 订单信息
	 * @param unknown $orderArr 更改信息
	 * @param unknown $ysArr 应收信息
	 * @param unknown $yjArr 管理费信息
	 */
	public function updateOrderYs($orderid ,$orderArr ,$ysArr ,$yjArr ,$logArr ,$logArr1=array())
	{
		$this->db->trans_start();
		//更改订单信息
		$this ->db ->where('id' ,$orderid) ->update('u_member_order' ,$orderArr);
		//写入订单日志
		$this ->db ->insert('u_member_order_log' ,$logArr);
		if (!empty($logArr1))
		{
			$this ->db ->insert('u_member_order_log' ,$logArr1);
		}
		
		//写入应收账单
		$this ->db ->insert('u_order_bill_ys' ,$ysArr);
		//写入管理费账单
		$this ->db ->insert('u_order_bill_yj' ,$yjArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 外交佣金数据
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getOrderBillWj(array $whereArr=array() ,$orderBy = 'wj.id asc')
	{
		$sql = 'select wj.*,a.username as amdin_name,e.realname as expert_name,be.realname as employee_name,s.linkman as supplier_name from u_order_bill_wj as wj left join u_admin as a on a.id=wj.user_id left join u_expert as e on e.id=wj.user_id left join u_supplier as s on s.id=wj.user_id left join b_employee as be on be.id=wj.user_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 订单收款记录
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getOrderReceivable(array $whereArr=array() ,$orderBy = 'id asc')
	{
		$sql = 'select * from u_order_receivable';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	
	/**
	 * @method 获取订单应付账单
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getBillYfData(array $whereArr=array() ,$orderBy = 'id asc')
	{
		$sql = 'select * from u_order_bill_yf '.$this ->getWhereStr($whereArr).' order by '.$orderBy;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取订单佣金账单
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getBillYjData(array $whereArr=array() ,$orderBy = 'yj.id asc')
	{
		$sql = 'select yj.*,u.union_name from u_order_bill_yj as yj left join b_union as u on u.id = yj.union_id '.$this ->getWhereStr($whereArr).' order by '.$orderBy;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 订单保险账单
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getBillBxData(array $whereArr=array() ,$orderBy = 'bx.id asc')
	{
		$sql = 'select bx.*,u.union_name from u_order_bill_bx as bx left join b_union as u on u.id = bx.belong_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取订单应收账单
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getBillYsData(array $whereArr=array() ,$orderBy = 'ys.id asc')
	{
		$sql = 'select ys.*,e.realname as expert_name from u_order_bill_ys as ys left join u_expert as e on e.id = ys.expert_id '.$this ->getWhereStr($whereArr).' order by '.$orderBy;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取订单操作日志
	 * @author jkr
	 */
	public function getOrderLogData(array $whereArr=array() ,$orderBy = 'log.id asc')
	{
		$sql = 'select log.*,e.realname as expert_name,a.realname as admin_name,be.realname as employee_name,s.company_name as supplier_name,m.truename as username from u_member_order_log as log left join u_expert as e on e.id = log.userid left join u_admin as a on a.id = log.userid left join u_supplier as s on s.id = log.userid left join b_employee as be on be.id = log.userid left join u_member as m on m.mid = log.userid';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取订单出游人
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getOrderNameData(array $whereArr=array() ,$orderBy = 'mt.id asc')
	{
		$sql = 'select mt.*,d.description as certificate_name from u_member_order_man as om left join u_member_traver as mt on om.traver_id = mt.id left join u_dictionary as d on d.dict_id = mt.certificate_type';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取订单信息
	 * @author jkr
	 * @param unknown $orderId
	 */
	public function getOrderRow($orderId)
	{
		$sql = 'select mo.*,e.mobile as expert_mobile,ls.unit,ls.suitname,l.overcity,l.line_kind,l.producttype,oa.spare_mobile,oa.remark as spare_remark from u_member_order as mo left join u_expert as e on e.id = mo.expert_id left join u_line_suit as ls on ls.id = mo.suitid left join u_line as l on l.id = mo.productautoid left join u_member_order_affiliated as oa on oa.order_id=mo.id where mo.id = '.$orderId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取订单已收款金额
	 * @param unknown $orderId
	 */
	public function getOrderBillYs($orderId)
	{
		$sql = 'select sum(money) as amount from u_order_receivable where status=2 and order_id ='.$orderId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	public function getOrderData (array $whereArr ,$orderBy = 'a.id desc',$specialSql='')
	{
		$sql = 'select a.id,a.ordersn,a.productname,a.user_type,a.balance_status,a.supplier_name,a.lefttime,a.confirmtime_admin,a.agent_rate,a.platform_fee,a.settlement_price,a.canceltime,a.status,a.confirmtime_supplier,a.total_price,a.usedate,a.addtime,e.realname as expert_name,a.ispay,a.dingnum,a.childnum,(a.first_pay+a.final_pay) as count_money,a.childnobednum,a.oldnum,group_concat(s.cityname) as cityname,su.unit from u_member_order as a left join u_line as l on l.id = a.productautoid left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as s on s.id= ls.startplace_id left join u_expert as e on e.id = a.expert_id left join u_line_suit as su on su.id = a.suitid ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy,'group by a.id',$specialSql);
	}
	
	/**
	 * @method 获取订单数据,用于退款管理新增订单的选择
	 * @author jiakairong
	 * @since  2015-12-23
	 * @param unknown $whereArr
	 * @param string $orderBy
	 */
	public function getOrderRefundData(array $whereArr ,$orderBy='mo.id desc')
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.' "'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select mo.*,s.cityname from u_member_order as mo left join u_line as l on l.id= mo.productautoid left join u_startplace as s on s.id=l.startcity '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by '.$orderBy.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	
	/**
	 * @method 取消订单
	 * @author jiakairong
	 * @since  2015-12-08
	 * @param unknown $orderid
	 * @param unknown $orderArr
	 * @param unknown $orderData
	 */
	public function cancelOrder($orderid ,$orderArr ,$orderData)
	{
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->db->trans_start();
		//更改订单状态
		$this ->db ->where(array('id' =>$orderid));
		$this ->db ->update('u_member_order' ,$orderArr);
		//订单统计
		$this->order_status_model->update_order_status_cal($orderid);
		//写订单日志
		$logArr = array(
				'order_id' => $orderid,
				'op_type' => 3,
				'userid' => $orderArr['admin_id'],
				'content' => '平台取消订单',
				'addtime' => $orderArr['canceltime']
		);
		$this->db->insert ( 'u_member_order_log', $logArr );
		//若支付积分，则将积分返回给用户
		if ($orderData['jifen'] > 0)
		{
			$sql = 'select jifen from u_member where mid = '.$orderData['memberid'];
			$memberData = $this ->db ->query($sql) ->result_array();
			
			$sql = 'update u_member set jifen=jifen+'.$orderData['jifen'].' where mid ='.$orderData['memberid'];
			$this ->db ->query($sql);
			//写入用户积分记录
			$pointArr = array(
				'member_id' =>$orderData['memberid'],
				'point_before' =>$memberData[0]['jifen'],
				'point_after' =>round($orderData['jifen'] + $memberData[0]['jifen'] ,0),
				'point' =>$orderData['jifen'],
				'content' =>'取消订单，退回积分',
				'addtime' =>$orderArr['canceltime']
			);
			$this ->db ->insert('u_member_point_log',$pointArr);
		}
		
		//取消订单，将余位退回
		$number = round($orderData['dingnum'] + $orderData['childnum'] + $orderData['oldnum']+$orderData['childnobednum'] ,2);
		$sql = 'update u_line_suit_price set number= number+'.$number.' where suitid='.$orderData['suitid'].' and day="'.$orderData['usedate'].'"';
		$this ->db ->query($sql);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	/**
	 * @method  退订订单
	 * @author jiakairong
	 * @since  2015-12-08
	 * @param unknown $orderid
	 * @param unknown $orderArr
	 * @param unknown $orderData
	 * @param unknown $refundArr
	 */
	public function refundOrder($orderid ,$orderArr ,$orderData ,$refundArr) 
	{
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->db->trans_start();
		//更改订单状态
		$this ->db ->where(array('id' =>$orderid));
		$this ->db ->update('u_member_order' ,$orderArr);
		//订单统计
		$this->order_status_model->update_order_status_cal($orderid);
		//写订单日志
		$logArr = array(
				'order_id' => $orderid,
				'op_type' => 3,
				'userid' => $orderArr['admin_id'],
				'content' => '平台退订',
				'addtime' => $orderArr['canceltime'],
				'order_status' =>$orderData['status']
		);
		$this->db->insert ( 'u_member_order_log', $logArr );
		//写入退款表
		$this ->db ->insert('u_refund' ,$refundArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 获取订单详情数据
	 * @author jiakairong
	 * @since  2015-12-08
	 */
	function getOrderDetail($whereArr){
		$this->db->select('mo.*,e.realname AS expert_name,l.lineday,e.mobile AS expert_mobile,s.company_name AS company_name,s.mobile AS telephone,su.unit,su.suitname');
		$this->db->from('u_member_order AS mo');
		$this->db->join('u_expert AS e', 'mo.expert_id=e.id', 'left');
		$this->db->join('u_line_suit AS su', 'mo.suitid=su.id', 'left');
		$this->db->join('u_line AS l', 'mo.productautoid=l.id', 'left');
		$this->db->join('u_supplier AS s', 'mo.supplier_id=s.id', 'left');
		$this->db->where($whereArr);
		return $this->db->get() ->result_array();
	}
	
	/**
	 * 已收款申请的列表数据
	 */
       public function get_apply_application($whereArr, $page = 1, $num = 10){
      	$this->db->select (
      		'mo.id,mo.ordersn,
      		m.nickname AS people,
      		mo.productname AS pro_title,
      		(mo.dingnum+mo.childnum+mo.oldnum) AS people_num,
		mo.total_price AS order_amount,
		(mo.first_pay+mo.final_pay) AS receive_amount,
		mo.supplier_name AS supplier_name,
		mo.expert_name AS expert,
		mo.usedate AS begin_time,
		mo.addtime AS addtime,
		mo.status  AS status'
      		);
      	$whereArr['mo.status'] = 2;
		$this->db->from ( 'u_member_order AS mo');
		$this->db->join ( 'u_member AS m', 'mo.memberid=m.mid', 'left' );
		$this->db->where($whereArr);
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;
       }

 	/**
           * 获取全部供应商
           */

          public function get_suppliers(){
          		$this->db->select('id,realname');
          		$this->db->where(array('status'=>2));
                   $this->db->from('u_supplier');
                   $result=$this->db->get()->result_array();
                   return $result;
          }

       
       /**
        * 订单参团人信息
        */
       function get_order_people($whereArr){
       	$this->db->select('	mt.id AS id,
				mt.name AS m_name,
       			mt.enname,
				mt.certificate_type AS certificate_type,
				mt.certificate_no AS certificate_no,
				mt.endtime AS endtime,
				mt.telephone AS telephone,
				mt.sex AS sex,
				mt.birthday AS birthday,
       			d.description');
       	$this->db->from('u_member_order AS mo');
       	$this->db->join('u_member_order_man AS mom', 'mo.id=mom.order_id', 'left');
       	$this->db->join('u_member_traver AS mt', 'mom.traver_id=mt.id', 'left');
       	$this->db->join('u_dictionary as d','d.dict_id = mt.certificate_type' ,'left');
       	$this->db->where($whereArr);
       	$query = $this->db->get();
       	$result = $query->result_array();
       	return $result;


       }
       /**
        * @method 获取订单的参与者
        */
       function get_order_people_id($where) {
       		$this ->db ->select('expert_id,supplier_id,memberid,ordersn,productname');
       		$this ->db ->from('u_member_order');
       		$this ->db ->where($where);
       		$query = $this->db->get();
       		return $query->result_array();
       }

       /**
        * @method 获取订单对应的结算单
        * @param unknown $orderid
        */
       public function getMonthAccount($orderid)
       {
       		$sql = 'select o.month_account_id,m.account_type from u_month_account_order as o left join u_month_account as m on m.id = o.month_account_id where o.order_id ='.$orderid;
       		return $this ->db ->query($sql) ->result_array();
       }
       
       public function getMonthAccountOrder($ids)
       {
       		$sql = 'select o.total_price,o.agent_fee,o.platform_fee,o.id as order_id,m.month_account_id from u_month_account_order as m left join u_member_order as o on o.id = m.order_id where m.month_account_id in ('.$ids.')';
       		return $this ->db ->query($sql) ->result_array();
       }
}