<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-05-24
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Gift extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('live/live_gift_model','giftModel');
	}
	
	public function index()
	{
		$this ->view('admin/a/live/gift');
	}
	//礼物数据
	public function getGiftJson()
	{
		$whereArr = array('status >' =>0);
		$name = trim($this ->input ->post('name' ,true));
		if (!empty($name))
		{
			$whereArr['like'] = array('gift_name' =>'%'.$name.'%');
		}
		$data = $this ->giftModel ->getGiftData($whereArr);
		//var_dump($this ->giftModel ->db ->queries);
		$count = $this ->giftModel ->getCiftCount($whereArr);
		echo json_encode(array('data' =>$data ,'count' =>$count['count']));
	}

	//添加礼物
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr);
		$id = $this ->giftModel ->insert($dataArr);
		if ($id > 0) 
		{
			$this ->callback ->setJsonCode('2000' ,'添加成功');
		}
		else
		{
			$this ->callback ->setJsonCode('4000' ,'添加失败');
		}
 	}
 	//编辑礼物
 	public function edit()
 	{
 		$postArr = $this->security->xss_clean($_POST);
 		$id = intval($postArr['id']);
 		$dataArr = $this ->commonFunc($postArr);
 		$status = $this ->giftModel ->update($dataArr ,array('gift_id' =>$id));
 		if ($status > 0)
 		{
 			$this ->callback ->setJsonCode('2000' ,'编辑成功');
 		}
 		else
 		{
 			$this ->callback ->setJsonCode('4000' ,'编辑失败');
 		}
 	}
 	//添加编辑公用部分
 	public function commonFunc($postArr)
 	{
 		$name = trim($postArr['name']);
 		$worth = intval($postArr['worth']);
 		$pic = trim($postArr['pic']);
 		$style = intval($postArr['style']);
 		$showorder = intval($postArr['showorder']);
 		$status = intval($postArr['status']);
 		$unit = trim($postArr['unit'] ,true);
 		if (empty($name))
 		{
 			$this ->callback ->setJsonCode(4000 ,'请填写礼物名称');
 		}
 		if ($worth < 1)
 		{
 			$this ->callback ->setJsonCode(4000 ,'请填写礼物价值');
 		}
 		if (empty($unit))
 		{
 			$this ->callback ->setJsonCode(4000 ,'请填写礼物的单位');
 		}
 		if (empty($pic))
 		{
 			$this ->callback ->setJsonCode(4000 ,'请填上传礼物图标');
 		}
//  		if (empty($style))
//  		{
//  			$this ->callback ->setJsonCode(4000 ,'请填选择动画效果');
//  		}
		return array(
				'gift_name' =>$name,
				'worth' =>$worth,
				'pic' =>$pic,
				'style' =>$style,
				'status' =>$status,
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'unit' =>$unit
		);
 	}
	//删除
	public function del()
	{
		$id = intval($this->input->post('id'));
		$status = $this ->giftModel ->update(array('status' =>0) ,array('gift_id' =>$id));
	//	var_dump($this ->giftModel ->db ->queries);
		if ($status == false)
		{
			$this ->callback ->setJsonCode('4000' ,'删除失败');
		}
		else
		{
			//$this ->log(2,3,'礼物管理','平台删除礼物,记录ID:'.$id);
			$this ->callback ->setJsonCode ( '2000' ,'删除成功');
		}
	}
	//获取某条详情
	public function getDetailJson()
	{
		$id = intval($this->input->post('id'));
		$data = $this ->giftModel ->getGiftDetail($id);
		echo json_encode($data);
	}
}