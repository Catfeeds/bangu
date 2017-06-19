<?php
/**
 * 消息通知
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月7日10:06:30
 * @author
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/message_model', 'message');
		$this->load->library('session');
	}

	//业务消息
	public function index($page = 1) {

		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/message/index/';
		$config['pagesize'] = 20;
		$config['page_now'] = $this->uri->segment(5,0);
		$post_arr = array();
		$this->session->unset_userdata('opportunity_title');
		$this->session->unset_userdata('time');
		# 搜索表单提交
		$post_arr['msg_type'] = ROLE_TYPE_EXPERT;
		$post_arr['receipt_id'] = $this->expert_id;
		$post_arr['read >='] = 0;
		$config['pagecount'] = $this->message->get_msg_count($this->expert_id);
		//print_r($this->db->last_query());exit();
		$this->page->initialize($config);
		$msg_list = $this->message->result($post_arr,$page, $config['pagesize'],'addtime desc');
		$statis_msg = $this->get_unread_msg();//消息统计
		
		$this->load_view('admin/b2/message', array(
				'msg_list' => $msg_list,
				'statis_msg' => $statis_msg
				));
	}
	public function search($page = 1){

		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/message/search/';
		$config['pagesize'] = 20;
		$config['page_now'] = $this->uri->segment(5,0);
		$post_arr = array();
		$title=$this->input->get('title');
		$time=$this->input->get('time');
		if(isset($_GET['title'])){//是否是get提交过来
			if(!empty($title)){
	    	 $title = empty($title)?$this ->session ->userdata('opportunity_title'):$title;
			}else{
				$this->session->unset_userdata('opportunity_title');
				$title='';
			}
		}else{ //分页
			$title = empty($title)?$this ->session ->userdata('opportunity_title'):$title;
		}

		if(isset($_GET['time'])){//是否是get提交过来
			if(!empty($time)){
				$time = empty($time)?$this ->session ->userdata('time'):$time;
			}else{
				$this->session->unset_userdata('time');
				$time='';
			}
		}else{//分页
			$time = empty($time)?$this ->session ->userdata('time'):$time;
		}

		#搜索
		if(!empty($time)){
		  $time = empty($time)?$this ->session ->userdata('time'):$time;
		}
		if (!empty($title))
		{
			$this->session->set_userdata('opportunity_title', trim($title));
			$post_arr['title like'] =  sprintf('%%%s%%', trim($title));;
		}else{
			$title='';
		}

		if(!empty($time)){
			$this->session->set_userdata('time', trim($time));
			$last_time=date('Y-m-d',strtotime("-$time month"));
			$nowtime=date('Y-m-d',time());
			$where ="addtime BETWEEN '".$last_time."' AND '".$nowtime."'";
		}else{
			$where='';
			$time='';
		}
		$post_arr['msg_type'] = ROLE_TYPE_EXPERT;
		$post_arr['receipt_id'] = $this->expert_id;

	    $config['pagecount'] = count($this->message->get_message($post_arr,$where));
		$this->page->initialize($config);
		$msg_list = $this->message->get_message($post_arr, $where,$page, $config['pagesize']);

		$this->load_view('admin/b2/message', array(
				'msg_list' => $msg_list,
				'title'=>$title,
				'time'=>$time
		));
	}

	/* 系统消息*/
	public function system($page = 1){

		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/message/system/';
		$config['pagesize'] = 20;
		$config['page_now'] = $this->uri->segment(5,0);
		$this->session->unset_userdata('opportunity_title');
		$this->session->unset_userdata('time');
		$post_ar = $this->expert_id;
		$whereA="n.`id` NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE FIND_IN_SET(1,nr.`notice_type`)>0 AND nr.`userid`={$post_ar} AND nr.`status`=0) AND FIND_IN_SET(1,n.`notice_type`)>0";
		$tatol=$this->message->system_row($whereA,0,10,$post_ar);
		@$config['pagecount'] = $tatol[0]['num'];
		// print_r($this->db->last_query());exit();
		$this->page->initialize($config);

		$msg_list = $this->message->system_row($whereA,$page, $config['pagesize'],$post_ar);
		$statis_msg = $this->get_unread_msg();//消息统计

		$this->load_view('admin/b2/message_1', array(
				'msg_list' => $msg_list,
				'statis_msg' => $statis_msg
				));

	}
	/* 系统消息搜索页*/
	public function system_search($page = 1){
		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/message/system_search/';
		$config['pagesize'] = 20;
		$config['page_now'] = $this->uri->segment(5,0);
		// $post_arr = array();

		$title=$this->input->get('title');
		$time=$this->input->get('time');
		/* $time = empty($time)?$this ->session ->userdata('time'):$time;
		$title = empty($title)?$this ->session ->userdata('opportunity_title'):$title; */

		if(isset($_GET['title'])){//是否是get提交过来
			if(!empty($title)){
				$title = empty($title)?$this ->session ->userdata('opportunity_title'):$title;
			}else{
				$this->session->unset_userdata('opportunity_title');
				$title='';
			}
		}else{ //分页
			$title = empty($title)?$this ->session ->userdata('opportunity_title'):$title;
		}

		if(isset($_GET['time'])){//是否是get提交过来
			if(!empty($time)){
				$time = empty($time)?$this ->session ->userdata('time'):$time;
			}else{
				$this->session->unset_userdata('time');
				$time='';
			}
		}else{//分页
			$time = empty($time)?$this ->session ->userdata('time'):$time;
		}

		if (!empty($title))
		{
			$this->session->set_userdata('opportunity_title', trim($title));
			// $post_arr['n.title like'] =  sprintf('%%%s%%', trim($title));;
			$titles=trim($title);
			$post_arr="n.title like  '%{$titles}%'";
		}else{
			$title='';
			$post_arr="n.title like  '%{$title}%'";
		}

		if(!empty($time)){
			$this->session->set_userdata('time', trim($time));
			$last_time=date('Y-m-d',strtotime("-$time month"));
			$nowtime=date('Y-m-d',time());
			$where ="addtime BETWEEN '".$last_time."' AND '".$nowtime."'";
		}else{
			$where='';
			$time='';
		}
		$userid=$this->expert_id;
		$config['pagecount'] = count($this->message->get_system_message($post_arr,$where,$userid));
		$this->page->initialize($config);
		$msg_list = $this->message->get_system_message($post_arr,$where,$userid, $page, $config['pagesize']);

		$this->load_view('admin/b2/message_1', array(
				'msg_list' => $msg_list,
				'title'=>$title,
				'time'=>$time,
		));

	}
	/*ajax返回消息详情*/
	public function ajax_data(){
		$id=$this->input->post('data');
		$data['messages']=$this->message->messages_row($id);
		/*$sql = "UPDATE u_message as m SET m.read=1,m.modtime=now() WHERE id=$id";
		$this->db->query($sql);*/
		$this->message->update_msg_status($id);
		$mess=$this->get_unread_msg();
		echo json_encode(array('status'=>1,'data'=>$data['messages'],'mess'=>$mess));
		//$this->load->view('admin/b2/ajax/messages_ajax',$data);
	}

	/*系统消息的详情页*/
	public function ajax_data_1(){
		$id=$this->input->post('data');
		$data['type']=1;
		$data['messages']=$this->message->system_data($id);
	   //判断是否是已读状态
		$where=array(
			'notice_id'=>$id,
			'userid'=>$this->expert_id,
			'notice_type'=>1,
		);
		$mess=$this->message->sel_data('u_notice_read',$where);
		if(empty($mess)){ //未读状态则插入
			$insert_data['notice_id'] = $id;
			$insert_data['notice_type'] = 1;
			$insert_data['read'] = 1;
			$insert_data['status'] = 1;
			$insert_data['userid'] = $this->expert_id;
			$insert_data['modtime'] = date('Y-m-d H:i:s');
			$this->db->insert('u_notice_read',$insert_data);
			//print_r($this->db->last_query());exit();
		}

		/*INSERT INTO u_notice_read (notice_id,notice_type,userid,READ,modtime)VALUES(4,2,91,1,NOW())*/
		//$this->load->view('admin/b2/ajax/messages_ajax',$data);
		$mess=$this->get_unread_msg();
		echo json_encode(array('status'=>1,'data'=>$data['messages'],'mess'=>$mess));
	}
   //显示消息数量
   function get_message_num(){
   		$mess=$this->get_unread_msg();
   		echo json_encode(array('status'=>1,'mess'=>$mess));
   }
	function ajax_delete_msg(){
		$msg_id = $this->input->post('msg_id');
		/*$sql = 'UPDATE u_message SET `read`=-1 WHERE id='.$msg_id;*/

		if($this->message->delete_msg($msg_id)){
			echo json_encode(array('status'=>200,'msg'=>'删除成功'));
		}else{
			echo json_encode(array('status'=>-200,'msg'=>'删除失败'));
		}
	}
	//
	function del_message_data(){
		$this->load->model('admin/b1/messages_model');
		$id=$this->input->post('msg_id');
		$this->load->library('session');
		$data['type']=2;
		$data['messages']=$this->message->system_data($id);
	   //判断是否是已读状态
		$where=array(
			'notice_id'=>$id,
			'userid'=>$this->expert_id,
			'notice_type'=>1,
		);
		$mess=$this->message->sel_data('u_notice_read',$where);
		if(empty($mess)){ //未读状态则插入
			$insert_data['notice_id'] = $id;
			$insert_data['notice_type'] = 1;
			$insert_data['status'] = 0;
			$insert_data['read'] = 1;
			$insert_data['userid'] = $this->expert_id;
			$insert_data['modtime'] = date('Y-m-d H:i:s');
			$this->db->insert('u_notice_read',$insert_data);
			echo json_encode(array('status'=>200,'msg'=>'ok'));
		}else{
			$sql = 'UPDATE u_notice_read SET `status`=0 WHERE notice_type=1  and notice_id='.$id;
			$status = $this->db->query($sql);echo json_encode(array('status'=>200,'msg'=>'删除成功！'));
		}
	}


}