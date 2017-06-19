<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		贾开荣
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Area extends UC_NL_Controller {

	public function __construct() {
		parent::__construct ();
		$this ->load_model('common/u_area_model' ,'area_model');
	}
	/***********以下为select联动所需数据******************/
	
	/**
	 * @method 获取所有的地区
	 * @author jiakairong
	 * @since  2015-12-04
	 */
	public function getAreaAllJson()
	{
		$areaArr = array();
		$areaData = $this ->area_model ->all(array('isopen' =>1) ,'id asc' ,'arr' ,'id,pid,name');
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
	 * @method 获取中国的省市(用于地区的联动)
	 * @author jiakairong
	 * @since  2015-09-02
	 */
	public function getChinaAreaPC() {
		$province = $this ->area_model ->all(array('isopen' =>1,'pid' =>2) ,'' ,'arr' ,'id,name');
		$pids = '';
		$areaData = array();
		foreach($province as $val) {
			$areaData['topArea'][] = $val; 
			$pids .= $val['id'].',';
		}
		$pids = rtrim($pids ,',');
		$sql = "select id,name,pid from u_area where isopen = 1 and pid in ({$pids})";
		$city = $this ->db ->query($sql) ->result_array();
		foreach($city as $v) {
			$areaData[$v['pid']][] = $v;
		}
		echo json_encode($areaData);
	}
	/**
	 * @method 获取中国的省市区(用于地区的联动)
	 * @author jiakairong
	 * @since  2015-09-08
	 */
	public function getChinaAreaPCR() {
		$province = $this ->area_model ->all(array('isopen' =>1,'pid' =>2) ,'' ,'arr' ,'id,name');
		$pids = '';
		$areaData = array();
		foreach($province as $val) {
			$areaData['topArea'][] = $val;
			$pids .= $val['id'].',';
		}
		$pids = rtrim($pids ,',');
		$sql = "select id,name,pid from u_area where isopen = 1 and pid in ({$pids})";
		$city = $this ->db ->query($sql) ->result_array();
		$cpid = '';
		foreach($city as $v) {
			$areaData[$v['pid']][] = $v;
			$cpid .= $v['id'].',';
		}
		$cpid = rtrim($cpid ,',');
		$sql = "select id,name,pid from u_area where isopen = 1 and pid in ({$cpid})";
		$region = $this ->db ->query($sql) ->result_array();
		foreach($region as $v) {
			$areaData[$v['pid']][] = $v;
		}
		echo json_encode($areaData);
	}
	
	
	/**
	 * @method 获取国家，省，市(用于地区的联动)
	 * @author jiakairong
	 * @since  2015-09-10
	 */
	public function getAreaCPC() {
		$areaAll = $this ->area_model ->all(array('isopen' =>1 ,'level <='=>3) ,'pid asc','arr' ,'id,name,pid');
		$areaData = array();
		foreach($areaAll as $val) {
			if ($val['pid'] == 0) {
				$areaData['topArea'][] = $val;
			} else {
				$areaData[$val['pid']][] = $val;
			}
		}
		echo json_encode($areaData);
	}
	
	
	/**
	 * @method 获取所有的地区(用于地区的联动)
	 * @author jiakairong
	 * @since  2015-09-10
	 */
	public function getAreaAll() {
		$areaAll = $this ->area_model ->all(array('isopen' =>1) ,'pid asc','arr' ,'id,name,pid');
		$areaData = array();
		foreach($areaAll as $val) {
			if ($val['pid'] == 0) {
				$areaData['topArea'][] = $val;
			} else {
				$areaData[$val['pid']][] = $val;
			}
		}
		echo json_encode($areaData);
	}
	/**
	 * @method 获取境外的国家和城市(用于地区的联动)
	 * @author jiakairong
	 * @since  2015-09-02
	 */
	public function getAbroadAreaPC() {
		$province = $this ->area_model ->all(array('isopen' =>1,'pid' =>1) ,'' ,'arr' ,'id,name');
		$pids = '';
		$areaData = array();
		foreach($province as $val) {
			$areaData['topArea'][] = $val;
			$pids .= $val['id'].',';
		}
		$pids = rtrim($pids ,',');
		$sql = "select id,name,pid from u_area where isopen = 1 and pid in ({$pids})";
		$city = $this ->db ->query($sql) ->result_array();
		foreach($city as $v) {
			$areaData[$v['pid']][] = $v;
		}
		echo json_encode($areaData);
	}
	/**
	 * @method 获取目的地(用于三级联动选择)
	 * @author jiakairong
	 */
	public function getDestThreeData() {
		$this ->load_model('common/u_destinations_model' ,'dest_model');
		$destArr = array();
		$destData = $this ->dest_model ->all(array('level <=' =>3) ,'' ,'arr' ,'id,kindname,pid');
		foreach($destData as $key=>$val) {
			if ($val['pid'] == 0) {
				$destArr['top'][] = $val;
			} else {
				$destArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($destArr);
	}
	/**
	 * @method 国内目的地，下拉选择
	 * @since  2015-10-26
	 * @author jiakairong
	 */
	public function getDomesticDestSel () {
		$this ->load_model('common/u_destinations_model' ,'dest_model');
		$destArr = array();
		$destData = $this ->dest_model ->all(array('level <=' =>3) ,'pid asc' ,'arr' ,'id,kindname,pid,level');
		foreach($destData as $key=>$val) {
			if ($val['pid'] == 2) {
				$destArr['top'][] = $val;
			} elseif ($val['level'] == 3){
				$destArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($destArr);
	}
	/**
	 * @method 境外目的地，下拉选择
	 * @since  2015-10-26
	 * @author jiakairong
	 */
	public function getAbroadDestSel () {
		$this ->load_model('common/u_destinations_model' ,'dest_model');
		$destArr = array();
		$destData = $this ->dest_model ->all(array('level <=' =>3) ,'' ,'arr' ,'level,id,kindname,pid');
		foreach($destData as $key=>$val) {
			if ($val['pid'] == 1) {
				$destArr['top'][] = $val;
			} elseif ($val['level'] == 3){
				$destArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($destArr);
	}
	
	/**
	 * @method 出发城市联动
	 * @author jiakairong
	 */
	public function getStartCity() {
		$this ->load_model('common/u_startplace_model' ,'start_model');
		$startArr = array();
		$startData = $this ->start_model ->all(array('isopen' =>1) ,'' ,'arr' ,'id,pid,cityname');
		foreach($startData as $val) {
			if ($val['pid'] == 0) {
				//continue;
				$startArr['top'][] = $val;
			//} else if ($val['pid'] == 2) { //国内
				
			} else {
				$startArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($startArr);
	}
	
	public function getStartCityCP() {
		$this ->load_model('common/u_startplace_model' ,'start_model');
		$startArr = array();
		$startData = $this ->start_model ->all(array('isopen' =>1 ,'level <=' =>2) ,'' ,'arr' ,'id,pid,cityname');
		foreach($startData as $val) {
			if ($val['pid'] == 0) {
				//continue;
				$startArr['top'][] = $val;
				//} else if ($val['pid'] == 2) { //国内
		
			} else {
				$startArr[$val['pid']][] = $val;
			}
		}
		echo json_encode($startArr);
	}
	
	/***********以上为select联动所需数据******************/
	
	
	/***********以下为地区，目的地，选择插件所需数据******************/
	
	
	/**
	 * @method 根据出发城市获取周边游
	 * @author jiakairong
	 * @since  2015-11-14-6
	 * @param intval $startplaceid 出发城市ID
	 */
	public function getRoundTripData($startplaceid = 0)
	{
		$this ->load_model('common/cfg_round_trip_model' ,'trip_model');
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
		$cityId = intval($this ->input ->post('startcity'));
		$startplaceid = empty($cityId) ? $startplaceid : $cityId;
		if(empty($startplaceid))
		{
			$startplaceid = $this ->session ->userdata('city_location_id');
			$cityName = $this ->session ->userdata('city_location');
		}
		else
		{
			$this ->load_model('common/u_startplace_model' ,'startplace_model');
			$startData = $this ->startplace_model ->row(array('id' =>$startplaceid));
			$cityName = $startData['cityname'];
		}
		//获取周边目的地
		$tripData = $this ->trip_model ->all(array('startplaceid' =>$startplaceid ,'isopen' =>1));
		$tripArr = array();
		if (!empty($tripData))
		{
			$destId = '';
			foreach($tripData as $v)
			{
				$destId .= $v['neighbor_id'].',';
			}
// 			$destId = rtrim($destId ,',');
// 			//获取目的地
// 			$tripArr = $this ->dest_base_model ->getDestInData($destId);
			$whereArr = array(
					'in' =>array('id' =>rtrim($destId ,','))
			);
			$tripArr = $this ->dest_base_model ->getDestBaseAll($whereArr);
		}
		$data = array(
				'name' =>'周边游',
				'two' =>array(
						array(
								'name' =>$cityName,
								'three' =>$tripArr
						),
				),
		);

		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			echo json_encode($data);
		} else {
			return $data;
		}
	}
	
	/**
	 * @method 获取地区，用于地区选择插件
	 * @author jiakairong
	 * @since  2015-11-16
	 */
	public function getAreaData()
	{
		$this ->load_model('common/u_area_model' ,'area_model');
		$areaData = $this ->area_model ->getAreaAllData();
		$areaArr = array();
		$three_area = array();
		foreach($areaData as $key=>$val)
		{
			if (empty($val['name'])) 
			{
				continue;
			}
			switch($val['level']) {
				case 1: //顶级
					if ($val['id'] == 1) //境外
					{
						$areaArr['abroad'] = $val;
					}
					elseif ($val['id'] == 2) //国内
					{
						$areaArr['domestic'] = $val;
					}
					break;
				case 2:
					if ($val['pid'] == 1)
					{
						$areaArr['abroad']['two'][$val['id']] = $val;
					}
					elseif ($val['pid'] == 2)
					{
						$areaArr['domestic']['two'][$val['id']] = $val;
					}
					break;
				case 3:
					$three_area[] = $val;
					break;
			}
		}
		foreach($three_area as $val)
		{
			foreach($areaArr as $index =>$item)
			{
				if (!isset($item['two']))
				{
					unset($areaArr[$index]); //没有第二级，则删除掉
				} 
				else
				{
					foreach($item['two'] as $k =>$v)
					{
						if ($val['pid'] == $v['id'])
						{
							$areaArr[$index]['two'][$k]['three'][] = $val;
						}
					}
				}
			}
		}
		//过滤第三级为空的情况
		foreach($areaArr as $key=>$val)
		{	
			foreach($val['two'] as $k=>$v)
			{
				if (empty($v['three']))
				{
					unset($areaArr[$key]['two'][$k]);
				}
			}
		}
		echo json_encode($areaArr);
	}
	/**
	 * @method 获取目的地，用于目的地选择插件
	 * @author jiakairong
	 * @since  2015-11-16
	 * @param intval $startplaceid  出发城市id，用于获取周边游
	 */
	public function getDestAllData($startplaceid=0)
	{
		$this ->load_model('common/u_destinations_model' ,'dest_model');
		$destData = $this ->dest_model ->getDistination(3);
		$destArr = array();
		$threeDestArr = array();
		foreach($destData as $key=>$val)
		{
			if (empty($val['name']))
			{
				continue;
			}
			switch($val['level']) {
				case 1: //顶级
					if ($val['id'] == 1) //出境游
					{
						$destArr['abroad'] = $val;
					}
					elseif ($val['id'] == 2) //国内游
					{
						$destArr['domestic'] = $val;
					}
					break;
				case 2:
					if ($val['pid'] == 1)
					{
						$destArr['abroad']['two'][$val['id']] = $val;
					}
					elseif ($val['pid'] == 2)
					{
						$destArr['domestic']['two'][$val['id']] = $val;
					}
					break;
				case 3:
					$threeDestArr[] = $val;
					break;
			}
		}
		foreach($threeDestArr as $val)
		{
			foreach($destArr as $index =>$item)
			{
				if (!isset($item['two']))
				{
					unset($destArr[$index]); //没有第二级，则删除掉
				}
				else
				{
					foreach($item['two'] as $k =>$v)
					{
						if ($val['pid'] == $v['id'])
						{
							$destArr[$index]['two'][$k]['three'][] = $val;
						}
					}
				}
			}
		}
		//过滤第三级为空的情况
		foreach($destArr as $key=>$val)
		{
			foreach($val['two'] as $k=>$v)
			{
				if (empty($v['three']))
				{
					unset($destArr[$key]['two'][$k]);
				}
			}
		}
		$destArr['trip'] = $this ->getRoundTripData($startplaceid);
	
		echo json_encode($destArr);
	}
	
	
	
	/**
	 * @method 通过城市ID获取其下面的行政区(现用于：获取管家服务地区)
	 * @since  2015-11-17
	 */
	public function getRegionData()
	{
		$cityid = intval($this ->input ->post('cityid'));
		$regionData = $this ->area_model ->all(array('isopen'=>1,'pid'=>$cityid));
		echo json_encode($regionData);
	}
	
	/**
	 * @method 获取出发城市，用于出发城市选择插件
	 * @author jiakairong
	 * @since  2015-11-17
	 */
	public function getStartplaceAllData()
	{
		$this ->load_model('common/u_startplace_model' ,'start_model');
		$startData = $this ->start_model ->getStartAllData(1);
		$startArr = array();
		$threeStartArr = array();
		foreach($startData as $key=>$val)
		{
			if (empty($val['name']))
			{
				continue;
			}
			switch($val['level']) {
				case 1: //顶级
					if ($val['id'] == 1) //国外
					{
						$startArr['abroad'] = $val;
					}
					elseif ($val['id'] == 2) //国内
					{
						$startArr['domestic'] = $val;
					}
					break;
				case 2:
					if ($val['pid'] == 1)
					{
						$startArr['abroad']['two'][$val['id']] = $val;
					}
					elseif ($val['pid'] == 2)
					{
						$startArr['domestic']['two'][$val['id']] = $val;
					}
					break;
				case 3:
					$threeStartArr[] = $val;
					break;
				case 4:
					$threeStartArr[] = $val;
					break;
			}
		}
		foreach($threeStartArr as $val)
		{
			foreach($startArr as $index =>$item)
			{
				if (!isset($item['two']))
				{
					unset($startArr[$index]); //没有第二级，则删除掉
				}
				else
				{
					foreach($item['two'] as $k =>$v)
					{
						if ($val['pid'] == $v['id'])
						{
							$startArr[$index]['two'][$k]['three'][] = $val;
						}
					}
				}
			}
		}
		//过滤第三级为空的情况
		foreach($startArr as $key=>$val)
		{
			foreach($val['two'] as $k=>$v)
			{
				if (empty($v['three']))
				{
					unset($startArr[$key]['two'][$k]);
				}
			}
		}
		
		echo json_encode($startArr);
	}
	
	/***********以上为地区，目的地，选择插件所需数据******************/
	
	//获取地区选择数据
	public function get_area_data() {
		$this ->load_model('area_model');
		$area = $this ->area_model ->all(array('isopen' =>1));
		if (empty($area)) {
			echo false;exit;
		}
		$aiid = sys_constant::AIID;//国际的ID
		$acid = sys_constant::ACID;//中国的ID
		$internationalArr = array(); //国际的国家
		$internationalArrHot = array();//热门国家
		$chinaArr = array();// 中国的城市
		$chinaArrHot = array();//热门城市
		$area1 = array();
		foreach($area as $key =>$val) {
			if ($val['pid'] == $aiid) {
				$internationalArr[] = $val;
				if ($val['ishot'] == 1) {
					$internationalArrHot[] = $val;
				}
				unset($area[$key]);
			} elseif ($val['pid'] == $acid) {
				$area1[$val['id']] = $val;
				unset($area[$key]);
			}
		}
		foreach($area as $k =>$v) {
			if (array_key_exists($v['pid'] ,$area1)) {
				if ($v['ishot'] == 1) {
					$chinaArrHot[] = $v;
				}
				$chinaArr[] = $v;
			}
		}
		$data = array(
			'chinaArr' =>$chinaArr,
			'internationalArr' =>$internationalArr,
			'chinaArrHot' =>$chinaArrHot,
			'internationalArrHot' =>$internationalArrHot
		);
		echo json_encode($data);
	}
	
	//生成拼音
	public function create_pinying() {
		$this->load->library ( 'Get_pinying' );
		$this ->load_model('common/u_startplace_model' ,'startplace_model');
		$whereArr = array();
		$area = $this ->startplace_model ->all($whereArr);
		foreach($area as $key =>&$val) {
			$val['enname'] = $this ->get_pinying ->getAllPY($val['cityname']);
			$val['simplename'] = $this ->get_pinying ->getFirstPY($val['cityname']);
			$this ->startplace_model ->update($val ,array('id' =>$val['id']));
		}
	}
	
	/**
	 *@author xml
	 *@method 添加线路的出发地
	 */
     public function get_line_startplace(){
     	$this ->load_model('common/u_startplace_model' ,'start_model');
     	$startData = $this ->start_model ->getStartAllData(1);
     	$startArr = array();
     	$threeStartArr = array();
     	foreach($startData as $key=>$val)
     	{
     		if (empty($val['name']))
     		{
     			continue;
     		}
     		switch($val['level']) {
     			case 1: //顶级
     				if ($val['id'] == 1) //国外
     				{
     					$startArr['abroad'] = $val;
     				}
     				elseif ($val['id'] == 2) //国内
     				{
     					$startArr['domestic'] = $val;
     				}
     				break;
     			case 2:
     				if ($val['pid'] == 1)
     				{
     					$startArr['abroad']['two'][$val['id']] = $val;
     				}
     				elseif ($val['pid'] == 2)
     				{
     					$startArr['domestic']['two'][$val['id']] = $val;
     					//var_dump($val);
     					if($val['name']=='全国出发'){
     						$forStartArr[$key] = $val;
     					//	var_dump($forStartArr);
     					}
     				}
     				break;
     			case 3:
     				$threeStartArr[] = $val;
     				break;
     			//case 4:
     			//	$forStartArr[$key] = $val;
     				//$threeStartArr[] = $val;
     			//	break;
     		}
     	}

     	foreach($threeStartArr as $val)
     	{
     		foreach($startArr as $index =>$item)
     		{
     			if (!isset($item['two']))
     			{
     				unset($startArr[$index]); //没有第二级，则删除掉
     			}
     			else
     			{
     				foreach($item['two'] as $k =>$v)
     				{
     					if ($val['pid'] == $v['id'])
     					{
     						$startArr[$index]['two'][$k]['three'][] = $val;
     					}
     				}
     			}
     		}
     	}
     	//过滤第三级为空的情况
     	foreach($startArr as $key=>$val)
     	{
     		foreach($val['two'] as $k=>$v)
     		{
     			if (empty($v['three']))
     			{
     				unset($startArr[$key]['two'][$k]);
     			}
     		}
     	}
     	//全国出发地
     	if(isset($forStartArr)){
     		//var_dump($startArr); 
     		foreach ($forStartArr as $k=>$v){
     			//$startArr['domestic']//国内
     			$startArr['domestic']['two']['137']['id']='37';
     			$startArr['domestic']['two']['137']['enname']='guonei';
     			$startArr['domestic']['two']['137']['ishot']='';
     			$startArr['domestic']['two']['137']['level']='2';
     			$startArr['domestic']['two']['137']['name']='国内';
     			$startArr['domestic']['two']['137']['pid']='2';
     			$startArr['domestic']['two']['137']['simplename']='gn';
     			$startArr['domestic']['two']['137']['three'][]=$v;
     		}	
     	}
     	echo json_encode($startArr);
     }
      
}
