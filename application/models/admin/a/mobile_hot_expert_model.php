<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_hot_expert_model extends MY_Model {

	private $table_name = 'cfgm_hot_expert';

	function __construct() {
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取手机端热门管家数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getMhotExpert(array $whereArr){
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'select he.*,e.realname,a.name as cityname from cfgm_hot_expert as he left join u_expert as e on e.id=he.expert_id left join u_area as a on a.id = he.startplaceid '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by he.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}

	/**
	 * @method 获取手机热门管家详细
	 * @param unknown $id
	 */
	public function getMobileExpertDetail($id)
	{
		$sql = 'select he.*,e.realname,a.id as city,a.pid as province,c.pid as country from cfgm_hot_expert as he left join u_expert as e on e.id=he.expert_id left join u_area as a on a.id = he.startplaceid left join u_area as c on c.id = a.pid where he.id ='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
}