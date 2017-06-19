<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind_theme_line_model extends MY_Model
{
	private $table_name = 'cfg_index_kind_theme_line';
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取首页分类主题线路数据
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getThemeLineData ($whereArr)
	{
		$sql = 'select tl.*,s.cityname,t.name as theme_name,l.linename,l.status as line_status from cfg_index_kind_theme_line as tl left join u_line as l on l.id=tl.line_id left join u_startplace as s on s.id=tl.startplaceid left join u_theme as t on t.id=tl.theme_id ';
		return $this ->getCommonData($sql ,$whereArr ,'tl.id desc');
	}
	/**
	 * @method 获取数据详细
	 * @param unknown $id
	 */
	public function getThemeLineDetail($id)
	{
		$sql = 'select cfg.*,l.linename,s.pid as province,(select us.pid from u_startplace as us where us.id=s.pid) as country from cfg_index_kind_theme_line as cfg left join u_line as l on l.id=cfg.line_id left join u_startplace as s on s.id=cfg.startplaceid where cfg.id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}