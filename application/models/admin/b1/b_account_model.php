<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:55:53
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class B_account_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}
	public function get_exchange($id){
			$this->db->select('*');
			$this->db->from('u_month_account');
			$this->db->where(array('status'=>$id));
			$query = $this->db->get();
			return $query->result_array();
	}
	public function get_where($id){
		$query = $this->db->get_where('u_month_account', array('id' => $id));
		return $query->row_array();
	}
	/*结算分页*/
	public function get_exchange_data($param,$page){
		//启用session
		$this->load->library('session');  	
   		$arr=$this->session->userdata ( 'loginSupplier' );
   		$login_id=$arr['id'];
   			
		$query_sql='';
		$query_sql.= 'select mao.month_account_id,ma.supplier_id,ma.union_id,ma.union_name,ma.employee_id,ma.e_reply,ma.addtime,ma.status,ma.amount,ma.real_amount,';
		$query_sql.='ma.remark,ma.invoice_entity,ma.open_man,ma.bank,ma.bankname,ma.brank,ma.amount as amount_money,ma.admin_name,em.realname ';
		$query_sql.=' FROM 	 b_month_account_order AS mao ';
		$query_sql.='INNER JOIN u_member_order AS mo ON mao.order_id = mo.id ';
		$query_sql.=' INNER JOIN b_month_account AS ma ON mao.month_account_id = ma.id  ';	
		$query_sql.=' LEFT JOIN b_employee as em on ma.employee_id=em.id ';
		$query_sql.='WHERE  mo.supplier_id='.$login_id;
	 	if($param!=null){
	 		if(null!=array_key_exists('status', $param)){
	 			if($param['status']==0){  //申请中
					$query_sql.=' AND (ma.status=? or ma.status=1) ';
					$param['status'] =trim($param['status']);
	 			}else if ($param['status']==2) {
	 				$query_sql.=' AND (ma.status=? or ma.status=4) ';
					$param['status'] =trim($param['status']);
	 			}else{
	 				$query_sql.=' AND ma.status=?  ';
					$param['status'] =trim($param['status']);
	 			}	
			}
			if(null!=array_key_exists('ordersn', $param)){
				$query_sql.=' AND mao.month_account_id = ? ';
				$param['ordersn'] =trim($param['ordersn']);
			}
			if(null!=array_key_exists('addtime', $param)){
				$query_sql.=' AND ma.addtime BETWEEN ? AND ?';
			}	
		} 
		$query_sql.=' GROUP BY mao.month_account_id ';
		$query_sql.=' ORDER BY mao.id  DESC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	/*明细*/
	public function get_detail($id){
		$query_sql='';
		$query_sql.='select mo.id,mo.order_price,mo.agent_fee,mo.platform_fee as agent_rate,mo.ordersn,m.truename,mo.productname,(mo.childnum+mo.dingnum+mo.oldnum) AS "joinnum",mo.total_price,mo.usedate,mo.addtime, ';
		$query_sql.='(mo.platform_fee) as a_rate,(mo.total_price-mo.platform_fee-mo.agent_fee) as real_free,mo.status, ';
		$query_sql.='mo.supplier_cost,mo.balance_money ';
		$query_sql.='FROM u_member_order AS mo ';
		$query_sql.='LEFT JOIN  b_month_account_order AS ma  ON ma.order_id=mo.id 	';
		$query_sql.='LEFT JOIN u_member AS m ON mo.memberid=m.mid 	';
		$query_sql.='WHERE ma.month_account_id ='.$id;
		$query=$this->db->query($query_sql)->result_array();
		return $query;
	}
	/*供应商的订单*/
	function get_supplier_orde($param,$page){
		
		$query_sql=' select mo.id as order_id,mo.total_price,mo.platform_fee as agent_rate,mo.agent_fee,mo.usedate as usedate,l.id as line_id,';
		$query_sql.=' mo.ordersn as ordersn,(mo.childnum+mo.dingnum+mo.childnobednum+mo.oldnum) as people_num, ';
		$query_sql.='mo.productname as productname,mo.supplier_cost,mo.balance_money,';
		$query_sql.=' mo.expert_id,mo.agent_fee as amount,e.realname as "expert_name",mo.status,mo.ispay,';
		$query_sql.='mo.addtime AS addtime,(mo.platform_fee) as a_rate ';
		$query_sql.=' from u_member_order as mo left join u_expert as e on mo.expert_id = e.id left join u_line as l on l.id=mo.productautoid';
		$query_sql.=' where mo.user_type = 1 ';
		$query_sql.=' and mo.id not in (select order_id from b_month_account_order as a  left join b_month_account as m on ';
		$query_sql.=' a.month_account_id = m.id  where (m.status =0 or m.status =1 or m.status =3))';
		if($param!=null){

		 	if(null!=array_key_exists('supplier_id', $param)){
				 $query_sql.=' AND mo.supplier_id = ? ';
				 $param['supplier_id'] = $param['supplier_id'];
			 } 
			 if(null!=array_key_exists('ordersn', $param)){
			 	$query_sql.=' AND mo.ordersn = ? ';
			 	$param['ordersn'] = trim($param['ordersn']);
			 } 
			 if(null!=array_key_exists('line_id', $param)){
			 	$query_sql.=' AND l.line_id = ? ';
			 	$param['line_id'] = trim($param['line_id']);
			 } 
			 if(null!=array_key_exists('userdate', $param)){
			 	$query_sql.=' AND mo.usedate = ? ';
			 	$param['userdate'] = trim($param['userdate']);
			 } 
		}

		return $this->queryPageJson( $query_sql , $param ,$page);	
	}
	/**
	 * 获取供应商的未结算订单数据
	 */
	function supplier_unsettled_order($whereArr,$page = 1, $num = 10,$supplier_id,$order_id=array()){
		$this->db->select("
		 		mo.id AS order_id,
		 		mo.ordersn as ordersn,
				me.truename AS truename,
				mo.productname AS productname,
				(mo.childnum+mo.dingnum+mo.childnobednum+mo.oldnum) AS people_num,
				mo.usedate AS usedate,
				mo.status,mo.expert_id,
				mo.total_price AS order_amount,
				mo.agent_fee AS amount,
				e.realname AS 'expert_name',
				mo.addtime AS addtime,
				mo.total_price,
				mo.supplier_cost,
				mo.balance_money,
				mo.platform_fee as agent_rate,
				mo.agent_fee,
				mo.status,
				mo.ispay,
				(mo.total_price-(mo.platform_fee)-mo.agent_fee) as real_pay,
				 (mo.platform_fee) as a_rate,
				");
		if(!empty($order_id)){
			$this->db->where_in('mo.id',$order_id);
		}
		
	//	$whereArr['mo.status >='] = 5;
		$whereArr['mo.supplier_id'] = $supplier_id;
		$this->db->where($whereArr);
		$this->db->from("u_member_order AS mo");
		$this->db->join('u_member AS me','mo.memberid=me.mid','left');
		$this->db->join('u_expert AS e','mo.expert_id=e.id','left');

	//	$this->db->order_by('mo.addtime','DESC');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		return $result;
	}
	/**
	 * 增加专家结算单
	 */
	function add_supplier_order($supplier_id, $invoice_entity,$beizhu,$union_id, $order_ids,$supplier_bank){
		$this->db->trans_start();	
		
		$union=$this->db->query("select  union_name from b_union where id={$union_id}")->row_array();

		$insert_data['supplier_id']=$supplier_id;
		$insert_data['union_id']=$union_id;
		$insert_data['union_name']=$union['union_name'];
		$insert_data['addtime']=date('Y-m-d H:i:s',time());
		$insert_data['status']=0;
		$insert_data['remark']=$beizhu;
		$insert_data['invoice_entity']=$invoice_entity;
		$insert_data['open_man']=$supplier_bank['open_man'];
		$insert_data['bank']=$supplier_bank['bank'];
		$insert_data['bankname']=$supplier_bank['bankname'];
		$insert_data['brank']=$supplier_bank['brank'];
		$all_amount=0;
		foreach($order_ids as $key=>$val){
			$order=$this->db->query("select  supplier_cost,balance_money from u_member_order where id={$val}")->row_array();
			$amount_money=$order['supplier_cost']-$order['balance_money'];
			$all_amount=$all_amount+$amount_money;
		}
		$insert_data['amount']=$all_amount;//申请的金额

		$this->db->insert('b_month_account ',$insert_data);
		$insert_id = $this->db->insert_id();

		foreach($order_ids as $key=>$val){
			$insert_data_order['month_account_id'] = $insert_id;
			$insert_data_order['order_id'] = $val;
			$this->db->insert('b_month_account_order',$insert_data_order);
			//订单结算状态
			$this->db->where('id', $val)->update('u_member_order', array('balance_status'=>1));;
		}

		//保存银行账号
		$bank_info=$this->db->query("SELECT id from u_supplier_bank where supplier_id={$supplier_id}")->row_array();
		$bank_data['supplier_id']=$supplier_id;
		$bank_data['bank']=$supplier_bank['bank'];
		$bank_data['bankname']=$supplier_bank['bankname'];
		$bank_data['brand']=$supplier_bank['brank']; 
		$bank_data['openman']=$supplier_bank['open_man']; //开户人
		$insert_data['modtime'] = date('Y-m-d H:i:s');

		if(empty($bank_info)){ //不存在插入
			$this->db->insert('u_supplier_bank', $bank_data);
		}else{  //存着就修改
			$status = $this->db->update('u_supplier_bank', $bank_data, array('id' =>$bank_info['id']));	
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}
	/**
	*@method 供应商的开户银行信息
	*/
	function get_supplier_bank($supplier_id){
		$query_sql="SELECT bank,bankname,brand,openman from u_supplier_bank  where supplier_id={$supplier_id}";
		$query=$this->db->query($query_sql)->row_array();
		return $query;
	}
	/**
	*@method 供应商合作的旅行社
	*/
	function get_company_supplier($supplier_id){
		$query_sql="select bcp.union_id,un.union_name from b_company_supplier as bcp left join b_union as un on bcp.union_id=un.id";
		$query_sql.=" where bcp.supplier_id={$supplier_id}";
		$query=$this->db->query($query_sql)->result_array();
		return $query;
	}
}