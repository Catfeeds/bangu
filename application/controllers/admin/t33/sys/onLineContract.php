<?php
/**
 * 合同签署
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月17日11:59:53
 * @author 徐鹏
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class OnLineContract extends T33_Controller {
	public $defaultData = array(
			'count' =>0,
			'data' =>array()
	);
	public function __construct()
	{
		parent::__construct ();
		$this->load->helper ( 'regexp' );
		$this ->load->library ( 'callback' );
		$this->load_model ( 'admin/t33/b_contract_launch_model', 'contract_model' );
		$this ->load_model('expert_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
	}

	public function index()
	{
		$employee_id = $this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		
		$chapterData = $this ->contract_model ->getChapterData($employee['union_id']);
		
		$dataArr = array(
				'chapterData' =>$chapterData
		);
		$this->load ->view('admin/t33/contract/on_line_contract_view' ,$dataArr);
		
	}
	
	//获取申请合同数据
	public function getContractApply()
	{
		$employee_id = $this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		
		$whereArr = array(
				'union_id =' =>$employee['union_id']
		);
		
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$expert_name = trim($this ->input ->post('expert_name' ,true));
		
		if (!empty($starttime)) {
			$whereArr['addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['addtime <='] = $endtime.' 23:59:59';
		}
		if (!empty($expert_name)) {
			$whereArr['expert_name like'] = '%'.$expert_name.'%';
		}
		
		$data = $this ->contract_model ->getContractApplyT33($whereArr);
		echo json_encode($data);
	}
	
	
	//获取合同数据
	public function getContractData()
	{
		$employee_id = $this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$whereArr['union_id ='] = $employee['union_id'];
		
		$status = intval($this ->input ->post('status'));
		$contract_code = trim($this ->input ->post('contract_code' ,true));
		$guest_name = trim($this ->input ->post('guest_name' ,true));
		$ordersn = trim($this ->input ->post('ordersn' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$expert_name = trim($this ->input ->post('expert_name' ,true));
		
		
		switch($status) {
			case 1:
				$orderBy = 'id desc';
				break;
			case 2:
				$orderBy = 'write_time desc';
				break;
			case 3:
				$orderBy = 'confirm_time desc';
				break;
			case 4:
			case -1:
				$orderBy = 'cancel_time desc';
				break;
			default:
				echo json_encode($this ->defaultData);exit;
				break;
		}
		$whereArr['status ='] = $status;
		
		if (!empty($contract_code)) {
			$whereArr['contract_code ='] = $contract_code;
		}
		if (!empty($guest_name)) {
			$whereArr['guest_name like'] = '%'.$guest_name.'%';
		}
		if (!empty($ordersn)) {
			$whereArr['order_sn ='] = $ordersn;
		}
		if (!empty($starttime)) {
			$whereArr['addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['addtime <='] = $endtime.' 23:59:59';
		}
		if (!empty($expert_name)) {
			$whereArr['expert_name like'] = '%'.$expert_name.'%';
		}
		
		$data = $this ->contract_model ->getContractData($whereArr);
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}
	
	//更新公章
	public function updateChapter()
	{
		$pic = trim($this ->input ->post('pic' ,true));
		if (empty($pic))
		{
			$this ->callback ->setJsonCode(4000 ,'请上传公章');
		}
		//获取帮游公章
		$banguChapter = $this ->db ->where('id' ,1) ->get('b_contract_chapter_bangu')->row_array();
		if (!empty($banguChapter))
		{
			$bangu_chapter = $banguChapter['bangu_chapter'];
		}
		
		$employee_id = $this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		$dataArr = array(
				'union_chapter' =>$pic,
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'union_id' =>$employee['union_id']
		);
		
		$unionChapter = $this ->db ->where('union_id' ,$employee['union_id']) ->get('b_contract_chapter')->row_array();
		if (empty($unionChapter))
		{
			$dataArr['addtime'] = $dataArr['modtime'];
			$status = $this ->db ->insert('b_contract_chapter' ,$dataArr);
		}
		else 
		{
			$status = $this ->db ->where('union_id' ,$employee['union_id']) ->update('b_contract_chapter' ,$dataArr);
		}
		
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//审核管家合同申请
	public function toExamineApply()
	{
		$type = intval($this ->input ->post('type'));
		$id = intval($this ->input ->post('id'));
		$remark = trim($this ->input ->post('remark' ,true));
		if ($type == 1)
		{
			$this ->throughApply($id); //通过申请
		}
		else
		{
			$this ->refuseApply($id ,$remark); //拒绝申请
		}
	}
	
	//通过申请
	public function throughApply($id)
	{
		$employee_id = $this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		
		$applyData = $this ->contract_model ->getApplyContractRow($id);
		if (empty($applyData))
		{
			$this ->callback ->setJsonCode(4000 ,'申请记录不存在');
		}
		if ($applyData['status'] != 0)
		{
			$this ->callback ->setJsonCode(4000 ,'记录不在审核状态');
		}
		
		if ($applyData['union_id'] != $employee['union_id'])
		{
			$this ->callback ->setJsonCode(4000 ,'此申请记录不属于您所在旅行社，您没有权限审核');
		}
		
		$status = $this ->contract_model ->throughApplyContract($employee ,$applyData);
		
		if ($status == false) {
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		} else {
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
		
	}
	
	//拒绝申请
	public function refuseApply($id ,$remark)
	{
		if (empty($remark))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写拒绝理由');
		}
		
		$employee_id = $this->session->userdata("employee_id");
		$employee = $this->b_employee_model->row(array('id'=>$employee_id));
		
		$applyData = $this ->contract_model ->getApplyContractRow($id);
		if (empty($applyData))
		{
			$this ->callback ->setJsonCode(4000 ,'申请记录不存在');
		}
		if ($applyData['status'] != 0)
		{
			$this ->callback ->setJsonCode(4000 ,'记录不在审核状态');
		}
		
		if ($applyData['union_id'] != $employee['union_id'])
		{
			$this ->callback ->setJsonCode(4000 ,'此申请记录不属于您所在旅行社，您没有权限审核');
		}
		
		$dataArr = array(
				'status' =>2,
				'remark' =>$remark,
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'employee_id' =>$employee_id,
				'employee_name' =>$employee['realname']
		);
		$status = $this ->db ->where('id' ,$id) ->update('b_contract_apply' ,$dataArr);
		if ($status == false) {
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		} else {
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//核销合同
	public function writeOff()
	{
		$contractId = intval($this ->input ->post('id'));
		$contractData = $this ->contract_model ->row(array('id' =>$contractId));
		if (empty($contractData))
		{
			$this ->callback ->setJsonCode(4000 ,'合同不存在');
		}
		if ($contractData['status'] != 2) 
		{
			$this ->callback ->setJsonCode(4000 ,'合同状态不正确');
		}
		
		$dataArr = array(
				'status' =>3,
				'confirm_time' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->db ->where('id' ,$contractId) ->update('b_contract_launch' ,$dataArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'核销失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'核销成功');
		}
	}
	
	
	//确认作废合同
	public function confirmAbandoned()
	{
		$id = intval($this ->input ->post('id'));
		
		$contractData = $this ->contract_model ->row(array('id' =>$id));
		if (empty($contractData))
		{
			$this ->callback ->setJsonCode(4000 ,'合同不存在');
		}
		if ($contractData['status'] != -1) 
		{
			$this ->callback ->setJsonCode(4000 ,'未申请作废');
		}
		$dataArr = array(
				'status' =>4,
				'cancel_time' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->db ->where('id' ,$id) ->update('b_contract_launch' ,$dataArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'确认作废失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'确认作废成功');
		}
	}
	
	//查看合同详情
	public function seeLaunchContract()
	{
		$code = trim($this ->input ->get('code')); //合同编号
		$contractData = $this ->contract_model ->row(array('contract_code' =>$code));
		if (!empty($contractData))
		{
			if ($contractData['type'] == 1)
			{
				$detailArr = $this ->contract_model ->getAbroadContract($code);
			}
			else
			{
				$detailArr = $this ->contract_model ->getDomesticContract($code);
			}
			
			
			$time = strtotime($detailArr['start_time']);
			$detailArr['start_year'] = date('Y' ,$time);
			$detailArr['start_month'] = date('m' ,$time);
			$detailArr['start_day'] = date('d' ,$time);
			
			$hour = date('H:i:s' ,$time);
			if ($hour == '23:59:59') {
				$detailArr['start_time'] = 24;
			} else {
				$detailArr['start_time'] = date('H' ,$time);
			}
			
			
			$time = strtotime($detailArr['end_time']);
			$detailArr['end_year'] = date('Y' ,$time);
			$detailArr['end_month'] = date('m' ,$time);
			$detailArr['end_day'] = date('d' ,$time);
			
			$hour = date('H:i:s' ,$time);
			if ($hour == '23:59:59') {
				$detailArr['end_time'] = 24;
			} else {
				$detailArr['end_time'] = date('H' ,$time);
			}
			$detailArr['pay_time'] = date('Y-m-d' ,strtotime($detailArr['pay_time']));
			
			//获取
			$fileData = $this ->contract_model ->getContractFile($contractData['id']);
			
			$expertData = $this ->expert_model ->row(array('id' =>$contractData['expert_id']));
			
			$dataArr = array(
					'detailArr' =>$detailArr,
					'fileData' =>$fileData,
					'expertData' =>$expertData,
			);
			//echo $this ->db ->last_query();
			$this ->load ->view('admin/t33/contract/see_launch_contract_view' ,$dataArr);
		}
	}
	
	
	
}