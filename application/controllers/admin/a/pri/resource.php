<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-01-08
 * @author jiakairong
 * @method 权限管理(角色功能管理)
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Resource extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/a/pri_role_model' ,'role_model');
		$this ->load_model('admin/a/pri_resource_model' ,'resource_model');
	}
	
	public function index()
	{
		$resourceData = $this ->resource_model ->all(array('pid' =>0));
		$roleData = $this ->role_model ->all(array());
		$this->load_view ( 'admin/a/pri/resource' ,array('roleArr' =>$roleData ,'resourceArr' =>$resourceData));
	}
	public function getResourceJson()
	{
		$whereArr = array();
		$isopen = $this ->input ->post('isopen');
		$pid = intval($this ->input ->post('pid'));
		if($pid > 0)
		{
			$whereArr['pr.pid ='] = $pid;
		}
		if ($isopen == 1 || $isopen == 2)
		{
			$isopen = $isopen == 2 ? 0 : 1;
			$whereArr['pr.isopen ='] = $isopen;
		}
		$data = $this ->resource_model ->getResourceData($whereArr);
		foreach($data['data'] as $key=>$val)
		{
			$data['data'][$key]['roles'] = '';
			$roleData = $this ->resource_model ->getRoleResource($val['resourceId']);
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
	
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$resourceArr = $this ->commonFunc($postArr);
		
		$this->db->trans_start();
		$resourceId = $this ->resource_model ->insert($resourceArr);
		foreach($postArr['role'] as $val)
		{
			$roleArr = array(
				'resourceId' =>$resourceId,
				'roleId' =>$val
			);
			$this ->db ->insert('pri_roleresource' ,$roleArr);
		}
		
		$this->db->trans_complete();
		$status = $this->db->trans_status();
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
		else 
		{
			$this ->log(1,3,'权限管理','添加权限，名称：'.$resourceArr['name']);
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑角色
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$resourceArr = $this ->commonFunc($postArr);
		
		$id = intval($postArr['id']);
		$this->db->trans_start();
		//更新管理员
		$this ->resource_model ->update($resourceArr ,array('resourceId' =>$id));
		//删除角色与功能关联表数据
		$this ->db ->delete('pri_roleresource',array('resourceId' =>$id));
		foreach($postArr['role'] as $val)
		{
			$roleArr = array(
				'resourceId' =>$id,
				'roleId' =>$val
			);
			$this ->db ->insert('pri_roleresource' ,$roleArr);
		}
		
		$this->db->trans_complete();
		$status = $this->db->trans_status();

		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'权限管理','编辑权限，名称：'.$resourceArr['name']);
			$this ->callback ->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr)
	{
		if (empty($postArr['role']))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择角色');
		}
		if (empty($postArr['name']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写名称');
		}
		if (empty($postArr['url']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写url地址');
		}
		$showorder = intval($postArr['showorder']);
		return array(
				'name' =>trim($postArr['name']),
				'uri' =>trim($postArr['url']),
				'description' =>trim($postArr['description']),
				'pid' =>intval($postArr['pid']),
				'showorder' =>empty($showorder) ? 9999 : $showorder,
				'isopen' =>intval($postArr['isopen'])
			);
	}
	//获取详情
	public function getResourceDetail()
	{
		$id = intval($this ->input ->post('id'));
		$resourceData = $this ->resource_model ->row(array('resourceId' =>$id));
		if (!empty($resourceData))
		{
			$roleData = $this ->resource_model ->getRoleResource($id);
			$resourceData['roles'] = $roleData;
			echo json_encode($resourceData);
		}
	}
}