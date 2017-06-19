<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_payable_apply_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_payable_apply' );
	}
	/**
	 * 付款申请：平台
	 * @param:  联盟单位id
	 *
	 * */
	public function payable_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
		
		//where条件
		$where_str="";
		if(isset($where['item_company']))
			$where_str.=" and a.item_company='{$where['item_company']}'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.brand like '%{$where['supplier_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate<='{$where['endtime']}'";
		if(isset($where['shen_start']))
			$where_str.=" and a.u_time>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and a.u_time<='{$where['shen_end']}'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like'%{$where['ordersn']}%'";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code like'%{$where['team_code']}%'";
		if(isset($where['status']))
		{
			if($where['status']=="4")
				$where_str.=" and (a.status =2 or a.status=4)";
			else
			    $where_str.=" and a.status ='{$where['status']}'";
		}
	
	
		$sql="
			select
					a.*,(select count(1) from u_payable_order where payable_id=a.id and status=1) as shenhe_num,
					s.company_name as supplier_name,s.brand,
					sum(mo.supplier_cost) as t_supplier_cost,
			        sum(mo.platform_fee+mo.diplomatic_agent) as t_all_platform_fee,
			        sum(mo.balance_money) as t_balance_money,
			        sum(mo.supplier_cost-mo.platform_fee-mo.diplomatic_agent-mo.balance_money) as t_nopay_money,
			        sum(mo.dingnum+mo.oldnum+mo.childnobednum+mo.childnum) as t_people_num
		
			from
					u_payable_apply as a
					left join u_supplier as s on a.supplier_id=s.id
					left join u_payable_order as po on po.payable_id=a.id 
                    LEFT JOIN u_member_order as mo on po.order_id=mo.id 
					
		where
					a.union_id='{$where['union_id']}' and a.status!=4 {$where_str}
		    GROUP BY a.id
		";
	
				$sql.="order by a.addtime desc";

		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 付款管理（财务）：版本二
	 * @param:  联盟单位id
	 *
	 * */
	public function payable_list2($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['item_company']))
			$where_str.=" and a.item_company='{$where['item_company']}'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.supplier_name='{$where['supplier_name']}'";
		if(isset($where['starttime']))
			$where_str.=" and a.addtime>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and a.addtime<='{$where['endtime']}'";
		if(isset($where['shen_start']))
			$where_str.=" and a.u_time>='{$where['shen_start']}'";
		if(isset($where['shen_end']))
			$where_str.=" and a.u_time<='{$where['shen_end']}'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like'%{$where['ordersn']}%'";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code like'%{$where['team_code']}%'";
		
		$big_where="";
		if(isset($where['status']))
		{
			if($where['status']=="1")
			{
				$big_where=" where (A.status =1 or (A.status=0 and A.approve_num>0))";
				//$big_where=" where A.approve_num>0";
			}
			else
			{
				$where_str.=" and a.status ='{$where['status']}'";
			}
			
		}
		
	
		$sql="
		select * from (select
			a.*,s.company_name as supplier_name,(select count(1) from u_payable_order where payable_id=a.id and status=2) as approve_num
		from
			u_payable_apply as a
		    left join u_supplier as s on a.supplier_id=s.id
		    left join u_payable_order as po on po.payable_id=a.id 
            LEFT JOIN u_member_order as mo on po.order_id=mo.id 
			
		where
		a.union_id='{$where['union_id']}' and a.status not in (2) {$where_str}
		GROUP BY a.id
		) as A {$big_where}
		";
	
		$sql.="order by A.addtime desc";

		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 付款管理（财务）：版本二
	 * @param:  联盟单位id
	 *
	 * */
	public function payable_list3($where,$from="",$page_size="")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['item_company']))
			$where_str.=" and a.item_company='{$where['item_company']}'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.brand like'%{$where['supplier_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate<='{$where['endtime']}'";
		if(isset($where['price_start']))
			$where_str.=" and po.amount_apply>='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and po.amount_apply<='{$where['price_end']}'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like'%{$where['ordersn']}%'";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code like'%{$where['team_code']}%'";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like'%{$where['productname']}%'";
		if(isset($where['commit_name']))
			$where_str.=" and a.commit_name like'%{$where['commit_name']}%'";
		
		if(isset($where['supplier_id']))
			$where_str.=" and s.id ='{$where['supplier_id']}'";   //供应商id(品牌名)
		else
		{
			//if(isset($where['supplier_brand']))
				//$where_str.=" and s.brand like '%{$where['supplier_brand']}%'"; //供应商id(供应商品牌)
		}
		//var_dump($where);
		if(isset($where['supplier_id2']))
			$where_str.=" and s.id ='{$where['supplier_id2']}'";   //供应商id(供应商代码)
		else 
		{
			//if(isset($where['supplier_code']))
				//$where_str.=" and s.code like '%{$where['supplier_code']}%'"; //供应商id(供应商代码)
		}
		
		if(isset($where['payable_id']))
			$where_str.=" and po.payable_id='{$where['payable_id']}'";
		
		if(isset($where['id']))
			$where_str.=" and po.id ='{$where['id']}'";
		if(isset($where['union_id']))
			$where_str.=" and a.union_id ='{$where['union_id']}'";
		if(!empty($where['list']))
			$where_str.=" and po.id in {$where['list']}";
		
		if(isset($where['status']))
		{
			if($where['status']=="5")
				$where_str.=" and (po.status = 3 or po.status=5)";
		    else
		    	$where_str.=" and po.status ='{$where['status']}'";
		}

		$sql="
		select
		        po.id,po.payable_id,po.status,po.order_id,po.amount_apply,po.amount_before,mo.platform_fee,mo.productautoid,mo.supplier_id,
				mo.ordersn,mo.productname,mo.order_price,mo.supplier_cost,mo.diplomatic_agent,mo.settlement_price,mo.balance_money,
				mo.platform_fee+mo.diplomatic_agent as all_platform_fee,
				mo.supplier_cost-mo.platform_fee-mo.balance_money-po.amount_apply-mo.diplomatic_agent as nopay_money2,
				mo.supplier_cost-mo.platform_fee-mo.balance_money-mo.diplomatic_agent as nopay_money,
				
				mo.supplier_cost-mo.platform_fee as jiesuan_money,mo.usedate,mo.balance_complete,mo.approve_status,
				mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,mo.total_price+mo.settlement_price as total_money,
				mo.item_code,e.realname as expert_name,d.name as depart_name,s.company_name as supplier_name,s.brand,
				a.bankcompany,a.item_company,a.remark,a.bankcard,a.bankname,a.remark,a.pay_way,
				(select sum(poo.amount_apply) from u_payable_order as poo where poo.order_id=po.order_id and poo.status=2) as to_pay_money
		
		from
				u_payable_order as po
				left join u_payable_apply as a on po.payable_id=a.id
				left join u_supplier as s on a.supplier_id=s.id
				LEFT JOIN u_member_order as mo on po.order_id=mo.id
				left join u_expert as e on e.id=mo.expert_id
				left join b_depart as d on d.id=mo.depart_id
			
		where
		    1=1 {$where_str}
		
		";
	
		$sql.="order by mo.usedate desc";

		$return['rows']=$this->db->query($sql)->num_rows();
		//汇总
		$sql_acount="
				select
						po.id,mo.ordersn,count(1) as num,
						sum(po.amount_apply) as amount_apply,
						mo.platform_fee+mo.diplomatic_agent as platform_fee,
						mo.supplier_cost,
						mo.supplier_cost-mo.platform_fee as jiesuan_price,
						mo.balance_money,
						mo.supplier_cost-mo.balance_money-mo.platform_fee-mo.diplomatic_agent as nopay_money,
						(select sum(amount_apply) from u_payable_order where order_id=mo.id and (status=1 or status=2))as total_apply,
						(select sum(poo.amount_apply) from u_payable_order as poo where poo.order_id=po.order_id and poo.status=2) as to_pay_money
				from
						u_payable_order as po
						left join u_payable_apply as a on po.payable_id=a.id
						left join u_supplier as s on a.supplier_id=s.id
						LEFT JOIN u_member_order as mo on po.order_id=mo.id
						left join u_expert as e on e.id=mo.expert_id
						left join b_depart as d on d.id=mo.depart_id
					
				where
				1=1 {$where_str}
				group by mo.ordersn
				";

		$return['account']=$this->db->query($sql_acount)->result_array();
		//待付款 统计
		//$sql_to_pay="select sum(poo.amount_apply) as sum_amount_apply from u_payable_order as poo where poo.id in {$where['list']} and poo.status=2";
		//$to_pay=$this->db->query($sql_to_pay)->row_array();
		//$return['account']['sum_to_pay_money']=$to_pay['sum_amount_apply'];
		
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		if(!empty($return['result']))
		{
			foreach ($return['result'] as $k=>$v)
			{
		
				if($v['amount_before']=="0")
				{
						
					$v['apply_percent']="0%"; //申请比例
				}
				else
				{
						
					$v['apply_percent']=(round($v['amount_apply']/$v['amount_before'],2)*100)."%"; //申请比例
				}
		
				if($v['supplier_cost']=="0")
				{
					$v['pay_percent']="0%"; //申请比例
				}
				else
				{
						
					$v['pay_percent']=(round($v['balance_money']/$v['jiesuan_money'],2)*100)."%"; //结算比例
				}
		
				$return['result'][$k]=$v;
			}
				
				
		}
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 付款管理（财务）：版本二 导出excel表格  
	 * @param:  联盟单位id
	 * 说明：  按订单排序，合并单元格
	 *
	 * */
	public function payable_list_excel($where,$from="",$page_size="")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['item_company']))
			$where_str.=" and a.item_company='{$where['item_company']}'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.brand like'%{$where['supplier_name']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate>='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate<='{$where['endtime']}'";
		if(isset($where['price_start']))
			$where_str.=" and po.amount_apply>='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and po.amount_apply<='{$where['price_end']}'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like'%{$where['ordersn']}%'";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code like'%{$where['team_code']}%'";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like'%{$where['productname']}%'";
		if(isset($where['commit_name']))
			$where_str.=" and a.commit_name like'%{$where['commit_name']}%'";
		if(isset($where['supplier_code']))
			$where_str.=" and s.id ='{$where['supplier_code']}'"; //供应商id(供应商代码)
		if(isset($where['supplier_id']))
			$where_str.=" and s.id ='{$where['supplier_id']}'";   //供应商id(品牌名)
	
		if(isset($where['payable_id']))
			$where_str.=" and po.payable_id='{$where['payable_id']}'";
	
		if(isset($where['id']))
			$where_str.=" and po.id ='{$where['id']}'";
		if(isset($where['union_id']))
			$where_str.=" and a.union_id ='{$where['union_id']}'";
		if(!empty($where['list']))
			$where_str.=" and po.id in {$where['list']}";
	
		if(isset($where['status']))
		{
			if($where['status']=="5")
				$where_str.=" and (po.status = 3 or po.status=5)";
			else
				$where_str.=" and po.status ='{$where['status']}'";
		}
	
		$sql="
		select
				po.id,po.payable_id,po.status,po.order_id,po.amount_apply,po.amount_before,mo.platform_fee,mo.productautoid,mo.supplier_id,
				mo.ordersn,mo.productname,mo.order_price,mo.supplier_cost,mo.diplomatic_agent,mo.settlement_price,mo.balance_money,
				mo.platform_fee+mo.diplomatic_agent as all_platform_fee,
				mo.supplier_cost-mo.platform_fee-mo.balance_money-mo.diplomatic_agent as nopay_money,
				(select sum(amount_apply) from u_payable_order where order_id=mo.id and (status=1 or status=2))as total_apply,
				mo.supplier_cost-mo.platform_fee as jiesuan_money,mo.usedate,mo.balance_complete,mo.approve_status,
				mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,mo.total_price+mo.settlement_price as total_money,
				mo.item_code,e.realname as expert_name,d.name as depart_name,s.company_name as supplier_name,s.brand,
				a.bankcompany,a.item_company,a.remark,a.bankcard,a.bankname,a.remark,a.pay_way,
				(select sum(poo.amount_apply) from u_payable_order as poo where poo.order_id=po.order_id and poo.status=2) as to_pay_money
				
	
		from
				u_payable_order as po
				left join u_payable_apply as a on po.payable_id=a.id
				left join u_supplier as s on a.supplier_id=s.id
				LEFT JOIN u_member_order as mo on po.order_id=mo.id
				left join u_expert as e on e.id=mo.expert_id
				left join b_depart as d on d.id=mo.depart_id
			
		where
		1=1 {$where_str}
	
		";
	
		$sql.="order by mo.usedate,po.order_id desc,po.id";
		$return['rows']=$this->db->query($sql)->num_rows();
		
		//汇总
		$sql_acount="
				select
						po.id,mo.ordersn,count(1) as num,
						sum(po.amount_apply) as amount_apply,
						mo.platform_fee+mo.diplomatic_agent as platform_fee,
						mo.supplier_cost,
						mo.supplier_cost-mo.platform_fee as jiesuan_price,
						mo.balance_money,
						mo.supplier_cost-mo.balance_money-mo.platform_fee-mo.diplomatic_agent as nopay_money,
						(select sum(poo.amount_apply) from u_payable_order as poo where poo.order_id=po.order_id and poo.status=2) as to_pay_money
				from
						u_payable_order as po
						left join u_payable_apply as a on po.payable_id=a.id
						left join u_supplier as s on a.supplier_id=s.id
						LEFT JOIN u_member_order as mo on po.order_id=mo.id
						left join u_expert as e on e.id=mo.expert_id
						left join b_depart as d on d.id=mo.depart_id
					
				where
				1=1 {$where_str}
				group by mo.ordersn
				";
		//var_dump($sql_acount);
		$return['account']=$this->db->query($sql_acount)->result_array();

		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";

		$return['result']=$this->db->query($sql)->result_array();
		if(!empty($return['result']))
			{
			foreach ($return['result'] as $k=>$v)
			{

			if($v['amount_before']=="0")
				{

				$v['apply_percent']="0%"; //申请比例
				}
				else
				{

			$v['apply_percent']=(round($v['amount_apply']/$v['amount_before'],2)*100)."%"; //申请比例
				}

		if($v['supplier_cost']=="0")
		{
			$v['pay_percent']="0%"; //申请比例
				}
				else
				{

			$v['pay_percent']=(round($v['balance_money']/$v['jiesuan_money'],2)*100)."%"; //结算比例
				}

					$return['result'][$k]=$v;
					}


				}
			$return['sql']=$sql;

			return $return;
	}
	/**
	 * 付款申请:详情
	 * @param:  
	 *
	 * */
	public function payable_detail($where=array())
	{
		$sql="
				select 
						a.*,po.status as p_status,po.order_id,po.amount_apply,po.amount_before,
						mo.platform_fee+mo.diplomatic_agent as platform_fee,mo.productautoid,mo.total_price,
						mo.ordersn,mo.productname,mo.order_price,mo.supplier_cost,mo.diplomatic_agent,mo.settlement_price,mo.balance_money,
						mo.supplier_cost-mo.platform_fee-mo.balance_money-mo.diplomatic_agent as nopay_money,mo.supplier_cost as jiesuan_money,mo.usedate,mo.balance_complete,mo.approve_status,
						mo.item_code,e.realname as expert_name,d.name as depart_name,s.brand,s.company_name,u.union_name,
						(select sum(money) from u_order_receivable where order_id=po.order_id and status=2) receive_total
				from 
						u_payable_order as po
				        left join u_payable_apply as a on a.id=po.payable_id
				        left join u_member_order as mo on mo.id=po.order_id
						left join u_expert as e on e.id=mo.expert_id
						left join b_depart as d on d.id=mo.depart_id
				        left join u_supplier as s on s.id=mo.supplier_id
				        left join b_union as u on u.id=a.union_id
				where 
						1=1
			";
		if(!empty($where['id']))
			$sql.=" and po.payable_id='{$where['id']}'";
		if(!empty($where['po_id']))
			$sql.=" and po.id='{$where['po_id']}'";
		
		$data=$this->db->query($sql)->result_array();
		
		if(!empty($data))
		{
			foreach ($data as $k=>$v)
			{
				
				if($v['amount_before']=="0")
				{
						
					$v['apply_percent']="0%"; //申请比例
				}
				else
				{
						
					$v['apply_percent']=(round($v['amount_apply']/$v['amount_before'],2)*100)."%"; //申请比例
				}
		
				if($v['supplier_cost']=="0")
				{
					$v['pay_percent']="0%"; //结算比例
				}
				else
				{
						
					$v['pay_percent']=(round($v['balance_money']/$v['jiesuan_money'],2)*100)."%"; //结算比例
				}
		
				$data[$k]=$v;
			}
				
				
		}
		return $data;
	}
	/**
	 * 付款申请单对应的订单列表
	 * @param:  联盟单位id
	 *
	 * */
	public function pay_order($where,$from="",$page_size="")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code like '%{$where['team_code']}%'";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'"; 
		if(isset($where['commit_name']))
			$where_str.=" and a.commit_name like '%{$where['commit_name']}%'";
		if(isset($where['price_start']))
			$where_str.=" and po.amount_apply >= '{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and po.amount_apply <= '{$where['price_end']}'";
		if(!empty($where['u_starttime']))  
			$where_str.=" and mo.usedate >= '{$where['u_starttime']}'";
		if(!empty($where['u_endtime']))
			$where_str.=" and mo.usedate <= '{$where['u_endtime']}'";
		if(!empty($where['ordersn']))
			$where_str.=" and mo.ordersn ={$where['ordersn']}";
		
		if(!empty($where['id']))
			$where_str.=" and po.payable_id ={$where['id']}";
		if(!empty($where['list']))
			$where_str.=" and po.id in {$where['list']}";
		
		$sql="
		select
				po.id,po.payable_id,po.status,po.order_id,po.amount_apply,po.amount_before,mo.platform_fee,mo.productautoid,
				mo.platform_fee+mo.diplomatic_agent as all_platform_fee,
				mo.ordersn,mo.productname,mo.order_price,mo.supplier_cost,mo.diplomatic_agent,mo.settlement_price,mo.balance_money,
				mo.supplier_cost-mo.platform_fee-mo.balance_money-mo.diplomatic_agent as nopay_money,
				mo.supplier_cost-mo.platform_fee-mo.balance_money-po.amount_apply-mo.diplomatic_agent as nopay_money2,
				mo.supplier_cost as jiesuan_money,mo.usedate,mo.balance_complete,mo.approve_status,
				mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,mo.total_price+mo.settlement_price as total_money,
				mo.item_code,e.realname as expert_name,d.name as depart_name,
				(select sum(poo.amount_apply) from u_payable_order as poo where poo.order_id=po.order_id and poo.status=2) as to_pay_money
		from
				u_payable_order as po
				left join u_member_order as mo on mo.id=po.order_id
				left join u_expert as e on e.id=mo.expert_id
				left join b_depart as d on d.id=mo.depart_id
				left join u_payable_apply as a on a.id=po.payable_id
				
		where
				1=1 {$where_str}
		";
	
	    $sql.="order by po.order_id desc";

		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		if(!empty($return['result']))
		{
			foreach ($return['result'] as $k=>$v)
			{
				
				if($v['amount_before']=="0")
				{
					
					$v['apply_percent']="0%"; //申请比例
				}
				else 
				{
					
					$v['apply_percent']=(round($v['amount_apply']/$v['amount_before'],2)*100)."%"; //申请比例
				}
				
				if($v['supplier_cost']=="0")
				{
					$v['pay_percent']="0%"; //申请比例
				}
				else 
				{
					
					$v['pay_percent']=(round($v['balance_money']/$v['jiesuan_money'],2)*100)."%"; //结算比例
				}
				
				$return['result'][$k]=$v;
			}
			
			
		}
		$return['sql']=$sql;
		
		return $return;
	}
	
	
}