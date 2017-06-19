<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-24 下午4:09:36
*2015
*UTF-8
****/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply extends UB1_Controller {
	function __construct(){
		$this->need_login = true;
		parent::__construct();
		header("content-type:text/html;charset=utf-8");
		$this->load->helper("url");
		$this->load->helper(array('form', 'url'));

		$this->load->database();
	}
	public function index()
	{
		//$this->load->view('admin/b1/header.html');
		$this->load->view("admin/b1/apply_list");
		//$this->load->view('admin/b1/footer.html');
	}
	function insert(){
		//注册
		$login_name=$this->input->post('username');
		$mobile=$this->input->post('mobile');
		$sn=$this->input->post('sn');//验证码
		$email=$this->input->post('email');
		$password=$this->input->post('pwd');
		$pwd1=$this->input->post('pwd1');
		$id=$this->input->post('id');//
		$company=$this->input->post('company');
		$management_code=$this->input->post('trip_id');
		$province=$this->input->post('province');
		$city=$this->input->post('city');
		$qq=$this->input->post('qq');
		$brand=$this->input->post('brand');
		$address=$this->input->post('address');
		$supplier_type=$this->input->post('line');
		$trip_type=$this->input->post('type');
		$business_type=$this->input->post('buession_typr[]');
		$telephone=$this->input->post('telephone');
		$fax=$this->input->post('fax');
		$main_business=$this->input->post('type_body');
		$management_model=$this->input->post('management');
		$cooperation=$this->input->post('cooperation');
		$cooperation_page=$this->input->post('cooperation_page');
		$description=$this->input->post('description');
		
		if($password==$pwd1){
			$data=array(
				'login_name'=>$login_name,
				'mobile'=>$mobile,
				'email'=>$email,
			 	'password'=>MD5($password),
				'company_name'=>$company,
				'management_code'=>$management_code,
				'province'=>$province,
				'city'=>$city,
				'qq'=>$qq,
				'brand'=>$brand,
				'address'=>$address,
				'supplier_type'=>$supplier_type,
				'trip_type'=>$trip_type,
				'business_type'=>$business_type,
				'telephone'=>$telephone,
				'fax'=>$fax,
				'main_business'=>$main_business,
				'management_model'=>$management_model,
				'cooperation'=>$cooperation,
				'cooperation_page'=>$cooperation_page,
				'description'=>$description,
			);
			$name=$this->db->get('u_supplier');
			foreach ($name->result() as $row){
				$loginname=$row->login_name;
			}
			if($login_name==$loginname){

			}else{
				$this->db->insert('u_supplier',$data);
				$this->load->view('admin/b1/user_line_last');
			}
		}else{
			echo "2次密码输入不一致";
		}
	}
}