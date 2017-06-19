<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月22日10:48:00
 * @author		贾开荣
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Startplace extends UA_Controller 
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/a/startplace_model', 'start_model' );
	}
	//出发城市列表
	public function index()
	{
		$this ->load_view('admin/a/ui/startplace');
	}
	//出发城市数据
	public function getStartplaceJson()
	{
		$whereArr = array();
		$isopen = intval($this ->input ->post('isopen'));
		$country = intval($this ->input ->post('country'));
		$province = intval($this ->input ->post('province'));
		$city = intval($this ->input ->post('city'));
		
		$pid = empty($city) ? $province : $city;
		$pid = empty($pid) ? $country : $pid;
		if (!empty($pid))
		{
			$whereArr['pid'] = $pid;
		}
		if ($isopen == 1 || $isopen == 2)
		{
			$isopen = $isopen == 2 ? 0 : $isopen;
			$whereArr['s.isopen ='] = $isopen;
		}
		$data = $this->start_model->getStartplaceData($whereArr);
		echo json_encode($data);
	}
	//添加出发城市
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$startArr = $this ->commonFunc($postArr, 'add');
		$id = $this ->start_model ->insert($startArr);
		if (empty($id))
		{
			$this->callback->setJsonCode(4000 ,'添加失败');
		}
		else
		{
			$startData = $this ->start_model ->getStartAllData();
			$this ->chioceDataPlugins($startData ,'./assets/js/staticState/chioceStartCityJson.js' ,'chioceStartCityJson');
			$this ->createHeaderStartJson();
			$this ->log(1, 3, '出发城市管理', '添加出发城市，ID：'.$id);
			$this->callback->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑出发城市
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$startArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->start_model ->update($startArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$startData = $this ->start_model ->getStartAllData();
			$this ->chioceDataPlugins($startData ,'./assets/js/staticState/chioceStartCityJson.js' ,'chioceStartCityJson');
			$this ->createHeaderStartJson();
			$this ->log(3, 3, '出发城市管理', '编辑出发城市，ID：'.$postArr['id']);
			$this->callback->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加，编辑公用
	public function commonFunc($postArr ,$type)
	{
		$areaid = empty($postArr['city']) ? $postArr['province'] : $postArr['city'];
		$areaid = empty($areaid) ? $postArr['country'] : $areaid;
		$pid = empty($postArr['start_province']) ? $postArr['start_country'] : $postArr['start_province'];
		
		if (empty($areaid))
		{
			$this->callback->setJsonCode(4000 ,'请选择城市');
		}
		else
		{
			//获取城市名称 
			$this ->load_model('admin/a/area_model' ,'area_model');
			$areaData = $this ->area_model ->row(array('id' =>$areaid));
			if (!empty($areaData))
			{
				$cityname = $areaData['name'];
			}
			else
			{
				$this->callback->setJsonCode(4000 ,'城市错误');
			}
		}
		//判断城市是否已是出发城市
		if ($type == 'add')
		{
			$startData = $this ->start_model ->row(array('areaid' =>$areaid));
		}
		else
		{
			$startData = $this ->start_model ->row(array('areaid' =>$areaid ,'id !=' =>intval($postArr['id'])));
		}
		if (!empty($startData))
		{
			$this->callback->setJsonCode(4000 ,'此城市已是出发城市');
		}
		if (empty($postArr['enname']))
		{
			$this->callback->setJsonCode(4000 ,'请填写全拼');
		}
		if (empty($postArr['simplename']))
		{
			$this->callback->setJsonCode(4000 ,'请填写简拼');
		}
		//计算级别
		if ($pid == 0)
		{
			$level = 1;
		}
		else
		{
			$startData = $this ->start_model ->row(array('id' =>$pid));
			$level = $startData['level'] + 1;
		}
		return array(
			'cityname' =>$cityname,
			'enname' =>trim($postArr['enname']),
			'simplename' =>trim($postArr['simplename']),
			'isopen' =>intval($postArr['isopen']),
			'displayorder' =>empty($postArr['displayorder']) ? 999 :intval($postArr['displayorder']),
			'ishot' =>intval($postArr['ishot']),
			'areaid' =>$areaid,
			'pid' =>$pid,
			'level' =>$level
		);
	}

	//获取一条记录
	public function getStartDetail()
	{
		$id = intval($this ->input ->post('id'));
		$startData = $this ->start_model ->row(array('id' =>$id));
		if (!empty($startData))
		{
			switch($startData['level'])
			{
				case 1:
				case 2:
					$startData['start_country'] = $startData['pid'];
					break;
				case 3:
					$start = $this ->start_model ->row(array('id' =>$startData['pid']));
					$startData['start_country'] = $start['pid'];
					$startData['start_province'] = $start['id'];
					break;
			}
			
			$this ->load_model('admin/a/area_model' ,'area_model');
			$areaData = $this ->area_model ->row(array('id' =>$startData['areaid']));
			switch($areaData['level'])
			{
				case 1:
					$startData['country'] = $areaData['id'];
					break;
				case 2:
					$startData['country'] = $areaData['pid'];
					$startData['province'] = $areaData['id'];
					break;
				case 3:
					$startData['province'] = $areaData['pid'];
					$startData['city'] = $areaData['id'];
					$areaData = $this ->area_model ->row(array('id' =>$areaData['pid']));
					$startData['country'] = $areaData['pid'];
					break;
			}
			echo json_encode($startData);
		}
	}
	//获取站点的子站点
	public function getChildStart()
	{
		$this ->load_model('startplace_child_model' ,'child_model');
		$id = intval($this ->input ->post('id'));
		$childData = $this ->child_model ->getChildStartData($id);
		echo json_encode($childData);
	}
	public function updateChild()
	{
		$this ->load_model('startplace_child_model' ,'child_model');
		$ids = rtrim($this ->input ->post('ids') ,',');
		$startId = intval($this ->input ->post('startid'));
// 		if (empty($ids))
// 		{
// 			$this ->callback ->setJsonCode(4000 ,'请选择子站点');
// 		}
		$this ->child_model ->delete(array('startplace_id' =>$startId));
		$idArr = explode(',' ,$ids);
		foreach($idArr as $val)
		{
			$childArr = array(
				'startplace_id' =>$startId,
				'startplace_child_id' =>$val,
			);
			$this ->child_model ->insert($childArr);
		}
		$this ->callback ->setJsonCode(2000 ,'子站点更新成功');
	}
	

}
