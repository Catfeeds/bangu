<?php
/**
 * @copyright		深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年6月23日09:42:00
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Gross_profit extends UA_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/gross_profit_model', 'gross_profit' );
	}


	public function index(){
		$expert = $this->gross_profit->get_expert();
		$data = array('expert'=>$expert);
		$this->load_view ( 'admin/a/ui/finance/gross_profit',$data);
	}

	function get_ajax_data(){
		$post_arr = array();
		$number = $this->input->post('pageSize', true);
     		$page = $this->input->post('pageNum', true);
     		$expertId = intval($this ->input ->post('expert_id'));
		$realname = trim($this ->input ->post('realname' ,true));
    		$number = empty($number) ? 15 : $number;
    		$page = empty($page) ? 1 : $page;
    		if($this->input->post('productname')!=''){
   			$post_arr['mo.productname LIKE'] = '%'.$this->input->post('productname').'%';
     		}
     		if($this->input->post('order_sn')!=''){
     			$post_arr['mo.ordersn'] = $this->input->post('order_sn');
     		}

     		if($this->input->post('use_date')!=''){
     		$usedata_arr = explode(' - ',$this->input->post('use_date'));
		$start_date_arr = explode('-',$usedata_arr[0]);
		$start_date = $start_date_arr[0].'-'.$start_date_arr[2].'-'.$start_date_arr[1];
		$end_date_arr = explode('-',$usedata_arr[1]);
		$end_date = $end_date_arr[0].'-'.$end_date_arr[2].'-'.$end_date_arr[1];
		$post_arr['mo.usedate >='] = $start_date.' 00:00:00';
		$post_arr['mo.usedate <='] = $end_date.' 23:59:59';
     		}
     		if($this->input->post('expert_id')!=''){
     			$post_arr['e.id'] = $this->input->post('expert_id');
     		}

     		//管家
		if (!empty($expertId)){
			$post_arr['e.id'] = $expertId;
		}elseif (!empty($realname)){
			$post_arr['e.realname like'] = '%'.$realname.'%';
		}

	$gross_profit_list = $this->gross_profit->get_data_list($post_arr, $page, $number);
	$pagecount = count($this->gross_profit->get_data_list($post_arr, 0, $number));
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
               	"rows" => $gross_profit_list,
               	"SQL" =>$this->db->last_query()
          		);
	echo json_encode($data);
}
}