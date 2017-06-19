<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月28日14:49
 * @author		汪晓烽
 *
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Invite_service extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'invite_service_model', 'invite_service');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
	}
	/*邀请管家服务*/
	public function invite($page=1){
		$this->load->library('session');
		$member_id=$this->session->userdata('c_userid');
		$where_str = " WHERE sr.member_id={$member_id} AND (sr.progress=1 OR sr.progress=2 OR sr.progress=3) ";
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		$config['base_url'] = '/base/invite_service/invite_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = $this->invite_service->get_service_data($where_str, 0, $config ['pagesize']);
		$data['row']=$this->invite_service->get_service_data($where_str, $page, $config ['pagesize']);
		$this->page->initialize ( $config );
		$data['title']='管家服务';
	    	$this->load->view('base/invite',$data);
	}


	/*已完成管家服务*/
	public function complete_service($page=1){
		$this->load->library('session');
		$member_id=$this->session->userdata('c_userid');
		$where_str = " WHERE sr.member_id={$member_id} AND sr.progress=4 ";
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		$config['base_url'] = '/base/invite_service/complete_service_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = $this->invite_service->get_service_data($where_str, 0, $config ['pagesize']);
		$data['row']=$this->invite_service->get_service_data($where_str, $page, $config ['pagesize']);
		$this->page->initialize ( $config );
		$data['title']='管家服务';
	    	$this->load->view('base/complete_service',$data);
	}

	//拒绝服务
	public function refused_service($page=1){
		$this->load->library('session');
		$member_id=$this->session->userdata('c_userid');
		$where_str = " WHERE sr.member_id={$member_id} AND sr.progress=-1 ";
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		$config['base_url'] = '/base/invite_service/refused_service_';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = $this->invite_service->get_service_data($where_str, 0, $config ['pagesize']);
		$data['row']=$this->invite_service->get_service_data($where_str, $page, $config ['pagesize']);
		$this->page->initialize ( $config );
		$data['title']='管家服务';
	    	$this->load->view('base/refused_service',$data);
	}

	//弹框的时候获取一些信息
	public function get_service_info(){
		$service_id = $this->input->post('service_id');
		$service_info  = $this->invite_service->get_service_info($service_id);
		echo json_encode($service_info[0]);
	}

	//用户评论管家的服务
	function comment_service(){
		$comment_data = $this->security->xss_clean($_POST);
		$update_arr['comment'] = $comment_data['comment_text'];
		$update_arr['score'] = $comment_data['comment_score'];
		$update_arr['progress'] = 4;
		$status = $this->db->update('u_expert_service_record', $update_arr, array('id' => $comment_data['service_id']));
		if($status){
			echo json_encode(array('status'=>200,'msg'=>'评论成功'));
		}else{
			echo json_encode(array('status'=>-200,'msg'=>'评论失败'));
		}
	}

}