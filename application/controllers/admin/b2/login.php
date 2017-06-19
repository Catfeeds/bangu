<?php
/**
 * 专家登录/退出
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月23日16:22:15
 * @author		徐鹏
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

	/**
	 * 登录错误提示
	 * @var string
	 */
	private $login_error = '';

	/**
	 * 登录页面
	 */
	public function index() 
	{
		if ($this->is_post_mode()) {
			if ($this->do_login()) return;
		}
		$this->load_view('admin/b2/login', array('login_error' => $this->login_error));
	}
	/**
	 * 执行登录
	 *
	 * @return boolean
	 */
	public function do_login()
	{
		$login_name = trim($this->input->post('username' ,true)); //登录账号
		$password = trim($this->input->post('password' ,true)); //密码
		$verifycode = strtolower($this->input->post('verifycode'));  //验证码
                
        $this ->load_model('common/u_expert_model' ,'expert_model');
		$this ->load->library ( 'callback' );
        if (empty($login_name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写用户名');
		}
		if (empty($password))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写密码');
		}
		if ($verifycode !== strtolower($this->session->userdata('captcha')))
		{
			$this ->callback ->setJsonCode(4000 ,'验证码错误');
		}
		
		//通过账号获取管家通过的数据
        // c端已通过审核的管家(status=2) 、b端已通过的管家才可以登录(union_status=1) 才能登录。
		$expertArr = $this ->expert_model ->getExpertLogin($login_name);
		
		if (empty($expertArr))
		{
			//当前账号没有通过，则获取最后一条记录
			$expertArr = $this ->expert_model ->getExpertLoginNo($login_name);
			if (empty($expertArr))
			{
				$this ->callback ->setJsonCode(4000 ,'账号不存在');
			}
			else
			{
				switch($expertArr[0]['status'])
				{
					case 1:
					case 3:
						$this->session->set_userdata('upExpertId' ,$expertArr[0]['id']);
						$this ->callback ->setJsonCode(7000 ,$expertArr[0]['id']);  //审核拒绝、审核中
						break;
					case -1://已终止合作
						$this ->callback ->setJsonCode(4000 ,'平台终止与您的合作，您可联系客服');
						break;
					default:
						$this ->callback ->setJsonCode(4000 ,'您的账号的状态异常，请联系客服');
						break;
				}
			}
		}
		if (md5($password) != $expertArr [0]['password'])
		{
			$this ->callback ->setJsonCode(4000 ,'密码不正确');
		}
                                        
        //session存储
		$expert = array(
			'expert_id' 		=> $expertArr [0]['id'],
			'login_name' 		=>$expertArr [0]['login_name'],
			'real_name'		=>$expertArr [0]['realname'],
			'email' 		=>$expertArr [0]['email'],
			'user_pic'		=>$expertArr [0]['small_photo'],
			'logindatetime'		=>$expertArr [0]['logindatetime'],
			'e_mobile' 		=> $expertArr [0]['mobile'],
			'nickname' 		=> $expertArr [0]['nickname'],
			'location_city' 	=> $expertArr [0]['city'],
			//'is_dm'		=>  $expertArr [0]['is_dm'],
			'depart_name'		=>  $expertArr [0]['expert_type'],
			'parent_depart_id'	=> current(explode(',',rtrim($expertArr [0]['depart_list'],','))),
			'depart_id'		=>	end(explode(',',rtrim($expertArr [0]['depart_list'],','))),
			'union_id'		=> $expertArr[0]['union_id'],
			'e_status'		=> $expertArr[0]['status'],
			'is_commit'		=> $expertArr[0]['is_commit'],
			'union_status' =>$expertArr[0]['union_status']
		);
		
		if($expertArr [0]['expert_type']==1 && $expertArr [0]['is_dm']==1){
			$expert['is_manage'] = 1;  //是经理
		}else{
			$expert['is_manage'] = 0;  //普通管家
		}
		//var_dump($expert);
		$this ->session ->set_userdata($expert);
		
        //登录信息处理
		$dataArr=array(
			'logindatetime'=>date("Y-m-d H:i:s" ,time()),
			'loginip' =>$this->getip()
		);
		$whereArr=array('id'=>$expertArr [0]['id']);
		$this->expert_model->update($dataArr,$whereArr);
		
        $web_config = $this->get_web_config();
		$ch = curl_init();
		$post_data = array(
		       "expert_id" => $this ->session ->userdata('expert_id'),
		       "newStatus" => 2
		);
		/*curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_URL,$web_config['expert_question_url'].'/chat!updateExpertStatus.do');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);*/
		//echo $is_manage=$this->session->userdata('is_manage');
		$this ->callback ->setJsonCode(2000 ,'登录成功');
	}
	
	public function do_login2()
	{
		$login_name = trim($this->input->post('username' ,true)); //登录账号
		$password = trim($this->input->post('password' ,true)); //密码
		$verifycode = strtolower($this->input->post('verifycode'));  //验证码
                
        $this ->load_model('common/u_expert_model' ,'expert_model');
		$this ->load->library ( 'callback' );
        if (empty($login_name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写用户名');
		}
		if (empty($password))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写密码');
		}
		if ($verifycode !== strtolower($this->session->userdata('captcha')))
		{
			//$this ->callback ->setJsonCode(4000 ,'验证码错误');
		}
		
		//通过账号获取管家通过的数据
        // c端已通过审核的管家(status=2) 、b端已通过的管家才可以登录(union_status=1) 才能登录。
		$expertArr = $this ->expert_model ->getExpertLogin($login_name);
		
		if (empty($expertArr))
		{
			//当前账号没有通过，则获取最后一条记录
			$expertArr = $this ->expert_model ->getExpertLoginNo($login_name);
			if (empty($expertArr))
			{
				$this ->callback ->setJsonCode(4000 ,'账号不存在');
			}
			else
			{
				switch($expertArr[0]['status'])
				{
					case 1:
					case 3:
						$this->session->set_userdata('upExpertId' ,$expertArr[0]['id']);
						$this ->callback ->setJsonCode(7000 ,$expertArr[0]['id']);  //审核拒绝、审核中
						break;
					case -1://已终止合作
						$this ->callback ->setJsonCode(4000 ,'平台终止与您的合作，您可联系客服');
						break;
					default:
						$this ->callback ->setJsonCode(4000 ,'您的账号的状态异常，请联系客服');
						break;
				}
			}
		}
		if (md5($password) != $expertArr [0]['password'])
		{
			$this ->callback ->setJsonCode(4000 ,'密码不正确');
		}
                                        
        //session存储
		$expert = array(
			'expert_id' 		=> $expertArr [0]['id'],
			'login_name' 		=>$expertArr [0]['login_name'],
			'real_name'		=>$expertArr [0]['realname'],
			'email' 		=>$expertArr [0]['email'],
			'user_pic'		=>$expertArr [0]['small_photo'],
			'logindatetime'		=>$expertArr [0]['logindatetime'],
			'e_mobile' 		=> $expertArr [0]['mobile'],
			'nickname' 		=> $expertArr [0]['nickname'],
			'location_city' 	=> $expertArr [0]['city'],
			//'is_dm'		=>  $expertArr [0]['is_dm'],
			'depart_name'		=>  $expertArr [0]['expert_type'],
			'parent_depart_id'	=> current(explode(',',rtrim($expertArr [0]['depart_list'],','))),
			'depart_id'		=>	end(explode(',',rtrim($expertArr [0]['depart_list'],','))),
			'union_id'		=> $expertArr[0]['union_id'],
			'e_status'		=> $expertArr[0]['status'],
			'is_commit'		=> $expertArr[0]['is_commit'],
			'union_status' =>$expertArr[0]['union_status']
		);
		
		if($expertArr [0]['expert_type']==1 && $expertArr [0]['is_dm']==1){
			$expert['is_manage'] = 1;  //是经理
		}else{
			$expert['is_manage'] = 0;  //普通管家
		}
		//var_dump($expert);
		$this ->session ->set_userdata($expert);
		
        //登录信息处理
		$dataArr=array(
			'logindatetime'=>date("Y-m-d H:i:s" ,time()),
			'loginip' =>$this->getip()
		);
		$whereArr=array('id'=>$expertArr [0]['id']);
		$this->expert_model->update($dataArr,$whereArr);
		
        $web_config = $this->get_web_config();
		$ch = curl_init();
		$post_data = array(
		       "expert_id" => $this ->session ->userdata('expert_id'),
		       "newStatus" => 2
		);
		/*curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_URL,$web_config['expert_question_url'].'/chat!updateExpertStatus.do');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);*/
		//echo $is_manage=$this->session->userdata('is_manage');
		$this ->callback ->setJsonCode(2000 ,'登录成功a');
	}

	/**
	 * 退出
	 */
	public function logout() {
		$this->load->library('session');
		$this->update_online(0);
		# 销毁session
		$array_items = array('expert_id' => '', 'login_name' => '','real_name'=>'','email' =>'','user_pic'=>'');
		$this->session->unset_userdata($array_items);
		redirect('admin/b2/login/index');
	}

	/**
	 * 修改管家在线状态
	 * 汪晓烽
	 * @return [type] [description]
	 */
	function update_online($online_status=0){
		$online_status = $this->input->post('online_status');
		$online_status = !empty($online_status) ? $online_status : 0;
		$update_sql = "update u_expert set online=$online_status where id=".$this->session->userdata('expert_id');
		$this->db->query($update_sql);
	}

	/**
	 * 汪晓烽
	 * 获取网站配置
	 * @return [type] [description]
	 */
	public function get_web_config(){
		$sql = "select * from cfg_web";
		$web_config = $this->db->query($sql)->result_array();
		return $web_config[0];
	}
	/**
	 * 模拟登录
	 */
	public function moni(){

		if ($this->is_post_mode()) {
			if ($this->do_login()) return;
		}
		$this->load_view('admin/b2/login_moni', array('login_error' => $this->login_error));
	}

	/**
	 * 执行模拟登录
	 *
	 * @return boolean
	 */
	public function do_login_moni()
	{
		$this ->load_model('common/u_expert_model' ,'expert_model');
		$this ->load->library ( 'callback' );
		$login_name = trim($this->input->post('username' ,true));
		$password = trim($this->input->post('password' ,true));

		//$md5_pwd=md5(md5('bangu')); //6d5cb5b1963ccdd2042346f9aeeb44f4
		//$this ->callback ->setJsonCode(4000 ,$md5_pwd);
		if (empty($login_name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写用户名');
		}
		if (empty($password))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写口令');
		}
		if (md5(md5($password))!="6d5cb5b1963ccdd2042346f9aeeb44f4")
		{
			$this ->callback ->setJsonCode(4000 ,'口令错误');
		}

		$sess_employee_id=$this->session->userdata('employee_id');
		if(!$sess_employee_id)
			$this ->callback ->setJsonCode(4000 ,'请先登录xx系统才能使用，你猜是什么？');
		//通过账号获取管家通过的数据
		$expertArr = $this ->expert_model ->getExpertLogin($login_name);
		if (empty($expertArr))
		{
			//当前账号没有通过，则获取最后一条记录
			$expertArr = $this ->expert_model ->getExpertLoginNo($login_name);
			if (empty($expertArr))
			{
				$this ->callback ->setJsonCode(4000 ,'账号不存在');
			}
			else
			{
				switch($expertArr[0]['status'])
				{
					case 1:
					case 3:
						$this->session->set_userdata('upExpertId' ,$expertArr[0]['id']);
						$this ->callback ->setJsonCode(7000 ,$expertArr[0]['id']);
						break;
					case -1://已终止合作
						$this ->callback ->setJsonCode(4000 ,'平台终止与您的合作，您可联系客服');
						break;
					default:
						$this ->callback ->setJsonCode(4000 ,'您的账号的状态异常，请联系客服');
						break;
				}
			}
		}

		$expert = array(
				'expert_id' 			=> $expertArr [0]['id'],
				'login_name' 		=>$expertArr [0]['login_name'],
				'real_name'		=>$expertArr [0]['realname'],
				'email' 				=>$expertArr [0]['email'],
				'user_pic'			=>$expertArr [0]['small_photo'],
				'logindatetime'		=>$expertArr [0]['logindatetime'],
				'e_mobile' 			=> $expertArr [0]['mobile'],
				'nickname' 		=> $expertArr [0]['nickname'],
				'location_city' 		=> $expertArr [0]['city'],
				//'is_dm'			=>  $expertArr [0]['is_dm'],
				'depart_name'		=>  $expertArr [0]['expert_type'],
				'parent_depart_id'	=> current(explode(',',rtrim($expertArr [0]['depart_list'],','))),
				'depart_id'			=>	end(explode(',',rtrim($expertArr [0]['depart_list'],','))),
				'union_id'			=> $expertArr [0]['union_id']
		);
		if($expertArr [0]['expert_type']==1 && $expertArr [0]['is_dm']==1){
			$expert['is_manage'] = 1;
		}else{
			$expert['is_manage'] = 0;
		}
		$this ->session ->set_userdata($expert);
		$this->load->model('common/u_expert_model','expert_model');
		$dataArr=array(
				'logindatetime'=>date("Y-m-d H:i:s" ,time()),
				'loginip' =>$this->getip()
		);
		$whereArr=array('id'=>$expertArr [0]['id']);

		$this->expert_model->update($dataArr,$whereArr);
		$web_config = $this->get_web_config();
		$ch = curl_init();
		$post_data = array(
				"expert_id" => $this ->session ->userdata('expert_id'),
				"newStatus" => 2
		);
		/*curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_URL,$web_config['expert_question_url'].'/chat!updateExpertStatus.do');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);*/
		$this ->callback ->setJsonCode(2000 ,'登陆成功');
	}
}