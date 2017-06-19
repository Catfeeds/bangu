<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 退款/退团审批
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Refund extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/u_order_refund_model' ,'refund_model');
		$this ->load_model('admin/a/order_model' ,'order_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/refund');
	}
	//获取退款数据
	public function getOrderRefundJson()
	{
		$whereArr = array();
		$linename = trim($this ->input ->post('linename' ,true));
		$ordersn = trim($this ->input ->post('ordersn' ,true));
		$item_code = trim($this ->input ->post('item_code' ,true));
		$expert_name = trim($this ->input ->post('expert_name' ,true));
		$starttime = trim($this ->input ->post('starttime'));
		$endtime = trim($this ->input ->post('endtime'));
		$destname = trim($this ->input ->post('destname'));
		$destid = intval($this ->input ->post('destid'));
		$startcity = trim($this ->input ->post('startcity' ,true));
		$startcity_id = intval($this ->input ->post('startcity_id'));
		$status = intval($this ->input ->post('status'));
		
		switch($status)
		{
			case 3:
			case 4:
				$whereArr['r.status ='] = $status;
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		
		if (!empty($linename))
		{
			$whereArr['l.linename like '] = '%'.$linename.'%';
		}
		if (!empty($expert_name))
		{
			$whereArr['e.realname like '] = '%'.$expert_name.'%';
		}
		if (!empty($item_code))
		{
			$whereArr['mo.item_code ='] = $item_code;
		}
		if (!empty($ordersn))
		{
			$whereArr['mo.ordersn ='] = $ordersn;
		}
		
		if (!empty($starttime)) {
			$whereArr['mo.usedate >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['mo.usedate <='] = $endtime.' 23:59:59';
		}
		//目的地搜索 
		$sql = '';
		if (!empty($destid))
		{
			$sql = ' find_in_set('.$destid.' ,l.overcity)';
		}
		else if (!empty($destname))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$destData = $this ->dest_base_model ->getDestData(array('kindname like' =>'%'.$destname.'%'));
			if (empty($destData))
			{
				echo json_encode($this->defaultArr);exit;
			}
			else 
			{
				$sql .= ' (';
				foreach($destData as $v) {
					$sql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$sql = rtrim($sql ,'or') .' )';
			}
		}
		//出发城市搜索
		if (!empty($startcity_id))
		{
			$whereArr['ls.startplace_id ='] =$startcity_id;
		}
		else if (!empty($startcity))
		{
			$this ->load_model('startplace_model');
			$startData = $this ->startplace_model ->getStartcityId($startcity);
			if (empty($startcity))
			{
				echo json_encode($this->defaultArr);exit;
			}
			else 
			{
				$sql = empty($sql) ? $sql.'(' : $sql.' and (';
				foreach($startData as $v) 
				{
					$sql .= ' ls.startplace_id ='.$v['id'].' or';
				}
				$sql = rtrim($sql ,'or').' )';
			}
		}
		
		$data = $this ->refund_model ->getOrderRefundData($whereArr ,$sql);
	//	echo $this ->db ->last_query();exit;
		if (!empty($data['data']))
		{
			foreach($data['data'] as &$v)
			{
				//获取订单已付款
				$moneyArr = $this ->order_model ->getOrderBillYs($v['order_id']);
				$v['money'] = $moneyArr['amount'];
			}
		}
		
		echo json_encode($data);
	}
	
	//结算单详细
	public function detail()
	{
		$id = intval($this ->input ->get('id'));
		$refundArr = $this ->refund_model ->getOrderRefundRow($id);
		//获取订单已交款
		$moneyArr = $this ->order_model ->getOrderBillYs($refundArr['order_id']);
		$refundArr['money'] = $moneyArr['amount'];
		//获取管家对此订单申请的信用额度
		$this ->load_model('admin/t33/b_expert_limit_apply_model' ,'apply_model');
		$applyData = $this ->apply_model ->row(array('order_id' =>$refundArr['order_id'] ,'status >=' =>1));
		//获取供应商退款申请
		$supplierRefund = $this ->refund_model ->getSupplierRefund($refundArr['yf_id']);
		
		$dataArr = array(
				'refundArr' =>$refundArr,
				'applyData' =>$applyData,
				'supplierRefund' =>$supplierRefund
		);
		$this ->view('admin/a/union_finance/refund_detail' ,$dataArr);
	}
	//通过退款退团
	public function through()
	{
		$id = intval($this ->input ->post('id'));
		$refundData = $this ->refund_model ->row(array('id' =>$id));
		if (empty($refundData) || $refundData['status'] != 3)
		{
			$this ->callback ->setJsonCode(4000 ,'申请不存在或状态不正确');
		}
		//获取订单
		$this ->load_model('order_model');
		$orderData = $this ->order_model ->row(array('id' =>$refundData['order_id']));
		if (empty($orderData))
		{
			$this ->callback ->setJsonCode(4000 ,'订单不存在');
		}
		
		$orderArr = array();
		$num = $orderData['dingnum'] + $orderData['childnum'] + $orderData['childnobednum'] + $orderData['oldnum'];
		if ($orderData['status'] == '-3' || $num == 0) {
			$orderArr = array(
					'status' =>-4,
					'canceltime' =>date('Y-m-d H:i:s' ,time())
			);
		}
		
		$dataArr = array(
				'status' =>4,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'a_time' =>date('Y-m-d H:i:s' ,time())
		);
		
		$status = $this ->refund_model ->through($id ,$dataArr ,$orderArr ,$refundData['order_id']);
		if ($status == true)
		{
			$this ->log(3, 3, '退款退团管理', '通过退款退团申请,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
	}
	
}