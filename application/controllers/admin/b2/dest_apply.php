<?php
/**
 * 专家目的地申请记录
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月1日16:23:28
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dest_apply extends UB2_Controller {
	
	public function __construct() {
		parent::__construct();
	
		$this->load_model('admin/b2/expert_dest_model', 'expert_dest');
	
	}
	
	/**
	 * 专家目的地申请记录
	 * @param number $page	分页
	 */
	public function index($page = 1) {
		
		$this->load->library('pagination');
		# 分页设置
		$config['base_url'] = '/b2/dest_apply/index';
		$config['per_page'] = '10';
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = true;
		$config['first_link'] = '首页'; // 第一页显示
		$config['last_link'] = '末页'; // 最后一页显示
		$config['next_link'] = '下一页'; // 下一页显示
		$config['prev_link'] = '上一页'; // 上一页显示
		
		$post_arr = array();
		
		# 所有session名都以控制器名开头,避免与其它session重名
		# 目的地
		$dest_id = 0;
		if ($this->session->userdata('dest_apply_destid') != '') {
			$dest_id = $this->session->userdata('order_destid');
		}
		
		# 订单状态
		if ($this->session->userdata('dest_apply_status') != '') {
			$post_arr['a.status']= $this->session->userdata('dest_apply_status');
		}
		
		# 搜索表单提交
		if ($this->is_post_mode()) {
			
			# 目的地
			if ($this->input->post('destid') != '') {
				$dest_id = $this->input->post('destid');
				$this->session->set_userdata(array('dest_apply_destid' => $dest_id));
			} else {
				unset($post_arr['destid']);
				$this->session->unset_userdata('dest_apply_destid');
			}
			
			# 订单状态
			if ($this->input->post('status') != '' && $this->input->post('status') != -1) {
				$post_arr['a.status']= $this->input->post('status');
				$this->session->set_userdata(array('dest_apply_status' => $post_arr['a.status']));
			}
			else {
				unset($post_arr['a.status']);
				$this->session->unset_userdata('dest_apply_status');
			}
		}
		
		$post_arr['expert_id']= $this->expert_id;
		
		$config['total_rows'] = count($this->expert_dest->get_expert_dest_list($post_arr, 0, $config['per_page']));
		
		$this->pagination->initialize($config);
		
		$dest_apply_list = $this->expert_dest->get_expert_dest_list($post_arr, $page, $config['per_page']);
		$this->load_view('admin/b2/dest_apply', array(
				'dest_apply_list' => $dest_apply_list,
				'page_link' => $this->pagination->create_links(),
				'dest_apply_destid' => $this->session->userdata('dest_apply_status'),
				'dest_apply_status' => $this->session->userdata('dest_apply_status'),
		));
	}
}