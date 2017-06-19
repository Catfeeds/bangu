<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年5月7日14:46:53
* @author		jiakairong
* @method 		首页导航管理
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_nav extends UA_Controller 
{

	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/a/index_nav_model','index_nav_model');
	}
	
	public function nav_list() {
		$this ->view('admin/a/cfg/nav_list');
		//$this ->view('admin/a/view');
	}
	public function getNavData()
	{
		$data = $this->index_nav_model->getNavData(array());
		echo json_encode($data);
	}
	//添加导航
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
	
		$navArr = $this ->commonFunc($postArr, 'add');
		$id = $this ->index_nav_model ->insert($navArr);
		if (empty($id))
		{
			$this->callback->setJsonCode(4000 ,'添加失败');
		}
		else
		{
			$this ->log(1, 3, '首页导航管理', '添加首页导航，ID：'.$id.',名称:'.$navArr['name']);
			$this->callback->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑首页导航
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
	
		$navArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->index_nav_model ->update($navArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3, 3, '首页导航管理', '编辑首页导航，ID：'.$postArr['id'].',名称:'.$navArr['name']);
			$this->callback->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr ,$type)
	{
		if (empty($postArr['name']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写名称');
		}
		else
		{
			if ($type == 'add')
			{
				$navData = $this ->index_nav_model ->row(array('name' =>trim($postArr['name'])));
			}
			else
			{
				$navData = $this ->index_nav_model ->row(array('name' =>trim($postArr['name']) ,'id !=' =>intval($postArr['id'])));
			}
			if (!empty($navData))
			{
				$this ->callback ->setJsonCode(4000 ,'此名称已存在');
			}
		}
		if (empty($postArr['link']))
		{
			$this->callback->setJsonCode(4000 ,'请填写链接地址');
		}
		$showorder = intval($postArr['showorder']);
		return array(
				'name' =>trim($postArr['name']),
				'link' =>trim($postArr['link']),
				'beizhu' =>trim($postArr['beizhu']),
				'is_modify' =>intval($postArr['is_modify']),
				'showorder' =>empty($showorder) ? 99 :$showorder,
				'is_show' =>intval($postArr['is_show'])
		);
	}
	//获取某条数据
	public function getNavDetail ()
	{
		$id = intval($this->input->post('id'));
		$data = $this->index_nav_model->row(array('id' =>$id));
		echo json_encode($data);
	}
	//删除
	public function delete()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->index_nav_model ->delete(array('id' =>$id));
		if ($status == false)
		{
			$this->callback->setJsonCode(4000 ,'删除失败');
		}
		else 
		{
			$this ->log(2,3,'首页导航配置','平台删除首页导航,记录ID:'.$id);
			$this->callback->setJsonCode(2000 ,'删除成功');
		}
	}
}