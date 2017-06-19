<?php
/**
 * 专家找回密码
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年8月10日18:00:01
 * @author		jiakairong
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retrieve_pass extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this ->load_model('supplier_model' ,'supplier_model');
	}
	//找回密码页面
	public function retrievePassword()
	{
		$this->load->view ( 'admin/b1/retrievePassword');
	}
	//找回密码验证
	public function do_retrieve_pass()
	{
		$this->load->library ( 'callback' );
		$mobile = trim($this ->input ->post('mobile' ,true));
		$code = trim($this ->input ->post('code' ,true));
		$password = trim($this ->input ->post('password' ,true));
		$repass = trim($this ->input ->post('repass' ,true));
		//验证验证码
		$mobile_code = $this ->session ->userdata('mobile_code');
		$time = time();
		if (empty($mobile_code))
		{
			$this ->callback ->setJsonCode(4000 ,'请您获取手机验证码');
		}
		else
		{
			$endtime = $time - $mobile_code['time'];
			if ($endtime > 600)
			{
				$this ->callback ->setJsonCode(4000 ,'您的验证码已过期');
			}
			else
			{
				if ($mobile_code['mobile'] != $mobile || $mobile_code['code'] != $code)
				{
					$this ->callback ->setJsonCode(4000 ,'您输入的手机号和验证码不匹配');
				}
			}
		}
		
		$supplierData = $this->supplier_model ->getPassSupp($mobile);
		
		if (empty($supplierData))
		{
			$this ->callback ->setJsonCode(4000 ,'您的手机号未注册，或已拒绝');
		}
		
		if (empty($password))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写密码');
		}
		$pass_len = strlen($password);
		if ($pass_len < 6 || $pass_len > 16)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写6到16位的密码');
		}
		if ($password != $repass)
		{
			$this ->callback ->setJsonCode(4000 ,'两次密码输入不一致');
		}
		//新密码与原密码一致
		if (md5($password) == $supplierData ['password'])
		{
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		}
		//修改用户密码
		$whereArr = array(
				'id' =>$supplierData['id']
		);
		$dataArr = array(
				'password' =>md5($password)
		);
		$status = $this ->supplier_model ->update($dataArr ,$whereArr);
		if ( empty($status) )
		{
			$this ->callback ->setJsonCode(4000 ,'修改失败');
		} 
		else
		{
			//清除session中的手机与验证码
			$this ->session ->unset_userdata('mobile_code');
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		}
	}
}