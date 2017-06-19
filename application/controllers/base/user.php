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

class User extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'member_model', 'member');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
	}
	/*我的资料*/
	public function index(){
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//会员信息
		$where['mid']=$userid;
		$data['member']=$this->member->get_member_message('u_member',$where);
       		 //优惠券
		$this->load_model( 'coupon_model', 'coupon');
		$data['coupon_n']=$this->coupon->get_where_coupon($userid,0);
		//订单信息
		$data['order']=$this->member->get_order_num($userid);
		//echo $this->db->last_query();
		//产品提问
		$data['line_answer']=$this->member->get_line_consult($userid);
		//指定提问
		$data['expert_answer']=$this->member->get_expert_consult($userid);
		//定制信息
		$data['custom_answer']=$this->member->get_custom_consult($userid);
		//业务消息
		$data['notice_answer']=$this->member->get_notice_consult($userid);
		$this->load->library('session');
		$data['c_logintime']=$this->session->userdata('c_logintime');
	  
		$this->load->view('base/user',$data);
	}
}
