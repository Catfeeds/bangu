<?php
/**
 * @method 用于地区，出发城市，目的地等联动的数据接口
 * @since  2015-12-14
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class SelectData extends MY_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	/**
	 * @method 获取出发城市数据
	 * @since  2015-01-04
	 */
	public function getStartplaceJson()
	{
		$this ->load_model('common/u_startplace_model' ,'start_model');
		$startArr = array();
		$startData = $this ->start_model ->all(array('isopen' =>1) ,'' ,'arr' ,'id,pid,cityname as name');
		foreach($startData as $val)
		{
			if ($val['pid'] == 0)
			{
				$startArr['defaultArr'][] = $val;
			}
			else
			{
				$startArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($startArr);
	}
	/**
	 * @method 获取所有地区
	 * @since  2016-01-05
	 */
	public function getAreaAll()
	{
		$whereArr = array();
		$isopen = $this ->input ->post('isopen');
		$level = intval($this ->input ->post('level'));
		if ($isopen == 1)
		{
			$whereArr['isopen'] = $isopen;
		}
		if ($level > 0)
		{
			$whereArr['level <='] = $level;
		}
		$this ->load_model('area_model');
		$areaArr = array();
		$areaData = $this ->area_model ->all($whereArr ,'' ,'arr' ,'id,pid,name');
		foreach($areaData as $val)
		{
			if ($val['pid'] == 0)
			{
				$areaArr['defaultArr'][] = $val;
			}
			else
			{
				$areaArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($areaArr);
	}
	/**
	 * @method 获取目的地数据
	 * @since  2016-01-18
	 */
	public function getDestAll()
	{
		$whereArr = array();
		$this ->load_model('destinations_model' ,'dest_model');
		$isopen = intval($this ->input ->post('isopen'));
		$level = intval($this ->input ->post('level'));
		if ($isopen == 1)
		{
			$whereArr['isopen'] = $isopen;
		}
		if ($level > 0)
		{
			$whereArr['level <='] = $level;
		}
		$destData = $this ->dest_model ->all($whereArr ,'' ,'arr' ,'id,kindname as name,pid');
		$destArr = array();
		foreach($destData as $val)
		{
			if ($val['pid'] == 0)
			{
				$destArr['defaultArr'][] = $val;
			}
			else 
			{
				$destArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($destArr);
	}
	/**
	 * @method 线路属性
	 * @since  2016-01-18
	 */
	public function getAttrJson()
	{
		$whereArr = array();
		$this ->load_model('admin/a/line_attr_model' ,'attr_model');
		$isopen = intval($this ->input ->post('isopen'));
		if ($isopen == 1)
		{
			$whereArr['isopen'] = 1;
		}
		$attrData = $this ->attr_model ->all($whereArr ,'' ,'arr' ,'id,attrname as name,pid');
		$attrArr = array();
		foreach($attrData as $val)
		{
			if ($val['pid'] == 0) 
			{
				$attrArr['defaultArr'][] = $val;
			}
			else 
			{
				$attrArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($attrArr);
	}
	/**
	 * @method 根据出发城市获取周边游目的地
	 * @author jiakairong
	 * @since  2015-03-07
	 */
	public function getStartCityDest()
	{
		$cityId = intval($this ->input ->post('city'));
		$this ->load_model('round_trip_model');
		$tripData = $this ->round_trip_model ->getRoundTripDest($cityId);
		echo json_encode($tripData);
	}
}