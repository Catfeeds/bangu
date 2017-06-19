<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Customize_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_customize' );
	}
	/**
	 * @method 生成定制单
	 * @author jiakairong
	 * @since  2015-11-06
	 * @param unknown $customArr 定制单信息
	 * @param unknown $destArr   用户选择的目的地
	 * @param unknown $memberArr  会员注册的信息，若手机号没有注册，则自动注册 
	 */
	public function createCustom($customArr ,$destArr ,$memberArr)
	{
		$this->db->trans_start();
		if (!empty($memberArr))
		{
			//自动注册会员
			$this->db->insert('u_member',$memberArr);
			$userid = $this->db->insert_id();
			$customArr['member_id'] = $userid;
			//写入积分变化表
			if ($memberArr['jifen'] >0)
			{
				$memberLogArr = array(
						'member_id' =>$userid,
						'point_before' =>0,
						'point_after' =>$memberArr['jifen'],
						'point' =>$memberArr['jifen'],
						'content' =>'注册赠送积分',
						'addtime' =>$memberArr['logintime']
				);
				$this ->db ->insert('u_member_point_log' ,$memberLogArr);
			}
		}
		//写入定制单表
		$this->db->insert('u_customize' ,$customArr);
		$customId = $this->db->insert_id();
		//写入定制目的地表
		foreach ($destArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$customDestArr = array(
				'customize_id' =>$customId,
				'dest_id' =>$val
			);
			$this->db->insert('u_customize_dest' ,$customDestArr);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		} else {
			return array('customId' =>$customId ,'userid' =>$customArr['member_id']);
		}
	}
	/**
	 * @method 获取定制单的目的地
	 * @param unknown $customid 定制单ID 
	 */
	public function getCustomDest($customid)
	{
		$sql = 'select d.kindname from u_customize_dest as cd left join u_dest_base as d on d.id = cd.dest_id where d.level=3 and cd.customize_id = ?';
		return $this ->db ->query($sql ,$customid) ->result_array();
	}
	
	/**
	 * @method 获取定制数据详情
	 * @param unknown $cid
	 */
	public function getCustomDetail($cid ,$userid)
	{
		$sql = 'select c.*,s.cityname from u_customize as c left join u_startplace as s on c.startplace = s.id where c.id = '.$cid.' and member_id ='.$userid;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取定制数据，用于平台定制单管理
	 * @since  2015-12-16
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getCustomizeAdmin(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr  as $key=>$val)
		{
			$whereStr .= ' '.$key.' "'.$val.'" and';
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select u.id,u.linkname,u.linkphone,u.startdate,u.startplace,u.endplace,u.budget,u.total_people,u.days,s.cityname from u_customize as u left join u_startplace as s on s.id=u.startplace '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by u.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 获取定制单详情,用于平台查看详情
	 * @author jiakairong
	 * @since  2015-12-17
	 * @param unknown $id
	 */
	public function getCustomizeDetail($id)
	{
		$sql = 'select u.*,s.cityname,e.nickname,e.small_photo,e.satisfaction_rate,e.total_score,e.id as expert_id from u_customize as u left join u_startplace as s on s.id=u.startplace left join u_expert as e on e.id = u.expert_id where u.id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取定制数据,用于前台
	 * @param unknown $whereArr
	 * @param unknown $page
	 * @param number $num
	 */
	public function get_customize_data (array $whereArr ,$page=1 ,$num = 10) {
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			if (empty($val))
			{
				continue;
			}
			switch($key)
			{
				case 'endplace':
				case 'destName':
					$whereStr .= ' (';
					foreach($val as $i)
					{
						$whereStr .= ' find_in_set ('.$i.' ,c.endplace) or';
					}
					$whereStr = rtrim($whereStr ,'or').' ) and';
					break;
				default:
					$whereStr .= ' '.$key.'="'.$val.'" and';
					break;
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		$limitStr = ' limit '.($page-1)*$num.','.$num;
		
		$sql = 'select c.id,c.pic,c.question,c.budget,c.addtime,e.realname,e.nickname,e.small_photo,c.isshopping as shopping,e.id as eid,c.startdate,c.estimatedate from u_customize as c left join u_customize_answer as ca on ca.customize_id = c.id left join u_expert as e on ca.expert_id = e.id where '.$whereStr;
		
		$data['count'] = $this ->getCount($sql ,array());
		$sql = $sql.' order by c.id desc '.$limitStr;
		$data['customData'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}
}