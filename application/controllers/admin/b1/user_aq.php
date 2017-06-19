<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-24 下午1:54:07
*2015
*UTF-8
****/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_aq extends UB1_Controller {
	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->helper(array('form', 'url'));
		$this -> load -> library('form_validation');
		$this->load->library('session');
		$this->load->database();
		header("content-type:text/html;charset=utf-8");
	}
	public function index()
	{
		//启用session
		$sesson=$this->getLoginSupplier();
		$login_name=$sesson['login_name'];
		$this->db->from('u_supplier');
		$data['user']=$this->db->where('login_name',$login_name)->get()->result_array();
		
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/user_aq_list',$data);
		$this->load->view('admin/b1/footer.html');
	}
	public function insert(){
		
		//判断用户是否存在
		$this->db->from('u_supplier');
		//启用session
		$sesson=$this->getLoginSupplier();
		$login_name=$sesson['login_name'];
			
		$data['user']=$this->db->where('login_name',$login_name)->get()->result_array();
		
		//表单的验证
		$this -> form_validation -> set_rules('pwd' , '原始密码' , 'required');
		$this -> form_validation -> set_rules('pwd1' , '新密码' , 'required');
		$this -> form_validation -> set_rules('pwd2' , '重复密码' ,  'required|matches[pwd1]');
		//表单验证不通过
		if($this -> form_validation ->run() === false) {
			$this->load->view('admin/b1/header.html');
			$this->load->view('admin/b1/user_aq_list',$data);
			$this->load->view('admin/b1/footer.html');		
		}else{ //修改密码
			$email=$this->input->post('email');
			$pwd=$this->input->post('pwd');
			$pwd1=$this->input->post('pwd1');
			$pwd2=$this->input->post('pwd2');
			$query=$this->db->get('u_supplier');
		
			$pwd_old=$data['user'][0]['password'];
		
	 		if(!empty($data['user'])){ 
	 			if(MD5($pwd)==$pwd_old){	//判断原始密码是否正确	
					if($pwd1==$pwd2){//修改
						$wh=array(
							//'email'=>$email,
							'password'=>MD5($pwd1),
						);
			            //修改密码
						$this->db->where('login_name',$login_name);
						$re=$this->db->update('u_supplier',$wh);
						$data ['status']=1;
						$data ['result_msg'] = '密码修改成功！';
						$this->load->view('admin/b1/header.html');
						$this->load->view('admin/b1/user_aq_list',$data);
						$this->load->view('admin/b1/footer.html');
					}else{	
						$data ['status']=2;
						$data ['result_msg'] = '两次输入新的密码不一致！';
		 				$this->load->view('admin/b1/header.html');
		 				$this->load->view('admin/b1/user_aq_list',$data);
		 				$this->load->view('admin/b1/footer.html');	
					} 
	 			}else{
	 				$data ['status']=2;
	 				$data ['result_msg'] = '原始密码不正确！';
	 				$this->load->view('admin/b1/header.html');
	 				$this->load->view('admin/b1/user_aq_list',$data);
	 				$this->load->view('admin/b1/footer.html');
	 			} 
	 		}else{
	 			$data ['status']=2;
	 			$this->load->model ( 'admin/a/admin_model', 'admin_model' );
	 			$data ['result_msg'] = '登录用户名不存在！';
	 			$this->load->view('admin/b1/header.html');
				$this->load->view('admin/b1/user_aq_list',$data);
				$this->load->view('admin/b1/footer.html');
	 		}
		}
	}
}