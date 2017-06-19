<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Pay extends UC_NL_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}

	/**
	 * @method 支付本地测试
	 */
	public function live_alipay()
	{
		$this->load_view('test/live_alipay_test');
	}
	
	/**
	 * @method 用户充值，用于微信支付测试
	 * @author jkr
	 */
	public function recharge_test()
	{
		$this->load_view('test/recharge_test');
	}
	/**
	 * @method 微信支付
	 */
	public function weixin_pay()
	{
		$money = $this->input ->post('money');
		if ($money <= 0)
		{
			echo '请填写充值金额';exit;
		}
		$dataArr = array(
				'status' =>0,
				'user_id' =>1,
				'money' =>$money,
				'pay_way' =>'微信支付',
				'addtime' =>date('Y-m-d H:i:s' ,time())
		);
		$this ->load_model('live/live_recharge_model' ,'rechargeModel');
		$id = $this ->rechargeModel ->insert($dataArr);
		//$id = 15;
		$this->load->library ( 'Weixin_api' ); //加载微信支付接口
		$config = array(
				'notify_url' =>base_url().'api/weixin_notify/live_notify',
				'out_trade_no' =>'0088'.$id,
				'trade_type' =>'NATIVE',
				'product_id' =>'0088'.$id,
				'total_fee' =>intval($money*100),
				'body' =>'帮游网用户充值'
		);
		$this ->weixin_api ->initialize ( $config );
		$url = $this ->weixin_api ->GetPayUrl();
		$this->load_view('test/weixin' ,array('url' =>$url));
	}
	
	/**
	 * @method 微信异步通知
	 * @author jkr
	 */
	public function weixin_notify()
	{
		
	}
}