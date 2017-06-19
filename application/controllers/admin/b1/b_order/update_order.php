<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Update_order extends  UB1_Controller{
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
		$param['status'] = 1;
		//项目选择
	       	$this->load_model ( 'common/u_dictionary_model', 'dictionary_model' );
		$data['item']=  $this ->dictionary_model ->getDictCodeLower('B2B_PREFERENTIAL_ITEM');

		$data['pageData'] = $this->apply_order->get_orderBill_apply($param,$this->getPage ());
		//echo $this->db->last_query();
		$this->load->view ( 'admin//b1/header.html' );
		$this->load->view ( "admin/b1/b_order/update_order_view",$data);
		$this->load->view ( 'admin/b1/footer.html' );

	}
	function indexData(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];
		$param['status'] = $this->input->post('status',true);
		//$linename=$this->input->post('linename',true);
		$linecode=$this->input->post('linecode',true);
		/*if(!empty($linename)){
			$param['linename']=$linename;
		}*/
		if(!empty($linecode)){
			$param['linecode']=$linecode;
		}
		//时间查询
		$line_time=$this->input->post('line_time',true);
		if(isset($line_time)&&!empty($line_time) ){
			$param['startdatetime'] =trim(substr(trim($line_time),0,10));
			$param['enddatetime'] = trim(substr(trim($line_time),12));
		}
		//var_dump($param);
    		$data = $this->apply_order->get_orderBill_apply($param,$this->getPage ());
    		//echo $this->db->last_query();
		echo  $data ;
	}
/*	function orderBillData(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];
		$linename=$this->input->post('linename',true);
		$linecode=$this->input->post('linecode',true);
		if(!empty($linename)){
			$param['linename']=$linename;
		}
		if(!empty($linecode)){
			$param['linecode']=$linecode;
		}
		//时间查询
		$line_time=$this->input->post('line_time',true);
		if(isset($line_time)&&!empty($line_time) ){
			$param['startdatetime'] =trim(substr(trim($line_time),0,10));
			$param['enddatetime'] = trim(substr(trim($line_time),12));
		}
		//var_dump($param);
    		$data = $this->apply_order->get_orderBill_apply($param,$this->getPage ());
		echo  $data ;
	}*/
	//申请付款信息
/*	function get_apply_money(){
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
	}*/
	//添加申请表
/*	function add_apply_money(){
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
			if($pay_money==$order['order_price']){
				echo json_encode(array('status' => -1,'msg' =>'申请金额不能等于成本价'));
				exit;	
			}
			
			$paymoney=$this->apply_order->get_pay_allmoney($orderid);//已申请的金额
			if(!empty($paymoney)){
				$allmoney=$paymoney['amount']+$pay_money;
			}else{
				$allmoney=$pay_money;
			}

			if($allmoney>$order['order_price']){
				echo json_encode(array('status' => -1,'msg' =>'申请金额不能大于成本价'));
				exit;	
			}

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

	}*/

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
	/**
	*@method 修改成本价
	*/
	function add_order_bill_price(){

		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$orderid=$this->input->post('orderid',true);
		$item=$this->input->post('item',true);
		$item_price=$this->input->post('item_price',true);
		if(empty($item)){
			echo  json_encode(array('status'=>-1,'msg'=>'请选择项目'));	
			exit();
		}else{
			$itemArr=$this->apply_order->sel_data('u_dictionary',array('dict_id'=>$item));
			if(empty($itemArr)){
				$item=$itemArr[0]['description'];
			}
			
		}

		if(empty($item_price)){
			echo  json_encode(array('status'=>-1,'msg'=>'请填写修改价格'));	
			exit();
		}
		//申请结算金额
		$flag=$this->apply_order->get_pay_allmoney($orderid);
		if(!empty($flag['amount'])){
			if($flag['amount']>$item_price){
				echo  json_encode(array('status'=>-1,'msg'=>'成本价已经小于已结算的金额'));	
				exit();
			}
		}

		if(!empty($orderid)){
			$bill=array(
				'order_id'=>$orderid,
				'item'=>$item,
				'item_price'=>$item_price,
				'supplier_id'=>$arr['id']
			);		
			$re=$this->apply_order->add_order_bill_yf($bill); 
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'提交成功'));	
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'提交失败'));	
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'提交失败'));	
		}
	}
	//申请成本价信息
	function get_order_bill(){
		$orderid=$this->input->post('orderid',true);
		$order=$this->apply_order->sel_data('u_member_order',array('id'=>$orderid));
		$bill_yf=$this->apply_order->sel_data('u_order_bill_log',array('order_id'=>$orderid,'user_type'=>2));
		if(!empty($order[0])){
			$order_price=$order[0]['supplier_cost'];
			echo  json_encode(array('status'=>1,'order'=>$order_price,'bill_yf'=>$bill_yf));	
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}		
	}
	//退团信息
	function get_price_bill(){
		$orderid=$this->input->post('orderid',true);
		$bill_id=$this->input->post('bill_id',true);
		if($bill_id>0){
			$order_bill=$this->apply_order->sel_data('u_order_bill_yf',array('id'=>$bill_id));
			if(!empty($order_bill)){
				$billArr=$order_bill[0];
			}else{
				$billArr='';
			}
			echo  json_encode(array('status'=>1,'order_bill'=>$billArr));

		}else{
		        echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
	// 修改订单
	function through_Oderprice(){
		$orderid=$this->input->post('orderid',true);
		$bill_id=$this->input->post('bill_id',true);
		$s_remark=$this->input->post('s_remark',true);
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );

		if($bill_id>0 && $orderid>0){

			$re=$this->apply_order->update_bill_yf($bill_id,$orderid,$arr['id'],$s_remark);
			//var_dump($re);
			if($re){
				if($re==2){
					echo  json_encode(array('status'=>-1,'msg'=>'成本价不能低于0元'));
				}elseif($re==3){
					echo  json_encode(array('status'=>1,'msg'=>'申请结算的金额已大于订单修改后的成本价'));	
				}else{
					echo  json_encode(array('status'=>1,'msg'=>'操作成功'));	
				}
				
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
		}else{
			 echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	//拒绝订单修改
	function refuse_Oderprice(){
		$orderid=$this->input->post('orderid',true);
		$bill_id=$this->input->post('bill_id',true);
		$s_remark=$this->input->post('s_remark',true);
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		if($bill_id>0 && $orderid>0){
			/*$paymoney=$this->apply_order->get_pay_allmoney($orderid);//已申请的金额
			if(!empty($paymoney)){
				$allmoney=$paymoney['amount']+$pay_money;
			}else{
				$allmoney=$pay_money;
			}*/

			$re=$this->apply_order->refuse_bill_yf($bill_id,$orderid,$arr['id'],$s_remark);
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'操作成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
		}else{
			 echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	
}