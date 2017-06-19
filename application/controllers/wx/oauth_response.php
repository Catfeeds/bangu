<?php

/**
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @method 订单支付
 * @author 贾开荣
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
define ( "TOKEN", "Aa11223344" );
define ( "APPID", "wxdf9c654d2458ec69" );
define ( "SECRET", "74e0ecfa7c222f2be87bd084dae2631e" );
class Oauth_response extends MY_Controller {
	public function __construct() {
		parent::__construct ();
		header ( 'Content-type: application/json;charset=utf-8' );
		header ( "content-type:text/html;charset=utf-8" );
		$this->load->helper('url');
		echo header ( 'Access-Control-Allow-Origin: *' );
	}
	/**
	 * 注册送漂流：初始页面
	 * 描述： 微信登录并参与活动
	 */
	public function index() {
		$state = $_GET["state"];
		$code = null;
		if (isset ( $_REQUEST["code"] )) {
			$code = $_REQUEST["code"];
		}
		if (null != $code) {  // 若用户授权
			$sns_access_token_array = $this->get_sns_access_token( $code );//SNS token
			//获取微信用户
			$user = $this->get_user ( $sns_access_token_array );
			$user["sns_access_token"] = $sns_access_token_array;
			
			$access_token_array = $this->get_access_token( $code ); //access token
			$user["access_token_array"] = $access_token_array;
			//获取签名
			$signature = $this->getSignature($access_token_array);
			//$this->session->set_userdata("signature",$signature);
			
			$errcode=0;
			if(array_key_exists("errcode",$user)){
				$errcode = $user['errcode'];
			}
			if($errcode==0){
				$user['user_type']='pl'; //用户类型：“漂流”活动用户
				$wx_member = $this->save_wx_member($user);
				//通过openid 判断 用户是否已经领取过
				//没领取跳转到注册页面,并且插入微信用户数据 状态为未领取
// 				echo "4".$wx_member->reg_status;
				$user['id']=$wx_member['id'];
				$user['reg_status']=$wx_member['reg_status'];
				$user['status']=$wx_member['status'];  //将$wx_member和$user整在一起，减少重复信息
				$this->session->set_userdata("user",$user );
				if($wx_member['reg_status']==0||$wx_member['reg_status']=='0'){
					//有推荐的ID 就获取上一个的ID
					if (isset ( $_REQUEST["id"] )) {
						$recommend_member = $this->getMember($_REQUEST["id"]);
						$data['headimgurl'] = $recommend_member['headimgurl'];
						$data['nickname'] = $recommend_member['nickname'];
					}else{
						$data['headimgurl'] = "http://www.1b1u.com/static/img/u.jpg";
						$data['nickname'] = "小U";
					}
					$data['user'] = $user;
					$data['number'] = $this->getNumber();
					//var_dump($user);
					$this->load->view('wx/pl/piaoliu',$data);
				}else{
					$data['user'] = $user;
					//已经领取跳转到成功页面
// 					$this->load->view('wx/pl/success',$data);
					redirect('http://m.1b1u.com/wx/oauth_response/success?id='.$user['id'], 'refresh');
				}
			}else{
				redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf9c654d2458ec69&redirect_uri=http%3A%2F%2Fm.1b1u.com%2Fwx%2Foauth_response&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', 'refresh');
			}
		}else{
			redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf9c654d2458ec69&redirect_uri=http%3A%2F%2Fm.1b1u.com%2Fwx%2Foauth_response&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', 'refresh');
		}
	}
	/**
	 * 注册送漂流：成功页面
	 * */
	public function success() {
		$user = $this->session->userdata ( 'user' );
		if (empty($user)){
			redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf9c654d2458ec69&redirect_uri=http%3A%2F%2Fm.1b1u.com%2Fwx%2Foauth_response&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', 'refresh');
		}else{
			$errcode=0;
			if(array_key_exists("errcode",$user)){
				$errcode = $user['errcode'];
			}
			if($errcode!=0 ||$errcode!='0'){
				redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf9c654d2458ec69&redirect_uri=http%3A%2F%2Fm.1b1u.com%2Fwx%2Foauth_response&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', 'refresh');
			}
			$user['user_type']='pl'; //用户类型：“漂流”活动用户
			$wx_member = $this->save_wx_member($user);
			$user['id']=$wx_member['id']; //wx_member的id
			$user['reg_status']=$wx_member['reg_status'];
			$user['status']=$wx_member['status'];  //将$wx_member和$user整在一起，减少重复信息
			$this->session->set_userdata("user",$user );
			$data['user'] = $user;
			$data['number'] = $this->getNumber();
			
			if($wx_member['reg_status']==0||$wx_member['reg_status']=='0'){
				//有推荐的ID 就获取上一个的ID
				if (isset ( $_REQUEST["id"] ) && ""!=$_REQUEST["id"]) {
					$recommend_member = $this->getMember($_REQUEST["id"]);
// 					var_dump($recommend_member);
					$data['headimgurl'] = $recommend_member['headimgurl'];
					$data['nickname'] = $recommend_member['nickname'];
				}else{
					$data['headimgurl'] = "http://www.1b1u.com/static/img/u.jpg";
					$data['nickname'] = "小U";
				}
				$this->load->view('wx/pl/piaoliu',$data);
			}else{
				$sess_token=$this->session->userdata('token');//session
				if($sess_token){
					$access_token_array['access_token']=$sess_token;
				}else{
					$access_token_array=$this->get_access_token();
				}
				$this->session->set_userdata(array('token'=>$access_token_array['access_token']));
				//var_dump($access_token_array);
				$signature = $this->getSignature($access_token_array);
				$this->session->set_userdata("signature",$signature);
				$this->load->view('wx/pl/success',$data);
			}
			
		}
	}
	public function shake2() {
		$this->load->view('wx/shake/shake');
	}
	public function yiy() {
		$this->load->view('wx/shake/yiy');
	}
	/**
	 * @abstract摇一摇
	 * @author温文斌
	 * */
	public function shake() {
		$state = $_GET["state"];
		$code = null;
		if (isset ( $_REQUEST["code"] )) {
			$code = $_REQUEST["code"];
		}
		if (null != $code) {
			$sns_access_token_array = $this->get_sns_access_token( $code );
			//获取用户
			$user = $this->get_user ( $sns_access_token_array );
			$user["sns_access_token"] = $sns_access_token_array;//SNS token
				
			$access_token_array = $this->get_access_token( $code );
			$user["access_token_array"] = $access_token_array;//
			//获取签名
			$signature = $this->getSignature($access_token_array);
			
			
				
			$errcode=0;
			if(array_key_exists("errcode",$user)){
				$errcode = $user['errcode'];
			}
			if($errcode==0){
				$user['user_type']='yiy';//用户类型：“摇一摇”活得用户
				$wx_member = $this->save_wx_member($user);
				//判断是否认证
				if($wx_member){
					//有推荐的ID 就获取上一个的ID
					$user['id']=$wx_member['id'];
					$user['reg_status']=$wx_member['reg_status'];
					$user['status']=$wx_member['status'];
					$this->session->set_userdata("user",$user );
					$data['user'] = $user;
					$this->load->view('wx/shake/shake',$data);
				}else{
					show_404('404',500,'page not found');
				}
			}else{
				redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf9c654d2458ec69&redirect_uri=http%3A%2F%2Fm.1b1u.com%2Fwx%2Foauth_response%2Fshake&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', 'refresh');
			}
		}else{
			redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf9c654d2458ec69&redirect_uri=http%3A%2F%2Fm.1b1u.com%2Fwx%2Foauth_response%2Fshake&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', 'refresh');
		}
	}
	
	public function getSignature($access_token_array){
		// 获取用户信息
		$sess_ticket=$this->session->userdata('ticket');//session
		$user_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token_array['access_token']."&type=jsapi";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $user_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		
		if($sess_ticket)
		{
			$result_array['ticket']=$sess_ticket;
		}
		else
		{
			$result_array = json_decode ( $output, 1 );
		}
		$this->session->set_userdata(array('ticket'=>$result_array['ticket']));
		
 		//var_dump($access_token_array);
		$time = time();
		$nonceStr = "e4b00e34-3c6f-421a-b032-69a1769d9b6c";
		//$url = "http://m.1b1u.com";
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$str = "jsapi_ticket=".$result_array['ticket']."&noncestr=".$nonceStr."&timestamp=".$time."&url=".$url;
		$val=sha1($str);
		$signature['appid'] = APPID;
		$signature['signature'] = $val;
		$signature['time'] = $time;
		$signature['nonceStr'] = $nonceStr;
		$signature['url'] = $url;
		// // 释放curl句柄
		// // 打印获得的数据
		// https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
// 		{
// 			"errcode":0,
// 			"errmsg":"ok",
// 			"ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA",
// 			"expires_in":7200
// 		}
        //var_dump($str);var_dump($val);
		return $signature;
	}
	
	public function getMember($id){
		$post_url = "http://www.1b1u.com/wx/pl/api/getMemberById?id=".$id;
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $post_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		$member_array = json_decode ( $output, 1 );
		return $member_array;
	}
	
	public function getNumber(){
		$post_url = "http://www.1b1u.com/wx/pl/api/getActivityNumber";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $post_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		return $output;
	}
	
	public function save_wx_member($user){
		$post_url = "http://www.1b1u.com/wx/pl/api/save_wx_member";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $post_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $user );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		return json_decode($output,true); // true 表示数组形式
	}
	
	public function test(){
		$user['headimgurl']="1";
		$data["user"] = $user;
		$this->load->view('wx/pl/piaoliu',$data);
	}
	
	public function test1(){
		$token = $_GET["token"];
		$access_token_array['access_token'] = $token;
		$signature = $this->getSignature($access_token_array);
		$this->load->view('wx/pl/success');
	}
	
	public function test2(){
		$signature = $this->getSignature("oWEeouOffT_ib9PovOkqsL3sJjJ8");
		$this->session->set_userdata("signature",$signature);
		$this->load->view('wx/pl/success');
	}
	/**
	 * @param unknown $access_token_array        	
	 * @return 返回数组 { 
	 * 		   "openid":" OPENID",用户的唯一标识
	 *         "nickname": NICKNAME,用户昵称
	 *         "sex":"1", 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
	 *         "province":"PROVINCE" 用户个人资料填写的省份
	 *         "city":"CITY",        普通用户个人资料填写的城市
	 *         "country":"COUNTRY",  国家，如中国为CN
	 *         "headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
	 *         "privilege":[ 用户特权信息，json 数组，如微信沃卡用户为（chinaunicom）
	 *         "PRIVILEGE1"
	 *         "PRIVILEGE2"
	 *         ],
	 *         "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"   只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。详见：获取用户个人信息（UnionID机制）
	 *}
	 */
	public function get_user($access_token_array) {
		// 获取用户信息
		$user_url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token_array['access_token'] . "&openid=" . $access_token_array['openid'] . "&lang=zh_CN";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $user_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		$user_array = json_decode ( $output, 1 );
		// // 释放curl句柄
		// // 打印获得的数据
		// https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
		return $user_array;
	}
	
	/**
	 *
	 * @param unknown $code        	
	 * @return 数组：{ "access_token":"ACCESS_TOKEN",
	 *         "expires_in":7200,
	 *         "refresh_token":"REFRESH_TOKEN",
	 *         "openid":"OPENID",
	 *         "scope":"SCOPE"
	 *         }
	 */
	private function get_sns_access_token($code) {
		$appid = APPID;
		$secret = SECRET;
		// 获取 access_token
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
		//$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code"."&refresh_token=REFRESH_TOKEN"; //刷新sns token
		// https: // api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
		// // 初始化
		$ch = curl_init ();
		// // 设置选项，包括URL
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		// 　　 curl_setopt ( $ch, CURLOPT_HEADER, false );
		// // 执行并获取HTML文档内容
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		$access_token_array = json_decode ( $output, 1 );
		return $access_token_array;
	}
	
	/**
	 *
	 * @param unknown $code
	 * @return 数组：{ "access_token":"ACCESS_TOKEN",
	 *         "expires_in":7200,
	 *         "refresh_token":"REFRESH_TOKEN",
	 *         "openid":"OPENID",
	 *         "scope":"SCOPE"
	 *         }
	 */
	private function get_access_token() {
		$appid = APPID;
		$secret = SECRET;
		// 获取 access_token
		// https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
		$url = "https://api.weixin.qq.com/cgi-bin/token?appid=" . $appid . "&secret=" . $secret. "&grant_type=client_credential";
		// https: // api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN  client_credential&appid=APPID&secret=APPSECRET
		// // 初始化
		$ch = curl_init ();
		// // 设置选项，包括URL
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		// 　　 curl_setopt ( $ch, CURLOPT_HEADER, false );
		// // 执行并获取HTML文档内容
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		$access_token_array = json_decode ( $output, 1 );
		return $access_token_array;
	}
}