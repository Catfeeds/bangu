<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_order_model extends MY_Model {
	private $table_name = 'u_member_order';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	//全部订单
	public function get_order_refund($param, $page){
		$query_sql = 'select	mo.balance_status,mo.user_type,mo.ordersn,mo.status,mo.suitid,l.id as lid,mo.id as order_id, ';
		$query_sql .= 'l.lineday,mo.expert_id,l.linename,mo.id,mo.dingnum,mo.usedate,mo.item_code as linesn,';
		$query_sql .= 'l.linecode,(mo.childnum + mo.dingnum + mo.childnobednum + mo.oldnum) as "num",l.overcity,';
		$query_sql .= 'e.realname,e.depart_name,mo.addtime,sre.refund_money,byf.id as bill_id,byf.kind,';
		$query_sql .= '(select sum(money) from u_order_receivable where status = 2 and order_id = mo.id) as receive_price,';
		$query_sql .= 'mo.balance_money,(mo.supplier_cost - mo.platform_fee - mo.balance_money) as un_money,';
		$query_sql .= 'CASE WHEN mo. STATUS = - 4 THEN	"已取消" WHEN mo. STATUS = - 3 THEN "退订中" ';
		$query_sql .= 'WHEN mo. STATUS = - 2 THEN "平台拒绝" WHEN mo. STATUS = - 1 THEN "供应商拒绝" ';
		$query_sql .= 'WHEN mo. STATUS = 0 THEN "待留位" WHEN mo. STATUS = 1 THEN "已留位" ';
		$query_sql .= 'WHEN mo. STATUS = 2 THEN	"待确认" WHEN mo. STATUS = 2 THEN "待确认" ';
		$query_sql .= 'WHEN mo. STATUS = 3 THEN "待确认" WHEN mo. STATUS = 4 THEN "已确认" ';
		$query_sql .= 'WHEN mo. STATUS = 5 THEN "出团中" WHEN mo. STATUS = 6 THEN "已评论" ';
		$query_sql .= 'WHEN mo. STATUS = 7 THEN "已投诉" WHEN mo. STATUS = 8 THEN "行程结束" END "o_status", ';
		$query_sql .= '(mo.supplier_cost - mo.platform_fee ) AS balance_cost,mo.supplier_cost, mo.platform_fee, ';
		$query_sql .= '(select sum(credit_limit)  from b_limit_apply where order_id = mo.id) as credit_limit, ';
		$query_sql .= '(mo.supplier_cost-mo.balance_money) as s_money,byf.amount,sre.status as re_status ';
		$query_sql .= 'FROM u_order_bill_yf as byf  ';
		$query_sql .= 'LEFT JOIN	u_member_order AS mo on mo.id=byf.order_id ';
		$query_sql .= 'LEFT JOIN u_line AS l ON l.id = mo.productautoid ';
		$query_sql .= 'LEFT JOIN u_line_suit AS ls ON ls.id = mo.suitid ';
		$query_sql .= 'LEFT JOIN u_expert AS e ON mo.expert_id = e.id ';
		$query_sql .= 'LEFT JOIN u_line_startplace AS lse ON lse.line_id = l.id ';
		$query_sql .= 'LEFT JOIN u_startplace AS s ON s.id = lse.startplace_id ';
		$query_sql .='LEFT JOIN u_supplier_refund as sre on sre.yf_id=byf.id and sre.status!=2 and sre.status!=-1 ';
		$query_sql .= 'WHERE mo. STATUS != 9 and byf.kind=2 AND byf.user_type=1 ';
		if ($param != null) {
			
			if (null != array_key_exists ( 'supplier_id', $param )) {
				$query_sql .= '  AND mo.supplier_id= ? ';
				$param['supplier_id'] = trim($param['supplier_id']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= '  AND l.linecode= ? ';
				$param['linecode'] = trim($param['linecode']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param['linename'] = '%' .trim($param['linename'] ). '%';
			}
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param['ordersn'] =trim($param['ordersn']);
			}
			if (null != array_key_exists ( 'status', $param )) {
				$query_sql .= ' AND byf.status = ? ';
				$param['status'] =trim($param['status']);
			}
		}

		$query_sql .='  GROUP BY byf.id   ORDER BY	mo.addtime DESC ';

		return $this->queryPageJson ( $query_sql, $param, $page );
	}
}