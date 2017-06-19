<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//"旅行社设置"控制器

class Union extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_union_bank_model','b_union_bank_model');
		$this->load->model('admin/t33/common_model','common_model');
		$this->load->model('admin/t33/u_foreign_agent_model','u_foreign_agent_model');
	}
	
	/**
	 * 外交佣金
	 * */
	public function agent_tree()
	{
		$this->load->view("admin/t33/union/ztree");
	}
	/**
	 * 外交佣金
	 * */
	public function agent()
	{
		$this->load->view("admin/t33/union/agent");
	}
	/**
	 * 销售（管家）列表
	 * */
	public function api_agent_list()
	{
		$dest_name=trim($this->input->post("dest_name",true));
		$type=trim($this->input->post("type",true)); //1是未设置，2是已设置
		$pid=trim($this->input->post("pid",true)); //1是境外，2是境内
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
	
			//分页
			$page = $this->input->post ( 'page', true );
			$page_size = sys_constant::B_PAGE_SIZE;
			//$page_size="1";
			$page = empty ( $page ) ? 1 : $page;
			$from = ($page - 1) * $page_size;
	
			//条件筛选
			$where=array('union_id'=>$union_id);
			//$supplier_name="地方";
			if(!empty($dest_name))
				$where['dest_name']=$dest_name;
			if(!empty($type))
				$where['type']=$type;
			if(!empty($pid))
				$where['pid']=$pid;
			
			$return=$this->u_foreign_agent_model->dest_list($where,$from,$page_size);
			$result=$return['result'];
			$total_page=ceil ( $return['rows']/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$return['rows'],
					'total_page'=>$total_page,
					//'sql'=>$return['sql'],
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/*
	 * 修改外交佣金:api
	 * */
	public function api_edit_agent()
	{
		$agent_id=$this->input->post("agent_id",true); //外交佣金表id
		$dest_id=$this->input->post("dest_id",true);
		$adult_agent=$this->input->post("adult_agent",true);
		$child_agent=$this->input->post("child_agent",true);
		$childnobed_agent=$this->input->post("childnobed_agent",true);
		$old_agent=$this->input->post("old_agent",true);
		if(empty($dest_id))  $this->__errormsg('目的地id不能为空');
		
		$dest=$this->common_model->dest_detail(array('id'=>$dest_id));
		if(empty($dest)) $this->__errormsg('目的地不存在');
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			if(empty($agent_id))
			{  //新增
				$this->load->model('admin/t33/b_employee_model','b_employee_model');
				$employee=$this->b_employee_model->row(array('id'=>$employee_id));
				$union_id=$employee['union_id'];
				$data=array(
					'dest_id'=>$dest_id,
					'dest_name'=>$dest['kindname'],
					'adult_agent'=>$adult_agent,
					'child_agent'=>$child_agent,
					'childnobed_agent'=>$childnobed_agent,
					'old_agent'=>$old_agent,
					'union_id'=>$union_id,
					'addtime'=>date("Y-m-d H:i:s")
				);
				$exist=$this->u_foreign_agent_model->row(array('dest_id'=>$dest_id,'union_id'=>$union_id));
				if(empty($exist))
				{
					$status=$this->u_foreign_agent_model->insert($data);
					if($status)  
						$this->__data('保存成功');
					else 
						$this->__errormsg('保存失败');
				}
				else 
				{
					$this->__data('保存成功');
				}
			} //修改
			else
			{
				$data=array(
						'adult_agent'=>$adult_agent,
						'child_agent'=>$child_agent,
						'childnobed_agent'=>$childnobed_agent,
						'old_agent'=>$old_agent,
						'addtime'=>date("Y-m-d H:i:s")
				);
				$status=$this->u_foreign_agent_model->update($data,array('id'=>$agent_id));
				if($status)
					$this->__data('保存成功');
				else
					$this->__errormsg('保存失败');
			}
		}
	}
	/*
	 * 修改或增加 ： 指定目的地的外交佣金
	* */
	public function api_agent_add()
	{
		$dest_id=$this->input->post("dest_id",true);

		$adult_agent=$this->input->post("adult_agent",true);
		$child_agent=$this->input->post("child_agent",true);
		if(empty($dest_id))  $this->__errormsg('目的地id不能为空');
		
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
			$union_id=$employee['id'];
			//目的地是二级还是三级
			$this->db->trans_begin();
			$addtime=date("Y-m-d H:i:s");
			$dest_row=$this->common_model->dest_detail(array('id'=>$dest_id));
			if($dest_row['level']=="3") //三级
			{
				$data=array('union_id'=>$union_id,'dest_id'=>$dest_id,'dest_name'=>$dest_row['kindname'],'adult_agent'=>$adult_agent,'child_agent'=>$child_agent,'addtime'=>$addtime);
				$update=array('adult_agent'=>$adult_agent,'child_agent'=>$child_agent,'addtime'=>$addtime);
				$exist=$this->u_foreign_agent_model->row(array('union_id'=>$union_id,'dest_id'=>$dest_id));
				if(empty($exist))
				{
					$this->u_foreign_agent_model->insert($data);
				}
				else 
				{
					$this->u_foreign_agent_model->update($update,array('id'=>$exist['id']));
				}
			}
			elseif($dest_row['level']=="2") //二级
			{
				$data=array('union_id'=>$union_id,'dest_id'=>$dest_id,'dest_name'=>$dest_row['kindname'],'adult_agent'=>$adult_agent,'child_agent'=>$child_agent,'addtime'=>$addtime);
				$update=array('adult_agent'=>$adult_agent,'child_agent'=>$child_agent,'addtime'=>$addtime);
				$exist=$this->u_foreign_agent_model->row(array('union_id'=>$union_id,'dest_id'=>$dest_id));
				if(empty($exist))
				{
					$this->u_foreign_agent_model->insert($data);
				}
				else
				{
					$this->u_foreign_agent_model->update($update,array('id'=>$exist['id']));
				}
				
				//设置子级
				$child_arr=$this->common_model->dest_detail(array('pid'=>$dest_id));
				if(!empty($child_arr))
				{
					foreach ($child_arr as $k=>$v)
					{
						$child_dest_row=$this->common_model->dest_detail(array('id'=>$v['id']));
						$child_data=array('union_id'=>$union_id,'dest_id'=>$v['id'],'dest_name'=>$child_dest_row['kindname'],'adult_agent'=>$adult_agent,'child_agent'=>$child_agent,'addtime'=>$addtime);
						$update_child=array('adult_agent'=>$adult_agent,'child_agent'=>$child_agent,'addtime'=>$addtime);
						$exist=$this->u_foreign_agent_model->row(array('union_id'=>$union_id,'dest_id'=>$v['id']));
						if(empty($exist))
						{
							$this->u_foreign_agent_model->insert($child_data);
						}
						else
						{
							$this->u_foreign_agent_model->update($update_child,array('id'=>$exist['id']));
						}
					}
				}
				//end
			}
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('操作失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('已保存');
			}
		}
	
	}
	/*
	 * 指定目的地的：外交佣金
	 * */
	public function api_agent_detail()
	{
		$dest_id=$this->input->post("dest_id",true);
		if(empty($dest_id))  $this->__errormsg('目的地id不能为空');
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
		{
			$this->__errormsg('请先登录');
		}
		else
		{
			$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
			$union_id=$employee['id'];
			$row=$this->u_foreign_agent_model->row(array('dest_id'=>$dest_id,'union_id'=>$union_id));
			$this->__data($row);
		}
		
	}
	/**
	 * 目的地:树结构
	 * */
	public function api_dest()
	{
		/*
		$destData=array(
				0=>array(
						'name'=>'境内',
						'open'=>true,
						'children'=>array(
								'0'=>array(
										'name'=>'江西省',
										'children'=>array(
												'0'=>array(
														'name'=>'南昌',
												),
												'1'=>array(
														'name'=>'赣州',
												)
										)
								),
								'1'=>array(
										'name'=>'广东省',
										'children'=>array(
												'0'=>array(
														'name'=>'深圳',
												),
												'1'=>array(
														'name'=>'广州',
												)
										)
								),
						)
				),
				1=>array(
						'name'=>'境外',
						'open'=>true,
						'children'=>array(
								'0'=>array(
										'name'=>'韩国',
										'children'=>array(
												'0'=>array(
														'name'=>'1',
												),
												'1'=>array(
														'name'=>'3',
												)
										)
								),
								'1'=>array(
										'name'=>'新加波',
										'children'=>array(
												
										),
										'isParent'=>true
								),
						)
				)
		
		);
		*/
		
		$menu1=$this->common_model->destList("1"); //一级
		$menu2=$this->common_model->destList("2"); //一级
		
		$menu3=$this->common_model->destList("3"); //一级
		$destData=array();
		foreach ($menu1 as $k=>$v)
		{
			$children=array();
			foreach ($menu2 as $k2=>$v2)
			{
				if($v2['pid']==$v['id'])
				{
					$three=array();
					foreach ($menu3 as $k3=>$v3)
					{
						 if($v3['pid']==$v2['id'])
						 {
						 	$three[]=array(
						 		'id'=>$v3['id'],
						 		't'=>'点击设置外交佣金',
						 		'level'=>$v3['level'],
						 		'name'=>$v3['kindname']
						 	);
						 }
					}
					$children[]=array(
					              'name'=>$v2['kindname'],
								  't'=>'点击设置外交佣金',
								  'level'=>$v2['level'],
							      'id'=>$v2['id'],
							      'isParent'=>true,
							      'children'=>$three
								);
				}
			}
			$temp_v=array(
				'id'=>$v['id'],
				'name'=>$v['kindname'],
				't'=>'点击设置外交佣金',
				'level'=>$v['level'],
				'open'=>true,
				'children'=>$children
			);
			$destData[$k]=$temp_v;
		}
		
		
		$this->__data($destData);
	}
	/**
	 * 银行账户
	 * */
	public function bank()
	{
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		$data['union_bank']=$this->b_union_bank_model->row(array('union_id'=>$union_id)); //个体银行
		$data['bangu_bank']=$employee;  //帮游银行
		$this->load->view("admin/t33/union/bank",$data);
	}
	/**
	 * 修改个体银行账户
	 * */
	public function api_edit_bank()
	{
		$id=$this->input->post("id",true);
		$bankname=$this->input->post("bankname",true);
		$bankcard=$this->input->post("bankcard",true);
		$branch=$this->input->post("branch",true);
		$cardholder=$this->input->post("cardholder",true);
		
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		$exist=$this->b_union_bank_model->row(array('union_id'=>$union_id));
		$addtime=date("Y-m-d H:i:s");
		if(empty($exist))
		{
			$data=array(
				'union_id'=>$union_id,
				'bankname'=>$bankname,
				'bankcard'=>$bankcard,
				'branch'=>$branch,
				'cardholder'=>$cardholder,
				'addtime'=>$addtime
					
			);
			$status=$this->b_union_bank_model->insert($data);
		}
		else
		{
			$data=array(
					'bankname'=>$bankname,
					'bankcard'=>$bankcard,
					'branch'=>$branch,
					'cardholder'=>$cardholder,
					'addtime'=>$addtime
						
			);
			$status=$this->b_union_bank_model->update($data,array('id'=>$id));
		}
		
		if($status)
			$this->__data('修改成功');
	}
	/**
	 * logo设置
	 * */
	public function logo()
	{
		$this->load->model('admin/t33/sys/b_union_log_model','b_union_log_model');
		$union_id=$this->get_union();
		$data['logo']=$this->b_union_log_model->row(array('union_id'=>$union_id)); //
		$this->load->view("admin/t33/union/logo",$data);
	}
	/**
	 * logo设置
	 * */
	public function api_logo_add()
	{
		$code_pic=$this->input->post("code_pic");
		if(empty($code_pic)) $this->__errormsg('请上传图片');
		
		$user=$this->userinfo();
		$this->load->model('admin/t33/sys/b_union_log_model','b_union_log_model');
		$row=$this->b_union_log_model->row(array('union_id'=>$user['union_id']));
		$data=array('logo'=>$code_pic,'modtime'=>date("Y-m-d H:i:s"),'employee_id'=>$user['id'],'employee_name'=>$user['realname']);
		if(empty($row))
		{
			$data['union_id']=$user['union_id'];
			$data['addtime']=date("Y-m-d H:i:s");
			$status=$this->b_union_log_model->insert($data);
		}
		else 
		    $status=$this->b_union_log_model->update($data,array('union_id'=>$user['union_id']));
		if($status) $this->__data('上传成功');
		else  $this->__errormsg('上传失败');
			
	}
	
	/**
	 * 待办事项
	 * */
	public function backlog()
	{
		echo "待开发";
	}
	
	
	
}

/* End of file login.php */
