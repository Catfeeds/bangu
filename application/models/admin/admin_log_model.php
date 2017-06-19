<?php
/**
 * 日志
 *
 * @author junhey
 * @time 2015-04-21
 */
class Admin_log_model extends CI_Model {
	/**
	 * 插入日志信息
	 * @param unknown $operate 操作类型(1,增,2删,3改,4查,5审批)
	 * @param unknown $user_type 操作人类型(实体类型)
	 * @param unknown $module 模块
	 * @param unknown $message 操作明细
	 */
	public function insert($operate,$user_type,$module, $message) {
		$dataArr = array(
				'ip' => $this->input->ip_address (),
				'addtime' => date("Y-m-d H:i:s",time()),
				'userid' => $this->session->userdata('a_user_id'),
				'operate'=>$operate,
				'user_type'=>$user_type,
				'module' => $module,
				'detail' => $message
		);
		$this->db->insert ( 'u_log', $dataArr );
		return $this->db->insert_id ();
	}


	/**
	 * 插入订单账单日志信息
	 * @param unknown $order_id 订单ID
	 * @param unknown $type 操作类型(1:应收; 2:应付; 3:保险; 4:平台佣金)
	 * @param unknown $num 人数
	 * @param unknown $amount 总价
	 * @param unknown $user_type (实体类型)
	 * @param unknown $user_id (用户登录ID)
	 * @param unknown $content (内容)
	 */
	public function write_bill_log($order_id, $type, $num, $amount, $user_type, $user_id, $content) {
		$dataArr = array(
				'order_id' => $order_id,
				'type' => $type,
				'num' => $num,
				'price'=>$amount,
				'amount'=>$amount,
				'user_type'=>$user_type,
				'user_id' => $user_id,
				'addtime' => date('Y-m-d H:i:s'),
				'remark'  => $content
		);
		$this->db->insert ( 'u_order_bill_log', $dataArr );
		return $this->db->insert_id ();
	}



	/**
	 * 读取日志列表
	 *
	 * @param array $whereArr
	 * @param number $num
	 * @param number $page
	 */
	public function log_list($whereArr, $page = 1, $num = 10) {
		if ($page <= 0) $page = 1;
		$offset = ($page - 1) * $num;
		$this->db->where ( $whereArr );
		$this->db->order_by ( 'time', 'desc' );
		$query = $this->db->get ( 'u_log', $num, $offset );
		return $query->result ();
	}
}
