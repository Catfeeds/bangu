<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
include_once './application/controllers/msg/t33_send_msg.php';
class Apply_order extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/apply_order_model','apply_order');
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];
		//$param['status'] = 0;
		//项目选择
	    $this->load_model ( 'common/u_dictionary_model', 'dictionary_model' );
		$data['item']=  $this ->dictionary_model ->getDictCodeLower('B2B_PREFERENTIAL_ITEM');
		
		//银行信息
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$bank=$this->apply_order->get_table_data('u_supplier_bank',array('supplier_id'=>$arr['id']));
		$bankArr='';
		if(!empty($bank[0])){
			$data['bank']=$bank[0];
		}
		$param['apply_status']=0; //未结算
		$data['pageData'] = $this->apply_order->get_payable_apply($param,$this->getPage ());
		//echo $this->db->last_query();exit;
		//供应商品牌名
		$supplier=$this->apply_order->get_table_data('u_supplier',array('id'=>$arr['id']));
		if(!empty($supplier[0]['company_name'])){
			$data['company_name']=$supplier[0]['company_name'];
		}
		//var_dump($data['pageData'] );exit;
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( "admin/b1/apply/apply_order_view",$data);
		$this->load->view ( 'admin/b1/footer.html' );
	}
	//申请付款列表
	function indexData(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];
		//$param['status'] = $this->input->post('status',true);
		$linecode=$this->input->post('linecode',true);
		$linename=$this->input->post('linename',true);
		$ordersn=$this->input->post('ordersn',true);
		$linesn=$this->input->post('linesn',true);
		$apply_status=$this->input->post('apply_status',true);
		$sch_union_name=$this->input->post('sch_union_name',true);
		if(!empty($linecode)){
			$param['linecode']=$linecode;
		}
		if(!empty($linename)){
			$param['linename']=$linename;
		}
		if(!empty($ordersn)){
			$param['ordersn']=$ordersn;
		}
		//时间查询
		$starttime=$this->input->post('starttime',true);
		if(!empty($starttime)){
			$param['starttime'] = trim($starttime);
		}
		$endtime=$this->input->post('endtime',true);
		if(!empty($endtime)){
			$param['endtime'] = trim($endtime);
		}
		//旅行社
		if(!empty($sch_union_name)){
			$param['sch_union_name']=$sch_union_name;
		}
		//团号
		if(!empty($linesn)){
			$param['linesn']=$linesn;
		}
		if($apply_status>=0){
			$param['apply_status']=$apply_status;
		}
		//var_dump($param);
    	$data = $this->apply_order->get_payable_apply($param,$this->getPage ());
    	//echo $this->db->last_query();eixt;
		echo  $data ;
	}

	//申请付款信息
	function get_apply_money(){
		$orderid=$this->input->post('orderid',true);
		if($orderid>0){
			$this->load->library('session');
			$arr=$this->session->userdata ( 'loginSupplier' );
			//成本价
			$order=$this->apply_order->get_order_price($orderid); 
			//付款信息
			$payable=$this->apply_order->get_payable_order($orderid);

			//银行信息
			$bank=$this->apply_order->get_table_data('u_supplier_bank',array('supplier_id'=>$arr['id']));

			$bankArr='';
			if(!empty($bank[0])){
				$bankArr=$bank[0];
			}
			echo json_encode(array('status' => 1,'order' =>$order,'payable'=>$payable,'bank'=>$bankArr));
		}else{
			echo json_encode(array('status' => -1,'msg' =>'不存在记录!'));
		}	
	}
	//添加申请表
	function add_apply_money(){

		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$item_company=$this->input->post('item_company',true);
		$bankname=$this->input->post('bankname',true);
		$bankpeople=$this->input->post('bankpeople',true);
		$bankcard=$this->input->post('bankcard',true);
		$pay_money=$this->input->post('pay_money',true);
		$remark=$this->input->post('remark',true);
		$orderid=$this->input->post('orderid',true);
		if(empty($item_company)){
			echo json_encode(array('status' => -1,'msg' =>'收款单位不能为空'));
			exit;
		}
		if(empty($bankname)){
			echo json_encode(array('status' => -1,'msg' =>'银行名称不能为空'));
			exit;
		}
		if(empty($bankcard)){
			echo json_encode(array('status' => -1,'msg' =>'银行卡不能为空'));
			exit;
		}
		if(empty($pay_money)){
			echo json_encode(array('status' => -1,'msg' =>'申请金额不能为空'));
			exit;	
		}else{
			//成本价
			$order=$this->apply_order->get_order_price($orderid); 
			if($order['balance_status']==1){
				echo json_encode(array('status' => -1,'msg' =>'结算申请中'));
				exit; 
			}
			
			//$paymoney=$this->apply_order->get_pay_allmoney($orderid);//已申请的金额
			$paymoney=$order['balance_money'];
			if(!empty($paymoney)){
				$allmoney=$paymoney+$pay_money;
			}else{
				$allmoney=$pay_money;
			}
			if($allmoney>$order['order_price']){
				echo json_encode(array('status' => -1,'msg' =>'申请金额不能大于成本价'));
				exit;	
			}
			if(empty($allmoney)){
				echo json_encode(array('status' => -1,'msg' =>'申请金额不能为空'));
				exit;
			}
		/*	$updatePrice=$this->apply_order->get_orderBill_yf($orderid);
			if(!empty($updatePrice)){
				$order['order_price']=$updatePrice+$order['order_price'];
			}*/
/*			if($order['order_price']==0){
				echo json_encode(array('status' => -1,'msg' =>'已退团'));
				exit;	
			}*/
		}

		$payableArr=array(
			'supplier_id'=>$arr['id'],
			'item_company'=>$item_company,
			'remark'=>$remark,
			'bankcard'=>$bankcard,
			'bankname'=>$bankname,
			'status'=>0,
			'order_id'=>$orderid,
			'amount_apply'=>$pay_money,
			'bankpeople'=>$bankpeople,
		);

		$re=$this->apply_order->save_payable_order($payableArr);
		if($re){
			echo json_encode(array('status' => 1,'msg' =>'申请成功'));
		}else{
			echo json_encode(array('status' => -1,'msg' =>'申请失败'));	
		}

	}

	/**
	 * 贾开荣
	 * 验证字段的唯一性
	 * @param array $where 要验证的字段与值组成的数组
	 * @return boolean
	 */
	public function unique_field($where) {
		$this ->db ->select('mid');
		$this ->db ->from('u_member');
		$this ->db ->where($where);
		$query = $this ->db ->get();
		$data = $query ->result_array();
		if (empty($data))
			return true; //其值不存在
		else
			return false; //其值存在
	}

	//付款详情页
	function payable_detail(){
		$orderid=$this->input->get('id',true);
		if($orderid>0){
			//订单信息
			$data['orderid']=$orderid;
			$data['order']=$order=$this->apply_order->sel_data('u_member_order',array('id'=>$orderid));

			//付款信息
			$data['payable']=$this->apply_order->get_payable_order($orderid);
			//echo $this->db->last_query();
			$this->load->library('session');
			$arr=$this->session->userdata ( 'loginSupplier' );

			//银行信息
			$bank=$this->apply_order->get_table_data('u_supplier_bank',array('supplier_id'=>$arr['id']));
			$bankArr='';
			if(!empty($bank[0])){
				$data['bankArr']=$bank[0];
			}
			//var_dump($data['bankArr']);
			$this->load->view ( "admin/b1/apply/payable_detail_view",$data);
		}else{
			echo "<script>alert('不存在记录');history.go(-1);</script>";
		}
		
	}

	//保存批量申请付款
	function p_payable_apply(){
		$orderid=$this->input->post('order',true); //批量的订单
		$money=$this->input->post('apply_money',true); //批量的申请金额
		$item_company=$this->input->post('p_item_company',true);
		$bankname=$this->input->post('p_bankname',true);
		$bankcompany=$this->input->post('p_bankcompany',true);
		$bankcard=$this->input->post('p_bankcard',true);
		$remark=$this->input->post('p_remark',true);
		$pay_way=$this->input->post('pay_way',true);
		$unionid=0;

		if(empty($orderid)){
			echo  json_encode(array('status'=>-1,'msg'=>'请选择申请单'));
			exit();
		}
		if($pay_way==-1){
			echo  json_encode(array('status'=>-1,'msg'=>'请选择付款方式'));
			exit();
		}else if($pay_way==1){

		/*	if(empty($item_company)){
				echo  json_encode(array('status'=>-1,'msg'=>'请填写收款单位'));
				exit();
			}*/
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
		
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$bankData=array(
			'item_company'=>$item_company,
			'bankname'=>$bankname,
			'bankcompany'=>$bankcompany,
			'bankcard'=>$bankcard,
			'remark'=>$remark,
			'supplier_id'=>$arr['id'],
			'pay_way'=>$pay_way,
		);
		
		 foreach ($orderid as $key => $value) {

		 	if(empty($money[$key])){
				echo  json_encode(array('status'=>-1,'msg'=>'请填写结算金额,不能有0元的申请单'));
				exit;
		 	}elseif ($money[$key]=='0.00'){
		 	    echo  json_encode(array('status'=>-1,'msg'=>'请填写结算金额,不能有0元的申请单'));
		 	    exit;
		 	}
		 	
		 	//订单申请
		 	$arr=$this->session->userdata ( 'loginSupplier' );
			$order=$this->apply_order->sel_data('u_member_order',array('id'=>$value));

			if($order[0]['supplier_id']!=$arr['id']){
				echo  json_encode(array('status'=>-1,'msg'=>'该申请记录跟供应商账号对不上,请刷新页面再申请'));
				exit;
			}

			$order[0]['supplier_cost']=$order[0]['supplier_cost']-$order[0]['platform_fee'];
			/*if($order[0]['balance_status']==1 || $order[0]['balance_status']==2){
				echo  json_encode(array('status'=>-1,'msg'=>'申请订单正在结算中或已结算'));
				exit;
			}*/

		/* 	if($money[$key]>$order[0]['supplier_cost']){
				echo  json_encode(array('status'=>-1,'msg'=>'申请结算金额不能大于扣除佣金后的结算价'));
				exit;
			} */

			//已申请的金额
			$pay_my=$this->apply_order->get_pay_allmoney($value);
			if(!empty($pay_my['amount'])){
				$paymoney=$pay_my['amount'];

			}else{
				$paymoney=0;
			}
			$paymoney=$order[0]['balance_money']+$paymoney;
			if(!empty($paymoney)){
				$Pmoney=$paymoney+$money[$key];
			}else{
				$Pmoney=$money[$key];
			}
			//var_dump($Pmoneypaymoney);
			if($Pmoney>$order[0]['supplier_cost'] ){

				echo  json_encode(array('status'=>-1,'msg'=>'申请结算金额不能大于结算价'));
				exit;
			}


			$receivable=$this->apply_order->get_order_receivable($value);

		 	if($Pmoney>$receivable['all_sk_money']){
		 		echo  json_encode(array('status'=>-1,'msg'=>'申请付款金额和已结算金额之和不能大于收款的金额'));
				exit;
		 	}

			$unionid=$order[0]['platform_id'];
		 }
		
		 if(empty($unionid)){
			echo  json_encode(array('status'=>-1,'msg'=>'订单的旅行社不存在!'));
			exit;
		 }

		$re=$this->apply_order->all_p_payable_apply($orderid,$money,$bankData,$unionid);
		if($re){
			//发送消息jkr
			$msg = new T33_send_msg();
			$loginData = $this ->session ->userdata('loginSupplier');
			$msgArr = $msg ->payableApply($re ,1 ,$loginData['linkman']);
			
			echo  json_encode(array('status'=>1,'msg'=>'申请成功'));
			exit;
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'申请成功'));
			exit;
		}
	}	
	//展开订单申请记录
	function get_order_payable_list(){
		$orderid=$this->input->post('orderid',true);
		if(is_numeric($orderid)){
			$payable=$this->apply_order->get_payable_list($orderid);
			 //echo $this->db->last_query();
			echo json_encode(array('status' => 1,'data' =>$payable));
		}else{
			echo json_encode(array('status' => -1,'msg' =>'数据获取失败'));
		}	
	}
	//获取旅行社
	function get_depart_data(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$data=$this->apply_order->get_depart_list($arr['id']);
		echo json_encode($data); 
	}

}