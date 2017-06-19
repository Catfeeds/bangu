<?php
/***
*深圳海外国际旅行社
*2015-3-24 上午11:54:10
*2015
*UTF-8
****/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends UB1_Controller {

	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('admin/b1/messages_model');
		
	}
	public function index(){
		$data['pageData']=$this->messages_model->get_messages(null,$this->getPage ());
		$data['pageData0'] = $this->messages_model->get_service_messages(null,$this->getPage ());
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/messages_last',$data);
		$this->load->view('admin/b1/footer.html');
	}
	/*通知系统的分页查询*/
	public function indexData(){

		$param = $this->getParam(array('title','addtime'));
		if(!empty($param['addtime'])){
			$mun=$param['addtime'];
			$last_time=date('Y-m-d',strtotime("-$mun month"));
			$nowtime=date('Y-m-d',time());
			$param['addtime']=$last_time;
			$param['nowtime']=$nowtime;
		}
		
	    	$data = $this->messages_model->get_messages($param,$this->getPage ());
		echo  $data ;
	}
	/*业务系统的分页查询*/
	public function indexData1(){
		$param = $this->getParam(array('title','addtime'));
		if(!empty($param['addtime'])){
			$mun=$param['addtime'];
			$last_time=date('Y-m-d',strtotime("-$mun month"));
			$nowtime=date('Y-m-d',time());
			$param['addtime']=$last_time;
			$param['nowtime']=$nowtime;
		}
	
		$data = $this->messages_model->get_service_messages($param,$this->getPage ());
		echo  $data ;
	}
	public function view($slug)
	{
		$data['messages_item'] = $this->messages_model->get_messages($slug);
	}
	/*删除消息*/
	function del_data(){
		$id=$this->input->post('data');
		if($id>0){
			$re=$this->messages_model->update_table_data('u_message',array('id'=>$id),array('read'=>-1));
			if($re){
				echo json_encode(array('status'=>1,'msg'=>'删除成功!'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'删除失败!'));
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'删除失败!'));
		}
	}
	/*删除平台的消息*/
	function del_message_data(){
		$id=$this->input->post('data');
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		if($id>0){
			$re=$this->messages_model->update_table_data('u_notice_read',array('notice_id'=>$id),array('status'=>-1,'notice_type'=>2,'userid'=>$login_id));
			if($re){
				echo json_encode(array('status'=>1,'msg'=>'删除成功!'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'删除失败!'));
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'删除失败!'));
		}
	}
	/*ajax返回消息详情*/
	public function ajax_data(){
		$type=$this->input->post('type');
		$id=$this->input->post('data');
	

		if ($type==2){	 //业务通知 	
		    	$data['messages']=$this->messages_model->service_messages_row($id);
		    	$data['type']=2;
		    	$this->messages_model->update_table_data('u_message',array('id'=>$id),array('read'=>1));
		    	//消息的统计
		    	$statis_msg = $this->get_unread_msg();
		    	echo json_encode(array('status'=>1,'data'=>$data['messages'],'mess'=>$statis_msg));
		}else{  //系统通知   
		    	
		    	//启用session
		    	$this->load->library('session');
		    	$arr=$this->session->userdata ( 'loginSupplier' );
		    	$login_id=$arr['id'];
		    	
		    	//判断是否已读了。
		    	$where=array(
		    		'notice_id'=>$id,
		    		'notice_type'=>2,
		    		'userid'=>$login_id,
		    	);
		    	$mess=$this->messages_model->sel_data('u_notice_read',$where);
		    	
		    	if(empty($mess)){  //未读则插入数据
		    		
		    		$insert_data=array(
		    			'notice_id'=>$id,
		    			'userid'=>$login_id,
		    			'read'=>1,
		    			'notice_type'=>2,
		    			'modtime' =>date('Y-m-d H:i:s'),
		    		);
		    		$this->db->insert('u_notice_read',$insert_data);
		    	}
		      
		    	$data['messages']=$this->messages_model->messages_row($id);
		    	//消息的统计
		    	$statis_msg = $this->get_unread_msg();
		    	echo json_encode(array('status'=>1,'data'=>$data['messages'],'mess'=>$statis_msg));
		}
	}
	
}
