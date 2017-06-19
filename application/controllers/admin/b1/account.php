<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Account extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/account_model' );
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {
		// 结算
		$data['pageData'] = $this->account_model->get_exchange_data( array('status'=>'0'),$this->getPage () );
		//echo $this->db->last_query();
		$data['pageData1'] = $this->account_model->get_exchange_data( array('status'=>'1'),$this->getPage () );

		$data['jsondata']=(Array)json_decode($data['pageData']);
		$data['jsondata1']=(Array)json_decode($data['pageData1']);
		$this->load->view ( 'admin//b1/header.html' );
		$this->load->view ( "admin/b1/account_money", $data );
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
		$this->load_view ('admin/b1/show_account_order',$data);
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
		//$param= array('status'=>'0');
		$starttime=$this->input->post('starttime');
		$endtime=$this->input->post('endtime');
		$ordersn=$this->input->post('ordersnid');
		$order_status=$this->input->post('order_status');
		if($starttime!=''){
		    	if(empty($endtime)){
		    		$endtime=date('Y-m-d');
		    	}
			$param=array(
			    	'starttime'=>$starttime,
			    	'endtime'=>$endtime,
			);
			if($ordersn){
			    	$param['ordersn']=$ordersn;
			}

		}else{
		    	if(!empty($ordersn)){
		    		$param['ordersn']=$ordersn;
		    	}
		}
		if(!empty($order_status)){
		    	$type['status']=$order_status;
		}else{
		    	$type='';
		}
      		// var_dump($param);
		$data = $this->account_model->get_supplier_orde( $param, $this->getPage (),$type );
	//	echo $this->db->last_query();
		echo  $data ;
	}
	/**
	 * Ajax刷新显示供应商选中的订单数据
	 */
	function show_supplier_ajax_order() {
		$post_arr = array();
		$order_ids = explode ( ',', rtrim ( $this->input->post ( 'order_ids' ), "," ) );
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

		$order_ids = explode ( ',', rtrim ( $this->input->post ( 'order_ids' ), "," ) );
		$starttime = $this->input->post ( 'start_time',true );
		$endtime = $this->input->post ( 'end_time' ,true);
		$supplier_id = $login_id;
		$beizhu = $this->input->post ( 'beizhu' ,true);

		$brand=trim($this->input->post ( 'brand' ,true));
		$bankname=trim($this->input->post ( 'bankname' ,true));
		$bank_num=trim($this->input->post ( 'bank_num' ,true));
		$openman=trim($this->input->post ( 'openman' ,true));

		$supplier_bank['brand']=$brand;
		$supplier_bank['bankname']=$bankname;
		$supplier_bank['bank']=$bank_num;
		$supplier_bank['openman']=$openman;
		
		$orderType=$this->input->post ( 'orderType' ,true);

		if(empty($bankname)){
			echo json_encode(array('status'=>-2,'msg'=>'银行名称不能为空'));
			exit();
		}
		if(empty($brand)){
			echo json_encode(array('status'=>-2,'msg'=>'银行支行不能为空'));
			exit();
		}

		if(empty($openman)){
			echo json_encode(array('status'=>-2,'msg'=>'开户人不能为空'));
			exit();
		}

		if(!preg_match('/^\d{1,}$/', $bank_num)){
			echo json_encode(array('status'=>-2,'msg'=>'填写合法的银行卡号'));
			exit();
		}
		
		$res = $this->account_model->add_supplier_order ( $supplier_id, $starttime, $endtime, $beizhu, $order_ids,$supplier_bank,$orderType);
		if($res){
			echo  json_encode(array('status'=>1,'msg'=>'添加成功'));
		}else{
 			echo  json_encode(array('status'=>-1,'msg'=>'添加失败'));
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */