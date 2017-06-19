<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 营业部银行卡管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Depart_bank extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/b_depart_bank_model' ,'depart_bank_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union/depart_bank');
	}
	//获取银行卡数据
	public function getDepartBankJson()
	{
		$whereArr = array();
		$union_name = trim($this ->input ->post('union_name'));
		$depart_name = trim($this ->input ->post('depart_name'));
		$status = intval($this ->input ->post('status'));
		
		if ($status)
		{
			$whereArr['d.status ='] = $status;
		}
		if (!empty($union_name))
		{
			$whereArr['d.union_name like '] = '%'.$union_name.'%';
		}
		if (!empty($depart_name))
		{
			$whereArr['d.name like '] = '%'.$depart_name.'%';
		}
		$data = $this ->depart_bank_model ->getDepartBankData($whereArr);
		echo json_encode($data);
	}
	
	//更改银行卡信息
	public function update()
	{
		$depart_id = intval($this ->input ->post('depart_id'));
		$bankcard = trim($this ->input ->post('bankcard' ,true));
		$bankname = trim($this ->input ->post('bankname' ,true));
		$branch = trim($this ->input ->post('branch' ,true));
		$cardholder = trim($this ->input ->post('cardholder' ,true));
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
		$bankData = $this ->depart_bank_model ->row(array('depart_id' =>$depart_id));
		$bankArr = array(
				'bankcard' =>$bankcard,
				'bankname' =>$bankname,
				'branch' =>$branch,
				'cardholder' =>$cardholder,
				'depart_id' =>$depart_id
		);
		if (empty($bankData))
		{
			$status = $this ->depart_bank_model ->insert($bankArr);
			if ($status == true) {
				$this ->log(1, 3, '营业部银行卡管理', '新增银行卡');
			}
		}
		else 
		{
			$status = $this ->depart_bank_model ->update($bankArr ,array('id' =>$bankData['id']));
			if ($status == true) {
				$this ->log(3, 3, '营业部银行卡管理', '编辑银行卡');
			}
		}
		if ($status == true)
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
	}
	
	//营业部银行卡信息
	public function detail()
	{
		$depart_id = intval($this ->input ->post('depart_id'));
		$departData = $this ->depart_bank_model ->getDepartBankRow($depart_id);
		echo json_encode($departData);
	}
}