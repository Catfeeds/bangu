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

class Turnover_statistics_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_all_turnover($whereArr=array(), $page = 1, $num = 10,$depart_id,$expert_id) {
	$sql = " SELECT mo.id, mo.ordersn, mo.total_price, mo.usedate, mo.productname, COALESCE((select sum(amount) from u_order_bill_ys AS ys where ys.amount>0 AND ys.status=1 and ys.order_id=mo.id ),0) as ys, COALESCE((select sum(amount) from u_order_bill_ys AS ys where ys.amount<0 AND ys.status=1 and ys.order_id=mo.id ),0) as yt, mo.total_price-COALESCE((select sum(amount) from u_order_bill_ys AS ys where ys.amount>0 AND ys.status=1 and ys.order_id=mo.id ),0) as wsk FROM u_member_order AS mo  WHERE mo.user_type=1 AND mo.depart_id=1";

		$whereStr = '';
		if (!empty($whereArr)){
			foreach($whereArr as $key=>$val){
				if($key!="overcity"){
					$whereStr .= ' '.$key.'"'.$val.'" and';
				}else{
					$whereStr .= ' '.$val.' and';
				}
			}
			$whereStr = rtrim($whereStr ,'and');
			$sql = $sql.' AND '.$whereStr;
		}
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY mo.id DESC";
			$sql = $sql." limit $offset,$num";
			$query = $this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}else{
			$total_num = $this->getCount($sql,'');
			return $total_num;
		}
	}

}