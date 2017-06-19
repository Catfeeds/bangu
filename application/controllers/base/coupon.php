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

class Coupon extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'member_model', 'member');
		$this->load_model( 'coupon_model', 'coupon');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
	}
	
	//我的优惠券 (全部)
	public function index($page=1){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		$config['base_url'] = '/base/coupon/index_';
		$config ['pagesize'] = 8;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->coupon->get_where_coupon($userid,2,0, $config['pagesize']));
		$data['coupon_n']=$this->coupon->get_where_coupon($userid,2,$page, $config['pagesize']);
		// echo $this->db->last_query();
		$this->page->initialize ( $config );
		$data['title']='我的优惠券';
		
		//优惠券列表 --未使用
		$data['coupon']=$this->coupon->get_where_coupon($userid,0,0, $config['pagesize']);
       
		//优惠券列表 --已使用
		$data['coupon_u']=$this->coupon->get_where_coupon($userid,1,0, $config['pagesize']);
		//优惠券列表 --已过期
		$data['coupon_o']=$this->coupon->get_where_coupon($userid,-1,0, $config['pagesize']); 
        
		$this->load->view('base/coupons_member_center',$data);
	}
	//我的优惠券 (未使用)
/* 	public function coupon_unused(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//优惠券列表 --未使用
		$data['coupon_n']=$this->coupon->get_where_coupon($userid,0);
		//优惠券列表 --已使用
		$data['coupon_u']=$this->coupon->get_where_coupon($userid,1);
		//优惠券列表 --已过期
		$data['coupon_o']=$this->coupon->get_where_coupon($userid,-1);
		
		$this->load->view('base/coupons_member_unused',$data);
	} */

	//我的优惠券  (0,未使用) (1,已使用) (2,已过期)
	public function coupon_used($type=0,$page=1){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		 if($type==0){ //未使用
		 	$data['typeid']='0';
		 	$config['base_url'] = '/base/coupon/coupon_used_0_';
		 	
		 }else if($type==1){ //已使用
		 	$data['typeid']='1';
		 	$config['base_url'] = '/base/coupon/coupon_used_1_';
		 }else if($type==2){ //已过期
		 	$data['typeid']='-1';
		 	$config['base_url'] = '/base/coupon/coupon_used_2_';
		 }else{
		 	$data['typeid']='0';
		 	$config['base_url'] = '/base/coupon/coupon_used_0_';
		 }
		
		$config ['pagesize'] = 10;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->coupon->get_where_coupon($userid,$data['typeid'],0, $config['pagesize']));
		$data['coupon']=$this->coupon->get_where_coupon($userid,$data['typeid'],$page, $config['pagesize']);
		$data['pagecount']=$config ['pagecount'];
		$this->page->initialize ( $config );
		$data['title']='我的优惠券';
		
		//优惠券列表 --未使用
		$data['coupon_all']=count($this->coupon->get_where_coupon($userid,0,0, $config['pagesize']));
		//优惠券列表 --已使用
		$data['coupon_u_all']=count($this->coupon->get_where_coupon($userid,1,0, $config['pagesize']));
		//优惠券列表 --已过期
		$data['coupon_o_all']=count($this->coupon->get_where_coupon($userid,-1,0, $config['pagesize']));
		
		$this->load->view('base/coupons_member_used',$data);
	}
	
	//我的优惠券 (已过期)
/* 	public function coupon_outdate(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		//优惠券列表 --未使用
		$data['coupon_n']=$this->coupon->get_where_coupon($userid,0);
		//优惠券列表 --已使用
		$data['coupon_u']=$this->coupon->get_where_coupon($userid,1);
		//优惠券列表 --已过期
		$data['coupon_o']=$this->coupon->get_where_coupon($userid,-1);
		//echo $this->db->last_query();
		$this->load->view('base/coupons_member_outdate',$data);
	} */
}