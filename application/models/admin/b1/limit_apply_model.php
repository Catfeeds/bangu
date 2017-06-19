<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Limit_apply_model extends MY_Model {
	function __construct() {
		parent::__construct('b_limit_apply');
	}
	
	
	public function get_b_limit_apply($param, $page,$supplier_id) {
		$query_sql = 'select lap.id,lap.depart_id,lap.depart_name,lap.expert_id,lap.expert_name,lap.credit_limit,lap.addtime,ep.realname,lap.remark,';
		$query_sql .= 'lap.union_id,lap.status,lap.employee_id,lap.manager_name,lap.m_addtime,lap.return_time,mom.ordersn,elap.real_amount,  ';
		$query_sql .= 'elap.status as e_status, s.realname as s_realname,elap.return_amount ,lap.order_id as is_orderid,mom.status as order_status ';
		$query_sql .= ' from b_limit_apply as lap ';
		$query_sql .= ' left join u_expert as ep on ep.id=lap.expert_id  ';
		$query_sql .= ' left join b_expert_limit_apply as elap on elap.apply_id=lap.id';
		//$query_sql .= ' left join  u_member_order as mom on mom.id=elap.order_id';
		$query_sql .= ' left join  u_member_order as mom on mom.id=lap.order_id';
		$query_sql .= ' left join u_supplier as s on s.id=lap.supplier_id ';
		$query_sql .= ' where lap.supplier_id = '.$supplier_id;
		$query_sql .= ' AND ((lap.status=1 and mom.status=3) or lap.status=3 or  lap.status=4 or  lap.status=5) ';

		if ($param != null) {
			if (null != array_key_exists ( 'sch_sn', $param )) {
				$query_sql .= '  AND lap.id= ? ';
				$param['sch_sn'] = trim($param['sch_sn']);
			}
			if (null != array_key_exists ( 'sch_expertName', $param )) {
				$query_sql .= ' AND ep.realname LIKE ? ';
				$param['sch_expertName'] = '%' .trim($param['sch_expertName'] ). '%';
			}
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND lap.addtime >= ? ';
				$param['starttime'] = trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND lap.addtime <=? ';
				$param['endtime'] = trim($param['endtime']);
			}
			if (null != array_key_exists ( 'return_starttime', $param )) {
				$query_sql .= ' AND lap.return_time >=? ';
				$param['return_starttime'] = trim($param['return_starttime']);
			}
			if (null != array_key_exists ( 'return_endtime', $param )) {
				$query_sql .= ' AND lap.return_time <=? ';
				$param['return_endtime'] = trim($param['return_endtime']);
			}
			if (null != array_key_exists ( 'sch_ordersn', $param )) {
				$query_sql .= ' AND mom.ordersn=? ';
				$param['sch_ordersn'] = trim($param['sch_ordersn']);
			}

			if (null != array_key_exists ( 'apply_status', $param )) {
				$query_sql .= ' AND lap.status =? ';
				$param['apply_status'] = trim($param['apply_status']);
			}
		}

		$query_sql .=' GROUP BY lap.id ORDER BY lap.addtime DESC ';

		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	//
	function get_expert_limit_apply($param, $page,$type=0,$checkdata=0){
		$query_sql = 'select lap.id,lap.depart_id,lap.depart_name,lap.expert_id,lap.expert_name,lap.credit_limit,lap.addtime,ep.realname,lap.remark,';
		$query_sql .= 'lap.union_id,lap.status,lap.employee_id,lap.manager_name,lap.m_addtime,lap.return_time,elap.order_id,mom.ordersn, ';
		$query_sql .= 'elap.status as e_status,elap.real_amount,s.realname as s_realname,elap.return_amount ';
		$query_sql .= ' from b_limit_apply as lap ';
		$query_sql .= 'left join b_expert_limit_apply as elap on elap.apply_id=lap.id';
		$query_sql .= ' left join u_expert as ep on ep.id=lap.expert_id  ';
		//$query_sql .= ' left join  u_member_order as mom on mom.id=elap.order_id';
		$query_sql .= ' left join  u_member_order as mom on mom.id=lap.order_id';
		$query_sql .= ' left join u_supplier as s on s.id=lap.supplier_id ';
		$query_sql .= ' where lap.id>0 and (lap.status=3 or  lap.status=4) ';

		if ($param != null) {	
			if (null != array_key_exists ( 'supplier_id', $param )) {
				$query_sql .= '  AND lap.supplier_id = ?';
				$param['supplier_id'] = trim($param['supplier_id']);
			}
			if (null != array_key_exists ( 'sch_sn', $param )) {
				$query_sql .= '  AND lap.id= ? ';
				$param['sch_sn'] = trim($param['sch_sn']);
			}
			if (null != array_key_exists ( 'sch_expertName', $param )) {
				$query_sql .= ' AND ep.realname LIKE ? ';
				$param['sch_expertName'] = '%' .trim($param['sch_expertName'] ). '%';
			}
			if (null != array_key_exists ( 'starttime', $param )) {
				$query_sql .= ' AND lap.addtime >= ? ';
				$param['starttime'] = trim($param['starttime']);
			}
			if (null != array_key_exists ( 'endtime', $param )) {
				$query_sql .= ' AND lap.addtime <=? ';
				$param['endtime'] = trim($param['endtime']);
			}
			if (null != array_key_exists ( 'return_starttime', $param )) {
				$query_sql .= ' AND lap.return_time >=? ';
				$param['return_starttime'] = trim($param['return_starttime']);
			}
			if (null != array_key_exists ( 'return_endtime', $param )) {
				$query_sql .= ' AND lap.return_time <=? ';
				$param['return_endtime'] = trim($param['return_endtime']);
			}
			if (null != array_key_exists ( 'apply_status', $param )) {
				$query_sql .= ' AND lap.status =? ';
				$param['apply_status'] = trim($param['apply_status']);
			}
			if (null != array_key_exists ( 'sch_ordersn', $param )) {
				$query_sql .= ' AND mom.ordersn =? ';
				$param['sch_ordersn'] = trim($param['sch_ordersn']);
			}
			
		}
		if(!empty($type)){
			if($type==1){
				$query_sql .= ' AND lap.status =3 ';
				//$query_sql .= ' AND lap.return_time <= CURDATE '	;
			}else if($type==2){
				$query_sql .= ' AND lap.status =4 ';	
			}	
		}
		if(!empty($checkdata) && $checkdata==1){  //超时未还款
			$query_sql .= ' AND lap.status =3 and lap.return_time < CURDATE() ';
		}
		$query_sql .=' ORDER BY lap.addtime DESC ';

		return $this->queryPageJson ( $query_sql, $param, $page );
	}
	//额度审核
	function update_limit_apply($apply_id,$type,$reply,$supplier_id){
		if($type==1){  //通过
			$this->db->trans_start();
			//信用额度
			$credit= $this->db->query("select * from b_limit_apply where id={$apply_id}")->row_array();

			//授信中
			$addLimt=array(
				'status'=>3,
				'supplier_id'=>$supplier_id,
				'reply'=>$reply,
				'modtime'=>date('Y-m-d H:i:s',time())
			);
			$this->db->where(array('id'=>$apply_id))->update('b_limit_apply',$addLimt);  

			//管家信用申请使用表
			$expertLimit=array(
				'depart_id'=>$credit['depart_id'],
				'depart_name'=>$credit['depart_name'],
				//'depart_name'=>$credit['depart_name'],
				'expert_id'=>$credit['expert_id'],
				'expert_name'=>$credit['expert_name'],
				'expert_name'=>$credit['expert_name'],
				'apply_id'=>$apply_id,
				'apply_amount'=>$credit['credit_limit'],
				'addtime'=>date('Y-m-d H:i:s',time()),
				'status'=>0,
				'return_time'=>$credit['return_time'],
			);
			$this->db->insert('b_expert_limit_apply',$expertLimit); 

			//营业部额度变化
			$depart=$this->db->query("select * from b_depart where id={$credit['depart_id']}")->row_array();
			if(empty($depart['cash_limit'])){
				$depart['cash_limit']=0;
			}
			$departLimit=array(
				'depart_id'=>$credit['depart_id'],
				'expert_id'=>$credit['expert_id'],
				//'expert_name'=>$credit['expert_name'],
				'manager_id'=>$credit['manager_id'],
				'union_id'=>$credit['union_id'],
				'supplier_id'=>$supplier_id,
				'cash_limit'=>$depart['cash_limit'],
				'credit_limit'=>$credit['credit_limit'],
				'sx_limit'=>$credit['credit_limit'],
				'addtime'=>date('Y-m-d H:i:s',time()),
				'type'=>'申请信用通过',
				'remark'=>'供应商审批通过的额度',
			);
			$this->db->insert('b_limit_log',$departLimit); 

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				return false;
			}else{
				return true;
			}

		}elseif($type==-1){  // 拒绝
			$this->db->trans_start();
			//$this->db->trans_start();
			//信用额度
			$credit= $this->db->query("select * from b_limit_apply where id={$apply_id}")->row_array();

			//已拒绝
			$this->db->where(array('id'=>$apply_id))->update('b_limit_apply', array('status'=>5,'supplier_id'=>$supplier_id,'reply'=>$reply,'modtime'=>date('Y-m-d H:i:s',time())));  

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				return false;
			}else{
				return true;
			}

		}else{
			return false;
		}
	}
	function get_limit_apply_row($id){
		$sql="select la.*,ela.real_amount,s.realname from b_limit_apply as la left join b_expert_limit_apply as ela on la.id=ela.apply_id ";
		$sql.=" left join u_supplier as s on s.id=la.supplier_id ";
		$sql.=" where la.id={$id}";
		return $this->db->query($sql)->row_array();
	}
}