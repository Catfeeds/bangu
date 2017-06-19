<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 旅行社管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Union_bank extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('union_bank_model' ,'bank_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union/union_bank');
	}
	
	public function getUnionJson()
	{
		$whereArr = array();
		$unionId = intval($this ->input ->post('union_id'));
		
		if ($unionId > 0)
		{
			$whereArr['ub.union_id ='] = $unionId;
		}
		$data = $this ->bank_model ->getUnionBankData($whereArr);
		echo json_encode($data);
	}
	
	//编辑
	public function edit()
	{
		$bank_id = intval($this ->input ->post('bank_id'));
		$bankcard = trim($this ->input ->post('bankcard'));
		$bankname = trim($this ->input ->post('bankname'));
		$branch = trim($this ->input ->post('branch'));
		$cardholder = trim($this ->input ->post('cardholder'));
		if (empty($bankcard))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行卡号');
		}
		if (empty($bankname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行名称');
		}
		if (empty($branch))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写开户支行');
		}
		if (empty($cardholder))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写持卡人');
		}
		$bankArr = array(
				'bankcard' =>$bankcard,
				'bankname' =>$bankname,
				'branch' =>$branch,
				'cardholder' =>$cardholder,
				'admin_id' =>$this ->admin_id
		);
		$status = $this ->bank_model ->update($bankArr ,array('id' =>$bank_id));
		if ($status == true)
		{
			$this ->log(3, 3, '旅行社银行卡管理' ,'修改旅行社银行卡信息，ID:'.$bank_id);
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'修改失败');
		}
	}
	//添加银行卡信息
	public function add()
	{
		$union_id = intval($this ->input ->post('union_id'));
		$bankcard = trim($this ->input ->post('bankcard'));
		$bankname = trim($this ->input ->post('bankname'));
		$branch = trim($this ->input ->post('branch'));
		$cardholder = trim($this ->input ->post('cardholder'));
		if (empty($bankcard))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行卡号');
		}
		if (empty($bankname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行名称');
		}
		if (empty($branch))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写开户支行');
		}
		if (empty($cardholder))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写持卡人');
		}
		$bankArr = array(
				'bankcard' =>$bankcard,
				'bankname' =>$bankname,
				'branch' =>$branch,
				'cardholder' =>$cardholder,
				'admin_id' =>$this ->admin_id,
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'union_id' =>$union_id
		);
		$status = $this ->bank_model ->insert($bankArr);
		if ($status == true)
		{
			$this ->log(1, 3, '旅行社银行卡管理' ,'添加旅行社银行卡信息');
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
	}
	
	//删除银行信息
	public function delete()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->bank_model ->delete(array('id' =>$id));
		if ($status == true)
		{
			$this ->log(2, 3, '旅行社银行卡管理' ,'删除旅行社银行卡信息，ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'删除成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'删除失败');
		}
	}
	
	//银行信息
	public function getUnionBankDetail()
	{
		$id = intval($this ->input ->post('id'));
		$bankData = $this ->bank_model ->row(array('id' =>$id));
		echo json_encode($bankData);
	}
}