<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_line extends UB1_Controller {

	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
		$this->load->model('admin/b1/app_line_model');
		$this->load->model ( 'admin/b1/user_shop_model');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
}
	public function index()
	{
		
		$data['type']=$this->input->get('type');
		 if(!empty($data['type'])){
		 	$where=array('status'=>2,'expert_grade'=>$data['type']);
		 }else{
		 	$where=array('status'=>2);
		 }
        
		$page = $this->getPage ();
		$data['pageData'] = $this->app_line_model->get_app_line($where,$page );
		//echo $this->db->last_query();
		//目的地
		$data['destinations']=$this->app_line_model->get_destinations(0);
		//专家
		//$data['expert']=$this->app_line_model->get_expert();	
		//出发地
	//	$data['startplace'] = $this->user_shop_model->get_user_shop_select ( 'u_startplace' ,array('pid'=>2)); // 始发地
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/app_line_last',$data);
		$this->load->view('admin/b1/footer.html');
	}	
	/*线路管理的分页查询*/
	public function indexData(){
		$this->load->model ( 'admin/b1/expert_upgrade_model','expert_upgrade');
		$param = $this->getParam(array('status','linename','expertid','formcity','expert_grade')); 
		//目的的选择
		$destcity=$this->input->post('destcity');
		$cityName=$this->input->post('cityName');
		if(!empty($destcity)){
			$param['overcity']=$destcity;
		}else if(!empty($cityName)){
			$dest=$this->expert_upgrade->get_destname(trim($cityName));
			if(!empty($dest)){
				$param['overcity']=$dest['id'];
			}	
		}  

       $startcity=$this->input->post('startcity');
		$page = $this->getPage ();
		$data = $this->app_line_model->get_app_line( $param,$page,$startcity );

		echo  $data ;
	}
	public function indexData1(){
		$param = $this->getParam(array('status','linename','expert'));
		//目的的选择
		$pdest_id=$this->input->post('pdest_id');
		$cdest_id=$this->input->post('cdest_id');
		$pdest_id1=$this->input->post('pdest_id1');
		$cdest_id1=$this->input->post('cdest_id1');
		if(!empty($pdest_id)){
			if(!empty($cdest_id)){
				$param['overcity']=$cdest_id;
			}else{
				$param['overcity']=$pdest_id;
			}
		}
		
		if(!empty($pdest_id1)){
			if(!empty($cdest_id1)){
				$param['overcity']=$cdest_id1;
			}else{
				$param['overcity']=$pdest_id1;
			}
		}
		$data = $this->app_line_model->get_app_line( $param,$this->getPage () );
		echo  $data ;
	}

	/*改变订单的状态*/
	public function ajax_status(){
		$this->load->library('session');
		$login_id=$this->session->userdata('login_id');
		if(!empty($_POST['data'])&& !empty($_POST['status'])){
			$id=$_POST['data'];
			$status=$_POST['status'];
			/*申请线路专家的查询*/
			$expert=$this->app_line_model->updata_expert($id);
			$param=array('status'=>$status,'grade'=>$expert['grade']+1);
		    $data = $this->app_line_model->update_status($param,$id);
		 
			if($data){
			   $arr=array(
			    	'expert_id'=>$expert['expert_id'],
			    	'line_id'=>$expert['line_id'],
			    	'grade_before'=>$expert['grade'],
			    	'grade_after'=>$expert['grade']+1,
			    	'user_id'=>$login_id,
			    	'status'=>0,
			    );
			    $res=$this->app_line_model->insert_expert_upgrade($arr); 
			    if($res){
			    	echo 2;//专家升级成功
			    }else{
			    	echo 3;
			    }
			}else{
				echo  1;//通过
			} 	
		}else{
			echo 0;
		}
	
	}
	
	/*拒绝原因*/
	public function refuse(){
		$reason=array('refuse_remark'=>$this->input->post('reason'),'status'=>3);
		$line_id=$this->input->post('line_id');
		if(!empty($reason)){
			$this->app_line_model->insert_refuse($reason,$line_id);
		}
		redirect('admin/b1/app_line');
	}
	/*调整专家级别*/
	public function adjustLevel(){
		$id=$this->input->post('id');
		$expert_id=$this->input->post('expert_id');
		$grade=$this->input->post('selexpert');
		$reason=$this->input->post('reason');
		$expert=$this->app_line_model->updata_expert($id);
		$lineid=$this->input->post('lineid');
		$expert_data=$this->app_line_model->get_expert_id($expert_id,$lineid);
	
		if(empty($grade)){
			echo json_encode(array('status' =>-1,'msg' =>'请选择要申请的级别'));
			exit;
		}
		if($grade==1){
			$grade_name='管家';
		}elseif($grade==2){
			$grade_name='初级专家';
		}elseif($grade==3){
			$grade_name='中级专家';
		}elseif($grade==4){
			$grade_name='高级专家';
		}else{
			$grade_name='管家';
		}
		if($expert_data[0]['grade']==$grade){
			echo json_encode(array('status' => -1,'msg' =>'你已经是'.$grade_name.',无需升级'));
			exit;
		}elseif (empty($expert_data[0]['grade']) && $grade==1){
			echo json_encode(array('status' => -1,'msg' =>'你已经是管家,无需升级'));
			exit;
		}elseif ($expert_data[0]['grade']==0 && $grade==1){
			echo json_encode(array('status' => -1,'msg' =>'你已经是管家,无需升级'));
			exit;
		} 

		/*if($grade<=$expert_data[0]['grade']){
			echo json_encode(array('status' =>-1,'msg' =>'不能升级比自己级别底的专家或管家'));
			exit;
		}*/

	    if($expert){
     		$arr=array(
     			'expert_id'=>$expert['expert_id'],
     			'line_id'=>$expert['line_id'],
     			'grade_before'=>$expert['grade'],
     			'grade_after'=>$grade,
     			'status'=>1,
     			'apply_remark'=>$reason,
     			'addtime'=>date("Y-m-d H:i:s",time()),
     		);
     		$res=$this->app_line_model->insert_expert_upgrade('u_expert_upgrade',$arr);
     		if($res){
     			echo json_encode(array('status' => 1,'msg' =>'申请成功！等待平台审核中'));
     			exit;
     		}else{
     			echo json_encode(array('status' => -1,'msg' =>'申请失败'));
     			exit;
     		}
	     }else{
	     		echo json_encode(array('status' => -1,'msg' =>'申请失败'));
	     		exit;
	     }
	}
	/*管家被拒绝信心*/
	function get_expert_refuse(){
	    	$lineid=$this->input->post('lineid');
	    	$expert=$this->input->post('expert');
	    	if(!empty($lineid)&& !empty($expert)){
	    		$where=array(
	    			'line_id'=>$lineid,
	    			'expert_id'=>$expert
	    		);
	    		$expert_mag=$this->app_line_model->get_expert_msg($where);
	    		echo json_encode(array('status' => 1,'msg' =>'获取数据成功','res'=>$expert_mag));
	    		exit;
	    	}else{
	    		echo json_encode(array('status' => -1,'msg' =>'获取数据失败'));
	    		exit;
	    	}
	}
	/*删除*/
	public function del_app_line(){
		$id=$this->input->post('data');
		$status=$this->input->post('status');
		$data=array('status'=>3);
		$this->app_line_model->update_status($data,$id);
		echo $this->db->last_query();
		
	}
	
	/*目的地的二级联动*/
	public function get_destinations(){
		$id=$this->input->post('id');
		if(is_numeric($id)){
			 $destinations=$this->app_line_model->get_destinations($id);
			 echo json_encode($destinations);
		}	
	}
	//获取申请管家
	public function get_expert_data () {
		$supplier = $this->getLoginSupplier();
		$experData= $this ->app_line_model ->get_expert($supplier['id']);
	//	echo $this->db->last_query();
		echo json_encode($experData); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
