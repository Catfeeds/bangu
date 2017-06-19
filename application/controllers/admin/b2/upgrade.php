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

class Upgrade extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/upgrade_model', 'upgrade');
		$this->load->library('session');
	}

	public function index($page = 1) {

		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/upgrade/index/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment(5,0);
		$this->session->unset_userdata('apply_time');
		$this->session->unset_userdata('apply_grade');
		$this->session->unset_userdata('apply_status');
		$page = $page==0 ? 1:$page;
		$post_arr = array();
		$expert_arr = array();

		$post_arr['eu.expert_id'] = $this->expert_id;
		$config['pagecount'] = $this->upgrade->get_expert_data($post_arr,'',0);

		$this->page->initialize($config);
		$upgrade_list = $this->upgrade->get_expert_data($post_arr, '',$page, $config['pagesize']);
		$expert_arr['id'] = $this->expert_id;
		$get_expert_info = $this->upgrade->get_expert_info($expert_arr);
		$data = array( 'upgrade_list' => $upgrade_list,
			           'get_expert_info' => $get_expert_info[0],
			            'apply_time' =>0,
			           'apply_grade'=>'',
			           'apply_status'=>''
			           );
		$this->load_view('admin/b2/upgrade', $data);
	}

	public function search($page = 1) {
		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/upgrade/search/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment(5,0);
		$apply_time=$this->input->get('apply_time');
		$apply_grade = $this->input->get('apply_grade');
		$apply_status = $this->input->get('apply_status');
		$post_arr = array();
		$expert_arr = array();
		# 搜索表单提交
		if(!empty($apply_time)&&$apply_time!=0){
			$apply_time=$apply_time;
			$this->session->set_userdata('apply_time', trim($apply_time));
			$last_time=date('Y-m-d',strtotime("-$apply_time month"));
			$nowtime=date('Y-m-d',time());
			$where ="eu.addtime BETWEEN '".$last_time."' AND '".$nowtime."'";
		}elseif(isset($_GET['apply_time']) && 0==$apply_time){
			$this->session->unset_userdata('apply_time');
			$where='';
			$apply_time='';
		}else{
			$apply_time = $this ->session ->userdata('apply_time');
			if($apply_time==0){
				$this->session->unset_userdata('apply_time');
				$where='';
				$apply_time='';
			}else{
				$this->session->set_userdata('apply_time', trim($apply_time));
				$last_time=date('Y-m-d',strtotime("-$apply_time month"));
				$nowtime=date('Y-m-d',time());
				$where ="eu.addtime BETWEEN '".$last_time."' AND '".$nowtime."'";
			}
		}

		if(isset($apply_grade) && ''!=$apply_grade){
			$this->session->set_userdata('apply_grade', trim($apply_grade));
			$post_arr['eu.grade_after'] = $apply_grade;
		}

		if(isset($apply_status) && ''!=$apply_status){
			$this->session->set_userdata('apply_status', trim($apply_status));
			$post_arr['eu.status'] = $apply_status;
		}
		$post_arr['eu.expert_id'] = $this->expert_id;
		$config['pagecount'] = count($this->upgrade->get_expert_data($post_arr,$where,0));
		$this->page->initialize($config);
		$upgrade_list = $this->upgrade->get_expert_data($post_arr,$where, $page, $config['pagesize']);
		//echo $this->db->last_query();exit;
		$expert_arr['id'] = $this->expert_id;
		$get_expert_info = $this->upgrade->get_expert_info($expert_arr);
	//echo $this->db->last_query();exit;
		$data = array(
			           'upgrade_list' => $upgrade_list,
			           'apply_time' => $this->session->userdata('apply_time'),
			           'apply_grade'=>$this->session->userdata('apply_grade'),
			           'apply_status'=>$this->session->userdata('apply_status'),
			           'get_expert_info' => $get_expert_info[0]
			);
		$this->load_view('admin/b2/upgrade',$data);
	}
}