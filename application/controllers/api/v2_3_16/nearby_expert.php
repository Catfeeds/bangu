<?php
/**
 *   @name:APP接口 => 附近的管家
 * 	 @author: jkr
 *   @time: 2016.05.25
 *   
 *	 @abstract:
 *
 *      1、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *        
 *      2、数据传递方式： POST
 * 		
 *      3、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Nearby_expert extends APP_Controller
{
	//用户查询附近管家，管家经纬度生成的hash长度
	public $expert_hash_len = 7;
	
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('expert_model');
		//$this->load->driver('cache');
	}

	/**
	 * 更新管家的位置,经纬度
	 * @return json
	 */
	public function update_expert_position()
	{
// 		$this->load->library('Geohash');
		//纬度
		$longitude = trim($this ->input ->post('longitude' ,true));
		//经度
		$latitude = trim($this ->input ->post('latitude' ,true));
		//管家ID
		$eid = intval($this ->input ->post('eid'));
		
// 		$longitude = '114.127119';
// 		$latitude = '22.608549';
// 		$eid = 3734;
		
		if (empty($longitude) || empty($latitude))
		{
			$this ->__errormsg('请传入经纬度');
		}
		if (empty($eid))
		{
			$this ->__errormsg('缺少管家参数');
		}
		else
		{
			$expertData = $this ->expert_model ->row(array('id' =>$eid));
			if (empty($expertData))
			{
				$this ->__errormsg('管家不存在');
			}
		}
		
		$dataArr = array(
				'longitude' =>$longitude,
				'latitude' =>$latitude
		);
		$status = $this ->expert_model ->update($dataArr ,array('id' =>$eid));
		if ($status == true)
		{
			$this->__data($dataArr);
		}
		else 
		{
			$this ->__errormsg('更新位置失败');
		}
		//生成hash值，一个hash值代表的是一块区域，在同一区域中生成的hash值是一样的
		//$geohash = $this ->geohash ->encode_geohash($latitude ,$longitude ,$this->expert_hash_len);
		
		//redis的列表类型储存,以$geohash为key，管家ID为value，这样同一区域的管家将储存在一起
		//$this ->cache ->redis ->lpush ('ne_'.$geohash ,$eid);
	}
	/**
	 * 获取附近的管家
	 * @return json
	 */
	public function get_nearby_expert()
	{
// 		$this->load->library('Geohash');
		//纬度
		$longitude = trim($this ->input ->post('longitude' ,true));
		//经度
		$latitude = trim($this ->input ->post('latitude' ,true));
		
// 		$_REQUEST['page'] = 1;
// 		$_REQUEST['pageSize'] = 10;
		
		//查询条件保存变量
		$whereArr = array();
		
// 		$longitude = '114.127119';
// 		$latitude = '22.109549';
		
		if (empty($longitude) || empty($latitude))
		{
			$this ->__errormsg('请传入经纬度');
		}
		
		$expertData = $this ->expert_model ->getNearbyExpert($whereArr,$longitude,$latitude,10*1000);
		//echo $this ->db ->last_query();
		if (empty($expertData))
		{
			$this ->__nullmsg();
		}
		foreach($expertData as $k=>$v)
		{
			if ($v['distance'] > 1000) 
			{
				$expertData[$k]['distance'] = round(($v['distance']/1000) ,2).'km';
			}
			else 
			{
				$expertData[$k]['distance'] = round($v['distance'] ,2).'m';
			}
		}
		$this ->__data($expertData);
		//获取用户所在地的hash值
// 		$geohash = $this ->geohash ->encode_geohash($latitude ,$longitude ,$this->expert_hash_len);
// 		$geohash = 'ws10t5';
		
// 		//获取周边的块区域
// 		$expands = $this->geohash->getGeoHashExpand($geohash);
	}
}