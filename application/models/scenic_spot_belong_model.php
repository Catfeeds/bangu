<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Scenic_spot_belong_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'scenic_spot_belong' );
	}
	/**
	 * @method 获取景点地区数据，用于平台管理
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 * @param string $specialSql
	 */
	public function getScenicAreaData (array $whereArr ,$orderBy = 'id desc',$specialSql='')
	{
		$sql = 'select * from scenic_spot_belong';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy,'',$specialSql);
	}
	/**
	 * @method 获取景点详细
	 * @param unknown $id
	 */
	public function getScenicDetail($id)
	{
		$sql = 'select s.*,a.pid as province,p.pid as country from scenic_spot as s left join u_area as a on a.id=s.area_id left join u_area as p on p.id=a.pid where s.id='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
}