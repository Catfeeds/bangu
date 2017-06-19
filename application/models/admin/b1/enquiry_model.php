<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Enquiry_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	//新询价单
	function get_enquiry_list($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = "SELECT c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,
		  (SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace) AS startplace,
		 (SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace,
		ce.budget AS budget,ce.days AS days,ce.total_people AS total_people, e.realname AS realname,e.mobile AS mobile, (SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS reply_count FROM u_enquiry AS ey LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (ey.id=ce.enquiry_id AND ce.customize_id=c.id) LEFT JOIN u_expert AS e ON ey.expert_id=e.id WHERE ey.status=2 AND ey.is_assign=0 AND ey.id NOT IN (SELECT eg.enquiry_id FROM u_enquiry_grab AS eg WHERE eg.supplier_id={$login_id}) ORDER BY ey.id DESC";
		return $this->queryPageJson( $query_sql , $param ,$page );
	}

	//已指定
	function get_specified_list($param,$page){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = "SELECT c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,  (SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace) AS startplace, (SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people, e.realname AS realname,e.mobile AS mobile, (SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS reply_count FROM u_enquiry AS ey LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (ey.id=ce.enquiry_id AND ce.customize_id=c.id) LEFT JOIN u_expert AS e ON ey.expert_id=e.id WHERE ey.status=2 AND ey.is_assign=1 AND ey.supplier_id={$login_id} AND ey.id NOT IN (SELECT eg.enquiry_id FROM u_enquiry_grab AS eg WHERE eg.supplier_id={$login_id}) ORDER BY ey.id DESC";
		return $this->queryPageJson( $query_sql , $param ,$page );
	}

	//已中标
	function get_bid_list($param,$page){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = "SELECT ey.line_id,ey.expert_id,eg.id AS grab_id,c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,  (SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace) AS startplace, (SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people, e.realname AS realname,e.mobile AS mobile, (SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS reply_count FROM u_enquiry_grab AS eg LEFT JOIN u_enquiry AS ey ON eg.enquiry_id=ey.id LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (ey.id=ce.enquiry_id AND ce.customize_id=c.id) LEFT JOIN u_customize_answer AS ca ON ey.customize_answer_id=ca.id LEFT JOIN u_expert AS e ON ey.expert_id=e.id WHERE eg.isuse=1 AND eg.supplier_id={$login_id} ORDER BY ey.id DESC";
		return $this->queryPageJson( $query_sql , $param ,$page );
	}




	//已回复
	function get_reply_data($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql  = "SELECT c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,  (SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace) AS startplace, (SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people, e.realname AS realname,e.mobile AS mobile, (SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS reply_count FROM u_enquiry_grab AS eg LEFT JOIN u_enquiry AS ey ON eg.enquiry_id=ey.id LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_customize_expert AS ce ON (ey.id=ce.enquiry_id AND ce.customize_id=c.id) LEFT JOIN u_customize_answer AS ca ON ey.customize_answer_id=ca.id LEFT JOIN u_expert AS e ON ey.expert_id=e.id WHERE eg.isuse=0 AND eg.supplier_id={$login_id} AND (ey.status=2 OR ey.status=3) ORDER BY ey.id DESC";
		 return $this->queryPageJson( $query_sql , $param ,$page );
	}

	//已过期
	function get_overdue_data($param,$page){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql  = "SELECT c.id AS c_id,ey.id AS eid,ce.startdate AS startdate,ce.estimatedate AS estimatedate,  (SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=ce.startplace) AS startplace, (SELECT GROUP_CONCAT(de.kindname) FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace, ce.budget AS budget,ce.days AS days,ce.total_people AS total_people, e.realname AS realname,e.mobile AS mobile, (SELECT COUNT(*) FROM u_enquiry_grab AS eg WHERE eg.enquiry_id=ey.id) AS reply_count FROM u_enquiry AS ey LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN u_enquiry_grab AS eg ON ey.id=eg.enquiry_id LEFT JOIN u_customize_expert AS ce ON (ey.id=ce.enquiry_id AND ce.customize_id=c.id) LEFT JOIN u_customize_answer AS ca ON ey.customize_answer_id=ca.id LEFT JOIN u_expert AS e ON ey.expert_id=e.id WHERE (ey.status=-2 OR ey.status=-3) AND eg.supplier_id={$login_id} ORDER BY ey.id DESC";
		return $this->queryPageJson( $query_sql , $param ,$page );
	}

	//获取定制头部需求(来自管家的需求)
	function get_one_customize($eid){
	$query_sql = "SELECT ey.id AS eid,c.id AS c_id,s.company_name AS s_name,(SELECT concat_ws('|',st.cityname,st.id)  FROM u_startplace AS st  WHERE st.id=ce.startplace) AS startplace, (SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=2) AS endplace_two, (SELECT concat_ws('|',group_concat(de.kindname),group_concat(de.id)) AS dest_name FROM  u_dest_base AS de  WHERE FIND_IN_SET(de.id,ce.endplace)>0 and de.level=3) AS endplace_three, ce.startdate AS startdate,ce.estimatedate AS estimatedate, ce.custom_type AS custom_type,ce.trip_way AS trip_way,ce.another_choose AS another_choose,ce.hotelstar AS hotelstar, ce.isshopping AS isshopping,ce.catering AS catering,ce.total_people AS total_people, ce.people AS people,ce.childnum AS childnum,ce.childnobednum AS childnobednum,ce.oldman AS oldman,ce.roomnum AS roomnum, ce.room_require AS room_require,ce.budget AS budget,ce.days AS days,ce.service_range AS service_range,ca.title AS ca_title,ca.plan_design AS plan_design FROM u_enquiry AS ey LEFT JOIN u_customize AS c ON ey.customize_id=c.id LEFT JOIN  u_customize_expert AS ce ON (ey.id=ce.enquiry_id AND ce.customize_id=c.id) LEFT JOIN u_customize_answer AS ca ON ey.customize_answer_id=ca.id LEFT JOIN u_supplier AS s ON s.id=ey.supplier_id WHERE ey.id={$eid}";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		return $result;
	}

	//管家设计的行程
	function get_customize_trip($eid){
	$query_sql = "SELECT cjp.id AS cjp_id,ca.id AS ca_id,cj.id AS cj_id, cj.day AS cj_day, cj.title AS cj_title,cj.transport AS transport,cj.hotel AS hotel,cj.breakfirsthas AS breakfirsthas,cj.breakfirst AS breakfirst, cj.lunchhas AS lunchhas,cj.lunch AS lunch,cj.supperhas AS supperhas,cj.supper AS supper,cj.jieshao AS cj_jieshao, cjp.pic AS c_pic FROM u_enquiry AS ey LEFT JOIN u_customize_answer AS ca ON ey.customize_answer_id=ca.id LEFT JOIN u_customize_jieshao AS cj ON cj.customize_answer_id=ca.id LEFT JOIN u_customize_jieshao_pic AS cjp ON cjp.customize_jieshao_id=cj.id WHERE ey.id={$eid}";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	//获取供应商的回复方案
	function get_supplier_customize($eid){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = "SELECT ey.id,eg.id,eg.title AS ca_title,eg.price,eg.childprice,eg.childnobedprice,eg.oldprice,eg.agent_rate,eg.attachment,eg.reply FROM u_enquiry AS ey LEFT JOIN u_enquiry_grab AS eg ON ey.id=eg.enquiry_id WHERE ey.id={$eid} AND eg.supplier_id={$login_id}";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		return $result;
	}

	//供应商设计的行程
	function get_supplier_trip($eid){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = "SELECT ey.id,ej.day AS cj_day,ej.title AS cj_title,ej.transport AS transport,ej.hotel AS hotel, ej.breakfirsthas AS breakfirsthas,ej.breakfirst AS breakfirst,ej.lunchhas AS lunchhas,ej.lunch AS lunch, ej.supperhas AS supperhas,ej.supper AS supper,ej.jieshao AS cj_jieshao,ej.pic AS c_pic FROM u_enquiry AS ey LEFT JOIN u_enquiry_grab AS eg ON ey.id=eg.enquiry_id LEFT JOIN u_enquiry_jieshao AS ej ON ej.enquiry_grab_id=.eg.id WHERE ey.id={$eid} AND eg.supplier_id={$login_id} order by cj_day ASC";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	//插入回复记录
	function insert_enquiry_grab($table,$data){
		 $this->db->insert($table,$data);
		 return $this->db->insert_id();
	}

	function get_supplier_info(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = "SELECT id,company_name AS company_name,brand AS brand,realname AS realname,mobile AS mobile,linkman AS linkman,link_mobile AS link_mobile FROM u_supplier WHERE id=$login_id";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		return $result;
	}

	function get_replyed_data($eid){
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];
		$query_sql = "SELECT ey.id AS eid,eg.id AS eg_id,eg.supplier_id,s.company_name AS company_name,s.brand AS brand,s.realname AS realname,s.mobile AS mobile,s.linkman AS linkman,s.link_mobile AS link_mobile,eg.price AS price,eg.childprice AS childprice,eg.agent_rate,eg.childnobedprice AS childnobedprice,eg.oldprice AS oldprice,eg.reply AS reply,eg.attachment AS attachment FROM u_enquiry AS ey LEFT JOIN u_enquiry_grab AS eg ON ey.id=eg.enquiry_id LEFT JOIN u_supplier AS s ON eg.supplier_id=s.id WHERE ey.id=$eid AND eg.supplier_id=$login_id";
		$query=$this->db->query($query_sql);
		$result = $query->result_array();
		return $result;
	}

	//查看方案
	function enquiry_data($id){
		//启用session
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$query_sql='';
		$query_sql.='SELECT	`eg`.`id`,	`ey`.`id` AS eid,`s`.`company_name`,`eg`.`reply`,	`eg`.`attachment` ';
		$query_sql.='FROM (`u_enquiry` AS ey) 	';
		$query_sql.='LEFT JOIN `u_enquiry_grab` AS eg ON `ey`.`id` = `eg`.`enquiry_id`	';
		$query_sql.='LEFT JOIN `u_customize` AS c ON `ey`.`customize_id` = `c`.`id`	';
		$query_sql.='LEFT JOIN `u_supplier` AS s ON `eg`.`supplier_id` = `s`.`id` ';
		$query_sql.='WHERE eg.supplier_id='.$login_id.' and `ey`.`id` = '.$id;
		$query=$this->db->query($query_sql)->result_array();
		return $query;
	}
	function upload_expert($data,$where){
		$this->db->where($where);
		$this->db->update('u_enquiry', $data);
	}
	//查看询价单的价格
	function select_enquiry_price($customize_id,$supplier){

		$query_sql  = 'select engrad.price,engrad.childprice as childpirce,engrad.childnobedprice,engrad.reply ';
		$query_sql.='  from u_enquiry as en  ';
		$query_sql.=' LEFT JOIN u_enquiry_grab as engrad on en.id=engrad.enquiry_id where en.customize_id='.$customize_id.' and engrad.supplier_id='.$supplier;
		$query=$this->db->query($query_sql)->row_array();
		return $query;
	}
	//转定制团
	public function return_enquiry($where,$expert_id,$isuse,$eid,$grabid){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$login_id=$arr['id'];

		$this->db->trans_start();

		//供应商信息
		$supplier_grab=$this->db->query("select brand from u_supplier WHERE id=?  ",$login_id);
		$supplier = $supplier_grab->row_array();
		//抢单信息
		$query_grab=$this->db->query("select * from u_enquiry_grab WHERE id=?  ",$grabid);
		$grab = $query_grab->row_array();

        //询价单信息
		$query = $this->db->query("select question as linename,question as lineprename,endplace as overcity2,days as lineday,startplace,startdate,estimatedate from u_customize WHERE id=?  ",$where);
		$customize = $query->row_array();
		$insertArr['linename']=$supplier['brand'].' · '.$customize['linename'];
		$insertArr['lineprename']=$customize['lineprename'];
		$insertArr['lineday']=$customize['lineday'];	
		$insertArr['addtime']=date('Y-m-d H:i:s');
		$insertArr['modtime']=date('Y-m-d H:i:s');
		$insertArr['supplier_id']=$login_id;
		$insertArr['status']=0;
	//	$insertArr['overcity2']=$customize['overcity2'];
		$insertArr['producttype']=1;
		$insertArr['agent_rate_int']=$grab['agent_rate'];
		//$insertArr['startcity']=$customize['startplace'];
		$insertArr['customize_id']=$where['id'];
		if(!empty($customize['overcity2'])){      //筛选三四级的目的地
			$endplace='';
			$endplaceArr=explode(',', $customize['overcity2']);
			foreach ($endplaceArr as $k=>$v){
				if(!empty($v)){
					$lpquery=$this->db->query('select id,list,level from u_dest_base where id='.$v);
					$lineplace=$lpquery->row_array();	
					if(!empty($lineplace)){
						if(empty($endplace)){
							$endplace=$lineplace['list'].$v.',';
						}else{
								$endplace.=$lineplace['list'].$v.',';
						}	
						$endplaceDataArr=explode(",",$endplace);
						$endplaceDataArr=array_unique($endplaceDataArr);
						$endplace=implode(',', $endplaceDataArr);
						//存三级目的地
						if($lineplace['level']==3){
							if(empty($insertArr['overcity2'])){
								$insertArr['overcity2']=$lineplace['id'];
							}else{
								$insertArr['overcity2'].=','.$lineplace['id'];
							}
							
						}
					}
				
				}
			}
			//存所有的级目的地
			$insertArr['overcity']=$endplace;
		}

		//生成线路
		$this->db->insert('u_line',$insertArr);
		$lineid=$this->db->insert_id();
		$updateDate = $this->db->query(" update u_enquiry SET line_id =".$lineid." WHERE id=?  ",$eid);
		$lineDate = $this->db->query(" update u_line SET linecode = 'B".$lineid."' WHERE id=".$lineid);

		//生成城市表		
		$this->db->insert('u_line_startplace', array('line_id' =>$lineid , 'startplace_id'=>$customize['startplace']));
		
		//线路目的地表
		if(!empty($insertArr['overcity2'])){
			$destcityArr=explode(",",$insertArr['overcity2']);
			foreach ($destcityArr as $k=>$v){
				$this->db->insert('u_line_dest', array('line_id' =>$lineid , 'dest_id'=>$v));
			}
		}
	
		//线路申请表
		$insert['addtime']=date('Y-m-d H:i:s');
		$insert['modtime']=date('Y-m-d H:i:s');
		$insert['expert_id']=$expert_id;
		$insert['status']=2;
		$insert['line_id']=$lineid;
		$insert['grade']=1;
		$this->db->insert('u_line_apply',$insert);

		//行程
		$jieshao_sql=$this->db->query('SELECT * from u_enquiry_jieshao WHERE enquiry_grab_id=? ',$grabid);
		$jieshao = $jieshao_sql->result_array();
		if(!empty($jieshao)){
			foreach ($jieshao as $k=>$v){
				$action['lineid']=$lineid;
				if(!empty($v['day'])){
					$action['day']=$v['day'];
				}
				$action['title']=$v['title'];
				$action['breakfirsthas']=$v['breakfirsthas'];
				$action['breakfirst']=$v['breakfirst'];
				$action['transport']=$v['transport'];
				$action['hotel']=$v['hotel'];
				$action['jieshao']=$v['jieshao'];
				$action['lunchhas']=$v['lunchhas'];
				$action['lunch']=$v['lunch'];
				$action['supperhas']=$v['supperhas'];
				$action['supper']=$v['supper'];
				$this->db->insert('u_line_jieshao',$action);
				$jieshao_id=$this->db->insert_id();
				$picArr['pic']=$v['pic'];
				$picArr['addtime']=date('Y-m-d H:i:s');
				$picArr['jieshao_id']=$jieshao_id;
				$this->db->insert('u_line_jieshao_pic',$picArr);
				//$jieshao_id=$this->db->insert_id();
			}
		}
		//套餐价格设置
		//line_suit

		if(!empty($customize['startdate']) && $customize['startdate']!='0000-00-00'){
		    $suitArr['lineid']=$lineid;
		    $suitArr['suitname']='标准价';
		    $suitArr['unit']=1;
		    $this->db->insert('u_line_suit',$suitArr);
		    $suit_id=$this->db->insert_id();
		    $priceArr['suitid']=$suit_id;
		    $priceArr['lineid']=$lineid;
		    $priceArr['day']=$customize['startdate'];
		    $priceArr['number']='';
		    $priceArr['childprice']=$grab['childprice'];
		    $priceArr['childnobedprice']=$grab['childnobedprice'];
		    $priceArr['oldprice']=$grab['oldprice'];
		    $priceArr['adultprice']=$grab['price'];
	    	    $this->db->insert('u_line_suit_price',$priceArr);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    return false;
		}else{
		     return $lineid;
		}
	}
	/**
	 * 查看询价单的价格
	 * @param unknown $value
	 * @param unknown $key
	 */
	public function select_enquiry_data($line_id,$supplier){
		$query_sql  = 'select engrad.agent_rate,e.id as expert_id,e.realname';
		$query_sql.='  from u_enquiry as en  ';
		$query_sql.=' LEFT JOIN u_enquiry_grab as engrad on en.id=engrad.enquiry_id left JOIN u_expert as e on e.id=en.expert_id  where en.line_id='.$line_id.' and engrad.supplier_id='.$supplier;
		$query=$this->db->query($query_sql)->row_array();
		return $query;
	}

	/**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		if(isset($value['c_pic'])&&$value['c_pic']!=''){
			$c_pic = trim($value['c_pic'], ';');
			$pic_arr = explode(';', $c_pic);
			$value['pic_arr'] = $pic_arr;
		}
	}

}
