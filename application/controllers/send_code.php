<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		贾开荣
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Send_code extends UC_NL_Controller {
	public function __construct()
	{
		parent::__construct (); 
		$this->load->helper ( 'regexp' );
		$this->load->library ( 'callback' );
		$this->load->model ( 'sms_template_model' ,'sms_model' );
	}
	
	/**
	 * @method 管家注册发送验证码，设置半小时内前三次发送不需要图形验证码，半小时内超过三次则需要
	 * @author jkr
	 */
	public function registerExpertCode()
	{
		$mobile = $this ->input ->post('mobile' ,true);
		$eid = intval($this ->input ->post('eid'));
		$code = $this ->input ->post('verifycode' ,true);
		$codeArr = $this ->session ->userdata('register_expert_code');
		$time = time();
		
		//判断手机号是否正确
		if (!regexp('mobile' ,$mobile))
		{
			$this ->callback->exitJsonCode(4000 ,'请输入正确的手机号');
		}
		//若发送了验证码，则判断是否在一分钟之内
		if (!empty($codeArr))
		{
			$endtime = $time - $codeArr['send_time'];
			if ($endtime < 60)
			{
				$this ->callback->exitJsonCode(4000 ,'请您一分钟后再获取验证码');
			}
			//管家注册，半小时内前三次无需输入图形验证码
			$endtime = $time - $codeArr['start_time'];
			if($codeArr['num'] >= 3 && $endtime < 1800)
			{
				if (empty($code))
				{
					$this ->callback->exitJsonCode(5000 ,$codeArr['num']);
				}
				else
				{
					if (strtolower($code) != strtolower($this->session->userdata('captcha')))
					{
						$this ->callback->exitJsonCode(4000 ,'请输入正确的图形验证码，再获取手机验证码');
					}
				}
			}
			if ($endtime > 1800)
			{
				//超过半小时，重置发送
				unset($codeArr);
			}
		}
		
		//判断手机号是否可以注册
		if ($eid)
		{
			$sql = 'select union_status,status from u_expert where (login_name='.$mobile.' or mobile='.$mobile.') and id != '.$eid.' order by id desc';
		}
		else 
		{
			$sql = 'select union_status,status from u_expert where (login_name='.$mobile.' or mobile='.$mobile.') order by id desc';
		}
		
		$expertData = $this ->db ->query($sql) ->result_array();
		if (!empty($expertData))
		{
			$this ->callback->exitJsonCode(4000 ,'手机号已存在');
		}
		
		$codeStr = mt_rand(1000 ,9999);
		$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_register_msg));
		//将验证码放入模板中
		$content = str_replace("{#CODE#}", $codeStr ,$template['msg']);
		
		$num = 1;
		$start_time = $time;
		if (!empty($codeArr))
		{
			$num = $codeArr['num'] +1;
			$start_time = $codeArr['start_time'];
		}
		
		$msgArr = array(
				'code' =>'2000',
				'msg' =>'发送成功',
				'num' =>$num
		);
		echo json_encode($msgArr);
		
		//发送短信
		$status = $this ->send_message($mobile ,$content);
		//保存进入session
		$dataArr = array(
				'mobile' =>$mobile,
				'code' =>$codeStr,
				'send_time' =>$time,//本次发送时间
				'start_time' =>$start_time, //第一次发送时间
				'num' =>$num//发送的次数
		);
		$this->session->set_userdata ( array('register_expert_code' =>$dataArr) );
	}
	
	
	/**
	 * @method 发送手机验证码(要输入图形验证码)
	 * @author 贾开荣
	 * @since  2015-08-01
	 */
	public function sendMobileCode () {
		
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$mobile = trim($_REQUEST['mobile']);//手机号
		$verifycode = empty($_REQUEST['verifycode']) ? 'none' :trim($_REQUEST['verifycode']);//图形验证码
		$type = empty($_REQUEST['type']) ? '' :intval($_REQUEST['type']);//用于区分发送哪种短信
		$msgtype = empty($_REQUEST['msgtype']) ? 'defalut' : $_REQUEST['msgtype'];

		$time = time();
		//判断是否一分钟内已发送过
		$mobile_code = $this ->session ->userdata('mobile_code');
		if (!empty($mobile_code))
		{
			$endtime = $time - $mobile_code['time'];
			if ($endtime < 60)
			{
				$this ->callback->exitJsonCode(4000 ,'请您一分钟后再获取验证码');
			}
		}
		//验证验证码
		if ($verifycode != '无' && $verifycode != 'none')
		{
			if (empty($verifycode))
			{
				$this ->callback->exitJsonCode(4000 ,'请先输入图形验证码，再获取手机验证码');
			}
			else
			{
				if (strtolower($verifycode) != strtolower($this->session->userdata('captcha')))
				{
					$this ->callback->exitJsonCode(4000 ,'请输入正确的图形验证码，再获取手机验证码');
				}
			}
		}
		//验证手机号的正确性
		if (!regexp('mobile' ,$mobile))
		{
			$this ->callback->exitJsonCode(4000 ,'请输入正确的手机号');
		}
		//生成验证码
		$code = mt_rand(1000 ,9999);
		switch($type)
		{
			case  1: //用户注册
				//判断手机号是否存在
				$this ->load_model("member_model");
				$member = $this ->member_model ->row(array('mobile' =>$mobile));
				if (!empty($member)) {
					if (!empty($callback)) {
						echo $callback . "(" . json_encode(array('code' =>4000 ,'msg' =>'该号码已注册帮游网会员，本活动只对未注册的用户开放哦，推荐给朋友来抢吧~')) . ")";
						exit;
					} else {
						$this->callback->set_code ( 9000 ,"手机号已被注册");
						$this->callback->exit_json();
					}
				}
				$template = $this ->sms_model ->row(array('msgtype' =>'reg_msgcode'));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 2: //用户找回密码
				//判断手机号是否存在
				$this ->load_model("member_model");
				$member = $this ->member_model ->row(array('mobile' =>$mobile));
				if (empty($member)) {
					$this->callback->set_code ( 7000 ,"您的手机号不存在，您可以去注册页面注册");
					$this->callback->exit_json();
				}
				$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::reg_findpwd));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 3: //用户下定制单
				$template = $this ->sms_model ->row(array('msgtype' =>'custom_msgcode'));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 4: //管家注册
				//判断手机号是否存在
				$this ->load_model("common/u_expert_model" ,'expert_model');
				$sql = "select mobile,id,status from u_expert where (mobile={$mobile} or login_name={$mobile}) order by id desc";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData))
				{
					$this->callback->setJsonCode ( 4000 ,"手机号已存在");
				}
				$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_register_msg));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 5://管家找回密码
				//判断手机号是否存在
				$this ->load_model("expert_model");
				$expert = $this ->expert_model ->row(array('login_name' =>$mobile));
				if (empty($expert)) {
					$this->callback->set_code ( 7000 ,"您的手机号尚未注册，您可以去注册页面注册");
					$this->callback->exit_json();
				}
				$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_retrieve_pass));
				//echo $this ->db ->last_query();
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 6: //商家注册
				//判断手机号是否存在
				$sql = "select link_mobile,status,id from u_supplier where login_name={$mobile} and status != 3 order by id desc";
				$supplierData = $this ->db ->query($sql) ->result_array();
				if (!empty($supplierData)) {
					switch($supplierData[0]['status']) {
						case 1:
							$this->callback->set_code ( 9000 ,"手机号已被申请，正在审核中");
							$this->callback->exit_json();
							break;
						case 2:
							$this->callback->set_code ( 9000 ,"手机号已存在");
							$this->callback->exit_json();
							break;
						case -1:
							$this->callback->set_code ( 9000 ,"您的手机已被平台冻结，请联系客服");
							$this->callback->exit_json();
							break;
						case -2:
							$this->callback->set_code ( 9000 ,"您的手机已被平台终止，请联系客服");
							$this->callback->exit_json();
							break;
						default:
							$this->callback->set_code ( 9000 ,"手机号已存在");
							$this->callback->exit_json();;
							break;
					}
				}
				$template = $this ->sms_model ->row(array('msgtype' =>'supplier_register_msg'));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 7: //商家找回密码
				//验证手机号是否存在
				$this ->load_model("supplier_model");
				$supplier = $this ->supplier_model ->row(array('mobile' =>$mobile,'status >=' =>1 ,'status <='=>2));
				//echo $this ->db ->last_query();
				if (empty($supplier)) {
					$this->callback->set_code ( 7000 ,"您的手机号尚未注册，您可以去注册页面注册");
					$this->callback->exit_json();
				} elseif ($supplier['status'] == 1) {
					$this->callback->set_code ( 4000 ,"您账号正在审核中，审核后会以短信通知您");
					$this->callback->exit_json();
				}
				$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::supplier_retrieve_pass));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 8: //管家资料的修改
				//判断手机号是否存在
				$this ->load_model("common/u_expert_model" ,'expert_model');
				$sql = "select mobile,id,status from u_expert where (mobile={$mobile} or login_name={$mobile}) and status !=3 order by id desc";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData)) {
					switch($expertData[0]['status']) {
						case 1:
							$this->callback->set_code ( 4000 ,"此手机号正在审核中，请耐心等待");
							$this->callback->exit_json();
							break;
						case 2:
							$this->callback->set_code ( 4000 ,"手机号已存在");
							$this->callback->exit_json();
							break;
						case -1;
						$this->callback->set_code ( 4000 ,"您的手机号已被平台终止，请联系客服");
						$this->callback->exit_json();
						break;
						default:
							$this->callback->set_code ( 4000 ,"手机号已存在");
							$this->callback->exit_json();
							break;
					}
				}
				$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_update));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 9: //普通短信 （不做手机号是否存在判断） 温文斌
					$template = $this ->sms_model ->row(array('msgtype' =>$msgtype));
					//将验证码放入模板中
					$content = str_replace("{#CODE#}", $code ,$template['msg']);
					break;
			case 10: //微信漂流活动验证码   温文斌
						$this ->load_model("member_model");
						$member = $this ->member_model ->row(array('mobile' =>$mobile));
						if (!empty($member)) {
							if (!empty($callback)) {
								echo $callback . "(" . json_encode(array('code' =>4000 ,'msg' =>'该号码已注册帮游网会员，本活动只对未注册的用户开放哦，推荐给朋友来抢吧~')) . ")";
								exit;
							} else {
								$this->callback->set_code ( 9000 ,"手机号已被注册");
								$this->callback->exit_json();
							}
						}
						$template = $this ->sms_model ->row(array('msgtype' =>'wx_activity_1'));
						//将验证码放入模板中
						$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			default:
				$this->callback->set_code ( 8000 ,"请确认发送类型");
				$this->callback->exit_json();
				break;
		}
		if (!empty($callback)) {
			echo $callback . "(" . json_encode(array('code'=>2000 ,'type'=>$type,'msgtype'=>$msgtype,'status'=>$status,'msg' =>'发送成功')) . ")";
		} else {
			echo json_encode(array('code'=>2000 ,'msg' =>'发送成功'));
		}
		//发送短信
		$status = $this ->send_message($mobile ,$content);
		//保存入session
		if (!empty($status)) {
			$this->load->library ( 'session' );
			$data = array(
					'code' =>$code,
					'mobile' =>$mobile,
					'time' =>$time
			);
			if ($type == 1 || $type == 9 || $type == 10) {
				$this ->upMobileCode($data);
			}
			$this->session->set_userdata ( array('mobile_code' =>$data) );
		}
	}
	//将验证码保存到数据库
	public function upMobileCode($msgArr)
	{
		$this ->load_model('mobile_code_model');
		$codeArr = array(
				'mobile' =>$msgArr['mobile'],
				'code' =>$msgArr['code'],
				'addtime' =>date('Y-m-d H:i:s' ,$msgArr['time'])
		);
		$this ->mobile_code_model ->insert($codeArr);
	}
	
	/**
	 * @method 发送邮箱验证码
	 * @author 贾开荣
	 * @since  2015-09-09
	 */
	public function sendEmailCode(){
		$email = $this ->input ->post('email' ,true); //手机号
		$verifycode = $this ->input ->post('verifycode' ,true); //图形验证码
		$type = $this ->input ->post('type' ,true);//用于区分发送哪种短信
		//echo json_encode(array('code'=>2000 ,'msg' =>'发送成功'));exit;
		$time = time();
		//判断是否一分钟内已发送过
		$email_code = $this ->session ->userdata('email_code');
		if (!empty($email_code)) {
			$endtime = $time - $email_code['time'];
			if ($endtime < 60) {
				$this->callback->set_code ( 4000 ,"请您一分钟后再获取验证码");
				$this->callback->exit_json();
			}
		}
		if ($verifycode != '无') {
			//验证验证码
			if (empty($verifycode)) {
				$this->callback->set_code ( 4000 ,"请先输入图形验证码，再获取验证码");
				$this->callback->exit_json();
			} else {
				if (strtolower($verifycode) != strtolower($this->session->userdata('captcha'))) {
					$this->callback->set_code ( 4000 ,"请输入正确的图形验证码，再获取验证码");
					$this->callback->exit_json();
				}
			}
		}
		//验证手机号的正确性
		if (!regexp('email' ,$email)) {
			$this->callback->set_code ( 4000 ,"请输入正确的邮箱号");
			$this->callback->exit_json();
		}
		//生成验证码
		$code = mt_rand(1000 ,9999);
		switch($type) {
			case 1: //管家注册
				//判断手机号是否存在
				$this ->load_model("common/u_expert_model" ,'expert_model');
				$sql = "select mobile,id,status from u_expert where email='{$email}' and status !=3 order by id desc";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData)) {
					switch($expertData[0]['status']) {
						case 1:
// 							$this->callback->set_code ( 4000 ,"此邮箱正在审核中，请耐心等待");
// 							$this->callback->exit_json();
							break;
						case 2:
							$this->callback->set_code ( 4000 ,"邮箱已存在");
							$this->callback->exit_json();
							break;
						case -1;
						$this->callback->set_code ( 4000 ,"您的邮箱已被平台终止，请联系客服");
						$this->callback->exit_json();
						break;
						default:
							$this->callback->set_code ( 4000 ,"邮箱已存在");
							$this->callback->exit_json();
							break;
					}
				}
				$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_register_msg));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			case 2: //修改管家
				//判断手机号是否存在
				$this ->load_model("common/u_expert_model" ,'expert_model');
				$sql = "select mobile,id,status from u_expert where email='{$email}' and status !=3 order by id desc";
				$expertData = $this ->db ->query($sql) ->result_array();
				if (!empty($expertData)) {
					switch($expertData[0]['status']) {
						case 1:
							$this->callback->set_code ( 4000 ,"此邮箱正在审核中，请耐心等待");
							$this->callback->exit_json();
							break;
						case 2:
							$this->callback->set_code ( 4000 ,"邮箱已存在");
							$this->callback->exit_json();
							break;
						case -1;
						$this->callback->set_code ( 4000 ,"您的邮箱已被平台终止，请联系客服");
						$this->callback->exit_json();
						break;
						default:
							$this->callback->set_code ( 4000 ,"邮箱已存在");
							$this->callback->exit_json();
							break;
					}
				}
				$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_update));
				//将验证码放入模板中
				$content = str_replace("{#CODE#}", $code ,$template['msg']);
				break;
			default:
				$this->callback->set_code ( 8000 ,"请确认发送类型");
				$this->callback->exit_json();
				break;
		}
		//保存到session
		$this->load->library ( 'session' );
		$data = array(
				'code' =>$code,
				'email' =>$email,
				'time' =>$time
		);
		
//		echo json_encode(array('code'=>2000 ,'msg' =>'发送成功'));
		//发送邮件
// 		$this->load->library('mailer');
// 		$status = $this->mailer->sendmail($email,'深圳市海外国际旅行社','深圳市海外国际旅行社',$content);
		$this->load->library('Send_email');
		//$email = 100;
		$msgArr = $this->send_email->email($email,'邮箱验证码',$content);
		
		if ($msgArr->statusCode == 200)
		{
			//发送成功
			$this->session->set_userdata ( array('email_code' =>$data) );
			$this->callback->set_code ( 2000 ,"发送成功");
			$this->callback->exit_json();
		}
		else 
		{
			//发送失败
			$this->callback->set_code ( 4000 ,"发送失败");
			$this->callback->exit_json();
		}
		
		//保存入session
// 		if (!empty($status)) {
// 			$this->session->set_userdata ( array('email_code' =>$data) );
// 		}
	}
	
	//获取登陆动态码
	public function getDynamicLogin(){
		$loginname = trim($this ->input ->post('loginname' ,true));
		$type = intval($this ->input ->post('type'));//类型
		try {
			if(regexp('mobile' ,$loginname)) {
				$login_type = 1;
			} else {
				if (regexp('email' ,$loginname)) {
					$login_type = 2;
				} else {
					throw new Exception('请填写正确的手机号或邮箱号');
				}
			}
			$time = time();
			//判断是否一分钟内已发送过
			$dynamicCode = $this ->session ->userdata('dynamicCode');
			if (!empty($dynamicCode)) {
				$endtime = $time - $dynamicCode['time'];
				if ($endtime < 60 && $loginname == $dynamicCode['loginname']) {
					throw new Exception('请您一分钟后再获动态登陆码');
				}
			}
			switch($type) {
				case 1: //会员动态登陆
					$sql = "select mid from u_member where loginname='{$loginname}' || mobile='{$loginname}' || email='{$loginname}'";
					$memberData = $this ->db ->query($sql) ->result_array();
					if (empty($memberData)) {
						throw new Exception('此账号不存在');
					}
					$msg_type = sys_constant::dynamic_password;
					break;
				default:
					throw new Exception('无法识别类型');
					break;
			}
			
			//获取信息模板
			$template = $this ->sms_model ->row(array('msgtype' =>$msg_type));
			if (empty($template)) {
				throw new Exception('无法读取模板');
			}
			//生成随时码
			$code = mt_rand(1000 ,9999);
			$msg = str_replace("{#PASSWORD#}", $code ,$template['msg']);
			echo json_encode(array('code' =>2000 ,'msg' =>'发送成功'));
			if ($login_type == 1) {
				//发送短信
				$status = $this ->send_message($loginname ,$msg);
			} else {
				//发送邮件
				
			}
			if (!empty($status)) {
				$dynamicArr = array(
					'loginname' =>$loginname,
					'code' =>$code,
					'time' =>$time
				);
				$this ->session ->set_userdata(array('dynamicCode' =>$dynamicArr));
			}
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e->getMessage());
			$this->callback->exit_json();
		}
		
	}
	
	//发送验证码
	public function send_mobile_code() {
		$this->load->library ( 'session' );
		
		$mobile = $this ->input ->post('mobile' ,true);
		$verifycode = $this ->input ->post('verifycode' ,true); //图形验证码
		$msgtype = $this ->input ->post('msgtype' ,true); //读取短信模板的标识
		$name = $this ->input ->post('name' ,true); //表名
		$time = time();
		//判断是否一分钟内已发送过
		$mobile_code = $this ->session ->userdata('mobile_code');

		if (!empty($mobile_code)) {
			$endtime = $time - $mobile_code['time'];
			if ($endtime < 60) {
				$this->callback->set_code ( 4000 ,"请您一分钟后再获取验证码");
				$this->callback->exit_json();
			}
		}

		//验证验证码
		if (empty($verifycode)) {
			$this->callback->set_code ( 4000 ,"请先输入图形验证码，再获取手机验证码");
			$this->callback->exit_json();
		} else {
			if (strtolower($verifycode) != strtolower($this->session->userdata('captcha'))) {
				$this->callback->set_code ( 4000 ,"请输入正确的图形验证码，再获取手机验证码");
				$this->callback->exit_json();
			}
		} 
		//验证手机号的正确性
		if (!empty($mobile)) {
			if (!regexp('mobile' ,$mobile)) {
				$this->callback->set_code ( 4000 ,"请输入正确的手机号");
				$this->callback->exit_json();
			}
			if (!empty($name)) {
				//检测手机号是否存在
				$sql = "select mobile from u_{$name} where mobile='{$mobile}' ";
				$data = $this ->db ->query($sql) ->result_array();
				if (!empty($data)) {
					$this->callback->set_code ( 4000 ,"此手机号已存在");
					$this->callback->exit_json();
				}
			}
		} else {
			$this->callback->set_code ( 4000 ,"请输入手机号");
			$this->callback->exit_json();
		}
		//生成验证码
		$code = mt_rand(1000 ,9999);
		//读取短信模板
		$template = $this ->sms_model ->row(array('msgtype' =>$msgtype));
		$template = $template ['msg'];
		//将验证码放入模板中
		$content = str_replace("{#CODE#}", $code ,$template);
		//保存到session
		$this->load->library ( 'session' );
		$data = array(
				'code' =>$code,
				'mobile' =>$mobile,
				'time' =>$time
		);
		echo json_encode(array('code'=>2000 ,'msg' =>'发送成功'));
		//发送短信
		$status = $this ->send_message($mobile ,$content);
		//保存入session
		if (!empty($status)) {
			$this->session->set_userdata ( array('mobile_code' =>$data) );
		}
	}
	
	//发送修改手机验证码
	public function send_updataMobile_code() {
		$this->load->library ( 'session' );
		
		$mobile = $this ->input ->post('mobile' ,true);
		$msgtype = 'member_update'; //读取短信模板的标识
		$time = time();
		//判断是否一分钟内已发送过
		$mobile_code_time = $this ->session ->userdata('mobile_code_time');
		
		if (!empty($mobile_code_time)) {
			$endtime = $time - $mobile_code_time['time'];
			if ($endtime < 60) {
				$this->callback->set_code ( 4000 ,"请您一分钟后再获取验证码");
				$this->callback->exit_json();
			}
		}
	
		//验证手机号的正确性
		if (!empty($mobile)) {
			if (!regexp('mobile' ,$mobile)) {
				$this->callback->set_code ( 4000 ,"请输入正确的手机号");
				$this->callback->exit_json();
			}
		//	if (!empty($name)) {
				//检测手机号是否存在
				$sql = "select mobile from u_member where mobile='{$mobile}' ";
				$data = $this ->db ->query($sql) ->result_array();
				if (!empty($data)) {
					$this->callback->set_code ( 4000 ,"此手机号已存在");
					$this->callback->exit_json();
				}
		//	}
		} else {
			$this->callback->set_code ( 4000 ,"请输入手机号");
			$this->callback->exit_json();
		}
		//生成验证码
		$code = mt_rand(1000 ,9999);
		//读取短信模板
		$template = $this ->sms_model ->row(array('msgtype' =>$msgtype));
		$template = $template ['msg'];
		//将验证码放入模板中
		$content = str_replace("{#CODE#}", $code ,$template);
		
		//保存到session
		$this->load->library ( 'session' );
		$data = array(
				'code' =>$code,
				'mobile' =>$mobile,
				'time' =>$time
		);
		//发送短信
		$status = $this ->send_message($mobile ,$content);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"发送失败");
			$this->callback->exit_json();
		} else {
			//保存入session
			$this->session->set_userdata ( array('mobile_code_time' =>$data) );
		
			$this->callback->set_code ( 2000 ,"发送成功");
			$this->callback->exit_json();
		}
		
	}
}