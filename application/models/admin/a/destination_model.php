<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Destination_model extends MY_Model {
	
	private $table_name = 'u_dest_base';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取目的地数据，用于平台目的地管理
	 * @since  2016-01-18
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getDestinationData(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			if ($key == 'pid')
			{
				$whereStr .= ' (d.id = '.$val.' or d.pid = '.$val.') and';
			} 
			else 
			{
				$whereStr .= ' '.$key.'"'.$val.'" and';
			}
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'select d.*,ud.kindname as parent from u_dest_base as d left join u_dest_base as ud on ud.id = d.pid '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by d.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	
	/**
	 * @method 获取目的地的名称
	 * @author 贾开荣
	 * @param unknown $where
	 */
	public function get_name ($where) {
		$this ->db ->select('kindname');
		$this ->db ->from($this ->table_name);
		$this ->db ->where($where);
		$result=$this->db->get()->result_array();
		if (empty($result)) {
			return false;
		}
		return $result[0]['kindname'];
	}
	
	public function getDistination(){
		$query = $this->db->query ( "SELECT `id`, `kindname` AS name, `pid`, `enname`, `simplename`, `level`, `ishot` FROM `u_dest_base` WHERE `level` <= 3 ORDER BY `pid` ASC,displayorder ASC " );
		return $query->result_array();
	}
}