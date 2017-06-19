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

		$query_sql  = 'SELECT c.link_mobile,u_line.status,u_line.line_status,s.realname,s.mobile,u_line.overcity,b.mobile as bmobile,u_line.id,u_line.linecode,DATE_FORMAT(u_line.addtime,"%y%m%d") as addtime,u_line.nickname,u_line.linename, GROUP_CONCAT(pl.`cityname`) AS startcity,u_line.linebefore, DATE_FORMAT(u_line.modtime,"%y%m%d")  as modtime,c.linkman,b.username,u_line.refuse_remark, DATE_FORMAT(u_line.returntime,"%y%m%d")  as returntime  ';
		$query_sql.=' FROM u_line ';
		$query_sql.=' LEFT JOIN u_admin b  ON u_line.admin_id = b.id ';
		$query_sql.=' LEFT JOIN u_supplier c  ON c.id = u_line.supplier_id ';
		$query_sql.=' LEFT JOIN u_line_startplace  ON u_line.`id`=u_line_startplace.`line_id`';
		$query_sql.=' LEFT JOIN u_startplace pl  ON pl.id = u_line_startplace.`startplace_id` ';
		$query_sql.=' LEFT JOIN u_supplier s  ON s.id = u_line.supplier_id ';
		$query_sql.=' WHERE  u_line.producttype=0 and u_line.supplier_id='.$login_id.'  ';
	   	 /*目的查询*/
		if(!empty($dest['cityid'])){
			//$query_sql.=' AND '.$dest.' get_user_shop';		
			$query_sql.=' AND FIND_IN_SET('.$dest['cityid'].',u_line.overcity2)>0 ';
			//$param['destcity'] = trim($param['destcity']);
		}else{
			if(!empty($dest['cityname'])){
				$city_sql="SELECT id from u_dest_base where kindname like '%{$dest['cityname']}%'";
				$query = $this->db->query($city_sql);
				$rows = $query->row_array();
				if(empty($rows)){  
					$rows['id']=0;
				}
				$query_sql.=' AND FIND_IN_SET('.$rows['id'].',u_line.overcity2)>0 ';
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
	//包团线路查询
	public function get_group_line($param,$page,$dest=''){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		
		$query_sql  = 'SELECT c.link_mobile,u_line.status,u_line.line_status,u_line.overcity,s.realname,s.mobile,b.mobile as bmobile,u_line.id,u_line.linecode,DATE_FORMAT(u_line.addtime,"%y%m%d") as addtime,u_line.nickname,u_line.linename,u_line.linebefore,GROUP_CONCAT(pl.`cityname`) AS startcity, DATE_FORMAT(u_line.modtime,"%y%m%d")  as modtime,c.linkman,b.username,u_line.refuse_remark, DATE_FORMAT(u_line.returntime,"%y%m%d")  as returntime  ';
		$query_sql.=' FROM u_line ';
		$query_sql.=' LEFT JOIN u_admin b  ON u_line.admin_id = b.id ';
		$query_sql.=' LEFT JOIN u_supplier c  ON c.id = u_line.supplier_id ';
		$query_sql.=' LEFT JOIN u_line_startplace  ON u_line.`id`=u_line_startplace.`line_id`';
		$query_sql.=' LEFT JOIN u_startplace pl  ON pl.id = u_line_startplace.`startplace_id` ';
		$query_sql.=' LEFT JOIN u_supplier s  ON s.id = u_line.supplier_id ';
		$query_sql.=' WHERE  u_line.producttype=1 and u_line.supplier_id='.$login_id.'  ';
		
		    /*目的查询*/
		if(!empty($dest['cityid'])){		
			$query_sql.=' AND FIND_IN_SET('.$dest['cityid'].',u_line.overcity2)>0 ';
		}else{
			if(!empty($dest['cityname'])){
				$city_sql="SELECT id from u_dest_base where kindname like '%{$dest['cityname']}%'";
				$query = $this->db->query($city_sql);
				$rows = $query->row_array();
				if(empty($rows)){  
					$rows['id']=0;
				}
				$query_sql.=' AND FIND_IN_SET('.$rows['id'].',u_line.overcity2)>0 ';
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
	
	public function updateLineStatus($lineId,$status){//联合查询
		if(isset($status)){  // 下线 修改时间
			if($status==0 || $status==-1){
				$data = array( 'status' => $status,'modtime'=>date('Y-m-d H:i:s',time()) );
			}else{
				$data = array( 'status' => $status );
			}
		}else{
			$data = array( 'status' => $status );
		}
		$this->db->where('id', $lineId);
		$this->db->update('u_line', $data);
		return $this->db->affected_rows();
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
		$suit_price_sql = "SELECT a.*,b.suitname,b.unit,b.id as suit_id FROM u_line_suit b LEFT  JOIN u_line_suit_price a  on a.suitid=b.id WHERE b.lineid=?  ORDER BY b.id";
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
			$productPrices=$productPrices.'"oldprice":"'.$row["oldprice"].'"';
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
			 if($suit_id==0){  //插入套餐
			    	if($insertData['suitname']!='标准价'){
				    	$sql= $this->db->query('select suitname from u_line_suit where lineid='.$line_id);
				    	$suitdata=$sql->result_array();
				    	$flay=0;
				    	foreach($suitdata as $k=>$v){
				    		if($v['suitname']=='标准价'){
				    			$flay=1;
				    		}
				    	}
				    	if($flay==0){ //判断是否有标准价
				    		$this->db->insert('u_line_suit',array('suitname'=>'标准价','lineid'=>$line_id,'unit'=>1));
				    	}
			    	}
			    	$this->db->insert('u_line_suit',$insertData);  //插入套餐
			    	$suit_id=$this->db->insert_id();	
			 }

			$day=array();
			$query = $this->db->query('select * from  u_line_suit_price where suitid='.$suit_id.' and lineid='.$line_id);
			$suit_price = $query->result_array();
			
			if(!empty($suit_price)){
				foreach ($suit_price as $key=>$val){
					$day[]=$val['day'];
				}
			}
			
			$dateArr=explode(',', $startDate);
			$time=strtotime(date('Y-m-d'));
		   	 $priceArr['suitid']=$suit_id;
			foreach ($dateArr as $k=>$v){
				if(!empty($v)){
					$priceArr['day']=$v;
					if(strtotime($v)>$time){
						if(in_array($v,$day)){   //存在修改
							$this->db->where(array('lineid'=>$line_id,'suitid'=>$suit_id,'day'=>$v));
							$this->db->update('u_line_suit_price', $priceArr);
						}else {        //不存在则插入
						
							$this->db->insert('u_line_suit_price',$priceArr);
						}
					}
				}
			}
			if($suit_id>0){
				//修改套餐名称
				$this->db->where(array('lineid'=>$line_id,'id'=>$suit_id))->update('u_line_suit', array('suitname'=>$insertData['suitname']));
			}
			

			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				echo false;
			}else{
				return $suit_id;
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
	public function updata_line_fee($id,$data){
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
	public  function  saveProductPrice($lineArr,$suit_arr,$lineId,$unit){
		
		$this->db->trans_start();
		
		//保存套餐
		if(!empty($suit_arr)){
			//$suit_arr[0]['tabName']='标准价';
			foreach ($suit_arr as $k=>$v){	
				if(!empty($v['tabName'])){
					$html_string=array("\r", "\n", "\\","'",'"');
					$v['tabName'] = str_replace($html_string,"",$v['tabName']);
				}
				if(isset($v['tabId']) && $v['tabId']>0){ //修改套餐价格
					if(!empty($v['data'])){
						foreach ($v['data'] as $key=>$val){	
						    $pirce_sql= $this->db->query("select dayid from u_line_suit_price where day='{$val['day']}' and lineid={$lineId} and suitid={$v['tabId']}");
							$pirceArr = $pirce_sql->row_array();
							$insertSuit=$v['data'][$key];
							$insertSuit['suitid']=$v['tabId'];
							$insertSuit['lineid']=$lineId;
							if($val['dayid']>0){
								unset($insertSuit['dayid']);
								if($insertSuit['adultprice']=='' || $insertSuit['adultprice']==0){
									$this->db->delete('u_line_suit_price', array('day'=>$val['day'],'lineid'=>$lineId,'suitid'=>$v['tabId'])); 
								}else{	
									$this->db->where(array('day'=>$val['day'],'lineid'=>$lineId,'suitid'=>$v['tabId']));
									$this->db->update('u_line_suit_price', $insertSuit);
								}
							}else{
								
								if(!empty($v['data'][$key]['adultprice'])){
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
			         
					//套餐
					if(isset($v['tabId'])){
						if(!empty($v['tabName'])){
							$suitArr['suitname']=$v['tabName'];
							$suitArr['lineid']=$lineId;
							if(!empty($v['unit'])){
								$suitArr['unit']=$v['unit'];
							}
							$this->db->insert('u_line_suit',$suitArr);
							$suitId=$this->db->insert_id();
						}else{
							//第一个套餐插入标准价
							$normalPrice=$this->db->query("select id from u_line_suit where lineid={$lineId}")->row_array();
							if(empty($normalPrice)){
								$suit0['suitname']='标准价';
								$suit0['lineid']=$lineId;
								$this->db->insert('u_line_suit',$suit0);
								$suitId=$this->db->insert_id();
							}
						}
					}else{
						//第一个套餐插入标准价
						$normalPrice=$this->db->query("select id from u_line_suit where lineid={$lineId}")->row_array();
						if(empty($normalPrice)){
							$suit0['suitname']='标准价';
							$suit0['lineid']=$lineId;
							$this->db->insert('u_line_suit',$suit0);
							$suitId=$this->db->insert_id();
						}	
					}
					
					//套餐价格
					if(!empty($v['data'])){
						foreach ($v['data'] as $key=>$val){
							//var_dump($v['data'][$key]['adultprice']);
							if(!empty($v['data'][$key]['adultprice']) && !empty($suitId)){  //成人价不能为空
								unset($v['data'][$key]['dayid']);
								$insertSuitPrice=$v['data'][$key];
								$insertSuitPrice['lineid']=$lineId;
								$insertSuitPrice['suitid']=$suitId;
								$this->db->insert('u_line_suit_price',$insertSuitPrice);
							}
						}
					}   
				} 
			}
		}
		
		if(!empty($lineArr)){
			//修改线路
			$lineArr['modtime']=date("Y-m-d H:i:s",time());
			$lineArr['ordertime']=date('Y-m-d H:i:s',strtotime('+7 day'));
			$lineArr['units']=$unit;
			
			$this->db->where(array('id'=>$lineId));
			$this->db->update('u_line', $lineArr);
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		        return false;
		}else{
		     if(!empty($suitId)){
		     	return $suitId;
		     }else{
		     	return true;
		     }
		}
	}
	//指定营业部
	    function select_line_package($lineid){
	    	$this->db->select('lp.line_id,lp.depart_id,lp.expert_id,e.realname as nickname,e.realname,d.name ');
	    	$this->db->from('u_line_package AS lp ');
	    	$this->db->join('u_expert AS e','e.id= lp.expert_id','left');
	    	$this->db->join('b_depart AS d','d.id= lp.depart_id','left');
	    	$this ->db ->where(array('lp.line_id'=>$lineid));
	    	$query = $this->db->get ();
	    	return $query->result_array ();	
	    }
	//线路的保险
	public function sel_line_insurance($lineid,$where){
		$query_sql="SELECT tin.*, tin.id in ( select insurance_id from u_line_insurance where line_id={$lineid} and STATUS=1 ) as 'isexit',";
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
		//插入  基础信息
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
	 	
	 	$html='linetype,producttype,nickname,linename,lineicon,linecode,product_recommend,startcity,overcity,line_beizhu,insurance,other_project,special_appointment,safe_alert,';
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
		 	    $this->db->query("UPDATE  u_line SET linecode=  CONCAT('L',$lid ) ,linename=CONCAT(linename,' — 复制')  where id=".$lid);
		 	}elseif($type=='group'){
		 		//$this->grouplinecodeupdate1($lid);
		 		 $this->db->query("UPDATE  u_line SET linecode=  CONCAT('B',$lid ),linename=CONCAT(linename,' — 复制')  where id=".$lid);
		 	}else{
		 		//$this->linecodeupdate1($lid);
		 		$this->db->query("UPDATE  u_line SET linecode=  CONCAT('L',$lid ) ,linename=CONCAT(linename,' — 复制')  where id=".$lid);
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
	    	 			$b_pic=$this->user_shop_model->select_rowData('u_line_picture_library',array('pic'=>$picArr[$k],'dest_id'=>$val));
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
     *@method 保存线路的基本信息
     * @param    $data  线路基本信息   
     * @param    $startcity  出发地
     * @param    $line_pic   线路图片
     */
    function save_line_base($data,$startcity,$line_pic,$expert,$overcityArr,$id){
    	$this->db->trans_start();
    	
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
    	if($expert>0){
    		$line_apply=$this->get_user_shop_select('u_line_apply',array('line_id'=>$id));
    		if(empty($line_apply)){
    			$expertArr=array(
    				'grade'=>1,
    				'line_id'=>$id,
    				'expert_id'=>$expert,
    				'status'=>2,
    				'addtime'=>date("Y-m-d H:i:s",time()),
    			);
    			$this->insert_data('u_line_apply',$expertArr);
    		}else{
    			 
    			$expertArr=array(
    				'expert_id'=>$expert,
    			);
    			$this->update_rowdata('u_line_apply',$expertArr,array('line_id'=>$id));
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
    				 if(!in_array($v,$overcitystr)){  //不存在该出发地就插入
    				 	$this->insert_data('u_line_dest',array('line_id'=>$id,'dest_id'=>$v));//插入表
    				 }
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
    //保存添加线路
    function save_linedata($data,$startcity,$line_pics_arr,$overcityArr,$expert){
    	$this->db->trans_start();
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
    	//定制管家
    	if($expert>0){
    		$expertArr=array(
    			'grade'=>1,
    			'line_id'=>$lineId,
    			'expert_id'=>$expert,
    			'status'=>2,
    			'addtime'=>date("Y-m-d H:i:s",time()),
    		);
    		$this->insert_data('u_line_apply',$expertArr);
    	}
    	//添加线路的目的地
           if(!empty($overcityArr)){
           	foreach ($overcityArr as $k => $v) {
           		if($v>0){
    				$this->insert_data('u_line_dest',array('line_id'=>$lineId,'dest_id'=>$v));//插入表
    			}
           	}
           }

    	$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    	{
    		echo false;
    	}else{
    		return $lineId;
    	}
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
}