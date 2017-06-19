<?php
/**
 * 退团审批
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年8月4日15:05:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class League_approval extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/league_approval_model', 'league_approval');
	}

	function index() {
		$this->view('admin/b2/league_approval_view');
	}

	function ajax_league_list(){
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
       	$league_status = $this->input->post('league_status', true);
        	$number = empty($number) ? 10 : $number;
        	$page = empty($page) ? 1 : $page;
        	$depart_id = $this->session->userdata('depart_id');
		$league_list = $this->league_approval->get_league_data($page,$number,$depart_id,$league_status);
		$pagecount = $this->league_approval->get_league_data(0,$number,$depart_id,$league_status);
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            }
	           $data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $league_list
            		);
		echo json_encode($data);
	}

	//经理通过改价申请
	function pass_apply(){
		$arrData = $this->security->xss_clean($_POST);
		$order_id = $arrData['pass_order_id'];
		$yf_id = $arrData['pass_id'];
		$this->db->trans_begin();//开启事物
		$this->db->update('u_order_bill_yf', array('status'=>1,'m_time'=>date('Y-m-d H:i:s'),'m_remark'=>$arrData['pass_remark'],'manager_id'=>$this->expert_id), array('id' => $yf_id));
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>'已提交,等待审核'));
			exit();
		}


	}

	//经理拒绝改价申请
	function refuse_apply(){
		$arrData = $this->security->xss_clean($_POST);
		$update_data = array(
			'status'=>3,
			'm_remark'=>$arrData['refuse_remark'],
			'm_time'=>date('Y-m-d H:i:s'),
			'manager_id'=>$this->expert_id
			);
		$status = $this->db->update('u_order_bill_yf',$update_data , array('id' => $arrData['refuse_id']));
		if($status){
			echo json_encode(array('status'=>200,'msg'=>'已提交'));
			exit();
		}else{
			echo json_encode(array('status'=>201,'msg'=>'操作失败'));
			exit();
		}
	}
}