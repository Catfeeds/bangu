<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Live_recharge_model extends APP_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	protected  $table= 'live_recharge';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table );
	}
	/**
	 * @method 用户充值
	 * @author jkr
	 * @since  2016-06-02
	 * @param intval $user_id 用户ID
	 * @param array $rechargeArr 用户充值信息
	 * @param intval $recharge_id 充值记录ID
	 */
	public function userRecharge($user_id ,$rechargeArr ,$recharge_id)
	{
		$this->db->trans_start();
		//更新用户的U币余额
		$sql = 'update live_anchor set umoney = umoney +'.$rechargeArr['umoney'].' where anchor_id='.$user_id;
		$this ->db ->query($sql);
		//写入用户购买礼物记录
		$this ->db ->where(array('id' =>$recharge_id)) ->update('live_recharge' ,$rechargeArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 获取充值记录数据，用于平台管理
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getRechargeData(array $whereArr ,$orderBy = 'r.id desc')
	{
		$sql = 'select r.*,a.name as username from live_recharge as r left join live_anchor as a on a.anchor_id=r.user_id';
		return $this ->queryCommon($sql ,$whereArr , $this ->getLimitStr() ,'order by '.$orderBy);
	}
	/**
	 * @method 获取某个会员的充值记录，用于app接口
	 * @param unknown $user_id 会员ID
	 */
	public function getAppRechargeData($user_id ,$page=1 ,$pagesize=10)
	{
		$sql = 'select * from live_recharge where status = 1 and user_id='.$user_id.' order by id desc limit '.($page-1)*$pagesize.','.$pagesize;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取记录总数
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getRechargeCount(array $whereArr)
	{
		$sql = 'select count(r.id) as count from live_recharge as r left join live_anchor as a on a.anchor_id=r.user_id';
		return $this ->queryCommonRow($sql ,$whereArr);
	}
}