<?php
/**
 * 首页
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		2.0 更新
 * @since		2015-11-2 10:47:26
 * @author		陈新亮
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends UB2_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/home_model', 'home');
		$this ->load_model('common/u_expert_model' ,'expert_model');

	}

	public function index() {
		$statis_msg = $this->get_unread_msg();
		$web_config = $this->get_web_config();
		$expert_info = $this ->expert_model ->row(array('id'=>$this->expert_id));
		$data = array(
				'email' => $this->session->userdata('email'),
				'login_name' => $this->session->userdata('login_name'),
				'user_pic'     => $this->session->userdata('user_pic'),
				'statis_msg' => $statis_msg,
				'web_config' => $web_config,
				'expert_info' =>$expert_info
					  );

		$this->view('admin/expert/index', $data);
	}
}