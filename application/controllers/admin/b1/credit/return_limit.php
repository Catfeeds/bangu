<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Return_limit extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/limit_apply_model','limit_apply');
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {

		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		
		$param['supplier_id']=$arr['id'];
		$data['pageData'] = $this->limit_apply->get_expert_limit_apply($param,$this->getPage ());
		//echo $this->db->last_query();
		$this->load->view ( 'admin//b1/header.html' );
		$this->load->view ( "admin/b1/credit/return_limit_view",$data);
		$this->load->view ( 'admin/b1/footer.html' );

	}
	function indexData(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$sch_sn=$this->input->post('sch_sn',true);
		$sch_expertName=$this->input->post('sch_expertName',true);
		$starttime=$this->input->post('starttime',true);	
		$endtime=$this->input->post('endtime',true);
		$return_starttime=$this->input->post('return_starttime',true);	
		$return_endtime=$this->input->post('return_endtime',true);	
		$apply_status=$this->input->post('apply_status',true);
		$sch_ordersn=$this->input->post('sch_ordersn',true);
		$checkdata=$this->input->post('checkdata',true);
		$param=array();
		if(!empty($arr['id'])){
			$param['supplier_id']=$arr['id'];
		}	
		if(!empty($sch_sn)){
			$param['sch_sn']=$sch_sn;
		}
		if(!empty($sch_expertName)){
			$param['sch_expertName']=$sch_expertName;
		}
		if(!empty($starttime)){
			$param['starttime']=$starttime;
		}
		if(!empty($endtime)){
			$param['endtime']=$endtime;
		}
		if(!empty($return_starttime)){
			$param['return_starttime']=$return_starttime;
		}
		if(!empty($return_endtime)){
			$param['return_endtime']=$return_endtime;
		}
		if(!empty($sch_ordersn)){
			$param['sch_ordersn']=$sch_ordersn;
		}
		if($checkdata=='on'){
			$checkdata=1;
		}else{
			$checkdata=0;
		}
		$type=$apply_status;  //未还款,已还款
				
    		$data = $this->limit_apply->get_expert_limit_apply($param,$this->getPage (),$type,$checkdata);
    		//echo $this->db->last_query();
		echo  $data ;
	}

	//额度的数据
	function get_credit_row(){
		$apply_id=$this->input->post('apply_id',true);
		if($apply_id>0){
			$data = $this->limit_apply->row(array('id'=>$apply_id));
			echo json_encode(array('status' => 1,'credit' =>$data));
		}else{
			echo json_encode(array('status' => -1,'msg' =>'数据获取失败'));
			exit;
		}
	}
	//申请额度
	function update_credit(){
		$type=$this->input->post('type',true); //1.通过,-1.拒绝
		$apply_id=$this->input->post('apply_id',true);
		$reply=$this->input->post('reply',true);

		if($apply_id>0){
			$this->load->library('session');
			$arr=$this->session->userdata ( 'loginSupplier' );

			$re=$this->limit_apply->update_limit_apply($apply_id,$type,$reply,$arr['id']);

			if($re){
				echo json_encode(array('status' => 1,'msg' =>'操作成功'));
				exit;	
			}else{
				echo json_encode(array('status' => -1,'msg' =>'操作失败'));
				exit;	
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'操作失败'));
			exit;
		}

	}

}