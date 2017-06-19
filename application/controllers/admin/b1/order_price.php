<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_price extends UB1_Controller {
	
	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
	//	$this->load->model ( 'admin/b1/order_price_model','order_price');
		$this->load->model ( 'admin/b1/order_price_model','order_price');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
	}
	public function index()
	{
		
		$data['pageData'] = $this->order_price->get_order_price(array('status'=>0),$this->getPage () );
		//  echo $this->db->last_query();
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/order_price',$data);
		$this->load->view('admin/b1/footer.html');
	}
	
	/*分页查询*/
	public function indexData(){		
		$page = $this->getPage ();
		$param = $this->getParam(array('status','linecode','linename','ordersn'));
		//var_dump($param);
		$data =  $this->order_price->get_order_price($param,$page );
		//echo $this->db->last_query();
		echo  $data ;
	}
	//获取订单修带价格
	function order_price_rowdata(){
		$id=$this->input->post('id');
		if($id>0){
			$data=$this->order_price->orderPriceRowdata($id);
			echo json_encode(array('status'=>1,'msg'=>'获取数据成功','data'=>$data));
			exit();
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
	    		exit();
		}			
	}
	//修改订单价格
	function up_order_price(){
		$id=$this->input->post('id');
		$reason=$this->input->post('reason');
		$price=$this->input->post('price');
		$line_id=$this->input->post('line_id');

		if($id>0 && !empty($price)){	
			$re=$this->order_price->up_price($id,$reason,$line_id);
			if($re>0){
				echo json_encode(array('status'=>1,'msg'=>'操做成功'));
				exit();
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'操做失败'));
				exit();
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'操做失败'));
	    	exit();	
		}
	}
	//拒绝更改订单价格
	function refuse_order_price(){
		$id=$this->input->post('id');
		$reason=$this->input->post('reason');
		$price=$this->input->post('price');
		if($id>0 && !empty($price)){
			$re=$this->order_price->refuse_price($id,$reason);
			if($re>0){
				echo json_encode(array('status'=>1,'msg'=>'操做成功'));
				exit();
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'操做失败'));
				exit();
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'操做失败'));
			exit();
		}
	}
}
