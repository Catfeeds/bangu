<?php
/**
 * 旅行社
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		温文斌
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Union extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/pre_order_model', 'pre_order');
	}

	function travel_print()
	{
		$line_id=$this->input->get("id",true);
		$dayid=$this->input->get("dayid",true);
		
		$this->load->model ( 'admin/t33/sys/u_line_suit_price_model', 'u_line_suit_price_model' );
		$data['suit']=$this->u_line_suit_price_model->row(array('dayid'=>$dayid));
		
		$this->load->model('admin/t33/u_line_model','u_line_model');
		$return = $this ->u_line_model ->line_trip($line_id);
		
		$data['list'] = $return['result'];
		$union_id=$this->session->userdata('union_id');
		$expert_id=$this->session->userdata('expert_id');
	
		$this->load->model('admin/t33/sys/b_union_log_model','b_union_log_model');
		$data['logo']=$this->b_union_log_model->row(array('union_id'=>$union_id));
		$data['expert_id']=$expert_id;
		$data['dayid']=$dayid;
		$data['line']['data']=$this->u_line_model->row(array('id'=>$line_id));
		//var_dump($data);
		$this->load->view("admin/b2/trip",$data);
	}
	
}