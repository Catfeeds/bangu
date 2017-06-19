<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_order_receivable_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_order_receivable' );
	}
	/**
	 * 信用额度申请列表
	 * @param:  联盟单位id
	 *
	 * */
	public function apply_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['depart_id']))
			$where_str.=" and a.depart_id='{$where['depart_id']}'";
		if(isset($where['ordersn']))
			$where_str.=" and a.order_sn like '%{$where['ordersn']}%'";
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
		if(isset($where['manager_name']))
			$where_str.=" and a.manager_name like '%{$where['manager_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['shen_start']))
			$where_str.=" and a.modtime>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and a.modtime<='{$where['shen_end']}'";
		if(isset($where['price_start']))
			$where_str.=" and a.money>='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and a.money<='{$where['price_end']}'";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code ='{$where['team_code']}'";
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";//$where_str.=" and a.status ='{$where['status']}' and a.is_print=0";
		
		if(isset($where['is_print']))
			$where_str.=" and a.is_print ='{$where['is_print']}'";
		if(isset($where['list']))
			$where_str.=" and a.id in ({$where['list']})";
	    //区分是否是银行认款（不带订单号的交款,即order_id=0）
	     if(isset($where['is_hand_bank']))
	     	$where_str .=" and a.order_id=0"; 
	     	
		$orderby=" order by a.id desc";
		if(isset($where['status'])&&$where['status']!="1")
			$orderby=" order by a.modtime desc";
		
		$sql="
		select
		a.*,d.depart_list,e.realname as expert_name,em.realname,d.name as depart_name,mo.item_code,mo.supplier_id,s.company_name,s.realname as supplier_fuze,
		mo.supplier_cost-mo.platform_fee as jiesuan_price,mo.supplier_cost,mo.platform_fee,s.brand
		from
		u_order_receivable as a
		left join u_expert as e on a.expert_id=e.id
		left join b_employee as em on em.id=a.employee_id
		left join b_depart as d on d.id=a.depart_id
		left join u_member_order as mo on mo.id=a.order_id
		left join u_supplier as s on mo.supplier_id=s.id
		where
		a.kind=1 and a.union_id='{$where['union_id']}' {$where_str}
				";
	
		$sql.=$orderby;

		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 信用额度申请列表
	 * @param:  联盟单位id
	 *
	 * */
	public function apply_list2($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['depart_id']))
			$where_str.=" and a.depart_id='{$where['depart_id']}'";
		if(isset($where['ordersn']))
			$where_str.=" and a.order_sn like '%{$where['ordersn']}%'";
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
		if(isset($where['manager_name']))
			$where_str.=" and a.manager_name like '%{$where['manager_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['shen_start']))
			$where_str.=" and a.modtime>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and a.modtime<='{$where['shen_end']}'";
		if(isset($where['price_start']))
			$where_str.=" and a.money>='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and a.money<='{$where['price_end']}'";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code ='{$where['team_code']}'";
		if(isset($where['status']))
			$where_str.=" and a.status ='{$where['status']}'";//$where_str.=" and a.status ='{$where['status']}' and a.is_print=0";
	
		if(isset($where['is_print']))
			$where_str.=" and a.is_print ='{$where['is_print']}'";
	
		if(!empty($where['list']))
			$where_str.=" and a.id in ({$where['list']})";
		if(isset($where['union_id']))
			$where_str.=" and a.union_id ='{$where['union_id']}'";
	
	
		$orderby=" order by a.id desc";
		if(isset($where['status'])&&$where['status']!="1")
			$orderby=" order by a.modtime desc";
	
		$sql="
		select
				a.*,d.depart_list,e.realname as expert_name,em.realname,d.name as depart_name,mo.item_code,mo.supplier_id,s.company_name,s.realname as supplier_fuze,
				mo.supplier_cost-mo.platform_fee as jiesuan_price,mo.supplier_cost,mo.platform_fee,s.brand
		from
				u_order_receivable as a
				left join u_expert as e on a.expert_id=e.id
				left join b_employee as em on em.id=a.employee_id
				left join b_depart as d on d.id=a.depart_id
				left join u_member_order as mo on mo.id=a.order_id
				left join u_supplier as s on mo.supplier_id=s.id
		where
			    1=1 {$where_str}
		";
	
		$sql.=$orderby;
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($from))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 信用额度申请列表
	 * @param:  联盟单位id
	 *
	 * */
	public function apply_list_platform($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['depart_id']))
			$where_str.=" and a.depart_id='{$where['depart_id']}'";
		if(isset($where['ordersn']))
			$where_str.=" and a.order_sn like '%{$where['ordersn']}%'";
		if(isset($where['item_code']))
			$where_str.=" and mo.item_code like '%{$where['item_code']}%'";
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
		if(isset($where['manager_name']))
			$where_str.=" and a.manager_name like '%{$where['manager_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['shen_start']))
			$where_str.=" and a.modtime>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and a.modtime<='{$where['shen_end']}'";
		if(isset($where['status']))
			$where_str.=" and a.a_status ='{$where['status']}'";
	
	
		$sql="
		select
				a.*,e.realname as expert_name,em.realname,d.name as depart_name,mo.platform_fee,mo.item_code
		from
				u_order_receivable as a
				left join u_expert as e on a.expert_id=e.id
				left join b_employee as em on em.id=a.employee_id
				left join b_depart as d on d.id=a.depart_id
		        left join u_member_order as mo on mo.id=a.order_id
		where
		a.union_id='{$where['union_id']}' and a.status=2 {$where_str}
		";
	
		$sql.="order by a.id desc";

		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 付款申请：详情
	 * */
	public function item_apply_detail($where=array())
	{
		$sql="
			select
					r.*,e.realname as expert_name,d.name as depart_name,mo.item_code,mo.supplier_id,
				    s.brand,s.realname as supplier_fuze
			from
					u_order_receivable as r 
					left join u_expert as e on e.id=r.expert_id
					left join b_depart as d on d.id=r.depart_id
				    left join u_member_order as mo on mo.id=r.order_id
				    left join u_supplier as s on s.id=mo.supplier_id
	    	where
					1=1
		";
	
		if(!empty($where['id']))
			$sql.=" and r.id='{$where['id']}'";
		if(!empty($where['status']))
			$sql.=" and r.status='{$where['status']}'";
		$data=$this->db->query($sql)->result_array();
		return $data;
	}
	
	/**
	 * 所有收款
	 * */
	public function all_rece($where=array())
	{
		$sql="
			select
					r.*,e.realname as expert_name,d.name as depart_name
			from
					u_order_receivable as r
					left join u_expert as e on e.id=r.expert_id
					left join b_depart as d on d.id=r.depart_id
				   
	    	where
					r.order_id='{$where['order_id']}'
		";
	
		$data=$this->db->query($sql)->result_array();
		return $data;
	}
	
	/**
	 * @method 获取收款数据，平台交款管理
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getReceivableData(array $whereArr=array() ,$orderBy = 'r.id desc')
	{
		$sql = 'select r.*,e.realname as expert_name,d.name as depart_name,mo.total_price,bu.union_name as unionName from u_order_receivable as r left join u_expert as e on e.id = r.expert_id left join b_depart as d on d.id = r.depart_id left join u_member_order as mo on mo.id = r.order_id left join b_union as bu on bu.id=r.union_id';
		return $this ->getCommonData($sql ,$this->sql_check($whereArr) ,$orderBy);
	}
	
	/**
	 * @method 获取收款数据，平台交款管理
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getReceivable($ids)
	{
		$sql = 'select r.*,e.realname as expert_name,d.name as depart_name,mo.total_price,ub.bankcard,ub.bankname,ub.branch,ub.cardholder,mo.ordersn,bu.union_name as unionName from u_order_receivable as r left join u_expert as e on e.id = r.expert_id left join b_depart as d on d.id = r.depart_id left join u_member_order as mo on mo.id= r.order_id left join b_union_bank as ub on ub.union_id=r.union_id left join b_union as bu on bu.id=r.union_id where r.id in ('.$ids.')';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 计算请款金额
	 * @author jkr
	 * @param unknown $ids
	 */
	public function getReceivableMoney($ids)
	{
		$sql = 'select sum(allow_money) as money from u_order_receivable where id in ('.$ids.')';
		return $this ->db ->query($sql) ->row_array();
	}
	
	public function getReceivablePic($id)
	{
		$sql = 'select * from u_order_receivable_pic where receivable_id='.$id;
		return  $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 通过申请
	 * @param unknown $ids
	 * @param unknown $dataArr
	 * @param unknown $pic
	 */
	public function through($ids ,$dataArr ,$pic) 
	{
		$this->db->trans_start();
		$time = date('Y-m-d H:i:s' ,time());
		$sql = "update u_order_receivable set a_status=2,a_time='{$time}',admin_name='{$dataArr['admin_name']}',admin_id={$dataArr['admin_id']},a_remark='{$dataArr['a_remark']}' where id in ({$ids})";
		$this ->db ->query($sql);
		
		$idArr = explode(',', $ids);
		foreach($idArr as $v) {
			$picArr = array(
					'receivable_id' =>$v,
					'pic' =>$pic,
					'addtime' =>$time
			);
			$this ->db ->insert('u_order_receivable_pic' ,$picArr);
		} 
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 拒绝申请
	 * @param unknown $ids
	 * @param unknown $dataArr
	 * @param unknown $pic
	 */
	public function refuse($ids ,$dataArr)
	{
		$this->db->trans_start();
		$time = date('Y-m-d H:i:s' ,time());
		$sql = "update u_order_receivable set a_status=3,a_time='{$time}',admin_name='{$dataArr['admin_name']}',admin_id={$dataArr['admin_id']},a_remark='{$dataArr['a_remark']}' where id in ({$ids})";
		$this ->db ->query($sql);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	public function _____________________1()
	{
		
	}
	
	/*
	 * 去还 u_order_debit 表
	 * */
	public function receives_to_reback($order_id,$deadline_time)
	{
		$sql="
				select 
						 r.* 
				from
						 u_order_receivable as r 
				where   
					     r.status=2 and r.money>0 and r.order_id={$order_id} and r.addtime >= '{$deadline_time}'
					     and r.id not in (select sk_id from u_order_bill_ys where sk_id!=0)
				";
		return $this->db->query($sql)->result_array();
	}
	/*
	 * 是否要去还信用
	 * */
	public function is_to_reback($receive_id)
	{
		$sql="
			 select
					*
			from
					u_order_bill_ys 
			where
					sk_id='{$receive_id}'
		";
		$result= $this->db->query($sql)->result_array();
		if(empty($result)) //如果没有，则去还
			return true;
		else                // 不还
			return false;
	}
	
}