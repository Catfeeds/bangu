<?php

/**
 * 管家上门服务
 *
 * @copyright		深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年12月02日10:37:11
 * @author		汪晓烽
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
class Expert_Service extends UB2_Controller{
	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/expert_service_model', 'expert_service');
	}

	function index(){
		$data = array();
		$this->view('admin/expert/expert_service_view',$data);
	}


	function service_list(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
       		 $status = $this->input->post('progress', true);

        		$number = empty($number) ? 15 : $number;
        		$page = empty($page) ? 1 : $page;
        		$service_list = $this->expert_service->get_service_list($this->expert_id,$status,$page,$number);
		//$reply_list = $this->grab_custom_order->get_grab_custom_list( $page, $number,$this->expert_id);
		//print_r($this->db->last_query());exit();
		$pagecount = $this->expert_service->get_service_list($this->expert_id,$status,0,$number);
		$this->db->close();
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
	               	"rows" => $service_list
            		);
		echo json_encode($data);

	}


	//接受服务邀请
	function promise(){
		$sr_id = $this->input->post('sr_id', true);
		$service_time = date('Y-m-d H:i:s');
		$sql = "UPDATE u_expert_service_record SET progress=2,service_time='{$service_time}' WHERE id={$sr_id}";
		$status = $this->db->query($sql);
		if($status){
			echo json_encode(array('status'=>200,'msg'=>'操作成功'));
		}else{
			echo json_encode(array('status'=>-200,'msg'=>'操作失败'));
		}
	}

	//完成服务
	function complete_service(){
		$sr_id = $this->input->post('sr_id', true);
		$sql = "UPDATE u_expert_service_record SET progress=3 WHERE id={$sr_id}";
		$status = $this->db->query($sql);
		if($status){
			echo json_encode(array('status'=>200,'msg'=>'操作成功'));
		}else{
			echo json_encode(array('status'=>-200,'msg'=>'操作失败'));
		}
	}

	//拒绝服务
	function refused(){
		$sr_id = $this->input->post('sr_id', true);
		$reason = $this->input->post('refused_reason', true);
		$sql = "UPDATE u_expert_service_record SET progress=-1,refuse='{$reason}' WHERE id={$sr_id}";
		$status = $this->db->query($sql);
		if($status){
			echo json_encode(array('status'=>200,'msg'=>'操作成功'));
		}else{
			echo json_encode(array('status'=>-200,'msg'=>'操作失败'));
		}
	}

}