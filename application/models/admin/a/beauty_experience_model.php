<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Beauty_experience_model extends MY_Model {

	private $table_name = 'cfg_beauty_experience';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取首页体验师数据
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getExperienceData(array $whereArr=array())
	{
		$sql = 'select be.*,m.nickname,s.cityname from cfg_beauty_experience as be left join u_member as m on be.member_id = m.mid left join u_startplace as s on be.startplaceid = s.id';
		return $this ->getCommonData($sql ,$whereArr ,'be.id desc');
	}
	/**
	 * @method 获取数据详细
	 * @author jiakairong
	 */
	public function getExperienceDetail($id)
	{
		$sql = 'select be.*,m.nickname from cfg_beauty_experience as be left join u_member as m on be.member_id = m.mid where be.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}