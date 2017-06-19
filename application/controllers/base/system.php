<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月27日18:26:53
 * @author		谢明丽
 *
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class System extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'member_model', 'member');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
		//$this->load->helper ( 'My_md5' );
	}
	  /*业务通知*/
	   public function  message($page=1){
		   	//启用session
		    	 $this->load->library('session');
		   	 $userid=$this->session->userdata('c_userid');
		   	 $where['m.receipt_id']=$userid;
		   	 //分页
		   	 if($page<1){
		   	 	$page=1;
		   	 }
		   	 $this->load->library('Page');
		   	 $config['base_url'] = '/base/system/message_';
		   	 $config ['pagesize'] = 10;
		   	 $config ['page_now'] = $page;
		   	 $config ['pagecount'] = count($this->member->system_message($where, 0, $config['pagesize']));	   	 
		   	 $data['row']=$this->member->system_message($where,$page, $config['pagesize']);
		  
		   	 $this->page->initialize ( $config );
	         		 $data['title']="通知消息";
		   	 $this->load->view('base/system_message',$data);
	   }
	   /*系统通知*/
	   public function  notice($page=1){
		   	//启用session
		   	$this->load->library('session');
		   	$userid=$this->session->userdata('c_userid');
		   	$data['title']="通知消息";
		   	//分页
		   	if($page<1){
		   		$page=1;
		   	}
		   	$this->load->library('Page');
		   	$config['base_url'] = '/base/system/notice/';
		   	$config ['pagesize'] = 10;
		   	$config ['page_now'] = $page;
		   	$config ['pagecount'] = count($this->member->system_notice('', 0, $config['pagesize']));
		   	$data['row']=$this->member->system_notice('',$page, $config['pagesize']);
		
		   	$this->page->initialize ( $config );
		   
		   	$this->load->view('base/system_notice',$data);
	   }
	   /*获取信息*/
	   public function get_content(){
	   	   $id=$this->input->post('id');
	   	   if(is_numeric($id)){
	   	   	$where=array('id'=>$id);
	   	   	$content=$this->member->get_alldata('u_message',$where);
	   	   	$this->member->updata_alldata('u_message',array('id'=>$id),array('read'=>1));
	   	   	echo json_encode($content);
	   	   }else{
	   	   	echo false;
	   	   }
	   }
	   /*获取系统消息*/
	   public function get_notice_content(){
		   	$id=$this->input->post('id');
		   	//启用session
		   	$this->load->library('session');
		   	$userid=$this->session->userdata('c_userid');
		   	
		   	if(is_numeric($id)){
		   		$where=array('id'=>$id);
		   		$content=$this->member->get_alldata('u_notice',$where);
		   		//判断是否已读
		   		$wh=array(
		   			'notice_id'=>$id,
		   			'notice_type'=>0,
		   			'userid'=>$userid,
		   		);
		   		$mess=$this->member->get_alldata('u_notice_read',$wh);
		   		
		   		if(empty($mess)){  //未读就插入数据	
		   			$insert_data=array(
		   				'notice_id'=>$id,
		   				'userid'=>$userid,
		   				'read'=>1,
		   				'notice_type'=>0,
		   				'modtime' =>date('Y-m-d H:i:s'),
		   			);
		   			$this->db->insert('u_notice_read',$insert_data);
		   		}
		   		
		   		echo json_encode($content);
		   	}else{
		   		echo false;
		   	}
	   }
   
}