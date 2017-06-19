<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @since		2015年5月2日
 * @author		贾开荣
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Round_trip extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'common/cfg_round_trip_model', 'trip_model' );
		$this->load_model ( 'dest/dest_base_model', 'dest_model' );
	}
	
	public function list_trip()
	{
		$this ->view('admin/a/cfg/list_trip');
	}
	
	public function getRoundData()
	{
		$whereArr = array();
		$isopen = intval($this ->input ->post('isopen'));
		$cityid = intval($this ->input ->post('cityid'));
		$destid = intval($this ->input ->post('destid'));
		$cityname = trim($this ->input ->post('cityname' ,true));
		$kindname = trim($this ->input ->post('kindname' ,true));
		
		if ($cityid > 0)
		{
			$whereArr['s.id ='] = $cityid;
		}
		elseif (!empty($cityname))
		{
			$whereArr['s.cityname like'] = '%'.$cityname.'%';
		}
		if ($destid > 0)
		{
			$whereArr['d.id ='] = $destid;
		}
		elseif (!empty($kindname))
		{
			$whereArr['d.kindname like'] = '%'.$kindname.'%';
		}
		if ($isopen != -1)
		{
			$whereArr['cfg.isopen ='] = $isopen;
		}
		
		$dataArr['data'] = $this ->trip_model ->getRoundTripData($whereArr);
		$dataArr['count'] = $this ->trip_model ->getRripNum($whereArr);
		echo json_encode($dataArr);
	}
	
	//添加周边游数据
	public function add()
	{
		$cityid = intval($this ->input ->post('cityid'));
		$destid = intval($this ->input ->post('destid'));
		if ($cityid < 1)
		{
			$this->callback->setJsonCode(4000 ,'请选择出发城市');
		}
		if ($destid < 1)
		{
			$this->callback->setJsonCode(4000 ,'请选择目的地');
		}
		else 
		{
			//目的地需要三级及以下
			$destData = $this ->dest_model ->row(array('id' =>$destid));
			if (empty($destData))
			{
				$this->callback->setJsonCode(4000 ,'目的地不存在');
			}
			if ($destData['level'] < 3)
			{
				$this->callback->setJsonCode(4000 ,'目的地请选择到第三级之后');
			}
		}
		
		//查询是否有此组合
		$whereArr = array(
				'cfg.startplaceid =' =>$cityid,
				'cfg.neighbor_id =' =>$destid
		);
		$tripData = $this ->trip_model ->getRoundTripData($whereArr);
		if (!empty($tripData))
		{
			$this->callback->setJsonCode(4000 ,'此种组合已存在');
		}
		
		$dataArr = array(
				'startplaceid' =>$cityid,
				'neighbor_id' =>$destid,
				'isopen' =>1
		);
		$id = $this ->trip_model ->insert($dataArr);
		if (empty($id))
		{
			$this->callback->setJsonCode(4000 ,'添加失败');
		}
		else
		{
			$this ->log(1,3,'周边游配置',"平台新增周边游配置,记录ID:{$id}");
			$this->callback->setJsonCode(2000 ,'添加成功');
		}
	}
	
	//编辑周边游数据
	public function edit()
	{
		$cityid = intval($this ->input ->post('cityid'));
		$destid = intval($this ->input ->post('destid'));
		$isopen = intval($this ->input ->post('isopen'));
		$id = intval($this ->input ->post('id'));
		if ($cityid < 1)
		{
			$this->callback->setJsonCode(4000 ,'请选择出发城市');
		}
		if ($destid < 1)
		{
			$this->callback->setJsonCode(4000 ,'请选择目的地');
		}
		else
		{
			//目的地需要三级及以下
			$destData = $this ->dest_model ->row(array('id' =>$destid));
			if (empty($destData))
			{
				$this->callback->setJsonCode(4000 ,'目的地不存在');
			}
			if ($destData['level'] < 3)
			{
				$this->callback->setJsonCode(4000 ,'目的地请选择到第三级之后');
			}
		}
	
		//查询是否有此组合
		$whereArr = array(
				'cfg.startplaceid =' =>$cityid,
				'cfg.neighbor_id =' =>$destid,
				'cfg.id !=' =>$id
		);
		$tripData = $this ->trip_model ->getRoundTripData($whereArr);
		if (!empty($tripData))
		{
			$this->callback->setJsonCode(4000 ,'此种组合已存在');
		}
	
		$dataArr = array(
				'startplaceid' =>$cityid,
				'neighbor_id' =>$destid,
				'isopen' =>$isopen
		);
		$status = $this ->trip_model ->update($dataArr ,array('id' =>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'周边游配置',"平台编辑周边游配置,记录ID:{$id}");
			$this->callback->setJsonCode(2000 ,'编辑成功');
		}
	}
	
	//编辑或添加周边游
	public function update_trip()
	{
		$id = intval($this ->input->get('id'));
		$tripData = array();
		if ($id >0)
		{
			$tripData = $this ->trip_model ->getRoundTripData(array('cfg.id =' =>$id));
			if (!empty($tripData))
			{
				$tripData = $tripData[0];
			}
		}
		$this ->view('admin/a/cfg/update_trip' ,$tripData);
	}
	
	//启用周边游配置
	public function enable()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->trip_model ->update(array('isopen' =>1) ,array('id' =>$id));
		if (empty($status))
		{
			$this ->callback ->setJsonCode(4000 ,'启用失败');
		}
		else
		{
			$this ->log(3,3,'周边游配置',"平台启用周边游,记录ID:{$id}");
			$this ->callback ->setJsonCode(2000 ,'启用成功');
		}
	}
	
	//停用周边游配置
	public function disable()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->trip_model ->update(array('isopen' =>0) ,array('id' =>$id));
		if (empty($status))
		{
			$this ->callback ->setJsonCode(4000 ,'禁用失败');
		}
		else
		{
			$this ->log(3,3,'周边游配置',"平台禁用周边游,记录ID:{$id}");
			$this ->callback ->setJsonCode(2000 ,'禁用成功');
		}
	}

}
