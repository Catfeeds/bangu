<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_send_msg.php';

//"交款2"控制器
class Approve2 extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/approve/u_order_receivable_model','u_order_receivable_model');  //订单收款表
		$this->load->model('admin/t33/approve/u_item_receivable_model','u_item_receivable_model');  // 一对多关联
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
		$data['action']=$this->input->get("action",true);
		$this->load->view("admin/t33/approve2/hand",$data);
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
		$ordersn=trim($this->input->post("ordersn",true));
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
			
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($shen_start))
				$where['shen_start']=$shen_start." 00:00:00";
			if(!empty($shen_end))
				$where['shen_end']=$shen_end." 23:59:59";
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($team_code))
				$where['team_code']=$team_code;
			

			//if(!empty($type))
				$where['status']=$type; //默认1

			$return=$this->u_item_apply_model->apply_list2($where,$from,$page_size);
			$result=$return['result'];
			$total_rows=$return['rows'];
			$total_page=ceil ( $total_rows/$page_size );
	        //var_dump($return['sql']);
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'sql'=>$return['sql'],
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
		$this->load->view("admin/t33/approve2/hand_detail",$data);
	}
	/*
	 * 交款申请: api接口
	*
	* */
	public function api_hand_detail()
	{
		$id=$this->input->post("batch",true); //u_order_receivable 表的batch 批次号
		$order_id=$this->input->post("order_id",true);
		$status=$this->input->post("status",true);
		if(empty($status)) $status="1";
		
		$result=$this->u_item_apply_model->receivable_list($id,$status,$order_id);
		$list="";
		if(!empty($result))
		{
			foreach ($result as $k=>$v)
			{
				$list=$v['receivable_id'].",".$list;
			}
			$list=substr($list, 0,-1);
		}
		
		$union_id=$this->get_union();
		if(empty($list))
		{
			$list=array();
		}
		else 
		{
		$where=array('list'=>$list); //去掉了 'status'=>'1'
		$list=$this->u_order_receivable_model->apply_list2($where);
		}
		
        $this->__data($list);
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

		$this->load->view("admin/t33/approve2/hand_add",$data);
	}
	/*
	 * 点击团号：所以的交款列表
	 * */
	public function hand_team_list()
	{
		$team_code=$this->input->get("team_code");
		$data['team_code']=$team_code;
		$this->load->view("admin/t33/approve2/hand_team",$data);
	}
	
	/*
	 *  批量提交：列表
	*   允许部分提交
	* */
	public function hand_submit()
	{
		$id=$this->input->get("id");
		$action=$this->input->get("action");
		if(empty($id))
		{
			$ids=$this->input->get("ids");
			$ids=substr($ids, 0,-1);
			
			$result=$this->u_item_apply_model->receivable_list($ids);
			$list="";
			if(!empty($result))
			{
				foreach ($result as $k=>$v)
				{
					$list=$v['receivable_id'].",".$list;
				}
				$list=substr($list, 0,-1);
			}
		}
		else 
		{
			$result=$this->u_item_apply_model->receivable_list($id);
			$list="";
			if(!empty($result))
			{
				foreach ($result as $k=>$v)
				{
					$list=$v['receivable_id'].",".$list;
				}
				$list=substr($list, 0,-1);
			}
		}
		
		$union_id=$this->get_union();
		$where=array('list'=>$list); //去掉了 'status'=>'1'
	    $result=$this->u_order_receivable_model->apply_list2($where);

	    $data['list']=$result['result'];
	    $data['list_id']=empty($id)==true?$ids:$id;
	    $data['action']=$action;
		$this->load->view("admin/t33/approve2/hand_submit",$data);
	}
	/*
	 *  批量提交：列表
	 *  不允许部分提交
	*
	* */
	public function hand_submit2()
	{
		$id=$this->input->get("batch"); //批次号
		$order_id=$this->input->get("order_id"); //批次号
		
		$action=$this->input->get("action");
		$status=$this->input->get("status",true); //状态
		if(empty($id))
		{
			$ids=$this->input->get("ids");  //批量的批次号
			$ids=substr($ids, 0,-1);
			$result=$this->u_item_apply_model->receivable_list($ids,$status,$order_id);
	
			$list="";
			if(!empty($result))
			{
				foreach ($result as $k=>$v)
				{
					$list=$v['receivable_id'].",".$list;
				}
				$list=substr($list, 0,-1);
			}
		}
		else
		{
			$result=$this->u_item_apply_model->receivable_list($id,$status,$order_id);
			$list="";
			if(!empty($result))
			{
				foreach ($result as $k=>$v)
				{
					$list=$v['receivable_id'].",".$list;
				}
				$list=substr($list, 0,-1);
			}
		}
	
		$union_id=$this->get_union();
        if(!empty($list))
        {
		$where=array('list'=>$list); //去掉了 'status'=>'1'
		$result=$this->u_order_receivable_model->apply_list2($where);
        }
        else $result['result']=array();
	
		$data['list']=$result['result'];
		$data['list_id']=empty($id)==true?$ids:$id;
		$data['action']=$action;
		$this->load->view("admin/t33/approve2/hand_submit2",$data);
	}
	/*
	 *  交款打印: 打印多条
	*
	* */
	public function hand_print()
	{
		$id=$this->input->get("batch"); //批次号
		$order_id=$this->input->get("order_id"); //批次号
		$status=$this->input->get("status");
		$union_id=$this->get_union();
		
		//var_dump($data['row']);
	    $result=$this->u_item_apply_model->receivable_list($id,$status,$order_id);
	    
	    $row=$this->u_item_apply_model->row(array('id'=>$result[0]['item_id']));
	    $data['row']=$row;
	    
		$list="";
		if(!empty($result))
		{
			foreach ($result as $k=>$v)
			{
				$list=$v['receivable_id'].",".$list;
			}
			$list=substr($list, 0,-1);
		}
	
		
		$where=array('list'=>$list); //去掉了 'status'=>'1'
		$result=$this->u_order_receivable_model->apply_list2($where);
	
		$data['list']=$result['result'];
		$data['list_id']=$id;
		//var_dump($data);
		$this->load->view("admin/t33/approve2/hand_print",$data);
	}
	/*
	 *  交款打印: 打印单条
	*
	* */
	public function hand_print_one()
	{
		$id=$this->input->get("id");
		
		if(empty($id)) $this->__errormsg('id不能为空');
	    $list="(".$id.")";
	
		$where=array('list'=>$list); //去掉了 'status'=>'1'
		$result=$this->u_order_receivable_model->apply_list2($where);
	
		$data['list']=$result['result'];
		$data['list_id']=$id;
		//var_dump($data);
		$this->load->view("admin/t33/approve2/hand_print_one",$data);
	}
	/**
	 * 不同交款下-》不同状态的交款数
	 * */
	public function receivable_num()
	{
		$id=$this->input->post("id",true);  //u_item_apply表id
		$status=$this->input->post("status",true);
		if(empty($id))  $this->__errormsg('id不能为空');
		if(empty($status))  $this->__errormsg('status不能为空');
		$num=$this->u_item_apply_model->receivable_num($id,$status); //status: 1是申请中，2是通过，3是拒绝
		$this->__data($num);
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
			$list=substr($list, 0,-1);
			$list_arr=explode(",", $list);
            foreach ($list_arr as $k=>$v)
            {
			  $this->hand_deal($v, $reply,$employee_id); //提交
			  
			  //修改的u_item_apply表的状态
			  $row=$this->u_item_receivable_model->row(array('receivable_id'=>$v));
			  /*$shenqing_num=$this->u_item_apply_model->receivable_num($row['item_id'],$status="1"); //申请中的数目
			  $tongguo_num=$this->u_item_apply_model->receivable_num($row['item_id'],$status="2"); //通过的数目
			  $zt="0";
			  if($shenqing_num>0)
			    $zt="0";
			  else if($tongguo_num>0)
			  	$zt="1";
			  else 
			  	$zt="2"; */
			  //var_dump($shenqing_num); var_dump($tongguo_num);var_dump($zt);
			  $user=$this->userinfo();
			  $this->u_item_apply_model->update(array('employee_name'=>$user['realname'],'reply'=>$reply,'modtime'=>date("Y-m-d H:i:s")),array('id'=>$row['item_id']));
            }

           // exit();
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
				$msgArr = $msg ->receivableApprove(rtrim($list,','),2,$this->session->userdata('employee_realname'));
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
			$list=substr($list, 0,-1);
			$list_arr=explode(",", $list);
			foreach ($list_arr as $k=>$v)
			{
				$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			    $data=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'3','employee_name'=>$employee['realname'],'modtime'=>date("Y-m-d H:i:s"));
			    $this->u_order_receivable_model->update($data,array('id'=>$v));
			    
			    //修改的u_item_apply表的状态
			    $row=$this->u_item_receivable_model->row(array('receivable_id'=>$v));
			    $shenqing_num=$this->u_item_apply_model->receivable_num($row['item_id'],$status="1"); //申请中的数目
			    $tongguo_num=$this->u_item_apply_model->receivable_num($row['item_id'],$status="2"); //通过的数目
			    $zt="0";
			    if($shenqing_num>0)
			    	$zt="0";
			    else if($tongguo_num>0)
			    	$zt="1";
			    else
			    	$zt="2";
			    //var_dump($shenqing_num); var_dump($tongguo_num);var_dump($zt);
			    $this->u_item_apply_model->update(array('status'=>$zt),array('id'=>$row['item_id']));
			    
			}
			//exit();
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
		//批次号
		$this->load->model('admin/t33/approve/code_sk_batch_model','code_sk_batch_model');  // 一对多关联
		$sk_batch=$this->code_sk_batch_model->insert(array('code'=>'A'));
		
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->detail($employee_id);
		$addtime=date("Y-m-d H:i:s");
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
		//1.2 增加 u_item_apply
		$this->load->model('admin/t33/approve/code_sk_batch_model','code_sk_batch_model');  // 一对多关联
		$sk_batch=$this->code_sk_batch_model->insert(array('code'=>'A'));
		$item_data=array(
			'item_code'=>$sk_batch,
			'expert_id'=>$expert_id,
			'amount'=>$money,
			'remark'=>$remark,
			'addtime'=>$addtime,
			'modtime'=>$addtime,
			'status'=>'1',
			'employee_id'=>$employee_id,
			'employee_name'=>$employee['realname'],
			'union_id'=>$employee['union_id'],
			'depart_id'=>$depart_id
		);
		$item_id=$this->u_item_apply_model->insert($item_data);
		//1.3  u_item_receivable
		$this->u_item_receivable_model->insert(array('receivable_id'=>$receivable_id,'item_id'=>$item_id));
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
			//更改信用申请的状态
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
	
	//end
	
	/*
	 * 分割线
	 * */
	public function ____________________1()
	{
		
	}
	/**
	 * 销售申请结算
	 * */
	public function hand_bank()
	{
		$data['action']=$this->input->get("action",true);
		$this->load->view("admin/t33/approve2/hand_bank",$data);
	}
	/**
	 * 交款申请列表：api
	 * */
	public function api_hand_bank()
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
			$where['is_hand_bank']=true; //银行认款	
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
	public function hand_bank_detail()
	{
		$id=$this->input->get("id",true); //u_order_receivable 表id
		$action=$this->input->get("action",true); //动作    1是查看，2是审核
		$data['list']=$this->u_order_receivable_model ->item_apply_detail(array('id'=>$id));
		$data['apply_id']=$id;
		$data['action']=$action;
		$this->load->view("admin/t33/approve2/hand_bank_detail",$data);
	}
	function pic_detail()
	{
		$data['url']=$this->input->get("url",true);
		
		$this->load->view("admin/t33/approve2/pic_detail",$data);
	}
	/*
	 *  新增收款
	*
	* */
	public function hand_bank_add()
	{
		$union_id=$this->get_union();
		$user=$this->userinfo();
		$expert_list=$this->u_expert_model->union_expert($union_id);
		$data['expert_list']=$expert_list;
		$data['m_date']=date("Y-m-d");
		$data['user']=$user;
	
		$this->load->view("admin/t33/approve2/hand_bank_add",$data);
	}
	
	/*
	 *  交款打印
	*
	* */
	public function hand_bank_print()
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
		$this->load->view("admin/t33/approve2/hand_bank_print",$data);
	}
	/**
	 * 打印改状态
	 * */
	public function api_bank_print_ok()
	{
		$id=$this->input->post("id",true);  //u_order_receivable表id
		if(empty($id))  $this->__errormsg('id不能为空');
		$status=$this->u_order_receivable_model->update(array('is_print'=>'1'),array('id'=>$id));
		$this->__data('已打印');
	}
	
	/**
	 * 新增交款
	 * */
	public function api_hand_bank_add()
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
		//if(empty($code))  $this->__errormsg('凭证号不能为空');
		/* if(empty($type))  $this->__errormsg('发票类型不能为空');
		if(empty($invoice_code))  $this->__errormsg('收据号不能为空');
		if(empty($voucher))  $this->__errormsg('收款单号不能为空'); */
		//if(empty($remark))  $this->__errormsg('备注不能为空');
		
	/* 	$exist=$this->u_order_receivable_model->row(array('code'=>$code));
		if(!empty($exist))  $this->__errormsg('凭证号已存在，请重新填写'); */
		//批次号
		$this->load->model('admin/t33/approve/code_sk_batch_model','code_sk_batch_model');  // 一对多关联
		$sk_batch=$this->code_sk_batch_model->insert(array('code'=>'A'));
		
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->detail($employee_id);
		$addtime=date("Y-m-d H:i:s");
		$data=array(
			'expert_id'=>$expert_id,
			'depart_id'=>$depart_id,
			'money'=>$money,
			//'voucher'=>$voucher,
			'bankname'=>$bankname,
			'bankcard'=>$bankcard,
			//'code'=>$code,
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
		//1.2 增加 u_item_apply
		$this->load->model('admin/t33/approve/code_sk_batch_model','code_sk_batch_model');  // 一对多关联
		$sk_batch=$this->code_sk_batch_model->insert(array('code'=>'A'));
		$item_data=array(
			'item_code'=>$sk_batch,
			'expert_id'=>$expert_id,
			'amount'=>$money,
			'remark'=>$remark,
			'addtime'=>$addtime,
			'modtime'=>$addtime,
			'status'=>'1',
			'employee_id'=>$employee_id,
			'employee_name'=>$employee['realname'],
			'union_id'=>$employee['union_id'],
			'depart_id'=>$depart_id
		);
		$item_id=$this->u_item_apply_model->insert($item_data);
		//1.3  u_item_receivable
		$this->u_item_receivable_model->insert(array('receivable_id'=>$receivable_id,'item_id'=>$item_id));
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
	public function api_hand_bank_deal()
	{
		$item_id=$this->input->post("item_id",true);  //u_order_receivable表id
		$voucher=$this->input->post("voucher",true);
		if(empty($item_id))  $this->__errormsg('交款id不能为空');
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$one=$this->u_order_receivable_model->row(array('id'=>$item_id));
			$exist=$this->u_order_receivable_model->num_rows(array('bankcard'=>$one['bankcard'],'voucher'=>$voucher));
			if($exist>0) $this->__errormsg('该流水号已经被使用');
			
			$this->db->trans_begin();
			$reply="";//审核意见
			$this->hand_deal($item_id, $reply,$employee_id); //提交
			$this->u_order_receivable_model->update(array('voucher'=>$voucher),array('id'=>$item_id));
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
				$msgArr = $msg ->receivableApprove($item_id,2,$this->session->userdata('employee_realname'));
				$this->__data('已通过');
			}
			//end
		}
	}
	
	/**
	 * 交款申请:拒绝
	 * */
	public function api_hand_bank_refuse()
	{
		$item_id=$this->input->post("item_id",true);  //u_order_receivable表id
		$reply=$this->input->post("reply",true);
		if(empty($item_id))  $this->__errormsg('申请id不能为空');
		//if(empty($reply))   $this->__errormsg('拒绝原因不能为空');
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
			//不用退回账户
			/* if($row['way']=="账户余额")
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
			} */
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
	
}

/* End of file login.php */
