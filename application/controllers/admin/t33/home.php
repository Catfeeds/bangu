<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends T33_Controller {
	
	/**
	 * 旅行社登录页
	 * */
	public function index()
	{
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$sess_employee_id=$this->session->userdata("employee_id");
		$data['employee']=$this->b_employee_model->row(array('id'=>$sess_employee_id));
		$data['menu']=$this->b_employee_model->get_role_menu(array('role_id'=>$data['employee']['role_id']));
		$data['user']=$this->userinfo();
		$data['employee_id'] = $sess_employee_id;
		//echo $this->db->last_query();
		
		//营业部管家，获取t33站内消息
		$this ->load_model('msg/msg_send_model' ,'send_model');
		//未读消息数量
		$whereArr = array(
				'ms.status =' =>0,
				'sp.user_id =' =>$sess_employee_id,
				'in' =>array('sp.user_type' =>'4,5,6')
		);
		$data['num'] = $this ->send_model ->getUnreadMsgCount($whereArr);
		
		//获取最新的5条未读消息
		$data['msgArr'] = $this ->send_model ->getNewMsgData($whereArr);
		
		$this->load->view('admin/t33/home_view',$data);
	}
	/**
	 * 外网：删手机号
	 * */
	public function del()
	{
		$this->load->view('admin/t33/del');
	}
	public function api_del_mobile()
	{
		$mobile=$this->input->post("mobile",true);
		if(empty($mobile))   $this->__errormsg('手机不能为空');
		
		$list=array(
			'13332900743',
			'13750024642',
			'13823049829',
			'15626427683',
			'13750018233',
			'15844229646',
			'13600436090',
			'13923782993',
			'13560371191',
			'15220208929',
			'13602534565',
			'13434153709',
			'15914125642',
			'18923082343',
			'13332985175',
			'15914125642',
			'13510591515',
			'18162191797',
			'13751136926',
			'13480122473',
			'13802565406',
			'13902319810',
			'13725513230',
			'13266565587',
			'18566626551',
			'15818602559',
			'15979141401',
			'13590107614',
			'13066908509',
			'18775393022',
			'13725513230',
			'13510509009',
			'15932812726',
			'13152571631',
			'17076903948',
			'18770073655',
			'13527212838',
			'15521243713',
			'13712266062'
		);
		if(!in_array($mobile, $list))  $this->__errormsg('该手机不允许删除');
		
		$this->load->model('admin/t33/u_member_model','u_member_model');
		$row=$this->u_member_model->row(array('loginname'=>$mobile));
		if(empty($row)) $this->__errormsg('手机号不存在或已删除');
		
		$status=$this->u_member_model->update(array('mobile'=>$mobile.'0','loginname'=>$mobile.'0'),array('mid'=>$row['mid']));
		if($status) $this->__data('已删除');
		else  $this->__errormsg('删除失败');
		
	}
	/**
	 * 图片上传
	 * */
	public function upload_img()
	{
		$inputname=$this->input->post("inputname",true); //file文本域的name属性值
		
		$typeArr = array("jpg", "jpeg","png", "gif");//允许上传文件格式
		$time = date('Ymd',time());
	
		$path ="./file/upload/".$time."/"; //上传路径
        $return="/file/upload/".$time."/"; //返回的路径
		if (!file_exists($path)) 
		{
			$status = mkdir($path ,0777 ,true);
			if ($status == false) 
				$this->__errormsg('图片上传失败');
		}
		//上传
		if (!empty($_FILES)) 
		{
			$name = $_FILES[$inputname]['name'];
			$size = $_FILES[$inputname]['size'];
			$name_tmp = $_FILES[$inputname]['tmp_name'];
			
			if (empty($name)) 
				$this->__errormsg('您还未选择图片');
			$type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
			if (!in_array($type, $typeArr)) 
				$this->__errormsg('请上传jpg,png或gif类型的图片！');
				
			$pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
			$pic_url = $path . $pic_name;//上传后图片路径+名称
			$return_url=$return.$pic_name;
		
			if (move_uploaded_file($name_tmp, $pic_url)) 
			{    //临时文件转移到目标文件夹
				echo json_encode(array("code"=>"2000","msg"=>"success","imgurl"=>$return_url));
					
			}
			else 
			{
				$this->__errormsg('上传有误，清检查服务器配置！');
				
			}
		}
		else
		{
			$this->__errormsg('请选择图片');
		}
	
	}
	/**
	 * 文件上传
	 * */
	public function upload_file()
	{
		$inputname=$this->input->post("inputname",true); //file文本域的name属性值
	
		$typeArr = array("jpg", "jpeg","png", "gif");//允许上传文件格式
		$time = date('Ymd',time());
	
		$path ="./file/t33/".$time."/"; //上传路径
		$return="/file/t33/".$time."/"; //返回的路径
		if (!file_exists($path))
		{
			$status = mkdir($path ,0777 ,true);
			if ($status == false)
				$this->__errormsg('图片上传失败');
		}
		//上传
		if (!empty($_FILES))
		{
			$name = $_FILES[$inputname]['name'];
			$size = $_FILES[$inputname]['size'];
			$name_tmp = $_FILES[$inputname]['tmp_name'];
				
			if (empty($name))
				$this->__errormsg('您还未选择文件');
			$type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
			
			$pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
			$pic_url = $path . $pic_name;//上传后图片路径+名称
			$return_url=$return.$pic_name;
	
			if (move_uploaded_file($name_tmp, $pic_url))
			{    //临时文件转移到目标文件夹
				echo json_encode(array("code"=>"2000","msg"=>"success","imgurl"=>$return_url,"filename"=>$name));
					
			}
			else
			{
				$this->__errormsg('上传有误，清检查服务器配置！');
	
			}
		}
		else
		{
			$this->__errormsg('请选择图片');
		}
	
	}
	//修改信息
	public function update_info()
	{
		$user=$this->userinfo();
		$this->load->view('admin/t33/pwd',$user);
	}
	//修改信息:处理
	public function api_update_info()
	{
		$realname=$this->input->post("realname",true);
		$sex=$this->input->post("sex",true);
		$mobile=$this->input->post("mobile",true);
		$email=$this->input->post("email",true);
		$remark=$this->input->post("remark",true);
		$password=$this->input->post("password",true);
		
		if($sex!="0"&&$sex!="1") $this->__errormsg('请选择性别');
		if(empty($realname))  $this->__errormsg('真实姓名不能为空');
		if(empty($mobile))    $this->__errormsg('手机号码不能为空');
		
		$update=array(
			'realname'=>$realname,
			'mobile'=>$mobile,
			'email'=>$email,
			'remark'=>$remark,
			'sex'=>$sex,
			'modtime'=>date("Y-m-d H:i:s"),	
		);
		if(!empty($password))  $update['pwd']=md5($password);
		$user=$this->userinfo();
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$status=$this->b_employee_model->update($update,array('id'=>$user['id']));
		if($status)  $this->__data('保存成功');
		else         $this->__errormsg('保存失败');
  	}
	
	public function content()
	{
		$this->load->view('admin/t33/content');
	}
	public function main()
	{
		$this->load->view('admin/t33/main');
	}
	public function test()
	{
		$this->load->view('admin/t33/test');
	}
	public function order_detail()
	{
		$this->load->view('admin/t33/order_detail');
	}
	
	public function table_example()
	{
		$this->load->view('admin/t33/table_example');
	}
}

/* End of file login.php */
