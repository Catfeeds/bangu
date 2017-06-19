<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 消息内容管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Content extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('msg/msg_content_model' ,'content_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/msg/content');
	}
	
	public function getContentData()
	{
		$status = intval($this ->input ->post('status'));
		$content = trim($this ->input ->post('content' ,true));
		
		$whereArr = array();
		switch($status)
		{
			case 0:
			case 1:
				$whereArr['isopen ='] = $status;
				break;
			default:
				echo json_encode($this ->defaultArr);exit;
				break;
		}
		if(!empty($content))
		{
			$whereArr['content like'] = '%'.$content.'%';
		}
		
		$data = $this ->content_model ->getMsgContentData($whereArr);
		echo json_encode($data);
	}
	
	public function upload()
	{
		$url = trim($this ->input ->post('url' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$type = intval($this ->input ->post('type'));
		$content = trim($this ->input ->post('content' ,true));
		$id = intval($this ->input->post('id'));
		
		if ($type != 1 && $type != 2 && $type != 3)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择完成后标志');
		}
		if (empty($content))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写内容');
		}
		
		$dataArr = array(
				'url' =>$url,
				'isopen' =>$isopen,
				'content' =>$content,
				'type' =>$type
		);
		if ($id > 0)
		{
			$status = $this ->content_model ->update($dataArr ,array('id' =>$id));
		}
		else 
		{
			$status = $this ->content_model ->insert($dataArr);
		}
		
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//停用消息
	public function disable()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'isopen' =>0
		);
		$status = $this ->content_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else 
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//启用消息
	public function enable()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'isopen' =>1
		);
		$status = $this ->content_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	public function uploadContent()
	{
		$id = intval($this ->input ->get('id'));
		$dataArr = array();
		if ($id > 0)
		{
			$dataArr = $this ->content_model ->row(array('id' =>$id));
		}
		$this->view ( 'admin/a/msg/upload_content' ,$dataArr);
	}
	
}