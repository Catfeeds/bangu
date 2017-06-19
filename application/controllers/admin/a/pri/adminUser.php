<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-01-12
 * @author jiakairong
 * @method 管理员个人中心
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class AdminUser extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/a/admin_model' ,'admin_model');
	}
	
	public function index()
	{
		$adminData = $this ->admin_model ->row(array('id' =>$this->admin_id));
		$this->load_view ( 'admin/a/pri/user' ,array('adminData' =>$adminData));
	}
	//更新管理员数据
	public function updateAdmin()
	{
		$realname = trim($this ->input ->post('realname'));
		$email = trim($this ->input ->post('email'));
		$mobile = trim($this ->input ->post('mobile'));
		$qq = trim($this ->input ->post('qq'));
		if (empty($realname))
		{
			$this ->callback->setJsonCode(4000 ,'请填写真实姓名');
		}
		if (empty($email))
		{
			$this ->callback->setJsonCode(4000 ,'请填写邮箱');
		}
		if (empty($mobile))
		{
			$this ->callback->setJsonCode(4000 ,'请填写手机号');
		}
		if (empty($qq))
		{
			$this ->callback->setJsonCode(4000 ,'请填写QQ号');
		}
		$adminArr = array(
			'realname' =>$realname,
			'email' =>$email,
			'mobile' =>$mobile,
			'qq' =>$qq
		);
		$status = $this ->admin_model ->update($adminArr ,array('id' =>$this ->admin_id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'更新失败');
		}
		else
		{
			$this ->log(3,3,'管理员会员中心管理','更新资料');
			$this ->callback ->setJsonCode(2000 ,'更新成功');
		}
	}
	//修改密码页面
	public function editPassword()
	{
		$this ->load_view('admin/a/pri/password');
	}
	//更新密码
	public function updatePassword()
	{
		$oldpass = trim($this ->input ->post('oldpass'));
		$password = trim($this ->input ->post('password'));
		$repass = trim($this ->input ->post('repass'));
		$adminData = $this ->admin_model ->row(array('id' =>$this ->admin_id));
		if (empty($adminData))
		{
			$this ->callback ->setJsonCode(4000 ,'管理员不正确');
		}
		if (md5($oldpass) != $adminData['password'])
		{
			$this ->callback ->setJsonCode(4000 ,'原密码不正确');
		}
		$lenPass = strlen($password);
		if ($lenPass < 6 || $lenPass > 20)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写6到20位的密码');
		}
		if ($password != $repass)
		{
			$this ->callback ->setJsonCode(4000 ,'两次密码输入不一致');
		}
		if ($password == $oldPass)
		{
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		}
		$status = $this ->admin_model ->update(array('password' =>md5($password)) ,array('id' =>$this ->admin_id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'修改失败');
		}
		else
		{
			$this ->log(3, 3, '管理员个人中心', '管理员修改密码');
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		}
	}
	
	//添加管理员
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$adminArr = $this ->commonFunc($postArr ,'add');
		
		$this->db->trans_start();
		$admin_id = $this ->admin_model ->insert($adminArr);
		foreach($postArr['role'] as $val)
		{
			$roleArr = array(
				'adminId' =>$admin_id,
				'roleId' =>$val
			);
			$this ->db ->insert('pri_adminrole' ,$roleArr);
		}
		
		$this->db->trans_complete();
		$status = $this->db->trans_status();
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
		else 
		{
			$this ->log(1,3,'管理员管理','添加管理员，账号：'.$adminArr['username']);
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
	}
}