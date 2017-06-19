<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Order_Refund extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/b_order_model','b_order');
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];
		$param['status'] = 1;

		$data['pageData'] = $this->b_order->get_order_refund($param,$this->getPage ());
		//echo $this->db->last_query();exit;
		$this->load->view ( 'admin//b1/header.html' );
		$this->load->view ( "admin/b1/b_order/order_refund_view",$data);
		$this->load->view ( 'admin/b1/footer.html' );

	}

	function indexData(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];
		$param['status'] = $this->input->post('status',true);
				
    		$data = $this->b_order->get_order_refund($param,$this->getPage ());
    		//echo $this->db->last_query();
		echo  $data ;
	}
}