<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月20日11:59:53
 * @author 何俊      
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Order extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/order_model', 'order_model' );
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
	}
	
	public function index()
	{
		$this->view ( 'admin/a/order/order_list');
	}
	
	/**
	 * @method 订单列表
	 * @author jiakairong
	 * @since  2015-12-04
	 */
	public function getOrderData()
	{
		$postArr = $this->security->xss_clean($_POST);
		$whereArr = array();
		$specialSql = '';
		
		switch ($postArr['status'])
		{
			case 1: //待留位
				$whereArr ['a.status='] = 0;
				$order_by = 'a.id desc';
				break;
			case 2: //已留位
				$whereArr ['a.status='] = 1;
				$order_by = 'a.lefttime desc';
				break;
			case 3: //已确定
				$whereArr ['a.status >='] = 4;
				$whereArr ['a.status <='] = 8;
				$order_by = 'a.id desc';
				break;
			case 4: //已取消
				$whereArr ['a.status='] = -4;
				$whereArr ['a.ispay >='] = 0;
				$whereArr ['a.ispay <='] = 2; 
				$order_by = 'a.canceltime desc';
				break;
			case 5: //退订列表
				$whereArr ['a.status >='] = -4;
				$whereArr ['a.status <='] = -3;
				$whereArr ['a.ispay >='] = 3;
				$whereArr ['a.ispay <='] = 4; 
				$order_by = 'a.canceltime desc';
				break;
			default:
				echo json_encode($this ->defaultArr);exit;
				break;
		}
		//线路名称
		if (!empty($postArr['productname']))
		{
			$whereArr ['a.productname like'] = '%'.trim($postArr['productname']).'%';
		}
		//订单号
		if (!empty($postArr['ordersn']))
		{
			$whereArr ['a.ordersn like'] = '%'.trim($postArr['ordersn']).'%';
		}
		//出团日期
		if (!empty($postArr['starttime']))
		{
			$whereArr ['a.usedate >='] = trim($postArr['starttime']);
		}
		if (!empty($postArr['endtime']))
		{
			$whereArr ['a.usedate <='] = trim($postArr['endtime']);
		}
		//出发城市
		if (!empty($postArr['city']))
		{
			$whereArr ['ls.startplace_id ='] = intval($postArr['city']);
		}
		elseif (!empty($postArr['province']))
		{
			$whereArr ['s.pid='] = intval($postArr['province']);
		}
		//目的地
		if (!empty($postArr['destid']))
		{
			$specialSql = ' find_in_set('.intval($postArr['destid']).' ,l.overcity)';
		}
		elseif (!empty($postArr['kindname']))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$destData = $this ->dest_base_model ->all(array('kindname like' =>'%'.$postArr['kindname'].'%'));
			if (empty($destData))
			{
				echo json_encode($this ->defaultArr);exit;
			}
			else
			{
				$specialSql = ' (';
				foreach($destData as $v)
				{
					$specialSql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$specialSql = rtrim($specialSql ,'or').') ';
			}
		}
		
		//管家
		if (!empty($postArr['expert_id']) && !empty($postArr['expert_name']))
		{
			$whereArr ['a.expert_id ='] = intval($postArr['expert_id']);
		}
		elseif (!empty($postArr['expert_name']))
		{
			$whereArr ['a.expert_name like'] = '%'.trim($postArr['expert_name']).'%';
		}
		//商家
		if (!empty($postArr['supplier_id']) && !empty($postArr['company_name']))
		{
			$whereArr ['a.supplier_id='] = intval($postArr['supplier_id']);
		}
		elseif (!empty($postArr['company_name']))
		{
			$whereArr ['a.supplier_name like'] = '%'.trim($postArr['company_name']).'%';
		}
		
		if ($postArr['user_type'] == 1 || $postArr['user_type'] == 0) 
		{
			$whereArr['a.user_type ='] = $postArr['user_type'];
		}
		
		//获取订单数据数据
		$data = $this ->order_model ->getOrderData($whereArr ,$order_by ,$specialSql);
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}

	public function order_detail_info() 
	{
		$orderId = intval($this ->input ->get('id'));
		$type = intval($this ->input ->get('type'));
		$code = $this ->input ->get('code');
		if (!empty($code)){
			$code_data=$this->db->query("select id from u_coupon_record where code='{$code}' and type=6")->row_array();
			if (!empty($code_data)){
				$order_data=$this->db->query("select id from u_member_order where code_id={$code_data['id']}")->row_array();
				$orderId=$order_data['id'];
			}
		}
		$orderData = $this ->order_model ->getOrderRow($orderId);
		if (empty($orderData))
		{
			echo '<script>alert("订单不存在");window.close();</script>';exit;
		}
		
		$amountArr = $this ->order_model ->getOrderBillYs($orderId);
		
		$dataArr ['orderData'] = $orderData;
		$dataArr ['moneyYs'] = empty($amountArr['amount']) ? 0 : $amountArr['amount'];
		$dataArr ['linetype'] = in_array(1 ,explode(',',$orderData['overcity'])) ? 1 : 2;
		
		
		$whereArr = array(
				'ys.order_id =' =>$orderId
		);
		$dataArr['ysArr'] = $this ->order_model ->getBillYsData($whereArr);
		
		$whereArr = array(
				'order_id =' =>$orderId
		);
		$dataArr['yfArr'] = $this ->order_model ->getBillYfData($whereArr);
		
		$whereArr = array(
				'yj.order_id =' =>$orderId
		);
		$dataArr['yjArr'] = $this ->order_model ->getBillYjData($whereArr);
		
		$dataArr['userType'] = array(0=>'用户',1=>'管家',2=>'供应商',3=>'平台');
		$dataArr['type'] = $type;
		$this->view ( 'admin/a/order/order_detail', $dataArr );
	}
	
	//佣金账单
	public function getBillYjJson()
	{
		$orderId = intval($this ->input ->post('orderId'));
		
		$whereArr = array(
				'yj.order_id =' =>$orderId
		);
		$dataArr = $this ->order_model ->getBillYjData($whereArr);
		echo json_encode($dataArr);
	}
	
	
	//订单保险账单
	public function getBillBxJson()
	{
		$orderId = intval($this ->input ->post('orderId'));
		
		$whereArr = array(
				'bx.order_id =' =>$orderId
		);
		$dataArr = $this ->order_model ->getBillBxData($whereArr);
		echo json_encode($dataArr);
	}
	
	//订单操作日志
	public function getOrderLogJson()
	{
		$orderId = intval($this ->input ->post('orderId'));
		
		$whereArr = array(
				'log.order_id =' =>$orderId
		);
		$dataArr = $this ->order_model ->getOrderLogData($whereArr);
		echo json_encode($dataArr);
	}
	//获取订单出游人
	public function getOrderNameJson()
	{
		$orderId = intval($this ->input ->post('orderId'));
		
		$whereArr = array(
				'om.order_id =' =>$orderId
		);
		$dataArr = $this ->order_model ->getOrderNameData($whereArr);
		echo json_encode($dataArr);
	}
	//订单收款记录
	public function getOrderReceivable()
	{
		$orderId = intval($this ->input ->post('orderId'));
		$whereArr = array(
				'order_id =' =>$orderId,
				'status >=' =>1
		);
		$dataArr = $this ->order_model ->getOrderReceivable($whereArr);
		echo json_encode($dataArr);
	}
	
	//外交佣金账单
	public function getOrderBillWj()
	{
		$orderId = intval($this ->input ->post('orderId'));
		$whereArr = array(
				'order_id =' =>$orderId
		);
		$dataArr = $this ->order_model ->getOrderBillWj($whereArr);
		echo json_encode($dataArr);
	}
	
	/**
	 * @method 新增订单应收
	 * @author jkr
	 * 只能更改C端的订单，并且没有支付，修改后的应收要大于等于应付
	 * 需要同步修改管家佣金 = 应收(更改后的)-应付
	 * 修改平台管理费 = 应收(更改后的) * 收取比例，并写入一条账单
	 * 写入一条应收账单
	 */
	public function addOrderYs()
	{
		$orderid = intval($this ->input ->post('id'));
		$num = intval($this ->input ->post('num'));
		$price = $this ->input ->post('price' ,true);
		$remark = $this ->input ->post('remark' ,true);
		if ($price == 0)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写单价');
		}
		if ($num < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写数量');
		}
		if (empty($remark))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写备注');
		}
		$orderData = $this ->order_model ->row(array('id' =>$orderid));
		//C端下的单，出团前可修改
		if (empty($orderData) || $orderData['user_type'] != 0 || $orderData['status'] > 4)
		{
			$this ->callback ->setJsonCode(4000 ,'订单不存在或没有修改权限');
		}
		//更改的总价格
		$amount = round($price * $num ,2);
		//更改后的应收价格(订单价格)
		$totalPrice = $orderData['total_price']+$amount;
		//管理费
		$fee = round($totalPrice * $orderData['agent_rate'] ,3);
		$adjustment = round($fee - $orderData['platform_fee'],3);
		
		//更改后的管家佣金
		$agentFee = $totalPrice - $orderData['supplier_cost'];
		if ($agentFee < -0.0001)
		{
			$this ->callback ->setJsonCode(4000 ,'应收不可以小于应付');
		}
		
		$time = date('Y-m-d H:i:s' ,time());
		$orderArr = array(
				'total_price' =>round($totalPrice ,'2'),
				'platform_fee' =>$fee,
				'agent_fee' =>round($agentFee ,2)
		);
		$ysArr = array(
				'order_id' =>$orderid,
				'expert_id' =>$orderData['expert_id'],
				'num' =>$num,
				'price' =>$price,
				'amount' =>$amount,
				'remark' =>$remark,
				'status'=> 1,
				'addtime' =>$time,
				'item' =>'平台调整应收价格',
				'user_name' =>$this->realname
		);
		
		$yjArr = array(
				'order_id' =>$orderid,
				'expert_id' =>$orderData['expert_id'],
				'num' =>1,
				'price' =>$adjustment,
				'amount' =>$adjustment,
				'status' =>2,
				'addtime' =>$time,
				'user_type' =>3,
				'user_id' =>$this->admin_id,
				'user_name' =>$this->realname,
				'item' =>'按比例',
				'remark' =>'平台调整应收，同步更改管理费'
		);
		
		$logArr = array(
				'order_id' =>$orderid,
				'op_type' =>3,
				'userid' =>$this ->admin_id,
				'content' =>'平台调整订单应收价格：'.$amount,
				'addtime' =>$time
		);
		$logArr1 = array(
				'order_id' =>$orderid,
				'op_type' =>3,
				'userid' =>$this ->admin_id,
				'content' =>'平台调整订单应收价格，同步更改管家佣金：'.round($agentFee - $orderData['agent_fee'],2).'，同步更改管理费：'.$adjustment,
				'addtime' =>$time,
				'type' =>1
		);
		
		$status = $this ->order_model ->updateOrderYs($orderid ,$orderArr ,$ysArr ,$yjArr ,$logArr ,$logArr1);
		if ($status === false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	/**
	 * @method 添加订单的应付
	 * @author jkr
	 * 应付应当小于等于应收
	 * 应付应当大于等于平台管理费
	 * 更改管家佣金
	 */
	public function addOrderYf()
	{
		$orderid = intval($this ->input ->post('id'));
		$num = intval($this ->input ->post('num'));
		$price = $this ->input ->post('price' ,true);
		$remark = $this ->input ->post('remark' ,true);
		if ($price == 0)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写单价');
		}
		if ($num < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写数量');
		}
		if (empty($remark))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写备注');
		}
		$orderData = $this ->order_model ->row(array('id' =>$orderid));
		//C端下的单，且没有出行才可以修改
		if (empty($orderData) || $orderData['user_type'] != 0 || $orderData['status'] > 4)
		{
			$this ->callback ->setJsonCode(4000 ,'订单不存在或没有修改权限');
		}
		//更改的总价格
		$amount = round($price * $num ,2);
		//更改后的应收价格(供应商成本)
		$cost = $orderData['supplier_cost']+$amount;
		
		//更改后的管家佣金
		$agentFee = $orderData['total_price'] - $cost;
		if ($agentFee < -0.0001)
		{
			$this ->callback ->setJsonCode(4000 ,'应付不可以大于应收');
		}
		
		if ($cost < $orderData['platform_fee'])
		{
			$this ->callback ->setJsonCode(4000 ,'应付不可以小于管理费');
		}
		
		$time = date('Y-m-d H:i:s' ,time());
		$orderArr = array(
				'supplier_cost' =>round($cost ,'2'),
				'agent_fee' =>round($agentFee ,2)
		);
		
		$yfArr = array(
				'order_id' =>$orderid,
				'expert_id' =>$orderData['expert_id'],
				'depart_id' =>$orderData['depart_id'],
				'num' =>$num,
				'price' =>$price,
				'amount' =>$amount,
				'remark' =>$remark,
				'status'=> 2,
				'addtime' =>$time,
				'm_time' =>$time,
				's_time' =>$time,
				'supplier_id' =>$orderData['supplier_id'],
				'user_type' =>3,
				'user_id' =>$this ->admin_id,
				'user_name' =>$this ->realname,
				'item' =>'平台调整应付价格'
		);
		
		$logArr = array(
				'order_id' =>$orderid,
				'op_type' =>3,
				'userid' =>$this ->admin_id,
				'content' =>'平台调整订单应付价格：'.$amount.'，同步更改管家佣金：'.round($agentFee - $orderData['agent_fee'],2),
				'addtime' =>$time,
				'type' =>1
		);
		
		$status = $this ->order_model ->updateOrderYf($orderid ,$orderArr ,$yfArr ,$logArr);
		if ($status === false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	/**
	 * @method 订单详情
	 * @since  2015-12-08
	 */
	function order_detail_info1() {
		$order_id = intval($this->input->get ( 'id' ));
		$orderData = $this ->order_model ->getOrderDetail(array('mo.id' =>$order_id));
		if (empty($orderData)) {
			exit;
		}
		$post_arr = array();
		
		$post_arr['mo.id'] = $order_id;
		$order_people = $this->order_model->get_order_people ( $post_arr );

		$this ->load_model('common/u_member_order_log_model' ,'log_model');
		$logData = $this ->log_model ->get_order_log_data($order_id);
		//发票信息
		$this ->load_model('common/u_member_order_invoice_model','invoice_model');
		$invoiceData = $this ->invoice_model ->getOrderInvoice(array('oi.order_id' =>$order_id));
		if (!empty($invoiceData)) {
			$invoiceData = $invoiceData[0];
		}
		//行程
		$this->load_model ( 'common/u_line_jieshao_model', 'jieshao_model' );
		$jieshaoData = $this->jieshao_model->getLineJieShao (array('lj.lineid' =>$orderData[0]['productautoid']));
		//echo $this ->db ->last_query();
		//保险
		$this->load_model('admin/a/u_order_insurance_model','insurance_model');
		$insuranceData = $this ->insurance_model ->getOrderInsurance(array('oi.order_id' =>$order_id));
		$data = array(
				'order' => $orderData[0],  
				'order_people' => $order_people,
				'logData' =>$logData,
				'invoice' =>$invoiceData,
				'jieshao' =>$jieshaoData,
				'insuranceData' =>$insuranceData
		);
		$this->load->view ( 'admin/a/order/order_detail', $data );
	}
	
	/**
	 *	@method 取消订单
	 *	@author jiakairong
	 *	@since  2015-08-12
	 */
	public function cancel()
	{
		$id = intval($this ->input ->post('id'));
		$orderData = $this ->order_model ->row(array('id' =>$id));
		if (empty($orderData) || ($orderData['status'] > 1 && $orderData['status'] < 0) || $orderData['ispay'] != 0) {
			$this->callback->setJsonCode ( 4000 ,'订单不可取消');
		}
		$time = date('Y-m-d H:i:s' ,time());
		$orderArr = array(
			'status' =>'-4',
			'canceltime' =>$time,
			'admin_id' =>$this ->admin_id
		);
		
		$status = $this ->order_model ->cancelOrder($id,$orderArr,$orderData);
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else 
		{
			$this ->log(3,3,'订单管理',"平台取消订单，订单ID：{$id}");
			//发送系统消息
			$content = "订单编号：{$orderData['ordersn']}<br/>线路标题:{$orderData['productname']}";
			$this ->add_message($content ,0 ,$orderData['memberid'] ,'平台取消订单');
			$this ->add_message($content ,1 ,$orderData['expert_id'] ,'平台取消订单');
			$this ->add_message($content ,2 ,$orderData['supplier_id'] ,'平台取消订单');
				
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}	
	}
	/**
	 * @method 平台退单
	 * @author jiakairong
	 * @since  2015-08-27
	 * @throws Exception
	 */
	public function refund_order()
	{
		$id = intval($this ->input ->post('id'));
		$money = round($this ->input ->post('money') ,2);
		$reason = trim($this ->input ->post('reason' ,true));
		if ($money <= 0)
		{
			$this->callback->setJsonCode ( 4000 ,'请填退款金额');
		}
		if (empty($reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写退单理由');
		}
		$orderData = $this ->order_model ->row(array('id' =>$id));
		if (empty($orderData))
		{
			$this->callback->setJsonCode ( 4000 ,'订单不存在');
		} 
		elseif ($orderData['ispay'] != 2 || $orderData['status'] >4 || $orderData['status'] <1)
		{
			$this->callback->setJsonCode ( 4000 ,'请确认订单状态，目前不支持此操作');
		}
		
		$orderMoney = round($orderData['first_pay'] + $orderData['final_pay'] ,2);
		if (($money - $orderMoney) > 0.0001)
		{
			$this->callback->setJsonCode ( 4000 ,'退款金额不可大于支付金额');
		}
		//查询订单付款表信息
		$this ->load_model('common/u_order_detail_model' ,'detail_model');
		$detailData = $this ->detail_model ->row(array('order_id' =>$id) ,'arr' ,'' ,'bankname,bankcard,id');
		//订单信息
		$orderArr = array(
			'status' =>-3,
			'canceltime' =>date('Y-m-d H:i:s' ,time()),
			'ispay' =>3,
			'admin_id' =>$this ->admin_id
		);
		//退款信息
		$refundArr = array(
				'refund_type' =>3,
				'order_id' =>$id,
				'refund_id' =>$this ->admin_id,
				'reason' =>$reason,
				'amount_apply' =>$money,
				'mobile' =>$orderData['linkmobile'],
				'is_remit' =>0,
				'status' =>0,
				'addtime' =>$orderArr['canceltime'],
				'bankname' =>$detailData['bankname'],
				'bankcard' =>$detailData['bankcard']
		);
		$status = $this ->order_model ->refundOrder($id ,$orderArr ,$orderData ,$refundArr);
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else 
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			//写操作日志
			$this ->log(3,3,'订单管理',"平台退单，订单ID：{$id},申请退款金额:{$money}");
			//发送短信
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>sys_constant::admin_refund));
			$content = str_replace("{#PRODUCTNAME#}", $orderData['productname'] ,$templateData['msg']);
			$this ->send_message($orderData['linkmobile'] ,$content);
		}
	}
	//更改管理费
	public function addOrderYj()
	{
		$orderid = intval($this ->input ->post('id'));
		$num = intval($this ->input ->post('num'));
		$price = $this ->input ->post('price' ,true);
		$remark = $this ->input ->post('remark' ,true);
		
		$orderData = $this ->order_model ->row(array('id' =>$orderid));
		if (empty($orderData) || $orderData['user_type'] != 0 || $orderData['status'] >4)
		{
			$this ->callback->setJsonCode(4000 ,'订单未完成或不存在');
		}
// 		if ($orderData['balance_status'] != 0 || $orderData['union_status'] != 0)
// 		{
// 			$this ->callback->setJsonCode(4000 ,'供应商结算或佣金结算已完成不可修改');
// 		}
		
		//更改的总价格
		$amount = round($price * $num ,2);
		$platform_fee = $orderData['platform_fee'] + $amount;
		if ($platform_fee < 0)
		{
			$this ->callback->setJsonCode(4000 ,'管理费率不可以小于0');
		}
		
		if($platform_fee > $orderData['supplier_cost'])
		{
			$this ->callback->setJsonCode(4000 ,'管理费率不可大于订单应付');
		}
		
		$orderArr = array(
				'platform_fee' =>round($platform_fee ,2),
				'agent_rate' => round($platform_fee / $orderData['total_price'],2 )
		);
		
		$time = date('Y-m-d H:i:s' ,time());
		$yjArr = array(
				'order_id' =>$orderData['id'],
				'user_type' =>3,
				'user_id' =>$this ->admin_id,
				'user_name' =>$this ->realname,
				'num' =>$num,
				'price' =>$price,
				'amount' =>$amount,
				'remark' =>$remark,
				'union_id' =>0,
				'addtime' =>$time,
				'expert_id' =>$orderData['expert_id'],
				'status' =>2,
				'a_id' =>$this ->admin_id,
				'a_remark' =>'平台修改管理费',
				'a_time' =>$time
		);
		
		$logArr = array(
				'order_id' =>$orderid,
				'op_type' =>3,
				'userid' =>$this ->admin_id,
				'content' =>'平台调整平台管理费：'.$amount,
				'addtime' =>$time,
				'type' =>1
		);
		
		$status = $this ->order_model -> updateOrderYj ($orderid ,$orderArr ,$yjArr ,$logArr);
		if ($status == false)
		{
			$this ->callback->setJsonCode(4000 ,'修改失败');
		}
		else
		{
			$this ->log(3, 3, '订单管理', '平台修改订单：'.$orderData['ordersn'].'的管理费为：'.$amount);
			$this ->callback->setJsonCode(2000 ,'修改成功');
		}
	}
	
	/**
	 * 汪晓烽
	 * [export_excel 导出出团人为Excel]
	 */
	function export_excel() {
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$post_arr = array();
		$order_id = $this->input->post ( 'id' );
		$post_arr['mo.id'] = $order_id;
		$order_people = $this->order_model->get_order_people ( $post_arr );
		
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 5 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'G' )->setWidth ( 5 );
		$objActSheet->getColumnDimension ( 'H' )->setWidth ( 20 );
		
		$objActSheet->setCellValue ( "A1", '序号' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		$objActSheet->setCellValue ( 'B1', '姓名' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		$objActSheet->setCellValue ( 'C1', '证件类型' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		$objActSheet->setCellValue ( 'D1', '证件号码' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		$objActSheet->setCellValue ( 'E1', '有效期' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		$objActSheet->setCellValue ( 'F1', '手机号码' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		$objActSheet->setCellValue ( 'G1', '性别' );
		$objActSheet->getStyle ( 'G1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		$objActSheet->setCellValue ( 'H1', '出生年月' );
		$objActSheet->getStyle ( 'H1' )->applyFromArray ( array(
				'font' => array(
						'bold' => true 
				), 
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
				) 
		) );
		
		if (! empty ( $order_people )) {
			$i = 0;
			foreach ( $order_people as $key => $value ) {
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $value['id'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $value['m_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $value['certificate_type'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $value['certificate_no'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), date ( 'Y-m-d', strtotime ( $value['endtime'] ) ), PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $value['telephone'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				if ($value['sex'] == 1) {
					$sex = '男';
				} elseif ($value['sex'] == -1) {
					$sex = '女';
				} else {
					$sex = '保密';
				}
				$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $sex, PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				$objActSheet->setCellValueExplicit ( 'H' . ($i + 2), date ( 'Y-m-d', strtotime ( $value['birthday'] ) ), PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'H' . ($i + 2) )->applyFromArray ( array(
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
						) 
				) );
				$i ++;
			}
		}
		
		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file = "file/a/upload/" . $g_session . ".xlsx";
		$objWriter->save ( $file );
		echo json_encode ( $file );
	}
}