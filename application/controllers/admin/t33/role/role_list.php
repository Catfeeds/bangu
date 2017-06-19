<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @method  权限管理
 * @since 2016-07-27
 * @author xml
 */
class Role_list extends T33_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model('admin/t33/b_role_model','role_model');
	}
	/**
	 * 旅行社权限管理
	 * */
	public function index()
	{ 
		//管理员
		$this->load->model('admin/t33/b_employee_model','employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$union=$this->employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=empty($union['id'])?0:$union['id'];
		$employee=$this->employee_model->result(array('status'=>1,'union_id'=>$union_id));
		//菜单模块
		$this->load->model('admin/t33/b_directory_model','directory_model');
		$directoryData=$this->directory_model->all(array('pid'=>0,'isopen'=>1));
		$directory=array();
		if(!empty($directoryData)){
			foreach ($directoryData as $key => $value) {
				$directory[$key]['pid']=$value['directory_id'];
				$directory[$key]['pname']=$value['name'];
				$directory[$key]['two']=$this->directory_model->all(array('pid'=>$value['directory_id'],'isopen'=>1));
			}
		}
        $data=array('employee'=>$employee,'directory'=>$directory);
		$this->load->view('admin/t33/role/role_list_view',$data);
	}
	public function getRoleJson()
	{
		//分页
		$page = $this->input->post ( 'page', true );
		$page_size =10;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;

		$employee_id=$this->session->userdata("employee_id");
		$this->load->model('admin/t33/b_employee_model','employee_model');
		//判断旅行社是否存在
        $union=$this->employee_model->get_employee_union(array('employee_id'=>$employee_id)); 
       if(!empty($union['id']))
       {
            $whereArr = array();
            $name=$this->input->post('name',true);
            $whereArr['name']=trim($name);
            $whereArr['union_id']=$union['id'];
			$data = $this ->role_model ->get_b_role($whereArr,$from,$page_size); //角色列表
			foreach($data['data'] as $key=>$val)
			{
				$data['data'][$key]['directory'] = '';
				$data['data'][$key]['admin'] = '';
				$roleData = $this ->role_model ->getRoleDirectory(array('roleid' =>$val['roleid'] ,'r.isopen' =>1)); //角色菜单
				//echo $this->db->last_query();
				if (!empty($roleData))
				{
					foreach($roleData as $v)
					{
						$data['data'][$key]['directory'] .= $v['name'].'&nbsp;,';
					}
					$data['data'][$key]['directory'] = rtrim($data['data'][$key]['directory'] ,',');
				}

				$employeeData = $this ->role_model ->getRoleEmployee(array('role_id'=>$val['roleid'],'union_id'=>$union['id'])); //角色员工表
				//echo $this->db->last_query();
				if (!empty($employeeData))
				{
					foreach($employeeData as $v)
					{
						$data['data'][$key]['admin'] .= $v['realname'].'&nbsp;,';
					}
					$data['data'][$key]['admin'] = rtrim($data['data'][$key]['admin'] ,',');
				}
			}
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

			//echo json_encode($data);	
                      }else{
                      	echo json_encode(array('code'=>4000,'msg'=>'不存在旅行社'));
                      }
			
	}
	/*
	*@method 获取某条角色信息
	*/
	public function getRoleRow(){
                 	$roleid=$this->input->post('roleid',true);  
                  	if($roleid>0){
                  		$role =$this->role_model->row(array('roleid'=>$roleid)); //角色
                  		$roleDirectory= $this ->role_model ->getRoleDirectory(array('roleid' =>$roleid ,'r.isopen' =>1)); //角色菜单
                  		$this->load->model('admin/t33/b_employee_model','employee_model');
                  		$employee=$this->employee_model->result(array('status'=>1,'role_id'=>$roleid));
                  		$data=array(
                  			'role'=>$role,
                  			'roleDirectory'=>$roleDirectory,
                  			'employee'=>$employee
                  		);
     			echo json_encode($data);
                 	 }else{

                  	     	echo json_encode(array('code'=>4000,'msg'=>'获取数据失败'));
                 	 }
	}
	/*
	*@method 添加,编辑角色
	*/
	public function add_role(){
		$roleid=$this->input->post('roleid',true);
		$role_name=$this->input->post('role_name',true);
		$eid=$this->input->post('eid',true);
		$directory=$this->input->post('directory',true);
		$beizhu=$this->input->post('beizhu',true);
		
		$union_id=$this->get_union();
		$roledata=array('rolename'=>$role_name,'remark'=>$beizhu,'union_id'=>$union_id);	

		$this->load->model('admin/t33/b_directory_model','directory_model');
		$this->load->model('admin/t33/b_employee_model','employee_model');
		
		if(empty($directory)){
			echo json_encode(array('code'=>5000,'msg'=>'选择模块'));	
			exit();
		}
		if(empty($beizhu)){
			echo json_encode(array('code'=>5000,'msg'=>'请填写角色描述'));
			exit();
		}
		
		
		if($roleid>0)
		{  //编辑角色
                               
			//统一管理员角色不能改
			$exit=$this->role_model->row(array('roleid'=>$roleid));
			if($exit['union_id']=="0"&&$exit['roleid']=="1") {
				echo json_encode(array('code'=>5000,'msg'=>'此角色不能修改'));
				exit();
			}
			
           $this->db->trans_start();
           $this->role_model->update($roledata, array('roleid'=>$roleid)); //角色
		
          //菜单管理
          $this->role_model->delete_table('b_role_directory',array('roleid'=>$roleid));
	      //添加角色菜单表
			if(!empty($directory)){
   				foreach ($directory as $key => $value) {
   					$this ->role_model ->insert_table('b_role_directory',array('roleid'=>$roleid,'directory_id'=>$value));
   				}
			}

			$this->db->trans_complete();
                           	if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));
			}else{
				 echo json_encode(array('code'=>2000,'msg'=>'编辑成功'));
			}
		}
		else
		{  //添加角色

			$this->db->trans_start();
            $roleid=$this->role_model->insert($roledata); //角色

             //菜单管理
             //$this->role_model->delete_table('b_role_directory',array('roleid'=>$roleid));
			//添加角色菜单表
			if(!empty($directory)){
   				foreach ($directory as $key => $value) {
   					$this ->role_model ->insert_table('b_role_directory',array('roleid'=>$roleid,'directory_id'=>$value));
   				}
			}

			$this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
			{
				echo json_encode(array('code'=>4000,'msg'=>'操作失败'));
			}else{
				 echo json_encode(array('code'=>2000,'msg'=>'添加成功'));
			}


		}	
	}
}