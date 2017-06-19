<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @method 		订单支付
 * @author		贾开荣
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_pay extends UC_NL_Controller
{
	public function __construct()
	{
		parent::__construct ();
	//	set_error_handler('customError');
		$this->load->library ( 'callback' );
		$this->load_model ( 'order_model', 'order_model' );
	}
	/**
	 * @method 进入支付页面
	 * @since  2015-06-10
	 */
	public function pay_type()
	{
		$id = intval($this ->input ->get('oid'));
		$user_id = $this ->session ->userdata('c_userid');
		//var_dump($id);exit;
		$this ->load_model('order_model');
		$orderData = $this ->order_model ->row(array('id' =>$id ,'memberid' =>$user_id));
//  		var_dump($orderData);
//  		exit;
		if (empty($orderData))
		{
			header("Location:/order_from/order/line_order");exit;
		}
		if ($orderData['status'] == 0 && $orderData['ispay'] == 0)
		{
			$tatal_price=round($orderData['total_price'] + $orderData['settlement_price'],2);
		}
		elseif ($orderData['diff_price']>0 && $orderData['ispay'] ==2)
		{
			//订单转团的差价费用
			$tatal_price=$orderData['diff_price'];
		}
		else
		{
			header("Location:/order_from/order/line_order");exit;
		}

		//余位
		if ($orderData['suitnum'] > 0) {
			//套餐线路
			$num = $orderData['suitnum'];
		} else {
			//正常线路
			$num = round($orderData['dingnum'] + $orderData['childnum'] + $orderData['oldnum']);
		}
		$this ->load_model('common/u_line_suit_price_model' ,'price_model');
		$whereArr = array(
				'lineid' =>$orderData['productautoid'],
				'suitid' =>$orderData['suitid'],
				'day' =>$orderData['usedate']
		);
		$suitPrice = $this ->price_model ->row($whereArr);
		
		//获取支付银行
		$this ->load_model('bank_model');
		$bankData = $this ->bank_model ->all(array('isopen'=>1),'showorder asc');

		$dataArr = array(
				'ordersn' =>$orderData['ordersn'],
				'id' =>$orderData['id'],
				'money' =>$tatal_price,
				'mobile' =>$orderData['linkmobile'],
				'linkman' =>$orderData['linkman'],
				'bankData' =>$bankData,
				'diff_price' =>$orderData['diff_price'],
				'ispay' => $orderData['ispay']
		);
		$this ->session ->set_userdata('payOrder' ,$orderData['id']);
		$this ->load ->view("pay/order_pay_view" ,$dataArr);
	}

	/**
	 * @method 根据选择的支付类型进入支付页面
	 * @since  2015-06-10
	 * @author jiakairong
	 */
	public function get_into_pay()
	{
		$userid = intval($this ->session ->userdata('c_userid'));
		$postArr = $this->security->xss_clean($_POST);
		$order_id = intval($postArr['pay_order_id']); //订单号
		$pay_type = trim($this ->input ->post('paystyle')); //支付类型	暂定：1-支付宝 ,3-银盛

		if ($order_id != $this ->session ->userdata('payOrder'))
		{
			header("Location:/order_from/order/line_order");exit;
		}
		//订单信息
		$orderData = $this ->order_model ->row(array('id' =>$order_id ,'memberid' =>$userid));
		//发票信息
		if (!empty($postArr['invoice']) && $postArr['invoice'] == 1)
		{
			$this ->orderInvoice($postArr);
		}

		$CountMoney = round($orderData['total_price'] + $orderData['settlement_price'],2);
		if ($pay_type == 1) //支付宝
		{
			$this->load->library ( 'Alipay_api' ); //加载支付宝接口
			$config = array(
				'notify_url' =>base_url().'pay/order_pay/alipay_notify',
				'return_url' =>base_url().'pay/order_pay/alipay_return',
				'out_trade_no' =>$orderData ['id'].'A'.time(),
				'subject' =>$orderData ['productname'],
				'total_fee' =>$CountMoney,
				//'body' =>$orderData ['productname'],
			);
			$this ->alipay_api ->initialize ( $config );
			$pay_string = $this ->alipay_api ->api();
			$this->callback->set_code ( 2000 ,$pay_string);
			$this->callback->exit_json();
		}
		elseif ($pay_type == 3)
		{
			$this->load->library ( 'Ysepay' ); //加载银盛支付接口
			$config = array(
					'orderid' =>$order_id.'A'.time(),
					'busicode' =>'01000010',//业务代码
					'amount' =>round($CountMoney*100 ,0),//订单价格，以分为单位
					'ordernote' =>'旅游产品支付',//订单说明
					'banktype' =>'',//银行行别 (固定值：快捷支付 - 9001000、纯网银方式 - 填入文档中对应的银行代码)
					'bankaccounttype' =>'', //付款方银行账户类型 (如：11 - 对私借记卡)
					'noticepg_url' =>site_url().'pay/order_pay/yse_return',//前台通知地址
					'noticebg_url' =>site_url().'pay/order_pay/yse_notify',//后台通知地址
			);
			//若为快捷支付(或纯网关方式)，则  bankType 和 bankAccountType 参数必须有
			$url = $this ->ysepay ->S3001_ysepay($config);
			$this->callback->set_code ( 3000 ,$url);
			$this->callback->exit_json();
		}
		elseif (!empty($pay_type)) //网银支付
		{
			$this ->load_model('bank_model');
			$bankData = $this ->bank_model ->row(array('isopen' =>1 ,'code' =>$pay_type));
			if (empty($bankData))
			{
				$this->callback->set_code ( 4000 ,'请选择支付方式');
				$this->callback->exit_json();
			}
			else
			{
				$this->load->library ( 'Alipay_api' ); //加载支付宝接口
				$config = array(
						'notify_url' =>base_url().'pay/order_pay/alipay_notify',
						'return_url' =>base_url().'pay/order_pay/alipay_return',
						'out_trade_no' =>$orderData ['id'].'A'.time(),
						'subject' =>$orderData ['productname'],
						'total_fee' =>$CountMoney,
						'paymethod' =>'bankPay',
						'defaultbank' =>$pay_type
				);
				$this ->alipay_api ->initialize ( $config );
				$pay_string = $this ->alipay_api ->alipayBankPay();
				$this->callback->set_code ( 2000 ,$pay_string);
				$this->callback->exit_json();
			}
		}
		else
		{
			$this->callback->set_code ( 4000 ,'请选择支付方式');
			$this->callback->exit_json();
		}
	}

	/**
	 * @method 订单发票信息
	 * @author jiakairong
	 * @since  2015-11-25
	 * @param unknown $postArr
	 */
	protected function orderInvoice($postArr)
	{
		if (empty($postArr['title']))
		{
			$this->callback->set_code ( 4000 ,'请填写发票抬头');
			$this->callback->exit_json();
		}
		if (empty($postArr['receiver']))
		{
			$this->callback->set_code ( 4000 ,'请填写收件人');
			$this->callback->exit_json();
		}
		if (empty($postArr['mobile']))
		{
			$this->callback->set_code ( 4000 ,'请填写手机号');
			$this->callback->exit_json();
		}
		if (empty($postArr['region']))
		{
			$this->callback->set_code ( 4000 ,'请将地址选择完整');
			$this->callback->exit_json();
		}
		if (empty($postArr['address']))
		{
			$this->callback->set_code ( 4000 ,'请填写详细地址');
			$this->callback->exit_json();
		}
		//获取地区
		$this ->load_model('common/u_area_model' ,'area_model');
		$areaData = $this ->area_model ->getAreaInData("{$postArr['province']},{$postArr['city']},{$postArr['region']}" ,'id asc');
		$address = '';
		foreach($areaData as $val)
		{
			$address .= $val['name'];
		}
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$invoiceArr = array(
				'invoice_name' =>$postArr['title'],
				'invoice_detail' =>$postArr['detail'],
				'receiver' =>$postArr['receiver'],
				'telephone' =>$postArr['mobile'],
				'address' =>$address.$postArr['address'],
				'member_id' =>$this ->session ->userdata('c_userid'),
				'modtime' =>$time,
				'addtime' =>$time
		);
		//判断是否有发票信息
		$orderInvoice = $this ->order_model ->getOrderInvoice($postArr['pay_order_id']);
		if(empty($orderInvoice))
		{
			$this ->order_model ->orderInvoiceInsert($invoiceArr ,$postArr['pay_order_id']);
		}
		else
		{
			//存在发票信息则更新
			$this ->db ->where(array('id' =>$orderInvoice[0]['invoice_id']));
			$this ->db ->update('u_member_invoice' ,$invoiceArr);
		}
	}
	/**
	 * @method 银盛异步通知处理(已弃用)
	 * @author jiakairong
	 * @since  2015-11-25
	 */
	public function yse_notify()
	{
// 		if (!file_exists('./orderpaylog'))
// 		{
// 			mkdir('./orderpaylog' ,0755);
// 		}
// 		$filename = './orderpaylog/'.date('Ymd' ,time()).'.txt';
// 		$file = fopen($filename ,'a+');

		$this->load->library ( 'Ysepay' );
		$xml=$this ->ysepay ->unsign_crypt(array("check"=>$_REQUEST['check'],"msg"=>$_REQUEST['msg']));
		//fwrite($file,'REQUEST：'.json_encode($_REQUEST).'*****');

		if ($xml == false)
		{
			//fwrite($file,'银盛支付：返回参数验证失败。****');
			echo base64_encode("fail");
		}
		else
		{
			$xml = str_replace('GBK' ,'utf-8' ,$xml);
			$xml = iconv('GBK', 'UTF-8//IGNORE', $xml);
			$xmlObj = simplexml_load_string($xml); //将xml字符解析成对象
			//var_dump($xmlObj);exit;
			$orderInfo = get_object_vars($xmlObj->body->Order);//将对象转化成数组
			$resultInfo = get_object_vars($xmlObj->body->Result);//银盛返回信息
			//记录返回的数据
			file_put_contents("./application/libraries/yinsheng/Response/R3501/".$orderInfo['OrderId'].".txt",$xml);
			//订单金额,返回值以分为单位
			$amount = $orderInfo['Amount'] / 100;
			//返回状态
			if($resultInfo['Code'] == "0000")
			{
				$status = $this ->orderHandle($orderInfo['OrderId'], $amount, '', $resultInfo['TradeSN'], '银盛支付' ,base64_encode("fail"));
				if ($status === true)
				{
					echo base64_encode("0000|success");
					$this ->sendMobileMsg($orderInfo['OrderId']);
				}
				else
				{
					echo base64_encode("fail");
				}
			}
			else
			{
				//fwrite($file,'银盛支付：返回参数验证失败。&&&&');
				echo base64_encode("fail");
			}
		}

	}

	/**
	 * @method 支付成功的订单处理(支付公用)
	 * @param unknown $orderid  包含订单ID的字符
	 * @param unknown $amount	支付金额,单位元
	 * @param unknown $bankcard  买家账号
	 * @param unknown $receipt  交易流水号
	 * @param string  $bankname  支付方式名称
	 * @param string  $failureCode  失败返回码
	 * @param string  $pay_way 支付类型，如：支付宝 or 银联
	 */
	protected function orderHandle($orderStr ,$amount ,$bankcard ,$receipt ,$bankname ,$failureCode ,$pay_way)
	{
		//$filename = './orderpaylog/'.date('Ymd' ,time()).'.txt';
		//$file = fopen($filename ,'a+');

		$orderid = explode('A', $orderStr);
		$orderid = $orderid[0];
		$orderData = $this ->order_model ->row(array('id' =>$orderid ));
		if (empty($orderData))
		{
			//fwrite($file,'订单号：'.$orderid.',说明：订单不存在。&&&&');
			echo $failureCode;exit;//订单不存在
		}
		
		if ($orderData['status'] == 0 && $orderData['ispay'] == 0)
		{
			$money = abs($amount - $orderData['total_price'] - $orderData['settlement_price']);
			if ($money > 0.0001)
			{
				//fwrite($file,'订单号：'.$orderid.',说明：订单金额不符合。&&&&');
				echo $failureCode;exit;//订单金额不符合
			}
			$payType = 1;
		}
		elseif ($orderData['ispay'] == 2 && $orderData['diff_price'] >0)
		{
			$money = abs($amount - $orderData['diff_price']);
			if ($money > 0.0001)
			{
				//fwrite($file,'订单号：'.$orderid.',说明：订单金额不符合。&&&&');
				echo $failureCode;exit;//订单金额不符合
			}
			$payType = 2;
		}
		else 
		{
			//fwrite($file,'订单号：'.$orderid.',说明：订单状态不符合。&&&&');
			echo $failureCode;exit;//订单状态不符合
		}
		
		
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		//付款信息记录
		$detailArr = array(
				'order_id' =>$orderid,
				'amount' =>round($amount ,2),
				'bankname' =>$bankname,
				'bankcard' =>$bankcard,
				'account_name' =>$bankcard,
				'receipt' =>$receipt,
				'addtime' =>$time,
				'status' =>0,
				'beizhu' =>'请求支付的订单号：'.$orderStr,
				'pay_way' =>$pay_way
		);
		if ($payType == 1)
		{
			$status = $this ->order_model ->orderPay($orderData['memberid'] ,$detailArr ,$orderData);
		}
		else 
		{
			$status = $this ->order_model ->orderPayFinal($orderData['memberid'] ,$detailArr);
		}
		
		if ($status === false)
		{
			//fwrite($file,'订单号：'.$orderid.',说明：写入数据失败。&&&&');
			//fclose($file);
			echo $failureCode;exit;//写入数据失败
		}
		else
		{
			//fclose($file);
			//发送消息
			$this->add_message ( "用户付款,订单编号：{$orderData['ordersn']}", 1, $orderData ['expert_id'] );
			$this->add_message ( "用户付款,订单编号：{$orderData['ordersn']}", 2, $orderData ['supplier_id'] );
			return true;
		}
	}


	/**
	 * @method 银盛同步通知处理
	 * @author jiakairong
	 * @since  2015-11-25
	 */
	public function yse_return()
	{
		$this->load->library ( 'Ysepay' );
		$msgArr = $this ->ysepay ->unsign_crypt_return($_REQUEST);

		$order_id = substr($msgArr['msg'] ,0 ,strpos($msgArr['msg'] ,'A'));
		$orderArr = explode('|', $msgArr['msg']);
		$amount = round($orderArr['1'] / 100 , 2); //支付金额
		$data = array(
				'amount' =>$amount,
				'order_id' =>$order_id,
				'status' =>$msgArr['status']
		);
		$this->load->view('pay/pay_result_view' ,$data);
	}

	/**
	 * @method 支付宝异步通知处理
	 * @author jiakairong
	 * @since  2015-06-16
	 */
	public function alipay_notify() {
// 		if (!file_exists('./orderpaylog'))
// 		{
// 			mkdir('./orderpaylog' ,0755);
// 		}
// 		$filename = './orderpaylog/'.date('Ymd' ,time()).'.txt';
// 		$file = fopen($filename ,'a+');

		$this->load->library ( 'Alipay_api' );
		//验证数据
		$status = $this ->alipay_api ->get_verifyNotify();
		//$status = true;
		if ($status) {
			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易金额
			$total_fee = $_POST['total_fee'];
			//买家支付宝账号
			$buyer_email = $_POST['buyer_email'];
			//交易状态
			$trade_status = $_POST['trade_status'];
			//bank_seq_no 网银流水
			$pay_way = empty($_POST['bank_seq_no']) ? '支付宝' : '银联支付';
			
			switch($trade_status)
			{
				case 'TRADE_FINISHED'://普通即时到账的交易成功状态
				case 'TRADE_SUCCESS'://开通了高级即时到账或机票分销产品后的交易成功状态
					$status = $this ->orderHandle($out_trade_no, $total_fee, $buyer_email, $trade_no, '支付宝支付' ,'fail' ,$pay_way);
					if ($status === true)
					{
						echo "success";	//请不要修改或删除
						$this ->sendMobileMsg($out_trade_no);
					}
					else
					{
						echo 'fail';
					}
					break;
				default:
					echo 'fail';
					break;
			}
		} else {
			//fwrite($file,'支付宝支付：返回参数验证失败。&&&&');
			echo "fail";
		}
	}

	/**
	 * @method 支付宝同步通知处理
	 * @since  2015-0616
	 */
	public function alipay_return() {
		$this->load->library ( 'Alipay_api' );
		//验证返回结果  true & false
		$status = $this ->alipay_api ->get_verifyReturn();

		$ordersn = $_REQUEST['out_trade_no'];
		$order_id = substr($ordersn ,0 ,strpos($ordersn ,'A'));

		$data = array(
				'amount' =>$_REQUEST['total_fee'],
				'order_id' =>$order_id,
				'status' =>$status
		);
		$this->load->view('pay/pay_result_view' ,$data);
	}

	//付款成功发送提示信息给管家 & 供应商
	public function sendMobileMsg($orderStr)
	{
		$orderid = explode('A', $orderStr);
		$orderid = $orderid[0]; //订单ID
		$this ->load_model('expert_model');
		$this ->load_model('supplier_model');
		$this ->load_model('sms_template_model');

		$orderData = $this ->order_model ->row(array('id' =>$orderid));

		$expert = $this ->expert_model ->row(array('id' =>$orderData['expert_id']));
		$supplier = $this ->supplier_model ->row(array('id' =>$orderData['supplier_id']));

		$template = $this ->sms_template_model ->row(array('msgtype' =>sys_constant::expert_order_pay));
		$content = str_replace('{#ORDERSN#}', $orderData['ordersn'] ,$template['msg']);
		$this ->send_message($expert['mobile'] ,$content);

		$template = $this ->sms_template_model ->row(array('msgtype' =>sys_constant::supplier_order_pay));
		$content = str_replace('{#ORDERSN#}', $orderData['ordersn'] ,$template['msg']);
		$this ->send_message($supplier ['link_mobile'] ,$content);
	}

	public function test_pay() {
		$this ->load ->view("pay/test_pay");
	}
	//@hejun  支付成功
	public function success_pay(){
		$this->load->view('pay/pay_result_view');
	}


}