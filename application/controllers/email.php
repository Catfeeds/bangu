<?php
/**
 * 
 * @copyright	深圳海外国际旅行社有限公司
 * @author		zyf
 * @since       2017-03-15

 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Email extends UC_NL_Controller {
	
	function __construct() {
		parent::__construct ();
		set_error_handler('customError');
		$this->load->model ( 'member_model' );
		$this->load->library ( 'callback' );
	}
	public function index() {
// 		$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :'/';
// 		if ($url == site_url('login')) {
// 			$url = '/';
// 		}
		$parameter=isset($_REQUEST['param'])?$_REQUEST['param']:'';
		if (!empty($parameter))
		{
	    	foreach (explode('&', urldecode($parameter)) as $k)
	    	{
	    		$param = explode("=", $k);
	    		$arr[$param['0']]=$param['1'];
	    	}
	    	$m_id=intval($arr['m_id']);
	    	$send_time=intval($arr['send_time']);
	    	$m_data=$this->db->query("select mid,checkmail from u_member where mid={$m_id}")->row_array();
	    	if (empty($m_data)) $this->callback->exitJsonCode(4000 ,'用户不存在');
	    	if ($m_data['checkmail'] == 0)
	    	{
		    	$u_data=$this->db->query("select * from u_email_verification where u_id={$m_id} and send_time={$send_time}")->row_array();
		    	if (!empty($u_data))
		    	{
		    		$time=time();
		    		if ($u_data['u_id']==$m_id && $u_data['u_identify']==$arr['code'] && $u_data['send_time']==$arr['send_time'])
		    		{
		    			if ($time-$arr['send_time']<=86400)
		    			{
		    				$result=$this->db->query("update u_member set checkmail=1 where mid={$m_id}");
		    				if (!empty($result))
		    				{
		    					$this->load->view('email_view');
		    				}
		    				else 
		    				{
		    					$this->callback->exitJsonCode(4006 ,'验证失败,请重新尝试');
		    				}
		    			}
		    			else 
		    			{
		    				$this->callback->exitJsonCode(4005 ,'已超时,请重新验证');
		    			}
		    		}
		    		else 
		    		{
		    			$this->callback->exitJsonCode(4004 ,'非法参数');
		    		}
		    	}
		    	else 
		    	{
		    		$this->callback->exitJsonCode(4003 ,'非法参数');
		    	}
	    	}
	    	else
	    	{
	    		$this->callback->exitJsonCode(4002 ,'您已验证过邮箱');
	    	}
		}
		else 
		{
			$this->callback->exitJsonCode(4001 ,'参数缺失');
		}
		
	}
	
}
