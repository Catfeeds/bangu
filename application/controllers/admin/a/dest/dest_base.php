<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 目的地管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Dest_base extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('dest/dest_base_model' ,'dest_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/dest/dest_base');
	}
	//目的地数据
	public function getDestBaseData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$parent_name = trim($this ->input ->post('parent_name' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$ishot = intval($this ->input ->post('ishot'));
		
		if ($isopen == 0 || $isopen==1)
		{
			$whereArr['d.isopen ='] = $isopen;
		}
		if ($ishot == 0 || $ishot==1)
		{
			$whereArr['d.ishot ='] = $ishot;
		}
		if (!empty($name))
		{
			$whereArr['d.kindname like'] = '%'.$name.'%';
		}
		if (!empty($parent_name))
		{
			$whereArr['p.kindname like'] = '%'.$parent_name.'%';
		}
		
		$dataArr['data'] = $this ->dest_model ->getDestBaseData($whereArr);
		$dataArr['count'] = $this ->dest_model ->getDestNum($whereArr);
		echo json_encode($dataArr);
	}
	
	//添加数据页面
	public function add_view()
	{
		$this ->view('admin/a/dest/add_dest_base_view');
	}
	//添加数据
	public function add()
	{
		$pid = intval($this ->input ->post('pid'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$simplename = trim($this ->input ->post('simplename' ,true));
		$enname = trim($this ->input ->post('enname' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$ishot = intval($this ->input ->post('ishot'));
		$type = intval($this ->input ->post('type'));
		$displayorder = intval($this ->input ->post('displayorder'));
		if (empty($kindname))
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
		if ($type != 1 && $type != 2)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择类型');
		}
		
		$list = '';
		$level = 1;
		if ($pid > 0)
		{
			//获取其上级
			$parentData = $this ->dest_model ->row(array('id' =>$pid));
			if (empty($parentData))
			{
				$this ->callback ->setJsonCode(4000 ,'选择的上级有误');
			}
			$list = $parentData['list'];
			$level = $parentData['level']+1;
		}
		
		$dataArr = array(
				'kindname' =>$kindname,
				'simplename' =>$simplename,
				'enname' =>$enname,
				'displayorder' =>$displayorder,
				'isopen' =>$isopen,
				'ishot' =>$ishot,
				'pid' =>$pid,
				'level' =>$level,
				'list' =>$list,
				'type' =>$type
		);
		$status = $this ->dest_model ->add($dataArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
		else
		{
			$whereArr = array('level <=' =>3);
			$destData = $this ->dest_model ->getDestBaseAllData($whereArr);
			unlink('./assets/js/staticState/chioceDestJson.js');
			$this ->chioceDataPlugins($destData ,'./assets/js/staticState/chioceDestJson.js' ,'chioceDestJson');
			
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑页面
	public function edit_view()
	{
		$id = intval($this ->input ->get('id'));
		$dataArr = $this ->dest_model ->getDestBaseData(array('d.id =' =>$id));
		if (!empty($dataArr))
		{
			$this ->view('admin/a/dest/edit_dest_base_view' ,$dataArr[0]);
		}
	}
	
	//编辑数据
	public function edit()
	{
		$pid = intval($this ->input ->post('pid'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$simplename = trim($this ->input ->post('simplename' ,true));
		$enname = trim($this ->input ->post('enname' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$ishot = intval($this ->input ->post('ishot'));
		$type = intval($this ->input ->post('type'));
		$displayorder = intval($this ->input ->post('displayorder'));
		$id = intval($this ->input ->post('id'));
		if (empty($kindname))
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
		if ($type != 1 && $type != 2)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择类型');
		}
		
		$list = '';
		$level = 1;
		if ($pid > 0)
		{
			//获取其上级
			$parentData = $this ->dest_model ->row(array('id' =>$pid));
			if (empty($parentData))
			{
				$this ->callback ->setJsonCode(4000 ,'选择的上级有误');
			}
			$list = $parentData['list'];
			$level = $parentData['level']+1;
		}
		
		$dataArr = array(
				'kindname' =>$kindname,
				'simplename' =>$simplename,
				'enname' =>$enname,
				'displayorder' =>$displayorder,
				'isopen' =>$isopen,
				'ishot' =>$ishot,
				'pid' =>$pid,
				'level' =>$level,
				'list' =>ltrim(trim($list,',').','.$id .',' ,','),
				'type' =>$type
		);
		$status = $this ->dest_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$whereArr = array('level <=' =>3);
			$destData = $this ->dest_model ->getDestBaseAllData($whereArr);
			unlink('./assets/js/staticState/chioceDestJson.js');
			$this ->chioceDataPlugins($destData ,'./assets/js/staticState/chioceDestJson.js' ,'chioceDestJson');
			
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
		$status = $this ->dest_model ->update($dataArr ,$whereArr);
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
		$status = $this ->dest_model ->update($dataArr ,$whereArr);
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