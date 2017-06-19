<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 交款管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Item_apply extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/approve/u_order_receivable_model' ,'receivable_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/item_apply');
	}
	//获取收款数据
	public function getItemApplyJson()
	{
		$whereArr = array();
		$expert_name = trim($this ->input ->post('expert_name'));
		$ordersn = trim($this ->input ->post('ordersn'));
		$voucher = trim($this ->input ->post('voucher'));
		$starttime = trim($this ->input ->post('starttime'));
		$endtime = trim($this ->input ->post('endtime'));
		$status = intval($this ->input ->post('status'));
		switch($status)
		{
			case 1:
			case 2:
			case 3:
				$whereArr['r.a_status ='] = $status;
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		
		if (!empty($expert_name))
		{
			$whereArr['e.realname like '] = '%'.$expert_name.'%';
		}
		if (!empty($ordersn))
		{
			$whereArr['r.order_sn ='] = $ordersn;
		}
		if (!empty($voucher))
		{
			$whereArr['r.voucher ='] = $voucher;
		}

		if (!empty($starttime)) {
			$whereArr['r.addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['r.addtime <='] = $endtime.' 23:59:59';
		}
		
		$whereArr['r.kind ='] =1;
		$data = $this ->receivable_model ->getReceivableData($whereArr);
		echo json_encode($data);
	}
	
	//交款详细
	public function detail()
	{
		$ids = rtrim(trim($this ->input ->get('ids')) ,',');
		if (empty($ids)) 
		{
			$this ->callback ->setJsonCode(4000 ,'参数有误');
		}
		
		$itemApply = $this ->receivable_model ->getReceivable($ids);
		
		$moneyArr = $this ->receivable_model ->getReceivableMoney($ids);
		//var_dump($itemApply);
		
		//获取转款凭证
// 		if ($itemApply[0]['a_status'] == 2)
// 		{
// 			//审核状态为2时，$ids是一个值
// 			$picData = $this ->receivable_model ->getReceivablePic($ids);
// 		}
		//var_dump($picData);
		$dataArr = array(
				'itemApply' =>$itemApply,
				'money' =>$moneyArr['money'],
				'ids' =>$ids,
// 				'picArr' =>empty($picData) ? array() : $picData
		);
		$this ->view('admin/a/union_finance/item_detail' ,$dataArr);
 		
// 		echo json_encode($itemApply);
	}
	
	//通过
	public function through() 
	{
		$ids = rtrim(trim($this ->input ->post('ids')) ,',');
		$pic = $this ->input ->post('pic' ,true);
		$remark = trim($this ->input ->post('remark' ,true));
		if (empty($pic))
		{
			$this ->callback ->setJsonCode(4000 ,'请上传转款凭证');
		}
		
		$receivableData = $this ->receivable_model ->getReceivable($ids);
		if (empty($receivableData))
		{
			$this ->callback ->setJsonCode(4000 ,'审核记录不存在');
		}
		$i = true;
		foreach($receivableData as $v)
		{
			if ($v['a_status'] !=1 || $v['status'] != 2)
			{
				$i = false;
				continue;
				
			}
		}
		if ($i === false)
		{
			$this ->callback ->setJsonCode(4000 ,'记录状态不匹配');
		}
		
		
		$dataArr = array(
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'a_remark' =>$remark
		);
		$status = $this ->receivable_model ->through($ids ,$dataArr ,$pic);
		if ($status == false) {
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		} else {
			$this ->log('3', '3', '已交款付款审批', '通过旅行社付款申请ids:'.$ids);
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
		
	}
	
	//拒绝
	public function refuse()
	{
		$ids = trim($this ->input ->post('ids'));
		$remark = trim($this ->input ->post('remark' ,true));
		if (empty($remark))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写拒绝理由');
		}
		$receivableData = $this ->receivable_model ->getReceivable($ids);
		if (empty($receivableData))
		{
			$this ->callback ->setJsonCode(4000 ,'审核记录不存在');
		}
		$i = true;
		foreach($receivableData as $v)
		{
			if ($v['a_status'] !=1 || $v['status'] != 2)
			{
				$i = false;
				continue;
				
			}
		}
		if ($i === false)
		{
			$this ->callback ->setJsonCode(4000 ,'记录状态不匹配');
		}
		
		$dataArr = array(
				'admin_id' =>$this ->admin_id,
				'admin_name' =>$this ->realname,
				'a_remark' =>$remark
		);
		$status = $this ->receivable_model ->refuse($ids ,$dataArr);
		if ($status == false) {
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		} else {
			$this ->log('3', '3', '已交款付款审批', '拒绝旅行社付款申请,ids:'.$ids);
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
}