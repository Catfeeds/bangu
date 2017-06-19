<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 供应商付款管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Payable_apply extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/u_payable_apply_model' ,'payable_apply_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/payable_apply');
	}
	//获取付款数据
	public function getPayableApplyJson()
	{
		$whereArr = array();
		$supplier_name = trim($this ->input ->post('supplier_name'));
		$starttime = trim($this ->input ->post('start_addtime'));
		$endtime = trim($this ->input ->post('end_addtime'));
		$start_u_time = trim($this ->input ->post('start_u_time'));
		$end_u_time = trim($this ->input ->post('end_u_time'));
		$status = intval($this ->input ->post('status'));
		switch($status)
		{
			case 0:
				$whereArr['pa.status ='] = $status;
				$orderBy = 'pa.id desc';
				break;
			case 1:
			case 2:
				$whereArr['pa.status ='] = $status;
				$orderBy = 'pa.u_time desc';
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		
		if (!empty($supplier_name))
		{
			$whereArr['s.company_name like '] = '%'.$supplier_name.'%';
		}
		//申请时间
		if (!empty($starttime)) {
			$whereArr['pa.addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['pa.addtime <='] = $endtime.' 23:59:59';
		}
		//旅行社审核时间
		if (!empty($start_u_time)) {
			$whereArr['pa.u_time >='] = $start_u_time;
		}
		if (!empty($end_u_time)) {
			$whereArr['pa.u_time <='] = $end_u_time.' 23:59:59';
		}
		
		$data = $this ->payable_apply_model ->getPayableApplyData($whereArr ,$orderBy);
		echo json_encode($data);
	}
	
	//付款详细
	public function detail()
	{
		$id = intval($this ->input ->get('id'));
		$payableArr = $this ->payable_apply_model ->getPayableApplyRow($id);
		$this ->view('admin/a/union_finance/payable_detail' ,array('payableArr' =>$payableArr));
	}
	//付款明细
	public function getPayableOrder()
	{
		$id = intval($this ->input ->post('detail_id'));
		
		$whereArr = array(
				'po.payable_id =' =>$id
		);
		$data = $this ->payable_apply_model ->getPayableOrderData($whereArr);
		echo json_encode($data);
	}
	
	//审核拒绝付款申请
	public function refuse()
	{
		$id = intval($this ->input ->post('payable_id'));
		$reply = trim($this ->input ->post('reply' ,true));
		if (empty($reply))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写审批意见');
		}
		$payableOrder = $this ->payable_apply_model ->getPayableOrderAll($id);
		if (empty($payableOrder))
		{
			$this ->callback ->setJsonCode(4000 ,'付款申请没有相应的订单');
		}
		$orderIds = '';
		$errorStr = false;
		foreach($payableOrder as $k =>$v)
		{
			if ($val['balance_status'] != 1 || $val['balance_complete'] == 2)
			{
				//订单的供应商结算状态不在申请中 或者 供应商已结算完成
				$errorStr = true;
				break;
			}
			$orderIds .= $v['order_id'].',';
		}
		if ($errorStr == true)
		{
			$this ->callback ->setJsonCode(4000 ,'付款申请对应的订单结算有误');
		}
		
		$applyArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>4,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'reply' =>$reply
		);
		$status = $this ->payable_apply_model ->refuseApply($id, $applyArr ,rtrim($orderIds));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3, 3, '供应商付款审核', '退回供应商付款申请，ID：'.$id);
			//发送短息
			$this ->load_model('supplier_model');
			$supplierData = $this ->supplier_model ->row(array('id' =>$payableData['supplier_id']));
				
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'union_supplier_apply_refuse'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$msg = str_replace('{#REASION#}', $reply ,$msg);
			$this ->send_message($supplierData['mobile'] ,$msg);
		}
	}
	
	//审核通过付款申请
	public function through()
	{
		$id = intval($this ->input ->post('id'));
		$reply = trim($this ->input ->post('reply'));
		$payableData = $this ->payable_apply_model ->row(array('id' =>$id));
		if (empty($payableData))
		{
			$this ->callback ->setJsonCode(4000 ,'付款申请不存在');
		}
		if ($payableData['status'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'此付款申请审核状态有误');
		}
		
		//判断每个订单的未结算金额是否足够
		$payableOrder = $this ->payable_apply_model ->getPayableOrderAll($id);
		if (empty($payableOrder))
		{
			$this ->callback ->setJsonCode(4000 ,'付款申请没有相应的订单');
		}
		$errorArr = array();
		$errorStr = false;
		foreach($payableOrder as $val)
		{
			if ($val['balance_status'] != 1 || $val['balance_complete'] == 2)
			{
				//订单的供应商结算状态不在申请中 或者 供应商已结算完成
				$errorStr = true;
				break;
			}
			
			if ($val['balance'] < $val['amount_apply']) 
			{
				//供应商可结算金额不足
				$errorArr[] = array('ordersn' =>$val['ordersn']);
			}
		}
		if ($errorStr == true)
		{
			$this ->callback ->setJsonCode(4000 ,'付款申请对应的订单结算有误');
		}
		if (!empty($errorArr))
		{
			$msg = '';
			foreach($errorArr as $v)
			{
				$msg .= $v['ordersn'].',';
			}
			$this ->callback ->setJsonCode(4000 ,'订单'.rtrim($msg,',').'剩余可结算金额不足');
		}
		
		$applyArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>3,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'reply' =>$reply
		);
		
		$status = $this ->payable_apply_model ->throughApply($id ,$applyArr ,$payableOrder);
		if ($status == true)
		{
			$this ->log(3, 3, '供应商付款审核', '通过供应商付款申请，ID：'.$id);
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			//发送短息
			$this ->load_model('supplier_model');
			$supplierData = $this ->supplier_model ->row(array('id' =>$payableData['supplier_id']));
			
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'union_supplier_apply_adopt'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$this ->send_message($supplierData['mobile'] ,$msg);
			
		}
		else 
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		
	}
}