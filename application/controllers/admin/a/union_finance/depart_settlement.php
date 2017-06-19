<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 营业部结算
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Depart_settlement extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/b_depart_settlement_model' ,'settlement_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/depart_settlement');
	}
	//获取结算数据
	public function getDepartSettlementData()
	{
		$whereArr = array();
		$expert_name = trim($this ->input ->post('expert_name'));
		$starttime = trim($this ->input ->post('start_addtime'));
		$endtime = trim($this ->input ->post('end_addtime'));
		$start_u_time = trim($this ->input ->post('start_u_time'));
		$end_u_time = trim($this ->input ->post('end_u_time'));
		$status = intval($this ->input ->post('status'));
		switch($status)
		{
			case 0:
				$whereArr['status ='] = $status;
				$orderBy = 'id desc';
				break;
			case 1:
			case 2:
				$whereArr['status ='] = $status;
				$orderBy = 'u_time desc';
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		
		if (!empty($expert_name))
		{
			$whereArr['expert_name like '] = '%'.$expert_name.'%';
		}

		//申请时间
		if (!empty($starttime)) {
			$whereArr['addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['addtime <='] = $endtime.' 23:59:59';
		}
		//旅行社审核时间
		if (!empty($start_u_time)) {
			$whereArr['u_time >='] = $start_u_time;
		}
		if (!empty($end_u_time)) {
			$whereArr['u_time <='] = $end_u_time.' 23:59:59';
		}
		
		$data = $this ->settlement_model ->getDepartSettlement($whereArr ,$orderBy);
		echo json_encode($data);
	}
	
	//营业部结算详细
	public function detail()
	{
		$id = intval($this ->input ->get('id'));
		$detailArr = $this ->settlement_model ->row(array('id' =>$id));
		$this ->view('admin/a/union_finance/settlement_detail.php' ,array('detailArr' =>$detailArr));
	}
	//结算订单明细
	public function getSettlementOrder()
	{
		$id = intval($this ->input ->post('settlement_id'));
		
		$whereArr = array(
				'bo.settlement_id =' =>$id
		);
		$data = $this ->settlement_model ->getSettlementOrder($whereArr);
		echo json_encode($data);
	}
	
	//审核拒绝结算申请
	public function refuse()
	{
		$id = intval($this ->input ->post('id'));
		$reason = trim($this ->input ->post('reason'));
		if (empty($reason))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写审批意见');
		}
		$settlementData = $this ->settlement_model ->row(array('id' =>$id));
		if (empty($settlementData))
		{
			$this ->callback ->setJsonCode(4000 ,'结算单不存在');
		}
		if ($settlementData['status'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单审核状态不匹配');
		}
		
		//获取结算单的订单
		$settlementOrder = $this ->settlement_model ->getSettlementOrderAll($id);
		if (empty($settlementOrder))
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单没有订单');
		}
		
		$errorStr = false;
		$idArr = array();
		foreach($settlementOrder as $val)
		{
			if ($val['depart_status'] != 1)
			{
				$errorStr = true;
				$msg = '结算订单中有部分订单结算状态不符合';
				break;
			}
			$idArr[] = $val['order_id'];
		}
		if ($errorStr == true)
		{
			$this ->callback ->setJsonCode(4000 ,$msg);
		}
		
		$applyArr = array(
				'a_time' =>date('Y-m-d H:i:s' ,time()),
				'status' =>4,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'a_reason' =>$reason
		);
		
		$status = $this ->settlement_model ->refuseApply($id ,$applyArr ,implode(',', $idArr));
		if ($status == true)
		{
			$this ->log(3, 3, '销售结算审核', '拒绝销售结算申请，ID：'.$id);
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			//发送短息
			$this ->load_model('expert_model');
			$expertData = $this ->expert_model ->row(array('id' =>$settlementData['expert_id']));
			
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'depart_account_refuse'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$msg = str_replace('{#REASON#}', $reason ,$msg);
			$this ->send_message($expertData['mobile'] ,$msg);
			
		}
		else 
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
	}
	
	//通过管家结算申请   结算金额、结算状态、申请人与订单管家
	public function through()
	{
		$id = intval($this ->input ->post('id'));
		$reason = trim($this ->input ->post('reason'));
		$settlementData = $this ->settlement_model ->row(array('id' =>$id));
		if (empty($settlementData))
		{
			$this ->callback ->setJsonCode(4000 ,'结算单不存在');
		}
		if ($settlementData['status'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单审核状态不匹配');
		}
		
		//获取结算单的订单
		$settlementOrder = $this ->settlement_model ->getSettlementOrderAll($id);
		if (empty($settlementOrder))
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单没有订单');
		}
		
		$errorStr = false;
		$money = 0;
		$idArr = array();
		foreach($settlementOrder as $val)
		{
			if ($val['depart_status'] != 1)
			{
				$errorStr = true;
				$msg = '结算订单中有部分订单结算状态不符合';
				break;
			}
			$idArr[] = $val['order_id'];
			$money = $money + $val['agent_fee'] - $val['diplomatic_agent'];
		}
		if ($errorStr == true)
		{
			$this ->callback ->setJsonCode(4000 ,$msg);
		}
		$balance = $money - $settlementData['amount'];
		if (abs($balance) > 0.0001)
		{
			$this ->callback ->setJsonCode(4000 ,'可结算总金额为：'.round($money,2));
		}
		
		$applyArr = array(
				'a_time' =>date('Y-m-d H:i:s' ,time()),
				'status' =>3,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'a_reason' =>$reason
		);
		
		$status = $this ->settlement_model ->throughApply($id ,$applyArr ,implode(',', $idArr));
		if ($status == true)
		{
			$this ->log(3, 3, '销售结算审核', '通过销售结算申请，ID：'.$id);
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			//发送短息
			$this ->load_model('expert_model');
			$expertData = $this ->expert_model ->row(array('id' =>$settlementData['expert_id']));
			
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'depart_account_adopt'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$this ->send_message($expertData['mobile'] ,$msg);
			
		}
		else 
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		
	}
}