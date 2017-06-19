<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月28日14:49
 * @author		谢明丽
 *
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Customer_service extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'member_model', 'member');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
	}
	/*我的咨询    已点评*/
	public function index($page=1){
        
		if($page<1){
			$page=1;
		}
		$data['title']='我的咨询';
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');

		//$post_arr = array();//查询条件数组
		$post_arr='q.memberid = '.$userid.' AND reply_id > 0 ';
		$this->load->library('Page');
		$config['base_url'] = '/base/customer_service/index_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
	
		$config ['pagecount'] = count($this->member->get_consult_data($userid,0, $config['pagesize']));
		//线路咨询信息
		$data['consulting']=$this->member->get_consult_data($userid,$page, $config['pagesize']); 
		$this->page->initialize ( $config );
		$data['tyle']='index';
		//未回复
		$data['noid']=count($this->member->get_noconsult_data($userid,0, $config['pagesize']));
		//已回复
		$data['did']=count($this->member->get_consult_data($userid,0, $config['pagesize']));
		//var_dump($data['noid']);
		$this->load->view('base/customer_service',$data);
	}
	/*我的咨询 未回复*/
	public function nodid($page=1){
		if($page<1){
			$page=1;
		}
		$data['title']='我的咨询';
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
	
		$post_arr = array();//查询条件数组
		$post_arr=array('q.memberid'=>$userid,'q.reply_id'=>0);
		$this->load->library('Page');
		$config['base_url'] = '/base/customer_service/nodid_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->member->get_noconsult_data($userid,0, $config['pagesize']));
	    
		//线路咨询信息
		$data['consulting']=$this->member->get_noconsult_data($userid,$page, $config['pagesize']);
	//	echo $this->db->last_query();
		$this->page->initialize ( $config );
		$data['tyle']='nod_server';
		//未回复
		$data['noid']=count($this->member->get_noconsult_data($userid,0, $config['pagesize']));
		//已回复
		$data['did']=count($this->member->get_consult_data($userid,0, $config['pagesize']));
		
		$this->load->view('base/nocustomer_service',$data);
		
	}	
	/*我的投诉   待处理*/
	public function complaint($page=1){
		
		if($page<1){
			$page=1;
		}
		$data['title']="投诉维权";
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//待处理
		$data['noid']=$this->member->get_complaint(0,$userid);
	
		//已处理
		$data['did']=$this->member->get_complaint(1,$userid);
		$data['tyle']=$this->uri->segment (4);
	
  		//待处理	
		$data['tyle']='nodid';
		$post_arr = array();//查询条件数组
		$post_arr=array('c.member_id'=>$userid,'c.status'=>0);
		$this->load->library('Page');
		$config['base_url'] = '/base/customer_service/complaint_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->member->get_line_complaint($post_arr,0, $config['pagesize']));
		
		//投诉信息
		$data['complaint']=$this->member->get_line_complaint($post_arr,$page, $config['pagesize']);
	//	echo $this->db->last_query();
		$this->page->initialize ( $config );
	//	var_dump($data['complaint']);
		$this->load->view('base/nocomplaint',$data);
	}

	/*我的投诉 --已处理  */
	public function deal_complaint($page=1){
		$data['title']="投诉维权";
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//待处理
		$data['noid']=$this->member->get_complaint(0,$userid);
		
		//已处理
		$data['did']=$this->member->get_complaint(1,$userid);
		$data['tyle']=$this->uri->segment (4);
		
		if($page<1){
			$page=1;
		}
		$data['tyle']='did';
		$post_arr = array();//查询条件数组
		$post_arr=array('c.member_id'=>$userid,'c.status'=>1);
		$this->load->library('Page');
		$config['base_url'] = '/base/customer_service/deal_complaint_';
		$config ['pagesize'] =10;
		$config ['page_now'] = $page;
	
		$config ['pagecount'] = count($this->member->get_line_complaint($post_arr,0, $config['pagesize']));
			
		//投诉信息
		$data['complaint']=$this->member->get_line_complaint($post_arr,$page, $config['pagesize']);
	    	// echo $this->db->last_query();
		$this->page->initialize ( $config );
		$this->load->view('base/complaint',$data);
	}
	/*我的咨询*/
	public function save_refer(){
	      
		$content=$this->input->post('content');
		$id=$this->input->post('pid');
		$where['id']=$id;
		$data['status']=1;
		$data['replycontent']=trim($content);
		$this->member->updata_alldata('u_line_question',$where,$data);
		redirect('base/customer_service');
	}
	/*保存咨询回复的内容*/
	public function save_repaly_customer(){
         		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$c_loginname=$this->session->userdata('c_loginname');
		$iipp=$_SERVER["REMOTE_ADDR"];
	    	$id=$this->input->post('pid');
	    	$lineid=$this->input->post('lineid');
	   	$content=$this->input->post('content');
		$customerArr=array(
		    	'typeid'=>1,
		        	'productid'=>$lineid,
		    	'content'=>$content,
		    	'nickname'=>$c_loginname,
		    	'ip'=>$iipp,
		    	'status'=>0,
		    	'memberid'=>$userid,
		    	'addtime'=>date('Y-m-d H:i:s',time()),
		    	'pid'=> $id,
		); 

	   	$insert_id=$this->member->insert_data('u_line_question',$customerArr);
		if(is_numeric($insert_id)){
			echo  json_encode(array('status'=>1,'msg'=>'回复成功!'));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'回复失败!'));
		}
	}
	/*体验师申请*/
	public function experience_architect(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');		
		//会员信息
		$where['mid']=$userid;
		$data['member']=$this->member->get_member_message('u_member',$where);
	  	//  var_dump($data['member']);
		$this->load->view('base/experience_architect',$data);
	}
	
	/*修改体验师信息*/
	public function updata_member_message(){ 
	
		  //启用session
		  $this->load->library('session');
		  $userid=$this->session->userdata('c_userid');
			
		  $nickname=$this->input->post('nickname');
		  $sex=$this->input->post('sex');
		  $job=$this->input->post('job');
		  $personalized=$this->input->post('personalized');
		  $email=$this->input->post('email');
		  $mobile=$this->input->post('mobile');
		  $truename=$this->input->post('truename');
		  $cardid=$this->input->post('cardid');
		  $address=$this->input->post('address');
		  $postcode=$this->input->post('postcode');
		  $talk=$this->input->post('talk');
		  $label=$this->input->post('label');
		  //修改资料
		  $post_array=array(
		  	'nickname'=>$nickname,
		  	'sex'=>$sex,
		  	'job'=>$job,
		  	'email'=>$email,
		  	'mobile'=>$mobile,
		   	'truename'=>$truename,
		  	'cardid' =>$cardid,
		  	'address'=>$address,
		   	'postcode'=>$postcode,
		  	'talk'=>$talk,
		  	'label'=>$label
		  );

		  $this->member->updata_member_message($userid,$post_array);
		  $experience=$this->member->get_data('u_member_experience',array('member_id'=>$userid));
		  if(empty($experience)){
			// 插入表
			$insert_data=array('member_id'=>$userid,'status'=>0);
			$this->member->insert_data('u_member_experience',$insert_data);
			echo "<script>alert('申请成功！等待平台审核');window.location.href='/base/customer_service/experience_architect';</script>";
		  }else{
		  	echo "<script>alert('您已申请过了,正等待平台审核...');window.location.href='/base/customer_service/experience_architect';</script>";
		  }

	//  redirect('base/customer_service/experience_architect');
	}
}