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

class APP_Model extends MY_Model {
	
	protected $table="";
	
	function __construct($table = '',$database = '')
	{
		parent::__construct($this->table);
		$this->db = $this->load->database ( "live", TRUE );
		$this->load->library('session');
		
	}
}