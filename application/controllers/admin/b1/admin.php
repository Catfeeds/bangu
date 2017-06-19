<?php

/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct(){
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
	}
	public function index()
	{
		$this->load->helper('url');
		$query = $this->db->get('u_expert');
		
		foreach ($query->result() as $row)
		{
			//$this->db->select('login_name,city,approve_status,order_count,amount,satisfaction_rate');
			$data['login_name']=$row->login_name;
			$data['city']=$row->city;
			$data['approve_status']=$row->approve_status;
			$data['amount']=$row->amount;
			//$data['order_max_wait']=$row->order_max_wait;
			$data['satisfaction_rate']=$row->satisfaction_rate;
			//echo $row->money;
		}
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/admin_list',$data);
		$this->load->view('admin/b1/footer.html');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */