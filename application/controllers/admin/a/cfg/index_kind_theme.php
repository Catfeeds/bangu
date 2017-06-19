<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年5月7日14:46:53
* @author		贾开荣
* @method 		首页分类主题
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind_theme extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/Index_kind_theme_model', 'kind_theme_model' );
	}
	
	public function index()
	{
		$this ->load_model('common/u_theme_model' ,'theme_model');
		$this ->load_model('admin/a/index_kind_model' ,'kind_model');
		$data['theme'] = $this ->theme_model ->all(array() ,'' ,'arr' ,'id,name');
		$data['kind'] = $this ->kind_model ->all(array('is_show' =>1));
		$this->view ( 'admin/a/cfg/index_kind_theme' ,$data);
	}

	public function getkindThemeJson()
	{
		$whereArr = array();
		$theme_id = intval($this ->input ->post('theme'));
		$province = intval($this ->input ->post('province'));
		$city = intval($this ->input ->post('city'));
		
		if (!empty($theme_id))
		{
			$whereArr['ikt.theme_id ='] = $theme_id;				
		}
		if (!empty($city))
		{
			$whereArr['ikt.startplaceid ='] = $city;
		} 
		elseif ($province)
		{
			$whereArr['s.pid ='] = $province;
		}
		$data = $this ->kind_theme_model ->getKindThemeData($whereArr);
		echo json_encode($data);
	}
	
	//增加首页分类主题
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
	
		$dataArr = $this ->commonFunc($postArr ,'add');
		$status = $this ->kind_theme_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(1,3,'首页分类主题配置','增加首页首页分类主题');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑首页分类主题
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr ,'edit');
		$status = $this ->kind_theme_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(3,3,'首页分类主题配置','编辑首页分类主题');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$cityId = intval($postArr['city']);
		$kindId = intval($postArr['kind']);
		$themeId = intval($postArr['theme']);
		if (empty($cityId))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择始发地城市');
		}
		if (empty($kindId))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择一级分类');
		}
		if (empty($themeId))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择主题');
		}
		if (empty($postArr['name']))
		{
			$this->callback->set_code ( 4000 ,'请填写名称');
		}
		if ($type == 'add')
		{
			$kindTheme = $this ->kind_theme_model ->row(array('startplaceid' =>$cityId ,'index_kind_id'=>$kindId,'theme_id'=>$themeId));
		} else {
			$kindTheme = $this ->kind_theme_model ->row(array('startplaceid' =>$cityId ,'index_kind_id'=>$kindId,'theme_id'=>$themeId ,'id !='=>intval($postArr['id'])));
		}
		if (!empty($kindTheme))
		{
			$this->callback->setJsonCode ( 4000 ,'此出发城市和一级分类下已有此主题');
		}
		
		return  array(
				'name ' =>trim($postArr['name']),
				'pic' =>$postArr['pic'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder']),
				'theme_id' =>$themeId,
				'index_kind_id' =>$kindId,
				'startplaceid' =>$cityId
		);
	}
	
	//获取某条数据
	public function getDetailJson()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->kind_theme_model ->getDetailData($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}
}