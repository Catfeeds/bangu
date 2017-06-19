<?php
/**
 * 交款管理
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_record extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/credit_record_model', 'credit_record');
	}
	function index() {
		$depart_id = $this->session->userdata('depart_id');
		$data  =array(
				'depart_id'=>$depart_id
				);
		$this->load_view('admin/b2/credit_record_view',$data);
	}

	//申请中的交款记录
	function ajax_credit_record_list(){
		$whereArr = array();
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 10 : $number;
        	$page = empty($page) ? 1 : $page;

        	$starttime = $this->input->post('starttime');
        	$endtime = $this->input->post('endtime');
        	$order_sn = $this->input->post('order_sn');
        	$depart_id = $this->input->post('depart_id');
        	$depart_name = $this->input->post('child_depart');

        	if (!empty($order_sn)){
			$whereArr['md.ordersn like'] = '%'.$order_sn.'%';
		}

		if (!empty($starttime)){
			$whereArr['bl.addtime >='] = $starttime;
		}

		if (!empty($endtime)){
			$whereArr['bl.addtime <='] = $endtime.' 23:59:59';
		}
		//子部门
		/*if (!empty($depart_id)){
			$whereArr['bl.depart_id ='] = $depart_id;
		}elseif(!empty($depart_name)){
			$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
			$departData = $this ->depart_model ->all(array('name like' =>'%'.$depart_name.'%','pid'=>$this->session->userdata('depart_id')));
			if (!empty($departData)) {
				foreach ($departData as $key => $value) {
					$depart_id_str = $value['id'].',';
				}
				$depart_id_str = rtrim($depart_id_str,',');
				$whereArr['bl.depart_id IN'] = $depart_id_str;
			}else{
				echo json_encode($this ->defaultArr);
				exit();
			}
		}*/
		if(empty($depart_id))
			$depart_id=$this->session->userdata('depart_id');
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
		$child=$this->depart_model->all(array('pid'=>$depart_id,'status'=>'1'));
		$child_arr=array();
		if(!empty($child))
		{
			foreach ($child as $k=>$v)
			{
				array_push($child_arr,$v['id']);
			}
		}
		array_push($child_arr, $depart_id);
		$depart_in=implode(",", $child_arr);
		
		
		$record_list = $this->credit_record->get_record_list($whereArr,$page,$number,$depart_in);
		$pagecount = $this->credit_record->get_record_list($whereArr,0,$number,$depart_in);
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
	               	"rows" => $record_list,
	               	"SQL" => $this->db->last_query()
            		);
		echo json_encode($data);
	}
}