<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cou_action_model extends MY_Model
{
	private $table_name = 'cou_action';

	public function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 更改用户的优惠券，更改优惠券数量
	 * @param unknown $mid  会员ID
	 * @param unknown $actionCouponData 要赠送的优惠券以及数量的数组
	 */
	public function changeMemberCoupon($mid ,$actionCouponData)
	{
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$this->db->trans_start();
		foreach($actionCouponData as $val)
		{
			//减去优惠券的数量
			$sql = 'update cou_coupon set number = number -'.$val['cacNumber'].' where id = '.$val['id'];
			$this ->db ->query($sql);
			//写入用户和优惠券项目奖励记录
			$cmaArr = array(
					'member_id' =>$mid,
					'action_id' =>$val['actionid'],
					'coupon_id' =>$val['id'],
					'number' =>$val['cacNumber'],
					'addtime' =>$time
			);
			$this ->db ->insert('cou_member_action_reword' ,$cmaArr);
			$a = 1;
			for($a ;$a <= $val['cacNumber'] ;$a++)
			{
				//写入用户拥有的优惠券表
				$cmArr = array(
						'coupon_id' =>$val['id'],
						'member_id' =>$mid,
						'status' =>0
				);
				$this ->db ->insert('cou_member_coupon' ,$cmArr);
			}
		}
		//写入用户与优惠券项目记录
		$maArr = array(
				'member_id' =>$mid,
				'action_id' =>$cmaArr['action_id'],
				'addtime' =>$time
		);
		$this ->db ->insert('cou_member_action' ,$maArr);
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * @method 通过唯一标识获取项目
	 * @author jiakairong
	 * @since  2015-11-17
	 * @param unknown $code
	 */
	public function getCouActionCode($code)
	{
		$time = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
		$sql = 'select id,isrepeat from cou_action where action_code = "'.$code.'" and starttime <= "'.$time.'" and endtime >"'.$time.'"';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 根据项目获取优惠券
	 * @author jiakairong
	 * @since  2015-11-17
	 * @param unknown $actionid  项目ID
	 */
	public function getActionCoupon($actionid)
	{
		$sql = 'select cc.id,cc.number as couponNumber,cac.number as cacNumber,ca.id as actionid from cou_action as ca left join cou_action_coupon as cac on cac.action_id = ca.id left join cou_coupon as cc on cc.id=cac.coupon_id where cc.status = 1 and ca.id = '.$actionid;
		return $this ->db ->query($sql) ->result_array();
	}
}