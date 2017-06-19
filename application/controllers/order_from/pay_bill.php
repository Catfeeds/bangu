<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pay_bill extends UC_NL_Controller{
	public function __construct() {
		parent::__construct();
		header("content-type:text/html;charset=utf-8");
	}
	
	public function index(){
		$this->load->model('line_model');
		$whereArr=array();
		$data=$this->line_model->row($whereArr);
		$this->load_view('order/pay_bill_view',$data);
	}
}