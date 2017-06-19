<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-01-07
 * @author jiakairong
 * @method 管理员管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class AdminList extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/a/admin_model' ,'admin_model');
		$this ->load_model('admin/a/pri_role_model' ,'role_model');
	}
	
	public function index()
	{
		$roleData = $this ->role_model ->all();
		$this->load_view ( 'admin/a/pri/admin' ,array('roleData' =>$roleData));
	}
	//管理员数据
	public function getAdminJson()
	{
		$whereArr = array();
		$realname = trim($this ->input ->post('realname'));
		$mobile = trim($this ->input ->post('mobile'));
		$email = trim($this ->input ->post('email'));
		if (!empty($realname))
		{
			$whereArr['realname like'] = '%'.$realname.'%';
		}
		if (!empty($email))
		{
			$whereArr['email ='] = $email;
		}
		if (!empty($mobile))
		{
			$whereArr['mobile ='] = $mobile;
		}
		$data = $this ->admin_model ->getAdminData($whereArr);
		foreach($data['data'] as $key=>$val)
		{
			$data['data'][$key]['roles'] = '';
			$roleData = $this ->admin_model ->getAdminRole($val['id']);
			if (!empty($roleData))
			{
				foreach($roleData as $v)
				{
					$data['data'][$key]['roles'] .= $v['roleName'].'&nbsp;,';
				}
				$data['data'][$key]['roles'] = rtrim($data['data'][$key]['roles'] ,',');
			}
		}
		echo json_encode($data);
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
	//编辑管理员
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$adminArr = $this ->commonFunc($postArr ,'edit');
		
		$id = intval($postArr['id']);
		$this->db->trans_start();
		//更新管理员
		$this ->admin_model ->update($adminArr ,array('id' =>$id));
		//删除管理员与角色关联表数据
		$this ->db ->delete('pri_adminrole',array('adminId' =>$id));
		foreach($postArr['role'] as $val)
		{
			$roleArr = array(
					'adminId' =>$id,
					'roleId' =>$val
			);
			$this ->db ->insert('pri_adminrole' ,$roleArr);
		}
		
		$this->db->trans_complete();
		$status = $this->db->trans_status();

		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'管理员管理','编辑管理员，账号：'.$adminArr['username']);
			$this ->callback ->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr ,$type)
	{
		if (empty($postArr['role']))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择管理员角色');
		}
		if (empty($postArr['username']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写管理员账号');
		}
		else
		{
			if ($type == 'add')
			{
				$adminData = $this ->admin_model ->row(array('username' =>trim($postArr['username'])));
			}
			else 
			{
				$adminData = $this ->admin_model ->row(array('username' =>trim($postArr['username']),'id !='=>intval($postArr['id'])));
			}
			if (!empty($adminData))
			{
				$this ->callback ->setJsonCode(4000 ,'此账号已存在');
			}
		}
		if ($type == 'add' || ($type == 'edit' && !empty($postArr['password'])))
		{
			$passlen = strlen($postArr['password']);
			if ($passlen < 6 || $passlen > 15)
			{
				$this ->callback ->setJsonCode(4000 ,'请填写6到15位的密码');
			}
			if ($postArr['password'] != $postArr['repass'])
			{
				$this ->callback ->setJsonCode(4000 ,'填写密码不一致');
			}
		}
		if (empty($postArr['realname']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写真实姓名');
		}
		if (empty($postArr['mobile']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写手机号');
		}
		if (empty($postArr['email']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写邮箱地址');
		}
		if (empty($postArr['qq']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写QQ号');
		}	
		if (empty($postArr['photo']))
		{
			$this ->callback ->setJsonCode(4000 ,'请上传头像');
		}
		$adminArr = array(
				'username' =>trim($postArr['username']),
				'password' =>md5($postArr['password']),
				'realname' =>trim($postArr['realname']),
				'mobile' =>trim($postArr['mobile']),
				'email' =>trim($postArr['email']),
				'qq' =>trim($postArr['qq']),
				'photo' =>$postArr['photo'],
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'beizu' =>trim($postArr['beizhu'])
			);
		if ($type== 'edit' && empty($postArr['password']))
		{
			unset($adminArr['password']);
		}
		return $adminArr;
	}
	//获取管理员详情
	public function getAdminDetail()
	{
		$id = intval($this ->input ->post('id'));
		$adminData = $this ->admin_model ->row(array('id' =>$id));
		if (!empty($adminData))
		{
			$roleData = $this ->admin_model ->getAdminRole($id);
			$adminData['roles'] = $roleData;
			echo json_encode($adminData);
		}
	}
	//禁用管理员
	public function disable()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->admin_model ->update(array('isopen' =>0) ,array('id' =>$id));
		if ($status == true)
		{
			$this ->log(3,3,'管理员管理','禁用管理员，ID：'.$id);
			$this->callback->setJsonCode(2000 ,'禁用成功');
		}
		else 
		{
			$this->callback->setJsonCode(4000 ,'禁用失败');
		}
	}
	//启用管理员
	public function enable()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->admin_model ->update(array('isopen' =>1) ,array('id' =>$id));
		if ($status == true)
		{
			$this ->log(3,3,'管理员管理','启用管理员，ID：'.$id);
			$this->callback->setJsonCode(2000 ,'启用成功');
		}
		else
		{
			$this->callback->setJsonCode(4000 ,'启用失败');
		}
	}
}