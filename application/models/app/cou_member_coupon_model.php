<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cou_member_coupon_model extends MY_Model
{
	private $table_name = 'cou_member_coupon';

	public function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取用户的优惠券
	 * @param array $whereArr 
	 */
	public function getMemberCouponData(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'="'.$val.'" and';
		}
		$whereStr = rtrim($whereStr ,'and');
		
		$sql = 'select cmc.id as mcid,cmc.coupon_id,cc.name,cc.min_price,cc.coupon_price,cc.starttime,cc.endtime,cc.use_platform from cou_member_coupon as cmc left join cou_coupon as cc on cc.id = cmc.coupon_id where '.$whereStr.' and (cc.use_platform = 0 or cc.use_platform = 1) order by cc.showorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/*
*
*        do     order   coupon    
*
*        by     zhy
*
*        at    2015年12月30日 15:23:53
*
*/
		public function page_my_coupon_order($m_id,$where=array()){
		$sql = "SELECT
		cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,
		cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url
		FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id
		WHERE cmc.status>=0 and cc.status='1' and cmc.member_id={$m_id}";
		
	    $sql.=" and cmc.id={$where['id']}"; //member_coupon的id
		$sql.=" order by cmc.status,cmc.id desc";
	
		$sql2 = "SELECT
		cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,
		cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url
		FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id
		WHERE cmc.status<0 and cc.status='1' and cmc.member_id={$m_id}";
		$sql2.=" and cmc.id={$where['id']}"; //member_coupon的id
		$sql2.=" order by cmc.status,cmc.id desc";
		$query = $this->db->query ( $sql );
			$query2 = $this->db->query ( $sql2 );
			$reDataArr['new'] = $query->result_array (); //未使用、已使用
			$reDataArr['old'] = $query2->result_array ();//已过期
			return $reDataArr;
	}
}