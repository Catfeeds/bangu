<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Login extends MY_Controller {	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/admin_model', 'admin_model' );
		$this->load->helper('form');
		$this->load->library ( 'form_validation' );
	}

	public function index() {	
		$this->load->view ( 'admin/a/ui/login' );
	}
	public function doLogin()
	{
		$this->load->library ( 'callback' );
		$username = $this->input->post ( 'username' );
		$password = $this->input->post ( 'password' );
		$code = strtolower($this->input->post ( 'ucap' ));
		if ($code != strtolower($this ->session->userdata('captcha')))
		{
			$this->callback->set_code ( 4000 ,'验证码错误');
			$this->callback->exit_json();
		}
		if (empty($username))
		{
			$this->callback->set_code ( 4000 ,'请填写登录名');
			$this->callback->exit_json();
		}
		if (empty($password))
		{
			$this->callback->set_code ( 4000 ,'请填写密码');
			$this->callback->exit_json();
		}
		$adminData = $this ->admin_model ->row(array('username' =>$username));
		if (empty($adminData))
		{
			$this->callback->set_code ( 4000 ,'账号不存在');
			$this->callback->exit_json();
		} 
		if ($adminData['isopen'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'账号已被禁用');	
		}
		if (md5($password) != $adminData['password'])
		{
			$this->callback->set_code ( 4000 ,'密码错误');
			$this->callback->exit_json();
		}
		$this ->session ->set_userdata(array(
				'a_username' => $username,
				'a_user_id' => $adminData ['id'],
				'a_photo' => $adminData ['photo'],
				'a_realname' =>$adminData ['realname']
		));
		
		$this->callback->set_code ( 2000 ,'登录成功');
		$this->callback->exit_json();
	}
	
	
	public function do_login() {
		$this->load->library ( 'session' );
		$username = $this->input->post ( 'username' );
		$password = $this->input->post ( 'password' );
		$ucap = strtolower($this->input->post ( 'ucap' ));
		$query_data = array ();
		//var_dump($_SESSION);//exit;
		if ( $ucap == strtolower($this->session->userdata ( 'captcha' ) )) {
			if (empty ( $username )) {
				$this->result_code = "4001";
				$this->result_msg = "用户名不能为空";
			} else {
				$query_data = array (
						"username" => $username 
				);
			}
			$res_query = $this->admin_model->row ( $query_data ); // 获取用户id
			if (! empty ( $res_query )) {
				
					
				$this->load->model ( 'admin/a/resource_model', 'resource_model' );
				$whereArr=array(
						'ar.adminId'=>$res_query ['id']
				);
				$resource=$this->resource_model->get_resource($whereArr);
				
				$password_local = $res_query ['password'];
				if (md5 ( $password ) == $password_local) {
					$this->result_code = "2000";
					$this->result_msg = "登录成功";
					$this->session->set_userdata ( array (
							'a_username' => $username,
							'a_user_id' => $res_query ['id'],
							'a_photo' => $res_query ['photo']
					) );
					$photo = $this ->session ->userdata('a_photo');
					$cache_key = 'resource';  //cache key 。任意字符即可
					$expireTime = 3;   //过期时间。 0 为永不过期
					if ( false == ($resource ==  cache_get($cache_key, $expireTime) ) ) {
						cache_set($cache_key, $resource);
					}
					redirect ( 'admin/a/home' );
				} else {
					$this->result_code = "4001";
					$this->result_msg = "密码错误，请重新输入";
				}
			} else {
				$this->result_code = "4001";
				$this->result_msg = "用户名不存在";
			}
		}else{
			$this->result_code = "4001";
			$this->result_msg = "验证码错误";
		}
		$data ['result_msg'] = $this->result_msg;
		$this->load->view ( 'admin/a/ui/login', $data );
	}
	
	/**
	 * 退出
	 */
	public function logout() {
		$this->load->helper ( 'common' ); //加载缓存方法
		$array_items = array('a_username' => '', 'a_user_id' => '');		
		$this->session->unset_userdata($array_items);
		cache_del($username.'_'.$admin_id ,$nav_data);
		redirect ( 'admin/a/login/index' );
	}
}