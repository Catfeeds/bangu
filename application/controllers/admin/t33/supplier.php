<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/b_union_bank_model','b_union_bank_model');
		$this->load->model('admin/t33/common_model','common_model');
		$this->load->model('admin/t33/u_line_model','u_line_model');
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model');
	}
	
	/**
	 * 供应商控制器
	 * */
	public function index()
	{
		$this->load->view("admin/t33/supplier/list");
	}
	/**
	 * 添加供应商
	 * */
	public function add()
	{
		$this->load->view("admin/t33/supplier/add");
	}
	/**
	 * 添加接口
	 * */
	public function to_add()
	{
		$this->load_model ( 'supplier_model');
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$this->load->helper ( 'regexp' );
		$post = $this->security->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			$post[$key] = trim($val);
		}
		//1、验证
		if ($post['kind'] != 1 && $post['kind'] != 2 && $post['kind'] != 3)
		$this->__errormsg('请选择供应商类型');
		
		if ($post['kind'] == 1 ||$post['kind'] == 3)
		{
		if(empty($post['company_name']))
			$this->__errormsg('请填写供应商名称');
		}
		
		if (empty($post['brand']))
			$this->__errormsg('请填写供应商品牌');
		if (empty($post['expert_business']))
			$this->__errormsg('请填写主营业务');
		if (empty($post['code']))
			$this->__errormsg('请填写供应商代码');
		if (empty($post['country']))
			$this->__errormsg('请选择供应商所在地');
		if (empty($post['idcardpic']))
			$this->__errormsg('请上传身份证扫描件');
		
		if ($post['kind'] == 1)
		{
			if (empty($post['business_licence']))
				$this->__errormsg('请填写营业执照扫描件');
			if (empty($post['licence_img']))
				$this->__errormsg('请填写经营许可证扫描件');
			if (empty($post['licence_img_code']))
				$this->__errormsg('请填写经营许可证编号');
				
		}
		
		if ($post['kind'] == 1 ||$post['kind'] == 3)
		{
			if (empty($post['corp_name']))
				$this->__errormsg('请填写法定代表人姓名');
			if (empty($post['corp_idcardpic']))
				$this->__errormsg('请上传身份证扫描件');
		}
		
		$password_len = strlen($post['password']);
		if (empty($post['password']) || $password_len < 6 || $password_len > 20)
		$this->__errormsg('请填写6到20位的密码');
		else
		{
			if ($post['password'] != $post['password2'])
			$this->__errormsg('两次密码输入不一致');
		}
			
		
		if (empty($post['realname']))
			$this->__errormsg('请填写负责人姓名');
	
		if (!regexp('mobile' ,$post['mobile']))
			$this->__errormsg('请填写正确的负责人手机号');
		
		$supplier = $this ->supplier_model ->uniqueMobileAdd($post['mobile']);
		if (!empty($supplier))
		$this->__errormsg('负责人手机号已存在,不可重复添加');
			
		
		
		if (empty($post['linkman']))
		$this->__errormsg('请填写联系人');
		if (empty($post['link_mobile']))
		$this->__errormsg('请填写联系人手机号');
		if (!regexp('email' ,$post['email']))
		$this->__errormsg('请填写正确的电子邮箱');
	
		$supplier_email = $this ->supplier_model ->uniqueEmailAdd($post['email']);
		if (!empty($supplier_email))
		$this->__errormsg('此电子邮箱已存在，不可重复添加');
		
		//2、数据处理
		$this ->load_model('common/cfg_web_model' ,'web_model');
		$webData = $this ->web_model ->row(array('id' =>1),'arr' ,'' ,'agent_rate');
		$addtime = date('Y-m-d H:i:s');
		$supplierArr = array(
			'kind' =>$post['kind'],
			'mobile' =>$post['mobile'],
			'login_name' =>$post['mobile'],
			'password' =>md5($post['password']),
			'realname' =>$post['realname'],
			'idcardpic' =>$post['idcardpic'],
			'country' =>$post['country'],
			'province' =>empty($post['province'])?0:$post['province'],
			'city' =>empty($post['city']) ? 0 : $post['city'],
			'brand' =>$post['brand'],
			'expert_business' =>$post['expert_business'],
			'code'=>$post['code'],
			'linkman' =>$post['linkman'],
			'link_mobile' =>$post['link_mobile'],
			'telephone' =>$post['telephone'],
			'fax' =>$post['fax'],
			'email' =>$post['email'],
			'company_name' =>$post['company_name'],
			'business_licence' =>$post['business_licence'],
			'licence_img' =>$post['licence_img'],
			'licence_img_code'=>$post['licence_img_code'],
			'corp_name' =>$post['corp_name'],
			'corp_idcardpic' =>$post['corp_idcardpic'],
			'addtime' =>$addtime,
			'modtime' =>$addtime,
			'status' =>1,  //审核通过
			'enable' =>0,
			'agent_rate' =>$webData['agent_rate']
		);
		
		$employee=$this->b_employee_model->row(array('id'=>$employee_id));
		$union_id=$employee['union_id'];
		$company_supplier=array(
			'union_id'=>$union_id,
			'status'=>'1',
			'addtime'=>$addtime,
			'modtime'=>$addtime
		);
		$this->db->trans_begin();
		$supplier_id=$this->supplier_model->insert($supplierArr);
		$company_supplier['supplier_id']=$supplier_id;
		$this->b_company_supplier_model->insert($company_supplier);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('添加失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('添加成功');
		}
		
	}
	/**
	 * 供应商列表
	 * */
	public function supplier_list()
	{
		$supplier_name=trim($this->input->post("supplier_name",true));
		$mobile=trim($this->input->post("mobile",true));
		$email=trim($this->input->post("email",true));
		$country=trim($this->input->post("country",true));
		$province=trim($this->input->post("province",true));
		$city=trim($this->input->post("city",true));
		$brand=trim($this->input->post("brand",true));
		$status=trim($this->input->post("status",true)); //-1停止，1正常
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
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
			if(!empty($supplier_name))
				$where['supplier_name']=$supplier_name;
			if(!empty($mobile))
				$where['mobile']=$mobile;
			if(!empty($email))
				$where['email']=$email;
			if(!empty($country))
				$where['country']=$country;
			if(!empty($province))
				$where['province']=$province;
			if(!empty($city))
				$where['city']=$city;
			if(!empty($brand))
				$where['brand']=$brand;
			if(!empty($status))
				$where['status']=$status;
			
			$return=$this->b_company_supplier_model->get_supplier($where,$from,$page_size);
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
	/**
	 * 供应商详情，不让看企业信息
	 * */
	public function detail()
	{
		$supplier_id=$this->input->get("id",true);
		$this->load_model ( 'supplier_model');
		$data = $this ->supplier_model ->getSupplierDetail($supplier_id);
		
		$this->load->view("admin/t33/supplier/detail",$data);
	}
	/**
	 * 供应商详情，让看企业信息
	 * */
	public function detail2()
	{
		$supplier_id=$this->input->get("id",true);
		$this->load_model ( 'supplier_model');
		$data = $this ->supplier_model ->getSupplierDetail($supplier_id);
	
		$this->load->view("admin/t33/supplier/detail2",$data);
	}
	/**
	 * 单个供应商
	 * */
	public function api_one_supplier()
	{
		$supplier_id=$this->input->post("supplier_id",true);
		$this->load_model ( 'supplier_model');
		$data = $this ->supplier_model ->getSupplierDetail($supplier_id);
		$this->__data($data);
	}
	/**
	 * 修改供应商
	 * */
	public function edit()
	{
		$supplier_id=$this->input->get("id",true);
		$this->load_model ( 'supplier_model');
		$data = $this ->supplier_model ->getSupplierDetail($supplier_id);
	   
		$this->load->view("admin/t33/supplier/edit",$data);
	}
	/**
	 * 供应商银行卡账号
	 * */
	public function bank()
	{
		$supplier_id=$this->input->get("id",true);
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$data['list'] = $this ->b_company_supplier_model ->supplier_bank($supplier_id);
		$data['supplier_id']=$supplier_id;
	
		$this->load->view("admin/t33/supplier/bank",$data);
	}
	/**
	 * 设置银行卡账户
	 * */
	public function api_set_bank()
	{
		$post_arr=$this->input->post("post_arr",true); //银行账户，数组
		$this->load->model('admin/t33/u_supplier_bank_model','u_supplier_bank_model');
		$this->db->trans_begin();
		$addtime=date("Y-m-d H:i:s");
		foreach ($post_arr as $k=>$v)
		{
			if(empty($v['id']))
			{
				
				$insert_data=array(
					'supplier_id'=>$v['supplier_id'],
					'bankname'=>$v['bankname'],
					'brand'=>$v['brand'],
					'bank'=>$v['bank'],
					'openman'=>$v['openman'],
					'addtime'=>$addtime,
					'modtime'=>$addtime	
				);
				$this->u_supplier_bank_model->insert($insert_data);
			}
			else 
			{
				$where=array('id'=>$v['id']);
				$data=array(
						'bankname'=>$v['bankname'],
						'brand'=>$v['brand'],
						'bank'=>$v['bank'],
						'openman'=>$v['openman'],
						'modtime'=>$addtime
				);
				$this->u_supplier_bank_model->update($data,$where);
			}
		}
		//返回结果
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('添加失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('设置成功');
		}
		
		
	}
	/**
	 * 佣金设置
	 * */
	public function set_yj()
	{
		$supplier_id=$this->input->get("id",true); //供应商id
		
		$union_id=$this->get_union();
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$user=$this->userinfo();
		$supplier=$this->b_company_supplier_model->row(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'status'=>'1'));
		$type=$supplier['agent_type'];
		//散拼
		$data['agent'] = $this ->u_line_model->line_agent($supplier_id,$union_id,$type); //佣金（按人群、比例）
		$data['days'] = $this ->u_line_model->day_agent($supplier_id,$union_id,$type); //按天佣金
		$data['agent_type']=$supplier['agent_type'];
		$data['supplier_id'] = $supplier_id;
		$this->load->view("admin/t33/supplier/set_yj",$data);
	}
	/**
	 * 佣金切换
	 * */
	public function api_yj_type()
	{
		$supplier_id=$this->input->post("supplier_id",true); //供应商id
		$type=$this->input->post("type",true); // 1散拼、2包团
	    if(empty($type))
	    {
	    	$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
	    	$user=$this->userinfo();
	    	$supplier=$this->b_company_supplier_model->row(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'status'=>'1'));
	        $type=$supplier['agent_type'];
	    }
		$union_id=$this->get_union();
		//散拼
		
		$data['agent'] = $this ->u_line_model->line_agent($supplier_id,$union_id,$type); //佣金（按人群、比例）
		$data['days'] = $this ->u_line_model->day_agent($supplier_id,$union_id,$type); //按天佣金
		 
		$this->__data($data);
	}
	/**
	 *  佣金设置:api
	 * */
	public function api_set_yj()
	{
		$supplier_id=$this->input->post("supplier_id",true);  // 
		$type=$this->input->post("type",true);  //
		
		$man=$this->input->post("man",true);  //
		$oldman=$this->input->post("oldman",true);  //
		$child=$this->input->post("child",true);  //
		$childnobed=$this->input->post("childnobed",true);  //
		$agent_rate=$this->input->post("agent_rate",true);  //
		
		$agent_type=$this->input->post("agent_type",true);  // 散拼、包团
		
		$day_arr=$this->input->post("day_arr",true);  //
		
		if(empty($supplier_id))  $this->__errormsg('供应商id不能为空');
		$user=$this->userinfo();
		$this->load->model("admin/t33/sys/b_union_line_agent_model","b_union_line_agent_model");
		$this->load->model("admin/t33/sys/b_union_line_agent_day_model","b_union_line_agent_day_model");
		$union_agent=$this->b_union_line_agent_model->row(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'agent_type'=>$agent_type));
		$addtime=date("Y-m-d H:i:s");
		$this->db->trans_begin();
		if($type=="3")//1、按天数
		{
			if(!empty($day_arr))
			{
				$this->b_union_line_agent_day_model->delete(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'agent_type'=>$agent_type));
				foreach ($day_arr as $k=>$v)
				{
					
					if(empty($v['id']))
					{
						$insert_data=array(
							'supplier_id'=>$supplier_id,
							'day'=>$v['day'],
							'money'=>$v['money'],
							'addtime'=>$addtime,
							'agent_type'=>$agent_type,
							'union_id'=>$user['union_id']
						);
						$this->b_union_line_agent_day_model->insert($insert_data);
						
					}
					else
					{
						$update_data=array(
							'day'=>$v['day'],
							'money'=>$v['money'],
							'addtime'=>$addtime
						);
						$this->b_union_line_agent_day_model->update($update_data,array('id'=>$v['id']));
						
					}
					
				}
			}
			if(empty($union_agent))
			{
				$insert_agent=array(
						'union_id'=>$user['union_id'],
						'supplier_id'=>$supplier_id,
						'employee_id'=>$user['id'],
						'addtime'=>$addtime,
						'modtime'=>$addtime,
					    'agent_type'=>$agent_type,
						'type'=>$type
				);
				$this->b_union_line_agent_model->insert($insert_agent);
			}
			else 
			{
				$this->b_union_line_agent_model->update(array('type'=>$type),array('id'=>$union_agent['id']));
			}
			
		}
		else  //2、按人群、比例
		{
			if(empty($union_agent))
			{   //新增
				
				if($type=="1")
				{
					$insert=array(
							'union_id'=>$user['union_id'],
							'supplier_id'=>$supplier_id,
							'employee_id'=>$user['id'],
							'addtime'=>$addtime,
							'modtime'=>$addtime,
							'man'=>$man,
							'oldman'=>$oldman,
							'child'=>$child,
							'agent_type'=>$agent_type,
							'childnobed'=>$childnobed,
							'type'=>$type
					);
				}
				else
				{
					$insert=array(
							'union_id'=>$user['union_id'],
							'supplier_id'=>$supplier_id,
							'employee_id'=>$user['id'],
							'agent_type'=>$agent_type,
							'addtime'=>$addtime,
							'modtime'=>$addtime,
							'agent_rate'=>$agent_rate,
							'type'=>$type
					);
					
				}
				$this->b_union_line_agent_model->insert($insert);
			}
			else
			{  //更新
				if($type=="1")
				{
					$update=array('man'=>$man,'oldman'=>$oldman,'child'=>$child,'childnobed'=>$childnobed,'type'=>$type);
				}
				else 
				{
					$update=array('agent_rate'=>$agent_rate,'type'=>$type);
				}
				$this->b_union_line_agent_model->update($update,array('id'=>$union_agent['id']));
			}
		}
		//更新b_company_supplier表的agent_type的值
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$this->b_company_supplier_model->update(array('agent_type'=>$agent_type),array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id']));
		
		//返回结果
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('添加失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('设置成功');
		}
	}
	/**
	 * 佣金设置:版本二
	 * */
	public function set_yj2()
	{
		$supplier_id=$this->input->get("id",true); //供应商id
		$union_id=$this->get_union();

		//散拼
		$data['agent'] = $this ->u_line_model->line_agent($supplier_id,$union_id,'1'); //佣金（按人群、比例）
		$data['days'] = $this ->u_line_model->day_agent($supplier_id,$union_id,'1'); //按天佣金
		//包团
		$data['agent2'] = $this ->u_line_model->line_agent($supplier_id,$union_id,'2'); //佣金（按人群、比例）
		$data['days2'] = $this ->u_line_model->day_agent($supplier_id,$union_id,'2'); //按天佣金
		
		$data['supplier_id'] = $supplier_id;
		$this->load->view("admin/t33/supplier/set_yj2",$data);
	}
	/**
	 *  佣金设置:api 
	 *  版本二
	 * */
	public function api_set_yj2()
	{
		$supplier_id=$this->input->post("supplier_id",true);  //
		//散拼
		$type=$this->input->post("type",true); 
		$man=$this->input->post("man",true);  
		$oldman=$this->input->post("oldman",true);  
		$child=$this->input->post("child",true);  
		$childnobed=$this->input->post("childnobed",true);  
		$agent_rate=$this->input->post("agent_rate",true);  
		$day_arr=$this->input->post("day_arr",true);  
		//包团
		$type2=$this->input->post("type2",true); 
		$man2=$this->input->post("man2",true);  
		$oldman2=$this->input->post("oldman2",true);  
		$child2=$this->input->post("child2",true);  
		$childnobed2=$this->input->post("childnobed2",true);  
		$agent_rate2=$this->input->post("agent_rate2",true);  
		$day_arr2=$this->input->post("day_arr2",true);  
	

		if(empty($supplier_id))  $this->__errormsg('供应商id不能为空');
		$user=$this->userinfo();
		$this->load->model("admin/t33/sys/b_union_line_agent_model","b_union_line_agent_model");
		$this->load->model("admin/t33/sys/b_union_line_agent_day_model","b_union_line_agent_day_model");
		$addtime=date("Y-m-d H:i:s");
		$this->db->trans_begin();
		//散拼
		$union_agent=$this->b_union_line_agent_model->row(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'agent_type'=>'1'));
		if(!empty($day_arr))
		{
	        $this->b_union_line_agent_day_model->delete(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'agent_type'=>'1'));
			foreach ($day_arr as $k=>$v)
			{
				  $insert_data=array(
				  'supplier_id'=>$supplier_id,
				  'day'=>$v['day'],
				  'money'=>$v['money'],
				  'addtime'=>$addtime,
			      'agent_type'=>'1',
				  'union_id'=>$user['union_id'],
				  'money_child'=>$v['money_child'],
				  'money_childbed'=>$v['money_childbed']
				  );
				  $this->b_union_line_agent_day_model->insert($insert_data);
             }
	     }
	     if(empty($union_agent))
		 {
					$insert_agent=array(
							'union_id'=>$user['union_id'],
							'supplier_id'=>$supplier_id,
							'employee_id'=>$user['id'],
							'addtime'=>$addtime,
							'modtime'=>$addtime,
							'man'=>$man,
							'oldman'=>$oldman,
							'child'=>$child,
							'childnobed'=>$childnobed,
							'agent_rate'=>$agent_rate,
							'agent_type'=>'1',
							'type'=>$type
			        );
			        $this->b_union_line_agent_model->insert($insert_agent);
		  }
		  else
		  {
				    $update_agent=array(
				    		'man'=>$man,
				    		'oldman'=>$oldman,
				    		'child'=>$child,
				    		'childnobed'=>$childnobed,
				    		'agent_rate'=>$agent_rate,
				    		'type'=>$type
				    );
					$this->b_union_line_agent_model->update($update_agent,array('id'=>$union_agent['id']));
		  }
		  //包团
		  $union_agent2=$this->b_union_line_agent_model->row(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'agent_type'=>'2'));
		  if(!empty($day_arr2))
		  {
		  	$this->b_union_line_agent_day_model->delete(array('supplier_id'=>$supplier_id,'union_id'=>$user['union_id'],'agent_type'=>'2'));
		  	foreach ($day_arr2 as $k=>$v)
		  	{
		  		$insert_data=array(
		  				'supplier_id'=>$supplier_id,
		  				'day'=>$v['day'],
		  				'money'=>$v['money'],
		  				'addtime'=>$addtime,
		  				'agent_type'=>'2',
		  				'union_id'=>$user['union_id'],
		  				'money_child'=>$v['money_child'],
				 	 	'money_childbed'=>$v['money_childbed']
		  		);
		  		$this->b_union_line_agent_day_model->insert($insert_data);
		  	}
		  }
		  if(empty($union_agent2))
		  {
		  	$insert_agent=array(
		  			'union_id'=>$user['union_id'],
		  			'supplier_id'=>$supplier_id,
		  			'employee_id'=>$user['id'],
		  			'addtime'=>$addtime,
		  			'modtime'=>$addtime,
		  			'man'=>$man2,
		  			'oldman'=>$oldman2,
		  			'child'=>$child2,
		  			'childnobed'=>$childnobed2,
		  			'agent_rate'=>$agent_rate2,
		  			'agent_type'=>'2',
		  			'type'=>$type2
		  	);
		  	$this->b_union_line_agent_model->insert($insert_agent);
		  }
		  else
		  {
		  	$update_agent=array(
		  			'man'=>$man2,
		  			'oldman'=>$oldman2,
		  			'child'=>$child2,
		  			'childnobed'=>$childnobed2,
		  			'agent_rate'=>$agent_rate2,
		  			'type'=>$type2
		  	);
		  	$this->b_union_line_agent_model->update($update_agent,array('id'=>$union_agent2['id']));
		  }
		//返回结果
		if ($this->db->trans_status() === FALSE)
	    {
			$this->db->trans_rollback();
			$this->__errormsg('添加失败');
	    }
		else
		{
			$this->db->trans_commit();
			$this->__data('设置成功');
		}
	}
	/**
	 *  佣金设置:api
	 * */
	public function api_delete_agent()
	{
		$id=$this->input->post("id",true);  //
		$this->load->model("admin/t33/sys/b_union_line_agent_day_model","b_union_line_agent_day_model");
		$status=$this->b_union_line_agent_day_model->delete(array('id'=>$id));
		//if($status)
			$this->__data('已删除');
		//else 
			//$this->__errormsg('操作异常');
	}
	/**
	 * 添加接口
	 * */
	public function to_edit()
	{
		$this->load_model ( 'supplier_model');
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$this->load->helper ( 'regexp' );
		$post = $this->security->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			$post[$key] = trim($val);
		}
		//1、验证
		
		if (empty($post['login_name']))
			$this->__errormsg('请填写登录账号');
		
		if (empty($post['code']))
			$this->__errormsg('请填写品牌代码');
		
		if (empty($post['brand']))
			$this->__errormsg('请填写品牌名称');
		
		
		if (empty($post['realname']))
			$this->__errormsg('请填写负责人姓名');
		
		if (!regexp('mobile' ,$post['mobile']))
			$this->__errormsg('请填写正确的负责人手机号');
		
		if ($post['kind'] == 1)
		{
			if (empty($post['licence_img_code']))
				$this->__errormsg('请填写经营许可证编号');
	
		}
	
		if ($post['kind'] == 1 ||$post['kind'] == 3)
		{
			if (empty($post['corp_name']))
				$this->__errormsg('请填写法定代表人姓名');
			
		}
		
		$exist=$this->supplier_model->row(array('login_name'=>$post['login_name'],'status'=>'2'));
		if(!empty($exist)&&$exist['id']!=$post['supplier_id']) $this->__errormsg('该登录账户已被占用，请重新填写');
		
		
      /*   if($post['mobile']!=$post['old_mobile'])  //当填写了新的“负责人联系方式”时，才执行
        {
			$supplier = $this ->supplier_model ->uniqueMobileAdd($post['mobile']);
			if (!empty($supplier))
				$this->__errormsg('负责人手机号已存在,不可重复添加');
        } */
	
		if (empty($post['linkemail']))
			$this->__errormsg('请填写联系人邮箱');
        $exist2=$this->supplier_model->row(array('linkemail'=>$post['linkemail'],'status'=>'2'));
        if(!empty($post['linkemail'])){
        if(!empty($exist2)&&$exist2['id']!=$post['supplier_id']) $this->__errormsg('联系人邮箱已被占用，请重新填写');
        }
		//2、数据处理
		$this ->load_model('common/cfg_web_model' ,'web_model');
		$webData = $this ->web_model ->row(array('id' =>1),'arr' ,'' ,'agent_rate');
		$addtime = date('Y-m-d H:i:s');
		$supplierArr = array(
				'mobile' =>$post['mobile'],
				'login_name' =>$post['mobile'],
				'realname' =>$post['realname'],
				'modtime' =>$addtime,
				'code'=>$post['code'],
				'company_name'=>$post['company_name'],
				'brand'=>$post['brand'],
				'login_name'=>$post['login_name']
				
		);
		if(!empty($post['corp_name']))
			$supplierArr['corp_name']=$post['corp_name'];
		if(!empty($post['licence_img_code']))
			$supplierArr['licence_img_code']=$post['licence_img_code'];
	    if(!empty($post['business_licence']))
	    	$supplierArr['business_licence']=$post['business_licence'];
	    if(!empty($post['licence_img']))
	    	$supplierArr['licence_img']=$post['licence_img'];
	    if(!empty($post['idcardpic']))
	    	$supplierArr['idcardpic']=$post['idcardpic'];
	    if(!empty($post['corp_idcardpic']))
	    	$supplierArr['corp_idcardpic']=$post['corp_idcardpic'];
	    
	    if(!empty($post['linkman']))
	    	$supplierArr['linkman']=$post['linkman'];
	    if(!empty($post['link_mobile']))
	    	$supplierArr['link_mobile']=$post['link_mobile'];
	    if(!empty($post['email']))
	    	$supplierArr['email']=$post['email'];
	    if(!empty($post['linkemail']))
	    	$supplierArr['linkemail']=$post['linkemail'];
	    
	    if(!empty($post['password']))
	    	$supplierArr['password']=md5($post['password']);
	    
	    $where=array('id'=>$post['supplier_id']);
		
		$this->db->trans_begin();
		$supplier_id=$this->supplier_model->update($supplierArr,$where);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('修改失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('修改成功');
		}
	
	}
	/**
	 * @method 冻结供应商
	 * @author jiakairong
	 * @since  2015-12-01
	 */
	public function frozenSupplier()
	{
		
		$id = intval($this ->input ->post('id'));
		$refuse_reason = trim($this ->input ->post('reason'));
		$this->load_model ( 'supplier_model');
		//$supplier = $this ->supplier_model ->row(array('id' =>$id) ,'arr' ,'' ,'id,status,mobile');
		
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$union_id=$this->get_union();
		$supplier = $this ->b_company_supplier_model ->row(array('supplier_id'=>$id,'union_id'=>$union_id,'status'=>'1'));
		
		if (empty($supplier))
			$this->__errormsg('此供应商不存在');
		if (empty($refuse_reason))
		$this->__errormsg('请填写冻结理由');
		
		$time = date('Y-m-d H:i:s');
		//供应商变更数据
		/* $supplierArr = array(
				'modtime' =>$time,
				'status' =>-1,
				'enable' =>0,
				'refuse_reason' =>$refuse_reason
		); */
		//黑名单数据
		/* $platformArr = array(
				'refuse_type' =>2,
				'userid' =>$id,
				'freeze_days' =>-1,
				//'admin_id' =>$this ->admin_id,
				'reason' =>$refuse_reason,
				'addtime' =>$time,
				'status' =>0
		);
	
		$status = $this ->supplier_model ->frozenSupplier($id ,$supplierArr ,$platformArr); */
	
		$status=$this->b_company_supplier_model->update(array('status'=>'-1'),array('supplier_id'=>$supplier['supplier_id'],'union_id'=>$union_id));
		//停用供应商的线路
		$this->load->model('admin/t33/sys/b_union_approve_line_model','b_union_approve_line_model');
		$this->b_union_approve_line_model->update(array('status'=>'3'),array('union_id'=>$union_id,'supplier_id'=>$supplier['supplier_id']));
		
		if ($status == false)
		{
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->__data('操作成功');
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$this ->log(3,3,'供应商管理','冻结供应商，ID：'.$id);
			$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::supplier_stop_msg ,'isopen' =>1));
			$content = str_replace('{#REASON#}', $refuse_reason, $sms['msg']);
			$this ->send_message($supplier['mobile'] ,$content);
		}
	}
	/**
	 * @method 恢复与供应商合作
	 * @author jiakairong
	 * @since  2015-12-02
	 */
	public function recovery()
	{
		$id = intval($this ->input ->post('id'));
		$this->load_model ( 'supplier_model');
		//$supplier = $this ->supplier_model ->row(array('id' =>$id) ,'arr' ,'' ,'id,status,mobile');
		
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$union_id=$this->get_union();
		$supplier = $this ->b_company_supplier_model ->row(array('supplier_id'=>$id,'union_id'=>$union_id,'status'=>'-1'));
		
		if(empty($supplier))
		{
			$this->__errormsg('此供应商不在冻结状态，不可进行此操作');
		}
	
		//$status = $this ->supplier_model ->recoverySupplier($id);
		$status=$this->b_company_supplier_model->update(array('status'=>'1'),array('supplier_id'=>$supplier['supplier_id'],'union_id'=>$union_id));
		
		//开启供应商的线路
		//$this->load->model('admin/t33/sys/b_union_approve_line_model','b_union_approve_line_model');
		//$this->b_union_approve_line_model->update(array('status'=>'2'),array('union_id'=>$union_id,'supplier_id'=>$supplier['supplier_id']));
		
		if ($status == false)
		{
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->__data('操作成功');
			$this ->log(3,3,'供应商管理','恢复与供应商合作，ID：'.$id);
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::supplier_back ,'isopen' =>1));
			$this ->send_message($supplier['mobile'] ,$sms['msg']);
		}
	}
	/**
	 * 城市列表
	 * */
	public function arealist()
	{
	   $pid=$this->input->post("pid",true);
	   $this->load->model('admin/t33/common_model','common_model');
	   $output=$this->common_model->areaList($pid);
	   $this->__data($output);
	}
	
	/**
	 * 导入供应商的源
	 * */
	public function import_supplier()
	{
		$data=array();
		$this->load->view("admin/t33/supplier/import_supplier",$data);
	}
	/**
	 * 导入供应商的源
	 * */
	public function api_import_supplier()
	{
		$kind=trim($this->input->post("kind",true)); //供应商类型
		$country=trim($this->input->post("country",true));
		$province=trim($this->input->post("province",true));
		$city=trim($this->input->post("city",true));
		$company_name=trim($this->input->post("company_name",true));
		$realname=trim($this->input->post("realname",true));
		$brand=trim($this->input->post("brand",true));
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
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
			if(!empty($kind))
				$where['kind']=$kind;
			if(!empty($country))
				$where['country']=$country;
			if(!empty($province))
				$where['province']=$province;
			if(!empty($city))
				$where['city']=$city;
			if(!empty($company_name))
				$where['company_name']=$company_name;
			if(!empty($realname))
				$where['realname']=$realname;
			if(!empty($brand))
				$where['brand']=$brand;
				
			$return=$this->b_company_supplier_model->get_import_supplier($where,$from,$page_size);
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
	/**
	 * 导入供应商=>处理操作
	 * @param array  供应商id数组
	 * */
	public function api_import_supplier_deal()
	{
		$arr=$this->input->post('ids',true); //需导入的供应商数组
		$code=$this->input->post('code',true); //供应商代码
		$is_import=$this->input->post('is_import',true); //是否导入线路
		
		if(empty($arr))  $this->__errormsg('请选择要导入的供应商');
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$union_id=$employee['union_id'];
			$this->db->trans_begin();
			foreach ($arr as $k=>$v)
			{
				//1、供应商、旅行社关联表
				$addtime=date("Y-m-d H:i:s");
				$insert_data=array(
					'supplier_id'=>$v,
				    'union_id'=>$union_id,
					'addtime'=>$addtime,
					'modtime'=>$addtime,
					'status'=>'1'
				);
				$row=$this->b_company_supplier_model->row(array('union_id'=>$union_id,'supplier_id'=>$v,'status'=>'1'));
				if(empty($row))
				$this->b_company_supplier_model->insert($insert_data);
				//2、供应商代码
				$this->u_supplier_model->update(array('code'=>$code),array('id'=>$v));
				//3、导入供应商线路，处于未审核状态
				if($is_import=="1")
				{
					
					$line_list=$this->u_line_model->all(array('supplier_id'=>$v));
					if(!empty($line_list))
					{
						foreach ($line_list as $m=>$n)
						{
							$arr=array(
								'supplier_id'=>$v,
								'line_id'=>$n['id'],
								'union_id'=>$union_id,
								'addtime'=>$addtime,
								'modtime'=>$addtime,
								'status'=>'1' //申请中
							);
							$this->load->model('admin/t33/sys/b_union_approve_line_model','b_union_approve_line_model');
							$this->b_union_approve_line_model->insert($arr);
						}
					}
				}
				//var_dump($line_list);
			}
			//exit();
			//提交
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('导入失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('导入成功');
			}
			
		}
		
	}
	/*
	 * 复制供应商
	* */
	public function copy()
	{
		$id=$this->input->get('id',true); //供应商id
		if(empty($id)) $this->__errormsg('供应商id不能为空');
	
		$supplier=$this->u_supplier_model->row(array('id'=>$id));
		$data['supplier']=$supplier;
		$data['supplier_id']=$id;
	
		$this->load->view("admin/t33/supplier/copy",$data);
	}
	/*
	 * 复制供应商 
	 * */
	public function api_copy_supplier()
	{
		$id=$this->input->post('id',true); //供应商id
		$loginname=$this->input->post('loginname',true);
		$password=$this->input->post('password',true);
		$brand=$this->input->post('brand',true);
		$linkman=$this->input->post('linkman',true);
		$linkphone=$this->input->post('linkphone',true);
		$linkemail=$this->input->post('linkemail',true);
		$code=$this->input->post('code',true);
		
		if(empty($id)) $this->__errormsg('供应商id不能为空');
		if(empty($loginname)) $this->__errormsg('供应商登录账号不能为空');
		if(empty($password)) $this->__errormsg('供应商登录密码不能为空');
		if(empty($brand)) $this->__errormsg('供应商品牌名称不能为空');
		if(empty($code)) $this->__errormsg('供应商代码不能为空');
		
		$exist=$this->u_supplier_model->num_rows(array('login_name'=>$loginname,'status'=>'2'));
		if($exist>0) $this->__errormsg('该供应商账号已被占用，请重新填写');
		
		$exist2=$this->u_supplier_model->num_rows(array('linkemail'=>$linkemail,'status'=>'2'));
		if($exist2>0) $this->__errormsg('该联系人邮箱已被占用，请重新填写');
		
		$this->db->trans_begin();
		$supplier=$this->u_supplier_model->row(array('id'=>$id));
		unset($supplier['id']);
		$supplier['brand']=$brand;
		$supplier['login_name']=$loginname;
		$supplier['password']=md5($password);
		$supplier['linkman']=$linkman;
		$supplier['link_mobile']=$linkphone;
		$supplier['linkemail']=$linkemail;
		$supplier['code']=$code;
		$new_supplier_id=$this->u_supplier_model->insert($supplier);
		
		//旅行社-供应商关联
		$union_id=$this->get_union();
		$addtime=date("Y-m-d H:i:s");
		$data=array(
			'union_id'=>$union_id,
			'supplier_id'=>$new_supplier_id,
			'addtime'=>$addtime,
			'modtime'=>$addtime,
			'status'=>'1'
		);
		$this->load->model('admin/t33/b_company_supplier_model','b_company_supplier_model');
		$this->b_company_supplier_model->insert($data);
		
	    if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->__errormsg('复制失败');
			}
			else
			{
				$this->db->trans_commit();
				$this->__data('复制成功');
			}
	}
	
}

/* End of file login.php */
