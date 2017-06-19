<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Account_list extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/b_account_model' ,'account_model');
		$this->load->model ( 'admin/b1/apply_order_model','apply_order');
		header ( "content-type:text/html;charset=utf-8" );
	}

	/*新建结算单*/
	public function show_item_order(){
		$order_id=$this->input->get('id',true);
		$supplier = $this->getLoginSupplier();
		if(is_numeric($order_id)){
			//订单信息
			$order=$this->apply_order->sel_data('u_member_order',array('id'=>$order_id,'supplier_id'=>$supplier['id']));
			
			if(empty($order)){
				echo '<script>alert("您没有权限访问该订单");window.history.back(-1);</script>';
				exit;	
			}
			$data['order']=$order[0];
			//银行信息
			$this->load->library('session');
			$arr=$this->session->userdata ( 'loginSupplier' );
			$bank=$this->apply_order->get_table_data('u_supplier_bank',array('supplier_id'=>$arr['id']));
			$bankArr='';
			if(!empty($bank[0])){
				$data['bank']=$bank[0];
			}

			//供应商品牌名
			$supplier=$this->apply_order->get_table_data('u_supplier',array('id'=>$arr['id']));
			if($supplier[0]['company_name']){
				$data['company_name']=$supplier[0]['company_name'];
			}


			//申请预付款
			$where=array(
				//'order_id'=>$data['order']['id'],
				'item_code'=>$data['order']['item_code'],
			);
			$data['payable']=$this->apply_order->get_payable_item($where);
			//echo $this->db->last_query();

		}else{
			echo '<script>alert("不存在该订单");window.history.back(-1);</script>';exit;
		}


		$this->load_view ('admin/b1/b_account/b_account_order',$data);
	}

	public function index() {
		// 结算
		$data['pageData'] = $this->account_model->get_exchange_data( array('status'=>'0'),$this->getPage () );
		//echo $this->db->last_query();
		$data['pageData1'] = $this->account_model->get_exchange_data( array('status'=>'1'),$this->getPage () );

		$data['jsondata']=(Array)json_decode($data['pageData']);
		$data['jsondata1']=(Array)json_decode($data['pageData1']);
		$this->load->view ( 'admin//b1/header.html' );
		$this->load->view ( "admin/b1/b_account/account_list_view", $data );
		$this->load->view ( 'admin/b1/footer.html' );

	}
	/*结算管理未结算的分页查询*/
	public function indexData(){

		$line_time=$this->getParam(array('line_time'));
		$param = $this->getParam(array('status','ordersn'));
		//时间查询
		if(isset($line_time['line_time'])&&!empty($line_time['line_time']) ){
			$param['startdatetime'] =trim(substr(trim($line_time['line_time']),0,10));
			$param['enddatetime'] = trim(substr(trim($line_time['line_time']),12));
		}

		$data = $this->account_model->get_exchange_data( $param, $this->getPage () );
		//echo $this->db->last_query();
		echo  $data ;
	}
	/*结算管理已结算的分页查询*/
	public function indexData1(){
		$line_time=$this->getParam(array('line_time'));
		$param = $this->getParam(array('status','ordersn'));
		if(isset($line_time['line_time'])&&!empty($line_time['line_time']) ){ //时间查询
			$param['startdatetime'] =trim(substr(trim($line_time['line_time']),0,10));
			//$arr=explode('-', $param['startdatetime']);
			//$param['startdatetime']=$arr[0].'-'.$arr[2].'-'.$arr[1];
			$param['enddatetime'] = trim(substr(trim($line_time['line_time']),12));
		}

		$data = $this->account_model->get_exchange_data( $param, $this->getPage () );
		echo  $data ;
	}
	/*查看明细*/
	public function ajax_detail(){
		$id=$this->input->post('data');
		$data['detail']=$this->account_model->get_detail($id);
		//echo $this->db->last_query();
		echo json_encode(array('status'=>1,'data'=>$data['detail']));
	}
	/*新建结算单*/
	public function show_supplier_add_order(){
		$create_time = date ( 'Y-m-d H:i:s' );
		//启用session
		$arr=$this->getLoginSupplier();
		$login_name=$arr['login_name'];
		$supplier_id=$arr['id'];
		$data = array(
			'create_time' => $create_time,
			'supplier' => $login_name
		);

		$starttime=$this->input->get('starttime');
		$endtime=$this->input->get('endtime');
		if($starttime!=''){
			if(empty($endtime)){
				$endtime=date('Y-m-d');
			}
			$param=array(
				'starttime'=>$starttime,
				'endtime'=>$endtime,
			);
		}else{
			$param=null;
		}
		$type['status']=1;
		// 结算
		$data['pageData'] = $this->account_model->get_supplier_orde( $param,$this->getPage (),  $type );
		$data['starttime']=$starttime;
		$data['endtime']=$endtime;
		//供应商的银行信息
		$data['supplier_bank']=$this->account_model->get_supplier_bank($supplier_id);
		//合作的旅行社
		$data['union']=$this->account_model->get_company_supplier($supplier_id);
		//发票
	    $this->load_model ( 'common/u_dictionary_model', 'dictionary_model' );
		$data['invoice']=  $this ->dictionary_model ->getDictCodeLower('DICT_ENTITY');
		//var_dump($data['invoice']);

		$this->load_view ('admin/b1/b_account/b_account_order',$data);
	}
	/*供应商结算*/
	public function show_supplier_order(){
	  	$starttime=$this->input->get('starttime');
	   	$endtime=$this->input->get('endtime');
		if($starttime!=''){
			$param=array(
			    	'starttime'=>$starttime,
			    	'endtime'=>$endtime,
			);
		 }else{
		    	$param=null;
		 }
	    	$type['status']=1;
		// 结算
		$data['pageData'] = $this->account_model->get_supplier_orde( $param,$this->getPage (),$type );
		$data['starttime']=$starttime;
		$data['endtime']=$endtime;
		$this->load->view ( "admin/b1/account_order_detail", $data );
		$this->load->view ( 'admin/b1/footer.html' );
	}
	public function orderDate(){

		$param=array();
		$ordersn=$this->input->post('ordersn',true);
		$line_id=$this->input->post('line_id',true);
		$userdate=$this->input->post('userdate',true);
	
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$param['supplier_id']=$login_id;

		if(!empty($ordersn)){
	    		$param['ordersn']=$ordersn;
	    	}
	    	if(!empty($line_id)){
			$param['line_id']=$line_id;
	    	}
	    	if(!empty($userdate)){
			$param['userdate']=$userdate;
	    	}
      		// var_dump($param);
		$data = $this->account_model->get_supplier_orde( $param, $this->getPage ());
		//echo $this->db->last_query();
		echo  $data ;
	}
	/**
	 * Ajax刷新显示供应商选中的订单数据
	 */
	function show_supplier_ajax_order() {
		$post_arr = array();
		$order_ids =$this->input->post('order',true);
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$supplierId=$login_id;
		$order_list = $this->account_model->supplier_unsettled_order ( $post_arr, 0, 5, $supplierId, $order_ids );
	//	echo $this->db->last_query();
		echo json_encode ( $order_list );
	}

	/**
	 * 增加供应商还未结算的订单数据到数据库
	 *
	 */
	function add_supplier_order() {

		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$order_ids = explode ( ',', rtrim ( $this->input->post ( 'orderIds' ), "," ) );
		$supplier_id = $login_id;
		

		$open_man=trim($this->input->post ( 'open_man' ,true));
		$bankname=trim($this->input->post ( 'bankname' ,true));
		$brank=trim($this->input->post ( 'brank' ,true));
		$bank=trim($this->input->post ( 'bank' ,true));
		$beizhu =trim($this->input->post ( 'beizhu' ,true));
		$union_id = $this->input->post ( 'union_id' ,true);
		$invoice_entity=$this->input->post ( 'invoice_entity' ,true);

		$supplier_bank['brank']=$brank;
		$supplier_bank['bankname']=$bankname;
		$supplier_bank['bank']=$bank;
		$supplier_bank['open_man']=$open_man;

		if(empty($union_id)){
			echo json_encode(array('status'=>-1,'msg'=>'旅行社名称'));
			exit();
		}
		if(empty($open_man)){
			echo json_encode(array('status'=>-1,'msg'=>'开户人不能为空'));
			exit();
		}
		if(empty($bankname)){
			echo json_encode(array('status'=>-1,'msg'=>'银行名称不能为空'));
			exit();
		}
		if(empty($brank)){
			echo json_encode(array('status'=>-1,'msg'=>'银行支行不能为空'));
			exit();
		}
		if(!preg_match('/^\d{1,}$/', $bank)){
			echo json_encode(array('status'=>-1,'msg'=>'填写合法的银行卡号'));
			exit();
		}

		$res = $this->account_model->add_supplier_order ( $supplier_id, $invoice_entity,$beizhu,$union_id, $order_ids,$supplier_bank);
		if($res){
			echo  json_encode(array('status'=>1,'msg'=>'添加成功'));
		}else{
 			echo  json_encode(array('status'=>-1,'msg'=>'添加失败'));
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */