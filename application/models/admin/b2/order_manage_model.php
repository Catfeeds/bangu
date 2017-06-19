<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:00:11
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_manage_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}


	//获取订单列表数据
	public function get_orders($whereArr=array(),$page = 1, $num = 10) {
	       //1、主sql 
		   $sql = " SELECT 
	        					e.realname,e.depart_name,l.lineday,mb_od.item_code AS team_code,l.id AS line_id,
	        					l.linecode, mb_od.id AS order_id,mb_od.supplier_id,mb_od.ordersn AS ordersn, 
	        					mb_od.depart_id AS depart_id,mb_od.linkmobile AS linkmobile,mb_od.linkman AS linkman,
	        					mb_od.productname AS linename,(mb_od.childnum+mb_od.dingnum+mb_od.oldnum+mb_od.childnobednum) AS people_num,
	        					(mb_od.total_price+mb_od.settlement_price) AS order_amount,mb_od.usedate AS usedate,mb_od.total_price, 
	        					mb_od.supplier_cost,mb_od.ispay,mb_od.STATUS AS md_status,mb_od.addtime AS addtime,mb_od.agent_fee AS agent_fee,
	        				    s.company_name AS supplier_name, s.mobile AS s_mobile, mb_od.dingnum, suit.unit AS unit 
	        		FROM 
	        					u_member_order AS mb_od 
	        					LEFT JOIN u_line AS l ON mb_od.productautoid = l.id 
	        					LEFT JOIN u_supplier AS s ON mb_od.supplier_id = s.id  
	        					LEFT JOIN u_line_suit AS suit ON suit.id = mb_od.suitid 
	        					LEFT JOIN u_line_suit_price AS suit_price ON suit_price.suitid = mb_od.suitid AND suit_price.day=mb_od.usedate  
	        					LEFT JOIN u_expert AS e ON e.id=mb_od.expert_id  
	        					LEFT JOIN u_line_startplace AS ls ON ls.line_id = mb_od.productautoid 
	        					LEFT JOIN u_startplace AS sp ON sp.id=ls.startplace_id 
	        		WHERE 
	        					mb_od.user_type=1 ";
		    //2、where条件
			$whereStr = '';
			if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				if($key=="supplier_ids" || $key=="overcity" || $key=="mb_od.depart_id" || $key=="mb_od.status"){
					$whereStr .= ' '.$val.' AND';
				}else{
					$whereStr .= ' '.$key.'"'.$val.'" AND';
				}
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' AND '.$whereStr;
			}
		   if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." GROUP BY mb_od.id ORDER BY mb_od.addtime DESC";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		   }else{
			$sql = $sql." GROUP BY mb_od.id ORDER BY mb_od.addtime DESC";
			$total_num = $this->getCount($sql,'');
			return $total_num;
		   }
	}

/*'parent_depart_id'	=> current(explode(',',rtrim($expertArr [0]['depart_list'],','))),
			'depart_id'			=>	end(explode(',',rtrim($expertArr [0]['depart_list'],','))),*/

	public function is_show_order($order_id,$order_depart_id){
		$is_manage = $this->session->userdata('is_manage');
		$parent_depart_id = $this->session->userdata('parent_depart_id');
		$depart_id = $this->session->userdata('depart_id');
		$order_info = $this->get_one_order($order_id);
		//if($is_manage==1){
		/*	$sql = 'SELECT id,depart_id,depart_list FROM u_expert WHERE id='.$order_expert_id;
			$query = $this->db->query($sql);
			$result=$query->row_array();*/
		if(empty($order_info))
			return false;
		else 
		{
			$depart_id_1 = current(explode(',',rtrim($order_info['depart_list'],',')));
			if($is_manage==1){
					if($depart_id_1==$parent_depart_id){
					 	return true;
					}else{
						return false;
					}
			}else{
					if($order_info['depart_id']==$depart_id){
						return true;
					}else{
						return false;
					}
			}
		}
	}

//获取订单出行人列表数据
	public function get_travels($order_id) {
	$sql = ' SELECT mt.* FROM u_member_order_man AS m LEFT JOIN u_member_traver AS mt ON mt.id=m.traver_id WHERE m.order_id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	public function get_one_travel($id){
		$sql = 'SELECT mt.* FROM  u_member_traver AS mt  WHERE mt.id='.$id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}
//获取选择的退订人数据
	public function get_tuituan_travels($travel_id) {
	$sql = ' SELECT GROUP_CONCAT(mt.name) AS mt_name FROM  u_member_traver AS mt  WHERE mt.id IN ('.$travel_id.')';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}


//获取订单的佣金计算规则
function get_agent_rules($order_id){
	$sql = 'SELECT * FROM u_order_agent WHERE order_id='.$order_id;
	$query = $this->db->query($sql);
	$result=$query->row_array();
	return $result;
}


	//保存这些退团人信息
	public function save_tuituan_travels($travel_id,$order_id,$yf_id) {
	$sql = ' INSERT INTO u_order_travel_del ( order_id, name, enname, certificate_type, certificate_no, endtime, country, telephone, sex, birthday, addtime, modtime, isman, member_id, enable, sign_place, sign_time, people_type, cost, price, yf_id )  SELECT '.$order_id.', name, enname, certificate_type, certificate_no, endtime, country, telephone, sex, birthday, addtime, modtime, isman, member_id, enable, sign_place, sign_time, people_type, cost, price, '.$yf_id.' FROM u_member_traver WHERE id  IN ('.$travel_id.')';
		$status = $this->db->query($sql);
		return $status;
	}
	//统计各个类别人群的数量
	public function get_group_count($traver_id) {
	$sql ='SELECT people_type,count(people_type) AS count_type,price AS mt_price,cost AS mt_cost FROM u_member_traver  WHERE id in('.$traver_id.') GROUP BY people_type';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}

	//获取一条订单数据
	//
	//$whereArr=array()
	function get_one_order($order_id){
		$sql = 'SELECT md.*,e.depart_name,e.realname,suit.suitname,suit.unit,l.linebefore,aff.deposit,order_aff.deposit AS order_deposit,order_aff.before_day FROM u_member_order AS md LEFT JOIN u_expert AS e ON e.id=md.expert_id LEFT JOIN u_line_suit AS suit ON suit.id=md.suitid  LEFT JOIN u_line AS l ON l.id=md.productautoid LEFT JOIN u_line_affiliated AS aff ON aff.line_id=l.id LEFT JOIN u_member_order_affiliated AS order_aff ON order_aff.order_id=md.id WHERE md.id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result))
			return $result[0];
		else
			return array();
	}

	//获取一条应付数据
	function get_one_yf($yf_id){
		$sql = 'SELECT * FROM u_order_bill_yf WHERE id='.$yf_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}
//获取一条订单已收款
//WHERE order_id='.$order_id.' AND status=2
	function get_sum_receive($whereArr){
		$whereStr = '';
		$sql = 'SELECT IFNULL(sum(money), 0)  AS total_receive_amount FROM u_order_receivable ';
		foreach($whereArr as $key=>$val){
			if($key!="status!="){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}else{
				$whereStr .= ' status not in('.$val.') AND';
			}

		}
		$whereStr = rtrim($whereStr ,'AND');
		$sql = $sql.' WHERE '.$whereStr;
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result;
	}

	//取消等待旅行社审核的交款
	function cancle_receive($order_id){
		$status = $this->db->query('UPDATE u_order_receivable SET status=4 WHERE order_id='.$order_id.' AND (status=0 OR status=1 OR status=5) ');
		return $status;
	}


	function get_pedding_receive($order_id){
		$sql = 'SELECT GROUP_CONCAT(id) AS recevie_ids, IFNULL(SUM(money),0) AS total_money FROM u_order_receivable WHERE order_id='.$order_id.' AND (status=0 OR status=1 OR status=5)';
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result;
	}

	//获取一条退款信息
	function get_refund_data($whereArr){
		$whereStr = '';
		$sql = 'SELECT * FROM u_order_refund ';
		foreach($whereArr as $key=>$val){
			if($key!="status!="){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}else{
				$whereStr .= ' status not in('.$val.') AND';
			}
		}
		$whereStr = rtrim($whereStr ,'AND');
		$sql = $sql.' WHERE '.$whereStr.' ORDER BY id DESC LIMIT 1';
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result;
	}

	/*
	 * wwb
	 * */
	function get_sum_receive2($whereArr){
		$sql = 'SELECT IFNULL(sum(money), 0) AS total_receive_amount FROM u_order_receivable ';
		$sql = $sql.' WHERE '.$whereArr;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}

	/*
	 * wxf
	 * */
	function get_sum_pay($whereArr){
		$whereStr = '';
		$whereArr['status!='] = 3;
		$sql = 'SELECT IFNULL(sum(amount_apply), 0)  AS total_pay_amount FROM u_payable_order ';
		foreach($whereArr as $key=>$val){
			$whereStr .= ' '.$key.'"'.$val.'" AND';
		}
		$whereStr = rtrim($whereStr ,'AND');
		$sql = $sql.' WHERE '.$whereStr;
		
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result;
	}

//获取应收客人账单记录
 function get_ys_data($whereArr){
 	$where_str = '';
 	$sql = 'SELECT ys.*,e.realname AS e_name,date_format(ys.addtime,\'%Y-%c-%d %H:%i\') AS addtime FROM u_order_bill_ys AS ys LEFT JOIN u_expert AS e ON e.id=ys.expert_id ';
 		if(!empty($whereArr)){
	 		foreach ($whereArr as $key => $value) {
	 			$where_str .= $key.'='.$value.' AND ';
	 		}
	 		$where_str = rtrim($where_str,' AND ');
	 	}
	 	$sql .= ' WHERE '.$where_str;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
 }

 //获取为确定下的应收款总和
 function get_sum_ys($order_id){
 	    $sql = 'SELECT SUM(amount) AS sum_amount FROM u_order_bill_ys AS ys  WHERE status!=3 AND order_id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result['sum_amount'];
 }

 //获取为应付账单
 function get_sum_yf($order_id){
 	    $sql = 'SELECT SUM(amount) AS sum_amount FROM u_order_bill_yf AS yf  WHERE status!=3 AND status!=4 AND order_id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result['sum_amount'];
 }

//获取应付供应商账单记录
 function get_yf_data($whereArr){
 	$where_str = '';
 	$sql = 'SELECT yf.*,e.realname,date_format(yf.addtime,\'%Y-%c-%d %H:%i\') AS addtime FROM  u_order_bill_yf AS yf LEFT JOIN u_expert AS e ON e.id=yf.expert_id ';
	 	if(!empty($whereArr)){
	 		foreach ($whereArr as $key => $value) {
	 			$where_str .= $key.'='.$value.' AND ';
	 		}
	 		$where_str = rtrim($where_str,' AND ');
	 	}
	 	$sql .= ' WHERE '.$where_str;

		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
 }
//获取保险账单
 function get_bx_data($order_id){
 	$sql = 'SELECT *,date_format(addtime,\'%Y-%c-%d %H:%i\') AS addtime FROM  u_order_bill_bx WHERE order_id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
 }
 //获取已收账单
 function get_receive_data($order_id){
 	$sql = 'SELECT recv.*,date_format(recv.addtime,\'%Y-%c-%d %H:%i\') AS addtime,e.realname,e.depart_name FROM  u_order_receivable AS recv LEFT JOIN u_expert AS e ON e.id=recv.expert_id WHERE recv.order_id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
 }


  //外交佣金账单数据
 function get_commission_data($order_id){
 	$sql = 'SELECT *,date_format(addtime,\'%Y-%c-%d %H:%i\') AS addtime FROM  u_order_bill_wj WHERE order_id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
 }

  //套餐数据 $whereArr
 function get_suit_price_data($whereArr){
 	$where_str='';
 	$sql = 'SELECT lsp.*,l.line_kind FROM u_line_suit_price AS lsp left join u_line as l on l.id=lsp.lineid';
 	if(!empty($whereArr)){
 		foreach ($whereArr as $key => $value) {
 			$where_str .= $key.'='.$value.' AND ';
 		}
 		$where_str = rtrim($where_str,' AND ');
 	}
 	$sql .= ' WHERE '.$where_str;
	$query = $this->db->query($sql);
	$result=$query->result_array();

	if(empty($result))
		return array();
	else
		return $result[0];
 }

 //获得管家可用额度之和
 function get_expert_limit($order_id){
 		$final_res = array();
 		$order_depart_sql = 'select depart_id from u_member_order where id='.$order_id;
 		$query = $this->db->query($order_depart_sql);
 		$order_depart=$query->result_array();
 		$sql = 'SELECT ela.apply_amount,ela.real_amount FROM b_expert_limit_apply AS ela WHERE order_id='.$order_id;
		$query = $this->db->query($sql);
		$res=$query->result_array();
		$sql_depart = 'SELECT cash_limit,credit_limit FROM b_depart  WHERE id='.$order_depart[0]['depart_id'];
		$query = $this->db->query($sql_depart);
		$result=$query->result_array();
		$total_limit = $result[0]['cash_limit']+$result[0]['credit_limit'];
		if(!empty($res)){
			$total_limit = $result[0]['cash_limit']+$result[0]['credit_limit']+($res[0]['apply_amount']-$res[0]['real_amount']);
			$final_res['cash_limit'] 		=  $result[0]['cash_limit'];
			$final_res['credit_limit'] 		=  $result[0]['credit_limit'];
			$final_res['apply_amount'] 	=  $res[0]['apply_amount'];
			$final_res['real_amount'] 		=  $res[0]['real_amount'];
			$final_res['total_limit'] 		=  $total_limit ;
		}else{
			$total_limit = $result[0]['cash_limit']+$result[0]['credit_limit'];
			$final_res['cash_limit'] 		=  $result[0]['cash_limit'];
			$final_res['credit_limit'] 		=  $result[0]['credit_limit'];
			$final_res['apply_amount'] 	=  0;
			$final_res['real_amount'] 		=  0;
			$final_res['total_limit'] 		=  $total_limit ;
		}
		return $final_res;
 	}




 	//获取外交佣金
 	function get_foreign_agent($overcity){
 		$sql = 'SELECT adult_agent,child_agent,childnobed_agent,old_agent FROM  u_foreign_agent WHERE union_id='.$this->session->userdata('union_id').' AND dest_id='.$overcity;
		$foreign_agent = $this->db->query($sql)->result_array();
		return $foreign_agent;
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

 	//获取管家信用使用记录
 	function get_e_limit($order_id){
 		$sql = 'SELECT * FROM b_expert_limit_apply WHERE order_id='.$order_id;
		$expert_limit = $this->db->query($sql)->result_array();
		if(!empty($expert_limit)){
			return $expert_limit[0];
		}else{
			return array('apply_amount'=>0,'real_amount'=>0);
		}
 	}

 	//获取管家信用申请记录
 	function get_apply_limit($whereArr=array()){
 		$whereStr = '';
 		$sql = 'SELECT s.company_name,bu.union_name, app.* FROM b_limit_apply AS app LEFT JOIN b_union AS bu ON bu.id=app.union_id LEFT JOIN u_supplier AS s ON s.id=app.supplier_id';
 		foreach($whereArr as $key=>$val){
			if($key!="status!="){
				$whereStr .= ' app.'.$key.'"'.$val.'" AND';
			}else{
				$whereStr .= ' app.status not in('.$val.') AND';
			}
		}
		$whereStr = rtrim($whereStr ,'AND');
		$sql = $sql.' WHERE '.$whereStr;
		$expert_limit = $this->db->query($sql)->result_array();
		return $expert_limit;
 	}

 	//获取经理ID
 	function get_manage(){
 		$sql = 'SELECT * FROM u_expert WHERE is_dm=1 AND depart_id='.$this->session->userdata('parent_depart_id');
		$manage = $this->db->query($sql)->result_array();
		return $manage[0];
 	}

 	//获取人头费
 	function get_line_agent($supplier_id){
 		$sql = 'SELECT * FROM b_union_line_agent WHERE union_id='.$this->session->userdata('union_id').' AND supplier_id='.$supplier_id;
		$line_agent = $this->db->query($sql)->result_array();
		return $line_agent;
 	}

 	//获取天数类型人头费
 	function get_line_agent_day($supplier_id,$lineday){
 		$sql = 'SELECT money FROM b_union_line_agent_day WHERE union_id='.$this->session->userdata('union_id').' AND supplier_id='.$supplier_id.' AND day='.$lineday;
		$line_agent_day = $this->db->query($sql)->result_array();
		return $line_agent_day;
 	}

 	//获取旅行社单位银行信息
 	function get_union_bank($whereArr=array()){
		$sql = 'SELECT bankcard ,bankname  FROM  b_union WHERE  id='.$this->session->userdata('union_id');
		$bank_info = $this->db->query($sql)->result_array();
		return $bank_info[0];
 	}

 	//获取使用了的发票数据
 	function get_use_invoice_data($order_id){
		$sql = 'SELECT GROUP_CONCAT(invoice_code) AS use_invoice_code FROM b_invoice_list WHERE order_id='.$order_id;
		$invoice = $this->db->query($sql)->result_array();
		return $invoice;
 	}
 	//获取使用了的发票数据: 列表
 	function get_use_invoice_list($order_id){
 		$sql = 'SELECT * FROM b_invoice_list WHERE order_id='.$order_id;
 		$invoice = $this->db->query($sql)->result_array();
 		return $invoice;
 	}


 	//获取使用了的收据数据
 	function get_use_receipt_data($order_id){
		$sql = 'SELECT GROUP_CONCAT(receipt_code) AS use_receipt_code FROM b_receipt_list WHERE order_id='.$order_id;
		$receipt = $this->db->query($sql)->result_array();
		return $receipt;
 	}
 	//获取使用了的收据数据:列表
 	function get_use_receipt_list($order_id){
 		$sql = 'SELECT * FROM b_receipt_list WHERE order_id='.$order_id;
 		$receipt = $this->db->query($sql)->result_array();
 		return $receipt;
 	}

 	//获取使用了的合同数据
 	function get_use_contract_data($order_id){
		$sql = 'SELECT GROUP_CONCAT(contract_code) AS use_contract_code FROM b_contract_list WHERE order_id='.$order_id;
		$contract = $this->db->query($sql)->result_array();

		$sql = 'SELECT GROUP_CONCAT(contract_code) AS use_contract_code FROM b_contract_launch WHERE order_id='.$order_id;
		$contract_launch = $this->db->query($sql)->result_array();
		//var_dump($contract[0]['use_contract_code']==null);exit();
		if(!empty($contract) && $contract[0]['use_contract_code']!=null ){
			if(!empty($contract_launch) && $contract_launch[0]['use_contract_code']!=null ){
				$contract[0]['use_contract_code'] = $contract[0]['use_contract_code'].','.$contract_launch[0]['use_contract_code'];
			}
			return $contract;
		}else{
			return $contract_launch;
		}

 	}
 	//获取使用了的纸质合同数据:列表
 	function get_use_contract_list($order_id){
 		$sql = 'SELECT * FROM b_contract_list WHERE order_id='.$order_id;
 		$receipt = $this->db->query($sql)->result_array();
 		return $receipt;
 	}
 	//获取使用了的在线合同数据:列表
 	function get_use_onlinecontract_list($order_id){
 		$sql = 'SELECT * FROM b_contract_launch WHERE order_id='.$order_id;
 		$receipt = $this->db->query($sql)->result_array();
 		return $receipt;
 	}
 	
 	
 	/**
 	 * @method 给订单新增合同，获取订单信息
 	 * @param unknown $order_id
 	 */
 	public function get_order_contract($order_id)
 	{
 		$sql = 'select mo.id,mo.ordersn,l.line_classify from u_member_order as mo left join u_line as l on l.id=mo.productautoid where mo.id='.$order_id;
 		return $this ->db ->query($sql) ->row_array();
 	}
 	
 	//获取合同数据
 	function get_contract_data($contract_sn,$type){
		$sql = 'SELECT 
						il.id,il.confirm_status,c.contract_name,cu.id AS cu_id  
				FROM  
						b_contract_list AS il 
						INNER JOIN b_contract AS c ON c.id=il.contract_id 
						INNER JOIN b_contract_use AS cu ON cu.id=il.use_id 
				WHERE 
						cu.depart_list=\''.$this->session->userdata('parent_depart_id').',\' AND il.contract_code=\''.$contract_sn.'\'';
		if($type==1){
			$sql = $sql.' AND c.contract_name=\'出境合同\'';
		}else{
			$sql = $sql.' AND c.contract_name=\'国内合同\'';
		}
		//b_contract_apply, b_contract_launch的status 2
		
		$contract = $this->db->query($sql)->result_array();
		if(empty($contract)){
			$sql = 'SELECT cl.id,cap.id AS cap_id,cl.confirm_status  FROM   b_contract_apply AS cap  INNER JOIN b_contract_launch AS cl ON cl.apply_id=cap.id  WHERE  cl.contract_code=\''.$contract_sn.'\' AND cl.expert_id='.$this->session->userdata('expert_id').' AND cl.status=2 AND  cl.confirm_status=0';
			if($type==1){
				$sql = $sql.' AND cl.type=1';
			}else{
				$sql = $sql.' AND cl.type=2';
			}
			$contract = $this->db->query($sql)->result_array();
			if(!empty($contract)){
				$contract[0]['contract_launch'] = true;
			}
		}
		
		return $contract;
 	}

 	//获取发票数据
 	function get_invoice_data($invoice_sn){
		$sql = 'SELECT 
						il.id,il.confirm_status,cu.id AS cu_id  
				FROM  
						b_invoice_list AS il 
						INNER JOIN b_invoice AS c ON c.id=il.invoice_id 
						INNER JOIN b_invoice_use AS cu ON cu.id=il.use_id 
				WHERE 
						cu.depart_list=\''.$this->session->userdata('parent_depart_id').',\' AND il.invoice_code=\''.$invoice_sn.'\'';
		$invoice = $this->db->query($sql)->result_array();
		return $invoice;
 	}

 	//获取收据数据
 	function get_receipt_data($receipt_sn){
		$sql = 'SELECT 
						il.id,il.confirm_status,cu.id AS cu_id  
				FROM  
						b_receipt_list AS il 
						INNER JOIN b_receipt AS c ON c.id=il.receipt_id 
						INNER JOIN b_receipt_use AS cu ON cu.id=il.use_id
				WHERE 
						cu.depart_list=\''.$this->session->userdata('parent_depart_id').',\' AND il.receipt_code=\''.$receipt_sn.'\'';
		$receipt = $this->db->query($sql)->result_array();
		return $receipt;
 	}

 	//获取一条扣款记录
	function get_order_debit($order_id){
		$sql='SELECT od.* FROM u_order_debit AS od WHERE od.order_id='.$order_id.' AND od.status=0';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}

	//获取一条扣款记录
	function get_one_debit($order_id,$type){
		$sql='SELECT od.* FROM u_order_debit AS od WHERE od.order_id='.$order_id.' AND od.type='.$type;
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result;
	}

	//获取一条扣款记录
	function get_item_apply($order_id){
		$sql='SELECT * FROM u_item_apply WHERE order_id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result;
	}

 	//应收账单
 	function write_ys($order_id,$ys_data=array()){
 		$order_info = $this->get_one_order($order_id);
 		$ys_info = array(
				'order_id'=>$order_info['id'],
				'expert_id'=>$order_info['expert_id'],
				'user_name'=>$this->session->userdata('real_name'),
				'addtime'=>date('Y-m-d H:i:s'),
				'depart_id'=>$order_info['depart_id']
			);
 		$ys_info =  array_merge($ys_info, $ys_data);
 		$status = $this->db->insert('u_order_bill_ys',$ys_info);
		return $this->db->insert_id();
 	}

 	//应付账单
 	function write_yf($order_id,$yf_data=array()){
 		$order_info = $this->get_one_order($order_id);
 		$yf_info = array(
					'order_id'=>$order_info['id'],
					'expert_id'=>$order_info['expert_id'],
					'depart_id'=>$order_info['depart_id'],
					'user_id'=>$this->session->userdata("expert_id"),
					'user_name'=>$this->session->userdata("real_name"),
					'addtime'=>date('Y-m-d H:i:s')
			);
 		$yf_info =  array_merge($yf_info, $yf_data);
 		$status = $this->db->insert('u_order_bill_yf',$yf_info);
		return $this->db->insert_id();
 	}

 	//应付账单
 	function write_receive($order_id,$receive_data=array()){
 		$order_info = $this->get_one_order($order_id);
 		$item_apply = $this->get_item_apply($order_id);
 		$receive_info = array(
				'order_id'=>$order_info['id'],
				'order_sn'=>$order_info['ordersn'],
				'expert_id'=>$order_info['expert_id'],
				'depart_id'=>$order_info['depart_id'],
				'union_id'=>$this->session->userdata('union_id'),
				'addtime'=>date('Y-m-d H:i:s'),
		);
 		$receive_info =  array_merge($receive_info, $receive_data);
 		$this->db->insert('u_order_receivable',$receive_info);
		$receive_id = $this->db->insert_id();
		$total_receive = $this->get_sum_receive(array('order_id='=>$order_id));
		$insert_item_apply = array(
				'expert_id' => $order_info['expert_id'],
				'addtime' => date('Y-m-d H:i:s'),
				'union_id' => $this->session->userdata('union_id'),
				'depart_id' => $order_info['depart_id'],
				'order_id' => $order_id,
				'status' => 0,
				'amount' =>$total_receive['total_receive_amount']
				);
		if(empty($item_apply)){
			$this->db->insert('u_item_apply',$insert_item_apply);
			$apply_item_id = $this->db->insert_id();
		}else{
			$this->db->update('u_item_apply',$insert_item_apply,array('order_id'=>$order_id));
			$apply_item_id = $item_apply['id'];
		}
		$item_receivable = array(
			'receivable_id'=>$receive_id,
			'item_id'=>$apply_item_id
			);
		$this->db->insert('u_item_receivable',$item_receivable);
		return $receive_id;
 	}

 	//佣金账单
 	function write_yj($order_id,$yj_data=array()){
 		$order_info = $this->get_one_order($order_id);
 		$manage = $this->get_manage();
 		$insert_yj_log = array(
			'manager_id'=>$manage['id'],
			'expert_id'=>$order_info['expert_id'],
			'user_id'=>$this->session->userdata('expert_id'),
			'user_name'=>$this->session->userdata('real_name'),
			'union_id'=>$this->session->userdata('union_id'),
			'order_id'=>$order_id,
			'addtime'=>date('Y-m-d H:i:s')
			);
 		$insert_yj_log =  array_merge($insert_yj_log, $yj_data);
 		$this->db->insert('u_order_bill_yj',$insert_yj_log);
		return $this->db->insert_id();
 	}
 	//佣金账单
 	function write_wj($order_id,$wj_data=array()){
 		$order_info = $this->get_one_order($order_id);
 		$manage = $this->get_manage();
 		$insert_wj_log = array(
 			'order_id'=>$order_id,
 			'user_type'=>1,
			'user_id'=>$this->session->userdata('expert_id'),
			'user_name'=>$this->session->userdata('real_name'),
			'addtime'=>date('Y-m-d H:i:s')
			);
 		$insert_yj_log =  array_merge($insert_wj_log, $wj_data);
 		$this->db->insert('u_order_bill_wj',$insert_wj_log);
		return $this->db->insert_id();
 	}

 	//信用额度明细日志
 	function write_limit_log($order_id,$limit_data=array()){
		$order_info = $this->get_one_order($order_id);
	 	$manage = $this->get_manage();
	 	$depart_limit = $this->get_depart_limit($order_info['depart_id']);
		$insert_limit_log = array(
				'depart_id'=>$order_info['depart_id'],
				'expert_id'=>$order_info['expert_id'],
				'manager_id'=>$manage['id'],
				'order_id'=>$order_info['id'],
				'order_sn'=>$order_info['ordersn'],
				'order_price'=>$order_info['total_price'],//$order_data['total_price'],
				'union_id'=>$this->session->userdata('union_id'),
				'cash_limit'=>$depart_limit['cash_limit'],
				'credit_limit'=>$depart_limit['credit_limit'],
				'addtime'=>date('Y-m-d H:i:s')
				);
		$insert_limit_log = array_merge($insert_limit_log, $limit_data);
		$status = $this->db->insert('b_limit_log',$insert_limit_log);
		return $this->db->insert_id();
	}

	public function write_debit($order_id ,$type ,$amount ,$remark=''){
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

	public function update_debit($order_id ,$type ,$amount ,$remark=''){
		$debitArr = array(
				'order_id' =>$order_id,
				'type' =>$type,
				'real_amount' =>$amount,
				'addtime' =>date('Y-m-d H:i:s'),
				'status' =>0,
				'remark' =>$remark
		);
		$this ->db ->update('u_order_debit' ,$debitArr,array('order_id'=>$order_id,'type'=>$type));
	}

	//管家信用申请表
	public function write_limit_apply($order_info,$money,$apply_code){
		$manage = $this->get_manage();
		$limit_apply_log = array(
					'depart_id' =>$order_info['depart_id'],
					'depart_name' =>$order_info['depart_name'],
					'expert_id' =>$order_info['expert_id'],
					'manager_id' =>$manage['id'],
					'manager_name' =>$manage['realname'],
					'expert_name' =>$order_info['expert_name'],
					'credit_limit' =>$money,
					'return_time' =>date('Y-m-d' ,strtotime($order_info['usedate']) - $order_info['before_day']*24*3600),
					'addtime' =>date('Y-m-d H:i:s'),
					'modtime' =>date('Y-m-d H:i:s'),
					'm_addtime' =>date('Y-m-d H:i:s'),
					'supplier_id' =>$order_info['supplier_id'],
					'remark' =>'押金订单重新提交，默认申请并通过',
					'status' =>3,
					'order_id'=>$order_info['id'],
					'code' =>$apply_code
			);
		$this ->db ->insert('b_limit_apply' ,$limit_apply_log);
		$limit_arr = array(
			'credit_limit' =>$money,
			'return_time' =>$limit_apply_log['return_time'],
			'apply_id' => $this->db->insert_id(),
			'addtime' =>$limit_apply_log['addtime']
			);
		return $limit_arr;
	}

	//管家信用申请使用表
	public function write_expert_apply($order_info,$limit_arr){
		$manage = $this->get_manage();
		//写入额度使用记录表
		$dataArr = array(
				'depart_id' =>$order_info['depart_id'],
				'depart_name' =>$order_info['depart_name'],
				'expert_id' =>$order_info['expert_id'],
				'expert_name' =>$order_info['expert_name'],
				'apply_id' =>$limit_arr['apply_id'],
				'order_id' =>$order_info['id'],
				'apply_amount' =>$limit_arr['credit_limit'],
				'real_amount' =>$limit_arr['credit_limit'],
				'addtime' =>$limit_arr['addtime'],
				'status' =>1,
				'return_time' =>$limit_arr['return_time']
		);
		$this ->db ->insert('b_expert_limit_apply' ,$dataArr);
	}



	//(减去)扣除额度
	function del_limit($order_id,$pass_depart_id,$ys_amount,$limit_log=array()){
		//订单应收价改高开始扣除信用额度
		//减去相对应的信用额度和现金额度
		$final_res = $this->get_depart_limit($pass_depart_id);
		if($final_res['cash_limit']>=$ys_amount){
			//账户现金额度足够扣除的时候直接扣除
			$this->del_cash($ys_amount,$pass_depart_id);
		}else{
			//账户现金额度不够就加上营业部信用额度
			$this->del_credit($ys_amount,$pass_depart_id,$final_res['cash_limit']);
		}
		//流水账记录
		$insert_limit_log = array(
			'cut_money'=>-$ys_amount,
			'type'=>'改高应收扣额度',
			'remark'=>'b2：改高应收扣额度'
			);
		if(!empty($limit_log)){
			$insert_limit_log = array_replace($insert_limit_log, $limit_log);
		}
		$this->write_limit_log($order_id,$insert_limit_log);
	}

	//扣除现金余额
	function del_cash($cut_money,$depart_id){
		$sql = 'UPDATE b_depart SET cash_limit=cash_limit-'.$cut_money.' WHERE id='.$depart_id;
		$status  =$this->db->query($sql);
		return $status;
	}

	//扣完营业部现金额度,扣除营业部信用额度
	function del_credit($cut_money,$depart_id,$depart_cash_limit){
		$diff_credit_limit = $cut_money - $depart_cash_limit;
		$sql = 'UPDATE b_depart SET cash_limit=0,credit_limit=credit_limit-'.$diff_credit_limit.' WHERE id='.$depart_id;
		$this->db->query($sql);
	}

	//退还营业部现金额度
	function return_cash($refund_money,$depart_id){
		$sql = 'UPDATE b_depart SET cash_limit=cash_limit+'.$refund_money.' WHERE id='.$depart_id;
 		$this->db->query($sql);
 		$sql2="select cash_limit from b_depart where id=".$depart_id;
 		$row=$this->db->query($sql2)->row_array();
 		return $row['cash_limit'];
	}

	//退还营业部信用额度
	function return_credit($refund_money,$depart_id){
		$sql = 'UPDATE b_depart SET credit_limit=credit_limit+'.$refund_money.' WHERE id='.$depart_id;
 		$this->db->query($sql);
	}

	/*
	 * 返还额度
	 * $ope_type: 1是改应收、2是退团
	 * */
	function return_limit($order_id,$pass_depart_id,$ys_amount,$ope_type,$ys_id)
	{
		//订单应收金额改低的时候,返还信用额度
		//恢复额度(首先是信用额度, 营业部信用额度,最后是现金额度的顺序开始还)
		$refund_type = array();
		//获取信用额度使用记录
		$debit_info = $this->get_order_debit($order_id);
		if(!empty($debit_info))
		{
				foreach ($debit_info as $key => $val) {
					$refund_type[$val['type']]=$val;
				}
				//账户现金额度使用记录
				$crash_limit = $refund_type[1]['real_amount']-$refund_type[1]['repayment'];
				//营业部信用额度使用记录
				if(isset($refund_type[2]) && !empty($refund_type[2])){
					$credit_limit = $refund_type[2]['real_amount']-$refund_type[2]['repayment'];
				}else{
					 $credit_limit = 0;
				}
				//临时申请的单团额度使用记录
				if(isset($refund_type[3]) && !empty($refund_type[3])){
					$sx_limit  = $refund_type[3]['real_amount']-$refund_type[3]['repayment'];
				}else{
					$sx_limit  = 0;
				}
		}else{
				//防止出现查询为空的时候的报错,给个默认值(一般不会出现这种)
				$sx_limit = 0;
				$credit_limit = 0;
				$crash_limit = 0;
		}

		//退款流水记录
		$insert_limit_log = array(
						//'refund_monry'=>$ys_amount,
						//'type'=>'退订退款',
						'addtime'=>date('Y-m-d H:i:s',strtotime("-2 second")),
						//'remark'=>'b2:经理通过退订退款申请'
				);
		if($ope_type=="1"){
				$log_text= "改低应收";
		}else{
			    $log_text= "退订退款";
		}
		
			//修改应收净变化值的绝对值
			 $ys_amount = abs($ys_amount);
			 //修改的净变化值只够退还临时单团额度
			 if($ys_amount<=$sx_limit){
			 	$debit_sql = 'UPDATE u_order_debit SET repayment=repayment+'.$ys_amount.' WHERE order_id='.$order_id.' AND type=3';
			 	$this->db->query($debit_sql);
			 	$sql = 'UPDATE b_expert_limit_apply SET return_amount=return_amount+'.$ys_amount.' WHERE order_id='.$order_id;
			 	$this->db->query($sql);
			 	if($ys_amount==$sx_limit){
			 		$sql = 'UPDATE b_expert_limit_apply SET status=2 WHERE order_id='.$order_id;
			 		$this->db->query($sql);
			 		$sql2 = 'UPDATE b_limit_apply SET status=4 WHERE order_id='.$order_id.'  AND status=3';
			 		$this->db->query($sql2);
			 	}
			 	$insert_limit_log['sx_limit'] = -$ys_amount;
			 	$insert_limit_log['type'] = $log_text."，自动还款(管家信用)";
			 	$insert_limit_log['remark'] = "b2:".$log_text."，自动还款(管家信用)";
			 	$this->write_limit_log($order_id,$insert_limit_log);
			 }else{
			 	//修改的净变化值可以足够还清临时信用额度和营业部信用额度,换完这两个之后还有剩下的就默认还款到现金额度
			 	$ys_diff = $ys_amount-($sx_limit +  $credit_limit );
			 
			 	if($ys_diff>=0){
			 		
			 		$debit_sql1 = 'UPDATE u_order_debit SET repayment=real_amount,status=2 WHERE order_id='.$order_id.' AND type=3';
			 		$this->db->query($debit_sql1);
			 		$debit_sql2 = 'UPDATE u_order_debit SET repayment=real_amount,status=2 WHERE order_id='.$order_id.' AND type=2';
			 		$this->db->query($debit_sql2);
			 		$debit_sql3 = 'UPDATE u_order_debit SET repayment=repayment+'.$ys_diff.' WHERE order_id='.$order_id.' AND type=1';
			 		$this->db->query($debit_sql3);
			 		$debit_res = $this->get_one_debit($order_id,1);
			 		if($debit_res['repayment']>=$debit_res['real_amount']){
			 			$debit_status_sql = 'UPDATE u_order_debit SET status=2 WHERE order_id='.$order_id.' AND type=1';
			 			$this->db->query($debit_status_sql);
			 		}
			 		$sql = 'UPDATE b_expert_limit_apply SET status=2,return_amount=return_amount+'.$sx_limit.' WHERE order_id='.$order_id;
			 		$this->db->query($sql);
			 		$sql2 = 'UPDATE b_limit_apply SET status=4 WHERE order_id='.$order_id.'  AND status=3';
			 		$this->db->query($sql2);

			 		$insert_limit_log['sx_limit'] = -$sx_limit;
			 		$insert_limit_log['type'] = $log_text."，自动还款(管家信用)";
			 		$insert_limit_log['remark'] = "b2:".$log_text."，自动还款(管家信用)";
			 		if($sx_limit!=0){
			 			$this->write_limit_log($order_id,$insert_limit_log);
			 		}


			 		//还部分信用额度
			 		$this->return_credit($credit_limit,$pass_depart_id);
			 		$insert_limit_log['credit_limit'] = $credit_limit;
			 		$insert_limit_log['type'] = $log_text.", 返还营业部信用额度";
			 		$insert_limit_log['remark'] = "b2:".$log_text.", 返还营业部信用额度";
			 		if($credit_limit!=0){
			 			$this->write_limit_log($order_id,$insert_limit_log);
			 		}
			 		
			 		//剩余的还到现金额度(还要考虑debit表的real_amount-repayment的值)
			 		//if($ys_diff>$crash_limit) //如果剩下的金额比要还的金额大，则只需还清要还的金额，否则将剩下的金额全部拿去还
			 			//$ys_diff=$crash_limit;
			 		$cash_limit=$this->return_cash($ys_diff,$pass_depart_id);
			 		//更改u_order_refund表的cash_refund
			 		$this->db->query("update u_order_refund set cash_refund={$ys_diff} where ys_id={$ys_id}");
			 		//$insert_limit_log['type'] = "改低应收价格, 返还申临时额度";
			 		$insert_limit_log['cash_limit'] =$cash_limit;
			 		$insert_limit_log['receivable_money'] =$ys_diff;
			 		$insert_limit_log['type'] = $log_text.", 返还营业部现金额度";
			 		$insert_limit_log['remark'] = "b2:".$log_text.", 返还营业部现金额度";
			 		if($ys_diff!=0){
			 			$this->write_limit_log($order_id,$insert_limit_log);
			 		}
			 	}else{
			 		//修改的净变化值可以只够换完临时申请的单团额度和部分营业部信用额度
			 		$debit_sql1 = 'UPDATE u_order_debit SET repayment=real_amount,status=2 WHERE order_id='.$order_id.' AND type=3';
			 		$this->db->query($debit_sql1);
			 		$debit_sql2 = 'UPDATE u_order_debit SET repayment=repayment+'.($ys_amount-$sx_limit).' WHERE order_id='.$order_id.' AND type=2';
			 		$this->db->query($debit_sql2);
			 		$debit_res = $this->get_one_debit($order_id,2);
			 		if($debit_res['repayment']>=$debit_res['real_amount']){
			 			$debit_status_sql = 'UPDATE u_order_debit SET status=2 WHERE order_id='.$order_id.' AND type=2';
			 			$this->db->query($debit_status_sql);
			 		}
			 		$sql = 'UPDATE b_expert_limit_apply SET return_amount=return_amount+'.$sx_limit.',status=2 WHERE order_id='.$order_id;
			 		$this->db->query($sql);
			 		$sql2 = 'UPDATE b_limit_apply SET status=4 WHERE order_id='.$order_id.' AND status=3';
			 		$this->db->query($sql2);

			 		$insert_limit_log['sx_limit'] =-$sx_limit;
			 		$insert_limit_log['type'] = $log_text."，自动还款(管家信用)";
			 		$insert_limit_log['remark'] = "b2:".$log_text."，自动还款(管家信用)";
			 		if($sx_limit!=0){
			 			$this->write_limit_log($order_id,$insert_limit_log);
			 		}

			 		$refund_credit_amount = $ys_amount-$sx_limit;
			 		$this->return_credit($refund_credit_amount,$pass_depart_id);
			 		$insert_limit_log['credit_limit'] =$refund_credit_amount;
			 		$insert_limit_log['receivable_money']=abs($ys_amount);
			 		$insert_limit_log['type'] = $log_text.", 返还营业部信用额度";
			 		$insert_limit_log['remark'] = "b2:".$log_text.", 返还营业部信用额度";
			 		if($refund_credit_amount!=0){
			 			$this->write_limit_log($order_id,$insert_limit_log);
			 		}
			}
		}  //end
 
	}
    /*
     * 只去还管家信用额度
     * */
	function return_only_sx($config)
	{
		if(!empty($config['order_id'])&&!empty($config['depart_id'])&&!empty($config['ys_amount']))
		{
			//1、还 u_order_debit表
			$sx_debit=$this->get_one_debit($config['order_id'],'3');
			if(!empty($sx_debit))
			{
				$no_back=$sx_debit['real_amount']-$sx_debit['repayment'];
				if(abs($config['ys_amount'])>$no_back)
					$config['ys_amount']=-$no_back;
				
				$this->reback_debit($config['order_id'], '3', abs($config['ys_amount']),'退团还信用额度');
			}
			
			//2、还b_expert_limit_apply表
			$expert_limit=$this->get_e_limit($config['order_id']);
			
			if(!empty($expert_limit)&&$expert_limit['apply_amount']>0)
			{
				   $no_back_limit=$expert_limit['apply_amount']-$expert_limit['return_amount'];
				   if(abs($config['ys_amount'])>$no_back_limit)
					  $config['ys_amount']=$no_back_limit;
				   $this->db->query("update b_expert_limit_apply set return_amount=return_amount+".abs($config['ys_amount']).",return_time='".date("Y-m-d H:i:s")."' where order_id=".$config['order_id']);
			
			}
		}
		
		$limit_log=array();
		if(!empty($config['limit_log'])) $limit_log=$config['limit_log'];
		$log_start=empty($limit_log['log_start'])==true?'':$limit_log['log_start'];
		
		$limit_log = array(
				'sx_limit'=>$config['ys_amount'],
				'type'=>$log_start.'自动还款(管家信用)',
				'remark'=>'经理通过自动还款申请(在退团使用公式之后写入的记录)'
		);
		if($config['ys_amount']!=0)
		$this->write_limit_log($config['order_id'],$limit_log);
	}

	//返还额度
	function return_sx_limit($order_id,$pass_depart_id,$ys_amount,$limit_log=array()){
		//订单应收金额改低的时候,返还信用额度
		//恢复额度(首先是信用额度, 营业部信用额度,最后是现金额度的顺序开始还)
		$log_start=empty($limit_log['log_start'])==true?'':$limit_log['log_start'];
		if(abs($ys_amount)==0){
			return true;
		}
		$refund_type = array();
		//获取信用额度使用记录
		$debit_info = $this->get_order_debit($order_id);
		if(!empty($debit_info)){
				foreach ($debit_info as $key => $val) {
					$refund_type[$val['type']]=$val;
				}
				//账户现金额度使用记录
				$crash_limit = $refund_type[1]['real_amount']-$refund_type[1]['repayment'];
				//营业部信用额度使用记录
				if(isset($refund_type[2]) && !empty($refund_type[2])){
					$credit_limit = $refund_type[2]['real_amount']-$refund_type[2]['repayment'];
				}else{
					 $credit_limit = 0;
				}
				//临时申请的单团额度使用记录
				if(isset($refund_type[3]) && !empty($refund_type[3])){
					$sx_limit  = $refund_type[3]['real_amount']-$refund_type[3]['repayment'];
				}else{
					$sx_limit  = 0;
				}
		}else{
				//防止出现查询为空的时候的报错,给个默认值(一般不会出现这种)
				$sx_limit = 0;
				$credit_limit = 0;
				$crash_limit = 0;
		}
			//修改应收净变化值的绝对值
			 $ys_amount = abs($ys_amount);
			 //修改的净变化值只够退还临时单团额度
			 if($ys_amount<=$sx_limit){
			 	$debit_sql = 'UPDATE u_order_debit SET repayment=repayment+'.$ys_amount.' WHERE order_id='.$order_id.' AND type=3';
			 	$this->db->query($debit_sql);
			 	$sql = 'UPDATE b_expert_limit_apply SET return_amount=return_amount+'.$ys_amount.' WHERE order_id='.$order_id;
			 	$this->db->query($sql);
			 	if($ys_amount==$sx_limit){
			 		$sql = 'UPDATE b_expert_limit_apply SET status=2 WHERE order_id='.$order_id;
			 		$this->db->query($sql);
			 		$sql2 = 'UPDATE b_limit_apply SET status=4 WHERE order_id='.$order_id.'  AND status=3';
			 		$this->db->query($sql2);
			 	}
			 }else{
			 	//修改的净变化值可以足够还清临时信用额度和营业部信用额度,换完这两个之后还有剩下的就默认还款到现金额度
			 	$ys_diff = $ys_amount-($sx_limit +  $credit_limit );
			 	if($ys_diff>=0){
			 		$debit_sql1 = 'UPDATE u_order_debit SET repayment=real_amount,status=2 WHERE order_id='.$order_id.' AND type=3';
			 		$this->db->query($debit_sql1);
			 		$debit_sql2 = 'UPDATE u_order_debit SET repayment=real_amount,status=2 WHERE order_id='.$order_id.' AND type=2';
			 		$this->db->query($debit_sql2);
			 		$debit_sql3 = 'UPDATE u_order_debit SET repayment=repayment+'.$ys_diff.' WHERE order_id='.$order_id.' AND type=1';
			 		$this->db->query($debit_sql3);
			 		$debit_res = $this->get_one_debit($order_id,1);
			 		if($debit_res['repayment']>=$debit_res['real_amount']){
			 			$debit_status_sql = 'UPDATE u_order_debit SET status=2 WHERE order_id='.$order_id.' AND type=1';
			 			$this->db->query($debit_status_sql);
			 		}
			 		$sql = 'UPDATE b_expert_limit_apply SET return_amount=return_amount+'.$sx_limit.' ,status=2 WHERE order_id='.$order_id;
			 		$this->db->query($sql);
			 		$sql2 = 'UPDATE b_limit_apply SET status=4 WHERE order_id='.$order_id.' AND status=3';
			 		$this->db->query($sql2);

			 		//还部分信用额度
			 		//$this->return_credit($credit_limit,$pass_depart_id);
			 		//剩余的还到现金额度
			 		//$this->return_cash($ys_diff,$pass_depart_id);
			 	}else{
			 		//修改的净变化值可以只够换完临时申请的单团额度和部分营业部信用额度
			 		$debit_sql1 = 'UPDATE u_order_debit SET repayment=real_amount,status=2 WHERE order_id='.$order_id.' AND type=3';
			 		$this->db->query($debit_sql1);
			 		$debit_sql2 = 'UPDATE u_order_debit SET repayment=repayment+'.($ys_amount-$sx_limit).' WHERE order_id='.$order_id.' AND type=2';
			 		$this->db->query($debit_sql2);
			 		$debit_res = $this->get_one_debit($order_id,2);
			 		if($debit_res['repayment']>=$debit_res['real_amount']){
			 			$debit_status_sql = 'UPDATE u_order_debit SET status=2 WHERE order_id='.$order_id.' AND type=2';
			 			$this->db->query($debit_status_sql);
			 		}
			 		$sql = 'UPDATE b_expert_limit_apply SET status=2,return_amount=return_amount+'.$sx_limit.' WHERE order_id='.$order_id;
			 		$this->db->query($sql);
			 		$sql2 = 'UPDATE b_limit_apply SET status=4 WHERE order_id='.$order_id.'AND status=3';
			 		$this->db->query($sql2);
			 		$refund_credit_amount = $ys_amount-$sx_limit;
			 		//$this->return_credit($refund_credit_amount,$pass_depart_id);
			}
		}


			$limit_sql = 'SELECT id FROM  b_expert_limit_apply  WHERE order_id='.$order_id.' AND status=1';
			$res=$this->db->query($limit_sql)->result_array();
			if(!empty($res)){
				//管家信用还款记录
				$insert_limit_log2 = array(
						'sx_limit'=>-$ys_amount,
						'type'=>$log_start.'自动还款(管家信用)',
						'remark'=>'经理通过自动还款申请(在退团使用公式之后写入的记录)'
				);
				$this->write_limit_log($order_id,$insert_limit_log2);
			}
	}


	//返还利润
	function return_profit($order_id){
		$order_info = $this->get_one_order($order_id);
		$profit = $order_info['agent_fee'] - $order_info['depart_balance'];
		//将现金充值进入账户
		$this->return_cash($profit,$order_info['depart_id']);
		$update_order = 'UPDATE u_member_order SET depart_balance=depart_balance+'.$profit.' WHERE id='.$order_id;
		$this->db->query($update_order);
	}

	/*
	 * 更新u_order_refund表的cash_refund
	 * */
	public function update_cash_refund($ys_id,$cash_refund)
	{
		if(!empty($ys_id))
		{
			$sql="update u_order_refund set cash_refund={$cash_refund} where ys_id={$ys_id}";
			$return =$this->db->query($sql);
			return $return;
		}
		else
		{
			return 0;
		}
	}
	/*
	 * 获得某个订单：申请通过的金额
	 * */
	public function get_tongguuo_limit($order_id)
	{
		$sql="select sum(apply_amount) as amount from b_expert_limit_apply where order_id={$order_id}";
		$row=$this->db->query($sql)->row_array();
		$amount=0;
		if(!empty($row)&&!empty($row['amount']))
		{
			$amount=$row['amount'];
		}
		return $amount;
	}
	/*
	 * 返还：repayment
	 * */
	public function reback_debit($order_id ,$type ,$amount ,$remark='退团还额度'){
		$modtime=date('Y-m-d H:i:s');
		$sql="update u_order_debit set repayment=repayment+".$amount.",modtime='".$modtime."',remark='".$remark."' where order_id=".$order_id." and type=".$type."";
		$this->db->query($sql);
	}
	/*
	 * 写订单操作日志
	 * */
	public function write_order_log($order_id ,$content=''){
		$order_row=$this->db->query("select id,status from u_member_order where id=".$order_id)->row_array();
		$log=array(
			'addtime'=>date("Y-m-d H:i:s"),
			'op_type'=>'1',
			'order_id'=>$order_id
		);
		$expert_id=$this->session->userdata('expert_id');
		$expert_name=$this->session->userdata('real_name');
		$is_manage=$this->session->userdata('is_manage');
		$is_manage_desc=$is_manage==1?'经理':'非经理';
		if(!empty($order_row))
		{
			$log['order_status']=$order_row['status'];
			$log['userid']=$expert_id; //操作人
			$log['content']=$expert_name.'('.$is_manage_desc.')'.$content;
		}
	    
		$insert_id=$this->db->insert("u_member_order_log",$log);
		return $this->db->insert_id();
	}

}