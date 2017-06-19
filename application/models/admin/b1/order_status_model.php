<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_status_model extends MY_Model {
	private $table_name = 'u_member_order';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	//全部订单
	public function get_order_list($param, $page,$supplier_id){
		$query_sql = 'select mo.balance_status,mo.user_type,mo.ordersn,mo.status,mo.suitid,l.id AS lid,l.lineday,';
		$query_sql .= 'mo.expert_id,l.linename,mo.id,mo.dingnum,mo.usedate,mo.item_code as linesn,l.linecode,';
		$query_sql .= '(mo.childnum + mo.dingnum + mo.childnobednum + mo.oldnum) AS "num",l.overcity ,';
		$query_sql .= '(mo.total_price + mo.settlement_price) AS total_price,e.realname,e.depart_name,mo.addtime,';
		$query_sql .= 'case when mo.ispay = 0 then "未付款" when mo.ispay = 1 then "确认中" when mo.ispay = 2 then "已收款" end "ispay",' ;
		$query_sql .='case when mo.status = -4 then "已取消" when mo.status = -3 then "退订中" when mo.status = -2 then "平台拒绝" ';
		$query_sql .='when mo.status = -1 then "供应商拒绝" when mo.status = 0 then "待确认" when mo.status = 1 then "待确认" ';
		$query_sql .='when mo.status = 2 then "待确认" when mo.status = 2 then "待确认" when mo.status = 3 then "待确认" ';
		$query_sql .='when mo.status = 4 then "已确认" when mo.status = 5 then "出团中" when mo.status = 6 then "已评论" ';
		$query_sql .='when mo.status = 7 then "已投诉" when mo.status =8 then "行程结束"  end "o_status" ,0 as un_balance,0 as a_balance,';
		$query_sql .= 'mo.balance_money,truncate((mo.supplier_cost-mo.platform_fee-mo.balance_money),2) as un_money,l.line_kind, ';
		$query_sql .= '(select sum(money) from u_order_receivable where  status = 2 and order_id = mo.id) as receive_price, ';
		$query_sql .= '(mo.supplier_cost) as supplier_cost,mo.platform_fee ';
		$query_sql .= 'from u_member_order AS mo ';
		$query_sql .= 'left join u_line as l on l.id = mo.productautoid ';
		$query_sql .= 'left join u_line_suit as ls on ls.id = mo.suitid ';
		$query_sql .= 'left join u_expert as e on mo.expert_id=e.id ';
		$query_sql .= ' left join u_line_startplace as lse on lse.line_id = l.id ';
		$query_sql .= 'left join u_startplace as s on s.id= lse.startplace_id ';
		$query_sql .= 'left join  b_limit_apply as bla on bla.order_id=mo.id  ';
		$query_sql .= ' where  mo.status!=2 and mo.status != -2 and mo.status != 9 and mo.status !=10 and mo.status !=11 and mo.status !=12 and mo.supplier_id='.$supplier_id;
		/*$query_sql .= '   and ((mo.user_type=1 and bla.status=1) or (mo.user_type=1 and bla.status=3)  ';
		$query_sql .= 'or (mo.user_type=1 and bla.status=4) or (mo.user_type=1 and bla.status=5) or mo.user_type=0) ';*/

		if ($param != null) {
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param['ordersn'] =trim($param['ordersn']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param['linename'] = '%' .trim($param['linename'] ). '%';
			}
		/*	if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN ? AND ? ';
			}*/
			if (null != array_key_exists ( 'linesn', $param )) {
				$query_sql .= ' AND mo.item_code = ? ';
				$param['linesn'] =trim($param['linesn']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= ' AND l.linecode = ? ';
				$param['linecode'] =trim($param['linecode']);
			}
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND mo.usedate >= ? ';
				$param['starttime'] =trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND mo.usedate <= ? ';
				$param['endtime'] =trim($param['endtime']);
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$query_sql .= ' AND e.realname LIKE ? ';
				$param['expert'] = '%' .trim($param['expert'] ). '%';
			}

			if (null != array_key_exists ( 'orvercity', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['orvercity'] =$param['orvercity'] ;
				unset($param['cityName']);
			}else if(null != array_key_exists ( 'cityName', $param )){
				$dest=$this->get_destname($param['cityName']);
				if(!empty($dest)){
					$param['cityName']=$dest['id'];
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}else{
					$param['cityName'] =0 ;
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}
			}

			if (null != array_key_exists ( 'province', $param )) {
				$query_sql .= ' AND find_in_set(? ,s.pid)';
				$param['province'] =$param['province'] ;
			}
			if (null != array_key_exists ( 'startcity', $param )) {
				$query_sql .= ' AND find_in_set(? ,lse.startplace_id )';
				$param['startcity'] =$param['startcity'] ;
			}
		}
		$query_sql .=' group by mo.id order by mo.addtime desc ';
		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	// 预留位,已确认
	public function get_order_user($param, $page) {
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql = 'select  mo.balance_status,mo.user_type,mo.ordersn,mo.suitnum,mo.settlement_price,mo.status,mo.suitid,l.id as lid,';
		$query_sql .= 'l.linecode,mo.memberid,mo.expert_id,l.linename,l.nickname,l.lineday,mo.id,e.realname,e.depart_name,';
		$query_sql .= '(mo.childnum + mo.dingnum + mo.childnobednum+mo.oldnum) AS "num",mo.dingnum,mo.balance_money,0 as un_balance,0 as a_balance,';
		$query_sql .= '(mo.total_price+mo.settlement_price) as total_price,mo.usedate,unix_timestamp(mo.usedate) as datetime,mo.ispay ,';
		$query_sql .= 'unix_timestamp("'.date('Y-m-d',time()).'") as nowtime,mo.lefttime ,mo.first_pay,mo.confirmtime_supplier,mo.canceltime,';
		//$query_sql .= '' ;
		$query_sql .= '(select sum(money) from u_order_receivable where  status = 2 and order_id = mo.id) as receive_price,l.line_kind, ';
		$query_sql .='(mo.supplier_cost-platform_fee-mo.balance_money) as un_money,ls.unit,l.overcity,mo.item_code as linesn,mo.addtime, ';
		$query_sql .='(mo.supplier_cost) as supplier_cost,mo.platform_fee ';
		$query_sql .= ' from u_member_order AS mo ';
		$query_sql .= 'left join  u_line AS l  ON l.id = mo.productautoid ';
	//	$query_sql .= 'left join u_line_suit_price as lsp on lsp.suitid = mo.suitid and mo.usedate=lsp.day ';
		$query_sql .= 'left join u_line_suit AS ls ON ls.id = mo.suitid ';
		$query_sql .= ' left join u_line_startplace as lse on lse.line_id = l.id ';
		$query_sql .= 'left join u_startplace as s on s.id= lse.startplace_id ';
		$query_sql .= 'left join u_expert as e on mo.expert_id=e.id ';
		$query_sql .= 'left join  b_limit_apply as bla on bla.order_id=mo.id ';
		$query_sql.=' where mo.supplier_id='.$login_id;

		if ($param != null) {
			if (null != array_key_exists ( 'status', $param )) {
				if($param['status']==0){
					$query_sql .= '  AND ((mo.user_type=1 and bla.status=1) or mo.user_type=0)  ';
					$query_sql .= '  AND (mo.status=? or mo.status=1 or mo.status=3) ';
					$param['status'] = trim($param['status']);
				}else{
					$query_sql .= '  AND mo.status=? ';
					$param['status'] = trim($param['status']);
				}

			}
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param['ordersn'] =trim($param['ordersn']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param['linename'] = '%' .trim($param['linename'] ). '%';
			}
		/*	if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN ? AND ? ';
			}*/
			if (null != array_key_exists ( 'linesn', $param )) {
				$query_sql .= ' AND mo.item_code = ? ';
				$param['linesn'] =trim($param['linesn']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= ' AND l.linecode = ? ';
				$param['linecode'] =trim($param['linecode']);
			}
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND mo.usedate >= ? ';
				$param['starttime'] =trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND mo.usedate <= ? ';
				$param['endtime'] =trim($param['endtime']);
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$query_sql .= ' AND e.realname LIKE ? ';
				$param['expert'] = '%' .trim($param['expert'] ). '%';
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$query_sql .= ' AND e.realname LIKE ? ';
				$param['expert'] = '%' .trim($param['expert'] ). '%';
			}
	/* 		if (null != array_key_exists ( 'dest_country', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_country'] =$param['dest_country'] ;
			}
			if (null != array_key_exists ( 'dest_province', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_province'] =$param['dest_province'] ;
			} */
			if (null != array_key_exists ( 'orvercity', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['orvercity'] =$param['orvercity'] ;
				unset($param['orvercity']);
			}else if(null != array_key_exists ( 'cityName', $param )){
				$dest=$this->get_destname($param['cityName']);
				if(!empty($dest)){
					$param['cityName']=$dest['id'];
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}else{
					$param['cityName'] =0 ;
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}
			}

			if (null != array_key_exists ( 'province', $param )) {
				$query_sql .= ' AND find_in_set(? ,s.pid)';
				$param['province'] =$param['province'] ;
			}
			if (null != array_key_exists ( 'startcity', $param )) {
				$query_sql .= ' AND find_in_set(? ,lse.startplace_id )';
				$param['startcity'] =$param['startcity'] ;
			}
		}
		if($param['status']==0){
			//$query_sql .='and  mo.usedate>=date_format(now(),"%Y-%m-%d")  ORDER BY mo.addtime desc,mo.confirmtime_supplier desc,mo.canceltime desc';
			$query_sql .=' group by mo.id ORDER BY mo.addtime desc';
		}else{
			$query_sql .=' group by mo.id ORDER BY mo.addtime desc,mo.confirmtime_supplier desc,mo.canceltime desc';
		}
		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	//type:1--出团中,type:2行程结束
	public function get_order_over($param, $page,$type=0) {
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );

		$query_sql = 'select mo.balance_status,mo.user_type,mo.ordersn,mo.suitnum,mo.settlement_price,mo.status,l.id as lid,0 as un_balance,0 as a_balance,';
		$query_sql.='l.linecode,ls.unit,l.overcity,e.realname,e.depart_name,mo.memberid,mo.expert_id,l.linename,mo.balance_money,l.nickname,';
		$query_sql.='mo.id,(mo.childnum + mo.dingnum + mo.childnobednum) AS "num",(mo.supplier_cost-mo.platform_fee-mo.balance_money) as un_money ,';
		$query_sql .= '(mo.total_price+mo.settlement_price) as total_price,mo.usedate,unix_timestamp(mo.usedate) as datetime,mo.lefttime ,';
		$query_sql .= 'unix_timestamp("'.date('Y-m-d',time()).'") as nowtime,mo.confirmtime_supplier,mo.canceltime,';
		$query_sql .= 'mo.ispay,mo.addtime,l.lineday,mo.item_code as linesn,l.line_kind,';
		$query_sql .= '(select sum(money) from u_order_receivable where  status = 2 and order_id = mo.id) as receive_price, ';
		$query_sql.='case when mo.status = 5 then "已出行" when mo.status = 6 then "已点评" when mo.status = 7 ';
		$query_sql.='then "已投诉" when mo.status =8 then "行程结束"  end "order_status",';
		$query_sql.='mo.first_pay,mo.dingnum,(mo.supplier_cost) as supplier_cost,mo.platform_fee ';
		$query_sql .= ' from   u_member_order AS mo ';
		$query_sql .= 'left join  u_line AS l on l.id = mo.productautoid ';
		//$query_sql .= 'left join u_line_suit_price as lsp on lsp.suitid = mo.suitid and mo.usedate=lsp.day ';
		$query_sql .= 'left join u_line_suit as ls on ls.id = mo.suitid ';
		$query_sql .= ' left join u_line_startplace as lse on lse.line_id = l.id ';
		$query_sql .= 'left join u_startplace as s on s.id= lse.startplace_id ';
		$query_sql .= 'left join u_expert as e on mo.expert_id=e.id ';
		$query_sql.=' where mo.supplier_id='.$arr['id'];

		if($type==1){  //出团中
			//$query_sql.=' and  (date_add(mo.usedate, interval l.lineday day)  > curdate() and curdate()>=mo.usedate)';
			$query_sql.=' and mo.status=5  ';
		}else if($type==2){  //行程结束
			//$query_sql.=' and  date_add(mo.usedate, interval l.lineday day)  <= curdate() ';
			$query_sql.=' and (mo.status=6 or mo.status=7 or mo.status=8)  ';
		}
		if ($param != null) {
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param ['ordersn'] =  trim($param ['ordersn']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param ['linename'] = '%' . trim($param ['linename']) . '%';
			}
			if (null != array_key_exists ( 'order_status', $param )) {
				$query_sql .= ' AND mo.status  = ? ';
				$param ['order_status'] =  trim($param ['order_status']);
			}
		/*	if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN ? AND ? ';
				//$param ['line_time'] = '%' . $param ['line_time'] . '%';
			}*/
			if (null != array_key_exists ( 'linesn', $param )) {
				$query_sql .= ' AND mo.item_code = ? ';
				$param['linesn'] =trim($param['linesn']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= ' AND l.linecode = ? ';
				$param ['linecode'] =  trim($param ['linecode']);
			}
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND mo.usedate >= ? ';
				$param['starttime'] =trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND mo.usedate <= ? ';
				$param['endtime'] =trim($param['endtime']);
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$query_sql .= ' AND e.realname LIKE ? ';
				$param['expert'] = '%' .trim($param['expert'] ). '%';
			}
	/* 		if (null != array_key_exists ( 'dest_country', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_country'] =$param['dest_country'] ;
			}
			if (null != array_key_exists ( 'dest_province', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_province'] =$param['dest_province'] ;
			} */
			if (null != array_key_exists ( 'orvercity', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['orvercity'] =$param['orvercity'] ;
			}else if(null != array_key_exists ( 'cityName', $param )){
				$dest=$this->get_destname($param['cityName']);
				if(!empty($dest)){
					$param['cityName']=$dest['id'];
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}else{
					$param['cityName'] =0 ;
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}
			}

			if (null != array_key_exists ( 'province', $param )) {
				$query_sql .= ' AND find_in_set(? ,s.pid)';
				$param['province'] =$param['province'] ;
			}
			if (null != array_key_exists ( 'startcity', $param )) {
				$query_sql .= ' AND find_in_set(? ,lse.startplace_id )';
				$param['startcity'] =$param['startcity'] ;
			}
		}
		$query_sql .=' group by mo.id ORDER BY mo.addtime desc,mo.confirmtime_supplier desc,mo.canceltime desc';

		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	//改价退团
	public function get_order_up($param, $page){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$query_sql = 'select mo.balance_status,mo.user_type,mo.ordersn,mo.status,mo.suitid,l.id AS lid,l.lineday,';
		$query_sql .= 'mo.expert_id,l.linename,mo.id,mo.dingnum,mo.usedate,mo.item_code as linesn,l.linecode,0 as un_balance,0 as a_balance,';
		$query_sql .= '(mo.childnum + mo.dingnum + mo.childnobednum + mo.oldnum) AS "num",l.overcity ,l.line_kind,';
		$query_sql .= '(mo.total_price + mo.settlement_price) AS total_price,e.realname,e.depart_name,mo.addtime,';
		$query_sql .= '(select sum(money) from u_order_receivable where  status = 2 and order_id = mo.id) as receive_price, ';
		$query_sql .= 'mo.balance_money,(mo.supplier_cost-mo.platform_fee-mo.balance_money) as un_money, ';
		$query_sql .='case when mo.status = -6 then "未提交"  when mo.status = -4 then "已取消" when mo.status = -3 then "退订中" when mo.status = -2 then "平台拒绝" ';
		$query_sql .='when mo.status = -1 then "供应商拒绝" when mo.status = 0 then "待付款" when mo.status = 1 then "待确认" ';
		$query_sql .='when mo.status = 2 then "待确认" when mo.status = 2 then "待确认" when mo.status = 3 then "待确认" ';
		$query_sql .='when mo.status = 4 then "已确认" when mo.status = 5 then "出团中" when mo.status = 6 then "已评论" ';
		$query_sql .='when mo.status = 7 then "已投诉" when mo.status =8 then "行程结束"  when mo.status =9 then "未提交" end "o_status" ,';
		$query_sql .= '(mo.supplier_cost) as supplier_cost,mo.platform_fee ';
		$query_sql .= 'from u_member_order AS mo ';
		$query_sql .= 'left join u_line as l on l.id = mo.productautoid ';
		$query_sql .= 'left join u_line_suit as ls on ls.id = mo.suitid ';
		$query_sql .= 'left join u_expert as e on mo.expert_id=e.id ';
		$query_sql .= ' left join u_line_startplace as lse on lse.line_id = l.id ';
		$query_sql .= 'left join u_startplace as s on s.id= lse.startplace_id ';
		$query_sql .= 'where  mo.status!=-5 and mo.supplier_id= '.$arr['id'];
		$query_sql .= ' and mo.id in( select order_id from u_order_bill_yf where (status=1 or (kind=3 and status=0)) and order_id=mo.id)';
		if ($param != null) {
		/*	if (null != array_key_exists ( 'supplier_id', $param )) {
				$query_sql .= '  AND mo.supplier_id=? ';
				$param['supplier_id'] = trim($param['supplier_id']);
			}*/
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param['ordersn'] =trim($param['ordersn']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param['linename'] = '%' .trim($param['linename'] ). '%';
			}
			/*if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN ? AND ? ';
			}*/
			if (null != array_key_exists ( 'linesn', $param )) {
				$query_sql .= ' AND mo.item_code = ? ';
				$param['linesn'] =trim($param['linesn']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= ' AND l.linecode = ? ';
				$param['linecode'] =trim($param['linecode']);
			}
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND mo.usedate >= ? ';
				$param['starttime'] =trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND mo.usedate <= ? ';
				$param['endtime'] =trim($param['endtime']);
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$query_sql .= ' AND e.realname LIKE ? ';
				$param['expert'] = '%' .trim($param['expert'] ). '%';
			}
	/* 		if (null != array_key_exists ( 'dest_country', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_country'] =$param['dest_country'] ;
			}
			if (null != array_key_exists ( 'dest_province', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_province'] =$param['dest_province'] ;
			} */
			if (null != array_key_exists ( 'orvercity', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['orvercity'] =$param['orvercity'] ;
			}else if(null != array_key_exists ( 'cityName', $param )){
				$dest=$this->get_destname($param['cityName']);
				if(!empty($dest)){
					$param['cityName']=$dest['id'];
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}else{
					$param['cityName'] =0 ;
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}
			}

			if (null != array_key_exists ( 'province', $param )) {
				$query_sql .= ' AND find_in_set(? ,s.pid)';
				$param['province'] =$param['province'] ;
			}
			if (null != array_key_exists ( 'startcity', $param )) {
				$query_sql .= ' AND find_in_set(? ,lse.startplace_id )';
				$param['startcity'] =$param['startcity'] ;
			}
		}
		$query_sql .=' group by mo.id order by mo.addtime desc ';
		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	public function get_order_left($param, $page) {
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql = 'select mo.balance_status,mo.user_type,mo.ordersn,mo.suitnum,mo.settlement_price,l.lineday,';
		$query_sql .= 'mo.status,l.id as lid,l.linecode,ls.unit,l.overcity,e.realname,e.depart_name,mo.memberid,';
		$query_sql .= 'mo.expert_id,l.linename,l.nickname,mo.id,(mo.dingnum + mo.childnum + mo.childnobednum+mo.oldnum) AS "num",';
		$query_sql .= 'mo.childnum,mo.dingnum,mo.childnobednum,(mo.total_price+mo.settlement_price) as total_price,mo.usedate,mo.lefttime ,';
		$query_sql .= 'mo.first_pay,mo.confirmtime_supplier,mo.canceltime,case WHEN mo.ispay = 0 ';
		$query_sql .= 'THEN "未付款" WHEN mo.ispay = 1 THEN	"确认中" WHEN mo.ispay = 2 THEN "已收款" END "ispay",mo.addtime,';
		$query_sql .= 'case WHEN mo.status=3 THEN "确认余位" END "returnstatus",lsp.description as linesn ';
		$query_sql .= ' FROM  u_member_order AS mo ';
		$query_sql .= 'left JOIN  u_line as l on l.id = mo.productautoid ';
		$query_sql .= 'left JOIN u_line_suit as ls on ls.id = mo.suitid ';
		$query_sql .= 'left join u_line_suit_price as lsp on lsp.suitid = mo.suitid and mo.usedate=lsp.day ';
		$query_sql .= ' left join u_line_startplace as lse on lse.line_id = l.id ';
		$query_sql .= 'left join u_startplace as s on s.id= lse.startplace_id ';
		$query_sql .= 'left join u_expert as e on mo.expert_id=e.id ';

		$query_sql.='  where  mo.supplier_id='.$login_id;

		if ($param != null) {
			if (null != array_key_exists ( 'status', $param )) {
				$query_sql .= ' AND (mo.status=? ';
				$param ['status'] = trim($param ['status']);
			}
			if (null != array_key_exists ( 'status1', $param )) {
				$query_sql .= ' or mo.status=? ';
				$param ['status1'] = trim($param ['status1']);
			}
			if (null != array_key_exists ( 'status2', $param )) {
				$query_sql .= ' or mo.status=? )';
				$param ['status2'] = trim($param ['status2']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param ['linecode'] =  trim($param ['linecode']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param ['linename'] = '%' . trim($param ['linename']) . '%';
			}
			if(null != array_key_exists ( 'pay_status', $param )){
				$query_sql .= ' AND mo.ispay = ? ';
				$param ['pay_status'] =  trim($param ['pay_status']) ;
			}
			if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN ? AND ? ';
			}
			if (null != array_key_exists ( 'linesn', $param )) {
				$query_sql .= ' AND lsp.description = ? ';
				$param['linesn'] =trim($param['linesn']);
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$query_sql .= ' AND e.realname LIKE ? ';
				$param['expert'] = '%' .trim($param['expert'] ). '%';
			}
			if (null != array_key_exists ( 'dest_country', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_country'] =$param['dest_country'] ;
			}
			if (null != array_key_exists ( 'dest_province', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_province'] =$param['dest_province'] ;
			}
			if (null != array_key_exists ( 'orvercity', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['orvercity'] =$param['orvercity'] ;
			}

			if (null != array_key_exists ( 'province', $param )) {
				$query_sql .= ' AND find_in_set(? ,s.pid)';
				$param['province'] =$param['province'] ;
			}
			if (null != array_key_exists ( 'startcity', $param )) {
				$query_sql .= ' AND find_in_set(? ,lse.startplace_id )';
				$param['startcity'] =$param['startcity'] ;
			}
		}
		$query_sql .=' group by mo.id ORDER BY mo.addtime desc';
		//$query_sql .= 'and mo.usedate>=date_format(now(),"%Y-%m-%d")  order by mo.lefttime desc';
		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	public function get_user_where($id) {
		$query = $this->db->get_where ( 'u_member_order', array (
				'status' => $id
		) );
		return $query->row_array ();
	}
	//订单收款
	function get_sum_receive($whereArr){
		$whereStr = '';
		$sql = 'SELECT sum(money) AS total_receive_amount FROM u_order_receivable ';
		foreach($whereArr as $key=>$val){
			$whereStr .= ' '.$key.'"'.$val.'" AND';
		}
		$whereStr = rtrim($whereStr ,'AND');
		$sql = $sql.' WHERE '.$whereStr;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}
	public function update_status($data, $id) {
		$this->db->where ( 'id', $id );
		return $this->db->update ( 'u_member_order', $data );
	}
	public function update_tabledata($table,$data, $where) {
		$this->db->where ( $where );
		return $this->db->update ( $table, $data );
	}
	//改变订单操作表
	public function update_order_read($data, $where,$wherestr='') {
		$this->db->where ( $where );
		if($wherestr!=''){
			$this->db->where ( $wherestr );
		}

		return $this->db->update ('cal_supplier_order_status', $data );
	}
	// 判断国内,国外
	 public function judge_around($pid){
	 	 return $this->db->query ( "select right(overcity,1) as inou from u_line where id={$pid}")->result_array ();
	 }
	//已取消
	public function get_disorder($param, $page) {
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = 'select  mo.balance_status,mo.user_type,r.amount,mo.settlement_price,mo.first_pay,l.lineday,l.linecode,';
		$query_sql .= 'mo.final_pay,mo.id ,mo.ordersn ,l.overcity,mo.canceltime ,mo.suitnum,e.realname,e.depart_name,l.line_kind,';
		$query_sql .= ' ls.unit,l.linename ,l.id as lid,l.nickname ,(mo.childnum + mo.dingnum + mo.childnobednum+mo.oldnum) AS "num",mo.dingnum,';
		$query_sql .= '(select sum(money) from u_order_receivable where  status = 2 and order_id = mo.id) as receive_price, ';
		$query_sql .='(mo.total_price+mo.settlement_price) as total_price,mo.lefttime,mo.confirmtime_supplier ,mo.usedate ,mo.ispay,';
		$query_sql .='CASE WHEN mo.status =- 3 THEN "退款中" WHEN mo.ispay <> 0 AND mo.status =- 4 THEN "已退款" WHEN mo.ispay = 0 THEN "无需退款" END "ispay1", mo.addtime , mo.status,mo.item_code as linesn ' ;
		$query_sql .=' from u_member_order AS mo  ';
		$query_sql .= 'left join u_line AS l ON l.id = mo.productautoid ';
		//$query_sql .= 'left join u_line_suit_price as lsp on lsp.suitid = mo.suitid and mo.usedate=lsp.day ';
		$query_sql .= 'left join u_refund AS r ON mo.id=r.order_id ';
		$query_sql .= 'left join u_line_suit AS ls ON ls.id = mo.suitid ';
		$query_sql .= ' left join u_line_startplace as lse on lse.line_id = l.id ';
		$query_sql .= 'left join u_startplace as s on s.id= lse.startplace_id ';
		$query_sql .= 'left join u_expert as e on mo.expert_id=e.id ';
		$query_sql.=' where  mo.status < 0  and mo.status !=-2 and  mo.supplier_id ='.$login_id;

		if ($param != null) {
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param ['ordersn'] =  trim($param ['ordersn']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param ['linename'] = '%' . trim($param ['linename']) . '%';
			}
			if(null != array_key_exists ( 'pay_status', $param )){
				$query_sql .= ' AND mo.ispay = ? ';
				$param ['pay_status'] = trim( $param ['pay_status']) ;
			}else{
				$query_sql .= ' AND mo.ispay >= 0 ';
			}
			if (null != array_key_exists ( 'linesn', $param )) {
				$query_sql .= ' AND mo.item_code = ? ';
				$param['linesn'] =trim($param['linesn']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= ' AND l.linecode = ? ';
				$param['linecode'] =trim($param['linecode']);
			}
			/*if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN ? AND ? ';
			}*/
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND mo.usedate >= ? ';
				$param['starttime'] =trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND mo.usedate <= ? ';
				$param['endtime'] =trim($param['endtime']);
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$query_sql .= ' AND e.realname LIKE ? ';
				$param['expert'] = '%' .trim($param['expert'] ). '%';
			}
/* 			if (null != array_key_exists ( 'dest_country', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_country'] =$param['dest_country'] ;
			}
			if (null != array_key_exists ( 'dest_province', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['dest_province'] =$param['dest_province'] ;
			} */
			if (null != array_key_exists ( 'orvercity', $param )) {
				$query_sql .= ' AND find_in_set(? ,l.overcity)';
				$param['orvercity'] =$param['orvercity'] ;
			}else if(null != array_key_exists ( 'cityName', $param )){
				$dest=$this->get_destname($param['cityName']);
				if(!empty($dest)){
					$param['cityName']=$dest['id'];
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}else{
					$param['cityName'] =0 ;
					$query_sql .= ' AND find_in_set(? ,l.overcity)';
					$param['cityName'] =$param['cityName'] ;
				}
			}

			if (null != array_key_exists ( 'province', $param )) {
				$query_sql .= ' AND find_in_set(? ,s.pid)';
				$param['province'] =$param['province'] ;
			}
			if (null != array_key_exists ( 'startcity', $param )) {
				$query_sql .= ' AND find_in_set(? ,lse.startplace_id )';
				$param['startcity'] =$param['startcity'] ;
			}
		}else{
			$query_sql .= ' AND mo.ispay >= 0 ';
		}
		$query_sql .=' group by mo.id  ORDER BY mo.canceltime desc';
		return $this->queryPageJson ( $query_sql, $param, $page );
	}

	/**
	 *获取订单详情数据
	 */
	function get_order_detail($whereArr){
		$sql='mo.id,mo.settlement_price,mo.addtime as addtime,mo.suitnum,mo.item_code,mo.productautoid as productautoid,mo.productname AS line_name,mo.ordersn AS line_sn,ls.unit,ls.suitname,mo.balance_complete,mo.balance_status,mo.platform_fee,mo.user_type,';
		$sql.='mo.usedate AS usedate,mo.status AS status,mo.status as order_status,mo.ispay AS ispay,mo.dingnum ,mo.price AS ding_price,';
		$sql.='mo.childprice AS childprice,mo.childnum AS children,mo.agent_fee AS agent_fee,mo.isneedpiao AS isneedpiao,mo.total_price,';
		$sql.='e.realname AS expert_name,e.mobile AS expert_mobile,s.company_name AS company_name,s.telephone AS telephone,mo.supplier_cost,';
		$sql.='mo.linkman AS linkman,mo.linkmobile AS linkmobile,mo.childnobedprice AS childnobedprice,mo.childnobednum AS childnobednum,';
		$sql.='mo.oldnum AS oldnum,mo.oldprice AS oldprice,mo.productautoid as lineid,mo.jifen,mo.jifenprice,mo.couponprice,mo.balance_money,';
		$sql.='case when find_in_set(1,l.overcity)>0 then 1 when find_in_set(2,l.overcity)>0 then 2 end cer_type, sum(i.amount) AS amout,mo.linkemail AS link_email';
		$this->db->select($sql,false);
		$this->db->from('u_member_order AS mo');
		$this->db->join('u_expert AS e', 'mo.expert_id=e.id', 'left');
		$this->db->join('u_supplier AS s', 'mo.supplier_id=s.id', 'left');
		$this->db->join('u_order_insurance AS i', 'i.order_id=mo.id', 'left');
		$this->db->join('u_line AS l', 'l.id=mo.productautoid', 'left');
		$this->db->join('u_line_suit AS ls', 'ls.id=mo.suitid', 'left');
		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		array_walk($result, array($this, 'user_order_status'));
		return $result;
	}
	protected function user_order_status(&$value, $key) {
		switch($value['status']){
			case -4:
				$value['status_opera'] = '-4';
				if($value['ispay']==0){
					$value['status']='已取消';
				}elseif($value['ispay']==4){
					$value['status']='已退订';
				}
				break;
			case -3:
				$value['status_opera'] = '-3';
				$value['status'] = '退订中';
				break;
			case -2:
				$value['status'] = '平台拒绝';
				$value['status_opera'] = '-2';
				break;
			case -1:
				$value['status'] = '供应商拒绝';
				$value['status_opera'] = '-1';
				break;
			case 0:

				$value['status'] = '待留位';
				$value['status_opera'] = '0';
				break;

			case 1:
				$value['status'] = '已预留位';
				$value['status_opera'] = '1';
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
				$value['status'] = '已出行';
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
				$value['status'] = '已结团';
				$value['status_opera'] = '8';
				break;
			default: $value['status'] = '订单状态';break;
		}

	}
	/**
	 * 订单参团人信息
	 */
	function get_order_people($whereArr){
		$sql='mt.id AS id,mt.name AS m_name,mt.enname AS enname,d.description AS certificate_type,mt.certificate_no AS certificate_no,mo.people_lock,';
		$sql.='mt.endtime AS endtime,mt.telephone AS telephone,mt.sex AS sex,mt.birthday AS birthday,mt.sign_place,mt.sign_time,mo.productautoid ';
		$this->db->select($sql);
		$this->db->from('u_member_order AS mo');
		$this->db->join('u_member_order_man AS mom', 'mo.id=mom.order_id', 'left');
		$this->db->join('u_member_traver AS mt', 'mom.traver_id=mt.id', 'left');
		$this->db->join('u_dictionary AS d', 'mt.certificate_type=d.dict_id', 'left');
		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	//订单发票信息
	function get_order_invoice($whereArr){
		$sql='mi.invoice_name,mi.invoice_detail,mi.receiver,';
		$sql.='mi.telephone,mi.address,mi.addtime,mi.member_id';
		$this->db->select($sql);
		$this->db->from('u_member_order_invoice AS mo');
		$this->db->join('u_member_invoice AS mi', 'mo.invoice_id = mi.id', 'left');

		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	/**
	 * 改变订单状态（预留位）
	 *
	 */
	function up_order_status($order,$id){

		$this->db->trans_start ();

		//----------------------------减库存-----------------------------------
		$num=$order['dingnum']+$order['childnum']+$order['oldnum'];//总人数
		$date=$order['usedate'];//出团日期
		$suitid=$order['suitid'];
		$lineid=$order['productautoid'];
		//原库存
		$number= $this->get_line_suit(array('sp.lineid'=>$lineid,'sp.suitid'=>$suitid,'sp.day'=>$date));
		$num_date=$number['number'];
		if(!empty($num)){      //减少库存
			$where_suit=array('lineid'=>$lineid,'suitid'=>$suitid,'day'=>$date);
			$num_date=$number['number']-$num;
			if($number['number']!=-1){
				if($num_date<0){
					echo  -1;exit;

				}else{
					$order_num=$number['order_num']+1;
					$this->updata_suit_price($where_suit,array('number'=>$num_date,'order_num'=>$order_num));
				}
			}
		}

		//---------------------------改变订单的状态-------------------------------
		if($order['total_price']==0){  //总的价格等于零时,直接确认订单
			$param=array('status'=>4,'ispay'=>2,'lefttime'=>date("Y-m-d H:i:s",time()),'confirmtime_supplier'=>date("Y-m-d H:i:s",time()));
		}else{
			$param=array('status'=>1,'lefttime'=>date("Y-m-d H:i:s",time()));
		}
		//改变订单状态
		$data = $this->update_status($param,$id);
		//管家订单状态记录
		$this->update_order_status_cal($id);

		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			return false;
		} else {
			$this->db->trans_commit ();
			return $data;
		}
	}
	//遍历表
	public function sel_data($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get($table)->row_array();
		return $query;
	}
	//平台管理费
	function get_bill_yj($order_id){
		$sql = " SELECT sum(amount) as amount_money from u_order_bill_yj where `status`=2 and order_id={$order_id}";
		return $this ->db ->query($sql) ->row_array();
	}
	//添加表
	public function insert_data($table,$data){
		$this->db->trans_start ();

		$this->db->insert($table,$data);
		$id=$this->db->insert_id();

		 $this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		echo false;
	    	}else{
	    		return $id;
	    	}
		//return $id;
	}
	/*获取套餐信息*/
	public function get_line_suit($where){
		$this->db->select('sp.*, ls.suitname');
		$this->db->from('u_line_suit_price AS sp');
		$this->db->join('u_line_suit AS ls', 'ls.id = sp.suitid', 'left');
		$this->db->where($where);
		$query = $this->db->get()->row_array();
		return $query;
	}
	/*导出订单信息*/
	public function get_order_meaasge($param,$type) {
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$query_sql = 'select mo.balance_status,mo.user_type,mo.ordersn,mo.status,mo.suitid,l.id AS lid,l.lineday,mo.ispay,mo.canceltime,';
		$query_sql .= 'mo.expert_id,l.linename,mo.id,mo.dingnum,mo.usedate,lsp.description as linesn,mo.supplier_cost,';
		$query_sql .= '(mo.childnum + mo.dingnum + mo.childnobednum + mo.oldnum) AS "num",l.overcity ,mo.status,';
		$query_sql .= '(mo.total_price + mo.settlement_price) AS total_price,e.realname,e.depart_name,mo.addtime,mo.ispay as ispay2,';
		$query_sql .= 'mo.balance_money,(mo.supplier_cost-mo.balance_money) as un_money,mo.lefttime,mo.confirmtime_supplier, ';
		$query_sql .='case when mo.status =-3 then "退款中" when mo.ispay <> 0 and mo.status=-4 then "已退款" when mo.ispay = 0 then "无需退款" end "ispay1", ';
		$query_sql .= '(select sum(money) from u_order_receivable where  status = 2 and order_id = mo.id) as receive_price, ';
		$query_sql .= ' case when mo.ispay = 0 then "未付款" when mo.ispay = 1 then "确认中" when mo.ispay = 2 then "已收款" end "ispay" ';
		$query_sql .= ' from u_member_order AS mo ';
		$query_sql .= 'left join u_line as l on l.id = mo.productautoid ';
		$query_sql .= 'left join u_line_suit as ls on ls.id = mo.suitid ';
		$query_sql .= 'left join u_line_suit_price as lsp on lsp.suitid = mo.suitid and mo.usedate=lsp.day ';
		$query_sql .= 'left join u_expert as e on mo.expert_id=e.id ';
		$query_sql .= ' left join u_line_startplace as lse on lse.line_id = l.id ';
		$query_sql .= 'left join u_startplace as s on s.id= lse.startplace_id ';
		$query_sql .= 'left join  b_limit_apply as bla on bla.order_id=mo.id  ';
		$query_sql .= 'where mo.id >0  and mo.supplier_id='.$arr['id'];
		//$query_sql .= ' where  mo.status!=2 and mo.status != -2 and mo.status != 9 and mo.status !=10 and mo.status !=11 and mo.status !=12 and mo.supplier_id='.$arr['id'];
		if ($param != null) {
			if (null != array_key_exists ( 'linecode', $param )) {
				$param['linecode'] ='"'.trim($param['linecode']).'"';
				$query_sql .= ' AND l.linecode = '.$param['linecode'];
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$param['linename'] = '%' .trim($param['linename'] ). '%';
				$query_sql .= ' AND l.linename LIKE  '.$param['linename'] ;
			}
			if (null != array_key_exists ( 'ordersn', $param )) {
				$param['ordersn'] ='"'.trim($param['ordersn']).'"';
				$query_sql .= ' AND mo.ordersn= '.$param['ordersn'];
			}

			/*if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN '.$param ['startdatetime'].' AND  '.$param ['enddatetime'];
			}*/

			if(null != array_key_exists ( 'pay_status', $param )){
				$param ['pay_status'] =  trim($param ['pay_status']) ;
				if(intval($param ['pay_status'])>=0){
					$query_sql .= ' AND mo.ispay =  '.$param ['pay_status'] ;
				}
			}
			if (null != array_key_exists ( 'order_status', $param )) {
				$param ['order_status'] =  trim($param ['order_status']);
				$query_sql .= ' AND mo.status  = '.$param ['order_status'];
			}
			if (null != array_key_exists ( 'linesn', $param )) {
				$param['linesn'] =trim($param['linesn']);
				$query_sql .= ' AND lsp.description =  '.$param['linesn'];

			}
			if (null != array_key_exists ( 'starttime', $param )) {
				$param['starttime'] =trim($param['starttime']);
				$query_sql .= ' AND mo.usedate >= "'.$param['starttime'].'"';
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$param['endtime'] =trim($param['endtime']);
				$query_sql .= ' AND mo.usedate <= "'.$param['endtime'].'"';
			}
			if (null != array_key_exists ( 'expert', $param )) {
				$param['expert'] = '%' .trim($param['expert'] ). '%';
				$query_sql .= ' AND e.realname LIKE  '.$param['expert'];
			}

			if (null != array_key_exists ( 'dest_country', $param )) {
				$param['dest_country'] =$param['dest_country'] ;
				$query_sql .= ' AND find_in_set('.$param['dest_country'] .' ,l.overcity)';

			}
			if (null != array_key_exists ( 'dest_province', $param )) {
				$param['dest_province'] =$param['dest_province'] ;
				$query_sql .= ' AND find_in_set('.$param['dest_province'].' ,l.overcity)';
			}
			if (null != array_key_exists ( 'orvercity', $param )) {
				$param['orvercity'] =$param['orvercity'] ;
				$query_sql .= ' AND find_in_set('.$param['orvercity'] .' ,l.overcity)';
			}

			if (null != array_key_exists ( 'province', $param )) {
				$param['province'] =$param['province'] ;
				$query_sql .= ' AND find_in_set('.$param['province'].' ,s.pid)';
			}
			if (null != array_key_exists ( 'startcity', $param )) {
				$param['startcity'] =$param['startcity'] ;
				$query_sql .= ' AND find_in_set('.$param['startcity'].' ,lse.startplace_id )';
			}
		}

		if($type==0){  //全部
			$query_sql .= '   and mo.status!=2 and mo.status != -2 and mo.status != 9 and mo.status !=10 and mo.status !=11 and mo.status !=12 ';
			$query_sql .=' group by mo.id ORDER BY mo.addtime desc';


		}elseif($type==1){  //预留位

			//$query_sql .= '  AND mo.status=0 ';
			$query_sql .= '  AND ((mo.user_type=1 and bla.status=1) or mo.user_type=0)  ';
			$query_sql .= '  AND (mo.status=0 or mo.status=1 or mo.status=3) ';
			$query_sql .=' group by mo.id ORDER BY mo.addtime desc';

		}/*else if($type==2){  //已预留位

			$query_sql .= '  AND (mo.status=1 or mo. status = 2  or mo. status = 3) ';
			$query_sql .=' group by mo.id ORDER BY mo.addtime desc,mo.confirmtime_supplier desc,mo.canceltime desc';

		}*/else if($type==3){  //已确认

			$query_sql .= '  AND mo.status=4 ';
			$query_sql .=' group by mo.id ORDER BY mo.addtime desc,mo.confirmtime_supplier desc,mo.canceltime desc';

		}else if($type==4){ //出团中

			$query_sql.=' and  (date_add(mo.usedate, interval l.lineday day)  > curdate() and curdate()>=mo.usedate)';
			$query_sql .=' group by mo.id order by mo.addtime desc ';

		}else if ($type==5){ //行程结束

			$query_sql.=' and  date_add(mo.usedate, interval l.lineday day)  <= curdate() ';
			$query_sql .=' group by mo.id order by mo.addtime desc ';

		}else if ($type==6){ //已取消
			if($param == null){
				$query_sql .= ' AND mo.ispay >= 0 ';
			}
			$query_sql .= '  AND mo.status<0 group by mo.id ORDER BY mo.canceltime desc';

		}else if($type==7){ //改价,退团

			$query_sql .= ' AND mo.id in( select order_id from u_order_bill_log) ';
			$query_sql .=' group by mo.id order by mo.addtime desc ';
		}


		return $this->db->query($query_sql)->result_array();
	}
	/*导出订单信息*/
	public function get_order_meaasge1($param='',$where=array()) {
		$where_str = "";
		if($where){
			if(isset($where['linename'])){
				$where_str .= ' AND l.linename LIKE "%'.$where['linename'].'%"';
			}
			if(isset($where['linecode'])){
				$where_str .= ' AND l.linecode='.$where['linename'];
			}
			if(isset($where['startdatetime'])){
				$where_str .= ' AND mo.userdate BETWEEN '.$where['startdatetime'].' AND '.$where['enddatetime'];
			}
		}

		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql = '';
		$query_sql .= 'select mo.ordersn,mo.status,l.id as lid,l.linecode,mo.memberid,mo.expert_id,l.linename,l.nickname,mo.id,';
		$query_sql .= ' (mo.childnum + mo.dingnum + mo.childnobednum) AS "num",mo.total_price,mo.usedate,mo.lefttime ,mo.confirmtime_supplier,mo.canceltime, ';
		$query_sql .= 'case WHEN mo.ispay = 0 THEN "未付款" WHEN mo.ispay = 1 THEN "确认中" WHEN mo.ispay = 2 THEN "已收款" END "ispay",mo.addtime,case WHEN mo.status=3 THEN "确认余位"END "returnstatus" ';
		$query_sql .=' FROM u_line AS l';
		$query_sql.='  left JOIN u_member_order AS mo ON l.id = mo.productautoid ';
		$query_sql .=' WHERE mo.supplier_id='.$login_id.' AND (mo.status=1 or mo.status=2 or mo.status=3) '.$where_str;
		//$query_sql .=' order by mo.addtime desc ,mo.lefttime desc  ';
		$query_sql .= 'and mo.usedate>=date_format(now(),"%Y-%m-%d")  ';

		if (isset($param['ispay'])) {
			$query_sql .= ' AND mo.ispay ='.$param['ispay'];

		}
		$query_sql .= ' order by mo.lefttime desc  ';

		return $this->db->query($query_sql)->result_array();
	}
	/*导出信息 取消订单*/
	//修改库存
	public function updata_suit_price($where,$data){
		$this->db->where($where);
		return   $this->db->update('u_line_suit_price', $data);
	}
	//订单的保险费用
	function get_insurance($order_id){
		$sql = "SELECT  oin.number,truncate((oin.amount/oin.number),2) as in_price,lin.* from u_order_insurance as oin LEFT JOIN  u_travel_insurance  as lin on lin.id=oin.insurance_id where  oin.order_id=".$order_id;
		return $this ->db ->query($sql) ->result_array();
	}
	//获取单个保险
	function get_one_insurance($id){
		$sql = "SELECT	tin.*,di.description as kingname FROM u_travel_insurance AS tin LEFT JOIN u_dictionary AS di ON di.dict_id = tin.insurance_kind where tin.id=".$id;
		return $this ->db ->query($sql) ->row_array();
	}

	/**
	 * @param 订单id号 $order_id
	 * @param 操作的内容 $log_content
	 */
	function order_log($order_id,$log_content,$userid,$order_status){
		$log_data['order_id'] = $order_id;
		$log_data['op_type'] = 2;
		$log_data['userid'] = $userid;
		$log_data['content'] = $log_content;
		$log_data['order_status'] = $order_status;
		$log_data['addtime'] = date('Y-m-d H:i:s');
		$this->db->insert('u_member_order_log',$log_data);
	}
	//得到线路库存
	function get_stock($lineid,$day,$suitid){
		$query_sql = '';
		$query_sql .= 'SELECT pri.day,pri.number FROM u_line_suit_price as pri ';
		$query_sql .= ' LEFT JOIN u_line_suit as suit on suit.id=pri.suitid ';
		$query_sql .= 'where suit.lineid='.$lineid.' and pri.day="'.$day.'"  and pri.suitid='.$suitid;
		return $this->db->query($query_sql)->row_array();
	}
	//订单转团
	function return_order_suit($param, $page){

		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql = '';
		$query_sql .= 'select diff.id as diffid,diff.diff_price,diff.usedate as usedate1,mo.ordersn,mo.settlement_price,mo.status,l.id as lid,l.overcity,ls.unit,mo.memberid,mo.expert_id,l.linename,l.nickname,mo.id,(mo.dingnum + mo.childnum + mo.childnobednum+mo.oldnum) AS "num",mo.childnum,mo.dingnum,mo.childnobednum,'.
				'(diff.total_price+mo.settlement_price) as return_price,mo.usedate,mo.lefttime ,mo.first_pay,mo.confirmtime_supplier,mo.canceltime,case WHEN mo.ispay = 0 '.
				'THEN "未付款" WHEN mo.ispay = 1 THEN	"确认中" WHEN mo.ispay = 2 THEN "已收款" END "ispay",mo.addtime,case WHEN mo.status=3 THEN "确认余位"'.
				 'END "returnstatus" ,e.realname,mo.trun_status,(mo.total_price_after+mo.settlement_price) as old_price,(mo.order_price+mo.settlement_price) as order_price,(diff.total_price+mo.settlement_price) as total_price,mo.total_price_after,(mo.total_price+mo.settlement_price) as total_price0 ';
		$query_sql .= '  from  u_member_order_diff as diff ';
		$query_sql.=' left join  u_member_order AS mo  on  mo.id=diff.order_id ';
		$query_sql .= ' left join u_line AS l ON l.id = mo.productautoid ';
		$query_sql .= ' left join u_line_suit AS ls ON ls.id = mo.suitid ';
		$query_sql .= ' left join u_expert as e on  mo.expert_id=e.id';

		 $query_sql.=' WHERE mo.supplier_id='.$login_id;


		if ($param != null) {
			if (null != array_key_exists ( 'status', $param )) {
				$query_sql .= '  AND diff.status=? ';
				$param['status'] = trim($param['status']);
			}
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= '  AND mo.ordersn=? ';
				$param['ordersn'] = trim($param['ordersn']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= '  AND l.linecode=? ';
				$param['linecode'] = trim($param['linecode']);
			}
			if (null != array_key_exists ( 'linename', $param )) {
				$query_sql .= ' AND l.linename LIKE ? ';
				$param ['linename'] = '%' . trim($param ['linename']) . '%';
			}
		}

		$query_sql .= ' order by diff.id desc';
		return $this->queryPageJson ( $query_sql, $param, $page );

	}
	//确认订单转单
	function return_orderSiutDate( $price,$orderid,$diffData,$suitData){
	         $this->db->trans_start();

             //修改库存
             if($suitData['unit']>1){
                    $order_people=$price['suitnum'];
             }else{
                    $order_people=$price['childnum']+$price['dingnum']+$price['oldnum']+$price['childnobednum'];
             }
    	      //  $order_people=$price['childnum']+$price['dingnum']+$price['oldnum']+$price['childnobednum'];
    	     $number= $this->get_line_suit(array('sp.dayid'=>$diffData['days_id']));
    		 $num_date=$number['number'];
        	 if(!empty($order_people)){      //减少库存
        			$where_suit=array('dayid'=>$diffData['days_id']);
        			$num_date=$number['number']-$order_people;
        			if($num_date<0){
        				//exit;
        			}else{
        				$this->updata_suit_price($where_suit,array('number'=>$num_date));
        				//加回原来的库存
        				$where_price=array('sp.lineid'=>$price['productautoid'],'sp.suitid'=>$price['suitid'],'sp.day'=>$price['usedate']);
        				$where_price0=array('lineid'=>$price['productautoid'],'suitid'=>$price['suitid'],'day'=>$price['usedate']);
        				$oldsuitprice=$this->get_line_suit($where_price);
        				$this->updata_suit_price($where_price0,array('number'=>$oldsuitprice['number']+$order_people));
        			}

        	 }

              //    var_dump($diffData);exit;
              //修改订单的套餐价格转态
              if($diffData['diff_price']==0){
              	     $f_price=$price['total_price_after'];
              }else{
           		     $f_price=$price['total_price_after']+$diffData['diff_price'];
              }

              $orderprice = array(
            		'trun_status'=>0,
            		'usedate'=>$diffData['usedate'],
            		'suitid'=>$diffData['suit_id'],
            		'diff_price' =>$diffData['diff_price'],
            		'total_price'=>$diffData['total_price'],
            		'order_price'=>$diffData['order_price'],
            		'total_price_after'=>$price['total_price'],
              );
	          $this->db->where(array("id"=>$orderid))->update('u_member_order',  $orderprice);
              $this->db->where(array("order_id"=>$orderid,'status'=>0))->update('u_member_order_diff', array('status'=>1));
              //付款信息表
	          $order_detail=$this->sel_data('u_order_detail',array('order_id'=>$orderid));
              //退款
          	  if( $diffData['diff_price']<0){
                        $amount_apply= -$diffData['diff_price'];
             		$refundArr=array(
                                     "order_id" =>$orderid,
                                     "bankcard "=>$order_detail['bankcard'],
                                     "bankname"=>$order_detail['bankname'],
                                     "approve_status"=>0,
                                     "is_remit"=>0,
                                     "addtime"=>date('Y-m-d H:i:s'),
                                     "amount_apply"=>$amount_apply,
                                     "mobile"=>$price['linkmobile'],
                                     "status"=>0,
                                     "refund_type"=>1,
                                     "refund_status"=>1,
                                     "refund_id"=>$price['expert_id'],
                 		);
             		$this->db->insert('u_refund',$refundArr);
             	}
    	        $this->db->trans_complete();
    	    	if ($this->db->trans_status() === FALSE)
    	    	{
    	    		echo false;
    	    	}else{
    	    		return true;
    	    	}

	}
	//获取平台管理费
	function get_order_bill_yj($orderid){
		$sql="select num,price,amount,status,addtime,user_id,user_type,user_name,addtime, item,remark from u_order_bill_yj  where order_id={$orderid}";
		$query = $this->db->query($sql);
		$row = $query->result_array();
		//总计
		$sql_str="select sum(amount) as sum from u_order_bill_yj where  order_id={$orderid} and status=2";
		$query_sql=$this->db->query($sql_str)->row_array();

		$result['data']=$row;
		if(!empty($query_sql)){
			$result['count_money']=$query_sql['sum'];
		}
		return $result;
	}
	//获取成本价
	function get_order_bill_yf($orderid){
		$sql="select byf.id,byf.order_id,byf.user_type,byf.user_id,byf.user_name,byf.kind,byf.expert_id,byf.item,byf.num,sre.status as re_status,";
		$sql=$sql."byf.childnum,byf.oldnum,byf.price,byf.amount, byf.remark,byf.addtime,byf.status,byf.remark,byf.childnobednum,byf.addtime, ";
		$sql=$sql."mo.supplier_cost,mo.platform_fee,mo.balance_money,(mo.supplier_cost-mo.balance_money) as s_money, ";
		$sql=$sql."(mo.supplier_cost-mo.platform_fee-mo.balance_money) as un_money ";
		$sql=$sql." from u_order_bill_yf as byf left join u_member_order as mo on byf.order_id=mo.id ";
		$sql=$sql." left join u_supplier_refund as sre on sre.yf_id=byf.id and sre.status!=2 and sre.status!=-1 ";
		$sql=$sql." where  byf.order_id={$orderid} and  ((byf.status=2 or byf.status=4 or byf.status=1) or (byf.status=3 and byf.user_type=2) or (byf.status=0 and byf.kind!=2))  ";
		$sql=$sql." GROUP BY byf.id order by byf.addtime asc ";
		$query = $this->db->query($sql);
		$row = $query->result_array();
		//echo $this->db->last_query();
		//总计
		$sql_str="select sum(amount) as sum from u_order_bill_yf where  order_id={$orderid} and status=2";
		$query_sql=$this->db->query($sql_str)->row_array();

		$result['data']=$row;
		if(!empty($query_sql)){
			$result['count_money']=$query_sql['sum'];
		}
		return $result;
	}
	//添加订单成本价
	function save_order_bill_yf($bill){
		$this->db->trans_start();

		//供应商
		$supplier=$this->db->query("select * from u_supplier where id={$bill['supplier_id']}")->row_array();

		//订单应收款表
		$ysArr=array(
			'user_name'=>$supplier['realname'],
			'depart_name'=>$supplier['brand'],
		);
		$this->db->insert ( 'u_order_bill_ys', $ysArr );
		$ys_id=$this->db->insert_id();

		//订单应付款表
		$billArr=array(
			'order_id'=>$bill['order_id'],
			'item'=>$bill['item'],
			'num'=>$bill['num'],
			'price'=>$bill['price'],
			'amount'=>$bill['amount'],
			'remark'=>$bill['remark'],
			'status'=>0,
			'addtime'=>date("Y-m-d H:i:s"),
			'supplier_id'=>$bill['supplier_id'],
			'user_type'=>2, //供应商申请
			'kind'=>3,
			'user_id'=>$bill['user_id'],
			'user_name'=>$bill['user_name'],
			'ys_id'=>$ys_id,
		);
		$this->db->insert ( 'u_order_bill_yf', $billArr );
		$id=$this->db->insert_id();
		//订单账单日志表
		$logArr=array(
			'order_id'=>$bill['order_id'],
			'num'=>$bill['num'],
			'type'=>1,
			'price'=>$bill['price'],
			'amount'=>$bill['amount'],
			'user_type'=>2,
			'user_id'=>$bill['supplier_id'],
			'addtime'=>date("Y-m-d H:i:s"),
			'remark'=>$bill['remark'],
		);
		$this->db->insert ( 'u_order_bill_log', $logArr );

    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		return false;
    	}else{
    		return $id;
    	}
	}
	//撤销成本价账单
	function dis_bill_yf($bill_id,$supplier_id){

		$this->db->trans_start();

		$bill= $this->db->query("select * from u_order_bill_yf where id={$bill_id}")->row_array();
		$orderid=$bill['order_id'];

		//成本账单表
		$billArr=array(
			'supplier_id'=>$supplier_id,
			's_time'=>date('Y-m-d,H:i:s',time()),
			'status'=>4,
		);
		$this->db->where(array('id'=>$bill['id']))->update('u_order_bill_yf',$billArr);
		//成本账单日志表
		$logArr=array(
			'order_id'=>$bill['order_id'],
			'num'=>$bill['num'],
			'type'=>1,
			'price'=>$bill['price'],
			'amount'=>$bill['amount'],
			'user_type'=>2,
			'user_id'=>$supplier_id,
			'addtime'=>date("Y-m-d H:i:s"),
			'remark'=>'供应商撤销修改应付,',
		);

		$this->db->insert ( 'u_order_bill_log', $logArr);


		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}

	//修改订单,锁定订单名单
	function update_people_lock($orderid){
		$this->db->trans_start();
		$order=$this->db->query("select people_lock from u_member_order where id={$orderid}")->row_array();
		if($order['people_lock']==1){
			$people_lock=0;
		}else{
			$people_lock=1;
		}
		$this->db->where(array("id"=>$orderid))->update('u_member_order', array('people_lock'=>$people_lock));

		$this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		return false;
	    	}else{
	    		return true;
	    	}
	}
	/**
	 * 管家订单状态 - 统计
	 * @param unknown $orderid
	 * @param unknown $expertid
	 * @param unknown $order_ispay
	 * @param unknown $order_status
	 */
	function update_order_status_cal($orderid){
// 		ispay 0 未支付  1用户支付 2确认收款   3退款中  4已退款
// 		status 0用户下单  1预留位   4已确认   5出行  6评论  7投诉  -4取消退订   -3退订中

		$query = $this->db->query("SELECT ispay,status,expert_id,supplier_id FROM u_member_order WHERE id=?",array($orderid));
		$row = $query->row_array();

		//管家后台
		$ispay = $row['ispay'];
		$order_status = $row['status'];
		$expert_id = $row['expert_id'];
		$supplier_id = $row['supplier_id'];
		//状态公用参数
		$data  = array( 'order_ispay' => $ispay,'order_status'=>$order_status,'modtime'=>date("Y-m-d H:i:s",time()) );
		// 管家【ispay=0 status=0  客人已下单】   供应商【ispay=0 status=0 待控位订单】
// 		echo 'orderid===='.$orderid.'  ispay==='.$ispay."   order_status====".$order_status ." ====".($ispay==0 && $order_status==0);
		if($ispay==0 && $order_status==0){
			$expert_arr = array(
					'order_id' => $orderid,
					'expert_id' => $expert_id,
					'order_ispay'=>$ispay,
					'order_status'=>$order_status,
					'modtime'=>date("Y-m-d H:i:s",time()),
					'isread'=>'0'
			);
			$this->db->insert ( 'cal_expert_order_status', $expert_arr );
			$expert_arr = array(
					'order_id' => $orderid,
					'supplier_id' => $row['supplier_id'],
					'order_ispay'=>$ispay,
					'order_status'=>$order_status,
					'modtime'=>date("Y-m-d H:i:s",time()),
					'isread'=>'0'
			);
			$this->db->insert ( 'cal_supplier_order_status', $expert_arr );
// 			echo "  SQL== ".$this ->db ->last_query();
		}else if($ispay==0 && $order_status==1){ //管家【ispay=0 status=1  供应商已预留位待用户付款】      供应商【等待用户付款】
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);

		}else if($ispay==0 && $status=-4){ //管家【ispay=0 status=-4  已取消】  供应商【ispay=0 status=-4  已取消】
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}
		//付款部分
		else if($ispay==1 && $order_status==1){//管家【ispay=1  客人已付款】
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}else if($ispay==2 && $order_status==1){//管家【ispay=1  平台已确认收款】
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}

		//确认订单
		else if($ispay==2 && $order_status==4){//管家【供应商已确认】  供应商 已确认
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}

		//确认订单
		else if($ispay==2 && $order_status==5){//管家【供应商已确认】  供应商 已确认
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}

		//退款部分
		else if($ispay==3 && $order_status==-3){//用户退款中
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}
		else if($ispay==4 && $order_status==-4){//用户已退款
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}
		//其他
		else if($order_status==6){//用户已退款
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}
		else if($order_status==7){//用户已退款
			$this->db->where(array("order_id"=>$orderid,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("order_id"=>$orderid,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);
		}
		else if($ispay==2 && $order_status==1){// 管家【ispay=2 status=1】  待供应商确认   供应商【（ispay=2 status=1 ) 待确认订单】
			$this->db->where(array("id"=>$id,'expert_id'=>$expert_id,'isread'=>'0'));
			$this->db->update('cal_expert_order_status', $data);

			$this->db->where(array("id"=>$id,'supplier_id'=>$supplier_id,'isread'=>'0'));
			$this->db->update('cal_supplier_order_status', $data);

		}

	}


	/**
	 * 更新供应商订单状态 - 统计
	 * @param unknown $orderid
	 * @param unknown $expertid
	 * @param unknown $order_ispay
	 * @param unknown $order_status
	 */
	function update_supplier_order_status($orderid,$supplier_id,$order_ispay,$order_status){

	}
	//B端下单 成本的信用额度
	function save_order_debit($orderid,$ap_reply=''){
		$this->db->trans_start();

		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$debit_sql="SELECT SUM(real_amount) as all_amount from u_order_debit where (type=1 or type=2) and order_id={$orderid}";
		$debit = $this->db->query($debit_sql)->row_array(); //订单扣款表

		$order_sql="select mom.*,de.name from u_member_order as mom left join b_depart as de on mom.depart_id=de.id ";
		$order_sql.=" where mom.id={$orderid} ";
		$order= $this->db->query($order_sql)->row_array(); //订单

		$credit_limit=$order['total_price']-$debit['all_amount'];

		//信用额度申请表
		$limitApply=$this->db->query("select id,credit_limit from b_limit_apply where order_id={$orderid} and status=1 ")->row_array();
		$this->db->where(array('order_id'=>$orderid,'status'=>1))->update('b_limit_apply',array('status'=>3,'reply'=>$ap_reply,'modtime'=>date("Y-m-d H:i:s",time())));
		/*$limitApply=array(
			'depart_id'=>$order['depart_id'],
			'depart_name'=>$order['name'],
			'expert_id'=>$order['expert_id'],
			'expert_name'=>$order['expert_name'],
			'credit_limit'=>$credit_limit,
			'return_time'=>$return_time,
			'addtime'=>date("Y-m-d H:i:s",time()),
			'modtime'=>date("Y-m-d H:i:s",time()),
			'supplier_id'=>$login_id,
			'status'=>3,
			'union_id'=>$order['platform_id'],
		);
		$this->db->insert ( 'b_limit_apply', $limitApply );
		$apply_id=$this->db->insert_id(); */

		//管家信用申请使用表
		$expertApply=array(
			'depart_id'=>$order['depart_id'],
			'depart_name'=>$order['name'],
			'expert_id'=>$order['expert_id'],
			'expert_name'=>$order['expert_name'],
			'apply_id'=>$limitApply['id'],
			'order_id'=>$orderid,
			'apply_amount'=>$limitApply['credit_limit'],
			'real_amount'=>$limitApply['credit_limit'],
			'addtime'=>date("Y-m-d H:i:s",time()),
			'status'=>1,
			//'return_time'=>date("Y-m-d H:i:s",time()),
		);
						
		$this->db->insert ( 'b_expert_limit_apply', $expertApply );

		$new=$this->db->query("select * from b_depart where id={$order['depart_id']}")->row_array(); //订单	
		//营业部额度变化记录表
		$limitLog=array(
			'depart_id'=>$order['depart_id'],
			'expert_id'=>$order['expert_id'],
			//'expert_name'=>$order['expert_name'],
			'order_id'=>$orderid,
			'union_id'=>$order['platform_id'],
			'supplier_id'=>$login_id,
			'addtime'=>date("Y-m-d H:i:s"),
			'order_sn'=>$order['ordersn'],
			'cash_limit'=>$new['cash_limit'],
			'credit_limit'=>$new['credit_limit'],
			'order_price'=>$order['total_price'],
		);
		$limitLog['remark']='供应商通过管家申请信用,信用额度'.$limitApply['credit_limit'];
		$limitLog['sx_limit']=$limitApply['credit_limit'];
		$limitLog['type']='管家信用申请通过';
		$this->db->insert ( 'b_limit_log', $limitLog );

		$limitLog['remark']='下单扣管家申请信用,信用额度-'.$limitApply['credit_limit'];
		$limitLog['sx_limit']='-'.$limitApply['credit_limit'];
		$limitLog['type']='下单扣管家信用';
		$this->db->insert ( 'b_limit_log', $limitLog );
		
		//改变订单状态
		$this->db->where(array("id"=>$orderid))->update('u_member_order', array('status'=>4,'confirmtime_supplier'=>date("Y-m-d H:i:s")));
		//改变订单记录
		$this->db->where(array("id"=>$orderid))->update('cal_supplier_order_status', array('order_ispay'=>2,'order_status'=>4));

		//订单扣款表
		$this->db->where(array("order_id"=>$orderid,'type'=>3))->update('u_order_debit', array('real_amount'=>$limitApply['credit_limit']));

		$settle_agent = round($order['diplomatic_agent'] + $order['platform_fee'] ,2);
		$settle_sql = 'update b_union set not_settle_agent = not_settle_agent + '.$settle_agent . ' where id = '.$order['platform_id'];
		$this ->db ->query($settle_sql);

		//减位置
		if($order['suitnum']>0){
			$member_sum=$order['suitnum'];
		}else{
			$member_sum=$order['childnobednum']+$order['childnum']+$order['oldnum']+$order['dingnum'];
		}
		$suit_sql=" update u_line_suit_price  set number=number-{$member_sum},order_num=order_num+1 where is_open=1 and suitid={$order['suitid']} and day='{$order['usedate']}' ";
		$this ->db ->query($suit_sql);

		$this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		return false;
	    	}else{
	    		return true;
	    	}
	}
	//下单额度
	function get_order_debit_list($orderid){
		//订单结果
		$order_sql="select mo.total_price,mo.childnobednum,mo.childnum,mo.dingnum,mo.oldnum,mo.usedate,";
		$order_sql.="(mo.childnobednum+mo.childnum+mo.dingnum+mo.oldnum) as  all_num,e.realname,e.depart_name  ";
		$order_sql.=" from u_member_order as mo left join u_expert as  e on mo.expert_id=e.id where mo.id={$orderid}";
		$order=$this->db->query($order_sql)->row_array();
		$data['order']=$order;
		//现金金额
		$cash_sql=" select sum(real_amount) as real_amount from u_order_debit where order_id={$orderid} and type=1 ";
		$cash_limit= $this->db->query($cash_sql)->row_array();
		$data['cash_limit']=$cash_limit['real_amount'];
		//信用额度
		$credit_sql=" select sum(real_amount) as real_amount from u_order_debit where order_id={$orderid} and type=2 ";
		$credit_limit= $this->db->query($credit_sql)->row_array();
		$data['credit_limit']=$credit_limit['real_amount'];
		//申请额度
		//$data['apply_limit']=$order['total_price']-$data['cash_limit']-$data['credit_limit'];

		//还款时间
		$limt= $this->db->query("select return_time,credit_limit from b_limit_apply where order_id={$orderid} and status=1 ")->row_array();
		$data['return_time']=$limt['return_time'];

		//申请额度
		$data['apply_limit']=$limt['credit_limit'];

		return $data;
	}
	//拒绝申请的订单
	function update_order_debit($orderid,$s_reply){
		$this->db->trans_start();
		//信用额度申请表 ,改变申请状态
		$limitApply=$this->db->query("select id,credit_limit from b_limit_apply where order_id={$orderid}")->row_array();
		$updateLimit=array(
			'status'=>5,
			'reply'=>$s_reply,
			'modtime'=>date("Y-m-d H:i:s",time())
		);
		$this->db->where(array('order_id'=>$orderid,'status'=>1))->update('b_limit_apply', $updateLimit);

		//订单信息
		$order=$this->db->query("select * from u_member_order where id={$orderid}")->row_array();

		//--------------营业部现金---------------
		$cash=$this->db->query("select sum(real_amount) as amount from u_order_debit where type=1 and order_id={$orderid}")->row_array();

		//还营业部的现金
		$cash_sql=" update b_depart  set cash_limit=cash_limit+{$cash['amount']}  where id={$order['depart_id']} ";
		$this ->db ->query($cash_sql);
	    //还扣款表
		$this ->db ->query("update u_order_debit  set repayment={$cash['amount']}  where order_id={$orderid} and type=1");
		
		//营业部信息
		$departArr=$this->db->query("select * from b_depart where  id={$order['depart_id']}")->row_array();
		//还现金额度
		$limitLog=array(
			'depart_id'=>$order['depart_id'],
			'expert_id'=>$order['expert_id'],
			//'expert_name'=>$order['expert_name'],
			'order_id'=>$orderid,
			'union_id'=>$order['platform_id'],
			'supplier_id'=>$order['supplier_id'],
			'addtime'=>date("Y-m-d H:i:s"),
			'order_sn'=>$order['ordersn'],
			'cash_limit'=>$departArr['cash_limit'],
			'credit_limit'=>$departArr['credit_limit'],
			'refund_monry'=>$cash['amount'],
			'type'=>'单团额度审批拒绝，供应商退营业部现金',
			'remark'=>'单团额度审批拒绝，供应商退营业部额度',
			'order_price'=>$order['total_price']
		);
		$this->db->insert ( 'b_limit_log', $limitLog );

		//----------------营业部信用-------------
		$credit=$this->db->query("select sum(real_amount) as amount from u_order_debit where type=2 and order_id={$orderid}")->row_array();
		//营业部额度变化
		$debit_sql=" update b_depart  set credit_limit=credit_limit+{$credit['amount']} where id={$order['depart_id']} ";
		$this ->db ->query($debit_sql);

		//还扣款表
		$this ->db ->query("update u_order_debit  set repayment={$credit['amount']}  where order_id={$orderid} and type=2");
		
		//营业部信息
		$depart=$this->db->query("select * from b_depart where  id={$order['depart_id']}")->row_array();
		//还营业部的信用额度
		$limitLog=array(
			'depart_id'=>$order['depart_id'],
			'expert_id'=>$order['expert_id'],
			'order_id'=>$orderid,
			'union_id'=>$order['platform_id'],
			'supplier_id'=>$order['supplier_id'],
			//'addtime'=>date("Y-m-d H:i:s"),
			'addtime'=>date('Y-m-d H:i:s',strtotime("+1 second")),
			'order_sn'=>$order['ordersn'],
			'cash_limit'=>$depart['cash_limit'],
			'credit_limit'=>$depart['credit_limit'],
			'refund_monry'=>$credit['amount'],
			'type'=>'单团额度审批拒绝，供应商退营业部信用',
			'remark'=>'单团额度审批拒绝，供应商退营业部现金',
			'order_price'=>$order['total_price']
		);
		$this->db->insert ( 'b_limit_log', $limitLog );


		//-----订单扣款表--------
		//$debit_sql=" update u_order_debit  set repayment=real_amount where order_id={$orderid} ";
		//$this ->db ->query($debit_sql);

		//修改订单状态
		$this->db->where(array("id"=>$orderid))->update('u_member_order', array('status'=>-1,'canceltime'=>date("Y-m-d H:i:s",time())));

		//订单收款表的转态是0 ,改为6;

		$this->db->where(array("order_id"=>$orderid,'status'=>0))->update('u_order_receivable', array('status'=>6));

		$this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		return false;
	    	}else{
	    		return true;
	    	}
	}
	//获取退团信息
	function get_tuituanData($bill,$orderid){
		//成本账单
		$billyf=$this->db->query("select order_id,(num+childnobednum+childnum+oldnum) as member from u_order_bill_yf where id={$bill}")->row_array();
		$orderid=$billyf['order_id'];
		//退团信息
		$order_sql="select byf.amount,(mo.supplier_cost-mo.platform_fee) as up_money,mo.supplier_cost,mo.platform_fee,mo.balance_money ";
		$order_sql.="from u_order_bill_yf as byf  left join u_member_order as mo on mo.id=byf.order_id where mo.id={$orderid} and byf.id={$bill} ";
		$orderyf=$this->db->query($order_sql)->row_array();
		//申请额度
		$limit_sql="select sum(lay.credit_limit) as credit_limit from b_limit_apply as lay left join b_expert_limit_apply as ela on ela.apply_id=lay.id where ela.order_id={$orderid} and (lay.status=3 or lay.status=4) ";
		$limit_sql=$this->db->query($limit_sql)->row_array();

		//供应商退款申请表
		$refund_sql="select refund_money,reply,remark from u_supplier_refund where order_id={$orderid} and status=1 and yf_id={$bill}";
		$refund=$this->db->query($refund_sql)->row_array();

		$data['up_money']=$orderyf['up_money']; //结算价-平台佣金
		$data['supplier_cost']=$orderyf['supplier_cost']; //结算价
		$data['platform_fee']=$orderyf['platform_fee'];  //平台管理
		$data['balance_money']=$orderyf['balance_money']; //已结算价格
		$data['credit_limit']=$limit_sql['credit_limit']; //申请的额度
		$data['amount']=$orderyf['amount'];  //修改成本价
		$data['p_amount']=$orderyf['up_money']-$data['balance_money']; //未结算

		$data['member']=$billyf['member']; //退团人数

		//人数
		$order=$this->db->query("select productname,usedate from u_member_order where id={$orderid}")->row_array();

		$data['linename']=$order['productname']; //线路名称
		$data['usedate']=$order['usedate']; //出团日期

		if(empty($refund['refund_money'])){
			$refund['refund_money']=0;
		}
		if(empty($refund['reply'])){
			$refund['reply']='';
		}

		$data['s_refund_money']=$refund['refund_money'];
		$data['s_reply']=$refund['reply'];
		return $data;

	}
	//计算通过成本账单和申请的中单
	function  get_order_yf_list($orderid,$bill_id){
		$billyf=$this->db->query("select sum(amount) as  amount from u_order_bill_yf where order_id={$orderid} and status=2 ")->row_array();
		if(!empty($bill_id)){
			$bill=$this->db->query("select sum(amount) as  amount from u_order_bill_yf where  id={$bill_id} ")->row_array();
		}

		$sum=0;
		if(!empty($billyf)){
			$sum=$sum+$billyf['amount'];
		}
		if(!empty($bill)){
			$sum=$sum+$bill['amount'];
		}
		return $sum;
	}
	//计算通过成本账单
	function get_order_q($orderid){
		$billyf=$this->db->query("select sum(amount) as  amount from u_order_bill_yf where order_id={$orderid} and status=2 ")->row_array();
		$sum=0;
		if(!empty($billyf)){
			$sum=$sum+$billyf['amount'];
		}
		return $sum;
	}
	function  get_order_yf_data($orderid){
		$billyf=$this->db->query("select sum(amount) as  amount from u_order_bill_yf where order_id={$orderid} and (status=1 or status=2) ")->row_array();
		$sum=0;
		if(!empty($billyf)){
			$sum=$sum+$billyf['amount'];
		}
		return $sum;
	}

	//供应商退款申请表
	function add_order_refund($Tmessage,$orderid,$bill_id,$supplier_id,$remark,$core_pic,$t_meney){
		$this->db->trans_start();
		$falg=true;

		$billyf=$this->db->query("select order_id,status from u_order_bill_yf where id={$bill_id}")->row_array();
		$orderid=$billyf['order_id'];

		$sql="select mo.platform_id,un.union_name from u_member_order as mo  left join b_union as un on un.id=mo.platform_id where mo.id={$orderid}";
		$union=$this->db->query($sql)->row_array();
		if(empty($Tmessage['credit_limit'])){
			$Tmessage['credit_limit']=0;
		}
		//供应商退款申请表
		$refundArr=array(
			'supplier_id'=>$supplier_id,
			'order_id'=>$orderid,
			'balance_money'=>$Tmessage['up_money'],
			'settle_money'=>$Tmessage['balance_money'],
			'collection_money'=>0,
			'credit_money'=>$Tmessage['credit_limit'],
			'refund_money'=>$t_meney,
			'remark'=>$remark,
			'addtime'=>date("Y-m-d",time()),
			'union_id'=>$union['platform_id'],
			'union_name'=>$union['union_name'],
			'status'=>0,
			'yf_id'=>$bill_id,
		);
		//var_dump($refundArr);exit;
		$this->db->insert ( 'u_supplier_refund', $refundArr );
		$refund_id=$this->db->insert_id();

		$refundPicArr=array('refund_id'=>$refund_id,'core_pic'=>$core_pic);
		$this->db->insert ( 'u_supplier_refund_pic', $refundPicArr);

		//订单退款表
		$refund_sql="update u_order_refund set status=2 where order_id={$orderid} and yf_id={$bill_id}";
		$this->db->query($refund_sql);

		$this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		return false;
	    	}else{
	    		return $falg;
	    	}
	}
	//确认订单退团
	function update_bill_yf($orderid,$bill_id,$supplier_id){

		$this->db->trans_start();
		$falg=true;
		$bill= $this->db->query("select * from u_order_bill_yf where id={$bill_id} and ( status=0 or status=1) ")->row_array();
		$orderid=$bill['order_id'];
		if(!empty($orderid)){

			$order= $this->db->query("select * from u_member_order where id={$orderid}")->row_array();

			$item_price=$order['supplier_cost']+$bill['amount']; //修改价格后的成本价

			$refund=$this->db->query("select refund_money from u_supplier_refund where order_id={$orderid} and yf_id={$bill_id} and status=1")->row_array();

			if(!empty($refund['refund_money'])){  //订单成本价
				$sql="update u_member_order set supplier_cost={$item_price} where id={$orderid}";
				$this->db->query($sql);
			}else{
				$sql="update u_member_order set supplier_cost={$item_price} where id={$orderid}";
				$this->db->query($sql);
			}
			//echo $this->db->last_query();exit;
			$billArr=array(
				'supplier_id'=>$supplier_id,
				's_time'=>date('Y-m-d,H:i:s',time()),
				'status'=>2,
			);
			$this->db->where(array('id'=>$bill['id']))->update('u_order_bill_yf',$billArr);

			//修改订单日志
			$dingnum =$order['dingnum']-$bill['num'];
			$childnum =$order['childnum']-$bill['childnum'];
			$oldnum =$order['oldnum']-$bill['oldnum'];
			$childnobednum =$order['childnobednum']-$bill['childnobednum'];
			if($bill['kind']==2){
				$remark=" 订单价格{$order['supplier_cost']} 改成 成本价{$item_price} ,";
				if(!empty($bill['num'])){
					$remark.=" 退{$bill['num']}成人 , ";
				}
				if(!empty($bill['childnum'])){
					$remark.=" 退{$bill['childnum']}小孩 , ";
				}
				if(!empty($bill['childnobednum'])){
					$remark.=" 退{$bill['childnobednum']}小孩(不占床) , ";
				}
				if(!empty($bill['oldnum'])){
					$remark.=" 退{$bill['oldnum']}老人 , ";
				}

			}else{
				$remark=" 订单价格{$order['supplier_cost']} 改成 成本价{$item_price} ";
			}

			$logArr=array(
				'order_id'=>$bill['order_id'],
				'num'=>$bill['num'],
				'type'=>1,
				'price'=>$bill['price'],
				'amount'=>$bill['amount'],
				'user_type'=>2,
				'user_id'=>$bill['supplier_id'],
				'addtime'=>date("Y-m-d H:i:s"),
				'remark'=>$remark,
			);

			$this->db->insert ( 'u_order_bill_log', $logArr );

			//退订退团,返管家佣金
			$this->change_expert_limit($orderid,$bill['id'],$supplier_id);

			//订单退款表	 状态改为2
			$yfdata=$this->db->query("SELECT yf_id,id FROM  u_order_refund where order_id={$orderid} and yf_id={$bill_id} ")->row_array();
			if(!empty($yfdata)){
				$this->db->query("update u_order_refund set status=2 where order_id={$orderid} and yf_id={$bill_id} ");
			}


		}else{
			$falg=false;

		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			//若是退款的则将退款信息返回，用于发送消息，jkr
			if (!empty($yfdata))
			{
				return $yfdata;
			}
			else
			{
				return $falg;
			}
		}
	}
	//修改订单的结算状态
	function update_order_balance($orderid){
		$order=$this->db->query("select * from u_member_order where id={$orderid} ")->row_array();
		$money=$order['supplier_cost']-$order['platform_fee'];  //未结算金额
		if($money!=$order['balance_money']){
			if($order['balance_status']==2){
				$this->db->query("update u_member_order set balance_status=0 where id={$orderid}");
			}
		}
	}
	//修改成本-营业部额度变化 -返管家佣金
	// $from 来自b1或者b2端的调用,默认是b1供应商
	function change_expert_limit($orderid,$bill_id,$login_id,$from="b1"){

		//订单是否交全款
		$receiva=$this->db->query("select  sum(money) as j_money  from u_order_receivable where order_id={$orderid} and (status=2 or status=1 or status=0)")->row_array();
		$bill=$this->db->query("select  amount,kind from u_order_bill_yf where id={$bill_id} ")->row_array();

		$order=$this->db->query("select  * from u_member_order where id={$orderid} ")->row_array();
        if(empty($receiva['j_money'])){
        	$receiva['j_money']=0;
        }
		if($receiva['j_money']>=$order['total_price']){ //已交全额

				$depart=$this->db->query("select  cash_limit  from b_depart where id={$order['depart_id']} ")->row_array();

				//修改后的佣金;
				$agent_fee=$order['total_price']-$order['supplier_cost']-$order['settlement_price']-$order['diplomatic_agent'];
				 //以前的佣金-修改后的佣金;
				$agent_change=$order['depart_balance']-$agent_fee;
                if($agent_change!=0)
                {//额度有变化时
					//营业部额度变化记录表
					$limitLog=array(
						'depart_id'=>$order['depart_id'],
						'expert_id'=>$order['expert_id'],
						'order_id'=>$order['id'],
						'union_id'=>$order['platform_id'],
						'supplier_id'=>$login_id,
						'addtime'=>date('Y-m-d H:i:s',strtotime("-1 second")),
						'order_sn'=>$order['ordersn'],
						'order_price'=>$order['total_price'],
					);
					$limitMoney=-$agent_change;
					$log_start="";
					if(isset($bill['kind'])&&($bill['kind']=="2"||$bill['kind']=="4"))
						$log_start="退订退款";
					else 
					{
						if($limitMoney>0)
							$log_start="改低应付";
						else 
							$log_start="改高应付";
					}
					if($limitMoney>0){
						$limitLog['receivable_money']=$limitMoney;
						$limitLog['type']=$log_start.',返还管家佣金';
						$limitLog['remark']=$from.'：'.$log_start.'，返还管家佣金';
					}else{
						$limitLog['cut_money']=$limitMoney;//改高应付
						$limitLog['type']=$log_start.',扣除管家佣金';
						$limitLog['remark']=$from.'：'.$log_start.'，扣除管家佣金';
					}
	
					$limitLog['cash_limit']=$depart['cash_limit']+$limitMoney;
	
					$this->db->insert ( 'b_limit_log', $limitLog );
	
					//营业部额度
					$this->db->query("update b_depart set cash_limit=cash_limit+{$limitMoney} where id={$order['depart_id']} ");
	
					$this->db->query("update u_member_order set depart_balance=depart_balance+{$limitMoney} where id={$order['id']} ");
                }
		}

		//判断是否已结算金额>成本价
		$s_money=$order['supplier_cost']-$order['platform_fee'];
		if($s_money>$order['balance_money'] && $order['balance_status']==2){
		    $this->db->query("update u_member_order set balance_status=0 where id={$order['id']} ");
		}

		//修改管家佣金     应交-应付-外交-保险
		$e_sql="update u_member_order set agent_fee=total_price-supplier_cost-settlement_price-diplomatic_agent where id={$order['id']}";
		$this->db->query($e_sql);

	}

	//订单交款信息
	function get_receive_list($orderid){
		$sql="select recv.*, date_format(recv.addtime,'%Y-%c-%d %h:%i') AS addtime,e.realname,e.depart_name,e.id as expert_id ";
		$sql.=" from u_order_receivable as recv ";
		$sql.=" left join u_expert as e on e.id = recv.expert_id  where  recv.order_id = {$orderid} and recv.status>=0 and  recv.status<3 ";
		$receiva=$this->db->query($sql)->result_array();
		//echo $this->db->last_query();
		$mysql="select sum(money) as all_money from u_order_receivable where order_id={$orderid} and status=2 ";
		$ty=$this->db->query($mysql)->row_array();
		//echo $this->db->last_query();
		if(!empty($ty['all_money'])){
			$receiva[0]['all_money']=$ty['all_money'];
		}

		return  $receiva;
	}

	//修改成本-营业部额度变化
	function change_limit_apply($order,$bill_id,$login_id){

		//订单是否交全款
		$receiva=$this->db->query("select  sum(money) as j_money  from u_order_receivable where order_id={$order['id']} and status=2")->row_array();
		$bill=$this->db->query("select  amount,kind from u_order_bill_yf where id={$bill_id} ")->row_array();
		if($bill['kind']!=2){  //修改成本价
			if(empty($receiva['j_money'])){
				$receiva['j_money']=0;
			}
			if($receiva['j_money']>=$order['total_price']){ //已交全额

				$depart=$this->db->query("select  cash_limit  from b_depart where id={$order['depart_id']} ")->row_array();

				//营业部额度变化记录表
				$limitLog=array(
					'depart_id'=>$order['depart_id'],
					'expert_id'=>$order['expert_id'],
					'order_id'=>$order['id'],
					'union_id'=>$order['platform_id'],
					'supplier_id'=>$login_id,
					'addtime'=>date("Y-m-d H:i:s"),
					'order_sn'=>$order['ordersn'],
					'order_price'=>$order['total_price']
				);
				$limitMoney=-$bill['amount'];
				if($limitMoney>0){
					$limitLog['receivable_money']=$limitMoney;
				}else{
					$limitLog['cut_money']=$limitMoney;
				}

				$limitLog['cash_limit']=$depart['cash_limit']+$limitMoney;
				$limitLog['type']='调整管家佣金';
				$this->db->insert ( 'b_limit_log', $limitLog );

				//营业部额度
				$this->db->query("update b_depart set cash_limit=cash_limit+{$limitMoney} where id={$order['depart_id']} ");

				//平台佣金
				//$this->db->query("update u_member_order set agent_fee=agent_fee+{$limitMoney} where id={$order['id']} ");

				if($order['agent_fee']==$order['depart_balance']){
					$this->db->query("update u_member_order set depart_balance=depart_balance+{$limitMoney} where id={$order['id']} ");
				}
			}
		}

		//修改管家佣金     应交-应付-外交-保险
		$e_sql="update u_member_order set agent_fee=total_price-supplier_cost-settlement_price-diplomatic_agent where id={$order['id']}";
		$this->db->query($e_sql);

	}
	//订单收款表
	public function  get_order_receIve($orderid){
		$data=$this->db->query("select sum(money) as money from u_order_receivable where  status = 2 and order_id ={$orderid}")->row_array();
		return $data;
	}

	//成本账单
	public function show_order_yf($id){
		$sql="select byf.*,e.realname,e.is_dm,sre.status as re_status ";
		$sql=$sql." from u_order_bill_yf  as  byf left join  u_expert as e on byf.expert_id=e.id ";
		$sql=$sql." left join u_supplier_refund as sre on sre.yf_id=byf.id and sre.status!=2 and sre.status!=-1 ";
		$sql=$sql."  where byf.id={$id} ";
		$data=$this->db->query($sql)->row_array();
		return $data;
	}
	//应收账单
	public function get_bill_ys($orderid){
		$sql="select * from u_order_bill_ys where order_id=".$orderid;
		$data=$this->db->query($sql)->result_array();
		return $data;
	}
	//应收账单总计
	public  function get_all_ys($orderid){
		$sql="select sum(amount)as amount from u_order_bill_ys where status=1 and order_id=".$orderid;
		$data=$this->db->query($sql)->row_array();
		return $data;
	}
	//供应商申请的总金额
	public function get_order_apply_money($order_id){
		$a_sql=" select sum(amount_apply) as ap_money from u_payable_order ";
		$a_sql.="where order_id={$order_id} and (status=0 or status=1  or status=2 or status=4)";
		$appData = $this->db->query($a_sql)->row_array();
		if(!empty($appData['ap_money'])){
			$applyMo=$appData['ap_money'];
		}else{
			$applyMo=0;
		}
		return $applyMo;
	}
	//供应商正在申请的总金额
	public function get_order_un_money($order_id){
		$a_sql=" select sum(amount_apply) as ap_money from u_payable_order ";
		$a_sql.="where order_id={$order_id} and (status=0 or status=1  or status=2 )";
		$appData = $this->db->query($a_sql)->row_array();
		if(!empty($appData['ap_money'])){
			$applyMo=$appData['ap_money'];
		}else{
			$applyMo=0;
		}
		return $applyMo;
	}
	//供应商审核额度
	function get_order_limit_apply($order_id,$supplier_id){

	    $sql=" select la.credit_limit as credit_limit, s.brand,la.reply, la.remark,u.union_name ";
	    $sql.="from b_limit_apply as la";
	    $sql.=" left join u_supplier as s on la.supplier_id = s.id ";
	    $sql.=" left join b_union as u on la.union_id = u.id ";
	    $sql.="where (la.status=3 or la.status=4)";
	    $sql.="and la.order_id={$order_id}";
	    $data=$this->db->query($sql)->row_array();
	    return $data;
	}
	//订单改价
	function get_order_bill_msg($supplier_id){
	    $sql=" select oy.id from u_order_bill_yf as oy left join u_member_order as mom on oy.order_id =mom.id ";
	    $sql.=" where (oy.status=1 or (oy.kind=3 and oy.status=0)) and mom.supplier_id={$supplier_id}";
	    $sql.=" GROUP BY mom.id ";
	    $data=$this->db->query($sql)->result_array();
	    return $data;
	}
	//模糊目的地搜索
	function get_destname($destname){		
		$data=$this->db->query("select id,kindname from u_dest_base  where kindname = '{$destname}'")->row_array();
	    return $data;
	}
	//获取营业部额度
	function get_depart_limit($depart_id){
		$sql = 'SELECT * FROM b_depart WHERE id='.$depart_id;
		$depart_limit = $this->db->query($sql)->result_array();
		if(!empty($depart_limit)){
			return $depart_limit[0];
		}else{
			return array('id'=>$depart_id,'name'=>'','cash_limit'=>0,'credit_limit'=>0,'name'=>'');
		}
	
	}
}