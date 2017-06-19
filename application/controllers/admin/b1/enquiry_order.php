<?php
/***
*深圳海外国际旅行社
*
*
*2015-5-26
*2015
*UTF-8
****/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enquiry_order extends UB1_Controller {
	function __construct(){
		$this->need_login = true;
		parent::__construct();
		header("content-type:text/html;charset=utf-8");
		$this->load->helper("url");
		$this->load->helper(array('form', 'url'));

		$this->load->model ( 'admin/b1/enquiry_model','enquiry' );
		header ( "content-type:text/html;charset=utf-8" );
	}

	//资源询价单
	public function index()
	{

		$page = $this->getPage ();
		//新询价单
		$data['pageData'] = $this->enquiry->get_enquiry_list(null,$page);
		//echo $this->db->last_query();
		//指定单
		$data['pageData1'] = $this->enquiry->get_specified_list(null,$page);

		//已回复
	   	$data['pageData2'] = $this->enquiry->get_reply_data(null,$page);

	   	 //已中标
		$data['pageData3'] = $this->enquiry->get_bid_list(null,$page);
		//echo $this->db->last_query();
		//已过期
		$data['pageData4'] = $this->enquiry->get_overdue_data(null,$page);
        		$data['type']=$this->input->get('type');
		$this->load->view('admin/b1/header.html');
		$this->load->view("admin/b1/enquiry_order",$data);
		$this->load->view('admin/b1/footer.html');
	}

	/*资源询价单的分页查询*/
	public function indexData(){
		$page = $this->getPage ();
		$data = $this->enquiry->get_enquiry_list( null,$page );
		echo  $data ;
	}

	/*指定单*/
	public function indexData1(){
		$page = $this->getPage ();
		$data = $this->enquiry->get_specified_list( null,$page );
		echo  $data ;
	}

	/*已回复*/
	public function indexData2(){
		$page = $this->getPage ();
		$data =$this->enquiry->get_reply_data(null,$page);
	//	echo $this->db->last_query();
		echo  $data ;
	}

	/*已中标*/
	public function indexData3(){
		$page = $this->getPage ();
		$data = $this->enquiry->get_bid_list( null,$page );
	//	echo $this->db->last_query();
		echo  $data ;
	}
	/*已过期*/
	public function indexData4(){
		$page = $this->getPage ();
		$data =$this->enquiry->get_overdue_data(null,$page);
		echo  $data ;
	}

	/*回复*/
	public function insert_enquiry_grab(){
		//启用session
		$this->load->library('session');
		$arr=$this->getLoginSupplier();
       		$login_id=$arr['id'];
       		$replay_data = $this->security->xss_clean($_POST);
		$eid=$replay_data['e_id'];
		$reply_content=$replay_data['reply_content'];
		$plan_description=$replay_data['travel_description'];
		$plan_name=$replay_data['plan_name'];
		//报价
		$price=$replay_data['price'];
		$childprice=$replay_data['childprice'];
		$childnobedprice=$replay_data['childnobedprice'];
		$oldprice=$replay_data['oldprice'];
		$agent_rate=$replay_data['agent_rate'];

		if(!empty($agent_rate)){
			if(!is_numeric($agent_rate)){
				echo json_encode(array('code'=>-304,'msg'=>'佣金比例只能是数字'));
				exit();
			}
		}
		$agent_rate=$agent_rate;
		//行程安排数据
		$travel_title_arr = $replay_data['travel_title'];
		$travel_content_arr = $replay_data['travel_content'];
		$pics_url_arr = $replay_data['pics_url'];
		$breakfirst_arr = $replay_data['breakfirst'];
		$lunch_arr = $replay_data['lunch'];
		$supper_arr = $replay_data['supper'];
		$traffic_arr = $replay_data['traffic'];
		$hotel_arr = $replay_data['hotel'];
		$travel_title_arr_count = count($travel_title_arr);
		for($k=0;$k<$travel_title_arr_count;$k++){
			$num = $k+1;
			if(isset($replay_data['breakfirsthas'][$num]) && $replay_data['breakfirsthas'][$num]!=''){
			   $breakfirsthas_arr[$k] = $replay_data['breakfirsthas'][$num];
			 }else{
		 	   $breakfirsthas_arr[$k] = 0;
			}

			if(isset($replay_data['supperhas'][$num]) && $replay_data['supperhas'][$num]!=''){
			   $supperhas_arr[$k] = $replay_data['supperhas'][$num];
			 }else{
		 	   $supperhas_arr[$k] = 0;
			}

			if(isset($replay_data['lunchhas'][$num]) && $replay_data['lunchhas'][$num]!=''){
			   $lunchhas_arr[$k] = $replay_data['lunchhas'][$num];
			 }else{
		 	   $lunchhas_arr[$k] = 0;
			}
		}
		if(!empty($price)){
			if(!is_numeric($price) && $price>=0){
				echo json_encode(array('code'=>-300,'msg'=>'成人价格必须是大于0的数字'));
				exit();
			}
		}
		if(!empty($childprice)){
			if(!is_numeric($childprice) && $childprice>=0){
				echo json_encode(array('code'=>-301,'msg'=>'占床小孩价格必须是大于0的数字'));
				exit();
			}
		}
		if(!empty($childnobedprice)){
			if(!is_numeric($childnobedprice) && $childnobedprice>=0){
				echo json_encode(array('code'=>-302,'msg'=>'不占床小孩价格必须是大于0的数字'));
				exit();
			}
		}
		if(!empty($oldprice)){
			if(!is_numeric($oldprice) && $oldprice>=0){
				echo json_encode(array('code'=>-303,'msg'=>'老人价格必须是大于0的数字'));
				exit();
			}
		}
		$insert_grab_data=array(
			'enquiry_id'=>$eid,
			'supplier_id'=>$login_id,
			'addtime'=>date("Y-m-d H:i:s"),
			'reply'=>$reply_content,
			'isuse'=>0,
			'price'=>$price,
			'childprice'=>$childprice,
			'childnobedprice'=>$childnobedprice,
			'oldprice'=>$oldprice,
			'agent_rate'=>$agent_rate,
			'title'=>$plan_name,
			'plan_description'=>$plan_description
		);
	 	$enquiry_grab_id = $this->enquiry->insert_enquiry_grab('u_enquiry_grab ',$insert_grab_data);
	 	for($i=0;$i<$travel_title_arr_count;$i++){
	 		$insert_reply_data['day'] = $i+1;
	 		$insert_reply_data['enquiry_grab_id'] = $enquiry_grab_id;
	 		$insert_reply_data['title'] = $travel_title_arr[$i];
	 		$insert_reply_data['hotel'] = $hotel_arr[$i];
	 		$insert_reply_data['transport'] = $traffic_arr[$i];
	 		$insert_reply_data['jieshao'] = $travel_content_arr[$i];
	 		$insert_reply_data['breakfirsthas'] = $breakfirsthas_arr[$i];
	 		$insert_reply_data['breakfirst'] = $breakfirst_arr[$i+1];
	 		$insert_reply_data['lunchhas'] = $lunchhas_arr[$i];
	 		$insert_reply_data['lunch'] = $lunch_arr[$i+1];
	 		$insert_reply_data['supperhas'] = $supperhas_arr[$i];
	 		$insert_reply_data['supper'] = $supper_arr[$i+1];
	 		$insert_reply_data['pic'] = $pics_url_arr[$i];
	 		$this->enquiry->insert_enquiry_grab('u_enquiry_jieshao ',$insert_reply_data);
	 	}
	 	if($enquiry_grab_id){
	 		echo json_encode(array('code'=>200,'msg'=>'已提交'));
	 	}else{
	 		echo json_encode(array('code'=>-200,'msg'=>'提交失败'));
	 	}

	}
	/*回复询价单(询价单抢单)*/
	function reply_inquiry(){
		$data = array();
		$eid = $this->input->get('eid');
		$custom_info = $this->enquiry->get_one_customize($eid);
		$custom_trip_data_list = $this->enquiry->get_customize_trip($eid);
		//$supplier = $this->enquiry->get_supplier_info();
		$data = array(
			'custom_info'=>$custom_info[0],
			'custom_trip_data_list'=>$custom_trip_data_list,
			'eid'=>$eid,
			'c_id'=>$custom_info[0]['c_id']
		);
		$this->view('admin/b1/reply_inquiry',$data);

	}
	/*查看询价单*/
	function preview_go_inquiry(){
		$data = array();
		$eid = $this->input->get('eid');
		$custom_info = $this->enquiry->get_one_customize($eid);
		$custom_trip_data_list = $this->enquiry->get_customize_trip($eid);

		$supplier_customize = $this->enquiry->get_supplier_customize($eid);
		if(!empty($supplier_customize)){
			$custom_info[0]['ca_title']= $supplier_customize[0]['ca_title'];
			$custom_info[0]['plan_design']= $supplier_customize[0]['reply'];
			$custom_info[0]['price']= $supplier_customize[0]['price'];
			$custom_info[0]['childprice']= $supplier_customize[0]['childprice'];
			$custom_info[0]['childnobedprice']= $supplier_customize[0]['childnobedprice'];
			$custom_info[0]['oldprice']= $supplier_customize[0]['oldprice'];
			$custom_info[0]['agent_rate']= $supplier_customize[0]['agent_rate'];
		}
		$supplier_trip_data_list = $this->enquiry->get_supplier_trip($eid);
		$data = array(
			'grab_custom_data'=>$custom_info[0],
			'eid'=>$eid,
			'c_id'=>$custom_info[0]['c_id']
		);
		if(!empty($supplier_trip_data_list)){
			$data['custom_trip_data_list'] = $supplier_trip_data_list;
		}else{
			$data['custom_trip_data_list'] = $custom_trip_data_list;
		}
		$this->view('admin/b1/preview_go_inquiry',$data);

	}

	/*查看方案*/
	function get_enquiry_reply(){
		$id=$this->input->post('data');
		if(is_numeric($id)){
		   	$row= $this->enquiry->enquiry_data($id);
		   	echo json_encode($row);
		}else{
			echo false;
		}
	}
	//转定制团
	function return_groupLine(){
	     	$id=$this->input->post('id');
	     	$expert_id=$this->input->post('expert_id');
	     	$isuse=$this->input->post('isuse');
	     	$eid=$this->input->post('eid');
	     	$grabid=$this->input->post('grabid');
	     	$answer_id=$this->input->post('answer_id');

	     	if($id>0){
	     		//转定制团
	     		$re=$this->enquiry->return_enquiry(array('id'=>$id),$expert_id,$isuse,array('id'=>$eid),array('id'=>$grabid));
	            if($re>0){
	            	$result=array('status' => 1,'msg' =>'转定制团成功!请前往定制团编辑定制团线路和添加套餐库存','id'=>$re);
	            	echo json_encode($result);
	            	exit;
	            }else{
	            	echo json_encode(array('status' => -1,'msg' =>'转定制团成败!'));
	            	exit;
	            }
	     	}else{
	     	    	echo json_encode(array('status' => -1,'msg' =>'转定制团成败!不存在该定制单'));
			exit;
	     	}

	}

	//Ajax文件上传
	public function up_file() {
		$name_str = $this ->input ->post('filename' ,true);
		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = './file/b1/uploads/';
		$config['allowed_types'] ='*';
		$config['max_size'] = '4000000000';
		$file_name = 'supplier_'.$name_str.'_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			echo json_encode(array('status' => -1,'msg' =>'请选择要上传的附件文件'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/b1/uploads/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));
			exit;
		}
	}
}
