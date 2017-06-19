<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Apply_order_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	public function get_payable_apply($param, $page) {
		$query_sql = 'select mo.ispay,mo.ordersn,mo.status,(mo.supplier_cost) as supplier_cost,mo.suitid,l.id AS lid,ls.unit,l.linecode,';
		$query_sql .= ' mo.memberid,mo.expert_id,l.linename,mo.id,mo.id as order_id,mo.balance_status,l.line_kind,0 as un_balance,';
		$query_sql .= 'mo.childnum,mo.dingnum,mo.childnobednum,mo.oldnum,mo.balance_money,un.union_name,0 as a_balance,';
		$query_sql .= '(mo.childnum + mo.dingnum + mo.childnobednum + mo.oldnum) as "num",un.id as union_id,';
		$query_sql .= '(mo.total_price + mo.settlement_price) as total_price,mo.item_code as linesn ,sum(sk.money) as all_money,';
		$query_sql .= 'mo.usedate,mo.user_type,mo.addtime,(sum(sk.money)-mo.depart_balance-mo.union_balance) as j_money,';
		$query_sql .= '((mo.supplier_cost)- mo.balance_money) as apply_money,mo.platform_fee,';//-mo.platform_fee
		$query_sql .= '(mo.balance_money/(mo.supplier_cost-mo.platform_fee))*100 as account_money_list, ';
		$query_sql .='(sum(sk.money)-mo.balance_money) as sk_money,((mo.supplier_cost)- mo.balance_money-mo.platform_fee) as a_money, ';
		$query_sql.='(mo.supplier_cost- mo.balance_money-mo.platform_fee) as un_money,e.realname,e.depart_name, ';
		$query_sql .='(sum(sk.money)-mo.balance_money)/((mo.supplier_cost-mo.platform_fee)- mo.balance_money)*100 as Mlist ';
		$query_sql .=' FROM u_member_order AS mo' ;
		$query_sql .=' LEFT JOIN  u_line AS l ON l.id = mo.productautoid';
		$query_sql .= ' LEFT JOIN u_line_suit AS ls ON ls.id = mo.suitid';
	//	$query_sql .= ' LEFT JOIN u_order_bill_yf as billy on billy.order_id=mo.id and billy.status=1 '#billy.id as billy_id,;
		$query_sql .= ' LEFT JOIN b_union AS un ON un.id = mo.platform_id ';
		$query_sql .= ' LEFT JOIN u_order_receivable as sk on mo.id=sk.order_id and sk.status=2';
		$query_sql .= ' LEFT JOIN u_expert as e on e.id=mo.expert_id ';
		$query_sql .= ' WHERE  mo.user_type=1 and ((mo.status>3  and mo.status<9) or mo.status=-4)  ';

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
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND mo.usedate >= ? ';
				$param['starttime'] =trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND mo.usedate <= ? ';
				$param['endtime'] =trim($param['endtime']);
			}
			if (null != array_key_exists ( 'sch_union_name', $param )) {
				$query_sql .= ' AND un.union_name LIKE ? ';
				$param['sch_union_name'] =trim($param['sch_union_name']);
			}
			if (null != array_key_exists ( 'linesn', $param )) {
				$query_sql .= ' AND mo.item_code = ? ';
				$param['linesn'] =trim($param['linesn']);
			}
			if (null != array_key_exists ( 'apply_status', $param )) {
				$query_sql .= ' AND mo.balance_status = ? ';
				$param['apply_status'] =trim($param['apply_status']);
			}
		}

		$query_sql .=' GROUP BY mo.id ORDER BY mo.addtime DESC ';

		$data= $this->queryPageJson ( $query_sql, $param, $page );
        // echo $this->db->last_query(); 
         //判断是否有申请单
		$dataArray=json_decode($data,true);
		if(!empty($dataArray['rows'])){
			foreach ($dataArray['rows'] as $key => $value) {

				//判断是否有申请单
				$mysql="select po.id from u_payable_order AS po  left join u_payable_apply as pap on po.payable_id = pap.id where po.order_id={$value['order_id']}";
				$apply = $this->db->query($mysql)->row_array();
				if(!empty($apply['id'])){
					$dataArray['rows'][$key]['is_apply']=$apply['id'];
				}else{
					$dataArray['rows'][$key]['is_apply']=0;	
				}	

				//正在申请的单
				$a_sql=" select sum(amount_apply) as ap_money from u_payable_order ";
				$a_sql.="where order_id={$value['order_id']} and (status=0 or status=1  or status=2)";	
				$appData = $this->db->query($a_sql)->row_array();
				if(!empty($appData['ap_money'])){
					$dataArray['rows'][$key]['applyMo']=sprintf("%.2f",$appData['ap_money']);	
				}else{
					$dataArray['rows'][$key]['applyMo']=0;	
				}
				
				$dataArray['rows'][$key]['apply_money']=sprintf("%.2f",$dataArray['rows'][$key]['apply_money']);
				$dataArray['rows'][$key]['un_money']=sprintf("%.2f",$dataArray['rows'][$key]['un_money']);
				$dataArray['rows'][$key]['un_balance']=$dataArray['rows'][$key]['un_money']-$dataArray['rows'][$key]['applyMo'];
				$dataArray['rows'][$key]['un_balance']=sprintf("%.2f",$dataArray['rows'][$key]['un_balance']);
				$dataArray['rows'][$key]['a_balance']=sprintf("%.2f",$dataArray['rows'][$key]['applyMo']);
			}	
		}
		$data= json_encode($dataArray);

		return $data;


	}
	//申请付款信息
	 public function get_payable_apply_log($param, $page){
	    $query_sql = 'select po.id,po.payable_id,po.order_id,po.amount_apply as amount_apply,po.amount_before,po.status,';
	    $query_sql .= 'pa.id as paid,un.union_name as p_union_name,un.union_name,pa.amount,pa.status as apply_status,mo.usedate,0 as type,0 as un_balance,0 as a_balance,';
		$query_sql .= ' pa.addtime,pa.u_reply,pa.reply,mo.ordersn,pa.admin_name,pa.employee_name,mo.supplier_cost,mo.productname,mo.item_code, ';
		$query_sql .= ' pa.remark,s.realname,batch,mo.balance_money,(mo.supplier_cost-mo.balance_money-mo.platform_fee) as un_money,mo.platform_fee,e.realname as e_realname, ';
		$query_sql .='mo.productautoid as lineid,l.line_kind, ';
		$query_sql .='(select sum(amount_apply) from u_payable_order where status=2 and order_id=mo.id) as p_apply ,';
		$query_sql .='(select sum(amount_apply) from u_payable_order where (status=2 or status=1 or status=0) and order_id=mo.id) as ap_balance ';
		$query_sql .= ' from u_payable_order as po  ';
		$query_sql .= 'left join  u_payable_apply as pa ON po.payable_id = pa.id ';
		$query_sql .= ' left join u_member_order as mo on mo.id=po.order_id ';
		$query_sql .= ' left join u_line as l on l.id=mo.productautoid ';
		$query_sql .= ' left join u_expert as e on e.id=mo.expert_id ';
		$query_sql .= ' left join u_supplier as s on s.id=pa.supplier_id ';
		$query_sql .= 'left join b_union as un on un.id=mo.platform_id where pa.id>0 ';

		if ($param != null) {
			if (null != array_key_exists ( 'supplier_id', $param )) {
				$query_sql .= '  AND mo.supplier_id=  ?';	
				$param['supplier_id'] = trim($param['supplier_id']);
				
			}
			
			if (null != array_key_exists ( 'ordersn', $param )) {
				$query_sql .= '  AND mo.ordersn=  ?';	
				$param['ordersn'] = trim($param['ordersn']);
				
			}
			if (null != array_key_exists ( 'apply_sn', $param )) {
				$query_sql .= '  AND pa.id=  ?';	
				$param['apply_sn'] = trim($param['apply_sn']);
				
			}
			if (null != array_key_exists ( 'apply_status', $param )) {
				if($param['apply_status']==1){
					$query_sql .= ' AND (po.status =  ? or po.status =0 )';
					$param['apply_status'] =trim($param['apply_status']);
				}else if($param['apply_status']==3){
					$query_sql .= ' AND (po.status =  ? or po.status =5 )';
					$param['apply_status'] =trim($param['apply_status']);
				}else if($param['apply_status']==6){  //已通过和已付款
				    $param['apply_status']=2;
				    $query_sql .= ' AND (po.status =  ? or po.status =4)';
				    $param['apply_status'] =trim($param['apply_status']);
				}else{
				    $query_sql .= ' AND po.status =  ?';
				    $param['apply_status'] =trim($param['apply_status']);
				}			
			}
			
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND DATE_FORMAT(mo.usedate,"%Y-%m-%d")  >=  ? ';
				$param['starttime'] =trim($param['starttime']);	
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND  DATE_FORMAT(mo.usedate,"%Y-%m-%d")   <=  ? ';
				$param['endtime'] =trim($param['endtime']);
			}
			if(null != array_key_exists ( 'item_code', $param )){
			    $query_sql .= '  AND mo.item_code=  ?';
			    $param['item_code'] = trim($param['item_code']);
			}
			if(null != array_key_exists ( 'linename', $param )){
			    $query_sql .= '  AND mo.productname like ?';
			    $param['linename'] = "%".$param['linename']."%";
			}
		}
		 $query_sql .= ' ORDER BY mo.id DESC ';

		return $this->queryPageJson ( $query_sql, $param, $page );

	 }
     
	 //导出申请付款信息
	 public function drive_payable_apply_log($param,$supplier_id){
	     $query_sql = 'select po.id,po.payable_id,po.order_id,(po.amount_apply) as amount_apply,po.amount_before,po.status,';
	     $query_sql .= 'pa.id as paid,un.union_name as p_union_name,un.union_name,pa.amount,pa.status as apply_status,mo.usedate,pa.remark,';
	     $query_sql .= ' pa.addtime,pa.u_reply,pa.reply,mo.ordersn,pa.admin_name,pa.employee_name,mo.supplier_cost,mo.productname,mo.item_code, ';
	     $query_sql .= ' pa.remark,s.realname,batch,mo.balance_money,(mo.supplier_cost-mo.balance_money-mo.platform_fee) as un_money,mo.platform_fee,e.realname as e_realname, ';
	     $query_sql .='mo.productautoid as lineid,l.line_kind,pa.item_company,pa.bankcard,pa.bankcompany,pa.bankname,s.brand as s_brand, ';
	     $query_sql .='(select sum(amount_apply) from u_payable_order where status=2 and order_id=mo.id) as p_apply,e.depart_name ,';
	     $query_sql .='(mo.dingnum+mo.childnum+mo.childnobednum) as order_people,mo.total_price ';
	     $query_sql .= ' from u_payable_order as po  ';
	     $query_sql .= 'left join  u_payable_apply as pa ON po.payable_id = pa.id ';
	     $query_sql .= ' left join u_member_order as mo on mo.id=po.order_id ';
	     $query_sql .= ' left join u_line as l on l.id=mo.productautoid ';
	     $query_sql .= ' left join u_expert as e on e.id=mo.expert_id ';
	     $query_sql .= ' left join u_supplier as s on s.id=pa.supplier_id ';
	     $query_sql .= 'left join b_union as un on un.id=mo.platform_id where pa.id>0 ';
	     $query_sql .= ' and mo.supplier_id= '.$supplier_id;
	     
	     if ($param != null) {
        	
	         if (null != array_key_exists ( 'ordersn', $param )) {
	             $param['ordersn'] = trim($param['ordersn']);
	             $query_sql .= '  AND mo.ordersn= "'.$param['ordersn'].'"';
	            
	         }
	         if (null != array_key_exists ( 'apply_sn', $param )) {
	             $param['apply_sn'] = trim($param['apply_sn']);
	             $query_sql .= '  AND pa.id= '.$param['apply_sn'];
	         }
	         if (null != array_key_exists ( 'apply_status', $param )) {
	             if($param['apply_status']==1){
	                 $param['apply_status'] =trim($param['apply_status']);
	                 $query_sql .= ' AND (po.status ='.$param['apply_status'].' or po.status =0 )';
	                 
	             }else if($param['apply_status']==3){
	                 $param['apply_status'] =trim($param['apply_status']);
	                 $query_sql .= ' AND (po.status ='.$param['apply_status'].' or po.status =5 )';   
	             }else if($param['apply_status']==6){
	                 $param['apply_status'] =trim($param['apply_status']);
	                 $query_sql .= ' AND (po.status =2 or po.status =4 )';   
	             }else if($param['apply_status']!=-1){
	                 $param['apply_status'] =trim($param['apply_status']);
	                 $query_sql .= ' AND po.status = '. $param['apply_status'];     
	             }
	         }
	         	
	         if (null != array_key_exists ( 'starttime', $param )) {
	             $param['starttime'] =trim($param['starttime']);
	             $query_sql .= ' AND DATE_FORMAT(mo.usedate,"%Y-%m-%d")  >= "'.$param['starttime'].'"';    
	         }
	         if (null != array_key_exists ( 'endtime', $param )) {
	             $param['endtime'] =trim($param['endtime']);
	             $query_sql .= ' AND  DATE_FORMAT(mo.usedate,"%Y-%m-%d")   <= "'.$param['endtime'].'"';
	         }
	         if(null != array_key_exists ( 'item_code', $param )){
	             $param['item_code'] = trim($param['item_code']);
	             $query_sql .= '  AND mo.item_code= "'.$param['item_code'].'"';
	            
	         }
	         if(null != array_key_exists ( 'linename', $param )){
	             $param['linename'] = "'%".$param['linename']."%'";
	             $query_sql .= '  AND mo.productname like '.$param['linename'];
	            
	         }
	     }
	     $query_sql .= ' ORDER BY mo.usedate,mo.id desc ';
	     
    	 $query = $this->db->query($query_sql)->result_array();
    	 
    	 foreach ($query as $key => $value) {

    	 	//正在申请的单
    	 	$a_sql=" select sum(amount_apply) as ap_money from u_payable_order ";
    	 	$a_sql.="where order_id={$value['order_id']} and (status=0 or status=1  or status=2)";
    	 	$appData = $this->db->query($a_sql)->row_array();
    	 	if(!empty($appData)){
    	 	$query[$key]['applyMo']=$appData['ap_money'];
				}else{
    	 	$query[$key]['applyMo']=0;
    	 	}
    	 	
    	 	$query[$key]['amount_apply']=sprintf("%.2f",$query[$key]['amount_apply']);
    	 	$query[$key]['un_money']=sprintf("%.2f",$query[$key]['un_money']);
    	 	$query[$key]['un_money']=$query[$key]['un_money']-$query[$key]['applyMo'];

    	 }
    	 
    	 return $query	;
	 
	 }
	//订单的信息
/*	public function get_orderBill_apply($param, $page) {
		$query_sql =' SELECT oby.*,mo.ordersn,mo.total_price,mo.balance_money,mo.supplier_cost,ep.realname,ept.realname as manager, ';
		$query_sql .=' mo.productname,mo.usedate FROM u_order_bill_yf AS oby ';
		$query_sql .=' LEFT JOIN u_member_order AS mo ON oby.order_id = mo.id ';
		$query_sql .=' LEFT JOIN u_expert as ep on ep.id=oby.expert_id ';
		$query_sql .=' LEFT JOIN u_expert as ept on ep.id=oby.manager_id ';
		$query_sql .= ' WHERE  mo.user_type=1  ';
		if ($param != null) {
			if (null != array_key_exists ( 'supplier_id', $param )) {
				$query_sql .= '  AND mo.supplier_id= ? ';
				$param['supplier_id'] = trim($param['supplier_id']);
			}
			if (null != array_key_exists ( 'status', $param )) {
				$query_sql .= '  AND oby.status= ? ';
				$param['status'] = trim($param['status']);
			}
			if (null != array_key_exists ( 'linecode', $param )) {
				$query_sql .= ' AND mo.ordersn = ? ';
				$param['linecode'] =trim($param['linecode']);
			}
		
			if (null != array_key_exists ( 'startdatetime', $param )) {
				$query_sql .= ' AND mo.usedate BETWEEN ? AND ? ';
			}
		}
		$query_sql .=' GROUP BY oby.id ';
		$query_sql .=' ORDER BY oby.addtime DESC ';

		return $this->queryPageJson ( $query_sql, $param, $page );
	}*/
	//订单成本价
	function get_order_price($orderid){
		$query_sql = " select supplier_cost as order_price ,balance_status,balance_money from u_member_order where id={$orderid} " ;
		$query = $this->db->query($query_sql)->row_array();
		return $query	;
	}
	//付款信息
	function get_payable_order($orderid){
		$query_sql ="select po.*,pa.status,pa.addtime,pa.bankcard,pa.bankname,pa.bankcompany,mom.ordersn from u_payable_order as po " ;
		$query_sql .=" left join u_payable_apply as pa on po.payable_id=pa.id  ";
		$query_sql .=" left join u_member_order AS mom on mom.id=po.order_id where po.order_id={$orderid} ";
		$query = $this->db->query($query_sql)->result_array();
		return $query	;
	}
	//查询表的信息
	function get_table_data($table,$where=''){
		if(!empty($where)){
		   $this->db->where($where);
		}
		$query=$this->db->get($table);
		return $query->result_array();	
	}
	//保存付款信息
	function save_payable_order($payable){
		$this->db->trans_start();
        $apply=array(
          	'supplier_id'=>$payable['supplier_id'],
          	'item_company'=>$payable['item_company'],
          	'remark'=>$payable['remark'],
          	'bankcard'=>$payable['bankcard'],
          	'bankname'=>$payable['bankname'],
          	'addtime'=>date("Y-m-d H:i:s"),
		    'modtime'=>date("Y-m-d H:i:s"),
		    'status'=>0,
		    'bankcompany'=>$payable['bankpeople'],
		    'amount'=>$payable['amount_apply'],
        );

		$this->db->insert('u_payable_apply',$apply);  //插入套餐
		$apply_id=$this->db->insert_id();	

        $payableOrder=array(
         	'payable_id'=>$apply_id,
         	'order_id'=>$payable['order_id'],
         	'amount_apply'=>$payable['amount_apply'],
        );
		$this->db->insert('u_payable_order',$payableOrder);

		//订单申请中
		$this->db->where(array('id'=>$payable['order_id']))->update('u_member_order', array('balance_status'=>1));

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}
	//订单申请的总金额
	function get_pay_allmoney($orderid){
		$query_sql ="select sum(po.amount_apply) as amount from u_payable_order as po left join u_payable_apply as pa on po.payable_id=pa.id " ;
		$query_sql .=" where po.order_id={$orderid} and (po.status=1 or po.status=0 or po.status=2 ) ";
		$query = $this->db->query($query_sql)->row_array();
		return $query	;
	}
	//订单应付款表
	function get_orderBill_yf($orderid){
		$query_sql ="SELECT SUM(amount) as price_amount from u_order_bill_yf where order_id={$orderid} where status=3 " ;
		$query = $this->db->query($query_sql)->row_array();
		return $query	;
	}
	/**
	*@method 订单修改成本价
	*/
	function add_order_bill_yf($bill){
		$this->db->trans_start();

		//订单信息
		$order = $this->db->query("select supplier_cost from u_member_order where id={$bill['order_id']}")->row_array();

		//修改价格的差价
		$amount=$bill['item_price']-$order['supplier_cost'];
		//订单应付款表
		$billArr=array(
			'order_id'=>$bill['order_id'],
			'item'=>$bill['item'],
			'num'=>0,
			'price'=>$amount,
			'amount'=>$amount,
			'remark'=>'订单价格'.$order['supplier_cost'].'改成'.$bill['item_price'],
			'status'=>2,
			'addtime'=>date("Y-m-d H:i:s"),
			'supplier_id'=>$bill['supplier_id'],
			'm_time'=>date("Y-m-d H:i:s"),
			's_remark'=>'订单价格'.$order['supplier_cost'].'改成'.$bill['item_price'],
		);
		$this->db->insert ( 'u_order_bill_yf', $billArr );

		//订单账单日志表
		$type=1;
		$logArr=array(
			'order_id'=>$bill['order_id'],
			'num'=>0,
			'type'=>1,
			'price'=>$amount,
			'amount'=>$amount,
			'user_type'=>2,
			'user_id'=>$bill['supplier_id'],
			'addtime'=>date("Y-m-d H:i:s"),
			'remark'=>'订单价格'.$order['supplier_cost'].'改成'.$bill['item_price'],
		);
		$this->db->insert ( 'u_order_bill_log', $logArr );

		$this->db->where(array('id'=>$bill['order_id']))->update('u_member_order', array('supplier_cost'=>$bill['item_price']));

    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		echo false;
    	}else{
    		return true;
    	}
	}
	//遍历表
	public function sel_data($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get($table)->result_array();
		return $query;
	}
	//修改订单 通过
	function update_bill_yf($bill_id,$orderid,$supplier_id,$s_remark=''){

		$this->db->trans_start();
		$falg=1;
		$bill= $this->db->query("select * from u_order_bill_yf where id={$bill_id}")->row_array();
		if($bill['order_id']==$orderid){

			$order= $this->db->query("select * from u_member_order where id={$orderid}")->row_array();

			$item_price=$order['supplier_cost']+$bill['amount']; //修改价格后的成本价

			//$paymoney=$this->get_pay_allmoney($orderid);//申请金额

			/*if($paymoney['amount']>$item_price){  //申请结算的金额大于订单修改后的成本价
				$falg=3;
				
			}else*/ if($item_price<0){ //成本价不能低于0 
				$falg=2;
			}else{  
				//var_dump($bill['amount']);exit;
				$sql="update u_member_order set supplier_cost=supplier_cost+{$bill['amount']} where id={$orderid}";
				$this->db->query($sql);

				$billArr=array(
					'supplier_id'=>$supplier_id,
					's_time'=>date('Y-m-d,H:i:s',time()),
					'status'=>2,
					's_remark'=>$s_remark
				);
				$this->db->where(array('id'=>$bill['id']))->update('u_order_bill_yf',$billArr);

				//修改订单日志
				
				$dingnum =$order['dingnum']-$bill['num'];
				$childnum =$order['childnum']-$bill['childnum'];
				$oldnum =$order['oldnum']-$bill['oldnum'];
				$childnobednum =$order['childnobednum']-$bill['childnobednum'];
				if($bill['kind']==2){
					$remark=" 订单价格{$order['supplier_cost']} 改成 成本价{$item_price} , {$order['childnum']}成人改成{$dingnum}成人 , ";
					$remark.="{$order['childnum']}小孩(占床)改成{$childnum}小孩 , {$order['childnobednum']}小孩(不占床)改成{$childnobednum }小孩 , {$order['oldnum']}老人改成{$oldnum}老人";
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
			}
			
		}else{
			$falg=false;

		}
	
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return $falg;
		}
	}
	//修改订单 拒绝 
	function refuse_bill_yf($bill_id,$orderid,$supplier_id,$s_remark=''){

		$this->db->trans_start();
		$falg=true;
		$bill= $this->db->query("select * from u_order_bill_yf where id={$bill_id} and (status=0 or status=1) ")->row_array();
		$order=$this->db->query("select * from u_member_order where id={$orderid}")->row_array();
		$orderid=$bill['order_id'];
		if($bill['order_id']==$orderid){
			//成本账单表
			$billArr=array(
				'supplier_id'=>$supplier_id,
				's_time'=>date('Y-m-d,H:i:s',time()),
				'status'=>4,
				's_remark'=>$s_remark
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
				'remark'=>'订单成本价'.$order['supplier_cost'].'拒绝修改成本价'.$bill['amount'],
			);

			$this->db->insert ( 'u_order_bill_log', $logArr);

			//订单退款表	 状态改为-2
			$yfdata=$this->db->query("SELECT yf_id FROM  u_order_refund where order_id={$orderid} and yf_id={$bill_id} ")->row_array();
			if(!empty($yfdata)){
				$this->db->query("update u_order_refund set status=-2 where order_id={$orderid} and yf_id={$bill_id} ");
			}

		}else{
			$falg=false;
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return $falg;
		}
	}
	//批量申请结算
	function  all_p_payable_apply($order,$money,$bankData,$unionid){
		$this->db->trans_start();
		$amount=0;
		$union=$this->db->query("select * from b_union where id={$unionid}")->row_array();
		$this->db->insert('code_fk_batch',array('code'=>'a'));  //插入
		$batch_id=$this->db->insert_id();	
        //供应商联系人
		$linkman='';
		$supplier=$this->db->query("select linkman from u_supplier where id={$bankData['supplier_id']}")->row_array();
	    if(!empty($supplier['linkman'])){
	        $linkman=$supplier['linkman'];
	    } 
		 $apply=array(
              'supplier_id'=>$bankData['supplier_id'],
              'item_company'=>$bankData['item_company'],
              'remark'=>$bankData['remark'],
              'bankcard'=>$bankData['bankcard'],
              'bankname'=>$bankData['bankname'],
              'addtime'=>date("Y-m-d H:i:s"),
    		  'modtime'=>date("Y-m-d H:i:s"),
    		  'status'=>0,
    		  'bankcompany'=>$bankData['bankcompany'],
    		  'pay_way'=>$bankData['pay_way'],
    		  'union_id'=>$unionid,
    		  'union_name'=>$union['union_name'],
    		  'batch'=>$batch_id,
		      'commit_name'=>$linkman
		 );
		$this->db->insert('u_payable_apply',$apply);  //插入
		$apply_id=$this->db->insert_id();	

		foreach ($order as $key => $value) {
		 	if(!empty($order[$key])&&!empty($money[$key])){
		 		$orderData=$this->db->query("select total_price,supplier_cost,balance_money,platform_fee from u_member_order where id={$value}")->row_array();
		 		$amount_before=$orderData['supplier_cost']-$orderData['platform_fee']-$orderData['balance_money'];
                $payableOrder=array(
                    'payable_id'=>$apply_id,
                    'order_id'=>$value,
                    'amount_apply'=>$money[$key],
                    'amount_before'=>$amount_before,
                    'remark'=>'应收账单'.$orderData['total_price'].',应付账单'.$orderData['supplier_cost'].',操作费'.$orderData['platform_fee'].',已结算'.$orderData['balance_money'],
                );
				$this->db->insert('u_payable_order',$payableOrder);

				//订单申请中
				$this->db->where(array('id'=>$value))->update('u_member_order', array('balance_status'=>1)); 

				$amount=$money[$key]+$amount;
			}

		}

		//统计总的金额
		if(!empty($amount)){
			$this->db->where(array('id'=>$apply_id))->update('u_payable_apply', array('amount'=>$amount)); 
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			//jkr ，用于消息发送
			return $apply_id;
		}
	}
	//t33申请结算
	function  all_t33_payable_apply($orderid,$money,$bankData,$unionid){
		$this->db->trans_start();
		$amount=0;
		$union=$this->db->query("select * from b_union where id={$unionid}")->row_array();
		$this->db->insert('code_fk_batch',array('code'=>'a'));  //插入
		$batch_id=$this->db->insert_id();	

		//供应商联系人
		$linkman='';
		$supplier=$this->db->query("select linkman from u_supplier where id={$bankData['supplier_id']}")->row_array();
		if(!empty($supplier['linkman'])){
		    $linkman=$supplier['linkman'];
		}
		
		 $apply=array(
	        'supplier_id'=>$bankData['supplier_id'],
	        'item_company'=>$bankData['item_company'],
	        'remark'=>$bankData['remark'],
	        'bankcard'=>$bankData['bankcard'],
	        'bankname'=>$bankData['bankname'],
	        'addtime'=>date("Y-m-d H:i:s"),
			'modtime'=>date("Y-m-d H:i:s"),
			'status'=>1,
			'bankcompany'=>$bankData['bankcompany'],
			'pay_way'=>$bankData['pay_way'],
			'union_id'=>$unionid,
			'union_name'=>$union['union_name'],
			'batch'=>$batch_id,
		    'commit_name'=>$linkman
		 );
		$this->db->insert('u_payable_apply',$apply);  //插入
		$apply_id=$this->db->insert_id();	


 		$orderData=$this->db->query("select total_price,supplier_cost,balance_money,platform_fee from u_member_order where id={$orderid}")->row_array();
 		$amount_before=$orderData['supplier_cost']-$orderData['platform_fee']-$orderData['balance_money'];
        $payableOrder=array(
               'payable_id'=>$apply_id,
               'order_id'=>$orderid,
               'amount_apply'=>$money,
               'amount_before'=>$amount_before,
               'status'=>2,
        	   'remark'=>'应收账单'.$orderData['total_price'].',应付账单'.$orderData['supplier_cost'].',操作费'.$orderData['platform_fee'].',已结算'.$orderData['balance_money'],
        );
		$this->db->insert('u_payable_order',$payableOrder);

		//订单申请中
		$this->db->where(array('id'=>$orderid))->update('u_member_order', array('balance_status'=>1)); 

		$amount=$money+$amount;
		
		 //统计总的金额
		 if(!empty($amount)){
			$this->db->where(array('id'=>$apply_id))->update('u_payable_apply', array('amount'=>$amount)); 
		 }

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}
	//取消订单申请
	function save_apply_order($apply_id,$order_id){

		$this->db->trans_start();

		$sql="select upo.*,pap.amount,pap.id as pap_id  from u_payable_order as upo  left join u_payable_apply as pap on  pap.id=upo.payable_id ";
		$sql.=" where upo.id={$apply_id} ";
		$payable= $this->db->query($sql)->row_array();
		
		$falg=$this->db->query("select id from  u_payable_order where payable_id ={$payable['pap_id']} and id !={$apply_id}")->row_array();

		if($payable['amount_apply']==$payable['amount'] && empty($falg)){  //申请一条可以全部删除

			$this->db->where(array('id'=>$payable['pap_id']))->delete('u_payable_apply');
			$this->db->where(array('id'=>$apply_id))->delete('u_payable_order');
			//订单申请中
			$this->db->where(array('id'=>$order_id))->update('u_member_order', array('balance_status'=>0)); 

		}else{
			$account=$payable['amount']-$payable['amount_apply'];
			$this->db->where(array('id'=>$apply_id))->delete('u_payable_order');

			$this->db->where(array('id'=>$payable['pap_id']))->update('u_payable_apply', array('amount'=>$account)); 
			$this->db->where(array('id'=>$order_id))->update('u_member_order', array('balance_status'=>0)); 
			//echo $this->db->last_query();
		}	

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}

	}
	//旅行社
	function get_depart_list($supplier_id){
		$data= $this->db->query("select un.* from b_company_supplier as bcs left join b_union as un on un.id = bcs.union_id  GROUP by  un.id ")->result_array();
		//where bcs.supplier_id={$supplier_id} 
		return $data;
	}
	//获取申请订单
	function get_apply_order_list($id,$param,$page=1 ,$num=10){
		$sql="select upo.id,pap.amount,upo.amount_apply,mom.ordersn,mom.productname,(mom.supplier_cost-mom.platform_fee) as supplier_cost,upo.status, ";
		$sql.=" upo.amount_apply/(mom.supplier_cost-mom.platform_fee-mom.balance_money)*100 as list,pap.remark, ";
		$sql.="((mom.supplier_cost-mom.platform_fee)-mom.balance_money) as un_account,e.realname as expert_name,dep.name as depart_name,";
		$sql.=" mom.balance_money/(mom.supplier_cost-mom.platform_fee)*100 as all_account,mom.item_code as linesn ,pap.status as apply_status,";
		$sql.="mom.balance_money,mom.usedate,mom.platform_fee,pap.bankcompany,pap.bankname,pap.bankcard, ";
		$sql.="pap.pay_way,mom.id as order_id ";
		$sql.=" from u_payable_order as upo ";
		$sql.=" left join u_member_order as mom on upo.order_id = mom.id";
		$sql.=" left join u_expert as e on e.id=mom.expert_id ";
		$sql.=" left join b_depart as dep on dep.id=mom.depart_id";
		//$sql.=" left join u_line_suit_price as lsp on lsp.suitid=mom.suitid and lsp.day=mom.usedate";
		$sql.=" left join u_payable_apply as pap on  pap.id=upo.payable_id ";
		$sql.=" where upo.payable_id={$id}";
		//var_dump($param);
		if ($param != null) {	
			if (null != array_key_exists ( 'u_starttime', $param )) {
				$param['u_starttime'] = trim($param['u_starttime']);
				$sql .= '  AND mom.usedate >= "'.$param['u_starttime'].'" ';	
			}
			if (null != array_key_exists ( 'u_endtime', $param )) {
				$param['u_endtime'] = trim($param['u_endtime']);
				$sql .= '  AND mom.usedate<= "'.$param['u_endtime'].'" ';	
			}
			if (null != array_key_exists ( 'ordersn', $param )) {
				$param['ordersn'] = trim($param['ordersn']);
				$sql .= '  AND mom.ordersn= "'.$param['ordersn'].'" ';	
			}
		}

		$data['count'] = $this ->getCount($sql, array());
		$limieStr = ' limit '.($page - 1) * $num.','.$num;
		$sql .=' ORDER BY mom.usedate DESC '.$limieStr;
		$data['data'] =$this ->db ->query($sql) ->result_array();
		if(!empty($data['data'])){
			$amount=0;
			foreach ($data['data'] as $key => $value) {
				$amount=$data['data'][$key]['amount_apply']+$amount; 
				$data['data'][$key]['amount']=$amount;
			}
		}
		return  $data;

	}
	//付款申请
	function get_order_receivable($orderid){
		$sql="select sum(sk.money) as  all_sk_money from  u_order_receivable as sk where sk.order_id={$orderid} and sk.status=2 ";
		$data= $this->db->query($sql)->row_array();
		return $data;
	}
	//流水单
	function  get_payable_pic($id){
		$sql=" SELECT pic from u_payable_apply_pic where payable_id={$id}";
		$data= $this->db->query($sql)->result_array();
		return $data;
	}
	
	//订单申请款单
	function get_payable_list($orderid){
		$sql='select po.id,po.amount_apply as amount_apply,mom.ordersn,e.realname,mom.balance_money,po.status,';
		$sql.='	e.depart_name,mom.usedate,mom.platform_fee,mom.item_code,0 as un_balance,0 as applyMo,';
		$sql.='(mom.supplier_cost) as supplier_cost,po.order_id,';
		$sql.='(mom.supplier_cost-mom.balance_money-mom.platform_fee) as un_money,';
		$sql.='mom.balance_money/(mom.supplier_cost-mom.platform_fee)*100 as list_money ';
		$sql.=' from u_payable_order as po ';
		$sql.='left join u_payable_apply as pap on po.payable_id = pap.id ';
		$sql.='left join u_member_order as mom on mom.id = po.order_id ';
		$sql.='left join u_expert as e on e.id = mom.expert_id ';
		$sql.=' where	po.order_id ='.$orderid;
		$sql.=' order by po.id desc ';
		$data= $this->db->query($sql)->result_array();
		if(!empty($data)){
			foreach ($data as $k=>$v){
				//正在申请的单
				$a_sql=" select sum(amount_apply) as ap_money from u_payable_order ";
				$a_sql.="where order_id={$v['order_id']} and (status=0 or status=1  or status=2)";	
				$appData = $this->db->query($a_sql)->row_array();
				if(!empty($appData['ap_money'])){
					$data[$k]['applyMo']=$appData['ap_money'];	
				}else{
					$data[$k]['applyMo']=0;	
				}
				$data[$k]['un_money']=sprintf("%.2f",$data[$k]['un_money']);
				$data[$k]['un_balance']=$data[$k]['un_money']-$data[$k]['applyMo'];
				$data[$k]['un_balance']=sprintf("%.2f",$data[$k]['un_balance']);
				$data[$k]['a_balance']=$data[$k]['applyMo'];
				$data[$k]['amount_apply']=sprintf("%.2f",$data[$k]['amount_apply']);
			}	
		}
		return $data;
	}

	//订单团队
	/*function show_order_message($orderid){
		$sql='select mom.item_code,mom.* from u_member_order as mom where  '
		$sql=' '
		$sql=' '
	}*/

	public function get_payable_item($param) {
		$query_sql = 'select mo.ispay,mo.ordersn,mo.status,(mo.supplier_cost) as supplier_cost,mo.suitid,l.id AS lid,ls.unit,l.linecode,';
		$query_sql .= ' mo.memberid,mo.expert_id,l.linename,mo.id,mo.id as order_id,mo.balance_status,0 as un_balance,0 as a_balance,';
		$query_sql .= 'mo.childnum,mo.dingnum,mo.childnobednum,mo.oldnum,mo.balance_money,un.union_name,';
		$query_sql .= '(mo.childnum + mo.dingnum + mo.childnobednum + mo.oldnum) as "num",un.id as union_id,';
		$query_sql .= '(mo.total_price + mo.settlement_price) as total_price,mo.item_code as linesn ,';
		$query_sql .= 'mo.usedate,mo.user_type,mo.addtime,billy.id as billy_id,(sum(sk.money)-mo.depart_balance-mo.union_balance) as j_money,';
		$query_sql .= '((mo.supplier_cost)- mo.balance_money) as apply_money,mo.platform_fee,';//-mo.platform_fee
		$query_sql .= '(mo.supplier_cost- mo.balance_money-mo.platform_fee) as un_money,e.realname,e.depart_name,';
		$query_sql .= '(mo.balance_money/(mo.supplier_cost-mo.platform_fee))*100 as account_money_list, ';
		$query_sql .='(sum(sk.money)-mo.balance_money) as sk_money,((mo.supplier_cost)- mo.balance_money-mo.platform_fee) as a_money, ';
		$query_sql .='(sum(sk.money)-mo.balance_money)/((mo.supplier_cost-mo.platform_fee)- mo.balance_money)*100 as Mlist ';
		$query_sql .=' FROM u_member_order AS mo' ;
		//$query_sql .=" LEFT JOIN  u_line_suit_price as lsp on lsp.lineid=mo.productautoid and lsp.day=mo.usedate";
		$query_sql .=' LEFT JOIN  u_line AS l ON l.id = mo.productautoid';
		$query_sql .= ' LEFT JOIN u_line_suit AS ls ON ls.id = mo.suitid';
		$query_sql .= ' LEFT JOIN u_order_bill_yf as billy on billy.order_id=mo.id and billy.status=1 ';
		$query_sql .= ' LEFT JOIN b_union AS un ON un.id = mo.platform_id ';
		$query_sql .= ' LEFT JOIN u_order_receivable as sk on mo.id=sk.order_id and sk.status=2';
		$query_sql .= ' LEFT JOIN u_expert as e on e.id=mo.expert_id ';
		$query_sql .= ' WHERE  mo.user_type=1 and ((mo.status>3  and mo.status<9) or mo.status=-4) ';

		if ($param != null) {
			
			if (null != array_key_exists ( 'order_id', $param )) {
				$param['order_id'] = trim($param['order_id']);
				$query_sql .= '  AND mo.id=  '.$param['order_id'] ;
				
			}
			if (null != array_key_exists ( 'item_code', $param )) {
				$param['item_code'] = trim($param['item_code']);
				$query_sql .= '  AND mo.item_code= "'.$param['item_code'].'"' ;
				
			}
		}

		$query_sql .=' GROUP BY mo.id ORDER BY mo.addtime DESC ';

		$data= $this->db->query($query_sql)->result_array();
		//echo $this->db->last_query();
		if(!empty($data)){
			foreach ($data as $key => $value) {
				//判断是否有申请的单
				$mysql="select po.id from u_payable_order AS po  left join u_payable_apply as pap on po.payable_id = pap.id where po.order_id={$value['order_id']}";
				$apply = $this->db->query($mysql)->row_array();
				if(!empty($apply['id'])){
					$data[$key]['is_apply']=$apply['id'];
				}else{
					$data[$key]['is_apply']=0;	
				}

				//正在申请的单
				$a_sql=" select sum(amount_apply) as ap_money from u_payable_order ";
				$a_sql.="where order_id={$value['order_id']} and (status=0 or status=1  or status=2)";	
				$appData = $this->db->query($a_sql)->row_array();
				if(!empty($appData)){
					$data[$key]['applyMo']=sprintf("%.2f",$appData['ap_money']);	
				}else{
					$data[$key]['applyMo']=0;	
				}
				$data[$key]['un_money']=sprintf("%.2f",$data[$key]['un_money']);
				$data[$key]['apply_money']=sprintf("%.2f",$data[$key]['apply_money']);
				$data[$key]['un_balance']=$data[$key]['un_money']-$data[$key]['applyMo'];
				$data[$key]['un_balance']=sprintf("%.2f",$data[$key]['un_balance']); 
				$data[$key]['a_balance']=sprintf("%.2f",$data[$key]['applyMo']); 
			}	
		}
		return $data;
	}
}