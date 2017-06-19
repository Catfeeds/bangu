<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_experience_model extends MY_Model {

	private $table_name = 'cfg_index_experience';

	function __construct() {
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取首页体验师数据
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getExperienceData(array $whereArr=array())
	{
		$sql = 'select ie.*,m.truename,m.nickname,s.cityname,tn.title from cfg_index_experience as ie left join u_member as m on ie.member_id = m.mid left join u_startplace as s on ie.startplaceid = s.id left join travel_note as tn on ie.travel_note_id = tn.id ';
		return $this ->getCommonData($sql ,$whereArr ,'ie.id desc');
	}
	/**
	 * @method 获取数据详细
	 * @author jiakairong
	 * @param unknown $id
	 */
	public function getExperienceDetail($id)
	{
		$sql = 'select ie.*,m.nickname,tn.title from cfg_index_experience as ie left join travel_note as tn on ie.travel_note_id = tn.id left join u_member as m on m.mid = ie.member_id where ie.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}