<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 旅游分享
 * @author HEJUN
 *
 */
class Share_list extends UC_NL_Controller{
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'common/u_member_model', 'member_model' );
		$this->load->model ( 'common/u_line_share_model', 'line_share_model' );
		$this->load->library ( 'callback' );
		$this->load->helper ( 'my_text' );
	}
	public function index(){
		$whereArr=array();
		//最新分享
		$data['new_share']=$this->line_share_model->result($whereArr,$page = 1, $num =10, $orderby = "addtime desc", $type='arr');
		
		//分享达人
		$data['share_man']=$this->member_model->result($whereArr,$page = 1, $num =12, $orderby = "share_count desc", $type='arr');
		//分享图片
		$data['share_img']=$this->line_share_model->result($whereArr,$page = 1, $num = 10, $orderby = "praise_count desc", $type='arr');
		//print_r($data);exit();
		$this->load->view('share/share_list_view',$data);
	}
}