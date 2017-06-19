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
class Sign_contract extends MY_Controller {

	public function __construct()
	{
		parent::__construct ();
		$this ->load->library ( 'callback' );
		$this->load->model( 'admin/t33/b_contract_launch_model', 'contract_model' );
	}

	public function index($code='')
	{
		//$contractId = intval($this ->input ->get('conid'));
		$contractData = $this ->contract_model ->row(array('link' =>$code));
		if (!empty($contractData))
		{
			$contractId = $contractData['id'];
			if ($contractData['type'] == 1)
			{
				$detailArr = $this ->contract_model ->getAbroadContract($contractData['contract_code']);
			}
			else
			{
				$detailArr = $this ->contract_model ->getDomesticContract($contractData['contract_code']);
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
			
			//获取签署文件
			$fileData = $this ->contract_model ->getContractFile($contractId);
			
			$this ->load_model('expert_model');
			$dataArr = array(
					'detailArr' =>$detailArr,
					'contractData' =>$contractData,
					'fileData' =>$fileData,
					'expertData' =>$this ->expert_model ->row(array('id' =>$contractData['expert_id']))
			);
			$this->load ->view('contract/contract_view' ,$dataArr);
		}
	}
	
	//手写图片处理
	public function imgHandle()
	{
		$contractId = intval($this ->input ->post('conid'));
		$base64 = trim($this ->input ->post('str' ,true));
		
		//判断合同
		$contractData = $this ->contract_model ->row(array('id' =>$contractId));
		if (empty($contractData))
		{
			echo json_encode(array('code' =>4000 ,'msg' =>'该合同不存在，请联系管家确认'));exit;
		}
		if ($contractData['status'] != 1)
		{
			echo json_encode(array('code' =>4000 ,'msg' =>'此合同已签署或已作废'));exit;
		}
		
		//保存用户签名
		$img = base64_decode($base64);
		$url = './file/user_sign/';
		if (!file_exists($url)) {
			mkdir($url ,0777 ,true);
		}
		
		$filename = md5(time().mt_rand(10, 99)).".png";
		$status = file_put_contents($url.$filename, $img);
		
		if ($status == false) {
			echo json_encode(array('code' =>4000 ,'msg' =>'签署失败'));exit;
		}
		
		$time = date('Y-m-d H:i:s' ,time());
		$dataArr = array(
				'gs_time' =>$time,
				'guest_sign' =>'/file/user_sign/'.$filename,
				'us_time' =>$time,
				'bs_time' =>$time
		);
		
		$contractArr = array(
				'is_sign' =>1,
				'write_time' =>$time,
				'status' =>2
		);
		
		$status = $this ->contract_model ->updateContractUser($contractId ,$contractArr ,$dataArr);
		if ($status ==  false) {
			echo json_encode(array('code' =>4000 ,'msg' =>'签署失败，请重新提交'));exit;
		} else {
			echo json_encode(array('code' =>2000 ,'msg' =>'签署成功'));exit;
		}
	}
	
	
	public function createPDF($contractId=6) {
		$contractId = 6;
		$str = file_get_contents('/sign_contract?conid='.$contractId);
		echo $str;
	}
	
}