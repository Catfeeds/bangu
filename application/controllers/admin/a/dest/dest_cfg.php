<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 目的地管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Dest_cfg extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('dest/dest_cfg_model' ,'dest_cfg_model');
		$this ->load_model('dest/dest_base_model' ,'dest_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/dest/dest_cfg');
	}
	//目的地数据
	public function getDestCfgData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$parent_name = trim($this ->input ->post('parent_name' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$ishot = intval($this ->input ->post('ishot'));
		
		if ($isopen == 0 || $isopen==1)
		{
			$whereArr['cfg.isopen ='] = $isopen;
		}
		if ($ishot == 0 || $ishot==1)
		{
			$whereArr['cfg.ishot ='] = $ishot;
		}
		if (!empty($name))
		{
			$whereArr['cfg.name like'] = '%'.$name.'%';
		}
		if (!empty($parent_name))
		{
			$whereArr['p.name like'] = '%'.$parent_name.'%';
		}
		
		$dataArr['data'] = $this ->dest_cfg_model ->getDestCfgData($whereArr, 'displayorder DESC');
		$dataArr['count'] = $this ->dest_cfg_model ->getDestNum($whereArr);
		echo json_encode($dataArr);
	}
	
	//添加数据页面
	public function add_view()
	{
		$this ->view('admin/a/dest/add_dest_cfg_view');
	}
	//添加数据
	public function add()
	{
		$pid = intval($this ->input ->post('pid'));
		$dest_id = intval($this ->input ->post('dest_id'));
		$name = trim($this ->input ->post('name' ,true));
		$simplename = trim($this ->input ->post('simplename' ,true));
		$enname = trim($this ->input ->post('enname' ,true));
		$pic = trim($this ->input ->post('pic' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$ishot = intval($this ->input ->post('ishot'));
		$displayorder = intval($this ->input ->post('displayorder'));
		if (empty($name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写名称');
		}
		if (empty($enname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写全拼');
		}
		if (empty($simplename))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写简拼');
		}
		if ($dest_id < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择绑定目的地');
		}
		
		$list = '';
		$level = 1;
		if ($pid > 0)
		{
			//获取其上级
			$parentData = $this ->dest_cfg_model ->row(array('id' =>$pid));
			if (empty($parentData))
			{
				$this ->callback ->setJsonCode(4000 ,'选择的上级有误');
			}
			$list = $parentData['list'];
			$level = round($parentData['level']+1);
		}
		
		$dataArr = array(
				'name' =>$name,
				'simplename' =>$simplename,
				'enname' =>$enname,
				'displayorder' =>$displayorder,
				'isopen' =>$isopen,
				'ishot' =>$ishot,
				'pid' =>$pid,
				'level' =>$level,
				'list' =>$list,
				'dest_id' =>$dest_id,
				'pic' =>$pic
		);
		$status = $this ->dest_cfg_model ->add($dataArr ,$list);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑页面
	public function edit_view()
	{
		$id = intval($this ->input ->get('id'));
		$dataArr = $this ->dest_cfg_model ->getDestCfgData(array('cfg.id =' =>$id));
		if (!empty($dataArr))
		{
			$this ->view('admin/a/dest/edit_dest_cfg_view' ,$dataArr[0]);
		}
	}
	
	//编辑数据
	public function edit()
	{
		$pid = intval($this ->input ->post('pid'));
		$dest_id = intval($this ->input ->post('dest_id'));
		$name = trim($this ->input ->post('name' ,true));
		$simplename = trim($this ->input ->post('simplename' ,true));
		$enname = trim($this ->input ->post('enname' ,true));
		$pic = trim($this ->input ->post('pic' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$ishot = intval($this ->input ->post('ishot'));
		$displayorder = intval($this ->input ->post('displayorder'));
		$id = intval($this ->input ->post('id'));
		if (empty($name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写名称');
		}
		if (empty($enname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写全拼');
		}
		if (empty($simplename))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写简拼');
		}
		if ($dest_id < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择绑定目的地');
		}
		
		$list = '';
		$level = 1;
		if ($pid > 0)
		{
			//获取其上级
			$parentData = $this ->dest_cfg_model ->row(array('id' =>$pid));
			if (empty($parentData))
			{
				$this ->callback ->setJsonCode(4000 ,'选择的上级有误');
			}
			$list = $parentData['list'];
			$level = round($parentData['level']+1);
		}
		
		$dataArr = array(
				'name' =>$name,
				'simplename' =>$simplename,
				'enname' =>$enname,
				'displayorder' =>$displayorder,
				'isopen' =>$isopen,
				'ishot' =>$ishot,
				'pid' =>$pid,
				'level' =>$level,
				'list' =>$list.$id.',',
				'dest_id' =>$dest_id,
				'pic' =>$pic
		);
		$status = $this ->dest_cfg_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'编辑成功');
		}
	}
	
	//停用目的地
	public function disable()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'isopen' =>0
		);
		$whereArr = array(
				'id' =>$id
		);
		$status = $this ->dest_cfg_model ->update($dataArr ,$whereArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	//启用目的地
	public function enable()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'isopen' =>1
		);
		$whereArr = array(
				'id' =>$id
		);
		$status = $this ->dest_cfg_model ->update($dataArr ,$whereArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
}