<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Orderstep extends UB1_Controller {

	public function __construct() {
		//$this->need_login = true;
		parent::__construct ();
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/order_status_model','order_model' );
	}
	public function order_yf() {

		$bill_id=$this->input->post('yf_id',true);
		if(is_numeric($bill_id)){
			$bill=$this->order_model->show_order_yf($bill_id);
			//echo $this->db->last_query();
			echo  json_encode(array('status'=>1,'msg'=>'获取数据成功','data'=>$bill));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));	
		}	
	}
}