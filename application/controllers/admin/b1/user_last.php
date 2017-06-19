<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-24 下午1:33:13
*2015
*UTF-8
****/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_last extends CI_Controller {
	function __construct(){
		parent::__construct();
		//$this->load->helper("url");
		$this->load->helper(array('form', 'url'));

		$this->load->database();
	}
	public function index()
	{
		$query=$this->db->get_where('u_supplier',array('id'=>25));
		foreach ($query->result() as $row){
			$data['login_name']=$row->login_name;
			$data['mobile']=$row->mobile;
			$data['idcard']=$row->idcard;
			$data['idcardpic']=$row->idcardpic;
			$data['city']=$row->city;
		}
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/user_last',$data);
		$this->load->view('admin/b1/footer.html');
		
	}
}