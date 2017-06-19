<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月1日15:22:54
 * @author		徐鹏
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Refund_model extends UB2_Model {

	/**
	 * 定义表字段集合（全部），主键字段不包含在内。
	 *
	 * @var String
	 */
	private $table_name = 'u_refund';

	public function __construct() {
		parent::__construct($this->table_name);
	}

	/**
	 * 获取能退款的列表数据
	 * @param array $whereArr	查询条件
	 * @param number $page		分页数
	 * @param number $num		单面显示数
	 * @return array
	 */
	public function get_refund_list($whereArr,$page = 1, $num = 10,$expert_id) {
		$where_str = "";
		$sql = "SELECT
			    mo.productautoid AS line_id,mo.id AS order_id,mo.ordersn,m.nickname AS predeter,mo.productname AS producttitle,mo.linkmobile,
			    (mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum) AS people_num,mo.total_price AS order_amount,
			    CASE WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status!=2) THEN (SELECT r.amount_apply FROM u_refund AS r WHERE r.order_id=mo.id ORDER BY r.addtime DESC LIMIT 1)
			    WHEN mo.id NOT IN (SELECT r.order_id FROM u_refund AS r ) THEN '0'
			    END refund_amount,
			    CONCAT(s.company_name,s.brand) AS supplier_name,mo.usedate AS depature_date,
			    CASE
			    WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=2) THEN '1'
			    WHEN mo.id NOT IN (SELECT r.order_id FROM u_refund AS r ) THEN '2'
			    WHEN mo.ispay=3 AND mo.status=-3 THEN '3'
			    WHEN mo.ispay=4 AND mo.status=-4 THEN '4'
			    END refund_status,
			    CASE
			    WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=1) THEN (SELECT r.modtime FROM u_refund AS r WHERE r.order_id=mo.id)
			    ELSE (SELECT r.addtime FROM u_refund AS r WHERE r.order_id=mo.id)
			    END refund_time,
			    CASE
			    WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status!=2) THEN (SELECT r.reason FROM u_refund AS r WHERE r.order_id=mo.id ORDER BY r.addtime DESC LIMIT 1)
			    ELSE '无'
			    END refund_reason,
			    CASE
			    WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status!=2) THEN (SELECT r.mobile FROM u_refund AS r WHERE r.order_id=mo.id ORDER BY r.addtime DESC LIMIT 1)
			    ELSE ''
			    END client_mobile
			    FROM u_member_order AS mo
			    LEFT JOIN u_member AS m ON mo.memberid=m.mid
			    LEFT JOIN u_expert AS e ON mo.expert_id=e.id
			    LEFT JOIN u_supplier AS s ON mo.supplier_id=s.id
			    WHERE (((mo.status=1 OR mo.status=4) AND mo.ispay=2) OR (mo.ispay=3 AND mo.status=-3 ) OR (mo.ispay=4 AND mo.status=4))
			    AND e.id=$expert_id";
			if(!empty($whereArr)){
				foreach ($whereArr as $key => $value) {
					switch ($key) {
						case 'productname':
							$where_str = $where_str.' AND mo.productname LIKE \'%' .$value.'%\' ';
							break;
						case 'ordersn':
							$where_str = $where_str.' AND mo.ordersn=\'' .$value.'\' ';
							break;
						case 'usedate':
							$usedata_arr = explode(' - ',$value);
							$where_str = $where_str.' AND mo.usedate >=\''.$usedata_arr[0].' 00:00:00\''.' AND mo.usedate <=\''.$usedata_arr[1].' 23:59:59\'';
							break;
						case 'supplier_id':
							$where_str = $where_str.' AND mo.supplier_id ='.$value.' ';
							break;
						default:
							break;
					}
				}
			}
			$sql = $sql.$where_str;
	    		if ($page > 0) {
				$offset = ($page-1) * $num;
				/*$sql = $sql." ORDER BY c.addtime DESC";*/
				$sql = $sql." limit $offset,$num";
				$query = $this->db->query($sql);
				$result=$query->result_array();
				return $result;
			}else{
				$total_num = $this->getCount($sql,'');
				return $total_num;
			}
	}

	/**
	 * 从系统配置那里获取已有的退款理由
	 * @param  [type] $cancle_reason [description]
	 * @return [type]                [description]
	 */
	function get_refund_reason($cancle_reason){
		$sql = "select description from u_dictionary where dict_id=$cancle_reason";
		$reason_res = $this->db->query($sql)->result_array();
		$reason = $reason_res[0]['description'];
		return $reason;
	}
	/**
	 * 退款的一些信息插入订单附表
	 * @param  [type] $expert_id           [description]
	 * @param  [type] $order_sn            [description]
	 * @param  [type] $reason              [description]
	 * @param  [type] $refund_apply_amount [description]
	 * @param  [type] $now                 [description]
	 * @return [type]                      [description]
	 */
	function insert_order_attach($expert_id,$order_sn,$reason,$refund_apply_amount,$now){
		$refund_sql = "INSERT INTO u_refund (refund_id,refund_type,order_id,reason,bankcard,bankname,approve_status,is_remit,modtime,addtime,amount_apply,amount,mobile,status)SELECT {$expert_id},1,$order_sn,'$reason',bankcard,bankname,0,0,'$now','$now',$refund_apply_amount,0,mobile,0 FROM u_expert where id=".$expert_id;
		$status = $this->db->query($refund_sql);
		return $status;
	}

	function update_order_status($order_sn){
		$sql = "UPDATE u_member_order SET ispay=3,STATUS = -3,canceltime='".date('Y-m-d')."' WHERE id = $order_sn";
		$status = $this->db->query($sql);
		return $status;
	}

	function insert_member_log($order_sn,$expert_id){
		$date = date('Y-m-d H:i:s');
		$sql = "INSERT INTO u_member_order_log(order_id,op_type,userid,content,addtime) values ({$order_sn},1,{$expert_id},'管家帮客户申请退款','{$date}')";
		$status = $this->db->query($sql);
		return $status;
	}

          /**
           * 获取全部供应商
           */
          public function get_suppliers(){
          	$this->db->select('id,realname');
          	$this->db->where(array('status'=>2));
             $this->db->from('u_supplier');
             $result=$this->db->get()->result_array();
             return $result;
          }
}