<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 旅行社佣金结算管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Union_agent extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/b_union_agent_apply_model' ,'agent_apply_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/union_agent');
	}
	//获取佣金结算数据
	public function getUnionAgentJson()
	{
		$whereArr = array();
		$union_name = trim($this ->input ->post('union_name' ,true));
		$employee_name = trim($this ->input ->post('employee_name' ,true));
		$admin_name = trim($this ->input ->post('admin_name' ,true));
		$starttime = trim($this ->input ->post('starttime'));
		$endtime = trim($this ->input ->post('endtime'));
		$m_starttime = trim($this ->input ->post('m_starttime'));
		$m_endtime = trim($this ->input ->post('m_endtime'));
		$status = intval($this ->input ->post('status'));
		
		switch($status)
		{
			case 0:
			case 1:
			case 2:
				$whereArr['status ='] = $status;
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		
		if (!empty($union_name))
		{
			$whereArr['union_name like '] = '%'.$union_name.'%';
		}
		if (!empty($employee_name))
		{
			$whereArr['employee_name like '] = '%'.$employee_name.'%';
		}
		if (!empty($admin_name))
		{
			$whereArr['admin_name like '] = '%'.$admin_name.'%';
		}
		
		if (!empty($starttime)) {
			$whereArr['addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['addtime <='] = $endtime.' 23:59:59';
		}
		
		if (!empty($m_starttime)) {
			$whereArr['modtime >='] = $m_starttime;
		}
		if (!empty($m_endtime)) {
			$whereArr['modtime <='] = $m_endtime.' 23:59:59';
		}
		
		$data = $this ->agent_apply_model ->getUnionAgentData($whereArr);
		echo json_encode($data);
	}
	
	//结算单详细
	public function detail()
	{
		$id = intval($this ->input ->post('id'));
		$agentArr = $this ->agent_apply_model ->getUnionAgentRow($id);
		echo json_encode($agentArr);
	}
	//结算订单明细
	public function getAgentOrder()
	{
		$id = intval($this ->input ->post('detail_id'));
		
		$whereArr = array(
				'bo.apply_id =' =>$id
		);
		$data = $this ->agent_apply_model ->getAgentOrderData($whereArr);
		echo json_encode($data);
	}
	
	//审核拒绝结算申请
	public function refuse()
	{
		$id = intval($this ->input ->post('agent_id'));
		$reply = trim($this ->input ->post('reply' ,true));
		if (empty($reply))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写拒绝理由');
		}
		$agentData = $this ->agent_apply_model ->getRowData($id);
		if (empty($agentData) || $agentData['status'] != 0)
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单不存在或已审核');
		}
		
		$applyArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>2,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'real_amount' =>0,
				'reply' =>$reply
		);
		//var_dump($applyArr);exit;
		$status = $this ->agent_apply_model ->refuseAgentApply($applyArr ,$id);
		
		if ($status == false) 
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3, 3, '旅行社佣金结算审核', '拒绝旅行社佣金结算申请，ID：'.$id);
			//发送短息
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'union_account_refuse'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$msg = str_replace('{#REASON#}', $reply ,$msg);
			$this ->send_message($agentData['linkmobile'] ,$msg);
		}
	}
	
	//审核通过结算申请
	public function through()
	{
		$id = intval($this ->input ->post('id'));
		//$amount = $this ->input ->post('amount');
		
		$agentData = $this ->agent_apply_model ->getRowData($id);
		if (empty($agentData) || $agentData['status'] != 0)
		{
			$this ->callback ->setJsonCode(4000 ,'此结算单不存在或已审核');
		}
// 		if ($agentData['amount'] < $amount)
// 		{
// 			$this ->callback ->setJsonCode(4000 ,'结算金额不可大于申请结算金额');
// 		}
		
		$orderAll = $this -> agent_apply_model ->getAgentOrderAll($id);
		if (empty($orderAll))
		{
			$this ->callback ->setJsonCode(4000 ,'结算订单不存在');
		}
		$error = false;
		foreach($orderAll as $k =>$v)
		{
			$balance = $v['money'] - ($v['platform_fee'] + $v['diplomatic_agent'] - $v['union_balance']);
			if (abs($balance) > 0.0001)
			{
				$error = true;
			}
			
		}
		if ($error === true)
		{
			$this ->callback ->setJsonCode(4000 ,'结算单有误');
		}
		
		$applyArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>1,
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'real_amount' =>$agentData['amount']
		);
		
		$status = $this ->agent_apply_model ->throughAgentApply($applyArr ,$orderAll ,$id ,$agentData);
		
		if ($status == true)
		{
			$this ->log(3, 3, '旅行社佣金结算审核', '通过旅行社佣金结算申请，ID：'.$id);
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			
			//$this ->load_model('');
			//发送短息
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>'union_account_adopt'));
			$msg = str_replace('{#CODE#}', $id ,$templateData['msg']);
			$this ->send_message($agentData['linkmobile'] ,$msg);
			
		}
		else 
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		
	}
}