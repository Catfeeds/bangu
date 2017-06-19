<?php
/**
 * **
 * 深圳海外国际旅行社
 * 艾瑞可
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Sxiu extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form', 
				'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		//$this->load->model ( 'admin/b1/account_model' );
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {
		$this->load->model ( 'admin/b1/user_shop_model' );
		$supplier = $this->getLoginSupplier();
		$data['ip']=$this->user_shop_model->get_user_shop_select('cfg_web','');
		//供应商信息
		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$supplier['id']));
		//var_dump($data['ip']);exit;
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/sxiu',$data);
		$this->load->view ( 'admin/b1/footer.html' ); 
	}
}