<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_price_model extends MY_Model {
	private $table_name = 'u_order_price_apply';
	function __construct() {
		parent::__construct ();
	}
	//获取更改订单价格的列表
	public  function get_order_price($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		//	var_dump($arr);exit;
		$query_sql  = 'SELECT op.id as opid,mo.ordersn,e.nickname,mo.productname,mo.productautoid as line_id,mo.usedate,(op.before_price+mo.settlement_price)  as before_price,(op.after_price+mo.settlement_price) as after_price ,op.expert_reason,op.addtime,op.supplier_reason,l.overcity ';
		$query_sql.=' FROM	u_order_price_apply AS op ';
		$query_sql.=' LEFT JOIN u_expert AS e ON op.expert_id = e.id LEFT JOIN u_member_order AS mo ON op.order_id = mo.id ';
		$query_sql.=' LEFT JOIN u_line as l on mo.productautoid=l.id';
		$query_sql.=' WHERE mo.supplier_id ='.$login_id;

		if(null!=array_key_exists('status', $param)){
			$query_sql.=' AND op.status = ? ';
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
	/*	if(null!=array_key_exists('realname', $param)){
			$query_sql.=' AND e.realname  like ? ';
			$param['realname'] = '%'.$param['realname'].'%';
		}

		if(null!=array_key_exists('mobile', $param)){
			$query_sql.=' AND e.mobile  = ? ';
			$param['mobile'] = trim($param['mobile']);
		}
		if(null!=array_key_exists('country', $param)){
			$query_sql.=' AND e.country  = ? ';
			$param['country'] = trim($param['country']);
		}
		if(null!=array_key_exists('province_id', $param)){
			$query_sql.=' AND e.province  = ? ';
			$param['province_id'] = trim($param['province_id']);
		}
		if(null!=array_key_exists('city_id', $param)){
			$query_sql.=' AND e.city  = ? ';
			$param['city_id'] = trim($param['city_id']);
		}*/
		$query_sql.=' order by e.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//获取某个更新的订单价格的数据
	function orderPriceRowdata($id){
		$query_sql  ='SELECT mo.ordersn,mo.productname,mo.usedate ,op.before_price,mo.productautoid as line_id, ';
		$query_sql.=' op.after_price ,op.expert_reason,op.supplier_reason ,op.modtime FROM	u_order_price_apply AS op ';
		$query_sql.=' LEFT JOIN u_member_order AS mo ON op.order_id = mo.id  ';
		$query_sql.=' where op.id='.$id;
		return  $this ->db ->query($query_sql) ->row_array();
	}
	
 	//修改价格
	function up_price($id,$reason,$line_id){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		$this->db->trans_start();
		//修改价格表
		$price=$this->db->select('*')->where(array('id'=>$id))->get('u_order_price_apply')->row_array();
		//线路信息
		$line=$this->db->select('agent_rate,agent_rate_int,agent_rate_child')->where(array('id'=>$line_id))->get('u_line')->row_array();
		
		if(!empty($price['after_price'])){ //更改价格
			//订单的供应商
			$order=$this->db->select('supplier_id,expert_id,settlement_price,dingnum,oldnum,childnobednum,childnum')->where(array('id'=>$price['order_id']))->get('u_member_order')->row_array();
			//管家的供应商
			$expert=$this->db->select('supplier_id')->where(array('id'=>$order['expert_id']))->get('u_expert')->row_array();
		/* 	if($order['supplier_id']==$expert['supplier_id']){ //直属管家的管家佣金为0；
				$priceArr['agent_fee']=0;
			}else{
				if(!empty($line['agent_rate'])){
					$priceArr['agent_fee']=round($price['after_price']*$line['agent_rate'],2);
				}
			} */			
			/*$supplierData=$this->db->select('*')->where(array('id'=>$login_id))->get('u_supplier')->row_array();
			//平台佣金，
			$priceArr['agent_rate']=$supplierData['agent_rate'];
		           $priceArr['platform_fee']=round($supplierData['agent_rate']*$price['after_price'] ,2) ;*/
                                   
			$priceArr['total_price']=$price['after_price'];
			$order_price=$order['settlement_price']+$price['after_price'];

			$supplierData=$this->db->select('*')->where(array('id'=>$login_id))->get('u_supplier')->row_array();
			//平台佣金，
			$priceArr['agent_rate']=$supplierData['agent_rate'];
		           $priceArr['platform_fee']=round($supplierData['agent_rate']*$price['after_price'],2) ;

			$this->db->where(array('id'=>$id))->update('u_order_price_apply', array('status'=>1,'supplier_reason'=>$reason));
			$this->db->where(array('id'=>$price['order_id']))->update('u_member_order', $priceArr);
			$logArr=array(
				'order_id'=>$price['order_id'],
				'op_type'=>2,
				'userid'=>$login_id,
				'content'=>'供应商确定修改后的订单价格:'.$order_price.',理由:'.$reason,
				'addtime'=> date('Y-m-d H:i:s',time()),
			);
			$this->db->insert('u_member_order_log', $logArr);	
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
				
			return $id;
		}
	} 
	//拒绝更改价格
	function refuse_price($id,$reason){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		$this->db->trans_start();
		
		$price=$this->db->select('*')->where(array('id'=>$id))->get('u_order_price_apply')->row_array();
		$this->db->where(array('id'=>$id))->update('u_order_price_apply', array('status'=>2,'supplier_reason'=>$reason));
		$logArr=array( 
				'order_id'=>$price['order_id'],
				'op_type'=>2,
				'userid'=>$login_id,
				'content'=>'供应商已拒绝管家修改后的订单价格:'.$price['after_price'].',理由:'.$reason,
				'addtime'=>date('Y-m-d H:i:s',time()),
		);
		$this->db->insert('u_member_order_log', $logArr);   //添加订单日志
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return $id;
		}
	}
}
