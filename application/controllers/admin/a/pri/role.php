<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-01-08
 * @author jiakairong
 * @method 角色管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Role extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/a/pri_role_model' ,'role_model');
		$this ->load_model('admin/a/admin_model' ,'admin_model');
	}
	
	public function index()
	{
		$this ->load_model('admin/a/pri_resource_model' ,'resource_model');
		$resourceData = $this ->resource_model ->all(array('isopen' =>1) ,'pid asc');
		$resourceArr = array();
		foreach($resourceData as $val)
		{
			if ($val['pid'] == 0)
			{
				$resourceArr[$val['resourceId']] = $val;
			}
			else 
			{
				if (array_key_exists($val['pid'], $resourceArr))
				{
					$resourceArr[$val['pid']]['lower'][] = $val;
				}
			}
		}
		$adminData = $this ->admin_model ->all(array('isopen' =>1));
		$this->load_view ( 'admin/a/pri/role' ,array('adminData' =>$adminData ,'resourceArr' =>$resourceArr));
	}
	//角色数据
	public function getRoleJson()
	{
		$whereArr = array();
		$data = $this ->role_model ->getRoleData($whereArr);
		foreach($data['data'] as $key=>$val)
		{
			$data['data'][$key]['resource'] = '';
			$data['data'][$key]['admin'] = '';
			$roleData = $this ->role_model ->getRoleResource(array('pr.roleId =' =>$val['roleId'] ,'r.isopen =' =>1));
			if (!empty($roleData))
			{
				foreach($roleData as $v)
				{
					$data['data'][$key]['resource'] .= $v['name'].'&nbsp;,';
				}
				$data['data'][$key]['resource'] = rtrim($data['data'][$key]['resource'] ,',');
			}
			$adminData = $this ->role_model ->getRoleAdmin($val['roleId']);
			if (!empty($adminData))
			{
				foreach($adminData as $v)
				{
					$data['data'][$key]['admin'] .= $v['realname'].'&nbsp;,';
				}
				$data['data'][$key]['admin'] = rtrim($data['data'][$key]['admin'] ,',');
			}
		}
		echo json_encode($data);
	}
	
	//添加角色
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$roleArr = $this ->commonFunc($postArr ,'add');
		
		$this->db->trans_start();
		$roleId = $this ->role_model ->insert($roleArr);
		foreach($postArr['admin'] as $val)
		{
			$adminrole = array(
				'adminId' =>$val,
				'roleId' =>$roleId
			);
			$this ->db ->insert('pri_adminrole' ,$adminrole);
		}
		foreach($postArr['resource'] as $v)
		{
			$roleresource = array(
				'resourceId' =>$v,
				'roleId' =>$roleId
			);
			$this ->db ->insert('pri_roleresource' ,$roleresource);
		}
		$this->db->trans_complete();
		$status = $this->db->trans_status();
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
		else 
		{
			$this ->log(1,3,'角色管理','添加角色，角色名称：'.$roleArr['roleName']);
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑角色
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$roleArr = $this ->commonFunc($postArr ,'edit');
		
		$id = intval($postArr['id']);
		$this->db->trans_start();
		//更新角色
		$this ->role_model ->update($roleArr ,array('roleId' =>$id));
		//删除管理员与角色关联表数据
		$this ->db ->delete('pri_adminrole',array('roleId' =>$id));
		$this ->db ->delete('pri_roleresource',array('roleId' =>$id));
		foreach($postArr['admin'] as $val)
		{
			$adminrole = array(
				'adminId' =>$val,
				'roleId' =>$id
			);
			$this ->db ->insert('pri_adminrole' ,$adminrole);
		}
		foreach($postArr['resource'] as $v)
		{
			$roleresource = array(
				'resourceId' =>$v,
				'roleId' =>$id
			);
			$this ->db ->insert('pri_roleresource' ,$roleresource);
		}
		$this->db->trans_complete();
		$status = $this->db->trans_status();

		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'角色管理','编辑管理员，账号：'.$roleArr['roleName']);
			$this ->callback ->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr ,$type)
	{
		if (empty($postArr['name']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写角色名称');
		}
		if (empty($postArr['admin']))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择管理员');
		}
		if (empty($postArr['resource']))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择模块');
		}
		return array(
				'roleName' =>trim($postArr['name']),
				'description' =>trim($postArr['description'])
			);
	}
	//获取角色详情
	public function getRoleDetail()
	{
		$id = intval($this ->input ->post('id'));
		$roleData = $this ->role_model ->row(array('roleId' =>$id));
		if (!empty($roleData))
		{
			$roleData['admins'] = $this ->role_model ->getRoleAdmin($id);
			$roleData['resource'] = $this ->role_model ->getRoleResource(array('pr.roleId =' =>$id));
			echo json_encode($roleData);
		}
	}
	//删除角色
	public function delete() 
	{
		$roleId = intval($this ->input ->post('id'));
		$this->db->trans_start();
		$this ->db ->delete('pri_role' ,array('roleId' =>$roleId));
		$this ->db ->delete('pri_adminrole',array('roleId' =>$roleId));
		$this ->db ->delete('pri_roleresource',array('roleId' =>$roleId));
		$this->db->trans_complete();
		$status = $this->db->trans_status();
		
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'删除失败');
		}
		else
		{
			$this ->log(3,3,'角色管理','删除角色，角色ID：'.$roleId);
			$this ->callback ->setJsonCode(2000 ,'删除成功');
		}
	}
}