<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @method  用户管理
 * @since 2016-07-28
 * @author xml
 */
class Employee_list extends T33_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','employee_model');
		$this->load->model('admin/t33/b_role_model','role_model');
	}
	/**
	 * 用户管理
	 * */
	public function index()
	{ 	
		$union_id=$this->get_union();
		//角色
		$data['roleData'] = $this ->role_model ->all_role($union_id);
		$data['msgrole'] = $this ->role_model ->all_msg_role();
		$this->load->view('admin/t33/role/employee_list_view',$data);
	}
	public function getEmployeeJson()
	{
		//分页
		$page = $this->input->post ( 'page', true );
		$page_size =10;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;

		$whereArr = array();
		//search_name
		$employee_id=$this->session->userdata("employee_id");
		$union=$this->employee_model->get_employee_union(array('employee_id'=>$employee_id)); 
		if(!empty($union)){
			$search_name=$this->input->post('search_name',true);
			$search_moblie=$this->input->post('search_moblie',true);
			$whereArr=array(
				'union_id'=>$union['id'],
				'name'=>trim($search_name),
				'moblie'=>trim($search_moblie),
			);
			$data=$this->employee_model->get_employee_data($whereArr,$from,$page_size);
			//echo $this->db->last_query();
			//echo json_encode($data);
			$total_page=ceil ($data['count']/$page_size );	
			if(empty($data['count']))  $this->__data($data['count']);
			$output=array(
				'page_size'=>$page_size,
				'page'=>$page,
				'total_rows'=>$data['count'],
				'total_page'=>$total_page,
				'result'=>$data['data']
			);
			$this->__data($output);
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'不存在该旅行社'));
		}	
	}
	/**
	*@method 获取员工数据
	*/
	function getEmployeeRow(){
		$employee_id=$this->input->post('employee_id',true); 
		if($employee_id>0){
			$employee=$this->employee_model->row(array('id'=>$employee_id));
			
			$this->load->model("admin/t33/b_employee_msg_model","b_employee_msg_model");
			$msgrole=$this->b_employee_msg_model->all(array('employee_id'=>$employee_id));
			
			echo json_encode(array('code'=>2000,'employee'=>$employee,'msgrole'=>$msgrole));
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'不存在记录'));
		}
		
	}
	/*
	*@method 添加编辑员工
	*/
	function add_employee(){
		//var_dump($_POST);
		$employee_id=$this->input->post('employee_id',true); 
		$roleid=$this->input->post('roleid',true);
		$loginname=$this->input->post('loginname',true);
		$password=$this->input->post('password',true);
		$repass=$this->input->post('repass',true);
		$realname=$this->input->post('realname',true);
		$mobile=$this->input->post('mobile',true);
		$email=$this->input->post('email',true);
		$isopen=$this->input->post('isopen',true);
		$remark=$this->input->post('remark',true);
		$checkbox=$this->input->post('checkbox',true);

		if(empty($roleid)){
			echo json_encode(array('code'=>5000,'msg'=>'请选择角色')); 
                               	exit();
		}
		if(empty($loginname)){
			echo json_encode(array('code'=>5000,'msg'=>'请填写账号')); 
                               	exit();
		}
		
		if ($employee_id<=0) //添加的时候
		{
			if(empty($password))
			{
				echo json_encode(array('code'=>5000,'msg'=>'请填写密码'));
				exit();
			}
		}
		if(!empty($password))
		{
			if($password!=$repass)
			{
				echo json_encode(array('code'=>5000,'msg'=>'密码与确认密码不一致'));
				exit();
			}
			else
			{
				$employeeData['pwd']=md5(trim($password));
			}
		}
		if(empty($checkbox))  {
			echo json_encode(array('code'=>5000,'msg'=>'请选择消息角色'));
			exit();
		}
		if(empty($realname)){
			echo json_encode(array('code'=>5000,'msg'=>'请填写真实姓名')); 
                               	exit();
		}
		
		if(empty($mobile)){
			echo json_encode(array('code'=>5000,'msg'=>'请填写手机号码')); 
                               	exit();
		}
		$employeeData['role_id']=$roleid;
		$employeeData['loginname']=$loginname;
		$employeeData['realname']=$realname;
		$employeeData['mobile']=$mobile;
		$employeeData['email']=$email;
		$employeeData['status']=$isopen;
		$employeeData['remark']=$remark;
		if(!empty($password)&&!empty($repass))
		   $employeeData['pwd']=md5($password);
			
		if ($employee_id>0) { //编辑
			$this->db->trans_start();

			$employee=$this->employee_model->update($employeeData,array('id'=>$employee_id)); //修改员工表
			//消息角色
			$this->load->model("admin/t33/b_employee_msg_model","b_employee_msg_model");
			$this->b_employee_msg_model->delete(array('employee_id'=>$employee_id));
			foreach ($checkbox as $k=>$v)
			{
				$this->b_employee_msg_model->insert(array('role_id'=>$v,'employee_id'=>$employee_id));  //新添加的人
			}
			
			$this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'编辑失败'));
			}else{
				 echo json_encode(array('code'=>2000,'msg'=>'编辑成功'));
			}

		}else{ //添加
			$employee_id=$this->session->userdata("employee_id");
			$union=$this->employee_model->get_employee_union(array('employee_id'=>$employee_id)); 
			if(!empty($union)){
				$employeeData['union_id']=$union['id'];
			}

			//账号是否存在
			$one=$this->employee_model->row(array('loginname'=>$loginname));
			if(!empty($one))  $this->__errormsg('账号已被占用，请重新填写');
			
			$this->db->trans_start();
			$employeeData['addtime']=date('Y-m-d H:i:s',time());	
			$employee=$this->employee_model->insert($employeeData); //修改员工表
			
			//消息角色
			$this->load->model("admin/t33/b_employee_msg_model","b_employee_msg_model");
			foreach ($checkbox as $k=>$v)
			{
				$this->b_employee_msg_model->insert(array('role_id'=>$v,'employee_id'=>$employee));  //新添加的人
			}
			
			$this->db->trans_complete();
                           	if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'添加失败'));
			}else{
				 echo json_encode(array('code'=>2000,'msg'=>'添加成功'));
			}
		}
	}

}