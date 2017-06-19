<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:00:11
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pre_Order_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}
    /*
     * 产品预订列表： sql拆分
     * 1、获取总记录行数
     * 2、获取分页的记录数据（只取dayid）
     * 3、根据第二步的id列表取出所有字段
     * */
	public function get_all_product($whereArr=array(), $page = 1, $expert_id,$union_id,$is_zhishu) 
	{
		$today = date('Y-m-d');
		//1、直属供应商  b_union_approve_line
		$count_sql = 'SELECT 
							 COUNT(lsp.dayid) AS data_count 
				      FROM 
							u_line_suit_price AS lsp 
							INNER JOIN u_line AS l ON l.id=lsp.lineid  
							INNER JOIN b_union_approve_line AS aff ON aff.line_id=lsp.lineid AND aff.status=2 AND aff.union_id='.$union_id.' 
						    INNER JOIN u_line_startplace AS ls ON ls.line_id = l.id 
							INNER JOIN u_startplace AS sp ON sp.id = ls.startplace_id
					  WHERE 
							lsp.day >= \''.$today.'\'  AND lsp.is_open=1 ';
		
		$id_sql = 'SELECT  
							dayid 
				   FROM   
							u_line_suit_price AS lsp 
							INNER JOIN u_line AS l ON l.id=lsp.lineid 
							INNER JOIN b_union_approve_line AS aff ON aff.line_id=lsp.lineid AND aff.status=2 AND aff.union_id='.$union_id.' 
							INNER JOIN u_line_startplace AS ls ON ls.line_id = l.id 
							INNER JOIN u_startplace AS sp ON sp.id = ls.startplace_id
				  WHERE 
						    lsp.day >= \' '.$today.' \'  AND lsp.is_open=1 ';
		//2、非直属供应商，重新写sql
		if($is_zhishu!=1){
			$count_sql = 'SELECT COUNT(lsp.dayid) AS data_count FROM u_line_suit_price AS lsp INNER JOIN u_line AS l ON l.id=lsp.lineid  AND l.status=2 WHERE lsp.day >= \''.$today.'\'  AND lsp.is_open=1 ';
			$id_sql = 'SELECT  dayid FROM u_line_suit_price AS lsp INNER JOIN u_line AS l ON l.id=lsp.lineid AND l.status=2 WHERE lsp.day >= \' '.$today.' \'  AND lsp.is_open=1 ';
		}

        //3、拼接 where条件
		$whereStr = '';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				if($key=="overcity"){
					//$whereStr .= ' '.$key.'"'.$val.'" and';
					$whereStr .= ' '.$val.' and';
				}elseif($key=='startplace_id'){
					$count_sql.=" AND ls.startplace_id =".$val;
					$id_sql.=" AND ls.startplace_id =".$val;

				}elseif ($key=='cityname') {
				
					$count_sql.= " AND sp.cityname like '%".$val."%'";
					$id_sql.= " AND sp.cityname like '%".$val."%'";
				}else{
					$whereStr .= ' '.$key.'"'.$val.'" and';
				}
			}
			
		}
		    //var_dump($whereStr);exit();
		if(!empty($whereStr)){
			$whereStr = rtrim($whereStr ,'and');
			$count_sql = $count_sql.' AND '.$whereStr;
			$id_sql = $id_sql.' AND '.$whereStr;
		}
		//4、是否直属供应商
		$supplier_sql = 'SELECT GROUP_CONCAT(supplier_id) AS supplier_id FROM b_company_supplier WHERE union_id='.$union_id.' AND status=1 ';
	    $supplier_id = $this ->db ->query($supplier_sql) ->row_array();
			if($is_zhishu==1){
				$id_sql .= " AND l.`supplier_id`  IN ({$supplier_id['supplier_id']}) ";
				$count_sql .= " AND l.`supplier_id`  IN ({$supplier_id['supplier_id']}) ";
			}else{
				$id_sql .= " AND l.`supplier_id` NOT IN ({$supplier_id['supplier_id']}) ";
				$count_sql .= " AND l.`supplier_id` NOT IN ({$supplier_id['supplier_id']}) ";
			}
		 //5、主sql：第三步sql
	     $sql = "SELECT 
	     				lsp.dayid,lsp.before_day,lsp.hour AS p_hour,lsp.minute AS p_minute,lsp.description AS desp,
	     				lsp.lineid,l.linecode,lsp.`day`,l.linename,CONCAT(s.company_name, '-', s.brand) AS company_name,
	     				s.brand,s.id as supplier_id,lsp.number,suit.suitname, suit.id AS suit_id, {$expert_id} AS eid, 
	     				GROUP_CONCAT(DISTINCT(sp.cityname)) AS startplace, lsp.childprice, lsp.oldprice, lsp.adultprice, 
	     				lsp.childnobedprice, SUM(mo.dingnum) AS total_dingnum,SUM(mo.oldnum) AS total_oldnum,SUM(mo.childnum) AS total_childnum,
	     				SUM(mo.childnobednum) AS total_childnobednum,SUM(mo.suitnum) AS total_suitnum 
	     		 FROM 
	     				u_line_suit_price AS lsp 
	     				LEFT JOIN u_line AS l ON lsp.lineid = l.id  
	     				LEFT JOIN u_line_suit AS suit ON suit.id = lsp.suitid 
	     				LEFT JOIN u_supplier AS s ON s.id = l.supplier_id 
	     				LEFT JOIN u_line_startplace AS ls ON ls.line_id = l.id 
	     				LEFT JOIN u_startplace AS sp ON sp.id = ls.startplace_id 
	     				LEFT JOIN u_member_order mo ON lsp.`suitid`=mo.`suitid` AND mo.`usedate`=lsp.`day` AND mo.`status`!=9 ";
	    
	     $count_rows=$this->db->query($count_sql)->row_array();
	     $page->totalRecords = $count_rows['data_count'];//总行数
	     $page->totalPages = ceil($page->totalRecords / $page->pageSize);// 总页数     + ($totalRecords % $pageSize > 0 ? 1 : 0);
	     $page->pageNum = $page->pageNum;
	     if ($page->pageNum > $page->totalPages){
	     	$page->pageNum = $page->totalPages;
	     }    //第几页

	     $day_ids = '';
		 if ($page->pageNum > 0) 
		 {
		 	//获得ids列表
			$offset = ($page->pageNum-1) * $page->pageSize;
			$id_sql = $id_sql." ORDER BY lsp.day ASC,lsp.dayid limit  $offset,".$page->pageSize;
			$id_res=$this->db->query($id_sql)->result_array();
			if(!empty($id_res)){
				foreach ($id_res as $key => $val) {
					$day_ids .= $val['dayid'].',';
				}
				$day_ids = rtrim($day_ids,',');
			}else{
				$day_ids = 0;
			}
			//主sql的where条件
			$sql .=' WHERE  lsp.dayId IN('.$day_ids.') GROUP BY lsp.dayid ORDER BY lsp.day ASC';
			$result=$this->db->query($sql)->result_array();
			$page->rows =  $result;
			//$page->sql =  $id_sql;
		}
		return $page;
	}

    //获取售卖线路----@xml
    function get_sellLine_product($whereArr=array(), $page = 1, $expert_id,$whereCity){

    	$today = date('Y-m-d',time());
    	$sql="select lsp.before_day,lsp. HOUR AS p_hour,lsp. MINUTE AS p_minute,lsp.dayid,lsp.description AS desp,lsp.lineid,";
    	$sql.="l.linecode,lsp.`day`,l.linename,CONCAT(s.company_name, '-', s.brand) AS company_name,s.brand,s.id AS supplier_id,";
    	$sql.="lsp.number,suit.suitname,suit.id AS suit_id,$expert_id AS eid,";
    	$sql.="lsp.childprice,lsp.oldprice,lsp.adultprice,lsp.childnobedprice,SUM(mo.dingnum) AS total_dingnum,SUM(mo.oldnum) AS total_oldnum,";
    	$sql.="SUM(mo.childnum) AS total_childnum,SUM(mo.childnobednum) AS total_childnobednum,SUM(mo.suitnum) AS total_suitnum";
    	$sql.=" from u_line_apply as lspy  ";
    	$sql.=" left join u_line as l on l.id = lspy.line_id ";
    	$sql.=" left join u_line_suit_price as lsp on lsp.lineid=l.id ";
    	$sql.=" left join u_line_suit AS suit ON suit.id = lsp.suitid";
    	$sql.=" left join u_member_order as mo on lsp.suitid=mo.suitid and lsp.day=mo.usedate ";
    	$sql.="left join u_supplier as s on s.id = l.supplier_id";
    	$sql.=" where lspy.status=2 and lspy.expert_id={$expert_id} and  l.status=2 and lsp.is_open=1 and lsp.day>='{$today}' ";

    	$whereStr = '';
    	if (!empty($whereArr)){

    		foreach($whereArr as $key=>$val){			
    				if($key=="overcity"){
    					$whereStr .= ' '.$val.' and';
    				}else{
    					$whereStr .= ' '.$key.'"'.$val.'" and';
    				}	
    		}

    		if(!empty($whereStr)){
    			$whereStr = rtrim($whereStr ,'and');
    			$whereStr='and'.$whereStr;
    		}
    	}
        //出发城市搜索
    	if(!empty($whereCity['startplace_id'])){
    		$whereStr=$whereStr.'and (select count(id) from u_line_startplace as lst where lst.line_id =l.id and lst.startplace_id='.$whereCity['startplace_id'].')>0 ';
    	}elseif(!empty($whereCity['cityname'])){
    		$citydata=$this->db->query("select id,cityname from u_startplace where cityname like '%{$whereCity['cityname']}%'")->row_array();
    		if(!empty($citydata['id'])){
    			$whereStr=$whereStr.'and (select count(id) from u_line_startplace as lst where lst.line_id =l.id and lst.startplace_id='.$citydata['id'].')>0 ';
    		}
    	} 
    	$count=$this->db->query($sql.$whereStr."GROUP BY lsp.dayid ")->result_array();
    	$data_count=count($count);
    	$page->totalRecords = $data_count;//总记录
    	$page->totalPages = ceil($page->totalRecords / $page->pageSize);// + ($totalRecords % $pageSize > 0 ? 1 : 0);
    	$page->pageNum = $page->pageNum;
    	if ($page->pageNum > $page->totalPages){
    		$page->pageNum = $page->totalPages;
    	}
    	
    	$result=array();
    	if ($page->pageNum > 0) {
    		$offset = ($page->pageNum-1) * $page->pageSize;
    		$sql .=$whereStr." GROUP BY lsp.dayid ORDER BY lsp.day ASC limit  $offset,".$page->pageSize;
    		$query = $this->db->query($sql);
    		$result=$query->result_array();
    		//线路出发城市
    		if(!empty($result)){
    			foreach ($result as $key => $value) {
    				$mysql ='select GROUP_CONCAT(sp.cityname) AS cityname from u_line as l ';
    				$mysql .=' left join  u_line_startplace as  ls on ls.line_id = l.id';
    				$mysql .=' left join u_startplace as sp on sp.id = ls.startplace_id';
    				$mysql .=' where l.id='.$value['lineid'];
    				$mysql .=' group by l.id ';
    				$data=$this ->db ->query($mysql) ->row_array();
    				if(!empty($data['cityname'])){
    					$result[$key]['cityname'] =$data['cityname'];
    				}else{
    					$result[$key]['cityname'] ='';
    				}
    			}
    		}
    		$page->rows =  $result;
    	}

    	
    	return $page;
    	
    }
    /*
     * 部门的现金和信用；若是经理，获得总现金和总信用
     * */
	function get_all_limit(){
		$is_manage = $this->session->userdata('is_manage');
		if($is_manage==1){
			$sql = 'SELECT sum(cash_limit) as cash_limit,sum(credit_limit) as credit_limit FROM b_depart WHERE FIND_IN_SET(\''.$this->session->userdata('depart_id').'\',depart_list) >0';
		}else{
			$sql = 'SELECT cash_limit,credit_limit FROM b_depart WHERE id='.$this->session->userdata('depart_id');
		}
		$row=$this->db->query($sql)->row_array();
		return $row;
		/*$sql = 'SELECT cash_limit ,credit_limit FROM b_depart WHERE id='.$this->session->userdata('depart_id');
		 $total_limit_res = $this->db->query($sql)->result_array();;
		return $total_limit_res[0];*/
		
	}
	/*
	 * 角色：经理
	 * 获得一级部门、子部门
	 * */
	function get_all_depart(){
		$sql = 'SELECT * FROM b_depart WHERE FIND_IN_SET(\''.$this->session->userdata('depart_id').'\',depart_list) >0 order by level asc,id';
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	//表数据
	function sel_table_rowdata($table,$where){
		$this->db->select('*')->where($where)->from($table);
		$result=$this->db->get()->row_array();
		return $result;
	}
	//帮游管家申请线路
	function get_sel_lineData($expert_id){
		$sql = " select lap.* from  u_line_apply as lap left join u_line as l on lap.line_id=l.id  ";
		$sql .= " where  lap.expert_id={$expert_id} and l.status=2 and l.producttype=0 and lap.status=2 ";
		$data = $this->db->query($sql)->row_array();
		return $data;	
	
	}

}