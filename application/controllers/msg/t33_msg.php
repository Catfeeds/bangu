<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		jkr
 * @method 		t33系统消息发送
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class T33_msg extends MY_Controller {
	/**定义消息编号，用于获取消息发送信息***/
	public $new_line = 'new_line';//线路审核消息
	
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
	 * @method 退款系统消息发送
	 * @param unknown $id 退款表ID
	 * @param unknown $step 发送步骤
	 * @param unknown $name  发起人
	 * @param unknown $isManager 是否是经理，第一步时需要
	 */
	public function sendMsgLine($id ,$step ,$name)
	{
		if (empty($id) || empty($step) || empty($name))
		{
			$this ->returnMsg(4000 ,'缺少参数');
		}
		$this ->sendman = $name;
		//获取线路信息
		$lineData = $this ->data_model ->getLineData($id);
		if (empty($lineData))
		{
			$this ->returnMsg(4000 ,'没有获取数据');
		}
		
		if($lineData['status'] == 1)
		{
			$belong = 3;//发送的消息类型
			$status = 2;
		}
		elseif ($lineData['status'] ==2)
		{
			$belong = 1;
			$status = 2;
		}
		else 
		{
			$belong = 2;
			$status = 3;
		}
		
		if ($step == 1)
		{
			//记录消息步骤
			$this ->recordStep($lineData['id'], $this ->new_line);
		}
		//更改消息记录的状态
		$this ->changeStepStatus($step, $lineData['id'], $this ->new_line, $status);
		
		//获取要发送的消息
		$msgData = $this ->point_model ->getPointContent($this ->new_line ,$step ,$belong);
		if (empty($msgData))
		{
			$this ->returnMsg(4000, '缺少发送的消息');
		}
		
		foreach($msgData as $item)
		{
			$dataArr = array(
					'type' =>$item['user_type'],
					'union_id' =>$lineData['union_id'],
					'supplier_id' =>$lineData['supplier_id'],
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
							case 6: //联盟运营人员
								$content = str_replace('{#COMPANYNAME#}', $this->sendman , $item['content']);
								$content = str_replace('{#LINECODE#}', $lineData['linecode'] , $content);
								break;
						}
						break;
					case 2:
						switch ($item['user_type'])
						{
							case 3: //供应商
								$content = str_replace('{#EMPLOYEENAME#}', $this->sendman , $item['content']);
								$content = str_replace('{#LINECODE#}', $lineData['linecode'] , $content);
								$content = str_replace('{#REASON#}', $lineData['remark'] , $content);
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
					$this ->addSendMsg($item, $content, $item['url'], $peopleArr ,$lineData['id']);
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
	 * @method 记录消息步骤，消息流程有多个步骤且再第一步时请求此发送
	 * @param unknown $type_id 业务ID 
	 * @param unknown $code 消息编号
	 */
	public function recordStep($type_id ,$code)
	{
		$stepArr = $this ->main_model ->getMainStep($code);
		$this ->point_model ->insertSendStep($stepArr ,$type_id ,$this->sendman);
	}
	/**
	 * @method 记录消息步骤，修改消息记录状态
	 * @param unknown $step 步骤
	 * @param unknown $type_id 业务ID
	 * @param unknown $code 消息编号
	 * @param unknown $status 消息步骤状态
	 */
	public function changeStepStatus($step ,$type_id ,$code ,$status)
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
