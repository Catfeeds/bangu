<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月20日11:59:53
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Destination extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/a/destination_model', 'dest_model' );
	}
	public function index()
	{
		$this->load_view ( 'admin/a/ui/destination');
	}
	//目的地数据
	public function getDestinationJson()
	{
		$whereArr = array();
		$kindname = trim($this ->input ->post('kindname' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$country = intval($this ->input ->post('country'));
		$region = intval($this ->input ->post('region'));
		
		$destid = empty($region) ? $city : $region;
		$destid = empty($destid) ? $province : $destid;
		$destid = empty($destid) ? $country : $destid;
		if ($destid > 0)
		{
			$whereArr['pid'] = $destid;
		}
		if (!empty($kindname))
		{
			$whereArr['d.kindname like '] = '%'.$kindname.'%';
		}
		$data = $this ->dest_model ->getDestinationData($whereArr);
		echo json_encode($data);
	}
	//添加目的地
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$destArr = $this ->commonFunc($postArr, 'add');
		$id = $this ->dest_model ->insert($destArr);
		if (empty($id))
		{
			$this->callback->setJsonCode(4000 ,'添加失败');
		}
		else
		{
			$destData = $this ->dest_model ->getDistination();
			unlink('./assets/js/staticState/chioceDestJson.js');
			$this ->chioceDataPlugins($destData ,'./assets/js/staticState/chioceDestJson.js' ,'chioceDestJson');
			$this ->log(1, 3, '目的地管理', '添加目的地，ID：'.$id.',名称:'.$destArr['kindname']);
			$this->callback->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑目的地
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$destArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->dest_model ->update($destArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$destData = $this ->dest_model ->getDistination();
			unlink('./assets/js/staticState/chioceDestJson.js');
			$this ->chioceDataPlugins($destData ,'./assets/js/staticState/chioceDestJson.js' ,'chioceDestJson');
			$this ->log(3, 3, '目的地管理', '编辑目的地，ID：'.$postArr['id'].',名称:'.$destArr['kindname']);
			$this->callback->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr ,$type)
	{
		$pid = empty($postArr['city']) ? $postArr['province'] : $postArr['city'];
		$pid = empty($pid) ? $postArr['country'] : $pid;
		if ($pid != 0)
		{
			$parentArr = $this ->dest_model ->row(array('id' =>$pid));
			if (empty($parentArr))
			{
				$this ->callback ->setJsonCode(4000 ,'选择的上级不存在');
			}
		}
		if (empty($postArr['kindname']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写目的地名称');
		}
		else 
		{
// 			if ($type == 'add') 
// 			{
// 				$destData = $this ->dest_model ->row(array('kindname' =>trim($postArr['kindname'])));
// 			}
// 			else
// 			{
// 				$destData = $this ->dest_model ->row(array('kindname' =>trim($postArr['kindname']) ,'id !=' =>intval($postArr['id'])));
// 			}
// 			if (!empty($destData))
// 			{
// 				$this ->callback ->setJsonCode(4000 ,'此目的地已存在');
// 			}
		}
		if (empty($postArr['enname']))
		{
			$this->callback->setJsonCode(4000 ,'请填写全拼');
		}
		if (empty($postArr['simplename']))
		{
			$this->callback->setJsonCode(4000 ,'请填写简拼');
		}
		//计算级别
		$level = $pid == 0 ? 1 : round($parentArr['level'] +1);
		return array(
				'kindname' =>trim($postArr['kindname']),
				'enname' =>trim($postArr['enname']),
				'simplename' =>trim($postArr['simplename']),
				'isopen' =>intval($postArr['isopen']),
				'displayorder' =>empty($postArr['displayorder']) ? 999 :intval($postArr['displayorder']),
				'ishot' =>intval($postArr['ishot']),
				'description' =>trim($postArr['description']),
				'pid' =>$pid,
				'level' =>$level,
				'pic' =>trim($postArr['pic'])
		);
	}
	//目的地详细
	public function getDestDetail()
	{
		$id = intval($this->input->post ('id'));
		$destData = $this ->dest_model ->row(array('id' =>$id));
		if (!empty($destData))
		{
			switch($destData['level'])
			{
				case '1':
				case '2':
					$destData['country'] = $destData['pid'];
					$destData['province'] = 0;
					break;
				case '3':
					$destArr = $this ->dest_model ->row(array('id' =>$destData['pid']));
					$destData['country'] = $destArr['pid'];
					$destData['province'] = $destData['pid'];
					break;
				case '4':
					$destArr = $this ->dest_model ->row(array('id' =>$destData['pid']));
					$destData['city'] = $destData['pid'];
					$destData['province'] = $destArr['pid'];
					$destArr = $this ->dest_model ->row(array('id' =>$destArr['pid']));
					$destData['country'] = $destArr['pid'];
					break;
			}
			echo json_encode($destData);
		}
	}
	

}