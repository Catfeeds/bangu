<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:42:59
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class User_shop_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_user_shop($param,$page,$dest=''){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql  = 'SELECT c.link_mobile,u_line.status,u_line.line_status,u_line.linetitle,s.realname,s.mobile,u_line.overcity,b.mobile as bmobile,';
		$query_sql.='u_line.id,u_line.linecode,DATE_FORMAT(u_line.addtime,"%y%m%d") as addtime,u_line.nickname,u_line.linename,';
		$query_sql.=' GROUP_CONCAT(pl.`cityname`) AS startcity,u_line.linebefore, DATE_FORMAT(u_line.modtime,"%y%m%d")  as modtime,';
		$query_sql.='c.linkman,b.realname  as username,u_line.refuse_remark, DATE_FORMAT(u_line.returntime,"%y%m%d")  as returntime ';
		$query_sql.=' FROM u_line ';
		$query_sql.=' LEFT JOIN u_admin b  ON u_line.admin_id = b.id ';
		$query_sql.=' LEFT JOIN u_supplier c  ON c.id = u_line.supplier_id ';
		$query_sql.=' LEFT JOIN u_line_startplace  ON u_line.`id`=u_line_startplace.`line_id`';
		$query_sql.=' LEFT JOIN u_startplace pl  ON pl.id = u_line_startplace.`startplace_id` ';
		$query_sql.=' LEFT JOIN u_supplier s  ON s.id = u_line.supplier_id ';
		$query_sql.=' WHERE  u_line.producttype=0 and (u_line.line_kind=1 or u_line.line_kind=0) and u_line.line_kind !=2 and u_line.supplier_id='.$login_id.'  ';
	   	 /*目的查询*/
		if(!empty($dest['cityid'])){
			//$query_sql.=' AND '.$dest.' get_user_shop';		
			$query_sql.=' AND FIND_IN_SET('.$dest['cityid'].',u_line.overcity)>0 ';
			//$param['destcity'] = trim($param['destcity']);
		}else{
			if(!empty($dest['cityname'])){
				$city_sql="SELECT id from u_dest_base where kindname like '%{$dest['cityname']}%'";
				$query = $this->db->query($city_sql);
				$rows = $query->row_array();
				if(empty($rows)){  
					$rows['id']=0;
				}
				$query_sql.=' AND FIND_IN_SET('.$rows['id'].',u_line.overcity)>0 ';
			}
		}
		if(null!=array_key_exists('status', $param)){
			if($param['status']==3){
				$query_sql.=' AND (u_line.status  = ? or u_line.status  = 4) and  u_line.line_status!=0';
				$param['status'] = trim($param['status']);
			}else if($param['status']==4){
				$query_sql.=' AND (u_line.status  = 3 or u_line.status  = ?) and  u_line.line_status=0';
				$param['status'] = trim($param['status']);
			}else{
				$query_sql.=' AND u_line.status  = ? ';
				$param['status'] = trim($param['status']);
			}
			//and u_line.status=?
		}
		if(null!=array_key_exists('productName', $param)){
			$query_sql.=' AND u_line.linename  like ? ';
				$param['productName'] = '%'.$param['productName'].'%';
		}
		if(null!=array_key_exists('lineday', $param)){
			$query_sql.=' AND u_line.lineday  = ? ';
			$param['lineday'] = trim($param['lineday']);
		}
		if(null!=array_key_exists('sn', $param)){
			$query_sql.=' AND u_line.linecode  = ? ';
			$param['sn'] = trim($param['sn']);
		}
		$query_sql.=' GROUP BY u_line.id order by u_line.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//产品汇总
	function  get_product_list($param,$page,$dest=''){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql  = 'SELECT c.link_mobile,u_line.status,u_line.line_status,u_line.linetitle,s.realname,s.mobile,u_line.overcity,un.linkmobile as bmobile,'; 
		$query_sql.='u_line.id,u_line.linecode,DATE_FORMAT(apl.addtime,"%y%m%d") as addtime,u_line.nickname,u_line.linename,';
		$query_sql.='GROUP_CONCAT(pl.`cityname`) AS startcity,u_line.linebefore, DATE_FORMAT(apl.modtime,"%y%m%d")  as modtime,';
		$query_sql.='c.linkman,b.username,u_line.refuse_remark,apl.remark, u_line.producttype,';
		$query_sql.=' DATE_FORMAT(u_line.returntime,"%y%m%d")  as returntime,apl.status as apl_status,un.union_name,apl.union_id ';
		$query_sql.=' FROM u_line ';
		$query_sql.=' LEFT JOIN b_union_approve_line  AS apl  on u_line.id=apl.line_id ';
		$query_sql.=' LEFT JOIN b_union as un on un.id=apl.union_id ';
		$query_sql.=' LEFT JOIN u_admin b  ON u_line.admin_id = b.id ';
		$query_sql.=' LEFT JOIN u_supplier c  ON c.id = u_line.supplier_id ';
		$query_sql.=' LEFT JOIN u_line_startplace  ON u_line.`id`=u_line_startplace.`line_id`';
		$query_sql.=' LEFT JOIN u_startplace pl  ON pl.id = u_line_startplace.`startplace_id` ';
		$query_sql.=' LEFT JOIN u_supplier s  ON s.id = u_line.supplier_id ';
		$query_sql.=' WHERE u_line.line_kind !=2 and u_line.producttype=0 and u_line.supplier_id='.$login_id.'';
	   	 /*目的查询*/
		if(!empty($dest['cityid'])){
			//$query_sql.=' AND '.$dest.' get_user_shop';		
			$query_sql.=' AND FIND_IN_SET('.$dest['cityid'].',u_line.overcity)>0 ';
			//$param['destcity'] = trim($param['destcity']);
		}else{
			if(!empty($dest['cityname'])){
				$city_sql="SELECT id from u_dest_base where kindname like '%{$dest['cityname']}%'";
				$query = $this->db->query($city_sql);
				$rows = $query->row_array();
				if(empty($rows)){  
					$rows['id']=0;
				}
				$query_sql.=' AND FIND_IN_SET('.$rows['id'].',u_line.overcity)>0 ';
			}
		}

		if(null!=array_key_exists('status', $param)){
			/*if($param['status']==3){
				$query_sql.=' AND (u_line.status  = ? or u_line.status  = 4) and  u_line.line_status!=0';
				$param['status'] = trim($param['status']);
			}else if($param['status']==4){
				$query_sql.=' AND (u_line.status  = 3 or u_line.status  = ?) and  u_line.line_status=0';
				$param['status'] = trim($param['status']);
			}else{*/
				$query_sql.=' AND apl.status  = ? ';
				$param['status'] = trim($param['status']);
			//}
			//and u_line.status=?
		}
		if(null!=array_key_exists('productName', $param)){
			$query_sql.=' AND u_line.linename  like ? ';
				$param['productName'] = '%'.$param['productName'].'%';
		}
		if(null!=array_key_exists('lineday', $param)){
			$query_sql.=' AND u_line.lineday  = ? ';
			$param['lineday'] = trim($param['lineday']);
		}
		if(null!=array_key_exists('sn', $param)){
			$query_sql.=' AND u_line.linecode  = ? ';
			$param['sn'] = trim($param['sn']);
		}
		$query_sql.=' GROUP BY u_line.id,apl.id order by u_line.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//联盟包团
	function  get_group_line_list($param,$page,$dest=''){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql  = 'SELECT c.link_mobile,u_line.status,u_line.line_status,u_line.linetitle,s.realname,s.mobile,u_line.overcity,un.linkmobile as bmobile,'; 
		$query_sql.='u_line.id,u_line.linecode,DATE_FORMAT(apl.addtime,"%y%m%d") as addtime,u_line.nickname,u_line.linename,';
		$query_sql.='GROUP_CONCAT(pl.`cityname`) AS startcity,u_line.linebefore, DATE_FORMAT(apl.modtime,"%y%m%d")  as modtime,';
		$query_sql.='c.linkman,b.realname as username,u_line.refuse_remark,apl.remark, u_line.producttype,';
		$query_sql.=' DATE_FORMAT(u_line.returntime,"%y%m%d")  as returntime,apl.status as apl_status,un.union_name,apl.union_id ';
		$query_sql.=' FROM u_line ';
		$query_sql.=' LEFT JOIN b_union_approve_line  AS apl  on u_line.id=apl.line_id ';
		$query_sql.=' LEFT JOIN b_union as un on un.id=apl.union_id ';
		$query_sql.=' LEFT JOIN u_admin b  ON u_line.admin_id = b.id ';
		$query_sql.=' LEFT JOIN u_supplier c  ON c.id = u_line.supplier_id ';
		$query_sql.=' LEFT JOIN u_line_startplace  ON u_line.`id`=u_line_startplace.`line_id`';
		$query_sql.=' LEFT JOIN u_startplace pl  ON pl.id = u_line_startplace.`startplace_id` ';
		$query_sql.=' LEFT JOIN u_supplier s  ON s.id = u_line.supplier_id ';
		$query_sql.=' WHERE u_line.line_kind !=2 and u_line.producttype=1 and u_line.supplier_id='.$login_id.'';
	   	 /*目的查询*/
		if(!empty($dest['cityid'])){	
			$query_sql.=' AND FIND_IN_SET('.$dest['cityid'].',u_line.overcity)>0 ';
		}else{
			if(!empty($dest['cityname'])){
				$city_sql="SELECT id from u_dest_base where kindname like '%{$dest['cityname']}%'";
				$query = $this->db->query($city_sql);
				$rows = $query->row_array();
				if(empty($rows)){  
					$rows['id']=0;
				}
				$query_sql.=' AND FIND_IN_SET('.$rows['id'].',u_line.overcity)>0 ';
			}
		}
		if(null!=array_key_exists('status', $param)){
			
			if($param['status']==0){
				$query_sql.=' AND (apl.status  = ? ) ';
				$param['status'] = trim($param['status']);
			}else{
				$query_sql.=' AND apl.status  = ? ';
				$param['status'] = trim($param['status']);
			}

		}
		if(null!=array_key_exists('productName', $param)){
			$query_sql.=' AND u_line.linename  like ? ';
				$param['productName'] = '%'.$param['productName'].'%';
		}
		if(null!=array_key_exists('lineday', $param)){
			$query_sql.=' AND u_line.lineday  = ? ';
			$param['lineday'] = trim($param['lineday']);
		}
		if(null!=array_key_exists('sn', $param)){
			$query_sql.=' AND u_line.linecode  = ? ';
			$param['sn'] = trim($param['sn']);
		}
		$query_sql.=' GROUP BY u_line.id,apl.id order by u_line.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//包团线路查询
	public function get_group_line($param,$page,$dest=''){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		$query_sql  = 'SELECT c.link_mobile,u_line.status,u_line.line_status,u_line.overcity,u_line.linetitle,s.realname,s.mobile,b.mobile as bmobile,u_line.id,u_line.linecode,DATE_FORMAT(u_line.addtime,"%y%m%d") as addtime,u_line.nickname,u_line.linename,u_line.linebefore,GROUP_CONCAT(pl.`cityname`) AS startcity, DATE_FORMAT(u_line.modtime,"%y%m%d")  as modtime,c.linkman,b.username,u_line.refuse_remark, DATE_FORMAT(u_line.returntime,"%y%m%d")  as returntime  ';
		$query_sql.=' FROM u_line ';
		$query_sql.=' LEFT JOIN u_admin b  ON u_line.admin_id = b.id ';
		$query_sql.=' LEFT JOIN u_supplier c  ON c.id = u_line.supplier_id ';
		$query_sql.=' LEFT JOIN u_line_startplace  ON u_line.`id`=u_line_startplace.`line_id`';
		$query_sql.=' LEFT JOIN u_startplace pl  ON pl.id = u_line_startplace.`startplace_id` ';
		$query_sql.=' LEFT JOIN u_supplier s  ON s.id = u_line.supplier_id ';
		$query_sql.=' WHERE  u_line.producttype=1 and (u_line.line_kind=1 or u_line.line_kind=0) and u_line.supplier_id='.$login_id.'  ';
		
		/*目的查询*/
		if(!empty($dest['cityid'])){		
			$query_sql.=' AND FIND_IN_SET('.$dest['cityid'].',u_line.overcity)>0 ';
		}else{
			if(!empty($dest['cityname'])){
				$city_sql="SELECT id from u_dest_base where kindname like '%{$dest['cityname']}%'";
				$query = $this->db->query($city_sql);
				$rows = $query->row_array();
				if(empty($rows)){  
					$rows['id']=0;
				}
				$query_sql.=' AND FIND_IN_SET('.$rows['id'].',u_line.overcity)>0 ';
			}
		}
		if(null!=array_key_exists('status', $param)){
			if($param['status']==3){
				$query_sql.=' AND (u_line.status  = ? or u_line.status  = 4) and  u_line.line_status!=0';
				$param['status'] = trim($param['status']);
			}else if($param['status']==4){
				$query_sql.=' AND (u_line.status  = 3 or u_line.status  = ?) and  u_line.line_status=0';
				$param['status'] = trim($param['status']);
			}else{
				$query_sql.=' AND u_line.status  = ? ';
				$param['status'] = trim($param['status']);
			}
			//and u_line.status=?
		}
		if(null!=array_key_exists('productName', $param)){
			$query_sql.=' AND u_line.linename  like ? ';
			$param['productName'] = '%'.trim($param['productName']).'%';
		}
		if(null!=array_key_exists('lineday', $param)){
			$query_sql.=' AND u_line.lineday  = ? ';
			$param['lineday'] = trim($param['lineday']);
		}
		if(null!=array_key_exists('sn', $param)){
			$query_sql.=' AND u_line.linecode  = ? ';
			$param['sn'] = trim($param['sn']);
		}
		$query_sql.=' GROUP BY u_line.id  order by u_line.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	public function get_user_where($id){
		$query = $this->db->get_where('u_line', array('status' => $id));
		return $query->row_array();
	}
	public function get_user_shop_last(){//联合查询
		//查询   始发地、目的地、线路属性
		$sql="u_startplace.cityname,u_startplace.id,u_startplace.pid,u_dest_base.id,u_dest_base.kindname,";
		$sql=$sql."u_dest_base.pid,u_line_attr.attrname,u_line_attr.id,u_line_attr.pid";
		$this->db->select($sql);
		$this->db->from('u_dest_base');
		$this->db->join('u_startplace','u_dest_base.id=u_startplace.destid','left');
		$this->db->join('u_line_attr','u_line_attr.destid=u_dest_base.id');
		$query =$this->db->get();
		return $query->result_array();
	}
	
	public function updateLineStatus($lineId,$status){ //联合查询
		$this->db->trans_start();
		if(isset($status)){  // 下线 修改时间
			if($status==0 || $status==-1){
				$data = array( 'status' => $status,'modtime'=>date('Y-m-d H:i:s',time()) );
			}else{
				$data = array( 'status' => $status );
			}
		}else{
			$data = array( 'status' => $status );
		}
	/*	if($status==-1){
			$this->load->library('session');
			$supplier=$this->session->userdata ( 'loginSupplier' );
			$approve= $this->db->query("select id from b_union_approve_line where  supplier_id={$supplier['id']} and line_id={$lineId}")->row_array();
			if(!empty($approve)){
				$this->db->where('line_id',$lineId)->update('b_union_approve_line', array('status'=>-1));
			}
		}*/
		 $this->db->where('id', $lineId)->update('u_line', $data);

		 $this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
		//$this->db
		//return $this->db->affected_rows();
	}
	// 线路审核状态,0中断线路审核,1提交审核
	public function update_examine_line($lineId,$supplier_id,$status){
		$this->db->trans_start();
/*		if($type==1){
			//旅行社审核
			if($status==1){
				$this->db->where(array('line_id'=>$lineId))->delete('b_union_approve_line');
				$union = $this->db->query("select union_id from b_company_supplier where supplier_id={$supplier_id} and status=1")->result_array();
				if(!empty($union)){
					foreach ($union as $key => $value) {
						$insert=array(
							'status'=>$status,
							'union_id'=>$value['union_id'],
							'supplier_id'=>$supplier_id,
							'line_id'=>$lineId,
							'addtime'=>date("Y-m-d H:i:s",time()),
							'modtime'=>date("Y-m-d H:i:s",time()),
						);
						$this->db->insert('b_union_approve_line',$insert);	
					}
				}	
			}else{
				$approve= $this->db->query("select id from b_union_approve_line where  supplier_id={$supplier_id} and line_id={$lineId}")->row_array();
				if(!empty($approve)){
					$this->db->where('line_id',$lineId)->update('b_union_approve_line', array('status'=>0));
				}
			}

		}else{*/
			//平台审核	
			$data = array( 'status' =>$status,'modtime'=>date('Y-m-d H:i:s',time()) );
			$this->db->where('id', $lineId)->update('u_line', $data);
		//}

		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return $lineId;
		}
	}

	//联盟线路
	public function  update_approve_line($lineId,$supplier_id,$status,$union_id){
		$this->db->trans_start();
		//旅行社审核
		if($status==1){

			$this->db->where(array('line_id'=>$lineId,'union_id'=>$union_id))->update('b_union_approve_line', array('status'=>1,'remark'=>''));
				
		}else if($status==-1){  //删除
			$this->db->where(array('line_id'=>$lineId,'union_id'=>$union_id))->update('b_union_approve_line', array('status'=>-1));
		}else{
			$approve= $this->db->query("select id from b_union_approve_line where  supplier_id={$supplier_id} and line_id={$lineId}")->row_array();
			if(!empty($approve)){
				$this->db->where(array('line_id'=>$lineId,'union_id'=>$union_id))->update('b_union_approve_line', array('status'=>0,'remark'=>''));
			}
		}
	    $this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return $lineId;
		}
	}

	public function updateLine($data,$id){//联合查询
		$this->db->where('id', $id);
		$this->db->update('u_line', $data);
		return $this->db->affected_rows();
	}
	/**
	 * 获取日历报价
	 * @param unknown $lineId
	 * @param unknown $suitId
	 * @param unknown $startDate
	 * @return string
	 * ,$suitId,$startDate
	 */
	public function getProductPriceByProductId($lineId){	
		//$time= date('Y-m-d', strtotime('+1 day'));	
		$suit_price_sql = "SELECT a.*,b.suitname,b.unit,b.id as suit_id FROM u_line_suit b LEFT  JOIN u_line_suit_price a  on a.suitid=b.id and a.is_open =1 WHERE  b.is_open =1 and b.lineid=?  ORDER BY b.id";
		$query = $this->db->query($suit_price_sql,array($lineId));
		$suit_price_arr = $query->result_array();

		$productPrices = '[';
		$suitid_tmp='0';
		$index=0;

		foreach ($suit_price_arr as $key=>$row){
// 			echo $row["tabId"]."=tabName===".$row["tabName"];
			$html_string=array("\r", "\n", "\\","'",'"');
			$row["suitname"] = str_replace($html_string,"",$row["suitname"]);
			$suitid = $row["suit_id"];
			if($suitid_tmp!=$suitid){
				if($suitid_tmp!='0'){
					$productPrices=$productPrices.'}},';
				}
				$productPrices=$productPrices.'{';
				$productPrices=$productPrices.'"tabId":"'.$row["suit_id"].'",';
				$productPrices=$productPrices.'"unit":"'.$row["unit"].'",';
				$productPrices=$productPrices.'"tabName":"'.$row["suitname"].'","data":{';
				$index=0;
			}
			$productPrices=$productPrices.($index>0?',"':'"').$row["day"].'":{';
			$productPrices=$productPrices.'"dayid":"'.$row["dayid"].'",';
			$productPrices=$productPrices.'"number":"'.$row["number"].'",';
			$productPrices=$productPrices.'"day":"'.$row["day"].'",';
			$productPrices=$productPrices.'"childnobedprice":"'.$row["childnobedprice"].'",';
			$productPrices=$productPrices.'"adultprice":"'.$row["adultprice"].'",';
			$productPrices=$productPrices.'"childprice":"'.$row["childprice"].'",';
			$productPrices=$productPrices.'"oldprice":"'.$row["oldprice"].'",';
			$productPrices=$productPrices.'"agent_rate_int":"'.$row["agent_rate_int"].'",';
			$productPrices=$productPrices.'"agent_rate_child":"'.$row["agent_rate_child"].'",';
			$productPrices=$productPrices.'"agent_rate_childno":"'.$row["agent_rate_childno"].'",';
			$productPrices=$productPrices.'"room_fee":"'.$row["room_fee"].'",';
			$productPrices=$productPrices.'"agent_room_fee":"'.$row["agent_room_fee"].'",';
			$productPrices=$productPrices.'"before_day":"'.$row["before_day"].'",';
			$productPrices=$productPrices.'"hour":"'.$row["hour"].'",';
			$productPrices=$productPrices.'"minute":"'.$row["minute"].'"';
			//$productPrices=$productPrices.'"unit":"'.$row["unit"].'"';
			$productPrices=$productPrices.'}';
			$suitid_tmp=$suitid;
			$index++;
		}
		if(!empty($suit_price_arr[0]['suit_id'])){
			$productPrices=$productPrices.'}}';
		}
		
		$productPrices=$productPrices.']';
		echo $productPrices;	
	}
	/**
	 * 获取促销价日历报价
	 * @param unknown $lineId
	 * @param unknown $suitId
	 * @param unknown $startDate
	 * @return string
	 * ,$suitId,$startDate
	 */
	public function getSalesPriceByLineId($lineId){
		//$time= date('Y-m-d', strtotime('+1 day'));
		$suit_price_sql = "SELECT a.*, b.suitname,b.unit,b.id AS suit_id,sla.adultprice as s_adultprice,sla.childprice as s_childprice,sla.childnobedprice as s_childnobedprice,sla.number as s_number ";
		$suit_price_sql.=" FROM u_line_suit b LEFT  JOIN u_line_suit_price a  on a.suitid=b.id and a.is_open =1 LEFT JOIN u_sales_line_suit_price as sla on  sla.dayid=a.dayid  WHERE  b.is_open =1 and b.lineid=?  ORDER BY b.id ";
		$query = $this->db->query($suit_price_sql,array($lineId));

		$suit_price_arr = $query->result_array();
	
		$productPrices = '[';
		$suitid_tmp='0';
		$index=0;
	
		foreach ($suit_price_arr as $key=>$row){
			// 			echo $row["tabId"]."=tabName===".$row["tabName"];
			$html_string=array("\r", "\n", "\\","'",'"');
			$row["suitname"] = str_replace($html_string,"",$row["suitname"]);
			$suitid = $row["suit_id"];
			if($suitid_tmp!=$suitid){
				if($suitid_tmp!='0'){
					$productPrices=$productPrices.'}},';
				}
				$productPrices=$productPrices.'{';
				$productPrices=$productPrices.'"tabId":"'.$row["suit_id"].'",';
				$productPrices=$productPrices.'"unit":"'.$row["unit"].'",';
				$productPrices=$productPrices.'"tabName":"'.$row["suitname"].'","data":{';
				$index=0;
			}
			$productPrices=$productPrices.($index>0?',"':'"').$row["day"].'":{';
			$productPrices=$productPrices.'"dayid":"'.$row["dayid"].'",';
			$productPrices=$productPrices.'"number":"'.$row["number"].'",';
			$productPrices=$productPrices.'"day":"'.$row["day"].'",';
			$productPrices=$productPrices.'"childnobedprice":"'.$row["childnobedprice"].'",';
			$productPrices=$productPrices.'"adultprice":"'.$row["adultprice"].'",';
			$productPrices=$productPrices.'"childprice":"'.$row["childprice"].'",';
			$productPrices=$productPrices.'"s_adultprice":"'.$row["s_adultprice"].'",';
			$productPrices=$productPrices.'"s_childprice":"'.$row["s_childprice"].'",';
			$productPrices=$productPrices.'"s_childnobedprice":"'.$row["s_childnobedprice"].'",';
			$productPrices=$productPrices.'"s_number":"'.$row["s_number"].'",';
			$productPrices=$productPrices.'"room_fee":"'.$row["room_fee"].'",';
			$productPrices=$productPrices.'"agent_room_fee":"'.$row["agent_room_fee"].'",';
			$productPrices=$productPrices.'"before_day":"'.$row["before_day"].'",';
			$productPrices=$productPrices.'"hour":"'.$row["hour"].'",';
			$productPrices=$productPrices.'"minute":"'.$row["minute"].'"';
			//$productPrices=$productPrices.'"unit":"'.$row["unit"].'"';
			$productPrices=$productPrices.'}';
			$suitid_tmp=$suitid;
			$index++;
		}
		if(!empty($suit_price_arr[0]['suit_id'])){
			$productPrices=$productPrices.'}}';
		}
	
		$productPrices=$productPrices.']';
		echo $productPrices;
	}
	 public function getProductPriceBylineID($lineId,$suitId){
	 	$query = $this->db->query("SELECT * FROM u_line_suit_price WHERE lineid=? AND suitid=? order by day asc  ",array($lineId,$suitId));
	 	$rows = $query->result_array();
	 	return $rows;
	 }
	
	public function getLineSuit($lineid){
		$query = $this->db->query("SELECT id,lineid,suitname,unit,child_nobed_description,child_description,old_description,special_description FROM u_line_suit WHERE lineid=?  order by id  ",array( 'lineid' => $lineid ));
		$rows = $query->result_array();
		return $rows;
	}
	//获取套餐价格
	function get_suitPrice_data($whereArr){
		$this ->db ->select ( 'sp.*' );
		$this ->db ->from (' u_line_suit as s ' );
		$this ->db ->join ('u_line_suit_price as sp' ,'s.id=sp.suitid' ,'left');
		$this ->db ->where ( $whereArr );
		return $this->db->get ()->result_array ();
		
	}
	/**
	 * 
	 * @param Arry  $insertData  套餐信息
	 * @param Arry $priceArr    套餐价格信息
	 * @param string  $startDate 选择的日期
	 * @param int    $suit_id    套餐ID 
	 * @return bool
	 */
	public function insert_line_price($insertData,$priceArr,$startDate,$suit_id,$line_id){
		$this->db->trans_start();
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		//判断是否有线路附属表	
		$affStr=$this->db->query("select id from u_line_affiliated where line_id={$line_id}")->row_array();
		if(empty($affStr)){
			$affArr=array('code'=>1,'line_id'=>$line_id);
			$this->db->insert('u_line_affiliated',$affArr);	
		}

		$line = $this->get_tylename($line_id);//ABC出境  

		//判断是否有相同的天数 code相同
		$this->get_line_code($line_id,$line,$login_id);

		//------------------------------------------------------修改价格----------------------------------------------

		 if($suit_id==0){  //插入套餐
 	        //添加套餐编码
			$s_description=$this->get_suit_code($line_id);

	    	if($insertData['suitname']!='标准价'){
		    	$sql= $this->db->query('select suitname from u_line_suit where lineid='.$line_id);
		    	$suitdata=$sql->result_array();
		    	$flay=0;
		    	foreach($suitdata as $k=>$v){
		    		if($v['suitname']=='标准价'){
		    			$flay=1;
		    		}
		    	}
	    	} 
	    	$insertData['description']=$s_description;
	    	$insertData['unit']=1;
	    	$this->db->insert('u_line_suit',$insertData);  //插入套餐
	    	$suit_id=$this->db->insert_id();
		 }

		$day=array();
		$query = $this->db->query('select dayid,lineid,suitid,day from  u_line_suit_price where is_open=1 and suitid='.$suit_id.' and lineid='.$line_id);
		$suit_price = $query->result_array();
		
		if(!empty($suit_price)){
			foreach ($suit_price as $key=>$val){
				$day[]=$val['day'];
			}
		}
		
		
		$suppCode = $this->get_suppliercode();//供应商代码
		$suitCode = $this->get_suitCode($suit_id);//套餐编码套餐编号  A：第一个套餐（A B C D等，套餐N个就多个）
		
		 
		$dateArr=explode(',', $startDate);
		$time=strtotime(date('Y-m-d'));
	   	$priceArr['suitid']=$suit_id;
	   	$line = $this->get_tylename($line_id);//ABC出境  
	   	$keystr=0;
		foreach ($dateArr as $k=>$v){
			if(!empty($v)){
				$priceArr['day']=$v;

				if(strtotime($v)>=$time){
					if(in_array($v,$day)){   //存在修改

					    $pirce_sql= $this->db->query("select dayid,description from u_line_suit_price where day='{$v}' and is_open=1 and lineid={$line_id} and suitid={$suit_id}");
						$pirceP = $pirce_sql->row_array();

				/* 		if(empty($pirceP['description'])){  //不存在团号,添加
							//团号天数天数一样 ,++1
							$item=$this->get_team_code($line_id,$suit_id,$priceArr['day'],$line,$suppCode,$suitCode);
							if($item){
								$priceArr['description']=$item;
							}else{
								return -1;exit;
							}
							
						} */
					    unset($priceArr['description']);		
						$this->db->where(array('lineid'=>$line_id,'suitid'=>$suit_id,'day'=>$v,'dayid'=>$pirceP['dayid']));
						$this->db->update('u_line_suit_price', $priceArr);
											
					}else {        //不存在则插入

						$item=$this->get_team_code($line_id,$suit_id,$priceArr['day'],$line,$suppCode,$suitCode); 
						if($item){
							$priceArr['description']=$item;
						}else{
							return -1;exit;
						}

						$priceArr['description']=$item;

						$this->db->insert('u_line_suit_price',$priceArr);	
					}
				}
			}
		}
		if($suit_id>0){
			//修改套餐名称
			$this->db->where(array('lineid'=>$line_id,'id'=>$suit_id))->update('u_line_suit', array('suitname'=>$insertData['suitname']));
		}
		

		$lineArr=array();
	    //取第一个最小的成人价格
	    $adult_sql="select adultprice as lineprice  from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
	    $adult_sql.="where lst.lineid={$line_id} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d') order by lsp.adultprice asc limit 1";
	    $adultData=$this->db->query($adult_sql)->row_array();
	 
	    //取第一个最小的儿童价格
	    $chil_sql="select childprice as lineprice from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
	    $chil_sql.="where lst.lineid={$line_id} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d') and lsp.childprice!=0 order by lsp.childprice asc limit 1";
	    $childData=$this->db->query($chil_sql)->row_array();
	    
	    //取第一个最小的儿童价格不占床
	    $chilno_sql="select childnobedprice as lineprice from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
	    $chilno_sql.="where lst.lineid={$line_id} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d')and lsp.childnobedprice!=0  order by lsp.childnobedprice asc limit 1";
	    $childnobeData=$this->db->query($chilno_sql)->row_array();
	    
	    $lineprice=array();
	    if(!empty($adultData['lineprice'])){
	    	$lineprice[]=$adultData['lineprice'];
	    }
	    
		if(!empty($childData['lineprice'])){
	    	$lineprice[]=$childData['lineprice'];
	    }
	    
	    if(!empty($childnobeData['lineprice'])){
	    	$lineprice[]=$childnobeData['lineprice'];
	    }
	    if(!empty($lineprice)){
	    	$lineArr['lineprice']=min($lineprice);//促销价
	    }
	    
	
	    //修改线路
	    $lineArr['modtime']=date("Y-m-d H:i:s",time());
	    $lineArr['ordertime']=date('Y-m-d H:i:s',strtotime('+7 day'));
	
	    $lineArr['saveprice']=0;
	    	
	    $this->db->where(array('id'=>$line_id));
	    $this->db->update('u_line', $lineArr);
	
		
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			return $suit_id;
		}
	}

	//生成线路套餐编号
	public function get_line_code($line_id,$line,$login_id){
		//判断线路的天数 是否有相同的 编号
		$sql="select la.id,la.code from u_line_affiliated as la  left join u_line as l on  la.line_id=l.id  ";
		$sql.="where  l.supplier_id={$login_id} and  l.lineday={$line['lineday']} and la.code={$line['code']} and l.id!={$line_id} ";
		$data=$this->db->query($sql)->row_array();
		
		if(!empty($data)){  //有天数,编码相同,++1
			//相同天数
			$mysql=" select id,code from  u_supplier_day where supplier_id={$login_id} and days={$line['lineday']} ";
			$daT=$this->db->query($mysql)->row_array();
			if(empty($daT)){  
				$dayArr=array('supplier_id'=>$login_id,'days'=>$line['lineday'],'code'=>1);
				$this->db->insert('u_supplier_day',$dayArr);
				$daT['code']=1;
			}

			$x=1;
			while($x>0) {

				$daT['code']=$daT['code']+1;

				$Tsql="select la.id,la.code from u_line_affiliated as la  left join u_line as l on  la.line_id=l.id  ";
				$Tsql.="where  l.supplier_id={$login_id} and  l.lineday={$line['lineday']} and la.code={$daT['code']} and l.id!={$line_id} ";
			 	$dataT=$this->db->query($Tsql)->row_array();

			 	if(!empty($dataT)){
			 		$x=1;
			 		//$daT['code']=$daT['code']+1;
			 	}else{
			 		$this->db->query("update  u_supplier_day set code={$daT['code']} where supplier_id={$login_id} and days={$line['lineday']} ");
			 		$this->db->query("update  u_line_affiliated set code={$daT['code']} where line_id={$line_id} ");
			 		$x=-1;
			 	}
			}
		}
	}

	public function getLineRout($lineid){
		$query_sql="SELECT	jie.id as 'id',jie.title as 'title',jie.DAY as 'day',jie.breakfirsthas as 'breakfirsthas',jie.breakfirst as 'breakfirst',jie.lunchhas as 'lunchhas',jie.lunch as 'lunch',";
		$query_sql.="jie.supperhas as 'supperhas',jie.supper as 'supper',jie.hotel as 'hotel',jie.transport as 'transport',jie.jieshao as 'jieshao', pic.id as 'picid', pic.pic as 'pic' ";
		$query_sql.="FROM u_line_jieshao as jie ";
		$query_sql.="LEFT JOIN u_line_jieshao_pic as pic on jie.id=pic.jieshao_id ";
		$query_sql.=" LEFT JOIN u_line as l on l.id=jie.lineid  ";
		$query_sql.="  WHERE  lineid=".$lineid." AND  l.lineday>=jie.day order by day asc ";
		$query = $this->db->query($query_sql);
		$rows = $query->result_array();
		return $rows;
	}
	//修改后的行程
	public function get_change_lineRout($where,$limit){
		$query_sql="jie.id as 'id',jie.title as 'title',jie.DAY as 'day',jie.breakfirsthas as 'breakfirsthas',jie.breakfirst as 'breakfirst',jie.lunchhas as 'lunchhas',jie.lunch as 'lunch',";
		$query_sql.="jie.supperhas as 'supperhas',jie.supper as 'supper',jie.hotel as 'hotel',jie.transport as 'transport',jie.jieshao as 'jieshao', pic.id as 'picid', pic.pic as 'pic' ";
		$this->db->select($query_sql);
		$this->db->from('u_line_jieshao as jie ');
		$this->db->join('u_line_jieshao_pic as pic','jie.id=pic.jieshao_id','left');
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($limit)){
			$this->db->limit($limit);		
		}

		$this->db->order_by('jie.day asc');
		$query =$this->db->get();
		 
		return $query->result_array();
	} 
	//修改行程变
	public function updata_line_jieshao($id,$lineid,$data){
		$this->db->where(array("id"=>$id,'lineid'=>$lineid));
		$this->db->update('u_line_jieshao', $data);
		return $this->db->affected_rows();
	}
	
	//根据第几天修改行程变
	public function updata_jieshao_data($where,$data){
		$this->db->where($where);
		$this->db->update('u_line_jieshao', $data);
		return $this->db->affected_rows();
	}
	
	//修改费用说明
	public function updata_line_fee($id,$data,$attachment=''){
        $this->db->trans_start();

		$this->db->where(array("id"=>$id));
		$this->db->update('u_line', $data);
		$this->db->affected_rows();

		//线路标签表
             if(!empty($data['linetype'])){    		
	    		$linetypeArr=explode(',', $data['linetype']);
	    		$linetypestr=array();
	    		$linetypeData=$this->db->select('attr_id')->where(array('line_id'=>$id))->get('u_line_type')->result_array();
	    		if(!empty($linetypeData)){
			            foreach ($linetypeData as $k=>$v){  //没选中的出发地就删除
			            	if(!empty($v['attr_id'])){
			            		$linetypestr[]=$v['attr_id'];
			            		if(!in_array($v['attr_id'],$linetypeArr)){
			            			$this->db->where(array('line_id'=>$id,'attr_id'=>$v['attr_id']))->delete('u_line_type');
			            		}
			            	}
			            } 		
	    		}
             
	    		foreach ($linetypeArr as $k=>$v){
	    			if(!empty($v)){
	    			
	    				 if(!in_array($v,$linetypestr)){  //不存在该出发地就插入
	    				 	$this->insert_data('u_line_type',array('line_id'=>$id,'attr_id'=>$v));//插入表	 
	    				 }
	    			}
	    		} 
    		}
    		//上传附件文件
    		if(!empty($attachment)){
    			$line_protocol=$this->db->select('id')->where(array('line_id'=>$id))->get('u_line_protocol')->row_array();
    			if(!empty($line_protocol)){
    				$this->db->where(array('line_id'=>$id))->delete('u_line_protocol');	
    			}
    			foreach ($attachment['name'] as $key => $value) {

    				if(!empty($attachment['url'][$key])){
					$attachmentArr['line_id']=$id;
    					$attachmentArr['addtime']=date("Y-m-d H:i:s",time());
    					$attachmentArr['name']= $value;
    					$attachmentArr['url']=$attachment['url'][$key];
    					$this->insert_data('u_line_protocol',$attachmentArr);//插入表
    					$protocol_id= $this ->db ->insert_id();

					$aArr['sysname']='L'.$id.$protocol_id;
					$this->db->where(array('id'=>$protocol_id))->update('u_line_protocol', $aArr);
    				}	
    			}	
    		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		        return false;
		}else{
	
		        return true;
		}

	}
	/**
	 * 删除套餐
	 * @param unknown $suitId
	 * @return unknown
	 */
	public function deleteSuitById($suitId){
		$this->db->trans_start();
		//删除套餐
		$this->db->where('id', $suitId);
		$this->db->delete('u_line_suit');
		$rows = $this->db->affected_rows();
		if($rows>0){
			//删除套餐下的报价
			$this->db->where('suitid', $suitId);
			$this->db->delete('u_line_suit_price');
		}
		$this->db->trans_complete();
		return $rows;
	}
	
	/**
	 *  * 保存套餐价格
	 * @param int     $lineId 线路ID
	 * @param Array   $lineArr 线路
	 * @param Array   $suit_arr 套餐信息
	 * @return bool
	 */
	public  function  saveProductPrice($lineArr,$suit_arr,$lineId,$unit,$lineAffil){
		
		$this->db->trans_start();

		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		//判断是否有线路附属表	
		$affStr=$this->db->query("select id from u_line_affiliated where line_id={$lineId}")->row_array();
		if(empty($affStr)){
			$affArr=array('code'=>1,'line_id'=>$lineId);
			$this->db->insert('u_line_affiliated',$affArr);	
		}

		$line = $this->get_tylename($lineId);//ABC出境
		$suppCode = $this->get_suppliercode();//供应商代码

		//保存套餐
		if(!empty($suit_arr)){

			//判断是否有相同的天数 code相同 生成线路编号
			$this->get_line_code($lineId,$line,$login_id);

			//------------------------------------------------------修改价格----------------------------------------------
			
			foreach ($suit_arr as $k=>$v){	
				if(!empty($v['tabName'])){
					$html_string=array("\r", "\n", "\\","'",'"');
					$v['tabName'] = str_replace($html_string,"",$v['tabName']);
				}
				if(isset($v['tabId']) && $v['tabId']>0){ 	//修改套餐价格

					$suitCode = $this->get_suitCode($v['tabId']);//套餐编码套餐编号  A：第一个套餐（A B C D等，套餐N个就多个）

					if(!empty($v['data'])){

						$line = $this->get_tylename($lineId);//ABC出境  
						$keystr=0;

						foreach ($v['data'] as $key=>$val){	

						    $pirce_sql= $this->db->query("select dayid,description from u_line_suit_price where day='{$val['day']}' and lineid={$lineId} and suitid={$v['tabId']}");
							$pirceArr = $pirce_sql->row_array();
							$insertSuit=$v['data'][$key];
							$insertSuit['suitid']=$v['tabId'];
							$insertSuit['lineid']=$lineId;
							if($val['dayid']>0){
	
									if(empty($pirceArr['description'])){  //不存在线路编号,重新添加
				 						$item=$this->get_team_code($lineId,$insertSuit['suitid'],$insertSuit['day'],$line,$suppCode,$suitCode);
										if($item){
											$insertSuit['description']=$item;
										}else{
											return -1;exit;
										}
									}
									$dayid=$insertSuit['dayid'];
									unset($insertSuit['dayid']);
									$this->db->where(array('day'=>$val['day'],'lineid'=>$lineId,'suitid'=>$v['tabId'],'dayid'=>$dayid));
									$this->db->update('u_line_suit_price', $insertSuit);
							
							}else{
								
								if(!empty($v['data'][$key]['adultprice'])){

									//团队编号
									$item=$this->get_team_code($lineId,$insertSuit['suitid'],$insertSuit['day'],$line,$suppCode,$suitCode);
									if($item){
										$insertSuit['description']=$item;
									}else{
										return -1;exit;
									}
	
									unset($insertSuit['dayid']);
									$this->db->insert('u_line_suit_price',$insertSuit);
								}
							}
						}
					}
					//修改套餐名
					if(isset($v['tabName'])&&!empty($v['tabName'])){
						$up_suitname['suitname']=$v['tabName'];
						$this->db->where(array('id'=>$v['tabId'],'lineid'=>$lineId));
						$this->db->update('u_line_suit', $up_suitname);
					}
					if(!empty( $v['unit'])){
						$up_suit['unit']=$v['unit'];
						$this->db->where(array('id'=>$v['tabId'],'lineid'=>$lineId));
						$this->db->update('u_line_suit', $up_suit);
					}
					$suitId=$v['tabId'];
				}else{             //插入套餐价格 
			         
					//添加套餐编码
					$s_description=$this->get_suit_code($lineId);
					//套餐
					if(isset($v['tabId'])){
						if(!empty($v['tabName'])){
							$suitArr['suitname']=$v['tabName'];
							$suitArr['lineid']=$lineId;
							$suitArr['description']=$s_description;
							if(!empty($v['unit'])){
								$suitArr['unit']=$v['unit'];
							}
							$this->db->insert('u_line_suit',$suitArr);
							$suitId=$this->db->insert_id();
							//团号天数天数一样 ,++1				
							//$this->get_lineday_code($login_id,$lineId,$line);
						}else{
							//第一个套餐插入标准价
							$normalPrice=$this->db->query("select id from u_line_suit where  is_open=1 and lineid={$lineId}")->row_array();
							if(empty($normalPrice)){
								$suit0['suitname']='标准价';
								$suit0['lineid']=$lineId;
								$suit0['unit']=1;
								$suit0['description']=$s_description;
								$this->db->insert('u_line_suit',$suit0);
								$suitId=$this->db->insert_id();
							}
						}
					}else{
						//第一个套餐插入标准价
						$normalPrice=$this->db->query("select id from u_line_suit where lineid={$lineId}")->row_array();
						
						if(empty($normalPrice)){
							$suit0['suitname']='标准价';
							$suit0['unit']=1;
							$suit0['lineid']=$lineId;
							$suit0['description']=$s_description;
							$this->db->insert('u_line_suit',$suit0);
							$suitId=$this->db->insert_id();
						}	
					}
					
					$line = $this->get_tylename($lineId);//ABC出境
					//套餐价格
					if(!empty($v['data'])){
					
						foreach ($v['data'] as $key=>$val){
							//var_dump($v['data'][$key]['adultprice']);
							if(!empty($v['data'][$key]['adultprice']) && !empty($suitId)){  //成人价不能为空
								unset($v['data'][$key]['dayid']);
								$insertSuitPrice=$v['data'][$key];
								$insertSuitPrice['lineid']=$lineId;
								$insertSuitPrice['suitid']=$suitId;
								$suitCode = $this->get_suitCode($suitId);//套餐编码套餐编号  A：第一个套餐（A B C D等，套餐N个就多个）
								//团队编号
								$item=$this->get_team_code($lineId,$suitId,$insertSuitPrice['day'],$line,$suppCode,$suitCode); 
								//echo $this->db->last_query();
								if($item){
									$insertSuitPrice['description']=$item;
								}else{
									return -1;exit;
								}

								$this->db->insert('u_line_suit_price',$insertSuitPrice);
							}
						}
					}   
				} 
			}
		}
		
		//if(!empty($lineArr)){

			//取第一个最小的成人价格
			$adult_sql="select adultprice as lineprice  from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
			$adult_sql.="where lst.lineid={$lineId} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d') order by lsp.adultprice asc limit 1";
			$adultData=$this->db->query($adult_sql)->row_array();
			
			//取第一个最小的儿童价格
	/* 		$chil_sql="select childprice as lineprice from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
			$chil_sql.="where lst.lineid={$lineId} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d') and lsp.childprice!=0 order by lsp.childprice asc limit 1";
			$childData=$this->db->query($chil_sql)->row_array(); */
			 
			//取第一个最小的儿童价格不占床
			/* $chilno_sql="select childnobedprice as lineprice from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
			$chilno_sql.="where lst.lineid={$lineId} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d')and lsp.childnobedprice!=0  order by lsp.childnobedprice asc limit 1";
			$childnobeData=$this->db->query($chilno_sql)->row_array(); */
			 
			$lineprice=array();
			if(!empty($adultData['lineprice'])){
				$lineprice[]=$adultData['lineprice'];
			}
			 
			if(!empty($lineprice)){
				$lineArr['lineprice']=min($lineprice);//促销价
			}
			
			//修改线路
			$lineArr['modtime']=date("Y-m-d H:i:s",time());
			$lineArr['ordertime']=date('Y-m-d H:i:s',strtotime('+7 day'));
			$lineArr['units']=$unit;

			$lineArr['saveprice']=0;
			
			$this->db->where(array('id'=>$lineId));
			$this->db->update('u_line', $lineArr);
		//}
		
		//线路押金,押金
	    	if(!empty($lineAffil)){
	    		$Aff=$this->db->select('id,deposit,line_id,before_day')->where(array('line_id'=>$lineId))->get('u_line_affiliated')->row_array();
	    		if(empty($Aff)){
	    			$lineAffil['line_id']=$lineId;
				$this->insert_data('u_line_affiliated',$lineAffil);//插入表
				//echo $this->db->last_query();
	    		}else{
	    			$this->update_rowdata('u_line_affiliated',$lineAffil,array('line_id'=>$lineId));
	    		}
	    	}

	    	// var_dump(12345);exit;
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		        return false;
		}else{
			if(!empty($suitId)){
			     	return $suitId;
			 }else{
			     	return 1;
			}
		}
	}
	/**
	 * @method 保存线路价格 api接口
	 * @param
	 * @author xml
	 * @return suitId
	 */
	public function save_price_api($price,$linepriceArr,$linepriceAffil,$lineArr){
		$suitArr=array();
		$this->db->trans_start();
		$line_id=$lineArr['id'];
		//判断是否有线路附属表
		$affStr=$this->db->query("select id from u_line_affiliated where line_id={$line_id}")->row_array();
		if(empty($affStr)){
			$affArr=array('code'=>1,'line_id'=>$line_id);
			$this->db->insert('u_line_affiliated',$affArr);		
		}
	   
		$line = $this->get_tylename($line_id);//ABC出境
		$supplier= $this->db->query("select id,code from u_supplier where id={$lineArr['supplier_id']}")->row_array();
		$suppCode =$supplier['code']; //供应商代码
		
		//保存套餐
		if(!empty($price)){
			
			//判断是否有相同的天数 code相同 生成线路编号
			$this->get_line_code($line_id,$line,$lineArr['supplier_id']);
			
			foreach ($price as $key=>$val){
				   
	               	if(intval($val['suitId'])>0){  //修改套餐
	               		
	               		$suitArr[]=$val['suitId'];
	               		 $suitCode = $this->get_suitCode($val['suitId']);//套餐编码套餐编号  A：第一个套餐（A B C D等，套餐N个就多个）
	               		
	               		 //编辑套餐名称
	               		 $suitData=array(
	               		 		'lineid'=>$line_id,
	               		 		'suitname'=>$val['suitName'],
	               		 		'unit'=>1,
	               		 );
	               		 $this->db->where(array('lineid'=>$line_id,'id'=>$val['suitId']))->update('u_line_suit', $suitData);
	               		 
	               		$suitTid= $this->db->query("select id from u_line_suit where id={$val['suitId']} and lineid={$line_id} and is_open=1 ")->row_array();
	               		if(!empty($suitTid)){ //是否存在该套餐

	               		 if(!empty($val['data'])){
	               		 
	               		 	$line = $this->get_tylename($line_id);//ABC出境
	               		 	$keystr=0;
	               		     
	               		 	foreach ($val['data'] as $n=>$y){
	               		 		$ret = strtotime($y['day']);
	               		 		if(!$ret){
	               		 			 return array('code'=>"4000",'msg'=>"出团日期格式出错");exit;
	               		 		}else{
	               		 			$y['day']=date("Y-m-d",$ret);
	               		 		}
	               		 		
	               		 		if(preg_match("/[^\d-., ]/",$y['adultprice'])){
	               		 			 return array('code'=>"4000",'msg'=>"成人价{$y['adultprice']}类型格式不对");exit;
	               		 		}
	               		 		if(preg_match("/[^\d-., ]/",$y['agent_rate_int'])){
	               		 			return array('code'=>"4000",'msg'=>"成人佣金{$y['agent_rate_int']}类型格式不对");exit;
	               		 		}
	               		 		if(preg_match("/[^\d-., ]/",$y['childprice'])){
	               		 			return array('code'=>"4000",'msg'=>"小孩占床价{$y['childprice']}类型格式不对");exit;
	               		 		}
	               		 		if(preg_match("/[^\d-., ]/",$y['agent_rate_child'])){
	               		 			return array('code'=>"4000",'msg'=>"小孩占床佣金{$y['agent_rate_child']}类型格式不对");exit;
	               		 		}
	               		 		if(preg_match("/[^\d-., ]/",$y['childnobedprice'])){
	               		 			return array('code'=>"4000",'msg'=>"小孩不占床价{$y['childnobedprice']}类型格式不对");exit;
	               		 		}
	               		 		if(preg_match("/[^\d-., ]/",$y['agent_rate_childno'])){
	               		 			return array('code'=>"4000",'msg'=>"小孩不占床佣金{$y['agent_rate_childno']}类型格式不对");exit;
	               		 		}
	               		 		//单人数补房差
	               		 		if(preg_match("/[^\d-., ]/",$y['room_fee'])){
	               		 			return array('code'=>"4000",'msg'=>"单人数补房差价{$y['room_fee']}类型格式不对");exit;
	               		 		}
	               		 		if(preg_match("/[^\d-., ]/",$y['agent_room_fee'])){
	               		 			return array('code'=>"4000",'msg'=>"单人数补房差价佣金{$y['agent_room_fee']}类型格式不对");exit;
	               		 		}
	               		 	
	               		 		//验证数据
	               		 		if($y['agent_rate_int']>$y['adultprice']){ return  array('code'=>"4000",'msg'=>"成人佣金不能大于成人价");exit;}
	               		 		if($y['agent_rate_child']>$y['childprice']){ return array('code'=>"4000",'msg'=>"小孩占床佣金不能大于小孩占床价"); exit;}
	               		 		if($y['agent_rate_childno']>$y['childnobedprice']){ return array('code'=>"4000",'msg'=>"小孩不占床佣金不能大于小孩不占床价");exit; }
	               		 		if($y['agent_room_fee']>$y['room_fee']){ return array('code'=>"4000",'msg'=>"单人数补房差价佣金不能大于其售卖价");exit; }
	               		 		
	               		 		$pirce_sql= $this->db->query("select dayid,description from u_line_suit_price where day='{$y['day']}' and is_open=1 and lineid={$line_id} and suitid={$val['suitId']}");
	               		 		$pirceArr = $pirce_sql->row_array();
	               		 		
	               		 		$insertSuit=$y;
	               		 		$insertSuit['suitid']=$val['suitId'];
	               		 		$insertSuit['lineid']=$line_id;
	               		 		
	               		 		if(!empty($pirceArr['dayid'])){
	               		 			
	               		 			if(empty($pirceArr['description'])){  //不存在线路编号,重新添加
	               		 				$item=$this->get_team_code($line_id,$insertSuit['suitid'],$insertSuit['day'],$line,$suppCode,$suitCode);
	               		 				if($item){
	               		 					$insertSuit['description']=$item;
	               		 				}else{
	               		 					 return array('code'=>"4000",'msg'=>"出团日期编号出错");exit;
	               		 				}
	               		 			}

	               		 			$this->db->where(array('day'=>$y['day'],'lineid'=>$line_id,'suitid'=>$val['suitId'],'is_open'=>1));
	               		 			$this->db->update('u_line_suit_price', $insertSuit);
	               		 			
	               		 		}else{
	               		 
	               		 			if(!empty($y['adultprice'])){
	               		 				
	               		 				//团队编号
	               		 				$item=$this->get_team_code($line_id,$insertSuit['suitid'],$y['day'],$line,$suppCode,$suitCode);
	               		 			
	               		 				if($item){
	               		 					$insertSuit['description']=$item;
	               		 				}else{
	               		 					 return array('code'=>"4000",'msg'=>"出团日期编号出错");exit;
	               		 				}
	               		 
	               		 				$this->db->insert('u_line_suit_price',$insertSuit);
	               		 			}else{
	               		 				return array('code'=>"4000",'msg'=>"出团日期{$y['day']}的成人价不能为空");exit;
	               		 			}
	               		 		}
	               		 	}
	               		 }	               			     
	                	}else{
	                		return array('code'=>"4000",'msg'=>"套餐不存在");exit;
	                	} 
	               	}else if($val['suitId']=='0'){   //添加套餐
	               	
	               		$suitThArr= $this->db->query("select id from u_line_suit where lineid={$line_id} and is_open=1 ")->result_array();
	               	    if(count($suitThArr)>10){
	               	    	return array('code'=>"4000",'msg'=>"套餐数量已经超过限制值");exit;
	               	    }
	               		//添加套餐编码
	               		$s_description=$this->get_suit_code($line_id);
	               		$suit['suitname']=$val['suitName'];
	               		$suit['lineid']=$line_id;
	               		$suit['unit']=1;
	               		$suit['description']=$s_description;
	               		$this->db->insert('u_line_suit',$suit);
	               		$suitId=$this->db->insert_id();
	               			
	               		//套餐价格
	               		if(!empty($val['data'])){
	               			foreach ($val['data'] as $a=>$b){
	               				$ret = strtotime($b['day']);
	               				if(!$ret){
	               					return array('code'=>"4000",'msg'=>"出团日期格式出错");exit;
	               				}else{
	               					$b['day']=date("Y-m-d",$ret);
	               				}
	               				if(!$ret){
	               					return array('code'=>"4000",'msg'=>"出团日期格式出错");exit;
	               				}else{
	               					$y['day']=date("Y-m-d",$ret);
	               				}
	               				 
	               				if(preg_match("/[^\d-., ]/",$b['adultprice'])){
	               					return array('code'=>"4000",'msg'=>"成人价{$b['adultprice']}类型格式不对");exit;
	               				}
	               				if(preg_match("/[^\d-., ]/",$b['agent_rate_int'])){
	               					return array('code'=>"4000",'msg'=>"成人佣金{$b['agent_rate_int']}类型格式不对");exit;
	               				}
	               				if(preg_match("/[^\d-., ]/",$b['childprice'])){
	               					return array('code'=>"4000",'msg'=>"小孩占床价{$b['childprice']}类型格式不对");exit;
	               				}
	               				if(preg_match("/[^\d-., ]/",$b['agent_rate_child'])){
	               					return array('code'=>"4000",'msg'=>"小孩占床佣金{$b['agent_rate_child']}类型格式不对");exit;
	               				}
	               				if(preg_match("/[^\d-., ]/",$b['childnobedprice'])){
	               					return array('code'=>"4000",'msg'=>"小孩不占床价{$b['childnobedprice']}类型格式不对");exit;
	               				}
	               				if(preg_match("/[^\d-., ]/",$b['agent_rate_childno'])){
	               					return array('code'=>"4000",'msg'=>"小孩不占床佣金{$b['agent_rate_childno']}类型格式不对");exit;
	               				}
	               				//单人数补房差
	               				if(preg_match("/[^\d-., ]/",$b['room_fee'])){
	               					return array('code'=>"4000",'msg'=>"单人数补房差价{$b['room_fee']}类型格式不对");exit;
	               				}
	               				if(preg_match("/[^\d-., ]/",$b['agent_room_fee'])){
	               					return array('code'=>"4000",'msg'=>"单人数补房差价佣金{$b['agent_room_fee']}类型格式不对");exit;
	               				}
	               				//验证数据
	               				if($b['agent_rate_int']>$b['adultprice']){ return  array('code'=>"4000",'msg'=>"成人佣金不能大于成人价");exit;}
	               				if($b['agent_rate_child']>$b['childprice']){ return array('code'=>"4000",'msg'=>"小孩占床佣金不能大于小孩占床价"); exit;}
	               				if($b['agent_rate_childno']>$b['childnobedprice']){ return array('code'=>"4000",'msg'=>"小孩不占床佣金不能大于小孩不占床价");exit; }
	               				if($b['agent_room_fee']>$b['room_fee']){ return array('code'=>"4000",'msg'=>"单人数补房差价佣金不能大于其售卖价");exit; }
	               				if(!empty($b['adultprice']) && !empty($suitId)){  //成人价不能为空
	               					$insertSuitPrice=$b;
	               					$insertSuitPrice['lineid']=$line_id;
	               					$insertSuitPrice['suitid']=$suitId;
	               					$suitCode = $this->get_suitCode($suitId);//套餐编码套餐编号  A：第一个套餐（A B C D等，套餐N个就多个）
	               					//团队编号
	               					$item=$this->get_team_code($line_id,$suitId,$insertSuitPrice['day'],$line,$suppCode,$suitCode);
	               					if(!empty($item)){
	               						$insertSuitPrice['description']=$item;
	               					}else{
	               						return array('code'=>"4000",'msg'=>"团号出错");exit;
	               					}
	               				
	               					$this->db->insert('u_line_suit_price',$insertSuitPrice);
	               				}else{
	               					return array('code'=>"4000",'msg'=>"出团日期{$b['day']}的成本价不能为空!");exit;
	               				}	
	               			}
	               		}
	               		$suitArr[]=$suitId;
	               	}else{
	               		//return array('status'=>"4000",'msg'=>"操作失败");exit;
	               	}               	
			}		
		}
		

		//取第一个最小的成人价格
		$adult_sql="select adultprice as lineprice  from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
		$adult_sql.="where lst.lineid={$line_id} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d') order by lsp.adultprice asc limit 1";
		$adultData=$this->db->query($adult_sql)->row_array();
		
		//取第一个最小的儿童价格
		$chil_sql="select childprice as lineprice from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
		$chil_sql.="where lst.lineid={$line_id} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d') and lsp.childprice!=0 order by lsp.childprice asc limit 1";
		$childData=$this->db->query($chil_sql)->row_array();
			
		//取第一个最小的儿童价格不占床
		$chilno_sql="select childnobedprice as lineprice from u_line_suit as lst left join u_line_suit_price as lsp on lst.id=lsp.suitid  ";
		$chilno_sql.="where lst.lineid={$line_id} and lsp.day>= DATE_FORMAT(NOW(),'%Y-%m-%d')and lsp.childnobedprice!=0  order by lsp.childnobedprice asc limit 1";
		$childnobeData=$this->db->query($chilno_sql)->row_array();
			
		$lineprice=array();
		if(!empty($adultData['lineprice'])){
			$lineprice[]=$adultData['lineprice'];
		}
			
		if(!empty($childData['lineprice'])){
			$lineprice[]=$childData['lineprice'];
		}
			
		if(!empty($childnobeData['lineprice'])){
			$lineprice[]=$childnobeData['lineprice'];
		}
			
		if(!empty($lineprice)){
			$linepriceArr['lineprice']=min($lineprice);//促销价
		}
			
		//修改线路
		$linepriceArr['modtime']=date("Y-m-d H:i:s",time());
		$linepriceArr['ordertime']=date('Y-m-d H:i:s',strtotime('+7 day'));
			
		$linepriceArr['saveprice']=0;
		
		$this->db->where(array('id'=>$line_id));
		$this->db->update('u_line', $linepriceArr);
		//定金
		if(!empty($linepriceAffil)){
			$this->update_rowdata('u_line_affiliated',$linepriceAffil,array('line_id'=>$line_id));
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return array('code'=>"4000",'msg'=>"操作失败");
		}else{
	
			return array('code'=>"200",'msg'=>"操作成功",'suitid'=>$suitArr);
		}
	}
	/**
	 * @method  修改线路库存 开放平台接口
	 * @param price
	 * @author xml
	 * @return suitId
	 */
	function save_priceStock_api($price,$lineArr){
		$suitArr=array();

		$line_id=$lineArr['id'];
		//供应商信息
		$supplier= $this->db->query("select id,code from u_supplier where id={$lineArr['supplier_id']}")->row_array();
		
		//保存套餐
		if(!empty($price)){
			
			$this->db->trans_start();
			
			foreach ($price as $key=>$val){
				
				if(intval($val['suitId'])>0){  //修改套餐
		        
					$suitArr[]=$val['suitId'];
						 
					$suitTid= $this->db->query("select id from u_line_suit where id={$val['suitId']} and lineid={$line_id} and is_open=1 ")->row_array();
					if(!empty($suitTid)){ //是否存在该套餐
		
						if(!empty($val['data'])){
							foreach ($val['data'] as $n=>$y){
								
								$ret = strtotime($y['day']);
								if(!$ret){
									return array('code'=>"4000",'msg'=>"出团日期格式出错");exit;
								}else{
									$y['day']=date("Y-m-d",$ret);
									if($y['day']<date("Y-m-d",time())){
										return array('code'=>"4000",'msg'=>"出团日期{$y['day']}以过期");exit;
									}	
								}
								if(!is_numeric($y['number'])){
									return array('code'=>"4000",'msg'=>"出团日期{$y['day']}的库存数据格式不对");exit;
								}
								
								$pirce_sql= $this->db->query("select dayid,description from u_line_suit_price where day='{$y['day']}' and is_open=1 and lineid={$line_id} and suitid={$val['suitId']}");
								$pirceArr = $pirce_sql->row_array();
		
								$insertSuit=$y;
								$insertSuit['suitid']=$val['suitId'];
								$insertSuit['lineid']=$line_id;
		
								if(!empty($pirceArr['dayid'])){
									 		
									$this->db->where(array('day'=>$y['day'],'lineid'=>$line_id,'suitid'=>$val['suitId'],'is_open'=>1));
									$this->db->update('u_line_suit_price', $insertSuit);
									 
								}else{
									 return array('code'=>"4000",'msg'=>"出团日期{$y['day']},不存在");exit;
								}
							}
						}else{
							return array('code'=>"4000",'msg'=>"数据不存在");exit;
						}
					}else{
						 return array('code'=>"4000",'msg'=>"套餐不存在");exit;
					}
				}else{
					 return array('code'=>"4000",'msg'=>"套餐ID不存在");exit;
				}
			}
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				return array('code'=>"4000",'msg'=>"操作失败");exit;
			}else{
			
				return array('code'=>"200",'msg'=>"修改成功",'suitid'=>$suitArr);exit;
			}
				
		}else{
				return array('code'=>"4000",'msg'=>"数据不存在");exit;
		}
		

	}
	//天数一样 +1
	public function get_lineday_code($login_id,$lineId,$line){

		$Ldaysql="select  id,supplier_id,days,code from u_supplier_day where supplier_id={$login_id} and days={$line['lineday']} ";
		$Ldaystr=$this->db->query($Ldaysql)->row_array();
		if(!empty($Ldaystr)){
			 $this->db->query("update  u_supplier_day set code=code+1 where supplier_id={$login_id} and days={$line['lineday']}");

			$lineAff=$this->db->query("select id from u_line_affiliated where line_id={$lineId}")->row_array();

			$Ldaystr['code']=$Ldaystr['code']+1;
			if(empty($lineAff)){
				$this->db->insert('u_line_affiliated',array('line_id'=>$lineId,'code'=>$Ldaystr['code']));
			}else{
				$this->db->query("update  u_line_affiliated set code={$Ldaystr['code']} where line_id={$lineId} ");	
			}	
			
		}else{
			$dayArr=array(
				'supplier_id'=>$login_id,
				'days'=>$line['lineday'],
				'code'=>1,
			);	
			$this->db->insert('u_supplier_day',$dayArr);


			$lineAff=$this->db->query("select id from u_line_affiliated where line_id={$lineId}")->row_array();

			if(empty($lineAff)){
				$this->db->insert('u_line_affiliated',array('line_id'=>$lineId,'code'=>1));
			}else{
				$this->db->query("update  u_line_affiliated set code=1 where line_id={$lineId} ");	
			}
		}
	}

	//套餐编号
	public function get_suit_code($line_id){
	  	//添加套餐编码
	  	$s_description="A";
		$d_suit=$this->db->query("select COUNT(id) as sum_suit from u_line_suit where lineid={$line_id}")->row_array();
		if(!empty($d_suit['sum_suit'])){
			$num=$d_suit['sum_suit']+1;
			for($i = 'A',$j=1; $i <= 'Z'; $i++,$j++) {
				if($j==$num){
					$s_description=$i;	
				} 
			}
		}else{
			$s_description="A";
		}
		return $s_description;
	}
	
	private function get_tylename($lineId){
		$line= $this->db->query("select l.id,l.line_classify,l.lineday,la.code,l.overcity from u_line  as l left join u_line_affiliated as la on l.id=la.line_id where l.id={$lineId} ")->row_array();
		return $line;
	}
	
	private function get_suppliercode(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$supplier= $this->db->query("select id,code from u_supplier where id={$arr['id']}")->row_array();
		return $supplier['code'];
	}
	
	private function get_suitCode($suitid){
		//套餐编号  A：第一个套餐（A B C D等，套餐N个就多个）
		$d_suit=$this->db->query("select description from u_line_suit where id={$suitid}")->row_array();
		$s_code='';
		if(!empty($d_suit['description'])){
			$s_code=$d_suit['description'];
		}
		return $s_code;
	}
	
	//团队编号
	public function get_team_code($lineId,$suitid,$day,$line,$suppCode,$suitCode){
		//var_dump($line['code']);exit;
		$time=strtotime($day);
		
		$tylename='B';
		if(!empty($line)){
			if($line['line_classify']==1){
				$tylename='A';
			}elseif($line['line_classify']==2){
				$tylename='B';
			}elseif ($line['line_classify']==3) {
				$tylename='C';
			}else{
				if(!empty($line['overcity'])){
					 $line_overcity=explode(',', $line['overcity']);
                     if(in_array("1", $line_overcity)){
                              $tylename='A';
                     }else{
                             $tylename='B';
                     }
				}else{
					$tylename='B';	
				}
				
			}
		}else{
			$tylename='B';
		}
		
		$codename=$tylename.'-'.date("ymd",$time).$suppCode.$line['lineday'].$suitCode.$line['code'];

		//判断是否有团号重复 
/*		$arr=$this->session->userdata ( 'loginSupplier' );
		$sql="select lsp.description from u_line_suit_price as lsp  left join u_line as l on lsp.lineid=l.id  ";
		$sql.="where  l.supplier_id={$arr['id']} and  lsp.description='{$codename}' and l.id !={$lineId} ";
		$data=$this->db->query($sql)->row_array();
		//echo $this->db->last_query();exit;
		if(!empty($data['description'])){
			return false; exit;
		}*/
		
		return $codename;
	}

	//线路的保险
	public function sel_line_insurance($lineid,$where){
		$query_sql="SELECT	tin.*, tin.id in ( select insurance_id from u_line_insurance where line_id={$lineid} and STATUS=1 ) as 'isexit',";
		$query_sql.=" tin.id IN (SELECT	insurance_id FROM u_line_insurance WHERE line_id = {$lineid}	AND STATUS = 1 AND isdefault=1) AS 'isd' FROM u_travel_insurance AS tin ";
		$query_sql.=" WHERE	tin.supplier_id =". $where['supplier_id']." AND tin.STATUS = ".$where['status'];
		$query = $this->db->query($query_sql);
		$rows = $query->result_array();
		return $rows;
	}
	//定制团的定制管家
	public function get_group_expert($lineid){
		$query_sql="SELECT e.id,e.realname,e.realname as nickname from u_line_apply as eu LEFT JOIN u_expert as e on eu.expert_id=e.id  where eu.line_id=".$lineid;
		$query = $this->db->query($query_sql);
		$rows = $query->row_array();
		return $rows;
	}
	public function get_user_shop_byid($id){//查询所有数据
		$query = $this->db->query('SELECT a.* FROM u_line a WHERE id=? LIMIT 1',array( 'id' => $id ));
		$row = $query->row_array();
		return $row;
	}
	
	private function chkDate($lineid,$suitid,$day){
		$query = $this->db->query("SELECT dayid FROM u_line_suit_price WHERE lineid=? AND suitid=? AND day=? ",array( 'lineid' => $lineid,'suitid' => $suitid,'day' => $day ));
		$rows = $query->result_array();
		return count($rows)==0?"":$rows[0]['dayid'];
	}
	
	public function get_user_shop_select($name,$where=''){//查询所有数据
		if(!empty($where)){
		   $this->db->where($where);
		}
		$query=$this->db->get($name);
		return $query->result_array();	
	}
	
	public function get_user_shop_select_array($name,$pid){//查询 $pid值
		$query=$this->db->get_where($name,array('pid'=>$pid));
		return $query->result();
	}
	
	public function get_user_shop_select_pid($name,$pid){//查询 $pid值
		$query=$this->db->get_where($name,array('pid'=>$pid));
		return $query->result_array();
	}
	
	public  function get_user_shop_num($name,$pid){//查询符合条件的$pid个数
		$query=$this->db->get_where($name,array('pid'=>$pid));
		return $query->num_rows();
	}
	
	public function get_user_shop_insert($name){
		//插入基础信息
		$this->db->insert('u_line',$name);
	}
	public function get_user_line_jieshao($data){
		//插入线路行程
		 $this->db->insert('u_line_jieshao ',$data);
		 return $this->db->insert_id();
	}
	public function linecodeupdate($id){
		$query = $this->db->query("UPDATE  u_line SET linecode=  CONCAT('L',$id )  where id=".$id);
		return $query;
	}
	public function grouplinecodeupdate($id){
		$query = $this->db->query("UPDATE  u_line SET linecode=  CONCAT('B',$id )  where id=".$id);
		return $query;
	}
	//插入表
	public function insert_data($table,$data){
		 $this->db->insert($table, $data);
		 return $this->db->insert_id();
	}
	//查询表
	public function select_data($table,$where){
		$this->db->select('*');
		if(!empty($where)){
			$this->db->where($where);
		}
	    
		return  $this->db->get($table)->result_array();
	}
	//查询表
	public function select_rowData($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		return  $this->db->get($table)->row_array();
	}
	//修改
	public function update_rowdata($table,$object,$where){
		$this->db->where($where);
		return $this->db->update($table, $object);
	}
	//判断线路是否已停售
	function get_line_online($lineid){
		$query = $this->db->query('select id from u_line where line_status=0 and (online_time="" or online_time="0000-00-00 00:00:00") and id='.$lineid);
		$rows = $query->result_array();
		return $rows;
	}
	//查询线路图片
	public function select_imgdata($lineid){
		$query = $this->db->query('select album.id as alid ,pic.id as pid ,album.filepath  from  u_line_pic as pic  JOIN u_line_album  as album on pic.line_album_id=album.id where pic.line_id='.$lineid);
		$rows = $query->result_array();
		return $rows;
	}
	//删除数据
	public function del_imgdata($table,$where){
		$this->db->where($where);
      		 return   $this->db->delete($table); 
	}
	//删除数据
	public function del_data($table,$where){
		$this->db->where($where);
		return   $this->db->delete($table);
	}
	//遍历交通方式表
	 public function description_data($type){
	 	$query = $this->db->query('SELECT dict_id,description FROM  u_dictionary WHERE pid IN (SELECT dict_id FROM  u_dictionary WHERE dict_code ="'.$type.'" ) ORDER BY showorder ASC');
	 	$rows = $query->result_array();
	 	return $rows;	
	 }
	//目的地的搜索 
	 public function destinations($like=''){	
	 	$this->db->select('id,kindname AS name,pid,level ');
		$this->db->from('u_dest_base');
		$this->db->where(array('level'=>3));
		$this->db->like('kindname',$like);	
		$query =$this->db->get();
		$rows= $query->result_array();
		return $rows;
		
	 }
	 //线路属性的搜索
	 public function search_atrr($like=''){
	 	$this->db->select('id,attrname AS name,pid');
	 	$this->db->from('u_line_attr');
	 	$this->db->like('attrname',$like);
	 	$query =$this->db->get();
	 	$rows= $query->result_array();
	 	return $rows;
	 }
	 /**
	  * 获取目的地
	  * @param string $ids 数组IDS
	  * @return string
	  */
	 public function getDestinationsID($ids = null){
	 	if(null!=$ids){
	 		$sql = 'SELECT id,kindname as name FROM u_dest_base WHERE id!=0  and level>2';
	 		$sql.=" AND id IN (";
	 		$i=0;
	 		foreach($ids as $v){
	 			if(!empty($v)){
		 			if($i>0){
		 				$sql.=',';
		 			}
		 			$sql.=$v;
		 			$i++;
	 			}
	 		}
	 		$sql.=" )";
	 		$query = $this->db->query($sql,$ids);
	 		$rows = $query->result_array();
	 	}
	 	return $rows;
	 }

	 /**
	  * 获取目的地
	  * @param string $ids 数组IDS
	  * @return string
	  */
	 public function getDestinationsDest($lineId){
	 	
	 	$sql = "SELECT ld.id,dn.kindname as name from u_line_dest as ld left JOIN u_dest_base as dn on ld.dest_id=dn.id  where dn.level >2 and line_id ={$lineId}";
	 	
	 	$query = $this->db->query($sql);
	 	$rows = $query->result_array();
	 	return $rows;
	 }
	 public function get_lineDestData($destArr){
	 	$data=array();
	 	foreach ($destArr as $k=>$v){
	 		if(!empty($v)){
	 			$mysql="SELECT id as dest_id,kindname as name FROM u_dest_base where id={$v}";
	 			$myquery = $this->db->query($mysql);
	 			$data[] = $myquery->row_array();
	 		}
	 		
	 	}
	 	return $data;
	 }
	// 获取目的地
	 public function getDestinationsData($lineId){
	 	$sql="select overcity2 from u_line where id={$lineId}"; 
	 //	$sql = "SELECT ld.id,dn.kindname as name,ld.dest_id from u_line_dest as ld left JOIN u_dest_base as dn on ld.dest_id=dn.id  where  ld.line_id ={$lineId}";	 
	 	$query = $this->db->query($sql);
	 	$rows = $query->row_array();
	 	if(!empty($rows['overcity2'])){
	 		$ids=explode(",",$rows['overcity2']);
	 		
	 		$mysql = 'SELECT id as dest_id,kindname as name FROM u_dest_base WHERE id!=0 ';
	 		$mysql.=" AND id IN (";
	 		$i=0;
	 		foreach($ids as $v){
	 			if(!empty($v)){
	 				if($i>0){
	 					$mysql.=',';
	 				}
	 				$mysql.=$v;
	 				$i++;
	 			}
	 		}
	 		$mysql.=" )";
	 		$myquery = $this->db->query($mysql,$ids);
	 		$data = $myquery->result_array();
	 		
	 		return $data;
	 	}else{
	 		return array();
	 	}
	 	
	 } 
	 //目的查询表
	 public function select_dest_data($where){
	 	$this->db->select('*');
	 	if(!empty($where)){
	 		$this->db->where($where);
	 	}
	 	$this->db->order_by('displayorder'); 
	 	//$this->db->limit(10);
	 	return  $this->db->get('u_dest_base')->result_array();
	 }
	 //线路属性
	 public function select_attr_data($where){
	 	$this->db->select('*');
	 	if(!empty($where)){
	 		$this->db->where($where);
	 	}
	 	$this->db->order_by('displayorder');
	 	return  $this->db->get('u_line_attr')->result_array();
	 }
	 //线路的目的地
	 //遍历交通方式表
	 public function select_destinations($lineid){
	 	$query = $this->db->query('select overcity from u_line where id='.$lineid);
	 	$rows = $query->row_array();
	 	return $rows;
	 }
	 //复制线路
	 public function copy_line($id,$type){
	 	
	 	$html='line_classify,linetype,producttype,nickname,linename,lineicon,linecode,product_recommend,startcity,overcity,line_beizhu,insurance,other_project,special_appointment,safe_alert,';
	 	$html=$html.'overcity2,book_notice,isacceptchild,lineday,linenight,linepic,linedoc,visa_content,hotel,beizu,feeinclude,feenotinclude,features,';
	 	$html=$html.'description,transport,linebefore,childrule,templet,supplier_id,first_pay_rate,final_pay_before,mainpic,linetitle,hotel_start,';
	 	$html=$html.'sell_direction,agent_rate,saveprice,confirm_time,lineprename,linedocname';
	 	$str=',addtime,modtime,status';
	 	$timestr=',now(),now(),0';
	 	$sql='INSERT INTO u_line ('.$html.$str.') SELECT '.$html.$timestr.' from u_line where id='.$id;
	 	$this->db->query($sql);
	 	$lid= $this->db->insert_id();
	 	if($lid>0){
		 	if($type=='line'){
		 	    $this->db->query("UPDATE  u_line SET linecode=  CONCAT('L',$lid ) ,linetitle=CONCAT(linetitle,' — 复制')  where id=".$lid);
		 	}elseif($type=='group'){
		 		//$this->grouplinecodeupdate1($lid);
		 		 $this->db->query("UPDATE  u_line SET linecode=  CONCAT('B',$lid ),linetitle=CONCAT(linetitle,' — 复制')  where id=".$lid);
		 	}else{
		 		//$this->linecodeupdate1($lid);
		 		$this->db->query("UPDATE  u_line SET linecode=  CONCAT('L',$lid ) ,linetitle=CONCAT(linetitle,' — 复制')  where id=".$lid);
		 	}
	 	}
	 	return $lid;
	 }

	 //复制行程
	 function copy_rout($id){
	 	 $string='jie.day,jie.title,jie.breakfirst,jie.breakfirsthas,jie.transport,jie.hotel,jie.jieshao,jie.lunchhas,jie.lunch,jie.supper,jie.supperhas,pic.pic ';
	 	 $sql_rout='select '.$string.' from u_line_jieshao as jie LEFT JOIN u_line_jieshao_pic as pic on pic.jieshao_id=jie.id where jie.lineid='.$id;
	 	 $query_rout = $this->db->query($sql_rout);
	 	 $rows = $query_rout->result_array();
	 	 return $rows;
	 }
	 //复制出发地
	 function copy_startplace($id){
	 	$sql_rout='select line_id,startplace_id from  u_line_startplace where line_id='.$id;
	 	$query_rout = $this->db->query($sql_rout);
	 	$rows = $query_rout->result_array();
	 	return $rows;
	 	
	 }
	 //复制出发地
	 function copy_line_dest($id){
	 	$sql_rout='select line_id,dest_id from  u_line_dest where line_id='.$id;
	 	$query_rout = $this->db->query($sql_rout);
	 	$rows = $query_rout->result_array();
	 	return $rows;
	 	 
	 }
	 //复制押金表
	 function copy_deposit($id){
	 	$sql='SELECT deposit,before_day from u_line_affiliated where line_id='.$id;
	 	$query= $this->db->query($sql);
	 	$rows = $query->result_array();
	 	return $rows;
	 }
	 //复制标签
	 function copy_line_type($id){
	 	$sql='SELECT line_id,attr_id from u_line_type where line_id='.$id;
	 	$query= $this->db->query($sql);
	 	$rows = $query->result_array();
	 	return $rows;
	 }
	 //复制图片
	 function copy_pic($id){
	 	$sql_pic='SELECT album.filepath FROM u_line_album AS album LEFT JOIN u_line_pic AS pic ON pic.line_album_id = album.id where pic.line_id='.$id.' LIMIT 5';
	 	$query_pic = $this->db->query($sql_pic);
	 	$rows = $query_pic->result_array();
	 	return $rows;
	 }
	 //复制套餐
	 function copy_suit($id){
	 	$sql_pic='SELECT suitname,description,child_description,old_description,special_description,unit,child_nobed_description from u_line_suit where lineid='.$id;
	 	$query_pic = $this->db->query($sql_pic);
	 	$rows = $query_pic->result_array();
	 	return $rows;
	 }
    //线路图片
    function sel_line_pic($id){
    	$sql_pic='SELECT filepath from u_line_pic as pic LEFT JOIN u_line_album as al on pic.line_album_id=al.id where pic.line_id='.$id;
    	$query_pic = $this->db->query($sql_pic);
    	$rows = $query_pic->result_array();
    	return $rows;
    }
    //目的地
    function select_destId_data(){
    	$this->db->select('id');
    	if(!empty($where)){
    		$this->db->where($where);
    	}
    	$this->db->order_by('displayorder');
    	return $this->db->get('u_dest_base')->result_array();
    }
    //插入礼品
    function insert_gift_data($insert,$lineid){	
    	$this->db->trans_start();	
    	$this->db->insert('luck_gift',$insert);
    	$gid=$this->db->insert_id();
    	//if($gid>0){
/*     		$row['line_id']=$lineid;
    		$row['gift_id']=$gid;
    		$row['gift_num']=$insert['account'];
    		$row['addtime']=date('Y-m-d H:i:s');
    		$row['modtime']=date('Y-m-d H:i:s');
    		$this->db->insert('luck_gift_line',$row); */
    //	}
    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		echo false;
    	}else{
    		return $gid;
    	}
    }
    /**
     *  * 修改礼品
     * @param  $giftArr   luck_gift礼品表
     * @param  $glineArr  luck_gift_line礼品线路关联表
     */
    function update_gift($giftArr, $glineArr,$where){
    	$this->db->trans_start();
    	$this->db->where($where)->update('luck_gift_line', $glineArr);
    	$this->db->where(array('id'=>$where['gift_id']))->update('luck_gift', $giftArr);;
    	//$updateGlineArr = $this->db->query(" update luck_gift_line SET ".$glineArr."  WHERE gift_id=".$where['gift_id'].' and line_id='.$where['line_id']);
    	//$updateGiftArr = $this->db->query(" update luck_gift SET ".$giftArr."  WHERE id=".$where['gift_id']);
    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		echo false;
    	}
    }
     /**
     *  * 线路礼品
     * @param  string   $lineid  线路id
  	 * @return array
     */
    function get_gift_data($lineid){
    	$sql_pic='SELECT gf.*,gl.id as glid,gl.gift_num from luck_gift_line as gl LEFT JOIN luck_gift as gf on gl.gift_id=gf.id where (gl.status=0 or gl.status>0) and gf.status!=-1 and gl.line_id='.$lineid;
    	$query_pic = $this->db->query($sql_pic);
    	$rows = $query_pic->result_array();
    	return $rows;
    }
    /**
     * 选择礼品
     * @param array $giftId 礼品ID
     * @param int   $line_id 线路ID
     * @return bool
     */
    function sel_gift_data($giftId,$gift_num,$line_id){
    	$this->db->trans_start();
    	if(!empty($giftId)){
    		foreach ($giftId as $k=>$v){
    			$insert=array(
    				'gift_id'=>$v,
    				'line_id'=>$line_id,
    				'addtime'=>date('Y-m-d H:i:s'),
    				'modtime'=>date('Y-m-d H:i:s'),
    				'status'=>1,
    				'gift_num'=>$gift_num[$k],
    			);
    			$this->db->insert('luck_gift_line',$insert);
    			
    			$sql='update luck_gift SET  account=account-'.$gift_num[$k].' where id='.$v;
    			$query = $this->db->query($sql);
    			
    		}
    	}
    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		echo false;
    	}
    } 
    /**
    *二级目的线路图片地址
    *@param $bourn 二级目的
    *@param $pic   添加的线路图片
    */
    function insert_pic_library($bourn,$pic,$supplier_id){
    	if(!empty($pic)){
    		foreach ($pic as  $k=>$v){
    			if(!empty($v)){
    				foreach ($bourn as $key=>$val){
    					$b_pic=$this->user_shop_model->select_rowData('u_line_picture_library',array('pic'=>$v,'dest_id'=>$val));
    					if(empty($b_pic)){
	    					$picArr=array(
	    						'supplier_id'=>$supplier_id,
	    						 'dest_id'=>$val,
	    						'pic'=>$v
	    					);
	    					$this->insert_data('u_line_picture_library',$picArr);
    					}
    				}
    			}
    		}
    	}
    }
    /**
     * 记录二级目的地的图片库
     * @param $picArr 图片数组
     * @param $dest   二级目的地 
     */
    function second_pic_library($picstr,$dest,$supplier_id){
       if(!empty($picstr)){
       	$picArr=explode(';',$picstr);
       	foreach ($picArr as $k=>$v){
       		if(!empty($v)){
	    	 	if(!empty($dest)){
	    	 		foreach ($dest as $key=>$val){
	    	 			$b_pic=$this->user_shop_model->select_rowData('u_line_picture_library',array('pic'=>$picArr[$k],'dest_id'=>$val,'supplier_id'=>$supplier_id));
	    	 			if(empty($b_pic)){
			    	 		$bpicArr=array(
			    	 				'supplier_id'=>$supplier_id,
			    	 				'dest_id'=>$val,
			    	 				'pic'=>$picArr[$k]
			    	 		);
			    	 		$this->insert_data('u_line_picture_library',$bpicArr);
	    	 			}
	    	 		}
	    	 	}
       	 	 } 
          }
       }
    }
    // 获取二级目的地的相册图片$type为0 默认选择六个。
    function get_picture_library($where='',$limit='',$type=0){
    	$this->db->select('pl.id,pl.pic,dt.kindname,dt.id as dest_id ');
    	$this->db->from('u_line_picture_library as pl ');
    	$this->db->join('u_dest_base as dt','pl.dest_id=dt.id','left');
    	if(!empty($where)){
    		$this->db->where($where);
    	}
    	if(!empty($limit)){
    		//$this->db->limit($limit);
    		$page=$limit;
    		if ($page > 0) {
    			$offset = ($page-1) * 12;
    			//$query_sql .=' limit ' .$offset.','.$num;
    			$this->db->limit(12,$offset);
    		}
    	}
    	if($type==0){
    		$this->db->group_by("pl.pic");
    	}
    	$this->db->order_by('pl.id desc');
    	$query =$this->db->get();
    	
    	return $query->result_array();
    }
     //获取相应照片的二级目的地的
    function get_dest_pic($supplier_id){
    	$sql_pic='SELECT dt.kindname,dt.id AS dest_id from u_line_picture_library  AS pl  LEFT JOIN `u_dest_base` AS dt ON `pl`.`dest_id` = `dt`.`id` where supplier_id='.$supplier_id.' GROUP BY dest_id ';
    	$query_pic = $this->db->query($sql_pic);
    	return $query_pic->result_array();
    }
    //获取相应相册图片的分页
    function line_picture_library($whereArr ,$page_new = 1, $number = 10 ,$is_page = 1 ,$likeArr = array()){
    	$this->db->select('pl.id,pl.pic,dt.kindname,dt.id as dest_id ');
    	$this->db->from('u_line_picture_library as pl ');
    	$this->db->join('u_dest_base as dt','pl.dest_id=dt.id','left');
    	$this->db->group_by("pl.pic");
    	$this->db->order_by('pl.id desc');
    	$this ->db ->where($whereArr);
    	
    	if (!empty($likeArr) && is_array($likeArr)) {
    		$this ->db ->where($likeArr);
    	}
    	if ($is_page == 1) {
    		$number = empty ( $number ) ? 10 : $number;
    		$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
    		$this->db->limit ( $number, $offset );
    	}
    	$query = $this->db->get ();
    	return $query->result_array ();
    }
    /**
     *@method    编辑线路的基本信息
     * @param    $data  线路基本信息   
     * @param    $startcity  出发地
     * @param    $line_pic   线路图片
     */
    function save_line_base($type,$data,$startcity,$line_pic,$expert=0,$overcityArr,$id,$LineAff=array(),$b_expert_id=0,$departId=array()){
    	
    	//修改线路信息
    	$this->db->where('id', $id)->update('u_line', $data);
    	
    	//保存线路出发地
    	if(!empty($startcity)){
    		
    		$cityArr=explode(',', $startcity);
    		$citystr=array();
    		$cityData=$this->db->select('startplace_id')->where(array('line_id'=>$id))->get('u_line_startplace')->result_array();
    		if(!empty($cityData)){
		            foreach ($cityData as $k=>$v){  //没选中的出发地就删除
		            	if(!empty($v['startplace_id'])){
		            		$citystr[]=$v['startplace_id'];
		            		if(!in_array($v['startplace_id'],$cityArr)){
		            			$this->db->where(array('line_id'=>$id,'startplace_id'=>$v['startplace_id']))->delete('u_line_startplace');
		            		}
		            	}
		            } 		
    		}
    		foreach ($cityArr as $k=>$v){
    			if($v>0){
    				 if(!in_array($v,$citystr)){  //不存在该出发地就插入
    				 	$this->insert_data('u_line_startplace',array('line_id'=>$id,'startplace_id'=>$v));//插入表
    				 }
    			}
    		} 
    	}
    	
    	$img_conut=$this->select_imgdata($id);
	    //保存线路图片
    	if(!empty($line_pic)){
    		foreach ($line_pic as  $k=>$v){  			
    			if(count($img_conut)<5){
	    			if(!empty($v)){
	    				$datas['filename']='line';
	    				$datas['filepath']=$v;
	    				$reid=$this->insert_data('u_line_album',$datas);//插入图片表
	    				$re['line_id']=$id;
	    				$re['line_album_id']=$reid;
	    				$this->insert_data('u_line_pic',$re);//插入图片表
	    			}
    			}
    		}
    	}
    	
    	//定制管家
    	if($b_expert_id>0){
    		$line_apply=$this->get_user_shop_select('u_line_apply',array('line_id'=>$id));
    		if(empty($line_apply)){
    			$expertArr=array(
    				'grade'=>1,
    				'line_id'=>$id,
    				'expert_id'=>$b_expert_id,
    				'status'=>2,
    				'addtime'=>date("Y-m-d H:i:s",time()),
    			);
    			$this->insert_data('u_line_apply',$expertArr);
    		}else{
    			 
    			$expertArr=array(
    				'expert_id'=>$b_expert_id,
    			);
    			$this->update_rowdata('u_line_apply',$expertArr,array('line_id'=>$id));
    		}   	
    	}else{
    		$this->db->where(array('line_id'=>$id))->delete('u_line_apply');
    	}

    	$arr=$this->session->userdata ( 'loginSupplier' );
		$supplier_id=$arr['id'];
    	if($type==1){  //-----定制团-------
    		 //联盟管家
    		$this->db->where(array('line_id'=>$id))->delete('u_line_package');
	    	if(!empty($departId)){	
	    		foreach ($departId as $key => $value) {
	    			$u_expertArr=array(
	    			'line_id'=>$id,
	    			'depart_id'=>$value,
	    			'expert_id'=>$expert[$key],
	    			'addtime'=>date("Y-m-d H:i:s",time()),
	    			);
	    			$this->insert_data('u_line_package',$u_expertArr);

	    			//联盟审核线路表
					$union = $this->db->query("select id,union_id from b_depart where id={$departId[$key]} ")->row_array();
					if(!empty($union)){
						$approve=$this->db->query("select id from b_union_approve_line where supplier_id={$supplier_id} and union_id={$union['union_id']} and line_id={$id} ")->row_array();
						if(empty($approve)){
							$insert=array(
								'status'=>0,
								'union_id'=>$union['union_id'],
								'supplier_id'=>$supplier_id,
								'line_id'=>$id,
								'addtime'=>date("Y-m-d H:i:s",time()),
							);
							$this->db->insert('b_union_approve_line',$insert);	
						}
					}

	    		}
	    	}
    	}

    	
    	//目的地
    	if(!empty($overcityArr)){
    		$overcityData=$this->db->select('dest_id')->where(array('line_id'=>$id))->get('u_line_dest')->result_array();
    		if(!empty($overcityData)){
		            foreach ($overcityData as $k=>$v){  //没选中的出发地就删除
		            	if(!empty($v['dest_id'])){
		            		$overcitystr[]=$v['dest_id'];
		            		if(!in_array($v['dest_id'],$overcityArr)){
		            			$this->db->where(array('line_id'=>$id,'dest_id'=>$v['dest_id']))->delete('u_line_dest');
		            		}
		            	}
		            } 		
    		}
    		foreach ($overcityArr as $k=>$v){
    			if($v>0){
    				if(empty($overcitystr)){
    					$overcitystr=array();
    				}
    				if(!in_array($v,$overcitystr)){  //不存在该出发地就插入
    				 	$this->insert_data('u_line_dest',array('line_id'=>$id,'dest_id'=>$v));//插入表
    				}
    			}
    		} 
    	} 
    	//线路押金,押金
    	if(!empty($LineAff)){
    		$Aff=$this->db->select('id,line_id,before_day,hour,minute')->where(array('line_id'=>$id))->get('u_line_affiliated')->row_array();
    		if(empty($Aff)){
    			$LineAff['line_id']=$id;
			$this->insert_data('u_line_affiliated',$LineAff);//插入表
    		}else{
    			$this->update_rowdata('u_line_affiliated',$LineAff,array('line_id'=>$id));
    		}
    	}

    }

    //保存添加线路
    function save_linedata($supplier_id,$data,$startcity,$line_pics_arr,$overcityArr,$expert=array(),$LineAff=array(),$b_expert_id=0,$departId=array()){
    
    	//插入线路
    	$this->db->insert ( 'u_line', $data );
    	$lineId = $this->db->insert_id();
    	
    	//添加线路出发地   
    	$cityArr=explode(',', $startcity);
    	if(!empty($cityArr)){
    		foreach ($cityArr as $k=>$v){
    			if($v>0){
    				$this->insert_data('u_line_startplace',array('line_id'=>$lineId,'startplace_id'=>$v));//插入表
    			}
    		}
    	}
    	
        	//插入线路图片
    	if(!empty($line_pics_arr)){
    		foreach ($line_pics_arr as  $k=>$v){
    			if(!empty($v)){
    				$datas['filename']='line';
    				$datas['filepath']=$v;
    				$this->insert_data('u_line_album',$datas);//插入图片表
    				$reid=  $this->db->insert_id();
    	
    				$re['line_id']=$lineId;
    				$re['line_album_id']=$reid;
    				$this->insert_data('u_line_pic',$re);//插入图片表
    			}
    		}
    	}

    	//添加线路的目的地
        if(!empty($overcityArr)){
           	foreach ($overcityArr as $k => $v) {
           		if($v>0){
    				$this->insert_data('u_line_dest',array('line_id'=>$lineId,'dest_id'=>$v));//插入表
    			}
           	}
        }


        
        //线路押金,押金
    	if(!empty($LineAff)){
    		$Aff=$this->db->select('id,deposit,line_id,before_day,hour,minute')->where(array('line_id'=>$lineId))->get('u_line_affiliated')->row_array();
    		if(empty($Aff)){
    			$LineAff['line_id']=$lineId;
			$this->insert_data('u_line_affiliated',$LineAff);//插入表
    		}else{
    			$this->update_rowdata('u_line_affiliated',$LineAff,array('line_id'=>$lineId));
    		}
    	}

       if($lineId>0){
       		return $lineId;
       }else{
       		return 0;
       }
    		
    	
    }

    function select_line_package($lineid){
    	$this->db->select('lp.line_id,lp.depart_id,lp.expert_id,e.realname as nickname,e.realname,d.name ');
    	$this->db->from('u_line_package AS lp ');
    	$this->db->join('u_expert AS e','e.id= lp.expert_id','left');
    	$this->db->join('b_depart AS d','d.id= lp.depart_id','left');
    	$this ->db ->where(array('lp.line_id'=>$lineid));
    	$query = $this->db->get ();
    	return $query->result_array ();	
    }

    //获取线路出发地
    function  select_startplace($likeArr){
    	$this->db->select('ls.id,ls.line_id,ls.startplace_id,st.cityname');
    	$this->db->from('u_line_startplace AS ls ');
    	$this->db->join('u_startplace AS st','st.id = ls.startplace_id','left');
    	$this ->db ->where($likeArr);
    	$query = $this->db->get ();
    	return $query->result_array ();
    }
  	public function insertScenic($scenicArr ,$picArr){
		$this->db->trans_start();
		$this ->db ->insert('scenic_spot' ,$scenicArr);
		$id = $this ->db ->insert_id();
		foreach($picArr as $v)
		{
			$dataArr = array(
					'scenic_spot_id' =>$id,
					'pic' =>$v
			);
			$this ->db ->insert('scenic_spot_pic' ,$dataArr);
		}
		
		$this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		echo false;
	    	}else{
	    		return $id;
	    	}

	}
	//保存线路景点
	public function save_line_spot($spot,$line_id){
		$this->db->trans_start();
		$this->db->where(array('line_id'=>$line_id))->delete('u_line_spot');
        if(!empty($spot)){   
               //$expert_destArr=explode(',', $expert_dest) ;
               $spotArr=explode(',', $spot);
               $spotstr=array();
    /*         $spotData=$this->db->select('id,spot_id')->where(array('line_id'=>$line_id))->get('u_line_spot')->result_array();
                    if(!empty($spotData)){
                                foreach ($spotData as $k=>$v){  //没选中的就删除
                                            if(!empty($v['spot_id'])){
                                                  $spotstr[]=$v['spot_id'];
                                                  if(!in_array($v['spot_id'],$spotArr)){
                                                              $this->db->where(array('line_id'=>$line_id,'spot_id'=>$v['spot_id']))->delete('u_line_spot');
                                                  }
                                            }
                                }           
                    }*/
                foreach ($spotArr as $k=>$v){
                       if(!empty($v)){
                            $this->insert_data('u_line_spot',array('line_id'=>$line_id,'spot_id'=>$v));//插入表
                       }
                } 
        }

		$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		echo false;
    	}else{
    		return true;
    	}
	}
	//选中的景点
	function select_line_spot($line_id){
		    $this->db->select('ls.id,ls.spot_id,sst.name,sst.city_id,sst.status');
	    	$this->db->from('u_line_spot as ls ');
	    	$this->db->join('scenic_spot as sst','ls.spot_id=sst.id','left');
	    	$this->db->where(array('line_id'=>$line_id));
	    	$this->db->order_by('ls.id asc');
	    	$query =$this->db->get();
	    	return $query->result_array();
	}
	/**
	 * @method 获取线路附属表信息
	 * @author jkr
	 * @param unknown $lineId
	 */
	public function getLineAffiliated($lineId) {
		$sql = 'select * from u_line_affiliated where line_id ='.$lineId;
		return $this ->db ->query($sql) ->row_array();
	}
	//团队收款列表
	public function get_team_list($param,$page,$supplier_id){
		$query_sql  ='select l.linebefore,lsp.dayid,lsp.day,lsp.description as desp,l.lineday,l.line_kind,';
		$query_sql.='lsp.lineid,l.linecode,l.linename,suit.suitname,suit.id as suit_id,';
		$query_sql.='(SUM(mo.dingnum)+SUM(mo.oldnum)+SUM(mo.childnum)+SUM(mo.childnobednum)) as number ,';
		$query_sql.='SUM(mo.dingnum) as total_dingnum,SUM(mo.oldnum) as total_oldnum,SUM(mo.childnum) as total_childnum,';
		$query_sql.='SUM(mo.childnobednum) as total_childnobednum,SUM(mo.balance_money) as t_balance_money, ';
		$query_sql.='sum(mo.supplier_cost-mo.platform_fee-balance_money)as unfund_money,mo.platform_fee as  pay_money,';
		$query_sql.='SUM(mo.supplier_cost-mo.platform_fee) as t_supplier_cost,sum(mo.total_price) as t_total_price,';
		$query_sql.='SUM(mo.id) as mom_num ';
		$query_sql.='from u_line_suit_price as lsp ';
		$query_sql.='left join u_line as l on lsp.lineid = l.id ';
		$query_sql.='left join u_line_suit as suit on suit.id = lsp.suitid ';
		$query_sql.='left join u_member_order mo on lsp.suitid = mo.suitid and mo.status>=4 and  mo.status<=8 and mo.usedate = lsp.day ';
		//$query_sql.='left join u_order_receivable mor on mo.id=mor.order_id and mor.status=2 ';
		$query_sql.='where	l.supplier_id='.$supplier_id;

		if(null!=array_key_exists('linencode', $param)){
			$query_sql.=' AND  l.linecode= ? ';
			$param['linencode'] = trim($param['linencode']);
		}
		if(null!=array_key_exists('linename', $param)){
			$query_sql.=' AND l.linename like ? ';
			$param['linename'] = '%'.$param['linename'].'%';
		}
		if(null!=array_key_exists('starttime', $param)){
			$query_sql.=' AND lsp.day  >= ? ';
			$param['starttime'] = trim($param['starttime']);
		}
		if(null!=array_key_exists('endtime', $param)){
			$query_sql.=' AND lsp.day  <= ? ';
			$param['endtime'] = trim($param['endtime']);
		}
		if(null!=array_key_exists('s_lineday', $param)){
			$query_sql.=' AND l.lineday  >= ? ';
			$param['s_lineday'] = trim($param['s_lineday']);
		}
		if(null!=array_key_exists('e_lineday', $param)){
			$query_sql.=' AND l.lineday  <= ? ';
			$param['e_lineday'] = trim($param['e_lineday']);
		}
		if(null!=array_key_exists('linensn', $param)){
			$query_sql.=' AND  lsp.description= ? ';
			$param['linensn'] = trim($param['linensn']);
		}
		$query_sql.=' group by lsp.dayid ';


		$totalRecords = $this->getCount($query_sql,$param);
		$pageSize = $page->pageSize;
		$totalPages = ceil($totalRecords / $pageSize);

		$pageNum = $page->pageNum;
		
		if ($pageNum > $totalPages){
			$pageNum = $totalPages;
		}
		if($pageNum==0){
			$pageNum=1;
		}
		$sql=$query_sql.' LIMIT ?,?';
		if(null==$param){
			$param = array();
		}
		$param['start'] = ($pageNum-1) * $pageSize;
		$param['size'] = $pageSize;
		
		$query = $this->db->query($sql, $param);
		$result = $query->result();
	

		foreach ($result as $key => $value) {

			$dayid=$value->dayid;
			$day=$value->day;
			$mysql="select sum(mor.money) as pay_money from u_line_suit_price as lsp   left join u_member_order mo  on lsp.suitid =mo.suitid and mo.status>=4 and  mo.status<=8 and mo.usedate =lsp.day left join  u_order_receivable mor  on mor.order_id=mo.id and mor.status=2 ";
			$mysql=$mysql." where  lsp.dayid ={$dayid} group by lsp.dayid ";
			$myquery = $this->db->query($mysql);
			$myresult = $myquery->row_array();
			//echo $this->db->last_query();exit;
			if(!empty($myresult)){
				$value->pay_money=$myresult['pay_money'];
			}else{
				$value->pay_money=0;
			}

		}	

	

		return $this->queryPageJson( $query_sql , $param ,$page,1 ,$result);

	}
	//团号的订单列表
	function get_order_list($dayid,$suitid){
		$query_sql  ="SELECT mo.id,(mo.dingnum+mo.oldnum+mo.childnum+mo.childnobednum) as order_member,mo.usedate,";
		$query_sql.="l.lineday,mo.addtime,mo.user_type,e.realname,mo.status as order_status,mo.ordersn, ";
		$query_sql.="(mo.supplier_cost-mo.platform_fee-balance_money)as unfund_money,(mo.balance_money) as t_balance_money ,";
		$query_sql.=" (mo.supplier_cost-mo.platform_fee) as t_supplier_cost ";
		$query_sql.="FROM	 u_member_order mo ";
		$query_sql.="LEFT JOIN  u_line_suit_price AS lsp ON lsp.suitid = mo.suitid  AND mo.usedate = lsp.day ";
		$query_sql.="LEFT JOIN u_line AS l ON lsp.lineid = l.id ";
		$query_sql.="LEFT JOIN u_line_suit AS suit ON suit.id = lsp.suitid ";	
		$query_sql.="LEFT JOIN u_expert as e on mo.expert_id=e.id ";
		//$query_sql.="LEFT JOIN u_order_receivable mor on mo.id=mor.order_id and mor.status=2 ";
		$query_sql.="WHERE  lsp.dayid={$dayid}  and mo.status>=4 and  mo.status<=8 ";
		if(!empty($suitid)){
			$query_sql.=" and suit.id={$suitid} ";
		}
		
		$query_sql.="GROUP BY mo.id ";
		$rows = $this->db->query($query_sql)->result_array();

		foreach ($rows as $key => $value) {

			$dayid=$dayid;
			$day=$value['usedate'];
			//$mysql="select sum(mor.money) as pay_money from u_line_suit_price as lsp   left join u_member_order mo  on lsp.suitid =mo.suitid and mo.status>=4 and  mo.status<=8 and mo.usedate =lsp.day  left join  u_order_receivable mor  on mor.order_id=mo.id and mor.status=2 ";
			$mysql="select sum(mor.money) as pay_money  from u_order_receivable as mor where mor.order_id={$value['id']} and mor.status=2";
			//$mysql=$mysql." where  mo.id={$value['id']} ";
			$myquery = $this->db->query($mysql);
			$myresult = $myquery->row_array();
			//echo $this->db->last_query();exit;
			if(!empty($myresult)){
				$rows[$key]['pay_money']=$myresult['pay_money'];
			}else{
				$rows[$key]['pay_money']=0;
			}

		}

		return $rows;
	}
	function get_line_itemlist($param,$from="",$page_size="10"){
		$query_sql  ="select  lsp.day,lsp.number,lst.suitname,l.linetitle,l.linename,l.linecode,l.id as line_id,lsp.suitid,lsp.description ,";
		$query_sql  .=" l.lineday,lsp.adultprice,lsp.childnobedprice,lsp.childprice,lsp.room_fee,lsp.oldprice,0 as startcity,laff.deposit,  ";
		$query_sql.=' SUM(mo.dingnum) as total_dingnum,SUM(mo.childnum) as total_childnum,lsp.before_day,lsp.hour,lsp.minute,';
		$query_sql.=' SUM(mo.childnobednum) as total_childnobednum,DATE_FORMAT(NOW(),"%Y-%m-%d") as nowdate ';
		$query_sql  .=" from u_line_suit_price as lsp ";
		$query_sql  .=" left join u_line_suit as lst on lsp.suitid = lst.id ";
		$query_sql  .=" left join u_line as l on lst.lineid=l.id ";
		$query_sql  .=" left join u_line_affiliated as laff on laff.line_id=l.id ";
		//$query_sql  .=" left join u_line_startplace  on l.id=u_line_startplace.line_id ";
		//$query_sql  .=" left join u_startplace pl  on pl.id = u_line_startplace.startplace_id ";
		$query_sql.='  left join b_union_approve_line  as apl  on l.id=apl.line_id ';
		$query_sql.="left join u_member_order as mo on   lsp.suitid = mo.suitid  AND mo.usedate = lsp.day and mo.status>=4 and  mo.status<=8 ";
		$query_sql  .=" where l.line_kind=1 and apl.status=2 and lsp.is_open=1  ";
		//$query_sql  .=" and bal.status!=3 and bal.status!=-1";

		if(!empty($param['supplier_id'])){
			$param['supplier_id'] = $param['supplier_id'];
			$query_sql.=' AND l.supplier_id = '.$param['supplier_id'];
			
		}
		if(!empty($param['linecode'])){
			$param['linecode'] = trim($param['linecode']);
			$query_sql.=' AND l.linecode  = "'.$param['linecode'].'"';	
		}
		if(!empty($param['linename'])){
			$param['linename'] = '%'.$param['linename'].'%';
			$query_sql.=' AND l.linename  like "'.$param['linename'].'"' ;
			
		}
		if(!empty($param['lineitem'])){
			$param['lineitem'] = trim($param['lineitem']);
			$query_sql.=' AND lsp.description = "'.$param['lineitem'].'"';
			
		}
		if(!empty($param['starttime'])){
			$param['starttime'] =trim($param['starttime']);
			$query_sql.=' AND lsp.day >= "'.$param['starttime'].'"' ;
			
		}
		if(!empty($param['endtime'])){
			$param['endtime'] = trim($param['endtime']);
			$query_sql.=' AND lsp.day <="'.$param['endtime'].'"';
			
		}
		$time=date("Y-m-d",time());
		if($param['type']==1){
			$query_sql.=' AND  lsp.day >="'.$time.'"';
		}else{
			$query_sql.=' AND lsp.day <"'.$time.'"';
		}

		$query_sql.=' GROUP BY lsp.dayid order by lsp.dayid desc ';

		$return['rows']=$this->db->query($query_sql)->num_rows();
		
		if(!empty($page_size))
		$query_sql=$query_sql." limit {$from},{$page_size}";
		$return['result']=$this->db->query($query_sql)->result_array();
	
		foreach ($return['result'] as $key => $value) {
			$line_id=$value['line_id'];
			$mysql="select GROUP_CONCAT(pl.cityname) AS startcity from  u_line_startplace  as ls ";
			$mysql  .=" left join u_startplace pl  on pl.id = ls.startplace_id  where ls.line_id={$line_id}  GROUP BY ls.line_id ";
			$myquery = $this->db->query($mysql);
			$myresult = $myquery->row_array();

			if(!empty($myresult)){
				$return['result'][$key]['startcity']=$myresult['startcity'];
			}else{
				$return['result'][$key]['startcity']='';
			}
		}

		$return['sql']=$query_sql;
	
		return $return;

	}	
	//计划线路
/*	function get_line_item($param,$page){
		$query_sql  ="select  lsp.day,lsp.number,lst.suitname,l.linetitle,l.linename,l.linecode,l.id as line_id,lsp.suitid,lsp.description ,";
		$query_sql  .=" l.lineday,lsp.adultprice,lsp.childnobedprice,lsp.childprice,lsp.oldprice,0 as startcity,laff.deposit,  ";
		$query_sql.=' SUM(mo.dingnum) as total_dingnum,SUM(mo.oldnum) as total_oldnum,SUM(mo.childnum) as total_childnum,';
		$query_sql.=' SUM(mo.childnobednum) as total_childnobednum';
		$query_sql  .=" from u_line_suit_price as lsp ";
		$query_sql  .=" left join u_line_suit as lst on lsp.suitid = lst.id ";
		$query_sql  .=" left join u_line as l on lst.lineid=l.id ";
		$query_sql  .=" left join u_line_affiliated as laff on laff.line_id=l.id ";
		//$query_sql  .=" left join u_line_startplace  on l.id=u_line_startplace.line_id ";
		//$query_sql  .=" left join u_startplace pl  on pl.id = u_line_startplace.startplace_id ";
		$query_sql.='  left join b_union_approve_line  as apl  on l.id=apl.line_id ';
		$query_sql.="left join u_member_order as mo on   lsp.suitid = mo.suitid  AND mo.usedate = lsp.day and mo.status>=4 and  mo.status<=8 ";
		$query_sql  .=" where l.line_kind=1 and apl.status=2  ";
		//$query_sql  .=" and bal.status!=3 and bal.status!=-1";

		if(null!=array_key_exists('supplier_id', $param)){
			$query_sql.=' AND l.supplier_id = ? ';
			$param['supplier_id'] = $param['supplier_id'];
		}
		if(null!=array_key_exists('linecode', $param)){
			$query_sql.=' AND l.linecode  = ? ';
			$param['linecode'] = trim($param['linecode']);
		}
		if(null!=array_key_exists('linename', $param)){
			$query_sql.=' AND l.linename  like ? ';
			$param['linename'] = '%'.$param['linename'].'%';
		}
		if(null!=array_key_exists('lineitem', $param)){
			$query_sql.=' AND lsp.description = ? ';
			$param['lineitem'] = trim($param['lineitem']);
		}
		if(null!=array_key_exists('starttime', $param)){
			$query_sql.=' AND lsp.day >= ? ';
			$param['starttime'] = trim($param['starttime']);
		}
		if(null!=array_key_exists('endtime', $param)){
			$query_sql.=' AND lsp.day <= ? ';
			$param['endtime'] = trim($param['endtime']);
		}


		$query_sql.=' GROUP BY lsp.dayid order by lsp.dayid desc ';



		$totalRecords = $this->getCount($query_sql,$param);
		$pageSize = $page->pageSize;
		$totalPages = ceil($totalRecords / $pageSize);

		$pageNum = $page->pageNum;
		
		if ($pageNum > $totalPages){
			$pageNum = $totalPages;
		}
		if($pageNum==0){
			$pageNum=1;
		}
		$sql=$query_sql.' LIMIT ?,?';
		if(null==$param){
			$param = array();
		}
		$param['start'] = ($pageNum-1) * $pageSize;
		$param['size'] = $pageSize;
		
		$query = $this->db->query($sql, $param);
		$result = $query->result();
	

		foreach ($result as $key => $value) {

			$line_id=$value->line_id;
			$mysql="select GROUP_CONCAT(pl.cityname) AS startcity from  u_line_startplace  as ls ";
			$mysql  .=" left join u_startplace pl  on pl.id = ls.startplace_id  where ls.line_id={$line_id}  GROUP BY ls.line_id ";
			$myquery = $this->db->query($mysql);
			$myresult = $myquery->row_array();

			if(!empty($myresult)){
				$value->startcity=$myresult['startcity'];
			}else{
				$value->startcity='';
			}

		}	
		return $this->queryPageJson( $query_sql , $param ,$page,1 ,$result);

	}*/
	/**
	 * @method 产品标签 开放平台接口 api
	* @param lineArr
	* @author xml
	*/
	function get_line_attr($line_id){
		$sql="select lat.id,lat.attrname from u_line_type as lt left join u_line_attr as lat on lt.attr_id=lat.id where lt.line_id={$line_id}";
		$query = $this->db->query ( $sql );
		$info = $query->result_array ();
		return $info;
	}
	
}