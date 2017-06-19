<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月23日15:36:00
 * @author		贾开荣
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	include_once './application/controllers/msg/t33_send_msg.php';
class Order_info extends UC_NL_Controller
{
	public function __construct()
	{
		parent::__construct ();
		//set_error_handler('customError');
		$this->load->library ( 'callback' );
		$this->load->model ( 'order_model');
		$this ->load_model('line_model' ,'line_model');
		$this ->load_model('common/u_line_suit_price_model' ,'suit_price_model');
		$this ->load_model('common/u_line_apply_model' ,'apply_model');
		$this ->load_model('common/u_supplier_model' ,'supplier_model');
		$this ->load_model('travel_insurance_model' ,'insurance_model');
	}

	//验证线路信息
	public function verification_info()
	{
		$lineid = intval($this->input->post ( 'line_id' )); // 线路id
		$suitid = intval($this->input->post ( 'suit_id' )); // 套餐id
		$childnum = intval($this->input->post ( 'childnum' )); // 儿童人数
		$adultnum = intval($this->input->post ( 'adultnum' )); // 成人数量
		$oldnum = intval($this ->input ->post('oldNums'));//老人
		$childnobednum = intval($this ->input ->post('childnobedNums'));//儿童不占床

		$usedate = $this->input->post ( 'usedate' ,true ); // 出团日期
		$new_date = date('Y-m-d' ,$_SERVER['REQUEST_TIME']); //今日
		if($new_date >= $usedate)
		{
			$this->callback->setJsonCode ( 4000 ,'请选择出团日期');
		}

// 		if (!file_exists('./error'))
// 		{
// 			mkdir('./error' ,0755);
// 		}
// 		$filename = './error/'.date('Ymd' ,time()).'.txt';
// 		$file = fopen($filename ,'a+');
// 		fwrite($file,'start:ok;------');
		//验证线路
		$lineData = $this ->getLineData($lineid ,$usedate);
		//验证套餐
		$suitData = $this ->getSuitPriceData($lineid, $suitid, $usedate);
		if ($adultnum < 1)
		{
			$msg = $suitData['unit'] > 1 ? '请填写套餐份数' : '出游必须有成人';
			$this->callback->setJsonCode ( 4000 ,$msg);
		}
		//验证套餐的余位
		$countNum = $suitData['unit'] == 1 ? $adultnum : $adultnum + $childnum +$oldnum;
		if ($countNum > $suitData['number'])
		{
			$this->callback->setJsonCode ( 4000 ,'余位不足，当前套餐还有'.$suitData['number'].'个位置');
		}
		//判断是否有服务管家
		$this ->isLineExpert($lineid);
		//判断商家
		$this ->getSupplierData($lineData['supplier_id']);
		//将信息保存到session中
		$data = array(
				'lineid' => $lineid,
				'suitid' => $suitid,
				'childnum' => $childnum,
				'adultnum' => $adultnum,
				'oldnum' =>$oldnum,
				'childnobednum' =>$childnobednum,
				'usedate' => $usedate
		);
		$this->session->set_userdata ( array('lineOrder' =>$data) );
		//fclose($file);
		$this->callback->setJsonCode ( 2000 ,'验证成功');
	}

	//管家下单
	public function order_basic()
	{
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
		$this ->load_model('expert_model');
		$this ->load ->helper ('my_text');
		$this->load->model ( 'dictionary_model', 'dictionary_model' );

		$dayId = intval($this ->input ->get('day_id'));
		$expertId = intval($this ->input ->get('expert_id'));
		
		$eid = $this ->session ->userdata('expert_id');
		if ($expertId != $eid)
		{
			echo '<script>alert("您没有登录管家系统");window.close();</script>';exit;
		}
		
		$lineId = 0;
		$data = array();
		//获取套餐
		$whereArr = array(
				'sp.dayid' =>$dayId
		);
		$suitPrice = $this ->suit_price_model ->getSuitPriceDetail($whereArr);

		if (!empty($suitPrice))
		{
			$data['suitPrice'] = $suitPrice[0];
			$lineId = $suitPrice[0]['lineid'];
		}
		else
		{
			echo '<script>alert("线路不存在");window.close();</script>';exit;
		}
		if ($suitPrice[0]['number'] < 1) {
			echo '<script>alert("余位不足");window.close();</script>';exit;
		}
		//判断价格信息
		if ($suitPrice[0]['adultprice'] <0 ) {
			echo '<script>alert("价格设置不正确");window.close();</script>';exit;
		}

		//获取当前管家信息
		$expertData = $this ->expert_model ->row(array('id' =>$expertId));
		
		if (empty($expertData))
		{
			echo '<script>alert("管家不存在");window.close();</script>';exit;
		}
		//管家所在营业部信息
		if ($expertData['depart_id'] < 1)
		{
			echo '<script>alert("管家不是营业部所属管家");window.close();</script>';exit;
		}
		
		$departData = $this ->depart_model ->row(array('id' =>$expertData['depart_id']));
		if (empty($departData) || $departData['status'] != 1)
		{
			echo '<script>alert("管家所在营业部不存在或已停用");window.close();</script>';exit;
		}
		
		//获取线路信息
		$lineData = $this->getLineData($lineId ,$suitPrice[0]['day'] ,true) ;

		if (empty($lineData)) {
			echo '<script>alert("线路不存在");window.close();</script>';exit;
		}

		if ($lineData['line_kind'] == 2 || $lineData['line_kind'] == 3)
		{
			//此线路是单项产品
			$data['suitPrice']['unit'] = 1;
		}
		else
		{
			if ($suitPrice[0]['unit'] < 1) {
				echo '<script>alert("套餐人数设置错误");window.close();</script>';exit;
			}
		}
		//var_dump($lineData);
		//获取线路类型和证件类型
		if ($lineData['line_classify'] == 1)
		{
			//$data['linetype'] = 1; //境外
			$data['certificate'] = $this ->dictionary_model ->get_dictionary_data(sys_constant::DICT_ABROAD_CERTIFICATE_TYPE);
		}
		else
		{
			//$data['linetype'] = 2; //境内
			$data['certificate'] = $this ->dictionary_model ->get_dictionary_data(sys_constant::DICT_DOMESTIC_CERTIFICATE_TYPE);
		}
		
		$data['linetype'] = $lineData['line_classify'] == 1 ? 1 : 2;
		
		//网站配置
		$data['webData'] = $this ->web_model ->getOrderWebData();
		//供应商
		$data['supplier'] = $this ->getSupplierData($lineData['supplier_id']);

		$startData = $this ->startplace_model ->getLineStartCity($lineId);
		$cityname = '';
		if (!empty($startData))
		{
			foreach($startData as $v)
			{
				$cityname .= $v['name'].',';
			}
		}
		$data['cityname'] = rtrim($cityname ,',');
		//获取线路保险
		$whereArr = array(
				't.insurance_date' =>$lineData ['lineday'],
				't.insurance_type' =>$data['linetype'],
				't.status' =>1
		);
		//获取营业部银行卡信息
		$data['bankData'] = $this ->order_model ->getDepartBank($expertData['union_id']);

		//获取上传地点
		$data['onCar'] = $this ->order_model ->getLineOnCar($lineId);
		
		//$data['insuranceData'] = $this ->insurance_model ->getLineInsurance($whereArr);
		//目前不开放保险
		$data['insuranceData'] = array();
		$data['line'] = $lineData;
		$data['expert'] = $expertData;
		$data['depart'] = $departData;
		$this->load->view ( 'order/order_basic'  ,$data);
	}

	//调试信息
	public function debugging($content)
	{
		if (!file_exists('./msgtest'))
		{
			mkdir('./msgtest' ,0755);
		}
		$filename = './msgtest/'.date('Ymd' ,time()).'.txt';
		$file = fopen($filename ,'a+');
		fwrite($file,'(***'.$content.'***)');
	
		fclose($file);
	}
	
	//下单时验证管家并获取管家数据 type为true代表管家下单
	public function vfGetExpert($expertId , $type =false )
	{
		$this ->load_model('expert_model');
		$expertData = $this ->expert_model ->row(array('id' =>$expertId));
		$sql = $this ->db ->last_query();
		
		if (empty($expertData))
		{
			$this->callback->setJsonCode ( 4000 ,'管家不存在');
		}
		if ($type == true && $expertData['depart_id'] < 1)
		{
			$this->callback->setJsonCode ( 4000 ,'管家不是营业部管家，不可下单');
		}
		return $expertData;
	}
	//获取营业部并验证
	public function getDepart($departid)
	{
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
		$departData = $this ->depart_model ->row(array('id' =>$departid));
		if (empty($departData))
		{
			$this->callback->setJsonCode ( 4000 ,'管家所属营业部不存在');
		}
		return $departData;
	}

	//获取外交佣金
	public function getDiplomaticAgent($unionid,$supplierid ,$overcity ,$adultnum ,$oldnum ,$childnobed ,$childnum)
	{
		$diplomatic_agent =0;
		$diplomaticArr = array(
				'adultprice' =>0,
				'oldprice' =>0,
				'childprice' =>0,
				'childnobedprice' =>0,
				'destid' =>0,
				'kind' =>4
		);
		
		$this ->load_model('admin/t33/b_company_supplier_model' ,'company_model');
		$whereArr = array(
				'union_id' =>$unionid,
				'supplier_id' =>$supplierid,
				'status' => 1
		);
		//查询供应商与旅行社的关系
		$companyData = $this ->company_model ->row($whereArr);
		if (empty($companyData) && !empty($overcity))
		{
			//获取旅行社设置的目的地的外交佣金
			$agentData = $this ->order_model ->getForeignAgent(trim($overcity,',') ,$unionid);
			$agentArr = array();
			if (!empty($agentData))
			{
				foreach($agentData as $k =>$v)
				{
					$agentArr[$v['dest_id']] = $v;
				}
				$overcityArr = explode(',', $overcity);
				foreach($overcityArr as $v)
				{
					if (array_key_exists($v, $agentArr))
					{
						$diplomaticArr = array(
								'adultprice' =>$agentArr[$v]['adult_agent'],
								'oldprice' =>$agentArr[$v]['old_agent'],
								'childprice' =>$agentArr[$v]['child_agent'],
								'childnobedprice' =>$agentArr[$v]['childnobed_agent'],
								'destid' =>$v
						);
						$diplomatic_agent = round($adultnum*$agentArr[$v]['adult_agent'] +$oldnum*$agentArr[$v]['old_agent'] + $childnobed*$agentArr[$v]['childnobed_agent'] +$childnum*$agentArr[$v]['child_agent'] ,2);
						break;
					}
				}
			}
		}
		$dataArr = array(
			'diplomatic_agent' =>$diplomatic_agent,
			'diplomaticArr' =>$diplomaticArr
		);
		return $dataArr;
	}
	//获取营业部经理信息
	public function getManagerArr($expertData)
	{
		if ($expertData['is_dm'] != 1) {
			$whereArr = array(
					'is_dm' =>1,
					'depart_id' =>$expertData['depart_id']
			);
			$expertArr = $this ->expert_model ->row($whereArr);
			if (empty($expertArr))
			{
				//查询此营业部上级
				$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
				$departData = $this ->depart_model ->getDepartParent($expertData['depart_id']);
				if (empty($departData))
				{
					//没有上级营业部
					$this ->callback ->setJsonCode(4000 ,'没有营业部经理，不可下单');
				}
				else
				{
					//获取上级营业部的经理
					$whereArr = array(
							'is_dm' =>1,
							'depart_id' =>$departData['id']
					);
					$expertArr = $this ->expert_model ->row($whereArr);
					if (empty($expertArr))
					{
						$this ->callback ->setJsonCode(4000 ,'没有营业部经理，不可下单');
					}
					return $expertArr;
				}
			}
			else
			{
				return $expertArr;
			}
		}
		else
		{
			return $expertData;
		}

	}

	//生成申请额度编号
	protected function createCodeApply()
	{
		$strArr = range('A' ,'Z');
		$code = $strArr[mt_rand(0,25)].mt_rand(100000,999999);
		$this ->load_model('admin/t33/b_limit_apply_model' ,'limit_apply_model');
		$applyData = $this ->limit_apply_model ->row(array('code' =>$code));
		if (!empty($applyData)) {
			$this ->createCodeApply();
		}
		return $code;
	}

	/**
	 * @method 验证联系人信息
	 * @param unknown $username 联系人名称
	 * @param unknown $mobiel 联系人手机
	 * @param unknown $email 联系人邮箱
	 */
	public function linkmanInfo($username ,$mobiel ,$email)
	{
		if (empty($username))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写联系人名称');
		}
		if (!regexp('mobile' ,$mobiel))
		{
			$this->callback->setJsonCode ( 4000 ,'请输入正确的手机号');
		}
		if (!empty($email) && !regexp('email' ,$email))
		{
			$this->callback->setJsonCode ( 4000 ,'请输入正确的邮箱号');
		}
	}
	
	/**
	 * @method 获取线路套餐信息,同时验证余位是否充足
	 * @param intval $dayid 套餐价格表ID
	 * @param intval $lineid 线路ID
	 * @param intval $num 订单总人数(套餐线路则是份数，非套餐线路则是总人数)
	 * @param intval $kind 线路类型 
	 * @return 线路的套餐价格信息
	 */
	public function getSuitInfo($dayid ,$lineid ,$num ,$kind)
	{
		$suitData = $this ->line_model ->getLineSuit($dayid ,$lineid);
		if (empty($suitData))
		{
			$this ->callback ->setJsonCode(4000 ,'您选择的套餐不存在，请确认');
		}
		if ($suitData['before_day'] == 0 && $suitData['hour']==0 && $suitData['minute']==0)
		{
			$endtime = strtotime($suitData['day'].' 23:59:59');
		}
		else 
		{
			//判断截止日期
			$endtime = (strtotime($suitData['day'])-$suitData['before_day']*24*3600)+$suitData['hour']*3600+$suitData['minute']*60;
		}
		if($kind == 1 && $endtime < time())
		{
			$this ->callback ->setJsonCode(4000 ,'线路已停止报名');
		}
		
		//总人数-余位
		$surplus = $num - $suitData['number'];
		if ($surplus > 0.1)
		{
			//余位不足
			if (isset($suitData['unit']) && $suitData['unit'] > 1)
			{
				$this->callback->setJsonCode ( 4000 ,'此线路套餐份数剩余：'.$suitData['number'].'份');
			}
			else 
			{
				$this->callback->setJsonCode ( 4000 ,'此线路余位剩余：'.$suitData['number'].'个');
			}
		}
		return $suitData;
	}
	
	/**
	 * @method 查询旅行社与供应商是否是直属关系
	 * @param unknown $unionId 旅行社ID
	 * @param unknown $supplieId 供应商ID
	 * @return true(是直属关系)/false(不是直属关系)
	 */
	public function isDirectlyUnder($unionId ,$supplierId)
	{
		$this ->load_model('admin/t33/b_company_supplier_model' ,'company_model');
		$whereArr = array(
				'union_id' =>$unionId,
				'supplier_id' =>$supplierId,
				'status' => 1
		);
		$companyData = $this ->company_model ->row($whereArr);
		if (empty($companyData))
		{
			return false;//不是直属关系
		}
		else
		{
			return true;//是直属关系
		}
	}
	
	/**
	 * @method 获取由供应商添加的产品的管理费,(t33下单给到旅行社)
	 * 管理费的收取方式：
	 * 		供应商的正常线路和供应商添加的单项，收取管理费按照旅行社设置的供应商佣金收取，收取类型分为：按人群，按比例，按天数三种
	 * @param intval $unionId 旅行社ID
	 * @param intval $supplierId 供应商ID
	 * @param intval $price 订单价格
	 * @param intval $adultnum 成人人数
	 * @param intval $oldnum 老人人数
	 * @param intval $childnum 儿童占床人数
	 * @param intval $childnobed 儿童不占床人数
	 * @param array $lineData 线路数据
	 */
	public function getSupplierLineFee($unionId,$supplierId,$lineData,$price,$adultnum,$oldnum,$childnum,$childnobed)
	{
		$fee = 0;//管理费
		//初始化数值
		$agentArr = array(
				'type' =>0, //收取类型
				'adult' =>0,//成人佣金
				'old' =>0,//老人佣金
				'child' =>0,//小孩佣金
				'childnobed' =>0,//小孩不占床佣金
				'agent_rate' =>0,//收取的佣金比例
				'money' =>0//按天数收取的佣金
		);
		if ($lineData['line_kind'] == 1)
		{
			if ($lineData['producttype'] == 0)
			{
				//正常线路去散客方式收取管理费
				$type = 1;
				$agentData = $this ->order_model ->getUnionLineAgent($unionId ,$supplierId ,1);
			}
			else 
			{
				//包团线路取包团方式收取管理费
				$type = 2;
				$agentData = $this ->order_model ->getUnionLineAgent($unionId ,$supplierId ,2);
			}
		}
		else 
		{
			//供应商单项产品取散客收取管理费
			$type = 1;
			$agentData = $this ->order_model ->getUnionLineAgent($unionId ,$supplierId ,1);
		}
		
		if (!empty($agentData))
		{
			switch($agentData['type'])
			{
				case 1://人群，成人，老人.....
					$fee = round($adultnum*$agentData['man'] + $oldnum*$agentData['oldman'] + $childnum*$agentData['child'] + $childnobed*$agentData['childnobed'] ,2);
					break;
				case 2://比例  总价格*比例
					$fee = round($price * $agentData['agent_rate'] ,2);
					break;
				case 3://天数
					$dayFee = $this ->order_model ->getUnionLineDay($supplierId ,$lineData['lineday'] ,$unionId ,$type);
					if (!empty($dayFee))
					{
						$agentData['money'] = $dayFee['money'];
						$agentData['money_child'] = $dayFee['money_child'];
						$agentData['money_childbed'] = $dayFee['money_childbed'];
						//$fee = round(($adultnum+$childnobed+$childnum+$oldnum)*$dayFee['money'] ,2);
						$fee = round($adultnum*$dayFee['money']+$childnobed*$dayFee['money_child']+$childnum*$dayFee['money_childbed'],2);
					}
					else 
					{
						$agentData['money'] = 0;
						$agentData['money_child'] = 0;
						$agentData['money_childbed'] = 0;
					}
					break;
				default:
					$this ->callback ->setJsonCode(4000 ,'未知的管理费收取方式');
					break;
			}
			$agentData['adult'] = $agentData['man'];
			$agentData['old'] = $agentData['oldman'];
			$dataArr = array(
					'fee' =>$fee,
					'agentArr' =>empty($agentData) ? $agentArr : $agentData
			);
			return $dataArr;
		}
		else 
		{
			return false;
		}
	}
	
	/**
	 * @method 旅行社添加的单项产品，佣金费计算
	 * @param unknown $lineId 线路ID
	 * @param unknown $price 订单价格
	 * @param unknown $adultnum 成人数量
	 * @param unknown $oldnum 老人数量
	 * @param unknown $childnobed 儿童不占床数量
	 * @param unknown $childnum 儿童占床数量
	 */
	public function getUnoinLineFee($lineId,$price,$adultnum,$oldnum,$childnobed,$childnum)
	{
		$fee = 0;
		$singleAgent = $this ->order_model ->getSingleAgent($lineId);
		
		if (!empty($singleAgent))
		{
			switch($singleAgent['type'])
			{
				case 1: //按人群
					$fee =round($adultnum*$singleAgent['adult']+$oldnum*$singleAgent['old']+$childnobed*$singleAgent['childnobed']+$childnum*$singleAgent['child'],2);
					break;
				case 2: //按比例
					$fee = round($price*$singleAgent['agent_rate'] ,2);
					break;
				default:
					$this ->callback ->setJsonCode(4000 ,'未知的管理费收取方式');
					break;
			}
			
			if ($singleAgent['object'] != 1 && $singleAgent['object'] != 2)
			{
				$this ->callback ->setJsonCode(4000 ,'管理费收取对象不明确');
			}
			//返回的信息
			$dataArr = array(
					'fee' =>$fee,
					'object' =>$singleAgent['object'],
					'agentArr' =>array(
							'type' =>$singleAgent['type'], //收取类型
							'adult' =>$singleAgent['adult'],//成人佣金
							'old' =>$singleAgent['old'],//老人佣金
							'child' =>$singleAgent['child'],//小孩佣金
							'childnobed' =>$singleAgent['childnobed'],//小孩不占床佣金
							'agent_rate' =>$singleAgent['agent_rate']//收取的佣金比例
					)
			);
			return $dataArr;
		}
		else 
		{
			return false;
		}
		
	}
	
	/**
	 * @method 验证管家额度申请，并返回申请数据
	 * @param array $expertData 管家信息
	 * @param array $departData 营业部信息
	 * @param intval $supplierid 供应商ID
	 * @param array $managerArr 经理信息
	 */
	public function getApplyQuota($expertData ,$departData ,$supplierid ,$managerArr)
	{
		$applyType = intval($this ->input ->post('applyType')); //管家申请额度的申请对象类型，1：向旅行社申请，2：向供应商申请
		$quota = floatval($this ->input ->post('applyQuota')); //管家申请的额度
		$return_time = trim($this ->input ->post('returnTime' ,true)); //管家申请额度的还款时间
		$remark = trim($this ->input ->post('remarkText' ,true)); //管家申请额度备注
		
		if ($applyType != 1 && $applyType != 2)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择额度申请对象');
		}
		if (empty($return_time))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择还款日期');
		}
		else 
		{
			$now_time = date('Y-m-d' ,time());
			if ($return_time <= $now_time)
			{
				$this ->callback ->setJsonCode(4000 ,'还款日期要在今日之后');
			}
		}
		if (empty($remark))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写申请理由');
		}
		if ($quota < 0)
		{
			$this->callback->setJsonCode ( 4000 ,'请填写申请的信用额度');
		}
		
		$time = date('Y-m-d H:i:s' ,time());
		$applyArr = array(
				'depart_id' =>$departData['id'],
				'depart_name' =>$departData['name'],
				'expert_id' =>$expertData['id'],
				'expert_name' =>$expertData['realname'],
				'manager_id' =>$managerArr['id'],
				'manager_name' =>$managerArr['realname'],
				'credit_limit' =>$quota,
				'addtime' => $time,
				'modtime' =>$time,
				'remark' =>$remark,
				'status' =>$expertData['is_dm'] == 1 ? 1 :0,
				'return_time' =>$return_time,
				'm_addtime' =>$time,
				'code' =>$this ->createCodeApply()
		);
		if ($applyType == 1) {
			$applyArr['union_id'] = $expertData['union_id'];
		} else {
			$applyArr['supplier_id'] = $supplierid;
		}
		return $applyArr;
	}
	
	/**
	 * @method 验证在线交款信息，并返回
	 * @param array $expertData 管家信息
	 * @param array $departData 营业部信息
	 */
	public function getReceivableInfo($expertData ,$departData)
	{
		
		$money = trim($this ->input ->post('rb_money' ,true));
		$remark = trim($this ->input ->post('rb_remark' ,true));
		$way = trim($this ->input ->post('rb_way' ,true));
		$code_pic = trim($this ->input ->post('rb_pic' ,true));
		$bankname = trim($this ->input ->post('rb_bankname' ,true));
		$bankcard = trim($this ->input ->post('rb_bankcard' ,true));
		
		if ($way != '转账' && $way != '现金')
		{
			$this->callback->setJsonCode ( 4000 ,'请选择交款方式');
		}
		
		if ($way == '转账') {
			if (empty($bankname))
			{
				$this->callback->setJsonCode ( 4000 ,'请填写银行名称');
			}
			if (empty($bankcard))
			{
				$this->callback->setJsonCode ( 4000 ,'请填写银行账号');
			}
		}
		
		$receivabelArr = array(
				'expert_id' =>$expertData['id'],
				'depart_id' =>$departData['id'],
				'money' =>$money,
				'way' =>$way,
				'remark' =>$remark,
				'status' =>0,
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'code_pic' =>$code_pic,
				'bankname' =>$bankname,
				'bankcard' =>$bankcard,
				'union_id' =>$departData['union_id'],
				'union_name' =>$departData['union_name']
		);
		return $receivabelArr;
	}
	
	
	/**
	 * @method 获取出游人信息
	 * @param unknown $suitData
	 * @param unknown $lineData
	 */
	public function getPeopleInfo()
	{
		$traverArr = array(
				'name' =>$this->security->xss_clean($_POST['name']),
				'sex' =>$this->security->xss_clean($_POST['sex']),
				'card_type' =>$this->security->xss_clean($_POST['card_type']),
				'card_num' =>$this->security->xss_clean($_POST['card_num']),
				'birthday' =>$this->security->xss_clean($_POST['birthday']),
				'tel' =>$this->security->xss_clean($_POST['tel']),
				'enname' =>isset($_POST['enname']) ? $this->security->xss_clean($_POST['enname']) : array(),
				'sign_place' =>isset($_POST['sign_place']) ? $this->security->xss_clean($_POST['sign_place']) : array(),
				'sign_time' =>isset($_POST['sign_time']) ? $this->security->xss_clean($_POST['sign_time']) : array(),
				'endtime' =>isset($_POST['endtime']) ? $this->security->xss_clean($_POST['endtime']) : array(),
				'people_type' =>$this->security->xss_clean($_POST['people_type']),
		);
		return $traverArr;
	}
	
	/**
	 * @method 获取线路信息
	 * @param intval $lineid 线路ID
	 */
	public function getLineInfo($lineid)
	{
		$lineData = $this ->order_model ->getUnionLine($lineid);
		if (empty($lineData))
		{
			$this->callback->setJsonCode ( 4000 ,'您选择的线路不存在或已下线');
		}
		if ($lineData['line_kind'] != 1 && $lineData['line_kind'] != 2 && $lineData['line_kind'] != 3)
		{
			$this ->callback ->setJsonCode(4000 ,'未能识别的线路类型');
		}
		
		return $lineData;
	}
	
	//管家下单
	public function createOrderB2_test()
	{
		ini_set('default_socket_timeout', -1);
		set_time_limit(0);
		
		$this->load->helper ( 'regexp' );
		
		$mobile = trim($this ->input ->post('mobile' ,true)); //联系人手机
		$username = trim($this ->input ->post('username' ,true)); //联系人姓名
		$email = trim($this ->input ->post('email' ,true));//联系人邮箱
		
		$adultnum = intval($this ->input ->post('dingnum')); //成人数量
		$childnum = intval($this ->input ->post('childnum')); //儿童占床数量
		$childnobed = intval($this ->input ->post('childnobednum')); //儿童不占床数量
		$oldnum = intval($this ->input ->post('oldnum')); //老人数量
		
		$lineid = intval($this ->input ->post('lineid')); //线路ID
		$suitid = intval($this ->input ->post('suitid')); //线路的套餐ID
		$dayid = intval($this ->input ->post('suitPriceId')); //线路套餐价格ID
		$expert_id = intval($this ->input ->post('expert_id')); //管家ID
		
		$spare_mobile = trim($this ->input ->post('spare_mobile' ,true));//备用手机
		$spare_remark = trim($this ->input ->post('spare_remark' ,true));//备注
		
		$isBalance = intval($this ->input ->post('isBalance')); //是否使用营业部现金余额交款，1：使用余额交款，0：否
		
		$cash = floatval($this ->input ->post('cash')); //使用营业部现金余额交款的金额
		
		$rb_money = floatval($this ->input ->post('rb_money')); //管家交款金额
// 		$rb_remark = trim($this ->input ->post('rb_remark' ,true)); //管家交款备注
// 		$rb_way = trim($this ->input ->post('rb_way' ,true)); //管家交款方式
// 		$rb_bankname = trim($this ->input ->post('rb_bankname' ,true)); //管家交款银行
// 		$rb_bankcard = trim($this ->input ->post('rb_bankcard' ,true)); //管家交款账号
// 		$rb_pic = trim($this ->input ->post('rb_pic' ,true)); //管家交款流水单
		
 		$apply_type = intval($this ->input ->post('applyType')); //管家申请额度的申请对象类型，1：向旅行社申请，2：向供应商申请
		$apply_quota = floatval($this ->input ->post('applyQuota')); //管家申请的额度
// 		$return_time = trim($this ->input ->post('returnTime' ,true)); //管家申请额度的还款时间
// 		$remark_text = trim($this ->input ->post('remarkText' ,true)); //管家申请额度备注
		
		$type = intval($this ->input ->post('orderType')); //下单的类型，1:没有申请额度正常下单，2：额度不足申请单团额度，3：临时保存订单
		
		if ($type != 1 && $type != 2 && $type != 3)
		{
			$this ->callback ->setJsonCode(4000 ,'下单类型未识别，请联系客服');
		}
		
		if ($adultnum < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'必须有成人');
		}
		
		//总人数或总份数
		$number = round($adultnum + $childnobed + $childnum + $oldnum);
		
		//订单联系人信息验证,验证内容：联系人姓名必填，联系人手机必填且格式正确，联系人邮箱选填(若填写则验证格式)
		$this ->linkmanInfo($username ,$mobile ,$email);
		
		//验证线路
		$lineData = $this->getLineInfo($lineid) ;
		
		//获取套餐信息
		$suitData = $this ->getSuitInfo($dayid ,$lineid ,$number ,$lineData['line_kind']);
		
		//供应商验证
		$supplierData = $this ->getSupplierData($lineData['supplier_id']);
		
		//管家验证
		$expertData =$this ->vfGetExpert($expert_id ,true);

		//总价格
		$money = $this ->getCountMoney($suitData, $adultnum, $childnum, $childnobed, $oldnum);

		//获取营业部数据
		$departData = $this ->getDepart ($expertData['depart_id']);
		
		//获取营业部经理(还需要优化优化)
		$managerArr = $this ->getManagerArr($expertData);
		
		//计算线路押金，套餐按份计算
		$deposit = 0;
		if (!empty($lineData['deposit']))
		{
			$deposit = $lineData['deposit'] * $number;
		}
		
		if ($deposit > $money)
		{
			$this ->callback ->setJsonCode(4000 ,'定金不可以大于订单价格');
		}
		
		//保存订单附属表的押金信息
		$affiliatedArr = array(
				'spare_mobile' =>$spare_mobile,
				'remark' =>$spare_remark
		);
		$applyQuota = array();//保存额度申请信息
		$receivabelArr = array();//管家在线交款信息
		$feeAgent = array(); //记录外交佣金或旅行社佣金的计算信息
		$paymentMoney = 0; //营业部现金交款金额
		$time = date('Y-m-d H:i:s' ,time());
		
		/**按照3种下单类型，分别验证**/
		if ($type == 1)
		{
			/** 管家点击确认下单，此时第一次进入后台验证，线路分为定金线路和非定金线路  ***/
			if ($deposit > 0)
			{
				/** 定金线路，定金部分只能用营业部的额度 */
				//验证营业部额度是否足够，若额度不足够，则不可以下单
				$surplus = $deposit -$departData['cash_limit'];
				if ($surplus > 0.0001)
				{
					//营业部现金额度不足，需扣除信用额度
					if ($departData['cash_limit'] > 0)
					{
						$surplus1 = $deposit -$departData['cash_limit'] - $departData['credit_limit'];
						if ($surplus1 > 0.0001)
						{
							$this ->callback ->setJsonCode(4000 ,'您所在营业部的额度不足以抵扣押金');
						}
					}
					else 
					{
						$surplus1 = $deposit - $departData['credit_limit'];
						if ($surplus1 > 0.0001)
						{
							$this ->callback ->setJsonCode(4000 ,'您所在营业部的额度不足以抵扣押金');
						}
					}
				}
				
				//订单附属表的押金信息
				$affiliatedArr['deposit'] = round($deposit ,2);
				$affiliatedArr['before_day'] = $lineData['before_day'];
					
				//在营业部额度充足的情况下，默认向供应商申请单团额度，并直接通过
				$applyQuota = array(
						'depart_id' =>$departData['id'],
						'depart_name' =>$departData['name'],
						'expert_id' =>$expertData['id'],
						'manager_id' =>$managerArr['id'],
						'manager_name' =>$managerArr['realname'],
						'expert_name' =>$expertData['realname'],
						'credit_limit' =>round($money - $deposit ,2),
						'return_time' =>date('Y-m-d' ,strtotime($suitData['day']) - $lineData['before_day']*24*3600),
						'addtime' =>$time,
						'modtime' =>$time,
						'm_addtime' =>$time,
						'supplier_id' =>$supplierData['id'],
						'remark' =>'押金订单，默认申请并通过',
						'status' =>3,
						'code' =>$this ->createCodeApply()
				);
					
				//计算营业部现金交款的金额，将用于验证管家在线交款
				if ($departData['cash_limit'] > $deposit)
				{
					$paymentMoney = $deposit;
				}
				else
				{
					$paymentMoney = $departData['cash_limit'];
				}
			}
			else
			{
				/*** 非定金线路 */
				if($departData['cash_limit'] >0)
				{
					//现金额度大于0
					$surplus = $money - $departData['cash_limit'];
					if ($surplus > 0.0001)
					{
						//现金额度不足，判断信用额度
						if ($departData['credit_limit'] >0)
						{
							$surplus = $money - ($departData['cash_limit'] +$departData['credit_limit']);
							if ($surplus >0.0001)
							{
								//现金+信用额度不足,需要申请
								$applyQuotaNum = $surplus; //需要申请的额度
								$applyStatus = true;
							}
							else
							{
								//现金+信用额度充足
								$applyQuotaNum = 0; 
								$applyStatus = false;
							}
						}
						else
						{
							//信用额度为负数,需要申请
							$applyQuotaNum = $surplus; //需要申请的额度
							$applyStatus = true;
						}
					}
					else
					{
						//现金额度充足
						$applyQuotaNum = 0; //需要申请的额度
						$applyStatus = false;
					}
				}
				else 
				{
					//现金额度小于等于0,判断信用额度
					if ($departData['credit_limit'] >0)
					{
						$surplus = $money - $departData['credit_limit'];
						if ($surplus >0.0001)
						{
							//营业部信用额度不足
							$applyQuotaNum = $surplus; //需要申请的额度
							$applyStatus = true;
						}
						else
						{
							//营业部信用额度充足,不需要申请单团额度
							$applyQuotaNum = 0; //需要申请的额度
							$applyStatus = false;
						}
					}
					else
					{
						//现金额度和信用额度都为负数,那么需要申请单团额度，额度为订单金额
						$applyQuotaNum = $money; //需要申请的额度
						$applyStatus = true;
					}
				}
				
				if ($applyStatus === true)
				{
					//营业部的额度不足，需要管家自己申请信用额度
					$dataArr = array(
							'code' =>'5000',
							'cash_limit' =>$departData['cash_limit'],
							'credit_limit' =>$departData['credit_limit'],
							'money' =>round($applyQuotaNum ,2)
					);
					echo json_encode($dataArr);exit;
				}
				else 
				{
					//营业部额度充足
					//计算营业部现金交款的金额，将用于验证管家在线交款
					if ($departData['cash_limit'] > $money)
					{
						$paymentMoney = $money;
					}
					else
					{
						$paymentMoney = $departData['cash_limit'];
					}
				}
			}
			//不论是定金订单还是额度充足的订单，订单状态都是4
			$status = 4;
		}
		elseif($type == 2)
		{
			/*** 营业部额度不足，管家申请单团额度 **/
			//还需要扣除的营业部额度
			$deductionQuota = $money - $apply_quota;
			if($departData['cash_limit'] >0)
			{
				//现金额度大于0
				$surplus = $deductionQuota - $departData['cash_limit'];
				if ($surplus > 0.0001)
				{
					/**还需要扣除的额度大于营业部的现金额度**/
					if ($departData['credit_limit'] >0)
					{
						$surplus = $deductionQuota - ($departData['cash_limit'] +$departData['credit_limit']);
						if ($surplus >0.0001)
						{
							//营业部的额度，不足以抵扣还需扣除的额度
							$msgData = array(
									'code' =>6000,
									'cash_limit' =>$departData['cash_limit'],
									'credit_limit' =>$departData['credit_limit'],
									'msg' =>'营业部额度发生变化，请重新提交',
									'quota' =>round($money- $departData['cash_limit'] -$departData['credit_limit'] ,2)
							);
							echo json_encode($msgData);exit;
						}
					}
					else
					{
						/**营业部信用额度为负数*/
						$msgData = array(
								'code' =>6000,
								'cash_limit' =>$departData['cash_limit'],
								'credit_limit' =>$departData['credit_limit'],
								'msg' =>'营业部额度发生变化，请重新提交',
								'quota' =>round($money- $departData['cash_limit'] ,2)
						);
						echo json_encode($msgData);exit;
					}
				}
			}
			else
			{
				//现金额度小于等于0,判断信用额度
				if ($departData['credit_limit'] >0)
				{
					$surplus = $deductionQuota - $departData['credit_limit'];
					if ($surplus >0.0001)
					{
						//营业部信用额度不足
						$msgData = array(
								'code' =>6000,
								'cash_limit' =>$departData['cash_limit'],
								'credit_limit' =>$departData['credit_limit'],
								'msg' =>'营业部额度发生变化，请重新提交',
								'quota' =>round($money- $departData['credit_limit'] ,2)
						);
						echo json_encode($msgData);exit;
					}
				}
				else
				{
					//现金额度和信用额度都为负数,申请的单团额度不等于订单金额，则用户重新确认
					if (abs($deductionQuota) > 0.0001)
					{
						$msgData = array(
								'code' =>6000,
								'cash_limit' =>$departData['cash_limit'],
								'credit_limit' =>$departData['credit_limit'],
								'msg' =>'营业部额度为负值，订单申请额度为订单金额，请重新提交',
								'quota' =>$money
						);
						echo json_encode($msgData);exit;
					}
				}
			}
			
			//验证并获取管家额度申请信息
			$applyQuota = $this ->getApplyQuota($expertData, $departData, $supplierData['id'] ,$managerArr);
			
			//计算营业部现金交款的金额，将用于验证管家在线交款
			if ($departData['cash_limit'] > $deductionQuota)
			{
				$paymentMoney = $deductionQuota;
			}
			else
			{
				$paymentMoney = $departData['cash_limit'];
			}
			
			if ($expertData['is_dm'] == 1)
			{
				//管家是营业部经理
				$status = $apply_type == 1 ? 2 : 3; //2-旅行社   3-供应商
			}
			else 
			{
				$status = $apply_type == 1 ? 10 : 11; //10-旅行社  11-供应商
			}
		}
		elseif($type == 3)
		{
			/*** 管家临时保存订单，不需要验证额度 ****/
			if ($deposit > 0)
			{
				//订单附属表的押金信息
				$affiliatedArr = array(
						'deposit' =>round($deposit ,2),
						'before_day' =>$lineData['before_day']
				);
				//交款金额不可大于非定金部分金额
				$paymentMoney = $money - $deposit;
			}
			else 
			{
				$paymentMoney = $money;
			}
			$status = 9;
		}
		
		//管家下单的同时交款
		if ($rb_money > 0)
		{
			//验证交款金额，在线交款金额+营业部现金交款金额不能大于订单金额
			$surplus = $rb_money - ($money -$paymentMoney);
			if ($surplus > 0.0001)
			{
				if ($deposit > 0)
				{
					//定金订单，定金部分不可以使用在线交款
					$this ->callback ->setJsonCode(4000 ,'收款金额不可大于扣除定金后的金额');
				}
				else
				{
					$this ->callback ->setJsonCode(4000 ,'收款金额不可大于余额交款后的金额');
				}
			}
			
			//验证交款信息并返回交款信息
			$receivabelArr = $this ->getReceivableInfo($rb_way, $rb_bankname, $rb_bankcard);
		}
		
		/** 管家佣金计算方式
		 *  1：供应商的正常线路(非单项产品)，取套餐价格表中供应商设置的管家佣金
		 *  2：单项产品(包含供应商单项和旅行社单项)，使用套餐价格表中的售卖价减去成本价
		 */
		$agent_fee = $this ->getExpertAgent($adultnum ,$oldnum ,$childnobed,$childnum ,$suitData ,$lineData);
		
		$platform_fee = 0; //旅行社的管理费
		$diplomatic_agent = 0; //外交佣金
		$agentArr = array();//管理费计算信息
		$feeAgent = array();//记录旅行社佣金或外交佣金的计算方式
		
		//查询旅行社与供应商是否是直属关系
		$relationship = $this ->isDirectlyUnder($expertData['union_id'],$supplierData['id']);
		if ($relationship == true)
		{
			//旅行社与供应商是直属关系，获取旅行社的管理费
			if ($lineData['line_kind'] == 1 || $lineData['line_kind'] == 3)
			{
				/**
				 * 直属供应商管理费的计算方式，供应商添加的产品
				 * 根据旅行社对供应商设置的管理费收取方式计算，分为：
				 * 1：按人群收取，用不同人群的总数*不同人群的单价 之和=旅行社佣金
				 * 2：按比例收取，订单总价格*收取比例=旅行社佣金
				 * 3：按天数收取，获取旅行社按天数设置的佣金费(用线路的出游天数获取)*总人数=旅行社佣金
				 */
				//供应商的线路，包括供应商添加的单项
				$feeArr = $this ->getSupplierLineFee($departData['union_id'],$supplierData['id'],$lineData,$money,$adultnum,$oldnum,$childnum,$childnobed);
				//var_dump($feeArr);exit;
				if ($feeArr !== false)
				{
					$platform_fee = $feeArr['fee'];
					$agentArr = $feeArr['agentArr'];
					
					$feeAgent = array(
							'kind' =>$agentArr['type'],
							'adultprice' =>$agentArr['man'],
							'childprice' =>$agentArr['child'],
							'childnobedprice' =>$agentArr['childnobed'],
							'oldprice' =>$agentArr['oldman'],
							'ratio' =>$agentArr['agent_rate'],
							'dayprice' =>isset($agentArr['money']) ? $agentArr['money'] : 0,
							'dayprice_child' =>isset($agentArr['money_childbed']) ? $agentArr['money_childbed'] : 0,
							'dayprice_childnobed' =>isset($agentArr['money_child']) ? $agentArr['money_child'] : 0,
							'days' =>$lineData['lineday']
					);
				}
			}
			else 
			{
				/**
				 * 获取旅行社单项的佣金费，根据指定的收取对象不同分为外交佣金和旅行社管理费
				 * 若指定收取对象为管家，则外外交佣金
				 * 若指定收取对象为供应商，则为旅行社管理费
				 * 收取方式分为按人群收取和按比例收取
				 * 1：按人群收取，用不同人群的总数*不同人群的单价 之和
				 * 2：按比例收取，订单总价格*收取比例
				 */
				//旅行社添加的单项
				$feeArr = $this ->getUnoinLineFee($lineid,$money,$adultnum,$oldnum,$childnobed,$childnum);
				if ($feeArr !== false)
				{
					
					$agentArr = $feeArr['agentArr'];
					$feeAgent = array(
							'kind' =>$agentArr['type'],
							'adultprice' =>$agentArr['adult'],
							'childprice' =>$agentArr['child'],
							'childnobedprice' =>$agentArr['childnobed'],
							'oldprice' =>$agentArr['old'],
							'ratio' =>$agentArr['agent_rate']
					);
					
					if($feeArr['object'] == 1)
					{
						//向营业部收取佣金，则计入外交佣金，没有管理费
						$diplomatic_agent = $feeArr['fee'];
					}
					else
					{
						//向供应商收取佣金，则计入管理费，没有外交佣金
						$platform_fee = $feeArr['fee'];
					}
				}
			}
		}
		else
		{
			/***旅行社与供应商不是直属关系，则旅行社向管家收取外交佣金，没有管理费**/
			$diplomaticAgent = $this ->getDiplomaticAgent($expertData['union_id'], $lineData['supplier_id'] ,$lineData['overcity2'] ,$adultnum ,$oldnum ,$childnobed ,$childnum);
			$diplomatic_agent = $diplomaticAgent['diplomatic_agent'];
			$feeAgent = $diplomaticAgent['diplomaticArr'];
		}
		
		//管家佣金小于外交佣金不可下单
		if ($lineData['line_kind'] == 1 && $agent_fee < $diplomatic_agent)
		{
			$this->callback->setJsonCode ( 4000 ,'您的佣金小于外交佣金，不可下单');
		}

		//判断联系人手机号是否注册，若没有注册返回数组信息，若注册了返回ID
		$memberArr = $this ->isRegisterUser($mobile, $username);

		//出游人信息
		$traverArr = $this ->getPeopleInfo($suitData ,$lineData);
		
		$time = date('Y-m-d H:i:s' ,time());
		//订单信息
		$orderArr = array(
				'expert_id' => $expertData['id'],
				'expert_name' =>$expertData['realname'],
				'supplier_id' => $supplierData['id'],
				'supplier_name' => $supplierData['company_name'],
				'channel' =>0,
				'depart_id' =>$departData['id'],
				'user_type' =>1,
				'productname' =>$lineData['linename'],
				'productautoid' =>$lineData['id'],
				'litpic' =>$lineData['mainpic'],
				'total_price' =>$money,
				'order_price' =>$money,
				'settlement_price' =>0,
				'insurance_price' =>0,
				'jifen' =>0,
				'jifenprice' =>0,
				'couponprice' =>0,
				'agent_rate' =>$supplierData['agent_rate'],
				'platform_fee' =>$platform_fee,
				'platform_id' =>$expertData['union_id'],
				'first_pay' =>$money,
				'usedate' =>$suitData['day'],
				'price' =>$suitData['adultprice'],
				'childprice' =>$suitData['childprice'],
				'childnobedprice' =>$suitData['childnobedprice'],
				'suitnum' =>$suitData['unit'] >1 ? $adultnum : 0,
				'dingnum' =>$suitData['unit'] >1 ? round($adultnum*$suitData['unit']) : $adultnum,
				'childnum' =>$childnum,
				'childnobednum' =>$childnobed,
				'oldnum' =>$oldnum,
				'oldprice' =>$suitData['oldprice'],
				'linkman' =>$username,
				'linkmobile' =>$mobile,
				'linkemail' =>$email,
				'addtime' =>$time,
				'suitid' =>$suitid,
				'isbuy_insurance' =>0,
				'agent_fee' =>round($agent_fee -$diplomatic_agent ,2),
				'confirmtime_supplier' =>$time,
				'final_pay' =>0,
				'supplier_cost' =>round($money - $agent_fee ,2),
				'diplomatic_agent' =>$diplomatic_agent,
				'item_code' =>$lineData['line_kind']==1 ? $suitData['description'] : $lineData['linecode'],
				'ispay' => 5,
				'status' => $status,
				'order_type' =>$lineData['line_kind']==1 ? 1 : 2,
				'depart_list' =>$expertData['depart_list'],
				'room_fee' =>$suitData['room_fee'],
				'agent_room_fee' =>$suitData['agent_room_fee']
		);
		
		//下订单
		$msgArr = $this ->order_model ->create_order_t33($orderArr,$lineData,$suitData,$traverArr,$managerArr['id'],$agentArr,$memberArr,$affiliatedArr,$applyQuota,$feeAgent);
		if ($msgArr['code'] == 200)
		{
			echo json_encode(array('code' =>2000 ,'orderid' =>$msgArr['order_id']));
			//推送微信消息
			$this ->sendMsgOrderWX(array('type' =>1 ,'orderid' =>$msgArr['order_id']));
			
			//发送站内消息
			$msg = new T33_send_msg();
			if (isset($msgArr['applyId']) && $msgArr['applyId'] >0)
			{
				//若申请了信用额度，则推送此消息
				$this ->sendMsgQuotaWX(array('applyId' =>$msgArr['applyId']));
				
				//管家申请单团额度发送消息
				$msg ->applyQuotaMsg($msgArr['applyId'],1,$expertData['realname']);
			}
			else 
			{
				if ($orderArr['status'] ==4)
				{
					//发送新订单消息
					$msg ->addOrderMsg($msgArr['order_id'],$expertData['realname']);
				}
			}
			//交款发送消息
			if (isset($msgArr['receivableId']) && $msgArr['receivableId'] >0)
			{
				$msg ->receivableMsg($msgArr['receivableId'],1,$expertData['realname']);
			}
		}
		else
		{
			if ($msgArr['code'] == 500)
			{
				$this ->callback ->setJsonCode(4000 ,'下单失败');
			}
			elseif($msgArr['code'] == 700)
			{
				//这是没有识别的订单类型
				$this ->callback ->setJsonCode(4000 ,'操作有误，请联系客服');
			}
			else
			{
				$this ->callback ->setJsonCode(4000 ,'在您下单的同时，有其他销售下单，扣除了营业部的额度，致使您的额度不足，请刷新页面重新下单');
			}
		}
	}
	
	/**
	 * @method 计算管家佣金
	 * @param unknown $adultnum
	 * @param unknown $oldnum
	 * @param unknown $childnobed
	 * @param unknown $childnum
	 * @param unknown $suitData
	 * @param unknown $lineData
	 * @return number
	 */
	public function getExpertAgent($adultnum ,$oldnum ,$childnobed,$childnum ,$suitData ,$lineData)
	{
		if ($lineData['line_kind'] == 2 || $lineData['line_kind'] == 3)
		{
			//单项产品管家佣金计算
			$adultAgent = $adultnum*($suitData['adultprice']-$suitData['adultprofit']);
			$oldAgent = $oldnum*($suitData['oldprice']-$suitData['oldprofit']);
			$childAgent = $childnum*($suitData['childprice']-$suitData['childprofit']);
			$childnobedAgent = $childnobed*($suitData['childnobedprice']-$suitData['childnobedprofit']);

			$agent_fee = round($adultAgent+$oldAgent+$childAgent+$childnobedAgent ,2);
		}
		else
		{
			$agent_fee = round($adultnum*$suitData['agent_rate_int'] + $childnobed*$suitData['agent_rate_childno'] + $childnum*$suitData['agent_rate_child'] ,2);
		}
		return $agent_fee;
	}

	/**
	 * @method 会员注册信息
	 * @author jiakairong
	 * @since  2015-11-05
	 * @param unknown $mobile 手机号
	 * @param unknown $name  用户姓名
	 */
	private function isRegisterUser($mobile ,$name) {
		$this ->load_model('member_model');
		$memberData = $this ->member_model ->row(array('mobile' =>$mobile));
		if (empty($memberData))
		{
			$time = date('Y-m-d H:i:s' ,time());
			$userArea = $this ->getUserArea();
			return array(
					'loginname'=>$mobile,
					'nickname' =>$name,
					'truename' =>$name,
					'pwd'=>md5(123456),
					'mobile'=>$mobile,
					'jointime'=> $time,
					'logintime' =>$time,
					'litpic' =>sys_constant::DEFAULT_PHOTO,
					'jifen' =>sys_constant::REGISTER_JIFEN,
					'register_channel' =>'PC',
					'loginip' =>$userArea['ip'],
					'province' =>$userArea['province'],
					'city' =>$userArea['city'],
			);
		}
		else {
			return $memberData['mid'];
		}
	}
	//获取会员的地址
	public function getUserArea()
	{
		$this->load->library ( 'GetCityIp' );
		$this->load_model('area_model');
		$province_id = 0;
		$city_id = 0;
		$ip = $this ->getip();
		//$ip = '61.244.148.166';
		$areaArr = $this ->getcityip ->getIPLoc_sina($ip);
		if (!empty($areaArr))
		{
			//$country = empty($areaArr['country']) ? '' : $areaArr['country'];
			$province = empty($areaArr['province']) ? '' : $areaArr['province'];
			$city = empty($areaArr['city']) ? '' : $areaArr['city'];
			if ($province == '香港')
			{
				$city = $province;
			}
			if (!empty($province))
			{
				$areaData = $this ->area_model ->row(array('name like' =>$province.'%' ,'level' =>2));
				if (!empty($areaData))
				{
					$province_id = $areaData['id'];
				}
			}
			if (!empty($city))
			{
				$areaData = $this ->area_model ->row(array('name like' =>$city.'%' ,'level' =>3));
				if (!empty($areaData))
				{
					$city_id = $areaData['id'];
				}
			}
		}
		return array(
				'ip' =>$ip,
				'province' =>$province_id,
				'city' =>$city_id
		);
	}


	//进入订单基本信息填写页面
	public function order_basic_info()
	{
		$this ->load ->helper ('my_text');
		$this->load->model ( 'dictionary_model', 'dictionary_model' );

		$lineOrder = $this ->session ->userdata('lineOrder'); //获取保存的线路信息
		$userid = $this ->session ->userdata('c_userid');
		$data = array();

		if ($lineOrder == false)
		{
			header("Location:/line/line_list/index");exit;
		}
		//获取线路专家
		$whereArr = array (
				'la.line_id' => $lineOrder['lineid'],
				'e.status' => 2,
				'la.status' => 2
		);
		$lineExpert = $this->apply_model->getLineExpert ( $whereArr, 1, 6 );
		$data['expert'] = $lineExpert['list'];
		//获取线路信息
		$lineData = $this->getLineData($lineOrder['lineid'] ,$lineOrder['usedate']) ;
		//获取线路类型和证件类型
		if ($lineData['line_classify'] ==1)
		{
			//$data['linetype'] = 1; //境外
			$data['certificate'] = $this ->dictionary_model ->get_dictionary_data(sys_constant::DICT_ABROAD_CERTIFICATE_TYPE);
		}
		else
		{
			//$data['linetype'] = 2; //境内
			$data['certificate'] = $this ->dictionary_model ->get_dictionary_data(sys_constant::DICT_DOMESTIC_CERTIFICATE_TYPE);
		}
		
		$data['linetype'] = $lineData['line_classify'] == 1 ? 1 : 2;
		//归来日期
		$data['backdate'] = date('Y-m-d' ,strtotime ( $lineOrder['usedate'] ) + (($lineData ['lineday']-1) * 24 * 3600));

		//获取套餐
		$data['suitPrice'] = $this ->getSuitPriceData($lineOrder['lineid'] ,$lineOrder['suitid'] ,$lineOrder['usedate']);
		//获取总价格
		$data['money'] = $this ->getCountMoney($data['suitPrice'] ,$lineOrder['adultnum'] ,$lineOrder ['childnum'] ,$lineOrder['childnobednum'] ,$lineOrder['oldnum']);
		//网站配置
		$data['webData'] = $this ->web_model ->getOrderWebData();
		//供应商
		$data['supplier'] = $this ->getSupplierData($lineData['supplier_id']);
		//若用户登录，则查询积分
		$data['memberData'] = array();
		if ($userid > 0)
		{
			$this ->load_model('common/u_member_model' ,'member_model');
			$data['memberData'] = $this ->member_model ->row(array('mid' =>$userid) ,'arr' ,'' ,'jifen,truename,mobile,email,mid');
			//查询用户的优惠券
			$this ->load_model('common/cou_member_coupon_model' ,'member_coupon_model');
			$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
			$whereArr = array(
					'cmc.status' =>0,
					'cmc.member_id' =>$userid,
					'cc.status' =>1,
					'cc.starttime <' =>$time,
					'cc.endtime >'=>$time
			);
			$data['mcData'] = $this ->member_coupon_model ->getMemberCouponData($whereArr);
			//echo $this ->db ->last_query();
		}
		//$this ->load_model('startplace_model');
		$startData = $this ->startplace_model ->getLineStartCity($lineOrder['lineid']);
		$cityname = '';
		if (!empty($startData))
		{
			foreach($startData as $v)
			{
				$cityname .= $v['name'].',';
			}
		}
		$data['cityname'] = rtrim($cityname ,',');
		//获取线路保险
		$whereArr = array(
			't.insurance_date' =>$lineData ['lineday'],
			't.insurance_type' =>$data['linetype'],
			't.status' =>1
		);
		$data['insuranceData'] = $this ->insurance_model ->getLineInsurance($whereArr);
		//echo $this->db ->last_query();
		$data['line'] = $lineData;
		$data['lineOrder'] = $lineOrder;
		$data['countNum'] = intval($lineOrder['adultnum']+$lineOrder ['childnum']+$lineOrder['childnobednum']+$lineOrder['oldnum']);
		$this->load->view ( 'order/order_basic_info', $data );
	}

	/**
	 * @method 获取线路数据并验证
	 * @param intval $id 线路id
	 * @param $day 出行日期
	 */
	protected function getLineData($lineid ,$day ,$type=false)
	{
		if ($type == true) { //管家下单
			$whereArr = array(
					'l.id' =>$lineid
			);
		}else {
			$whereArr = array(
					'l.id' =>$lineid,
					'l.status' =>2
			);
		}

		$lineData = $this ->line_model ->getLineOrder($whereArr);

		if (empty($lineData))
		{
			if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest") {
				$this->callback->setJsonCode ( 4000 ,'您选择的线路不存在或已下线');
			} else {
				echo '<script>alert("您选择的线路不存在或已下线");window.close();</script>';exit;
			}
		}
		$date = date('Y-m-d');
		$before = date('Y-m-d',strtotime($day)-$lineData[0]['linebefore']*24*3600);
// 		if ($before < $date) {
// 			if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest") {
// 				$this->callback->setJsonCode ( 4000 ,'该线路需提前'.$lineData[0]['linebefore'].'天报名！');
// 			} else {
// 				echo '<script>alert("该线路需提前'.$lineData[0]['linebefore'].'天报名！");window.close();</script>';exit;
// 			}
// 		}
		return $lineData[0];
	}

	/**
	 * @method 获取价格
	 * @param unknown $suitPrice  套餐数据
	 * @param unknown $adultnum
	 * @param unknown $childnum
	 * @param unknown $childnobednum
	 * @param unknown $oldnum
	 */
	protected function getCountMoney($suitPrice ,$adultnum ,$childnum ,$childnobednum ,$oldnum) {
		$money = $childnum *$suitPrice ['childprice'] + $adultnum*$suitPrice ['adultprice'] + $oldnum*$suitPrice['oldprice'] + $childnobednum*$suitPrice['childnobedprice'];
		return round($money ,2);
	}

	/**
	 * @method 获取线路套餐并验证
	 * @param unknown $lineid  线路id
	 * @param unknown $suitid	套餐id
	 * @param unknown $usedate  出发日期
	 * @return unknown
	 */
	protected function getSuitPriceData($lineid ,$suitid, $usedate)
	{
		$whereArr = array(
				'sp.lineid' =>$lineid,
				'sp.suitid' =>$suitid,
				'sp.day' =>$usedate
		);
		$suitPriceData = $this ->suit_price_model ->getSuitPriceDetail($whereArr);
		if (empty($suitPriceData))
		{
			$this->callback->setJsonCode ( 4000 ,'您选择的线路套餐不存在');
		}
		return $suitPriceData[0];
	}

	/**
	 * @method 判断线路是否存在管家
	 * @param intval $id 线路id
	 */
	protected function isLineExpert($lineid) {
		$whereArr = array (
				'la.line_id' => $lineid,
				'e.status' => 2,
				'la.status' => 2
		);
		$expertApply = $this ->apply_model ->getLineExpert($whereArr ,1 ,1);
		if (empty($expertApply['list'])) {
			$this->callback->setJsonCode ( 4000 ,'您选择的线路暂无管家，请选择其它线路');
		}
	}

	/**
	 * @method 获取商家数据并验证商家
	 * @param intval $id 商家id
	 */
	protected function getSupplierData($id) {
		$supplierData = $this ->supplier_model ->row(array('id' =>$id));
// 		if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest") {
// 			if (empty($supplierData) || $supplierData['status']!=2) {
// 				$this->callback->setJsonCode ( 4000 ,'此线路的商家不存在或已停止服务');
// 			}
// 		}
		if (empty($supplierData))
		{
			$this ->callback ->setJsonCode(4000 ,'供应商不存在');
		}
		return $supplierData;
	}

	/**
	 * @method 用户使用积分进行验证
	 * @param unknown $jifen  用户使用积分
	 * @param unknown $orderMoney  订单的出游人金额，不包括保险金额
	 * @return array  用户信息
	 */
	protected function userJifen($jifen ,$orderMoney) {
		$this->load_model('member_model');
		$userid = $this ->session ->userdata('c_userid');
		$memberData = $this ->member_model ->row(array('mid' =>$userid));
		if (empty($memberData)) {
			$this->callback->setJsonCode ( 4000 ,'登陆会员不存在');
		} else {
			if (!empty($jifen)) {
				if ($memberData['jifen'] < $jifen) {
					$this->callback->setJsonCode ( 4000 ,'您的积分不足');
				} else {
					//支付积分不可大于出游人金额
					if ($jifen - $orderMoney*100 > 0) {
						$this->callback->setJsonCode ( 4000 ,'您支付的积分大于出游人的费用');
					}
				}
			}
			return $memberData;
		}
	}

	/**
	 * @method 验证保险，并返回保费和保存保险信息的数组
	 * @param string $insuranceIds  保险种类,以逗号链接
	 * @param intval $numPeople  保险人数,人数固定为出游人数
	 */
	protected function getInsuranceInfo($insuranceIds ,$numPeople )
	{
		$insuranceArr = array();
		$sMoney = 0; //保险总售价
		$cMoney = 0; //保险总成本价
		$typeArr = explode(',', rtrim($insuranceIds ,','));
		foreach($typeArr as $key =>$val) {
			//获取保险
			$whereArr = array(
					't.id' =>$val,
					't.status' =>1
			);
			$insuranceData = $this ->insurance_model ->getLineInsurance($whereArr);
			if (empty($insuranceData))
			{
				$this->callback->setJsonCode ( 4000 ,'您选择的保险有误');
			}
			//对外售价
			$settlement = round($insuranceData[0]['settlement_price'] * $numPeople ,2);
			//对内成本价
			$costPrice = round($insuranceData[0]['insurance_price'] * $numPeople ,2);
			$cMoney = $cMoney +$costPrice;
			$sMoney = $sMoney +$settlement;
			$insuranceArr[] = array(
					'insurance_id' =>$val,
					'number' =>$numPeople,
					'amount' =>$settlement,
					'name' =>$insuranceData[0]['insurance_name'],
					'price' =>$insuranceData[0]['settlement_price']
			);
		}
		return array(
				'insuranceArr' =>$insuranceArr,
				'settlement' =>round($sMoney ,2),
				'costPrice' =>round($cMoney ,2)
		);
	}

	/**
	 * @method 出游人信息验证
	 * @param unknown $data
	 * @return array 返回出游人信息的数组
	 */
	protected function getTraverInfo($data)
	{
		$this->load->helper ( 'regexp' );
		$traverArr = array();
		$yearNow = date('Y-m-d' ,time());
		$addtime = date('Y-m-d H:i:s' ,time());
		if (!isset($data['name']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写出游人信息');
		}
		foreach($data['name'] as $k =>$v)
		{
			if (isset($data['enname'][$k]))
			{
				if (empty($data['enname'][$k]))
				{
					$this->callback->setJsonCode ( 4000 ,'请填写英文姓名');
				}
			}
			else
			{
				if (empty($data['name'][$k]))
				{
					$this->callback->setJsonCode ( 4000 ,'请填写姓名');
				}
			}

			if($data['sex'][$k] != 1 && $data['sex'][$k] != 0)
			{
				$this->callback->setJsonCode ( 4000 ,'请选择性别');
			}
			if (empty($data['card_type'][$k]))
			{
				$this->callback->setJsonCode ( 4000 ,'请选择证件类型');
			}
			if (empty($data['card_num'][$k]))
			{
				$this->callback->setJsonCode ( 4000 ,'请填写证件号');
			}

			if (!regexp('date', $data["birthday"][$k]))
			{
				$this->callback->setJsonCode ( 4000 ,'请填写正确的出生日期');
			}
			else
			{
				if ($data['birthday'][$k] > $yearNow)
				{
					$this->callback->setJsonCode ( 4000 ,'出生日期不可以在今天以后');
				}
			}

			if (isset($data['sign_time'][$k]))
			{
				if (empty($data['sign_time'][$k]))
				{
					$this->callback->setJsonCode ( 4000 ,'请填写签发日期');
				}
				else
				{
					if (!regexp('date', $data['sign_time'][$k]))
					{
						$this->callback->setJsonCode ( 4000 ,'请填写正确的签发日期');
					}
					if ($data['sign_time'][$k] > $yearNow)
					{
						$this->callback->setJsonCode ( 4000 ,'签发日期不可以在今日之后');
					}
				}
			}

			if (isset($data['endtime'][$k]))
			{
				if (empty($data['endtime'][$k]))
				{
					$this->callback->setJsonCode ( 4000 ,'请填证件有效期');
				}
				else
				{
					if (!regexp('date', $data['endtime'][$k]))
					{
						$this->callback->setJsonCode ( 4000 ,'请填写正确的有效日期');
					}
					if ($data['endtime'][$k] < $yearNow)
					{
						$this->callback->setJsonCode ( 4000 ,'有效期要在今日之后');
					}
				}
			}

			
			if (isset($data['enname']))
			{
				$traverArr[] = array(
					'name' =>trim($v),
					'sex' =>intval($data['sex'][$k]),
					'certificate_type' =>intval($data['card_type'][$k]),
					'certificate_no' =>trim($data['card_num'][$k]),
					'birthday' =>$data['birthday'][$k],
					'telephone' =>$data['tel'][$k],
					'enname' =>$data['enname'][$k],
					'sign_place' =>$data['sign_place'][$k],
					'sign_time' =>$data['sign_time'][$k],
					'endtime' =>$data['endtime'][$k],
					'addtime' =>$addtime
				);
			}
			else 
			{
				$traverArr[] = array(
						'name' =>trim($v),
						'sex' =>intval($data['sex'][$k]),
						'certificate_type' =>intval($data['card_type'][$k]),
						'certificate_no' =>trim($data['card_num'][$k]),
						'birthday' =>$data['birthday'][$k],
						'telephone' =>$data['tel'][$k],
						'addtime' =>$addtime
				);
			}
		}
		return $traverArr;
	}

	//验证用户使用的优惠券
	protected function getMemberCoupon($member_coupon_id ,$orderMoney)
	{
		$this ->load_model('common/cou_member_coupon_model' ,'member_coupon_model');
		$userid = $this ->session ->userdata('c_userid');
		$whereArr = array(
			'cmc.status' =>0,
			'cmc.member_id' =>$userid,
			'cc.status' =>1,
			'cmc.id' =>$member_coupon_id
		);
		$couponData = $this ->member_coupon_model ->getMemberCouponData($whereArr);
		if (empty($couponData))
		{
			$this->callback->setJsonCode ( 4000 ,'您选择的优惠券不存在');
		}
		$time =date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		if ($couponData[0]['use_platform'] != 1 && $couponData[0]['use_platform'] != 0)
		{
			$this->callback->setJsonCode ( 4000 ,'此优惠券不可再PC端使用');
		}
		if ($time > $couponData[0]['endtime'] || $time < $couponData[0]['starttime'])
		{
			$this->callback->setJsonCode ( 4000 ,'优惠券已过期');
		}
		if ($orderMoney < $couponData[0]['min_price'])
		{
			$this->callback->setJsonCode ( 4000 ,'订单金额不满足使用此优惠券的条件');
		}
		return $couponData[0]['coupon_price'];
	}

	//生成订单
	public function create_order()
	{
		ini_set('default_socket_timeout', -1);
		set_time_limit(0);
		
		//$this->callback->setJsonCode ( 2000 ,102405);
		$this->load->helper ( 'regexp' );
		$lineOrder = $this ->session ->userdata('lineOrder');
		$userid = $this ->session ->userdata('c_userid');
		if ($lineOrder == false)
		{
			$this->callback->setJsonCode ( 7000 ,'');//没有获取到选择的线路信息
		}
		//判断用户是否登陆
		if ($userid == false)
		{
			$this->callback->setJsonCode ( 5000 ,'请登陆');
		}
		else 
		{
			//获取用户信息
			$this ->load_model('member_model');
			$memberData = $this ->member_model ->row(array('mid' =>$userid));
			if (empty($memberData))
			{
				$this->callback->setJsonCode ( 4000 ,'会员不存在');
			}
		}
		
		$postArr = $this->security->xss_clean($_POST);
		if (!isset($postArr['agree_check']) || $postArr['agree_check'] != '1')
		{
			$this->callback->setJsonCode ( 4000 ,'请您同意合同条款后下单');
		}
		$adultnum = intval($postArr['dingnum']);
		$childnum = isset($postArr['childnum']) ? intval($postArr['childnum']) : 0;//儿童占床
		$childnobed = isset($postArr['childnobednum']) ? intval($postArr['childnobednum']) :0;//儿童不占床
		$oldnum = isset($postArr['oldnum']) ? intval($postArr['oldnum']) : 0;//老人数量
		
		$spare_mobile = trim($this ->input ->post('spare_mobile' ,true));//备用手机
		$spare_remark = trim($this ->input ->post('spare_remark' ,true));//备注
		
		//线路验证
		$lineData = $this ->getLineData($lineOrder['lineid'] ,$lineOrder['usedate']);
		//供应商验证
		$supplierData = $this ->getSupplierData($lineData['supplier_id']);
		//管家验证
		if (empty($postArr['expert_id']))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择管家');
		}
		else
		{
			$whereArr = array (
					'la.line_id' => $lineOrder['lineid'],
					'e.id' =>intval($postArr['expert_id']),
					'e.status' => 2,
					'la.status' => 2
			);
			$expert = $this ->apply_model ->getLineExpert($whereArr ,1 ,1);
			if (empty($expert['list']))
			{
				$this->callback->setJsonCode ( 4000 ,'您选择的管家不服务此线路或不存在');
			}
			else
			{
				$expert = $expert['list'];
			}
		}
		if ($adultnum < 1)
		{
			$this->callback->setJsonCode ( 4000 ,'成人数量不可为空');
		}
		if (empty($postArr['username']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写联系人名称');
		}
		//验证手机号
		if (!regexp('mobile' ,$postArr ['mobile']))
		{
			$this->callback->setJsonCode ( 4000 ,'请输入正确的手机号');
		}
		//验证邮箱
		if (!regexp('email' ,$postArr ['email']))
		{
			$this->callback->setJsonCode ( 4000 ,'请输入正确的邮箱号');
		}
		$suitPrice = $this ->getSuitPriceData($lineOrder['lineid'], $lineOrder['suitid'], $lineOrder['usedate']);
		//占床位的总人数
		$number = $adultnum*$suitPrice['unit'] + $childnum + $oldnum;
		//总人数
		$countNum = $number + $childnobed;

		if ($suitPrice['unit'] > 1)
		{
			//判断套餐份数是否足够
			if ($suitPrice['number'] < $adultnum)
			{
				$this->callback->setJsonCode ( 4000 ,'此线路套餐份数剩余：'.$suitPrice['number'].'份');
			}
		}
		else
		{
			//判断余位是否足够
			if ($suitPrice['number'] < $number)
			{
				$this->callback->setJsonCode ( 4000 ,'此线路余位剩余：'.$suitPrice['number'].'个');
			}
		}

		//出游人信息验证
		$traverArr = $this ->getTraverInfo($postArr);

		//出游人总价
		$traverMoney = $this ->getCountMoney($suitPrice, $adultnum, $childnum, $childnobed, $oldnum);
		$orderPrice = $traverMoney;
		$total_price = $traverMoney;
		//积分使用计算
		$postArr['jifen'] = 0;//目前不使用积分
		if (isset($postArr['jifen']) && $postArr['jifen'] >0) {
			$jifenMoney = round(($postArr['jifen'] /100),2);
			if ($jifenMoney > $orderPrice)
			{
				$this->callback->setJsonCode ( 4000 ,'积分抵扣金额不可以超过出游人价格');
			}
			$jifen = intval($postArr['jifen']);
		} else {
			$jifen = 0;
			$jifenMoney = 0;
		}
		//验证积分并返回用户原有的积分
		$memberData = $this ->userJifen($jifen ,$total_price);
		$total_price = $total_price - $jifen/100;

		//优惠券使用计算
		if (isset($postArr['member_coupon_id']) && $postArr['member_coupon_id'] >0)
		{
			$member_coupon_id = intval($postArr['member_coupon_id']);
			//验证优惠券，并返回优惠额
			$coupon_price = $this ->getMemberCoupon($member_coupon_id, $traverMoney);
			$total_price = $total_price - $coupon_price;
		}
		else
		{
			$member_coupon_id = 0;
			$coupon_price = 0;
		}

		if ($total_price < 0) {
			$total_price = 0;
		}
		if ($expert[0]['supplier_id'] == $supplierData['id'])
		{
			//直属管家，佣金为0
			$agent_fee = 0;
		}
		else
		{
			//管家佣金,不包括保险,各种优惠之后的价格，
			$agent_fee = round($adultnum*$suitPrice['agent_rate_int'] + $childnobed*$suitPrice['agent_rate_childno'] + $childnum*$suitPrice['agent_rate_child']);
		}
		//保险计算,保险价格不包含在订单价格中
		$insuranceArr = array();
		$settlement_price = 0;
		$insurance_price = 0;
		$isbuy_insurance = 0;
		if (!empty($postArr['insurance']))
		{
			$insuranceInfo = $this ->getInsuranceInfo($postArr['insurance'] ,$countNum );
			$insuranceArr = $insuranceInfo['insuranceArr'];
			$settlement_price = $insuranceInfo['settlement'];
			$insurance_price = $insuranceInfo['costPrice'];
			$isbuy_insurance = 1;
		}
		//var_dump($insuranceArr);exit;
		$suitnum = 0;
		if ($suitPrice['unit'] >1) {
			$suitnum = $adultnum;
		}
		
		//订单附属信息
		$affiliatedArr = array(
				'spare_mobile' =>$spare_mobile,
				'remark' =>$spare_remark
		);
		
		//订单信息
		$orderArr = array(
				'expert_id' =>intval($postArr['expert_id']),
				'depart_id' =>0,
				'expert_name' =>$expert[0]['realname'],
				'supplier_id' => $supplierData['id'],
				'supplier_name' => $supplierData['company_name'],
				'channel' =>0,
				'agent_id' =>$expert [0]['agent_id'],
				'memberid' =>$userid,
				'productname' =>$lineData['linename'],
				'productautoid' =>$lineOrder['lineid'],
				'litpic' =>$lineData['mainpic'],
				'total_price' =>round($total_price,2),
				'agent_fee' =>$agent_fee,
				'price' =>$suitPrice['adultprice'],
				'childprice' =>$suitPrice['childprice'],
				'childnobedprice' =>$suitPrice['childnobedprice'],
				'usedate' =>$lineOrder['usedate'],
				'oldprice' =>$suitPrice['oldprice'],
				'dingnum' =>round($adultnum*$suitPrice['unit']),
				'suitnum' =>$suitnum,
				'childnum' =>$childnum,
				'childnobednum' =>$childnobed,
				'oldnum' =>$oldnum,
				'ispay' =>0,
				'status' =>0,
				'linkman' =>$postArr['username'],
				'linkmobile' =>$postArr['mobile'],
				'linkemail' =>$postArr['email'],
				'addtime' =>date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']),
				'suitid' => $lineOrder['suitid'],
				'jifen' =>$jifen,
				'order_price' =>round($orderPrice ,2),
				'jifenprice' =>$jifenMoney,
				'agent_rate' =>$supplierData['agent_rate'],
				'couponprice' =>$coupon_price,
				'settlement_price' =>$settlement_price,
				'insurance_price' =>$insurance_price,
				'isbuy_insurance' =>$isbuy_insurance,
				'platform_fee' =>round($supplierData['agent_rate']*$total_price ,2),
				'room_fee' =>$suitPrice['room_fee'],
				'agent_room_fee' =>$suitPrice['agent_room_fee'],
				'item_code' =>$suitPrice['description'],
				'supplier_cost' =>round($orderPrice-$agent_fee ,2)
		);
		//var_dump($orderArr);exit;
		$this ->load_model('order/add_order_model' ,'add_order_model');
		$status = $this ->add_order_model ->addOrder($orderArr ,$traverArr ,$insuranceArr ,$jifen ,$member_coupon_id,$memberData['nickname'],$suitPrice,$affiliatedArr);
		if($status === false)
		{
			$this->callback->setJsonCode ( 4000 ,'下单失败');
		}
		else
		{
			echo json_encode(array('code' =>2000,'msg' =>$status));

			//发送短信
			$this ->load_model('sms_template_model');
			$template = $this ->sms_template_model ->row(array('msgtype' =>sys_constant::line_order_msg1));
			$content = str_replace("{#MEMBERNAME#}", $memberData['truename'] ,$template['msg']);
			$content = str_replace("{#PRODUCTNAME#}", $lineData['linename'] ,$content);
			$this ->send_message($postArr ['mobile'] ,$content);

			$template = $this ->sms_template_model ->row(array('msgtype' =>sys_constant::expert_order));
			$content = str_replace('{#LINENAME#}', $lineData['linename'] ,$template['msg']);
			$this ->send_message($expert [0]['mobile'] ,$content);

// 			$template = $this ->sms_template_model ->row(array('msgtype' =>sys_constant::order_leave));
// 			$content = str_replace('{#LINENAME#}', $lineData['linename'] ,$template['msg']);
// 			$this ->send_message($supplierData ['link_mobile'] ,$content);

			//清除session
			$this ->session ->unset_userdata('lineOrder');
		}
	}

	//成功提示
	public function order_success($order_id=0)
	{
		$orderData =  $this ->order_model ->row(array('id' =>$order_id) ,'arr' ,'' ,'expert_id');
		if (empty($orderData)) {
			header("Location:/line/line_list/index");exit;
		}
		$this ->load_model("common/u_expert_model" ,'expert_model');
		$expertData = $this ->expert_model ->row(array('id' =>$orderData['expert_id']) ,'arr' ,'' ,'realname,mobile');
		$this ->load->view('order/order_success' ,array('id' =>$order_id,'expert' =>$expertData));
	}

	public function success_b2($order_id=0)
	{
		$orderData =  $this ->order_model ->row(array('id' =>$order_id) ,'arr' ,'' ,'expert_id');
		if (empty($orderData)) {
			header("Location:/line/line_list/index");exit;
		}
		//获取广告图
		$this->load->model ( 'b_cfg_banner_model', 'banner_model' );
		$banner = $this ->banner_model ->getLastData();
		if (!empty($banner))
		{
			$banner = $banner[0];
		}
		
		$this ->load_model("common/u_expert_model" ,'expert_model');
		$expertData = $this ->expert_model ->row(array('id' =>$orderData['expert_id']) ,'arr' ,'' ,'realname,mobile');
		
		$dataArr = array(
				'id' =>$order_id,
				'expert' =>$expertData,
				'banner' =>$banner
		);
		$this ->load->view('order/success_b2' ,$dataArr);
	}
}


