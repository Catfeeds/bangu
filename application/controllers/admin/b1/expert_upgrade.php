<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expert_upgrade  extends UB1_Controller {

	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load->model ( 'admin/b1/expert_upgrade_model','expert_upgrade');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
	}
	public function index()
	{
		$param['status']=0;
		$page = $this->getPage ();
		$data['pageData'] = $this->expert_upgrade->get_expertUpgrade_list($param,$page );
		//echo $this->db->last_query();
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/expert_upgrade',$data);
		$this->load->view('admin/b1/footer.html');
	}
	
	/*线路管理的分页查询*/
	public function indexData(){		
		$page = $this->getPage ();
		$param = $this->getParam(array('status','linename','startcity_id','destcity','cityName','expert_id'));
		$data =  $this->expert_upgrade->get_expertUpgrade_list($param,$page );
		echo  $data ;
	}

	//管家级别通过,拒绝
	function update_expertGrade(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$id=$this->input->post('upgrade_id',true);
		$supplier_reason=$this->input->post('supplier_reason',true);
		$expert_type=$this->input->post('expert_type',true);
		if($id>0){
			if($expert_type==1){    //管家通过
				$data=array(
					'status'=>1,
					'supplier_reason'=>$supplier_reason,
					'supplier_id'=>$arr['id'],
					'modtime'=>date('Y-m-d H:i:s',time()),
				);
	                                	$re=$this->expert_upgrade->update($data,array('id'=>$id));
	                                	if($re){
					echo json_encode(array('status'=>1,'msg'=>'操作成功！'));
			    		exit();
	                                	}else{
	                                		echo json_encode(array('status'=>1,'msg'=>'操作失败！'));
			    		exit();
	                               	 }

			}else if($expert_type==2){ //拒绝管家通过
				$data=array(
					'status'=>-2,
					'supplier_reason'=>$supplier_reason,
					'supplier_id'=>$arr['id'],
					'modtime'=>date('Y-m-d H:i:s',time()),
				);
	                                	$re=$this->expert_upgrade->update($data,array('id'=>$id));
	                                	if($re){
					echo json_encode(array('status'=>1,'msg'=>'操作成功！'));
			    		exit();
	                                	}else{
	                                		echo json_encode(array('status'=>1,'msg'=>'操作失败！'));
			    		exit();
	                                	}

			}else{
				echo json_encode(array('status'=>1,'msg'=>'操作失败！'));
			    	exit();	
			}
	
		}else{
			echo json_encode(array('status'=>1,'msg'=>'操作失败！'));
		    	exit();
		}
	}
}
