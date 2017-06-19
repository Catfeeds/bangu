<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_expert_model extends MY_Model
{
	private $table_name = 'cfg_index_expert';
	public function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取首页配置管家数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getIndexExpertData(array $whereArr){
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'select ie.*,e.realname,a.name as cityname,a.pid,(select ua.name from u_area as ua where ua.id=a.pid) as pname from cfg_index_expert as ie left join u_expert as e on e.id=ie.expert_id left join u_area as a on a.id = ie.startplaceid '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by ie.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 获取一条数据的详细
	 * @param unknown $id
	 */
	public function getDetailData($id)
	{
		$sql = 'select ie.*,e.realname,a.pid as province,(select c.pid from u_area as c where c.id=a.pid) as country from cfg_index_expert as ie left join u_expert as e on e.id=ie.expert_id left join u_area as a on a.id = ie.startplaceid where ie.id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
}