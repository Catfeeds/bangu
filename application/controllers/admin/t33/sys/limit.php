<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_send_msg.php';

//"额度管理"控制器
class Limit extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$this->load->model('admin/t33/limit/b_limit_apply_model','b_limit_apply_model');  //信用额度申请表
		$this->load->model('admin/t33/limit/b_expert_limit_apply_model','b_expert_limit_apply_model'); //信用额度使用表
		$this->load->model('admin/t33/approve/u_order_debit_model','u_order_debit_model'); //订单扣款表
		
		$this->load->model('admin/t33/limit/b_limit_log_model','b_limit_log_model'); //额度使用日志表
		$this->load->model('admin/t33/u_member_order_model','u_member_order_model'); //订单表
		
	}
	
	/**
	 * 营业部现金额度
	 * */
	public function cash()
	{
		$this->load->view("admin/t33/limit/cash");
	}
	/**
	 * 营业部额度：api
	 * */
	public function api_cash()
	{
		$name=trim($this->input->post("name",true));
		$small_value=trim($this->input->post("small_value",true)); //现金额度
		$big_value=trim($this->input->post("big_value",true));
		$name=trim($this->input->post("name",true));
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = sys_constant::B_PAGE_SIZE;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
			if(!empty($name))
				$where['name']=$name;
			if(!empty($small_value))
				$where['small_value']=$small_value;
			if(!empty($big_value))
				$where['big_value']=$big_value;
			$where['status']="1"; //正常的营业部			
			$return=$this->b_depart_model->depart_list($where,$from,$page_size);
			$result=$return['result'];
			$total_rows=$return['rows'];
			$total_page=ceil ( $total_rows/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/**
	 * 营业部额度使用日志
	 * */
	public function limit_log($depart_id="")
	{

		$data['depart_id']=$depart_id;
		$data['depart']=$this->b_depart_model->depart_detail($depart_id);
		$this->load->view("admin/t33/limit/limit_log",$data);
	}
	/**
	 *  营业部额度使用日志：api
	 * */
	public function api_limit_log()
	{
		$ordersn=trim($this->input->post("ordersn",true)); //订单编号
		$starttime=trim($this->input->post("starttime",true)); //
		$endtime=trim($this->input->post("endtime",true));
		$depart_id=trim($this->input->post("depart_id",true)); //营业部id
	 
		$employee_id=$this->session->userdata("employee_id");
		if(empty($depart_id)) $this->__errormsg('部门id不能为空');
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = 12;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($starttime))
				$where['starttime']=$starttime." 23:59:59";
			if(!empty($endtime))
				$where['endtime']=$endtime." 23:59:59";
			
			$where['depart_id']=$depart_id;
			
			$return=$this->b_limit_log_model->log_list($where,$from,$page_size);
		
			$result=$return['result'];
			$total_rows=$return['rows'];
			$total_page=ceil ( $total_rows/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'from'=>$from,
					//'sql'=>$return['sql'],
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/**
	 * 信用额度申请列表
	 * */
	public function apply()
	{
		$action=trim($this->input->get("action",true)); // action=2  只看不操作
		$data['action']=$action;
		$this->load->view("admin/t33/limit/apply_list",$data);
	}
	
	/**
	 * 信用额度申请列表：api
	 * */
	public function api_apply()
	{
		$type=trim($this->input->post("type",true)); //类型 -2全部，1申请中，3已通过，4已还款、5已拒绝
		$depart_id=trim($this->input->post("depart_id",true));
		$expert_name=trim($this->input->post("expert_name",true));
		$manager_name =trim($this->input->post("manager_name",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = sys_constant::B_PAGE_SIZE;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($manager_name))
				$where['manager_name']=$manager_name;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if($type!="-2")
				$where['status']=$type; //默认-2
			
			$return=$this->b_limit_apply_model->apply_list($where,$from,$page_size);
			$result=$return['result'];
			$total_rows=$return['rows'];
			$total_page=ceil ( $total_rows/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/*
	 * 信用额度使用：来源
	*
	* */
	public function apply_detail()
	{
		$id=$this->input->get("id",true); //b_limit_apply 表id
		$action=$this->input->get("action",true);
		$this->load_model ( 'admin/t33/sys/b_limit_apply_model','b_limit_apply_model');
		$data['list']=$this->b_limit_apply_model->detail($id);
		$data['action']=$action;
		$data['apply_id']=$id;
	
		$this->load->view("admin/t33/limit/apply_detail",$data);
	}
	/**
	 * 信用额度申请:审核通过
	 * */
	public function api_apply_deal()
	{
		$apply_id=$this->input->post("apply_id",true);
		$reply=$this->input->post("reply",true);
		if(empty($apply_id))  $this->__errormsg('申请id不能为空');
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			//1、更改信用申请的状态为通过（status=3）
			$apply=$this->b_limit_apply_model->row(array('id'=>$apply_id));
			$row=$this->u_member_order_model->row(array('id'=>$apply['order_id']));
			$data1=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'3');
			$this->b_limit_apply_model->update($data1,array('id'=>$apply_id));
			//2、额度申请日志
			$new=$this->b_depart_model->row(array('id'=>$apply['depart_id']));
			$addtime=date("Y-m-d H:i:s");
			$log=array(
					'depart_id'=>$apply['depart_id'],
					'expert_id'=>$apply['expert_id'],
					'union_id'=>$apply['union_id'],
					'order_id'=>$apply['order_id'],
					'order_sn'=>$row['ordersn'],
					'order_price'=>$row['total_price'],
					'cash_limit'=>$new['cash_limit'],
					'credit_limit'=>$new['credit_limit'],
					'sx_limit'=>$apply['credit_limit'],
					'addtime'=>date("Y-m-d H:i:s",time()+1),
					'type'=>'管家信用申请通过',
					'remark'=>'旅行社端：管家信用申请通过'
			);
			$this->write_limit_log($log);
			//订单操作日志
			$this->write_order_log($apply['order_id'],'审核通过：'.$log['sx_limit'].'元管家信用额度');
			//3、新增一条额度使用记录 ，b_expert_limit_apply_model
			$data2=array(
					'depart_id'=>$apply['depart_id'],
					'depart_name'=>$apply['depart_name'],
					'expert_id'=>$apply['expert_id'],
					'expert_name'=>$apply['expert_name'],
					'apply_id'=>$apply_id,
					'apply_amount'=>$apply['credit_limit'],
					'real_amount'=>$apply['credit_limit'],
					'order_id'=>$apply['order_id'],
					'addtime'=>date("Y-m-d H:i:s"),
					'return_time'=>$apply['return_time'],
					'status'=>'1'  //已使用
			);
			$this->b_expert_limit_apply_model->insert($data2);
			//4、额度使用日志
			$new=$this->b_depart_model->row(array('id'=>$apply['depart_id']));
			$addtime=date("Y-m-d H:i:s");
			$log=array(
					'depart_id'=>$apply['depart_id'],
					'expert_id'=>$apply['expert_id'],
					'order_id'=>$apply['order_id'],
					'order_sn'=>$row['ordersn'],
					'order_price'=>$row['total_price'],
					'union_id'=>$apply['union_id'],
					'cash_limit'=>$new['cash_limit'],
					'credit_limit'=>$new['credit_limit'],
					'sx_limit'=>0-$apply['credit_limit'],
					'addtime'=>date("Y-m-d H:i:s",time()+2),
					'type'=>'下单使用管家信用',
					'remark'=>'旅行社端：下单使用管家信用'
			);
			$this->write_limit_log($log);
			//5、订单改为确认状态：u_member_order_model status=>4 
			$this->u_member_order_model->update(array('status'=>'4'),array('id'=>$apply['order_id']));
			//6、扣款表 u_order_debit， 更改real_amount
			$this->u_order_debit_model->update(array('real_amount'=>$apply['credit_limit']),array('type'=>'3','order_id'=>$apply['order_id']));
			//7、u_line_suit_price表的order_num加1  、  减余位
			$order=$this->u_member_order_model->row(array('id'=>$apply['order_id']));
			if($order['suitnum']>0)
			{
				$member_num=$order['suitnum'];
			}
			else
			{
				$member_num=$order['dingnum']+$order['oldnum']+$order['childnum']+$order['childnobednum'];
			}
			
			$this->load->model('admin/t33/sys/u_line_suit_price_model','u_line_suit_price_model');
			$old=$this->u_line_suit_price_model->row(array('suitid'=>$order['suitid'],'day'=>$order['usedate']));
			if(!empty($old))
			{
				$num=$old['order_num']+1;
				$new_member_num=$old['number']-$member_num;
				if($new_member_num<0) $this->__errormsg('该线路的余位不足，无法通过审核');
				$this->u_line_suit_price_model->update(array('order_num'=>$num,'number'=>$new_member_num),array('dayid'=>$old['dayid']));
			}
			
			//结果
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				//发送消息jkr
				$msg = new T33_send_msg();
				$msgArr = $msg ->applyQuotaMsg($apply_id,3,$this->session->userdata('employee_realname'));
				$this->__data('已通过');
			}
		}
	}
	/**
	 * 信用额度申请:拒绝
	 * 退钱：现金、营业部信用都根据扣款表扣除
	 * */
	public function api_apply_refuse()
	{
		$apply_id=$this->input->post("apply_id",true);
		$reply=$this->input->post("reply",true);
		if(empty($apply_id))  $this->__errormsg('申请id不能为空');
		if(empty($reply))   $this->__errormsg('拒绝原因不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			$apply=$this->b_limit_apply_model->row(array('id'=>$apply_id));
			//1、更改信用申请的状态
			$data1=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'5');
			$this->b_limit_apply_model->update($data1,array('id'=>$apply_id));
			//订单操作日志
			$this->write_order_log($apply['order_id'],'审核拒绝：'.$apply['credit_limit'].'元管家信用额度');
			//2、订单改为平台拒绝状态：u_member_order_model status=>-2
			$this->u_member_order_model->update(array('status'=>'-2'),array('id'=>$apply['order_id']));
			$order_row=$this->F_order_detail($apply['order_id']);
			
			//2.2
			$this->load->model('admin/t33/approve/u_order_receivable_model','u_order_receivable_model');  //订单收款表
			$this->u_order_receivable_model->update(array('status'=>'3'),array('order_id'=>$apply['order_id'],'status'=>'0'));
			//3、还款：扣款表 u_order_debit， 更改real_amount；b_depart 表更改 cash_limit
			  //还营业部信用额度
			$row1=$this->u_order_debit_model->row(array('type'=>'2','order_id'=>$apply['order_id']));
			$this->u_order_debit_model->update(array('repayment'=>$row1['real_amount']),array('type'=>'2','order_id'=>$apply['order_id']));
			$row2=$this->b_depart_model->row(array('id'=>$apply['depart_id']));
			$this->b_depart_model->update(array('credit_limit'=>$row2['credit_limit']+$row1['real_amount']),array('id'=>$apply['depart_id']));
			$log=array(
					'cash_limit'=>$row2['cash_limit'],
					'depart_id'=>$apply['depart_id'],
					'expert_id'=>$apply['expert_id'],
					'expert_name'=>$apply['expert_name'],
					'order_id'=>$apply['order_id'],
					'order_sn'=>$order_row['ordersn'],
					'union_id'=>$apply['union_id'],
					'supplier_id'=>$apply['supplier_id'],
					'credit_limit'=>$row2['credit_limit']+$row1['real_amount'],
					'receivable_money'=>$row1['real_amount'],
					'addtime'=>date("Y-m-d H:i:s"),
					'type'=>'单团额度审批时被旅行社拒绝，退营业部信用额度！',
					'remark'=>'单团额度审批时被旅行社拒绝，退营业部信用额度！'
			);
			$this->write_limit_log($log);
			  // 还营业部现金额度
			$row3=$this->u_order_debit_model->row(array('type'=>'1','order_id'=>$apply['order_id']));
			$this->u_order_debit_model->update(array('repayment'=>$row3['real_amount']),array('type'=>'1','order_id'=>$apply['order_id']));
			$row4=$this->b_depart_model->row(array('id'=>$apply['depart_id']));
			$this->b_depart_model->update(array('cash_limit'=>$row4['cash_limit']+$row3['real_amount']),array('id'=>$apply['depart_id']));
			$log2=array(
					'cash_limit'=>$row4['cash_limit']+$row3['real_amount'],
					'depart_id'=>$apply['depart_id'],
					'expert_id'=>$apply['expert_id'],
					'expert_name'=>$apply['expert_name'],
					'order_id'=>$apply['order_id'],
					'order_sn'=>$order_row['ordersn'],
					'union_id'=>$apply['union_id'],
					'supplier_id'=>$apply['supplier_id'],
					'credit_limit'=>$row4['credit_limit'],
					'receivable_money'=>$row3['real_amount'],
					'addtime'=>date("Y-m-d H:i:s",time()+1),
					'type'=>'单团额度审批时被旅行社拒绝，退营业部现金额度！',
					'remark'=>'单团额度审批时被旅行社拒绝，退营业部现金额度！'
			);
			$this->write_limit_log($log2);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				//发送消息jkr
				$msg = new T33_send_msg();
				$msgArr = $msg ->applyQuotaMsg($apply_id,3,$this->session->userdata('employee_realname'));
				$this->__data('已拒绝');
			}
		}
	}
	/**
	 * 信用额度申请:拒绝 （版本二）
	 * 退钱：现金部分根据收款表扣除，营业部信用根据扣款表扣除
	 * */
	public function api_apply_refuse2()
	{
		$apply_id=$this->input->post("apply_id",true);
		$reply=$this->input->post("reply",true);
		if(empty($apply_id))  $this->__errormsg('申请id不能为空');
		if(empty($reply))   $this->__errormsg('拒绝原因不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			$apply=$this->b_limit_apply_model->row(array('id'=>$apply_id));
			//1、更改信用申请的状态
			$data1=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'5');
			$this->b_limit_apply_model->update($data1,array('id'=>$apply_id));
			//2、订单改为平台拒绝状态：u_member_order_model status=>-2
			$this->u_member_order_model->update(array('status'=>'-2'),array('id'=>$apply['order_id']));
			$order_row=$this->F_order_detail($apply['order_id']);
				
			//3、还款：扣款表 u_order_debit， 更改real_amount；b_depart 表更改 cash_limit
			//还营业部信用额度
			$row1=$this->u_order_debit_model->row(array('type'=>'2','order_id'=>$apply['order_id']));
			$this->u_order_debit_model->update(array('repayment'=>$row1['real_amount']),array('type'=>'2','order_id'=>$apply['order_id']));
			$row2=$this->b_depart_model->row(array('id'=>$apply['depart_id']));
			$this->b_depart_model->update(array('credit_limit'=>$row2['credit_limit']+$row1['real_amount']),array('id'=>$apply['depart_id']));
			$log=array(
					'cash_limit'=>$row2['cash_limit'],
					'depart_id'=>$apply['depart_id'],
					'expert_id'=>$apply['expert_id'],
					'expert_name'=>$apply['expert_name'],
					'order_id'=>$apply['order_id'],
					'order_sn'=>$order_row['ordersn'],
					'union_id'=>$apply['union_id'],
					'supplier_id'=>$apply['supplier_id'],
					'credit_limit'=>$row2['credit_limit']+$row1['real_amount'],
					'receivable_money'=>$row1['real_amount'],
					'addtime'=>date("Y-m-d H:i:s"),
					'type'=>'单团额度审批拒绝，退营业部现金',
					'remark'=>'单团额度审批拒绝，退营业部额度'
			);
			$this->write_limit_log($log);
			// 还营业部现金额度
			
			$this->load->model('admin/t33/approve/u_order_receivable_model','u_order_receivable_model');  //订单收款表
			$list=$this->u_order_receivable_model->all(array('order_id'=>$apply['order_id'],'status'=>'0'));
			if(!empty($list))
			{
				foreach ($list as $k=>$v)
				{
					$row4=$this->b_depart_model->row(array('id'=>$apply['depart_id']));
					$this->b_depart_model->update(array('cash_limit'=>$row4['cash_limit']+$v['money']),array('id'=>$apply['depart_id']));
					$log2=array(
							'cash_limit'=>$row4['cash_limit']+$v['money'],
							'depart_id'=>$apply['depart_id'],
							'expert_id'=>$apply['expert_id'],
							'expert_name'=>$apply['expert_name'],
							'order_id'=>$apply['order_id'],
							'order_sn'=>$order_row['ordersn'],
							'union_id'=>$apply['union_id'],
							'supplier_id'=>$apply['supplier_id'],
							'credit_limit'=>$row4['credit_limit'],
							'receivable_money'=>$v['money'],
							'addtime'=>date("Y-m-d H:i:s"),
							'type'=>'单团额度审批拒绝，退营业部信用',
							'remark'=>'单团额度审批拒绝，退营业部现金'
					);
					$this->write_limit_log($log2);
					$this->u_order_receivable_model->update(array('status'=>'3'),array('order_id'=>$v['order_id']));
				}
			}
				
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				//发送消息jkr
				$msg = new T33_send_msg();
				$msgArr = $msg ->applyQuotaMsg($apply_id,3,$this->session->userdata('employee_realname'));
				$this->__data('已拒绝');
			}
		}
	}
	
	/**
	 * 信用额度列表: 未使用、已使用、已还款
	 * */
	public function limit_list()
	{
		
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		
		$union_id=$employee['id'];
		$data['depart']=$this->b_depart_model->all(array('union_id'=>$union_id,'status'=>'1'));
		$this->load->view("admin/t33/limit/limit_list",$data);
	}
	/**
	 * 信用额度使用情况：api
	 * */
	public function api_limit_list()
	{
		$type=trim($this->input->post("type",true)); //类型 0申请中，1已使用，2已还款
		$depart_id=trim($this->input->post("depart_id",true));
		$expert_name=trim($this->input->post("expert_name",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$ordersn=trim($this->input->post("ordersn",true));
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = sys_constant::B_PAGE_SIZE;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if($type!="-2")
				$where['status']=$type; //默认-1
			
			$return=$this->b_expert_limit_apply_model->apply_list($where,$from,$page_size);
			$result=$return['result'];
			$total_rows=$return['rows'];
			$total_page=ceil ( $total_rows/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/*
	 * 信用额度使用：来源
	 * 
	 * */
	public function limit_detail()
	{
		$id=$this->input->get("id",true); //b_expert_limit_apply 表id
		$this->load_model ( 'admin/t33/sys/b_expert_limit_apply_model','b_expert_limit_apply_model');
		$data['apply']=$this->b_expert_limit_apply_model ->limit_apply_detail($id);
	    $this->load->view("admin/t33/limit/detail",$data);
	}
	
	
}

/* End of file login.php */
