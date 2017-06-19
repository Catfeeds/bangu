<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_expert extends UA_Controller
{
	public $typeArr = array('请选择' ,'首页中间','首页右侧','首页底部','最美管家');
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/index_expert_model','index_expert_model');
	}
	
	public function index()
	{
		$this ->view('admin/a/cfg/index_expert' ,array('typeArr' =>$this ->typeArr));
	}
	//首页管家数据获取
	public function getIndexExpertJson()
	{
		$whereArr = array();
		$realname = $this ->input ->post('realname' ,true);
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$location = intval($this ->input ->post('location'));
		
		if (!empty($realname))
		{
			$whereArr['e.realname like '] = '%'.$realname.'%';
		}
		if ($city > 0)
		{
			$whereArr['ie.startplaceid ='] = $city;
		}
		elseif ($province > 0)
		{
			$whereArr['a.pid ='] = $province;
		}
		if ($location > 0)
		{
			$whereArr['ie.location ='] = $location;
		}
		$data = $this ->index_expert_model ->getIndexExpertData($whereArr);
		echo json_encode($data);
	}

	//增加管家
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');
		$id = $this ->index_expert_model ->insert($dataArr);
		if ($id > 0) 
		{
			$this->cache->redis->delete('SYhomeExpert');
			$this ->log(1, 3, '首页管家配置', '添加首页管家,ID:'.$id.',管家名称:'.$postArr['realname'].',管家类型:'.$this ->typeArr[$dataArr['location']]);
			$this ->callback ->setJsonCode('2000' ,'添加成功');
		}
		else 
		{
			$this ->callback ->setJsonCode('4000' ,'添加失败');
		}
 	}
 	//编辑
 	public function edit()
 	{
 		$postArr = $this->security->xss_clean($_POST);
 		$id = intval($postArr['id']);
 		$dataArr = $this ->commonFunc($postArr, 'edit');
 		
 		$status = $this ->index_expert_model ->update($dataArr ,array('id' =>$id));
 		if ($status > 0)
 		{
 			$this->cache->redis->delete('SYhomeExpert');
 			$this ->log(3, 3, '首页管家配置', '编辑首页管家,ID:'.$id.',管家名称:'.$postArr['realname'].',管家类型:'.$this ->typeArr[$dataArr['location']]);
 			$this ->callback ->setJsonCode('2000' ,'编辑成功');
 		}
 		else
 		{
 			$this ->callback ->setJsonCode('4000' ,'编辑失败');
 		}
 	}
 	//添加编辑公用部分
 	public function commonFunc($postArr ,$type)
 	{
 		$cityId = empty($postArr['city']) ? 0 : intval($postArr['city']);
 		$expertId = intval($postArr['expertId']);
 		$location = intval($postArr['location']);
 		$showorder = intval($postArr['showorder']);
 		
 		if (empty($cityId))
 		{
 			$this ->callback ->setJsonCode('4000' ,'请选择城市');
 		}
 		if ($expertId < 1)
 		{
 			$this ->callback ->setJsonCode('4000' ,'请选择管家');
 		}
 		else 
 		{
 			$this ->load_model('expert_model');
 			$expertData = $this ->expert_model ->row(array('status' =>2 ,'id' =>$expertId));
 			if (empty($expertData))
 			{
 				$this ->callback ->setJsonCode('4000' ,'管家不存在');
 			}
 			if ($expertData['city'] != $cityId)
 			{
 				$this ->callback ->setJsonCode('4000' ,'当前管家与所选城市不符合');
 			}
 		}
 		if ($location < 1 || $location > 4)
 		{
 			$this ->callback ->setJsonCode('4000' ,'请选择管家类型');
 		}
 		else
 		{
 			if ($type == 'add')
 			{
 				$dataArr = $this ->index_expert_model ->all(array('expert_id' =>$expertId ,'location' =>$location));
 			}
 			else 
 			{
 				$dataArr = $this ->index_expert_model ->all(array('expert_id' =>$expertId ,'location' =>$location ,'id !=' =>intval($postArr['id'])));
 			}
 			if (!empty($dataArr))
 			{
 				$this ->callback ->setJsonCode('4000' ,'当前管家已配置过此类型');
 			}
 		}
 		$pic = empty($postArr['pic']) ? $expertData['small_photo'] : $postArr['pic'];
 		return array(
 			'startplaceid' =>$cityId,
 			'expert_id' =>$expertId,
 			'location' =>$location,
 			'pic' =>$pic,
 			'smallpic' =>$pic,
 			'is_modify' =>intval($postArr['is_modify']),
 			'is_show' =>intval($postArr['is_show']),
 			'beizhu' =>trim($postArr['beizhu']),
 			'showorder' =>empty($showorder) ? 9999 : $showorder
 		);
 	}
	//删除首页专家
	public function delete()
	{
		$id = intval($this->input->post("id"));
		$dataArr = $this ->index_expert_model ->row(array('id' =>$id));
		if (empty($dataArr))
		{
			$this ->callback ->setJsonCode('4000' ,'管家不存在');
		}
		$status = $this ->index_expert_model ->delete(array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode('4000' ,'删除失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeExpert');
			$this ->log(2,3,'首页管家配置','平台删除首页管家,记录ID:'.$id);
			$this ->callback ->setJsonCode ( '2000' ,'删除成功');
		}
	}
	//获取某条首页管家详情
	public function getDetailJson()
	{
		$id = intval($this->input->post('id'));
		$data = $this ->index_expert_model ->getDetailData($id);
		if (!empty($data))
			echo json_encode($data[0]);
	}
}