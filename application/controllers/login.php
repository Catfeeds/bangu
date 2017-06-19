<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
require_once(FCPATH."uc/config.inc.php");
require_once(FCPATH."uc/uc_client/client.php");
class Login extends UC_NL_Controller {
	private $key = '1b1u-user-rl';//秘钥
	public function __construct() {
		parent::__construct ();  
		$this->load->model ( 'member_model' );
		$this->load->library ( 'callback' );
		$this->load->helper ( 'cryp' );
		$this->load->helper('cookie');
	}  
	public function index() {
		$username = $this->session->userdata('c_username');
		if(!empty($username)){
			echo "<script>alert('您已登录');window.history.back();</script>";exit;
		}
		$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
		$member = get_cookie('ps');
		if ($member !== false)
		{
			$member = decrypt($member ,$this->key);
			$userArr = explode('##', $member);
			$data['mobile'] = $userArr[0];
			$data['pass'] = $userArr[1];
			$data['isRemeber'] = 1;
		}
		else 
		{
			$data['mobile'] = '';
			$data['pass'] = '';
			$data['isMember'] = 0;
		}
		
		$data ['result_msg'] = '';
		$data ['url'] = $url;
		$this->load->view ( 'login_view', $data );
	}
	
	public function do_login() {
		$username = $this->input->post ( 'username' ,true );
		$password = $this->input->post ( 'password' ,true );
		$verifycode = $this ->input ->post( 'verifycode' ,true);
		$isRemember = intval($this ->input ->post( 'isRemember'));
		
		$url = $this ->input ->post('url' ,true);
		$url = empty($url)?'/':$url;
		if (strtolower($verifycode) !== strtolower($this->session->userdata('captcha')))
		{
			$this->callback->set_code ( 4000 ,"验证码不正确");
			$this->callback->exit_json();
		}

		if (empty ( $username )) {
			$this->callback->set_code ( 4000 ,"用户名不能为空");
			$this->callback->exit_json();
		}
		
		$res_query = $this ->member_model ->getMemberLogin($username);
		if (empty($res_query)) {
			$this->callback->set_code ( 4000 ,"用户名不存在");
			$this->callback->exit_json();
		} else {
			$res_query = $res_query[0];
		}

		$password_local = $res_query ['pwd'];
		if (md5 ( $password ) != $password_local) {
			$this->callback->set_code ( 4000 ,"密码错误");
			$this->callback->exit_json();
		}
		//写入授权
		$sns_user=$this->session->userdata('user');
		if (!empty($sns_user)) {
			$status = $this ->insertMemberThird($res_query['mid']);
			if ($status == false) {
				$this->callback->set_code ( 4000 ,"绑定失败，请刷新重试");
				$this->callback->exit_json();
			}
		}
		//写入session
		$res_query['pwd']= $password;
		$this->loginSuccess($res_query);
		if ($isRemember == 1)
		{
			set_cookie('ps',encrypt($username.'##'.$password ,$this->key),24*7*3600);
		}
		else 
		{
			delete_cookie('ps');
		}
		
		if(empty($url) || $url == site_url('register') || $url == site_url('register/index') || $url == site_url('login/retrieve_pass'))
		{
			$url = "/";
		}
		$this->callback->set_code ( 2000 ,$url);
		$this->callback->exit_json();
	}
	
	
	//动态登陆
	public function doDynamicLogin() {
		$loginname = trim($this ->input ->post('loginname' ,true));
		$code = intval($this ->input ->post('dynamic_code'));
		$url = trim($this ->input ->post('url' ,true));
		$dynamicCode = $this ->session ->userdata('dynamicCode');
		
		
		if (empty($dynamicCode)) {
			$this->callback->set_code ( 4000 ,'请获取动态码');
			$this->callback->exit_json();
		}
		
		if ($dynamicCode['code'] != $code || $dynamicCode['loginname'] != $loginname) {
			$this->callback->set_code ( 4000 ,'您输入的动态码不正确');
			$this->callback->exit_json();
		} else {
			$endtime = time() - $dynamicCode['time'];
			if ($endtime > 600) {
				$this->callback->set_code ( 4000 ,'您的动态码已过期');
				$this->callback->exit_json();
			}
		}
		$memberData = $this ->member_model ->getMemberLogin($loginname);
		if (empty($memberData)) {
			$this->callback->set_code ( 4000 ,'您的账号不存在');
			$this->callback->exit_json();
		}

		$this ->loginSuccess($memberData[0]);
		
		if($url == site_url('register') || $url == site_url('register/index') || $url == site_url('login/retrieve_pass'))
		{
			$url = "/";
		}
		$this ->session ->unset_userdata('dynamicCode');
		$this->callback->set_code ( 2000 ,$url);
		$this->callback->exit_json();
	}
	
	/**
	 * @method 创建账号并绑定第三方登录 
	 * @author jiakairong
	 * @since  2015-10-13
	 */
	public function createAccount() {
		$mobile = trim($this ->input ->post('mobile' ,true));
		$password = trim($this ->input ->post('password' ,true));
		$repass = trim($this ->input ->post('repass' ,true));
		$code = trim($this ->input ->post('code' ,true));
		$isAccept = intval($this ->input ->post('isAccept'));
		$isAgree = intval($this ->input ->post('isAgree'));
		
		$time = time();
		try {
			if ($isAccept != 1) {
				throw new Exception('请您接受旅游咨询免费信息'); 	
			}
			if ($isAgree != 1) {
				throw new Exception('请您阅读并同意游帮会员协议');
			}
			
			$status = $this ->judgeMobileCode($mobile ,$code);
			if ($status !== true) {
				throw new Exception($status); 	
			}
			//验证密码
			$length_pass = strlen($password);
			if ($length_pass < 6 || $length_pass >15) {
				throw new Exception('密码在6到15位之间');
			}
			if ($password != $password) {
				throw new Exception('两次密码输入不一致');
			}
			//验证手机号
			$memberData = $this ->member_model ->getMemberLogin($mobile);
			if (!empty($memberData)) {
				throw new Exception('手机号已存在');
			}
			
			$this->db->trans_begin(); //事务开始
			$sns_user=$this->session->userdata('user');
// 			$sns_user = array(
// 					'via' =>'weibo',
// 					'uid' =>'5241994404',
// 					'screen_name' =>'贾开荣alfred',
// 					'name' =>'贾开荣alfred',
// 					'location' =>'广东 深圳',
// 					'description' =>'',
// 					'image' =>'http://tp1.sinaimg.cn/5241994404/50/0/1',
// 					'access_token' =>'2.00qMskiFanRmUDc4bd875270JHIbVD',
// 					'expire_at' =>'1445367601',
// 					'refresh_token' =>null
// 			);
			$password = 123456;
			$memberArr = array(
					'loginname' => $mobile,
					'nickname'=>$sns_user['screen_name'],
					'truename' =>substr($mobile ,0,2).'****'.substr($mobile,7,10),
					'pwd' => md5 ( $password ),
					'mobile' => $mobile,
					'litpic' => sys_constant::DEFAULT_PHOTO,
					'jointime' => $time,
					'sex' => - 1
			);
			$mid = $this ->member_model ->insert($memberArr);
			if (empty($status)) {
				throw new Exception('创建失败，请刷新重试');
			}
				
			//写入授权
			if (!empty($sns_user)) {
				$status = $this ->insertMemberThird($mid);
				if ($status == false) {
					$this->callback->set_code ( 4000 ,"绑定失败，请刷新重试");
					$this->callback->exit_json();
				}
			}
			
			//登陆
			$memberArr['mid'] = $mid;
			$memberArr['logintime'] = date('Y-m-d H:i:s' ,$time);
			$this ->loginSuccess($memberArr);
			

			if ($this->db->trans_status() === FALSE) { //判断此组事务运行结果
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				echo json_encode(array('code' =>'2000' ,'msg'=>'/'));
				//发送短信
				$this ->load_model('common/u_sms_template_model','template_model');
				$smsData = $this ->template_model ->row(array('msgtype' =>sys_constant::auto_reg));
				if (!empty($smsData['msg'])) {
					$msg = str_replace("{#LOGINNAME#}", $mobile ,$smsData['msg']);
					$msg = str_replace("{#PASSWORD#}", $password ,$msg);
					$this ->send_message($mobile ,$msg);
				}
			}
				
		} catch (Exception $e) {
			$this->db->trans_rollback(); //出现错误执行回滚
			$this->callback->set_code ( 4000 ,$e->getMessage());
			$this->callback->exit_json();
		}
	}
	
	/**
	 * @method 写入第三方登录的授权
	 * @param intval $mid 用户id
	 * @return boolean
	 */
	public function insertMemberThird($mid) {
		$sns_user=$this->session->userdata('user');
		$dataArr=array(
				'mid'=>$mid,
				'connectid'=>$sns_user['uid'],
				'from'=>$sns_user['via'],
				'access_token'=>$sns_user['access_token'],
				'addtime'=>date('Y-m-d H:i:s', time())
		);
		$status = $this->db->insert('u_member_third_login', $dataArr);
		if (empty($status)) {
			return false;
		} else {
			$this ->session ->unset_userdata(array('user'=>''));
			return true;
		}
	}
	
	
	//找回密码页
	public function retrieve_pass() {
		$this->load->view ( 'retrieve_pass');
	}
	/**
	 * @method 找回密码验证
	 * @author jiakairong
	 * @since  2015-07-02
	 */
	public function do_retrieve_pass() {
		$this->load->library ( 'callback' );
		$this->load->library ( 'session' );
		$mobile = trim($this ->input ->post('mobile'));
		$code = $this ->input ->post('code' ,true);
		$password = trim($this ->input ->post('password' ,true));
		$repass = trim($this ->input ->post('repass' ,true));
		//验证手机验证码
		$session_data = $this ->session ->userdata('mobile_code');
		$time = time();
		if (empty($session_data)) {
			$this->callback->set_code ( 4000 ,'请获取手机验证码');
			$this->callback->exit_json();
		} else {
			if (!empty($session_data) && ($time - $session_data ['time']) > 600 ) {
				$this ->session ->unset_userdata('mobile_code');
				$this->callback->set_code ( 4000 ,"您的验证码已过期");
				$this->callback->exit_json();
			}
			if ($session_data ['code'] != $code || $session_data['mobile'] != $mobile) {
				$this->callback->set_code ( 4000 ,"您输入的手机验证码不正确");
				$this->callback->exit_json();
			}
		}
		
		if (empty($mobile)) {
			$this->callback->set_code ( 4000 ,'请填写手机号');
			$this->callback->exit_json();
		} else {
			//验证手机是否已注册
			$member_info = $this->member_model->row ( array('mobile' =>$mobile)); // 获取用户信息
			if (empty($member_info)) {
				$this->callback->set_code ( 4000 ,"您的手机号尚未注册，您可以去注册页注册");
				$this->callback->exit_json();
			}
		}
		
		if (empty($password)) {
			$this->callback->set_code ( 4000 ,'请填写密码');
			$this->callback->exit_json();
		}
		$pass_len = strlen($password);
		if ($pass_len < 6 || $pass_len > 16) {
			$this->callback->set_code ( 4000 ,'请填写6到16位的密码');
			$this->callback->exit_json();
		}
		if ($password != $repass) {
			$this->callback->set_code ( 4000 ,'两次密码输入不一致');
			$this->callback->exit_json();
		}
		//新密码与原密码一致
		if (md5($password) == $member_info ['pwd']) {
			$this->callback->set_code ( 2000 ,'修改成功');
			$this->callback->exit_json();
		}
		//修改用户密码
		$whereArr = array(
			'mobile' =>$mobile
		);
		$member_data = array(
			'pwd' =>md5($password)
		);
		$status = $this ->member_model ->update($member_data ,$whereArr);
		if ( empty($status) ) {
			$this->callback->set_code ( 4000 ,'修改失败');
			$this->callback->exit_json();
		} else {
			//清除session中的手机与验证码
			$this ->session ->unset_userdata('mobile_code');
			$this->callback->set_code ( 2000 ,'修改成功');
			$this->callback->exit_json();
		}
		
	}
	/**
	 * 退出
	 */
	public function logout() {
		$this->load->library ( 'session' );
		$array_items = array('c_username' => '', 'c_userid' => '' ,'c_loginname' =>'');		
		$this->session->unset_userdata($array_items);
	//	var_dump($_SERVER['HTTP_REFERER']);exit;
		redirect ( $_SERVER['HTTP_REFERER'] );
	}
}