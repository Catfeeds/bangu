<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_send_msg.php';

//"审批"控制器
class Approve extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/approve/u_order_receivable_model','u_order_receivable_model');  //订单收款表
		
		$this->load->model('admin/t33/approve/u_item_apply_model','u_item_apply_model'); //交款申请表
		
		$this->load->model('admin/t33/approve/u_payable_order_model','u_payable_order_model'); //付款关联订单表
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		$this->load->model('admin/t33/approve/u_payable_apply_pic_model','u_payable_apply_pic_model'); //付款流水单表
		$this->load->model('admin/t33/u_member_order_model','u_member_order_model'); //订单表
		
		$this->load->model('admin/t33/limit/b_expert_limit_apply_model','b_expert_limit_apply_model'); //信用额度使用表
		$this->load->model('admin/t33/limit/b_limit_apply_model','b_limit_apply_model'); //申请表
		
		$this->load->model('admin/t33/bill/b_depart_settlement_model','b_depart_settlement_model');  // 营业部结算申请
		$this->load->model('admin/t33/bill/u_exchange_model','u_exchange_model');  // 提现申请
		$this->load->model('admin/t33/approve/u_order_debit_model','u_order_debit_model'); //订单扣款表
		
		$this->load->model('admin/t33/approve/u_supplier_refund_model','u_supplier_refund_model'); //供应商退款申请
		
	}
	
	/**
	 * 销售申请结算
	 * */
	public function hand()
	{
		$this->load->view("admin/t33/approve/hand");
	}
	/**
	 * 交款申请列表：api
	 * */
	public function api_hand()
	{
		$type=trim($this->input->post("type",true)); //类型 1经理提交，2已通过，3已拒绝
		
		$depart_id=trim($this->input->post("depart_id",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$expert_name=trim($this->input->post("expert_name",true));//销售或者经理
		$starttime=trim($this->input->post("starttime",true));
		
		$shen_start=trim($this->input->post("shen_start",true));
		$shen_end=trim($this->input->post("shen_end",true));
		
		$endtime=trim($this->input->post("endtime",true));
		$price_start=trim($this->input->post("price_start",true));//交款金额
		$price_end=trim($this->input->post("price_end",true));
		
		$team_code=trim($this->input->post("team_code",true));
	
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
			//$page_size="10";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
		
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($shen_start))
				$where['shen_start']=$shen_start;
			if(!empty($shen_end))
				$where['shen_end']=$shen_end;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($team_code))
				$where['team_code']=$team_code;
			
			if(!empty($type))
			{
				if($type=="5")
				    $where['is_print']="1"; //已打印
				else 
					$where['status']=$type; //默认1
			}
			
			$return=$this->u_order_receivable_model->apply_list($where,$from,$page_size);
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
	* 交款申请: 详情
	*
	* */
	public function hand_detail()
	{
		$id=$this->input->get("id",true); //u_order_receivable 表id
		$action=$this->input->get("action",true); //动作    1是查看，2是审核
		$data['list']=$this->u_order_receivable_model ->item_apply_detail(array('id'=>$id));
		$data['apply_id']=$id;
		$data['action']=$action;
		$this->load->view("admin/t33/approve/hand_detail",$data);
	}
	/*
	 *  新增收款
	*
	* */
	public function hand_add()
	{
		$union_id=$this->get_union();
		$user=$this->userinfo();
		$expert_list=$this->u_expert_model->union_expert($union_id);
		$data['expert_list']=$expert_list;
		$data['m_date']=date("Y-m-d");
		$data['user']=$user;

		$this->load->view("admin/t33/approve/hand_add",$data);
	}
	/*
	 * 点击团号：所以的交款列表
	 * */
	public function hand_team_list()
	{
		$team_code=$this->input->get("team_code");
		$data['team_code']=$team_code;
		$this->load->view("admin/t33/approve/hand_team",$data);
	}
	
	/*
	 *  批量提交：列表
	*
	* */
	public function hand_submit()
	{
		$list=$this->input->get("list");
		$list=substr($list, 0,-1);
		$union_id=$this->get_union();
		$where=array('union_id'=>$union_id,'status'=>'1','list'=>$list);
	    $result=$this->u_order_receivable_model->apply_list($where);
	    $data['list']=$result['result'];
	    $data['list_id']=$list;
		$this->load->view("admin/t33/approve/hand_submit",$data);
	}
	/*
	 *  交款打印
	*
	* */
	public function hand_print()
	{
		$id=$this->input->get("id");
		$union_id=$this->get_union();

		$where=array('union_id'=>$union_id,'list'=>$id); //去掉了 'status'=>'1'
		$result=$this->u_order_receivable_model->apply_list($where);
	
		$data['list']=$result['result'];
		$data['row']=$result['result'][0];
		$depart_list=$data['row']['depart_list'];
		$depart_list=substr($depart_list, 0,-1);
		
		//$manager=$this->u_expert_model->get_manager($depart_list);
		//$data['manager']=$manager;
		$data['list_id']=$id;
		//var_dump($data);
		$this->load->view("admin/t33/approve/hand_print",$data);
	}
	/**
	 * 打印改状态
	 * */
	public function api_print_ok()
	{
		$id=$this->input->post("id",true);  //u_order_receivable表id
		if(empty($id))  $this->__errormsg('id不能为空');
		$status=$this->u_order_receivable_model->update(array('is_print'=>'1'),array('id'=>$id));
		$this->__data('已打印');
	}
	/**
	 * 批量提交:通过
	 * */
	public function hand_submit_deal()
	{
		$list=$this->input->post("list",true);  //u_order_receivable表id
		$reply=$this->input->post("reply",true);
		if(empty($list))  $this->__errormsg('交款id不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			$list_arr=explode(",", $list);
            foreach ($list_arr as $k=>$v)
            {
			  $this->hand_deal($v, $reply,$employee_id); //提交
			  sleep(3);
            }
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已通过');
			}
			//end
		}
	}
	/**
	 * 批量提交:拒绝
	 * */
	public function hand_submit_refuse()
	{
		$list=$this->input->post("list",true);  //u_order_receivable表id
		$reply=$this->input->post("reply",true);
		if(empty($list))   $this->__errormsg('交款id不能为空');
		if(empty($reply))  $this->__errormsg('审核意见不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			$list_arr=explode(",", $list);
			foreach ($list_arr as $k=>$v)
			{
				$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			    $data=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'3','employee_name'=>$employee['realname'],'modtime'=>date("Y-m-d H:i:s"));
			    $this->u_order_receivable_model->update($data,array('id'=>$v));
			}
				
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已通过');
			}
			//end
		}
	}
	/**
	 * 新增交款
	 * */
	public function api_hand_add()
	{
		$expert_id=$this->input->post("expert_id",true);
		$addtime=$this->input->post("addtime",true);
		$money=$this->input->post("money",true);
		$depart_id=$this->input->post("depart_id",true);
		$way=$this->input->post("way",true);
		$type=$this->input->post("type",true);
		$bankname=$this->input->post("bankname",true);
		$bankcard=$this->input->post("bankcard",true);
		$invoice_code=$this->input->post("invoice_code",true);
		$voucher=$this->input->post("voucher",true);
		$remark=$this->input->post("remark",true);
		$code_pic=$this->input->post("code_pic",true);
		$code=$this->input->post("code",true);
		
		
		if(empty($addtime))  $this->__errormsg('收款时间不能为空');
		if(empty($money))  $this->__errormsg('收款金额不能为空');
		if(empty($expert_id))  $this->__errormsg('交款人不能为空');
		if(empty($way))  $this->__errormsg('收款方式不能为空');
		if($way=="转账")
		{
			if(empty($bankname))  $this->__errormsg('银行名称不能为空');
			if(empty($bankcard))  $this->__errormsg('银行卡号不能为空');
		}
		if(empty($code))  $this->__errormsg('凭证号不能为空');
		/* if(empty($type))  $this->__errormsg('发票类型不能为空');
		if(empty($invoice_code))  $this->__errormsg('收据号不能为空');
		if(empty($voucher))  $this->__errormsg('收款单号不能为空'); */
		//if(empty($remark))  $this->__errormsg('备注不能为空');
		
		$exist=$this->u_order_receivable_model->row(array('code'=>$code));
		if(!empty($exist))  $this->__errormsg('凭证号已存在，请重新填写');
		
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->detail($employee_id);
		$addtime=date("Y-m-d H:i:s");
		$this->load->model('admin/t33/approve/code_sk_batch_model','code_sk_batch_model');  // 一对多关联
		$sk_batch=$this->code_sk_batch_model->insert(array('code'=>'A'));
		$data=array(
			'expert_id'=>$expert_id,
			'depart_id'=>$depart_id,
			'money'=>$money,
			'voucher'=>$voucher,
			'code'=>$code,
			'way'=>$way,
			'invoice_type'=>$type,
			'invoice_code'=>$invoice_code,
			'remark'=>$remark,
			'addtime'=>$addtime,
			'union_id'=>$employee['union_id'],
			'union_name'=>$employee['union_name'],
			'employee_id'=>$employee_id,
			'employee_name'=>$employee['realname'],
			'code_pic'=>$code_pic,
			'modtime'=>$addtime,
			'batch'=>$sk_batch,
			'status'=>'2' //直接审核通过
		);
		if($way=="转账")
		{
			$data['bankname']=$bankname;
			$data['bankcard']=$bankcard;
		}
		$this->db->trans_begin();
		//1、增加收款记录
		$receivable_id=$this->u_order_receivable_model->insert($data);
		$this->load->model('admin/t33/approve/u_order_receivable_pic_model','u_order_receivable_pic_model');  //流水单
		$this->u_order_receivable_pic_model->insert(array('receivable_id'=>$receivable_id,'pic'=>$code_pic,'addtime'=>$addtime)); //流水单
		//2、现金充值到营业部现金额度
		$row=$this->b_depart_model->row(array('id'=>$depart_id));
		$new_money=$row['cash_limit']+$money;
		$this->b_depart_model->update(array('cash_limit'=>$new_money),array('id'=>$depart_id));
		//3、额度变化日志
		$log=array(
			'depart_id'=>$depart_id,
			'expert_id'=>$expert_id,
			'union_id'=>$employee['union_id'],
			'receivable_money'=>$money,
			'cash_limit'=>$new_money,
			'credit_limit'=>$row['credit_limit'],
			'type'=>'充值',
			'addtime'=>$addtime
		);
        $this->write_limit_log($log);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('收款成功');
		}
		
	}
	
	/**
	 * 交款申请:审核通过
	 * */
	public function api_hand_deal()
	{
		$item_id=$this->input->post("item_id",true);  //u_order_receivable表id
		$reply=$this->input->post("reply",true);
		if(empty($item_id))  $this->__errormsg('交款id不能为空');
		$employee_id=$this->session->userdata("employee_id");
		 if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			
		    $this->hand_deal($item_id, $reply,$employee_id); //提交
		    
		    if ($this->db->trans_status() === FALSE)
		    {
		    	$this->db->trans_rollback();
		    	$this->__errormsg('操作失败');
		    }
		    else
		    {
		    	$this->db->trans_commit();
		    	$this->__data('已通过');
		    }
		    //end
		}
	}
	
	/**
	 * 交款申请:拒绝
	 * */
	public function api_hand_refuse()
	{
		$item_id=$this->input->post("item_id",true);  //u_order_receivable表id
		$reply=$this->input->post("reply",true);
		if(empty($item_id))  $this->__errormsg('申请id不能为空');
		if(empty($reply))   $this->__errormsg('拒绝原因不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			//1、若是“账户余额”交款，则退回余额
			$result=$this->u_order_receivable_model->item_apply_detail(array('id'=>$item_id));
			if(empty($result)) 
				$this->__errormsg('交款单不存在');
			else 
				$row=$result[0];
			if($row['status']!="1") $this->__errormsg('操作失败，交款单不是处于申请状态');
			if($row['way']=="账户余额")
			{
				$depart=$this->b_depart_model->row(array('id'=>$row['depart_id']));
				$this->b_depart_model->update(array('cash_limit'=>$depart['cash_limit']+$row['money']),array('id'=>$row['depart_id']));
				$log=array(
						'cash_limit'=>$depart['cash_limit']+$row['money'],
						'depart_id'=>$row['depart_id'],
						'expert_id'=>$row['expert_id'],
						'expert_name'=>$row['expert_name'],
						'order_id'=>$row['order_id'],
						'order_sn'=>$row['order_sn'],
						'union_id'=>$row['union_id'],
						'supplier_id'=>$row['supplier_id'],
						'credit_limit'=>$depart['credit_limit'],
						'receivable_money'=>$row['money'],
						'addtime'=>date("Y-m-d H:i:s"),
						'type'=>'账户余额交款，审核拒绝退额度',
						'remark'=>'账户余额交款，审核拒绝退额度'
				);
			
				$this->write_limit_log($log);
			}
			//2、更改交款的状态
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'3','employee_name'=>$employee['realname'],'modtime'=>date("Y-m-d H:i:s"));
			$this->u_order_receivable_model->update($data,array('id'=>$item_id));
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已拒绝');
			}
		}
	}
	/*
	 * 分割线
	 * */
	public function ___________________1()
	{
	
	}
	/**
	 * 提交交款到平台
	 * */
	public function hand_platform()
	{
		$this->load->view("admin/t33/approve/hand_platform");
	}
	/**
	 * 提交交款到平台：api
	 * */
	public function api_hand_platform()
	{
		$type=trim($this->input->post("type",true)); //类型 -1全部，1经理提交，2已通过，3已拒绝
		$depart_id=trim($this->input->post("depart_id",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$item_code=trim($this->input->post("item_code",true));
		$expert_name=trim($this->input->post("expert_name",true));//销售或者经理
		$starttime=trim($this->input->post("starttime",true));
	
		$shen_start=trim($this->input->post("shen_start",true));
		$shen_end=trim($this->input->post("shen_end",true));
	
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
	
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($item_code))
				$where['item_code']=$item_code;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($shen_start))
				$where['shen_start']=$shen_start;
			if(!empty($shen_end))
				$where['shen_end']=$shen_end;
			if($type!="-1")
				$where['status']=$type; //默认-1
				
			$return=$this->u_order_receivable_model->apply_list_platform($where,$from,$page_size);
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
	 * 提交交款到平台：处理
	 * */
	public function api_hand_platform_deal()
	{
		$list=$this->input->post("list",true);
		if(empty($list))  $this->__errormsg('请选择要提交的交款');
		
		$this->db->trans_begin();
		if(!empty($list))
		{
			foreach ($list as $k=>$v)
			{
				$this->u_order_receivable_model->update(array('a_status'=>'1'),array('id'=>$v));//$v 交款id
				
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
			$this->__data('已提交');
		}
	}
	
	/**
	 * 销售结算申请
	 * */
	public function expert_bill()
	{
		
		$this->load->view("admin/t33/approve/expert_bill");
	}
	/**
	 * 销售结算申请列表：api
	 * */
	public function api_expert_bill()
	{
		$type=trim($this->input->post("type",true)); //类型 0申请中，1已通过，2已退回
		$depart_id=trim($this->input->post("depart_id",true));
		$expert_name=trim($this->input->post("expert_name",true));//销售或者经理
		$starttime=trim($this->input->post("starttime",true));
	
		$shen_start=trim($this->input->post("shen_start",true));
		$shen_end=trim($this->input->post("shen_end",true));
	
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
	
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($shen_start))
				$where['shen_start']=$shen_start;
			if(!empty($shen_end))
				$where['shen_end']=$shen_end;
			if($type!="-1")
				$where['status']=$type; //默认-1
			
			$return=$this->b_depart_settlement_model->apply_list($where,$from,$page_size);
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
	 * 结算单详情
	 * */
	public function bill_detail($id="",$action="1")
	{
	
		$data['id']=$id;
		$data['action']=$action;
		$data['bill']=$this->b_depart_settlement_model->row(array('id'=>$id));
		$this->load->view("admin/t33/approve/bill_detail",$data);
	}
	/**
	 *  结算订单列表：api
	 * */
	public function api_bill_order()
	{
		$ordersn=trim($this->input->post("ordersn",true)); //订单编号
		$productname=trim($this->input->post("productname",true)); //产品名称
		$id=trim($this->input->post("id",true)); //营业部结算申请表id
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($id)) $this->__errormsg('结算单id不能为空');
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = 8;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($productname))
				$where['productname']=$productname;
				
			$where['id']=$id;
				
			$return=$this->b_depart_settlement_model->settlement_order($where,$from,$page_size);
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
	 * 管家结算申请:审核通过
	 * */
	public function api_bill_deal()
	{
		$apply_id=$this->input->post("id",true); //b_depart_settlement 表id
		$reply=$this->input->post("reply",true);
		if(empty($apply_id))  $this->__errormsg('结算申请id不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			//将该付款下的订单，更改数据
			$settlement_list=$this->b_depart_settlement_model->settlement_order(array('id'=>$apply_id));
			
			if(!empty($settlement_list['result']))
			{
				foreach ($settlement_list['result'] as $k=>$v)
				{    //循环每个订单
					//$order=$this->u_member_order_model->row(array('id'=>$v['order_id']));
					
					$this->u_member_order_model->update(array('depart_status'=>'2'),array('id'=>$v['order_id']));
				}
	
			}
	
			//状态更改
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('u_reason'=>$reply,'employee_id'=>$employee_id,'status'=>'1','employee_name'=>$employee['realname'],'u_time'=>date("Y-m-d H:i:s"));
			$this->b_depart_settlement_model->update($data,array('id'=>$apply_id));
	
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已通过');
			}
		}
	}
	/**
	 * 管家结算申请:拒绝
	 * */
	public function api_bill_refuse()
	{
		$apply_id=$this->input->post("id",true);//b_depart_settlement 表id
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
			//将该付款下的订单，更改数据
			$settlement_list=$this->b_depart_settlement_model->settlement_order(array('id'=>$apply_id));
				
			if(!empty($settlement_list['result']))
			{
				foreach ($settlement_list['result'] as $k=>$v)
				{    //循环每个订单
					//$order=$this->u_member_order_model->row(array('id'=>$v['order_id']));
						
					$this->u_member_order_model->update(array('depart_status'=>'0'),array('id'=>$v['order_id']));
				}
			
			}
			//更改信用申请的状态
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('u_reason'=>$reply,'employee_id'=>$employee_id,'status'=>'2','employee_name'=>$employee['realname'],'u_time'=>date("Y-m-d H:i:s"));
			$this->b_depart_settlement_model->update($data,array('id'=>$apply_id));
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已拒绝');
			}
		}
	}
	/*
	 * 分割线
	 * */
	public function ____________________2()
	{
	
	}
	/**
	 * 提现申请
	 * */
	public function exchange()
	{
		$data['action']=$this->input->get("action",true);
		$this->load->view("admin/t33/approve/exchange",$data);
	}
	/**
	 * 提现申请列表：api
	 * */
	public function api_exchange()
	{
		$type=trim($this->input->post("type",true)); //类型 0申请中，1已通过，2已退回
		$expert_name=trim($this->input->post("expert_name",true));//管家姓名
		$starttime=trim($this->input->post("starttime",true));  //提现时间
		$endtime=trim($this->input->post("endtime",true));
		
		$shen_start=trim($this->input->post("shen_start",true));
		$shen_end=trim($this->input->post("shen_end",true));
	
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
	
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($shen_start))
				$where['shen_start']=$shen_start;
			if(!empty($shen_end))
				$where['shen_end']=$shen_end;
			if($type!="-1")
				$where['status']=$type; //默认-1
			$where['union_id']=$union_id; //旅行社
			
			$return=$this->u_exchange_model->exchange_list($where,$from,$page_size);
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
	 * 结算单详情
	 * */
	public function exchange_detail($id="",$action="1")
	{
		$data['id']=$id;
	
		$data['action']=$action;
		$data['exchange']=$this->u_exchange_model->exchange_detail(array('id'=>$id));
		$data['exchange_depart']=$this->u_exchange_model->exchange_depart($id);
		$this->load->view("admin/t33/approve/exchange_detail",$data);
	}
	/**
	 * 打印提现审核
	 * */
	public function print_exchange()
	{
		$id=$this->input->get("id",true);
		$data['id']=$id;
		$data['exchange']=$this->u_exchange_model->exchange_detail(array('id'=>$id));
		$data['exchange_depart']=$this->u_exchange_model->exchange_depart($id);
		
		$this->load->view("admin/t33/approve/print_exchange",$data);
	}
	/**
	 * 交款申请:审核通过
	 * */
	public function api_exchange_deal()
	{
		$id=$this->input->post("id",true);  //u_exchange表id
		$reply=$this->input->post("reply",true);
		$action=$this->input->post("status",true); //1是通过，2是拒绝
		if(empty($id))  $this->__errormsg('提现id不能为空');
		if(empty($reply)&&$action=="2")   $this->__errormsg('审核内容不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			$update=array(
				'admin_id'=>$employee_id,
				'modtime'=>date("Y-m-d H:i:s"),
				'status'=>$action,
				'is_remit'=>$action,
				'remark'=>$reply
			);
			$status=$this->u_exchange_model->update($update,array('id'=>$id));
			
			//循环列表
			
			$exchange=$this->u_exchange_model->row(array('id'=>$id));
			$exchange_depart=$this->u_exchange_model->exchange_depart($id);
			if(!empty($exchange_depart))
			{
				foreach ($exchange_depart as $k=>$v)
				{
					//若是拒绝，则把金额退回账户
					if($action=="2")
					{
						$depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
						$new_cash_limit=$depart['cash_limit']+$v['amount'];
						$this->b_depart_model->update(array('cash_limit'=>$new_cash_limit),array('id'=>$v['depart_id']));
						
						//写日志
						$new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
						$log=array(
								'depart_id'=>$v['depart_id'],
								'expert_id'=>$exchange['userid'],
								'cut_money'=>$v['amount'],
								'cash_limit'=>$new_depart['cash_limit'],
								'credit_limit'=>$new_depart['credit_limit'],
								'addtime'=>date("Y-m-d H:i:s"),
								'type'=>'旅行社拒绝提现申请，返还额度'
						
						);
						$this->write_limit_log($log);
					}
					elseif($action=="1")//若是通过，写入额度日志表
					{
						//不写日志，在管家端提现的时候已经扣了钱，写了日志
					}
				}
			}

			//提交
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__data('操作异常');
			}
			else
			{
				$this->db->trans_commit();
				if($action=="1")
				    $this->__data('审核通过');
				else 
					$this->__data('已拒绝');
			}
			
		}
	}
	/*
	 * 分割线
	 * */
	public function ____________________3()
	{
	
	}
	/**
	 * 付款审批
	 * */
	public function pay()
	{
		$this->load->view("admin/t33/approve/pay");
	}
	/**
	 * 付款申请列表：api
	 * */
	public function api_pay()
	{
		$type=trim($this->input->post("type",true)); //类型 -1全部，0申请中，1已通过，2已退回
		$supplier_name=trim($this->input->post("supplier_name",true)); //供应商名称
		$item_company=trim($this->input->post("item_company",true));//收款单位
		$pagesize=trim($this->input->post("pagesize",true));
		$starttime=trim($this->input->post("starttime",true));
		$starttime.=" 00:00:00";
		$endtime=trim($this->input->post("endtime",true));
		$endtime.=" 23:59:59";
		
		$ordersn=trim($this->input->post("ordersn",true));
		$team_code=trim($this->input->post("team_code",true));
	
		$shen_start=trim($this->input->post("shen_start",true));
		$shen_end=trim($this->input->post("shen_end",true));
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = empty($pagesize)==true?sys_constant::B_PAGE_SIZE:$pagesize;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
	
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($expert_name))
				$where['item_company']=$item_company;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($shen_start))
				$where['shen_start']=$shen_start;
			if(!empty($shen_end))
				$where['shen_end']=$shen_end;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($team_code))
				$where['team_code']=$team_code;
			if($type!="-1")
			$where['status']=$type; //默认-1
			
			$return=$this->u_payable_apply_model->payable_list($where,$from,$page_size);
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
	 * 付款申请详情
	 * */
	public function pay_detail($id,$action="1")
	{
		$data['id']=$id;
		$data['action']=$action;
		$data['row']=$this->u_payable_apply_model->row(array('id'=>$id));
		
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model'); //
		$data['supplier']=$this->u_supplier_model->row(array('id'=>$data['row']['supplier_id']));
		
		$this->load->view("admin/t33/approve/pay_detail",$data);
	}
	/**
	 * 打印月结预览
	 * */
	public function pay_print_month($id,$action="1")
	{
		$data['id']=$id;
		$data['action']=$action;
		$data['row']=$this->u_payable_apply_model->row(array('id'=>$id));
	
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model'); //
		$data['supplier']=$this->u_supplier_model->row(array('id'=>$data['row']['supplier_id']));
	
		$this->load->view("admin/t33/approve/pay_print_month",$data);
	}
	
	/*
	 *  付款审批：打印预付
	*
	* */
	public function pay_print()
	{
		
		$id=$this->input->get("id");
		$union_id=$this->get_union();
	
		$where=array('union_id'=>$union_id,'list'=>$id); //去掉了 'status'=>'1'
		$result=$this->u_payable_apply_model->payable_detail(array('po_id'=>$id));
	
		$data['list']=$result;
		$data['row']=$result[0];
		$data['list_id']=$id;
		//var_dump($data);
		$this->load->view("admin/t33/approve/pay_print",$data);
	}
	/**
	 * 团号下的所有订单
	 * */
	public function team_order($id)
	{
		$data['id']=$id; //团号
		$data['row']=$this->u_payable_apply_model->row(array('id'=>$id));
		$this->load->view("admin/t33/approve/team_order",$data);
	}
	/**
	 *  团号下的所有订单：api
	 * */
	public function api_team_order()
	{
	
		$id=trim($this->input->post("team_id",true)); //团号
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($id)) $this->__errormsg('团号不能为空');
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = 15;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('team_id'=>$id);
			//$supplier_name="地方";
			/* if(!empty($ordersn))
			 $where['ordersn']=$ordersn;
			if(!empty($productname))
				$where['productname']=$productname; */
			
			
			$return=$this->u_member_order_model->team_order($where,$from,$page_size);
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
	 *  结算订单列表：api
	 * */
	public function api_pay_order()
	{
	
		$id=trim($this->input->post("id",true)); //营业部结算申请表id
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
		$team_code=trim($this->input->post("team_code",true));
		$productname=trim($this->input->post("productname",true));
		$commit_name=trim($this->input->post("commit_name",true));
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($id)) $this->__errormsg('付款申请单id不能为空');
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = 8;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
			if(!empty($team_code))
				$where['team_code']=$team_code;
			if(!empty($productname))
				$where['productname']=$productname; 
			if(!empty($commit_name))
				$where['commit_name']=$commit_name;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
	
			$where['id']=$id;
			$return=$this->u_payable_apply_model->pay_order($where,$from,$page_size);
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
	 * 付款申请:审核通过
	 * */
	public function api_pay_deal()
	{
		$apply_id=$this->input->post("apply_id",true);
		$list=$this->input->post("list",true); //勾选的checkbox
		
		$reply=$this->input->post("reply",true);
		if(empty($apply_id))  $this->__errormsg('交款id不能为空');
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			foreach ($list as $a=>$b)
			{
				$this->u_payable_order_model->update(array('status'=>"2"),array('id'=>$b));
				$one=$this->u_payable_order_model->row(array('id'=>$b));
				$this->write_order_log($one['order_id'],'在[付款审批]页面，审核通过序号'.$b.'(改为已审待付):'.$one['amount_apply'].'元');
			}
			//状态更改
			$num=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'1')); //申请中的条数
			$num2=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'2')); //已通过的条数
			$num4=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'4')); //已付款的条数
			if($num>0)
				$status="0";
			else if($num2>0)
				$status="1";
			else if($num4>0)
				$status="3";
			else 
				$status="4";
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('u_reply'=>$reply,'employee_id'=>$employee_id,'status'=>$status,'employee_name'=>$employee['realname'],'u_time'=>date("Y-m-d H:i:s"));
			$this->u_payable_apply_model->update($data,array('id'=>$apply_id));
			
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
				$msgArr = $msg ->payableAllow(implode(',', $list),1,$this->session->userdata('employee_realname'));
				$this->__data('已通过');
			}
		}
	}
	/**
	 * 付款申请:拒绝
	 * */
	public function api_pay_refuse()
	{
		$apply_id=$this->input->post("apply_id",true);
		$reply=$this->input->post("reply",true);
		$list=$this->input->post("list",true); //勾选的checkbox
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
			//将该付款下的订单，更改数据
			$payable_list=$this->u_payable_apply_model->payable_detail(array('id'=>$apply_id));
			
			if(!empty($payable_list))
			{
				foreach ($payable_list as $k=>$v)
				{    //循环每个订单
					$this->u_member_order_model->update(array('balance_status'=>'0'),array('id'=>$v['order_id']));
				}
					
			}
			//更改状态
			foreach ($list as $a=>$b)
			{
				$this->u_payable_order_model->update(array('status'=>"3"),array('id'=>$b));
				$one=$this->u_payable_order_model->row(array('id'=>$b));
				$this->write_order_log($one['order_id'],'在[付款审批]页面，审核拒绝序号'.$b.'(改为已拒绝):'.$one['amount_apply'].'元');
			}
			//更改信用申请的状态
			$num=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'1')); //有没有未提交的
			$num2=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'2')); //已通过的条数
			if($num>0)
				$status="0";
			else if($num2>0)
				$status="1";
			else 
				$status="2";
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('u_reply'=>$reply,'employee_id'=>$employee_id,'status'=>$status,'employee_name'=>$employee['realname'],'u_time'=>date("Y-m-d H:i:s"));
			$this->u_payable_apply_model->update($data,array('id'=>$apply_id));
			
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
				$msgArr = $msg ->payableRefund(implode(',', $list),1,$this->session->userdata('employee_realname'));
				$this->__data('已拒绝');
			}
		}
	}
	/**
	 * 付款查询
	 * */
	public function pay_list()
	{
		$this->load->view("admin/t33/approve/pay_list");
	}
	/**
	 * 付款查询
	 * */
	public function api_pay_list()
	{
		$type=trim($this->input->post("type",true)); //类型 -1全部，1未提交，2已通过（代付款），3、5已退回，4已付款
		$supplier_name=trim($this->input->post("supplier_name",true)); //供应商名称
		$item_company=trim($this->input->post("item_company",true));//收款单位
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$team_code=trim($this->input->post("team_code",true));
		$productname=trim($this->input->post("productname",true));
		$commit_name=trim($this->input->post("commit_name",true));
		$supplier_code=trim($this->input->post("supplier_code",true));
		$supplier_brand=trim($this->input->post("supplier_brand",true));
		$supplier_id=trim($this->input->post("supplier_id",true));
		$supplier_id2=trim($this->input->post("supplier_id2",true));
		
		$payable_id=trim($this->input->post("payable_id",true));
		
		$pagesize=trim($this->input->post("pagesize",true));
		
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = empty($pagesize)==true?sys_constant::B_PAGE_SIZE:$pagesize;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
	
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($item_company))
				$where['item_company']=$item_company;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($team_code))
				$where['team_code']=$team_code;
			if(!empty($productname))
				$where['productname']=$productname;
			if(!empty($commit_name))
				$where['commit_name']=$commit_name;
			if(!empty($supplier_code))
				$where['supplier_code']=$supplier_code;
			if(!empty($supplier_id))
				$where['supplier_id']=$supplier_id;
			if(!empty($supplier_id2))
				$where['supplier_id2']=$supplier_id2;
			if(!empty($payable_id))
				$where['payable_id']=$payable_id;
			
			
			if($type!="-1")
				$where['status']=$type; //默认-1
	
			$return=$this->u_payable_apply_model->payable_list3($where,$from,$page_size);
			$result=$return['result'];
			$total_rows=$return['rows'];
			$total_page=ceil ( $total_rows/$page_size );
	
			if(empty($result))  $this->__data($result);
			
			//统计
			//$return['account'] 订单汇总列表
			$count_array=array(
				'sum_amount_apply'=>0,
				'sum_platform_fee'=>0,
				'sum_supplier_cost'=>0,
				'sum_jiesuan_price'=>0,
				'sum_balance_money'=>0,
				'sum_nopay_money'=>0,
				'sum_to_pay_money'=>0,
			);
			if(!empty($return['account']))
			{
				foreach ($return['account'] as $k=>$v)
				{
					$count_array['sum_amount_apply']+=$v['amount_apply'];
					$count_array['sum_platform_fee']+=$v['platform_fee'];
					$count_array['sum_supplier_cost']+=$v['supplier_cost'];
					$count_array['sum_jiesuan_price']+=$v['jiesuan_price'];
					$count_array['sum_balance_money']+=$v['balance_money'];
					$count_array['sum_nopay_money']+=($v['nopay_money']-$v['total_apply']);
					$count_array['sum_to_pay_money']+=$v['to_pay_money'];
				}
			}
			
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'account'=>$count_array,
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/*
	 * 分割线
	* */
	public function ____________________4()
	{
	
	}
	/**
	 * 付款管理（财务）
	 * */
	public function pay_manage()
	{
		$this->load->view("admin/t33/approve/pay_manage");
	}
	/**
	 * 付款管理（财务）：api
	 * */
	public function api_pay_manage()
	{
		$type=trim($this->input->post("type",true)); //类型 -1全部，0申请中，1已通过，2已退回
		$supplier_name=trim($this->input->post("supplier_name",true)); //供应商名称
		$item_company=trim($this->input->post("item_company",true));//收款单位
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$team_code=trim($this->input->post("team_code",true));
	
		$shen_start=trim($this->input->post("shen_start",true));
		$shen_end=trim($this->input->post("shen_end",true));
	
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
	
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($item_company))
				$where['item_company']=$item_company;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($shen_start))
				$where['shen_start']=$shen_start;
			if(!empty($shen_end))
				$where['shen_end']=$shen_end;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($team_code))
				$where['team_code']=$team_code;
			if($type!="-1")
				$where['status']=$type; //默认-1
				
			$return=$this->u_payable_apply_model->payable_list2($where,$from,$page_size);
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
	 * 付款申请详情(财务)
	 * */
	public function pay_manage_detail($id,$action="1")
	{
		$data['id']=$id;
		$data['action']=$action;
		$data['row']=$this->u_payable_apply_model->row(array('id'=>$id));
		
		$this->load->model('admin/t33/u_supplier_bank_model','u_supplier_bank_model'); //供应商银行账号
		$data['bank']=$this->u_supplier_bank_model->row(array('supplier_id'=>$data['row']['supplier_id']));
		$data['pics']=$this->u_payable_apply_pic_model->all(array('payable_id'=>$id));
		
		
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model'); //
		$data['supplier']=$this->u_supplier_model->row(array('id'=>$data['row']['supplier_id']));
		
		$this->load->view("admin/t33/approve/pay_manage_detail",$data);
	}
	/**
	 * 付款申请（财务）:审核通过
	 * */
	public function api_pay_manage_deal()
	{
		$apply_id=$this->input->post("apply_id",true);
		$reply=$this->input->post("reply",true);
		$list=$this->input->post("list",true); //勾选的checkbox
		$pic=$this->input->post("pic",true); //流水单
		
		if(empty($apply_id))  $this->__errormsg('申请id不能为空');
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			//1、将该付款下的订单，更改数据
				
			if(!empty($list))
			{
				foreach ($list as $k=>$v)
				{    //循环每个订单
					$row=$this->u_payable_order_model->row(array('id'=>$v));
					
					$this->u_payable_order_model->update(array('status'=>'4'),array('id'=>$v));
					//订单日志
					$this->write_order_log($row['order_id'],'在[付款管理]页面，审核通过序号'.$v.'(改为已付款):'.$row['amount_apply'].'元');
					//
					$order=$this->u_member_order_model->row(array('id'=>$row['order_id']));
					$old_balance_money=$order['balance_money'];
					$new_balance_money=$old_balance_money+$row['amount_apply'];
					$yf_supplier=$order['supplier_cost']-$order['platform_fee'];//应付供应商=供应商成本-平台佣金
					if($new_balance_money>=$yf_supplier)
					{
						$update_arr=array(
								'balance_status'=>'2',  //已结算
								'balance_money'=>$new_balance_money,  //结算金额
								'balance_complete'=>'2'  //全部结算
						);
						$this->u_member_order_model->update($update_arr,array('id'=>$row['order_id']));
					}
					else
					{
						$update_arr=array(
								'balance_status'=>'0',  //未结算
								'balance_money'=>$new_balance_money,  //结算金额
								'balance_complete'=>'1'  //部分结算
						);
						$this->u_member_order_model->update($update_arr,array('id'=>$row['order_id']));
					}
				}
	
			}
	
			//2、付款申请状态更改
			$num=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'1')); //申请中的条数
			$num2=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'2')); //已通过的条数
			$num4=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'4')); //已付款的条数
			if($num>0)
				$status="0";
			else if($num2>0)
				$status="1";
			else if($num4>0)
				$status="3";
			else 
				$status="4";
			//var_dump($num);var_dump($status);
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('u_reply'=>$reply,'employee_id'=>$employee_id,'status'=>$status,'employee_name'=>$employee['realname'],'u_time'=>date("Y-m-d H:i:s"));
			$this->u_payable_apply_model->update($data,array('id'=>$apply_id));
			//3、付款审核流水单
			$insert=array('pic'=>$pic,'payable_id'=>$apply_id,'addtime'=>date("Y-m-d H:i:s"));
			$this->u_payable_apply_pic_model->insert($insert);
			//exit();
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已通过');
			}
		}
	}
	/**
	 * 付款申请（财务）:退回
	 * 操作： 供应商退回已结算
	 * */
	public function api_pay_manage_back()
	{
		$apply_id=$this->input->post("apply_id",true);
		$reply=$this->input->post("reply",true);
		$list=$this->input->post("list",true); //勾选的checkbox
		
		if(empty($apply_id))  $this->__errormsg('申请id不能为空');
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$this->db->trans_begin();
			//1、将该付款下的订单，更改数据
			if(!empty($list))
			{
				foreach ($list as $k=>$v) //循环每个订单
				{   
					//1、u_payable_order 改状态
					$row=$this->u_payable_order_model->row(array('id'=>$v));
					$this->u_payable_order_model->update(array('status'=>'1'),array('id'=>$v));
					//订单日志
					$this->write_order_log($row['order_id'],'审核退回序号'.$v.'(改为申请中):'.$row['amount_apply'].'元');
					
					//u_payable_apply 状态更改
					$num=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'1')); //申请中的条数
					$num2=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'2')); //已通过的条数
					if($num>0)
						$status="0";
					else if($num2>0)
						$status="1";
					else
						$status="2";
					$this->u_payable_apply_model->update(array('status'=>$status),array('id'=>$apply_id));
					//2、退回供应商结算的佣金
					if($row['status']=="4") //已付款的，才退回供应商结算的佣金
					{
						$order=$this->u_member_order_model->row(array('id'=>$row['order_id']));
						$old_balance_money=$order['balance_money'];
						$new_balance_money=$old_balance_money-$row['amount_apply'];
						$yf_supplier=$order['supplier_cost']-$order['platform_fee'];//应付供应商=供应商成本-平台佣金
						if($new_balance_money>=$yf_supplier)
						{
							$update_arr=array(
									'balance_status'=>'2',  //已结算
									'balance_money'=>$new_balance_money,  //结算金额
									'balance_complete'=>'2'  //全部结算
							);
							$this->u_member_order_model->update($update_arr,array('id'=>$row['order_id']));
						}
						else
						{
							$update_arr=array(
									'balance_status'=>'0',  //未结算
									'balance_money'=>$new_balance_money,  //结算金额
									'balance_complete'=>'1'  //部分结算
							);
							$this->u_member_order_model->update($update_arr,array('id'=>$row['order_id']));
						}
					}
				}
	
			}
	
			//2、付款申请状态更改
			
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('u_reply'=>$reply,'employee_id'=>$employee_id,'employee_name'=>$employee['realname'],'u_time'=>date("Y-m-d H:i:s"));
			
			$num=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status !='=>'1')); //
			if($num==0)
				$data['status']="0";
			$this->u_payable_apply_model->update($data,array('id'=>$apply_id));
			
			//exit();
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已退回');
			}
		}
	}
	/**
	 * 付款申请(财务):拒绝
	 * */
	public function api_pay_manage_refuse()
	{
		$apply_id=$this->input->post("apply_id",true);
		$reply=$this->input->post("reply",true);
		$list=$this->input->post("list",true); //勾选的checkbox
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
			//将该付款下的订单，更改数据
	
			if(!empty($list))
			{
				foreach ($list as $k=>$v)
				{    //循环每个订单
					$row=$this->u_payable_order_model->row(array('id'=>$v));
					$this->u_payable_order_model->update(array('status'=>'5'),array('id'=>$v));
					//订单日志
					$this->write_order_log($row['order_id'],'在[付款管理]页面，审核拒绝序号'.$v.'(改为已拒绝):'.$row['amount_apply'].'元');
					//
					$this->u_member_order_model->update(array('balance_status'=>'0'),array('id'=>$row['order_id']));
				}
					
			}
			//更改信用申请的状态
			$num=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'2')); //待付款
			$num2=$this->u_payable_order_model->num_rows(array('payable_id'=>$apply_id,'status'=>'4')); //已付款
			if($num>0)
				$status="1";
			else if($num2>0)
				$status="3";
			else
				$status="4";
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('u_reply'=>$reply,'employee_id'=>$employee_id,'status'=>$status,'employee_name'=>$employee['realname'],'u_time'=>date("Y-m-d H:i:s"));
			$this->u_payable_apply_model->update($data,array('id'=>$apply_id));
				
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已拒绝');
			}
		}
	}
	
	/**
	 * 付款管理（财务）:版本二
	 * */
	public function pay_manage2()
	{
		$this->load->view("admin/t33/approve/pay_manage2");
	}
	/**
	 * 付款管理（财务）：api   版本二
	 * */
	public function api_pay_manage2()
	{
		$type=trim($this->input->post("type",true)); //类型 -1全部，1未提交，2已通过（代付款），3、5已退回，4已付款
		$supplier_name=trim($this->input->post("supplier_name",true)); //供应商名称
		$item_company=trim($this->input->post("item_company",true));//收款单位
		$pagesize=trim($this->input->post("pagesize",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$team_code=trim($this->input->post("team_code",true));
		$productname=trim($this->input->post("productname",true));
		$commit_name=trim($this->input->post("commit_name",true));
		$payable_id=trim($this->input->post("payable_id",true));
		
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = empty($pagesize)==true?sys_constant::B_PAGE_SIZE:$pagesize;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
	
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($item_company))
				$where['item_company']=$item_company;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($team_code))
				$where['team_code']=$team_code;
			if(!empty($productname))
				$where['productname']=$productname;
			if(!empty($commit_name))
				$where['commit_name']=$commit_name;
			if(!empty($payable_id))
				$where['payable_id']=$payable_id;
			
			if($type!="-1")
				$where['status']=$type; //默认-1
	
			$return=$this->u_payable_apply_model->payable_list3($where,$from,$page_size);
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
	 * 付款申请详情(财务) ： 版本二
	 * */
	public function pay_manage_detail2($id,$action="1")
	{
		$data['payable_order_id']=$id;
		$data['action']=$action;
		$union_id=$this->get_union();
		
		$result=$this->u_payable_apply_model->payable_list3(array('id'=>$id,'union_id'=>$union_id));
		$data['row']=$result['result'][0];
		$this->load->model('admin/t33/u_supplier_bank_model','u_supplier_bank_model'); //供应商银行账号
		$data['bank']=$this->u_supplier_bank_model->row(array('supplier_id'=>$data['row']['supplier_id']));
		$data['pics']=$this->u_payable_apply_pic_model->all(array('payable_id'=>$data['row']['payable_id']));
		$data['apply_id']=$data['row']['payable_id'];
	
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model'); //
		$data['supplier']=$this->u_supplier_model->row(array('id'=>$data['row']['supplier_id']));
	
		$this->load->view("admin/t33/approve/pay_manage_detail2",$data);
	}
	
}

/* End of file login.php */
