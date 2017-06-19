<?php
/**
 * 投诉维权
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:01
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain extends UB2_Controller {

	public function __construct() {
		parent::__construct();

	}

	/**
	 * 与专家有关的投诉
	 *
	 * @param number $page	页
	 */
	public function index($page = 1) {

		$this->load_model('admin/b2/complain_model', 'complain');
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/b2/complain/index/';
		$config ['pagesize'] = 15;
		$config ['page_now'] = $this->uri->segment ( 5, 0 );

		$page = $page==0 ? 1:$page;
		$post_arr = array();

	     if($this->uri->segment (5)!=''){
		# 产品名称
		if ($this->session->userdata('productname') != '') {
			$post_arr['mb_od.productname LIKE'] = '%' . $this->session->userdata('productname') . '%';
		}

		# 订单编号
		if ($this->session->userdata('c_nickname') != '') {
			$post_arr['truename LIKE']= $this->session->userdata('c_nickname');
		}

		# 供应商
		if ($this->session->userdata('status') != '') {
			$post_arr['c.status'] = $this->session->userdata('status');
		}
	}else{
		unset($post_arr['mo.productname LIKE']);
		$this->session->unset_userdata('productname');
		unset($post_arr['truename LIKE']);
		$this->session->unset_userdata('c_nickname');
		unset($post_arr['c.status']);
		$this->session->unset_userdata('status');
	}

		# 搜索表单提交
		if ($this->is_post_mode()) {
			# 产品名称
			if ($this->input->post('productname') != '') {
				$post_arr['mo.productname LIKE'] = '%'.$this->input->post('productname').'%';
				$this->session->set_userdata(array('productname' => $this->input->post('productname')));
			}else{
				unset($post_arr['mo.productname LIKE']);
				$this->session->unset_userdata('productname');
			}

			# 投诉人
			if ($this->input->post('nickname') != '') {
				$post_arr['truename LIKE'] = '%'.$this->input->post('nickname').'%';
				$this->session->set_userdata(array('c_nickname' => $this->input->post('nickname')));
			}else{
				unset($post_arr['truename LIKE']);
				$this->session->unset_userdata('c_nickname');
			}

			# 状态
			if ($this->input->post('status') != '') {
				$post_arr['c.status'] = $this->input->post('status');
				$this->session->set_userdata(array('status' => $this->input->post('status')));
			}else{
				unset($post_arr['c.status']);
				$this->session->unset_userdata('status');
			}
		}
		$post_arr['mo.expert_id'] = $this->expert_id;
		$config['pagecount'] = $this->complain->get_expert_complain($post_arr, 0);
		$this->page->initialize ( $config );
		$complain_list = $this->complain->get_expert_complain($post_arr, $page, $config['pagesize']);
		$this->load_view('admin/b2/complain', array(
				'complain_list' => $complain_list,
				'productname' =>$this->session->userdata('productname'),
				'status' =>$this->session->userdata('status'),
				'nickname' =>$this->session->userdata('c_nickname')

				));
	}
}