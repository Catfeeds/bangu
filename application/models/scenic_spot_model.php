<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Scenic_spot_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'scenic_spot' );
	}
	public function batchUpdate($ids ,$admin_id) {
		$date = date('Y-m-d H:i:s' ,time());
		$sql = 'update scenic_spot set status=1,admin_id='.$admin_id.',open_time="'.$date.'" where id in ('.$ids.')';
		return $this->db->query($sql);
	}
	
	/**
	 * @method 获取景点数据，用于平台景点管理
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 * @param string $specialSql
	 */
	public function getScenicSpotData (array $whereArr ,$orderBy = 's.open_time desc',$specialSql='')
	{
		$sql = 'select s.*,d.kindname as cityname,a.username from scenic_spot as s left join u_dest_base as d on d.id = s.city_id left join u_dest_base as ud on ud.id = d.pid left join u_admin as a on a.id=s.admin_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy,'',$specialSql);
	}
	/**
	 * @method 获取景点详细
	 * @param unknown $id
	 */
	public function getScenicDetail($id)
	{
		$sql = 'select s.*,ua.id as province_id,ua.pid as country_id,c.kindname as city,ua.kindname as province,d.kindname as country from scenic_spot as s left join u_dest_base as c on c.id=s.city_id left join u_dest_base as ua on ua.id=c.pid left join u_dest_base as d on d.id=ua.pid  where s.id='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	public function updateScenic($scenicArr ,$picArr ,$id)
	{
		$this->db->trans_start();
		$this ->db ->where(array('id' =>$id)) ->update('scenic_spot' ,$scenicArr);
		$this ->db ->where(array('scenic_spot_id' =>$id)) ->delete('scenic_spot_pic');
		foreach($picArr as $v)
		{
			$dataArr = array(
					'scenic_spot_id' =>$id,
					'pic' =>$v
			);
			$this ->db ->insert('scenic_spot_pic' ,$dataArr);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	public function insertScenic($scenicArr ,$picArr)
	{
		$this->db->trans_start();
		$this ->db ->insert('scenic_spot' ,$scenicArr);
		$id = $this ->db ->insert_id();
		foreach($picArr as $v)
		{
			$dataArr = array(
					'scenic_spot_id' =>$id,
					'pic' =>$v
			);
			$this ->db ->insert('scenic_spot_pic' ,$dataArr);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 获取景点图片
	 * @author jkr
	 */
	public function getScenicPic($id)
	{
		$sql = 'select pic from scenic_spot_pic where scenic_spot_id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 更新景点图片
	 * @author jkr
	 * @param unknown $id
	 * @param unknown $picArr
	 */
	public function updatePic($id ,$picArr ,$mainpic)
	{
		$this->db->trans_start();
		$this ->db ->where(array('id' =>$id)) ->update('scenic_spot' ,array('mainpic' =>$mainpic));
		$this ->db ->delete('scenic_spot_pic' ,array('scenic_spot_id' =>$id));
		foreach($picArr as $val)
		{
			$this ->db ->insert('scenic_spot_pic' ,$val);
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}