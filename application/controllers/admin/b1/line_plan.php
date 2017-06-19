<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2016-10-30
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line_plan extends UB1_Controller {
	function __construct() {
	
		parent::__construct ();

		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
			'form', 
			'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/user_shop_model',"user_shop_model" );

		header ( "content-type:text/html;charset=utf-8" );
				
	}

	public function index(){
 
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/line_plan' );
		$this->load->view ( 'admin/b1/footer.html' );
	}

	public function indexData(){

		//分页
		$page = $this->input->post ( 'page', true );
		$page_size = sys_constant::B_PAGE_SIZE;
		//$page_size="1";
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;

		$page = $this->getPage ();
		$supplier = $this->getLoginSupplier();
		$param=array('supplier_id'=>$supplier['id']);

		$linecode=$this->input->post('linecode',true);
		if(!empty($linecode)){
			$param['linecode']=$linecode;
		}

		$linename=$this->input->post('linename',true);
		if(!empty($linename)){
			$param['linename']=$linename;
		}

		$lineitem=$this->input->post('lineitem',true);
		if(!empty($lineitem)){
			$param['lineitem']=$lineitem;
		}

		$starttime=$this->input->post('starttime',true);
		if(!empty($starttime)){
			$param['starttime']=$starttime;
		}

		$endtime=$this->input->post('endtime',true);
		if(!empty($endtime)){
			$param['endtime']=$endtime;
		}

		$param['type']=$this->input->post('type',true);

		$return=$this->user_shop_model->get_line_itemlist($param,$from,$page_size);
		//echo  $this->db->last_query();
		$result=$return['result'];
		$total_page=ceil ( $return['rows']/$page_size );
	
		if(empty($result)){
			$output= json_encode ( array (
				'code' =>"4001",
				'msg' =>"data empty",
				"data" => array(),
			) );
			echo  $output;exit;
		}  
		$output=array(
				'page_size'=>$page_size,
				'page'=>$page,
				'total_rows'=>$return['rows'],
				'total_page'=>$total_page,
				'sql'=>$return['sql'],
				
				'result'=>$result
		);
	//	$this->__data($output);
		$output= json_encode ( array (
			"code" => 2000,
			"msg" => '请求成功',
			"data" => $output,
		) );
		echo $output;


	}


}