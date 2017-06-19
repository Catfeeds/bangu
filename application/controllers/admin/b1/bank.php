<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Bank extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/bank_model' );
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {
		//启用session
		$sesson=$this->getLoginSupplier();
		//var_dump($sesson);exit();
		$data['login_name']=$sesson['login_name'];
		$data['supplier_id']=$sesson['id'];
		// 结算
		$data['bank_info'] = $this->bank_model->get_bank_info($sesson['id']);

		//var_dump($data);exit();
		$this->load->view ( 'admin//b1/header.html' );
		$this->load->view ( "admin/b1/bank_view", $data );
		$this->load->view ( 'admin/b1/footer.html' );

	}

	function add_bank(){
		$sesson=$this->getLoginSupplier();
		$data['supplier_id']=$sesson['id'];
		$bankname = trim($this->input->post('bankname'));//银行名称
		$brand = trim($this->input->post('brand'));//支行
		$openman = trim($this->input->post('openman'));
		$bank_num = trim($this->input->post('bank_num'));
		$bank_info_id = $this->input->post('bank_info_id');
		if(empty($bankname)){
			echo json_encode(array('code'=>201,'msg'=>'银行名称不能为空'));
			exit();
		}

		if(empty($brand)){
			echo json_encode(array('code'=>202,'msg'=>'银行支行不能为空'));
			exit();
		}

		if(empty($openman)){
			echo json_encode(array('code'=>203,'msg'=>'开户人不能为空'));
			exit();
		}


		if(!preg_match('/^\d{8,28}$/', trim($bank_num))){
				echo json_encode(array('code'=>204,'msg'=>'填写合法的银行卡号'));
				exit();
		}


		$bank_info = array("bank"=>$bank_num,"bankname"=>$bankname,"brand"=>$brand,"openman"=>$openman,"modtime"=>date('Y-m-d H:i:s'));
		if(!empty($bank_info_id) && $bank_info_id!=0){
			$res = $this->bank_model->update_bank_info($bank_info,$bank_info_id);
		}else{
			$bank_info["addtime"] = date('Y-m-d H:i:s');
			$bank_info["supplier_id"] = $data['supplier_id'];
			$res = $this->bank_model->update_bank_info($bank_info,$bank_info_id);
		}

		if($res){
			echo  json_encode(array('code'=>200,'msg'=>'保存成功'));
			exit();
		}else{
			echo  json_encode(array('code'=>206,'msg'=>'保存失败'));
			exit();
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */