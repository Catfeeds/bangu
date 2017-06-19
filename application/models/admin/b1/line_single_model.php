
<?php
/***
*深圳海外国际旅行社
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Line_single_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}


	/**
	 * 按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function single_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['linename']))
			$where_str.=" and l.linename like '%{$where['linename']}%'";
		if(isset($where['linecode']))
			$where_str.=" and l.linecode like '%{$where['linecode']}%'";
		if(isset($where['supplier_name']))
			$where_str.=" and s.company_name like '%{$where['supplier_name']}%'";  
		if(isset($where['startplace']))
			$where_str.=" and us.cityname like '%{$where['startplace']}%'";
		
		if(isset($where['price_start']))
			$where_str.=" and lsp.adultprice >='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and lsp.adultprice <='{$where['price_end']}'";
		if(isset($where['starttime']))
			$where_str.=" and lsp.day >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and lsp.day <='{$where['endtime']}'";
		if(isset($where['dest_id']))
			$where_str.=" and (find_in_set({$where['dest_id']},l.overcity)>0)";
		//是否直属供应商
		if(isset($where['type'])&&$where['type']=="2")
			$where_str.=" and l.status={$where['type']}";
		if(isset($where['type'])&&$where['type']=="3")
			$where_str.=" and (l.status=3 or l.status=4)";
		
		
		$sql="select sa.*,l.linecode,l.online_time,l.line_kind,l.modtime,l.lineprice,l.supplier_id,l.linename,s.brand,s.company_name,";
		$sql.="l.lineday,l.linebefore,l.status,lsp.day,lsp.room_fee,lsp.adultprice,lsp.childprice,lsp.childnobedprice,lsp.number,";
		$sql.="SUM(dingnum) AS total_dingnum,SUM(childnum) AS total_childnum,";
		$sql.="us.cityname as startplace,SUM(childnobednum) AS total_childnobednum ";
		$sql.="from  b_single_affiliated as sa ";
		$sql.="left join u_line as l on sa.line_id=l.id ";	
		$sql.="left join u_line_suit_price as lsp on lsp.lineid=l.id ";	
		$sql.="left join u_supplier as s on l.supplier_id=s.id ";
		$sql.="left join u_line_startplace as ls on ls.line_id=l.id ";
		$sql.="left join u_startplace as us on ls.startplace_id=us.id ";	
		$sql.="LEFT JOIN u_member_order mo ON lsp.`suitid`=mo.`suitid` AND mo.`usedate`=lsp.`day` AND mo.productautoid=l.id ";	
		$sql.=" where	(l.line_kind=3 or l.line_kind=2) {$where_str} and (l.supplier_id={$where['supplier_id']})  group by sa.id ";		
		$sql.="order by sa.id desc";

		$return['rows']=$this->db->query($sql)->num_rows();
	
		if(!empty($page_size))
		$sql=$sql." limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
	
		$return['sql']=$sql;
	
		return $return;
	}
	//供应商联盟
	function get_company_supplier($supplier_id){
		$sql="SELECT * from b_company_supplier where supplier_id={$supplier_id} and status=1 order by id desc ";
		$return=$this->db->query($sql)->row_array();
		return $return;
	}

	/*
	 * 单项产品详情
	 * */
	public function single_detail($id)
	{
		$sql="
				select 
						sa.*,d.kindname as dest_name,l.linecode,l.overcity2,l.supplier_id,l.linename,l.book_notice,ra.server_name,s.company_name,
				        lsp.number,lsp.day,lsp.adultprice,lsp.adultprofit,lsp.childprice,lsp.childprofit,lsp.childnobedprice,
				        lsp.childnobedprofit,lsp.oldprice,lsp.oldprofit,
				        ba.type,ba.object,ba.agent_rate,ba.adult as adult_agent,ba.old as old_agent,ba.child as child_agent,ba.childnobed as childnobed_agent,l.status,l.line_kind,
				        (select us.cityname from u_line_startplace as ls left join u_startplace as us on us.id=ls.startplace_id where ls.line_id=sa.line_id) as startplace,
				        (select startplace_id from u_line_startplace where line_id=sa.line_id) as startplace_id
				from 
					    b_single_affiliated as sa
				        left join u_line as l on l.id=sa.line_id
				        left join u_line_suit_price as lsp on lsp.lineid=sa.line_id
				        left join b_single_agent as ba on ba.line_id=sa.line_id
				        left join u_supplier as s on s.id=l.supplier_id
				        left join b_server_range as ra on ra.id=sa.server_range
				        left join u_dest_base as d on d.id=l.overcity2
				where 
					    sa.id='{$id}'
			 ";
		$output=$this->db->query($sql)->row_array();
		return $output;
	}
}