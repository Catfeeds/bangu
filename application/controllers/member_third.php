<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ===================================================================
 * @类别：第三方登录
 * @作者：何俊
 */
class Member_third extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model('common/u_member_third_model','member_third_model');
	}
	
	public function index(){
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
		
		$whereArr=array("connectid"=>$sns_user['uid'],'from'=>$sns_user['via']);
		$res_query=$this->member_third_model->row($whereArr);
		if(!empty($res_query)){//已授权过
			//echo '已授权过';
			$this->load->model ( 'common/u_member_model','u_member_model' );
			$user_info = $this->u_member_model->row(array("mid"=>$res_query['mid']));
			if($user_info){
				$this->session->set_userdata ( array (
						'c_mobile' =>$user_info['mobile'],
						'c_username'=>$user_info ['truename'],
						'c_userid' =>$user_info ['mid'],
						'c_loginname' =>$user_info ['loginname']
				) );
			}
			echo "<script>location='/'</script>";die();
		}else{//没有授权过
			$data = array(
				'pic' =>$sns_user['image'],
				'screen_name' =>$sns_user['screen_name']
			);
			$this->load->view('member_third' ,$data);
		}
	}
	
	public function do_register(){
		$mobile = $this->input->post ( 'mobile', true );
		$code = $this->session->userdata ( 'code' );
		$this ->load_model('common/u_member_model' ,'member_model');
		try {
			$time = time();
			$mCode = $this ->session ->userdata('mobile_code');
			if (!empty($mobile)) {
				if ($time - $mCode['time'] > 600) {
					$this ->session ->unset_userdata('mobile_code');
					throw new Exception("您的验证码已过期");
				}
				if ($mCode['mobile'] != $mobile && $mCode['code'] != $code) {
					throw new Exception("您的手机号和验证码不匹配");
				}
			} else {
				throw new Exception("请填写手机号");
			}
			$this->db->trans_begin(); //事务开始
			
			$sql = "select loginname,truename,mobie,mid,logintime from u_member where mobile='$mobile' or loginname='$mobile'";
			$memberData = $this ->db ->query($sql) ->result_array();
			
			$isAuto = 0;
			$sns_user=$this->session->userdata('sns_user');

			if (empty($memberData)) {
				//手机号不存在则注册
				$password = 123456;
				$memberData = array(
					'loginname' => $mobile,
					'nickname'=>$sns_user['screen_name'],
					'truename' =>substr($mobile ,0,2).'****'.substr($mobile,7,10),
					'pwd' => md5 ( $password ),
					'mobile' => $mobile,
					'litpic' => $sns_user['image'],
					'jointime' => $time,
					'sex' => - 1
				);
				$status = $this ->member_model ->insert($memberData);
				if (empty($status)) {
					throw new Exception('完善失败，请刷新重试');
				}
				$isAuto = 1;
				
			}
			//写入授权
			$connectid=$this->session->userdata('connectid');
			$dataArr=array(
					'mid'=>$res_query ['mid'],
					'connectid'=>$sns_user['uid'],
					'from'=>$sns_user['via'],
					'access_token'=>$sns_user['access_token'],
					'addtime'=>date('Y-m-d H:i:s', $time)
			);
			$status = $this->db->insert('u_member_third_login', $dataArr);
			if (empty($status)) {
				throw new Exception('完善失败，请刷新重试');
			}
			$array_items = array('user' => '',);
			$this->session->unset_userdata($array_items);

			//登陆
			$this ->loginSuccess($memberData);
			echo json_encode(array('code' =>'2000' ,'msg'=>'成功'));
			//若是注册则发送短信
			if ($isAuto == 1) {
				//发送短信
				$this ->load_model('common/u_sms_template_model','template_model');
				$smsData = $this ->template_model ->row(array('msgtype' =>sys_constant::auto_reg));
				if (!empty($smsData['msg'])) {
					$msg = str_replace("{#LOGINNAME#}", $mobile ,$smsData['msg']);
					$msg = str_replace("{#PASSWORD#}", $password ,$msg);
					$this ->send_message($mobile ,$msg);
				}
			}
			if ($this->db->trans_status() === FALSE) { //判断此组事务运行结果
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
			
		} catch (Exception $e) {
			$this->db->trans_rollback(); //出现错误执行回滚
			$this->callback->set_code ( 4000 ,$e->getMessage());
			$this->callback->exit_json();
		}
	}
}