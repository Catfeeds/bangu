<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年5月7日14:46:53
* @author		贾开荣
* @method 		首页分类目的地
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind_dest extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/a/index_kind_dest_model', 'kind_dest_model' );
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
	}

	public function index()
	{
		$this ->load_model('admin/a/index_kind_model' ,'kind_model');
		
		$data['kind'] = $this ->kind_model ->all(array('is_show' =>1 ,'dest_id >' =>0));
		$destData = $this ->dest_base_model ->all(array('level >' =>1 ,'level <' =>4 ,'isopen' =>1));
		$destArr = array();
		foreach($destData as $val)
		{
			$destArr[$val['pid']][] = $val;
		}
		$data['destArr'] = $destArr;
		$this ->view('admin/a/cfg/kind_dest_list' ,$data);
	}
	
	public function getKindDestJson()
	{
		$whereArr = array();
		$kindId = intval($this ->input ->post('kind'));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($kindId))
		{
			$whereArr ['ikd.index_kind_id ='] = $kindId;
		}
		if (!empty($city))
		{
			$whereArr['ikd.startplaceid ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr ['s.pid ='] = $province;
		}
		
		$whereArr['ikd.is_show >='] = 0;
		$data = $this ->kind_dest_model ->getKindDestData($whereArr);
		//echo $this ->db ->last_query();
		echo json_encode($data);
	}
	
	//通过出发城市获取周边游配置
	public function getTripDest()
	{
		$cityid = intval($this ->input ->post('city'));
		$this ->load_model('common/cfg_round_trip_model' ,'trip_model');
		$whereArr = array(
				'cfg.startplaceid=' =>$cityid ,
				'cfg.isopen =' =>1
		);
		$data = $this ->trip_model ->getRoundTripAll($whereArr ,'id desc','d.kindname is not null');
		echo json_encode($data);
	}

	//增加首页一级分类
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$kindArr = $this ->commonFunc($postArr);
		$status = $this ->kind_dest_model ->insert($kindArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(1,3,'首页分类目的地配置','增加首页分类目的地');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑特价线路
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$kindArr = $this ->commonFunc($postArr);
		$status = $this ->kind_dest_model ->update($kindArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(3,3,'首页分类目的地配置','编辑首页分类目的地');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	
	public function del()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'is_show' =>-1
		);
		$status = $this ->kind_dest_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this->callback ->setJsonCode(4000 ,'删除失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'删除成功');
		}
	}
	
	//添加编辑时公用
	public function commonFunc($postArr)
	{
		$city = empty($postArr['city']) ? 0 : intval($postArr['city']);
		$kind = intval($postArr['kind']);
		$destId = empty($postArr['dest_city']) ? 0 : intval($postArr['dest_city']);
		$destId = empty($destId) ? intval($postArr['dest_province']) : $destId;
		$showorder = intval($postArr['showorder']);
		if (empty($city))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择始发地城市');
		}
		if (empty($kind))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择一级分类');
		}
		if (empty($destId)) {
			$this->callback->setJsonCode ( 4000 ,'请选择目的地');
		}
		if (empty($postArr['name']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写名称');
		}
	
		return  array(
				'name ' =>trim($postArr['name']),
				'pic' =>$postArr['pic'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : intval($showorder),
				'dest_id' =>$destId,
				'index_kind_id' =>$kind,
				'startplaceid' =>$city
		);
	}

	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$kindDest = $this ->kind_dest_model ->getKindDestDetail($id);
		if (!empty($kindDest))
		{
			echo json_encode($kindDest[0]);exit;
		}
		
		if (empty($kindDest)) {
			echo false;exit;
		}
		//获取出发城市的上级
		$this ->load_model('common/u_startplace_model' ,'start_model');
		$startData = $this ->start_model ->row(array('id' =>$kindDest[0]['startplaceid']));
		$kindDest[0]['start_province'] = $startData['pid'];
		$startData = $this ->start_model ->row(array('id' =>$startData['pid']));
		$kindDest[0]['start_country'] = $startData['pid'];
		
		//获取目的地的上级
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
		$destData = $this ->dest_base_model ->row(array('id' =>$kindDest[0]['dest_id']));
		//var_dump($destData);
		$kindDest[0]['destOne'] = $destData['pid'];	

		//判断是一级分类是否是周边游
		if ($kindDest[0]['ikname'] == '周边游') {
			$this ->load_model('common/cfg_round_trip_model' ,'trip_model');
			$kindDest[0]['trip'] = $this ->trip_model ->getRoundTripData(array('crt.startplaceid' =>$kindDest[0]['startplaceid'] ,'crt.isopen' =>1) ,0);
		}
		echo json_encode($kindDest[0]);
	}
}