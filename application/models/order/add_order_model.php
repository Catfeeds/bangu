<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月23日11:59:53
 * @author		jkr
 * @method 		会员下单
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Add_order_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'u_member_order' );
	}
	
	/**
	 * @method 会员下单
	 * @param unknown $orderArr  订单信息
	 * @param unknown $traverArr  出游人信息
	 * @param unknown $insuranceArr  保险信息
	 * @param unknown $jifen  使用的积分
	 * @param intval  $member_coupon_id  用户关联优惠券的ID
	 * @param string  $username  会员名称
	 * @param array  $suitArr  套餐信息
	 * @param array  $affiliatedArr  订单附属信息
	 */
	public function addOrder($orderArr ,$traverArr ,$insuranceArr ,$jifen ,$member_coupon_id ,$username ,$suitArr,$affiliatedArr)
	{
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->db->trans_start();
		//获取订单号
		$orderArr['ordersn'] = $this ->createOrderCode();
		//写入订单
		$this ->db ->insert('u_member_order' ,$orderArr);
		$orderArr['order_id'] = $this->db->insert_id();
		$orderArr['username'] = $username;
		
		$this->order_status_model->update_order_status_cal($orderArr['order_id']);
		
		//写入订单附属表
		$affiliatedArr['order_id'] = $orderArr['order_id'];
		$status = $this ->db ->insert('u_member_order_affiliated' ,$affiliatedArr);
		
		//写入订单日志表
		$this ->insertLog($orderArr);
		
		// 写入保险账单
		$this ->insertBillBx($insuranceArr, $orderArr);
		//写入应付账单
		$this ->orderBillYf($orderArr, $suitArr);
		//写入应收账单
		$this ->orderBillYs($orderArr);
		//写入管理费账单
		$this ->insertBillYj($orderArr);
		
		//扣除线路余位
		if ($orderArr['suitnum'] > 0) {
			//套餐线路
			$num = $orderArr['suitnum'];
		} else {
			//正常线路
			$num = round($orderArr['dingnum'] + $orderArr['childnum'] + $orderArr['oldnum'] + $orderArr['childnobednum']);
		}
		$sql = 'update u_line_suit_price set number=number-'.$num.' where lineid='.$orderArr['productautoid'].' and suitid='.$orderArr['suitid'].' and day="'.$orderArr['usedate'].'"';
		$this ->db ->query($sql);
		
		//会员积分更改
		if (!empty($jifen))
		{
			$sql = 'select jifen from u_member where mid = '.$orderArr['memberid'].' for update';
			$memberData = $this ->db ->query($sql) ->result_array();
			$sql = 'update u_member set jifen = jifen -'.$jifen.' where mid = '.$orderArr['memberid'];
			$this ->db ->query($sql);
			//写入会员积分变动表
			$pointArr = array(
					'member_id' =>$orderArr['memberid'],
					'point_before' =>$memberData[0]['jifen'],
					'point_after' =>$memberData[0]['jifen'] - $jifen,
					'point' =>$jifen,
					'content' =>'下单支付积分',
					'addtime' =>$orderArr['addtime']
			);
			$this ->db ->insert('u_member_point_log' ,$pointArr);
		}
		//更改优惠券状态
		if ($member_coupon_id > 0)
		{
			$sql = 'update cou_member_coupon set status = 1 where id ='.$member_coupon_id;
			$this ->db ->query($sql);
		}

		//写入出游人表
		foreach($traverArr as $val)
		{
			$val['member_id'] = $orderArr['memberid'];
			$this ->db ->insert('u_member_traver' ,$val);
			$traverId = $this ->db ->insert_id();
			//出游人，订单关联表
			$orderManArr = array(
					'order_id' =>$orderArr['order_id'],
					'traver_id' =>$traverId
			);
			$this ->db ->insert('u_member_order_man' ,$orderManArr);
			//出游人保险表
			if (!empty($insuranceArr))
			{
				foreach($insuranceArr as $val)
				{
					$itArr = array(
							'order_id' =>$orderArr['order_id'],
							'traver_id' =>$traverId,
							'insurance_id' =>$val['insurance_id'],
							'is_down' =>0
					);
					$this ->db ->insert('u_insurance_traver' ,$itArr);
				}
			}
		}
		//写入保险表
		if (!empty($insuranceArr))
		{
			foreach($insuranceArr as &$val)
			{
				$val['order_id'] = $orderArr['order_id'];
				unset($val['name']);
				unset($val['price']);
				$this ->db ->insert('u_order_insurance' ,$val);
			}
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return $orderArr['order_id'];
		}
	}
	
	/**
	 * @method 写入保险账单，按不同的保险种类写入 
	 * @author jkr
	 */
	protected function insertBillBx($insuranceArr ,$orderArr)
	{
		foreach($insuranceArr as $val)
		{
			$bxArr = array(
					'order_id' =>$orderArr['order_id'],
					'insurance_id' =>$val['insurance_id'],
					'insurance_name' =>$val['name'],
					'belong_id' =>0,
					'num' =>$val['number'],
					'price' =>$val['price'],
					'amount' =>$val['amount'],
					'addtime' =>$orderArr['addtime']
			);
			$this ->db ->insert('u_order_bill_bx' ,$bxArr);
		}
	}
	
	/**
	 * @method 写入平台管理费账单，帮游平台的线路管理费都是按比例收取
	 * @author jkr
	 * @param array $orderArr 订单信息
	 */
	protected function insertBillYj($orderArr)
	{
		$yjArr = array(
				'order_id' =>$orderArr['order_id'],
				'expert_id' =>$orderArr['expert_id'],
				'num' =>1,
				'price' =>$orderArr['platform_fee'],
				'amount' =>$orderArr['platform_fee'],
				'status' =>2,
				'addtime' =>$orderArr['addtime'],
				'user_type' =>0,
				'user_id' =>$orderArr['memberid'],
				'user_name' =>$orderArr['username'],
				'item' =>'按比例',
				'remark' =>'订单金额：'.$orderArr['total_price'].'*收取比例'.$orderArr['agent_rate'].'='.$orderArr['platform_fee']
		);
		$this ->db ->insert('u_order_bill_yj' ,$yjArr);
	}
	
	/**
	 * @method 写入应付账单，按人群写入
	 * @author jkr
	 * @param array $orderArr 订单信息
	 * @param array $suitArr 套餐信息
	 */
	protected function orderBillYf($orderArr ,$suitArr)
	{
		//需要区分是套餐线路还是普通线路
		if ($orderArr['suitnum'] >0)
		{
			/**应付价格=售价-管家佣金*/
			$price = round($suitArr['adultprice']-$suitArr['agent_rate_int'],2);
			$remark = '下订单，套餐成本';
			$this ->insertBillYf($orderArr, $orderArr['suitnum'], $price, $remark, '套餐成本');
		}
		else
		{
			/*计算应付账单需要注意，直属管家没有佣金*/
			if ($orderArr['dingnum'] >0)
			{
				/**应付价格=售价-管家佣金*/
				if ($orderArr['agent_fee'] == 0)
				{
					$price = $suitArr['adultprice'];
				}
				else 
				{
					$price = round($suitArr['adultprice']-$suitArr['agent_rate_int'],2);
				}
				$remark = '下订单，成人成本';
				$this ->insertBillYf($orderArr, $orderArr['dingnum'], $price, $remark, '成人成本');
			}
			if ($orderArr['childnum'] >0)
			{
				/**应付价格=售价-管家佣金*/
				if ($orderArr['agent_fee'] == 0)
				{
					$price = $suitArr['childprice'];
				}
				else
				{
					$price = round($suitArr['childprice']-$suitArr['agent_rate_child'],2);
				}
				
				$remark = '下订单，儿童占床成本';
				$this ->insertBillYf($orderArr, $orderArr['childnum'], $price, $remark, '儿童占床成本');
			}
			if ($orderArr['childnobednum'] >0)
			{
				/**应付价格=售价-管家佣金*/
				if ($orderArr['agent_fee'] == 0)
				{
					$price = $suitArr['childnobedprice'];
				}
				else
				{
					$price = round($suitArr['childnobedprice']-$suitArr['agent_rate_childno'],2);
				}
				$remark = '下订单，儿童不占床成本';
				$this ->insertBillYf($orderArr, $orderArr['childnobednum'], $price, $remark, '儿童不占床成本');
			}
		}
	}
	
	/**
	 * @method 写入应付账单
	 * @param unknown $orderArr 订信息
	 * @param unknown $num 数量
	 * @param unknown $price 单价
	 * @param unknown $remark 说明
	 * @param unknown $item 项目
	 */
	protected function insertBillYf($orderArr ,$num ,$price ,$remark ,$item)
	{
		$yfArr = array(
				'order_id' =>$orderArr['order_id'],
				'expert_id' =>$orderArr['expert_id'],
				'depart_id' =>$orderArr['depart_id'],
				'num' =>$num,
				'price' =>$price,
				'amount' =>round($price * $num ,2),
				'remark' =>$remark,
				'status'=> 2,
				'addtime' =>$orderArr['addtime'],
				'm_time' =>$orderArr['addtime'],
				's_time' =>$orderArr['addtime'],
				'supplier_id' =>$orderArr['supplier_id'],
				'user_type' =>0,
				'user_id' =>$orderArr['memberid'],
				'user_name' =>$orderArr['username'],
				'item' =>$item
		);
		$this ->db ->insert('u_order_bill_yf' ,$yfArr);
	}
	
	/**
	 * @method 写入应收账单，按人群写入
	 * @author jkr
	 * @param array $orderArr 订单信息
	 */
	protected function orderBillYs($orderArr)
	{
		//需要区分是套餐线路还是普通线路
		if ($orderArr['suitnum'] >0)
		{
			$this ->insertBillYs($orderArr, $orderArr['suitnum'], $orderArr['price'], '套餐团费');
		}
		else
		{
			if ($orderArr['dingnum'] > 0)
			{
				$this ->insertBillYs($orderArr, $orderArr['dingnum'], $orderArr['price'], '成人团费');
			}
			if ($orderArr['childnum'] > 0)
			{
				$this ->insertBillYs($orderArr, $orderArr['childnum'], $orderArr['childprice'], '儿童占床团费');
			}
			if ($orderArr['childnobednum'] > 0)
			{
				$this ->insertBillYs($orderArr, $orderArr['childnobednum'], $orderArr['childnobedprice'], '儿童不占床团费');
			}
		}
	}
	
	/**
	 * @method 写入应收账单
	 * @param unknown $orderArr 订信息
	 * @param unknown $num 数量
	 * @param unknown $price 单价
	 * @param unknown $item 项目
	 */
	protected function insertBillYs($orderArr ,$num ,$price ,$item)
	{
		$amount = round($num * $price,2);
		$ysArr = array(
				'order_id' =>$orderArr['order_id'],
				'expert_id' =>$orderArr['expert_id'],
				'num' =>$num,
				'price' =>$price,
				'amount' =>$amount,
				'remark' =>'单价：'.$price.' * 数量：'.$num.'='.$amount,
				'status'=> 1,
				'addtime' =>$orderArr['addtime'],
				'item' =>$item,
				'user_name' =>$orderArr['username']
		);
		$this ->db ->insert('u_order_bill_ys' ,$ysArr);
	}
	
	/**
	 * @method 写入订单日志
	 * @author jkr
	 */
	protected function insertLog($orderArr)
	{
		$content = '下订单，订单价格：'.$orderArr['order_price'].'，优惠后价格：'.$orderArr['total_price'];
		if ($orderArr['jifen'] > 0)
		{
			$content .= '，使用积分：'.$orderArr['jifen'].'，积分抵扣金额：'.round($orderArr['jifen']/100 ,2);
		}
		if ($orderArr['couponprice'] > 0)
		{
			$content .= '，优惠券抵扣金额：'.$orderArr['couponprice'];
		}
		$content .= '，保险费：'.$orderArr['settlement_price'];
		
		$logArr = array(
				'order_id' =>$orderArr['order_id'],
				'op_type' =>0,
				'userid' =>$orderArr['memberid'],
				'content' =>$content,
				'addtime' =>$orderArr['addtime']
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
		
		$content = '下订单，管家佣金：'.$orderArr['agent_fee'].'，平台管理费：'.$orderArr['platform_fee'];
		$logArr['content'] = $content;
		$logArr['type'] = 1;
		$this ->db ->insert('u_member_order_log' ,$logArr);
	}
	
	/**
	 * @method 获取订单号
	 * @author jkr
	 */
	protected function createOrderCode()
	{
		$this ->db ->insert('u_order_code' ,array('code' =>'a'));
		return $this ->db ->insert_id();
	}
}

