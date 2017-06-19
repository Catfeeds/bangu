<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Chat_test extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();  
	}  
	
	public function index() {
		$this ->load_view('chat_test');
	}
}