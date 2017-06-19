<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends UB1_Controller {
	function __construct(){
		//$this->need_login = true;
		parent::__construct();
	   $this->load->helper(array('form', 'url'));
	   $this->load->helper('url');
		$this->load->database();
		$this->load->model('admin/b1/user_model');
		$this->load->library('session');
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index()
	{   
		
		//启用session
		$arr=$this->getLoginSupplier();
		$login_name=$arr['login_name'];
		
		//个人资料的遍历
		$user=$this->user_model->get_last_ten_supplier($login_name);
		foreach ($user as $row){
			$data['realname']=$row->realname;
			$data['mobile']=$row->mobile;
			$data['email']=$row->email;
			$data['idcard']=$row->idcard;
			$data['idcardpic']=$row->idcardpic;
			$data['business_licence']=$row->business_licence;
			$data['licence_img']=$row->licence_img ;
			$data['insurace_img']=$row->insurace_img;
			$data['city']=$row->city;
			$data['beizhu']=$row->beizhu;
			$data['country']=$row->country;
			$data['province']=$row->province;
			$data['city']=$row->city;
			$data['region']=$row->region;
			$data['brand']=$row->brand;
			$data['company_name']=$row->company_name;
			$data['idcard_type']=$row->idcard_type;
			$data['idcard']=$row->idcard;
			$data['telephone']=$row->telephone;
			$data['fax']=$row->fax;
			$data['business_licence_code']=$row->business_licence_code;
			$data['endtime']=$row->endtime;
			$data['corp_name']=$row->corp_name;
			$data['corp_idcardpic']=$row->corp_idcardpic;
			$data['expert_business']=$row->expert_business;
			$data['linkman']=$row->linkman;
			$data['link_mobile']=$row->link_mobile;
			$data['linkemail']=$row->linkemail;
			$data['licence_img_code']=$row->licence_img_code;
		}
	//	var_dump($data);exit;
		//获取国家
		$this ->db ->select('id,name');
		$this ->db ->from('u_area');
		$this ->db ->where(array('pid' =>0 ,'isopen' =>1));
		$this ->db ->order_by("displayorder", "asc");
		$query = $this ->db ->get();
		$data['area'] = $query ->result_array();
		//获取地区
		if(!empty($data['country'])){
			$pid=$data['country'];
			$this ->db ->select('id,name');
			$this ->db ->from('u_area');
			$this ->db ->where(array('pid' =>$pid ,'isopen' =>1));
			$this ->db ->order_by("displayorder", "asc");
			$query = $this ->db ->get();
			$data['province_arr']= $query ->result_array();
		}
		if(!empty($data['province'])){
			// 获取某个地区的名称		
			$this ->db ->select('id,name');
			$this ->db ->from('u_area');
			$this ->db ->where(array('pid' =>$data['province'] ,'isopen' =>1));
			$this ->db ->order_by("displayorder", "asc");
			$query = $this ->db ->get();
			$area = $query ->result_array();
			$data['city_arr'] = $query ->result_array();
		}
	    //var_dump($data['city_arr']);exit;
		if(!empty($data['city'])){
			// 获取某个地区的名称
			$this ->db ->select('id,name');
			$this ->db ->from('u_area');
			$this ->db ->where(array('pid' =>$data['city'] ,'isopen' =>1));
			$this ->db ->order_by("displayorder", "asc");
			$query = $this ->db ->get();
			$area = $query ->result_array();
			$data['region_arr'] = $query ->result_array();
		}
	
		//var_dump($data['region_arr']);exit;
		//上门服务
		$data['visit_service']=$this->user_model->get_expert_service($login_name);
		//exit;
		//证件类型
		$data['certify_tyle']=$this->user_model->description_data('DICT_CERTIFY_WAY');
		
		$this->load->view('admin/b1/header.html');
		$this->load->view("admin/b1/user_data",$data);
		$this->load->view('admin/b1/footer.html');
	}

	//修改管家资料
	 function update_userdata(){
	 	//资料的修改 
	 	$arr=$this->getLoginSupplier();
		$login_name=$arr['login_name'];
		if($this->is_post_mode()){
			
			$linkman=$this->input->post('linkman');
		//	$realname=$this->input->post('realname');
			$link_mobile=$this->input->post('link_mobile');
			//$mobile=$this->input->post('mobile');
		//	$email=$this->input->post('email');
			$idcard=$this->input->post('idcard');
			$corp_idcardpic=$this->input->post('corp_idcardpic');
			$city=$this->input->post('city');
			$beizhu=$this->input->post('beizhu');
			$licence_img=$this->input->post('licence_img');
			$insurace_img=$this->input->post('insurace_img');
			$country_id=$this->input->post('country_id');
			$province_id=$this->input->post('province_id');
			$city_id=$this->input->post('city_id');
			$region_id=$this->input->post('region_id');
			$fax=$this->input->post('fax');
			$telephone=$this->input->post('telephone');
			$idcardpic=$this->input->post('idcardpic');
			$corp_name=$this->input->post('corp_name');
			$linkemail=$this->input->post('linkemail');
			$expert_business=$this->input->post('expert_business');
           	$licence_img_code=$this->input->post('licence_img_code');
/* 			$check_mobile =$this->user_model->get_last_user(array('mobile'=>$mobile,'status'=>2),$arr['id']);		
			if(!empty($check_mobile['id'])){
				echo "<script>alert('电话号码已经存在了!');window.location.href='/admin/b1/user'</script>";
				return FALSE;
			} */
           	if(empty($linkman)){
           		echo  json_encode(array('status'=>-1,'msg'=>'联系人不能为空'));exit;
           	}
           	if(empty($linkemail)){
           		echo  json_encode(array('status'=>-1,'msg'=>'联系人邮箱不能为空'));exit;
           	}
            if(empty($link_mobile)){
            	echo  json_encode(array('status'=>-1,'msg'=>'联系人手机号码不能为空'));exit;
            }else{
            	//手机验证
            	if(!preg_match("/^1[34578]\d{9}$/", $link_mobile)){
            		echo  json_encode(array('status'=>-1,'msg'=>'联系人手机格式不对!'));exit;
            	}
            }
        
           	//固定电话
           	$isTel="/^([0-9]{3,4}-)?[0-9]{7,8}$/";
           	if(!empty($telephone)){
           		if(!preg_match($isTel,$telephone)){
           			echo  json_encode(array('status'=>-1,'msg'=>'固定电话格式不对!'));exit;
           		}
           	}
 	
			$config['upload_path']="./file/b1/images/".date("Y/m-d");//文件上传目录
			if(!file_exists("./file/b1/images/".date("Y/m-d"))){
				mkdir("./file/b1/images/".date("Y/m-d"),0777,true);//原图路径
			}

			$supplier=array(
					'linkman'=>$linkman,
					//'mobile'=>$mobile,
				//	'email'=>$email,
					'city'=>$city,
					'beizhu'=>$beizhu,
					'licence_img'=>$licence_img,
					'country'=>$country_id,
					'province'=>$province_id,
					'city'=>$city_id,
					'region'=>$region_id,
					'modtime'=>date('Y-m-d H:i:s',time()),
					'telephone'=>$telephone,
					'fax'=>$fax,
					'corp_name'=>$corp_name,
					'expert_business'=>$expert_business,
				//	'realname'=>$realname,
					'link_mobile'=>$link_mobile,
					'linkemail'=>$linkemail,
					'licence_img_code'=>$licence_img_code
			);
			//启用session
			
			$where['id']=$arr['id'];
			$res=$this->user_model->upload_supplier($supplier,$where);
			if($res){
				echo  json_encode(array('status'=>1,'msg'=>'修改成功!'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'修改失败!'));
			}			
			
		}	
	 }
	/*
	 * 获取地区
	*/
	public function get_area() {
		$pid = intval($_POST['id']);
		$this ->db ->select('id,name');
		$this ->db ->from('u_area');
		$this ->db ->where(array('pid' =>$pid ,'isopen' =>1));
		$this ->db ->order_by("displayorder", "asc");
		$query = $this ->db ->get();
		$area = $query ->result_array();
		echo json_encode($area);
	}
	/*
	 * 获取某个地区的名称
	*/
	public function get_area_name ($id) {
		$this ->db ->select('id,name');
		$this ->db ->from('u_area');
		$this ->db ->where(array('id' =>$id ,'isopen' =>1));
		$query = $this ->db ->get();
		$area = $query ->result_array();
		return $area [0]['name'];
	}
/* 	
	//发送邮箱
	function to_email()
	{
		require '/file/common/plugins/PHPMailer/class.phpmailer.php';
		$mail = new PHPMailer(); //实例化
		$mail->IsSMTP(); // 启用SMTP
		$mail->Host = "smtp.163.com"; //SMTP服务器 这里以新浪邮箱为例子
		$mail->Port = 25;  //邮件发送端口
		$mail->SMTPAuth   = true;  //启用SMTP认证
		$mail->CharSet  = "UTF-8"; //字符集
		$mail->Encoding = "base64"; //编码方式
		$mail->Username = "13926704138@163.com";  //你的邮箱
		$mail->Password = "13926704138";  //你的密码
		$mail->Subject = "测试邮件标题"; //邮件标题
		$mail->From = "13926704138@163.com";  //发件人地址（也就是你的邮箱）
		$mail->FromName = "test";  //发件人姓名
		$address = "xml717@qq.com";//收件人email
		$mail->AddAddress($address, "某某人");//添加收件人地址，昵称
		$mail->IsHTML(true); //支持html格式内容
		$mail->Body = "这是一份测试邮件，此为邮件内容"; //邮件内容
		//发送
		if(!$mail->Send()) {
			echo "fail: " . $mail->ErrorInfo;
		} else {
			echo "ok";
		}
	
	} */

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */