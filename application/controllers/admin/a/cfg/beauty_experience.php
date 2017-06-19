<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年6月30日14:46:53
* @author		贾开荣
* @method 		最美体验师
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Beauty_experience extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/a/beauty_experience_model', 'experience_model' );
	}
	public function index()
	{
		$this ->view('admin/a/cfg/beauty_experience');
	}
	public function getExperienceData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($name))
		{
			$whereArr ['m.nickname like'] = '%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr ['be.startplaceid ='] = $city;
		}
		elseif(!empty($province))
		{
			$whereArr ['s.pid ='] = $province;
		}
		$data = $this ->experience_model ->getExperienceData($whereArr);
		echo json_encode($data);
	}
	//增加最美体验师
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->experience_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeBeautyExperience');
			$this ->log(1,3,'最美体验师配置','增加最美体验师');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑最美体验师
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->experience_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeBeautyExperience');
			$this ->log(3,3,'最美体验师配置','编辑最美体验师');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$mid = intval($postArr['member_id']);
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
				$this->callback->setJsonCode ( 4000 ,'您选择的体验师已是最美体验师，请重新选择');
			}
		}
		$this ->load_model('common/u_member_model' ,'member_model');
		$memberData = $this ->member_model ->row(array('mid' =>$postArr['member_id']) ,'arr' ,'' ,'litpic,city');
		if (empty($memberData))
		{
			$this->callback->setJsonCode ( 4000 ,'体验师对应的用户不存在');
		}
		if (empty($memberData['city']))
		{
			$this->callback->setJsonCode ( 4000 ,'此体验师没有完善所在地，不可选择');
		}
		$pic = empty($postArr['pic']) ? $memberData['litpic'] : $postArr['pic'];
		return array(
				'member_id' =>$mid,
				'pic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'startplaceid' =>$memberData['city']
		);
	}

	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->experience_model ->getExperienceDetail($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}
	//删除
	public function delBeauty()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->experience_model ->delete(array('id' =>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this->cache->redis->delete('SYhomeBeautyExperience');
			$this ->log(2,3,'最美体验师配置','平台删除最美体验师');
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
}