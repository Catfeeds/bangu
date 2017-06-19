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

class League_approval_model extends MY_Model {

	public function __construct() {
		parent::__construct('u_order_bill_yf');
	}


	//获取订单列表数据
	public function get_league_data($page = 1, $num = 10,$depart_id,$league_status) {
			$sql = 'SELECT yf.*,mo.ordersn,mo.productname FROM u_order_bill_yf AS yf LEFT JOIN u_member_order AS mo ON mo.id=yf.order_id WHERE yf.depart_id='.$depart_id.' AND yf.status='.$league_status;
			 if ($page > 0) {
				$offset = ($page-1) * $num;
				$sql = $sql." ORDER BY yf.addtime DESC";
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
