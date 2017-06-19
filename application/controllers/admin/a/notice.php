<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-01-15
 * @author jiakairong
 * @method 系统消息管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Notice extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/a/notice_model' ,'notice_model');
	}
	
	public function index()
	{
		$this->load_view ( 'admin/a/ui/notice');
	}
	//系统消息数据
	public function getNoticeJson()
	{
		$whereArr = array();
		$title = trim($this ->input ->post('title' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		if (!empty($title))
		{
			$whereArr['n.title like '] = '%'.$title.'%';
		}
		if (!empty($starttime))
		{
			$whereArr['n.addtime >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['n.addtime <='] = $endtime.' 23:59:59';
		}
		
		$data = $this ->notice_model ->getNoticeData($whereArr);
		echo json_encode($data);
	}
	//添加系统消息
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$noticeArr = $this ->commonFunc($postArr);
		
		$status = $this ->notice_model ->insert($noticeArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
		else 
		{
			//若给管家发送系统消息，则向APP也推送一条消息
			if (array_search(1, $postArr['type']) !== false)
			{
				//获取所有绑定设备的管家，给所有管家发消息
				$this->load_model('expert_model');
				$this->load->library('Jpush_app');
					
				$expertData = $this->expert_model->getExpertEquipment();
				$ridArr = array();
				foreach($expertData as $v)
				{
					$ridArr[] = $v['equipment_id'];
				}
				$status = $this ->jpush_app ->push($ridArr,$postArr['content'],$postArr['title']);
				if (is_array($status))
				{
					//发送成功
				}
				else
				{
					//消息推送失败
				}
			}
			
			$this ->log(1,3,'系统消息管理','添加系统消息，标题：'.$noticeArr['title']);
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑系统消息
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$noticeArr = $this ->commonFunc($postArr);
		
		$id = intval($postArr['id']);
		$status = $this ->notice_model ->update($noticeArr ,array('id' =>$id));

		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3,3,'系统消息管理','编辑系统消息，标题：'.$noticeArr['title']);
			$this ->callback ->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr)
	{
		if (empty($postArr['title']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写标题');
		}
		if (empty($postArr['content']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写内容');
		}
		if (empty($postArr['type']))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择接收人');
		}
		
		return array(
				'title' =>trim($postArr['title']),
				'content' =>trim($postArr['content']),
				'notice_type' =>implode($postArr['type'] ,','),
				'admin_id' =>$this ->admin_id,
				'attachment' =>$postArr['attachment'],
				'addtime' =>date('Y-m-d H:i:s' ,time())
			);
	}
	//获取系统消息详情
	public function getNoticeDetail()
	{
		$id = intval($this ->input ->post('id'));
		$noticeData = $this ->notice_model ->row(array('id' =>$id));
		echo json_encode($noticeData);
	}
}