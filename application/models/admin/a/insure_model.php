<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Insure_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	//保险
	function get_insure_list($param,$page){
		//启用session
		$query_sql=' select insure.id,insure.supplier_id,insure.insurance_type,insure.settlement_price,insure.insurance_name,insure.insurance_company,insure.insurance_date,insure.insurance_price,insure.insurance_clause as insurance_clause1, ';
		$query_sql.=' left(insure.simple_explain,15) as "simple_explain",insure.simple_explain as "simple_explain1", left(insure.description,15) as "description",insure.description as "description1",left(insure.insurance_clause,15) as "insurance_clause",insure.modtime ,insure.status,d.description as kind ';
		$query_sql.=' FROM  u_travel_insurance AS insure LEFT JOIN u_dictionary as d on d.dict_id=insure.insurance_kind where insure.status=1 ';
		if($param!=null){
		
			if(null!=array_key_exists('search_insurance_type', $param)){
				$query_sql.=' AND insure.insurance_type  = ? ';
				$param['search_insurance_type'] = trim($param['search_insurance_type']);
			}

			if(null!=array_key_exists('search_insurance_kind', $param)){
				$query_sql.=' AND insure.insurance_kind  = ? ';
				$param['search_insurance_kind'] = trim($param['search_insurance_kind']);
			}
			if(null!=array_key_exists('name', $param)){
				$query_sql.=' AND insure.insurance_name  like ? ';
				$param['name'] = '%'.trim($param['name']).'%';
			}
			if(null!=array_key_exists('commpany', $param)){
				$query_sql.=' AND insure.insurance_company  like ? ';
				$param['commpany'] = '%'.trim($param['commpany']).'%';
			}
		}
		return $this->queryPageJson( $query_sql , $param ,$page );	
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
	//保险种类
	public function get_insurance_kind($code){
		$sql_rout="SELECT chird.* FROM u_dictionary AS chird LEFT JOIN u_dictionary AS parent ON parent.dict_id = chird.pid ";
		$sql_rout.="where parent.dict_code='{$code}'";
		$query_rout = $this->db->query($sql_rout);
		$rows = $query_rout->result_array();
		return $rows;
	}
	//订单保险
	public function get_insure_order($param,$page){
		$query_sql='SELECT  memo.ordersn,mt.*,memo.isbuy_insurance,memo.usedate,memo.productname,ti.insurance_name,d.description as certificate,idw.is_down,oi.is_buy ';
		$query_sql.='FROM	u_member_traver AS mt LEFT JOIN u_member_order_man AS om ON mt.id = om.traver_id ';
		$query_sql.=' LEFT JOIN u_member_order as memo on  memo.id=om.order_id ';
		$query_sql.=' LEFT JOIN u_order_insurance as oi on oi.order_id=memo.id ';
		$query_sql.=' LEFT JOIN u_travel_insurance as ti on ti.id=oi.insurance_id ';
		$query_sql.=' LEFT JOIN u_dictionary as d on d.dict_id=mt.certificate_type ';
	//	$query_sql.=' LEFT JOIN u_dictionary as dd on dd.dict_id=ti.insurance_kind';
		$query_sql.=' LEFT JOIN u_insurance_traver as idw on idw.traver_id=mt.id and idw.insurance_id=ti.id';
		$query_sql.=' where memo.status=4 and curdate()<memo.usedate and memo.isbuy_insurance=1';
	
		if($param!=null){
		
			if(null!=array_key_exists('if_insurance', $param)){
				if($param['if_insurance']==1){
					$query_sql.=' AND  idw.is_down=? ';
				}else{
					$query_sql.=' AND (idw.is_down  is null or idw.is_down=?) ';
				}

				$param['if_insurance'] = trim($param['if_insurance']);
			}

			if(null!=array_key_exists('is_buy', $param)){
				$query_sql.=' AND oi .is_buy  = ? ';
				$param['is_buy'] = $param['is_buy'];
			}

			if(null!=array_key_exists('line_name', $param)){
				$query_sql.=' AND memo.productname  like ? ';
				$param['line_name'] = '%'.trim($param['line_name']).'%';
			}
			if(null!=array_key_exists('ordersn', $param)){
				$query_sql.=' AND memo.ordersn = ? ';
				$param['ordersn'] = trim($param['ordersn']);
			}
		
			if(null!=array_key_exists('starttime', $param)){
				$query_sql.=' AND memo.usedate  = ? ';
				$param['starttime'] = trim($param['starttime']);
			}
		}
		$query_sql.=' ORDER BY	mt.id DESC';
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//导出保险信息
	function derive_insurance_order($param){
		
		$query_sql='SELECT	mt.*,memo.isbuy_insurance,memo.usedate,memo.productname,ti.insurance_name,d.description as certificate,ti.id as insurance_id ';
		$query_sql.='FROM	u_member_traver AS mt LEFT JOIN u_member_order_man AS om ON mt.id = om.traver_id ';
		$query_sql.=' LEFT JOIN u_member_order as memo on  memo.id=om.order_id ';
		$query_sql.=' LEFT JOIN u_order_insurance as oi on oi.order_id=memo.id ';
		$query_sql.=' LEFT JOIN u_travel_insurance as ti on ti.id=oi.insurance_id ';
		$query_sql.=' LEFT JOIN u_dictionary as d on d.dict_id=mt.certificate_type ';
		//	$query_sql.=' LEFT JOIN u_dictionary as dd on dd.dict_id=ti.insurance_kind';
		$query_sql.=' LEFT JOIN u_insurance_traver as idw on idw.traver_id=mt.id and idw.insurance_id=ti.id';
		$query_sql.=' where memo.status=4 and curdate()<memo.usedate and memo.isbuy_insurance=1';
		if($param!=null){
		
			if(null!=array_key_exists('if_insurance', $param)){
				//$query_sql.=' AND memo.isbuy_insurance = '.$param['if_insurance'];
				if($param['if_insurance']==1){
					$query_sql.=' AND  idw.is_down='.$param['if_insurance'];
				}else{
					$query_sql.=' AND (idw.is_down  is null or idw.is_down='.$param['if_insurance'].') ';
				}
				
				$param['if_insurance'] = trim($param['if_insurance']);
			}
			if(null!=array_key_exists('line_name', $param)){
				$query_sql.=' AND memo.productname  like  '.'"%'.$param['line_name'].'%"';
				$param['line_name'] = '%'.$param['line_name'].'%';
			}
			if(null!=array_key_exists('ordersn', $param)){
				$query_sql.=' AND memo.ordersn = '.$param['ordersn'];			
				$param['ordersn'] = trim($param['ordersn']);
			}
		
			if(null!=array_key_exists('starttime', $param)){
				$query_sql.=' AND memo.usedate  = "'.$param['starttime'].'"';
				$param['starttime'] = $param['starttime'];
			}
			if(null!=array_key_exists('is_buy', $param)){
				$query_sql.=' AND oi .is_buy  = '.$param['is_buy'];
				$param['is_buy'] = $param['is_buy'];
			}

		}
		$query_sql.=' ORDER BY	mt.id DESC' ;
		$data=$this ->db ->query($query_sql) ->result_array();
		
	/*	//修改导出保险的状态
		foreach ($data as $k=>$v){
			$where['traver_id']=$v['id'];
			$where['insurance_id']=$v['insurance_id'];
			$this->db->where($where)->update('u_insurance_traver', array('is_down'=>1));
		}*/

		return $data;
	}

	//被保险人---准备删
	function get_insurance_member($param){

		$query_sql='SELECT	mt.*,om.order_id,ti.insurance_date,ti.id as travelid,memo.isbuy_insurance,memo.usedate,memo.productname,ti.insurance_name,d.description as certificate,ti.id as insurance_id,li.lineday,ti.insurance_price,memo.productname,oi.number  ';
		$query_sql.='FROM	u_member_traver AS mt LEFT JOIN u_member_order_man AS om ON mt.id = om.traver_id ';
		$query_sql.=' LEFT JOIN u_member_order as memo on  memo.id=om.order_id ';
		$query_sql.=' LEFT JOIN u_line as li on  li.id=memo.productautoid ';
		$query_sql.=' LEFT JOIN u_order_insurance as oi on oi.order_id=memo.id ';
		$query_sql.=' LEFT JOIN u_travel_insurance as ti on ti.id=oi.insurance_id ';
		$query_sql.=' LEFT JOIN u_dictionary as d on d.dict_id=mt.certificate_type ';
		$query_sql.=' LEFT JOIN u_insurance_traver as idw on idw.traver_id=mt.id and idw.insurance_id=ti.id';
		$query_sql.=' where memo.status=4   and  oi.is_buy = 0 ';
		
		if(null!=array_key_exists('starttime', $param)){
			$query_sql.=' AND memo.usedate  = "'.$param['starttime'].'"';
			$param['starttime'] = $param['starttime'];
		}
		if(null!=array_key_exists('insurance_code', $param)){
			$query_sql.=' AND ti .insurance_code  = "'.$param['insurance_code'].'"';
			$param['insurance_code'] = $param['insurance_code'];
		}
		if(null!=array_key_exists('order_id', $param)){
			$query_sql.=' AND memo.id  = "'.$param['order_id'].'"';
			$param['order_id'] = $param['order_id'];
		}
		$query_sql.=' ORDER BY mt.id DESC' ;
		$data=$this ->db ->query($query_sql) ->result_array();
		return $data;
	}
	//被保险人
	function get_insurance_people($param){

		$query_sql='SELECT oi.id as oid,ti.settlement_price,lsp.dayid as suit_price_id,mt.*,om.order_id,ti.insurance_date,ti.id as travelid,memo.isbuy_insurance,memo.usedate,memo.productname,ti.insurance_name,d.description as certificate,ti.id as insurance_id,ti.insurance_price,memo.productname,memo.productautoid as lineid,li.lineday ';
		$query_sql.='FROM	u_member_traver AS mt LEFT JOIN u_member_order_man AS om ON mt.id = om.traver_id ';
		$query_sql.=' LEFT JOIN u_member_order as memo on  memo.id=om.order_id ';
		$query_sql.=' LEFT JOIN u_line_suit_price as lsp on lsp.suitid=memo.suitid and lsp.day=memo.usedate ';
		$query_sql.=' LEFT JOIN u_line as li on  li.id=memo.productautoid ';
		$query_sql.=' LEFT JOIN u_order_insurance as oi on oi.order_id=memo.id ';
		$query_sql.=' LEFT JOIN u_travel_insurance as ti on ti.id=oi.insurance_id ';
		$query_sql.=' LEFT JOIN u_dictionary as d on d.dict_id=mt.certificate_type ';
		$query_sql.=' LEFT JOIN u_insurance_traver as idw on idw.traver_id=mt.id and idw.insurance_id=ti.id';
		//$query_sql.=' LEFT JOIN u_insurance_order as uio on uio.suit_day_id=lsp.dayid';
		$query_sql.=' where memo.status=4 and oi.is_buy=0';
		
		if(null!=array_key_exists('usedate', $param)){
			$query_sql.=' AND memo.usedate  = "'.$param['usedate'].'"';
			$param['usedate'] =trim($param['usedate']);
		}
		if(null!=array_key_exists('suitid', $param)){
			$query_sql.=' AND memo.suitid  = "'.$param['suitid'].'"';
			$param['suitid'] = trim($param['suitid']);
		}
		if(null!=array_key_exists('insurance_id', $param)){
			$query_sql.=' AND ti.id  = "'.$param['insurance_id'].'"';
			$param['insurance_id'] = $param['insurance_id'];
		}
		if(null!=array_key_exists('water_account', $param)){
			$query_sql.=' AND oi.water_account  = "'.$param['water_account'].'"';
			$param['water_account'] = $param['water_account'];
		}
		$query_sql.=' ORDER BY mt.id DESC' ;
		$data=$this ->db ->query($query_sql) ->result_array();
		return $data;
	}
	//同一个订单的同一个方案
	function get_order_result($param){
	              $query_sql=' SELECT mor.id as order_id,  ti.insurance_code';
	              $query_sql.=' FROM   u_member_order AS mor ';
	              $query_sql.=' LEFT JOIN u_order_insurance AS oi ON oi.order_id = mor.id';
	              $query_sql.=' LEFT JOIN u_travel_insurance AS ti ON ti.id = oi.insurance_id';
	              $query_sql.=' where mor.status=4 and  oi.is_buy != 1 ';
	              if(null!=array_key_exists('starttime', $param)){
			$query_sql.=' AND mor.usedate  = "'.$param['starttime'].'"';
			$param['starttime'] = $param['starttime'];
		}
	              $data=$this ->db ->query($query_sql) ->result_array();
		return $data;
	}
	//已经出行的订单
	function get_complete_order($param){
		 $query_sql='	SELECT mor.*';
	              $query_sql.=' FROM u_insurance_order as mor ';
	              $query_sql.=' where  (mor.status=1 or mor.status=-1 )';
	              //mor.status>4  and
	              if(null!=array_key_exists('starttime', $param)){
			$query_sql.=' AND mor.order_use_date  = "'.$param['starttime'].'"';
			$param['starttime'] = $param['starttime'];
		 }
	              $data=$this ->db ->query($query_sql) ->result_array();
		 return $data;
	}

	//获取保单号
	function get_insurance_baodan($baodan){
		$query_sql=' SELECT oi.*,ti.insurance_name,ti.insurance_code as code';
		$query_sql.=' FROM	u_insurance_order AS oi ';
		$query_sql.=' LEFT JOIN u_travel_insurance AS ti ON ti.id = oi.insurance_id';
		$query_sql.='  where oi.status=1 and oi.insurance_code="'.$baodan.'"';
		$data=$this ->db ->query($query_sql) ->row_array();
		return $data;
	}

	//获取订单保险数据
	function get_insurance_edit($param,$page){
		$query_sql=' SELECT in_or.suit_id as suitid,in_or.water_account,in_or.insurance_price, in_or.settlement_price, in_or.people_num, l.linename as productname,';
		$query_sql.='  uti.insurance_code AS code,uti.insurance_name,in_or.order_use_date as usedate,in_or.status,l.id as productautoid';
		$query_sql.=' FROM	u_insurance_order AS in_or';
		$query_sql.=' LEFT JOIN u_travel_insurance AS uti ON uti.id = in_or.insurance_id';
		$query_sql.=' LEFT JOIN u_line as l on in_or.line_id=l.id';
		$query_sql.=' where in_or.id>0 ';
		if($param!=null){
			
			if (null!=array_key_exists('starttime', $param)){
				$query_sql.=' AND in_or.order_use_date  >= ? ';
				$param['starttime'] = trim($param['starttime']);
			}
			if (null!=array_key_exists('usertime', $param)){
				$query_sql.=' AND in_or.order_use_date  <= ? ';
				$param['usertime'] = trim($param['usertime']);
			}
		/*	if(null!=array_key_exists('usertime', $param)){
				$query_sql.=' AND in_or.order_use_date  = ? ';
				$param['usertime'] = trim($param['usertime']);
			}*/

			if(null!=array_key_exists('status', $param)){
				$query_sql.=' AND in_or.status  = ? ';
				$param['status'] = trim($param['status']);
			}
		}
		
		//return $this->queryPageJson( $query_sql , $param ,$page );
		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//未购买的保险
	function get_unuser_insurance($param,$page){

		$query_sql=' SELECT mom.id as order_id, mom.productname,mom.productautoid, tri.insurance_code,mom.ordersn, ';
		$query_sql.=' mom.usedate,tri.insurance_name,(tri.insurance_price*uoi.number) as insurance_price,uoi.amount,uoi.number,mom.status,mom.ispay ';
		$query_sql.=' FROM u_order_insurance AS uoi ';
		$query_sql.=' LEFT JOIN u_member_order as mom on mom.id=uoi.order_id ';
		$query_sql.=' LEFT JOIN u_travel_insurance as tri on tri.id=uoi.insurance_id';
		$query_sql.=' where uoi.is_buy=0';
		if($param!=null){
			if(null!=array_key_exists('ordersn', $param)){
				$query_sql.=' AND mom.ordersn  = ? ';
				$param['ordersn'] = trim($param['ordersn']);
			}
			if (null!=array_key_exists('starttime', $param)){
				$query_sql.=' AND mom.usedate   >= ? ';
				$param['starttime'] = trim($param['starttime']);
			}
			if (null!=array_key_exists('usertime', $param)){
				$query_sql.=' AND mom.usedate   <= ? ';
				$param['usertime'] = trim($param['usertime']);
			}
		/*	if(null!=array_key_exists('usertime', $param)){
				$query_sql.=' AND mom.usedate  = ? ';
				$param['usertime'] = trim($param['usertime']);
			}*/
		}

		return $this->queryPageJson( $query_sql , $param ,$page );
	}
	//获取出游人信息
	function get_order_traver($param){
                     //uio.insurance_code_cancel
	/*	$query_sql='SELECT mt.*,uio.insurance_code,uio.insurance_sn,uio.status,uio.people_num';
		$query_sql.=' FROM	u_member_traver AS mt LEFT JOIN u_member_order_man AS om ON mt.id = om.traver_id ';
		$query_sql.=' LEFT JOIN u_member_order as memo on  memo.id=om.order_id ';
		$query_sql.=' LEFT JOIN u_line_suit_price as lsp on lsp.suitid=memo.suitid and lsp.day=memo.usedate ';
		$query_sql.=' LEFT JOIN u_line as li on  li.id=memo.productautoid ';
		$query_sql.=' LEFT JOIN u_order_insurance as oi on oi.order_id=memo.id ';
		$query_sql.=' LEFT JOIN u_travel_insurance as ti on ti.id=oi.insurance_id ';
		$query_sql.=' LEFT JOIN u_dictionary as d on d.dict_id=mt.certificate_type ';
		$query_sql.=' LEFT JOIN u_insurance_traver as idw on idw.traver_id=mt.id and idw.insurance_id=ti.id';
		$query_sql.=' LEFT JOIN u_insurance_order as uio on uio.suit_day_id=lsp.dayid';
		$query_sql.=' where memo.status>3 ';*/
		 $query_sql=' SELECT mt.* ';
		$query_sql.='  FROM	 u_order_insurance AS oi ';
		$query_sql.=' LEFT JOIN u_member_order AS memo  ON oi.order_id = memo.id' ;
		$query_sql.=' LEFT JOIN u_member_order_man AS om ON om.order_id = memo.id';
		$query_sql.=' LEFT JOIN u_member_traver AS mt ON mt.id = om.traver_id';
		$query_sql.=' WHERE memo. STATUS > 3 ';
		if(null!=array_key_exists('water_account', $param)){
			$query_sql.=' AND oi.water_account  = "'.$param['water_account'].'"';
			$param['water_account'] = trim($param['water_account']);
		}
		$query_sql.=' ORDER BY mt.id asc' ;

		$data=$this ->db ->query($query_sql) ->result_array();
		return $data;

	/*	$query_sql=' SELECT oi.id as oid ,mt.*,oi.insurance_code,oi.insurance_sn,oi.insurance_code_cancel,oi.is_buy ';
		$query_sql.=' FROM	u_member_traver AS mt';
		$query_sql.=' LEFT JOIN  u_member_order_man AS mom ON mt.id = mom.traver_id';
		$query_sql.=' LEFT JOIN  u_order_insurance as oi on oi.order_id=mom.order_id';
		$query_sql.=' where oi.id='.$id;
		$data=$this ->db ->query($query_sql) ->result_array();
		return $data;*/


	}
           //保险费用
	function get_insurance_price($whereArr){
		$this ->db ->select ( 'oi.amount,ti.insurance_code AS CODE,(ti.insurance_price*oi.number) as price' );
		$this ->db ->from ( 'u_order_insurance AS oi');
		$this ->db ->join ('u_travel_insurance AS ti' ,'oi.insurance_id = ti.id' ,'left');
		$this ->db ->where ( $whereArr );
		return $this->db->get ()->row_array ();
	}

	//保险日志
	function insert_insurance_log($order_insure){
		$this->db->trans_start();

		foreach ($order_insure as $key => $value) {
			$logArr=array(
				'order_id'=>$value['order_id'],
				'insurance_id'=>$value['insurance_id'],
				'num'=>$value['number'],
				'addtime'=>date('Y-m-d H:i:s',time()),
				'description'=>'保险日志',
			);

			$data=$this ->db ->query("select id from u_insurance_log where order_id={$value['order_id']} and insurance_id={$value['insurance_id']}") ->row_array();
                                if(empty($data)){
				$this->db->insert('u_insurance_log', $logArr);   //添加保险日志
                                }
			
		}
		

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return 1;
		}

	}
	//保险套餐
	function get_insurance_suit($date){
		$query_sql=" SELECT mom.suitid, SUM(mom.settlement_price) as settlement_price, SUM(number) as people, uti.insurance_price, uti.insurance_code,mom.productautoid  as line_id ,uoi.insurance_id " ;
		$query_sql.=" FROM u_member_order as mom ";
		$query_sql.=" LEFT JOIN u_order_insurance as uoi on uoi.order_id=mom.id ";
		$query_sql.=" LEFT JOIN u_travel_insurance as uti on uti.id=uoi.insurance_id  ";
		//$query_sql.=" LEFT JOIN u_insurance_order as uio on uio.suit_id=mom.suitid and uio.order_use_date=mom.usedate ";
		$query_sql.=" WHERE usedate = '".$date."' AND mom.STATUS = 4 and (uoi.is_buy!=1 && uoi.is_buy!=-1) GROUP BY mom.suitid ,uti.id ";
		$data=$this ->db ->query($query_sql) ->result_array();
		return $data;
	}	

}