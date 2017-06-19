<?php
/**
 * @copyright 深圳海外国际旅行社有限公司   
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Information_list extends UC_NL_Controller {
	
/* 	private $whereArr = array('e.status' =>2); //保存管家的搜索条件
	private $dataArr = array();//保存视图层的数据
	private $postArr = array();//搜索条件 */
	
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'information_model', 'information_model' );
	}
	//资讯列表页
	public function index(){
		$this->load->view ( 'information/information_list' );
	}
	
}

