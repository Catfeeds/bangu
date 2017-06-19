<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2015-12-14
 * @author jiakairong
 * @method 主题管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Theme extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/a/theme_model' ,'theme_model');
	}
	
	public function index()
	{
		$this->load_view ( 'admin/a/theme');
	}
	//主题数据
	public function getThemeJson()
	{
		$whereArr = array();
		$pageNew = intval($this ->input ->post('page_new'));
		$pageNew = empty($pageNew) ? 1 : $pageNew;
		$name = trim($this ->input ->post('name'));
		if (!empty($name))
		{
			$whereArr['name'] = $name;
		}
		$data['list'] = $this ->theme_model ->getThemeData($whereArr ,$pageNew ,sys_constant::A_PAGE_SIZE);
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($pageNew ,$count);
		echo json_encode($data);
	}
	//获取详情
	public function getThemeDetail()
	{
		$id = intval($this ->input ->post('id'));
		$themeData = $this ->theme_model ->row(array('id' =>$id));
		echo json_encode($themeData);
	}
	
	//添加银行卡
	public function addTheme()
	{
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['name']))
		{
			$this->callback->set_code ( 4000 ,'请填写主题名称');
			$this->callback->exit_json();
		}
		else 
		{
			$themeData = $this ->theme_model ->row(array('name' =>trim($postArr['name'])));
			if (!empty($themeData))
			{
				$this->callback->set_code ( 4000 ,'此主题名称已存在');
				$this->callback->exit_json();
			}
		}
		$themeArr = array(
				'name' =>trim($postArr['name']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder']),
				'description' =>trim($postArr['description'])
		);
		
		$status = $this ->theme_model ->insert($themeArr);
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'添加失败');
			$this->callback->exit_json();
		}
		else 
		{
			$this ->log(1,3,'主题管理','添加主题，名称：'.$themeArr['name']);
			$this->callback->set_code ( 2000 ,'添加成功');
			$this->callback->exit_json();
		}
	}
	//编辑银行卡
	public function editTheme()
	{
		$name = trim($this ->input ->post('name'));
		$id = intval($this ->input ->post('id'));
		$showorder = intval($this ->input ->post('showorder'));
		$description = trim($this ->input ->post('description'));
		if (empty($name))
		{
			$this->callback->set_code ( 4000 ,'请填写主题名称');
			$this->callback->exit_json();
		}
		else 
		{
			$themeData = $this ->theme_model ->row(array('name' =>$name ,'id !=' =>$id));
			if (!empty($themeData))
			{
				$this->callback->set_code ( 4000 ,'此主题名称已存在');
				$this->callback->exit_json();
			}
		}
		$themeArr = array(
				'name' =>$name,
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'description' =>$description
		);
		
		$status = $this ->theme_model ->update($themeArr ,array('id' =>$id));
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'编辑失败');
			$this->callback->exit_json();
		}
		else
		{
			$this ->log(3,3,'主题管理','编辑主题，名称：'.$themeArr['name']);
			$this->callback->set_code ( 2000 ,'编辑成功');
			$this->callback->exit_json();
		}
	}
}