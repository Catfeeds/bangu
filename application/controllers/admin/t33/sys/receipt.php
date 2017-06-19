<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//"合同收据"控制器

class Receipt extends T33_Controller {

public function __construct(){
	parent::__construct ();
	$this->load->model('admin/t33/sys/b_receipt_model','receipt_model');

}
/**
 * 收据列表
 * */
public function index(){
	$this->load->view("admin/t33/receipt/receipt_view");
}

/**
 * 订单列表：接口
 * api_receipt_list
 * */
public function api_receipt_list(){
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
		$return = $this->get_receipt_data($arrData, $from, $page_size);
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


function get_receipt_data($arrData, $from, $page_size){
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

			$result = $this->receipt_model->received_data($whereArr,$from, $page_size);
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
				$whereArr['il.receipt_code='] = $arrData['invoce_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['il.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['il.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}
			$result = $this->receipt_model->receipt_list($whereArr,$from, $page_size);
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
				$whereArr['il.receipt_code='] = $arrData['invoce_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['il.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['il.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}
			$result = $this->receipt_model->receipt_list($whereArr,$from, $page_size);
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
				$whereArr['il.receipt_code='] = $arrData['invoce_sn'];
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
			$result = $this->receipt_model->receipt_list($whereArr,$from, $page_size);
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
			$result = $this->receipt_model->not_received_data($whereArr,$from, $page_size);
			break;
	}
	return $result;
}


//添加收据接口
function add_receipt(){
	$arrData = $this->security->xss_clean($_POST);
	$total_count = count($arrData['prefix']);

	$start_receipt_arr = $arrData['start_receipt_num'];
	$end_receipt_arr = $arrData['end_receipt_num'];
	$prefix_arr = $arrData['prefix'];
	for($j =0 ;$j<$total_count; $j++){

		$prefix_arr[$j] = trim($prefix_arr[$j]);
		if(empty($prefix_arr[$j])){
			echo json_encode(array('status'=>205,'msg'=>'收据前缀必填'));
			exit();
		}

		if(!preg_match('/^\d*$/',$start_receipt_arr[$j]) || !preg_match('/^\d*$/',$end_receipt_arr[$j])){
			echo json_encode(array('status'=>202,'msg'=>'收据起始编号和终止编号只能是0-9数字'));
			exit();
		}
		if(strlen($start_receipt_arr[$j]) != strlen($end_receipt_arr[$j])){
			echo json_encode(array('status'=>203,'msg'=>'收据起始编号和终止编号长度相等'));
			exit();
		}
		if($start_receipt_arr[$j]== $end_receipt_arr[$j]){
			echo json_encode(array('status'=>204,'msg'=>'收据起始编号和终止编号不能相等'));
			exit();
		}
		
		//控制收据代码的唯一性
		$chk_exist=$this->receipt_model->row(array('prefix'=>$prefix_arr[$j]));
		if(!empty($chk_exist)){ //收据前缀相同的时候  新增收据的起始编号要大于 已存在收据的终止编号
			if($start_receipt_arr[$j]<=$chk_exist['end_code'])
			{
				echo json_encode(array('status'=>204,'msg'=>'收据前缀为'.$prefix_arr[$j].'的起始编号已存在'));
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
		$this->db->insert('b_receipt_code',array('code'=>'AAA'));
		$batch_id = $this->db->insert_id();
		$insert_receipt_data = array(
				'batch'=>$batch_id,
				//'receipt_name'=>$arrData['receipt_name'][$i],
				'prefix'	=> $arrData['prefix'][$i],
				'start_code' => $arrData['start_receipt_num'][$i],
				'end_code' => $arrData['end_receipt_num'][$i],
				'num'		=> $arrData['total_num'][$i],
				'use_num' => 0,
				'remark'	=> $arrData['remark'][$i],
				'addtime'	=> date('Y-m-d H:i:s'),
				'employee_id' => $employee_id,
				'employee_name' => $this->session->userdata("employee_loginName"),
				'union_id'	=> $employee['union_id']
			);
		$this->db->insert('b_receipt',$insert_receipt_data);
		$receipt_id = $this->db->insert_id();
		for($j=0; $j<$arrData['total_num'][$i]; $j++){
			$insert_list_data = array(
					'receipt_id'=>$receipt_id,
					'receipt_code' => $arrData['prefix'][$i].sprintf("%0".strlen($arrData['start_receipt_num'][$i]).'d',(int)$arrData['start_receipt_num'][$i]+$j),
					'code' => sprintf("%0".strlen($arrData['start_receipt_num'][$i]).'d',(int)$arrData['start_receipt_num'][$i]+$j)
				);
			$this->db->insert('b_receipt_list',$insert_list_data);
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


//作废收据
function cancel_receipt(){
	$use_id = $this->input->post('hidden_use_id');
	$list_id = $this->input->post('hidden_list_id');
	$cancel_date = $this->input->post('hidden_cancel_date');
	$cancel_remark = $this->input->post('cancel_remark');
	$this->db->trans_begin();//开启事物

	$sql = 'UPDATE b_receipt_use SET cancel_num=cancel_num+1 WHERE id='.$use_id;
	$this->db->query($sql);

	$sql2 = 'UPDATE b_receipt_list SET cancel_status=1,cancel_remark=\''.$cancel_remark.'\', modtime=\''.$cancel_date.'\',employee_id='.$this->session->userdata('employee_id').',employee_name=\''.$this->session->userdata('employee_loginName').'\' WHERE id='.$list_id;
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


//回收收据
function recycle_receipt(){
	$use_id = $this->input->post('use_id');
	$receipt_id = $this->input->post('receipt_id');
	$this->db->trans_begin();//开启事物
	$sql = 'UPDATE b_receipt_use SET is_recover=1 WHERE id='.$use_id;
	$this->db->query($sql);
	$sql2 = 'UPDATE b_receipt_list SET use_id=0,use_status=0 WHERE confirm_status=0 AND cancel_status=0 AND use_id='.$use_id;
	$this->db->query($sql2);
	$recyle_num = $this->db->affected_rows();
	$sql3 = 'UPDATE b_receipt SET use_num=use_num-'.$recyle_num.' WHERE id='.$receipt_id;
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
function get_receipt_list(){
	$use_id = $this->input->post('use_id'); //b_receipt_use表id
	$receipt_id = $this->input->post('receipt_id'); //b_receipt表id
	
	if(!empty($use_id))
	{
	$receipt_use=$this->db->query("select * from b_receipt_use where id=".$use_id)->row_array();
	$whereArr['il.code >='] = $receipt_use['start_code'];
	$whereArr['il.code <='] = $receipt_use['end_code'];
	$whereArr['il.receipt_id ='] = $receipt_use['receipt_id'];
	}
	else if(!empty($receipt_id))
	{
		$whereArr['i.id='] = $receipt_id;
	}
	$result = $this->receipt_model->get_receipt_list($whereArr);
	echo json_encode($result);
}


//查看详情接口
function get_receipt_detail(){
		$receipt_id = $this->input->post('receipt_id');
		$whereArr['ru.receipt_id='] = $receipt_id;
		$whereArr2['id='] = $receipt_id;
		$result = $this->receipt_model->get_use_receipt($whereArr);
		$one_receipt = $this->receipt_model->get_one_receipt($whereArr2);
		 $no_use_receipt = $this->receipt_model->get_no_use_receipt(array('receipt_id='=>$receipt_id,'use_status='=>0));
		$can_use_start_code = sprintf("%0".strlen($one_receipt['start_code'])."d",(int)$one_receipt['start_code'] + $one_receipt['use_num']);
		$one_receipt['can_use_start_code'] = $can_use_start_code;
		$result['receipt'] = $one_receipt;
		$result['no_use_receipt'] = empty($no_use_receipt) ? '' : $no_use_receipt[0];
		echo json_encode($result);
}


//已作废的点击接口
function show_cancel_receipt(){
	$list_id = $this->input->post('list_id');
	$whereArr['il.id='] = $list_id;
	$result = $this->receipt_model->get_receipt_list($whereArr);
	echo json_encode($result[0]);
}

//收据核销
function write_off_receipt(){
	$receipt_ids = $this->input->post('receipt_ids');
	$receipt_ids = trim($receipt_ids,",");
	$submit_date = $this->input->post('submit_date');
	$sql = 'UPDATE b_receipt_list SET cancel_status=0,confirm_status=2,employee_id='.$this->session->userdata('employee_id').',employee_name=\''.$this->session->userdata('employee_loginName').'\',modtime=\''.$submit_date.'\' WHERE id IN('.$receipt_ids.')';
	$res = $this->db->query($sql);
	if($res){
		echo json_encode(array('status'=>200,'msg'=>'核销成功'));
		exit();
	}else{
		echo json_encode(array('status'=>201,'msg'=>'核销成功'));
		exit();
	}
}

//领用收据
function receive_receipt(){

	$arrData = $this->security->xss_clean($_POST);
	$receipt_one=$this->receipt_model->row(array('id'=>$arrData['hidden_receipt_id']));
	
	if(empty($arrData['start_input_code'])||empty($arrData['end_input_code'])){
			echo json_encode(array('status'=>202,'msg'=>'合同起始和结束编号不能为空'));
			exit();
		}
		if(!preg_match('/^\d*$/',$arrData['end_input_code'])||!preg_match('/^\d*$/',$arrData['start_input_code'])){
			echo json_encode(array('status'=>202,'msg'=>'合同起始和结束编号只能是0-9数字'));
			exit();
		}
	if(strlen($arrData['end_input_code']) != strlen($arrData['start_input_code'])){
		echo json_encode(array('status'=>203,'msg'=>'收据起始编号和结束编号长度要相等'));
		exit();
	}
	if($arrData['start_input_code'] > $arrData['end_input_code']){
		echo json_encode(array('status'=>203,'msg'=>'收据结束编号不能小于起始编号'));
		exit();
	}
	if($arrData['end_input_code']>$receipt_one['end_code']){
		echo json_encode(array('status'=>203,'msg'=>'结束编号不能大于收据最大编号'));
		exit();
	}
	if(empty($arrData['choose_expert_id']))
	{
		echo json_encode(array('status'=>203,'msg'=>'请选择领用人'));
		exit();
	}
	
	//判断输入的  起始编号~结束编号之间是否存在已领用的编号
	$use_list=$this->receipt_model->received_data(array('iu.receipt_id ='=>$arrData['hidden_receipt_id'],'iu.is_recover='=>'0'));
	
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
	$real_usenum_sql = 'select count(1) as real_use_num from  b_receipt_list  WHERE receipt_id='.$arrData['hidden_receipt_id'].' AND code>=\''.$arrData['start_input_code'].'\''.' AND code<=\''.$arrData['end_input_code'].'\' AND use_status=0 AND cancel_status=0';
	$real_use=$this->db->query($real_usenum_sql)->row_array();
	$real_use_num=empty($real_use['real_use_num'])?0:$real_use['real_use_num'];
	
	$insert_use_data = array(
		'receipt_id' => $arrData['hidden_receipt_id'],
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
	$this->db->insert('b_receipt_use',$insert_use_data);
	$use_id = $this->db->insert_id();
	$update_list_sql = 'UPDATE b_receipt_list SET use_id='.$use_id.', use_status=1 WHERE receipt_id='.$arrData['hidden_receipt_id'].' AND code>=\''.$arrData['start_input_code'].'\''.' AND code<=\''.$arrData['end_input_code'].'\' AND use_status=0 AND cancel_status=0';
	$this->db->query($update_list_sql);

	$update_receipt_sql = 'UPDATE b_receipt SET use_num=use_num+'.$real_use_num.' WHERE id='.$arrData['hidden_receipt_id'];
	$this->db->query($update_receipt_sql);
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
	$whereArr['receipt_id='] = $arrData['receipt_id'];
	$whereArr['code>='] = $arrData['start_num'];
	$whereArr['code<='] = $arrData['end_num'];
	$whereArr['use_status='] = 0;
	$whereArr['cancel_status='] = 0;
	$result = $this->receipt_model->get_can_use_receipt($whereArr);
	echo json_encode($result);
}



}

/* End of file receipt.php */
