<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年6月19日09:53:53
 * @author		jiakairong
 * @method 		首页体验师配置
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_experience extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/index_experience_model','experience_model');
	}
	public function index()
	{
		$this->view ( 'admin/a/cfg/index_experience_list');
	}
	
	public function getExperienceData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name'));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($name))
		{
			$whereArr['m.nickname like'] = '%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr['ie.startplaceid ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr['s.pid ='] = $province;
		}
		$data =$this->experience_model->getExperienceData($whereArr);
		echo json_encode($data);
	}
	//增加体验师
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$experienceArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->experience_model ->insert($experienceArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeExperience');
			$this ->log(1,3,'首页体验师配置','增加体验师');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑体验师
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$experienceArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->experience_model ->update($experienceArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeExperience');
			$this ->log(3,3,'首页体验师配置','编辑体验师');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$mid = intval($postArr['member_id']);
		$noteId = intval($postArr['note_id']);
		$showorder = intval($postArr['showorder']);
		if ($mid < 1)
		{
			$this->callback->setJsonCode ( 4000 ,'请选择体验师');
		}
		else
		{
			if ($type == 'add')
			{
				$experienceData = $this ->experience_model ->row(array('member_id' =>$mid));
			}
			else
			{
				$experienceData = $this ->experience_model ->row(array('member_id' =>$mid ,'id !=' =>intval($postArr['id'])));
			}
			if (!empty($experienceData))
			{
				$this->callback->setJsonCode ( 4000 ,'您选择的体验师已是首页体验师，请重新选择');
			}
		}
		if ($noteId < 1)
		{
			$this->callback->setJsonCode ( 4000 ,'请选择体验师的游记');
		}
		else
		{
			//查询游记信息
			$this ->load_model('admin/a/travel_note_model' ,'travel_note_model');
			$noteData = $this ->travel_note_model ->getNoteCfgData(array('tn.id' =>$noteId ,'userid'=>$mid));
			if (empty($noteData))
			{
				$this->callback->setJsonCode ( 4000 ,'您选择的游记不存在');
			}
		}
		$startplaceid = $noteData[0]['startcity'];
		$pic = empty($postArr['pic']) ? $noteData[0]['mainpic'] : $postArr['pic'];
		return array(
				'member_id' =>$mid,
				'travel_note_id' =>$noteId,
				'pic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 9999 : $showorder,
				'startplaceid' =>$startplaceid
		);
	}

	//获取某条数据
	public function getDetailjson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->experience_model ->getExperienceDetail($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}
	//删除
	public function delExperience()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->experience_model ->delete(array('id' =>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this->cache->redis->delete('SYhomeExperience');
			$this ->log(2,3,'首页体验师配置','平台删除首页体验师');
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
}