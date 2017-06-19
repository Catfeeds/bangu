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

class Change_approval_model extends MY_Model {

	public function __construct() {
		parent::__construct('u_order_bill_ys');
	}


	//获取改价退团列表数据
	public function get_approval_data($whereArr,$page = 1, $num = 10) {
			$sql = 'SELECT ofd.sk_money,ofd.id AS refund_id, dep.name AS depart_name,md.id AS order_id,ys.id AS ys_id, yf.id AS yf_id, ys.item, COALESCE(ys.amount,0) AS ys_amount,  COALESCE(yf.amount,0) AS yf_amount, md.total_price, md.ordersn, ys.user_name, ys.`status` AS ys_status, ys.addtime, yf.kind, yf.user_type, COALESCE((select sum(os.money) from u_order_receivable as os where os.order_id=ys.order_id and os.`status`=2),0) AS receive_amount, md.depart_id FROM u_order_bill_ys AS ys LEFT JOIN u_order_bill_yf AS yf ON ys.id = yf.ys_id LEFT JOIN u_member_order AS md ON md.id = ys.order_id LEFT JOIN b_depart  AS dep ON dep.id = md.depart_id LEFT JOIN u_expert  AS e ON e.id = md.expert_id LEFT JOIN u_order_refund AS ofd ON ofd.ys_id=ys.id WHERE ys.source=2 AND  FIND_IN_SET('.$this->session->userdata('depart_id').',e.depart_list)>0';

			$whereStr = '';
			if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				$whereStr .= ' '.$key.'"'.$val.'" AND';
			}
			$whereStr = rtrim($whereStr ,'AND');
			$sql = $sql.' AND '.$whereStr;
			}

			 if ($page > 0) {
				$offset = ($page-1) * $num;
				$sql = $sql." ORDER BY ys.addtime DESC";
				$sql = $sql." limit $offset,$num";
				$query = $this->db->query($sql);
				$result=$query->result_array();
				return $result;
			}else{
				$total_num = $this->getCount($sql,'');
				return $total_num;
			}
	}


	//修改订单的价格
	public function update_order_price($order_id,$ys_id){
		$sql = "UPDATE u_member_order AS mo SET total_price=total_price+(SELECT ys.amount FROM u_order_bill_ys AS ys WHERE ys.id={$ys_id}) WHERE mo.id={$order_id}";
		$query = $this->db->query($sql);
		return $query;
	}


	//获取一条订单数据
	public function get_one_order($order_id){
		$sql = 'SELECT md.*,e.realname,suit.suitname,suit.unit,l.linebefore,aff.deposit FROM u_member_order AS md LEFT JOIN u_expert AS e ON e.id=md.expert_id LEFT JOIN u_line_suit AS suit ON suit.id=md.suitid  LEFT JOIN u_line AS l ON l.id=md.productautoid LEFT JOIN u_line_affiliated AS aff ON aff.line_id=l.id WHERE md.id='.$order_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}

	//恢复被删除的人员信息;订单人数相对应的变化
	public function return_del_travel($order_id, $yf_id){
		$sql = 'SELECT count(id) AS all_id FROM u_order_travel_del WHERE order_id='.$order_id.' AND yf_id='.$yf_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if($result[0]['all_id']>0){
			$sql = 'INSERT INTO  u_member_traver ( name, enname, certificate_type, certificate_no, endtime, country, telephone, sex, birthday, addtime, modtime, isman, member_id, ENABLE, sign_place, sign_time, people_type, cost, price ) SELECT NAME, enname, certificate_type, certificate_no, endtime, country, telephone, sex, birthday, addtime, modtime, isman, member_id, ENABLE, sign_place, sign_time, people_type, cost, price FROM u_order_travel_del WHERE order_id='.$order_id.' AND yf_id='. $yf_id;
			$query = $this->db->query($sql);
			$start_trave_id = $this->db->insert_id();
			$affect_row = $this->db->affected_rows();
			for($i=0; $i<$affect_row; $i++){
				$this->db->query('INSERT INTO u_member_order_man (traver_id,order_id) VALUES ('.($start_trave_id+$i).', '.$order_id.')');
			}
			$sql2 = 'DELETE FROM u_order_travel_del WHERE order_id='.$order_id.' AND yf_id='. $yf_id;
			$status = $this->db->query($sql2);
			return $status;
		}
	}

	//订单相对应的出游人恢复
	public function return_order_travel($order_id, $yf_id){
		$res = array(
			'dingnum'=>0,
			'childnum'=>0,
			'oldnum' =>0,
			'childnobednum'=>0
			);
		$sql = 'SELECT count(*) AS peoppe_count,people_type FROM u_order_travel_del WHERE order_id='.$order_id.' AND yf_id='.$yf_id.' GROUP BY people_type ';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result)){
			//人群种类1成人2老人3儿童占床4儿童不占床
			foreach ($result as $key => $val) {
				if($val['people_type']==1){
					$res['dingnum'] = $res['dingnum']+$val['peoppe_count'];
				}elseif($val['people_type']==2){
					$res['oldnum'] = $res['oldnum']+$val['peoppe_count'];
				}elseif($val['people_type']==3){
					$res['childnum'] = $res['childnum']+$val['peoppe_count'];
				}elseif($val['people_type']==4){
					$res['childnobednum'] = $res['childnobednum']+$val['peoppe_count'];
				}
			}
			$sql2 = ' UPDATE u_member_order SET dingnum=dingnum+'.$res['dingnum'].', oldnum=oldnum+'.$res['oldnum'].', childnum=childnum+'.$res['childnum'].', childnobednum=childnobednum+'.$res['childnobednum'].' WHERE id='.$order_id;
			$query = $this->db->query($sql2);
		}
	}

	//订单相对应的出游人恢复
	public function get_order_travel($ids){
		$sql = 'select * FROM u_member_traver  where id IN('.$ids.')';
		$query = $this->db->query($sql);
		$res=$query->result_array();
		return $res;
	}


	 //获得管家可用额度之和
 function get_expert_limit($order_id){
 		$final_res = array();
 		$order_depart_sql = 'select depart_id from u_member_order where id='.$order_id;
 		$query = $this->db->query($order_depart_sql);
 		$order_depart=$query->result_array();
 		$sql = 'SELECT ela.apply_amount,ela.real_amount FROM b_expert_limit_apply AS ela WHERE order_id='.$order_id;
		$query = $this->db->query($sql);
		$res=$query->result_array();
		$sql_depart = 'SELECT cash_limit,credit_limit FROM b_depart  WHERE id='.$order_depart[0]['depart_id'];
		$query = $this->db->query($sql_depart);
		$result=$query->result_array();
		if(!empty($res)){
			$total_limit = $result[0]['cash_limit']+$result[0]['credit_limit']+($res[0]['apply_amount']-$res[0]['real_amount']);
			$final_res['cash_limit'] 		=  $result[0]['cash_limit'];
			$final_res['credit_limit'] 		=  $result[0]['credit_limit'];
			$final_res['apply_amount'] 	=  $res[0]['apply_amount'];
			$final_res['real_amount'] 		=  $res[0]['real_amount'];
			$final_res['total_limit'] 		=  $total_limit ;
		}else{
			$total_limit = $result[0]['cash_limit']+$result[0]['credit_limit'];
			$final_res['cash_limit'] 		=  $result[0]['cash_limit'];
			$final_res['credit_limit'] 		=  $result[0]['credit_limit'];
			$final_res['apply_amount'] 	=  0;
			$final_res['real_amount'] 		=  0;
			$final_res['total_limit'] 		=  $total_limit ;
		}
		return $final_res;
 	}

 	 	//获取营业部额度
 	function get_depart_limit($pass_depart_id){
 		$sql = 'SELECT * FROM b_depart WHERE id='.$pass_depart_id;
		$depart_limit = $this->db->query($sql)->result_array();
		if(!empty($depart_limit)){
			return $depart_limit[0];
		}else{
			return array('cash_limit'=>0,'credit_limit'=>0);
		}

 	}

	//获取一条应收记录
	function get_one_ys($ys_id){
		$sql='SELECT ys.amount,ys.status FROM u_order_bill_ys AS ys WHERE ys.id='.$ys_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(empty($result)){
			return array();
		}else{
			return $result[0];
		}
	}


	//获取一条应付记录
	function get_one_yf($yf_id){
		$sql='SELECT amount FROM u_order_bill_yf  WHERE id='.$yf_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(empty($result)){
			return array();
		}else{
			return $result[0];
		}
	}

	//获取一条应付记录
	function get_one_refund($ys_id){
		$sql='SELECT * FROM u_order_refund  WHERE ys_id='.$ys_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(empty($result)){
			return array();
		}else{
			return $result[0];
		}
	}

	//获取一条扣款记录
	function get_order_debit($order_id){
		$sql='SELECT od.* FROM u_order_debit AS od WHERE od.order_id='.$order_id.' AND od.status=0';
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}

	//获取一条扣款记录
	function get_one_debit($order_id,$type){
		$sql='SELECT od.* FROM u_order_debit AS od WHERE od.order_id='.$order_id.' AND od.type='.$type;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result[0];
	}

	//获取退团人的信息
	function get_travel_record($order_id,$ys_id){
		$sql='SELECT * FROM u_record_tuituan_travel  WHERE order_id='.$order_id.' AND ys_id='.$ys_id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
}
