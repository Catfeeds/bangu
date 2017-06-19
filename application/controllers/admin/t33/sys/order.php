<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_send_msg.php';
include_once './application/controllers/msg/t33_refund_msg.php';
//"订单"控制器

class Order extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_union_bank_model','b_union_bank_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/common_model','common_model');
		
		$this->load->model('admin/t33/u_member_order_model','u_member_order_model');
		
		$this->load->model('admin/t33/bill/u_order_bill_yf_model','u_order_bill_yf_model');  //应付供应商、成本
		$this->load->model('admin/t33/bill/u_order_bill_ys_model','u_order_bill_ys_model');  //应收客人
		$this->load->model('admin/t33/bill/u_order_bill_yj_model','u_order_bill_yj_model');  //平台佣金
		$this->load->model('admin/t33/bill/u_order_bill_bx_model','u_order_bill_bx_model');  //保险
		$this->load->model('admin/t33/bill/u_order_bill_wj_model','u_order_bill_wj_model');  //保险
		
		$this->load->model('admin/t33/approve/u_order_refund_model','u_order_refund_model');  //退团订单表
		$this->load->model('admin/t33/approve/u_supplier_refund_model','u_supplier_refund_model'); //供应商退款申请
		$this->load->model('admin/t33/approve/u_order_receivable_model','u_order_receivable_model');  //订单收款表
	}
	
	/**
	 * 订单列表
	 * */
	public function order_list()
	{
		$this->load->view("admin/t33/order/list");
	}
	/**
	 * 订单列表：接口
	 * */
	public function api_order_list()
	{
		$productname=trim($this->input->post("productname",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$item_code=trim($this->input->post("item_code",true));
		$expert_name=trim($this->input->post("expert_name",true));
		$destname=trim($this->input->post("destname",true));
		$startplace=trim($this->input->post("startplace",true));
		$order_code=trim($this->input->post("order_code",true)); //order 6种状态
		$dest_id=trim($this->input->post("dest_id",true));
		$supplier_name=$this->input->post("supplier_name",true);
		$depart_id=trim($this->input->post("depart_id",true));
		$big_depart_id=trim($this->input->post("big_depart_id",true));//营业部（含子营业部）
		
		$supplier_code=trim($this->input->post("supplier_code",true));
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
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
			$child_depart=$this->b_depart_model->all(array('pid'=>$big_depart_id));
			$big_depart_id_in=$big_depart_id;
			if(!empty($child_depart)){
				foreach ($child_depart as $k=>$v){
					$big_depart_id_in=$big_depart_id_in.",".$v['id'];
				}
			}
			
			if(!empty($productname))
				$where['productname']=$productname;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($item_code))
				$where['item_code']=$item_code;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($destname))
				$where['destname']=$destname;
			if(!empty($startplace))
				$where['startplace']=$startplace;
			if(!empty($order_code))
				$where['order_code']=$order_code;
			if(!empty($dest_id))
				$where['dest_id']=$dest_id;
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($big_depart_id))
				$where['big_depart_id']=$big_depart_id_in;
			if(!empty($supplier_code))
				$where['supplier_code']=$supplier_code;
				
			$return=$this->u_member_order_model->order_list($where,$from,$page_size);
			$result=$return['result'];
			$total_page=ceil ( $return['rows']/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					'sql'=>$return['sql'],
					'account'=>$return['account'],
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	
	/**
	 * 订单详情
	 * */
	public function order_detail()
	{
		$order_id=$this->input->get("id",true);
		$action=$this->input->get("action",true);
		$data['order']=$this->F_order_detail($order_id);
		
		$data['order']['yf']=$this->u_order_bill_yf_model->all(array('order_id'=>$order_id)); //应付供应商
		$data['order']['yj']=$this->u_order_bill_yj_model->all(array('order_id'=>$order_id));  //平台佣金
		$data['order']['visitor']=$this->u_member_order_model->visitor_list($order_id);  //游客名单
		
		$data['order']['ys']=$this->u_order_bill_ys_model->all(array('order_id'=>$order_id));  //应收客人
		$data['order']['wj']=$this->u_order_bill_wj_model->all(array('order_id'=>$order_id,'status'=>'1'));  //外交佣金
		$data['order']['bx']=$this->u_order_bill_bx_model->all(array('order_id'=>$order_id));  //保险
		
		$data['order']['sk']=$this->u_order_receivable_model->all_rece(array('order_id'=>$order_id));  //保险
		
		//合同、发票、收据
		$data['contract']=$this->db->query("select group_concat(contract_code) as contract_code from b_contract_list where order_id=".$order_id)->row_array();
		$data['invoice']=$this->db->query("select group_concat(invoice_code) as invoice_code from b_invoice_list where order_id=".$order_id)->row_array();
		$data['receipt']=$this->db->query("select group_concat(receipt_code) as receipt_code from b_receipt_list where order_id=".$order_id)->row_array();
		
		$user=$this->userinfo();
		$data['order']['employee_name']=$user['realname'];
		$data['action']=$action;
		$data['expert_limit']=$this->u_member_order_model->order_expert_limit($order_id);

		$this->load->view("admin/t33/order/detail",$data);
	}
	//修改供应商成本 确认退团
	function save_tuituan_order(){
		//模板model 与b1 共用.修改时,需一起修改 
		$this->load->model ( 'admin/b1/order_status_model','b1_order_model' );
		$orderid=$this->input->post('orderid',true);
		$bill_id=$this->input->post('bill_id',true);
          
		if(!empty($bill_id)){

			//供应商成本
			$orderArr=$this->b1_order_model->sel_data('u_member_order',array('id'=>$orderid));
			if(empty($orderArr)){
				echo  json_encode(array('status'=>-1,'msg'=>' 该订单不存在!'));
				exit;
			}

			$bill=$this->b1_order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id));
			if(!empty($bill)){
				if($bill['status']==2){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已通过')); 
					exit;
				}
				if($bill['status']==4){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已拒绝'));
					exit;
				}
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>' 该条账单记录不存在!'));
				exit;
			}
			
					
			//-------------------判断管家账户余额是否够扣-----------------------
			//修改后的佣金;
			$item_price=$orderArr['supplier_cost']+$bill['amount'];
			$agent_fee=$orderArr['total_price']-$item_price-$orderArr['settlement_price']-$orderArr['diplomatic_agent'];
			//以前的佣金-修改后的佣金;
			$agent_change=$orderArr['depart_balance']-$agent_fee;
			$depart_limit=$this->b1_order_model->get_depart_limit($orderArr['depart_id']);
			if($agent_change>$depart_limit['cash_limit']&&$orderArr['status']!="9"){
				echo json_encode(array('status'=>-1,'msg'=>'营业部账户余额不足以抵扣调高的应付'));
				exit();
			}
			
			//订单操作日志 wwb
			$bill_row=$this->db->query("select * from u_order_bill_yf where id=".$bill_id)->row_array();
			$order_refund=$this->db->query("select id from u_order_refund where yf_id=".$bill_id)->row_array();
			$text="调整应付:";
			if(!empty($order_refund)) $text="退团的退应付:";
			$this->write_order_log($bill_row['order_id'],'审核通过'.$text.$bill_row['amount']);
			
			//已通过成本的账单get_order_yf_list
			$order_yf=$this->b1_order_model->get_order_yf_list($orderid,$bill_id);

			if($order_yf>$orderArr['total_price']){
				echo  json_encode(array('status'=>-1,'msg'=>'修改后的成本价不能少于订单总价')); 
				exit;
			}

			$re=$this->b1_order_model->update_bill_yf($orderid,$bill_id,$orderArr['supplier_id']);

			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'操作成功')); 
				exit;
			}else{
				//var_dump($re);
				echo  json_encode(array('status'=>-1,'msg'=>'该条账单记录不存在')); 
				exit;	
			}	
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'提交失败'));	
		}
	}
	/*拒绝成本价 退团*/
	function refuse_oderprice(){
		//模板model 与b1 共用.修改时,需一起修改 
		$this->load->model ( 'admin/b1/order_status_model','b1_order_model' );
		$orderid=intval($this->input->post('orderid',true));
		$bill_id=intval($this->input->post('bill_id',true));
      
		$s_remark='旅行社拒绝应付账单的修改';

		//供应商成本
		$orderArr=$this->b1_order_model->sel_data('u_member_order',array('id'=>$orderid));

        if(empty($orderArr)){
        	echo json_encode(array('status'=>-1,'msg'=>'该订单不存在'));
        	exit;
        }
        //订单操作日志
        $bill_row=$this->db->query("select * from u_order_bill_yf where id=".$bill_id)->row_array();
        $this->write_order_log($orderid,'审核拒绝调整应付:'.$bill_row['amount']);
        
		//账单
		$bill=$this->b1_order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id));
		if(!empty($bill)){

			if($bill['status']==4){
				echo json_encode(array('status'=>-1,'msg'=>'该账单已被拒绝了'));
				exit;
			}
			if($bill['status']==2){
				echo json_encode(array('status'=>-1,'msg'=>'该账单已被确认了'));
				exit;
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'该账单不存在了'));
			exit;
		}
		//已通过成本的账单
		$order_yf=$this->b1_order_model->get_order_yf_list($orderid,$bill_id);
		if($order_yf>$orderArr['total_price']){
			echo  json_encode(array('status'=>-1,'msg'=>'成本价不能少于订单总价')); 
			exit;
		}

		if($bill_id>0){
			$this->load->model ( 'admin/b1/apply_order_model','apply_order');
			$re=$this->apply_order->refuse_bill_yf($bill_id,$orderid,$orderArr['supplier_id'],$s_remark);
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'操作成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
		}else{
			 echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	//付款申请
	function get_payable(){
		$this->load->model ( 'admin/b1/apply_order_model','apply_order');
		$this->load->model ( 'admin/b1/order_status_model','b1_order_model' );
		$orderid=$this->input->get('orderid',true);
		$data['order']=$this->b1_order_model->sel_data('u_member_order',array('id'=>$orderid));
			
		$data['payable']=$this->apply_order->get_payable_list($orderid);
		$supplier_id=$data['order']['supplier_id'];
		//供应商账号
		$bank=$this->apply_order->get_table_data('u_supplier_bank',array('supplier_id'=>$supplier_id));
		$bankArr='';
		if(!empty($bank[0])){
			$data['bank']=$bank[0];
		}
		//供应商品牌名
		$supplier=$this->apply_order->get_table_data('u_supplier',array('id'=>$supplier_id));
		if($supplier[0]['company_name']){
			$data['company_name']=$supplier[0]['company_name'];
		}
		//已交款
		$whereArr['order_id='] = $orderid;
		$whereArr['status='] = 2;
		$data['receive'] = $this->b1_order_model->get_sum_receive($whereArr);
		
		//结算申请中
		if(!empty($data['payable'][0]['a_balance'])){
			$data['order']['a_balance']=$data['payable'][0]['a_balance'];
		}else{
			$data['order']['a_balance']=0;
		}

		$data['orderid']=$orderid;
		$this->load->view("admin/t33/order/payable",$data);
	}
	//申请预付款
	function p_payable_apply(){

		$this->load->model ( 'admin/b1/apply_order_model','apply_order');

		$orderid=$this->input->post('orderid',true); //批量的订单
		$money=$this->input->post('apply_money',true); //批量的申请金额
		$item_company=$this->input->post('p_item_company',true);
		$bankname=$this->input->post('p_bankname',true);
		$bankcompany=$this->input->post('p_bankcompany',true);
		$bankcard=$this->input->post('p_bankcard',true);
		$remark=$this->input->post('p_remark',true);
		$pay_way=$this->input->post('pay_way',true);
		if(!is_numeric($money)){
			echo  json_encode(array('status'=>-1,'msg'=>'填写申请金额格式不对'));
			exit();
		}
		if(empty($money)){
			echo  json_encode(array('status'=>-1,'msg'=>'请填写申请金额'));
			exit();
		}
		if(empty($orderid)){
			echo  json_encode(array('status'=>-1,'msg'=>'申请失败'));
			exit();
		}
		if($pay_way==-1){
			echo  json_encode(array('status'=>-1,'msg'=>'请选择付款方式'));
			exit();
		}else if($pay_way==1){

			if(empty($bankname)){
				echo  json_encode(array('status'=>-1,'msg'=>'请填写银行名称+支行'));
				exit();
			}
			if(empty($bankcompany)){
				echo  json_encode(array('status'=>-1,'msg'=>'请填写开户人'));
				exit();
			}
			if(empty($bankcard)){
				echo  json_encode(array('status'=>-1,'msg'=>'请填写开户帐号'));
				exit();
			}	
		}
		
		//订单申请
		$order=$this->apply_order->sel_data('u_member_order',array('id'=>$orderid));

		$bankData=array(
			'item_company'=>$item_company,
			'bankname'=>$bankname,
			'bankcompany'=>$bankcompany,
			'bankcard'=>$bankcard,
			'remark'=>$remark,
			'supplier_id'=>$order[0]['supplier_id'],
			'pay_way'=>$pay_way,
		);		 

		$order[0]['supplier_cost']=$order[0]['supplier_cost']-$order[0]['platform_fee'];


		if($money>$order[0]['supplier_cost']){
			echo  json_encode(array('status'=>-1,'msg'=>'申请结算金额不能大于扣除佣金后的成本价'));
			exit;
		}

		//已申请的金额
		$pay_my=$this->apply_order->get_pay_allmoney($orderid);
		if(!empty($pay_my['amount'])){
			$paymoney=$pay_my['amount'];

		}else{
			$paymoney=0;
		}
		$paymoney=$order[0]['balance_money']+$paymoney;
		if(!empty($paymoney)){
			$Pmoney=$paymoney+$money;
		}else{
			$Pmoney=$money;
		}

		if($Pmoney>$order[0]['supplier_cost'] ){

			echo  json_encode(array('status'=>-1,'msg'=>'申请结算金额不能大于成本价'));
			exit;
		}
	
		$receivable=$this->apply_order->get_order_receivable($orderid);

	 	if($Pmoney>$receivable['all_sk_money']){
	 		echo  json_encode(array('status'=>-1,'msg'=>'申请付款金额和已结算金额之和不能大于收款的金额'));
			exit;
	 	}

		$unionid=$this->get_union();
		
		$re=$this->apply_order->all_t33_payable_apply($orderid,$money,$bankData,$unionid);
		if($re){
			echo  json_encode(array('status'=>1,'msg'=>'申请成功'));
			exit;
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'申请成功'));
			exit;
		}
	}
	/**
	 * 修改平台佣金
	 * */
	public function update_platform_fee()
	{
		$order_id=$this->input->post("order_id",true);
		$project=$this->input->post("project",true);
		$price=$this->input->post("price",true);
		$num=$this->input->post("num",true);
		$my_date=$this->input->post("my_date",true);
		$beizhu=$this->input->post("beizhu",true);
		
		
		if(empty($order_id))  $this->__errormsg('订单id不能为空');
		//if(empty($beizhu))  $this->__errormsg('备注不能为空');
		if(empty($project))  $this->__errormsg('项目内容不能为空');
		if(empty($price))  $this->__errormsg('单价不能为空');
		if(empty($num))  $this->__errormsg('数量不能为空');
		
		$order=$this->u_member_order_model->row(array('id'=>$order_id));
		$new_platform_fee=$order['platform_fee']+$num*$price;
		if($new_platform_fee<0)   {$this->__errormsg('保存失败，负数金额小计不能大于平台佣金总计');exit();}
		
		$this->load->model('admin/t33/approve/u_payable_order_model','u_payable_order_model'); //付款关联订单表
		$pay_total=$this->u_payable_order_model->apply_order($order_id);
		$all=$pay_total['amount_apply']+$new_platform_fee;
		$allow=$order['supplier_cost']-$pay_total['amount_apply']-$order['platform_fee'];
		$allow=round($allow,2);
		if($order['supplier_cost']<$all) $this->__errormsg('当前最大可调整的平台佣金金额为'.$allow);

		$this->db->trans_begin();
		//1、写到账单
		$employee=$this->userinfo();
		$data=array(
			'order_id'=>$order_id,
			'item'=>$project,
			'user_type'=>'4',//旅行社
			'user_id'=>$employee['id'],
			'user_name'=>$employee['realname'],
			'num'=>$num,
			'price'=>$price,
			'amount'=>$price*$num,
			'remark'=>$beizhu,
			'union_id'=>$employee['union_id'],
			'addtime'=>$my_date,
			'status'=>'2'
		);
		$yj_id = $this->u_order_bill_yj_model->insert($data);
		//订单操作日志
		$this->write_order_log($order_id,'在订单详情页面，调整平台佣金：'.$data['amount']);
		//2、修改订单表的 platform_fee
		
		$this->u_member_order_model->update(array('platform_fee'=>$new_platform_fee),array('id'=>$order_id));
		
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
			$msgArr = $msg ->billYjChange($yj_id,1,$this->session->userdata('employee_realname'));
			$this->__data('已通过');
		}
	}
	/**
	 * 修改外交佣金
	 * */
	public function update_wj()
	{
		$order_id=$this->input->post("order_id",true);
		$project=$this->input->post("project",true);
		$price=$this->input->post("price",true);
		$num=$this->input->post("num",true);
		$my_date=$this->input->post("my_date",true);
		$beizhu=$this->input->post("beizhu",true);
	
	
		if(empty($order_id))  $this->__errormsg('订单id不能为空');
		//if(empty($beizhu))  $this->__errormsg('备注不能为空');
		if(empty($project))  $this->__errormsg('项目内容不能为空');
		if(empty($price))  $this->__errormsg('单价不能为空');
		if(empty($num))  $this->__errormsg('数量不能为空');
	
		$order=$this->u_member_order_model->row(array('id'=>$order_id));
		$new_diplomatic_agent=$order['diplomatic_agent']+$num*$price;
		$new_agent_fee=$order['agent_fee']-$num*$price;
		$add=$num*$price;
		if($order['agent_fee']==0&&$order['diplomatic_agent']==0)   {$this->__errormsg('管家佣金为0，不能进行调整');exit();}
		if($new_diplomatic_agent<0)   {$this->__errormsg('保存失败，外交佣金总计不能小于0');exit();}
		if(abs($add)>$order['agent_fee']&&$price>0)   {$this->__errormsg('保存失败，外交佣金不能大于管家佣金');exit();}
		//退团中订单不能改外交佣金
		if($order['status']=="-3")   {$this->__errormsg('保存失败，退团中订单不能修改外交佣金');exit();}
		$this->db->trans_begin();
		
		//3、写到账单
		$employee=$this->userinfo();
		$data=array(
				'order_id'=>$order_id,
				'item'=>$project,
				'user_type'=>'4',//旅行社
				'user_id'=>$employee['id'],
				'user_name'=>$employee['realname'],
				'num'=>$num,
				'price'=>$price,
				'amount'=>$price*$num,
				'remark'=>$beizhu,
				//'union_id'=>$employee['union_id'],
				'addtime'=>$my_date,
				'status'=>'1'
		);
		$wj_id = $this->u_order_bill_wj_model->insert($data);
		//订单操作日志
		$this->write_order_log($order_id,'在订单详情页面，调整外交佣金：'.$data['amount']);
		//2、修改订单表的 diplomatic_agent外交佣金、agent_fee管家佣金、管家已结佣金
		$chazhi=$order['depart_balance']-$new_agent_fee; //这个值大于0，就扣掉这个差值的营业部现金，小于0的时候，若叫全款，返差值佣金
		if($chazhi>0)
		{
			//4、营业部额度加减
			$depart=$this->b_depart_model->row(array('id'=>$order['depart_id']));
			$expert=$this->u_expert_model->row(array('id'=>$order['expert_id']));
			$new_cash_limit=$depart['cash_limit']-$chazhi;
			$this->b_depart_model->update(array('cash_limit'=>$new_cash_limit),array('id'=>$order['depart_id']));
			$limit_log=array(
					'depart_id'=>$order['depart_id'],
					'expert_id'=>$order['expert_id'],
					'expert_name'=>$order['expert_name'],
					'order_id'=>$order_id,
					'order_sn'=>$order['ordersn'],
					'order_price'=>$order['total_price'],
					'supplier_id'=>$order['supplier_id'],
					'cash_limit'=>$new_cash_limit,
					'union_id'=>$expert['union_id'],
					'credit_limit'=>$depart['credit_limit'],
					'addtime'=>date("Y-m-d H:i:s")
			);
			//if($price>=0)
			//{
				$limit_log['cut_money']=0-$chazhi;
				$limit_log['type']=$limit_log['remark']="调整外交佣金扣额度";
			//}
			//else
			//{
			//	$limit_log['cut_money']=0-$price*$num;
			//	$limit_log['type']=$limit_log['remark']="调整外交佣金加额度";
			//}
			$this->write_limit_log($limit_log);
			$this->u_member_order_model->update(array('depart_balance'=>$new_agent_fee),array('id'=>$order_id));
		}
		else 
		{
			 //5、交全款的时候返管家佣金
			$receive=$this->u_order_receivable_model->all(array('order_id'=>$order_id,'status'=>'2'));
			$re_money=0;//该订单总共交的钱
			if(!empty($receive))
			{
				foreach ($receive as $n=>$m)
				{
					$re_money+=$m['money'];
				}
			}
			$ys=$order['total_price']-$order['platform_fee']; //订单应收-平台佣金  （为了扣佣金）
			if($re_money>=$ys)//交全款
			{
				$depart=$this->b_depart_model->row(array('id'=>$order['depart_id']));
				$expert=$this->u_expert_model->row(array('id'=>$order['expert_id']));
				$new_cash_limit=$depart['cash_limit']-$num*$price;
				$this->b_depart_model->update(array('cash_limit'=>$new_cash_limit),array('id'=>$order['depart_id']));
				$limit_log=array(
						'depart_id'=>$order['depart_id'],
						'expert_id'=>$order['expert_id'],
						'expert_name'=>$order['expert_name'],
						'order_id'=>$order_id,
						'order_sn'=>$order['ordersn'],
						'order_price'=>$order['total_price'],
						'supplier_id'=>$order['supplier_id'],
						'cash_limit'=>$new_cash_limit,
						'union_id'=>$expert['union_id'],
						'credit_limit'=>$depart['credit_limit'],
						'addtime'=>date("Y-m-d H:i:s")
				);
				//if($price>=0)
				//{
				//	$limit_log['receivable_money']=0-$price*$num;
				//	$limit_log['type']=$limit_log['remark']="调整外交佣金扣额度";
				//}
				//else
				//{
					$limit_log['receivable_money']=0-$num*$price;
					$limit_log['type']=$limit_log['remark']="调整外交佣金加额度";
				//}
				$this->write_limit_log($limit_log);
				$this->u_member_order_model->update(array('depart_balance'=>$new_agent_fee),array('id'=>$order_id));
			}
			 
		}
		$this->u_member_order_model->update(array('diplomatic_agent'=>$new_diplomatic_agent,'agent_fee'=>$new_agent_fee),array('id'=>$order_id));
	    //3、u_order_bill_log
	    $log=$data;
	    unset($log['item']);
	    unset($log['status']);
	    unset($log['user_name']);
	    $log['remark']="外交佣金由".$order['diplomatic_agent']."改为".$new_diplomatic_agent;
	    $this->load->model('admin/t33/bill/u_order_bill_log_model','u_order_bill_log_model');  //日志
	    $this->u_order_bill_log_model->insert($log);

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			//发送消息jkr
			$msg = new T33_send_msg();
			$msgArr = $msg ->billWjChange($wj_id,1,$this->session->userdata('employee_realname'));
			$this->__data('已通过');
		}
	}
	/*
	 * 订单核算：单个核算
	 * */
	public function order_check_one()
	{
		$this->load->view("admin/t33/order/check_one");
	}
	/**
	 * 订单核算列表：接口
	 * */
	public function api_check_one_list()
	{
		$productname=trim($this->input->post("productname",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$supplier_name=trim($this->input->post("supplier_name",true));
		$expert_name=trim($this->input->post("expert_name",true));
		$destname=trim($this->input->post("destname",true));
		$dest_id=trim($this->input->post("dest_id",true)); //目的地id
		$startplace=trim($this->input->post("startplace",true));
		$team_code=trim($this->input->post("team_code",true));
		$depart_id=trim($this->input->post("depart_id",true));
		$big_depart_id=trim($this->input->post("big_depart_id",true));//营业部（含子营业部）
		
		$order_code=trim($this->input->post("order_code",true)); //order 1是未核算，2是已核算
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
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
			$child_depart=$this->b_depart_model->all(array('pid'=>$big_depart_id));
			$big_depart_id_in=$big_depart_id;
			if(!empty($child_depart)){
				foreach ($child_depart as $k=>$v){
					$big_depart_id_in=$big_depart_id_in.",".$v['id'];
				}
			}
			if(!empty($productname))
				$where['productname']=$productname;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($dest_id))
				$where['dest_id']=$dest_id;
			/* if(!empty($destname))
				$where['destname']=$destname; */
			if(!empty($startplace))
				$where['startplace']=$startplace;
			if(!empty($order_code))
				$where['order_code']=$order_code;
			if(!empty($team_code))
				$where['team_code']=$team_code;
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($big_depart_id))
				$where['big_depart_id']=$big_depart_id_in;
	
	
			$return=$this->u_member_order_model->check_one_list($where,$from,$page_size);
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
	/**
	 * 核算详情页面
	 * */
	public function check_detail()
	{
		$order_id=$this->input->get("id",true);
		$data['order']=$this->F_order_detail($order_id);
	
		$data['order']['yf']=$this->u_order_bill_yf_model->all(array('order_id'=>$order_id)); //应付供应商
		$data['order']['yj']=$this->u_order_bill_yj_model->all(array('order_id'=>$order_id));  //平台佣金
		$data['order']['ys']=$this->u_order_bill_ys_model->all(array('order_id'=>$order_id));  //应收客人
		$data['order']['bx']=$this->u_order_bill_bx_model->all(array('order_id'=>$order_id));  //保险
		$data['order']['wj']=$this->u_order_bill_wj_model->all(array('order_id'=>$order_id));  //外交佣金
		
		$data['order_id']=$order_id;
		//var_dump($data['order']);
		$this->load->view("admin/t33/order/check_detail",$data);
	}
	/**
	 * 订单核算:处理
	 * */
	public function do_check_one()
	{
		$order_id=$this->input->post("order_id",true);
		$value=$this->input->post("value",true);
		$action=$this->input->post("action",true);
	
		if(empty($order_id))  $this->__errormsg('订单id不能为空');
		if($value!="0"&&$value!="1")  $this->__errormsg('value值不合法');
		if(empty($action))  $this->__errormsg('action值不能为空');
	
		if($action=="ys")
		{
			if($value=="1")
			{
				$no_approve=$this->u_order_bill_ys_model->num_rows(array('order_id'=>$order_id,'status'=>'0')); //未审核的条数
				if($no_approve>0) $this->__errormsg('核算失败，该订单还存在未审核的应收项');
			}
				
			$this->u_member_order_model->update(array('ys_lock'=>$value),array('id'=>$order_id));
			$this->__data('操作成功');
		}
		if($action=="yf")
		{
			if($value=="1")
			{
				$no_approve=$this->u_order_bill_yf_model->num_rows("(order_id='{$order_id}' and (status=0 or status=1))"); //未审核的条数
				if($no_approve>0) $this->__errormsg('核算失败，该订单还存在未审核的应付项');
			}
				
			$this->u_member_order_model->update(array('yf_lock'=>$value),array('id'=>$order_id));
			$this->__data('操作成功');
		}
		if($action=="yj")
		{
			if($value=="1")
			{
				$no_approve=$this->u_order_bill_yj_model->num_rows("(order_id='{$order_id}' and (status=0 or status=1))"); //未审核的条数
				if($no_approve>0) $this->__errormsg('核算失败，该订单还存在未审核的平台佣金');
			}
				
			$this->u_member_order_model->update(array('yj_lock'=>$value),array('id'=>$order_id));
			
			//新增加
			if($value=="1")
			{
				$no_approve=$this->u_order_bill_wj_model->num_rows("(order_id='{$order_id}' and status=0)"); //未审核的条数
				if($no_approve>0) $this->__errormsg('核算失败，该订单还存在未审核的外交佣金');
			}
			
			//订单操作日志
			if($value=="1") $this->write_order_log($order_id,'核算订单成功');
			else $this->write_order_log($order_id,'撤销核算订单成功');
			
			$this->u_member_order_model->update(array('wj_lock'=>$value),array('id'=>$order_id));
			$this->u_order_bill_wj_model->update(array('is_lock'=>$value),array('order_id'=>$order_id));
			$this->u_order_bill_yj_model->update(array('is_lock'=>$value),array('order_id'=>$order_id));
			
			$this->__data('操作成功');
		}
		if($action=="wj")
		{
			if($value=="1")
			{
				$no_approve=$this->u_order_bill_wj_model->num_rows("(order_id='{$order_id}' and status=0)"); //未审核的条数
				if($no_approve>0) $this->__errormsg('核算失败，该订单还存在未审核的外交佣金');
			}
		
			$this->u_member_order_model->update(array('wj_lock'=>$value),array('id'=>$order_id));
			$this->__data('操作成功');
		}
		if($action=="bx")
		{
			$this->u_member_order_model->update(array('bx_lock'=>$value),array('id'=>$order_id));
			$this->__data('操作成功');
		}
		//一键核算、一键撤销核算
		if($action=="all")
		{
			if($value=="1")
			{
				/* $no_approve1=$this->u_order_bill_ys_model->num_rows(array('order_id'=>$order_id,'status'=>'0')); //未审核的条数
				if($no_approve1>0) $this->__errormsg('核算失败，该订单还存在未审核的应收项');
				$no_approve2=$this->u_order_bill_yf_model->num_rows("(order_id='{$order_id}' and (status=0 or status=1))"); //未审核的条数
				if($no_approve2>0) $this->__errormsg('核算失败，该订单还存在未审核的应付项');*/
				$no_approve3=$this->u_order_bill_yj_model->num_rows("(order_id='{$order_id}' and (status=0 or status=1))"); //未审核的条数 
				if($no_approve3>0) $this->__errormsg('核算失败，该订单还存在未审核的平台佣金');
				$no_approve4=$this->u_order_bill_wj_model->num_rows("(order_id='{$order_id}' and status=0)"); //未审核的条数
				if($no_approve4>0) $this->__errormsg('核算失败，该订单还存在未审核的外交佣金');
			}
			//$this->u_member_order_model->update(array('wj_lock'=>$value,'ys_lock'=>$value,'yf_lock'=>$value,'yj_lock'=>$value,'bx_lock'=>$value),array('id'=>$order_id));
			$this->u_member_order_model->update(array('wj_lock'=>$value,'yj_lock'=>$value),array('id'=>$order_id));
		    
			$this->__data('操作成功');
		}
	
	}
	/**
	 * 单团核算
	 * */
	public function order_check()
	{
		$this->load->view("admin/t33/order/check_list");
	}
	/**
	 * 单团核算列表：接口
	 * */
	public function api_check_list()
	{
		$productname=trim($this->input->post("productname",true));
		$dest_id=trim($this->input->post("dest_id",true));
	
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$supplier_name=trim($this->input->post("supplier_name",true));
		
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
		$day_start=trim($this->input->post("day_start",true));
		$day_end=trim($this->input->post("day_end",true));
		
		$team_code=trim($this->input->post("team_code",true));
		$startplace=trim($this->input->post("startplace",true));
		$order_code=trim($this->input->post("order_code",true)); //order 1是未核算，2是已核算
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = 10;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
				
			if(!empty($productname))
				$where['productname']=$productname;
			if(!empty($dest_id))
				$where['dest_id']=$dest_id;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($day_start))
				$where['day_start']=$day_start;
			if(!empty($day_end))
				$where['day_end']=$day_end;
			
			if(!empty($team_code))
				$where['team_code']=$team_code;
			if(!empty($startplace))
				$where['startplace']=$startplace;
			if(!empty($order_code))
				$where['order_code']=$order_code;
			
			$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
			$supplier=$this->b_company_supplier_model->all(array('union_id'=>$union_id,'status'=>'1'),'id','arr','supplier_id');

			$supplier_arr=array();
			$supplier_in="";
			if(!empty($supplier))
			{
				foreach ($supplier as $k=>$v)
				{
					array_push($supplier_arr, $v['supplier_id']);
				}
				$supplier_in=implode(",", $supplier_arr);
				$supplier_in="(".$supplier_in.")";
				$where['supplier_in']=$supplier_in;
			}
		
			$return=$this->u_member_order_model->check_list($where,$from,$page_size);
			if(empty($supplier)) //如果没有供应商，就没有记录
			{
				$result=array();
			}
			else 
			{
				$result=$return['result'];
			}
			
			$total_page=ceil ( $return['rows']/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					'sql'=>$return['sql'],
					'sql1'=>$return['sql1'],
					'sql2'=>$return['sql2'],
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	
	/**
	 * 团号下的所有订单
	 * */
	public function team_order($id,$action)
	{
		$data['id']=$id; //团号
		$data['row']=$this->u_member_order_model->check_detail($id);
		$data['action']=$action;
		$this->load->view("admin/t33/order/team_order",$data);
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
	 * 核算:操作
	 * */
	public function do_check()
	{
		$team_code=$this->input->post("team_code",true); //团号
		$list=$this->input->post("list",true); //订单id 数组
		$value=$this->input->post("action",true);  //1是核算，0是撤销核算
		
		if(empty($list))  $this->__errormsg('请选择要核算的订单');
		if($value!="0"&&$value!="1")  $this->__errormsg('action值不合法');
		
		//$order_list=$this->u_member_order_model->team_all_order($team_code);
		$this->db->trans_begin();
		foreach ($list as $k=>$v)
		{
			$order_id=$v;
			if($value=="1")
			{
				$no_approve1=$this->u_order_bill_ys_model->num_rows(array('order_id'=>$order_id,'status'=>'0')); //未审核的条数
				if($no_approve1>0) $this->__errormsg('核算失败，该订单还存在未审核的应收项');

				$no_approve3=$this->u_order_bill_yf_model->num_rows("(order_id='{$order_id}' and (status=0 or status=1))"); //未审核的条数
				if($no_approve3>0) $this->__errormsg('核算失败，该订单还存在未审核的应付项');
				
				$no_approve4=$this->u_order_bill_yj_model->num_rows("(order_id='{$order_id}' and (status=0 or status=1))"); //未审核的条数
				if($no_approve4>0) $this->__errormsg('核算失败，该订单还存在未审核的旅行社账单');

			}

			$this->u_member_order_model->update(array('ys_lock'=>$value,'yf_lock'=>$value,'yj_lock'=>$value,'bx_lock'=>$value),array('id'=>$order_id));

		}
		
		//更改 u_line_suit_price 表的核算状态
		$nocheck_num=$this->u_member_order_model->team_no_check($team_code);
		$hascheck_num=$this->u_member_order_model->team_has_check($team_code);
		if($nocheck_num==0)  //不存在为核算的时候，改为已核算
		{
			$this->db->where(array('description'=>$team_code));
			$this->db->update("u_line_suit_price",array('calculation'=>'1'));
		}
	
		if($hascheck_num==0)  //不存在已核算的时候，改为未核算
		{
			$this->db->where(array('description'=>$team_code));
			$this->db->update("u_line_suit_price",array('calculation'=>'0'));
		}
	
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			if($value=="1")
			    $this->__data('已核算');
			else 
				$this->__data('已撤销核算');
		}
	}
	
	
	/**
	 * 旅行社佣金结算
	 * */
	public function yj()
	{
		$this->load->view("admin/t33/order/yj");
	}
	/**
	 * 旅行社佣金结算：接口
	 * */
	public function api_yj()
	{
		$productname=trim($this->input->post("productname",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$item_code=trim($this->input->post("item_code",true));

		$type=trim($this->input->post("type_value",true)); //-1是全部
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
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
				
			if(!empty($productname))
				$where['productname']=$productname;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($item_code))
				$where['item_code']=$item_code;
            
            $where['status']=$type;
            $this->load->model('admin/t33/sys/b_union_agent_apply_model','b_union_agent_apply_model');
			if($type=="-1") //未结算 订单
			    $return=$this->u_member_order_model->yj_balance($where,$from,$page_size);
			else   //已申请  申请表
				$return=$this->b_union_agent_apply_model->yj_balance_apply($where,$from,$page_size);

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
	/**
	 * 结算佣金提交：接口
	 * */
	public function api_submit_yj()
	{
		$list=$this->input->post("list",true);  //订单id列表
		$reply=trim($this->input->post("reply",true));  //订单id列表
		
		if(empty($list))  $this->__errormsg('请选择要结算的订单');
		//if(empty($reply))  $this->__errormsg('请填写备注');
		
		$employee=$this->userinfo();
		$this->db->trans_begin();
		if(!empty($list))
		{
			// b_union_agent_apply_order => b_union_agent_apply 一对一关联
			foreach ($list as $k=>$v)
			{
				//1、
				$data=array(
						'union_id'=>$employee['union_id'],
						'union_name'=>$employee['union_name'],
						'employee_id'=>$employee['id'],
						'employee_name'=>$employee['realname'],
						'amount'=>$v['money'],
						'addtime'=>date("Y-m-d H:i:s"),
						'modtime'=>date("Y-m-d H:i:s"),
						'status'=>'0'
				);
				$this->load_model('admin/t33/sys/b_union_agent_apply_model','b_union_agent_apply_model');
				$apply_id=$this->b_union_agent_apply_model->insert($data);
				//2、
				$insert_data=array(
					'order_id'=>$v['order_id'],
					'apply_id'=>$apply_id,
					'money'=>$v['money'],
				);
				$this->db->insert("b_union_agent_apply_order",$insert_data);
				//3、订单里的union_balance 要加上 $v['money']
				$order=$this->u_member_order_model->row(array('id'=>$v['order_id']));
				$new_union_balance=$order['union_balance']+$v['money'];
				$this->u_member_order_model->update(array('union_balance'=>$new_union_balance),array('id'=>$v['order_id']));//更改订单的审核状态
			}
		
			
		}
		//提交
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
	 * 平台管理费审核
	 * */
	public function platform_fee()
	{
		$this->load->view("admin/t33/order/platform_fee");
	}
	/**
	 * 旅行社佣金结算：接口
	 * */
	public function api_platform_fee()
	{
		$type=trim($this->input->post("type",true));
	
		$user_name=trim($this->input->post("user_name",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
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
	
			if(!empty($user_name))
				$where['user_name']=$user_name;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if($type!="-1")
				$where['status']=$type;

			$return=$this->u_order_bill_yj_model->bill_yj($where,$from,$page_size);
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
	/**
	 * 平台管理费申请详情
	 * */
	public function platform_fee_detail($id="",$action="1")
	{
	
		$data['id']=$id;
	
		$data['action']=$action;
		$data['bill']=$this->u_order_bill_yj_model->detail(array('id'=>$id));
		$this->load->view("admin/t33/order/platform_fee_detail",$data);
	}
	/**
	 * 平台管理费:审核通过
	 * */
	public function api_platform_fee_deal()
	{
		$id=$this->input->post("id",true);  //u_order_bill_yj表id
		$reply=$this->input->post("reply",true);
		if(empty($id))
			$this->__errormsg('id不能为空');
		$this->db->trans_begin();
		$exist=$this->u_order_bill_yj_model->row(array('id'=>$id));
		
		if(empty($exist))
			$this->__errormsg('数据有误');
		else 
		{
			$order=$this->u_member_order_model->row(array('id'=>$exist['order_id']));
			$platform_fee=$order['platform_fee']+$exist['amount'];
			$this->u_member_order_model->update(array('platform_fee'=>$platform_fee),array('id'=>$exist['order_id']));
			
			$status=$this->u_order_bill_yj_model->update(array('status'=>'2','a_time'=>date("Y-m-d H:i:s"),'a_remark'=>$reply),array('id'=>$id));
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
		
	}
	/**
	 * 平台管理费:审核拒绝
	 * */
	public function api_platform_fee_refuse()
	{
		$id=$this->input->post("id",true);  //u_order_bill_yj表id
		$reply=$this->input->post("reply",true);
		if(empty($id))
			$this->__errormsg('id不能为空');
		$exist=$this->u_order_bill_yj_model->row(array('id'=>$id));
		if(empty($exist))
			$this->__errormsg('数据有误');
		else
		{
			$status=$this->u_order_bill_yj_model->update(array('status'=>'4','a_time'=>date("Y-m-d H:i:s"),'a_remark'=>$reply),array('id'=>$id));
		}
		if($status)
			$this->__data('已拒绝');
		else
			$this->__errormsg('操作异常');
	
	}
	/**
	 * 退团审批
	 * */
	public function reback()
	{
		$this->load->view("admin/t33/order/reback");
	}
	/**
	 * 退团审批：接口
	 * */
	public function api_reback()
	{
		$type=trim($this->input->post("type",true));
	
		$expert_name=trim($this->input->post("expert_name",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
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
	
			if(!empty($expert_name))
				$where['expert_name']=$expert_name;
			if(!empty($ordersn))
				$where['ordersn']=$ordersn;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if($type!="-1")
				$where['status']=$type;
	
			$return=$this->u_order_refund_model->apply_list($where,$from,$page_size);
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
	/**
	 * 退团审批：申请详情
	 * */
	public function reback_detail($id="",$action="1")
	{
	
		$data['id']=$id;
	
		$data['action']=$action;
		$data['bill']=$this->u_order_refund_model->detail(array('id'=>$id));
		$this->load->view("admin/t33/order/reback_detail",$data);
	}
	/**
	 * 退团审批:审核通过
	 * */
	public function api_reback_deal()
	{
		$id=$this->input->post("id",true);  //u_order_refund 表id
		$supplier_refund_id=$this->input->post("supplier_refund_id",true); //u_supplier_refund 表id
		$reply=$this->input->post("reply",true);
		$code_pic=$this->input->post("code_pic",true);
		
		$union_money=$this->input->post("union_money",true); //佣金
		if(empty($id))
			$this->__errormsg('id不能为空');
		$exist=$this->u_order_refund_model->row(array('id'=>$id));
		$this->db->trans_begin();
		if(empty($exist))
			$this->__errormsg('数据有误');
		else
		{
			//1、退团订单表
			$employee=$this->userinfo();
			$status=$this->u_order_refund_model->update(array('union_money'=>$union_money,'status'=>'3','code_pic'=>$code_pic,'u_remark'=>$reply,'employee_id'=>$employee['id'],'employee_name'=>$employee['realname']),array('id'=>$id));
			
			//2、订单操作日志
			$this->write_order_log($exist['order_id'],'审核通过退团：退应收'.$exist['ys_money'].'、退已交'.$exist['sk_money'].'、退应付'.$exist['yf_money'].'，退人：'.$exist['num'].'个');
			
			//2、添加平台管理费账单 + 平台佣金结算
			/* if($exist['num']==0)
				$price=$union_money;
			else 
				$price=$union_money/$exist['num'];
			$data=array(
				'order_id'=>$exist['order_id'],
				'item'=>'退团',
				'user_type'=>'3',
				'user_id'=>$employee['id'],
				'user_name'=>$employee['realname'],
				'num'=>$exist['num'],
				'price'=>$price,
				'amount'=>$union_money,
				'remark'=>'退团',
				'union_id'=>$employee['union_id'],
				'addtime'=>date("Y-m-d H:i:s"),
				'expert_id'=>$exist['expert_id'],
				'status'=>'2',
				'a_id'=>$employee['union_id'],
				'a_time'=>date("Y-m-d H:i:s")		
			);
			$this->u_order_bill_yj_model->insert($data); */
			//3、平台佣金结算
			/* $row=$this->u_member_order_model->row(array('id'=>$exist['order_id']));
			if(!empty($row))
			{
			$new_yj=$row['platform_fee']+$union_money;
			if((int)$new_yj<'0') $this->__errormsg('所退平台佣金不能大于原平台佣金');
			$this->u_member_order_model->update(array('platform_fee'=>$new_yj),array('id'=>$exist['order_id']));
			} */
			//4、供应商退款:有的话就退
			/* if(!empty($supplier_refund_id))
			{
				
				$one=$this->u_supplier_refund_model->row(array('id'=>$supplier_refund_id));
				if(!empty($one))
				{
					$employee=$this->userinfo();
					$order=$this->u_member_order_model->row(array('id'=>$one['order_id']));
					$new_balance_money=$order['balance_money']-$one['refund_money'];//$exist['refund_money']是正数； 已结算金额-退款金额
					$yf=$this->u_order_bill_yf_model->row(array('id'=>$exist['yf_id'])); 
					$new_supplier_cost=$order['supplier_cost']+$yf['price']; // 成本,$yf['price']是负数
					//更改balance_money和supplier_cost
					$this->u_member_order_model->update(array('balance_money'=>$new_balance_money,'supplier_cost'=>$new_supplier_cost),array('id'=>$one['order_id']));
					
					//更改agent_fee
					$new_agent_fee=$order['total_price']-$new_supplier_cost-$order['diplomatic_agent'];
					$this->u_member_order_model->update(array('agent_fee'=>$new_agent_fee),array('id'=>$one['order_id']));
					
					//退团，管家吐回利润
					$new_order=$this->u_member_order_model->row(array('id'=>$one['order_id']));
					if($row['status']=="-3") //退全款
					{
						$depart=$this->b_depart_model->row(array('id'=>$new_order['depart_id']));
						$new_cash_limit=$depart['cash_limit']-$new_order['depart_balance'];
						$this->b_depart_model->update(array('cash_limit'=>$new_cash_limit),array('id'=>$new_order['depart_id']));
							
						$log=array(
								'cash_limit'=>$new_cash_limit,
								'depart_id'=>$new_order['depart_id'],
								'expert_id'=>$new_order['expert_id'],
								'expert_name'=>$new_order['expert_name'],
								'order_id'=>$new_order['id'],
								'order_sn'=>$new_order['ordersn'],
								'union_id'=>$exist['union_id'],
								'supplier_id'=>$new_order['supplier_id'],
								'credit_limit'=>$depart['credit_limit'],
								'cut_money'=>0-$new_order['depart_balance'],
								'addtime'=>date("Y-m-d H:i:s"),
								'type'=>'退团扣除管家佣金',
								'remark'=>'退团扣除管家佣金'
						);
							
						$this->write_limit_log($log);
						$this->u_member_order_model->update(array('status'=>'-4','ispay'=>'4','depart_balance'=>'0'),array('id'=>$exist['order_id']));
					}
					else  //退部分款
					{
						$back_money=$new_order['depart_balance']-$new_order['agent_fee']; //需吐回的钱
						if($back_money>0)
						{
							$init=$this->b_depart_model->row(array('id'=>$row['depart_id']));
							$this->b_depart_model->update(array('cash_limit'=>$init['cash_limit']-$back_money),array('id'=>$new_order['depart_id']));
							$log=array(
									'cash_limit'=>$init['cash_limit']-$back_money,
									'depart_id'=>$new_order['depart_id'],
									'expert_id'=>$new_order['expert_id'],
									'expert_name'=>$new_order['expert_name'],
									'order_id'=>$new_order['id'],
									'order_sn'=>$new_order['ordersn'],
									'union_id'=>$exist['union_id'],
									'supplier_id'=>$new_order['supplier_id'],
									'credit_limit'=>$init['credit_limit'],
									'receivable_money'=>0-$back_money,
									'addtime'=>date("Y-m-d H:i:s"),
									'type'=>'退团扣除管家佣金',
									'remark'=>'退团扣除管家佣金'
							);
							$this->write_limit_log($log);
							$this->u_member_order_model->update(array('status'=>'4','depart_balance'=>$new_order['agent_fee']),array('id'=>$exist['order_id']));
						}
					}
					
					//更改供应商退款表的状态u_supplier_refund
					$this->u_supplier_refund_model->update(array('status'=>'1','employee_id'=>$employee['id'],'employee_name'=>$employee['realname'],'modtime'=>date("Y-m-d H:i:s"),'reply'=>$reply),array('id'=>$supplier_refund_id));

				}
			}   */
			
			//4、应付账单改状态
			$this->u_order_bill_yf_model->update(array('status'=>'2'),array('id'=>$exist['yf_id']));
			//5、退交款
			$reveive=$this->u_order_receivable_model->row(array('id'=>$exist['sk_id']));
			if(!empty($reveive))
			{
				/*if($reveive['status']=="1")
				{
					$this->hand_deal($exist['sk_id'], '', $employee['id']);
					
				}*/
				//改状态
				if($reveive['status']!='4')  //经理已拒绝的时候，不改状态
					$reveive=$this->u_order_receivable_model->update(array('status'=>'2'),array('id'=>$exist['sk_id']));
			} 
			
			
			//6、订单状态
			$row=$this->u_member_order_model->row(array('id'=>$exist['order_id']));
			if(($row['dingnum']+$row['oldnum']+$row['childnum']+$row['childnobednum'])=="0"&&$row['total_price']=="0")
				$this->u_member_order_model->update(array('status'=>'-4'),array('id'=>$exist['order_id']));
			
		}
		if ($this->db->trans_status() === FALSE)
		{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
		}
		else
		{
				$this->db->trans_commit();
				$msg = new T33_refund_msg();
				$msgArr = $msg ->sendMsgRefund($id,4,$this->session->userdata('employee_realname'));
				$this->__data('已通过');
		}
	
	}
	/**
	 * 旅行社:杂费列表
	 * */
	public function zafei()
	{
		$this->load->view("admin/t33/order/zafei");
	}
	/**
	 * 旅行社杂费列表：接口
	 * */
	public function api_zafei()
	{
		$employee_name=trim($this->input->post("employee_name",true));
		$depart_id=trim($this->input->post("depart_id",true));
		$depart_pid=trim($this->input->post("depart_pid",true));
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true)); 
		$item=trim($this->input->post("item",true));
		
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
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
	
			if(!empty($employee_name))
				$where['employee_name']=$employee_name;
			if(!empty($item))
				$where['item']=$item;
			if(!empty($starttime))
				$where['starttime']=$starttime;
			if(!empty($endtime))
				$where['endtime']=$endtime;
			if(!empty($price_start))
				$where['price_start']=$price_start;
			if(!empty($price_end))
				$where['price_end']=$price_end;
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($depart_pid))
				$where['depart_pid']=$depart_pid;
			
			$this->load->model('admin/t33/sys/b_depart_incidentals_model','b_depart_incidentals_model');  //营业部杂费
			$return=$this->b_depart_incidentals_model->zafei_list($where,$from,$page_size);
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
	/**
	 * 旅行社:新增杂费
	 * */
	public function zafei_add()
	{
		$union_id=$this->get_union();
		$data['depart']=$this->b_depart_model->all(array('pid'=>'0','status'=>'1','union_id'=>$union_id));
		$this->load->view("admin/t33/order/zafei_add",$data);
	}
	/**
	 * 二级部门
	 * */
	public function api_child_depart()
	{
		$pid=$this->input->post("pid",true);
		if(empty($pid))  $this->__errormsg('pid不能为空');
		
		$union_id=$this->get_union();
		$data=$this->b_depart_model->result(array('pid'=>$pid,'status'=>'1'));
        $this->__data($data);
	}
	/**
	 * 新增部门：提交
	 * */
	public function api_zafei_add()
	{
		$item=$this->input->post("item",true);
		$description=$this->input->post("description",true);
		$p_amount=$this->input->post("p_amount",true);
		$p_depart_id=$this->input->post("p_depart_id",true);
		$list=$this->input->post("list",true); //二级营业部
		if(empty($item))  $this->__errormsg('杂费名称不能为空');
		if(empty($p_depart_id))  $this->__errormsg('营业部不能为空');
	    
		$user=$this->userinfo();
		$addtime=date("Y-m-d H:i:s");
		$data=array(
			'depart_id'=>$p_depart_id,
			'depart_pid'=>'0',
			'union_id'=>$user['union_id'],
			'employee_id'=>$user['id'],
			'employee_name'=>$user['realname'],
			'item'=>$item,
			'amount'=>$p_amount,
			'description'=>$description,
			'addtime'=>$addtime
		);
		
		$this->load->model('admin/t33/sys/b_depart_incidentals_model','b_depart_incidentals_model');  //营业部杂费
		//1级营业部
		$this->db->trans_begin();
		if(!empty($p_amount))
		{
		  $this->b_depart_incidentals_model->insert($data);
		  
		  $depart=$this->b_depart_model->row(array('id'=>$p_depart_id));
		  $new_cash_limit=$depart['cash_limit']-$p_amount;
		  $this->b_depart_model->update(array('cash_limit'=>$new_cash_limit),array('id'=>$p_depart_id));
		  
		  $log=array(
		  	'depart_id'=>$p_depart_id,
		  	'union_id'=>$user['union_id'],
		  	'cash_limit'=>$new_cash_limit,
		  	'credit_limit'=>$depart['credit_limit'],
		  	'cut_money'=>0-$p_amount,
		  	'addtime'=>$addtime,
		  	'type'=>"扣杂费(".$item.")",
		  	'remark'=>"扣杂费(".$item.")"
		  );
		  $this->write_limit_log($log);
		}
		//2级营业部
		if(!empty($list))
		{
			foreach ($list as $k=>$v)
			{
				$zafei_data=array(
						'depart_id'=>$v['depart_id'],
						'depart_pid'=>$p_depart_id,
						'union_id'=>$user['union_id'],
						'employee_id'=>$user['id'],
						'employee_name'=>$user['realname'],
						'item'=>$item,
						'amount'=>$v['amount'],
						'description'=>$description,
						'addtime'=>$addtime
				);
				$this->b_depart_incidentals_model->insert($zafei_data);
				
				$one=$this->b_depart_model->row(array('id'=>$v['depart_id']));
				$new_amount=$one['cash_limit']-$v['amount'];
				$this->b_depart_model->update(array('cash_limit'=>$new_amount),array('id'=>$v['depart_id']));
				
				$log2=array(
						'depart_id'=>$v['depart_id'],
						'union_id'=>$user['union_id'],
						'cash_limit'=>$new_amount,
						'credit_limit'=>$one['credit_limit'],
						'cut_money'=>0-$v['amount'],
						'addtime'=>$addtime,
						'type'=>"扣杂费(".$item.")",
						'remark'=>"扣杂费(".$item.")"
				);
				$this->write_limit_log($log2);
			}//循环结束
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('已添加');
		}
		
	}//end
	
	

	//拒绝订单退团(不退人)
	function refuse_order_bill(){
		$this->load->model ( 'admin/b1/order_status_model','order_model' );
		$orderid=$this->input->post('orderid',true);
		$bill_id=$this->input->post('bill_id',true);
		$s_remark=$this->input->post('supplier_remark',true);
		//$supplier = $this->getLoginSupplier();
		//$supplier_id=$supplier['id'];
		if(intval($bill_id)>0){
		  
			$this->db->trans_start(); //事务开始
			//订单操作日志wwb
			$order_refund=$this->db->query("select * from u_order_refund where yf_id=".$bill_id.' and order_id='.$orderid)->row_array();
			$this->write_order_log($orderid,'拒绝退团(不退人):退应收'.$order_refund['ys_money'].'、退已交'.$order_refund['sk_money'].'、退应付'.$order_refund['yf_money']);
			//订单信息
			$order=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
			$supplier_id=$order['supplier_id'];
			//应付账单
			$bill_yf=$orderArr=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id,'order_id'=>$orderid));
			if($bill_yf['status']==4 ||$bill_yf['status']==3){
				echo json_encode(array('status'=>-1,'msg'=>'该账单已拒绝'));exit;
			}
			if($bill_yf['status']==2){
				echo json_encode(array('status'=>-1,'msg'=>'该账单已通过'));exit;
			}
			if($bill_yf['status']==0){
				echo json_encode(array('status'=>-1,'msg'=>'该账单需经理审核提交'));exit;
			}
	
			//应收账单
			$bill_ys=$this->order_model->sel_data('u_order_bill_ys',array('id'=>$bill_yf['ys_id'],'order_id'=>$orderid));
			if(empty($bill_ys)){
				echo json_encode(array('status'=>-1,'msg'=>'操作失败,不存在应收账单'));exit;
			}
			 
			//改应付账单
			$this->order_model->update_tabledata('u_order_bill_yf',array('status'=>4,'s_remark'=>$s_remark,'s_time'=>date('Y-m-d,H:i:s',time())), array('id'=>$bill_id));
		
			//退款账单
			$order_receiv=$this->db->query("select sum(cash_refund) as money from u_order_refund where ys_id={$bill_yf['ys_id']} and order_id={$orderid}")->row_array();
			if(empty($order_receiv['money'])){
				$order_receiv['money']=0;
			}
			$rece=$order_receiv['money'];
			
			//退应收-改应收账单
			$total_price=$order['total_price']-$bill_ys['amount'];
			$this->order_model->update_tabledata('u_member_order',array('total_price'=>$total_price), array('id'=>$orderid));
			$this->order_model->update_tabledata('u_order_bill_ys',array('status'=>3), array('id'=>$bill_ys['id']));
			 
			//退额度--营业部额度变化记录表
			$depart=$this->order_model->sel_data('b_depart',array('id'=>$order['depart_id']));
			$limitLog=array(
					'depart_id'=>$order['depart_id'],
					'expert_id'=>$order['expert_id'],
					'order_id'=>$order['id'],
					'union_id'=>$order['platform_id'],
					'supplier_id'=>$supplier_id,
					'addtime'=>date('Y-m-d H:i:s',time()),
					'order_sn'=>$order['ordersn'],
					'order_price'=>$order['total_price'],
					'remark'=>'旅行社拒绝退团',
			);
			//$limitMoney=$bill_ys['amount'];
			$limitMoney=-$rece;
			if($limitMoney>0){
				$limitLog['receivable_money']=$limitMoney;
				$limitLog['type']='旅行社拒绝退团,退营业部额度';
			}else{
				$limitLog['cut_money']=$limitMoney;
				$limitLog['type']='旅行社拒绝退团,扣营业部额度';
			}
			 
			$limitLog['cash_limit']=$depart['cash_limit']+$limitMoney;
			$this->db->insert ( 'b_limit_log', $limitLog );
			 
			//营业部额度
			$this->db->query("update b_depart set cash_limit=cash_limit+{$limitMoney} where id={$order['depart_id']} ");
			 
			//订单账单日志表
			$logArr=array(
					'order_id'=>$bill_yf['order_id'],
					'num'=>0,
					'type'=>1,
					'price'=>$bill_yf['price'],
					'amount'=>$bill_yf['amount'],
					'user_type'=>2,
					'user_id'=>$bill_yf['supplier_id'],
					'addtime'=>date("Y-m-d H:i:s",time()),
					'remark'=>'订单成本'.$order['supplier_cost'].',旅行社拒绝退团',
			);
			$this->db->insert ( 'u_order_bill_log', $logArr );
			 

	        if(!empty($bill_ys['sk_id'])){ //情况一:产生一条负交款单
	        	
	        	$this->order_model->update_tabledata('u_order_receivable',array('status'=>6), array('id'=>$bill_ys['sk_id']));
	        	
	        }else{ //情况二: 经理拒绝交款---改成未提交
	        		
	        	$refund=$this->order_model->sel_data('u_order_refund',array('yf_id'=>$bill_id,'order_id'=>$orderid));
	        	if(!empty($refund['sk_id'])){
	        		$sk_id=explode(',', $refund['sk_id']);
	        		if(!empty($sk_id)){
	        			foreach ($sk_id as $k=>$v){
	        				$this->order_model->update_tabledata('u_order_receivable',array('status'=>0), array('order_id'=>$order['id'],'id'=>$v));
	        			}
	        		}
	        	}
	        	
	        }
			
			//改退款表
			$this->order_model->update_tabledata('u_order_refund',array('status'=>-2), array('yf_id'=>$bill_id,'order_id'=>$orderid));
			 
			//-------修改订单扣款表----------
			$yf_money=-$bill_ys['amount'];
			$limit_money=$yf_money-$rece;  //单团信用额度
			$this->db->query("update u_order_debit set repayment=repayment-{$rece} where order_id={$orderid} and type=1 ");
			$this->db->query("update u_order_debit set repayment=repayment-{$limit_money} where order_id={$orderid} and type=3 ");
			
			//重新计算管家佣金
			$e_sql="update u_member_order set agent_fee=total_price-supplier_cost-settlement_price-diplomatic_agent where id={$orderid}";
			$this->db->query($e_sql);
			 
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}else{
				$this->db->trans_commit();
				 
				//获取退团信息
				$sql = 'select * from u_order_refund where yf_id='.$bill_id.' and order_id='.$orderid;
				$refundData = $this ->db ->query($sql) ->row_array();
				 
				$loginData = $this ->session ->userdata('loginSupplier');
				$msg = new T33_refund_msg();
				$msgArr = $msg ->sendMsgRefund($refundData['id'],3,$loginData['linkman']);
				 
				echo json_encode(array('status'=>1,'msg'=>'操作成功'));
			}
			 
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
		 
	}
	

	//旅行社确认退团退人
	function save_confirm_order(){
		
		$this->load->model ( 'admin/b1/order_status_model','order_model' );
		
		$orderid=$this->input->post('orderid',true);
		$bill_id=intval($this->input->post('bill_id',true));

		if($bill_id>0){
	
			$this->db->trans_start(); //事务开始
	
			//订单操作日志wwb
			$order_refund=$this->db->query("select * from u_order_refund where yf_id=".$bill_id.' and order_id='.$orderid)->row_array();
			$this->write_order_log($orderid,'通过退团(退'.$order_refund['num'].'人):退应收'.$order_refund['ys_money'].'、退已交'.$order_refund['sk_money'].'、退应付'.$order_refund['yf_money']);
				
			//供应商成本信息
			$orderArr=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
			$supplier_id=$orderArr['supplier_id'];

	
			//成本账单信息
			$bill=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id));
	
			if(!empty($bill)){
				if($bill['status']==2){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已通过,请刷新一下页面'));
					exit;
				}
				if($bill['status']==4 || $bill['status']==3){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已被拒绝,请刷新一下页面'));
					exit;
				}
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>' 该条账单不存在'));
				exit;
			}

			//-----------------------------1.修改供应商成本-------------------------
			$item_price=$orderArr['supplier_cost']+$bill['amount'];
			$this->order_model->update_tabledata('u_member_order',array('supplier_cost'=>$item_price), array('id'=>$orderid));
	
			//修改成本账单
			$billArr=array(
					'supplier_id'=>$supplier_id,
					's_time'=>date('Y-m-d,H:i:s',time()),
					'status'=>2,
			);
			$this->order_model->update_tabledata('u_order_bill_yf',$billArr, array('id'=>$bill['id']));
	
			//---------------------------------2.订单操作日记----------------------------------
			if($bill['kind']==2){
				$remark=" 订单价格{$orderArr['supplier_cost']} 改成 成本价{$item_price} ,";
				if(!empty($bill['num'])){ $remark.=" 退{$bill['num']}成人 , ";}
				if(!empty($bill['childnum'])){ $remark.=" 退{$bill['childnum']}小孩 , ";}
				if(!empty($bill['childnobednum'])){ $remark.=" 退{$bill['childnobednum']}小孩(不占床) , ";}
				if(!empty($bill['oldnum'])){ $remark.=" 退{$bill['oldnum']}老人 , ";}
			}else{
				$remark=" 订单价格{$orderArr['supplier_cost']} 改成 成本价{$item_price} ";
			}
			$logArr=array(
					'order_id'=>$bill['order_id'],
					'num'=>$bill['num'],
					'type'=>1,
					'price'=>$bill['price'],
					'amount'=>$bill['amount'],
					'user_type'=>2,
					'user_id'=>$bill['supplier_id'],
					'addtime'=>date("Y-m-d H:i:s"),
					'remark'=>$remark,
			);
			$this->db->insert ( 'u_order_bill_log', $logArr );
	
			//------------------------------4.订单退款表  状态改为2--------------------------------
			$yfdata=$this->order_model->sel_data('u_order_refund',array('yf_id'=>$bill_id,'order_id'=>$orderid));
			if(!empty($yfdata)){
				$this->order_model->update_tabledata('u_order_refund',array('status'=>2), array('order_id'=>$orderid,'yf_id'=>$bill_id));
			}
	
			//------------------------------------ 5.退管家佣金-----------------------------
			///订单是否交全款
			$receiva=$this->db->query("select  sum(money) as j_money  from u_order_receivable where order_id={$orderid} and (status=2 or status=1 or status=0)")->row_array();
			if(empty($receiva['j_money'])){
				$receiva['j_money']=0;
			}	
			if($receiva['j_money']>=$orderArr['total_price']){
	
				//营业部额度信息
				$depart=$this->db->query("select  cash_limit  from b_depart where id={$orderArr['depart_id']} ")->row_array();
	
				//修改后的佣金;
				$agent_fee=$orderArr['total_price']-$item_price-$orderArr['settlement_price']-$orderArr['diplomatic_agent'];
				//以前的佣金-修改后的佣金;
				$agent_change=$orderArr['depart_balance']-$agent_fee;
	
				//营业部额度变化记录表
				$limitLog=array(
						'depart_id'=>$orderArr['depart_id'],
						'expert_id'=>$orderArr['expert_id'],
						'order_id'=>$orderArr['id'],
						'union_id'=>$orderArr['platform_id'],
						'supplier_id'=>$supplier_id,
						'addtime'=>date("Y-m-d H:i:s"),
						'order_sn'=>$orderArr['ordersn'],
						'order_price'=>$orderArr['total_price'],
						'remark'=>'旅行社确认退团'
				);
				$limitMoney=-$agent_change;
				if($limitMoney>0){
					$limitLog['receivable_money']=$limitMoney;
					$limitLog['type']='旅行社确认退团,返回管家佣金';
				}else{
					$limitLog['cut_money']=$limitMoney;
					$limitLog['type']='旅行社确认退团,扣除管家佣金';
				}
				$limitLog['cash_limit']=$depart['cash_limit']+$limitMoney;
				$this->db->insert ( 'b_limit_log', $limitLog );
	
				//判断管家账户余额是否够用
				$depart_limit=$this->order_model->get_depart_limit($orderArr['depart_id']);
				if($agent_change>0){
					if($agent_change>$depart_limit['cash_limit']&&$orderArr['status']!="9"){
						echo json_encode(array('status'=>-1,'msg'=>'营业部账户余额不足以抵扣调高的应付'));
						exit();
					}
				}
				
				//营业部额度
				$this->db->query("update b_depart set cash_limit=cash_limit+{$limitMoney} where id={$orderArr['depart_id']} ");
				$this->db->query("update u_member_order set depart_balance=depart_balance+{$limitMoney} where id={$orderid} ");
			}
	
			//修改管家佣金  应交-应付-外交-保险
			$e_sql="update u_member_order set agent_fee=total_price-supplier_cost-settlement_price-diplomatic_agent where id={$orderid}";
			$this->db->query($e_sql);
			
			//订单操作日志
			$this->write_order_log($order_id,'');
	
			//---------------------------------6.修改订单价格--------------------------------------
			if($orderArr['status']==-3){  //退订中
				if($orderArr['total_price']==0){
					$this->order_model->update_tabledata('u_member_order',array('status'=>'-4','ispay'=>4,'depart_balance'=>0), array('id'=>$orderid));
				}
			}else{
				$this->order_model->update_tabledata('u_member_order',array('status'=>'4'), array('id'=>$orderid));
			}
	
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}else{
				$this->db->trans_commit();
				echo json_encode(array('status'=>1,'msg'=>'操作成功'));
			}
	
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	
	}
	
}

/* End of file login.php */
