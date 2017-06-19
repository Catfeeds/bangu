<?php
/**
 * 抢定制订单
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年12月28日15:50:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
class Change_Price_Record extends UB2_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/change_price_record_model', 'change_price_record');
	}

          //进入首页,列出数据
	public function index($page=1) {
		$this->view('admin/expert/price_record_view');
	}


	//申请中
	function apply_ing(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 15 : $number;
        		$page = empty($page) ? 1 : $page;
        		$apply_status = $this->input->post('apply_status', true);
		$data_list = $this->change_price_record->get_record_list( $page, $number,$this->expert_id,$apply_status);
		$pagecount = $this->change_price_record->get_record_list(0,10,$this->expert_id,$apply_status);
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
	               	"rows" => $data_list
            		);
		echo json_encode($data);
	}

	//已通过
	function apply_pass(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 15 : $number;
        		$page = empty($page) ? 1 : $page;
        		$apply_status = $this->input->post('apply_status', true);
		$data_list = $this->change_price_record->get_record_list( $page, $number,$this->expert_id,$apply_status);
		$pagecount = $this->change_price_record->get_record_list(0,10,$this->expert_id,$apply_status);
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
	               	"rows" => $data_list
            		);
		echo json_encode($data);
	}

	//已经拒绝
	function apply_refused(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 15 : $number;
        		$page = empty($page) ? 1 : $page;
        		$apply_status = $this->input->post('apply_status', true);
		$data_list = $this->change_price_record->get_record_list( $page, $number,$this->expert_id,$apply_status);
		$pagecount = $this->change_price_record->get_record_list(0,10,$this->expert_id,$apply_status);
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
	               	"rows" => $data_list
            		);
		echo json_encode($data);
	}


}