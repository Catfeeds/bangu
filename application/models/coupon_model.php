<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Coupon_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'u_member' );
	}
	
		/**
		 * 获取优惠券的列表
		 * 
		 * */
		function get_coupon_list($id, $page = 1, $num = 10){
			$query_sql ='';
			$query_sql .= 'SELECT	cc.id,cc.name,cc.starttime,cc.endtime,cc.coupon_price, ';
			$query_sql .= 'CASE WHEN DATEDIFF(cc.endtime, NOW()) < 0 THEN "已过期" WHEN cmc. STATUS = - 1 THEN "已过期" WHEN cmc. STATUS = 1 THEN "已使用" WHEN cmc. STATUS = 0 THEN "未使用" END AS "status"   ';
			$query_sql .= 'FROM cou_coupon AS cc ';
			$query_sql .= 'LEFT JOIN cou_member_coupon AS cmc ON cc.id = cmc.coupon_id ';
			$query_sql .= 'WHERE cmc.member_id ='.$id;			
	
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$query_sql .=' limit '.$offset.','.$num;
			}
			$query = $this->db->query($query_sql)->result_array();
			return $query;

		}
		/*根据提交获取优惠券*/
		function get_where_coupon($id,$type=2, $page = 1, $num = 10){
			$query_sql ='';
			$query_sql .= 'SELECT	cc.id,cc.name,cc.starttime,cc.endtime,cc.coupon_price,cc.use_url, ';
			$query_sql .= 'CASE WHEN DATEDIFF(cc.endtime, NOW()) < 0 THEN "-1" WHEN cmc. STATUS = - 1 THEN "-1" WHEN cmc. STATUS = 1 THEN "1" WHEN cmc. STATUS = 0 THEN "0" END AS "status"   ';
			$query_sql .= 'FROM cou_coupon AS cc ';
			$query_sql .= 'LEFT JOIN cou_member_coupon AS cmc ON cc.id = cmc.coupon_id ';
			$query_sql .= 'WHERE cmc.member_id ='.$id;
			
		
		   if($type==0){ //未使用	
				$query_sql .= ' AND (cmc.status = 0 AND DATEDIFF(cc.endtime,NOW())>0)';
			}elseif($type==1){  //已使用
				$query_sql .= ' AND (cmc.status = 1 )';
			}elseif ($type==-1){  //已经过期
				$query_sql .= ' AND (cmc.status = -1 OR  DATEDIFF(cc.endtime,NOW())<0 )';
			} 
			$query_sql .= ' order by cmc.status desc';
		 	if ($page > 0) {
				$offset = ($page-1) * $num;
				$query_sql .=' limit '.$offset.','.$num;
			}
			$query = $this->db->query($query_sql)->result_array();
			return $query;
		}

}
