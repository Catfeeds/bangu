<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//"合同发票"控制器

class Invoice extends T33_Controller {

public function __construct(){
	parent::__construct ();
	$this->load->model('admin/t33/sys/b_invoice_model','invoice_model');

}
/**
 * 发票列表
 * */
public function index(){
	$this->load->view("admin/t33/invoice/invoice_view");
}

/**
 * 发票列表：接口
 * api_invoice_list
 * */
public function api_invoice_list(){
	$arrData = $this->security->xss_clean($_POST);
	$employee_id=$this->session->userdata("employee_id");
	if(empty($employee_id)){
		$this->__errormsg('请先登录');
	}else{
		//分页
		$page = $arrData['page'];
		$page_size = sys_constant::B_PAGE_SIZE;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$return = $this->get_invoce_data($arrData, $from, $page_size);
		$result=$return['result'];
		$total_page=ceil ( $return['rows']/$page_size );
		if(empty($result))  $this->__data($result);
		$output=array(
				'page_size'=>$page_size,
				'page'=>$page,
				'total_rows'=>$return['rows'],
				'total_page'=>$total_page,
				'sql'=>$return['sql'],
				'result'=>$result
		);
		$this->__data($output);
	}
}


function get_invoce_data($arrData, $from, $page_size){
	$this->load->model('admin/t33/b_employee_model','b_employee_model');
	$type = $arrData['type'];
	$whereArr = array();
	$employee_id=$this->session->userdata("employee_id");
	$employee=$this->b_employee_model->row(array('id'=>$employee_id));
	$union_id=$employee['union_id'];
	$whereArr['i.union_id='] = $union_id;
	switch($type){
		case "1":
			if(!empty($arrData['receive_depart'])){
				$whereArr['iu.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			if(!empty($arrData['start_num'])){
				$whereArr['i.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['i.num<='] = $arrData['end_num'];
			}

			if(!empty($arrData['start_receive_date'])){
				$whereArr['iu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['iu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['prefix'])){
				$whereArr['i.prefix='] = $arrData['prefix'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['iu.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			$result = $this->invoice_model->received_data($whereArr,$from, $page_size);
			break;
		case "2":
		//echo json_encode($type);exit();
			$whereArr['il.confirm_status='] = 1;
			$whereArr['il.cancel_status='] = 0;
			if(!empty($arrData['receive_depart'])){
				$whereArr['il.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			/*if(!empty($arrData['start_num'])){
				$whereArr['i.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['i.num<='] = $arrData['end_num'];
			}*/

			if(!empty($arrData['start_receive_date'])){
				$whereArr['iu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['iu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['invoce_sn'])){
				$whereArr['il.invoice_code='] = $arrData['invoce_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['il.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['il.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}
			$result = $this->invoice_model->invoice_list($whereArr,$from, $page_size);
			break;
		case "3":
			$whereArr['il.confirm_status='] = 2;
			$whereArr['il.cancel_status='] = 0;
			if(!empty($arrData['receive_depart'])){
				$whereArr['il.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			/*if(!empty($arrData['start_num'])){
				$whereArr['i.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['i.num<='] = $arrData['end_num'];
			}*/

			if(!empty($arrData['start_receive_date'])){
				$whereArr['iu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['iu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['invoce_sn'])){
				$whereArr['il.invoice_code='] = $arrData['invoce_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['il.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['il.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}
			$result = $this->invoice_model->invoice_list($whereArr,$from, $page_size);
			break;
		case "4":
			$whereArr['il.cancel_status='] = 1;
			$whereArr['il.confirm_status!='] = 2;
			if(!empty($arrData['receive_depart'])){
				$whereArr['il.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			if(!empty($arrData['start_receive_date'])){
				$whereArr['iu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['iu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['invoce_sn'])){
				$whereArr['il.invoice_code='] = $arrData['invoce_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['il.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['il.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}

			if(!empty($arrData['prefix'])){
				$whereArr['i.prefix='] = $arrData['prefix'];
			}
			$result = $this->invoice_model->invoice_list($whereArr,$from, $page_size);
			break;
		default:
			if(!empty($arrData['input_people'])){
				$whereArr['i.employee_name like'] = '%'.$arrData['input_people'].'%';
			}
			if(!empty($arrData['start_num'])){
				$whereArr['i.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['i.num<='] = $arrData['end_num'];
			}

			if(!empty($arrData['start_input_date'])){
				$whereArr['i.addtime>='] = $arrData['start_input_date'].'00:00:00';
			}
			if(!empty($arrData['end_input_date'])){
				$whereArr['i.addtime<='] = $arrData['end_input_date'].'23:59:59';
			}
			if(!empty($arrData['prefix'])){
				$whereArr['i.prefix='] = $arrData['prefix'];
			}
			$result = $this->invoice_model->not_received_data($whereArr,$from, $page_size);
			break;
	}
	return $result;
}


//添加发票接口
function add_invoice(){
	$arrData = $this->security->xss_clean($_POST);
	$total_count = count($arrData['invoice_name']);

	$start_invoice_arr = $arrData['start_invoice_num'];
	$end_invoice_arr = $arrData['end_invoice_num'];
	$prefix_arr = $arrData['prefix'];
	for($j =0 ;$j<$total_count; $j++){

		$prefix_arr[$j] = trim($prefix_arr[$j]);
		if(empty($prefix_arr[$j])){
			echo json_encode(array('status'=>205,'msg'=>'发票前缀必填'));
			exit();
		}

		if(!preg_match('/^\d*$/',$start_invoice_arr[$j]) || !preg_match('/^\d*$/',$end_invoice_arr[$j])){
			echo json_encode(array('status'=>202,'msg'=>'发票起始编号和终止编号只能是0-9数字'));
			exit();
		}
		if(strlen($start_invoice_arr[$j]) != strlen($end_invoice_arr[$j])){
			echo json_encode(array('status'=>203,'msg'=>'发票起始编号和终止编号长度相等'));
			exit();
		}
		if($start_invoice_arr[$j]== $end_invoice_arr[$j]){
			echo json_encode(array('status'=>204,'msg'=>'发票起始编号和终止编号不能相等'));
			exit();
		}
		
		//控制发票代码的唯一性
		$chk_exist=$this->invoice_model->row(array('prefix'=>$prefix_arr[$j]));
		if(!empty($chk_exist)){ //发票前缀相同的时候  新增发票的起始编号要大于 已存在发票的终止编号
			if($start_invoice_arr[$j]<=$chk_exist['end_code'])
			{
				echo json_encode(array('status'=>204,'msg'=>'发票前缀为'.$prefix_arr[$j].'的起始编号已存在'));
				exit();
			}
		}
		
	}

	$this->load->model('admin/t33/b_employee_model','b_employee_model');

	$employee_id = $this->session->userdata("employee_id");
	$employee=$this->b_employee_model->row(array('id'=>$employee_id));
	$union_id=$employee['union_id'];
	$this->db->trans_begin();//开启事物
	for($i=0; $i<$total_count; $i++){
		$this->db->insert('b_invoice_code',array('code'=>'AAA'));
		$batch_id = $this->db->insert_id();
		$insert_invoice_data = array(
				'batch'=>$batch_id,
				'invoice_name'=>$arrData['invoice_name'][$i],
				'prefix'	=> $arrData['prefix'][$i],
				'start_code' => $arrData['start_invoice_num'][$i],
				'end_code' => $arrData['end_invoice_num'][$i],
				'num'		=> $arrData['total_num'][$i],
				'use_num' => 0,
				'remark'	=> $arrData['remark'][$i],
				'addtime'	=> date('Y-m-d H:i:s'),
				'employee_id' => $employee_id,
				'employee_name' => $this->session->userdata("employee_loginName"),
				'union_id'	=> $employee['union_id']
			);
		$this->db->insert('b_invoice',$insert_invoice_data);
		$invoice_id = $this->db->insert_id();
		for($j=0; $j<$arrData['total_num'][$i]; $j++){
			$insert_list_data = array(
					'invoice_id'=>$invoice_id,
					'invoice_code' => $arrData['prefix'][$i].sprintf("%0".strlen($arrData['start_invoice_num'][$i]).'d',(int)$arrData['start_invoice_num'][$i]+$j),
					'code' => sprintf("%0".strlen($arrData['start_invoice_num'][$i]).'d',(int)$arrData['start_invoice_num'][$i]+$j)
				);
			$this->db->insert('b_invoice_list',$insert_list_data);
		}
	}
	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
		echo json_encode(array('status'=>201,'msg'=>'提交失败'));
		exit();
	}else{
		$this->db->trans_commit();
		echo json_encode(array('status'=>200,'msg'=>'提交成功'));
		exit();
	}
}


//作废发票
function cancel_invoice(){
	$use_id = $this->input->post('hidden_use_id');
	$list_id = $this->input->post('hidden_list_id');
	$cancel_date = $this->input->post('hidden_cancel_date');
	$cancel_remark = $this->input->post('cancel_remark');
	$this->db->trans_begin();//开启事物

	$sql = 'UPDATE b_invoice_use SET cancel_num=cancel_num+1 WHERE id='.$use_id;
	$this->db->query($sql);

	$sql2 = 'UPDATE b_invoice_list SET cancel_status=1,cancel_remark=\''.$cancel_remark.'\', modtime=\''.$cancel_date.'\',employee_id='.$this->session->userdata('employee_id').',employee_name=\''.$this->session->userdata('employee_loginName').'\' WHERE id='.$list_id;
	$this->db->query($sql2);
	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
		echo json_encode(array('status'=>201,'msg'=>'操作失败'));
		exit();
	}else{
		$this->db->trans_commit();
		echo json_encode(array('status'=>200,'msg'=>'已作废'));
		exit();
	}
}


//回收发票
function recycle_invoice(){
	$use_id = $this->input->post('use_id');
	$invoice_id = $this->input->post('invoice_id');
	$this->db->trans_begin();//开启事物
	$sql = 'UPDATE b_invoice_use SET is_recover=1 WHERE id='.$use_id;
	$this->db->query($sql);
	$sql2 = 'UPDATE b_invoice_list SET use_id=0,use_status=0 WHERE confirm_status=0 AND cancel_status=0 AND use_id='.$use_id;
	$this->db->query($sql2);
	$recyle_num = $this->db->affected_rows();
	$sql3 = 'UPDATE b_invoice SET use_num=use_num-'.$recyle_num.' WHERE id='.$invoice_id;
	$this->db->query($sql3);
	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
		echo json_encode(array('status'=>201,'msg'=>'收回失败'));
		exit();
	}else{
		$this->db->trans_commit();
		echo json_encode(array('status'=>200,'msg'=>'收回成功'));
		exit();
	}
}


//点击前缀显示列表接口
function get_invoice_list(){
	$use_id = $this->input->post('use_id'); //b_invoice_use表id
	$invoice_id = $this->input->post('invoice_id'); //b_invoice表id
	if(!empty($use_id))
	{
	$invoice_use=$this->db->query("select * from b_invoice_use where id=".$use_id)->row_array();
	$whereArr['il.code >='] = $invoice_use['start_code'];
	$whereArr['il.code <='] = $invoice_use['end_code'];
	$whereArr['il.invoice_id ='] = $invoice_use['invoice_id'];
	}
	else if(!empty($invoice_id))
	{
		$whereArr['i.id='] = $invoice_id;
	}
	$result = $this->invoice_model->get_invoice_list($whereArr);
	echo json_encode($result);
}


//查看详情接口
function get_invoice_detail(){
		$invoice_id = $this->input->post('invoice_id');
		$whereArr['iu.invoice_id='] = $invoice_id;
		$whereArr2['id='] = $invoice_id;
		$result = $this->invoice_model->get_use_invoice($whereArr);
		$one_invoice = $this->invoice_model->get_one_invoice($whereArr2);
		$no_use_invoice = $this->invoice_model->get_no_use_invoice(array('invoice_id='=>$invoice_id,'use_status='=>0));
		$can_use_start_code = sprintf("%0".strlen($one_invoice['start_code'])."d",(int)$one_invoice['start_code'] + $one_invoice['use_num']);
		$one_invoice['can_use_start_code'] = $can_use_start_code;
		$result['invoice'] = $one_invoice;
		$result['no_use_invoice'] = empty($no_use_invoice) ? '' : $no_use_invoice[0];
		echo json_encode($result);
}


//已作废的点击接口
function show_cancel_invoice(){
	$list_id = $this->input->post('list_id');
	$whereArr['il.id='] = $list_id;
	$result = $this->invoice_model->get_invoice_list($whereArr);
	echo json_encode($result[0]);
}

//发票核销
function write_off_invoice(){
	$invoice_ids = $this->input->post('invoice_ids');
	$invoice_ids = trim($invoice_ids,",");
	$submit_date = $this->input->post('submit_date');
	$sql = 'UPDATE b_invoice_list SET cancel_status=0,confirm_status=2,employee_id='.$this->session->userdata('employee_id').',employee_name=\''.$this->session->userdata('employee_loginName').'\',modtime=\''.$submit_date.'\' WHERE id IN('.$invoice_ids.')';
	$res = $this->db->query($sql);
	if($res){
		echo json_encode(array('status'=>200,'msg'=>'核销成功'));
		exit();
	}else{
		echo json_encode(array('status'=>201,'msg'=>'核销成功'));
		exit();
	}
}

//领用发票
function receive_invoice(){

	$arrData = $this->security->xss_clean($_POST);
	$invoice_one=$this->invoice_model->row(array('id'=>$arrData['hidden_invoice_id']));
	
	if(empty($arrData['start_input_code'])||empty($arrData['end_input_code'])){
		echo json_encode(array('status'=>202,'msg'=>'发票起始和结束编号不能为空'));
		exit();
	}
	if(!preg_match('/^\d*$/',$arrData['end_input_code'])||!preg_match('/^\d*$/',$arrData['start_input_code'])){
			echo json_encode(array('status'=>202,'msg'=>'发票起始和结束编号只能是0-9数字'));
			exit();
	}
	if(strlen($arrData['end_input_code']) != strlen($arrData['start_input_code'])){
		echo json_encode(array('status'=>203,'msg'=>'发票起始编号和结束编号长度要相等'));
		exit();
	}
	if($arrData['start_input_code']>$arrData['end_input_code']){
		echo json_encode(array('status'=>203,'msg'=>'发票结束编号不能小于起始编号'));
		exit();
	}
	if($arrData['end_input_code']>$invoice_one['end_code']){
		echo json_encode(array('status'=>203,'msg'=>'结束编号不能大于发票最大编号'));
		exit();
	}
	
	if(empty($arrData['choose_expert_id']))
	{
		echo json_encode(array('status'=>203,'msg'=>'请选择领用人'));
		exit();
	}
	
	//判断输入的  起始编号~结束编号之间是否存在已领用的编号
	$use_list=$this->invoice_model->received_data(array('iu.invoice_id ='=>$arrData['hidden_invoice_id'],'iu.is_recover='=>'0'));

	if(!empty($use_list['result'])){
		foreach ($use_list['result'] as $key=>$v){
			if($arrData['start_input_code']<=$v['use_end_code']&&$arrData['start_input_code']>=$v['use_start_code']){
				echo json_encode(array('status'=>203,'msg'=>'编号'.$arrData['start_input_code'].' ~ '.$arrData['end_input_code'].'之间存在已领用的编号'));
				exit();
			}
			
		}
	}
	
	$this->db->trans_begin();//开启事物
	
	//获取真正领取的数量   $arrData['choose_use_num']= 已经领用过的 + 没领用过的   ；  领用过的不能重复领用
	$real_usenum_sql = 'select count(1) as real_use_num from  b_invoice_list  WHERE invoice_id='.$arrData['hidden_invoice_id'].' AND code>=\''.$arrData['start_input_code'].'\''.' AND code<=\''.$arrData['end_input_code'].'\' AND use_status=0 AND cancel_status=0';
	$real_use=$this->db->query($real_usenum_sql)->row_array();
	$real_use_num=empty($real_use['real_use_num'])?0:$real_use['real_use_num'];
	
	$insert_use_data = array(
		'invoice_id' => $arrData['hidden_invoice_id'],
		'employee_id' =>$this->session->userdata('employee_id'),
		'employee_name' => $this->session->userdata('employee_loginName'),
		'addtime' => $arrData['hidden_assign_date'],
		'start_code' => $arrData['start_input_code'],
		'end_code' => $arrData['end_input_code'],
		'expert_id' => $arrData['choose_expert_id'],
		'expert_name' => $arrData['choose_receive_people'],
		'depart_id' => $arrData['choose_depart_id'],
		'depart_name' => $arrData['choose_depart_name'],
		'depart_list' => explode(',',$arrData['choose_depart_list'])[0].',',
		'num'		 => $real_use_num // 取代 $arrData['choose_use_num']
		);
	$this->db->insert('b_invoice_use',$insert_use_data);
	$use_id = $this->db->insert_id();
	$update_list_sql = 'UPDATE b_invoice_list SET use_id='.$use_id.', use_status=1 WHERE invoice_id='.$arrData['hidden_invoice_id'].' AND code>=\''.$arrData['start_input_code'].'\''.' AND code<=\''.$arrData['end_input_code'].'\' AND use_status=0 AND cancel_status=0';
	$this->db->query($update_list_sql);

	$update_invoice_sql = 'UPDATE b_invoice SET use_num=use_num+'.$real_use_num.' WHERE id='.$arrData['hidden_invoice_id'];
	$this->db->query($update_invoice_sql);
	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
		echo json_encode(array('status'=>201,'msg'=>'领用失败'));
		exit();
	}else{
		$this->db->trans_commit();
		echo json_encode(array('status'=>200,'msg'=>'领用成功'));
		exit();
	}
}

//选择营业部的管家
public function get_union_expert_data() {
	$this->load->model('admin/t33/b_employee_model','b_employee_model');
	$employee_id = $this->session->userdata("employee_id");
	$employee=$this->b_employee_model->row(array('id'=>$employee_id));
	$union_id=$employee['union_id'];
	$sql = 'SELECT * FROM u_expert WHERE union_id='.$union_id;
	$query = $this->db->query($sql);
	$result=$query->result_array();
	echo json_encode($result);
}

//获取实际的使用能用的数量
function get_can_use(){
	$arrData = $this->security->xss_clean($_POST);
	$whereArr['invoice_id='] = $arrData['invoice_id'];
	$whereArr['code>='] = $arrData['start_num'];
	$whereArr['code<='] = $arrData['end_num'];
	$whereArr['use_status='] = 0;
	$whereArr['cancel_status='] = 0;
	$result = $this->invoice_model->get_can_use_invoice($whereArr);
	echo json_encode($result);
}



}

/* End of file invoice.php */
