<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年5月7日14:46:53
* @author		jiakairong
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_hot_search extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('admin/a/index_hot_search_model','hot_search_model');
	}
	
	public function search_list()
	{
		$this ->view('admin/a/cfg/search_list');
	}
	
	public function getHotSearchJson()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		if (!empty($name))
		{
			$whereArr['name like '] = '%'.$name.'%';
		}
		$data = $this ->hot_search_model ->getHotSearchData($whereArr);
		echo json_encode($data);
	}
	//添加热搜词
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');
		$id = $this ->hot_search_model ->insert($dataArr);
		if ($id > 0)
		{
			$this ->log(1, 3, '首页热搜词配置', '添加热搜词,ID：'.$id);
			$this ->callback ->setJsonCode('2000' ,'添加成功');
		}
		else
		{
			$this ->callback ->setJsonCode('4000' ,'添加失败');
		}
	}
	//编辑热搜词
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		
		$id = intval($postArr['id']);
		$status = $this ->hot_search_model ->update($dataArr ,array('id' =>$id));
		if ($status == true)
		{
			$this ->log(3, 3, '首页热搜词配置', '编辑热搜词,ID：'.$id);
			$this ->callback ->setJsonCode('2000' ,'编辑成功');
		}
		else
		{
			$this ->callback ->setJsonCode('4000' ,'编辑失败');
		}
	}
	//添加&编辑公用部分
	public function commonFunc($postArr ,$type)
	{
		$name = trim($postArr['name']);
		if (empty($name))
		{
			$this ->callback ->setJsonCode('4000' ,'请填写名称');
		}
		else 
		{
			if ($type == 'add')
			{
				$dataArr = $this ->hot_search_model ->row(array('name' =>$name));
			}
			else 
			{
				$dataArr = $this ->hot_search_model ->row(array('name' =>$name ,'id !=' =>intval($postArr['id'])));
			}
			if (!empty($dataArr))
			{
				$this ->callback ->setJsonCode('4000' ,'名称已存在');
			}
		}
		$showorder = intval($postArr['showorder']);
		return array(
				'name' =>$name,
				'link' =>trim($postArr['link']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'is_show' =>$postArr['is_show'],
				'is_modify' =>$postArr['is_modify']
			);
	}
	
	//获取某条数据
	public function getSearchDetail ()
	{
		$id = intval($this ->input ->post('id'));
		$data = $this->hot_search_model->row(array('id' =>$id));
		echo json_encode($data);
	}
	//删除
	public function delete()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->hot_search_model ->delete(array('id' =>$id));
		if (empty($status))
		{
			$this ->callback ->setJsonCode('4000' ,'删除失败');
		} 
		else 
		{
			$this ->log(2,3,'首页热搜词配置','平台删除首页热搜词,记录ID:'.$id);
			$this ->callback ->setJsonCode('2000' ,'删除成功');
		}
	}
}