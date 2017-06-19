<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind_theme_model extends MY_Model
{
	private $table_name = 'cfg_index_kind_theme';
	public function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取首页分类主题数据
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getKindThemeData (array $whereArr=array())
	{
		$sql = 'select ikt.*,s.cityname,t.name as theme_name,ik.name as kind_name from cfg_index_kind_theme as ikt left join cfg_index_kind as ik on ik.id=ikt.index_kind_id left join u_startplace as s on s.id=ikt.startplaceid left join u_theme as t on t.id=ikt.theme_id';
		return $this ->getCommonData($sql ,$whereArr ,'ikt.id desc');
	}
	/**
	 * @method 获取分类主题详细信息
	 * @author jiakairong
	 * @param unknown $id
	 */
	public function getDetailData($id)
	{
		$sql = 'select i.*,s.pid as province,(select p.pid from u_startplace as p where p.id=s.pid) as country from cfg_index_kind_theme as i left join u_startplace as s on i.startplaceid = s.id where i.id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取所有分类主题
	 * @author jiakairong
	 * @since  2015-11-27
	 */
	public function getKindThemeAll()
	{
		$sql = 'select kt.startplaceid,s.cityname,kt.theme_id,kt.name as theme_name,kt.id as kind_theme_id from cfg_index_kind_theme as kt left join u_startplace as s on kt.startplaceid = s.id where kt.is_show = 1';
		return $this ->db ->query($sql) ->result_array();
	}
}