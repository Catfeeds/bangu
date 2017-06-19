<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//"旅行社设置"控制器

class Bill extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_union_bank_model','b_union_bank_model');
		$this->load->model('admin/t33/common_model','common_model');
		
	}
	
	/**
	 * 管家结算
	 * */
	public function expert_bill()
	{
		echo "佣金结算";
	}
	/**
	 * 供应商结算
	 * */
	public function supplier_bill()
	{
		echo "供应商结算";
		//$this->load->view("admin/t33/union/agent");
	}
	
	
	
	
	
}

/* End of file login.php */
