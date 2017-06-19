<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @method 线路属性管理
 * @since 2016-01-19
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Attr extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/a/line_attr_model', 'attr_model' );
	}
	public function index()
	{
		$this->load_view ( 'admin/a/line/attr');
	}
	//目的地数据
	public function getAttrJson()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$attrid = intval($this ->input ->post('attrid'));
		$pid = intval($this ->input ->post('pid'));
		$pid = $pid > 0 ? $pid : $attrid;
		if ($pid > 0)
		{
			$whereArr['pid'] = $pid;
		}
		if (!empty($name))
		{
			$whereArr['a.attrname like '] = '%'.$name.'%';
		}
		$data = $this ->attr_model ->getLineAttrData($whereArr);
		echo json_encode($data);
	}
	//添加线路属性
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$attrArr = $this ->commonFunc($postArr, 'add');
		$id = $this ->attr_model ->insert($attrArr);
		if (empty($id))
		{
			$this->callback->setJsonCode(4000 ,'添加失败');
		}
		else
		{
			$this ->log(1, 3, '线路属性管理', '添加线路属性，ID：'.$id.',名称:'.$attrArr['attrname']);
			$this->callback->setJsonCode(2000 ,'添加成功');
		}
	}
	//编辑线路属性
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$attrArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->attr_model ->update($attrArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode(4000 ,'编辑失败');
		}
		else
		{
			$this ->log(3, 3, '线路属性管理', '编辑线路属性，ID：'.$postArr['id'].',名称:'.$attrArr['kindname']);
			$this->callback->setJsonCode(2000 ,'编辑成功');
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr ,$type)
	{
		$pid = intval($postArr['pid']);
		if ($pid != 0)
		{
			$parentArr = $this ->attr_model ->row(array('id' =>$pid));
			if (empty($parentArr))
			{
				$this ->callback ->setJsonCode(4000 ,'选择的上级不存在');
			}
		}
		if (empty($postArr['attrname']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写名称');
		}
		else 
		{
			if ($type == 'add') 
			{
				$attrData = $this ->attr_model ->row(array('attrname like' =>'%'.trim($postArr['attrname']).'%'));
			}
			else
			{
				$attrData = $this ->attr_model ->row(array('attrname like' =>'%'.trim($postArr['attrname']).'%' ,'id !=' =>intval($postArr['id'])));
			}
			if (!empty($attrData))
			{
				$this ->callback ->setJsonCode(4000 ,'此名称已存在');
			}
		}
		return array(
				'attrname' =>trim($postArr['attrname']),
				'isopen' =>intval($postArr['isopen']),
				'displayorder' =>empty($postArr['displayorder']) ? 999 :intval($postArr['displayorder']),
				'ishot' =>intval($postArr['ishot']),
				'description' =>trim($postArr['description']),
				'pid' =>$pid
		);
	}
	//线路属性详细
	public function getAttrDetail()
	{
		$id = intval($this->input->post ('id'));
		$attrData = $this ->attr_model ->row(array('id' =>$id));
		echo json_encode($attrData);
	}
}