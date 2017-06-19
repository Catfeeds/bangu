<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月3日11:03:55
 * @author		何俊
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UC_Controller extends UC_NL_Controller {

	private $username;
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->username=$this->session->userdata('c_userid');
		if (!isset($this->username) ||empty($this->username)){
			redirect ( 'login' );
		}
	}
	
	
	public function load_view($page_view, $param = NULL) {
		$userid=$this->session->userdata('c_userid');
		$username=$this->session->userdata('c_username'); 
		$data= array (
				'username' => $username,
				'userid' => $userid
		);
		
		$this->load->view('common/header',$data);
		$this->load->view($page_view, $param);
		$this->load->view('common/footer');
	}
	
	public function load_self_view($page_view, $param = NULL) {
		$this->load->view($page_view, $param);
	}

}