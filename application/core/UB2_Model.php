<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月19日17:41:18
 * @author		徐鹏
 *
 */ 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class UB2_Model extends MY_Model {
	
	protected $expert_id;
	
	function __construct($table = '',$database = 'default')
	{
		parent::__construct($table = '',$database = 'default');

		$this->load->library('session');
		$this->expert_id = $this->session->userdata('expert_id');
	}
}