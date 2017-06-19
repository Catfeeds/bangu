<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年5月7日14:46:53
* @author		jiakairong
* @method 		预定页广告
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Banner extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'b_cfg_banner_model', 'banner_model' );
	}
	
	public function index()
	{
		$dataArr = array(
				'banner' =>$this ->banner_model ->getLastData()
		);
		$this->view ( 'admin/a/cfg/banner' ,$dataArr);
	}

	public function getBannerData()
	{
		$dataArr = array(
				'data' =>$this ->banner_model ->getLastData(),
				'count' =>1
		);
		echo json_encode($dataArr);
	}
	
	public function add()
	{
		$url = trim($this ->input ->post('url' ,true));
		$pic = trim($this ->input ->post('pic' ,true));
		$id = intval($this ->input ->post('id'));
		if(empty($url))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写url地址');
		}
		if(empty($pic))
		{
			$this ->callback ->setJsonCode(4000 ,'请上传图片');
		}
		
		$dataArr = array(
				'pic' =>$pic,
				'url' =>$url
		);
		if ($id)
		{
			$status = $this ->banner_model ->update($dataArr ,array('id' =>$id));
		}
		else
		{
			$status = $this ->banner_model ->insert($dataArr);
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
	
	public function del()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->banner_model ->delete(array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	public function detail()
	{
		$dataArr = $this ->banner_model ->getLastData();
		if (!empty($dataArr))
		{
			echo json_encode($dataArr[0]);
		}
	}
}