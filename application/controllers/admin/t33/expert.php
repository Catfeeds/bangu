<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expert extends T33_Controller {
	
	public function __construct()
	{
		parent::__construct ();
		//$this->db->trans_begin();
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		
	}
	/**
	 * 我的销售（管家）
	 * */
	public function expert_list()
	{
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$data['depart']=$this->b_depart_model->all(array('union_id'=>$union_id,'pid'=>'0'));
		$this->load->view("admin/t33/expert/list",$data);
	}
	/**
	 * 销售（管家）列表
	 * */
	public function api_expert_list()
	{
		$realname=trim($this->input->post("realname",true));
		$nickname=trim($this->input->post("nickname",true));
		$mobile=trim($this->input->post("mobile",true));
		$email=trim($this->input->post("email",true));
		$country=trim($this->input->post("country",true));
		$province=trim($this->input->post("province",true));
		$city=trim($this->input->post("city",true));
		$depart_id=trim($this->input->post("depart_id",true));
		$type=trim($this->input->post("type",true));
		
	
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
			if(!empty($realname))
				$where['realname']=$realname;
			if(!empty($nickname))
				$where['nickname']=$nickname;
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
			if(!empty($depart_id))
				$where['depart_id']=$depart_id;
			if(!empty($type))
                $where['union_status']=$type;			
				
			$return=$this->u_expert_model->get_expert($where,$from,$page_size);
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
	 * 供应商详情
	 * */
	public function detail()
	{
		$expert_id=$this->input->get("id",true);
		$this->load_model ( 'admin/t33/u_expert_model','u_expert_model');
		$expert_row=$this ->u_expert_model ->getExpertDetail($expert_id);
		$data['expert'] = $expert_row[0];
		
		//擅长路线
		$data['expert']['expert_dest_arr']=explode(",", $data['expert']['expert_dest']);
		$data['expert']['visit_service_arr']=explode(",", $data['expert']['visit_service']);
		
		//证件名称
		$this->load->model('admin/t33/common_model','common_model');
		if(!empty($data['expert']['idcardtype']))
		{
			
		$typeone=$this->common_model->idcardtype_detail($data['expert']['idcardtype']);
		$data['expert']['idcardtype_name']=$typeone['description'];  
		}
		
		
		
		$data['expert_cert'] = $this ->u_expert_model ->getExpertCertificate($expert_id);
		$data['expert_resume'] = $this ->u_expert_model ->getExpertResume($expert_id);
	   // var_dump($data);
	    
	    /**/
	   
	    $this->load->model('admin/t33/b_depart_model','b_depart_model');
	    $this->load->model('admin/t33/b_employee_model','b_employee_model');
	    $employee_id=$this->session->userdata("employee_id");
	    $employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
	    
	    $union_id=$employee['id'];
	    
	    $data['top']=$this->common_model->destList('1');
	    $data['dest']=$this->common_model->destList('2');
	    $data['idcardtype']=$this->common_model->idcardtype_list("100");
	    $data['depart']=$this->b_depart_model->all(array('union_id'=>$union_id));
	    
	    
	    
		$this->load->view("admin/t33/expert/detail",$data);
	}
	/**
	 * 添加销售
	 * */
	public function add()
	{
		$this->load->model('admin/t33/common_model','common_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		
		$union_id=$employee['id'];
		$data['city']=$employee['city'];
		$data['cityname']=$employee['cityname'];
		$data['province_id']=$employee['province_id'];
		$data['province_name']=$employee['province_name'];
		
		$data['top']=$this->common_model->destList('1');
		$data['dest']=$this->common_model->destList('2');
		$data['idcardtype']=$this->common_model->idcardtype_list("100");
		$data['depart']=$this->b_depart_model->all(array('union_id'=>$union_id,'status'=>'1','pid'=>'0'));
		
		//$data['json_depart']=json_encode(array('0'=>array('id'=>'1','pid'=>'0','name'=>'北京'),'1'=>array('id'=>'2','pid'=>'0','name'=>'上海')));
		$data['json_depart']=$this->b_depart_model->all_depart();
		$this->load->view("admin/t33/expert/add2",$data);
	}
	/**
	 * 数型数据:营业部
	 * */
	public function api_depart_list()
	{
		$content=$this->input->post("value",true);
		
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$where=array('union_id'=>$union_id,'content'=>$content);
		$result=$this->b_depart_model->all_depart($where);
		$this->__data($result);
	}
	/**
	 * 数型数据:营业部一级
	 * */
	public function api_level_one()
	{
		$content=$this->input->post("value",true);
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
	
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$result=$this->b_depart_model->all_depart(array('union_id'=>$union_id,'level'=>'1','content'=>$content));
		$this->__data($result);
	}
	/**
	 * 数型数据:营业部二级
	 * */
	public function api_level_two()
	{
		$content=trim($this->input->post("content",true));
		
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$where=array('union_id'=>$union_id,'level'=>'2');
		if(!empty($content))
			$where['content']=$content;
		$result=$this->b_depart_model->all_depart_expert($where);
		$this->__data($result);
	}
	/**
	 * 数型数据:目的地
	 * */
	public function api_tree_dest()
	{
		$content=$this->input->post("value",true);
	    $user=$this->userinfo();
		$this->load->model('admin/t33/common_model','common_model');
		$result=$this->common_model->tree_destData(array('level'=>'4','content'=>$content,'city'=>$user['city']));
		$this->__data($result);
	}
	/**
	 * 数型数据:出发地
	 * */
	public function api_tree_startplace()
	{
	
		$this->load->model('admin/t33/common_model','common_model');
		$result=$this->common_model->tree_startplaceData(array('level'=>'3'));
		$this->__data($result);
	}
	/**
	 * 添加接口
	 * */
	public function to_add()
	{
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/u_expert_certificate_model','u_expert_certificate_model');
		$this->load->model('admin/t33/u_expert_resume_model','u_expert_resume_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$employee_id=$this->session->userdata("employee_id");
		$this->load->helper ( 'regexp' );
		$post = $this->security->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			if(!is_array($val))
			$post[$key] = trim($val);
		}
		//1、验证
		if ($post['type'] != 1 && $post['type'] != 2)
			$this->__errormsg('请选择类型');
	
		if (empty($post['mobile']))
			$this->__errormsg('请填写手机号码');
		if (!regexp('mobile' ,$post['mobile']) && $post['type'] == 1)
			$this->__errormsg('请填写正确的手机号');
		$expert = $this ->u_expert_model ->row(array('mobile'=>$post['mobile'],'status'=>'2'));
		$expert2 = $this ->u_expert_model ->row(array('mobile'=>$post['mobile'],'status'=>'1'));
		if (!empty($expert)||!empty($expert2))
			$this->__errormsg('手机号已存在,不可重复添加');
		
		$password_len = strlen($post['password']);
		if (empty($post['password']) || $password_len < 6 || $password_len > 20)
			$this->__errormsg('请填写6到20位的密码');
		else
		{
			if ($post['password'] != $post['password2'])
				$this->__errormsg('两次密码输入不一致');
		}
		if (empty($post['nickname']))
			$this->__errormsg('请填写昵称');
		if (empty($post['realname']))
			$this->__errormsg('请填写真实姓名');
		if ($post['sex']!="1" && $post['sex']!='0')
			$this->__errormsg('请选择性别');
	
		if (empty($post['depart_id']))
			$this->__errormsg('请选择营业部');
		
		//经理职位判断
		$depart=$this->b_depart_model->row(array('id'=>$post['depart_id']));
		if($post['is_dm']=="1")
		{
			if($depart['pid']=="0") //一级营业部只能有1个经理
			{
			$has_dm=$this->u_expert_model->row(array('depart_id'=>$post['depart_id'],'is_dm'=>'1'));
			if(!empty($has_dm)&&$has_dm['expert_id']!=$post['expert_id'])  $this->__errormsg('该营业部已有1个经理，请重新选择职位');
			}
			else   //二级营业部没有经理
			{
				$this->__errormsg('二级营业部不能设置经理职位，请重新选择');
			}
		}
		//depart_list ： 一级营业部，二级营业部
		$depart_list="";
		if($depart['pid']=="0")
		{
			$depart_list=$post['depart_id'].",";
		}
		else
		{
			$depart_list=$depart['pid'].",".$post['depart_id'].",";
		}
	
		$idcardtype="";
		if ($post['type'] == '2')
		{
			if (empty($post['idcardtype']))
				$this->__errormsg('请选择证件类型');
			if (empty($post['idcard']))
				$this->__errormsg('请填写证件号');
			
			$idcardtype=$post['idcardtype'];
		}
		else
		{
			$idcardtype="";
		}
		if ($post['type'] == '1')
		{
			if (empty($post['idcard']))
				$this->__errormsg('请填写身份证号');
		}
	
		if (empty($post['email']))
			$this->__errormsg('请填写邮箱');
		if (!regexp('email' ,$post['email']))
			$this->__errormsg('请填写正确的邮箱');
		$expert_email = $this ->u_expert_model ->row(array('email'=>$post['email']));
		if (!empty($expert_email))
			$this->__errormsg('此电子邮箱已存在，不可重复添加');
	
		/* if (empty($post['weixin']))
			$this->__errormsg('请填写微信'); */
		if (empty($post['expert_dest']))
				$this->__errormsg('请选择擅长线路');
		if (empty($post['province']))
			$this->__errormsg('请选择所在地');
		if (empty($post['city']))
			$this->__errormsg('请选择城市');
		if (empty($post['visit_service'])&&$post['type'] == '1')
			$this->__errormsg('请选择上门服务');
		
		if (empty($post['big_photo']))
			$this->__errormsg('请上传头像');
		if (empty($post['idcardpic']))
			$this->__errormsg('请上传证件正面扫描件');
		if (empty($post['idcardconpic']))
			$this->__errormsg('请上传证件反扫描件');
		if (strlen($post['beizhu'])<6)
			$this->__errormsg('请填写多于6字的个人描述');
		
			
	
	
		if (empty($post['school']))
			$this->__errormsg('请填写毕业学校');
		if (empty($post['profession']))
			$this->__errormsg('请填写从业');
		if (empty($post['working']))
			$this->__errormsg('请填写工作年限');
		if (empty($post['work_row']))
			$this->__errormsg('请填写工作经历');
	
		//2、数据处理
		$beizhu="毕业于".$post['school'].";旅游从业岗位：".$post['profession'].";".$post['working']."年从业经验";//毕业于1;旅游从业岗位：2;3年从业经验
		$addtime = date('Y-m-d H:i:s');
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		$expertArr = array(
				'type' =>$post['type'],
				'mobile' =>$post['mobile'],
				'login_name' =>$post['mobile'],
				'password' =>md5($post['password']),
				'mobile' =>$post['mobile'],
				'nickname' =>$post['nickname'],
				'realname' =>$post['realname'],
				'sex' =>$post['sex'],
				'idcardtype' =>$idcardtype,
				'idcard' =>$post['idcard'],
				'email' =>$post['email'],
				'weixin' =>$post['weixin'],
				'expert_dest' =>substr($post['expert_dest'],0,-1),
				'province' =>$post['province'],
				'city' =>$post['city'],
				'visit_service' =>substr($post['visit_service'],0,-1),
				'big_photo' =>$post['big_photo'],
				'small_photo' =>$post['big_photo'],
				'idcardpic' =>$post['idcardpic'],
				'idcardconpic' =>$post['idcardconpic'],
				'talk'=>$post['beizhu'],
				'beizhu'=>$beizhu,
				'school' =>$post['school'],
				'profession' =>$post['profession'],
				'working'=>$post['working'],
				'addtime' =>$addtime,
				'modtime' =>$addtime,
				'status' =>'0',  //审核中
				'is_commit'=>'0',  //未提交
				'expert_type'=>'1',  //1营业部管家
				'union_id'=>$union_id,
				'union_name'=>$employee['union_name'],
				'depart_id'=>$post['depart_id'],
				'depart_name'=>$post['depart_name'],
				'is_dm'=>$post['is_dm'],
				'depart_list'=>$depart_list,
				'union_status'=>'1' //0是无旅行社，1是合作中，-1是停用
				
		);
		
		$this->db->trans_begin();
		$expert_id=$this->u_expert_model->insert($expertArr);
		
		if(!empty($post['work_row']))
		{
			foreach ($post['work_row'] as $k=>$v)
			{
				$work=array(
						'expert_id'=>$expert_id,
						'company_name'=>$v['company_name'],
						'job'=>$v['job'],
						'starttime'=>$v['starttime'],
						'endtime'=>$v['endtime'],
						'description'=>$v['description'],
						'status'=>'1'
				);
				$this->u_expert_resume_model->insert($work);  //u_expert_certificate_model
			}
		}
		if(!empty($post['certificate_row']))
		{
			foreach ($post['certificate_row'] as $m=>$n)
			{
				$certificate=array(
						'expert_id'=>$expert_id,
						'certificate'=>$n['certificate'],
						'certificatepic'=>$n['certificatepic'],
						'status'=>'1'
				);
				$this->u_expert_certificate_model->insert($certificate);  //u_expert_certificate_model
			}
		}
		//$this->b_company_supplier_model->insert($company_supplier);
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
	 * 添加接口： 版本二 （轻便）
	 * */
	public function to_add2()
	{
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/u_expert_certificate_model','u_expert_certificate_model');
		$this->load->model('admin/t33/u_expert_resume_model','u_expert_resume_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$employee_id=$this->session->userdata("employee_id");
		$this->load->helper ( 'regexp' );
		$post = $this->security->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			if(!is_array($val))
				$post[$key] = trim($val);
		}
		//1、验证
		if ($post['type'] != 1 && $post['type'] != 2)
			$this->__errormsg('请选择类型');
	
		if (empty($post['mobile']))
			$this->__errormsg('请填写手机号码');
		if (!regexp('mobile' ,$post['mobile']) && $post['type'] == 1)
			$this->__errormsg('请填写正确的手机号');
		$expert = $this ->u_expert_model ->row(array('mobile'=>$post['mobile']));
		$expert2 = $this ->u_expert_model ->row(array('login_name'=>$post['mobile']));
		if (!empty($expert)||!empty($expert2))
			$this->__errormsg('手机号已存在,不可重复添加');
	
		$password_len = strlen($post['password']);
		if (empty($post['password']) || $password_len < 6 || $password_len > 20)
			$this->__errormsg('请填写6到20位的密码');
		else
		{
			if ($post['password'] != $post['password2'])
				$this->__errormsg('两次密码输入不一致');
		}
		/* if (empty($post['nickname']))
			$this->__errormsg('请填写昵称'); */
		if (empty($post['realname']))
			$this->__errormsg('请填写真实姓名');
		if ($post['sex']!="1" && $post['sex']!='0')
			$this->__errormsg('请选择性别');
	
		if (empty($post['depart_id']))
			$this->__errormsg('请选择营业部');
	
		//经理职位判断
		$depart=$this->b_depart_model->row(array('id'=>$post['depart_id']));
		if($post['is_dm']=="1")
		{
			if($depart['pid']=="0") //一级营业部只能有1个经理
			{
				$has_dm=$this->u_expert_model->row(array('depart_id'=>$post['depart_id'],'is_dm'=>'1'));
				if(!empty($has_dm)&&$has_dm['expert_id']!=$post['expert_id'])  $this->__errormsg('该营业部已有1个经理，请重新选择职位');
			}
			else   //二级营业部没有经理
			{
				$this->__errormsg('二级营业部不能设置经理职位，请重新选择');
			}
		}
		//depart_list ： 一级营业部，二级营业部
		$depart_list="";
		if($depart['pid']=="0")
		{
			$depart_list=$post['depart_id'].",";
		}
		else
		{
			$depart_list=$depart['pid'].",".$post['depart_id'].",";
		}
	
		$idcardtype="";
		if ($post['type'] == '2')
		{
			if (empty($post['idcardtype']))
				$this->__errormsg('请选择证件类型');
			if (empty($post['idcard']))
				$this->__errormsg('请填写证件号');
				
			$idcardtype=$post['idcardtype'];
		}
		else
		{
			$idcardtype="";
		}
		if ($post['type'] == '1')
		{
			if (empty($post['idcard']))
				$this->__errormsg('请填写身份证号');
		}
	
		/* if (empty($post['email']))
			$this->__errormsg('请填写邮箱');
		if (!regexp('email' ,$post['email']))
			$this->__errormsg('请填写正确的邮箱');
		$expert_email = $this ->u_expert_model ->row(array('email'=>$post['email']));
		if (!empty($expert_email))
			$this->__errormsg('此电子邮箱已存在，不可重复添加'); */
	
		/* if (empty($post['weixin']))
		 $this->__errormsg('请填写微信'); */
		/* if (empty($post['expert_dest']))
			$this->__errormsg('请选择擅长线路'); */
		/* if (empty($post['province']))
			$this->__errormsg('请选择所在地');
		if (empty($post['city']))
			$this->__errormsg('请选择城市'); */
		if (empty($post['visit_service'])&&$post['type'] == '1')
			$this->__errormsg('请选择上门服务');
	
		/* if (empty($post['big_photo']))
			$this->__errormsg('请上传头像'); */
		if (empty($post['idcardpic']))
			$this->__errormsg('请上传证件正面扫描件');
		if (empty($post['idcardconpic']))
			$this->__errormsg('请上传证件反扫描件');
		/* if (strlen($post['beizhu'])<6)
			$this->__errormsg('请填写多于6字的个人描述'); */
	
			
	
	
		/* if (empty($post['school']))
			$this->__errormsg('请填写毕业学校');
		if (empty($post['profession']))
			$this->__errormsg('请填写从业');
		if (empty($post['working']))
			$this->__errormsg('请填写工作年限');
		if (empty($post['work_row']))
			$this->__errormsg('请填写工作经历'); */
	
		//2、数据处理
		
		$addtime = date('Y-m-d H:i:s');
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		$expertArr = array(
				'type' =>$post['type'],
				'mobile' =>$post['mobile'],
				'login_name' =>$post['mobile'],
				'password' =>md5($post['password']),
				'mobile' =>$post['mobile'],
				'realname' =>$post['realname'],
				'nickname'=>$post['realname'],
				'sex' =>$post['sex'],
				'idcardtype' =>$idcardtype,
				'idcard' =>$post['idcard'],
				'province' =>$post['province'],
				'city' =>$post['city'],
				'visit_service' =>substr($post['visit_service'],0,-1),
				//'big_photo' =>$post['big_photo'],
				//'small_photo' =>$post['big_photo'],
				'idcardpic' =>$post['idcardpic'],
				'idcardconpic' =>$post['idcardconpic'],
				//'beizhu'=>$beizhu,
				'addtime' =>$addtime,
				'modtime' =>$addtime,
				'status' =>'0',  //审核中
				'is_commit'=>'0',  //未提交
				'expert_type'=>'1',  //1营业部管家
				'union_id'=>$union_id,
				'union_name'=>$employee['union_name'],
				'depart_id'=>$post['depart_id'],
				'depart_name'=>$post['depart_name'],
				'is_dm'=>$post['is_dm'],
				'depart_list'=>$depart_list,
				'union_status'=>'1' //0是无旅行社，1是合作中，-1是停用
	
		);
	
		$this->db->trans_begin();
		$expert_id=$this->u_expert_model->insert($expertArr);
	
		if(!empty($post['work_row']))
		{
			foreach ($post['work_row'] as $k=>$v)
			{
				$work=array(
						'expert_id'=>$expert_id,
						'company_name'=>$v['company_name'],
						'job'=>$v['job'],
						'starttime'=>$v['starttime'],
						'endtime'=>$v['endtime'],
						'description'=>$v['description'],
						'status'=>'1'
				);
				$this->u_expert_resume_model->insert($work);  //u_expert_certificate_model
			}
		}
		if(!empty($post['certificate_row']))
		{
			foreach ($post['certificate_row'] as $m=>$n)
			{
				$certificate=array(
						'expert_id'=>$expert_id,
						'certificate'=>$n['certificate'],
						'certificatepic'=>$n['certificatepic'],
						'status'=>'1'
				);
				$this->u_expert_certificate_model->insert($certificate);  //u_expert_certificate_model
			}
		}
		//$this->b_company_supplier_model->insert($company_supplier);
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
	 * 修改销售
	 * */
	public function edit()
	{
		$expert_id=$this->input->get("id",true);
		$this->load_model ( 'admin/t33/u_expert_model','u_expert_model');
		$expert_row=$this ->u_expert_model ->getExpertDetail($expert_id);
		$data['expert'] = $expert_row[0];
		
		//擅长路线
		$data['expert']['expert_dest_arr']=explode(",", $data['expert']['expert_dest']);
		$data['expert']['visit_service_arr']=explode(",", $data['expert']['visit_service']);
		
		//证件名称
		$this->load->model('admin/t33/common_model','common_model');
		if(!empty($data['expert']['idcardtype']))
		{
		$typeone=$this->common_model->idcardtype_detail($data['expert']['idcardtype']);
		$data['expert']['idcardtype_name']=$typeone['description'];  
		}
		
		
		
		$data['expert_cert'] = $this ->u_expert_model ->getExpertCertificate($expert_id);
		$data['expert_resume'] = $this ->u_expert_model ->getExpertResume($expert_id);
	    //var_dump($data);
	    
	    /**/
	   
	    $this->load->model('admin/t33/b_depart_model','b_depart_model');
	    $this->load->model('admin/t33/b_employee_model','b_employee_model');
	    $employee_id=$this->session->userdata("employee_id");
	    $employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
	    
	    $union_id=$employee['id'];
	    
	    $data['top']=$this->common_model->destList('1');
	    $data['dest']=$this->common_model->destList('2');
	    $data['idcardtype']=$this->common_model->idcardtype_list("100");
	    $data['depart']=$this->b_depart_model->all(array('union_id'=>$union_id,'status'=>'1','pid'=>'0'));
	    
	    
	    
		$this->load->view("admin/t33/expert/edit2",$data);
	}
	/**
	 * 修改接口
	 * */
	public function to_edit()
	{
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/u_expert_certificate_model','u_expert_certificate_model');
		$this->load->model('admin/t33/u_expert_resume_model','u_expert_resume_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$employee_id=$this->session->userdata("employee_id");
		$this->load->helper ( 'regexp' );
		$post = $this->security->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			if(!is_array($val))
				$post[$key] = trim($val);
		}
		//1、验证
		if (empty($post['expert_id']))
			$this->__errormsg('管家id不能为空');
		//if ($post['type'] != 1 && $post['type'] != 2)
			//$this->__errormsg('请选择类型');
	
		
		if (empty($post['nickname']))
			$this->__errormsg('请填写昵称');
	
		if ($post['sex']!="1" && $post['sex']!='0')
			$this->__errormsg('请选择性别');
		if (empty($post['depart_id']))
			$this->__errormsg('请选择营业部');
	
		//经理职位判断
	    $depart=$this->b_depart_model->row(array('id'=>$post['depart_id']));
	    if($post['is_dm']=="1")
		{
			if($depart['pid']=="0") //一级营业部只能有1个经理
			{
			$has_dm=$this->u_expert_model->row(array('depart_id'=>$post['depart_id'],'is_dm'=>'1'));
			if(!empty($has_dm)&&$has_dm['id']!=$post['expert_id'])  $this->__errormsg('该营业部已有1个经理，请重新选择职位');
			}
			else   //二级营业部没有经理
			{
				$this->__errormsg('二级营业部不能设置经理职位，请重新选择');
			}
		}
		//depart_list ： 一级营业部，二级营业部
		$depart_list="";
		if($depart['pid']=="0")
		{
			$depart_list=$post['depart_id'].",";
		}
		else 
		{
			$depart_list=$depart['pid'].",".$post['depart_id'].",";
		}
		
		$idcardtype="";
		if ($post['type'] == '2')
		{
			if (empty($post['idcardtype']))
				$this->__errormsg('请选择证件类型');
			if (empty($post['idcard']))
				$this->__errormsg('请填写证件号');
				
			$idcardtype=$post['idcardtype'];
		}
		else
		{
			$idcardtype="";
		}
		if ($post['type'] == '1')
		{
			if (empty($post['idcard']))
				$this->__errormsg('请填写身份证号');
		}
		
		if (empty($post['expert_dest']))
			$this->__errormsg('请选择擅长线路');
		if (empty($post['province']))
			$this->__errormsg('请选择所在地');
		if (empty($post['city']))
			$this->__errormsg('请选择城市');
		if (empty($post['visit_service']))
			$this->__errormsg('请选择上门服务');
	
		if (empty($post['big_photo']))
			$this->__errormsg('请上传头像');
		if (empty($post['idcardpic']))
			$this->__errormsg('请上传证件正面扫描件');
		if (empty($post['idcardconpic']))
			$this->__errormsg('请上传证件反扫描件');

		
		if (empty($post['school']))
			$this->__errormsg('请填写毕业学校');
		if (empty($post['profession']))
			$this->__errormsg('请填写从业');
		if (empty($post['working']))
			$this->__errormsg('请填写工作年限');
		if (empty($post['work_row']))
			$this->__errormsg('请填写工作经历');
	
		//2、数据处理
		$beizhu="毕业于".$post['school'].";旅游从业岗位：".$post['profession'].";".$post['working']."年从业经验";//毕业于1;旅游从业岗位：2;3年从业经验
		$addtime = date('Y-m-d H:i:s');
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		$expertArr = array(
				'nickname' =>$post['nickname'],
				
				'sex' =>$post['sex'],
				'idcardtype' =>$idcardtype,
				'idcard' =>$post['idcard'],
				
				'expert_dest' =>$post['expert_dest'],
				'province' =>$post['province'],
				'city' =>$post['city'],
				'visit_service' =>$post['visit_service'],
				'big_photo' =>$post['big_photo'],
				'small_photo'=>$post['big_photo'],
				'idcardpic' =>$post['idcardpic'],
				'idcardconpic' =>$post['idcardconpic'],
				
				'beizhu'=>$beizhu,
				'school' =>$post['school'],
				'profession' =>$post['profession'],
				'working'=>$post['working'],
				
				'modtime' =>$addtime,

				'depart_id'=>$post['depart_id'],
				'depart_name'=>$post['depart_name'],
				'is_dm'=>$post['is_dm'],
				'depart_list'=>$depart_list,
				'union_status'=>'1' //0是无旅行社，1是合作中，-1是停用
	
		);
		$expert_id=$post['expert_id'];
		$where=array('id'=>$expert_id);
	
		$this->db->trans_begin();
		$status=$this->u_expert_model->update($expertArr,$where);
	
		$this->u_expert_resume_model->delete(array('expert_id'=>$expert_id));
		if(!empty($post['work_row']))
		{
			foreach ($post['work_row'] as $k=>$v)
			{
				$work=array(
							'expert_id'=>$expert_id,
							'company_name'=>$v['company_name'],
							'job'=>$v['job'],
							'starttime'=>$v['starttime'],
							'endtime'=>$v['endtime'],
							'description'=>$v['description'],
							'status'=>'1'
					);
				$this->u_expert_resume_model->insert($work);  //u_expert_certificate_model
			}
		}
		$this->u_expert_certificate_model->delete(array('expert_id'=>$expert_id));
		if(!empty($post['certificate_row']))
		{
			foreach ($post['certificate_row'] as $m=>$n)
			{
				   $certificate=array(
							'expert_id'=>$expert_id,
							'certificate'=>$n['certificate'],
							'certificatepic'=>$n['certificatepic'],
							'status'=>'1'
					);
					$this->u_expert_certificate_model->insert($certificate);  //u_expert_certificate_model
			}
		}
		//提交
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
	 * 修改接口： 版本二（轻便）
	 * */
	public function to_edit2()
	{
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$this->load->model('admin/t33/u_expert_certificate_model','u_expert_certificate_model');
		$this->load->model('admin/t33/u_expert_resume_model','u_expert_resume_model');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$employee_id=$this->session->userdata("employee_id");
		$this->load->helper ( 'regexp' );
		$post = $this->security->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			if(!is_array($val))
				$post[$key] = trim($val);
		}
		//1、验证
		if (empty($post['expert_id']))
			$this->__errormsg('管家id不能为空');
		//if ($post['type'] != 1 && $post['type'] != 2)
		//$this->__errormsg('请选择类型');
	
	
		if (empty($post['realname']))
			$this->__errormsg('请填写真实姓名');
	
		if ($post['sex']!="1" && $post['sex']!='0')
			$this->__errormsg('请选择性别');
		if (empty($post['depart_id']))
			$this->__errormsg('请选择营业部');
	
		//经理职位判断
		$depart=$this->b_depart_model->row(array('id'=>$post['depart_id']));
		if($post['is_dm']=="1")
		{
			if($depart['pid']=="0") //一级营业部只能有1个经理
			{
				$has_dm=$this->u_expert_model->row(array('depart_id'=>$post['depart_id'],'is_dm'=>'1'));
				if(!empty($has_dm)&&$has_dm['id']!=$post['expert_id'])  $this->__errormsg('该营业部已有1个经理，请重新选择职位');
			}
			else   //二级营业部没有经理
			{
				$this->__errormsg('二级营业部不能设置经理职位，请重新选择');
			}
		}
		//depart_list ： 一级营业部，二级营业部
		$depart_list="";
		if($depart['pid']=="0")
		{
			$depart_list=$post['depart_id'].",";
		}
		else
		{
			$depart_list=$depart['pid'].",".$post['depart_id'].",";
		}
	
		$idcardtype="";
		if ($post['type'] == '2')
		{
			if (empty($post['idcardtype']))
				$this->__errormsg('请选择证件类型');
			if (empty($post['idcard']))
				$this->__errormsg('请填写证件号');
	
			$idcardtype=$post['idcardtype'];
		}
		else
		{
			$idcardtype="";
		}
		if ($post['type'] == '1')
		{
			if (empty($post['idcard']))
				$this->__errormsg('请填写身份证号');
		}
	
		/* if (empty($post['expert_dest']))
			$this->__errormsg('请选择擅长线路'); */
		if (empty($post['province']))
			$this->__errormsg('请选择所在地');
		if (empty($post['city']))
			$this->__errormsg('请选择城市');
		if (empty($post['visit_service']))
			$this->__errormsg('请选择上门服务');
	
		/* if (empty($post['big_photo']))
			$this->__errormsg('请上传头像'); */
		if (empty($post['idcardpic']))
			$this->__errormsg('请上传证件正面扫描件');
		if (empty($post['idcardconpic']))
			$this->__errormsg('请上传证件反扫描件');
	
	
		/* if (empty($post['school']))
			$this->__errormsg('请填写毕业学校');
		if (empty($post['profession']))
			$this->__errormsg('请填写从业');
		if (empty($post['working']))
			$this->__errormsg('请填写工作年限');
		if (empty($post['work_row']))
			$this->__errormsg('请填写工作经历'); */
	
		//2、数据处理
		
		$addtime = date('Y-m-d H:i:s');
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		$expertArr = array(
				'realname' =>$post['realname'],
				'nickname'=>$post['realname'],
				'sex' =>$post['sex'],
				'idcardtype' =>$idcardtype,
				'idcard' =>$post['idcard'],
				'province' =>$post['province'],
				'city' =>$post['city'],
				'visit_service' =>$post['visit_service'],
				//'big_photo' =>$post['big_photo'],
				//'small_photo'=>$post['big_photo'],
				'idcardpic' =>$post['idcardpic'],
				'idcardconpic' =>$post['idcardconpic'],
				'modtime' =>$addtime,
				'depart_id'=>$post['depart_id'],
				'depart_name'=>$post['depart_name'],
				'is_dm'=>$post['is_dm'],
				'depart_list'=>$depart_list,
				//'union_status'=>'1' //0是无旅行社，1是合作中，-1是停用
	
		);
		$expert_id=$post['expert_id'];
		$where=array('id'=>$expert_id);
	
		$this->db->trans_begin();
		$status=$this->u_expert_model->update($expertArr,$where);
	
		
		//提交
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
	 * 裁剪头像页面
	 * */
	public function cut()
	{
		$img_url=$this->input->get("url",true);
		$iframeid=$this->input->get("iframeid",true); //iframeid
	    $data['img_url']=$img_url;
	    $data['iframeid']=$iframeid;
	   
		$this->load->view("admin/t33/expert/cut",$data);
	}
	/**
	 * 裁剪头像处理
	 * */
	public function do_cut()
	{
		$this->load->library('images');
		$images = new images();
		
		
		$img=$this->input->post("img",true);
		$x=$this->input->post("x",true);
		$y=$this->input->post("y",true);
		$w=$this->input->post("w",true);
		$h=$this->input->post("h",true);
		
		$new_width=$this->input->post("new_width",true);//需重设尺寸
		$new_height=$this->input->post("new_height",true);
		
		
		if(empty($img))
		{
			$this->__errormsg('图片不存在');
		}
		else
		{
			$img_new=".".$img;
			$resize_img=$images->resize($img_new,$new_width,$new_height);
			$back_url=substr($resize_img['path'],1);
			$re=$images->cutImage($resize_img['path'],$x,$y,$w,$h,$back_url);
		
			$re['param']=array('img'=>$img,'x'=>$x,'y'=>$y,'w'=>$w,'h'=>$h);
			$re['resize_img']=$resize_img;
			$this->__data($re);
		}
		
		//$this->__data('dd');
		
		
	}
	public function get_visit_service()
	{
		$pid=$this->input->post("pid",true);
		if(empty($pid)) $this->__errormsg('pid不能为空');
		$this->load->model('admin/t33/common_model','common_model');
		$re=$this->common_model->get_visit_service($pid);
		if($re)
			$this->__data($re);
		else
			$this->__errormsg('请求失败');
	}
	/*
	 * 指定管家对应的部门：所有一级管家
	 * */
	public function depart_expert()
	{
		$expert_id=$this->input->post("expert_id",true);
		if(empty($expert_id)) $this->__errormsg('管家id不能为空');
		
		$depart_list=$this->u_expert_model->depart_list($expert_id);
		$this->__data($depart_list);
	}
	/**
	 * @method 冻结管家
	 * @author jiakairong
	 * @since  2015-12-01
	 */
	public function frozenExpert()
	{
	
		$id = intval($this ->input ->post('id',true));
		$refuse_reason = trim($this ->input ->post('reason',true));
		$new_manage=$this->input->post('new_manage',true); //新的经理
		$action=$this->input->post('action',true); //是否验证
		
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/u_platform_refuse_model','u_platform_refuse_model');
		$expert = $this ->u_expert_model->row(array('id' =>$id));
		if (empty($expert))
			$this->__errormsg('此销售不存在');
		if ($new_manage=="-1"&&$action)
			$this->__errormsg('需指定新的经理');
		if (empty($refuse_reason))
			$this->__errormsg('请填写停用理由');
	
		$time = date('Y-m-d H:i:s');
		//销售变更数据
		$expertArr = array(
				'modtime' =>$time,
				'is_dm'=>'0', //非经理
				//'status' =>-1	
				'union_status'=>'-1' //0是无旅行社，1是合作中，-1是停用
		);
		//黑名单数据
		/*$platformArr = array(
				'refuse_type' =>1,
				'userid' =>$id,
				'freeze_days' =>-1,
				//'admin_id' =>$this ->admin_id,
				'reason' =>$refuse_reason,
				'addtime' =>$time,
				'status' =>0
		);*/
		
		$this->db->trans_begin();
		$this->u_expert_model->update($expertArr,array('id'=>$id));
		
		//新的经理
		$this->u_expert_model->update(array('is_dm'=>'1'),array('id'=>$new_manage)); 
		
		//$this->u_platform_refuse_model->insert($platformArr);
		
		//提交
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('操作成功');
			//$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			//$this ->log(3,3,'管家管理','冻结管家，ID：'.$id);
			//$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_stop_msg ,'isopen' =>1));
			//$content = str_replace('{#REASON#}', $refuse_reason, $sms['msg']);
			//$this ->send_message($expert['mobile'] ,$content);
		}
		
	}
	/**
	 * @method 恢复与管家合作
	 * @author jiakairong
	 * @since  2015-12-02
	 */
	public function recovery()
	{
		$id = intval($this ->input ->post('id'));
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$this->load->model('admin/t33/u_platform_refuse_model','u_platform_refuse_model');
		$expert = $this ->u_expert_model->row(array('id' =>$id));
		
		if (empty($expert) || $expert['union_status'] != -1)
		{
			$this->__errormsg('此供应商不在冻结状态，不可进行此操作');
		}
	
		//$status = $this ->u_expert_model ->recoveryExpert($id);
		$status = $this ->u_expert_model ->update(array('union_status'=>'1'),array('id'=>$id));  //0是无旅行社，1是合作中，-1是停用
		
		if ($status == false)
		{
			$this->__errormsg('操作失败');
		}
		else
		{
			$this->__data('操作成功');
			//$this ->log(3,3,'管家管理','恢复与管家合作，ID：'.$id);
			//$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			//$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::expert_back ,'isopen' =>1));
			//$this ->send_message($expert['mobile'] ,$sms['msg']);
		}
	}
	/**
	 * 导入销售
	 * */
	public function import_expert()
	{
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
	    $this->load->model('admin/t33/b_employee_model','b_employee_model');
	    $employee_id=$this->session->userdata("employee_id");
	    $employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
	    
	    $union_id=$employee['id'];
	    
	 
	    $data['depart']=$this->b_depart_model->all(array('union_id'=>$union_id,'status'=>'1','pid'=>'0'));
		$this->load->view("admin/t33/expert/import_expert",$data);
	}
	/**
	 * 解除和销售（管家）的关系
	 * */
	public function cancel_expert()
	{
		$expert_id=$this->input->post("id",true);
		$new_manage=$this->input->post('new_manage',true); //新的经理
		$action=$this->input->post('action',true); //是否要验证
		
		if(empty($expert_id))  $this->__errormsg('销售id不能为空');
		if ($new_manage=="-1"&&$action)
			$this->__errormsg('需指定新的经理');
		$this->load->model('admin/t33/u_expert_model','u_expert_model');
		$data=array(
			'union_id'=>"",
			'union_name'=>"",
			'depart_id'=>"",
			'depart_name'=>"",
			'depart_list'=>"-1",
			'is_dm'=>'0',
			//'expert_type'=>'0',
			'union_status'=>'-2' //0是解除关系，1是合作中，-1是停用
				
		);
		
		$this->u_expert_model->update(array('is_dm'=>'1'),array('id'=>$new_manage));
		$status=$this->u_expert_model->update($data,array('id'=>$expert_id));
		if($status)
			$this->__data('解除成功');
		else
			$this->__errormsg('解除失败');
			
	}
	/**
	 * 导入销售的源
	 * */
	public function api_import_expert()
	{
		
		$type=trim($this->input->post("type",true)); //供应商类型
		$realname=trim($this->input->post("realname",true));
		$mobile=trim($this->input->post("mobile",true));
		$province=trim($this->input->post("province",true));
		$city=trim($this->input->post("city",true));
	
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
			if(!empty($type))
				$where['type']=$type;
			if(!empty($realname))
				$where['realname']=$realname;
			if(!empty($mobile))
				$where['mobile']=$mobile;
			if(!empty($province))
				$where['province']=$province;
			if(!empty($city))
				$where['city']=$city;
	
			$return=$this->u_expert_model->import_expert_list($where,$from,$page_size);
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
	 * 导入管家=>处理操作
	 * @param array  供应商id数组
	 * */
	public function api_import_expert_deal()
	{
		$arr=$this->input->post('ids',true); //需导入的供应商数组
		$depart_id=$this->input->post('depart_id',true); //营业部id
		$depart_name=$this->input->post('depart_name',true); //营业部
		if(empty($arr))  $this->__errormsg('请选择要导入的销售');
		if(empty($depart_id))  $this->__errormsg('请选择导入到的营业部');
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			
			$this->load->model('admin/t33/u_expert_model','u_expert_model');
			$union=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
			$union_id=$union['id'];
			$status=true;
			foreach ($arr as $k=>$v)
			{
				$addtime=date("Y-m-d H:i:s");
				$this->load->model('admin/t33/b_depart_model','b_depart_model');
				$depart=$this->b_depart_model->row(array('id'=>$depart_id));
				$depart_list="";
				if($depart['pid']=="0")
				{
					$depart_list=$depart_id.",";
				}
				else
				{
					$depart_list=$depart['pid'].",".$depart_id.",";
				}
				$update_data=array(
						'depart_id'=>$depart_id,
						'depart_list'=>$depart_list,
						'expert_type'=>'1', //1是营业部管家
						'depart_name'=>$depart_name,
						'union_id'=>$union_id,
						'union_name'=>$union['union_name'],
						'modtime'=>$addtime,
						'union_status'=>'1' //0是无旅行社，1是合作中，-1是停用
						
				);
				$status=$this->u_expert_model->update($update_data,array('id'=>$v));
				
			}
			if($status)
				$this->__data('导入成功');
			else
				$this->__errormsg('导入失败');
		}
	
	}
	/**
	 * 营业部管理
	 * */
	public function depart()
	{
		$this->load->view("admin/t33/expert/depart");
	}
	/**
	 * 营业部列表
	 * */
	public function api_depart()
	{
		$name=trim($this->input->post("name",true));
		$pid=trim($this->input->post("pid",true));
		$linkman=trim($this->input->post("linkman",true));
		$status=trim($this->input->post("status",true));
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/b_depart_model','b_depart_model');
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
			if(!empty($name))
				$where['name']=$name;
			if(!empty($linkman))
				$where['linkman']=$linkman;
			if(!empty($status))
				$where['status']=$status;
			
			$where['pid']=$pid;
			
	
			$return=$this->b_depart_model->depart_list($where,$from,$page_size);
			$result=$return['result'];
			$total_rows=$return['rows'];
			$total_page=ceil ( $total_rows/$page_size );
	
			if(empty($result))  $this->__data($result);
			$output=array(
					'page_size'=>$page_size,
					'page'=>$page,
					'total_rows'=>$total_rows,
					'total_page'=>$total_page,
					'sql'=>$linkman,
					'result'=>$result
			);
			$this->__data($output);
		}
			
	}
	/**
	 * 添加营业部
	 * */
	public function api_add_depart()
	{
		$pid=trim($this->input->post("pid",true));
		$name=trim($this->input->post("name",true));
		$linkman=trim($this->input->post("linkman",true));
		$linkmobile=trim($this->input->post("linkmobile",true));
		$remark=trim($this->input->post("remark",true));
		$finance_id=trim($this->input->post("finance_id",true));
	
		if(empty($name))  $this->__errormsg('营业部名称不能为空');
		if(empty($linkman))  $this->__errormsg('联系人不能为空');
		if(empty($linkmobile))  $this->__errormsg('联系人电话不能为空');
		if(empty($finance_id))  $this->__errormsg('跟进财务人员不能为空');
		
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_employee_model','b_employee_model');
			$this->load->model('admin/t33/b_depart_model','b_depart_model');
			$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
			$union_id=$employee['id'];
			$union_name=$employee['union_name'];
		  
			$this->db->trans_begin();
			if($pid=="0")
			{
				$level="1";
			}
			else 
			{
				$depart=$this->b_depart_model->row(array('id'=>$pid));
				$level=$depart['level']+1;
			}
			
        	$addtime=date("Y-m-d H:i:s");
        	$data=array(
        		'name'=>$name,
        		'pid'=>$pid,
        		'level'=>$level,
        		'linkmobile'=>$linkmobile,
        		'linkman'=>$linkman,
        		'remark'=>$remark,
        		'addtime'=>$addtime,
        		'status'=>'1',
        		'modtime'=>$addtime,
        		'union_id'=>$union_id,
        		'union_name'=>$union_name,
        		'finance_id'=>$finance_id
        	);
        	$status=$this->b_depart_model->insert($data); //返回id
        	
        	//depart_list
        	$depart_list="";
        	if($pid=='0')
        	{
        		$depart_list=$status.',';
        	}
        	else 
        	{
        		$depart_list=$pid.','.$status.',';
        	}
        	$this->b_depart_model->update(array('depart_list'=>$depart_list),array('id'=>$status));
        	
        	if ($this->db->trans_status() === FALSE)
        	{
        		$this->db->trans_rollback();
        		$this->__data('添加失败');
        	}
        	else
        	{
        		$this->db->trans_commit();
        		$this->__data('添加成功');
        	}
        	
	       
			
		}
			
	}
	/**
	 * 旅行社下的员工
	 *
	 * */
	public function api_employee_list()
	{
		$content=$this->input->post("content");
		$union_id=$this->get_union();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$where=array('union_id'=>$union_id);
		if(!empty($content))
			$where['content']=$content;
		$employee=$this->b_employee_model->all($where);
		$this->__data($employee);
	}
	/**
	 * 营业部详情
	 * */
	public function api_depart_detail()
	{
		$id=trim($this->input->post("id",true));
		if(empty($id))  $this->__errormsg('营业部id不能为空');
		
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$data=$this->b_depart_model->depart_detail($id);
		$p=$this->b_depart_model->row(array('id'=>$data['pid']));
		if(empty($p))
		{
			$data['p_name']='顶级营业部';
		}
		else 
		{
		    $data['p_name']=$p['name'];
		}
		$this->__data($data);
	}
	/**
	 * 停用和开启营业部
	 * */
	public function stop_and_start()
	{
		
		$id=trim($this->input->post("id",true));
		$status=trim($this->input->post("status",true));
		if(empty($id))  $this->__errormsg('营业部id不能为空');
		if($status!="1"&&$status!="-1")  $this->__errormsg('营业部状态不能为空');
		
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		$re=$this->b_depart_model->update(array('status'=>$status),array('id'=>$id));
		if($re)
		{
			if($status=="1")
				$this->__data('已开启');
			else if($status=="-1")
				$this->__data('已停用');
			else 
				$this->__data('操作成功');
			
		}
		else
		$this->__errormsg('操作失败');
	}
	
	/**
	 * 修改营业部
	 * */
	public function api_edit_depart()
	{
		$pid=trim($this->input->post("pid",true));
		$id=trim($this->input->post("id",true));
		$name=trim($this->input->post("name",true));
		$linkman=trim($this->input->post("linkman",true));
		$linkmobile=trim($this->input->post("linkmobile",true));
		$remark=trim($this->input->post("remark",true));
		$finance_id=trim($this->input->post("finance_id",true));
		$finance_value=trim($this->input->post("finance_value",true));
		
		if(empty($name))  $this->__errormsg('营业部名称不能为空');
		if(empty($linkman))  $this->__errormsg('联系人不能为空');
		if(empty($linkmobile))  $this->__errormsg('联系人电话不能为空');
		
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$exist=$this->b_employee_model->row(array('realname'=>$finance_value));
		if(empty($finance_id)||empty($exist))  $this->__errormsg('请选择跟进财务人员');
	
		$employee_id=$this->session->userdata("employee_id");
		if(empty($employee_id))
			$this->__errormsg('请先登录');
		else
		{
			$this->load->model('admin/t33/b_depart_model','b_depart_model');
			$depart_row=$this->b_depart_model->row(array('id'=>$id));
			if($pid!="0")
			{
			$num_rows=$this->b_depart_model->num_rows(array('pid'=>$id)); //判断当前部门下面是否有组别
			if($num_rows>0)
				$this->__errormsg('当前部门存在子级部门，无法移动');
			}
			
			$addtime=date("Y-m-d H:i:s");
			$depart_list="";//depart_list
			if($pid=="0")
			{
				$level="1";
				$depart_list=$id.',';
			}
			else
			{
				$depart=$this->b_depart_model->row(array('id'=>$pid));
				$level=$depart['level']+1;
				$depart_list=$pid.','.$id.',';
			}

			$data=array(
					'name'=>$name,
					'level'=>$level,
					'linkmobile'=>$linkmobile,
					'linkman'=>$linkman,
					'remark'=>$remark,
					'pid'=>$pid,
					'depart_list'=>$depart_list,
					'modtime'=>$addtime,
					'finance_id'=>$finance_id
			);
			$status=$this->b_depart_model->update($data,array('id'=>$id));
			
			//修改这个部门下所有管家的depart_list
			$this->u_expert_model->update(array('depart_list'=>$depart_list,'depart_name'=>$name),array('depart_id'=>$id));
			
			if($status)
			{
				//若修改了部门名称或者部门层级，则写入操作日志
				$this->load->model('admin/t33/sys/b_update_expert_log_model','b_update_expert_log_model');
				$user=$this->userinfo();
				$log_data=array(
					'employee_id'=>$user['id'],
					'employee_name'=>$user['realname'],
					'addtime'=>date("Y-m-d H:i:s")
				);
				if($depart_row['name']!=$name)
				{
					$log_data['remark']='将营业部名称由['.$depart_row['name'].']变更为['.$name.']';
					$this->b_update_expert_log_model->insert($log_data);
				}
				if($depart_row['depart_list']!=$depart_list)
				{
					$log_data['remark']='将营业部depart_list由['.$depart_row['depart_list'].']变更为['.$depart_list.']';
					$this->b_update_expert_log_model->insert($log_data);
				}
				
				$this->__data('修改成功');
			}
			else
				$this->__data('添加失败');
			
				
		}
			
	}
	/**
	 * 营业部银行卡账号
	 * */
	public function depart_bank()
	{
		$depart_id=$this->input->get("depart_id",true);
		$this->load->model('admin/t33/b_depart_bank_model','b_depart_bank_model');
		$data['list'] = $this ->b_depart_bank_model ->result(array('depart_id'=>$depart_id));
		$data['depart_id']=$depart_id;
	
		$this->load->view("admin/t33/expert/depart_bank",$data);
	}
	/**
	 * 设置银行卡账户
	 * */
	public function api_set_bank()
	{
		$post_arr=$this->input->post("post_arr",true); //银行账户，数组
		$this->load->model('admin/t33/b_depart_bank_model','b_depart_bank_model');
		$this->db->trans_begin();
		$addtime=date("Y-m-d H:i:s");
		foreach ($post_arr as $k=>$v)
		{
			if(empty($v['id']))
			{
	
				$insert_data=array(
						'depart_id'=>$v['depart_id'],
						'bankname'=>$v['bankname'],
						'branch'=>$v['branch'],
						'bankcard'=>$v['bankcard'],
						'cardholder'=>$v['cardholder'],
						'addtime'=>$addtime
				);
				$this->b_depart_bank_model->insert($insert_data);
			}
			else
			{
				$where=array('id'=>$v['id']);
				$data=array(
						'bankname'=>$v['bankname'],
						'branch'=>$v['branch'],
						'bankcard'=>$v['bankcard'],
						'cardholder'=>$v['cardholder']
				);
				$this->b_depart_bank_model->update($data,$where);
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
	 * 营业部佣金设置
	 * */
	public function  depart_cash()
	{
		$this->load->view("admin/t33/expert/depart_cash");
	}
	/**
	 * 修改营业部的额度
	 * */
	public function api_edit_cash()
	{
		$id=$this->input->post("id",true); //营业部id
		$cash_limit=$this->input->post("cash_limit",true); //现金额度
		$credit_limit=$this->input->post("credit_limit",true); //信用额度
		if(empty($id))  $this->__errormsg('营业部id不能为空');
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
		
		//旅行社id
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee_id=$this->session->userdata("employee_id");
		$employee=$this->b_employee_model->get_employee_union(array('employee_id'=>$employee_id));
		$union_id=$employee['id'];
		
		$addtime=date("Y-m-d H:i:s");
		$this->db->trans_begin();
		$row=$this->b_depart_model->row(array('id'=>$id));
		if(empty($row)) $this->__errormsg('营业部不存在');
		else
		{
			$change=$cash_limit-$row['cash_limit']; //现金额度差
			$credit_change=$credit_limit-$row['credit_limit']; //信用额度差
		}
		if($change!="0") //现金额度发生改变时
		{
			$status=$this->b_depart_model->update(array('cash_limit'=>$cash_limit,'modtime'=>$addtime),array('id'=>$id));
            $new=$this->b_depart_model->row(array('id'=>$id));//最新的部门额度
		    $log=array(
		    	'depart_id'=>$id,
		    	'union_id'=>$union_id,
		    	'cash_limit'=>$new['cash_limit'],
		    	'credit_limit'=>$new['credit_limit'],
		    	'receivable_money'=>$change,	
		    	'addtime'=>$addtime,
		    	'type'=>'调整现金额度',
		    	'remark'=>'旅行社端:手动修改营业部现金账户额度'
		    );
		    $this->write_limit_log($log);
		}
		if($credit_change!="0") //信用额度发生改变时
		{
			$status=$this->b_depart_model->update(array('credit_limit'=>$credit_limit,'modtime'=>$addtime),array('id'=>$id));
			$new=$this->b_depart_model->row(array('id'=>$id));//最新的部门额度
			$log=array(
					'depart_id'=>$id,
					'union_id'=>$union_id,
					'cash_limit'=>$new['cash_limit'],
					'credit_limit'=>$new['credit_limit'],
					'receivable_money'=>$credit_change,
					'addtime'=>$addtime,
					'type'=>'调整信用额度',
					'remark'=>'旅行社端:手动修改营业部信用账户额度'
			);
			$this->write_limit_log($log);
		}
	    //返回结果
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('保存失败');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data('保存成功');
		}
		
	}
}

/* End of file login.php */
