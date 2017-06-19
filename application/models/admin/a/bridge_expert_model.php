<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Bridge_expert_model extends MY_Model
{
	private $table_name = 'bridge_expert';
	
	function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取管家修改资料数据 
	 * @author jiakairong
	 * @since  2015-11-27
	 */
	public function getExpertMapData($whereArr = array())
	{
		$sql = 'select bem.*,be.realname,be.nickname,be.mobile,be.email,be.idcard from bridge_expert_map as bem left join bridge_expert as be on bem.b_expert_id = be.id';
		return $this ->getCommonData($sql ,$whereArr ,'bem.id desc');
	}
	
	/**
	 * @method 获取管家修改的资料信息
	 * @author jiakairong
	 * @since  2015-11-30
	 * @param unknown $mapid
	 */
	public function getBridgeExpert($mapid)
	{
		$sql = 'select bem.expert_id,bem.id as mapid,bem.b_expert_certificate_ids,bem.b_expert_resume_ids,bem.reason,be.*,a.name as country_name,b.name as province_name,c.name as city_name,d.name as region_name from bridge_expert_map as bem left join bridge_expert as be on be.id = bem.b_expert_id left join u_area as a on a.id=be.country left join u_area as b on b.id=be.province left join u_area as c on c.id=be.city left join u_area as d on d.id=be.region where bem.id='.$mapid;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取管家从业简历
	 * @author jiakairong
	 * @since  2015-11-30
	 * @param unknown $ids  从业简历ID
	 */
	public function getExpertResume($ids)
	{
		$sql = 'select * from bridge_expert_resume where id in ('.$ids.') and status =1 order by id asc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取管家证书
	 * @author jiakairong
	 * @since  2015-11-30
	 * @param unknown $ids
	 */
	public function getExpertCertificate($ids)
	{
		$sql = 'select * from bridge_expert_certificate where id in ('.$ids.') and status =1 order by id asc';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 拒绝管家资料修改
	 * @param unknown $mapid
	 */
	public function refuseExpertUpdate($mapid ,$refuse_remark)
	{
		$sql = 'update bridge_expert_map set status = 2,refuse_remark="'.$refuse_remark.'" where id='.$mapid;
		return $this ->db ->query($sql);
	}
	/**
	 * @method 更新管家表
	 * @param intval  $expert_id  管家ID 
	 * @param unknown $expertArr  管家信息
	 * @param unknown $certificateArr  管家证书
	 * @param unknown $resumeArr 管家从业简历
	 */
	public function updateExpert($expert_id ,$expertArr ,$certificateArr ,$resumeArr ,$mapid)
	{
		$this->db->trans_start();
		//更新管家信息
		$this ->db ->where(array('id' =>$expert_id));
		$this ->db ->update('u_expert' ,$expertArr);
		
		//删除管家从业简历与证书
		$sql = 'delete from u_expert_resume where expert_id = '.$expert_id;
		$this ->db ->query($sql);
		
		$sql = 'delete from u_expert_certificate where expert_id = '.$expert_id;
		$this ->db ->query($sql);
		//更新管家简历
		if (!empty($resumeArr))
		{
			foreach($resumeArr as $val)
			{
				$val['expert_id'] = $expert_id;
				unset($val['id']);
				$this ->db ->insert('u_expert_resume' ,$val);
			}
		}
		//更新管家证书
		if (!empty($certificateArr))
		{
			foreach($certificateArr as $val)
			{
				$val['expert_id'] = $expert_id;
				unset($val['id']);
				$this ->db ->insert('u_expert_certificate' ,$val);
			}
		}
		
		//更新桥接表状态
		$sql = 'update bridge_expert_map set status = 1 where id ='.$mapid;
		$this ->db ->query($sql);
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}
}