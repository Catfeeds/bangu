<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//"合同合同"控制器

class Contract extends T33_Controller {

	public function __construct(){
	parent::__construct ();
	$this->load->model('admin/t33/sys/b_contract_model','contract_model');

}
	/**
	 * 合同列表
	 * */
	public function index(){
			$this->load->view("admin/t33/contract/contract_view");
	}


	/**
 * 合同列表：接口
 * api_contract_list
 * */
public function api_contract_list(){
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
		$return = $this->get_contract_data($arrData, $from, $page_size);
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


function get_contract_data($arrData, $from, $page_size){
	$this->load->model('admin/t33/b_employee_model','b_employee_model');
	$type = $arrData['type'];
	$whereArr = array();
	$employee_id=$this->session->userdata("employee_id");
	$employee=$this->b_employee_model->row(array('id'=>$employee_id));
	$union_id=$employee['union_id'];
	$whereArr['c.union_id='] = $union_id;
	switch($type){
		case "1":
			if(!empty($arrData['receive_depart'])){
				$whereArr['cu.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			if(!empty($arrData['start_num'])){
				$whereArr['c.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['c.num<='] = $arrData['end_num'];
			}

			if(!empty($arrData['start_receive_date'])){
				$whereArr['cu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['cu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['prefix'])){
				$whereArr['c.prefix='] = $arrData['prefix'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['cu.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			$result = $this->contract_model->received_data($whereArr,$from, $page_size);
			break;
		case "2":
		//echo json_encode($type);exit();
			$whereArr['cl.confirm_status='] = 1;
			$whereArr['cl.cancel_status='] = 0;
			if(!empty($arrData['receive_depart'])){
				$whereArr['cl.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			/*if(!empty($arrData['start_num'])){
				$whereArr['i.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['i.num<='] = $arrData['end_num'];
			}*/

			if(!empty($arrData['start_receive_date'])){
				$whereArr['cu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['cu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['contract_sn'])){
				$whereArr['cl.contract_code='] = $arrData['contract_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['cl.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['cl.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}
			$result = $this->contract_model->contract_list($whereArr,$from, $page_size);
			break;
		case "3":
			$whereArr['cl.confirm_status='] = 2;
			$whereArr['cl.cancel_status='] = 0;
			if(!empty($arrData['receive_depart'])){
				$whereArr['cl.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			/*if(!empty($arrData['start_num'])){
				$whereArr['i.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['i.num<='] = $arrData['end_num'];
			}*/

			if(!empty($arrData['start_receive_date'])){
				$whereArr['cu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['cu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['contract_sn'])){
				$whereArr['cl.contract_code='] = $arrData['contract_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['cl.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['cl.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}
			$result = $this->contract_model->contract_list($whereArr,$from, $page_size);
			break;
		case "4":
			$whereArr['cl.cancel_status='] = 1;
			$whereArr['cl.confirm_status!='] = 2;
			if(!empty($arrData['receive_depart'])){
				$whereArr['cl.depart_name like'] = '%'.$arrData['receive_depart'].'%';
			}
			if(!empty($arrData['start_receive_date'])){
				$whereArr['cu.addtime>='] = $arrData['start_receive_date'].'00:00:00';
			}
			if(!empty($arrData['end_receive_date'])){
				$whereArr['cu.addtime<='] = $arrData['end_receive_date'].'23:59:59';
			}
			if(!empty($arrData['contract_sn'])){
				$whereArr['cl.contract_code='] = $arrData['contract_sn'];
			}

			if(!empty($arrData['receive_people'])){
				$whereArr['cl.expert_name like'] = '%'.$arrData['receive_people'].'%';
			}

			if(!empty($arrData['order_sn'])){
				$whereArr['cl.ordersn like'] = '%'.$arrData['order_sn'].'%';
			}

			if(!empty($arrData['prefix'])){
				$whereArr['c.prefix='] = $arrData['prefix'];
			}
			$result = $this->contract_model->contract_list($whereArr,$from, $page_size);
			break;
		default:
			if(!empty($arrData['input_people'])){
				$whereArr['c.employee_name like'] = '%'.$arrData['input_people'].'%';
			}
			if(!empty($arrData['start_num'])){
				$whereArr['c.num>='] = $arrData['start_num'];
			}
			if(!empty($arrData['end_num'])){
				$whereArr['c.num<='] = $arrData['end_num'];
			}

			if(!empty($arrData['start_input_date'])){
				$whereArr['c.addtime>='] = $arrData['start_input_date'].'00:00:00';
			}
			if(!empty($arrData['end_input_date'])){
				$whereArr['c.addtime<='] = $arrData['end_input_date'].'23:59:59';
			}
			if(!empty($arrData['prefix'])){
				$whereArr['c.prefix='] = $arrData['prefix'];
			}
			$result = $this->contract_model->not_received_data($whereArr,$from, $page_size);
			break;
	}
	return $result;
}


//添加合同接口
function add_contract(){
	$arrData = $this->security->xss_clean($_POST);
	$total_count = count($arrData['contract_name']);

	$start_contract_num = $arrData['start_contract_num'];
	$end_contract_num = $arrData['end_contract_num'];
	$prefix_arr = $arrData['prefix'];
	for($j =0 ;$j<$total_count; $j++){

		$prefix_arr[$j] = trim($prefix_arr[$j]);
		if(empty($prefix_arr[$j])){
			echo json_encode(array('status'=>205,'msg'=>'合同前缀必填'));
			exit();
		}

		if(!preg_match('/^\d*$/',$start_contract_num[$j]) || !preg_match('/^\d*$/',$end_contract_num[$j])){
			echo json_encode(array('status'=>202,'msg'=>'合同起始编号和终止编号只能是0-9数字'));
			exit();
		}

		if(strlen($start_contract_num[$j]) != strlen($end_contract_num[$j])){
			echo json_encode(array('status'=>203,'msg'=>'合同起始编号和终止编号长度相等'));
			exit();
		}

		if($start_contract_num[$j]== $end_contract_num[$j]){
			echo json_encode(array('status'=>204,'msg'=>'合同起始编号和终止编号不能相等'));
			exit();
		}
		
		//控制合同代码的唯一性
		$chk_exist=$this->contract_model->row(array('prefix'=>$prefix_arr[$j]));
		if(!empty($chk_exist)){ //合同前缀相同的时候  新增合同的起始编号要大于 已存在合同的终止编号
			if($start_contract_num[$j]<=$chk_exist['end_code'])
			{
				echo json_encode(array('status'=>204,'msg'=>'合同前缀为'.$prefix_arr[$j].'的起始编号已存在'));
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
		$this->db->insert('b_contract_code',array('code'=>'AAA'));
		$batch_id = $this->db->insert_id();
		$insert_contract_data = array(
				'batch'=>$batch_id,
				'contract_name'=>$arrData['contract_name'][$i],
				'prefix'	=> $arrData['prefix'][$i],
				'start_code' => $arrData['start_contract_num'][$i],
				'end_code' => $arrData['end_contract_num'][$i],
				'num'		=> $arrData['total_num'][$i],
				'use_num' => 0,
				'remark'	=> $arrData['remark'][$i],
				'addtime'	=> date('Y-m-d H:i:s'),
				'employee_id' => $employee_id,
				'employee_name' => $this->session->userdata("employee_loginName"),
				'union_id'	=> $employee['union_id']
			);
		$this->db->insert('b_contract',$insert_contract_data);
		$invoice_id = $this->db->insert_id();
		for($j=0; $j<$arrData['total_num'][$i]; $j++){
			$insert_list_data = array(
					'contract_id'=>$invoice_id,
					'contract_code' => $arrData['prefix'][$i].sprintf("%0".strlen($arrData['start_contract_num'][$i]).'d',(int)$arrData['start_contract_num'][$i]+$j),

					'code' => sprintf("%0".strlen($arrData['start_contract_num'][$i]).'d',(int)$arrData['start_contract_num'][$i]+$j)
				);
			$this->db->insert('b_contract_list',$insert_list_data);
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


//作废合同
function cancel_contract(){
	$use_id = $this->input->post('hidden_use_id');
	$list_id = $this->input->post('hidden_list_id');
	$cancel_date = $this->input->post('hidden_cancel_date');
	$cancel_remark = $this->input->post('cancel_remark');
	$this->db->trans_begin();//开启事物

	$sql = 'UPDATE b_contract_use SET cancel_num=cancel_num+1 WHERE id='.$use_id;
	$this->db->query($sql);

	$sql2 = 'UPDATE b_contract_list SET cancel_status=1,cancel_remark=\''.$cancel_remark.'\', modtime=\''.$cancel_date.'\',employee_id='.$this->session->userdata('employee_id').',employee_name=\''.$this->session->userdata('employee_loginName').'\' WHERE id='.$list_id;
	$this->db->query($sql2);
	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
		echo json_encode(array('status'=>201,'msg'=>'提交失败'));
		exit();
	}else{
		$this->db->trans_commit();
		echo json_encode(array('status'=>200,'msg'=>'已作废'));
		exit();
	}
}


//回收合同
function recycle_contract(){
	$use_id = $this->input->post('use_id');
	$contract_id = $this->input->post('contract_id');
	$this->db->trans_begin();//开启事物
	$sql = 'UPDATE b_contract_use SET is_recover=1 WHERE id='.$use_id;
	$this->db->query($sql);

	$sql2 = 'UPDATE b_contract_list SET use_status=0, use_id=0 WHERE confirm_status=0 AND cancel_status=0 AND use_id='.$use_id;
	$this->db->query($sql2);
	$recyle_num = $this->db->affected_rows();
	$sql3 = 'UPDATE b_contract SET use_num=use_num-'.$recyle_num.' WHERE id='.$contract_id;
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
function get_contract_list(){
	$use_id = $this->input->post('use_id'); //b_contract_use表id
	$contract_id = $this->input->post('contract_id'); //b_contract表id
	if(!empty($use_id))
	{
	$contract_use=$this->db->query("select * from b_contract_use where id=".$use_id)->row_array();
	$whereArr['cl.code >='] = $contract_use['start_code'];
	$whereArr['cl.code <='] = $contract_use['end_code'];
	$whereArr['cl.contract_id ='] = $contract_use['contract_id'];
	}
	else if(!empty($contract_id))
	{
		$whereArr['c.id='] = $contract_id;
	}
	$result = $this->contract_model->get_contract_list($whereArr);
	echo json_encode($result);
}


//查看详情接口
function get_contract_detail(){
		$contract_id = $this->input->post('contract_id');
		$whereArr['cu.contract_id='] = $contract_id;
		$whereArr2['id='] = $contract_id;
		$result = $this->contract_model->get_use_contract($whereArr);
		$one_contract = $this->contract_model->get_one_contract($whereArr2);
		$no_use_invoice = $this->contract_model->get_no_use_contract(array('contract_id='=>$contract_id,'use_status='=>0));
		$can_use_start_code = sprintf("%0".strlen($one_contract['start_code'])."d",(int)$one_contract['start_code'] + $one_contract['use_num']);
		$one_contract['can_use_start_code'] = $can_use_start_code;
		$result['contract'] = $one_contract;
		$result['no_use_contract'] = empty($no_use_invoice) ? '' : $no_use_invoice[0];
		echo json_encode($result);
}


//已作废的点击接口
function show_cancel_contract(){
	$list_id = $this->input->post('list_id');
	$whereArr['cl.id='] = $list_id;
	$result = $this->contract_model->get_contract_list($whereArr);
	echo json_encode($result[0]);
}

//合同核销
function write_off_cantract(){
	$contract_ids = $this->input->post('contract_ids');
	$contract_ids = trim($contract_ids,",");
	$submit_date = $this->input->post('submit_date');
	$sql = 'UPDATE b_contract_list SET cancel_status=0,confirm_status=2,employee_id='.$this->session->userdata('employee_id').',employee_name=\''.$this->session->userdata('employee_loginName').'\',modtime=\''.$submit_date.'\' WHERE id IN('.$contract_ids.')';
	$res = $this->db->query($sql);
	if($res){
		echo json_encode(array('status'=>200,'msg'=>'核销成功'));
		exit();
	}else{
		echo json_encode(array('status'=>201,'msg'=>'核销成功'));
		exit();
	}
}

//领用合同
function receive_contract(){

	$arrData = $this->security->xss_clean($_POST);
	$contract_one=$this->contract_model->row(array('id'=>$arrData['hidden_contract_id']));
	
		if(empty($arrData['start_input_code'])||empty($arrData['end_input_code'])){
			echo json_encode(array('status'=>202,'msg'=>'合同起始和结束编号不能为空'));
			exit();
		}
		if(!preg_match('/^\d*$/',$arrData['end_input_code'])||!preg_match('/^\d*$/',$arrData['start_input_code'])){
			echo json_encode(array('status'=>202,'msg'=>'合同起始和结束编号只能是0-9数字'));
			exit();
		}
	  

		if(strlen($arrData['end_input_code']) != strlen($arrData['start_input_code'])){
			echo json_encode(array('status'=>203,'msg'=>'合同起始编号和结束编号长度要相等'));
			exit();
		}
		if($arrData['start_input_code'] > $arrData['end_input_code']){
			echo json_encode(array('status'=>203,'msg'=>'合同结束编号不能小于起始编号'));
			exit();
		}
		if($arrData['end_input_code']>$contract_one['end_code']){
			echo json_encode(array('status'=>203,'msg'=>'结束编号不能大于合同最大编号'));
			exit();
		}
		if(empty($arrData['choose_expert_id']))
		{
			echo json_encode(array('status'=>203,'msg'=>'请选择领用人'));
			exit();
		}
		
		//判断输入的  起始编号~结束编号之间是否存在已领用的编号
		$use_list=$this->contract_model->received_data(array('cu.contract_id ='=>$arrData['hidden_contract_id'],'cu.is_recover='=>'0'));
		
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
	$real_usenum_sql = 'select count(1) as real_use_num from  b_contract_list  WHERE contract_id='.$arrData['hidden_contract_id'].' AND code>=\''.$arrData['start_input_code'].'\''.' AND code<=\''.$arrData['end_input_code'].'\' AND use_status=0 AND cancel_status=0';
	$real_use=$this->db->query($real_usenum_sql)->row_array();
	$real_use_num=empty($real_use['real_use_num'])?0:$real_use['real_use_num'];
	
	$insert_use_data = array(
		'contract_id' => $arrData['hidden_contract_id'],
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
		'num'		 => $real_use_num //取代 $arrData['choose_use_num']
		);
	$this->db->insert('b_contract_use',$insert_use_data);
	$use_id = $this->db->insert_id();
	$update_list_sql = 'UPDATE b_contract_list SET use_id='.$use_id.', use_status=1 WHERE contract_id='.$arrData['hidden_contract_id'].' AND code>=\''.$arrData['start_input_code'].'\''.' AND code<=\''.$arrData['end_input_code'].'\' AND use_status=0 AND cancel_status=0';
	$this->db->query($update_list_sql);

	$update_contract_sql = 'UPDATE b_contract SET use_num=use_num+'.$real_use_num.' WHERE id='.$arrData['hidden_contract_id'];
	$this->db->query($update_contract_sql);
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
	$whereArr['contract_id='] = $arrData['contract_id'];
	$whereArr['code>='] = $arrData['start_num'];
	$whereArr['code<='] = $arrData['end_num'];
	$whereArr['use_status='] = 0;
	$whereArr['cancel_status='] = 0;
	$result = $this->contract_model->get_can_use_contract($whereArr);
	echo json_encode($result);
}

}

/* End of file invoice.php */
