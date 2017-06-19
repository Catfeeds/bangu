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
include_once './application/controllers/msg/t33_send_msg.php';
class Pay_manage extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/pay_manage_model', 'pay_manage');
		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load_model('admin/b2/order_manage_model', 'order_manage');
	}
	/*
	 * 交款列表
	 * */
	function index() {
		$depart = $this->pay_manage->get_depart(array('dep.id'=>$this->session->userdata('depart_id')));
		$data = array(
			'real_name'=>$this->session->userdata('real_name'),
			'depart_info'=>$depart
			);
		$expert_info = $expert_info = $expert_info = $this->expert->all('FIND_IN_SET(\''.$this->session->userdata('parent_depart_id').'\',depart_list)>0' );
		$data['expert_info'] = $expert_info;
		$this->load_view('admin/b2/pay_manage_view',$data);
	}

	/*
	 * 交款列表：数据
	 * */
	function ajax_pay_order(){
		$whereArr = array();
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
       	$number = empty($number) ? 10 : $number;
        	$page = empty($page) ? 1 : $page;
        	$receive_status = trim($this ->input ->post('receive_status' ,true));

       	$order_sn = trim($this ->input ->post('order_sn' ,true));
       	$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$receive_status = trim($this ->input ->post('receive_status' ,true));
		$expert = trim($this ->input ->post('expert' ,true));
		$receive_sn =  trim($this ->input ->post('receive_sn' ,true));

		$whereArr['rev.status ='] = $receive_status;

		if (!empty($order_sn)){
			$whereArr['rev.order_sn like'] = '%'.$order_sn.'%';
		}

		/*if (!empty($receive_status) || $receive_status==='0'){
			$whereArr['rev.status ='] = $receive_status;
		}*/

		if (!empty($expert)){
			$whereArr['rev.expert_id ='] = $expert;
		}

		if (!empty($receive_sn)){
			$whereArr['rev.voucher ='] = $receive_sn;
		}

		if (!empty($starttime)){
			$whereArr['app.addtime >='] = $starttime;
		}

		if (!empty($endtime)){
			$whereArr['app.addtime <='] = $endtime.' 23:59:59';
		}

		//$whereArr['md.status !='] = 9;
		//$whereArr['rev.way !='] = '账户余额';

		$pay_order_list = $this->pay_manage->get_pay_list($whereArr,$page,$number);
		$pagecount = $this->pay_manage->get_pay_list($whereArr,0,$number);
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
	               	"rows" => $pay_order_list
            		);
		echo json_encode($data);
	}


	//获取一条交款详情
	function get_one_detail(){
		$receive_id  = $this->input->post('receive_id');
		$res = $this->pay_manage->get_pay_one_data($receive_id);
		echo json_encode($res);
		exit();
	}

	function get_receiv_detail(){
		$item_id  = $this->input->post('item_id');
		$rev_status  = $this->input->post('rev_status');
		$whereArr['ir.item_id'] = $item_id;
		$whereArr['rev.status'] = $rev_status;
		$whereArr['filter_data'] = 'true';
		$res = $this->pay_manage->get_pay_data($whereArr);
		//echo json_encode($this->db->last_query());
		echo json_encode($res);
		exit();
	}

	/*
	 * 新增银行认款：提交处理页面
	 * 场景1：保存，数据保存到 u_order_receivable、u_item_apply、u_item_reveivable
	 * 场景2： 保存并提交，再场景1的基础上，修改u_order_receivable的状态和提交人姓名、发送消息提醒
	 * */
	function new_payment()
	{
			//1、post数据
			$arrData = $this->security->xss_clean($_POST);
			$arrData['pay_date'] = trim($arrData['pay_date']);
			$arrData['pay_amount'] = trim($arrData['pay_amount']);
			$arrData['bank_info'] = trim($arrData['bank_info']);
			$arrData['bank_num'] = trim($arrData['bank_num']);
			$arrData['pay_amount'] = (float)$arrData['pay_amount'];

			//2、验证
			if(empty($arrData['pay_date'])){
				echo json_encode(array('status'=>202,'msg'=>'交款日期必填'));
				exit();
			}
			if ( $arrData['pay_amount']==0 || !preg_match("/^[0-9]+(.[0-9]{1,3})?$/", $arrData['pay_amount'])) {
				echo json_encode(array('status'=>203,'msg'=>'交款金额必填正数'));
				exit();
			}
			
			if($arrData['pay_way']=="转账"){
				if(empty($arrData['bank_info'])){
					echo json_encode(array('status'=>204,'msg'=>'开户银行必填'));
					exit();
				}
				if(empty($arrData['bank_num'])){
					echo json_encode(array('status'=>205,'msg'=>'银行账号必填'));
					exit();
				}
			}
			
			//3、数据处理: u_order_receivable表
			$this->db->trans_begin();//开启事物
			$insert_item_apply = array(
				'expert_id'=>$this->expert_id,
				'money'=>$arrData['pay_amount'],
				'remark'=>$arrData['pay_remark'],
				'addtime'=>$arrData['pay_date'], //date('Y-m-d H:i:s'),
				'status'=>0,
				'depart_id'=>$arrData['depart_id'],
				'way'=>$arrData['pay_way'],
				'bankcard'=>$arrData['bank_num'],
				'bankname'=>$arrData['bank_info'],
				'union_id' => $arrData['union_id'],
				'kind'=>1,
				'from'=>1,
				'code_pic'=>$arrData['single_water_pic']
				);
			if(isset($arrData['is_urgent']) && !empty($arrData['is_urgent'])){
				$insert_item_apply['is_urgent'] = 1;
			}else{
				$insert_item_apply['is_urgent'] = 0;
			}
			//如果是“保存并提交”,则需多做一些操作
			$this->db->insert('code_sk_batch',array('code'=>'A'));
		    $batch_code = $this->db->insert_id();
		    if($arrData['submit_type']=="2")
		    {
		    	$insert_item_apply['batch']=$batch_code;
		    	$insert_item_apply['status']=1;
		    	$insert_item_apply['commit_name']=$this->session->userdata('real_name');
		    }
			$status =  $this->db->insert('u_order_receivable',$insert_item_apply);
			$receive_id = $this->db->insert_id();
			
			//4、数据处理: u_item_apply 表
		   $insert_item_apply = array(
				'expert_id' => $this->expert_id,
				'addtime' => date('Y-m-d H:i:s'),
				'union_id' => $this->session->userdata('union_id'),
				'depart_id' => $this->session->userdata('depart_id'),
				'remark' => $arrData['pay_remark'],
				'status' => 0,
				'amount' =>$arrData['pay_amount']
				);
			$this->db->insert('u_item_apply',$insert_item_apply);
			$apply_item_id = $this->db->insert_id();
			
			//5、数据处理: u_item_receivable 表
			$item_receivable = array(
				'receivable_id'=>$receive_id,
				'item_id'=>$apply_item_id
				);
			$this->db->insert('u_item_receivable',$item_receivable);
			
			//6、submit提交
			if($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				echo json_encode(array('status'=>201,'msg'=>'提交失败'));
				exit();
			}
			else
			{
				$this->db->trans_commit();
				//如果是"保存并提交"，则需发送消息
				if($arrData['submit_type']=="2")
				{
					$msg = new T33_send_msg();
					$msgArr = $msg ->receivableApprove($receive_id,1,$this->session->userdata('real_name'));
					echo json_encode(array('status'=>200,'msg'=>'提交成功,等待审核'));
				}
				else 
				{
					echo json_encode(array('status'=>200,'msg'=>'已保存,请及时提交审核'));
				}
				exit();
			}
	}

	//获取营业部银行信息
	function get_depart_bank(){
		$whereArr  =array();
		$bank = $this->pay_manage->get_depart_bank($whereArr);
		echo json_encode($bank);
		exit();
	}
    /*
     * 交款：提交数据
     * */
	function submit_apply(){
		$arrData = $this->security->xss_clean($_POST);
		$apply_id = rtrim($arrData['receive_ids'],',');
		$receive_ids = $this->pay_manage->get_receive_ids($apply_id);
		//$receive_id_arr = explode(',',$receive_ids);
		//$count_ids = count($receive_id_arr);

		$this->db->trans_begin();//开启事物
		$this->db->insert('code_sk_batch',array('code'=>'A'));
		$batch_code = $this->db->insert_id();
		//$this->db->query('UPDATE u_order_receivable SET status=1,\''.$batch_code.'\',,commit_name=\''.$this->session->userdata('real_name').'\' WHERE id IN ('.$receive_ids['receive_ids'].')');

		$status = $this->db->query('UPDATE u_item_apply SET remark=\''.$arrData['remark'].'\' WHERE id IN ('.$apply_id.')');

		$status = $this->db->query('UPDATE u_order_receivable SET status=1,batch=\''.$batch_code.'\',commit_name=\''.$this->session->userdata('real_name').'\' WHERE id IN ('.$receive_ids['receive_ids'].') AND status=0');
		$receive_rows=$this->db->query("select id,order_id,money from u_order_receivable where id IN (".$receive_ids['receive_ids'].")")->result_array();
		//订单操作日志
		$money_str="";
		if(!empty($receive_rows))
		{
			foreach ($receive_rows as $k=>$v)
			{
				if($k>0&&$k==count($receive_rows)-1)
				    $money_str=$money_str.$v['money'].'元';
				else 
					$money_str=$money_str.$v['money'].'元、';
			}
		}
		$this->order_manage->write_order_log($receive_rows[0]['order_id'],'在交款管理页面，提交交款 '.$money_str.' 到旅行社审核');
		
		/*$insert_item_arr = array(
			'item_code'=>$batch_code,
			'expert_id'=>$this->expert_id,
			'amount'=>$arrData['receive_price'],
			'remark'=>$arrData['remark'],
			'addtime'=>$arrData['submit_date'],
			'status'=>0,
			'union_id'=>$this->session->userdata('union_id'),
			'depart_id'=>$this->session->userdata('depart_id')
			);
		$this->db->insert('u_item_apply',$insert_item_arr);
		$item_id = $this->db->insert_id();
		for($i=0; $i<$count_ids; $i++){
			$this->db->insert('u_item_receivable',array('receivable_id'=>$receive_id_arr[$i],'item_id'=>$item_id));
		}*/
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			//发送消息
			$msg = new T33_send_msg();
			$msgArr = $msg ->receivableApprove($receive_ids['receive_ids'],1,$this->session->userdata('real_name'));
			
			echo json_encode(array('status'=>200,'msg'=>'提交成功,等待审核'));
			exit();
		}
	}

	//重新提交申请
	function resubmit(){
		$apply_id = $this->input->post('apply_id');
		$receive_ids = $this->pay_manage->get_receive_ids($apply_id);
		$this->db->trans_begin();//开启事物
		$this->db->insert('code_sk_batch',array('code'=>'A'));
		$batch_code = $this->db->insert_id();
		$this->db->query('UPDATE u_order_receivable SET status=1,\''.$batch_code.'\',,commit_name=\''.$this->session->userdata('real_name').'\' WHERE id IN ('.$receive_ids['receive_ids'].')');
		//$this->db->query('UPDATE u_item_apply SET status=0 WHERE id='.$apply_id);
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

	function refuse_receive(){
		$receive_id = $this->input->post('receive_id');
		$one_receive = $this->pay_manage->get_pay_one_data($receive_id);
		$this->db->trans_begin();//开启事物
		if($one_receive['way']=='账户余额'){
			//退还额度
			$return_limit_sql = 'UPDATE b_depart SET cash_limit=cash_limit+'.$one_receive['money'].' WHERE id='.$one_receive['depart_id'];
			$this->db->query($return_limit_sql);
			$insert_limit_log = array(
				'refund_monry'=>$one_receive['money'],
				'type'=>'收款拒绝',
				'remark'=>'收款拒绝,返还额度'
				);
			$this->order_manage->write_limit_log($one_receive['order_id'],$insert_limit_log);
		}
		//退还额度
			$update_receive_arr = array(
				'status'=>4
				);
			$this->db->update('u_order_receivable',$update_receive_arr,array('id'=>$receive_id));
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>201,'msg'=>'提交失败'));
				exit();
			}else{
				$this->db->trans_commit();
				echo json_encode(array('status'=>200,'msg'=>'已拒绝'));
				exit();
			}
	}
}