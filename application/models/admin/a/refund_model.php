<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Refund_model extends MY_Model {
	private $table_refund = "u_refund";
	
	/**
	 * @method 退款数据获取
	 * @author jiakairong
	 * @since  2015-12-22
	 * @param unknown $whereArr
	 */
	public function getRefundData(array $whereArr ,$orderBy = 'r.id desc')
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.' "'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select r.*,mo.ordersn,mo.productname as linename,(mo.first_pay+mo.final_pay) as total_price,mo.supplier_name,mo.expert_name,m.nickname,a.username,group_concat(s.cityname) as cityname  from u_refund as r left join u_member_order as mo on mo.id=r.order_id left join u_member as m on m.mid=mo.memberid left join u_line as l on l.id=mo.productautoid left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as s on s.id=ls.startplace_id left join u_admin as a on a.id=r.admin_id '.$whereStr.' group by r.id ';
		
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by '.$orderBy.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 平台通过退款申请
	 * @author jiakairong
	 * @since  2015-12-22
	 */
	public function throughApplyRefund($refundDetail ,$orderArr ,$logArr ,$refundArr ,$refundId)
	{
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->db->trans_start();
		//更改订单状态
		$this ->db ->where(array('id' =>$logArr['order_id']));
		$this ->db ->update('u_member_order' ,$orderArr);
		$this->order_status_model->update_order_status_cal($logArr['order_id']);
		//写订单日志
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//积分返还
		if ($refundDetail['jifen'] > 0)
		{
			$sql = 'select jifen from u_member where mid ='.$refundDetail['memberid'];
			$memberData = $this ->db ->query($sql)->result_array();
			//更改用于积分
			$sql = 'update u_member set jifen = jifen +'.$refundDetail['jifen'].' where mid='.$refundDetail['memberid'];
			$this ->db  ->query($sql);
			//会员积分日志
			$pointArr = array(
				'member_id' =>$refundDetail['memberid'],
				'point_before' =>$memberData[0]['jifen'],
				'point_after' =>round($refundDetail['jifen'] + $memberData[0]['jifen']),
				'point' =>$refundDetail['jifen'],
				'content' =>'通过退款申请，退回积分',
				'addtime' =>$logArr['addtime']
			);
			$status = $this ->db ->insert('u_member_point_log' ,$pointArr);
		}
		//给线路的余位增加回去
		$sql = 'update u_line_suit_price set number= number+'.$refundDetail['number'].' where suitid='.$refundDetail['suitid'].' and day="'.$refundDetail['usedate'].'"';
		$status = $this ->db ->query($sql);
		//更改退款表
		$this ->db ->where(array('id' =>$refundId));
		$this ->db ->update('u_refund' ,$refundArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 平台拒绝退款申请
	 * @author jiakairong
	 * @since  2015-12-22
	 */
	public function refuseApplyRefund($orderArr ,$logArr ,$refundArr ,$refundId)
	{
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->db->trans_start();
		//更改订单状态
		$this ->db ->where(array('id' =>$logArr['order_id']));
		$this ->db ->update('u_member_order' ,$orderArr);
		$this->order_status_model->update_order_status_cal($logArr['order_id']);
		//写订单日志
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//更改退款表
		$this ->db ->where(array('id' =>$refundId));
		$this ->db ->update('u_refund' ,$refundArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 平台新增退款
	 * @author jiakairong
	 * @since  2015-12-23
	 */
	public function addRefund($orderArr ,$logArr ,$refundArr)
	{
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->db->trans_start();
		//更改订单状态
		$this ->db ->where(array('id' =>$logArr['order_id']));
		$this ->db ->update('u_member_order' ,$orderArr);
		$this->order_status_model->update_order_status_cal($logArr['order_id']);
		//写订单日志
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//写入退款表
		$this ->db ->insert('u_refund' ,$refundArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 获取退款数据的信息
	 * @author jiakairong
	 * @since  2015-12-22
	 */
	public function getRefundOrder($refund_id)
	{
		$sql = 'select r.*,mo.status as order_status,mo.ispay,mo.expert_id,mo.linkmobile,mo.productname,mo.ordersn,mo.jifen,(mo.first_pay+mo.final_pay ) as money,mo.memberid,mo.usedate,mo.suitid,(mo.dingnum+mo.childnum+mo.oldnum) as number from u_refund as r left join u_member_order as mo on mo.id=r.order_id where r.id='.$refund_id;
		return $this ->db ->query($sql)->result_array();
	}
}
