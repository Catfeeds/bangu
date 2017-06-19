<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		列表页推荐线路
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class List_line_recommend extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/line_recommend_model', 'recommend_model' );
	}
	public function index()
	{
		$this->view ( 'admin/a/cfg/list_recommend');
	}
	public function getRecommendData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		
		if (!empty($name))
		{
			$whereArr ['l.linename like'] = '%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr ['lr.startplaceid ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr ['s.pid ='] = $province;
		}
		$data = $this ->recommend_model ->getRecommendData($whereArr);
		echo json_encode($data);
	}
	//增加
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->recommend_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this ->log(1,3,'列表页推荐线路配置','增加列表页推荐线路');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->recommend_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'列表页推荐线路','编辑列表页推荐线路');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$lineId = intval($postArr['lineId']);
		$showorder = intval($postArr['showorder']);
		$city = empty($postArr['city']) ? 0 : intval($postArr['city']);
		if ($city < 1)
		{
			$this ->callback ->setJsonCode('4000' ,'请选择始发地');
		}
		if ($lineId < 1)
		{
			$this->callback->setJsonCode ( '4000' ,'请选择线路');
		}
		if ($type == 'add')
		{
			$data = $this ->recommend_model ->row(array('line_id' =>$lineId ,'startplaceid' =>$city));
		}
		else
		{
			$data = $this ->recommend_model ->row(array('line_id'=>$lineId ,'startplaceid' =>$city,'id !='=>intval($postArr['id']) ));
		}
		if (!empty($data))
		{
			$this->callback->setJsonCode ( 4000 ,'当前始发地下已有此畅销线路，请重新选择');
		}
		$this ->load_model('admin/a/line_model' ,'line_model');
		$lineData = $this ->line_model ->row(array('id'=>$lineId ,'status' =>2) ,'arr' ,'' ,'mainpic');
		if (empty($lineData))
		{
			$this->callback->setJsonCode ( 4000 ,'此线路不存在');
		}
		$pic = empty($postArr['pic']) ? $lineData['mainpic'] : $postArr['pic'];
		return  array(
				'line_id ' =>$lineId,
				'pic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'startplaceid' =>$city
			);
	}
	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->recommend_model ->getRecommendDetail($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}
	//删除特价线路
	function delHotLine()
	{
		$id = intval($this->input->post("id"));
		$status = $this ->recommend_model ->delete(array('id'=>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this ->log(2,3,'列表页推荐线路','平台删除列表页推荐线路');
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
}