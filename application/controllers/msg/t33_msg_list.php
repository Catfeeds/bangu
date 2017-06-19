<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class T33_msg_list extends MY_Controller {
	public $defaultArr = array(
			'count' =>0,
			'data' =>array()
	);
	
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('msg/msg_send_model' ,'msg_send_model');
		$this ->load_model('msg/msg_point_model' ,'msg_point_model');
		$this ->load_model('msg/msg_main_model' ,'msg_main_model');
		$this ->load_model('msg/msg_send_step_model' ,'send_step_model');
		$this ->load_model('expert_model');
	}

	/**
	 * 管家，供应商，旅行社公用，注意要验证ID的真实性
	 * @method t33系统消息
	 * @author jkr
	 */
	public function msg_list()
	{
		//管家ID
		$expert_id = intval($this ->input ->get('expertid'));
		//供应商ID
		$supplier_id = intval($this ->input ->get('supplier_id'));
		//旅行社员工ID
		$employee_id = intval($this ->input ->get('employee_id'));
		
		//验证是否登录
		if ($expert_id > 0)
		{
			$login_id = $this ->session ->userdata('expert_id');
			if ($expert_id != $login_id)
			{
				return false;
			}
		}
		elseif ($supplier_id > 0)
		{
			$loginData = $this ->session ->userdata('loginSupplier');
			if ($loginData['id'] != $supplier_id)
			{
				return false;
			}
		}
		elseif ($employee_id > 0)
		{
			$login_id = $this->session->userdata('employee_id');
			if ($login_id != $employee_id)
			{
				return false;
			}
		}
		else 
		{
			return false;
		}
		
		$dataArr = array(
				'expert_id' =>$expert_id,
				'supplier_id' =>$supplier_id,
				'employee_id' =>$employee_id
		);
		
		if ($supplier_id > 0)
		{
			$this->load->view('admin/b1/header.html');
			$this->load->view('msg/t33_msg_list' ,$dataArr);
			$this->load->view('admin/b1/footer.html');
		}
		else 
		{
			$this ->load ->view('msg/t33_msg_list' ,$dataArr);
		}
	}
	
	public function getMsgSendData()
	{
		//管家ID
		$expert_id = intval($this ->input ->post('expert_id'));
		//供应商ID
		$supplier_id = intval($this ->input ->post('supplier_id'));
		//旅行社员工ID
		$employee_id = intval($this ->input ->post('employee_id'));
		$status = intval($this ->input ->post('status'));
		$title = trim($this ->input ->post('title' ,true));
		//查询条件数组
		$whereArr = array();
		
		//验证是否登录
		if ($expert_id > 0)
		{
			$login_id = $this ->session ->userdata('expert_id');
			if ($expert_id != $login_id)
			{
				echo json_encode($this ->defaultArr);
			}
			else
			{
				$expertData = $this ->expert_model ->row(array('id' =>$expert_id));
				if ($expertData['is_dm'] == 1)
				{
					//管家是营业部经理的时候，会收到两种身份的信息，1：营业部经理，2：营业部销售
					$whereArr = array(
						'sp.user_type' =>array(1,2),
						'sp.user_id =' =>$expert_id
					);
				}
				else 
				{
					$whereArr = array(
						'sp.user_type =' =>2,
						'sp.user_id =' =>$expert_id
					);
				}
			}
		}
		elseif ($supplier_id > 0)
		{
			$loginData = $this ->session ->userdata('loginSupplier');
			if ($loginData['id'] != $supplier_id)
			{
				echo json_encode($this ->defaultArr);
			}
			else
			{
				$whereArr = array(
						'sp.user_type =' =>3,
						'sp.user_id =' =>$supplier_id
				);
			}
		}
		elseif ($employee_id > 0)
		{
			$login_id = $this->session->userdata('employee_id');
			if ($login_id != $employee_id)
			{
				echo json_encode($this ->defaultArr);
			}
			else
			{
				$whereArr = array(
						'sp.user_type' =>array(4,5,6),
						'sp.user_id =' =>$employee_id
				);
			}
		}
		else
		{
			echo json_encode($this ->defaultArr);
		}
		if (!empty($title))
		{
			$whereArr ['ms.title like'] = '%'.$title.'%';
		}
		
		if ($status == 0 || $status ==1 || $status ==2)
		{
			$whereArr ['ms.status ='] = $status;
		}
		
		$data = $this ->msg_send_model ->getMsgSendData($whereArr);
		echo json_encode($data);
	}
	
	//查看消息详细
	public function detail()
	{
		$send_id = intval($this ->input ->get('id'));
		$sendData = $this ->msg_send_model ->getSendContent($send_id);
		
		//获取消息步骤记录
		$sendStepArr = $this ->send_step_model ->getSendStepData($sendData['code'] ,$sendData['type_id']);
		$dataArr = array(
				'sendArr' =>$sendData,
				'sendStepArr' =>$sendStepArr
		);
		
		if ($sendData['status'] == 0)
		{
			//更改消息状态
			if ($sendData ['content_type'] == 2)
			{
				$sendArr = array(
						'status' =>1,
						'modtime' =>date('Y-m-d H:i:s' ,time())
				);
			}
			else 
			{
				$sendArr = array(
						'status' =>2,
						'modtime' =>date('Y-m-d H:i:s' ,time())
				);
			}
			
			$this ->msg_send_model ->update($sendArr ,array('id' =>$send_id));
		}
		
		$this ->load ->view('msg/t33_msg_detail' ,$dataArr);
	}
}
