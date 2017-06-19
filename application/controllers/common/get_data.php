<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 目的地管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Get_data extends MY_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('dest/dest_base_model' ,'dest_model');
		$this ->load_model('dest/dest_cfg_model' ,'dest_cfg_model');
	}
	
	/**
	 * 出发城市数据
	 * @author jkr
	 */
	public function getStartplaceData()
	{
		$this ->load_model('startplace_model');
		$whereArr = array('isopen =' =>1);
		$dataArr = $this ->startplace_model ->getStartplaceTree($whereArr);
		echo json_encode($dataArr);
	}
	
	/**
	 * @method 目的地数据，出境和国内
	 * @author jkr
	 */
	public function getDestBaseData()
	{
		$whereArr = array('isopen =' =>1);
		$name = trim($this ->input ->post('name' ,true));
		
		if (!empty($name))
		{
			$dataArr = $this ->dest_model ->getNameSearchDest($whereArr ,$name);
		}
		else
		{
			$dataArr = $this ->dest_model ->getDestBaseAll($whereArr);
		}
		
		echo json_encode($dataArr);
	}
	
	/**
	 * @method 目的地数据，出境、国内、周边
	 * @author jkr
	 */
	public function getTripDestBaseArr()
	{
		$cityid = intval($this ->input ->post('startcity'));
		$name = trim($this ->input ->post('name' ,true));
		
		$whereArr = array(
				'isopen =' =>1
		);
		//获取出境和国内的目的地
		if (!empty($name))
		{
			$baseArr = $this ->dest_model ->getNameSearchDest($whereArr ,$name);
		}
		else
		{
			$baseArr = $this ->dest_model ->getDestBaseAll($whereArr);
		}
		//获取周边游目的地
		$whereArr = array(
				'cfg.isopen =' =>1,
				'd.isopen =' =>1,
				'cfg.startplaceid =' =>$cityid
		);
		if (!empty($name))
		{
			$whereArr['d.kindname like'] = '%'.$name.'%';
		}
		
		$tripArr = $this ->dest_model ->getTripDestBase($whereArr);
		if (!empty($tripArr))
		{
			$topArr = array(
					'name' =>'周边游',
					'simplename' =>'zby',
					'enname' =>'zhoubianyou',
					'pId' =>0,
					'list'=>0,
					'id' =>3
			);
			$tripArr[] = $topArr;
		}
		$dataArr = array_merge($baseArr ,$tripArr);
		echo json_encode($dataArr);
	}
	
	/**
	 * @method 周边游目的地数据
	 * @author jkr
	 */
	public function getTripDestAll()
	{
		$whereArr = array(
				'cfg.isopen =' =>1,
				'd.isopen =' =>1
		);
		//出发城市，获取周边游目的地，必须有
		$cityid = intval($this ->input ->post('startcity'));
		//$cityid = 235;
		$name = trim($this ->input ->post('name' ,true));
		if ($cityid < 1)
		{
			echo json_encode(array());
			exit;
		}
		else
		{
			$whereArr['cfg.startplaceid ='] = $cityid;
		}
	
		if (!empty($name))
		{
			$whereArr['d.kindname like'] = '%'.$name.'%';
		}
	
		$dataArr = $this ->dest_model ->getTripDestBase($whereArr);
		if (!empty($dataArr))
		{
			$topArr = array(
					'name' =>'周边游',
					'simplename' =>'zby',
					'enname' =>'zhoubianyou',
					'pId' =>0,
					'id' =>3
			);
			$dataArr[] = $topArr;
		}else{
			$topArr = array(
					'name' =>'暂无数据',
					'simplename' =>'',
					'enname' =>'',
					'pId' =>0,
					'id' =>0
			);
			$dataArr[] = $topArr;
		}
		echo json_encode($dataArr);
	}
	
	/**
	 * @method 目的地配置表数据
	 * @author jkr
	 */
	public function getDestCfgData()
	{
		$whereArr = array('isopen =' =>1);
		$name = trim($this ->input ->post('name' ,true));
	
		if (!empty($name))
		{
			$dataArr = $this ->dest_cfg_model ->getNameSearchDest($whereArr ,$name);
		}
		else 
		{
			$dataArr = $this ->dest_cfg_model ->getDestCfgAll($whereArr);
		}
		echo json_encode($dataArr);
	}

	/**
	 * @method 出境游目的地数据
	 * @author jkr
	 */
	public function getJLDestBaseData(){
		$whereArr = array(
				'isopen =' =>1,
				'list like' => '2,%'
		);
		$name = trim($this ->input ->post('name' ,true));
		
		if (!empty($name))
		{
			$dataArr = $this ->dest_model ->getNameSearchDest($whereArr ,$name);
		}
		else 
		{
			$dataArr = $this ->dest_model ->getDestBaseAll($whereArr);
		}
		
		echo json_encode($dataArr);
	}
	
	/**
	 * @method 国内游目的地数据
	 * @author jkr
	 */
	public function getGLDestBaseData()
	{
		$whereArr = array(
				'isopen =' =>1,
				'list like' => '1,%'
		);
		$name = trim($this ->input ->post('name' ,true));
	
		if (!empty($name))
		{
			$dataArr = $this ->dest_model ->getNameSearchDest($whereArr ,$name);
		}
		else 
		{
			$dataArr = $this ->dest_model ->getDestBaseAll($whereArr);
		}
		echo json_encode($dataArr);
	}
	/**
	 * @method 帮游管家
	 * @author xml
	 */
	public function get_c_expertList()
	{
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
		$whereArr['$name'] = trim($this ->input ->post('name' ,true));
	
		if (!empty($name))
		{
			$dataArr = $this ->depart_model ->get_c_expert($whereArr);
		}
		else
		{
			$dataArr = $this ->depart_model ->get_c_expert($whereArr);
		}
		echo json_encode($dataArr);
	}
}