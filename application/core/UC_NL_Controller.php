<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月3日11:03:55
 * @author		贾开荣
 * @method 		未登录继承
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UC_NL_Controller extends MY_Controller {
	public $userid ;
	
	public function __construct() {
		parent::__construct();
		$this ->get_ip_city();
		
		$commonData = array(
			'web' =>$this ->get_web(),
			'navData' =>$this ->getHeadNav()
		);
		$this ->load->view('data',$commonData);
	}
	
	/**
	 * @method 获取站点配置信息
	 * @return unknown
	 */
	public function get_web() {
		$this ->load_model('common/cfg_web_model' ,'web_model');
		$webData = $this ->web_model ->row(array('id' =>1) ,'arr' ,'' ,'title,url,webname,icon,keyword,description,companyname,icp,expert_question_url');
		return $webData;
	}
	//获取头部导航
	public function getHeadNav() {
		$this ->load_model('common/cfg_index_nav_model' ,'nav_model');
		$nav_list = $this ->nav_model ->all(array('is_show' =>1) ,'showorder asc' ,'arr');
		//var_dump($nav_list);
		return $nav_list;
	}

	//根据ip地址定位
	public function get_ip_city () {
		$this ->load_model('startplace_model' ,'startplace_model');
		$startcity = $this ->session ->userdata('city_location');
		//var_dump($this->session->userdata('city_location_id'));
		$startcity = array();
		//var_dump($startcity);
		if (empty($startcity))
		{
			$this->load->library ( 'GetCityIp' );
			$ip = $this ->getip();
			//$ip = '61.244.148.166';
			$areaArr = $this ->getcityip ->getIPLoc_sina($ip);
			if (!empty($areaArr) && (!empty($areaArr['city']) || !empty($areaArr['province']))) {
				if (!empty($areaArr['city'])) {
					$startcity = $areaArr['city'];
					$startArr = $this ->startplace_model ->row(array('cityname like' =>"{$startcity}%" ,'isopen' =>1,'level'=>3));
				} elseif (!empty($areaArr['province'])) {
					$startcity = $areaArr['province'];
					$startArr = $this ->startplace_model ->row(array('cityname like' =>"{$startcity}%" ,'isopen' =>1,'level'=>3));
				}
			}
			if (empty($areaArr) || !isset($startArr) || empty($startArr)) {
				
				//$startArr未定义则是ip未定位到城市，若$startArr为空则没有这个出发城市
				//读取默认城市
				$startcity = sys_constant::STARTCITY;
				$startArr = $this ->startplace_model ->row(array('cityname like' =>"{$startcity}%" ,'isopen' =>1,'level'=>3));
			}
			$startId = $startArr['id'];
			$my_city=$this->session->userdata('city_location_id');
			if(empty($my_city))
			{
				$this->session->set_userdata('city_location',$startcity);
				$this->session->set_userdata('city_location_id',$startId);
			}
		}
	}

	/**
	 * @method 会员操作后送优惠券
	 * @param intval $type  操作类型
	 * @param intval $mid   会员ID
	 */
	public function member_coupon($type ,$mid)
	{
		$this ->load_model('common/cou_action_model' ,'cou_action_model');
		$this ->load_model('common/cou_member_action_model' ,'member_action_model');
		switch($type)
		{
			case 1: //会员注册
				$code = 'REGISTER';
				break;
		}
		$couActionData = $this ->cou_action_model ->getCouActionCode($code);
		if (empty($couActionData))
		{
			return 1;//会员的当前操作没有可参与项目
		}

		if ($couActionData[0]['isrepeat'] == 0)//不可以重复参与
		{
			$memberActionData = $this ->member_action_model ->all(array('member_id' =>$mid ,'action_id' =>$couActionData[0]['id']));
			if (!empty($memberActionData))
			{
				return 2;//用户已参与过此项目
			}
		}

		//获取当前项目关联的优惠券
		$actionCouponData = $this ->cou_action_model ->getActionCoupon($couActionData[0]['id']);
		if (empty($actionCouponData))
		{
			return 3;//没有优惠券
		}
		//验证优惠券数量是否足够
		foreach($actionCouponData as $key=>$val)
		{
			if ($val['couponNumber'] < $val['cacNumber'] || $val['cacNumber'] == 0)
			{
				unset($actionCouponData[$key]); //优惠券数量不足 or 赠送数量为0, 则不与赠送
			}
		}
		if (count($actionCouponData) == 0)
		{
			return 3;
		}
		return $this ->cou_action_model ->changeMemberCoupon($mid ,$actionCouponData);
	}
	
	/**
	 * @method 验证发送的手机验证码
	 * @param string $mobile 手机号
	 * @param string $code	手机验证码
	 * @param string $type	验证码保存方式 session or database
	 * @return string|boolean
	 */
	public function judgeMobileCode($mobile ,$code ,$type='session')
	{
		if (empty($mobile))
		{
			return '请填写手机号';
		}
		if (empty($code))
		{
			return '请填写验证码';
		}
		//优先获取session中的验证码
		//$mCode = $this ->session ->userdata('mobile_code');
		//获取验证码信息
		if ($type == 'database')
		{
			$this ->load_model('mobile_code_model');
			$mCode = $this ->mobile_code_model ->row(array('mobile' =>$mobile),'arr','id desc');
		}
		else 
		{
			$mCode = $this ->session ->userdata('mobile_code');
		}
		if (empty($mCode))
		{
			return '请获取验证码';
		}
		else
		{
			$mCode['time'] = empty($mCode['time']) ? strtotime($mCode['addtime']) : $mCode['time'];
			$timeMC = time();
			if ($timeMC - $mCode['time'] > 600)
			{
				$this ->session ->unset_userdata('mobile_code');
				return '您的验证码已过期,请重新获取';
			}
			elseif ($mCode['mobile'] == $mobile && $mCode['code'] == $code)
			{
				return true;
			}
			else
			{
				return '您的手机号和验证码不匹配';
			}
		}
	}
	/**
	 * @method 删除已使用的手机验证码
	 * @author jkr
	 * @param unknown $mobile
	 */
	public function deleteMobileCode($mobile)
	{
		$this ->load_model('mobile_code_model');
		$this ->mobile_code_model ->delete(array('mobile' =>$mobile));
	}
	/**
	 * @method 登陆成功保存用户信息到session并修改登录时间与ip地址
	 * @param array $dataArr 用户信息的数组
	 */
	public function loginSuccess(array $dataArr)
	{
		$this ->load_model('member_model');
		$this->session->set_userdata ( array (
				'c_username' => $dataArr['loginname'],
				'c_pwd' => $dataArr['pwd'],
				'c_userid' => $dataArr ['mid'],
				'c_loginname' =>$dataArr ['nickname'],
				'c_truename' =>$dataArr['truename'],
				'c_logintime' =>$dataArr['logintime']
		) );
		$memberArr = array(
				'logintime' =>date('Y-m-d H:i:s' ,time()),
				'loginip' =>$this ->getip()
		);
		$this ->member_model ->update($memberArr ,array('mid' =>$dataArr['mid']));
	}
	
}