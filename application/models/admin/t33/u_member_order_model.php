<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_member_order_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_member_order' );
	}
	/**
	 * 核算：按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function order_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate <='{$where['endtime']}'";
		if(isset($where['item_code']))
			$where_str.=" and mo.item_code like '%{$where['item_code']}%'";
		if(isset($where['depart_id']))
			$where_str.=" and mo.depart_id ='{$where['depart_id']}'";
		
		if(isset($where['big_depart_id']))
			$where_str.=" and mo.depart_id in ({$where['big_depart_id']})";
		
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.brand like '%{$where['supplier_name']}%'";
		if(isset($where['dest_id']))
		{
			$where_str.=" and FIND_IN_SET({$where['dest_id']},l.overcity)>0";
		}
		if(isset($where['supplier_id']))
			$where_str.=" and mo.supplier_id = '{$where['supplier_id']}'";
		else 
		{
			if(isset($where['supplier_code']))
				$where_str.=" and s.code like '%{$where['supplier_code']}%'";
		}
		
		if(isset($where['union_id']))
			$where_str.=" and mo.platform_id={$where['union_id']}";

		//var_dump($where);
		//别名where条件
		$all_str="";
		if(isset($where['startplace']))
			$all_str.=" and A.startplace like '%{$where['startplace']}%'";
		if(isset($where['order_code']))
			$all_str.=" and A.order_code = '{$where['order_code']}'";
		/* if(isset($where['dest_id']))
		{
			$all_str.=" and FIND_IN_SET({$where['dest_id']},A.dest_ids)>0";
		} 
		              GROUP_CONCAT(DISTINCT(d.id)) as dest_ids,
		*           left join u_line_dest as ld on ld.line_id=l.id 
					left join u_dest_base as d on d.id=ld.dest_id 
		*/
		
		$orderby=" order by A.addtime desc";
		if(isset($where['starttime'])||isset($where['starttime']))
			$orderby=" order by A.usedate desc";
	    /* 订单状态: 
	     *     status: 1预留位(待留位)
	     *             2已留位（B1已确认留位）
	     *             3已确认
	     *             4出团中
	     *             5行程结束
	     *             6已取消
	     *             7改价退团
	     **/
		$sql="
			 select * from(select 
					mo.id,mo.ordersn,mo.item_code,mo.usedate,mo.addtime,mo.total_price,mo.balance_money,mo.supplier_cost,
					mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,
					e.realname as expertname,d.name as depart_name,l.lineday,mo.productautoid,mo.productname,
					mo.supplier_cost-mo.platform_fee-mo.balance_money as nopay_money,mo.supplier_cost-mo.platform_fee as jiesuan_money,
					(mo.platform_fee+mo.diplomatic_agent)as all_platform_fee,
					(select sum(re.money) from u_order_receivable as re where re.order_id=mo.id and re.status=2) as receive_price,
					
					group_concat(DISTINCT(us.cityname)) as startplace,
					mo.status as status2,mo.ispay as ispay2,
					(
					    CASE  
					    	WHEN mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())>24 
					    		THEN '已取消'  
					   	    WHEN mo.status = -3
					   	    	THEN '退款中'  
					   	    WHEN mo.id IN (SELECT r.order_id FROM u_order_refund AS r WHERE r.status=3) AND (mo.status=-4) 
					   	    	THEN '退款成功'  
					   	    WHEN mo.status = -4 
					   	    	THEN '已取消'  
					   	    WHEN mo.status = -2 
					   	    	THEN '旅行社拒绝'  
					   	    WHEN mo.status = -1 
					   	    	THEN '供应商拒绝'  
					   	    WHEN mo.status = 0 AND mo.ispay=0 
					   	    	THEN '预留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=0 
					   	    	THEN '已留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=1 
					   	    	THEN '已留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=2 
					   	    	THEN '已确认'  
					   	    WHEN mo.status = 2
					   	    	THEN '向旅行社申请中'  
					   	    WHEN mo.status = 4 
					   	        THEN '已确认' 
					   	    WHEN mo.status = 5 
					   	    	THEN '出团中'  
					   	    WHEN (mo.status = 8 or mo.status = 6 or mo.status = 7)
					   	    	THEN '行程结束'  
					   	 
					   	   
					   	END) AS order_status,
					 (
					    CASE  
					    	WHEN mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())>24 
					    		THEN '6'  
					   	    WHEN mo.status=-3
					   	    	THEN '7'  
					   	     WHEN mo.id IN (SELECT r.order_id FROM u_order_refund AS r WHERE r.status=3) AND (mo.status=-4) 
					   	    	THEN '7'  
					   	    WHEN mo.status = -4 
					   	    	THEN '6'  
					   	    WHEN mo.status = -2 
					   	    	THEN '6'  
					   	    WHEN mo.status = -1 
					   	    	THEN '6'  
					   	    WHEN mo.status = 0 AND mo.ispay=0 
					   	    	THEN '1'  
					   	    WHEN mo.status = 1 AND mo.ispay=0 
					   	    	THEN '2'  
					   	    WHEN mo.status = 1 AND mo.ispay=1 
					   	    	THEN '2'  
					   	    WHEN mo.status = 1 AND mo.ispay=2 
					   	    	THEN '3'  
					   	    WHEN mo.status = 2
					   	    	THEN '1'  
					   	    WHEN mo.status = 4
					   	    	THEN '3'  
					   	    WHEN mo.status = 5
					   	    	THEN '4'  
					   	    WHEN (mo.status = 8 or mo.status = 6 or mo.status = 7)
					   	    	THEN '5'  
					   	   
					   	END) AS order_code
					  
			 from 
					u_member_order as mo
					left join u_expert as e on e.id=mo.expert_id
					left join u_line as l on l.id=mo.productautoid
					left join u_supplier as s on s.id=mo.supplier_id
					left join u_line_startplace as ls on ls.line_id=l.id 
					left join u_startplace as us on ls.startplace_id=us.id 
					left join b_depart as d on d.id=mo.depart_id
					
			 where 
					mo.status<9 and mo.status!=3 and mo.status!=-6 and mo.user_type=1  {$where_str}
	         GROUP BY mo.id	       	
        )A where 1=1 {$all_str}
		";
		$sql.=$orderby;
		
		$return['rows']=$this->db->query($sql)->num_rows();
		//汇总
		$sql_acount="
				 select 
				 		sum(A.account_people_num) as sum_people_num,sum(A.total_price) as sum_total_price,
				 		sum(A.balance_money) as sum_balance_money,sum(A.supplier_cost) as sum_supplier_cost,
				 		sum(A.all_platform_fee) as sum_all_platform_fee,sum(A.receive_price) as sum_receive_price
				  from(
		            select
					mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as account_people_num,
					mo.total_price,mo.balance_money,mo.supplier_cost,
					(mo.platform_fee+mo.diplomatic_agent)as all_platform_fee,
					(select sum(re.money) from u_order_receivable as re where re.order_id=mo.id and re.status=2) as receive_price,
					group_concat(DISTINCT(us.cityname)) as startplace,
					GROUP_CONCAT(DISTINCT(d.id)) as dest_ids,
					 (
					    CASE  
					    	WHEN mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())>24 
					    		THEN '6'  
					   	    WHEN mo.status=-3
					   	    	THEN '7'  
					   	     WHEN mo.id IN (SELECT r.order_id FROM u_order_refund AS r WHERE r.status=3) AND (mo.status=-4) 
					   	    	THEN '7'  
					   	    WHEN mo.status = -4 
					   	    	THEN '6'  
					   	    WHEN mo.status = -2 
					   	    	THEN '6'  
					   	    WHEN mo.status = -1 
					   	    	THEN '6'  
					   	    WHEN mo.status = 0 AND mo.ispay=0 
					   	    	THEN '1'  
					   	    WHEN mo.status = 1 AND mo.ispay=0 
					   	    	THEN '2'  
					   	    WHEN mo.status = 1 AND mo.ispay=1 
					   	    	THEN '2'  
					   	    WHEN mo.status = 1 AND mo.ispay=2 
					   	    	THEN '3'  
					   	    WHEN mo.status = 2
					   	    	THEN '1'  
					   	    WHEN mo.status = 4
					   	    	THEN '3'  
					   	    WHEN mo.status = 5
					   	    	THEN '4'  
					   	    WHEN (mo.status = 8 or mo.status = 6 or mo.status = 7)
					   	    	THEN '5'  
					   	   
					   	END) AS order_code
		from
					u_member_order as mo
					left join u_expert as e on e.id=mo.expert_id
					left join u_line as l on l.id=mo.productautoid
					left join u_supplier as s on s.id=mo.supplier_id
					
					left join u_line_startplace as ls on ls.line_id=l.id 
					left join u_startplace as us on ls.startplace_id=us.id 
					left join u_line_dest as ld on ld.line_id=l.id 
					left join u_dest_base as d on d.id=ld.dest_id 
			
		where
					mo.status<9 and mo.status>3 and mo.status!=-6 and mo.user_type=1  {$where_str}
		GROUP BY mo.id	      		
       ) A where 1=1 {$all_str}
		";
		
		$return['account']=$this->db->query($sql_acount)->row_array();
		
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 单团核算：按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function check_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		
		if(isset($where['productname']))
			$where_str.=" and l.linename like '%{$where['productname']}%'";
		if(isset($where['team_code']))
			$where_str.=" and p.description like '%{$where['team_code']}%'";
		if(isset($where['starttime']))
			$where_str.=" and p.day >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and p.day <='{$where['endtime']}'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.company_name like '%{$where['supplier_name']}%'";
		
		if(isset($where['day_start']))
			$where_str.=" and l.lineday >='{$where['day_start']}'";
		if(isset($where['day_end']))
			$where_str.=" and l.lineday <='{$where['day_end']}'";
		if(isset($where['price_start']))
			$where_str.=" and p.adultprice >='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and p.adultprice <='{$where['price_end']}'";
		
		if(isset($where['startplace']))
			$where_str.=" and us.cityname like '%{$where['startplace']}%'";
		if(isset($where['dest_id']))
			$where_str.=" and (find_in_set({$where['dest_id']},l.overcity)>0)";
		
		if(isset($where['supplier_in']))
			$where_str.=" and l.supplier_id in {$where['supplier_in']}";
		
		//是否已核算
		if(isset($where['order_code'])&&$where['order_code']=="1")
			$where_str.=" and p.calculation=0";
		if(isset($where['order_code'])&&$where['order_code']=="2")
			$where_str.=" and p.calculation=1";
		
        $date=date("Y-m-d");

		
               //总数
				$sql=" 
				SELECT
						COUNT(p. DAY) as total_rows
				FROM
						u_line_suit_price p
						INNER JOIN u_line AS l ON l.id = p.lineid
						INNER join u_supplier as s on s.id=l.supplier_id
						INNER JOIN u_line_startplace AS ls ON ls.line_id=p.lineid
						INNER JOIN u_startplace AS us ON ls.startplace_id=us.id
				WHERE
					   p. DAY > '2016-01-01' {$where_str} and p.order_num>0
				
				";
				
	            $total_rows=$this->db->query($sql)->row_array();
				$return['rows']=$total_rows['total_rows'];
				//第一次查
				$sql1="
				SELECT
						p.dayid
				FROM
						u_line_suit_price p
						INNER JOIN u_line AS l ON l.id = p.lineid
						INNER join u_supplier as s on s.id=l.supplier_id
						INNER JOIN u_line_startplace AS ls ON ls.line_id=p.lineid
						INNER JOIN u_startplace AS us ON ls.startplace_id=us.id
				WHERE
				p. DAY > '2016-01-01' {$where_str} and p.order_num>0

				order by p.day
				
				";
				if(!empty($page_size))
				$sql1.=" limit {$from},{$page_size}";
				//var_dump($sql1);
				$day_list=$this->db->query($sql1)->result_array();
				
				//第二次查
				$str="";
				if(!empty($day_list))
				{
					foreach ($day_list as $m=>$n)
					{
						if(($m+1)==count($day_list))
							$str.=$n['dayid'];
						else
						    $str.=$n['dayid'].",";
						
					}
				}
				else
				{
					$str="0";
				}
				$str='('.$str.')';
				$sql2="
				
				select
						p.*,GROUP_CONCAT(us.cityname) AS startplace,s.company_name,
						l.linename,
						(select (sum(dingnum)+sum(oldnum)+sum(childnum)+sum(childnobednum)) from u_member_order where status>=4 and item_code=p.description)as total_people,
						(select (sum(total_price)+sum(settlement_price)) from u_member_order where status>=4 and item_code=p.description)as total_money,
						(select sum(platform_fee) from u_member_order where status>=4 and item_code=p.description)as total_platform_fee
						
				from
						u_line_suit_price as p
						left join u_line as l on l.id=p.lineid
						LEFT JOIN u_line_startplace AS ls ON ls.line_id=p.lineid
						LEFT JOIN u_startplace AS us ON ls.startplace_id=us.id
						left join u_supplier as s on s.id=l.supplier_id
					
				where
				       p.dayid in {$str}
				GROUP BY p.dayid 
				order by
						p.dayid
				";
				$return['result']=$this->db->query($sql2)->result_array();
				$return['sql']=$sql;
				$return['sql1']=$sql1;
				$return['sql2']=$sql2;
	
				return $return;
	}
	/**
	 * 按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function check_one_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	   
		//where条件
		$where_str="";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['team_code']))
			$where_str.=" and mo.item_code like '%{$where['team_code']}%'";
		
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate <='{$where['endtime']}'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.brand like '%{$where['supplier_name']}%'";
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
		if(isset($where['dest_id']))
			$where_str.=" and find_in_set({$where['dest_id']},l.overcity)>0";
		
		if(isset($where['depart_id']))
			$where_str.=" and mo.depart_id ='{$where['depart_id']}'";
		if(isset($where['big_depart_id']))
			$where_str.=" and mo.depart_id in ({$where['big_depart_id']})";
	
		$all_str="";
		if(isset($where['startplace']))
			$all_str.=" and A.startplace like '%{$where['startplace']}%'";
		
		/* if(isset($where['destname']))
			$all_str.=" and A.destname like '%{$where['destname']}%'"; */
	
		//是否已核算
		if(isset($where['order_code'])&&$where['order_code']=="1")
			$all_str.=" and ((A.wj_num>0||A.yj_num>0)||(A.wj_lock=0&&A.yj_lock=0))";
		if(isset($where['order_code'])&&$where['order_code']=="2")
			$all_str.=" and (A.wj_lock=1&&A.yj_lock=1)";
	
		/* 订单状态:
		 *     status: 1预留位(待留位)
		*             2已留位（B1已确认留位）
		*             3已确认
		*             4出团中
		*             5行程结束
		*             6已取消
		*             7改价退团
		**/
		$sql="
		select * from
		(
		  select
			mo.id,mo.ordersn,mo.item_code,mo.usedate,mo.addtime,mo.total_price,mo.balance_money,mo.supplier_cost,
			mo.wj_lock,mo.yj_lock,mo.productname,mo.productautoid,
			mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,
			e.realname as expertname,d.name as depart_name,l.lineday,s.brand,
			mo.order_price-mo.balance_money as nopay_money,(mo.total_price+mo.settlement_price)as all_price,
			(mo.platform_fee+mo.diplomatic_agent) as caozuo_fee,
			group_concat(DISTINCT(us.cityname)) as startplace,
			(select count(1) as yj_num from u_order_bill_yj where is_lock=0 and order_id=mo.id) as yj_num,
			(select count(1) as wj_num from u_order_bill_wj where is_lock=0 and order_id=mo.id) as wj_num,
			mo.status as status2,mo.ispay as ispay2,
			(
						    CASE  
						    	WHEN mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())>24 
						    		THEN '已取消'  
						   	    WHEN mo.status = -3
						   	    	THEN '退款中'  
						   	    WHEN mo.id IN (SELECT r.order_id FROM u_order_refund AS r WHERE r.status=3) AND (mo.status=-4) 
						   	    	THEN '退款成功'  
						   	    WHEN mo.status = -4 
						   	    	THEN '已取消'  
						   	    WHEN mo.status = -2 
						   	    	THEN '旅行社拒绝'  
						   	    WHEN mo.status = -1 
					   	    	THEN '供应商拒绝'  
					   	    WHEN mo.status = 0 AND mo.ispay=0 
					   	    	THEN '预留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=0 
					   	    	THEN '已留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=1 
					   	    	THEN '已留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=2 
					   	    	THEN '已确认'  
					   	    WHEN mo.status = 2
					   	    	THEN '向旅行社申请中'  
					   	    WHEN mo.status = 4 
					   	        THEN '已确认' 
					   	    WHEN mo.status = 5 
					   	    	THEN '出团中'  
					   	    WHEN (mo.status = 8 or mo.status = 6 or mo.status = 7)
					   	    	THEN '行程结束'  
					   	 
					   	   
					   	END) AS order_status
	
		from
				u_member_order as mo
				left join u_expert as e on e.id=mo.expert_id
				left join u_line as l on l.id=mo.productautoid
				left join u_supplier as s on s.id=mo.supplier_id
				left join u_line_startplace as ls on ls.line_id=l.id 
				left join u_startplace as us on ls.startplace_id=us.id 
				left join b_depart as d on d.id=mo.depart_id
				
		where
				mo.user_type=1 and mo.status>3 and mo.status<9 and mo.platform_id='{$where['union_id']}' {$where_str}
	    GROUP BY mo.id	
		)A where 1=1 {$all_str}
		";
	
		$sql.="order by A.addtime desc";
	    //var_dump($sql);
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 佣金结算列表
	 * 
	 *
	 * */
	public function yj_order_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
		
		//where条件
		$where_str="";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate <='{$where['endtime']}'";
		if(isset($where['item_code']))
			$where_str.=" and mo.item_code like '%{$where['item_code']}%'";
		if(isset($where['union_status']))
		{
			if($where['union_status']=="-2")
				$where_str.=" and aa.status is null";
			else 
				$where_str.=" and aa.status = '{$where['union_status']}'";
		}
		
		/* 订单状态:
		 *     status: 1预留位(待留位)
		*             2已留位（B1已确认留位）
		*             3已确认
		*             4出团中
		*             5行程结束
		*             6已取消
		*             7改价退团
		**/
		$sql="
		select
				mo.*,mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,e.realname as expertname,e.depart_name,l.lineday,
				mo.supplier_cost-mo.platform_fee-mo.balance_money as nopay_money,mo.supplier_cost-mo.platform_fee as jiesuan_money,
				(select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
				r.union_money,aa.status as apply_status
		
		from
				u_order_receivable as r
				left join u_member_order as mo on mo.id=r.order_id
				left join u_line as l on l.id=mo.productautoid
				left join u_expert as e on e.id=mo.expert_id
				left join b_union_agent_apply_order as aao on aao.order_id=r.order_id
				left join b_union_agent_apply as aa on aa.id=aao.apply_id
		where
				r.order_id!=0 and r.union_money!=0 and r.union_id='{$where['union_id']}' {$where_str}
		
		";
		
		$sql.="order by r.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
		
		return $return;
	}
	/**
	 * 佣金结算列表
	 * 版本二
	 *
	 * */
	public function yj_balance($where,$from="",$page_size="")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate <='{$where['endtime']}'";
		if(isset($where['item_code']))
			$where_str.=" and mo.item_code like '%{$where['item_code']}%'";

		/* 订单状态:
		 *     status: 1预留位(待留位)
		*             2已留位（B1已确认留位）
		*             3已确认
		*             4出团中
		*             5行程结束
		*             6已取消
		*             7改价退团
		*             left join b_union_agent_apply_order as aao on aao.order_id=r.order_id
				      left join b_union_agent_apply as aa on aa.id=aao.apply_id
		**/
		$sql="
		select
				mo.*,mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,e.realname as expertname,e.depart_name,l.lineday,
				mo.supplier_cost-mo.platform_fee-mo.balance_money as nopay_money,mo.supplier_cost-mo.platform_fee as jiesuan_money,
				(select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
				(mo.platform_fee+mo.diplomatic_agent-mo.union_balance) as platform_fee_jiesuan,
				(mo.platform_fee+mo.diplomatic_agent) as all_platform_fee
		from
				u_member_order as mo 
				left join u_line as l on l.id=mo.productautoid
				left join u_expert as e on e.id=mo.expert_id
				
		where
		        e.union_id='{$where['union_id']}' and (mo.platform_fee+mo.diplomatic_agent-mo.union_balance !=0) {$where_str}
	
		";
	
		$sql.="order by mo.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
	    return $return;
	}
	
	/**
	 * 按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function check_detail($team_code)
	{
		$team_code=$this->sql_check($team_code);
		
		$sql="
	
					 select
					 p.*,GROUP_CONCAT(us.cityname) AS startplace,s.company_name,
					 l.linename,(select count(1) from u_member_order where status>=4 and item_code=p.description)as order_num,
					 (select (sum(dingnum)+sum(oldnum)+sum(childnum)+sum(childnobednum)) from u_member_order where status>=4 and item_code=p.description)as total_people,
					 (select (sum(total_price)+sum(settlement_price)) from u_member_order where status>=4 and item_code=p.description)as total_money,
					 (select sum(platform_fee) from u_member_order where status>=4 and item_code=p.description)as total_platform_fee,
					 (select sum(settlement_price) from u_member_order where status>=4 and item_code=p.description)as total_settlement_price,
					 (select (sum(supplier_cost-platform_fee)) from u_member_order where status>=4 and item_code=p.description)as total_jiesuan_money,
					 (select (sum(balance_money)) from u_member_order where status>=4 and item_code=p.description)as total_balance_money,
					 (select (sum(supplier_cost)) from u_member_order where status>=4 and item_code=p.description)as total_supplier_cost,
					(select sum(r.money) from u_order_receivable as r left join u_member_order as mo on mo.id=r.order_id where mo.item_code=p.description and mo.status>=4)as total_receive_price
	
					 from
					 u_line_suit_price as p
					 left join u_line as l on l.id=p.lineid
					 LEFT JOIN u_line_startplace AS ls ON ls.line_id=p.lineid
					 LEFT JOIN u_startplace AS us ON ls.startplace_id=us.id
					 left join u_supplier as s on s.id=l.supplier_id
					 	
					 where
					 p.description='{$team_code}'
					 GROUP BY p.dayid 
					 ";
	
 		$return=$this->db->query($sql)->row_array();
 				
		return $return;
	}
	
	/**
	 * 线路行程
	 * 
	 * */
	public function line_trip($line_id)
	{
		$sql="
				select 
						j.*,jp.pic
				from  
						u_line_jieshao as j
						left join u_line_jieshao_pic as jp on j.id=jp.jieshao_id
				where 
						j.lineid='{$line_id}'
			";
		$return['result']=$this->db->query($sql)->result_array();
		if(!empty($return['result']))
		{
			foreach ($return['result'] as $k=>$v)
			{
				$v['pic_arr']=explode(";",$v['pic']);
				array_pop($v['pic_arr']);
				$return['result'][$k]=$v;
			}
		}
		
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 游客名单
	 *
	 * */
	public function visitor_list($order_id)
	{
		$sql="select m.*,d.description as typename from u_member_order_man as om left join u_member_traver as m on m.id=om.traver_id left join u_dictionary as d on d.dict_id=m.certificate_type where om.order_id='{$order_id}'";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	/**
	 * 按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function team_order($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['productname']))
			$where_str.=" and mo.productname like '%{$where['productname']}%'";
		if(isset($where['ordersn']))
			$where_str.=" and mo.ordersn like '%{$where['ordersn']}%'";
		if(isset($where['starttime']))
			$where_str.=" and mo.usedate >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and mo.usedate <='{$where['endtime']}'";
		if(isset($where['item_code']))
			$where_str.=" and mo.item_code like '%{$where['item_code']}%'";
		if(isset($where['expert_name']))
			$where_str.=" and e.realname like '%{$where['expert_name']}%'";
	
		$all_str="";
		if(isset($where['startplace']))
			$all_str.=" and A.startplace like '%{$where['startplace']}%'";
		if(isset($where['destname']))
			$all_str.=" and A.destname like '%{$where['destname']}%'";
		if(isset($where['order_code']))
			$all_str.=" and A.order_code = '{$where['order_code']}'";
	
		/* 订单状态:
		 *     status: 1预留位(待留位)
		*             2已留位（B1已确认留位）
		*             3已确认
		*             4出团中
		*             5行程结束
		*             6已取消
		*             7改价退团
		**/
		$sql="
		select * from(select
				mo.*,mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum as total_people,e.realname as expertname,e.depart_name,l.lineday,
				mo.supplier_cost-mo.platform_fee-mo.balance_money-mo.diplomatic_agent as nopay_money,mo.supplier_cost-mo.platform_fee as jiesuan_money,
				mo.total_price+mo.settlement_price as total_money,mo.platform_fee+mo.diplomatic_agent as all_platform_fee,
				(select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
				(select GROUP_CONCAT(kindname) from u_dest_base where FIND_IN_SET(id,l.overcity2) >0 )as destname,
				(select group_concat(us.cityname) from u_line_startplace as ls left join u_startplace as us on ls.startplace_id=us.id where ls.line_id=l.id) as startplace,
				mo.status as status2,mo.ispay as ispay2,
				(select count(1) from u_order_bill_yf where order_id=mo.id and (status=0 or status=1)) as yf_no_approve, 
				(select count(1) from u_order_bill_yj where order_id=mo.id and status=0) as yj_no_approve, 
				(select count(1) from u_order_bill_ys where order_id=mo.id and status=0) as ys_no_approve
			
					
				from
				u_member_order as mo
				left join u_expert as e on e.id=mo.expert_id
				left join u_line as l on l.id=mo.productautoid
				where
				 mo.status>=4 and mo.item_code='{$where['team_id']}' {$where_str}
				)A where 1=1 {$all_str}
				";
	
				$sql.="order by A.addtime desc";
	
				$return['rows']=$this->db->query($sql)->num_rows();
				if(!empty($page_size))
				$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	        
	    return $return;
	}
	/*
	 * 指定团号下的订单
	 * */
	public function team_all_order($team_code)
	{
		$sql="select 
					 mo.id 
			  from 
					u_member_order as mo
			 where  
					mo.item_code='{$team_code}' and mo.status>=4";
		$return=$this->db->query($sql)->result_array();
		return $return;
	}
	/*
	 * 指定团号下:未核算的订单
	* */
	public function team_no_check($team_code)
	{
		$sql="select
						mo.id
			 from
						u_member_order as mo
			where
						mo.item_code='{$team_code}' and mo.status>=4 and (mo.yf_lock=0 or mo.ys_lock=0 or mo.bx_lock=0 or mo.yj_lock=0)";
			$return=$this->db->query($sql)->num_rows();
			return $return;
	}
	/*
	 * 指定团号下:已核算的订单
	* */
	public function team_has_check($team_code)
	{
		$sql="select
					   mo.id
			from
					   u_member_order as mo
		    where
						mo.item_code='{$team_code}' and mo.status>=4 and (mo.yf_lock=1 and mo.ys_lock=1 and mo.bx_lock=1 and mo.yj_lock=1)";
		$return=$this->db->query($sql)->num_rows();
		return $return;
	}
	
	/*
	 * 制定订单下的管家信用申请记录
	 * */
	public function order_expert_limit($order_id)
	{
		$sql="
				select 
						la.*,a.reply,u.union_name,s.brand,a.union_id,a.supplier_id
				from 
						b_expert_limit_apply as la 
						left join b_limit_apply as a on a.id=la.apply_id 
						left join u_supplier as s on s.id=a.supplier_id
						left join b_union as u on u.id=a.union_id
				where 
						la.order_id={$order_id} and la.status=1
			 ";
		$result = $this->db->query($sql)->row_array();
		return $result;
	}
}