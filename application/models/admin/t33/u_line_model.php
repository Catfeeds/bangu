<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'u_line' );
	}
	
	/**
	 * @method 获取线路信息
	 * @author jkr
	 * @param unknown $unionLineId 
	 */
	public function getUnionLineRow($unionLineId)
	{
		$sql = 'select l.id from u_line as l left join b_union_approve_line as bl on bl.line_id = l.id where bl.id='.$unionLineId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * 按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function line_all($where,$from="",$page_size="10")
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
		if(isset($where['days_start']))
			$where_str.=" and l.lineday >='{$where['days_start']}'";
		if(isset($where['days_end']))
			$where_str.=" and l.lineday <='{$where['days_end']}'";
		if(isset($where['price_start']))
			$where_str.=" and l.lineprice >='{$where['price_start']}'";
		if(isset($where['price_end']))
			$where_str.=" and l.lineprice <='{$where['price_end']}'";
		if(isset($where['starttime']))
			$where_str.=" and l.online_time >='{$where['starttime']}'";
		if(isset($where['endtime']))
			$where_str.=" and l.online_time <='{$where['endtime']}'";
		if(isset($where['dest_id']))
			$where_str.=" and (find_in_set({$where['dest_id']},l.overcity)>0)";
		if(isset($where['line_classify']))
			$where_str.=" and l.line_classify ='{$where['line_classify']}'";
		if(isset($where['linkman']))
			$where_str.=" and s.linkman like '%{$where['linkman']}%'";
		
		if(isset($where['startplace']))
			$where_str.=" and sp.cityname like '%{$where['startplace']}%'";
		
		
		//是直属供应商  + 状态
		if($where['type']=="1")
			$where_str.=" and pl.status=1 and l.supplier_id in(select supplier_id from b_company_supplier where union_id = '{$where['union_id']}' and status=1)";
		elseif($where['type']=="2")
		    $where_str.=" and pl.status=2 and l.supplier_id in(select supplier_id from b_company_supplier where union_id = '{$where['union_id']}' and status=1)";
		elseif($where['type']=="3")
			$where_str.=" and pl.status=3 and l.supplier_id in(select supplier_id from b_company_supplier where union_id = '{$where['union_id']}' and status=1)";
		

		$sql="
	
		select
				l.id,l.linecode,pl.online_time,l.modtime,a.realname as admin_name,l.lineprice,pl.supplier_id,pl.id as pl_id,pl.remark,
				l.linename,s.brand,s.company_name,s.linkman,pl.status,l.lineday,l.linebefore,l.linetitle,
				 (select group_concat(us.cityname) from u_line_startplace as ls left join u_startplace as us on ls.startplace_id=us.id where ls.line_id=l.id) as startplace
			   
	
		from
				b_union_approve_line as pl
				left join u_line as l on pl.line_id=l.id 
				left join u_supplier as s on pl.supplier_id=s.id
				
				left join u_admin as a on a.id=l.admin_id
				
	
		where
		pl.union_id={$where['union_id']} {$where_str}
		
		group by pl.line_id
	
		";
	
		$sql.="order by pl.modtime desc";

		$return['rows']=$this->db->query($sql)->num_rows();
	 
		if(!empty($page_size))
		$sql=$sql." limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
	
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * (废弃)按出团日期显示
	 * @param:  联盟单位id
	 *
	 * */
	public function line_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['linename']))
			$where_str.=" and l.linename like '%{$where['linename']}%'";
		if(isset($where['linecode']))
			$where_str.=" and l.linecode like '%{$where['linecode']}%'";
		if(isset($where['days_start']))
			$where_str.=" and l.lineday >='{$where['days_start']}'";
		if(isset($where['days_end']))
			$where_str.=" and l.lineday <='{$where['days_end']}'";
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
		if(isset($where['team_code']))
			$where_str.=" and lsp.description like '%{$where['team_code']}%'";
		
		if(isset($where['startplace']))
			$where_str.=" and sp.cityname like '%{$where['startplace']}%'";
		
		
		//是否直属供应商
		if($where['type']=="1") //是
			$where_str.=" and lsp.lineid in(select line_id from b_union_approve_line where union_id = '{$where['union_id']}' and status=2 and supplier_id in (select supplier_id from b_company_supplier where union_id = '{$where['union_id']}' and status=1))";
		elseif($where['type']=="2") //不是
			$where_str.=" and lsp.lineid in(select line_id from b_union_approve_line where  status=2 and supplier_id not in (select supplier_id from b_company_supplier where union_id = '{$where['union_id']}' and status=1))";
		
		$date=date("Y-m-d");
		//1、sql1
		$sql1="
			
						select
								count(lsp.day) as total_rows
						from 
								u_line_suit_price as lsp
								left join u_line as l on l.id=lsp.lineid
								left join u_supplier as s on l.supplier_id=s.id
								LEFT JOIN u_line_startplace as ls on ls.line_id=l.id
							    left join u_startplace as sp on sp.id=ls.startplace_id 
					    where
					    	    lsp. DAY >= '{$date}' and lsp.is_open=1 {$where_str}
					
				
		";
		$result1=$this->db->query($sql1)->row_array();
		$total_rows=$result1['total_rows']; //总数
		
		//2、sql2
		$sql2="
					select
							lsp.dayid
					from
							u_line_suit_price as lsp
							left join u_line as l on l.id=lsp.lineid
							left join u_supplier as s on l.supplier_id=s.id
							LEFT JOIN u_line_startplace as ls on ls.line_id=l.id
							left join u_startplace as sp on sp.id=ls.startplace_id 
					where
							lsp. DAY >= '{$date}' and lsp.is_open=1 {$where_str}
		            order by lsp.day 
                    limit {$from},{$page_size}
                    
		";
		$result2=$this->db->query($sql2)->result_array();//结果1
		$str="";
		if(!empty($result2))
		{
			foreach ($result2 as $m=>$n)
			{
				if(($m+1)==count($result2))
					$str.=$n['dayid'];
				else
					$str.=$n['dayid'].",";
		
			}
		}
		else
		{
			$str="0";
		}
		$str='('.$str.')';  //拼接成字符串
		
		//3、sql3
		
		$sql3="

		select
				lsp.dayid as id,lsp.lineid,lsp.day,lsp.description as team_code,lsp.adultprice,lsp.room_fee,lsp.oldprice,lsp.childnobedprice,lsp.childprice,number,
				l.linename,s.company_name,s.company_name,l.status,l.lineday,l.linebefore,
				SUM(dingnum) AS total_dingnum,SUM(oldnum) AS total_oldnum,SUM(childnum) AS total_childnum,SUM(childnobednum) AS total_childnobednum,
				(SELECT group_concat(us.cityname) from u_line_startplace as ls LEFT JOIN u_startplace as us on ls.startplace_id=us.id where ls.line_id=lsp.lineid) as startplace,
				 s.linkman,s.id as supplier_id
		
		from
				u_line_suit_price as lsp
				left join u_line as l on l.id=lsp.lineid
				left join u_supplier as s on l.supplier_id=s.id
				
				LEFT JOIN u_member_order mo ON lsp.`suitid`=mo.`suitid` AND mo.`usedate`=lsp.`day`
				
		where
				lsp.dayId IN {$str}
		 GROUP BY lsp.dayid	
		order by lsp.day 
		
		";
	
	    $result3=$this->db->query($sql3)->result_array();
		//var_dump($sql3);
		
		$return['result']=$result3;
		$return['rows']=$total_rows;
		$return['sql1']=$sql1;
		$return['sql2']=$sql2;
		$return['sql3']=$sql3;
	
		return $return;
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
		//
		$kind_str=" (l.line_kind=2 or l.line_kind=3)";
		if((isset($where['type'])&&$where['type']=="2")||(isset($where['type'])&&$where['type']=="1")) //type=1或2  status=2
		{
			$where_str.=" and l.status=2";
			if($where['type']=="1")
				$kind_str="l.line_kind=3";
			else if($where['type']=="2")
				$kind_str="l.line_kind=2";
		}
		
		if(isset($where['type'])&&$where['type']=="3")
			$where_str.=" and (l.status=3 or l.status=4)";
		
		//1、查总数
		$sql="
	
		select
			sa.*,l.linecode,l.online_time,l.modtime,l.lineprice,l.supplier_id,
			l.linename,s.brand,s.company_name,l.lineday,l.linebefore,l.status,lsp.day,lsp.oldprice,lsp.adultprice,lsp.childprice,lsp.childnobedprice,lsp.number,
			us.cityname as startplace,
			SUM(dingnum) AS total_dingnum,SUM(oldnum) AS total_oldnum,SUM(childnum) AS total_childnum,SUM(childnobednum) AS total_childnobednum,
            bsa.id as single_agent_id
		from
			b_single_affiliated as sa
			left join u_line as l on sa.line_id=l.id
			left join u_line_suit_price as lsp on lsp.lineid=l.id
			left join u_supplier as s on l.supplier_id=s.id
			left join u_line_startplace as ls on ls.line_id=l.id
			left join u_startplace as us on ls.startplace_id=us.id
			LEFT JOIN u_member_order mo ON lsp.`suitid`=mo.`suitid` AND mo.`usedate`=lsp.`day` AND mo.productautoid=l.id
			left join b_single_agent as bsa on bsa.line_id=l.id

		where
				{$kind_str} {$where_str} 
	    
		";
		//and sa.union_id={$where['union_id']}
		$union_supplier=$this->db->query("select supplier_id from b_company_supplier where union_id={$where['union_id']} and status=1")->result_array();
		$supplier_str="";
		if(!empty($union_supplier))
		{
			foreach($union_supplier as $k=>$v)
			{
				$supplier_str=$v['supplier_id'].",".$supplier_str;
			}
		}
		
		if(!empty($supplier_str))
		{
			$supplier_str=substr($supplier_str, 0,-1);
			$supplier_in="(".$supplier_str.")";
			$sql.=" and l.supplier_id in".$supplier_in;
		} 
		$sql.=" group by sa.id order by sa.id desc";  //and sa.union_id={$where['union_id']}

		$return['rows']=$this->db->query($sql)->num_rows();
	    //var_dump($sql);
		if(!empty($page_size))
		$sql=$sql." limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
	
		$return['sql']=$sql;
	
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
	 * 轮播图
	 *
	 * */
	public function lunbo($line_id)
	{
		$sql="
			select
					lp.*,la.filepath
			from
				    u_line_pic as lp 
					left join u_line_album as la on lp.line_album_id=la.id
			where
					lp.line_id='{$line_id}'
		";
		$result=$this->db->query($sql)->result_array();
	    return $result;
	}
	
	/**
	 * 旅行社审核对应供应商下的线路
	 *
	 * */
	public function approve_line($supplier_id,$union_id,$line_id)
	{
		$sql="
		select
				*
		from
				b_union_approve_line
		where
				supplier_id='{$supplier_id}' and union_id='{$union_id}' and line_id='{$line_id}'
		";
		$result=$this->db->query($sql)->row_array();
	
		return $result;
	}
	/**
	 * 审核通过或者拒绝
	 *
	 * */
	function approve_ok($dataArr, $whereArr)
	{
		
		$this->db->where($whereArr);
		$this->db->update("b_union_approve_line", $dataArr);
		
		$num=$this->db->affected_rows();
		
		return $num;
		
	}
	/**
	 * 审核通过或者拒绝
	 *
	 * */
	function approve_row($id,$union_id)
	{
	    $sql="select al.id,al.line_id,l.producttype,l.status,al.online_time,l.online_time as lonline_time from b_union_approve_line as al left join u_line as l on l.id=al.line_id where union_id={$union_id} and  al.id=".$id;
		return $this->db->query($sql)->row_array();
	
	}
	/**
	 * 线路对应旅行社下：人头费(按人群、比例)
	 *
	 * */
	public function line_agent($supplier_id,$union_id,$type="1")
	{
		$sql="
		select
		 		*
		from
			    b_union_line_agent
		where
				supplier_id='{$supplier_id}' and union_id='{$union_id}' and agent_type={$type}
		";
		$result=$this->db->query($sql)->row_array();
		
		return $result;
	}
	/**
	 * 线路对应旅行社下：人头费 (按天数)
	 *
	 * */
	public function day_agent($supplier_id,$union_id,$type="1")
	{
		$sql="
		select
				*
		from
				b_union_line_agent_day
		where
				supplier_id='{$supplier_id}' and union_id='{$union_id}' and agent_type={$type}
		";
		$result=$this->db->query($sql)->result_array();
	
		return $result;
	}
	
	
}