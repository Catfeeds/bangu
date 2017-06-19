<?php
/*
 * do one sql one model by zhy at 2016年2月18日 15:13:16
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Wx_member_model extends MY_Model {
	private $table_name = 'wx_member';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * 获取用户是否存在
	 */
	public function getMemberByOpenId($openId){
		$sql="SELECT * FROM wx_member WHERE openid=?";
		
		$query = $this->db->query ( $sql, array ( $openId ) );
		return $query->row_array();
	}
	
	/**
	 * 获取用户是否存在
	 */
	public function getMemberById($id){
		$query = $this->db->query ( "SELECT * FROM wx_member WHERE id=?", array ( $id ) );
		return $query->row_array();
	}
	
	
	/**
	 * 获取活动数量
	 */
	public function getActivityNumber($code){
		$query = $this->db->query ( "SELECT * FROM wx_activity WHERE code=?", array ( $code ) );
		return $query->row_array()["num"];
	}
	
	public function save_wx_member($wx_member){
		$this->db->trans_begin ();
		$wx_member['reg_status'] = 0;
		$wx_member['member_id'] = 0;
		$wx_member['privilege'] = "";
		$wx_member['unionid'] = "";
		$this->db->insert ( 'wx_member', $wx_member );
		$wx_member['id'] = $this->db->insert_id ();
		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			return false;
		} else {
			$this->db->trans_commit ();
			return $wx_member;
		}
	}
	
	/**
	 * 注册用户 
	 * @param unknown $code
	 * @param unknown $num
	 */
	public function updateMemberStatus($openId,$member_id,$channel){
		$this->db->trans_begin ();
		$updateSQL = "UPDATE wx_member SET reg_status=1,member_id={$member_id} WHERE openid=?";
		$query = $this->db->query ( $updateSQL, array( $openId ));
		//减去数量
		if($channel=='pl')
		{
		$query = $this->db->query ( "UPDATE wx_activity SET num=num-1  WHERE code=? ", array("reg_pl"));
		}
		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			return false;
		} else {
			$this->db->trans_commit ();
			return true;
		}
	}
	/**
	 * 注册用户,数量不减1
	 * @param unknown $code
	 * @param unknown $num
	 */
	public function updateMemberStatus_two($openId,$member_id){
		$this->db->trans_begin ();
		$updateSQL = "UPDATE wx_member SET reg_status=1,member_id={$member_id} WHERE openid=?";
		$query = $this->db->query ( $updateSQL, array( $openId ));
		
		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			return false;
		} else {
			$this->db->trans_commit ();
			return true;
		}
	}
	
	
}