<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 旅行社佣金结算管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Supplier_account extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/b_month_account_model' ,'account_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/supplier_account');
	}
	//获取付款数据
	public function getSupplierAccount()
	{
		$whereArr = array();
		$supplier_name = trim($this ->input ->post('supplier_name'));
		$starttime = trim($this ->input ->post('starttime'));
		$endtime = trim($this ->input ->post('endtime'));
		$status = intval($this ->input ->post('status'));
		switch($status)
		{
			case 0:
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
				$whereArr['ma.status ='] = $status;
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		
		if (!empty($supplier_name))
		{
			$whereArr['s.company_name like '] = '%'.$supplier_name.'%';
		}
		if ($status == 0)
		{
			if (!empty($starttime)) {
				$whereArr['ma.addtime >='] = $starttime;
			}
			if (!empty($endtime)) {
				$whereArr['ma.addtime <='] = $endtime.' 23:59:59';
			}
		} 
		elseif($status == 2 || $status == 1)
		{
			if (!empty($starttime)) {
				$whereArr['ma.modtime >='] = $starttime;
			}
			if (!empty($endtime)) {
				$whereArr['ma.modtime <='] = $endtime.' 23:59:59';
			}
		}
		else
		{
			if (!empty($starttime)) {
				$whereArr['ma.a_time >='] = $starttime;
			}
			if (!empty($endtime)) {
				$whereArr['ma.a_time <='] = $endtime.' 23:59:59';
			}
		}
		
		$data = $this ->account_model ->getMonthAccount($whereArr);
		echo json_encode($data);
	}
	
	//结算单详细
	public function detail()
	{
		$id = intval($this ->input ->get('id'));
		$accountArr = $this ->account_model ->getMonthAccountRow($id);
		$data = array(
				'accountArr' =>$accountArr
		);
		$this ->view('admin/a/union_finance/supplier_account_detail' ,$data);
	}
	//结算订单明细
	public function getAccountOrder()
	{
		$id = intval($this ->input ->post('id'));
		
		$whereArr = array(
				'ma.month_account_id =' =>$id
		);
		$data = $this ->account_model ->getAccountOrderData($whereArr);
		echo json_encode($data);
	}
	
	//审核拒绝结算申请
	public function refuse()
	{
		$id = intval($this ->input ->post('id'));
		$reply = trim($this ->input ->post('reply'));
		if (empty($reply))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写拒绝理由');
		}
		$accountData = $this ->account_model ->row(array('id' =>$id));
		if (empty($accountData) || $accountData['status'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单不存在或已审核');
		}
		
		$orderAll = $this -> account_model ->getAccountOrderAll($id);
		if (empty($orderAll))
		{
			$this ->callback ->setJsonCode(4000 ,'结算订单不存在');
		}
		$orderIds = '';
		$error = false;
		foreach($orderAll as $k =>$v)
		{
			if ($v['balance_status'] != 1 || $v['balance_complete'] == 2) {
				//订单的供应商结算状态不在申请中 或者 供应商已结算完成
				$error = true;
				break;
			}
			$orderIds .= $v['order_id'].',';
		}
		if ($error === true)
		{
			$this ->callback ->setJsonCode(4000 ,'结算单有误');
		}
		
		$accountArr = array(
				'a_time' =>date('Y-m-d H:i:s' ,time()),
				'status' =>4,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'real_amount' =>0,
				'a_reply' =>$reply
		);
		
		$status = $this ->account_model ->refuseAccount($accountArr ,rtrim($orderIds ,',') ,$id);
		
		if ($status == false) 
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3, 3, '供应商结算审核', '拒绝供应商结算申请，ID：'.$id);
			//发送短息
			$this ->load_model('supplier_model');
			$supplierData = $this ->supplier_model ->row(array('id' =>$accountData['supplier_id']));
				
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'supplier_account_refuse'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$msg = str_replace('{#REASON#}', $reply ,$msg);
			$this ->send_message($supplierData['mobile'] ,$msg);
		}
	}
	
	//审核通过结算申请
	public function through()
	{
		$id = intval($this ->input ->post('id'));
		$reply = trim($this ->input ->post('reply'));
		$amount = $this ->input ->post('amount');
		
		$accountData = $this ->account_model ->row(array('id' =>$id));
		if (empty($accountData) || $accountData['status'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单不存在或已审核');
		}
		if ($accountData['amount'] < $amount)
		{
			$this ->callback ->setJsonCode(4000 ,'结算金额不可大于申请结算金额');
		}
		
		$orderAll = $this -> account_model ->getAccountOrderAll($id);
		if (empty($orderAll))
		{
			$this ->callback ->setJsonCode(4000 ,'结算订单不存在');
		}
		$orderIds = '';
		$error = false;
		foreach($orderAll as $k =>$v)
		{
			if ($v['balance_status'] != 1 || $v['balance_complete'] == 2) {
				//订单的供应商结算状态不在申请中 或者 供应商已结算完成
				$error = true;
				break;
			}
			$orderIds .= $v['order_id'].',';
		}
		if ($error === true)
		{
			$this ->callback ->setJsonCode(4000 ,'结算单有误');
		}
		
		$accountArr = array(
				'a_time' =>date('Y-m-d H:i:s' ,time()),
				'status' =>3,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'real_amount' =>$amount,
				'a_reply' =>$reply
		);
		
		$status = $this ->account_model ->throughAccount($accountArr ,rtrim($orderIds ,',') ,$id);
		
		if ($status == true)
		{
			$this ->log(3, 3, '供应商结算审核', '通过供应商结算申请，ID：'.$id);
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			//发送短息
			$this ->load_model('supplier_model');
			$supplierData = $this ->supplier_model ->row(array('id' =>$accountData['supplier_id']));
			
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'supplier_account_adopt'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$this ->send_message($supplierData['mobile'] ,$msg);
		}
		else 
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		
	}
}