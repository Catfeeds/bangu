<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insure extends UB1_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model ( 'admin/b1/insure_model');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
}
	public function index()
	{
		$page = $this->getPage ();
		$data['pageData'] = $this->insure_model->get_insure_list('',$page);
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/insure_last',$data);
		$this->load->view('admin/b1/footer.html');

	}	
	/*线路管理的分页查询*/
/* 	public function indexData(){
	    $param = $this->getParam(array('status','linename','expert','formcity')); 
	    //目的的选择
	    $pdest_id=$this->input->post('pdest_id');
	    $cdest_id=$this->input->post('cdest_id');
	    if(!empty($pdest_id)){
	    	if(!empty($cdest_id)){
	    		$param['overcity']=$cdest_id;
	    	}else{
	    		$param['overcity']=$pdest_id;
	    	}
	    }  

		$page = $this->getPage ();
		$data = $this->app_line_model->get_app_line( $param,$page );
	//	echo $this->db->last_query();
		echo  $data ;
	} */
	//添加保险
	function addInsure(){
		 $this->load->library('session');
		 $arr=$this->session->userdata ( 'loginSupplier' );
		 $login_id=$arr['id'];
		 $insurance_name=$this->input->post('insurance_name');
		 $insurance_company=$this->input->post('insurance_company');
		 $insurance_date=$this->input->post('insurance_date');
		 $insurance_price=$this->input->post('insurance_price');
		 $simple_explain=$this->input->post('simple_explain');
		 $description=$this->input->post('description');
		 $insurance_clause=$this->input->post('insurance_clause');
		 $insert_date=array(
		 	'insurance_name'=>$insurance_name,
		 	'insurance_company'=>$insurance_company,
		 	'insurance_date'=>$insurance_date,
		 	'insurance_price'=>$insurance_price,
		 	'simple_explain'=>$simple_explain,
		 	'description'=>$description,
		 	'insurance_clause'=>$insurance_clause,
		 	'modtime'=>date('Y-m-d H:i:s',time()),
		 	'status'=>1,
		 	'supplier_id'=>$login_id,
		 
		 );
		 $insert_id=$this->insure_model->insert_data('u_travel_insurance',$insert_date);
		 if(is_numeric($insert_id)){
		 	 echo json_encode(array('status' => 1,'msg' =>'添加成功!'));
		 }else{
		 	 echo json_encode(array('status' => -1,'msg' =>'添加失败!'));
		 }
	}
    //获取数据
    function sel_insure(){
    	$id=$this->input->post('id');
    	if(is_numeric($id)){
    		$insure=$this->insure_model->select_rowData('u_travel_insurance',array('id'=>$id));
    		echo json_encode(array('status' => 1,'msg' =>'获取数据成功','data'=>$insure));
    	}else{
    		echo json_encode(array('status' => -1,'msg' =>'获取数据失败','data'=>array()));
    	}
    }
    //保存编辑保险
    function editInsure(){
	    	$insurance_name=$this->input->post('edit_insurance_name');
	    	$insurance_company=$this->input->post('edit_insurance_company');
	    	$insurance_date=$this->input->post('edit_insurance_date');
	    	$insurance_price=$this->input->post('edit_insurance_price');
	    	$simple_explain=$this->input->post('edit_simple_explain');
	    	$description=$this->input->post('edit_description');
	    	$insurance_clause=$this->input->post('edit_insurance_clause');
	    	$insure_id=$this->input->post('insure_id');
	    	$updata_date=array(
	    		'insurance_name'=>$insurance_name,
	    		'insurance_company'=>$insurance_company,
	    		'insurance_date'=>$insurance_date,
	    		'insurance_price'=>$insurance_price,
	    		'simple_explain'=>$simple_explain,
	    		'description'=>$description,
	    		'insurance_clause'=>$insurance_clause,
	    		'modtime'=>date('Y-m-d H:i:s',time()),				
	    	);
	    	if(is_numeric($insure_id)){
	    		//修改保险
	    	     $re=$this->insure_model->update_rowdata('u_travel_insurance',$updata_date,array('id'=>$insure_id));
	    	     if($re){
	    	     	echo json_encode(array('status' => 1,'msg' =>'编辑成功'));
	    	     }else{
	    	     	echo json_encode(array('status' => -1,'msg' =>'编辑失败'));
	    	     } 
	    	}else{
	    		echo json_encode(array('status' => -1,'msg' =>'编辑失败'));
	    	}
    }
    //删除
    function del_insure(){
    	$id=$this->input->post('id');
    	if(is_numeric($id)){
    		$re=$this->insure_model->update_rowdata('u_travel_insurance',array('status'=>0),array('id'=>$id));
    		if($re){
    	     		echo json_encode(array('status' => 1,'msg' =>'删除成功'));
    	   	}else{
    	     		echo json_encode(array('status' => -1,'msg' =>'删除失败'));
    	    	} 
    	}else{
    		echo json_encode(array('status' => -1,'msg' =>'删除失败'));
    	}
    }
}
