<?php
/*
 * do one sql one model by zhy at 2016年2月18日 15:13:16
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Wx_gift_model extends MY_Model {
	private $table_name = 'wx_gift';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * 可用于抽奖的礼品
	 * */
	function enable_gift($where_supplier,$activity_id)
	{
		
		$this->db->where('status','0');
		$this->db->where('num >','0');
		$this->db->where($where_supplier);
		$this->db->where('activity_id',$activity_id);
		
			
		$this->db->order_by('level');
		
		$query = $this->db->get($this->table);
		
		return $query->result_array();
	}
	/**
	 * 查看会员的手机号
	 * */
	function member_phone($member_id)
	{
	
	    $sql="SELECT m.mobile,m.mid FROM wx_member as wm left join u_member as m on wm.member_id=m.mid WHERE wm.id={$member_id}";
		
		$query = $this->db->query ( $sql, array ( $openId ) );
		return $query->row_array();
	}
	
}