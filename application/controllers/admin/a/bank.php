<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2015-12-09
 * @author jiakairong
 * @method 银行卡管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Bank extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('bank_model' ,'bankModel');
	}
	
	public function index()
	{
		$this->load_view ( 'admin/a/bank');
	}
	//银行卡数据
	public function getBankJson()
	{
		$whereArr = array();
		$pageNew = intval($this ->input ->post('page_new'));
		$pageNew = empty($pageNew) ? 1 : $pageNew;
		$name = trim($this ->input ->post('name'));
		if (!empty($name))
		{
			$whereArr['name'] = $name;
		}
		$data['list'] = $this ->bankModel ->getBankData($whereArr ,$pageNew ,sys_constant::A_PAGE_SIZE);
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($pageNew ,$count);
		echo json_encode($data);
	}
	//获取详情
	public function getBankDetail()
	{
		$id = intval($this ->input ->post('id'));
		$bankData = $this ->bankModel ->row(array('id' =>$id));
		echo json_encode($bankData);
	}
	
	//添加银行卡
	public function addBank()
	{
		$postArr = $this->security->xss_clean($_POST);
		$bankArr = $this ->commonFunc($postArr ,'add');
		
		$status = $this ->bankModel ->insert($bankArr);
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'添加失败');
			$this->callback->exit_json();
		}
		else 
		{
			$this ->log(1,3,'银行卡管理','添加银行卡，名称：'.$bankArr['name']);
			$this->callback->set_code ( 2000 ,'添加成功');
			$this->callback->exit_json();
		}
	}
	//编辑银行卡
	public function editBank()
	{
		$postArr = $this->security->xss_clean($_POST);
		$bankArr = $this ->commonFunc($postArr ,'edit');
		
		$status = $this ->bankModel ->update($bankArr ,array('id' =>intval($postArr['id'])));
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'编辑失败');
			$this->callback->exit_json();
		}
		else
		{
			$this ->log(3,3,'银行卡管理','编辑银行卡，名称：'.$bankArr['name']);
			$this->callback->set_code ( 2000 ,'编辑成功');
			$this->callback->exit_json();
		}
	}
	//添加编辑公用部分
	public function commonFunc($postArr ,$type)
	{
		if (empty($postArr['name']))
		{
			$this->callback->set_code ( 4000 ,'请填写银行名称');
			$this->callback->exit_json();
		}
		else
		{
			if ($type == 'add')
			{
				$bankData = $this ->bankModel ->row(array('name' =>trim($postArr['name'])));
			}
			else 
			{
				$bankData = $this ->bankModel ->row(array('name' =>trim($postArr['name']),'id !='=>intval($postArr['id'])));
			}
			if (!empty($bankData))
			{
				$this->callback->set_code ( 4000 ,'此银行已存在');
				$this->callback->exit_json();
			}
		}
		if (empty($postArr['code']))
		{
			$this->callback->set_code ( 4000 ,'请填写标识码');
			$this->callback->exit_json();
		}
		else
		{
			if ($type == 'add')
			{
				$bankData = $this ->bankModel ->row(array('code' =>trim($postArr['code'])));
			}
			else 
			{
				$bankData = $this ->bankModel ->row(array('code' =>trim($postArr['code']),'id !='=>intval($postArr['id'])));
			}
			if (!empty($bankData))
			{
				$this->callback->set_code ( 4000 ,'此标识码已存在');
				$this->callback->exit_json();
			}
		}	
		if (empty($postArr['pic']))
		{
			$this->callback->set_code ( 4000 ,'请上传图片');
			$this->callback->exit_json();
		}
		return array(
				'name' =>trim($postArr['name']),
				'code' =>trim($postArr['code']),
				'pic' =>$postArr['pic'],
				'showorder' =>empty($postArr['showorder']) ? 99 : intval($postArr['showorder']),
				'isopen' =>intval($postArr['isopen'])
		);
	}
}