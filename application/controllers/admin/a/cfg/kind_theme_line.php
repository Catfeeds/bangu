<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		首页主题线路
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Kind_theme_line extends UA_Controller
{
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/index_kind_theme_line_model','theme_line_model');
	}
	public function index()
	{
		$this ->load_model('admin/a/theme_model' ,'theme_model');
		$data['theme'] = $this ->theme_model ->all();
		$this->view ( 'admin/a/cfg/kind_theme_line' ,$data);
	}
	public function getKindThemeData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$themeid = intval($this ->input ->post('theme'));
		
		if (!empty($themeid))
		{
			$whereArr['tl.theme_id ='] = $themeid;
		}
		if (!empty($name))
		{
			$whereArr ['l.linename like'] ='%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr ['tl.startplaceid ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr ['s.pid ='] = $province;
		}

		$data = $this ->theme_line_model ->getThemeLineData($whereArr);
		echo json_encode($data);
	}
	//增加首页分类主题线路
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->theme_line_model ->insert($dataArr);
		if (empty($status)) 
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(1,3,'首页主题线路配置','增加首页主题线路');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑首页分类主题线路
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->theme_line_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(3,3,'首页主题线路配置','编辑首页主题线路');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$city = empty($postArr['city']) ? 0 :intval($postArr['city']);
		$themeId = intval($postArr['theme']);
		$lineId = intval($postArr['lineId']);
		$showorder = intval($postArr['showorder']);
		if (empty($city))
		{
			$this->callback->setJsonCode('4000' ,'请选择始发地城市');
		}
		if(empty($themeId)) 
		{
			$this->callback->setJsonCode ( 4000 ,'请选择主题');
		}		
		if (empty($lineId)) 
		{
			$this->callback->setJsonCode ( 4000 ,'请选择线路');
		}
		else
		{
			if ($type == 'add') 
			{
				$themeLine = $this ->theme_line_model ->row(array('line_id' =>$lineId ,'theme_id' =>$themeId ,'startplaceid' =>$city));
			} 
			else
			{
				$themeLine = $this ->theme_line_model ->row(array('line_id'=>$lineId ,'theme_id' =>$themeId,'id !='=>intval($postArr['id']) ,'startplaceid' =>$city));
			}
			if (!empty($themeLine)) 
			{
				$this->callback->setJsonCode ( 4000 ,'当前出发城市的主题下已存在此线路');
			}
		}
		//获取首页分类主题
		$this ->load_model('admin/a/index_kind_theme_model' ,'kind_theme_model');
		$kindTheme = $this ->kind_theme_model ->row(array('startplaceid' =>$city ,'theme_id' =>$themeId));
		if (empty($kindTheme))
		{
			$this->callback->setJsonCode ( 4000 ,'没有此分类主题，请添加');
		}
		$this ->load_model('common/u_line_model' ,'line_model');
		$lineData = $this ->line_model ->row(array('id'=>$lineId) ,'arr' ,'' ,'mainpic');
		if (empty($lineData))
		{
			$this->callback->setJsonCode ( 4000 ,'线路不存在');
		}
		return array(
				'theme_id' =>$themeId,
				'line_id ' =>$lineId,
				'pic' =>empty($postArr['pic']) ? $lineData['mainpic'] : $postArr['pic'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'startplaceid' =>$city,
				'index_kind_theme_id' =>$kindTheme['id']
		);
	}
	//获取某条数据
	public function getDetailJson()
	{
		$id = intval($this ->input ->post('id'));
		$themeLineArr = $this ->theme_line_model ->getThemeLineDetail($id);
		if (!empty($themeLineArr))
		{
			$this ->load_model('admin/a/index_kind_theme_model' ,'kind_theme_model');
			$themeArr = $this ->kind_theme_model ->all(array('startplaceid' =>$themeLineArr[0]['startplaceid'] ,'is_show' =>1));
			$data = array(
					'theme' =>$themeArr,
					'dataArr' =>$themeLineArr[0]
			);
			echo json_encode($data);
		}
	}
	//删除首页主题线路
	public function delThemeLine()
	{
		$id = intval($this->input->post("id"));
		$status = $this ->theme_line_model ->delete(array('id'=>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(2,3,'首页主题线路配置','平台删除首页主题线路');
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
	
	/**
	 * @method 获取出发城市的主题
	 * @since  2015-11-27
	 */
	public function getStartCityTheme()
	{
		$this ->load_model('admin/a/index_kind_theme_model' ,'kind_theme_model');
		$startplaceid = intval($this ->input ->post('city'));
		$themeArr = $this ->kind_theme_model ->all(array('startplaceid' =>$startplaceid ,'is_show' =>1));
		echo json_encode($themeArr);
	}
}