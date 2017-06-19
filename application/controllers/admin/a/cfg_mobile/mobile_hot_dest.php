<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		手机端热门目的地
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_hot_dest extends UA_Controller
{
	public $controllerName = '手机端热门目的地';
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/mobile_hot_dest_model','hot_dest_model');
	}
	public function index()
	{
		$this->view ( 'admin/a/cfg_mobile/mobile_hot_dest_list');
	}
	public function getMHotDestData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($name))
		{
			$whereArr ['cfg.name like'] = '%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr ['cfg.startplaceid ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr ['s.pid ='] = $province;
		}
		$data = $this ->hot_dest_model ->getHotDestData($whereArr);
		echo json_encode($data);
	}
	//增加
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->hot_dest_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this ->log(1,3,'手机热门目的地','增加手机热门目的地');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->hot_dest_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'手机热门目的地','编辑手机热门目的地');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$cityId = empty($postArr['city']) ? 0 : intval($postArr['city']);
		$showorder = intval($postArr['showorder']);
		$destid = intval($postArr['destid']);
		if (empty($cityId))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择始发地');
		} 
		if (empty($destid))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择目的地');
		}
		else 
		{
			//获取目的地
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$destData = $this ->dest_base_model ->row(array('id' =>$destid));
			if (empty($destData))
			{
				$this->callback->setJsonCode ( 4000 ,'选择的目的地不存在');
			}
		}
		
		if (empty($postArr['name']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写名称');
		}
		if (empty($postArr['pic']))
		{
			$this->callback->setJsonCode ( 4000 ,'请上传图片');
		}
		if ($type == 'add')
		{
			$data = $this ->hot_dest_model ->row(array('startplaceid' =>$cityId ,'dest_id'=>$destid));
		}
		else
		{
			$data = $this ->hot_dest_model ->row(array('startplaceid' =>$cityId ,'dest_id'=>$destid ,'id !='=>intval($postArr['id']) ));
		}
		if (!empty($data))
		{
			$this->callback->setJsonCode ( 4000 ,'此始发地和目的地的组合已存在');
		}
		
		
		
		return array(
				'dest_id ' =>$destid,
				'pic' =>$postArr['pic'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'startplaceid' =>$cityId,
				'name' =>trim($postArr['name']),
				'dest_type' =>reset(explode(',', $destData['list']))
		);
	}
	
	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->hot_dest_model ->getHotDestDetail($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}

	//删除
	function delHotDest()
	{
		$id = intval($this->input->post("id"));
		$status = $this ->hot_dest_model ->delete(array('id'=>$id));
		if (empty($status)) 
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this ->log(2,3,'手机热门目的地','平台删除手机热门目的地');
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
}