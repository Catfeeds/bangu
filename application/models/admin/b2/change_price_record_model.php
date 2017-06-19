<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Change_price_record_model extends MY_Model {

	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'u_order_price_apply';
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}



	function get_record_list($page = 1, $num = 10,$expert_id,$apply_status){
		$sql = "SELECT  mo.ordersn AS ordersn,m.nickname AS nickname,mo.productname AS productname,mo.usedate AS usedate, op.before_price AS before_price,op.after_price AS after_price,op.expert_reason AS expert_reason,op.supplier_reason AS supplier_reason,op.modtime AS modtime,op.addtime AS addtime  FROM u_order_price_apply AS op LEFT JOIN u_member_order AS mo ON op.order_id=mo.id LEFT JOIN u_member AS m ON mo.memberid=m.mid WHERE op.expert_id={$expert_id} AND op.status={$apply_status}";
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY op.addtime DESC";
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