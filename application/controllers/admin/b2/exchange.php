<?php
/**
 * 专家提现
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月19日16:24:24
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends UB2_Controller {

	public function __construct() {
		parent::__construct();

	}

	/**
	 * 提现
	 * @param number $page	页
	 */
	public function add() {

		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load_model('admin/b2/exchange_model', 'exchange');

		$expert_info = $this->expert->row(array(
				'id' => $this->expert_id));

		$post_arr['amount'] = $this->input->post('amount');
		$available_amount = $this->input->post('available_amount');
		$bank_card = $this->input->post('bank_card');
		$bank_card = trim($bank_card);
		$bank_name = $this->input->post('bank_name');
		$bank_name = trim($bank_name);
		$brand = $this->input->post('brand');
		$brand = trim($brand);
		if(empty($bank_card)){
			echo json_encode(array('status' =>-1 ,'msg' =>'银行卡号不能为空'));exit();
		}
		if(empty($bank_name)){
			echo json_encode(array('status' =>-2 ,'msg' =>'银行名称不能为空'));exit();
		}
		if(empty($brand)){
			echo json_encode(array('status' =>-3 ,'msg' =>'银行支行名称不能为空'));exit();
		}
		#提现金额大于实际可提现金额不可提现
		if ($expert_info['amount'] < $post_arr['amount']) {
			echo json_encode(array('status' =>-3 ,'msg' =>'您填写的提现金额大于可提现金额，请您重新填写'));
			exit();
		}

		$post_arr['exchange_type'] = ROLE_TYPE_EXPERT;
		$post_arr['userid'] = $this->expert_id;
		$post_arr['bankcard'] = $expert_info['bankcard'];
		$post_arr['bankname'] = $expert_info['bankname'];
		$post_arr['brand'] = $expert_info['branch'];
		$post_arr['cardholder'] = $expert_info['cardholder'];
		$post_arr['serial_number'] = 'TX'.date('YmdHis').rand(100,999);
		$post_arr['addtime'] = date('Y-m-d H:i:s', CLIENT_REQUEST_TIME);
		$post_arr['amount_before'] = $expert_info['amount'];
		$post_arr['status'] = 0;
		//$update_expert_amount_sql = 'update u_expert set amount=amount-'.$this->input->post('amount').' where id='.$this->expert_id;

		# 当提取数额大于0时,才允许提现
		if ($post_arr['amount'] > 0 && $available_amount>=$post_arr['amount']) {
			$flag = $this->exchange->insert($post_arr);

			if ($flag){
					$this->exchange->update_expert_amount($this->input->post('amount'),$this->expert_id);
					echo json_encode(array('status' =>1 ,'msg' =>'提现成功'));exit();
				}else{
				echo json_encode(array('status' =>-4 ,'msg' =>'提现失败'));exit();
			}
		}else{
				echo json_encode(array('status' =>-3 ,'msg' =>'您填写的提现金额大于可提现金额，请您重新填写'));
				exit();
		}
	}
	/**
	 * 提现：b端
	 * 分为： 帮游平台提现+旅行社提现
	 */
	public function to_add() 
	{
	    //1传值
		$expert_id = $this->input->post('tx_expert_id');
		$type=$this->input->post('type');  //1是平台提现，2是营业部提现
		$bangu_tx = $this->input->post('bangu_tx'); //帮游平台提现
		$depart_list = $this->input->post('depart_list');  //营业部提现
		
		//2、数据模型
		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load_model('admin/b2/exchange_model', 'exchange');
		$this->load_model('admin/b2/b_depart_model', 'b_depart_model');
		
		//3、平台提现、营业部提现
		$expert_info = $this->expert->row(array('id' => $expert_id));
	
		$this->db->trans_begin();
		if($type=="1")
		{
			$post_arr['exchange_type'] = ROLE_TYPE_EXPERT;
			$post_arr['userid'] = $expert_id;
			$post_arr['bankcard'] = $expert_info['bankcard'];
			$post_arr['bankname'] = $expert_info['bankname'];
			$post_arr['brand'] = $expert_info['branch'];
			$post_arr['cardholder'] = $expert_info['cardholder'];
			$post_arr['serial_number'] = 'TX'.date('YmdHis').rand(100,999);
			$post_arr['addtime'] = date('Y-m-d H:i:s', CLIENT_REQUEST_TIME);
			$post_arr['amount_before'] = $expert_info['amount'];
			$post_arr['amount'] = $bangu_tx;
			$post_arr['status'] = 0;
			$post_arr['approve_type'] = 0; //0是平台审核，非0是旅行社审核
			
			
			if ((int)$expert_info['amount'] < $bangu_tx)
			{
				echo json_encode(array('status' =>-3 ,'msg' =>'您填写的平台账号提现金额大于可提现金额，请您重新填写'));
				exit(); //提现金额大于实际可提现金额不可提现
			}
			
			if($bangu_tx>0)
			{
				
				$flag = $this->exchange->insert($post_arr);
				$this->exchange->update_expert_amount($bangu_tx,$expert_id);
			}
			else 
			{
				echo json_encode(array('status' =>-3 ,'msg' =>'提现金额须大于0'));
				exit(); 
			}
		}
		elseif($type=="2")
		{
			$amount_before=$amount="0";
			foreach ($depart_list as $k=>$v)
			{
				$amount_before+=$v['amount_before'];
				$amount+=$v['amount'];
			}
			
			$post_arr['exchange_type'] = ROLE_TYPE_EXPERT;
			$post_arr['userid'] = $expert_id;
			$post_arr['bankcard'] = $expert_info['bankcard'];
			$post_arr['bankname'] = $expert_info['bankname'];
			$post_arr['brand'] = $expert_info['branch'];
			$post_arr['cardholder'] = $expert_info['cardholder'];
			$post_arr['serial_number'] = 'TX'.date('YmdHis').rand(100,999);
			$post_arr['addtime'] = date('Y-m-d H:i:s', CLIENT_REQUEST_TIME);
			$post_arr['amount_before'] = $amount_before;
			$post_arr['amount'] = $amount;
			$post_arr['status'] = 0;
			$post_arr['approve_type'] = $expert_info['union_id']; //0是平台审核，非0是旅行社审核
			$exchange_id = $this->exchange->insert($post_arr);
			foreach ($depart_list as $k=>$v)
			{
				if($v['amount']>0)
				{
					$insert_data=array(
						'exchange_id'=>$exchange_id,
						'depart_id'=>$v['depart_id'],
						'depart_name'=>$v['depart_name'],
						'amount'=>$v['amount']
					);
					$this->db->insert("u_exchange_depart",$insert_data);
					
					//营业部剩余金额
					$new_money=$v['amount_before']-$v['amount'];
					$this->b_depart_model->update(array('cash_limit'=>$new_money),array('id'=>$v['depart_id']));
					//额度明细日志
					$manage = $this->get_manage();
					$new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
					$log=array(
							'depart_id'=>$v['depart_id'],
							'expert_id'=>$expert_id,
							'union_id'=>$this->session->userdata('union_id'),
							'manager_id'=>$manage['id'],
							'cut_money'=>-$v['amount'],
							'cash_limit'=>$new_depart['cash_limit'],
							'credit_limit'=>$new_depart['credit_limit'],
							'type'=>'提现扣额度',
							'remark'=>'b2:提现扣额度',
							'addtime'=>date('Y-m-d H:i:s')
					);
					$this->db->insert("b_limit_log",$log);
					//end
				}
			}
		}
		
		//提交
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo json_encode(array('status' =>-4 ,'msg' =>'提现失败'));exit();
		}
		else
		{
			$this->db->trans_commit();
			echo json_encode(array('status' =>1 ,'msg' =>'提现成功'));exit();
		}
		
				
	}
	//获取经理ID
	function get_manage(){
		$sql = 'SELECT * FROM u_expert WHERE is_dm=1 AND depart_id='.$this->session->userdata('parent_depart_id');
		$manage = $this->db->query($sql)->result_array();
		return $manage[0];
	}
}