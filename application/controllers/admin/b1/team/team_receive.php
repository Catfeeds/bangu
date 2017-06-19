<?php
/**
 * **
 * 深圳海外国际旅行社
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class team_receive extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/user_shop_model' );
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {

		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );

		$param['starttime'] =date("Y-m-d",time()); 
		$param['endtime'] =date("Y-m-d",strtotime("+30 day")); 

		$data['pageData'] = $this->user_shop_model->get_team_list($param,$this->getPage (),$arr['id']);
		//echo $this->db->last_query();exit;
		$this->load->view ( 'admin//b1/header.html' );
		$this->load->view ( "admin/b1/team/team_receive",$data);
		$this->load->view ( 'admin/b1/footer.html' );
	}

	public function indexData() {
		$param = $this->getParam(array('linencode','linename','starttime','endtime','s_lineday','e_lineday','linensn'));
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		
		$data= $this->user_shop_model->get_team_list($param,$this->getPage (),$arr['id']);

		echo  $data ;
	}
	//订单列表
	function get_team_order(){
		$dayid=$this->input->post('dayid',true);
		$suitid=$this->input->post('suitid',true);
		if($dayid>0){
			$data=$this->user_shop_model->get_order_list($dayid,$suitid);
			//echo $this->db->last_query();
			 echo json_encode(array('status' => 1,'data' =>$data));
		}else{
			 echo json_encode(array('status' => -1,'msg' =>'数据获取失败'));
		}	
	}

}