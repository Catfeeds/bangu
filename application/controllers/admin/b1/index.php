<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-26 下午3:13:56
*2015
*UTF-8
****/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->helper(array('form', 'url'));
		$this->load->database();
	}
	public function index()
	{
		$this->load->library('session');
		$login_data = $this ->session ->userdata('b1_login_data');
		if (empty($login_data)) {
			$login_data = array(
					'username' =>'',
					'password' =>''
			);
		}
		//var_dump($login_data);exit;
		$this->load->view("admin/b1/login" ,$login_data);
	}
}