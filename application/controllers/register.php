<?php
/**
 * 
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊

 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Register extends UC_NL_Controller {
	
	function __construct() {
		parent::__construct ();
		set_error_handler('customError');
		$this->load->model ( 'member_model' );
		$this->load->library ( 'callback' );
	}
	public function index() {
		$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :'/';
		if ($url == site_url('login')) {
			$url = '/';
		}
		$this->load->view('register_view' ,array('url' =>$url));
	}
	
	/**
	 * @method 会员注册
	 * @author jiakairong
	 * @since  2015-11-04
	 */
	public function doRegister()
	{
		$json_callback = empty($_REQUEST['callback']) ? '' : $_REQUEST['callback'];
		$this->load->model ( 'sms_template_model' ,'sms_model' );
		$isAgree = empty($_REQUEST['isAgree']) ? 0 : intval($_REQUEST['isAgree']);
		$mobile = trim($_REQUEST['mobile']);
		$code = trim($_REQUEST['mobile_code']);
		$password = empty($json_callback) ? trim($_REQUEST['password']) :substr($mobile,5,10);
		$repass = empty($json_callback) ? trim($_REQUEST['repass']) : $password;
		$nickname = empty($_REQUEST['nickname']) ? substr($mobile ,0,3).'****'.substr($mobile,7,10) : trim($_REQUEST['nickname']);
		$litpic = empty($_REQUEST['litpic']) ? sys_constant::DEFAULT_PHOTO :trim($_REQUEST['litpic']);
		$sex = empty($_REQUEST['sex']) ? 0 : intval($_REQUEST['sex']);
		$channel = empty($_REQUEST['channel']) ? '' : $_REQUEST['channel'];
		if ($isAgree != 1)
		{
// 			if (!empty($json_callback)) {
// 				echo $json_callback . "(" . json_encode(array('code' =>3000 ,'msg' =>'你同意会员协议后方可注册')) . ")";
// 				exit;
// 			} else{
// 				$this->callback->set_code ( 4000 ,"你同意会员协议后方可注册");
// 				$this->callback->exit_json();
// 			}
			$this->callback->exitJsonCode(4000 ,'你同意会员协议后方可注册');
		}
		//手机短信验证
		$msg = $this ->judgeMobileCode($mobile ,$code ,'database');
		if ($msg !== true)
		{
// 			if (!empty($json_callback)) {
// 				echo $json_callback . "(" . json_encode(array('code' =>4000 ,'msg'=>$msg)) . ")";
// 				exit;
// 			} else{
// 				$this->callback->set_code ( 4000 ,$msg);
// 				$this->callback->exit_json();
// 			}
			$this->callback->exitJsonCode(4000 ,$msg);
		}
		//无密码 默认手机后六位
// 		if (!empty($json_callback)) {
// 			$password = substr($mobile,5,10);
// 			$repass = $password;
// 		}
		//密码验证
		$passLen = strlen($password);
		if ($passLen < 6 || $passLen > 20){
// 			$this->callback->set_code ( 4000 ,"密码在6到20位之间");
// 			$this->callback->exit_json();
			$this->callback->exitJsonCode(4000 ,'密码在6到20位之间');
		}else{
			if ($password != $repass)
			{
// 				$this->callback->set_code ( 4000 ,"两次密码输入不一致");
// 				$this->callback->exit_json();
				$this->callback->exitJsonCode(4000 ,'两次密码输入不一致');
			}
		}
		
		//验证手机号是否存在
		$memberData = $this ->member_model ->uniqueMobile($mobile);
		if (!empty($memberData))
		{
			if (!empty($json_callback)) {
				$this->load_model ( 'wx/wx_member_model', 'wx_member_model' );
				$openid = $_REQUEST['openid'];
				$status = $this->wx_member_model->updateMemberStatus_two($openid,$memberData[0]['mid']);
// 				echo $json_callback . "(" . json_encode(array('code' =>4000 ,'msg' =>'该号码已注册帮游网会员，本活动只对未注册的用户开放哦，推荐给朋友来抢吧~')) . ")";
// 				exit;
				$this->callback->exitJsonCode(4001 ,'该号码已注册帮游网会员，本活动只对未注册的用户开放哦，推荐给朋友来抢吧~');
			} else{
// 				$this->callback->set_code ( 4000 ,"手机号已存在");
// 				$this->callback->exit_json();
				$this->callback->exitJsonCode(4000 ,'手机号已存在');
			}
		}
		$userArea = $this ->getUserArea();
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$memberArr = array(
				'loginname'=>$mobile,
				'nickname' =>$nickname,
				'truename' =>'',
				'pwd'=>md5($password),
				'mobile'=>$mobile,
				'jointime'=> $time,
				'sex' =>$sex,
				'litpic' =>$litpic,
				'jifen' =>sys_constant::REGISTER_JIFEN,
				'logintime' =>$time,
				'loginip' =>$userArea['ip'],
				'province' =>$userArea['province'],
				'city' =>$userArea['city'],
				'register_channel' =>$channel
		);

		$mid = $this->member_model->memberRegister( $memberArr );
		if ($mid > 0){
			//给会员送优惠券
			//$this ->member_coupon(1, $mid);
			$this ->session ->unset_userdata('mobile_code');
			//注册成功直接登录
			$memberArr['mid'] = $mid;
			$this ->loginSuccess($memberArr);
			if (!empty($json_callback)) {
				//更新激活状态
				$this->load_model ( 'wx/wx_member_model', 'wx_member_model' );
				$openid = $_REQUEST['openid'];
				$status = $this->wx_member_model->updateMemberStatus($openid,$mid,$channel);
				//echo $json_callback . "(" . json_encode(array('code' =>2000 ,'msg' =>'注册成功')) . ")";
				//exit;
			} else{
				//echo json_encode(array('code'=>2000 ,'msg'=>'注册成功'));
			}
			$this->callback->echoJsonCode(2000 ,'注册成功');
			$this ->deleteMobileCode($mobile);
			//发送短信
			$template = $this ->sms_model ->row(array('msgtype' =>sys_constant::member_register));
			$content = str_replace("{#loginname#}", $mobile ,$template['msg']);
			$content = str_replace("{#ID#}", $mid ,$content);
			$this ->send_message($mobile ,$content);
		}else{
// 			if (!empty($json_callback)) {
// 				echo $json_callback . "(" . json_encode(array('code' =>4000 ,'msg' =>'注册失败')) . ")";
// 				exit;
// 			} else{
// 				$this->callback->set_code ( 4000 ,"注册失败");
// 				$this->callback->exit_json();
// 			}
			$this->callback->exitJsonCode(4000 ,'注册失败');
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
}
