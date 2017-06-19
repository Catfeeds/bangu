<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		jiakairong
 * @method 		景点地区管理
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Scenic_area extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'scenic_spot_belong_model', 'belong_model' );
	}
	public function index()
	{
		$this->view ( 'admin/a/scenic_spot/scenic_area' );
	}
	public function getScenicAreaData()
	{
		$whereArr = array();
		$postArr = $this->security->xss_clean($_POST);
		
		if (!empty($postArr['city_id']))
		{
			$whereArr['city_id ='] = $postArr['city_id'];
		}
		elseif (!empty($postArr['province_id']))
		{
			$whereArr['province_id ='] = $postArr['province_id'];
		}
		elseif (!empty($postArr['country_id']))
		{
			$whereArr['country_id ='] = $postArr['country_id'];
		}
		//获取数据
		$data = $this ->belong_model ->getScenicAreaData ($whereArr);
		echo json_encode($data);
	}
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$status = $this ->commonFunc($postArr);
		if (!empty($status))
		{
			$this ->log(1,3,'景点地区管理','添加景点地区');
			$this->callback->setJsonCode(2000 ,'添加成功');
		}
		else
		{
			$this->callback->setJsonCode(2000 ,'添加失败');
		}
	}
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$status = $this ->commonFunc($postArr);
		if (!empty($status))
		{
			$this ->log(3,3,'景点地区管理','编辑景点地区');
			$this->callback->setJsonCode(2000 ,'编辑成功');
		}
		else
		{
			$this->callback->setJsonCode(2000 ,'编辑失败');
		}
	}
	
	//添加编辑公用部分
	public function commonFunc($postArr)
	{
		$this ->load_model('area_model');
		$country_id = intval($postArr['country_id']);
		$province_id = empty($postArr['province_id']) ? 0 : intval($postArr['province_id']);
		$city_id = empty($postArr['city_id']) ? 0 : intval($postArr['city_id']);
		$country = trim($postArr['country']);
		$province = empty($postArr['province']) ? '' : trim($postArr['province']);
		$city = empty($postArr['city']) ? '' : trim($postArr['city']);
		$id = empty($postArr['id']) ? '' : intval($postArr['id']);
		if($country_id == 1)
		{
			if ($province_id < 1)
			{
				$this->callback->setJsonCode(4000 ,'请选择境外的国家');
			}
		}
		else 
		{
			if ($province_id < 1)
			{
				$this->callback->setJsonCode(4000 ,'请选择省份');
			}
			if ($city_id < 1)
			{
				$this->callback->setJsonCode(4000 ,'请选择城市');
			}
			if ($id > 0)
			{
				$belongData = $this ->belong_model ->row(array('city_id' =>$city_id ,'id !=' =>$id));
			} else {
				$belongData = $this ->belong_model ->row(array('city_id' =>$city_id));
			}
			
			if (!empty($belongData))
			{
				$this->callback->setJsonCode(4000 ,'此城市已存在，请重新选择');
			}
		}
		
		$belongArr = array(
				'country_id' =>$country_id,
				'country' =>$country,
				'province_id' =>$province_id,
				'province' =>$province,
				'city_id' =>$city_id,
				'city' =>$city
		);
		if (empty($id))
		{
			return $this ->belong_model ->insert($belongArr);
		}
		else 
		{
			return $this ->belong_model ->update( $belongArr ,array('id' =>$id));
		}
	}
	public function getBelongDetail() 
	{
		$id = intval($this ->input ->post('id'));
		$data = $this ->belong_model ->row(array('id' =>$id));
		echo json_encode($data);
	}
	//获取所有的景点地区
	public function getAllScenicArea()
	{
		$belongData = $this ->belong_model ->all();
		$dataArr = array();
		if (!empty($belongData))
		{
			foreach($belongData as $val)
			{
				if (!isset($dataArr['defaultArr']) || !array_key_exists($val['country_id'], $dataArr['defaultArr']))
				{
					$dataArr['defaultArr'][$val['country_id']] = array('id'=>$val['country_id'] ,'name' =>$val['country']);
				}
				if (!isset($dataArr[$val['country_id']]) || !array_key_exists($val['province_id'], $dataArr[$val['country_id']]))
				{
					$dataArr[$val['country_id']][$val['province_id']] = array('id'=>$val['province_id'] ,'name' =>$val['province']);
				}
				if (!isset($dataArr[$val['province_id']]) || !array_key_exists($val['city_id'], $dataArr[$val['province_id']]))
				{
					$dataArr[$val['province_id']][$val['city_id']] = array('id'=>$val['city_id'] ,'name' =>$val['city']);
				}
			}
		}
		echo json_encode($dataArr);
	}
}