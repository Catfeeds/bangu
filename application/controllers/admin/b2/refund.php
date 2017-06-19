<?php
/**
 * 客人退款申请
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月1日15:15:14
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Refund extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/refund_model', 'refund');
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );

	}

	public function index() {
		$suppliers = $this->refund->get_suppliers();
		$refund_reason = $this->get_dict_data('DICT_CANCEL_REASON');
		$data = array(
				'suppliers'          => $suppliers,
				'refund_reason' => $refund_reason
			);
		$this->load_view('admin/b2/refund', $data);
	}


	function ajax_refund_list(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
        		$post_arr = array();
        		if ($this->input->post('productname') != '') {
				$post_arr['productname']= $this->input->post('productname');
		}
		# 订单编号
		if ($this->input->post('ordersn') != '') {
			$post_arr['ordersn']= $this->input->post('ordersn');
		}
		# 出团日期
		if ($this->input->post('departure_date') != '' && $this->input->post('departure_date') != '出团日期') {
			$post_arr['usedate'] = $this->input->post('departure_date');
		}
		# 供应商
		if ($this->input->post('supplier_id') != '') {
			$post_arr['supplier_id']= $this->input->post('supplier_id') ;
		}
		$pagecount = $this->refund->get_refund_list($post_arr,0,10,$this->expert_id);
		$refund_list = $this->refund->get_refund_list($post_arr,$page, $number,$this->expert_id);
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
	               	"rows" => $refund_list
            		);
		echo json_encode($data);
	}

	function apply_refund($page=1){

		$refund_apply_amount   = $this->input->post('refund_amount');
		$order_amount                = $this->input->post('order_amount');
		$reason 		  = $this->input->post('reason_txt');
		$cancle_reason 	  = $this->input->post('cancle_reason');
		$order_sn 		  = $this->input->post('order_sn');
		$order_id 		  = $this->input->post('order_id');
		$linkmobile 	  = $this->input->post('order_linkmobile');
		$now                               = date('Y-m-d H:i:s');
		if(!is_numeric($refund_apply_amount)){
 			echo json_encode(array('status'=>-7,'msg'=>'申请退款金额只能是数字'));
			exit();
		}
		if(!isset($cancle_reason) || empty($cancle_reason)){
			echo json_encode(array('status'=>-1,'msg'=>'请选择退款原因'));
			exit();
		}
		if($refund_apply_amount<0 || empty($refund_apply_amount)){
			echo json_encode(array('status'=>-1,'msg'=>'申请退款金额不能为负数或为空'));
			exit();
		}
		if($refund_apply_amount-$order_amount>0){
			echo json_encode(array('status'=>-2,'msg'=>'申请退款金额不能大于订单金额'));
			exit();
		}

		if($cancle_reason!=-1){
		      $reason = $this->refund->get_refund_reason($cancle_reason);
		      $insert_refund_arr['orderid'] = $order_id;
		      $insert_refund_arr['cancel_reason'] = $cancle_reason;
		      $insert_refund_arr['cancel_text'] = $reason;
		      $this->db->insert('u_member_order_attach', $insert_refund_arr);
		}else{
		      $insert_refund_arr['orderid'] = $order_id;
		      $insert_refund_arr['cancel_reason'] = -1;
		      $insert_refund_arr['cancel_text'] = $reason;
		      $this->db->insert('u_member_order_attach', $insert_refund_arr);
		}
		$this->refund->insert_order_attach($this->expert_id,$order_id,$reason,$refund_apply_amount,$now);
		$this->refund->update_order_status($order_id);
		$this->refund->insert_member_log($order_id,$this->expert_id);
		$this->order_status_model->update_order_status_cal($order_id);
		$this ->load_model('common/u_sms_template_model' ,'template_model');
		$template = $this->template_model->row(array('msgtype' =>'expert_refund_apply'));
		$e_msg = str_replace("{#ORDERSN#}", $order_sn ,$template['msg']);
		$this ->send_message($this ->session ->userdata('e_mobile'), $e_msg);
		$template = $this->template_model->row(array('msgtype' =>'member_refund_apply'));
		$m_msg = str_replace("{#ORDERSN#}", $order_sn ,$template['msg']);
		$this ->send_message($linkmobile, $m_msg);
		echo json_encode(array('status'=>1,'msg'=>'申请成功'));
	}
}