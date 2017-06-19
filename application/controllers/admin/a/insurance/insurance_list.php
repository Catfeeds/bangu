<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Insurance_list extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->database();
		$this->load->model ( 'admin/a/insure_model','insure_model');
	}
	public function index()
	{
	            $page = $this->getPage ();
		$data['pageData'] = $this->insure_model->get_insure_list('',$page);
                          //保险种类
		$data['kind']=$this->insure_model->get_insurance_kind('DICT_INSURANCE_KIND');
         
		$this ->load_view('admin/a/ui/insurance/insurance_list' ,$data);
	}
	/*分页查询*/
	public function indexData(){
		$param = $this->getParam(array('search_insurance_type','search_insurance_kind','name','commpany'));

		$page = $this->getPage ();
		$data = $this->insure_model->get_insure_list( $param,$page );
		//echo $this->db->last_query();
		echo  $data ;
	}
	
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
		$insurance_type=$this->input->post('insurance_type',true);
		$settlement_price=$this->input->post('settlement_price',true);
		$insurance_kind=$this->input->post('insurance_kind',true);
		$insurance_code=$this->input->post('insurance_code',true);
		$min_date=$this->input->post('min_date',true);
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
				'insurance_type'=>$insurance_type,
				'settlement_price'=>$settlement_price,
				'insurance_kind'=>$insurance_kind,
				'insurance_code'=>$insurance_code,
				'min_date'=>$min_date
					
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
		$insurance_type=$this->input->post('edit_insurance_type',true);
		$settlement_price=$this->input->post('edit_settlement_price',true);
		$insurance_kind=$this->input->post('edit_insurance_kind',true);
		$insurance_code=$this->input->post('edit_insurance_code',true);
		$min_date=$this->input->post('edit_min_date',true);
		$updata_date=array(
				'insurance_name'=>$insurance_name,
				'insurance_company'=>$insurance_company,
				'insurance_date'=>$insurance_date,
				'insurance_price'=>$insurance_price,
				'simple_explain'=>$simple_explain,
				'description'=>$description,
				'insurance_clause'=>$insurance_clause,
				'modtime'=>date('Y-m-d H:i:s',time()),
				'insurance_type'=>$insurance_type,
				'settlement_price'=>$settlement_price,
				'insurance_kind'=>$insurance_kind,
				'insurance_code'=>$insurance_code,
				'min_date'=>$min_date
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
