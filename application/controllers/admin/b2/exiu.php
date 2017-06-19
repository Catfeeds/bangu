<?php
/**
 * 专家个人中心
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:01
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exiu extends UB2_Controller {

	public function __construct() {
		parent::__construct();




	}

	/**
	 * 我的资料
	 */
	public function index() {	
		$this->load_model('admin/b2/expert_model', 'expert');
		$data['ip']=$this->expert->get_alldate('cfg_web','');
	
		$data['expert']=$this->expert->all(array('id'=>$this->expert_id));
		//var_dump($data['expert']);
		$this->load_view('admin/b2/exiu',$data);
	}
}
