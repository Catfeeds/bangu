<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
require_once "./application/libraries/weixin/lib/WxPay.Api.php";
require_once './application/libraries/weixin/lib/WxPay.Notify.php';
require_once './application/libraries/weixin/log.php';

class Weixin_notify extends APP_Controller
{
	public function __construct(){
		parent::__construct ();
	}
	/**
	 * @method 微信支付回调地址
	 * @author jkr
	 */
	public function live_notify()
	{
		$notify = new notify();
		$notify ->start_notify();
		//$notify ->Queryorder();
	}
	/**
	 * @method 微信支付成功，数据处理，用于直播会员充值
	 * @author jkr
	 */
	public function liveUpdate($payArr=array())
	{
		$this ->load_model('live/live_recharge_model' ,'rechargeModel');
		$this ->load_model('live/anchor_model' ,'anchorModel');
		
		$ordersn = $payArr['out_trade_no'];
		$serial = $payArr['transaction_id'];
		$money = $payArr['total_fee'] /100;
		//$ordersn = '008830';
		$recharge_id = substr($ordersn ,4);
		
		$rechargeData = $this ->rechargeModel ->row(array('id' =>$recharge_id));
		if (empty($rechargeData) || $rechargeData['status'] != 0)
		{
			return false;//数据有误 
		}
		$difference = $rechargeData['money'] - $money;
		if ($difference > 0.001)
		{
			return false;//金额不匹配
		}
		$anchorData = $this ->anchorModel ->getUserUMoney($rechargeData['user_id']);
		if (empty($anchorData))
		{
			return false;//会员不存在
		}
		$rechargeArr = array(
				'umoney' =>round($money * sys_constant::URATE),
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'serial' =>$serial,
				'pay_way' =>'微信支付',
				'status' =>1
		);
		return $this ->rechargeModel ->userRecharge($rechargeData['user_id'] ,$rechargeArr ,$recharge_id);
	}
}

class notify extends WxPayNotify
{	
	public function start_notify()
	{
		$logHandler= new CLogFileHandler("./weixin/logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		$this->Handle(false);
	}
	
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS")
		{
// 			$result = array(
// 					'out_trade_no' =>'008823',
// 					'transaction_id' =>'4002732001201606217641638237',
// 					'total_fee' =>1
// 			);
			$weixin_notify = new Weixin_notify();
			$status = $weixin_notify ->liveUpdate($result);
			return $status;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		if(!array_key_exists("transaction_id", $data)){
			Log::DEBUG("error:输入参数不正确");
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			Log::DEBUG("error:订单查询失败");
			return false;
		}
		return true;
	}
}
