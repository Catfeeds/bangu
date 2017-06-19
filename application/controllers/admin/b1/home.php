<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->helper(array('form', 'url'));
		$this->load->database();
		$this->load->model('admin/b1/user_model');
		$this ->load_model('common/u_supplier_model' ,'supplier_model');
		set_error_handler('customError');
	}
	public function index() {
		redirect('admin/b1/index' );
	}
	
	//登录
	public function do_login()
	{
        $this->load->library ( 'callback' );
		$login_name=trim($this->input->post('username'));
		$password=trim($this->input->post('password'));
		$verifycode = strtolower($this->input->post('verifycode'));
      	// $remember = intval($this ->input ->post('remember'));//是否记住密码
       	// $auto_login = intval($this ->input ->post('auto_login')); //是否自动登陆
			
		if ($verifycode !== strtolower($this->session->userdata('captcha')))
		{
			$this ->callback ->setJsonCode(4000 ,'验证码错误');
		}
		if (empty($login_name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写用户名');
		}
		if (empty($password))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写密码');
		}
			
		$supplierData = $this->supplier_model ->getLoginData($login_name);
		//echo $this ->db ->last_query();exit;
		//现在这个很麻烦，无法保证数据库的账号唯一，所以循环验证
// 		$supplierData[0] = array(
// 				'id' =>'1258',
// 				'status' =>1,
// 				'bs_status' =>1,
// 				'logindatetime' =>'2016-11-02',
// 				'login_name' =>'13924593259',
// 				'linkman' =>'刘金生',
// 				'realname' =>'王译平'
// 		);
		$supplierArr = array();
		if (!empty($supplierData))
		{
			$num = count($supplierData);
			if ($num == 1)
			{
				//数据库只有一个账号
				if (md5($password) != $supplierData[0] ['password'])
				{
					$this ->callback ->setJsonCode(4000 ,'密码不正确');
				}
				if ($supplierData[0]['status'] == 2 || $supplierData[0]['bs_status'] == 1)
				{
					//平台已通过或者旅行社导入了
					$supplierArr = $supplierData[0];
				}
				elseif ($supplierData[0]['status'] == 1 || $supplierData[0]['status'] == 3)
				{
					$this->session->set_userdata(array('perfectId' =>$supplierData[0]['id']));
					$this ->callback ->setJsonCode(7000 ,$supplierData[0]['id']);
				}
				elseif ($supplierData[0]['status'] == -2)
				{
					$this ->callback ->setJsonCode(4000 ,'您的账号已被终止，请联系客服');
				}
				elseif ($supplierData[0]['status'] == -1)
				{
					$this ->callback ->setJsonCode(4000 ,'您的账号已被冻结，请联系客服');
				}
				else
				{
					$this ->callback ->setJsonCode(4000 ,'账号不存在');
				}
			}
			else 
			{
				//先判断是否有平台通过或旅行社导入的供应商
				$dataArr = array();
				foreach($supplierData as $v)
				{
					if ($v['status'] == 2 || $v['bs_status'] == 1){
						$dataArr[] = $v;
					}
				}
				if (empty($dataArr))
				{
					//没有符合登录条件数据，取第一条进行说明
					if ($supplierData[0]['status'] == 1 || $supplierData[0]['status'] == 3)
					{
						$this->session->set_userdata(array('perfectId' =>$supplierData[0]['id']));
						$this ->callback ->setJsonCode(7000 ,$supplierData[0]['id']);
					}
					elseif ($supplierData[0]['status'] == -2)
					{
						$this ->callback ->setJsonCode(4000 ,'您的账号已被终止，请联系客服');
					}
					elseif ($supplierData[0]['status'] == -1)
					{
						$this ->callback ->setJsonCode(4000 ,'您的账号已被冻结，请联系客服');
					}
					else
					{
						$this ->callback ->setJsonCode(4000 ,'账号不存在');
					}
				}
				else 
				{
					$is = false;
					foreach($dataArr as $v)
					{
						if (md5($password) == $v['password'])
						{
							$is = true;
							$supplierArr = $v;
						}
					}
					if ($is === false) {
						$this ->callback ->setJsonCode(4000 ,'密码不正确');
					}
					
				}
			}
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'账号不存在');
		}
		
		$infoArr = array(
				'logindatetime' =>$supplierArr['logindatetime'],
				'login_name' =>$supplierArr['login_name'],
				'login_realname'=>$supplierArr['realname'],
				'linkman'=>$supplierArr['linkman'],
				'id' =>$supplierArr['id']
		);
		
		$this->session->set_userdata("loginSupplier",$infoArr );
		$this->session->set_userdata('login_id',$supplierArr ['id']);
		
		//是否是联盟供应商
		$is_union = $supplierArr['bs_status'] == 1 ? 1 : 0;
		$this->session->set_userdata('is_union',$is_union);

		$loginInfo = array(
				'logindatetime' =>date('Y-m-d H:i:s' ,time()),
				'loginip' =>$this->getip()
		);
		$this ->supplier_model ->update($loginInfo ,array('id' =>$supplierArr['id']));
		$this ->callback ->setJsonCode(2000 ,'登陆成功');
	}
	
	//退出登录
	public function login_out(){
	
		$this->load->library('session');
		$array_items = array('loginSupplier' => '', 'login_id' => '');
		$this->session->unset_userdata($array_items);
		$this->session->unset_userdata(array('is_union'=>0));	
		redirect('admin/b1/home');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */