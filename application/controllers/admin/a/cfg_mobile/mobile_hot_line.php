<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		手机端热门线路
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_hot_line extends UA_Controller
{
	public $controllerName = '手机端热门线路';
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/mobile_hot_line_model','hot_line_model');
	}
	public function index()
	{
		$this->view ( 'admin/a/cfg_mobile/mobile_hot_line_list');
	}
	public function getMHotLineData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$stime = trim($this ->input ->post('stime' ,true));
		$etime = trim($this ->input ->post('etime' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($name))
		{
			$whereArr ['l.linename like'] = '%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr ['hl.startplaceid ='] = $city;
		}
		elseif(!empty($province))
		{
			$whereArr['s.pid ='] = $province;
		}
		if (!empty($stime))
		{
			$whereArr ['hl.starttime >'] = $stime; 
		}
		if (!empty($etime))
		{
			$whereArr ['hl.endtime <'] = $etime.' 23:59:59';
		}
		$data = $this ->hot_line_model ->getMHotLineData($whereArr);
		echo json_encode($data);
	}
	//增加
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->hot_line_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this ->log(1,3,'手机端热门线路','增加手机端热门线路');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->hot_line_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'手机端热门线路','编辑手机端热门线路');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$cityId = empty($postArr['city']) ? 0 : intval($postArr['city']);
		$destType = intval($postArr['dest']);
		$showorder = intval($postArr['showorder']);
		$lineId = intval($postArr['lineId']);
		$linename = trim($postArr['linename']);
		if (empty($cityId))
		{
			$this->callback->setJsonCode('4000' ,'请选择始发地城市');
		}
		if (empty($destType))
		{
			$this->callback->setJsonCode('4000' ,'请选择目的地');
		}
		if (empty($lineId))
		{
			$this->callback->setJsonCode ( '4000' ,'请选择线路');
		}
		if (empty($postArr['starttime']) || empty($postArr['endtime']))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择开始或结束时间');
		}
		else
		{
			if ($postArr['starttime'] >= $postArr['endtime'])
			{
				$this->callback->setJsonCode ( 4000 ,'结束时间要大于开始时间');
			}
		}
		if ($type == 'add')
		{
			$dataArr = $this ->hot_line_model ->row(array('line_id' =>$lineId ,'startplaceid' =>$cityId));
		}
		else
		{
			$dataArr = $this ->hot_line_model ->row(array('line_id'=>$lineId,'startplaceid' =>$cityId ,'id !='=>intval($postArr['id']) ));
		}
		if (!empty($dataArr))
		{
			$this->callback->setJsonCode ( 4000 ,'此线路已是手机端热门线路，请重新选择');
		}
		$this ->load_model('common/u_line_model' ,'line_model');
		$lineData = $this ->line_model ->row(array('id'=>$lineId) ,'arr' ,'' ,'mainpic');
		$pic = empty($postArr['pic']) ? $lineData['mainpic'] : $postArr['pic'];
		return array(
				'line_id ' =>$lineId,
				'pic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'startplaceid' =>$cityId,
				'endtime' =>$postArr['endtime'],
				'starttime' =>$postArr['starttime'],
				'dest_type' =>$destType
		);
	}
	
	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->hot_line_model ->getHotLineDetail($id);
		if (!empty($data)) {
			echo json_encode($data[0]);
		}
	}

	//删除
	public function delHotLine()
	{
		$id = intval($this->input->post("id"));
		$status = $this ->hot_line_model ->delete(array('id'=>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"删除失败");
			$this->callback->exit_json();
		} 
		else {
			$this ->log(2,3,'手机端热门线路','平台删除手机端热门线路');
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}
	}
}