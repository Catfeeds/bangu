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
Class Account_model extends MY_Model{
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
		$query_sql.= 'SELECT  mao.month_account_id,mo.ordersn,ma.status,ma.startdatetime ,ma.enddatetime ,ma.addtime,CASE	WHEN ma.account_mode = 0 THEN "月结"	END AS "account_mode",  ma.amount, ma.real_amount, ma.beizhu ';
		$query_sql.=' FROM 	u_month_account_order AS mao ';
		$query_sql.='INNER JOIN u_member_order AS mo ON mao.order_id = mo.id ';
		$query_sql.=' INNER JOIN u_month_account AS ma ON mao.month_account_id = ma.id  WHERE mo.user_type=0 AND  mo.supplier_id='.$login_id.' and ma.status=?';	
		//$query_sql.=' INNER JOIN u_month_account AS ma ON mao.month_account_id = ma.id  WHERE  mo.supplier_id=25 and ma.status=?';
		
	 	if($param!=null){
			if(null!=array_key_exists('ordersn', $param)){
				$query_sql.=' AND mao.month_account_id = ? ';
				$param['ordersn'] =trim($param['ordersn']);
			}
			if(null!=array_key_exists('startdatetime', $param)){
				$query_sql.=' AND ma.startdatetime BETWEEN ? AND ?';
				//$param['startdatetime'] = $param['startdatetime'];
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
		$query_sql.='(mo.platform_fee) as a_rate,truncate((mo.total_price-mo.platform_fee-mo.agent_fee),2) as real_free ,mo.status, ';
		$query_sql.='(select sum(amount) from u_refund where status=1 and order_id=mo.id) as total_amount ';
		$query_sql.='FROM u_member_order AS mo ';
		$query_sql.='LEFT JOIN  u_month_account_order AS ma  ON ma.order_id=mo.id 	';
		$query_sql.='LEFT JOIN u_member AS m ON mo.memberid=m.mid 	';
		//$query_sql.='LEFT JOIN u_refund AS fu ON mo.id = fu.order_id	';
		$query_sql.='WHERE ma.month_account_id ='.$id;
		$query=$this->db->query($query_sql)->result_array();
		return $query;
	}
	/*供应商的订单*/
	function get_supplier_orde($param,$page,$type=''){

		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		$query_sql='';
		$query_sql.= 'SELECT mo.id AS order_id,mo.total_price,mo.platform_fee as agent_rate,mo.agent_fee,truncate((mo.total_price-(mo.platform_fee)-mo.agent_fee),2) as real_pay,mo.ordersn AS ordersn,me.truename AS truename,mo.productname AS productname,(mo.childnum+mo.dingnum+mo.childnobednum+mo.oldnum) AS people_num, ';
		$query_sql.=' mo.usedate AS usedate,fu.amount as f_amount,mo.status,mo.ispay,mo.expert_id,mo.total_price AS order_amount,mo.agent_fee AS amount,e.realname AS "expert_name",mo.addtime AS addtime,(mo.platform_fee) as a_rate, ';
		$query_sql.='(select sum(amount) from u_refund where status=1 and order_id=mo.id) as total_amount ';
		$query_sql.=' from u_member_order AS mo';
		$query_sql.=' LEFT JOIN u_member AS me on mo.memberid=me.mid left join u_expert AS e on mo.expert_id=e.id';
		$query_sql.=' LEFT JOIN  u_refund AS fu on mo.id=fu.order_id and fu.status=1';
		$query_sql.=' where mo.user_type=0 and mo.supplier_id='.$login_id ;
		$query_sql.=' and mo.id  not in (SELECT order_id from u_month_account_order as a left JOIN u_month_account as m on a.month_account_id=m.id where m.account_type=2 ) ';
		//and
	
		if($param!=null){

		 	if(null!=array_key_exists('starttime', $param)){
				 $query_sql.=' AND mo.usedate BETWEEN ? AND ?';
				 $param['starttime'] = $param['starttime'];
				 $param['endtime'] = $param['endtime'];
			 } 
			 if(null!=array_key_exists('ordersn', $param)){
			 	$query_sql.=' AND mo.ordersn = ? ';
			 	$param['ordersn'] = trim($param['ordersn']);
			 } 
		}
		if(!empty($type)){
			if($type['status']==1){  //已出团
				$query_sql.='and mo.status >=5 ';
				$type['status'] = $type['status'];
			}
			if($type['status']==2){ //已确认
				$query_sql.='and ( mo.status =4  and mo.ispay =2 )';
				$type['status'] = $type['status'];
			}
			if($type['status']==3){  //已退团
				$query_sql.='and ( fu.amount<mo.total_price)';
				$type['status'] = $type['status'];
			}
			$type['status'] = $type['status'];
		}else{
			$query_sql.='and (mo.status >=5 or ( mo.status =4  and mo.ispay =2 ) or (fu.amount<mo.total_price) )';
		}
		$query_sql.='  AND mo.balance_status=0  GROUP BY mo.id ';
		
		return $this->queryPageJson( $query_sql , $param ,$page);	
	}
	/**
	 * 获取供应商的未结算订单数据
	 */
	function supplier_unsettled_order($whereArr,$page = 1, $num = 10,$supplier_id,$order_id=array()){
		$sql="mo.id AS order_id,mo.ordersn as ordersn,me.truename AS truename,mo.productname AS productname,";
		$sql.="(mo.childnum + mo.dingnum) AS people_num,mo.usedate AS usedate,mo.status,mo.expert_id,mo.total_price AS order_amount,";
		$sql.="mo.agent_fee AS amount,e.realname AS 'expert_name',mo.addtime AS addtime,mo.total_price, mo.platform_fee as agent_rate,";
		$sql.="mo.agent_fee,mo.status,mo.ispay,";
		$sql.="fu.amount as f_amount,(mo.total_price-mo.platform_fee-mo.agent_fee) as real_pay,";
		$sql.='(select sum(amount) from u_refund where status=1 and order_id=mo.id) as total_amount ,';
		$sql.="(mo.platform_fee) as a_rate,";
		$this->db->select($sql);
		if(!empty($order_id)){
			$this->db->where_in('mo.id',$order_id);
		}
		
	//	$whereArr['mo.status >='] = 5;
		$whereArr['mo.supplier_id'] = $supplier_id;
		$this->db->where($whereArr);
		$this->db->where('(mo.status >=5 or ( mo.status =4  and mo.ispay =2 ) or (fu.amount<mo.total_price)) AND mo.balance_status=0');
		$this->db->from("u_member_order AS mo");
		$this->db->join('u_member AS me','mo.memberid=me.mid','left');
		$this->db->join('u_expert AS e','mo.expert_id=e.id','left');
		$this->db->join('u_refund AS fu','mo.id=fu.order_id ','left');

		$this->db->order_by('mo.addtime','DESC');
		$this->db->group_by("mo.id");
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$result=$this->db->get()->result_array();
		foreach ($result as $k=>$v){
			
			$result[$k]['real_pay']=sprintf("%.2f", $v['real_pay']);
		}
		return $result;
	}
	/**
	 * 增加专家结算单
	 */
	function add_supplier_order($supplier_id,$start_time,$end_time,$biezhu,$order_ids,$supplier_bank,$orderType){
		$this->db->trans_start();
		
	    if($orderType==3){ //已退款
	    	$this->db->select(' sum(total_price) as total_price,sum(agent_fee) as total_agent_fee,sum(platform_fee) AS admin_fee');
	    	$this->db->from("u_member_order");
	    	$this->db->where_in('id',$order_ids);
	    	$total_price = $this->db->get()->result_array();
	    	
	    	$this->db->select(' sum(amount) as total_amount');
	    	$this->db->from("u_refund");
	    	$this->db->where_in('order_id',$order_ids);
	    	$this->db->where(array('status'=>1));
	    	$refund_price = $this->db->get()->result_array();
	    	$real_amount = $total_price[0]['total_price'] - $refund_price[0]['total_amount']-$total_price[0]['total_agent_fee']-$total_price[0]['admin_fee'];
	    	$real_amount=sprintf("%.2f", $real_amount);
	    }else{
	    	/*SELECT sum(price) as total_price  FROM u_member_order WHERE id IN (1,2,3,4,5,6);*/
	    	$this->db->select(' sum(total_price) as total_price,sum(total_price-(platform_fee)-agent_fee) as pirce');
	    	$this->db->from("u_member_order");
	    	$this->db->where_in('id',$order_ids);
	    	$total_price = $this->db->get()->result_array();
	    	$real_amount=sprintf("%.2f", $total_price[0]['pirce']);
	    }		
		
		$insert_data['account_type'] = 2;
		$insert_data['userid'] = $supplier_id;
		$insert_data['amount'] =  $total_price[0]['total_price'];
		$insert_data['before_amount'] = 0;
		$insert_data['after_amount'] = 0;
		$insert_data['addtime'] = date('Y-m-d H:i:s');
		//$insert_data['startdatetime'] = $start_time ? $start_time:date('Y-m-d H:i:s');
		$insert_data['startdatetime'] =$start_time ? $start_time:date('Y-m-d H:i:s');
		$insert_data['enddatetime'] = $end_time ? $end_time : date('Y-m-d H:i:s');
		$insert_data['beizhu'] = '未结算';
		$insert_data['real_amount'] = $real_amount;  
		$insert_data['status'] = 0;
		$insert_data['account_mode'] = '月结';
		$insert_data['bank'] =$supplier_bank['bank']; //银行卡号
		$insert_data['bankname'] =$supplier_bank['bankname']; //银行
		$insert_data['brand'] =$supplier_bank['brand']; //银行支行
		$insert_data['openman'] =$supplier_bank['openman']; //开户人
		$this->db->insert('u_month_account',$insert_data);
		$insert_id = $this->db->insert_id();
		foreach($order_ids as $key=>$val){
			$insert_data_order['month_account_id'] = $insert_id;
			$insert_data_order['order_id'] = $val;
			$this->db->insert('u_month_account_order',$insert_data_order);
			//订单结算状态
			$this->db->where('id', $val)->update('u_member_order', array('balance_status'=>1));;
		}
		//保存银行账号
		$bank_info=$this->db->query("SELECT id from u_supplier_bank where supplier_id={$supplier_id}")->row_array();
		$bank_data['supplier_id']=$supplier_id;
		$bank_data['bank']=$supplier_bank['bank'];
		$bank_data['bankname']=$supplier_bank['bankname'];
		$bank_data['brand']=$supplier_bank['brand']; 
		$bank_data['openman']=$supplier_bank['openman']; //开户人
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
}