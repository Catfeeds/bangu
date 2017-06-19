<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年06月10日11:59:53
 * @author		贾开荣
 *
 */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_detail_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_order_detail' );
	}
	
	/**
	 * @method 获取付款详情数据，用于平台收款管理
	 * @author jiakairong
	 * @since  2015-12-21
	 * @param unknown $whereArr
	 */
	public function getOrderDetail(array $whereArr ,$orderBy='od.addtime desc')
	{
		$whereStr = '';
		foreach ($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select od.*,mo.ordersn,mo.productname as linename,mo.supplier_name,mo.expert_name,m.truename,m.nickname,a.realname as adminname,group_concat(s.cityname) as cityname,d.description  from u_order_detail as od left join u_member_order as mo on mo.id=od.order_id left join u_line as l on l.id= mo.productautoid left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as s on s.id=ls.startplace_id left join u_member as m on m.mid= mo.memberid left join u_admin as a on a.id=od.admin_id left join u_dictionary as d on d.dict_id = od.invoice_entity '.$whereStr.' group by od.id ';
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by '.$orderBy.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	
	/**
	 * @method 获取图片
	 * @param unknown $detailId
	 */
	public function getOrderDetailPic($detailId)
	{
		$sql = 'select * from u_order_detail_pic where detail_id = '.$detailId;
		return $this ->db ->query($sql) ->row_array();      // 将result_array()改为row_array
	}
	
	/**
	 * @method 获取付款信息以及订单信息，用于平台审核
	 * @author jiakairong
	 * @since  2015-12-21
	 * @param unknown $orderDetailId 付款详情ID 
	 */
	public function getOrderDetailStatus($orderDetailId)
	{
		$sql = 'select od.amount,od.order_id,od.status as detail_status,mo.total_price,mo.ordersn,mo.productname,mo.memberid,mo.expert_id,mo.supplier_id,mo.usedate,mo.dingnum,mo.childnum,mo.childnobednum,mo.oldnum,mo.status as order_status,mo.ispay,mo.linkman,mo.linkmobile,mo.diff_price from u_order_detail as od left join u_member_order as mo on od.order_id=mo.id where od.id='.$orderDetailId;
		return $this ->db ->query($sql)->result_array();
	}
	
	/**
	 * @method 平台审核通过/拒绝付款申请
	 * @author jiakairong
	 * @since  2015-12-21
	 */
	public function through_order_detail($detail_id,$orderArr,$logArr,$detailArr)
	{
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->db->trans_start();
		//更改订单表
		$this ->db ->where(array('id' =>$logArr['order_id']));
		$this ->db ->update('u_member_order' ,$orderArr);
		$this->order_status_model->update_order_status_cal($logArr['order_id']);
		//写订单日志
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//更改付款表
		$this ->db ->where(array('id' =>$detail_id));
		$this ->db ->update('u_order_detail' ,$detailArr);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}

