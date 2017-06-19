<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		首页推荐目的地
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_dest_love extends UA_Controller
{
	public $controllerName = '首页推荐目的地';
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/index_dest_love_model', 'dest_love_model' );
	}
	public function index()
	{
		$this->view ( 'admin/a/cfg/index_dest_love');
	}
	public function getDestLoveData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($name))
		{
			$whereArr ['dl.name like'] = '%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr ['dl.startplaceid ='] = $city;
		} 
		elseif (!empty($province))
		{
			$whereArr ['s.pid ='] = $province;
		}
		$data = $this ->dest_love_model ->getDestLoveData($whereArr);
		echo json_encode($data);
	}
	//增加
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->dest_love_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this ->log(1,3,'首页推荐目的地','增加首页推荐目的地');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->dest_love_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'首页推荐目的地','编辑首页推荐目的地');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$city = empty($postArr['city']) ? 0 : intval($postArr['city']);
		$destid = intval($postArr['destid']);
		$showorder = intval($postArr['showorder']);
		if (empty($city))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择始发地');
		}
		if (empty($destid))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择目的地');
		}
		if (empty($postArr['name']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写名称');
		}
		if ($type == 'add')
		{
			$data = $this ->dest_love_model ->row(array('dest_id' =>$destid ,'startplaceid' =>$city));
		}
		else
		{
			$data = $this ->dest_love_model ->row(array('dest_id' =>$destid ,'startplaceid' =>$city ,'id !='=>intval($postArr['id'])));
		}
		if (!empty($data))
		{
			$this->callback->setJsonCode ( 4000 ,'当前目的地和始发地组合已存在');
		}
		return  array(
				'dest_id ' =>$destid,
				'name' =>trim($postArr['name']),
				'pic' =>$postArr['pic'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'startplaceid' =>$city
		);
	}
	
	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->dest_love_model ->getDetailData($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}
}