<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-01-05
 * @author		jiakairong
 * @method 		地区管理
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Area extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/area_model','area_model');
	}

	function index()
	{
		$this->load_view ( 'admin/a/basics/area');
	}
	//获取地区数据
	public function getAreaJson()
	{
		$whereArr = array();
		$postArr = $this->security->xss_clean($_POST);
		if (!empty($postArr['name']))
		{
			$whereArr['a.name like'] = '%'.trim($postArr['name']).'%';
		}
		if ($postArr['ishot'] == 1 || $postArr['ishot'] == 2)
		{
			$whereArr['a.ishot ='] = $postArr['ishot'] == 2 ? 0 : $postArr['ishot'];
		}
		if ($postArr['isopen'] == 1 || $postArr['isopen'] == 2)
		{
			$whereArr['a.isopen ='] = $postArr['isopen'] == 2 ? 0 : $postArr['isopen'];
		}
		
		$data = $this ->area_model ->getAreaData($whereArr);
		echo json_encode($data);
	}
	//增加地区
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$areaArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->area_model ->insert($areaArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			//生成静态数据文件
			$areaData = $this ->area_model ->getSelectAreaAll();
			$this ->createSelectJson($areaData ,'selectAreaJson' ,'./assets/js/staticState/areaSelectJson.js');
			$this ->chioceDataPlugins($areaData ,'./assets/js/staticState/chioceAreaJson.js' ,'chioceAreaJson');
			$this ->log(1,3,'地区管理','增加地区');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑首页分类目的地线路
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
	
		if (empty($postArr['id']))
		{
			$this->callback->set_code ( 4000 ,'缺少编辑的数据');
			$this->callback->exit_json();
		}
		$areaArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->area_model ->update($areaArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			//生成静态数据文件
			$areaData = $this ->area_model ->getSelectAreaAll();
			$this ->createSelectJson($areaData ,'selectAreaJson' ,'./assets/js/staticState/areaSelectJson.js');
			$this ->chioceDataPlugins($areaData ,'./assets/js/staticState/chioceAreaJson.js' ,'chioceAreaJson');
			$this ->log(3,3,'地区管理','编辑地区,ID:'.$postArr['id']);
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$pid = empty($postArr['city']) ? $postArr['province'] : $postArr['city'];
		$pid = empty($pid) ? $postArr['country'] : $pid;
		if (empty($pid))
		{
			$level = 0;
		}
		else 
		{
			$areaData = $this ->area_model ->row(array('id' =>$pid));
			if (empty($areaData))
			{
				$this->callback->setJsonCode ( 4000 ,'选择的上级城市不存在');
			}
			else 
			{
				$level = round($areaData['level'] + 1);
			}
		}
		if (empty($postArr['name']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写名称');
		}
		else 
		{
			if ($type == 'add')
			{
				$areaData = $this ->area_model ->row(array('name' =>trim($postArr['name'])));
			}
			else 
			{
				$areaData = $this ->area_model ->row(array('name' =>trim($postArr['name']) ,'id !=' =>$postArr['id']));
			}
			if (!empty($areaData))
			{
				$this ->callback ->setJsonCode(4000 ,'此名称已存在');
			}
		}
		if (empty($postArr['enname']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写全拼');
		}
		if (empty($postArr['simplename']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写简拼');
		}
		$displayorder = intval($postArr['displayorder']);
		return array(
				'name' =>trim($postArr['name']),
				'enname' =>strtolower(trim($postArr['enname'])),
				'simplename' =>strtolower(trim($postArr['simplename'])),
				'displayorder' =>empty($displayorder) ? 9999 : $displayorder,
				'pid' =>$pid,
				'level' =>$level,
				'isopen' =>intval($postArr['isopen']),
				'ishot' =>intval($postArr['ishot'])
		);
	}
	
	//获取某条数据
	public function getAreaDetail ()
	{
		$id = intval($this ->input ->post('id'));
		$areaData = $this ->area_model ->row(array('id' =>$id));
		if (!empty($areaData))
		{
			switch($areaData['level'])
			{
				case 1:
					$areaData['country'] = 0;
					break;
				case 2:
					$areaData['country'] = $areaData['pid'];
					break;
				case 3:
					$parentArr = $this ->area_model ->getParents($areaData['pid']);
					$areaData['country'] = $parentArr[0]['parentid'];
					$areaData['province'] = $areaData['pid'];
					break;
				case 4:
					$parentArr = $this ->area_model ->getParents($areaData['pid']);
					$areaData['province'] = $parentArr[0]['parentid'];
					$areaData['city'] = $areaData['pid'];
					$parentArr = $this ->area_model ->getParents($areaData['province']);
					$areaData['country'] = $parentArr[0]['parentid'];
					break;
			}
			echo json_encode($areaData);
		}
	}
}