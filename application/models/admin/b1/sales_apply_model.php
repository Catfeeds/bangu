<?php
/****
 * 深圳海外国际旅行社
 * 艾瑞可
 * 2015-3-18
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Sales_apply_model extends MY_Model{
	private $table_name = ' u_sales_line';
	function __construct() {
		parent::__construct ( $this->table_name );
	}	
	function get_line_sales($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		$query_sql='select sl.lineid,sl.isOnline,l.status,l.linename,l.linecode,sl.sort,sl.lineName as sale_name,st.typeName,GROUP_CONCAT(pl.`cityname`) as startcity ';
		$query_sql.=' from  u_sales_line as sl';
		$query_sql.=' left join u_line as l on sl.lineid = l.id';
		$query_sql.=' left join  u_sales_type  as st on st.typeId=sl.typeId';
		$query_sql.=' left join u_line_startplace as start on l.id=start.line_id';
		$query_sql.=' left join u_startplace pl  on pl.id = start.startplace_id ';
		$query_sql.=' where l.supplier_id ='.$login_id;
		
		if($param!=null){
		
			if(null!=array_key_exists('typeId', $param)){
				$query_sql.=' AND sl.typeId= ? ';
				$param['typeId'] =($param['typeId']);
			}
			if(null!=array_key_exists('linecode', $param)){
				$query_sql.=' AND l.linecode LIKE ? ';
				$param['linecode'] = '%'.trim($param['linecode']).'%';
			}
			if(null!=array_key_exists('linename', $param)){
				$query_sql.=' AND l.linename LIKE ? ';
				$param['linename'] = '%'.trim($param['linename']).'%';
			}
			if(null!=array_key_exists('sales_name', $param)){
				$query_sql.=' AND sl.lineName LIKE ? ';
				$param['sales_name'] = '%'.trim($param['sales_name']).'%';
			}
				
		}
		$query_sql.=' GROUP BY sl.lineid ORDER BY sl.sort desc';
		
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	//	//查询表
	public function select_data($table,$where){
		$this->db->select('*');
		if(!empty($where)){
			$this->db->where($where);
		}
	    
		return  $this->db->get($table)->result_array();
	}
	//添加促销数据
	function add_linesales_Data($data){
		$this->db->trans_start ();
        //线路表 
       
		$this->db->insert('u_sales_line',$data);
		$id=$this->db->insert_id();
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}
	//编辑促销线路的数据
	function edit_linesales_Data($data){
		$this->db->trans_start ();
		//线路表
		$line=$this->db->select('*')->where(array('id'=>$data['lineId']))->get('u_line')->row_array();
		
		//u_sales_type  促销表
		$lineId=$data['lineId'];
		unset($data['lineId']); 
		$this->db->where (array('lineId'=>$lineId))->update ( 'u_sales_line', $data );

		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		} 
	}
  /**
   *  * 保存套餐价格
   * @param int     $lineId 线路ID
   * @param Array   $lineArr 线路
   * @param Array   $suit_arr 套餐信息
   * @return bool
   */

  public function saveSalesLinePrice($suit_arr,$lineId){
  
  	$this->db->trans_start();
  
  	$this->load->library('session');
  	$arr=$this->session->userdata ( 'loginSupplier' );
  	$login_id=$arr['id'];
   
  	$falg=1;
  	$msg="保存成功";
  	//保存套餐
  	if(!empty($suit_arr)){
  
  		//------------------------------------------------------修改价格----------------------------------------------	
  		foreach ($suit_arr as $k=>$v){
  			if(!empty($v['tabName'])){
  				$html_string=array("\r", "\n", "\\","'",'"');
  				$v['tabName'] = str_replace($html_string,"",$v['tabName']);
  			}
  			if(isset($v['tabId']) && $v['tabId']>0){ 	//修改套餐价格
  
  				if(!empty($v['data'])){
                   
  					foreach ($v['data'] as $key=>$val){
                       if(!empty($val['dayid'])){
                       	     //售卖价
	                       	$pirce_sql= $this->db->query("select * from u_sales_line_suit_price where dayid='{$val['dayid']}'");
	                       	$pirceArr = $pirce_sql->row_array();
	             
	                       	$stpirce= $this->db->query("select * from u_line_suit_price where dayid='{$val['dayid']}'")->row_array();

	                       	if(!empty($val['s_adultprice']) && $val['s_adultprice']>$stpirce['adultprice']){
	                       		$falg=-1;
	                       		$msg="出团日期{$val['day']},促销成本价格不能大于售卖成本价";
	                       		return array('stauts'=>$falg,'msg'=>$msg);
	                       		exit;
	                        }
                          	if(!empty($val['s_childprice']) && $val['s_childprice']>$stpirce['childprice']){
	                       		$falg=-1;
	                       		$msg="出团日期{$val['day']},促销儿童价格不能大于售卖儿童价";
	                       		return array('stauts'=>$falg,'msg'=>$msg);
	                       		exit;
	                        }
	                        if(!empty($val['s_childnobedprice']) && $val['s_childnobedprice']>$stpirce['childnobedprice']){
	                        	$falg=-1;
	                        	$msg="出团日期{$val['day']},促销儿童不占床价格不能大于售卖儿童不占床价";
	                        	return array('stauts'=>$falg,'msg'=>$msg);
	                        	exit;
	                        }
	                        if(!empty($val['s_number']) && $val['s_number']>$stpirce['number']){
	                        	$falg=-1;
	                        	$msg="出团日期{$val['day']},促销余位不能大于售卖余位";
	                        	return array('stauts'=>$falg,'msg'=>$msg);
	                        	exit;
	                        }
	                        
	                       	$insertSuit['suitid']=$v['tabId'];
	                       	$insertSuit['lineid']=$lineId;
	                       	$insertSuit['adultprice']=$val['s_adultprice'];
	                       	$insertSuit['childprice']=$val['s_childprice'];
	                       	$insertSuit['childnobedprice']=$val['s_childnobedprice'];
	                       	$insertSuit['number']=$val['s_number'];
	                       	$insertSuit['dayid']=$val['dayid'];
	                       	
	                       	if(!empty($pirceArr['dayid'])){  //修改
	                       		$dayid=$insertSuit['dayid'];
	                       		unset($insertSuit['dayid']);
	                       		$this->db->where(array('lineid'=>$lineId,'suitid'=>$v['tabId'],'dayid'=>$dayid));
	                       		$this->db->update('u_sales_line_suit_price', $insertSuit);
	                       	
	                       	}else{  //添加
	                       	
	                       		if(!empty($v['data'][$key]['s_adultprice'])){
	                       			$this->db->insert('u_sales_line_suit_price',$insertSuit);
	                       			//echo $this->db->last_query();exit;
	                       		}
	                       	}
                       }else{
                         	if(!empty($val['s_adultprice'])|| !empty($val['s_childprice']) || !empty($val['s_childnobedprice'])){
                         		$falg=-1;
                         		$msg="出团日期{$val['day']}没有售卖价";
    
                         	}	
                       }
  		
  					}
  				}
  				$suitId=$v['tabId'];
  			}else{   //没有套餐
  				//var_dump($suit_arr);
  				//$falg=-1;
  				//$msg="该线路没有填写套餐";
  			}
  		}
  	}

  	$this->db->trans_complete();
  	if ($this->db->trans_status() === FALSE)
  	{
  		return array('stauts'=>-1,'msg'=>'保存失败'); 
  	}else{
  
  		return array('stauts'=>$falg,'msg'=>$msg); 

  	}
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
  //获取促销线路的数据
  function sel_sales($where){
	  	$sql=" select sl.*,l.linename from u_sales_line as sl left join u_line as l on sl.lineId=l.id ";
	  	$sql.="where lineId={$where['lineId']}";
	  	$appData = $this->db->query($sql)->row_array();
	    return $appData;
  } 
  //取消促销线路
  function dis_sales_line($lineid){
	  	$this->db->trans_start ();
	  	
	  	$this->db->where(array('lineId'=>$lineid))->delete('u_sales_line');
	  	
	  	$this->db->where(array('lineid'=>$lineid))->delete('u_sales_line_suit_price');
	  	
	  	$this->db->trans_complete();
	  	if ($this->db->trans_status() === FALSE)
	  	{
	  		return false;
	  	}else{
	  	
	  		return true;
	  	}
  }
  
  
}
