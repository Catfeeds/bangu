<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_area_model extends MY_Model {
	
	private $table_name = 'u_area';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 通过城市的id获取区域
	 * @param unknown $cityid 城市的id
	 */
	public function getRegion($cityid) {
		$sql = "select id,name from u_area where pid in ({$cityid})";
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取城市，用于地区插件选择
	 * @author jiakairong
	 * @since  2015-11-16
	 */
	public function getAreaAllData()
	{
		$sql = 'select * from u_area where isopen=1 and level <= 3 order by pid asc,displayorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 通过一组ID获取数据
	 * @param unknown $ids
	 * @param string $orderBy
	 */
	public function getAreaInData($ids ,$orderBy = 'id asc')
	{
		$sql = 'select * from u_area where id in ('.$ids.') and isopen=1 order by '.$orderBy;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * 通过城市名模糊查询一条城市数据
	 */
	public function get_row_city($cityname){
		$this->db->like('name',$cityname);
		$query = $this->db->get($this->table);
		return $query->row_array();
	}
}