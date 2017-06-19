<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_depart_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_depart' );
	}
	
	public function getDepartInData($ids ,$level)
	{
		$sql = 'select * from b_depart where id in ('.$ids.') and level='.$level;
		return $this ->db ->query($sql) ->row_array();
	}
	
	public function getDepartLike($name)
	{
		$sql = 'select * from b_depart where name like "%'.$name.'%"';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取营业部上级的数据
	 * @param unknown $departId
	 */
	public function getDepartParent($departId)
	{
		$sql = 'select p.* from b_depart as d left join b_depart as p on p.id=d.pid where d.id='.$departId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取所有一级营业部
	 * @author jkr
	 */
	public function getDepartTop()
	{
		$sql = 'select d.name as depart_name,d.id as depart_id,u.union_name,d.union_id from b_depart as d left join b_union as u on u.id=d.union_id where d.status=1 and d.pid =0';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取营业部及下级营业部销售人员
	 * @author jkr
	 */
	public function getDepartExpert($departId)
	{
		$sql = 'select e.realname as expert_name,e.nickname,e.id as expert_id from b_depart as d left join u_expert as e on e.depart_id = d.id where (d.id='.$departId.' or d.pid ='.$departId.') and e.status=2';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 统计营业部人数
	 * @author jkr
	 */
	public function countDepartPeople($whereArr ,$sqlWhere)
	{
		$sql = 'select d.name as depart_name,mo.item_code,agent_fee,dingnum,childnum,childnobednum,oldnum,mo.productname as linename,mo.expert_id,e.realname as expert_name from b_depart as d left join u_member_order as mo on mo.depart_id = d.id left join u_expert as e on e.id=mo.expert_id left join u_line as l on l.id=mo.productautoid ';
		
		return $this ->getCommonData($sql ,$whereArr ,'mo.usedate asc' ,'' ,$sqlWhere ,'all');
	}
	
	
	/**
	 * 获取当前旅行社下的营业部
	 * @param:  联盟单位id
	 *
	 * */
	public function depart_list($where,$from="",$page_size="10")
	{
		$where=$this->sql_check($where);
	
		//where条件
		$where_str="";
		if(isset($where['name']))
			$where_str.=" and d.name like '%{$where['name']}%'";
		if(isset($where['small_value']))
			$where_str.=" and d.cash_limit >='{$where['small_value']}'";
		if(isset($where['big_value']))
			$where_str.=" and d.cash_limit <='{$where['big_value']}'";
		if(isset($where['status']))
			$where_str.=" and d.status ='{$where['status']}'";
		if(isset($where['pid'])==true&&@$where['pid']!="-1")
			$where_str.=" and d.pid ='{$where['pid']}'";
		
	
	
		$sql="
		select
				d.*,d2.name as pname2,d3.name as pname3,d4.name as pname4
		from 
				b_depart as d
				left join b_depart as d2 on d2.id=d.pid
				left join b_depart as d3 on d3.id=d2.pid
				left join b_depart as d4 on d4.id=d3.pid
		where
		d.union_id='{$where['union_id']}' {$where_str}
		";
	
		$sql.="order by d.addtime desc";
	
		$return['rows']=$this->db->query($sql)->num_rows();
		if(!empty($page_size))
		$sql.=" limit {$from},{$page_size}";
		$return['result']=$this->db->query($sql)->result_array();
		$return['sql']=$sql;
	
		return $return;
	}
	/**
	 * 营业部详情
	 *
	 * */
	public function depart_detail($id)
	{
	
		$sql="
				select 
						d.*,d2.name as pname,db.bankcard,db.bankname,db.branch,e.realname
				from 
					    b_depart as d 
						left join b_depart as d2 on d2.id=d.pid
				        left join b_depart_bank as db on db.depart_id=d.id
				        left join b_employee as e on e.id=d.finance_id
				where d.id='{$id}'
		    ";
		
		$result=$this->db->query($sql)->row_array();
	
		return $result;
	}
	/**
	 * 获取所有的营业部
	 * 
	 * */
	public function all_depart($where=array())
	{
	
		$sql="
				select id,pid as pId,name,level,0 as open from b_depart where status=1 
		    ";
		if(!empty($where['union_id']))
			$sql.=" and union_id='{$where['union_id']}'";
		if(!empty($where['level']))
			$sql.=" and level<='{$where['level']}'";
		if(!empty($where['content']))
			$sql.=" and name like '%{$where['content']}%'";
		
		$result=$this->db->query($sql)->result_array();
		array_push($result,array('id'=>'0','name'=>'顶层','level'=>'1','pId'=>"-1",'open'=>'1','child_num'=>'1','expert_num'=>'1'));
		
		//上级
		$result2=array();
		$pid_in="";
		if(!empty($result))
		{
			foreach ($result as $k=>$v)
			{
				$pid_in=$v['pId'].",".$pid_in;
			}
			$pid_in=substr($pid_in, 0,-1);
			$pid_in="(".$pid_in.")";
			$sql2="select id,pid as pId,name,level,1 as open from b_depart where status=1 and id in".$pid_in;
			$result2=$this->db->query($sql2)->result_array();
		}
		
		if(empty($where['content']))   return array_merge($result);
		else return array_merge($result,$result2);
		
	}
	/**
	 * 获取所有的营业部和管家
	 *
	 * */
	public function all_depart_expert($where=array())
	{
	
		$sql=" select d.id,d.pid as pId,CONCAT(d.name,'(',d.linkman,')') as name,d.level as jibie,d.cash_limit,d.credit_limit,case when d.pid=0 then 0 else 0 end as open,";
		$sql.="	(select count(1) from u_expert where depart_id=d.id and status=2) expert_num,";
		$sql.=" (select count(1) from b_depart where pid=d.id and status=1) child_num, ";
		$sql.="	CASE WHEN d.id > 0 THEN 'depart_id' ELSE 'depart_id' END AS type,d2.id as ppid ";
		$sql.=" from b_depart as d LEFT JOIN b_depart AS d2 ON d2.id = d.pid where d.status=1 ";	        

		if(!empty($where['union_id']))
			$sql.=" and d.union_id='{$where['union_id']}'";
		if(!empty($where['level']))
			$sql.=" and d.level<='{$where['level']}'";
		if(!empty($where['content']))
			$sql.=" and (d.name like '%{$where['content']}%' or d.linkman like '%{$where['content']}%')";

		$result=$this->db->query($sql)->result_array();
		
        //
		$expert_sql=" select id,case when depart_id is null then 0 else depart_id end as pId,nickname as name,3 as jibie,0 as open, ";
		$expert_sql.="0 as child_num,0 as expert_num , CASE WHEN id > 0 THEN 'expert_id' ELSE 'expert_id' END AS type ";
		$expert_sql.=" from u_expert where union_status=1 and union_id='{$where['union_id']}' ";
		
		$depart_list="";
		$depart_ppid="";
		if(!empty($result))
		{
			foreach ($result as $k=>$v)
			{
				$depart_list=$v['id'].",".$depart_list;
				
				if($v['ppid']!="")
				$depart_ppid=$v['ppid'].",".$depart_ppid;
			}
		}
		
		
		if(!empty($depart_list))
		{
			$depart_list=substr($depart_list, 0,-1);
			$depart_in="(".$depart_list.")";
			$expert_sql.=" and depart_id in ".$depart_in;
		}
		if(!empty($depart_ppid))
		{
			$depart_ppid=substr($depart_ppid, 0,-1);
			
			$depart_ppid_in="(".$depart_ppid.")";
		}
		//var_dump($expert_sql);
		if(empty($result))
			$expert=array();
		else 
		    $expert=$this->db->query($expert_sql)->result_array();//$result[9]=array('id'=>'20','pId'=>'4','jibie'=>'3','cash_limit'=>'500','name'=>'销售','open'=>'0');
		
		//一级
		$result2=array();
		$sql2=" select d.id,pid as pId,CONCAT(d.name,'(',d.linkman,')') as name,level as jibie,d.cash_limit,d.credit_limit,case when d.pid=0 then 0 else 0 end as open,";
		$sql2.="	(select count(1) from u_expert where depart_id=d.id and status=2) expert_num,";
		$sql2.=" (select count(1) from b_depart where pid=d.id and status=1) child_num, ";
		$sql2.="	CASE WHEN d.id > 0 THEN 'depart_id' ELSE 'depart_id' END AS type ";
		$sql2.=" from b_depart as d  where d.status=1 ";
		
		if(!empty($where['union_id']))
			$sql2.=" and d.union_id='{$where['union_id']}'";
		if(!empty($where['level']))
			$sql2.=" and d.level<='{$where['level']}'";
		if(!empty($depart_ppid)&&!empty($where['content']))
		{
			$sql2.=" and d.id in".$depart_ppid_in;
			$result2=$this->db->query($sql2)->result_array();
		}
		
		$return=array_merge($result,$result2,$expert);
		
		return $return;
	}
	/**
	 * 获取所有的营业部和管家和帮游管家
	 * @xml
	 * */
	public function showDepartExpert($where=array())
	{

		//联盟旅行社	
		$expert=array();
		$sql="select  b.id,b.union_name as name,0 as level,CASE WHEN b.id > 0 THEN 'union' ELSE 'union' END AS type   from b_company_supplier as bcs left join b_union as b on bcs.union_id=b.id ";
		$sql .=" where bcs.supplier_id={$where['supplier_id']} and bcs.status=1 and b.status=1 "; 
	        	$union=$this ->db ->query($sql ) ->result_array();
		//echo $this->db->last_query();
	        	$expert=array();
	        //	$where ='';
	        	$Twhere='';
	        	$return=array();
	        	$unionArr=array();
	       	 if(!empty($union[0])){
	       	  	foreach ($union as $key => $value) {

				$key=-($key+3);
				//营业部门
				if(empty($where['content'])){
					$unionArr[0]=array('id'=>$key,'name'=>$value['name'],'level'=>'1','pId'=>$key,'type'=>'union','open'=>1);
				}
				$sql=" select d.id,CASE WHEN d.level > 1 THEN d.pId ELSE {$key} END AS pId,d.name,d.level ,case when d.pid=0 then 0 else 0 end as open,";
				$sql.="	(select count(1) from u_expert where depart_id=d.id and status=2) expert_num,";
				$sql.=" (select count(1) from b_depart where pid=d.id and status=1) child_num, ";
				$sql.="	CASE WHEN d.id > 0 THEN 'depart_id' ELSE 'depart_id' END AS type,d2.id as ppid ";
				$sql.=" from b_depart as d LEFT JOIN b_depart AS d2 ON d2.id = d.pid where d.status=1 ";	        

				if(!empty($value['id']))
					$sql.=" and d.union_id='{$value['id']}'";
				if(!empty($where['level']))
					$sql.=" and d.level<='{$where['level']}'";
				if(!empty($where['content']))
					$sql.=" and (d.name like '%{$where['content']}%' )";

				$result=$this->db->query($sql)->result_array();	
		        //
				$expert_sql=" select 0 as id,id as expertid,case when depart_id is null then 0 else depart_id end as pId,realname as name,0 as level ,0 as open, ";
				$expert_sql.="0 as child_num,0 as expert_num , CASE WHEN id > 0 THEN 'expert_id' ELSE 'expert_id' END AS type,depart_id as departId ";
				$expert_sql.=" from u_expert where union_status=1 and union_id='{$value['id']}' ";
				
				$depart_list="";
				$depart_ppid="";
				if(!empty($result))
				{
					foreach ($result as $k=>$v)
					{
						$depart_list=$v['id'].",".$depart_list;
						
						if($v['ppid']!="")
						$depart_ppid=$v['ppid'].",".$depart_ppid;
					}
				}
				
				
				if(!empty($depart_list))
				{
					$depart_list=substr($depart_list, 0,-1);
					$depart_in="(".$depart_list.")";
					$expert_sql.=" and depart_id in ".$depart_in;
				}
				if(!empty($depart_ppid))
				{
					$depart_ppid=substr($depart_ppid, 0,-1);
					
					$depart_ppid_in="(".$depart_ppid.")";
				}
				$expertAD=array();
				if(empty($result)){

					if(!empty($where['content'])){	  //管家搜素					
						$expert_sql.=" and (realname like '%{$where['content']}%' )";
						$expertAD=$this->db->query($expert_sql)->result_array();
						foreach ($expertAD as $k => $v) {
					    	  	$expertAD[$k]['id']=$expertAD[$k]['expertid'];
					    	}	
					}					

				}else {
	
					if(!empty($where['content'])){ //营业部和管家搜素
					    	$expert=$this->db->query($expert_sql)->result_array();
					    	foreach ($expert as $k => $v) {
					    	  	$expert[$k]['id']=$expert[$k]['expertid'];
					    	}
					}else{
					    	$expert=$this->db->query($expert_sql)->result_array();	
					}
				}
				
				//一级
				$result2=array();
				$sql2=" select d.id,pid as pId,d.linkman,d.name,level,case when d.pid=0 then 0 else 0 end as open,";
				$sql2.="(select count(1) from u_expert where depart_id=d.id and status=2) expert_num,";
				$sql2.=" (select count(1) from b_depart where pid=d.id and status=1) child_num, ";
				$sql2.=" CASE WHEN d.id > 0 THEN 'depart_id' ELSE 'depart_id' END AS type ";
				$sql2.=" from b_depart as d  where d.status=1 ";
				
				if(!empty($value['id']))
					$sql2.=" and d.union_id='{$value['id']}'";
				if(!empty($where['level']))
					$sql2.=" and d.level<='{$where['level']}'";
				if(!empty($depart_ppid)&&!empty($where['content']))
				{  //营业部搜索
					$sql2.=" and d.id in".$depart_ppid_in;
					$result2=$this->db->query($sql2)->result_array();
				}
				if(!empty($expertAD)){  //管家搜索

					$de_list='';
					foreach ($expertAD as $k=>$v)
					{
						$de_list=$v['pId'].",".$de_list;	
					}
					if(!empty($depart_ppid)&&!empty($where['content']))
					{
						if(!empty($de_list)){
							$de_list=substr($de_list, 0,-1);
							$de_list_in="(".$de_list.")";
							$sql2.=" and ( (d.id in".$de_list_in.") or  (d.id in".$depart_ppid_in."))";
							
							$result2=$this->db->query($sql2)->result_array();	
						}else{
							$sql2.=" and d.id in".$depart_ppid_in;
							$result2=$this->db->query($sql2)->result_array();	
						}	
					}else{
						if(!empty($de_list)){
							$de_list=substr($de_list, 0,-1);
							$de_list_in="(".$de_list.")";
							$sql2.=" and d.id in".$de_list_in;
							
							$result2=$this->db->query($sql2)->result_array();	
						}
					}
					
				}
				$return=array_merge($unionArr,$result,$result2,$expert,$expertAD,$return);
				
				//return $return;
	       	  	}
	       	}
	       			

				//帮游管家
				$e_sql=" select id as e_id,-2 as id,case when id is null then -1 else -1 end as pId,concat(realname,'(',nickname,')') as name,";
				$e_sql.=" CASE WHEN id > 0 THEN 'b_expert_id' ELSE 'b_expert_id' END AS type, ";
				$e_sql.="case when depart_id is null then 0 else depart_id end as departId ";
				$e_sql.=" from u_expert where status=2 ";
				if(!empty($where['content'])){
					$e_sql.=" and (realname like '%{$where['content']}%' or nickname like '%{$where['content']}%') ";
				}
				$b_expert=$this->db->query($e_sql)->result_array();
				$resultArr=array();	
				if(!empty($b_expert)){
				   if(!empty($where['content'])){
				       //帮游网
				       $resultArr[0]=array('id'=>'-1','pId'=>'-1','name'=>'帮游管家','child_num'=>1,'type'=>'bangu','open'=>1);
				   }else{
				       //帮游网
				       $resultArr[0]=array('id'=>'-1','pId'=>'-1','name'=>'帮游管家','child_num'=>1,'type'=>'bangu');
				   }	
				}
				//echo $this->db->last_query();
				$return=array_merge($return,$resultArr,$b_expert);
				$return=$return;
	       

		
		return $return;
	}
	/**
	 * @method 获取营业部数据,用于平台额度查询
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getDepartQuotaData(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select * from b_depart ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}

	/**
	 * 获取所有的旅行社下的管家 @xml
	 *
	 * */
	public function get_union_expert($where=array())
	{

		//联盟旅行社
		$expert=array();
		$sql="select  b.id,b.union_name as name,0 as level,CASE WHEN b.id > 0 THEN 'union' ELSE 'union' END AS type   from b_company_supplier as bcs left join b_union as b on bcs.union_id=b.id ";
		$sql .=" where bcs.supplier_id={$where['supplier_id']} and bcs.status=1 and b.status=1 ";
		$union=$this ->db ->query($sql ) ->result_array();
		$expert=array();
		$Twhere='';
		$return=array();
		$unionArr=array();
		if(!empty($union[0])){
			foreach ($union as $key => $value) {
					
				$key=-($key+3);
				//营业部门
				if(empty($where['content'])){
					$unionArr[0]=array('id'=>$key,'union_id'=>$value['id'],'name'=>$value['name'],'level'=>'1','pId'=>$key,'type'=>'union','open'=>1);
				}
				$sql=" select d.id,CASE WHEN d.level > 1 THEN d.pId ELSE {$key} END AS pId,d.name,d.level ,case when d.pid=0 then 0 else 0 end as open,";
				$sql.="	(select count(1) from u_expert where depart_id=d.id and union_status=1) expert_num,";
				$sql.=" (select count(1) from b_depart where pid=d.id and status=1) child_num,";
				$sql.="	CASE WHEN d.id > 0 THEN 'depart_id' ELSE 'depart_id' END AS type,d2.id as ppid ";
				$sql.=" from b_depart as d LEFT JOIN b_depart AS d2 ON d2.id = d.pid where d.status=1 ";
					
				if(!empty($value['id']))
					$sql.=" and d.union_id='{$value['id']}'";
				if(!empty($where['level']))
					$sql.=" and d.level<='{$where['level']}'";
				if(!empty($where['content']))
					$sql.=" and (d.name like '%{$where['content']}%' )";
					
				$result=$this->db->query($sql)->result_array();
				//
				$expert_sql=" select 0 as id,id as expertid,case when depart_id is null then 0 else depart_id end as pId,realname as name,0 as level ,0 as open, ";
				$expert_sql.="0 as child_num,0 as expert_num , CASE WHEN id > 0 THEN 'expert_id' ELSE 'expert_id' END AS type,depart_id as departId ";
				$expert_sql.=" from u_expert where union_status=1 and union_id='{$value['id']}' ";
					
				$depart_list="";
				$depart_ppid="";
				if(!empty($result))
				{
					foreach ($result as $k=>$v)
					{
						$depart_list=$v['id'].",".$depart_list;
		
						if($v['ppid']!="")
							$depart_ppid=$v['ppid'].",".$depart_ppid;
					}
				}
					
					
				if(!empty($depart_list))
				{
					$depart_list=substr($depart_list, 0,-1);
					$depart_in="(".$depart_list.")";
					$expert_sql.=" and depart_id in ".$depart_in;
				}
				if(!empty($depart_ppid))
				{
					$depart_ppid=substr($depart_ppid, 0,-1);
						
					$depart_ppid_in="(".$depart_ppid.")";
				}
				$expertAD=array();
				if(empty($result)){
						
					if(!empty($where['content'])){	  //管家搜素
						$expert_sql.=" and (realname like '%{$where['content']}%' )";
						$expertAD=$this->db->query($expert_sql)->result_array();
						foreach ($expertAD as $k => $v) {
							$expertAD[$k]['id']=$expertAD[$k]['expertid'];
						}
					}
						
				}else {
						
					if(!empty($where['content'])){ //营业部和管家搜素
						$expert=$this->db->query($expert_sql)->result_array();
						foreach ($expert as $k => $v) {
							$expert[$k]['id']=$expert[$k]['expertid'];
						}
					}else{
						$expert=$this->db->query($expert_sql)->result_array();
					}
				}
					
				//一级
				$result2=array();
				$sql2=" select d.id,pid as pId,d.linkman,d.name,level,case when d.pid=0 then 1 else 1 end as open,";
				$sql2.="(select count(1) from u_expert where depart_id=d.id and status=2) expert_num,";
				$sql2.=" (select count(1) from b_depart where pid=d.id and status=1) child_num, ";
				$sql2.=" CASE WHEN d.id > 0 THEN 'depart_id' ELSE 'depart_id' END AS type ";
				$sql2.=" from b_depart as d  where d.status=1 ";
					
				if(!empty($value['id']))
					$sql2.=" and d.union_id='{$value['id']}'";
				if(!empty($where['level']))
					$sql2.=" and d.level<='{$where['level']}'";
				if(!empty($depart_ppid)&&!empty($where['content']))
				{  //营业部搜索
					$sql2.=" and d.id in".$depart_ppid_in;
					$result2=$this->db->query($sql2)->result_array();
				}
				if(!empty($expertAD)){  //管家搜索
						
					$de_list='';
					foreach ($expertAD as $k=>$v)
					{
						$de_list=$v['pId'].",".$de_list;
					}
					if(!empty($depart_ppid)&&!empty($where['content']))
					{
						if(!empty($de_list)){
							$de_list=substr($de_list, 0,-1);
							$de_list_in="(".$de_list.")";
							$sql2.=" and ( (d.id in".$de_list_in.") or  (d.id in".$depart_ppid_in."))";
		
							$result2=$this->db->query($sql2)->result_array();
						}else{
							$sql2.=" and d.id in".$depart_ppid_in;
							$result2=$this->db->query($sql2)->result_array();
						}
					}else{
						if(!empty($de_list)){
							$de_list=substr($de_list, 0,-1);
							$de_list_in="(".$de_list.")";
							$sql2.=" and d.id in".$de_list_in;
		
							$result2=$this->db->query($sql2)->result_array();
						}
					}
						
				}
				$return=array_merge($unionArr,$result,$result2,$expert,$expertAD,$return);
		
			}
		}
		
		return $return;
		
	}
	/**
	 * @method 获取帮游管家数据
	 * @author xml
	 * @param array $whereArr
	 */
	function get_c_expert($where){
		//帮游管家
		$e_sql=" select id,concat(realname,'(',nickname,')') as name,nickname,realname,";
		$e_sql.=" CASE WHEN id > 0 THEN 'b_expert_id' ELSE 'b_expert_id' END AS type, ";
		$e_sql.="case when depart_id is null then 0 else depart_id end as departId ";
		$e_sql.=" from u_expert where status=2 ";
		if(!empty($where['content'])){
			$e_sql.=" and (realname like '%{$where['content']}%') or (nickname like '%{$where['content']}%') ";
		}
		$b_expert=$this->db->query($e_sql)->result_array();
		return $b_expert;
	}
}