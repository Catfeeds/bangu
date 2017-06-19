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

class Gift extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'gift_model', 'gift_model');
		$this->load->helper(array('form', 'url'));
		$this ->load ->library('form_validation');
		//$this->load->helper ( 'My_md5' );
	}

	/*我的礼品*/
	public function gift_list($type='',$page=1){
		 
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		
		//分页
		$where['member_id'] = $userid;
		if($page<1){
			$page=1;
		}
		$this->load->library('Page');
		
		if($type==0){  //全部
		    	$data['type']=0;
		    	$config['base_url'] = '/base/gift/gift_list_0_';
		}else if($type==1){   //未使用 
		    	$data['type']=1;
		    	$where['lm.status']=0;
		    	$where['lg.status !=']=2;
		    	$config['base_url'] = '/base/gift/gift_list_1_';
		}else if($type==2){   //已使用
		    	$data['type']=2;
		    	$where['lm.status']=1;
		    	$where['lg.status !=']=2;
		    	$config['base_url'] = '/base/gift/gift_list_2_';
		}else if($type==3){   //已过期
		    	$data['type']=3;
		    	$where='(lm.status = 2 or lg.status = 2 ) and member_id ='.$userid;
		    	//$where['lm.status']=2;
		    	//$where['lg.status']=2;
		    	$config['base_url'] = '/base/gift/gift_list_3_';
		}else{
		    	$data['type']=0;
		    	$config['base_url'] = '/base/gift/gift_list_0_';
		}
		
		$config ['pagesize'] = 5;
		$config ['page_now'] = $page;
		$config ['pagecount'] = count($this->gift_model->get_giftlist($where, 0, $config['pagesize']));
		$data['row']=$this->gift_model->get_giftlist($where,$page, $config['pagesize']);
		//echo $this->db->last_query();
		$data['title']='我的礼品';

		$this->page->initialize ( $config );
		
		$this->load->view('base/gift_list',$data);
	}
}
