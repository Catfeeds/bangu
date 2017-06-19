<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_member_order';

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * 获得专家所有客户信息
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 * @param string $type
	 */
	public function get_expert_customers($whereArr, $page = 1, $num = 10, $type='arr') {
		/*$sql = "SELECT `mo`.`memberid` AS memberid, `m`.`nickname` AS nickname, `m`.`truename` AS truename, `m`.`mobile` AS mobile, `mo`.`expert_id` AS expert_id, MAX(mo.addtime) AS last_time, COUNT(mo.memberid) AS order_amount, SUM(mo.total_price) AS total_price FROM (`u_member_order` AS mo) LEFT JOIN `u_member` m ON `m`.`mid`=`mo`.`memberid` WHERE `mo`.`expert_id` = '1' GROUP BY `mo`.`memberid` ";
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY `mo`.`addtime` desc";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}*/
		$this->db->select("mo.memberid AS memberid,
					m.nickname AS nickname,
					m.truename AS truename,
					m.mobile AS mobile,
					mo.expert_id AS expert_id,
					MAX(mo.addtime) AS last_time,
					COUNT(mo.memberid) AS order_amount,
					SUM(mo.total_price) AS total_price");
		$this->db->from("u_member_order AS mo");
		$this->db->join('u_member m', 'm.mid=mo.memberid', 'left');
		$this->db->where($whereArr);
		$this->db->group_by('mo.memberid');
		$this->db->order_by('mo.addtime', 'desc');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$query = $this->db->get();
		if($type=='obj')return $query->result();
		elseif($type=='arr')return $query->result_array();
	}


	/**
	 * 获得专家订单
	 *
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 * @param string $orderby
	 * @return array
	 */
	public function get_expert_orders($whereArr, $page = 1, $num = 10) {


                        if($page > 0){
                        	 $res_str = 'l.id AS line_id,
				mb_od.id AS order_id,
				mb_od.ordersn AS ordersn,
				mb_od.linkman AS nickname,
				mb_od.productname AS linename,
				(mb_od.childnum + mb_od.dingnum+mb_od.oldnum+mb_od.childnobednum) AS  people_num,
				(mb_od.total_price+mb_od.settlement_price) AS order_amount,
				mb_od.usedate AS usedate,
				mb_od.total_price,
				mb_od.settlement_price,
				mb_od.ispay,
				mb_od.status,
				mb_od.addtime AS addtime,
				s.company_name AS supplier_name,
				s.mobile AS s_mobile,
				op.status AS op_status,
				mb_od.dingnum,
				ls.unit AS unit
				';
                        }else{
                        	   $res_str = 'count(*) AS num';
                        }
                       $whereArr['mb_od.user_type']=0;
		$this->db->select($res_str);
		$this->db->from($this->table_name . ' as mb_od');
		$this->db->join('u_line as l', 'mb_od.productautoid = l.id', 'left');
		$this->db->join('u_supplier as s', 'mb_od.supplier_id = s.id', 'left');
		$this->db->join('u_order_price_apply as op', 'mb_od.id = op.order_id', 'left');
		$this->db->join('u_dest_base as det', ' l.overcity = det.id', 'left');
		$this->db->join('u_line_suit AS ls', 'ls.id=mb_od.suitid', 'left');
		$this->db->where($whereArr);

		if ($page > 0) {
			$this->db->group_by('mb_od.id');
			$this->db->order_by('mb_od.addtime','DESC');
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			array_walk($ret_arr, array($this, '_fetch_list'));
			return $ret_arr;
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}

	}


	/**
	 *获取订单详情数据
	 */
	function get_order_detail($whereArr){
	$this->db->select('
				mo.id,
				mo.addtime as addtime,
				mo.productautoid as productautoid,
				mo.productname AS line_name,
				mo.ordersn AS line_sn,
				mo.usedate AS usedate,
				mo.status AS status,
				mo.ispay AS ispay,
				mo.dingnum AS dingnum,
				mo.price AS ding_price,
				mo.childnum AS children,
				mo.suitnum AS suitnum,
			           (mo.dingnum+childnobednum+oldnum) as old_people,
				mo.childprice AS childprice,
				(mo.dingnum*mo.price)+(mo.childnum*mo.childprice)+(mo.childnobednum*mo.childnobedprice)+(mo.oldnum*mo.oldprice) AS order_amount,
				mo.agent_fee AS agent_fee,
				e.realname AS expert_name,
				e.mobile AS expert_mobile,
				s.company_name AS company_name,
				s.telephone AS telephone,
				mo.isneedpiao AS isneedpiao,
				mo.linkman AS linkman,
				mo.linkmobile AS linkmobile,
				mo.childnobedprice AS childnobedprice,
				mo.childnobednum AS childnobednum,
				mo.oldnum AS oldnum,
				mo.oldprice AS oldprice,
				mo.total_price AS order_price,
				mo.settlement_price AS settlement_price,
				mo.productautoid as lineid,
				mo.supplier_cost,
				mo.balance_money,
				mo.jifen,
				mo.jifenprice,
				mo.couponprice,
				mo.total_price,
				mo.balance_status,
				case  when l.line_classify=1 then 1 else 2 end cer_type,
				l.overcity,
				 sum(i.amount) as amout,
				mo.linkemail AS link_email,
				mo.suitid,
				mo.supplier_id,
				mo.depart_id,
				mo.expert_id,
				mo.diplomatic_agent,
				mo.order_type,
				mo.balance_complete,
				mo.yf_lock,
				mo.ys_lock,
				mo.bx_lock,
				mo.yj_lock,
				mo.wj_lock,
				mo.item_code,
				ls.suitname,
				ls.unit,
				s.agent_rate AS s_agent_rate,
				l.agent_rate_child,
				l.agent_rate_int,
				l.lineday,
				l.overcity2,
				aff.spare_mobile,
				aff.remark
				',false);
		$this->db->from('u_member_order AS mo');
		$this->db->join('u_expert AS e', 'mo.expert_id=e.id', 'left');
		$this->db->join('u_supplier AS s', 'mo.supplier_id=s.id', 'left');
		$this->db->join('u_order_insurance AS i', 'i.order_id=mo.id', 'left');
		$this->db->join('u_line_suit AS ls', 'ls.id=mo.suitid', 'left');
		$this->db->join('u_line AS l', 'l.id=mo.productautoid', 'left');
		$this->db->join('u_member_order_affiliated AS aff', 'aff.order_id=mo.id', 'left');

		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	//获取保险订单数据
	function get_order_insurance($order_id){
		$sql = "SELECT osu.insurance_id,osu.number,osu.amount,su.insurance_name,su.insurance_company,su.insurance_date,su.insurance_price,su.settlement_price FROM u_order_insurance AS osu LEFT JOIN u_travel_insurance AS su ON osu.insurance_id=su.id WHERE osu.order_id={$order_id}";
		$query_res = $this->db->query($sql);
		$result = $query_res->result_array();
		return $result;
	}

	//订单发票信息
	function get_order_invoice($whereArr){
		$sql='mi.invoice_name,mi.invoice_detail,mi.receiver,';
		$sql.='mi.telephone,mi.address,mi.addtime,mi.member_id';
		$this->db->select($sql);
		$this->db->from('u_member_order_invoice AS mo');
		$this->db->join('u_member_invoice AS mi', 'mo.invoice_id = mi.id', 'left');

		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	//获取保险的详细数据
	function get_insurance_detail($insurance_id){
/* 		$sql = "SELECT * FROM u_travel_insurance WHERE id={$insurance_id}";
		$query_res = $this->db->query($sql);
		$result = $query_res->result_array();
		return $result; */
		$sql = "SELECT tin.*,di.description as kingname FROM u_travel_insurance AS tin LEFT JOIN u_dictionary AS di ON di.dict_id = tin.insurance_kind where tin.id=".$insurance_id;
		return $this ->db ->query($sql) ->result_array();
	}
	//遍历表
	public function sel_data($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get($table)->row_array();
		return $query;
	}
	/**
	 * 订单参团人信息
	 */
	function get_order_people($whereArr){
	$this->db->select('	mt.id AS id,
				dict.description AS description,
				mt.name AS m_name,
				mt.certificate_type AS certificate_type,
				mt.certificate_no AS certificate_no,
				mt.endtime AS endtime,
				mt.telephone AS telephone,
				mt.sex AS sex,
				mt.birthday AS birthday,
				mt.people_type AS people_type');
		$this->db->from('u_member_order AS mo');
		$this->db->join('u_member_order_man AS mom', 'mo.id=mom.order_id', 'left');
		$this->db->join('u_member_traver AS mt', 'mom.traver_id=mt.id', 'left');
		$this->db->join('u_dictionary AS dict', 'mt.certificate_type=dict.dict_id', 'left');
		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	/**
	 * 统计订单已经添加的出行人数
	 */
	function get_added_people($whereArr=array()){
		$this->db->select('count(*) AS add_people_count');
		$this->db->from('u_member_order_man as mom');
		$this->db->join('u_member_traver  as mt', 'mom.traver_id=mt.id', 'left');
		$this->db->where($whereArr);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}



	/**
	 * 获取全部的目的地
	 */
          public function get_destinations(){
                   $this->db->select('id,kindname');
                   $this->db->from('u_dest_base');
                   $this->db->where('isopen' ,1);
                   $this->db->order_by('id' ,'asc');
                   $result=$this->db->get()->result_array();
                   return $result;
          }

          /**
	 * 获取全部的证件类型
	 */
          public function get_certificate_type($whereArr=array()){
                   $this->db->select('dict_id,description');
                   //$whereArr['pid'] = 36;
                   $this->db->where($whereArr);
                   $this->db->from('u_dictionary');
                   $result=$this->db->get()->result_array();
                   return $result;
          }

            //查询表的数据
   public function select_table($status,$order_id){
   	$query = $this->db->query('select '.$order_id.' IN (SELECT r.order_id FROM u_refund AS r WHERE r.status='.$status.') as isexist');
   	$rows = $query->row_array();
   	return $rows;
   }

      public function get_time($data){
   	$query = $this->db->query('select TIMESTAMPDIFF(HOUR,"'.$data.'",NOW()) as time');
   	$rows = $query->row_array();
   	return $rows;
   }



  //查询订单的状态
   public function select_order_stutas($id){
   	$query = $this->db->query('select status from u_member_order where id=.'.$id);
   	$rows = $query->row_array();
   	return $rows;
   }

  //修改订单的状态位
   public function updata_order_stutas($where,$data){
   	 $this->db->where($where);
     return   $this->db->update('u_member_order', $data);
   }
	/**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		switch($value['status']){
			case -6:
				$value['status_opera'] = '-6';
				$value['status'] = '经理拒绝';
				break;
		case -4:
			$value['status_opera'] = '-4';
			if($value['ispay']==0 || $value['ispay']==5){
				$value['status']='已取消';
			}elseif($value['ispay']==4 || $value['ispay']==6){
				$value['status']='已退订';
			}
			break;
		case -3:
			$value['status_opera'] = '-3';
			$value['status'] = '退订中';
			break;
		case -2:
			$value['status'] = '旅行社拒绝';
			$value['status_opera'] = '-2';
			break;
		case -1:
			$value['status'] = '供应商拒绝';
			$value['status_opera'] = '-1';
			break;
		case 0:
			$value['status'] = '待留位';
			$value['status_opera'] = '0';
			break;
		case 1:
			$value['status'] = '已预留位';
			$value['status_opera'] = '1';
			if($value['ispay']==2){}
			break;
		case 2:
			$value['status'] = '向旅行社申请额度中';
			$value['status_opera'] = '2';
			break;
		case 3:
			$value['status'] = '向供应商申请额度中';
			$value['status_opera'] = '3';
			break;
		case 4:
			$value['status'] = '已确认';
			$value['status_opera'] = '4';
			break;
		case 5:
			$value['status'] = '已出行';
			$value['status_opera'] = '5';
			break;
		case 6:
			$value['status'] = '已点评';
			$value['status_opera'] = '6';
			break;
		case 7:
			$value['status'] = '已投诉';
			$value['status_opera'] = '7';
			break;
		case 8:
			$value['status'] = '行程结束';
			$value['status_opera'] = '8';
		break;
		case 9:
			$value['status'] = '未提交';
			$value['status_opera'] = '9';
		break;
		case 10:
			$value['status'] = '等待经理审核';
			$value['status_opera'] = '10';
		break;
		case 11:
			$value['status'] = '等待经理审核';
			$value['status_opera'] = '11';
		break;
		default: $value['status'] = '订单状态';break;
	}

	switch($value['ispay']){
		case 0:
		 	if($value['status']==-4){/*  || strtotime($value['usedate'])<time()*/
				//$value['status'] = '已经失效';
		 		$value['status'] = '已取消';
				$value['status_opera'] = '-4';
				$value['ispay'] = '未付款';
				$value['ispay_code']=0;
				break;
			}elseif($value['status']==0){
				$value['ispay'] = '未付款';
				$value['ispay_code']=0;
				break;
			}

		case 1:
			//判断是否退款,退款成功,支付状态为空
			$value['ispay'] = '确认中';
			$value['ispay_code'] = 1;
			break;
		case 2:
			//判断是否退款,退款成功,支付状态为空
			$value['ispay'] = '已收款';
			$value['ispay_code'] = 2;

			break;
		case 3:
			$value['ispay'] = '退款中';
			$value['ispay_code'] = 3;
		break;
		case 4:
			$value['ispay'] = '已退款';
			$value['ispay_code'] = 4;
		break;
		case 5:
			$value['ispay'] = '未交款';
			$value['ispay_code'] = 5;
		break;
		case 6:
			$value['ispay'] = '已交款';
			$value['ispay_code'] = 6;
		break;

		default: $value['ispay'] = '支付状态';break;
	}
	}

	//订单转团--获取订单信息
	function get_line_order_data($where){
		$sql = " SELECT `l`.`id` AS line_id,	`mb_od`.`id` AS order_id,`mb_od`.`ordersn` AS ordersn,mb_od.settlement_price,";
		$sql .= "`mb_od`.`linkman` AS nickname,`mb_od`.`productname` AS linename,ls.suitname, `mb_od`.`suitid`,mb_od.total_price, ";
		$sql .= "(mb_od.childnum + mb_od.dingnum + mb_od.oldnum + mb_od.childnobednum) AS people_num, ";
		$sql .= " (mb_od.total_price + mb_od.settlement_price) AS order_amount,`mb_od`.`usedate` AS usedate,";
		$sql .= " `mb_od`.`ispay`,`mb_od`.`status`,`mb_od`.`addtime` AS addtime,`mb_od`.`dingnum`,`ls`.`unit` AS unit";
		$sql .= "  FROM (`u_member_order` AS mb_od)";
		$sql .= "  LEFT JOIN `u_line` AS l ON `mb_od`.`productautoid` = `l`.`id`";
		$sql .= "  LEFT JOIN `u_line_suit` AS ls ON `ls`.`id` = `mb_od`.`suitid`";
		$sql .= "  WHERE ".$where ;
		$query_res = $this->db->query($sql);
		$result = $query_res->row_array();
		return $result;
	}
	//订单转团--获取订单套餐的出团日期
	function get_order_date($id){
	            $sql = " SELECT  unit,lsp.* ";
		$sql .= "  FROM (`u_member_order` AS mb_od) ";
		$sql .= "  LEFT JOIN `u_line_suit` AS ls ON `ls`.`id` = `mb_od`.`suitid`";
		$sql .= "  LEFT JOIN u_line_suit_price as lsp on lsp.suitid=ls.id";
		$sql .= "  WHERE  CURDATE()<lsp.day and mb_od.id={$id} and mb_od.usedate!=lsp.day " ;
		$query_res = $this->db->query($sql);
		$result = $query_res->result_array();
		return $result;
	}
	//订单转团--获取订单套餐
	function  get_line_order_suit($id,$suitid){
		 $sql =" SELECT ls.* FROM	u_member_order AS mb_od LEFT JOIN u_line_suit AS ls ON ls.lineid = mb_od.productautoid  ";
		 $sql .=" where  mb_od.id={$id} and   ls.id={$suitid}";
		 $query_res = $this->db->query($sql);
		$result = $query_res->result_array();
		return $result;
	}
	//订单转团--获取套餐日期价格
	function get_table_data($where){

		$sql = " SELECT lsp.*";
		$sql .= "  FROM u_line_suit_price as lsp";
		//$sql .= "  LEFT JOIN u_member_order as mb_od on lsp.suitid=mb_od.suitid";
		$sql .= "  WHERE ".$where ;
		$query_res = $this->db->query($sql);
		$result = $query_res->result_array();
		return $result;
	}
	//订单套餐日期的转换
	function return_order_siutDate($order_price,$old_price,$suitid,$dayid,$orderid,$expert_id,$suitPrice){
		$this->db->trans_start();
		$re=1;
                            //原来的订单价格
		 $price=$this->sel_data('u_member_order',array('id'=>$orderid));

		 //修改后的价格
		 $total_price=$order_price;


		 //转团差价
                          $diff_price= ($total_price-$old_price)+$price['diff_price'];

                          //修改订单的套餐价格
                          $orderprice = array(
                        		    'trun_status'=>1,
                        		  //   'diff_price'=>$diff_price,
                          );

	             $this->db->where(array("id"=>$orderid))->update('u_member_order',  $orderprice);

                          //修改订单的套餐价格转态
                          if($diff_price==0){
                          	$f_price=$price['total_price']+($total_price-$old_price);
                          }else{
                       		$f_price=$price['total_price']+($total_price-$old_price);
                          }

                        //转团记录表      u_member_order_diff
	             $order_diff=array(
				      'order_id'=>$orderid,
				      'suit_id'=>$suitid,
				      'days_id'=>$dayid,
				      'usedate'=>$suitPrice['day'],
				      'reason'=>'订单转团',
				      'diff_price'=>$diff_price,
				      'status'=>0,
				      'order_price'=>$order_price,
				      'total_price'=>$f_price,
				     );
	             $diffData=$this->sel_data('u_member_order_diff',array('order_id'=>$orderid,'status'=>0));
	             if(!empty($diffData)){    //订单
                                      $this->db->where(array("order_id"=>$orderid,'status'=>0))->update('u_member_order_diff', $order_diff);
	             }else{    //插入订单转团
			$this->db->insert('u_member_order_diff',$order_diff);
	             }
	        //     echo $this->db->last_query();

	    	$this->db->trans_complete();
	    	if ($this->db->trans_status() === FALSE)
	    	{
	    		echo false;
	    	}else{
	    		return $re;
	    	}
	}

}