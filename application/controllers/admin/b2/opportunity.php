<?php
/**
 * 消息通知
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月7日10:06:30
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opportunity extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/opportunity_apply_model', 'opportunity_apply');
		$this->load->library('session');
	}

	public function index($page = 1) {

		# 分页设置

		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/opportunity/index/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment(5,0);
		$config['page_query_string'] = TRUE;
		$this->load->library('session');
		$this->session->unset_userdata('opportunity_title');
		$this->session->unset_userdata('opportunity_status');
		$page = $page==0 ? 1:$page;
		$post_arr = array();

		$config['pagecount'] = $this->opportunity_apply->get_opportunity_apply_list($post_arr, 0);
		//$this->pagination->initialize($config);
		$this->page->initialize($config);
		$op_apply_list = $this->opportunity_apply->get_opportunity_apply_list($post_arr, $page, $config['pagesize']);
		//echo $this->db->last_query();
		$this->load_view('admin/b2/opportunity_apply', array(
				'op_apply_list' => $op_apply_list,
				/*'page_link' => $this->pagination->create_links()*/));
	}


	public function search($page = 1) {
		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/opportunity/search/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment(4,0);
		$config['page_query_string'] = TRUE;
		$title=$this->input->post('title',true);
		$status = $this ->input ->post('status');

	    if($this->is_post_mode()){

	    	if($title==''){
	    		$title='';
	    	}
	    	if($status==''){
	    		$status='';
	    	}
	    }else{

	    	 $title = empty($title)?$this ->session ->userdata('opportunity_title'):$title;
		     $status = empty($status)?$this ->session ->userdata('opportunity_status'):$status;
	    }


		$post_arr = array();
		# 搜索表单提交
		if (!empty($title))
		{
			$this->session->set_userdata('opportunity_title', $title);
			$post_arr['op.title like'] = trim($title);
		}

		if ($status != '' && isset($status))
		{

			if($status==-1){
				$status=$this->session->unset_userdata('opportunity_status');
			}else{
				$this->session->set_userdata('opportunity_status', $status);
				$post_arr['op.status'] = trim($status);
			}

		}else{
			$status=$this->session->unset_userdata('opportunity_status');
		}

		//$post_arr['expert_id'] = $this->expert_id;

		$config['pagecount'] = count($this->opportunity_apply->get_opportunity_apply_list($post_arr, 0));
		//$this->pagination->initialize($config);
		$this->page->initialize($config);
		$op_apply_list = $this->opportunity_apply->get_opportunity_apply_list($post_arr, $page, $config['pagesize']);

		$this->load_view('admin/b2/opportunity_apply', array(
				'op_apply_list' => $op_apply_list,
				'title' =>$title,
				'status'=>$status,
		));
	}


	/*ajax返回修改报名状态*/
	public function update_data(){
		$id=$this->input->post('data');
		$status=$this->input->post('status');
		$opid=$this->input->post('opid');
		if(!empty($id)&& !empty($status)){
		       $re=$this->opportunity_apply->opportunity_row($id,$status);
		       $this->opportunity_apply->dis_opportunity($opid);
		       if($re){
		       		return 1;
		       }else{
		       		return 0;
		       }
		}else{
			return 0;
		}
	}
	/*ajax返回修改报名状态*/
	public function ajax_insert(){
		$id=$this->input->post('data');
		$time=$this->input->post('time');
		if(!empty($id)){
			$data=array(
					'expert_id'=>$this->expert_id,
					'opportunity_id'=>$id,
					'addtime'=>date('Y-m-d H:i:s', time()),
					'modtime'=>date('Y-m-d H:i:s', time()),
					'status'=>0
			);
			//数据表加1
			$this->opportunity_apply->update_opportunity($id);
			$re=$this->opportunity_apply->opportunity_insert($data);
			echo 1;

		}else{
			echo  0;
		}
	}
}