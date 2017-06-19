<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年5月7日14:46:53
* @author		jiakairong
* @method 		首页一级分类
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/a/Index_kind_model', 'kind_model' );
	}
	public function index()
	{
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
		$data['destData'] = $this ->dest_base_model ->all(array('level' =>1));
		$this->view ( 'admin/a/cfg/index_kind' ,$data);
	}
	//首页分类数据
	public function getIndexkindJson()
	{
		$data = $this ->kind_model ->getIndexKindData(array());
		echo json_encode($data);
	}
	//增加首页一级分类
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr);
		$status = $this ->kind_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( '4000' ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(1,3,'首页一级分类配置','增加首页一级分类');
			$this->callback->setJsonCode ( '2000' ,'添加成功');
		}
	}
	//编辑特价线路
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
	
		$dataArr = $this ->commonFunc($postArr);
		$status = $this ->kind_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( '4000' ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(3,3,'首页一级分类配置','编辑首页一级分类');
			$this->callback->setJsonCode ( '2000' ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr)
	{
		$name = trim($postArr['name']);
		$pic = trim($postArr['pic']);
		$showorder = intval($postArr['showorder']);
		if (empty($name))
		{
			$this->callback->setJsonCode ( '4000' ,'请填写名称');
		}
		if (empty($pic))
		{
			$this->callback->setJsonCode ( '4000' ,'请上传图片');
		}
		return  array(
				'name ' =>$name,
				'pic' =>$pic,
				'smallpic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'dest_id' =>intval($postArr['dest_id'])
			);
	}
	
	//获取某条数据
	public function getDetailJson()
	{
		$id = intval($this ->input ->post('id'));
		$data = $this ->kind_model ->row(array('id' =>$id));
		echo json_encode($data);
	}
}