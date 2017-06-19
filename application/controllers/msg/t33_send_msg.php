<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		jkr
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class T33_send_msg extends MY_Controller {
	/**定义消息编号，用于获取消息发送信息***/
	public $quota_supplier = 'apply_limit_supplier'; //向供应商申请额度
	public $quota_union = 'apply_limit_union'; //向旅行社申请额度
	public $quota_cancel = 'apply_limit_cancel'; //取消额度申请
	public $ys_apply = 'add_order_ys';//营业部销售申请修改应收价格
	public $ys_manager = 'add_order_ys_manager';//营业部经理修改应收价格
	public $yf_expert = 'add_order_yf_expert';//销售修改应付价格
	public $yf_supplier = 'add_order_yf_supplier';//供应商修改应付价格
	public $yj_change = 'add_order_yj';//联盟修改佣金
	public $wj_change = 'add_order_wj';//联盟修改外交佣金
	public $add_people = 'order_add_people';//添加参团人
	public $order_receivable = 'add_receviable';//销售交款
	public $payable_order = 'add_payable';//供应商付款申请
	public $payable_allow = 'payable_allow';//联盟审核通过付款申请
	public $payable_refund = 'payable_refuse';//联盟审核拒绝付款申请
	public $add_order = 'new_order';//新订单消息
	public $receivable_approve = 'receivable_approve';//交款审核
	
	public $fund_inquiry = 'fund_inquiry';//认款流程
	
	public $manager_name = '';//营业部经理名称
	public $manager_id = '';//营业部经理ID
	public $sendman = '';//发送人姓名
	
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('msg/msg_point_model' ,'point_model');
		$this ->load_model('msg/msg_main_model' ,'main_model');
		$this ->load_model('msg/msg_send_model' ,'send_model');
		$this ->load_model('msg/msg_send_people_model' ,'people_model');
		$this ->load_model('msg/get_data_model' ,'data_model');
		$this ->load_model('msg/msg_send_step_model' ,'send_step_model');
	}
	
	/**
	 * @method 通过应付修改发送消息
	 * @author jkr
	 * @param  array $billYfData 应付数据
	 */
	public function sendYfMsg($billYfData)
	{
		$time = date('Y-m-d H:i:s' ,time());
			
		$content = $time.' ， '.$billYfData['depart_name'].' 营业部 ， 新增订单成本: '.$billYfData['amount'].' 元 (已通过)，订单编号为 '.$billYfData['ordersn'].'，请及时跟进。'; //消息内容
			
		$sendArr = array(
				'title' =>'修改应付通知',
				'content' =>$content,
				'sendman' =>$this ->sendman,
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>0
		);
		$id = $this ->send_model ->insert($sendArr);
			
		$peopleArr = array(
				'send_id' =>$id,
				'user_type' =>5,
				'user_id' =>$billYfData['finance_id']
		);
		$this ->people_model ->insert($peopleArr);
	}
	
	
	/**
	 * @method 交款审批提醒
	 * @author jkr
	 * @param string $ids 交款表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function receivableApprove($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取交款信息
		$receivableData = $this ->data_model ->getReceivableData($ids);
		if (empty($receivableData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$belong = $receivableData[0]['status'] ==1 ? 3 : 1;
		$msgData = $this ->point_model ->getPointContent($this->receivable_approve ,$step ,$belong);
		//认款消息发送内容
		$inquiryMsg = $this ->point_model ->getPointContent($this->fund_inquiry ,$step ,$belong);
		
// 		if (empty($msgData))
// 		{
// 			$this ->returnMsg(4000, '缺少发送的消息');
// 		}
		
		//按订单或充值将交款分开
		$receivableArr = array();
		foreach($receivableData as $v)
		{
			if (!array_key_exists($v['order_id'], $receivableArr))
			{
				$receivableArr[$v['order_id']] = array(
						'money' =>$v['money'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id'],
						'id' =>$v['id'],
						'order_sn' =>$v['order_sn'],
						'from' =>$v['from']
				);
			}
			else 
			{
				$receivableArr[$v['order_id']]['money'] = round($receivableArr[$v['order_id']]['money']+$v['money'] ,2);
			}
		}
		if ($receivableData[0]['status'] ==1 || $receivableData[0]['status'] ==2)
		{
			$status = 2;
		}
		else 
		{
			$status = 3;
		}
		foreach($receivableArr as $k=>$v)
		{
			
			if ($v['from'] == 1)
			{
				/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
				$this ->changeStep($step, $v['id'], $this->fund_inquiry, $status);
				//认款流程
				if (empty($inquiryMsg))
				{
					continue;
				}
				foreach($inquiryMsg as $item)
				{
					$dataArr = array(
							'type' =>$item['user_type'],
							'union_id' =>$v['union_id'],
							'supplier_id' =>$v['supplier_id'],
							'expert_id' =>$v['expert_id'],
							'depart_id' =>$v['depart_id']
					);
					//获取消息接收人
					$peopleArr = $this ->getPeopleArr($dataArr);
				
					$content = ''; //消息内容
					if (!empty($peopleArr))
					{
						//根据步骤替换消息内容的变量
						switch($step)
						{
							case 1:
								switch ($item['user_type'])
								{
									case 5: //联盟财务
										$content = str_replace('{#DEPARTNAME#}', $receivableData[0]['depart_name'] , $item['content']);
										$content = str_replace('{#MONEY#}', $v['money'] , $content);
										$url = $item['url'];
										break;
								}
								break;
							case 2:
								switch ($item['user_type'])
								{
									case 1: //经理
										$content = str_replace('{#EMPLOYEENAME#}', $name , $item['content']);
										$content = str_replace('{#MONEY#}', $v['money'] , $content);
										$url = $item['url'];
										break;
								}
								break;
							default:
								$this ->returnMsg(4000 ,'未知的送步骤');
								break;
						}
				
						if (!empty($content))
						{
							//写入消息
							$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
						}
					}
				}
			}
			else 
			{
				/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
				$this ->changeStep($step, $v['id'], $this->receivable_approve, $status);
				//交款流程
				foreach($msgData as $item)
				{
					$dataArr = array(
							'type' =>$item['user_type'],
							'union_id' =>$v['union_id'],
							'supplier_id' =>$v['supplier_id'],
							'expert_id' =>$v['expert_id'],
							'depart_id' =>$v['depart_id']
					);
					//获取消息接收人
					$peopleArr = $this ->getPeopleArr($dataArr);
				
					$content = ''; //消息内容
					if (!empty($peopleArr))
					{
						//根据步骤替换消息内容的变量
						switch($step)
						{
							case 1:
								switch ($item['user_type'])
								{
									case 5: //联盟财务
										$content = str_replace('{#DEPARTNAME#}', $receivableData[0]['depart_name'] , $item['content']);
										$content = str_replace('{#EXPERTNAME#}', $name , $content);
										$content = str_replace('{#ORDERSN#}', $v['order_sn'] , $content);
										$url = $item['url'];
										break;
								}
								break;
							case 2:
								switch ($item['user_type'])
								{
									case 1: //经理
										$content = str_replace('{#EMPLOYEENAME#}', $name , $item['content']);
										$content = str_replace('{#ORDERSN#}', $v['order_sn'] , $content);
										$url = $item['url'];
										break;
								}
								break;
							default:
								$this ->returnMsg(4000 ,'未知的送步骤');
								break;
						}
				
						if (!empty($content))
						{
							//写入消息
							$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
						}
					}
				}
				
			}
		}
	}
	
	/**
	 * @method 销售交款消息发送
	 * @author jkr
	 * @param string $ids 交款表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function receivableMsg($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取交款信息 
		$receivableData = $this ->data_model ->getReceivableData($ids);
		if (empty($receivableData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->order_receivable ,$step ,3);
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($receivableData as $v)
		{
			/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
			//$this ->changeStep($step, $v['id'], $this->order_receivable, $status);
		
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 1: //经理
									$content = str_replace('{#EXPERTNAME#}', $name , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['order_sn'] , $content);
									$content = str_replace('{#MONEY#}', $v['money'] , $content);
									$url = $item['url'];
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 新订单通知
	 * @author jkr
	 * @param string $id 订单ID
	 * @param string $name 发起人
	 */
	public function addOrderMsg($id ,$name)
	{
		if (empty($id) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取订单信息
		$orderData = $this ->data_model ->getOrderData($id);
		if (empty($orderData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->add_order ,1 ,3);
		
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		//总人数
		$num = round($orderData['childnobednum']+$orderData['childnum']+$orderData['dingnum']);
		//使用的额度
		if (empty($orderData['real_amount']))
		{
			$quota = round($orderData['total_price']-$orderData['real_amount'],2);
		}
		else
		{
			$quota = $orderData['total_price'];
		}
		
		//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
		foreach($msgData as $item)
		{
			$dataArr = array(
					'type' =>$item['user_type'],
					'union_id' =>$orderData['union_id'],
					'supplier_id' =>$orderData['supplier_id'],
					'expert_id' =>$orderData['expert_id'],
					'depart_id' =>$orderData['depart_id']
			);
			//获取消息接收人
			$peopleArr = $this ->getPeopleArr($dataArr);
			$content = ''; //消息内容
			if (!empty($peopleArr))
			{
				switch ($item['user_type'])
				{
					case 3: //供应商
						$content = str_replace('{#LINENAME#}', $orderData['linename'] , $item['content']);
						$content = str_replace('{#EXPERTNAME#}', $orderData['expert_name'] , $content);
						$content = str_replace('{#ADULTNUM#}', $orderData['dingnum'] , $content);
						$content = str_replace('{#CHILDNOBEDNUM#}', $orderData['childnobednum'] , $content);
						$content = str_replace('{#CHILDNUM#}', $orderData['childnum'] , $content);
						$content = str_replace('{#NUM#}', $num , $content);
						$url = str_replace('{#ORDERID#}', $orderData['id'] , $item['url']);
						break;
					case 1://经理
						$content = str_replace('{#LINENAME#}', $orderData['linename'] , $item['content']);
						$content = str_replace('{#EXPERTNAME#}', $orderData['expert_name'] , $content);
						$content = str_replace('{#QUOTA#}', $quota , $content);
						$content = str_replace('{#ADULTNUM#}', $orderData['dingnum'] , $content);
						$content = str_replace('{#CHILDNOBEDNUM#}', $orderData['childnobednum'] , $content);
						$content = str_replace('{#CHILDNUM#}', $orderData['childnum'] , $content);
						$content = str_replace('{#NUM#}', $num , $content);
						$url = str_replace('{#ORDERID#}', $orderData['id'] , $item['url']);
						break;
				}
		
				if (!empty($content))
				{
					//写入消息
					$this ->addSendMsg($item, $content, $url, $peopleArr ,$orderData['id']);
				}
			}
		}
	}
	
	/**
	 * @method 联盟审核拒绝付款申请
	 * @author jkr
	 * @param string $ids 付款表ID组
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function payableRefund($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
	
		//获取应收账单
		$payableData = $this ->data_model ->getPayableData($ids);
		if (empty($payableData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
	
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->payable_refund ,$step ,3);
	
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
	
		$ordersns = '';
		foreach($payableData as $v)
		{
			$ordersns .= $v['ordersn'].'、';
		}
	
		//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
		foreach($msgData as $item)
		{
			$dataArr = array(
					'type' =>$item['user_type'],
					'union_id' =>$payableData[0]['union_id'],
					'supplier_id' =>$payableData[0]['supplier_id'],
					'expert_id' =>0,
					'depart_id' =>0
			);
			//获取消息接收人
			$peopleArr = $this ->getPeopleArr($dataArr);
			$content = ''; //消息内容
			if (!empty($peopleArr))
			{
				//根据步骤替换消息内容的变量
				switch($step)
				{
					case 1:
						switch ($item['user_type'])
						{
							case 3: //供应商
								$content = str_replace('{#EMPLOYEENAME#}', $name , $item['content']);
								$content = str_replace('{#PAYABLEID#}', $payableData[0]['payable_id'] , $content);
								$content = str_replace('{#REASON#}', $payableData[0]['u_reply'] , $content);
								$content = str_replace('{#ORDERSNS#}', rtrim($ordersns,'、') , $content);
								break;
						}
						break;
					default:
						$this ->returnMsg(4000 ,'未知的送步骤');
						break;
				}
	
				if (!empty($content))
				{
					//写入消息
					$this ->addSendMsg($item, $content, $item['url'], $peopleArr ,$v['id']);
				}
			}
		}
	}
	
	/**
	 * @method 联盟审核通过付款申请
	 * @author jkr
	 * @param string $ids 付款表ID组
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function payableAllow($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$payableData = $this ->data_model ->getPayableData($ids);
		if (empty($payableData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->payable_allow ,$step ,3);
		
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		$ordersns = '';
		foreach($payableData as $v)
		{
			$ordersns .= $v['ordersn'].'、';
		}
		
		//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
		foreach($msgData as $item)
		{
			$dataArr = array(
					'type' =>$item['user_type'],
					'union_id' =>$payableData[0]['union_id'],
					'supplier_id' =>$payableData[0]['supplier_id'],
					'expert_id' =>0,
					'depart_id' =>0
			);
			//获取消息接收人
			$peopleArr = $this ->getPeopleArr($dataArr);
			$content = ''; //消息内容
			if (!empty($peopleArr))
			{
				//根据步骤替换消息内容的变量
				switch($step)
				{
					case 1:
						switch ($item['user_type'])
						{
							case 3: //供应商
								$content = str_replace('{#EMPLOYEENAME#}', $name , $item['content']);
								$content = str_replace('{#PAYABLEID#}', $payableData[0]['payable_id'] , $content);
								$content = str_replace('{#REASON#}', $payableData[0]['u_reply'] , $content);
								$content = str_replace('{#ORDERSNS#}', rtrim($ordersns,'、') , $content);
								break;
						}
						break;
					default:
						$this ->returnMsg(4000 ,'未知的送步骤');
						break;
				}
		
				if (!empty($content))
				{
					//写入消息
					$this ->addSendMsg($item, $content, $item['url'], $peopleArr ,$v['id']);
				}
			}
		}
	}
	
	/**
	 * @method 供应商申请付款
	 * @author jkr
	 * @param string $id 付款表ID
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function payableApply($id ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$payableData = $this ->data_model ->getPayableApplyData($id);
		if (empty($payableData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->payable_order ,$step ,3);
		
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($payableData as $v)
		{
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>0,
						'depart_id' =>0
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 5: //联盟财务
									$content = str_replace('{#COMPANYNAME#}', $name , $item['content']);
									$content = str_replace('{#PAYABLE#}', $v['id'] , $content);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $item['url'], $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 管家添加参团人
	 * @author jkr
	 * @param string $order_id 订单ID
	 * @param intval $price 新增价格
	 * @param string $quota 新增使用的额度
	 * @param intval $dingnum 成人数量
	 * @param intval $childnum 儿童数量
	 * @param intval $childnobednum 儿童不占床数量
	 * @param string $name 发起人姓名
	 */
	public function addPeopleMsg($order_id,$price,$quota,$dingnum,$childnum,$childnobednum,$name)
	{
		$this ->sendman = $name;
		
		//获取订单信息
		$orderData = $this ->data_model ->getOrderData($order_id);
		if (empty($orderData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$step = 1;//只有一步
		$msgData = $this ->point_model ->getPointContent($this->add_people ,1 ,3);
		
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		$num = round($dingnum+$childnobednum+$childnum);
		//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
		foreach($msgData as $item)
		{
			$dataArr = array(
					'type' =>$item['user_type'],
					'union_id' =>$orderData['union_id'],
					'supplier_id' =>$orderData['supplier_id'],
					'expert_id' =>$orderData['expert_id'],
					'depart_id' =>$orderData['depart_id']
			);
			//获取消息接收人
			$peopleArr = $this ->getPeopleArr($dataArr);
		
			$content = ''; //消息内容
			if (!empty($peopleArr))
			{
				//根据步骤替换消息内容的变量
				switch($step)
				{
					case 1:
						switch ($item['user_type'])
						{
							case 3: //供应商
								$content = str_replace('{#EXPERTNAME#}', $name , $item['content']);
								$content = str_replace('{#ORDERSN#}', $orderData['ordersn'] , $content);
								$content = str_replace('{#ADULTNUM#}', $dingnum , $content);
								$content = str_replace('{#CHILDNOBED#}', $childnobednum , $content);
								$content = str_replace('{#CHILDNUM#}', $childnum , $content);
								$content = str_replace('{#NUM#}', $num , $content);
								$url = str_replace('{#ORDERID#}', $order_id , $item['url']);
								break;
							case 1: //经理
								$content = str_replace('{#EXPERTNAME#}', $name , $item['content']);
								$content = str_replace('{#ORDERSN#}', $orderData['ordersn'] , $content);
								$content = str_replace('{#ADULTNUM#}', $dingnum , $content);
								$content = str_replace('{#CHILDNOBED#}', $childnobednum , $content);
								$content = str_replace('{#CHILDNUM#}', $childnum , $content);
								$content = str_replace('{#NUM#}', $num , $content);
								$content = str_replace('{#QUOTA#}', $quota , $content);
								$url = str_replace('{#ORDERID#}', $order_id , $item['url']);
								break;
						}
						break;
					default:
						$this ->returnMsg(4000 ,'未知的送步骤');
						break;
				}
	
				if (!empty($content))
				{
					//写入消息
					$this ->addSendMsg($item, $content, $url, $peopleArr ,$order_id);
				}
			}
		}
	}
	
	/**
	 * @method 联盟修改管理费
	 * @author jkr
	 * @param string $ids 佣金表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function billYjChange($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$billYjData = $this ->data_model ->getBillYjData($ids);
		if (empty($billYjData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->yj_change ,$step ,3);
		
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($billYjData as $v)
		{
			/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
// 			$status = $v['status'] == 1 ? 2 : 3;
// 			$this ->changeStep($step, $v['id'], $this->yj_change, $status);
		
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 3: //供应商
									$content = str_replace('{#EMPLOYEENAME#}', $name , $item['content']);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 联盟修改外交佣金
	 * @author jkr
	 * @param string $ids 外交佣金表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function billWjChange($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$billWjData = $this ->data_model ->getBillWjData($ids);
		if (empty($billWjData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->wj_change ,$step ,3);
		
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($billWjData as $v)
		{
			/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
// 			$status = $v['status'] == 1 ? 2 : 3;
// 			$this ->changeStep($step, $v['id'], $this->wj_change, $status);
		
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 2: //销售
									$content = str_replace('{#EMPLOYEENAME#}', $name , $item['content']);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 供应商发起订单的应付价格修改
	 * @author jkr
	 * @param string $ids 应付表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function billYfSupplier($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$billYfData = $this ->data_model ->getBillYfData($ids);
		if (empty($billYfData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		if ($billYfData[0]['status'] ==0)
		{
			$belong = 3;
		}
		elseif ($billYfData[0]['status'] == 2)
		{
			$belong = 1;
		}
		else
		{
			$belong = 2;
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->yf_supplier ,$step ,$belong);
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($billYfData as $v)
		{
			/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
			$status = $v['status'] == 2 ? 2 : 3;
			$this ->changeStep($step, $v['id'], $this->yf_supplier, $status);
				
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 2: //销售
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $item['content']);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						case 2:
							if ($v['status'] == 1)
							{
								//审核通过的时候给指定的财务发送一条消息
								$this ->sendYfMsg($v);
							}
							
							switch ($item['user_type'])
							{
								case 3: //供应商
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $item['content']);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$content = str_replace('{#EXPERTNAME#}', $name , $content);
									if ($v['status'] == 3)
									{
										$content = str_replace('{#REASON#}', $v['m_remark'] , $content);
									}
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
								case 5:
									$content = str_replace('{#TIME#}', date('Y-m-d H:i:s' ,time()) , $item['content']);
									$content = str_replace('{#DEPARTNAME#}', $v['depart_name'] , $content);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$url = $item['url'];
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 管家发起订单的应付价格修改
	 * @author jkr
	 * @param string $ids 应付表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function billYfExpert($ids ,$step ,$name)
	{
	if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$billYfData = $this ->data_model ->getBillYfData($ids);
		if (empty($billYfData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		if ($billYfData[0]['status'] ==1)
		{
			$belong = 3;
		}
		elseif ($billYfData[0]['status'] == 2)
		{
			$belong = 1;
		}
		else
		{
			$belong = 2;
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->yf_expert ,$step ,$belong);
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($billYfData as $v)
		{
			/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
			$status = $v['status'] == 2 ? 2 : 3;
			$this ->changeStep($step, $v['id'], $this->yf_expert, $status);
				
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 3: //供应商
									$content = str_replace('{#EXPERTNAME#}', $name , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						case 2:
							if ($v['status'] == 2)
							{
								//审核通过的时候给指定的财务发送一条消息
								$this ->sendYfMsg($v);
							}
							switch ($item['user_type'])
							{
								case 2: //供应商
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $item['content']);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$content = str_replace('{#EXPERTNAME#}', $name , $content);
									if ($v['status'] == 4)
									{
										$content = str_replace('{#REASON#}', $v['s_remark'] , $content);
									}
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
								case 5:
									$content = str_replace('{#TIME#}', date('Y-m-d H:i:s' ,time()) , $item['content']);
									$content = str_replace('{#DEPARTNAME#}', $v['depart_name'] , $content);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$url = $item['url'];
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 营业部经理修改订单应收价格，发送消息通知订单的销售人
	 * @author jkr
	 * @param string $ids 应收表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function billYsManager($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$billYsData = $this ->data_model ->getBillYsData($ids);
		if (empty($billYsData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->ys_manager ,$step ,3);
		
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($billYsData as $v)
		{
			/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
// 			$status = $v['status'] == 1 ? 2 : 3;
// 			$this ->changeStep($step, $v['id'], $this->ys_manager, $status);
				
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 2: //销售
									$content = str_replace('{#EXPERTNAME#}', $name , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 销售申请修改订单应收消息发送
	 * @author jkr
	 * @param string $ids 应收表ID组，以逗分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function billYsUpdate($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取应收账单
		$billYsData = $this ->data_model ->getBillYsData($ids);
		if (empty($billYsData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		if ($billYsData[0]['status'] ==0)
		{
			$belong = 3;
		}
		elseif ($billYsData[0]['status'] == 1)
		{
			$belong = 1;
		}
		else 
		{
			$belong = 2;
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->ys_apply ,$step ,$belong);
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($billYsData as $v)
		{
			/** 有多个步骤的需要执行此方法，用于记录消息步骤，和步骤的状态 */
			$status = $v['status'] == 1 ? 2 : 3;
			$this ->changeStep($step, $v['id'], $this->ys_apply, $status);
			
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['eid'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 1: //经理
									$content = str_replace('{#DEPARTNAME#}', $v['departName'] , $item['content']);
									$content = str_replace('{#EXPERTNAME#}', $v['expert_name'] , $content);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$url = $item['url'];
									break;
							}
							break;
						case 2:
							switch ($item['user_type'])
							{
								case 2: //销售
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $item['content']);
									$content = str_replace('{#MONEY#}', $v['amount'] , $content);
									$content = str_replace('{#EXPERTNAME#}', $name , $content);
									if ($v['status'] == 3)
									{
										$content = str_replace('{#REASON#}', $v['m_remark'] , $content);
									}
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
		
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 取消额度申请的消息处理，只给额度申请的销售发送一条通知消息
	 * @author jkr
	 * @param string $id 额度申请表ID
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function cancelQuotaApply($ids ,$step ,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		
		//获取额度信息
		$quotaData = $this ->data_model ->getApplyQuota($ids);
		if (empty($quotaData))
		{
			$this ->returnMsg(4000 ,'没有获取到额度申请信息');
		}
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this->quota_cancel ,$step ,3);
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($quotaData as $v)
		{
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
		
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 2: //销售
									$content = str_replace('{#EXPERTNAME#}', $name , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
						
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $item['url'], $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 发送有关单团额度处理的消息，分为两个分支消息流程，1：向旅行社申请，2：向供应商申请
	 * @author jkr
	 * @param string $ids 额度申请表ID组，以逗号分隔
	 * @param intval $step 发送步骤
	 * @param string $name 发起人
	 */
	public function applyQuotaMsg($ids,$step,$name)
	{
		if (empty($ids) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$idArr = explode(',', trim($ids,','));
		$this ->sendman = $name;
		
		//获取管家申请的额度信息，一条或多条
		$quotaData = $this ->data_model ->getApplyQuota(trim($ids ,','));
		if (empty($quotaData))
		{
			$this ->returnMsg(4000 ,'没有获取到额度申请信息');
		}
		
		/**第一步有特殊情况，需要先获取营业部经理信息，且第一步是在下单的时候申请额度，只会有一条信息*/
		$step_now = $step;
		if ($step == 1)
		{
			//获取营业部经理
			$managerArr = $this ->data_model ->getDepartManager($quotaData[0]['depart_id']);
			$manager_id = empty($managerArr) ? 0 : $managerArr['id'];
			$this ->manager_name = empty($managerArr['realname']) ? '' : $managerArr['realname'];
			$this ->manager_id = $manager_id;
			
			/***注意啦：在申请额度时，管家是营业部经理的时候，会默认经理通过，所以此情况下从第二步发送***/
			if ($this ->manager_id == $quotaData[0]['expert_id'] && $step ==1)
			{
				$step_now = 2;
				$belong = 1; //第一步是营业部经理，则发送通过的消息
			}
			else
			{
				$belong = 3; //第一步不是营业部经理，则发送普通的消息
			}
		}
		if ($step > 1)
		{
			if ($quotaData[0]['status'] == 1 || $quotaData[0]['status'] == 3)
			{
				$belong = 1;
			}
			else
			{
				$belong = 2;
			}
		}
		
		/**
		 * 注意：同一批的额度申请状态是一致的
		 * 获取需要发送的消息内容，分为两种流程消息
		 */
		//向供应商申请额度的消息内容
		$supplierMsg = $this ->point_model ->getPointContent($this->quota_supplier ,$step_now ,$belong);
		//向旅行社申请额度的消息内容
		$unionMsg = $this ->point_model ->getPointContent($this->quota_union ,$step_now ,$belong);
		
		if (empty($supplierMsg) || empty($unionMsg))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		/***
		 * 发送消息的步骤
		 * 1：获取每条额度申请的消息发送流程，可根据向旅行社申请还是想供应商申请判断
		 * 2：根据每条消息的接收人类型获取到接收人群，供应商，管家，营业部经理都只有一个，旅行社的存在多个接收人
		 * 3：替换消息内容中的变量，然后写入数据库
		 */
		foreach($quotaData as $v)
		{
			//获取当前的额度申请记录的消息发送流程，根据申请对象来判断
			if (empty($v['union_id']))
			{
				$msgData = $supplierMsg;
				$code = $this ->quota_supplier;
			}
			else 
			{
				$msgData = $unionMsg;
				$code = $this ->quota_union;
			}
			
			/**若这是第一步，则需要将消息的步骤写入消息步骤记录表，方便在消息详细中展示*/
			if ($step == 1)
			{
				//获取消息步骤
				$stepArr = $this ->main_model ->getMainStep($code);
				if ($this->manager_id == $v['expert_id'])
				{
					//管家是营业部经理的时候，订单的额度申请回自动进入经理通过状态
					$this ->point_model ->insertSendStep($stepArr ,$v['id'] ,$name ,1);
				}
				else
				{
					$this ->point_model ->insertSendStep($stepArr ,$v['id'] ,$name);
				}
			}
			
			/** 当步骤大于第一步的时候，需要更改消息步骤表记录的状态 **/
			if ($step > 1)
			{
				$whereArr = array(
						'step' =>$step,
						'code' =>$code,
						'type_id' =>$v['id']
				);
				if ($v['status'] == 1 || $v['status'] == 3)
				{
					//经理通过和授信中将消息记录状态改为已通过
					$upArr = array(
							'status' =>2,
							'modtime' =>date('Y-m-d H:i:s'),
							'name' =>$name
					);
					$this ->send_step_model ->update($upArr ,$whereArr);
				}
				elseif ($v['status'] == 2 || $v['status'] == 5)
				{
					//经理拒绝和旅行社拒绝和供应商拒绝将消息记录状态改为已拒绝
					$upArr = array(
							'status' =>3,
							'modtime' =>date('Y-m-d H:i:s'),
							'name' =>$name
					);
					$this ->send_step_model ->update($upArr ,$whereArr);
				}
			}
			
			//发送消息，目前关于额度的消息，不论是向旅行社还是向供应商申请，其消息步骤是一致的
			foreach($msgData as $item)
			{
				$dataArr = array(
						'type' =>$item['user_type'],
						'union_id' =>$v['union_id'],
						'supplier_id' =>$v['supplier_id'],
						'expert_id' =>$v['expert_id'],
						'depart_id' =>$v['depart_id']
				);
				//获取消息接收人
				$peopleArr = $this ->getPeopleArr($dataArr);
				
				$content = ''; //消息内容
				if (!empty($peopleArr))
				{
					//根据步骤替换消息内容的变量
					switch($step_now)
					{
						case 1:
							switch ($item['user_type'])
							{
								case 1: //营业部经理
									$content = str_replace('{#EXPERTNAME#}', $v['expert_name'] , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
								case 2: //销售
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $item['content']);
									$content = str_replace('{#QUOTA#}', $v['credit_limit'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						case 2:
							switch ($item['user_type'])
							{
								case 2: //销售
									$content = str_replace('{#EXPERTNAME#}', $this->manager_name , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									if ($v['status'] == 2)
									{
										//经理拒绝
										$content = str_replace('{#REASON#}', $v['m_remark'] , $content);
									}
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
								case 3: //供应商
									$content = str_replace('{#EXPERTNAME#}', $v['expert_name'] , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$content = str_replace('{#APPLYID#}', $v['code'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
								case 5: //联盟财务
									$content = str_replace('{#EXPERTNAME#}', $v['expert_name'] , $item['content']);
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $content);
									$content = str_replace('{#APPLYID#}', $v['code'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						case 3:
							switch ($item['user_type'])
							{
								case 2: //销售
									//目前审核通过和拒绝发送的消息，变量一样
									$content = str_replace('{#ORDERSN#}', $v['ordersn'] , $item['content']);
									$content = str_replace('{#EMPLOYEENAME#}', $this->sendman , $content);
									$content = str_replace('{#REASON#}', $v['reply'] , $content);
									$url = str_replace('{#ORDERID#}', $v['order_id'] , $item['url']);
									break;
							}
							break;
						default:
							$this ->returnMsg(4000 ,'未知的送步骤');
							break;
					}
					
					if (!empty($content))
					{
						//写入消息
						$this ->addSendMsg($item, $content, $url, $peopleArr ,$v['id']);
					}
				}
			}
		}
	}
	
	/**
	 * @method 写入消息
	 * @param array $pointArr 消息信息
	 * @param string $content 消息内容
	 * @param string $url 跳转链接
	 * @param array  $peopleArr 消息接收人
	 * @param intval  $typeid 业务ID
	 */
	public function addSendMsg($pointArr,$content ,$url ,$peopleArr ,$typeid)
	{
		$time = date('Y-m-d H:i:s' ,time());
		$msgArr = array(
				'code' =>$pointArr['code'],
				'point_id' =>$pointArr['id'],
				'title' =>$pointArr['title'],
				'content' =>$content,
				'url' =>$url,
				'sendman' =>$this ->sendman,
				'addtime' =>$time,
				'modtime' =>$time,
				'status' =>0,
				'type' =>$pointArr['main_type'],
				'type_id' =>$typeid
		);
		$id = $this ->send_model ->insert($msgArr);
		foreach($peopleArr as $v)
		{
			$v['send_id'] = $id;
			$this ->people_model ->insert($v);
		}
	}
	
	/**
	 * @method 获取接收人
	 * @param array $paramArr = array(
	 * 		'type' =>'接收人类型',
	 * 		'union_id' =>'旅行社ID',
	 * 		'expert_id' =>'管家ID',
	 * 		'supplier_id' =>'供应商ID',
	 * 		'depart_id' =>'营业部ID'
	 * );
	 */
	public function getPeopleArr($paramArr)
	{
		$peopleArr = array();
		switch($paramArr['type'])
		{
			case 1: //接收人身份营业部经理
				//获取营业部经理
				if ($this ->manager_id == 0)
				{
					$managerArr = $this ->data_model ->getDepartManager($paramArr['depart_id']);
					$manager_id = empty($managerArr) ? 0 : $managerArr['id'];
					$this ->manager_name = empty($managerArr['realname']) ? '' : $managerArr['realname'];
					$this ->manager_id = $manager_id;
				}
				$peopleArr[] = array('user_type'=>$paramArr['type'] ,'user_id' =>$this ->manager_id);
				break;
			case 2: //接收人身份营业部销售
				$peopleArr[] = array('user_type'=>$paramArr['type'] ,'user_id' =>$paramArr['expert_id']);
				break;
			case 3: //接收人身份供应商
				$peopleArr[] = array('user_type'=>$paramArr['type'] ,'user_id' =>$paramArr['supplier_id']);
				break;
			case 4: //接收人身份联盟管理人员
			case 5: //接收人身份联盟财务人员
			case 6: //接收人身份联盟运营人员
				$this ->load_model('msg/b_employee_msg_model' ,'employee_model');
				$employeeArr = $this ->employee_model ->getUnionEmployee($paramArr['union_id'] ,$paramArr['type']);
				if (!empty($employeeArr))
				{
					foreach($employeeArr as $v)
					{
						$peopleArr[] = array('user_type'=>$paramArr['type'] ,'user_id' =>$v['employee_id']);
					}
				}
				break;
			default:
				break;
		}
		return $peopleArr;
	}
	
	/**
	 * @method 记录消息步骤，修改消息记录状态
	 * @param unknown $step 步骤
	 * @param unknown $type_id 业务ID
	 * @param unknown $code 消息编号
	 * @param unknown $status 消息步骤状态
	 */
	public function changeStep($step ,$type_id ,$code ,$status)
	{
		/**若这是第一步，则需要将消息的步骤写入消息步骤记录表，方便在消息详细中展示*/
		if ($step == 1)
		{
			//获取消息步骤
			$stepArr = $this ->main_model ->getMainStep($code);
			//防止没有配置消息步骤
			if ($stepArr[0]['step'])
			{
				$this ->point_model ->insertSendStep($stepArr ,$type_id ,$this->sendman);
			}
		}
		/** 当步骤大于第一步的时候，需要更改消息步骤表记录的状态 **/
		if ($step > 1)
		{
			$whereArr = array(
					'step' =>$step,
					'code' =>$code,
					'type_id' =>$type_id
			);
			$upArr = array(
					'status' =>$status,
					'modtime' =>date('Y-m-d H:i:s' ,time()),
					'name' =>$this->sendman
			);
			$this ->send_step_model ->update($upArr ,$whereArr);
		}
	}
	
	/**
	 * @method 返回信息
	 * @param unknown $code
	 * @param unknown $msg
	 */
	public function returnMsg($code,$msg)
	{
		$dataArr = array(
				'code' =>$code,
				'msg' =>$msg
		);
		return $dataArr;
	}
}
