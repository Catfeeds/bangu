<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月23日11:59:53
 * @author		汪晓烽
 *
 */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'u_member_order' );
	}

	/**
	 * @method C端订单导出数据
	 * @author jkr
	 */
	public function getExportOrderData($whereArr ,$orderBy = 'mo.id desc' ,$num=false)
	{
		$sql = "SELECT mo.`id`,mo.`usedate`,GROUP_CONCAT(st.`cityname`) as cityname,a.`realname` AS admin_name,mo.`ordersn`,mo.`total_price`,mo.settlement_price,mo.`agent_fee`,mo.`platform_fee`,(mo.total_price-mo.settlement_price-mo.agent_fee-mo.platform_fee) AS settlement_fee,
	(mo.`dingnum`+mo.`childnobednum`+mo.`childnum`+mo.`oldnum`) AS num,e.`realname` AS expert_name,
	mo.status,mo.ispay,CONCAT(s.company_name,s.brand) AS supplier_name,l.linename
FROM u_member_order AS mo LEFT JOIN u_admin AS a ON mo.admin_id=a.id
LEFT JOIN u_expert AS e ON mo.`expert_id`=e.`id`
LEFT JOIN u_line_startplace AS ls ON mo.productautoid=ls.line_id
LEFT JOIN u_startplace AS st ON st.id=ls.startplace_id
LEFT JOIN u_line AS l ON l.id=mo.productautoid
LEFT JOIN u_supplier AS s ON s.id=mo.supplier_id";
//WHERE mo.`usedate` BETWEEN '2016-11-01 00:00:00' AND '2016-11-30 23:59:59' AND mo.user_type=0 AND s.id!=299 ";
		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'GROUP BY mo.id','' ,$num);
	}
	
	
	public function getUnionLine($lineid)
	{
		$sql = 'select l.*,la.deposit,la.before_day from u_line as l left join u_line_affiliated as la on la.line_id=l.id where l.id='.$lineid;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取上车地点
	 * @param unknown $id 线路ID
	 */
	public function getLineOnCar($id)
	{
		$sql = 'select * from u_line_on_car where line_id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取营业部银行卡信息
	 * @author jkr
	 * @param unknown $departId
	 */
	public function getDepartBank($departId)
	{
		$sql = 'SELECT bankcard ,bankname  FROM  b_union WHERE id='.$departId;
		return $this ->db ->query($sql) ->row_array();
	}

	/**
	 * @method 单项产品获取旅行社管理费
	 * @author jkr
	 */
	public function getSingleAgent($lineId)
	{
		$sql = 'select * from b_single_agent where line_id='.$lineId;
		return $this ->db ->query($sql) ->row_array();
	}

	/**
	 * @method 获取旅行社线路的人头费
	 * @author jkr
	 */
	public function getUnionLineAgent($unionId ,$supplier_id ,$agent_type)
	{
		$sql = 'select * from b_union_line_agent as u where union_id ='.$unionId.' and supplier_id ='.$supplier_id.' and agent_type='.$agent_type;
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 获取线路人头费
	 * @param unknown $supplier_id
	 * @param unknown $day
	 */
	public function getUnionLineDay($supplier_id ,$day ,$union_id ,$agent_type)
	{
		$sql = 'select * from b_union_line_agent_day where supplier_id ='.$supplier_id.' and day="'.$day.'" and union_id='.$union_id.' and agent_type='.$agent_type;
		return $this ->db ->query($sql) ->row_array();
	}

	/**
	 * @method 获取外交佣金
	 * @param unknown $overcity
	 */
	public function getForeignAgent($overcity ,$union_id)
	{
		$sql = 'select * from u_foreign_agent where dest_id in ('.$overcity.') and union_id ='.$union_id;
		return $this ->db ->query($sql) ->result_array();
	}


	/**
	 * @method 下载合同,获取订单及线路信息
	 * @param unknown $orderId 订单ID
	 * @param intval $mid 用户ID
	 */
	public function getOrderLine($orderId ,$mid)
	{
		$sql = 'select mo.id,mo.usedate,mo.ordersn,mo.confirmtime_supplier,mo.settlement_price,mo.price,mo.childprice,mo.suitnum,mo.childnobedprice,mo.oldprice,mo.dingnum,mo.jifenprice,mo.couponprice,mo.childnum,mo.childnobednum,mo.oldnum,mo.suitid,mo.total_price,mo.linkmobile,mo.linkemail,mo.isbuy_insurance,l.feenotinclude,l.lineday,l.linenight,l.overcity,l.linename,s.linkman as supplier_name,c.name as country,p.name as province,a.name as city,s.company_name,s.link_mobile as supplier_mobile,s.brand,s.email as supplier_email,s.licence_img_code,s.kind,od.addtime as paytime,od.pay_way,ls.unit from u_member_order as mo left join u_line as l on l.id=mo.productautoid left join u_supplier as s on s.id=mo.supplier_id left join u_order_detail as od on od.order_id = mo.id left join u_area as c on c.id = s.country left join u_area as p on p.id=s.province left join u_area as a on a.id=s.city left join u_line_suit as ls on ls.id=mo.suitid where mo.id='.$orderId.' and mo.memberid='.$mid;
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 订单的第一个出游人信息，用于合同下载
	 * @param unknown $orderId 订单ID
	 */
	public function getOrderTraver($orderId)
	{
		$sql = 'select mt.* from u_member_traver as mt left join u_member_order_man as om on mt.id=om.traver_id where om.order_id ='.$orderId.' order by om.id asc limit 1';
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 获取订单的保险，用于合同下载
	 * @param unknown $orderId
	 */
	public function getOrderInsurance($orderId)
	{
		$sql = 'select ti.insurance_name from u_order_insurance as oi left join u_travel_insurance as ti on ti.id=oi.insurance_id where oi.order_id='.$orderId;
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 写入营业部额度变化日期(此日志只适用于下订单)
	 * @author jkr
	 * @param array $orderArr 订单信息
	 * @param float $cash_limit 营业部剩余的现金额度
	 * @param float $credit_limit 营业部剩余的信用额度
	 * @param float $sx_limit 管家的信用额度
	 * @param float $cut_money 扣除的营业部的现金和信用额度总和
	 * @param string $remark 备注信息
	 * @param string $time 写入时间(只用于特殊情况，如：押金订单，先写入一条单团额度申请记录，在写入一条扣款记录)
	 */
	public function insertQuotaLog($orderArr,$cash_limit,$credit_limit,$sx_limit,$cut_money,$remark,$time=false)
	{
		$logArr = array(
				'depart_id' =>$orderArr['depart_id'],
				'expert_id' =>$orderArr['expert_id'],
				'expert_name' =>$orderArr['expert_name'],
				'manager_id' =>$orderArr['manager_id'],
				'order_id' =>$orderArr['order_id'],
				'order_sn' =>$orderArr['ordersn'],
				'order_price' =>$orderArr['total_price'],
				'union_id' =>$orderArr['platform_id'],
				'supplier_id' =>$orderArr['supplier_id'],
				'cash_limit' =>$cash_limit,
				'credit_limit' =>$credit_limit,
				'sx_limit' =>$sx_limit,
				'cut_money' =>'-'.$cut_money,
				'addtime' =>$time == false ? $orderArr['addtime'] : $time,
				'type' =>'下订单',
				'remark' =>$remark
		);
		$this ->db ->insert('b_limit_log' ,$logArr);
	}
	
	
	
	/**
	 * @method 写入订单交款表
	 * @author jkr
	 * @param array $orderArr 订单信息
	 * @param string $remark 交款备注
	 * @param string $union_name 旅行社名称
	 * @param float $money 交款金额
	 * @param intval $status 交款状态 0:未提交
	 */
	public function insertOrderReceivable($orderArr,$money,$remark,$union_name,$status=0)
	{
		$receivableArr = array(
				'money' =>$money,
				'way' =>'账户余额',
				'remark' =>$remark,
				'status' =>$status,
				'addtime' =>$orderArr['addtime'],
				'expert_id' =>$orderArr['expert_id'],
				'depart_id' => $orderArr['depart_id'],
				'union_id' => $orderArr['platform_id'],
				'union_name' => $union_name,
				'order_id' => $orderArr['order_id'],
				'order_sn' => $orderArr['ordersn'],
				'from' =>2
		);
		$this ->db ->insert('u_order_receivable' ,$receivableArr);
		$receivableid = $this ->db ->insert_id();
		
		$applyArr = array(
				'expert_id' =>$orderArr['expert_id'],
				'amount' =>$money,
				'addtime' =>$orderArr['addtime'],
				'modtime' =>$orderArr['addtime'],
				'status' =>0,
				'union_id' =>$orderArr['platform_id'],
				'depart_id' =>$orderArr['depart_id'],
				'order_id' =>$orderArr['order_id'],
				'have' =>0
		);
		$this ->db ->insert('u_item_apply' ,$applyArr);
		$itemid = $this ->db ->insert_id();
		
		$itemArr = array(
				'receivable_id' =>$receivableid,
				'item_id' =>$itemid
		);
		$this ->db ->insert('u_item_receivable' ,$itemArr);
		return $receivableid;
	}
	
	/**
	 * @method 记录订单日志
	 * @param unknown $orderArr 订单信息
	 */
	public function orderLog($orderArr ,$applyQuota,$affiliatedArr)
	{
		//status 2,3,4,9,10,11
		$msg = '订单价格：'.$orderArr['total_price'].'，联盟管理费：'.$orderArr['platform_fee'].'，外交佣金：'.$orderArr['diplomatic_agent'].'，管家佣金：'.$orderArr['agent_fee'].'，供应商成本：'.$orderArr['supplier_cost'];
		
		switch($orderArr['status'])
		{
			case 2:
				$content = '管家下单，额度不足，向旅行社申请额度，申请额度为：'.$applyQuota['credit_limit'].'，管家是营业部经理，自动提交额度申请，'.$msg;
				break;
			case 3:
				$content = '管家下单，额度不足，向供应商申请额度，申请额度为：'.$applyQuota['credit_limit'].'，管家是营业部经理，自动提交额度申请，'.$msg;
				break;
			case 4:
				if (!empty($affiliatedArr['deposit']))
				{
					$content = '定金订单，定金为：'.$affiliatedArr['deposit'].'，默认向供应商申请额度，并通过，申请额度为：'.$applyQuota['credit_limit'].'，'.$msg;
				}
				else
				{
					$content = '额度充足，'.$msg;
				}
				break;
			case 9:
				$content = '管家临时保存订单，'.$msg;
				break;
			case 10:
				$content = '管家下单，额度不足，向旅行社申请额度，申请额度为：'.$applyQuota['credit_limit'].'，'.$msg;
				break;
			case 11:
				$content = '管家下单，额度不足，向供应商申请额度，申请额度为：'.$applyQuota['credit_limit'].'，'.$msg;
				break;
			default:
				$content = '管家下单!!，'.msg;
				break;
		}
			
		$logArr = array(
				'order_id' =>$orderArr['order_id'],
				'op_type' => 1,
				'userid' =>$orderArr['expert_id'],
				'content' =>$content,
				'addtime' => $orderArr['addtime']
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
	}
	
	
	/**
	 * @method 管家申请信用额度订单，不可以用于其它情况
	 * 扣除营业部现金额度的同时写入订单交款表
	 * @param unknown $orderArr 订单信息
	 * @param unknown $applyQuota 管家申请额度信息
	 */
	public function applyOrderQuota($orderArr ,$applyQuota)
	{
		/** 营业部的现金和信用额度不足，需要管家申请单团额度 **/
		$msgArr = array(
				'code' =>200, //执行状态码，400：营业部额度不足以抵扣押金，200：正常
				'cashQuota' =>0, //使用的营业部现金额度
				'departArr' =>array(),//营业部数据
				'applyId' =>0,//申请额度表ID
				'sk_id' =>0
		);
		
		//获取营业部信息并建立行锁
		$sql = 'select * from b_depart where id ='.$orderArr['depart_id'].' for update';
		$departData = $this ->db ->query($sql) ->row_array();
		$msgArr['departArr'] = $departData;
		
		//管家申请的额度
		$quota = $applyQuota['credit_limit'];
		//需要扣除的营业部额度
		$departQuota = $orderArr['total_price']-$quota;
		
		//写入单团额度申请表
		$applyQuota['order_id'] = $orderArr['order_id'];
		$this ->db ->insert('b_limit_apply' ,$applyQuota);
		//记录申请的单团额度
		$msgArr['applyQuota'] = $quota;
		$msgArr['applyId'] = $this ->db ->insert_id();
		
		if($departData['cash_limit'] >0)
		{
			//现金额度大于0
			$surplus = $departQuota - $departData['cash_limit'];
			if ($surplus > 0.0001)
			{
				//现金额度不足，判断信用额度
				if ($departData['credit_limit'] >0)
				{
					$surplus = $departQuota - ($departData['cash_limit'] +$departData['credit_limit']);
					if ($surplus >0.0001)
					{
						$msgArr['code'] = 400;
						return $msgArr;
					}
					else
					{
						/**现金额度扣为0，信用额度扣除部分***/
						$credit_limit = round($departQuota - $departData['cash_limit'],2);
						$cash_limit = $departData['cash_limit'];
						$sql = 'update b_depart set cash_limit=0,credit_limit=credit_limit-'.$credit_limit.' where id ='.$orderArr['depart_id'];
						$this ->db ->query($sql);
					}
				}
				else
				{
					$msgArr['code'] = 400;
					return $msgArr;
				}
			}
			else
			{
				/**只扣除营业部现金额度***/
				$credit_limit = 0;
				$cash_limit = round($departQuota ,2);
				$sql = 'update b_depart set cash_limit=cash_limit-'.$cash_limit.' where id ='.$orderArr['depart_id'];
				$this ->db ->query($sql);
			}
		}
		else
		{
			//现金额度小于等于0,判断信用额度
			if ($departData['credit_limit'] >0)
			{
				$surplus = $departQuota - $departData['credit_limit'];
				if ($surplus >0.0001)
				{
					$msgArr['code'] = 400;
					return $msgArr;
				}
				else
				{
					/**只扣除营业部信用额度***/
					$credit_limit = round($departQuota ,2);
					$cash_limit = 0;
					$sql = 'update b_depart set credit_limit=credit_limit-'.$credit_limit.' where id ='.$orderArr['depart_id'];
					$this ->db ->query($sql);
				}
			}
			else
			{
				if ($departQuota >0.0001)
				{
					/**还需要扣除额度，但营业部没有额度，则需要返回重新确认*/
					$msgArr['code'] = 400;
					return $msgArr;
				}
				else 
				{
					$cash_limit = 0;
					$credit_limit = 0;
				}
			}
		}
		
		if ($departQuota >0)
		{
			//额度使用备注
			$remark = '现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$cash_limit.'，信用额度:'.$departData['credit_limit'].'扣除信用额度：'.$credit_limit.'，申请单团额度：'.$quota;
			//写入额度记录变化表
			$this ->insertQuotaLog($orderArr, round($departData['cash_limit']-$cash_limit ,2), round($departData['credit_limit']-$credit_limit ,2), 0, round($departQuota ,2), $remark);
		}
		
		//扣款备注
		$remark1 = '管家下订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$cash_limit;
		$remark2 = '管家下订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：'.$credit_limit;
		$remark3 = '管家下订单，扣除单团额度：0，申请单团额度：'.$quota;
		
		/**营业部额度不足，需要管家申请单团额度，此时扣款表没有记录扣除的单团额度，需要供应商或旅行社审核通过后写入*/
		//写入订单扣款表
		$this ->insertOrderDebit($orderArr['order_id'] ,1 ,$cash_limit ,$remark1);
		$this ->insertOrderDebit($orderArr['order_id'] ,2 ,$credit_limit ,$remark2);
		$this ->insertOrderDebit($orderArr['order_id'] ,3 ,0 ,$remark3);
		
		//若扣除了营业部的现金额度，则写入订单交款表
		if ($cash_limit > 0)
		{
			$orderArr['addtime'] = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
			$remark = '管家下单，现金余额交款，交款金额：'.$cash_limit;
			$sk_id = $this ->insertOrderReceivable($orderArr, $cash_limit, $remark ,$departData['union_name']);
			$msgArr['sk_id'] = $sk_id;
		}
		return $msgArr;
		
		/***以下是早期版本**/
		//营业部拥有的额度
		$departLimit = $departData['cash_limit']+$departData['credit_limit'];
		
		$balance = $departQuota - $departLimit;
		if ($balance > 0.0001)
		{
			/***注意哦！！！营业部的额度不足啦**/
			$msgArr['code'] = 400;
			return $msgArr;
		}
		else 
		{
			//写入单团额度申请表
// 			$applyQuota['order_id'] = $orderArr['order_id'];
// 			$this ->db ->insert('b_limit_apply' ,$applyQuota);
// 			//记录申请的单团额度
// 			$msgArr['applyQuota'] = $quota;
// 			$msgArr['applyId'] = $this ->db ->insert_id();
			
			$balance = $departQuota - $departData['cash_limit'];
			
			if ($balance >0.0001)
			{
				//营业部现金额度不足，需要扣除信用额度
				//需要扣除的营业部信用额度
				$creditQuota = round($balance ,2);
				
// 				//扣除营业部的额度
// 				$sql = 'update b_depart set cash_limit = 0,credit_limit=credit_limit-'.$creditQuota.' where id ='.$orderArr['depart_id'];
// 				$this ->db ->query($sql);
				
				if ($departQuota >0)
				{
					//额度使用备注
					$remark = '现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$departData['cash_limit'].'，信用额度:'.$departData['credit_limit'].'扣除信用额度：'.$creditQuota.'，申请单团额度：'.$quota;
					//写入额度记录变化表
					$this ->insertQuotaLog($orderArr, 0, round($departData['credit_limit']-$creditQuota ,2), 0, $departQuota, $remark);
				}
				
// 				//扣款备注
// 				$remark1 = '管家下订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$departData['cash_limit'];
// 				$remark2 = '管家下订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：'.$creditQuota;
// 				$remark3 = '管家下订单，扣除单团额度：0，申请单团额度：'.$quota;
					
// 				/**营业部额度不足，需要管家申请单团额度，此时扣款表没有记录扣除的单团额度，需要供应商或旅行社审核通过后写入*/
// 				//写入订单扣款表
// 				$this ->insertOrderDebit($orderArr['order_id'] ,1 ,$departData['cash_limit'] ,$remark1);
// 				$this ->insertOrderDebit($orderArr['order_id'] ,2 ,$creditQuota ,$remark2);
// 				$this ->insertOrderDebit($orderArr['order_id'] ,3 ,0 ,$remark3);
					
				//若扣除了营业部的现金额度，则写入订单交款表
// 				if ($departData['cash_limit'] > 0)
// 				{
// 					$orderArr['addtime'] = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
// 					$remark = '管家下单，现金余额交款，交款金额：'.$departData['cash_limit'];
// 					$sk_id = $this ->insertOrderReceivable($orderArr, $departData['cash_limit'], $remark ,$departData['union_name']);
// 					$msgArr['sk_id'] = $sk_id;
// 				}
			}
			else 
			{
				$departQuota = round($departQuota ,2);
				//营业部现金额度充足
				//扣除营业部的额度
				$sql = 'update b_depart set cash_limit = cash_limit-'.$departQuota.' where id ='.$orderArr['depart_id'];
				$this ->db ->query($sql);
				
				if ($departQuota >0)
				{
					//额度使用备注
					$remark = '现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$departQuota.'，信用额度:'.$departData['credit_limit'].'扣除信用额度：0，申请单团额度：'.$quota;
					//写入额度记录变化表
					$this ->insertQuotaLog($orderArr, round($departData['cash_limit']-$departQuota ,2), $departData['credit_limit'], 0, $departQuota, $remark);
				}
				//扣款备注
				$remark1 = '管家下订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$departQuota;
				$remark2 = '管家下订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：0';
				$remark3 = '管家下订单，扣除单团额度：0，申请单团额度：'.$quota;
				
				/**营业部额度不足，需要管家申请单团额度，此时扣款表没有记录扣除的单团额度，需要供应商或旅行社审核通过后写入*/
				//写入订单扣款表
				$this ->insertOrderDebit($orderArr['order_id'] ,1 ,$departQuota ,$remark1);
				$this ->insertOrderDebit($orderArr['order_id'] ,2 ,0 ,$remark2);
				$this ->insertOrderDebit($orderArr['order_id'] ,3 ,0 ,$remark3);
					
				//若扣除了营业部的现金额度，则写入订单交款表
				if ($departQuota > 0)
				{
					$orderArr['addtime'] = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
					$remark = '管家下单，现金余额交款，交款金额：'.$departQuota;
					$sk_id = $this ->insertOrderReceivable($orderArr, $departQuota, $remark ,$departData['union_name']);
					$msgArr['sk_id'] = $sk_id;
				}
			}
			return $msgArr;
		}
	}
	
	/**
	 * @method 押金订单，扣除信用额度，不可以用于其它情况
	 * 押金订单，管家向供应商申请单团额度，默认申请通过，并向额度使用表写入一条记录
	 * 注意这里要写入两条额度使用日志，一条是通过单团额度申请的日志，一条是扣除营业部额度和管家单团额度的日志
	 * 扣除营业部现金额度的同时写入订单交款表
	 * @param unknown $orderArr 订单信息
	 * @param unknown $applyQuota 管家申请额度信息
	 * @param unknown $applyQuota 订单附属表
	 */
	public function depositOrderQuota($orderArr ,$applyQuota ,$affiliatedArr)
	{
		$msgArr = array(
				'code' =>200, //执行状态码，400：营业部额度不足以抵扣押金，200：正常
				'cashQuota' =>0, //使用的营业部现金额度
				'departArr' =>array(),//营业部数据
				'applyId' =>0, //额度申请表ID
				'sk_id'=>0
		);
		
		//获取营业部信息并建立行锁
		$sql = 'select * from b_depart where id ='.$orderArr['depart_id'].' for update';
		$departData = $this ->db ->query($sql) ->row_array();
		$msgArr['departArr'] = $departData;
		
		/***押金订单，押金需要用营业部的现金额度和信用额度抵扣，不可以使用管家的信用额度,同时剩余部分金额给管家默认申请一个信用额度，向供应商申请并通过**/
		//线路的押金
		$deposit = $affiliatedArr['deposit'];
		$balance = $departData['cash_limit'] - $deposit;
		if ($balance > -0.0001)
		{
			/**营业部现金额度充足**/
			$cash_limit = $deposit;
			$credit_limit = 0;
		}
		else
		{
			/**营业部现金额度不足，比较信用额度**/
			if ($departData['cash_limit'] > 0)
			{
				$balance1 = $departData['credit_limit'] - abs($balance);
				if ($balance1 > -0.0001)
				{
					$cash_limit = $departData['cash_limit'];
					$credit_limit = abs($balance);
				}
				else
				{
					$msgArr['code'] = 400;
					return $msgArr;
				}
			}
			else
			{
				$balance = $departData['credit_limit'] - $deposit;
				if ($balance > -0.0001)
				{
					$cash_limit = 0;
					$credit_limit = $deposit;
				}
				else
				{
					$msgArr['code'] = 400;
					return $msgArr;
				}
			}
		}
		
		//写入单团额度申请表，默认供应商通过
		if ($applyQuota['credit_limit'] >0)
		{
			$applyQuota['order_id'] = $orderArr['order_id'];
			$this ->db ->insert('b_limit_apply' ,$applyQuota);
			$msgArr['applyId'] = $this ->db ->insert_id();
		
			//写入额度使用记录表
			$dataArr = array(
					'depart_id' =>$applyQuota['depart_id'],
					'depart_name' =>$applyQuota['depart_name'],
					'expert_id' =>$applyQuota['expert_id'],
					'expert_name' =>$applyQuota['expert_name'],
					'apply_id' =>$this ->db ->insert_id(),
					'order_id' =>$orderArr['order_id'],
					'apply_amount' =>$applyQuota['credit_limit'],
					'real_amount' =>$applyQuota['credit_limit'],
					'addtime' =>$applyQuota['addtime'],
					'status' =>1,
					'return_time' =>$applyQuota['return_time']
			);
			$this ->db ->insert('b_expert_limit_apply' ,$dataArr);
			$msgArr['applyQuota'] = $applyQuota['credit_limit'];
				
			//额度使用备注
			$remark = '定金订单，默认向供应商申请信用额度并通过，申请的额度为：'.$applyQuota['credit_limit'];
				
			$time = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
			//写入额度日志表，记录管家申请的单团额度
			$this ->insertQuotaLog($orderArr, $departData['cash_limit'], $departData['credit_limit'], $applyQuota['credit_limit'], 0, $remark ,$time);
		}
		
		$sql = 'update b_depart set cash_limit=cash_limit-'.$cash_limit.',credit_limit=credit_limit-'.$credit_limit.' where id = '.$orderArr['depart_id'];
		$status = $this ->db ->query($sql);
		//额度使用备注
		$remark = '定金订单，现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$cash_limit.'，信用额度:'.$departData['credit_limit'].'扣除信用额度：'.$credit_limit.'，扣除单团额度：'.$applyQuota['credit_limit'];
		//写入额度记录变化表
		$this ->insertQuotaLog($orderArr, round($departData['cash_limit']-$cash_limit ,2), round($departData['credit_limit']-$credit_limit,2), '-'.$applyQuota['credit_limit'], $deposit, $remark);
		
		//扣款备注
		$remark1 = '定金订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$cash_limit;
		$remark2 = '定金订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：'.$credit_limit;
		$remark3 = '定金订单，扣除单团额度：'.$applyQuota['credit_limit'];
		
		//写入订单扣款表
		$status = $this ->insertOrderDebit($orderArr['order_id'] ,1 ,$cash_limit ,$remark1);
		$status = $this ->insertOrderDebit($orderArr['order_id'] ,2 ,$credit_limit ,$remark2);
		$status = $this ->insertOrderDebit($orderArr['order_id'] ,3 ,$applyQuota['credit_limit'] ,$remark3);
		
		//保存扣除的
		$msgArr['cashQuota'] = $cash_limit;
		
		//若扣除了营业部的现金额度，则写入订单交款表
		if ($cash_limit > 0)
		{
			$orderArr['addtime'] = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
			$remark = '定金订单，现金余额交款，交款金额：'.$cash_limit;
			$sk_id = $this ->insertOrderReceivable($orderArr, $cash_limit, $remark ,$departData['union_name']);
			$msgArr['sk_id'] = $sk_id;
		}
		
		return $msgArr;
		
		
		//线路的押金
		$deposit = $affiliatedArr['deposit'];
		$balance = ($departData['cash_limit'] + $departData['credit_limit']) - $deposit;
		/**分为营业部额度充足和额度不足两种情况，若额度不足则不可下单*/
		if ($balance > -0.00001)
		{
			//营业部额度充足，可以抵扣押金
			//写入单团额度申请表，默认供应商通过
			if ($applyQuota['credit_limit'] >0) 
			{
				$applyQuota['order_id'] = $orderArr['order_id'];
				$this ->db ->insert('b_limit_apply' ,$applyQuota);
				$msgArr['applyId'] = $this ->db ->insert_id();
				
				//写入额度使用记录表
				$dataArr = array(
						'depart_id' =>$applyQuota['depart_id'],
						'depart_name' =>$applyQuota['depart_name'],
						'expert_id' =>$applyQuota['expert_id'],
						'expert_name' =>$applyQuota['expert_name'],
						'apply_id' =>$this ->db ->insert_id(),
						'order_id' =>$orderArr['order_id'],
						'apply_amount' =>$applyQuota['credit_limit'],
						'real_amount' =>$applyQuota['credit_limit'],
						'addtime' =>$applyQuota['addtime'],
						'status' =>1,
						'return_time' =>$applyQuota['return_time']
				);
				$this ->db ->insert('b_expert_limit_apply' ,$dataArr);
				$msgArr['applyQuota'] = $applyQuota['credit_limit'];
			
				//额度使用备注
				$remark = '定金订单，默认向供应商申请信用额度并通过，申请的额度为：'.$applyQuota['credit_limit'];
			
				$time = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
				//写入额度日志表，记录管家申请的单团额度
				$this ->insertQuotaLog($orderArr, $departData['cash_limit'], $departData['credit_limit'], $applyQuota['credit_limit'], 0, $remark ,$time);
			}
			//写入订单附属表
// 			$affiliatedArr['order_id'] = $orderArr['order_id'];
// 			$this ->db ->insert('u_member_order_affiliated' ,$affiliatedArr);
		
			/******扣除营业部的额度，分为现金额度充足，现金额度不足需扣除营业部信用额度******/
			$balance = $departData['cash_limit']-$deposit;
			if ($balance > -0.00001)
			{
				/*****营业部现金额度充足******/
		
				$sql = 'update b_depart set cash_limit = cash_limit -'.$deposit.' where id = '.$orderArr['depart_id'];
				$status = $this ->db ->query($sql);
				//额度使用备注
				$remark = '定金订单，现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$deposit.'，信用额度:'.$departData['credit_limit'].'扣除信用额度：0，扣除单团额度：'.$applyQuota['credit_limit'];
				//写入额度记录变化表
				$this ->insertQuotaLog($orderArr, round($balance ,2), $departData['credit_limit'], '-'.$applyQuota['credit_limit'], $deposit, $remark);
		
				//扣款备注
				$remark1 = '定金订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$deposit;
				$remark2 = '定金订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：0';
				$remark3 = '定金订单，扣除单团额度：'.$applyQuota['credit_limit'];
		
				//写入订单扣款表
				$status = $this ->insertOrderDebit($orderArr['order_id'] ,1 ,$deposit ,$remark1);
				$status = $this ->insertOrderDebit($orderArr['order_id'] ,2 ,0 ,$remark2);
				$status = $this ->insertOrderDebit($orderArr['order_id'] ,3 ,$applyQuota['credit_limit'] ,$remark3);
		
				//保存扣除的
				$msgArr['cashQuota'] = $deposit;
		
				//若扣除了营业部的现金额度，则写入订单交款表
				if ($deposit > 0)
				{
					$orderArr['addtime'] = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
					$remark = '定金订单，现金余额交款，交款金额：'.$deposit;
					$sk_id = $this ->insertOrderReceivable($orderArr, $deposit, $remark ,$departData['union_name']);
					$msgArr['sk_id'] = $sk_id;
				}
			}
			else
			{
				/******需要使用营业部信用额度*****/
				//营业部剩余的信用额度
				$credit = round($departData['credit_limit'] - ($deposit -$departData['cash_limit']) ,2);
				//扣除的营业部信用额度
				$deduction = round($deposit -$departData['cash_limit'] ,2);
		
				$sql = 'update b_depart set cash_limit = 0,credit_limit = '.$credit.' where id = '.$orderArr['depart_id'];
				$status = $this ->db ->query($sql);
		
				//额度使用备注
				$remark = '定金订单，现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$departData['cash_limit'].'，信用额度:'.$departData['credit_limit'].'扣除信用额度：'.$deduction.'，扣除单团额度：'.$applyQuota['credit_limit'];
				//写入额度记录变化表
				$this ->insertQuotaLog($orderArr, 0, $credit, '-'.$applyQuota['credit_limit'], $deposit, $remark);
		
				//扣款备注
				$remark1 = '定金订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$departData['cash_limit'];
				$remark2 = '定金订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：'.$deduction;
				$remark3 = '定金订单，扣除单团额度：'.$applyQuota['credit_limit'];
		
				//写入订单扣款表
				$this ->insertOrderDebit($orderArr['order_id'] ,1 ,$departData['cash_limit'] ,$remark1);
				$this ->insertOrderDebit($orderArr['order_id'] ,2 ,$deduction ,$remark2);
				$this ->insertOrderDebit($orderArr['order_id'] ,3 ,$applyQuota['credit_limit'] ,$remark3);
		
				//若扣除了营业部的现金额度，则写入订单交款表
				if ($departData['cash_limit'] > 0)
				{
					$orderArr['addtime'] = date('Y-m-d H:i:s' ,strtotime($orderArr['addtime'])-1);
					$remark = '定金订单，现金余额交款，交款金额：'.$departData['cash_limit'];
					$sk_id = $this ->insertOrderReceivable($orderArr, $departData['cash_limit'], $remark ,$departData['union_name']);
					$msgArr['sk_id'] = $sk_id;
				}
			}
		}
		else
		{
			//营业部额度不足，不足以抵扣押金
			$msgArr['code'] = 400;
		}
		return $msgArr;
	}
	
	/**
	 * @method 下单扣除营业部额度，非定金订单，额度充足情况，不可用于其他情况
	 * 扣除营业部现金额度的同时写入订单交款表
	 * @author jkr
	 * @param $orderArr 订单信息
	 */
	public function adequateQuota($orderArr)
	{
		$msgArr = array(
				'code' =>200, //执行状态码，400：营业部额度不足以抵扣押金，200：正常
				'cashQuota' =>0, //使用的营业部现金额度
				'departArr' =>array(),//营业部数据
				'applyId' =>0,//额度申请表ID
				'sk_id' =>0
		);
		
		//获取营业部信息并建立行锁
		$sql = 'select * from b_depart where id ='.$orderArr['depart_id'].' for update';
		$departData = $this ->db ->query($sql) ->row_array();
		$msgArr['departArr'] = $departData;
		
		$balance = $departData['cash_limit'] - $orderArr['total_price'];
		if ($balance > -0.0001)
		{
			/**营业部现金额度充足**/
			$cash_limit = $orderArr['total_price'];
			$credit_limit = 0;
		}
		else 
		{
			/**营业部现金额度不足，比较信用额度**/
			if ($departData['cash_limit'] > 0)
			{
				$balance1 = $departData['credit_limit'] - abs($balance);
				if ($balance1 > -0.0001)
				{
					$cash_limit = $departData['cash_limit'];
					$credit_limit = abs($balance);
				}
				else 
				{
					$msgArr['code'] = 400;
					return $msgArr;
				}
			}
			else 
			{
				$balance = $departData['credit_limit'] - $orderArr['total_price'];
				if ($balance > -0.0001)
				{
					$cash_limit = 0;
					$credit_limit = $orderArr['total_price'];
				}
				else 
				{
					$msgArr['code'] = 400;
					return $msgArr;
				}
			}
		}
		
		$sql = 'update b_depart set cash_limit=cash_limit-'.$cash_limit.',credit_limit=credit_limit-'.$credit_limit.' where id = '.$orderArr['depart_id'];
		$status = $this ->db ->query($sql);
		//额度使用备注
		$remark = '管家下订单，现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$cash_limit.'，信用额度:'.$credit_limit.'扣除信用额度：0';
		//写入额度记录变化表
		$this ->insertQuotaLog($orderArr, round($departData['cash_limit']-$cash_limit ,2), round($departData['credit_limit']-$credit_limit ,2), 0, $orderArr['total_price'], $remark);
		
		//扣款备注
		$remark1 = '管家下订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$cash_limit;
		$remark2 = '管家下订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：'.$credit_limit;
		$remark3 = '管家下订单，扣除单团额度：0';
		
		//写入订单扣款表
		$status = $this ->insertOrderDebit($orderArr['order_id'] ,1 ,$cash_limit ,$remark1);
		$status = $this ->insertOrderDebit($orderArr['order_id'] ,2 ,$credit_limit ,$remark2);
		$status = $this ->insertOrderDebit($orderArr['order_id'] ,3 ,0 ,$remark3);
		
		//若扣除了营业部的现金额度，则写入订单交款表
		if ($cash_limit > 0)
		{
			$remark = '管家下单，现金余额交款，交款金额：'.$cash_limit;
			$sk_id = $this ->insertOrderReceivable($orderArr, $cash_limit, $remark ,$departData['union_name']);
			$msgArr['sk_id'] = $sk_id;
		}
		
		return $msgArr;
		
		
		$balance = $departData['cash_limit'] - $orderArr['total_price'];
		$balance1 = ($departData['cash_limit'] + $departData['credit_limit']) - $orderArr['total_price'];
		if ($balance > -0.0001)
		{
			/****营业部现金额度充足情况**/
		
			$sql = 'update b_depart set cash_limit = cash_limit -'.$orderArr['total_price'].' where id = '.$orderArr['depart_id'];
			$status = $this ->db ->query($sql);
			//额度使用备注
			$remark = '管家下订单，现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$orderArr['total_price'].'，信用额度:'.$departData['credit_limit'].'扣除信用额度：0';
			//写入额度记录变化表
			$this ->insertQuotaLog($orderArr, round($balance ,2), $departData['credit_limit'], 0, $orderArr['total_price'], $remark);
		
			//扣款备注
			$remark1 = '管家下订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$orderArr['total_price'];
			$remark2 = '管家下订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：0';
			$remark3 = '管家下订单，扣除单团额度：0';
		
			//写入订单扣款表
			$status = $this ->insertOrderDebit($orderArr['order_id'] ,1 ,$orderArr['total_price'] ,$remark1);
			$status = $this ->insertOrderDebit($orderArr['order_id'] ,2 ,0 ,$remark2);
			$status = $this ->insertOrderDebit($orderArr['order_id'] ,3 ,0 ,$remark3);
		
			//若扣除了营业部的现金额度，则写入订单交款表
			if ($orderArr['total_price'] > 0)
			{
				$remark = '管家下单，现金余额交款，交款金额：'.$orderArr['total_price'];
				$sk_id = $this ->insertOrderReceivable($orderArr, $orderArr['total_price'], $remark ,$departData['union_name']);
				$msgArr['sk_id'] = $sk_id;
			}
		}
		elseif ($balance1 > -0.0001)
		{
			/****营业部现金额度加其信用额度 充足情况**/
		
			//营业部剩余的信用额度
			$credit = round($departData['credit_limit'] - ($orderArr['total_price'] -$departData['cash_limit']) ,2);
			//扣除的营业部信用额度
			$deduction = round($orderArr['total_price'] -$departData['cash_limit'] ,2);
		
			$sql = 'update b_depart set cash_limit = 0,credit_limit = '.$credit.' where id = '.$orderArr['depart_id'];
			$status = $this ->db ->query($sql);
		
			//额度使用备注
			$remark = '管家下订单，现金额度:'.$departData['cash_limit'].',扣除现金额度为：'.$departData['cash_limit'].'，信用额度:'.$departData['credit_limit'].'扣除信用额度：'.$deduction;
			//写入额度记录变化表
			$this ->insertQuotaLog($orderArr, 0, $credit, 0, $orderArr['total_price'], $remark);
		
			//扣款备注
			$remark1 = '管家下订单，现金额度：'.$departData['cash_limit'].'，扣除现金额度：'.$departData['cash_limit'];
			$remark2 = '管家下订单，信用额度：'.$departData['credit_limit'].'，扣除信用额度：'.$deduction;
			$remark3 = '管家下订单，扣除单团额度：0';
		
			//写入订单扣款表
			$this ->insertOrderDebit($orderArr['order_id'] ,1 ,$departData['cash_limit'] ,$remark1);
			$this ->insertOrderDebit($orderArr['order_id'] ,2 ,$deduction ,$remark2);
			$this ->insertOrderDebit($orderArr['order_id'] ,3 ,0 ,$remark3);
		
			//若扣除了营业部的现金额度，则写入订单交款表
			if ($departData['cash_limit'] > 0)
			{
				$remark = '管家下单，现金余额交款，交款金额：'.$departData['cash_limit'];
				$sk_id = $this ->insertOrderReceivable($orderArr, $departData['cash_limit'], $remark ,$departData['union_name']);
				$msgArr['sk_id'] = $sk_id;
			}
		}
		else
		{
			/***意外发生，额度不足啦**/
			/**发生这种情况得可能场景是： 同营业部，多人同时下单，其中一人占用了行锁，其他人等待解锁，解锁后营业部额度被扣，不够下一人使用*/
			$msgArr['code'] = 400;
		}
		return $msgArr;
	}
	
	/**
	 * @method 添加出游人
	 */
	public function addTraver($traverArr ,$suitData,$lineData,$orderArr)
	{
		//获取出游人群的成本
		if ($lineData['line_kind'] == 1)
		{
			//成人成本
			$adultprofit = round($suitData['adultprice']-$suitData['agent_rate_int'] ,2);
			//老人成本
			$oldprofit = 0;
			//小孩成本
			$childprofit = round($suitData['childprice']-$suitData['agent_rate_child'] ,2);
			//小孩不占床成本
			$childnobedprofit = round($suitData['childnobedprice']-$suitData['agent_rate_childno'] ,2);
		}
		else 
		{
			//单项产品
			//成人成本
			$adultprofit = $suitData['adultprofit'];
			//老人成本
			$oldprofit = $suitData['oldprofit'];
			//小孩成本
			$childprofit = $suitData['childprofit'];
			//小孩不占床成本
			$childnobedprofit = $suitData['childnobedprofit'];
		}
		
		$num = ceil(count($traverArr['name'])/100);
		
		$i = 0;
		$key = 0;
		for($i ;$i<$num ;$i++)
		{
			$sql = 'insert into u_member_traver
				(order_id,name,enname,certificate_type,certificate_no,endtime,telephone,sex,birthday,addtime,member_id,sign_place,sign_time,people_type,cost,price)
				values';
			
			$j = 0;
			for($j ;$j<100 ;$j++)
			{
				if (array_key_exists($key, $traverArr['name']))
				{
					$sql .= "({$orderArr['order_id']},";
					//中文姓名
					$sql .= "'{$traverArr['name'][$key]}',";
					//英文姓名
					if (array_key_exists($key, $traverArr['enname']))
					{
						$sql .= "'{$traverArr['enname'][$key]}',";
					}
					else 
					{
						$sql .= "'',";
					}
					//证件类型
					$sql .= "'{$traverArr['card_type'][$key]}',";
					//证件号
					$sql .= "'{$traverArr['card_num'][$key]}',";
					//有效期
					if (array_key_exists($key, $traverArr['endtime']))
					{
						$sql .= "'{$traverArr['endtime'][$key]}',";
					}
					else
					{
						$sql .= "'',";
					}
					//手机号
					$sql .= "'{$traverArr['tel'][$key]}',";
					//性别
					$sql .= "'{$traverArr['sex'][$key]}',";
					//生日 
					$sql .= "'{$traverArr['birthday'][$key]}',";
					//添加时间
					$sql .= "'{$orderArr['addtime']}',";
					//会员ID
					$sql .= "'{$orderArr['memberid']}',";
					//签发地
					if (array_key_exists($key, $traverArr['sign_place']))
					{
						$sql .= "'{$traverArr['sign_place'][$key]}',";
					}
					else
					{
						$sql .= "'',";
					}
					//签发时间
					if (array_key_exists($key, $traverArr['sign_time']))
					{
						$sql .= "'{$traverArr['sign_time'][$key]}',";
					}
					else
					{
						$sql .= "'',";
					}
					//出游人类型 
					$sql .= "'{$traverArr['people_type'][$key]}',";
					switch($traverArr['people_type'][$key])
					{
						case 1:// 成人
							$sql .= "'{$adultprofit}',";
							$sql .= "'{$suitData['adultprice']}'),";
							break;
						case 2: //老人
							$sql .= "'{$oldprofit}',";
							$sql .= "'{$suitData['oldprice']}'),";
							break;
						case 3: //儿童占床
							$sql .= "'{$childprofit}',";
							$sql .= "'{$suitData['childprice']}'),";
							break;
						case 4: //儿童不占床
							$sql .= "'{$childnobedprofit}',";
							$sql .= "'{$suitData['childnobedprice']}'),";
							break;
						default: //默认成人
							$sql .= "'{$adultprofit}',";
							$sql .= "'{$suitData['adultprice']}'),";
							break;
					}
					
					
					if ($j == 99)
					{
						$this ->db ->query(rtrim($sql,','));
					}
				}
				else 
				{
					$this ->db ->query(rtrim($sql,','));
					break;
				}
				$key ++;
			}
		}
		
		$sql = 'select id from u_member_traver where order_id ='.$orderArr['order_id'];
		$traverData = $this ->db->query($sql) ->result_array();
		
		$sql = 'insert into u_member_order_man (order_id,traver_id) values';
		
		foreach($traverData as $k =>$v)
		{
			$sql .= "({$orderArr['order_id']},{$v['id']}),";
		}
		$this ->db ->query(rtrim($sql ,','));
		
	}
	
	/**
	 * @method 记录旅行社佣金或外交佣金的计算方式
	 * @param unknown $orderArr 订单信息
	 * @param unknown $feeAgent 计算方式信息
	 */
	public function insertOrderAgent($orderArr,$feeAgent)
	{
		$dataArr = array(
				'order_id' =>$orderArr['order_id'],
				'type' =>$orderArr['platform_fee'] >0 ? 2 : 1,
				'kind' =>$feeAgent['kind'],
				'adultnum' =>$orderArr['dingnum'],
				'childnum' =>$orderArr['childnum'],
				'chilnobednum' =>$orderArr['childnobednum'],
				'oldnum' =>$orderArr['oldnum'],
				'adultprice' =>isset($feeAgent['adultprice']) ? $feeAgent['adultprice'] : 0,
				'childprice' =>isset($feeAgent['childprice']) ? $feeAgent['childprice'] : 0,
				'childnobedprice' =>isset($feeAgent['childnobedprice']) ? $feeAgent['childnobedprice'] : 0,
				'oldprice' =>isset($feeAgent['oldprice']) ? $feeAgent['oldprice'] : 0,
				'ratio' =>isset($feeAgent['ratio']) ? $feeAgent['ratio'] : 0,
				'days' =>isset($feeAgent['days']) ? $feeAgent['days'] : 0,
				'dayprice' =>isset($feeAgent['dayprice']) ? $feeAgent['dayprice'] : 0,
				'dayprice_child' =>isset($feeAgent['dayprice_child']) ? $feeAgent['dayprice_child'] : 0,
				'dayprice_childnobed' =>isset($feeAgent['dayprice_childnobed']) ? $feeAgent['dayprice_childnobed'] : 0,
				'dest_id' =>isset($feeAgent['destid']) ? $feeAgent['destid'] : 0,
				'amount' =>empty($orderArr['platform_fee']) ? $orderArr['diplomatic_agent'] : $orderArr['platform_fee']
		);
		$this ->db ->insert('u_order_agent' ,$dataArr);
		
	}
	
	
	/**
	 * @method 管家下单
	 * @param array $orderArr 订单信息
	 * @param array $lineData 线路信息
	 * @param array $memberArr 会员信息(可以是会员ID或者会员注册信息)
	 * @param array $suitData 线路套餐价格信息
	 * @param array $traverArr 出游人信息
	 * @param array $applyQuota 管家申请单团额度信息
	 * @param array $affiliatedArr 订单附属表信息
	 * @param array $managerId 经理ID
	 * @param array $agentArr 订单附属表信息
	 * @param array $feeAgent 记录旅行社佣金或外交佣金的计算方式
	 * @param array $affiliatedArr 订单附属信息
	 */
	public function create_order_t33($orderArr,$lineData,$suitData,$traverArr,$managerId,$agentArr,$memberArr,$affiliatedArr,$applyQuota=array(),$feeAgent=array())
	{
		$msgArr = array(
				'code' =>200,
				'order_id' =>'',
				'departArr' =>array(),
				'applyId' =>0,//额度申请表ID
				'receivableId' =>0,//交款表ID
		);
		$this->db->trans_begin();
		//注册会员
		if (is_array($memberArr) && !empty($memberArr))
		{
			$this ->db ->insert('u_member' ,$memberArr);
			$orderArr['memberid'] = $this ->db ->insert_id();
		}
		else 
		{
			//若已注册，则是ID
			$orderArr['memberid'] = $memberArr;
		}
		
		//生成订单号
		$orderArr['ordersn'] = $this ->createOrderCode();
		//写入订单
		$this ->order_model ->insert($orderArr);
		$orderId = $this ->db ->insert_id();
		
		$orderArr['order_id'] = $orderId;
		$orderArr['manager_id'] =$managerId;
		
		//写入订单附属表
		$affiliatedArr['order_id'] = $orderId;
		$status = $this ->db ->insert('u_member_order_affiliated' ,$affiliatedArr);
		
		//写入出游人表
		//$this ->insertTraver($traverArr, $orderArr['memberid'], $orderId, array());
		$this ->addTraver($traverArr ,$suitData,$lineData,$orderArr);
		
		//写入订单应付款表
		$this ->insertOrderYf($orderId, $orderArr, $managerId ,$lineData ,$suitData);
		
		if ($orderArr['platform_fee'] >0)
		{
			//订单旅行社佣金费表
			$this ->insertOrderYj($orderId, $orderArr, $managerId ,$agentArr ,$lineData);
		}
		//写入外交佣金账单表
		if ($orderArr['diplomatic_agent'] >0)
		{
			$this ->insertOrderWj($orderArr ,$feeAgent);
		}
		/*******以上部分，所有订单情况公用*********/
		
		//下单时的订单状态目前有 2,3,4,9,10,11
		if ($orderArr['status'] == 4)
		{
			//营业部额度充足，订单状态为已确认，分为两种情况，押金订单和非押金订单
			if (isset($affiliatedArr['deposit']) && $affiliatedArr['deposit'] >0)
			{
				/**这是押金订单，押金部分用营业部额度扣除，不可使用单团额度，但是非押金部分自动申请单团额度，并通过**/
				$infoArr = $this ->depositOrderQuota($orderArr, $applyQuota, $affiliatedArr);
				if ($infoArr['code'] == 400)
				{
					//回滚事务
					$this->db->trans_rollback();
				
					//并发影响，是营业部的额度不足已抵扣押金，返回给管家重新下单
					return $msgArr = array(
							'code' =>402, //管家下押金订单是额度充足的情况，但现在不够了
							'departArr' =>$infoArr['departArr']
					);
				}
			}
			else 
			{
				/**非押金订单，营业部额度充足的情况，管家不能申请单团额度**/
				$infoArr = $this ->adequateQuota($orderArr);
				if ($infoArr['code'] == 400)
				{
					//回滚事务
					$this->db->trans_rollback();
				
					//并发影响，是营业部的额度不足，返回给管家重新下单
					return $msgArr = array(
							'code' =>401, //管家下单是额度充足的情况，但现在不够了
							'departArr' =>$infoArr['departArr']
					);
				}
			}
		}
		elseif ($orderArr['status']==10 || $orderArr['status']==11 || $orderArr['status']==2 || $orderArr['status'] ==3)
		{
			/**管家申请了单团额度**/
			$infoArr = $this ->applyOrderQuota($orderArr, $applyQuota);
			if ($infoArr['code'] == 400)
			{
				//回滚事务
				$this->db->trans_rollback();
			
				//并发影响，是营业部的额度不足，返回给管家重新下单
				return $msgArr = array(
						'code' =>403, //管家下单是额度充足的情况，但现在不够了
						'departArr' =>$infoArr['departArr']
				);
			}
		}
		elseif ($orderArr['status'] = 9)
		{
			/**这里是临时保存的订单，不会扣除营业部额度**/
			
		}
		else 
		{
			//回滚事务
			$this->db->trans_rollback();
			return $msgArr = array(
					'code' =>700 //下单类型获取错误
			);
		}
		
		//写入订单应收账单表
		if ($orderArr['status'] == 9)
		{
			$this ->insertOrderYs($orderId ,$orderArr, $managerId ,0);
		}
		else 
		{
			$this ->insertOrderYs($orderId ,$orderArr, $managerId ,$infoArr['sk_id']);
		}
		
		//管家在线交款
		
		
		if ($orderArr['platform_fee'] >0 || $orderArr['diplomatic_agent'] >0 )
		{
			//记录旅行社佣金或外交佣金的计算方式 
			$this ->insertOrderAgent($orderArr,$feeAgent);
		}
		
		
		//记录订单日志
		$this ->orderLog($orderArr, $applyQuota ,$affiliatedArr);
		
		//确认状态的订单要扣除线路余位，更改旅行社剩余的结算佣金
		if ($orderArr['status'] == 4)
		{
			//更改线路套餐的订单数量 ,余位
			if ($orderArr['suitnum'] > 0)
			{
				$num = $orderArr['suitnum'];
			}
			else
			{
				$num = round($orderArr['dingnum'] + $orderArr['childnum'] + $orderArr['oldnum'] + $orderArr['childnobednum'] ,2);
			}
			
			$sql = 'update u_line_suit_price set order_num = order_num +1,number=number-'.$num.' where dayid ='.$suitData['dayid'];
			$status = $this ->db ->query($sql);
				
			//更改旅行社佣金
			$settle_agent = round($orderArr['diplomatic_agent'] + $orderArr['platform_fee'] ,2);
			$sql = 'update b_union set not_settle_agent = not_settle_agent + '.$settle_agent . ' where id = '.$orderArr['platform_id'];
			$status = $this ->db ->query($sql);
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msgArr['code'] = 500;
			return $msgArr;
		}
		else
		{
			$this->db->trans_commit();
			$msgArr['order_id'] = $orderId;
			$msgArr['applyId'] = isset($infoArr['applyId']) ? $infoArr['applyId'] : 0;
			$msgArr['receivableId'] = isset($infoArr['sk_id']) ? $infoArr['sk_id'] : 0;
			return $msgArr;
		}
	}
	
	/**
	 * 外交佣金的收取情况
	 * 1:供应商不是旅行社的直属供应商，则按旅行社设置的目的地收取外交佣金
	 * 2:旅行社添加的单项产品，指定向管家收取佣金，则为外交佣金。此情况分按比例和按人群两种计算方式
	 * @method 外交佣金账单
	 * @param unknown $orderId
	 * @param unknown $orderArr
	 */
	public function insertOrderWj($orderArr ,$feeAgent)
	{
		switch($feeAgent['kind'])
		{
			case 1: //按人群写入账单
			case 4: //按目的地收取
				$msg = $feeAgent['kind']==1 ? '按人群收取' : '按目的地收取';
				if ($orderArr['dingnum'] > 0)
				{
					if ($orderArr['suitnum'] > 0)
					{
						$num = $orderArr['suitnum'];
						$remark = '套餐线路外交佣金';
					}
					else
					{
						$num = $orderArr['dingnum'];
						$remark = '成人外交佣金';
					}
					$wjArr = array(
							'order_id' =>$orderArr['order_id'],
							'num' =>$num,
							'price' =>$feeAgent['adultprice'],
							'amount' =>round($num * $feeAgent['adultprice'] ,2),
							'user_type' =>1,
							'user_id' =>$orderArr['expert_id'],
							'user_name' =>$orderArr['expert_name'],
							'addtime' =>$orderArr['addtime'],
							'remark' =>$msg.$remark
					);
					$this ->db ->insert('u_order_bill_wj' ,$wjArr);
				}
				if ($orderArr['childnum'] > 0)
				{
					$wjArr = array(
							'order_id' =>$orderArr['order_id'],
							'num' =>$orderArr['childnum'],
							'price' =>$feeAgent['childprice'],
							'amount' =>round($orderArr['childnum'] * $feeAgent['childprice'] ,2),
							'user_type' =>1,
							'user_id' =>$orderArr['expert_id'],
							'user_name' =>$orderArr['expert_name'],
							'addtime' =>$orderArr['addtime'],
							'remark' =>$msg.'儿童占床外交佣金'
					);
					$this ->db ->insert('u_order_bill_wj' ,$wjArr);
				}
				if ($orderArr['childnobednum'] > 0)
				{
					$wjArr = array(
							'order_id' =>$orderArr['order_id'],
							'num' =>$orderArr['childnobednum'],
							'price' =>$feeAgent['childnobedprice'],
							'amount' =>round($orderArr['childnobednum'] * $feeAgent['childnobedprice'] ,2),
							'user_type' =>1,
							'user_id' =>$orderArr['expert_id'],
							'user_name' =>$orderArr['expert_name'],
							'addtime' =>$orderArr['addtime'],
							'remark' =>$msg.'儿童不占床外交佣金'
					);
					$this ->db ->insert('u_order_bill_wj' ,$wjArr);
				}
				break;
			case 2: //按比例写入
				$wjArr = array(
						'order_id' =>$orderArr['order_id'],
						'num' =>1,
						'price' =>$orderArr['diplomatic_agent'],
						'amount' =>$orderArr['diplomatic_agent'],
						'user_type' =>1,
						'user_id' =>$orderArr['expert_id'],
						'user_name' =>$orderArr['expert_name'],
						'addtime' =>$orderArr['addtime'],
						'remark' =>'按比例收取外交佣金，订单价格'.$orderArr['total_price'].'*收取比例'.$feeAgent['ratio']
				);
				$this ->db ->insert('u_order_bill_wj' ,$wjArr);
				break;
			default:
				$wjArr = array(
						'order_id' =>$orderArr['order_id'],
						'num' =>1,
						'price' =>$orderArr['diplomatic_agent'],
						'amount' =>$orderArr['diplomatic_agent'],
						'user_type' =>1,
						'user_id' =>$orderArr['expert_id'],
						'user_name' =>$orderArr['expert_name'],
						'addtime' =>$orderArr['addtime'],
						'remark' =>'外交佣金'
				);
				$this ->db ->insert('u_order_bill_wj' ,$wjArr);
				break;
		}
	}

	//写入管理费账单
	public function insertOrderYj($orderId ,$orderArr ,$managerId ,$agentArr ,$lineData)
	{
		if ($lineData['line_kind'] == 2) {
			//单项产品
			if (empty($agentArr)) {
				$agentArr['man'] = 0;
				$agentArr['oldman'] = 0;
				$agentArr['type'] = 1;
			} else {
				$agentArr['man'] = $agentArr['adult'];
				$agentArr['oldman'] = $agentArr['old'];
			}
		}

		if ($agentArr['type'] == 1 && $orderArr['platform_fee'] >0)
		{
			//按人头
			if ($orderArr['dingnum'] > 0)
			{
				if ($orderArr['suitnum'] > 0)
				{
					$amount = round($orderArr['suitnum'] * $agentArr['man'] ,2);
					
					$yjArr = array(
							'order_id' =>$orderId,
							'num' =>$orderArr['suitnum'],
							'price' =>$agentArr['man'],
							'amount' =>$amount,
							'union_id' =>$orderArr['platform_id'],
							'addtime' =>$orderArr['addtime'],
							'expert_id' =>$orderArr['expert_id'],
							'status'  =>2,
							'm_time' =>$orderArr['addtime'],
							'manager_id' =>$managerId,
							'a_id' =>$orderArr['platform_id'],
							'a_time' =>$orderArr['addtime'],
							'user_type' =>1,
							'user_id' =>$orderArr['expert_id'],
							'user_name' =>$orderArr['expert_name'],
							'item' =>'按人群',
							'remark' =>'套餐费用'.$agentArr['man'].'*份数'.$orderArr['suitnum'].'='.$amount
					);
					$this ->db ->insert('u_order_bill_yj' ,$yjArr);
				}
				else 
				{
					$amount = round($orderArr['dingnum'] * $agentArr['man'] ,2);
					
					$yjArr = array(
							'order_id' =>$orderId,
							'num' =>$orderArr['dingnum'],
							'price' =>$agentArr['man'],
							'amount' =>$amount,
							'union_id' =>$orderArr['platform_id'],
							'addtime' =>$orderArr['addtime'],
							'expert_id' =>$orderArr['expert_id'],
							'status'  =>2,
							'm_time' =>$orderArr['addtime'],
							'manager_id' =>$managerId,
							'a_id' =>$orderArr['platform_id'],
							'a_time' =>$orderArr['addtime'],
							'user_type' =>1,
							'user_id' =>$orderArr['expert_id'],
							'user_name' =>$orderArr['expert_name'],
							'item' =>'按人群',
							'remark' =>'成人费用'.$agentArr['man'].'*人数'.$orderArr['dingnum'].'='.$amount
					);
					$this ->db ->insert('u_order_bill_yj' ,$yjArr);
				}
				
			}
			if ($orderArr['childnum'] > 0)
			{
				$amount = round($orderArr['childnum'] * $agentArr['child'] ,2);

				$yjArr = array(
						'order_id' =>$orderId,
						'num' =>$orderArr['childnum'],
						'price' =>$agentArr['child'],
						'amount' =>$amount,
						'union_id' =>$orderArr['platform_id'],
						'addtime' =>$orderArr['addtime'],
						'expert_id' =>$orderArr['expert_id'],
						'status'  =>2,
						'm_time' =>$orderArr['addtime'],
						'manager_id' =>$managerId,
						'a_id' =>$orderArr['platform_id'],
						'a_time' =>$orderArr['addtime'],
						'user_type' =>1,
						'user_id' =>$orderArr['expert_id'],
						'user_name' =>$orderArr['expert_name'],
						'item' =>'按人群',
						'remark' =>'儿童占床费用'.$agentArr['child'].'*人数'.$orderArr['childnum'].'='.$amount
				);
				$this ->db ->insert('u_order_bill_yj' ,$yjArr);
			}
			if ($orderArr['childnobednum'] > 0)
			{
				$amount = round($orderArr['childnobednum'] * $agentArr['childnobed'] ,2);

				$yjArr = array(
						'order_id' =>$orderId,
						'num' =>$orderArr['childnobednum'],
						'price' =>$agentArr['childnobed'],
						'amount' =>$amount,
						'union_id' =>$orderArr['platform_id'],
						'addtime' =>$orderArr['addtime'],
						'expert_id' =>$orderArr['expert_id'],
						'status'  =>2,
						'm_time' =>$orderArr['addtime'],
						'manager_id' =>$managerId,
						'a_id' =>$orderArr['platform_id'],
						'a_time' =>$orderArr['addtime'],
						'user_type' =>1,
						'user_id' =>$orderArr['expert_id'],
						'user_name' =>$orderArr['expert_name'],
						'item' =>'按人群',
						'remark' =>'儿童不占床费用'.$agentArr['childnobed'].'*人数'.$orderArr['childnobednum'].'='.$amount
				);
				$this ->db ->insert('u_order_bill_yj' ,$yjArr);
			}
			if ($orderArr['oldnum'] > 0)
			{
				$amount = round($orderArr['oldnum'] * $agentArr['oldman'] ,2);

				$yjArr = array(
						'order_id' =>$orderId,
						'num' =>$orderArr['oldnum'],
						'price' =>$agentArr['oldman'],
						'amount' =>$amount,
						'union_id' =>$orderArr['platform_id'],
						'addtime' =>$orderArr['addtime'],
						'expert_id' =>$orderArr['expert_id'],
						'status'  =>2,
						'm_time' =>$orderArr['addtime'],
						'manager_id' =>$managerId,
						'a_id' =>$orderArr['platform_id'],
						'a_time' =>$orderArr['addtime'],
						'user_type' =>1,
						'user_id' =>$orderArr['expert_id'],
						'user_name' =>$orderArr['expert_name'],
						'item' =>'按人群',
						'remark' =>'老人费用'.$agentArr['oldman'].'*人数'.$orderArr['oldnum'].'='.$amount
				);
				$this ->db ->insert('u_order_bill_yj' ,$yjArr);
			}
		}
		elseif ($orderArr['platform_fee'] >0)
		{
			if ($agentArr['type'] == 2)
			{
				$price = round($orderArr['total_price'] * $agentArr['agent_rate'] ,2);
				$item = '按比例';
				$remark = '订单金额'.$orderArr['total_price'].'*管理费比例'.$agentArr['agent_rate'].'='.$price;
				//写入数据
				$this ->insertBillYj($orderArr, 1, $price, $managerId, $item, $remark);
			}
			else
			{
				//按天数收取管理费
				if ($orderArr['suitnum'] > 0) 
				{
					//套餐线路
					$num = $orderArr['suitnum'];
					$price = round($num*$agentArr['money'],2 );
					$item = '按天数';
					$remark = $num.'(份)*'.$agentArr['money'].'元/人='.$price;
					//写入数据，不区分人群
					$this ->insertBillYj($orderArr, 1, $price, $managerId, $item, $remark);
				}
				else 
				{
					//非套餐线路，需要区分人群写入数据库
					if ($orderArr['dingnum'] >0)
					{
						$item = '按天数成人';
						$remark = $orderArr['dingnum'].'(人)*'.$agentArr['money'].'元/人';
						$this ->insertBillYj($orderArr, $orderArr['dingnum'], $agentArr['money'], $managerId, $item, $remark);
					}
					if ($orderArr['childnobednum'] >0)
					{
						$item = '按天数儿童不占床';
						$remark = $orderArr['childnobednum'].'(人)*'.$agentArr['money_child'].'元/人';
						$this ->insertBillYj($orderArr, $orderArr['childnobednum'], $agentArr['money_child'], $managerId, $item, $remark);
					}
					if ($orderArr['childnum'] >0)
					{
						$item = '按天数儿童占床';
						$remark = $orderArr['childnum'].'(人)*'.$agentArr['money_childbed'].'元/人';
						$this ->insertBillYj($orderArr, $orderArr['childnum'], $agentArr['money_childbed'], $managerId, $item, $remark);
					}
				}
			}

// 			$yjArr = array(
// 					'order_id' =>$orderId,
// 					'num' =>1,
// 					'price' =>$price,
// 					'amount' =>$price,
// 					'union_id' =>$orderArr['platform_id'],
// 					'addtime' =>$orderArr['addtime'],
// 					'expert_id' =>$orderArr['expert_id'],
// 					'status'  =>2,
// 					'm_time' =>$orderArr['addtime'],
// 					'manager_id' =>$managerId,
// 					'a_id' =>$orderArr['platform_id'],
// 					'a_time' =>$orderArr['addtime'],
// 					'user_type' =>1,
// 					'user_id' =>$orderArr['expert_id'],
// 					'user_name' =>$orderArr['expert_name'],
// 					'item' =>$item,
// 					'remark' =>$remark
// 			);
// 			$this ->db ->insert('u_order_bill_yj' ,$yjArr);
		}
	}

	/**
	 * 写入管理费账单
	 * @param unknown $orderArr 订单信息
	 * @param unknown $num 数量
	 * @param unknown $price 单价
	 * @param unknown $managerId 营业部经理ID
	 * @param unknown $item 项目
	 * @param unknown $remark 备注
	 */
	public function insertBillYj($orderArr,$num,$price,$managerId,$item,$remark)
	{
		$yjArr = array(
				'order_id' =>$orderArr['order_id'],
				'num' =>$num,
				'price' =>$price,
				'amount' =>round($num*$price ,2),
				'union_id' =>$orderArr['platform_id'],
				'addtime' =>$orderArr['addtime'],
				'expert_id' =>$orderArr['expert_id'],
				'status'  =>2,
				'm_time' =>$orderArr['addtime'],
				'manager_id' =>$managerId,
				'a_id' =>$orderArr['platform_id'],
				'a_time' =>$orderArr['addtime'],
				'user_type' =>1,//申请人类型
				'user_id' =>$orderArr['expert_id'],
				'user_name' =>$orderArr['expert_name'],
				'item' =>$item,
				'remark' =>$remark
		);
		$this ->db ->insert('u_order_bill_yj' ,$yjArr);
	}
	
	
	/**
	 * @method 写入订单应付账单表
	 * @param unknown $orderId 订单ID
	 * @param unknown $orderArr 订单信息
	 * @param unknown $managerId 经理ID
	 * @param unknown $lineData 线路信息
	 */
	public function insertOrderYf($orderId ,$orderArr ,$managerId ,$lineData ,$suitData)
	{
		if ($orderArr['dingnum'] >0)
		{
			if ($orderArr['suitnum'] >0)
			{
				if ($lineData['line_kind'] == 1)
				{
					$price = round($suitData['adultprice']-$suitData['agent_rate_int'] ,2);
					$amount = round($price * $orderArr['suitnum'] ,2);
					$remark = "(套餐价格{$suitData['adultprice']}-管家佣金{$suitData['agent_rate_int']})*套餐数量{$orderArr['suitnum']}=".$amount;
				}
				else
				{
					$price = $suitData['adultprofit'];
					$amount = round($price * $orderArr['suitnum'] ,2);
					if ($lineData['line_kind'] ==2)
					{
						$remark = "旅行社设置成本{$suitData['adultprofit']}*套餐数量{$orderArr['suitnum']}=$amount";
					}
					else
					{
						$remark = "供应商设置成本{$suitData['adultprofit']}*套餐数量{$orderArr['suitnum']}=$amount";
					}
				}
					
				$yfArr = array(
						'order_id' =>$orderId,
						'expert_id' =>$orderArr['expert_id'],
						'depart_id' =>$orderArr['depart_id'],
						'num' =>$orderArr['suitnum'],
						'price' =>$price,
						'amount' =>$amount,
						//'remark' =>$remark,
						'remark' =>'管家下单，套餐成本',
						'status'=> 2,
						'addtime' =>$orderArr['addtime'],
						'manager_id' =>$managerId,
						'm_time' =>$orderArr['addtime'],
						's_time' =>$orderArr['addtime'],
						'supplier_id' =>$orderArr['supplier_id'],
						'user_type' =>1,
						'user_id' =>$orderArr['expert_id'],
						'user_name' =>$orderArr['expert_name'],
						'item' =>'套餐成本'
				);
				$this ->db ->insert('u_order_bill_yf' ,$yfArr);
			}
			else 
			{
				if ($lineData['line_kind'] == 1)
				{
					$price = round($suitData['adultprice']-$suitData['agent_rate_int'] ,2);
					$amount = round($price * $orderArr['dingnum'] ,2);
					$remark = "(成人价格{$suitData['adultprice']}-管家佣金{$suitData['agent_rate_int']})*成人数量{$orderArr['dingnum']}=".$amount;
				}
				else
				{
					$price = $suitData['adultprofit'];
					$amount = round($price * $orderArr['dingnum'] ,2);
					if ($lineData['line_kind'] ==2)
					{
						$remark = "旅行社设置成本{$suitData['adultprofit']}*成人数量{$orderArr['dingnum']}=$amount";
					}
					else
					{
						$remark = "供应商设置成本{$suitData['adultprofit']}*成人数量{$orderArr['dingnum']}=$amount";
					}
				}
					
				$yfArr = array(
						'order_id' =>$orderId,
						'expert_id' =>$orderArr['expert_id'],
						'depart_id' =>$orderArr['depart_id'],
						'num' =>$orderArr['dingnum'],
						'price' =>$price,
						'amount' =>$amount,
						//'remark' =>$remark,
						'remark' =>'管家下单，成人成本',
						'status'=> 2,
						'addtime' =>$orderArr['addtime'],
						'manager_id' =>$managerId,
						'm_time' =>$orderArr['addtime'],
						's_time' =>$orderArr['addtime'],
						'supplier_id' =>$orderArr['supplier_id'],
						'user_type' =>1,
						'user_id' =>$orderArr['expert_id'],
						'user_name' =>$orderArr['expert_name'],
						'item' =>'成人成本'
				);
				$this ->db ->insert('u_order_bill_yf' ,$yfArr);
			}
		}

		if ($orderArr['childnum'] >0)
		{
			if ($lineData['line_kind'] == 1)
			{
				
				$price = round($suitData['childprice']-$suitData['agent_rate_child'] ,2);
				$amount = round($price * $orderArr['childnum'] ,2);
				$remark = "(儿童价格{$suitData['childprice']}-管家佣金{$suitData['agent_rate_child']})*儿童数量{$orderArr['childnum']}=".$amount;
			}
			else
			{
				$price = $suitData['childprofit'];
				$amount = round($price * $orderArr['childnum'] ,2);
				if ($lineData['line_kind'] ==2)
				{
					$remark = "旅行社设置成本{$suitData['childprofit']}*儿童数量{$orderArr['childnum']}=$amount";
				}
				else
				{
					$remark = "供应商设置成本{$suitData['childprofit']}*儿童数量{$orderArr['childnum']}=$amount";
				}
			}

			$yfArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['childnum'],
					'price' =>$price,
					'amount' =>$amount,
					//'remark' =>$remark,
					'remark' =>'管家下单，儿童成本',
					'status'=> 2,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					's_time' =>$orderArr['addtime'],
					'supplier_id' =>$orderArr['supplier_id'],
					'user_type' =>1,
					'user_id' =>$orderArr['expert_id'],
					'user_name' =>$orderArr['expert_name'],
					'item' =>'儿童占床成本'
			);
			$this ->db ->insert('u_order_bill_yf' ,$yfArr);
		}
		if ($orderArr['childnobednum'] >0)
		{
			if ($lineData['line_kind'] == 1)
			{
				$price = round($suitData['childnobedprice']-$suitData['agent_rate_childno'] ,2);
				$amount = round($price * $orderArr['childnobednum'] ,2);
				$remark = "(儿童不占床价格{$suitData['childnobedprice']}-管家佣金{$suitData['agent_rate_childno']})*儿童不占床数量{$orderArr['childnobednum']}=".$amount;
			}
			else
			{
				$price = $suitData['childnobedprofit'];
				$amount = round($price * $orderArr['childnobednum'] ,2);
				if ($lineData['line_kind'] ==2)
				{
					$remark = "旅行社设置成本{$suitData['childnobedprofit']}*儿童不占床数量{$orderArr['childnobednum']}=$amount";
				}
				else
				{
					$remark = "供应商设置成本{$suitData['childnobedprofit']}*儿童不占床数量{$orderArr['childnobednum']}=$amount";
				}
			}

			$yfArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['childnobednum'],
					'price' =>$price,
					'amount' =>$amount,
					//'remark' =>$remark,
					'remark' =>'管家下单，儿童不占床成本',
					'status'=> 2,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					's_time' =>$orderArr['addtime'],
					'supplier_id' =>$orderArr['supplier_id'],
					'user_type' =>1,
					'user_id' =>$orderArr['expert_id'],
					'user_name' =>$orderArr['expert_name'],
					'item' =>'儿童不占床成本'
			);
			$this ->db ->insert('u_order_bill_yf' ,$yfArr);
		}
		if ($orderArr['oldnum'] >0)
		{
			if ($lineData['line_kind'] == 1)
			{
				$price = round($suitData['oldprice']-$suitData['agent_rate_int'] ,2);
				$amount = round($price * $orderArr['oldnum'] ,2);
				$remark = "(老人价格{$suitData['oldprice']}-管家佣金{$suitData['agent_rate_int']})*成人数量{$orderArr['oldnum']}=".$amount;
			}
			else
			{
				$price = $suitData['oldprofit'];
				$amount = round($price * $orderArr['oldnum'] ,2);
				if ($lineData['line_kind'] ==2)
				{
					$remark = "旅行社设置成本{$suitData['oldprofit']}*老人数量{$orderArr['oldnum']}=$amount";
				}
				else
				{
					$remark = "供应商设置成本{$suitData['oldprofit']}*老人数量{$orderArr['oldnum']}=$amount";
				}
			}

			$yfArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['oldnum'],
					'price' =>$price,
					'amount' =>$amount,
					//'remark' =>$remark,
					'remark' =>'管家下单，老人成本',
					'status'=> 2,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					's_time' =>$orderArr['addtime'],
					'supplier_id' =>$orderArr['supplier_id'],
					'user_type' =>1,
					'user_id' =>$orderArr['expert_id'],
					'user_name' =>$orderArr['expert_name'],
					'item' =>'老人成本'
			);
			$this ->db ->insert('u_order_bill_yf' ,$yfArr);
		}
	}

	//写入订单日志
	public function insertOrderLog($orderId ,$type ,$userid ,$time)
	{
		$logArr = array(
				'order_id' =>$orderId,
				'op_type' => $type,
				'userid' =>$userid,
				'content' =>'管家下单',
				'addtime' => date('Y-m-d H:i:s')
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
	}

	/**
	 * @method 写入订单应收账单表
	 * @param unknown $orderId 订单ID
	 * @param unknown $orderArr 订单信息
	 * @param unknown $managerId 经理ID
	 * @param unknown $sk_id 收款ID
	 */
	public function insertOrderYs($orderId ,$orderArr ,$managerId ,$sk_id)
	{
		if ($orderArr['suitnum'] > 0) {
			//购买的套餐类型
			$amount = round($orderArr['suitnum'] * $orderArr['price'],2);
			$ysArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['suitnum'],
					'price' =>$orderArr['price'],
					'amount' =>$amount,
					'remark' =>'多人套餐线路，套餐单价'.$orderArr['price'].' * 购买份数'.$orderArr['suitnum'].'='.$amount,
					'status'=> 1,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					'item' =>'套餐团费',
					'sk_id' =>$sk_id
			);
			$status = $this ->db ->insert('u_order_bill_ys' ,$ysArr);
		} else {
			$amount = round($orderArr['dingnum'] * $orderArr['price'],2);
			$ysArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['dingnum'],
					'price' =>$orderArr['price'],
					'amount' =>$amount,
					'remark' =>'单价'.$orderArr['price'].' * 成人数量'.$orderArr['dingnum'].'='.$amount,
					'status'=> 1,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					'item' =>'成人团费',
					'sk_id' =>$sk_id
			);
			$this ->db ->insert('u_order_bill_ys' ,$ysArr);
		}

		if ($orderArr['childnum'] > 0) {
			$amount = round($orderArr['childnum'] * $orderArr['childprice'],2);
			$ysArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['childnum'],
					'price' =>$orderArr['childprice'],
					'amount' =>$amount,
					'remark' =>'单价'.$orderArr['childprice'].' * 儿童数量'.$orderArr['childnum'].'='.$amount,
					'status'=> 1,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					'item' =>'儿童团费',
					'sk_id' =>$sk_id
			);
			$this ->db ->insert('u_order_bill_ys' ,$ysArr);
		}
		if ($orderArr['oldnum'] > 0) {
			$amount = round($orderArr['oldnum'] * $orderArr['oldprice'],2);
			$ysArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['oldnum'],
					'price' =>$orderArr['oldprice'],
					'amount' =>$amount,
					'remark' =>'单价'.$orderArr['oldprice'].' * 老人数量'.$orderArr['oldnum'].'='.$amount,
					'status'=> 1,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					'item' =>'老人团费',
					'sk_id' =>$sk_id
			);
			$this ->db ->insert('u_order_bill_ys' ,$ysArr);
		}
		if ($orderArr['childnobednum'] > 0) {
			$amount = round($orderArr['childnobednum'] * $orderArr['childnobedprice'],2);
			$ysArr = array(
					'order_id' =>$orderId,
					'expert_id' =>$orderArr['expert_id'],
					'depart_id' =>$orderArr['depart_id'],
					'num' =>$orderArr['childnobednum'],
					'price' =>$orderArr['childnobedprice'],
					'amount' =>$amount,
					'remark' =>'单价'.$orderArr['childnobedprice'].' * 儿童不占床数量'.$orderArr['childnobednum'].'='.$amount,
					'status'=> 1,
					'addtime' =>$orderArr['addtime'],
					'manager_id' =>$managerId,
					'm_time' =>$orderArr['addtime'],
					'item' =>'儿童不占床团费',
					'sk_id' =>$sk_id
			);
			$this ->db ->insert('u_order_bill_ys' ,$ysArr);
		}
	}



	/**
	 * @method 写入出游人表以及出游人保险关联表
	 * @author jkr
	 */
	public function insertTraver($traverArr ,$memberid ,$orderid ,$insuranceArr)
	{
		foreach($traverArr as $val) {
			$val['member_id'] = $memberid;
			$this ->db ->insert('u_member_traver' ,$val);
			$traverId = $this ->db ->insert_id();
			//出游人，订单关联表
			$orderManArr = array(
					'order_id' =>$orderid,
					'traver_id' =>$traverId
			);
			$this ->db ->insert('u_member_order_man' ,$orderManArr);
			//出游人保险表
			if (!empty($insuranceArr))
			{
				foreach($insuranceArr as $val)
				{
					$itArr = array(
							'order_id' =>$orderid,
							'traver_id' =>$traverId,
							'insurance_id' =>$val['insurance_id'],
							'is_down' =>0
					);
					$this ->db ->insert('u_insurance_traver' ,$itArr);
				}
			}
		}
	}

	/**
	 * @method 写入订单扣款表
	 * @author jkr
	 * @param intval $order_id 订单ID
	 * @param intval $type 扣款类型，1：营业部现金额度，2：营业部信用额度，3管家信用额度
	 * @param floatval $amount 扣除金额
	 * @param string $remark 备注
	 */
	public function insertOrderDebit ($order_id ,$type ,$amount ,$remark='')
	{
		$debitArr = array(
				'order_id' =>$order_id,
				'type' =>$type,
				'real_amount' =>$amount,
				'addtime' =>date('Y-m-d H:i:s'),
				'status' =>0,
				'remark' =>$remark
		);
		$this ->db ->insert('u_order_debit' ,$debitArr);
	}
	
	//获取订单号
	public function createOrderCode()
	{
		$this ->db ->insert('u_order_code' ,array('code' =>'a'));
		return $this ->db ->insert_id();
	}

	/**
	 * @method 会员下单
	 * @param unknown $orderArr  订单信息
	 * @param unknown $traverArr  出游人信息
	 * @param unknown $insuranceArr  保险信息
	 * @param unknown $jifen  使用的积分
	 * @param intval  $member_coupon_id  用户关联优惠券的ID
	 */
	public function userCreateOrder($orderArr ,$traverArr ,$insuranceArr ,$jifen ,$member_coupon_id) {
		$this->db->trans_start();
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		//写入订单
		$orderArr['ordersn'] = $this ->createOrderCode();
		$this ->db ->insert('u_member_order' ,$orderArr);
		$order_id = $this ->db ->insert_id();

		$this->order_status_model->update_order_status_cal($order_id);
		//写入订单日志表
		$logArr = array(
				'order_id' =>$order_id,
				'op_type' => 0,
				'userid' =>$orderArr['memberid'],
				'content' =>'会员下单',
				'addtime' => $time
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//会员积分更改
		if (!empty($jifen)) {
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
					'addtime' =>$time
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
		foreach($traverArr as $val) {
			$val['member_id'] = $orderArr['memberid'];
			$this ->db ->insert('u_member_traver' ,$val);
			$traverId = $this ->db ->insert_id();
			//出游人，订单关联表
			$orderManArr = array(
					'order_id' =>$order_id,
					'traver_id' =>$traverId
			);
			$this ->db ->insert('u_member_order_man' ,$orderManArr);
			//出游人保险表
			if (!empty($insuranceArr))
			{
				foreach($insuranceArr as $val)
				{
					$itArr = array(
							'order_id' =>$order_id,
							'traver_id' =>$traverId,
							'insurance_id' =>$val['insurance_id'],
							'is_down' =>0
					);
					$this ->db ->insert('u_insurance_traver' ,$itArr);
				}
			}
		}
		//写入保险表
		if (!empty($insuranceArr)) {
			foreach($insuranceArr as &$val) {
				$val['order_id'] = $order_id;
				unset($val['name']);
				unset($val['price']);
				$this ->db ->insert('u_order_insurance' ,$val);
			}
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return $order_id;
		}
	}
	/**
	 * @method 获取订单关联发票信息
	 * @param unknown $orderid
	 */
	public function getOrderInvoice($orderid)
	{
		$sql = 'select * from u_member_order_invoice where order_id='.$orderid;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 订单发票
	 * @author jiakairong
	 * @since  2015-11-25
	 * @param unknown $invoiceArr
	 * @param unknown $orderid
	 */
	public function orderInvoiceInsert($invoiceArr ,$orderid)
	{
		$this->db->trans_start();
		//更改订单的发票状态
		$sql = 'update u_member_order set isneedpiao = 1 where id='.$orderid;
		$this ->db ->query($sql);
		//写入发票信息表
		$this ->db ->insert('u_member_invoice' ,$invoiceArr);
		$invoiceid = $this ->db ->insert_id();
		//写入订单发票关联表
		$oiArr = array(
				'order_id' =>$orderid,
				'invoice_id' =>$invoiceid
		);
		$this ->db ->insert('u_member_order_invoice' ,$oiArr);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @method 会员支付，更改订单状态
	 * @param unknown $userid  会员ID
	 * @param unknown $detailArr 付款详情信息
	 */
	public function orderPay($userid ,$detailArr ,$orderData)
	{
		$this->db->trans_start();
		//更改订单付款状态
		//$sql = 'update u_member_order set ispay = 1,first_pay='.$detailArr['amount'].',final_pay=0 where id = '.$detailArr['order_id'];
		$sql = 'update u_member_order set ispay = 1 where id = '.$detailArr['order_id'];
		$this ->db ->query($sql);
		//写入订单日志
		$logArr = array(
				'order_id' =>$detailArr['order_id'],
				'op_type' =>0,
				'userid' =>$userid,
				'content' =>'会员自己付款',
				'addtime' =>$detailArr['addtime']
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//写入付款详情表
		$this ->db ->insert('u_order_detail' ,$detailArr);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 订单改团，支付差价
	 * @param  $userid 会员ID
	 * @param  $detailArr 付款信息
	 */
	public function orderPayFinal($userid ,$detailArr)
	{
		$this->db->trans_start();
		//更改订单付款状态
		$sql = 'update u_member_order set final_pay='.$detailArr['amount'].' where id = '.$detailArr['order_id'];
		$this ->db ->query($sql);
		//写入订单日志
		$logArr = array(
				'order_id' =>$detailArr['order_id'],
				'op_type' =>0,
				'userid' =>$userid,
				'content' =>'订单改团，支付差价',
				'addtime' =>$detailArr['addtime']
		);
		$this ->db ->insert('u_member_order_log' ,$logArr);
		//写入付款详情表
		$this ->db ->insert('u_order_detail' ,$detailArr);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	//获得所有的线路订单
	function get_all_line_order($whereArr, $page = 1, $num = 10){
		$this->db->select('
				mb_od.id AS order_id,
				mb_od.supplier_id as supplier_id ,
				l.linename,
				l.overcity,
				ls.unit,
				mb_od.ordersn AS order_sn,
				mb_od.memberid AS member_sn,
				mb_od.productname AS product_title,
				(mb_od.dingnum+mb_od.childnum+mb_od.childnobednum+mb_od.oldnum) AS people_num,
				mb_od.total_price AS order_amount,
				mb_od.usedate AS usedate,
				mb_od.status as status,
				mb_od.ispay,
				mb_od.dingnum,
				mb_od.settlement_price,
				mb_od.diff_price,
				mb_od.addtime AS addtime,
				mb_od.productautoid as line_id,
				mb_od.expert_id as expert_id,
				mb_od.linkmobile as mobile,
				mb_od.trun_status,
				 mb.mobile as m_mobile,
				 co.id as commentid');
		$this->db->from('u_member_order AS mb_od');
		$this->db->join('u_member AS mb', 'mb_od.memberid = mb.mid', 'left');
		$this->db->join('u_line AS l', 'mb_od.productautoid = l.id', 'left');
		$this->db->join('u_order_detail AS or_de', 'or_de.order_id = mb_od.id', 'left');
		$this->db->join('u_line_suit AS ls', 'ls.id = mb_od.suitid', 'left');
		$this->db->join('u_comment AS co', 'mb_od.id = co.orderid and co.status=1', 'left');
		$this->db->where($whereArr);
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
        		$this->db->order_by('mb_od.addtime DESC,mb_od.status asc');
        		$this->db->group_by('mb_od.id');
		$query = $this->db->get();
		//print_r($this->session->userdata('userid'));exit();
		$ret_arr = array();
		$ret_arr = $query->result_array();
		array_walk($ret_arr, array($this, '_fetch_list'));

		return $ret_arr;
	}


	//进度追踪
	function get_progress_tracking($order_id){
		$this->db->select("id,addtime,content");
		$this->db->from("u_member_order_log");
		$where['order_id'] = $order_id;
		$where['type'] = 0;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;
	}

	//联系人信息
	function get_contact($order_id){
		$this->db->select("id,linkman,linkmobile ,linktel,linkemail AS 'E-mail'");
		$this->db->from("u_member_order");
		$where['id'] = $order_id;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;

	}

	//出游人信息
	function get_travel($where){
		$this->db->select("mt.id,mt.name,dict.description as certificate_type,mt.certificate_no,mt.certificate_type as certificate,
		mt.endtime,mt.country ,mt.telephone ,mt.sex,mt.enname,mt.sign_place,mt.sign_time,
		mt.birthday");
		$this->db->from("u_member_traver AS mt");
		$this->db->join('u_member_order_man AS mom','mt.id=mom.traver_id','left');
		$this->db->join('u_dictionary AS dict','dict.dict_id=mt.certificate_type','left');
		//$where['mom.order_id'] = $order_id;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;

	}

	//修改游客信息
	function updata_travel($id,$data){

	   $this->db->where('id', $id);
	   $re= $this->db->update('u_member_traver', $data);
	   return $re;

	}
	//发票信息
	function get_invoice($order_id){
		$this->db->select("mi.id,mi.invoice_name ,mi.invoice_detail ,mo.total_price ,mi.telephone,mi.receiver,mi.address");
		$this->db->from("u_member_order_invoice AS moi");
		$this->db->join('u_member_invoice AS mi','moi.invoice_id=mi.id','left');
		$this->db->join('u_member_order AS mo','moi.order_id=mo.id','left');
		$where['mo.id'] = $order_id;
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr;


	}
	//用户保险
	function get_insurance($order_id){
/* 		$this->db->select("id,sum(num) as mun ,amount as free");
		$this->db->from("u_order_insurance ");
		$this->db->where($where);
		$query = $this->db->get();
		$ret_arr = $query->result_array();
		return $ret_arr; */
		$sql = "select id,sum(amount) as 'amount',order_id from u_order_insurance where order_id=".$order_id;
		return $this ->db ->query($sql) ->result_array();
	}
	//保存发票信息
	function updata_invoice($id,$data){
		$this->db->where('id', $id);
		$re= $this->db->update('u_member_invoice', $data);
		return $re;

	}
	//修改联系人
	function updata_concact($id,$data){
		$this->db->where('id', $id);
		$re= $this->db->update('u_member_order', $data);
		return $re;

	}
	//修改用户积分
	function update_member_jifen($member_id,$jifen){
		$sql = "UPDATE u_member SET jifen = jifen+$jifen WHERE mid= {$member_id}";
		return $this->db->query($sql);
	}
     //会员信息
     function get_member_data($where){
     	$this->db->select("mb.mid,mb.litpic,mb.nickname,mb.truename,mb.mobile,mb.jifen,mb.loginname ");
     	$this->db->from("u_member as mb");
     	$this->db->where($where);
     	$query = $this->db->get();
     	$ret_arr=$query->result_array();
     	return $ret_arr[0];
     }
     //我的消息
     function get_member_message($where){
     	$this->db->select("COUNT(*) as num");
     	$this->db->from(" u_message as me");
     	$this->db->join('u_member as m','me.receipt_id=m.mid','left');
     	$this->db->where($where);
     	$this->db->where(array('me.msg_type'=>0));
     	$query = $this->db->get();
     	$ret_arr=$query->result_array();
     	return $ret_arr[0];
     }
	/**
	 * @param 订单id号 $order_id
	 * @param 操作的内容 $log_content
	 */
	function order_log($order_id,$log_content,$order_status){
		$log_data['order_id'] = $order_id;
		$log_data['op_type'] = 0;
		$log_data['userid'] = $this->session->userdata('c_userid');
		$log_data['content'] = $log_content;
		$log_data['order_status']=$order_status;
		$log_data['addtime'] = date('Y-m-d H:i:s');
		$this->db->insert('u_member_order_log',$log_data);
	}

	//修改游客信息
	function updata_Stock($where,$data){

		$this->db->where($where);
		$re= $this->db->update('u_line_suit_price', $data);
		return $re;

	}



protected function _fetch_list(&$value, $key) {
	switch($value['status']){
		case -4:
			$value['status_opera'] = '-4';
			if($value['ispay']==0){
				$value['status']='已取消';
			}elseif($value['ispay']==4){
				$value['status']='已退订';
			}else{
				$value['status']='已取消';
			}
			break;
		case -3:
			$value['status_opera'] = '-3';
			$value['status'] = '退订中';
			break;
		case -2:
			$value['status'] = '旅行社拒绝';
			$value['status_opera'] = '-2';
			break;
		case -1:
			$value['status'] = '供应商拒绝';
			$value['status_opera'] = '-1';
			break;
		case 0:

			$value['status'] = '待付款';
			$value['status_opera'] = '0';
			break;

		case 1:
			$value['status'] = '待确认';
			$value['status_opera'] = '1';
			if($value['ispay']==2){
				if(!empty($value['order_id'])){
				   $refuse_reason = $this->select_refund_reason($value['order_id']);
				}
				if(!empty($refuse_reason)){
					$value['refuse_reason'] =  $refuse_reason['beizhu'];
				}
			}
			break;
		case 2:
			$value['status'] = '待确认';
			$value['status_opera'] = '2';
			break;
		case 3:
			$value['status'] = '待确认';
			$value['status_opera'] = '3';
			break;
		case 4:
			$value['status'] = '已确认';
			$value['status_opera'] = '4';
			break;
		case 5:
			$value['status'] = '出团中';
			$value['status_opera'] = '5';
			break;
		case 6:
			$value['status'] = '已点评';
			$value['status_opera'] = '6';
			break;
		case 7:
			$value['status'] = '已投诉';
			$value['status_opera'] = '7';
			break;
		case 8:
			$value['status'] = '行程结束';
			$value['status_opera'] = '8';
			break;
		case 9:
			$value['status'] = '待确认';
			$value['status_opera'] = '9';
			break;
		case 10:
			$value['status'] = '待确认';
			$value['status_opera'] = '10';
			break;
		case 11:
			$value['status'] = '待确认';
			$value['status_opera'] = '11';
			break;
		default: $value['status'] = '订单状态';break;
	}

	switch($value['ispay']){
		case 0:
			$date=$this->get_time($value['addtime']);
	/* 		if(!empty($date['time'])){    //订单时间已经超过24小时；
			 	if($date['time']>24 || $value['status']==-4 ){
					//$value['status'] = '已经失效';
			 		$value['status'] = '已取消';
					$value['status_opera'] = '-4';
					$value['ispay'] = '未付款';
					$value['ispay_code']=0;
					break;
				}else{
					$value['ispay'] = '未付款';
					$value['ispay_code']=0;
					break;
				}
			}else */
		/* 	if(strtotime($value['usedate'])<time()){  //出行时间已过期；
				//$value['status'] = '已经失效';
				$value['status'] = '已取消';
				$value['status_opera'] = '-4';
				$value['ispay'] = '未付款';
				$value['ispay_code']=0;
				break;
			}else{ */
				$value['ispay'] = '未付款';
				$value['ispay_code']=0;
				break;
		//	}
		case 1:
			//判断是否退款,退款成功,支付状态为空
			$value['ispay'] = '确认中';
			$value['ispay_code'] = 1;
			break;
		case 2:
			//判断是否退款,退款成功,支付状态为空
			$value['ispay'] = '已付款';
			$value['ispay_code'] = 2;

			break;
		case 3:
			$value['ispay'] = '退款中';
			$value['ispay_code'] = 3;
		break;
		case 4:
			$value['ispay'] = '已退款';
			$value['ispay_code'] = 4;
		break;
		case 5:
			$value['ispay'] = '未交款';
			$value['ispay_code'] = 4;
		break;
		case 6:
			$value['ispay'] = '已交款';
			$value['ispay_code'] = 4;
		break;

		default: $value['ispay'] = '支付状态';$value['ispay_code'] = '';break;
	}

}
	/*
	 * 获取订单信息
	 * 贾开荣
	 */
	public function get_order_data($where) {
		$this ->db ->select('mo.expert_id,mo.status,mo.id,mo.ordersn,mo.addtime,mo.usedate,l.lineday,mo.ispay,mo.first_pay,s.cityname,mo.productname,l.first_pay_rate,mo.linkman,l.overcity,mo.total_price');
		$this ->db ->from('u_member_order as mo');
		$this ->db ->join('u_line as l','l.id = mo.productautoid' ,'left');
		$this ->db ->join('u_startplace as s' ,'l.startcity = s.id' ,'left');
		$this ->db ->where($where);
		$query = $this ->db ->get();
		$data = $query ->result_array();
		if (empty($data))
			return false;
		else
			return $data[0];
	}

	public function get_order_message($where) {
		$this ->db ->select('mo.settlement_price,mo.expert_id,mo.status,mo.suitnum,mo.id,mo.ordersn,mo.addtime,mo.usedate,l.lineday,mo.ispay,mo.first_pay,s.cityname,mo.productname,l.first_pay_rate,mo.linkman,l.overcity,mo.total_price');
		$this ->db ->from('u_member_order as mo');
		$this ->db ->join('u_line as l','l.id = mo.productautoid' ,'left');
		$this ->db ->join('u_startplace as s' ,'l.startcity = s.id' ,'left');
		$this ->db ->where($where);
		$query = $this ->db ->get();
		$data = $query ->result_array();

		array_walk($data, array($this, '_fetch_list'));


		if (empty($data))
			return false;
		else
			return $data[0];
	}
	/**
	 * @method 根据线路的目的地ID获取目的地
	 * @author 贾开荣
	 */
	public function get_dest_line ($overcity) {
		$sql = "select * from u_dest_base where id in ({$overcity})";
		$query = $this ->db ->query($sql);
		$data = $query ->result_array();
		return $data;
	}
	/*
	 * 获取产品信息
	*/
	public function get_product_data($where) {
		$this ->db ->select('mo.id,mo.settlement_price,mo.suitnum,mo.ordersn,ls.unit,ls.suitname,l.id as lineid,mo.jifen,mo.jifenprice,mo.couponprice,mo.addtime ,mo.usedate,s.cityname , mo.productname ,mo.price ,mo.dingnum ,mo.childnum ,mo.childnobednum ,mo.childnobedprice,mo.total_price,mo.childprice ,l.linedocname,l.linedoc,mo.oldnum,mo.oldprice,i.amount,(mo.jifenprice+mo.couponprice) as saveprice,l.overcity');
		$this ->db ->from('u_member_order as mo');
		$this ->db ->join('u_line as l ','mo.productautoid = l.id' ,'left');
		$this ->db ->join('u_startplace as s' ,'l.startcity = s.id' ,'left');
		$this ->db ->join('u_order_insurance as i' ,'i.order_id = mo.id' ,'left');
		$this->db->join('u_line_suit AS ls', 'ls.id = mo.suitid', 'left');
		$this ->db ->where($where);
		$query = $this ->db ->get();
		$data = $query ->result_array();
		if (empty($data))
			return false;
		else
			return $data[0];
	}
	public function select_data($type){
	   	$query = $this->db->query('SELECT dict_id,description FROM  u_dictionary WHERE pid IN (SELECT dict_id FROM  u_dictionary WHERE dict_code ="'.$type.'" ) ORDER BY showorder ASC');
	   	$rows = $query->result_array();
	   	return $rows;
	}
	//查询表的数据
	public function select_table($order_id){
	   	$query = $this->db->query("select r.status from  u_refund AS r where r.order_id=$order_id order by modtime desc limit 1");
	   	$rows = $query->row_array();
	   	return $rows;
	}
	//查询退款被拒绝的理由
	public function select_refund_reason($order_id){
	   	$query = $this->db->query('SELECT r.order_id,r.beizhu FROM u_refund AS r WHERE r.status=2 AND order_id='.$order_id.' order by modtime desc limit 1');
	   	$rows = $query->row_array();
	   	return $rows;
	}
	//查询时间
	public function get_time($data){
	   	$query = $this->db->query('select TIMESTAMPDIFF(HOUR,"'.$data.'",NOW()) as time');
	   	$rows = $query->row_array();
	   	return $rows;
	}
	//修改订单的状态位
	public function updata_order_stutas($where,$data){
	   	 $this->db->where($where);
	     	return   $this->db->update('u_member_order', $data);
	}
	   /**
	    * 订单退款
	    * @param  int      $order_id   订单ID
	    * @param string    $reason     退款原因
	    * @param string    $mobile     用户手机号码
	    * @return bool
	    */
	   public  function insert_order_refund($order_id,$reason,$mobile,$userid){
		   	$insert_refund_sql = "insert into u_refund(order_id,reason,bankcard,bankname,mobile,modtime,addtime,amount_apply,status,refund_type,refund_id) select $order_id,'$reason',bankcard,bankname,'$mobile',NOW(),NOW(),SUM(amount) AS amount,0,0,'$userid' from u_order_detail where order_id=$order_id";
		    return	$this->db->query($insert_refund_sql);
	   }
	   //查询订单的状态
	   public function select_order_stutas($id){
	   	$query = $this->db->query('select status from u_member_order where id=.'.$id);
	   	$rows = $query->row_array();
	   	return $rows;
	   }
	   //查询单个订单的信息
	   function get_alldata($table,$where){
	   	$this->db->select('*');
	   	$this->db->where($where);
	   	return  $this->db->get($table)->row_array();
	   }
	   //插入表
	   public function insert_tabledata($table,$data){
	   	  $this->db->insert($table, $data);
	   	 return $this->db->insert_id();
	   }
	   public function get_ordermessage($where){
		   	$this ->db ->select('mo.expert_id,l.linename,mo.ordersn,mo.status,mo.id,mo.ordersn,mo.addtime,mo.usedate,l.lineday,mo.ispay,mo.first_pay,mo.productname,l.first_pay_rate,mo.linkman,l.overcity,mo.total_price');
		   	$this ->db ->from('u_member_order as mo');
		   	$this ->db ->join('u_line as l','l.id = mo.productautoid' ,'left');
		   	$this ->db ->where($where);
		   	$query = $this ->db ->get();
		   	return $query ->row_array();

	   }
	   //修改线路评论的数量
	   public function update_comment_count($lineid){
		   	$query = $this->db->query('update u_line set comment_count=comment_count+1 where id='.$lineid);
		   	return $query;
	   }
	   //修改管家评论线路的数量
	   public function update_expert_comment_count($expert_id){
		   	$query = $this->db->query('update u_expert set comment_count=comment_count+1 where id='.$expert_id);
		   	return $query;
	   }

	   //获取线路出发地
	   function  select_startplace($likeArr){
	   	$this->db->select('ls.id,ls.line_id,ls.startplace_id,st.cityname');
	   	$this->db->from('u_line_startplace AS ls ');
	   	$this->db->join('u_startplace AS st','st.id = ls.startplace_id','left');
	   	$this ->db ->where($likeArr);
	   	$query = $this->db->get ();
	   	return $query->result_array ();
	   }

   	  //删除线路评价
	  public  function updata_comment($id,$orderid){
	  	$this->db->trans_start();

	  	//修改评论状态
	  	$this->db->where('id', $id)->update('u_comment', array('status'=>0));

	  	//修改订单状态
	  	$order=$this->db->select('status')->where(array('id'=>$orderid))->get('u_member_order')->row_array();
	  	if(!empty($order)){
	  		if($order['status']==6){
	  			$this->db->where('id', $orderid)->update('u_member_order', array('status'=>5));
	  		}
	  	}
	  	//$member=$this->db->select('*')->from('u_comment') ->where(array('id'=>$id))->get ()->row_array ();
	  	$member = $this->db->query("select c.jifen as cjifen,c.memberid,m.jifen as jifen from u_comment as c left join u_member as m on c.memberid=m.mid where c.id={$id}")->row_array ();
	  	//回滚积分
	  	$integral='-'.$member['cjifen'];
	  	$jifenArr['member_id']=$member['memberid'];
		$jifenArr['point_before']=$member['jifen'];
		$jifenArr['point_after']=$member['jifen']+$integral;
		$jifenArr['point']=$member['cjifen'];
		$jifenArr['content']='删除评论减去的积分';
		$jifenArr['addtime']=date('Y-m-d H:i:s',time());
		$this->db->insert('u_member_point_log',$jifenArr);

		//减去用户积分
		$sql = "UPDATE u_member SET jifen = jifen-{$member['cjifen']} WHERE mid= {$member['memberid']}";
	          $this->db->query($sql);

  		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			return true;
		}

	  }
	 //查询今天的订单评价表
	  function get_today_complain($order_id){
	  	$date=date('Y-m-d',time());
	  	$query = $this->db->query("SELECT id from u_complain where  date_format(addtime ,'%Y-%m-%d')='{$date}' and order_id={$order_id}");
		$rows = $query->row_array();
	   	return $rows;
	  }

}

