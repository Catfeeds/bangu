<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月20日11:59:53
 * @author 何俊
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Finance extends UA_Controller {
	const pagesize = 10;

	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/finance_model', 'finance' );
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
	}
	//收款管理
	public function orderDetail()
	{
		$this ->load_model('dictionary_model');
		$data['dictionary'] = $this ->dictionary_model ->get_dictionary_data('DICT_ENTITY');
		$this->load_view ( 'admin/a/finance/order_detail' ,$data);
	}
	public function wwb()
	{
		$this->send_message_templet("13751174462","order_confirm","{#ORDERSN#}","2016");
	}
	/**
	 * @method 收款管理数据获取
	 * @author jiakairong
	 * @since  2015-12-21
	 */
	public function getOrderDetailJson()
	{
		$whereArr = array();
		$this ->load_model('order_detail_model');
		$status = $this ->input ->post('status');
		$nickname = trim($this ->input ->post('nickname' ,true));
		$linename = trim($this ->input ->post('linename' ,true));
		$ordersn = trim($this ->input ->post('ordersn' ,true));

		switch($status)
		{
			case 0: //新申请,确保订单的状态正确
				$orderBy = 'od.id desc';
				$whereArr['od.status='] = 0;
				//$whereArr['mo.ispay ='] = 1;
				//$whereArr['mo.status ='] = 1;
				break;
			case 1: //已通过
			case -1: //已拒绝
				$orderBy = 'od.approvetime desc';
				$whereArr['od.status='] = $status;
				break;
			default:
				echo json_encode($this ->defaultArr);exit;
				break;
		}
		if (!empty($ordersn))
		{
			$whereArr['mo.ordersn ='] = $ordersn;
		}
		if (!empty($linename))
		{
			$whereArr['mo.productname like '] = '%'.$linename.'%';
		}
		if (!empty($nickname))
		{
			$whereArr['m.nickname like '] = '%'.$nickname.'%';
		}
		$data = $this ->order_detail_model ->getOrderDetail($whereArr ,$orderBy);
		//echo $this ->db ->last_query();
		echo json_encode($data);
	}
	/**
	 * @method 获取订单付款情
	 * @author jiakairong
	 * @since  2015-12-21
	 */
	public function getOrderDetailData()
	{
		$this ->load_model('order_detail_model');
		$id = intval($this ->input ->post('id'));
		$data = $this ->order_detail_model ->getOrderDetail(array('od.id =' =>$id));
		if (!empty($data['data']))
		{
			$detailId = $data['data'][0]['id'];
			//获取图片
			$picArr = $this ->order_detail_model ->getOrderDetailPic($detailId);
			$dataArr = array(
					'detail' =>$data['data'][0],
					'picArr' =>$picArr
			);
			echo json_encode($dataArr);
		}

	}

	/**
	 * @method 平台审批通过收款
	 * @since  2015-12-21
	 * @author jiakairong
	 */
	public function through_order_detail()
	{
		//echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));exit;
		$this ->load_model('order_detail_model');
		$id = intval($this->input->post ( 'id' ));
		$refuse_reason = trim($this ->input ->post('refuse_reason' ,true));
		$invoice_entity = intval($this ->input ->post('invoice_entity'));
		$detailData = $this ->order_detail_model ->getOrderDetailStatus($id);
		if (empty($invoice_entity))
		{
			$this->callback->setJsonCode('4000' ,'请选择客单发票主体');
		}
		//var_dump($detailData);exit;
		if (empty($detailData))
		{
			$this->callback->setJsonCode ( 4000 ,'记录不存在，请确认');
		}
		$detailData = $detailData[0];
		if ($detailData['detail_status'] != 0)
		{
			$this->callback->setJsonCode ( 4000 ,'记录已处理');
		}
		if ($detailData['ispay'] == 1)
		{
			$type = 1;
		}
		elseif ($detailData['ispay'] == 2 && $detailData['diff_price'] > 0)
		{
			$type = 2;
		}
		else
		{
			$this->callback->setJsonCode ( 4000 ,'订单状态不符合');
		}
		$time = date('Y-m-d H:i:s' ,time());
		if ($type == 1)
		{
			//现在，财务确认后，直接控位
			$orderArr = array(
					'confirmtime_admin' =>$time,
					'admin_id' =>$this ->admin_id,
					'ispay' =>2,
					'status' =>4,
					'first_pay' =>$detailData['amount']
			);
		}
		else
		{
			$orderArr = array(
					'confirmtime_admin' =>$time,
					'admin_id' =>$this ->admin_id,
					'diff_price' =>0,
					'final_pay' =>$detailData['amount']
			);
		}
		$detailArr = array(
			'status' =>1,
			'approvetime' =>$time,
			'admin_id' =>$this ->admin_id,
			'refuse_reason' =>$refuse_reason,
			'invoice_entity' =>$invoice_entity
		);
		$logArr = array(
			'order_id' =>$detailData['order_id'],
			'op_type' => 3,
			'userid' =>$this ->admin_id,
			'content' =>'平台审核通过收款',
			'addtime' =>$time
		);
		$status = $this ->order_detail_model ->through_order_detail($id ,$orderArr ,$logArr ,$detailArr);

		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this->log ( 5, 3, '已收款管理', '平台通过新申请收款,记录ID:' . $id.',订单编号：'.$detailData['ordersn'].',收款金额:'.$detailData['amount']);
			if ($type == 1)
			{
				$content = "订单编号：{$detailData['ordersn']} 会员付款已确认，请及时跟进<br/>产品名称：{$detailData['productname']}<br/>订单金额：{$detailData['total_price']}元, 付款金额:{$detailData['amount']}元<br/>出发日期：{$detailData['usedate']}<br/>预定人数：大人（{$detailData['dingnum']}），小孩占位（ {$detailData['childnum']}）,小孩不占位（{$detailData['childnobednum']})，老人（{$detailData['oldnum']}）";
				$content1 = "订单编号：{$detailData['ordersn']} 您的付款平台已确认<br/>产品名称：{$detailData['productname']}<br/>订单金额：{$detailData['total_price']}元 付款金额:{$detailData['amount']}元<br/>出发日期：{$detailData['usedate']}<br/>预定人数：大人（{$detailData['dingnum']}），小孩占位（ {$detailData['childnum']}）,小孩不占位（{$detailData['childnobednum']})，老人（{$detailData['oldnum']}）";
				$this->add_message ( $content1, 0, $detailData['memberid'] ,'平台已确认收款,请您及时关注');
				$this->add_message ( $content, 1, $detailData['expert_id'] ,'平台已确认收款,请您及时跟进');
				$this->add_message ( $content, 2, $detailData['supplier_id'] ,'平台已确认收款,请您及时跟进');
				//发送短信
				$this ->load_model('common/u_sms_template_model' ,'template_model');
				$templateData = $this -> template_model ->row(array('msgtype' =>sys_constant::order_detail_through));
				$msg = str_replace("{#PRODUCTNAME#}", $detailData['productname'] ,$templateData['msg']);
				$msg = str_replace('{#NAME#}',$detailData['linkman'] ,$msg);
				$msg = str_replace("{#MONEY#}", $detailData['amount'] ,$msg);
				$this ->send_message($detailData['linkmobile'] ,$msg);
				//供应商发生短信
				$this->load_model('supplier_model');
				$suppler_arr=$this->supplier_model->row(array('id'=>$detailData['supplier_id']));
				$templateData_suppler = $this -> template_model ->row(array('msgtype' =>sys_constant::order_confirm));
				$msg = str_replace("{#ORDERSN#}", $detailData['ordersn'] ,$templateData_suppler['msg']);
				$this ->send_message($suppler_arr['link_mobile'] ,$msg);
				//管家短信提醒
				$this->load_model('expert_model');
				$expert = $this->expert_model->row(array('id'=>$detailData['expert_id']));
				$template = $this -> template_model ->row(array('msgtype' =>sys_constant::expert_order_confirm));
				$msg = str_replace("{#ORDERSN#}", $detailData['ordersn'] ,$template['msg']);
				$this ->send_message($expert['mobile'] ,$msg);
			}
			else
			{
				$content = "订单编号：{$detailData['ordersn']} 会员转团尾款已确认，请及时跟进<br/>产品名称：{$detailData['productname']}<br/>尾款金额：{$detailData['diff_price']}元,<br/>出发日期：{$detailData['usedate']}<br/>预定人数：大人（{$detailData['dingnum']}），小孩占位（ {$detailData['childnum']}）,小孩不占位（{$detailData['childnobednum']})，老人（{$detailData['oldnum']}）";
				$content1 = "订单编号：{$detailData['ordersn']} 您的转团尾款平台已确认<br/>产品名称：{$detailData['productname']}<br/>尾款金额：{$detailData['diff_price']}元 <br/>出发日期：{$detailData['usedate']}<br/>预定人数：大人（{$detailData['dingnum']}），小孩占位（ {$detailData['childnum']}）,小孩不占位（{$detailData['childnobednum']})，老人（{$detailData['oldnum']}）";
				$this->add_message ( $content1, 0, $detailData['memberid'] ,'平台已确认收款,请您及时关注');
				$this->add_message ( $content, 1, $detailData['expert_id'] ,'平台已确认收款,请您及时跟进');
				$this->add_message ( $content, 2, $detailData['supplier_id'] ,'平台已确认收款,请您及时跟进');
				//发送短信
				$this ->load_model('common/u_sms_template_model' ,'template_model');
				$templateData = $this -> template_model ->row(array('msgtype' =>'order_detail_diff_member'));
				$msg = str_replace("{#PRODUCTNAME#}", $detailData['productname'] ,$templateData['msg']);
				$msg = str_replace('{#NAME#}',$detailData['linkman'] ,$msg);
				$msg = str_replace("{#MONEY#}", $detailData['amount'] ,$msg);
				$this ->send_message($detailData['linkmobile'] ,$msg);
				//供应商发生短信
				$this->load_model('supplier_model');
				$suppler_arr=$this->supplier_model->row(array('id'=>$detailData['supplier_id']));
				$templateData_suppler = $this -> template_model ->row(array('msgtype' =>'order_detail_diff_supplier'));
				$msg = str_replace("{#ORDERSN#}", $detailData['ordersn'] ,$templateData_suppler['msg']);
				$msg = str_replace("{#MONEY#}", $detailData['amount'] ,$msg);
				$this ->send_message($suppler_arr['link_mobile'] ,$msg);
				//管家短信提醒
				$this->load_model('expert_model');
				$expert = $this->expert_model->row(array('id'=>$detailData['expert_id']));
				$template = $this -> template_model ->row(array('msgtype' =>'order_detail_diff_expert'));
				$msg = str_replace("{#ORDERSN#}", $detailData['ordersn'] ,$template['msg']);
				$msg = str_replace("{#MONEY#}", $detailData['amount'] ,$msg);
				$this ->send_message($expert['mobile'] ,$msg);
			}
		}
	}
	/**
	 * @method 平台拒绝收款
	 * @author 贾开荣
	 * @since  2015-06-12
	 */
	public function refuse_order_detail()
	{
		$id = intval($this->input->post ( 'id' ));
		$refuse_reason = trim($this->input->post ( 'refuse_reason' ,true)); //拒绝原因
		$this ->load_model('order_detail_model');
		$id = intval($this->input->post ( 'id' ));
		$refuse_reason = trim($this ->input ->post('refuse_reason' ,true));
		if (empty($refuse_reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写审批意见');
		}
		$detailData = $this ->order_detail_model ->getOrderDetailStatus($id);
		if (empty($detailData))
		{
			$this->callback->setJsonCode ( 4000 ,'记录不存在，请确认');
		}
		$detailData = $detailData[0];
		if ($detailData['detail_status'] != 0)
		{
			$this->callback->setJsonCode ( 4000 ,'记录已处理');
		}
		if ($detailData['ispay'] == 1)
		{
			$type = 1;
		}
		elseif ($detailData['ispay'] == 2 && $detailData['diff_price'] > 0)
		{
			$type = 2;
		}
		else
		{
			$this->callback->setJsonCode ( 4000 ,'订单状态不符合');
		}
		$time = date('Y-m-d H:i:s' ,time());
		if ($type == 1)
		{
			$orderArr = array(
					'admin_id' =>$this ->admin_id,
					'ispay' =>0
			);
		}
		else
		{
			$orderArr = array(
					'admin_id' =>$this ->admin_id,
					'final_pay' =>0
			);
		}

		$detailArr = array(
				'status' =>-1,
				'approvetime' =>$time,
				'admin_id' =>$this ->admin_id,
				'refuse_reason' =>$refuse_reason
		);
		$logArr = array(
				'order_id' =>$detailData['order_id'],
				'op_type' => 3,
				'userid' =>$this ->admin_id,
				'content' =>'平台审核拒绝收款,原因:'.$refuse_reason,
				'addtime' =>$time
		);
		$status = $this ->order_detail_model ->through_order_detail($id ,$orderArr ,$logArr ,$detailArr);
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this->log ( 5, 3, '已收款管理', '平台拒绝新申请收款,记录ID:' . $id.',订单编号：'.$detailData['ordersn'].',收款金额:'.$detailData['amount']);
			if ($type == 1)
			{
				$content = "订单编号：{$detailData['ordersn']} 会员付款已拒绝，请及时跟进<br/>产品名称：{$detailData['productname']}<br/>订单金额：{$detailData['total_price']}元 付款金额:{$detailData['amount']}元<br/>出发日期：{$detailData['usedate']}预定人数：{$detailData['dingnum']}大 {$detailData['childnum']}小";
				$content1 = "订单编号：{$detailData['ordersn']} 您的付款平台已拒绝，如有疑问请联系管家或客服<br/>产品名称：{$detailData['productname']}<br/>订单金额：{$detailData['total_price']}元 付款金额:{$detailData['amount']}元<br/>出发日期：{$detailData['usedate']}预定人数：{$detailData['dingnum']}大 {$detailData['childnum']}小";
				$this->add_message ( $content1, 0, $detailData['memberid'] ,'平台拒绝收款,请您及时关注');
				$this->add_message ( $content, 1, $detailData['expert_id'] ,'平台拒绝收款,请您及时跟进');
				$this->add_message ( $content, 2, $detailData['supplier_id'] ,'平台拒绝收款,请您及时跟进');
				//发送短信
				$this ->load_model('common/u_sms_template_model' ,'template_model');
				$templateData = $this -> template_model ->row(array('msgtype' =>sys_constant::order_detail_refuse));
				$msg = str_replace("{#PRODUCTNAME#}", $detailData['productname'] ,$templateData['msg']);
				$msg = str_replace('{#NAME#}',$detailData['linkman'] ,$msg);
				$this ->send_message($detailData['linkmobile'] ,$msg);
			}
			else
			{
				$content = "订单编号：{$detailData['ordersn']} 会员转团尾款已拒绝，请及时跟进<br/>产品名称：{$detailData['productname']}<br/>尾款金额：{$detailData['diff_price']}元 <br/>出发日期：{$detailData['usedate']}预定人数：{$detailData['dingnum']}大 {$detailData['childnum']}小";
				$content1 = "订单编号：{$detailData['ordersn']} 您的转团尾款平台已拒绝，如有疑问请联系管家或客服<br/>产品名称：{$detailData['productname']}<br/>尾款金额：{$detailData['diff_price']}元 <br/>出发日期：{$detailData['usedate']}预定人数：{$detailData['dingnum']}大 {$detailData['childnum']}小";
				$this->add_message ( $content1, 0, $detailData['memberid'] ,'平台拒绝收款,请您及时关注');
				$this->add_message ( $content, 1, $detailData['expert_id'] ,'平台拒绝收款,请您及时跟进');
				$this->add_message ( $content, 2, $detailData['supplier_id'] ,'平台拒绝收款,请您及时跟进');
				//发送短信
				$this ->load_model('common/u_sms_template_model' ,'template_model');
				$templateData = $this -> template_model ->row(array('msgtype' =>'order_refuse_diff_member'));
				$msg = str_replace("{#PRODUCTNAME#}", $detailData['productname'] ,$templateData['msg']);
				$msg = str_replace('{#NAME#}',$detailData['linkman'] ,$msg);
				$msg = str_replace('{#REASON#}',$refuse_reason ,$msg);
				$this ->send_message($detailData['linkmobile'] ,$msg);
				//管家短信提醒
				$this->load_model('expert_model');
				$expert = $this->expert_model->row(array('id'=>$detailData['expert_id']));
				$template = $this -> template_model ->row(array('msgtype' =>'order_refuse_diff_expert'));
				$msg = str_replace("{#ORDERSN#}", $detailData['ordersn'] ,$template['msg']);
				$this ->send_message($expert['mobile'] ,$msg);
			}
		}

	}
	/**
	 * @method 退款审批
	 * @author jiakairong
	 * @since  2015-12-22
	 */
	public function refund()
	{
		$this->load_view ( 'admin/a/finance/refund');
	}
	/**
	 * @method 退款审批数据获取
	 * @author jiakairong
	 * @since  2015-12-22
	 */
	public function getRefundJson()
	{
		$whereArr = array();
		$this->load_model ( 'admin/a/refund_model', 'refund_model' );
		$status = intval ( $this->input->post ( 'status' ) );
		$nickname = trim($this ->input ->post('nickname' ,true));
		$ordersn = trim($this ->input ->post('ordersn' ,true));
		$linename = trim($this ->input ->post('linename' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		switch ($status)
		{
			case 0 : //申请中
				$whereArr['r.status ='] = 0;
				//$whereArr['mo.status ='] = -3;
				//$whereArr['mo.ispay ='] = 3;
				$orderBy = 'r.id desc';
				break;
			case 1 : //已通过
			case 2 : //已拒绝
				$whereArr['r.status ='] = $status;
				$orderBy = 'r.modtime desc';
				break;
			default :
				echo json_encode($this ->defaultArr);exit;
				break;
		}
		if (! empty ( $nickname ))
		{
			$whereArr['m.nickname like'] = '%'.$nickname.'%';
		}
		if (! empty ( $ordersn ))
		{
			$whereArr['mo.ordersn ='] = $ordersn;
		}
		if (! empty ( $linename ))
		{
			$whereArr['mo.productname like '] = '%'.$linename.'%';
		}
		if (!empty($starttime))
		{
			$whereArr['r.addtime >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['r.addtime <='] = $endtime.' 23:59:59';
		}
		$data = $this ->refund_model ->getRefundData($whereArr ,$orderBy);
		echo json_encode($data);
	}
	/**
	 * @method 通过退款申请
	 * @author jiakairong
	 * @since  205-12-22
	 */
	public function through_refund()
	{
		//echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));exit;
		$this ->load_model('admin/a/refund_model' ,'refund_model');
		$this ->load_model('common/u_sms_template_model' ,'template_model');
		$id = intval ($this ->input ->post('id'));
		$money = round($this->input->post ('money'),2);
		$beizhu = trim($this->input->post ( 'beizhu', true ));
		if(empty($beizhu))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写备注');
		}
		$refundData = $this ->refund_model ->getRefundOrder($id);
		if (empty($refundData))
		{
			$this->callback->setJsonCode ( 4000 ,'退款申请不存在');
		}
		$refundData = $refundData[0];
		$time = date('Y-m-d H:i:s' ,time());
		//获取申请者id
		$ids_data=$this->db->query("select order_id from u_refund where id={$id}")->row_array();
		$param=array('order_id'=>$ids_data['order_id']);
		$id_data=$this->db->query("select memberid from u_member_order where id={$ids_data['order_id']}")->row_array();
		if ($refundData['refund_status'] == 1) //转团退差价
		{
			$this->db->trans_start();
			$refundArr = array(
					'status' => 1,
					'beizhu' => $beizhu,
					'admin_id' => $this ->admin_id,
					'modtime' => $time,
					'is_remit' => 1,
					'amount' =>$money
			);
			$this ->db ->where(array('id' =>$id)) ->update('u_refund',$refundArr);
			$this ->db ->where(array('id' =>$refundData['order_id'])) -> update('u_member_order',array('diff_price' =>0));

			$this->db->trans_complete();
			$status = $this->db->trans_status();
			if ($status == false)
			{
				$this->callback->setJsonCode ( 4000 ,'操作失败');
			}
			else
			{
				$insertArr=array(
						's_title'=>'退款成功',
						's_content'=>'您的订单退款成功，资金将会在1-3个工作日内原路退回！',
						'from'=>3, //1、帮游管家 2、帮游直播 3、帮游产品 4、积分中心
						's_time'=>time(),
						's_type'=>6,
						'link_param'=>json_encode($param),
						'mid'=>$id_data['memberid']
				);
				$this->db->insert('u_system_notify',$insertArr);//系统通知记录
				echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
				$this->log ( 5, 3, '退款管理', '平台通过退款申请,记录ID:' . $id.',订单号：'.$refundData['ordersn'].',退款金额：'.$money );
				$templateData = $this -> template_model ->row(array('msgtype' =>'refund_message'));
				$msg = str_replace('{#ORDERSN#}', $refundData['ordersn'] ,$templateData['msg']);
				$msg = str_replace('{#MONEY#}', $money ,$msg);
				$msg = str_replace('{#DAYS#}', $refundData['usedate'] ,$msg);
				$this ->send_message($refundData['linkmobile'] ,$msg);
			}
		}
		else
		{
			if ($refundData['status'] != 0 || $refundData['order_status'] != -3 || $refundData['ispay'] != 3)
			{
				$this->callback->setJsonCode ( 4000 ,'此申请已处理或订单状态不符合');
			}
			$absMoney = $money - $refundData['money'];
			if ($absMoney > 0.0001 ) {
				$this->callback->setJsonCode ( 4000 ,'退款金额不可大于支付金额');
			}
			$orderArr = array(
					'status' =>-4,
					'ispay' =>4,
					'admin_id' =>$this ->admin_id
			);
			$logArr = array(
					'order_id' =>$refundData['order_id'],
					'op_type' =>3,
					'userid' =>$this ->admin_id,
					'content' =>'平台通过退款申请,退款金额：'.$money,
					'addtime' =>$time
			);
			$refundArr = array(
					'status' => 1,
					'beizhu' => $beizhu,
					'admin_id' => $this ->admin_id,
					'modtime' => $time,
					'is_remit' => 1,
					'amount' =>$money
			);

			$status = $this ->refund_model ->throughApplyRefund($refundData ,$orderArr ,$logArr ,$refundArr ,$id);
			if($status == false)
			{
				$this->callback->setJsonCode ( 4000 ,'操作失败');
			}
			else
			{
				$insertArr=array(
						's_title'=>'退款成功',
						's_content'=>'您的订单退款成功，资金将会在1-3个工作日内原路退回！',
						'from'=>3, //1、帮游管家 2、帮游直播 3、帮游产品 4、积分中心
						's_time'=>time(),
						's_type'=>6,
						'link_param'=>json_encode($param),
						'mid'=>$id_data['memberid']
				);
				$this->db->insert('u_system_notify',$insertArr);//系统通知记录
				echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
				$this->log ( 5, 3, '退款管理', '平台通过退款申请,记录ID:' . $id.',订单号：'.$refundData['ordersn'].',退款金额：'.$money );
				//发送短信

				$templateData = $this -> template_model ->row(array('msgtype' =>sys_constant::order_refund_through));
				$msg = str_replace("{#PRODUCTNAME#}", $refundData['productname'] ,$templateData['msg']);
				$msg = str_replace("{#MONEY#}", $money ,$msg);
				$msg = str_replace("{#REFUND_REASON#}", $beizhu ,$msg);
				$this ->send_message($refundData['linkmobile'] ,$msg);
				//管家短信提醒
				$this->load_model('expert_model');
				$expert = $this->expert_model->row(array('id'=>$refundData['expert_id']));
				$template = $this -> template_model ->row(array('msgtype' =>sys_constant::order_refund_through_expert));
				$msg = str_replace("{#ORDERSN#}", $refundData['ordersn'] ,$template['msg']);
				$msg = str_replace("{#MONEY#}", $money ,$msg);
				$msg = str_replace("{#REFUND_REASON#}", $beizhu ,$msg);
				$this ->send_message($expert['mobile'] ,$msg);
			}
		}
	}

	/**
	 * @method 拒绝退款申请
	 * @author jiakairong
	 * @since  2015-12-22
	 */
	public function refund_return()
	{
		$this ->load_model('admin/a/refund_model' ,'refund_model');
		$this ->load_model('common/u_member_order_log_model' ,'order_log_model');
		$this ->load_model('common/u_sms_template_model' ,'template_model');
		$id = intval ($this ->input ->post('id'));
		$beizhu = trim($this->input->post ( 'beizhu', true ));
		if (empty($beizhu))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写拒绝原因');
		}
		$refundData = $this ->refund_model ->getRefundOrder($id);
		if (empty($refundData))
		{
			$this->callback->setJsonCode ( 4000 ,'退款申请不存在');
		}
		$refundData = $refundData[0];
		if ($refundData['refund_status'] == 1) //转团退差价
		{
			$refundArr = array(
					'status' => 2,
					'beizhu' => $beizhu,
					'admin_id' => $this ->admin_id,
					'modtime' => $time,
					'is_remit' => 2
			);
			$status = $this ->refund_model ->update($refundArr ,array('id' =>$id));
			if ($status == false)
			{
				$this->callback->setJsonCode ( 4000 ,'操作失败');
			}
			else
			{
				echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
				$this->log ( 5, 3, '退款管理', '平台拒绝退款,记录ID:' . $id.',订单号：'.$refundData['ordersn'] );
				$templateData = $this -> template_model ->row(array('msgtype' =>'refund_message_refuse'));
				$msg = str_replace('{#ORDERSN#}', $refundData['ordersn'] ,$templateData['msg']);
				$msg = str_replace('{#REASON#}', $beizhu ,$msg);
				$this ->send_message($refundData['linkmobile'] ,$msg);
			}
		}
		else
		{
			if ($refundData['status'] != 0 || $refundData['order_status'] != -3 || $refundData['ispay'] != 3)
			{
				$this->callback->setJsonCode ( 4000 ,'此申请已处理或订单状态不符合');
			}
			//获取最后一条订单日志
			$orderLogData = $this ->order_log_model ->row(array('order_id' =>$refundData['order_id']),'arr' ,'id desc' ,'order_status,order_id');
			if (empty($orderLogData) || ($orderLogData['order_status'] != 1 && $orderLogData['order_status'] != 4)) {
				$order_status = 1;
			} else {
				$order_status = $orderLogData['order_status'];
			}
			$time = date('Y-m-d H:i:s' ,time());
			$orderArr = array(
					'status' =>$order_status,
					'ispay' =>2,
					'admin_id' =>$this ->admin_id
			);
			$logArr = array(
					'order_id' =>$refundData['order_id'],
					'op_type' =>3,
					'userid' =>$this ->admin_id,
					'content' =>'平台拒绝退款',
					'addtime' =>$time
			);
			$refundArr = array(
					'status' => 2,
					'beizhu' => $beizhu,
					'admin_id' => $this ->admin_id,
					'modtime' => $time,
					'is_remit' => 2
			);

			$status = $this ->refund_model ->refuseApplyRefund($orderArr ,$logArr ,$refundArr ,$id);
			if ($status == false)
			{
				$this->callback->setJsonCode ( 4000 ,'操作失败');
			}
			else
			{
				echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
				$this->log ( 5, 3, '退款管理', '平台拒绝退款,记录ID:' . $id.',订单号：'.$refundData['ordersn'] );

				$templateData = $this -> template_model ->row(array('msgtype' =>sys_constant::order_refund_refuse));
				$msg = str_replace("{#PRODUCTNAME#}", $refundData['productname'] ,$templateData['msg']);
				$this ->send_message($refundData['linkmobile'] ,$msg);
				//管家短信提醒
				$this->load_model('expert_model');
				$expert = $this->expert_model->row(array('id'=>$refundData['expert_id']));
				$template = $this -> template_model ->row(array('msgtype' =>sys_constant::order_refund_refuse_expert));
				$msg = str_replace("{#ORDERSN#}", $refundData['ordersn'] ,$template['msg']);
				$this ->send_message($expert['mobile'] ,$msg);
			}
		}
	}
	/**
	 * @method 新增退款选择订单
	 * @author jiakairong
	 * @since  2015-12-23
	 */
	public function getOrderChoiceData() {
		$this ->load_model('admin/a/order_model' ,'order_model');
		$whereArr = array(
				'mo.status >=' => 1,
				'mo.status <=' => 4,
				'mo.ispay =' =>2
		);
	//	$page_new = intval($this ->input ->post('page'));
	//	$page_new = empty($page_new) ? 1 : $page_new;
		$ordersn = trim($this ->input ->post('choice_ordersn' ,true));
		$supplier_name = trim($this ->input ->post('choice_supplier' ,true));
		$productname = trim($this ->input ->post('choice_linename' ,true));

		if (!empty($ordersn)) {
			$whereArr ['mo.ordersn ='] = $ordersn;
		}
		if (!empty($supplier_name)) {
			$whereArr ['mo.supplier_name like'] = "%{$supplier_name}%";
		}
		if (!empty($productname)) {
			$whereArr ['mo.productname like'] = "%{$productname}%";
		}
		$data = $this ->order_model ->getOrderRefundData($whereArr);
		echo json_encode($data);exit;
// 		$data['list'] = $data['data'];
// 		unset($data['data']);
// 		$data ['page_string'] = $this ->getAjaxPage($page_new ,$data['count']);
// 		//echo $this ->db ->last_query();exit;
// 		echo json_encode ( $data );
	}
	/**
	 * @method 新增退款
	 * @author 贾开荣
	 */
	public function add_refund() {
		$this ->load_model('admin/a/order_model' ,'order_model');
		$this ->load_model('common/u_order_detail_model' ,'detail_model');
		$this ->load_model('admin/a/refund_model' ,'refund_model');
		$order_id = intval ($this ->input ->post('order_id')); //订单ID
		$reason = $this->input->post ( 'reason', true );
		$money = round($this->input->post ( 'money') ,2);
		if (empty($reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写理由');
		}
		$orderData = $this ->order_model ->getOrderRefundData(array('mo.id =' =>$order_id));
		if (empty($orderData))
		{
			$this->callback->setJsonCode ( 4000 ,'订单不存在');
		}
		$orderData = $orderData['data'][0];
		if ($orderData['status'] >4 || $orderData['ispay'] != 2)
		{
			$this->callback->setJsonCode ( 4000 ,'订单状态不符合，不可操作');
		}
		if ($money <= 0)
		{
			$this->callback->setJsonCode ( 4000 ,'请填写退款金额');
		}
		$absMoeny = $money - $orderData['first_pay'] - $orderData['final_pay'];
		if ($absMoeny > 0.0001)
		{
			$this->callback->setJsonCode ( 4000 ,'退款金额不可大于支付金额');
		}
		$time = date('Y-m-d H:i:s' ,time());
		$orderArr = array(
				'status' =>-3,
				'canceltime' =>$time,
				'ispay' =>3
			);
		$logArr = array(
				'order_id' =>$order_id,
				'op_type' =>3,
				'userid' =>$this ->admin_id,
				'content' =>'平台新增退款',
				'addtime' =>$time,
				'order_status' =>$orderData['status']
		);
		//查询订单付款表信息
		$detailData = $this ->detail_model ->row(array('order_id' =>$id) ,'arr' ,'' ,'bankname,bankcard');
		$refundArr = array(
				'refund_type' =>3,
				'order_id' =>$order_id,
				'refund_id' =>$this ->admin_id,
				'reason' =>$reason,
				'amount_apply' =>$money,
				'mobile' =>$orderData['linkmobile'],
				'is_remit' =>0,
				'status' =>0,
				'addtime' =>$time,
				'bankname' =>$detailData['bankname'],
				'bankcard' =>$detailData['bankcard']
		);
		$status = $this ->refund_model ->addRefund($orderArr ,$logArr ,$refundArr);
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3,3,'订单管理','平台新增退款，订单ID：'.$order_id.',申请退款金额:'.$money);
			//发送短信
			$this ->load_model('common/u_sms_template_model' ,'template_model');
			$templateData = $this -> template_model ->row(array('msgtype' =>sys_constant::admin_refund));
			$content = str_replace("{#PRODUCTNAME#}", $orderData['productname'] ,$templateData['msg']);
			$this ->send_message($orderData['linkmobile'] ,$content);
		}
	}

	/**
	 * [expert_month_account 专家未结算数据]
	 *
	 * @author 汪晓烽
	 */
	public function expert_month_account($page = 1) {
		$post_arr = array(); // 查询条件数组
		$this->load->library ( 'Page' );
		$config['base_url'] = '/admin/a/finance/expert_month_account/';
		$config['pagesize'] = 10;
		$config['page_now'] = $this->uri->segment ( 5, 0 );
		$post_arr = $this->get_search_condition ( $this->uri->segment ( 5 ), $this->is_post_mode (), '1' );
		$config['pagecount'] = count ( $this->finance->expert_month_account_list ( $post_arr, 0, $config['pagesize'], 0 ) );
		$expert_month_account_list = $this->finance->expert_month_account_list ( $post_arr, $page, $config['pagesize'], 0 );
		$this->page->initialize ( $config );
		$data = array(
				'expert_month_account_list' => $expert_month_account_list,
				'search_name' => $this->session->userdata ( 'search_name' ),
				'operator' => $this->session->userdata ( 'operator' ),
				'create_date' => $this->session->userdata ( 'create_date' )
		);
		$this->load_view ( 'admin/a/ui/finance/expert_month_account', $data );
	}

	/**
	 * 专家已结算
	 *
	 * @author 汪晓烽
	 */
	public function expert_month_account_Settled($page = 1) {
		$post_arr = array(); // 查询条件数组
		$this->load->library ( 'Page' );
		$config['base_url'] = '/admin/a/finance/expert_month_account_Settled/';
		$config['pagesize'] = 10;
		$config['page_now'] = $this->uri->segment ( 5, 0 );
		$post_arr = $this->get_search_condition ( $this->uri->segment ( 5 ), $this->is_post_mode (), '1' );
		$config['pagecount'] = count ( $this->finance->expert_month_account_list ( $post_arr, 0, $config['pagesize'], 1 ) );
		$expert_month_account_list = $this->finance->expert_month_account_list ( $post_arr, $page, $config['pagesize'], 1 );
		$this->page->initialize ( $config );
		$data = array(
				'expert_month_account_list' => $expert_month_account_list,
				'search_name' => $this->session->userdata ( 'search_name' ),
				'operator' => $this->session->userdata ( 'operator' ),
				'create_date' => $this->session->userdata ( 'create_date' )
		);
		$this->load_view ( 'admin/a/ui/finance/expert_month_account_1', $data );
	}

	/**
	 * 结算订单明细
	 *
	 * @author 汪晓烽
	 */
	function show_month_detail() {
		$account_month_id = $this->input->get ( 'id' );
		$starttime = $this->input->get ( 'starttime' );
		$endtime = $this->input->get ( 'endtime' );
		$addtime = $this->input->get ( 'addtime' );
		$expert = $this->input->get ( 'expert' );
		$beizhu = $this->input->get ( 'beizhu' );
		$creator = $this->finance->get_creator ($account_month_id);
		$sum_price = $this->finance->get_sum_price ($account_month_id);
		//$detail_list = $this->finance->get_detail_info ( $account_month_id );
		//$edit_list = $this->finance->get_edit_record ( $account_month_id );
		$data = array(
				'account_month_id' => $account_month_id,
				'starttime' => $starttime,
				'endtime' => $endtime,
				'addtime' => $addtime,
				'expert' => $expert,
				'creator' => $creator,
				'beizhu' => $beizhu,
				'sum_price' => $sum_price
				//'edit_list'=>$edit_list
		);
		$this->load_view( 'admin/a/ui/finance/new_month_detail',$data);
	}

	//获取已选订单
	public function get_order_list() {
		$account_month_id = $this->input->post( 'account_month_id' );
		$page_new = intval($this ->input ->post('page_new'));
		$data ['list']=$detail_list = $this->finance->get_detail_info ( $account_month_id );
		//echo json_encode($this->db->last_query());exit();
		$count = $this ->getCountNumber($this ->db ->last_query());
		$data['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}

	//获取修改记录
	public function get_edit_list() {
		$account_month_id = $this->input->post( 'account_month_id');
		$page_new = intval($this ->input ->post('page_new'));
		$data ['list']=$this->finance->get_edit_record($account_month_id);
		$count = $this ->getCountNumber($this ->db ->last_query());
		$data['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}

	function get_account_remark(){
		$account_id = $this->input->post( 'account_id');
		$remark = $this->finance->get_account_remark($account_id);
		echo json_encode($remark);
	}

	function edit_account_remark(){
		$account_id = $this->input->post( 'account_order_id');
		$month_account_id = $this->input->post( 'month_account_id');
		$beizhu = $this->input->post( 'beizhu');
		$sql = "UPDATE u_month_account_order SET remark='{$beizhu}' WHERE id={$account_id}";
		$status = $this->db->query($sql);
		if($status){
			$update_arr = array(
				'modtime'=>date('Y-m-d H:i:s'),
				'admin_id'=>$this->session->userdata('a_user_id')
				);
			$this->db->update('u_month_account',$update_arr,array('id'=>$month_account_id));
			echo json_encode(array('code'=>2000,'msg'=>'修改成功'));
		}else{
			echo json_encode(array('code'=>4000,'msg'=>'没有完成修改'));
		}
	}

	/**
	 * 供应商未结算
	 *
	 * @author 汪晓烽
	 */
	public function supplier_month_account($page = 1) {
		$post_arr = array(); // 查询条件数组
		$this->load->library ( 'Page' );
		$config['base_url'] = '/admin/a/finance/supplier_month_account/';
		$config['pagesize'] = 10;
		$config['page_now'] = $this->uri->segment ( 5, 0 );
		$post_arr = $this->get_search_condition ( $this->uri->segment ( 5 ), $this->is_post_mode (), '2' );
		$config['pagecount'] = count ( $this->finance->supplier_month_account_list ( $post_arr, 0, $config['pagesize'], 0 ) );
		$supplier_month_account_list = $this->finance->supplier_month_account_list ( $post_arr, $page, $config['pagesize'], 0 );
		$this->page->initialize ( $config );
		$data = array(
				'supplier_month_account_list' => $supplier_month_account_list,
				'search_name' => $this->session->userdata ( 'search_name' ),
				'operator' => $this->session->userdata ( 'operator' ),
				'create_date' => $this->session->userdata ( 'create_date' ),
				'supplier_brand' => $this->session->userdata ( 'supplier_brand' )
		);
		$this->load_view ( 'admin/a/ui/finance/supplier_month_account', $data );
	}

	/**
	 * 供应商已结算
	 *
	 * @author 汪晓烽
	 */
	public function supplier_month_account_Settled($page = 1) {
		$post_arr = array(); // 查询条件数组
		$this->load->library ( 'Page' );
		$config['base_url'] = '/admin/a/finance/supplier_month_account_Settled/';
		$config['pagesize'] = 10;
		$config['page_now'] = $this->uri->segment ( 5, 0 );
		$post_arr = $this->get_search_condition ( $this->uri->segment ( 5 ), $this->is_post_mode (), '2' ); // 组装搜索条件
		$config['pagecount'] = count ( $this->finance->supplier_month_account_list ( $post_arr, 0, $config['pagesize'], 1 ) );
		$supplier_month_account_list = $this->finance->supplier_month_account_list ( $post_arr, $page, $config['pagesize'], 1 );
		$this->page->initialize ( $config );
		$data = array(
				'supplier_month_account_list' => $supplier_month_account_list,
				'search_name' => $this->session->userdata ( 'search_name' ),
				'operator' => $this->session->userdata ( 'operator' ),
				'create_date' => $this->session->userdata ( 'create_date' ),
				'supplier_brand' => $this->session->userdata ( 'supplier_brand' )
		);
		$this->load->view ( 'admin/a/common/head' );
		$this->load_view ( 'admin/a/ui/finance/supplier_month_account_1', $data );
	}

	/**
	 * 新增供应商结算单
	 *
	 * @author 汪晓烽
	 */
	function show_supplier_add_order() {
		$post_arr = array();
		$create_time = date ( 'Y-m-d H:i:s' );
		$creator = $this->session->userdata ( 'a_username' );
		$supplier = $this->finance->get_supplier ();

		$data = array(
				'create_time' => $create_time,
				'creator' => $creator,
				'supplier' => $supplier
		);
		$this->load->view ( 'admin/a/common/head' );
		$this->load->view ( 'admin/a/ui/finance/show_supplier_add_order', $data );
	}

	//获取供应商的银行信息
	function show_supplier_bank_info(){
		$supplier_id = $this->input->post('supplier_id');
		$this->load->model ( 'admin/b1/bank_model', 'bank_model');
		$supplier_bank = $this ->bank_model ->row(array('supplier_id' =>$supplier_id));
		echo json_encode($supplier_bank);
	}

	/**
	 * 专家新增结算单
	 *
	 * @author 汪晓烽
	 */
	function show_expert_add_order() {
		$post_arr = array();
		$create_time = date ( 'Y-m-d H:i:s' );
		$creator = $this->session->userdata ( 'a_username' );
		$expert = $this->finance->get_expert ();

		$data = array(
				'create_time' => $create_time,
				'creator' => $creator,
				'expert' => $expert
		);
		$this->load->view ( 'admin/a/common/head' );
		$this->load->view ( 'admin/a/ui/finance/show_expert_add_order', $data );
	}

	/**
	 * 获取专家的银行信息
	 *
	 * @author 汪晓烽
	 */
	function show_expert_bank_info() {
		$expert_id = $this->input->post('expert_id');
		$this ->load_model ('admin/a/expert_model' ,'expert_model');
		$expert = $this ->expert_model ->row(array('id' =>$expert_id));
		echo json_encode($expert);
	}

	/**
	 * 在新增加为结算订单的时候,页面跳转到供应商未结算订单的页面
	 *
	 * @author 汪晓烽
	 */
	function show_supplier_unsettled_order() {
		$post_arr = array();
		$supplierId = $this->input->get ( 'supplierId' );
		$start_time = $this->input->get ( 'start_time' );
		$end_time = $this->input->get ( 'end_time' );
		$beizhu = $this->input->get ( 'beizhu' );
		$data = array(

				'supplierId' => $supplierId,
				'start_time' => $start_time,
				'end_time' => $end_time,
				'beizhu' => $beizhu
		);
		$this->load->view ( 'admin/a/common/head' );
		$this->load->view ( 'admin/a/ui/finance/supplier_unsettled_order', $data );
	}

	/**
	 * 这是一个接口,在新增加为结算订单的时候,通过ajax分页获取供应商的未结算的订单数据
	 *
	 * @author 汪晓烽
	 */
	function get_supplier_unsettled_order() {
		$post_arr = array();
		$supplierId = $this->input->post ( 'supplier_Id' );
		$number = $this->input->post ( 'pageSize', true );
		$page = $this->input->post ( 'pageNum', true );
		$order_status = $this->input->post ( 'order_status', true );
		if ($this->input->post ( 'productname' ) != '') {
			$post_arr['mo.productname like'] = '%' . $this->input->post ( 'productname' ) . '%';
		}
		if ($this->input->post ( 'start_time' ) != '') {
			$start_date = $this->input->post ('start_time');
			$end_date= $this->input->post ('end_time');
		    if(empty($end_date)){
		    	$end_date =date('Y-m-d');
		    }
			$post_arr['mo.usedate >='] = $start_date . ' 00:00:00';
			$post_arr['mo.usedate <='] = $end_date . ' 23:59:59';
		}
		if ($this->input->post ( 'ordersn' ) != '') {
			$post_arr['mo.ordersn'] = $this->input->post ( 'ordersn' );
		}
		$number = empty ( $number ) ? 5 : $number;
		$page = empty ( $page ) ? 1 : $page;
		$pagecount = count ( $this->finance->supplier_unsettled_order ( $post_arr, 0, $number, $supplierId,array(), $order_status) );
		$order_list = $this->finance->supplier_unsettled_order ( $post_arr, $page, $number, $supplierId,array(), $order_status);

		/**
		 * 计算总共的页数
		 */
		if (($total = $pagecount - $pagecount % $number) / $number == 0) {
			$total = 1;
		} else {
			$total = ($pagecount - $pagecount % $number) / $number;
			if ($pagecount % $number > 0) {
				$total += 1;
			}
		}
		$data = array(
				"totalRecords" => $pagecount,
				"totalPages" => $total,
				"pageNum" => $page,
				"pageSize" => $number,
				"rows" => $order_list,
				'SQL'=>$this->db->last_query()
		);
		echo json_encode ( $data );
	}

	/**
	 * 专家未结算订单的时候,只做页面跳转到未结算订单的页面
	 *
	 * @author 汪晓烽
	 */
	function show_expert_unsettled_order() {
		$post_arr = array();
		$expertId = $this->input->get ( 'expertId' );
		$start_time = $this->input->get ( 'start_time' );
		$end_time = $this->input->get ( 'end_time' );
		$beizhu = $this->input->get ( 'beizhu' );
		$data = array(
				'expertId' => $expertId,
				'start_time' => $start_time,
				'end_time' => $end_time,
				'beizhu' => $beizhu
		);
		$this->load->view ( 'admin/a/common/head' );
		$this->load->view ( 'admin/a/ui/finance/expert_unsettled_order', $data );
	}

	/**
	 * 通过ajax 获取专家未结算订单数据的接口
	 *
	 * @author 汪晓烽
	 */
	function get_expert_unsettled_order() {
		$post_arr = array();
		$expertId = $this->input->post ( 'expert_Id' );
		$number = $this->input->post ( 'pageSize', true );
		$page = $this->input->post ( 'pageNum', true );
		if ($this->input->post ( 'productname' ) != '') {
			$post_arr['mo.productname like'] = '%' . $this->input->post ( 'productname' ) . '%';
		}
		if ($this->input->post ( 'start_time' ) != '') {
			$start_date = $this->input->post ('start_time');
			$end_date= $this->input->post ('end_time');
			if(empty($end_date)){
				$end_date =date('Y-m-d');
			}
			$post_arr['mo.usedate >='] = $start_date . ' 00:00:00';
			$post_arr['mo.usedate <='] = $end_date . ' 23:59:59';
		}
		if ($this->input->post ( 'ordersn' ) != '') {
			$post_arr['mo.ordersn'] = $this->input->post ( 'ordersn' );
		}
		$number = empty ( $number ) ? 5 : $number;
		$page = empty ( $page ) ? 1 : $page;
		$pagecount = $this->finance->expert_unsettled_order ( $post_arr, 0, $number, $expertId) ;
		$order_list = $this->finance->expert_unsettled_order ( $post_arr, $page, $number, $expertId );
		if (($total = $pagecount - $pagecount % $number) / $number == 0) {
			$total = 1;
		} else {
			$total = ($pagecount - $pagecount % $number) / $number;
			if ($pagecount % $number > 0) {
				$total += 1;
			}
		}
		$data = array(
				"totalRecords" => $pagecount,
				"totalPages" => $total,
				"pageNum" => $page,
				"pageSize" => $number,
				'rows' => $order_list
		);
		echo json_encode ( $data );
	}

	/**
	 * 增加供应商还未结算的订单数据到数据库
	 *
	 * @author 汪晓烽
	 */
	function add_supplier_order() {

		$order_ids = $this->input->post ( 'order_ids' );
		$order_ids = rtrim ($order_ids, "," );
		$order_ids_arr = explode ( ',',  $order_ids);
		if(empty($order_ids)){
			echo json_encode(array('code'=>-200,'msg'=>"你还没有选择需要结算的订单"));
			exit();
		}

		$starttime = $this->input->post ( 'start_time' );
		$endtime = $this->input->post ( 'end_time' );
		$supplier_id = $this->input->post ( 'supplier_id' );
		$beizhu = $this->input->post ( 'beizhu' );
		$order_status = $this->input->post('order_status');

		$bank_name  = $this->input->post ( 'bank_name' );
		$brand 		= $this->input->post ( 'brand' );
		$bank_num 	= $this->input->post ( 'bank_num' );
		$openman 	= $this->input->post ( 'openman' );

		$this->load->model ( 'admin/b1/bank_model', 'bank_model');


		$this->db->trans_begin();

		$bank_info = array('bank'=>$bank_num,'bankname'=>$bank_name,'openman'=>$openman,'brand'=>$brand);
		$supplier_bank_info = $this->bank_model->row(array('supplier_id' => $supplier_id));
		if(!empty($supplier_bank_info)){
			$this->bank_model->update(array('bank'=>$bank_num,'bankname'=>$bank_name,'openman'=>$openman,'brand'=>$brand,'modtime'=>date('Y-m-d H:i:s')),array(
				'supplier_id' => $supplier_id));
		}else{
			$this->bank_model->insert(array('supplier_id'=>$supplier_id,'bank'=>$bank_num,'bankname'=>$bank_name,'openman'=>$openman,'brand'=>$brand,'modtime'=>date('Y-m-d H:i:s'),'addtime'=>date('Y-m-d H:i:s')));
		}


		$res = $this->finance->add_supplier_order ($this->admin_id,$supplier_id, $starttime, $endtime, $beizhu, $order_ids_arr, $order_status,$bank_info );
		$this->db->query("UPDATE u_member_order SET balance_status=1 WHERE id IN($order_ids)");
		if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array('code'=>200,'msg'=>'Success'));
				exit();
			}else{
				$this->db->trans_rollback();
				echo json_encode(array("code"=>-3,"msg"=>"操作失败"));
			}
	}

	/**
	 * 增加专家还未结算的订单数据到数据库
	 *
	 * @author 汪晓烽
	 */
	function add_expert_order() {
		$this ->load_model ('admin/a/expert_model' ,'expert_model');

		$order_ids = $this->input->post ( 'order_ids' );
		$order_ids_arr = explode ( ',', rtrim ($order_ids, "," ) );
		if(empty($order_ids)){
			echo json_encode(array('code'=>-200,'msg'=>"你还没有选择需要结算的订单"));
			exit();
		}
		$starttime = $this->input->post ( 'start_time' );
		$endtime = $this->input->post ( 'end_time' );
		$expert_id = $this->input->post ( 'expert_id' );
		$beizhu = $this->input->post ( 'beizhu' );

		$bank_name  = $this->input->post ( 'bank_name' );
		$brand 		= $this->input->post ( 'brand' );
		$bank_num 	= $this->input->post ( 'bank_num' );
		$openman 	= $this->input->post ( 'openman' );

		$bank_info = array('bank'=>$bank_num,'bankname'=>$bank_name,'openman'=>$openman,'brand'=>$brand);

		$expert_info = $this->expert_model->update(array('bankcard'=>$bank_num,'bankname'=>$bank_name,'cardholder'=>$openman,'branch'=>$brand),array(
				'id' => $expert_id));

		$res = $this->finance->add_expert_order ($this->admin_id,$expert_id, $starttime, $endtime, $beizhu, $order_ids_arr, $bank_info );
		if($res){
			echo json_encode(array('code'=>200,'msg'=>'Success'));
			exit();
		}else{
			echo json_encode(array('code'=>-200,'msg'=>'Fail'));
			exit();
		}

	}

	/**
	 * Ajax刷新显示供应商选中的订单数据
	 *
	 * @author 汪晓烽
	 */
	function show_supplier_ajax_order() {
		$post_arr = array();
		$order_ids = explode ( ',', rtrim ( $this->input->post ( 'order_ids' ), "," ) );
		$supplierId = $this->input->post ( 'supplier_id' );
		$order_status = $this->input->post ( 'order_status' );
		$order_list = $this->finance->supplier_unsettled_order ( $post_arr, 0, 5, $supplierId, $order_ids, $order_status );
		echo json_encode ( $order_list );
	}

	/**
	 * Ajax刷新页面显示专家选中的订单列表数据
	 *
	 * @author 汪晓烽
	 */
	function show_expert_ajax_order() {
		$post_arr = array();
		$order_ids = explode ( ',', rtrim ( $this->input->post ( 'order_ids' ), "," ) );
		$expertId = $this->input->post ( 'expert_id' );
		$order_list = $this->finance->expert_unsettled_order ( $post_arr, 1, 5, $expertId, $order_ids );
		echo json_encode ( $order_list );
	}

	/**
	 * Ajax修改结算单状态为已结算,并且扣款
	 * $user_type=1代表专家(b2),$user_type=2代表供应商(b1)
	 *
	 * @author 汪晓烽
	 */
	function ajax_pass() {
		$month_id = $this->input->post ( 'mounth_id' );
		$user_id = $this->input->post ( 'userid' );
		$real_amount = $this->input->post ( 'real_amount' );
		$user_type = $this->input->post ( 'user_type' );
		$admin_id=$this->admin_id;
		$order_id_res = $this->db->query("SELECT GROUP_CONCAT(order_id) AS orderid_str FROM u_month_account_order WHERE month_account_id={$month_id}")->result_array();
		$orderids_str = $order_id_res[0]['orderid_str'];


		if ($user_type == 1) {
			$update_amount_sql = "update u_expert set amount=amount+{$real_amount},beizhu='已结算' where id=" . $user_id;
		} else {
			$update_amount_sql = "update u_supplier set amount=amount+{$real_amount},beizhu='已结算' where id=" . $user_id;
		}
		$this->db->trans_begin();
		$this->db->query ( $update_amount_sql );
		$sql = "update u_month_account set status=1,beizhu='已结算',admin_id=$admin_id where id=" . $month_id;
		$this->db->query ( $sql );
		$settle_sql = "UPDATE u_member_order SET balance_status=2 WHERE id IN($orderids_str)";
		$this->db->query ( $settle_sql );
		if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array('code'=>200,'msg'=>'Success'));
				exit();
		}else{
				$this->db->trans_rollback();
				echo json_encode(array("code"=>-3,"msg"=>"操作失败"));
		}
	}

	/**
	 * Ajax修改结算单状态为未结算,并且扣款
	 *
	 * @author 汪晓烽
	 */
	function ajax_cancle() {
		$month_id = $this->input->post ( 'mounth_id' );
		$user_id = $this->input->post ( 'userid' );
		$real_amount = $this->input->post ( 'real_amount' );
		$user_type = $this->input->post ( 'user_type' );
		$order_id_res = $this->db->query("SELECT GROUP_CONCAT(order_id) AS orderid_str FROM u_month_account_order WHERE month_account_id={$month_id}")->result_array();
		$orderids_str = $order_id_res[0]['orderid_str'];
		if ($user_type == 1) {
			$update_amount_sql = "update u_expert set amount=amount-{$real_amount} where id=" . $user_id;
		} else {
			$update_amount_sql = "update u_supplier set amount=amount-{$real_amount} where id=" . $user_id;
		}
		$this->db->trans_begin();
		$this->db->query ( $update_amount_sql );
		$sql = "update u_month_account set status=0,beizhu='未结算' where id=" . $month_id;
		$this->db->query ( $sql );
		$settle_sql = "UPDATE u_member_order SET balance_status=0 WHERE id IN($orderids_str)";
		$this->db->query ( $settle_sql );
		if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array('code'=>200,'msg'=>'Success'));
				exit();
		}else{
				$this->db->trans_rollback();
				echo json_encode(array("code"=>-3,"msg"=>"操作失败"));
				exit();
		}

	}

	/**
	 * [ajax_edit_amount 修改结算金额]
	 * @return [type] [description]
	 */
	function ajax_edit_amount(){
		//u_month_account_update_record
		$insert_log_arr = array();
		$postArr = $this->security->xss_clean($_POST);
		if(!is_numeric($postArr['newAmount'])){
			echo json_encode(array("code"=>-2,"msg"=>"结算金额只能是数字"));
			exit();
		}
		if($postArr['newAmount']==$postArr['oldAmount']){
			echo json_encode(array("code"=>-3,"msg"=>"你没有修改结算金额"));
			exit();
		}
		$sql = "update u_month_account set real_amount={$postArr['newAmount']} where id=".$postArr['account_id'];
		$status = $this->db->query ( $sql );
		if($status){
			$insert_log_arr['admin_id'] = $this->session->userdata('a_user_id');
			$insert_log_arr['month_account_id'] = $postArr['account_id'];
			$insert_log_arr['before_amount'] = $postArr['oldAmount'];
			$insert_log_arr['after_amount'] = $postArr['newAmount'];
			$insert_log_arr['addtime'] = date('Y-m-d H:i:s');
			$insert_log_arr['remark'] = $postArr['edit_reason'];
			$res = $this->db->insert('u_month_account_update_record',$insert_log_arr);
			if($res){
				echo json_encode(array("code"=>200,"msg"=>"修改成功"));
				exit();
			}else{
				echo json_encode(array("code"=>-4,"msg"=>"操作失败"));
				exit();
			}
		}else{
			echo json_encode(array("code"=>-4,"msg"=>"操作失败"));
			exit();
		}
	}

	/**
	 * 获取并且组装搜索条件
	 * $type=1是专家,$type=2是供应商
	 *
	 * @author 汪晓烽
	 */
	function get_search_condition($uri_segment_5, $is_post_model, $type) {
		$post_arr = array();
		if ($uri_segment_5 != '') {

			if ($this->session->userdata ( 'search_name' ) != '') {
				if ($type == '1') {
					$post_arr['ex.realname LIKE'] = '%' . $this->session->userdata ( 'search_name' ) . '%';
				} else {
					$post_arr['sup.company_name LIKE'] = '%' . $this->session->userdata ( 'search_name' ) . '%';
				}
			}
			if ($this->session->userdata ( 'operator' ) != '') {
				$post_arr['ad.realname LIKE'] = '%' . $this->session->userdata ( 'operator' ) . '%';
			}
			if ($this->session->userdata ( 'supplier_brand' ) != '') {
				$post_arr['sup.brand LIKE'] = '%' . $this->session->userdata ( 'supplier_brand' ) . '%';
			}
			if ($this->session->userdata ( 'create_date' ) != '') {
				$adddate_arr = explode ( ' - ', $this->session->userdata ( 'create_date' ) );
				$start_date_arr = explode ( '-', $adddate_arr[0] );
				$start_date = $start_date_arr[0] . '-' . $start_date_arr[2] . '-' . $start_date_arr[1];
				$end_date_arr = explode ( '-', $adddate_arr[1] );
				$end_date = $end_date_arr[0] . '-' . $end_date_arr[2] . '-' . $end_date_arr[1];
				$post_arr['ZJJS.addtime >='] = $start_date . ' 00:00:00';
				$post_arr['ZJJS.addtime <='] = $end_date . ' 23:59:59';
			}
		} else {
			if ($type == '1') {
				unset ( $post_arr['ex.realname LIKE'] );
			} else {
				unset ( $post_arr['sup.company_name LIKE'] );
			}
			$this->session->unset_userdata ( 'search_name' );
			unset ( $post_arr['ad.realname LIKE'] );
			$this->session->unset_userdata ( 'operator' );
			unset ( $post_arr['ZJJS.addtime >='] );
			unset ( $post_arr['ZJJS.addtime <='] );
			$this->session->unset_userdata ( 'create_date' );
			$this->session->unset_userdata ( 'supplier_brand' );
		}
		if ($is_post_model) {

			if ($this->input->post ( 'search_name' ) != '') {
				if ($type == '1') {
					$post_arr['ex.realname LIKE'] = '%' . $this->input->post ( 'search_name' ) . '%';
				} else {
					$post_arr['sup.company_name LIKE'] = '%' . $this->input->post ( 'search_name' ) . '%';
				}
				$this->session->set_userdata ( array(
						'search_name' => $this->input->post ( 'search_name' )
				) );
			} else {
				if ($type == '1') {
					unset ( $post_arr['ex.realname LIKE'] );
				} else {
					unset ( $post_arr['sup.company_name LIKE'] );
				}
				$this->session->unset_userdata ( 'search_name' );
			}

			if ($this->input->post ( 'operator' ) != '') {
				$post_arr['ad.realname LIKE'] = '%' . $this->input->post ( 'operator' ) . '%';
				// $post_arr['det.kindname'] = $this->input->post('destination');
				$this->session->set_userdata ( array(
						'operator' => $this->input->post ( 'operator' )
				) );
			} else {
				unset ( $post_arr['ad.realname LIKE'] );
				$this->session->unset_userdata ( 'operator' );
			}

			if ($this->input->post ( 'supplier_brand' ) != '') {
				$post_arr['sup.brand LIKE'] = '%' . $this->input->post ( 'supplier_brand' ) . '%';
				$this->session->set_userdata ( array(
						'supplier_brand' => $this->input->post ( 'supplier_brand' )
				) );
			} else {
				unset ( $post_arr['sup.brand LIKE'] );
				$this->session->unset_userdata ( 'supplier_brand' );
			}

			if ($this->input->post ( 'create_date' ) != '') {
				$adddate_arr = explode ( ' - ', $this->input->post ( 'create_date' ) );
				$start_date_arr = explode ( '-', $adddate_arr[0] );
				$start_date = $start_date_arr[0] . '-' . $start_date_arr[2] . '-' . $start_date_arr[1];
				$end_date_arr = explode ( '-', $adddate_arr[1] );
				$end_date = $end_date_arr[0] . '-' . $end_date_arr[2] . '-' . $end_date_arr[1];
				$post_arr['ZJJS.addtime >='] = $start_date . ' 00:00:00';
				$post_arr['ZJJS.addtime <='] = $end_date . ' 23:59:59';
				$this->session->set_userdata ( array(
						'create_date' => $this->input->post ( 'create_date' )
				) );
			} else {
				unset ( $post_arr['ZJJS.addtime >='] );
				unset ( $post_arr['ZJJS.addtime <='] );
				$this->session->unset_userdata ( 'create_date' );
			}
		}
		return $post_arr;
	}

}