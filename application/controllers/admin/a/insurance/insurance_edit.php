<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Insurance_edit extends UA_Controller
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
	            $param['starttime']=date("Y-m-d",strtotime("+1 day"));  
	            $param['usertime']=date("Y-m-d",strtotime("+1 day"));   
	            $param['status']=1; 
		$data['pageData'] = $this->insure_model->get_insurance_edit($param,$page);
		$this ->load_view('admin/a/ui/insurance/insurance_edit' ,$data);
	}
	/*分页查询*/
	public function indexData(){
		$param = $this->getParam(array('starttime','usertime','status'));
		$page = $this->getPage ();
		$data = $this->insure_model->get_insurance_edit($param,$page );
		//echo $this->db->last_query();
		echo  $data ;
	}
             //查看
	function order_traver(){
		$suitid=$this->input->post('suitid',true);
		$water_account=$this->input->post('water_account',true);
		if( !empty($water_account)){
			$param=array('water_account'=>$water_account);
			$data = $this->insure_model->get_order_traver($param); //出游人
			//echo $this->db->last_query();
			$orderInsure= $this->insure_model->select_rowData('u_insurance_order',array('water_account'=>$water_account));
			echo  json_encode(array('status'=>1,'data'=>$data,'orderInsure'=>$orderInsure));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败!'));
		}		
	}
            //未购买保险
            function get_insurance_order(){
            	$param = $this->getParam(array('ordersn','starttime','usertime'));
		$page = $this->getPage ();
		$data = $this->insure_model->get_unuser_insurance($param,$page );
		//echo $this->db->last_query();
		echo  $data ;
            } 
	
           //取消保险
	function quxiao_insurance(){
		$id=$this->input->post('order_insurance_id',true);
		if($id>0){
			$re=$this->insure_model->update_rowdata('u_order_insurance',array('is_buy'=>-2),array('id'=>$id));
			if($re){
 			        echo  json_encode(array('status'=>1,'msg'=>'取消成功'));	
			}else{
			        echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));	
			}			
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
}