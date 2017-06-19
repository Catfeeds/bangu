<?php
/**
 * **
 * 深圳海外国际旅行社
 * 贾开荣
 * 2015-5-5
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Register extends  MY_Controller{
	public function __construct()
	{
		parent::__construct ();
		header ( "content-type:text/html;charset=utf-8" );
		$this->load->library ( 'callback' );
		$this ->load_model('common/u_supplier_model' ,'supplier_model');
		$this->load->helper ( 'regexp' );
	}
	
	//进入注册页面
	public function index()
	{
		$this ->load_view('admin/b1/register_one');
	}
	//审核拒绝，完善信息
	public function perfectInfo()
	{
		$id = intval($this ->input ->get('sid'));
		$perfectId = $this ->session ->userdata('perfectId');
		if ($perfectId != $id) {
			header("Location:/admin/b1/index");exit;
		}
		$data['supplier'] = $this ->supplier_model ->row(array('id' =>$id));
		$this ->load_view('admin/b1/register_one' ,$data);
	}
	
	
	/**
	 * @method 商家注册
	 * @author 贾开荣
	 */
	public function supplier_register()
	{
		$post = $this->security->xss_clean($_POST);
		foreach($post as &$val) {
			$val = trim($val);
		}
		$supplierArr = $this ->common_supplier($post ,1);
		$status = $this ->db ->insert('u_supplier' ,$supplierArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'注册失败,请稍后重试');
		}
		else
		{
			$this ->session ->unset_userdata('mobile_code');
			$this ->callback ->setJsonCode(2000 ,'注册成功');
		}
	}
	
	/**
	 * @method 审核拒绝后供应商完善信息
	 * @author jiakairong
	 * @since  2015-10-20
	 */
	public function perfect_supplier()
	{
		$post = $this->security->xss_clean($_POST);
		foreach($post as &$val) {
			$val = trim($val);
		}
		$supplierArr = $this ->common_supplier($post ,2);
		$status = $this ->supplier_model ->update($supplierArr ,array('id' =>intval($post['sid'])));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'信息完善失败,请稍后再试');
		} 
		else
		{
			$this ->session ->unset_userdata('mobile_code');
			$this ->session ->unset_userdata('perfectId');
			$this ->callback ->setJsonCode(2000 ,'完善成功');
		}
	}
	
	/**
	 * @method 供应商信息验证
	 * @param array $post 供应商信息
	 * @param intval $type 类型 	1：供应商注册，2：供应商信息完善
	 */
	public function common_supplier($post ,$type)
	{
		$time = time();
		$kind = intval($post['kind']);//供应商类型 1：国内，2：个人，3：境外
		
		if ($kind != 1 && $kind != 2 && $kind != 3)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择供应商类型');
		}
		//验证验证码
		if ($kind == 1 || $kind == 2)
		{
			//验证手机号和手机验证码
			$mobileCode = $this ->session ->userdata('mobile_code');
			if (empty($mobileCode))
			{
				$this ->callback ->setJsonCode(4000 ,'请您先获取手机验证码');
			}
			else
			{
				//验证是否已超过10分钟
				$endtime = $time - $mobileCode['time'];
				if ($endtime > 600)
				{
					$this ->callback ->setJsonCode(4000 ,'您的验证码已过期，请重新获取');
				}
				//验证验证码
				if ($mobileCode['mobile'] != $post['mobile'] || $mobileCode['code'] != $post['code'])
				{
					$this ->callback ->setJsonCode(4000 ,'您的验证码不正确');
				}
			}
		}
		else
		{
			if (strtolower($post['code']) != strtolower($this->session->userdata('captcha')))
			{
				$this ->callback ->setJsonCode(4000 ,'验证码错误');
			}
			//境外手机号验证
			if (!preg_match("/^[0-9]+$/",$post['mobile']))
			{
				$this ->callback ->setJsonCode(4000 ,'请输入正确的手机号');
			}
		}
		
		//验证密码
		if (preg_match('/\s/' ,$post['password']))
		{
			$this ->callback ->setJsonCode(4000 ,'密码中不可以有空格');
		}
		else
		{
			$passLen = strlen($post['password']);
			if ($passLen > 20 || $passLen < 6)
			{
				$this ->callback ->setJsonCode(4000 ,'请填写6到20位的密码');
			}
			if ($post['password'] != $post['repass'])
			{
				$this ->callback ->setJsonCode(4000 ,'您两次密码输入不一致');
			}
		}
		//验证负责人姓名
		if (empty($post['responname']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写负责人姓名');
		}
		//有效证件
		if (empty($post['cardImgUrl']))
		{
			if ($kind == 3) {
				$this ->callback ->setJsonCode(4000 ,'请上传有效证件');
			} else {
				$this ->callback ->setJsonCode(4000 ,'请上传身份证扫描件');
			}
		}
		//供应商所在地
		if ($kind == 3)
		{
			if (empty($post['province'])) {
				$this ->callback ->setJsonCode(4000 ,'请选择供应商所在地');
			}
		} else {
			if (empty($post['province']) || !isset($post['city']) || empty($post['city']))
			{
				$this ->callback ->setJsonCode(4000 ,'请选择供应商所在地');
			}
		}
		//品牌
		if (empty($post['brand']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写供应商品牌');
		}
		//主营业务
		if (empty($post['expert_business']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写主营业务');
		}
		//联系人
		if (empty($post['linkman']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写联系人姓名');
		}
		if (!regexp('email' ,$post['linkemail']))
		{
			$this ->callback ->setJsonCode(4000 ,'请输入正确的联系人邮箱号');
		}
		
		if (empty($post['link_mobile']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写联系人手机号');
		}
		
		
		//验证邮箱
		if (!regexp('email' ,$post['email']))
		{
			$this ->callback ->setJsonCode(4000 ,'请输入正确的邮箱号');
		}
		
		//企业信息验证
		if ($kind == 1 || $kind == 3)
		{
			//企业名称
			if (empty($post['company_name']))
			{
				$this ->callback ->setJsonCode(4000 ,'请填写企业名称');
			}
			if (empty($post['corp_name']))
			{
				$this ->callback ->setJsonCode(4000 ,'请填写法人代表姓名');
			}
		}
		if ($kind == 1)
		{
			if (empty($post['business_licence']))
			{
				$this ->callback ->setJsonCode(4000 ,'请上传营业执照扫描件');
			}
			if (empty($post['licence_img']))
			{
				$this ->callback ->setJsonCode(4000 ,'请上传经营许可证扫描件');
			}
			if (empty($post['licence_img_code']))
			{
				$this ->callback ->setJsonCode(4000 ,'请填写经营许可证号');
			}
		}
		//获取平台的管理费率
		$this ->load_model('web_model');
		$webArr = $this ->web_model ->row(array('id' =>1) ,'arr' ,'' ,'agent_rate');
		//获取地区首层
		$this ->load_model('common/u_area_model' ,'area_model');
		$areaData = $this ->area_model ->row(array('id' =>$post['province'])); 
		if (empty($areaData)) {
			$country = 0;
		} else {
			$country = $areaData['pid'];
		}
		
		//验证登录账号是否存在
		$login_name = $post['mobile'];
		if ($type == 1)
		{
			//验证手机号是否存在(除了被拒绝的手机号之外还有记录则不可以注册)
			$whereArr = array(
					'login_name =' =>$login_name,
					'status !=' =>3
			);
			$supplierData = $this ->supplier_model ->uniqueLoginname($whereArr);
			if (!empty($supplierData))
			{
				$this ->callback ->setJsonCode(4000 ,'手机号已存在');
			}
		} else {
			//完善信息
			//验证手机号是否存在(除了被拒绝的手机号之外还有记录则不可以注册),除自己之外
			$whereArr = array(
					'login_name =' =>$login_name,
					'status !=' =>3,
					'id !=' =>$post['sid']
			);
			$supplierData = $this ->supplier_model ->uniqueLoginname($whereArr);
			if (!empty($supplierData))
			{
				$this ->callback ->setJsonCode(4000 ,'手机号已存在');
			}
		}
		
		
		$date = date('Y-m-d H:i:s' ,$time);
		$supplierArr = array(
			'kind' =>$kind,
			'login_name' =>$login_name,
			'password' =>md5($post['password']),
			'realname' =>$post['responname'],
			'mobile' =>$post['mobile'],
			'email' =>$post['email'],
			'linkemail' =>$post['linkemail'],
			'idcardpic' =>$post['cardImgUrl'],
			'province' =>intval($post['province']),
			'city' =>isset($post['city']) ? intval($post['city']) : 0,
			'brand' =>$post['brand'],
			'expert_business' =>$post['expert_business'],
			'linkman' =>$post['linkman'],
			'telephone' =>$post['tel'],
			'link_mobile' =>$post['link_mobile'],
			'fax' =>$post['fax'],
			'addtime' =>$date,
			'modtime' =>$date,
			'status' =>1,
			'enable' =>0,
			'agent_rate' =>$webArr['agent_rate'],
			'country' =>$country
		);
		if ($kind == 1) {
			$supplierArr['company_name'] = $post['company_name'];
			$supplierArr['business_licence'] = $post['business_licence'];
			$supplierArr['licence_img'] = $post['licence_img'];
			$supplierArr['corp_name'] = $post['corp_name'];
			$supplierArr['corp_idcardpic'] = $post['corp_idcardpic'];
			$supplierArr['licence_img_code'] = $post['licence_img_code'];
		} elseif ($kind == 3) {
			$supplierArr['company_name'] = $post['company_name'];
			$supplierArr['corp_name'] = $post['corp_name'];
		} elseif ($kind == 2) {
			$supplierArr['company_name'] = $post['responname'];
		}
		return $supplierArr;
	}
	
	
	//成功提示
	public function success() {
		$this ->load_view('admin/b1/register_success');
	}
}
