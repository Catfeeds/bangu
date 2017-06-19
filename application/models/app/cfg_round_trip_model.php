<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfg_round_trip_model extends MY_Model {
	
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'cfg_round_trip';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取周边游目的地配置 (用于平台)
	 * @param array $whereArr
	 * @param number $page
	 * @param number $size
	 */
	public function getRoundTripData($whereArr ,$page = 1, $num =10) {
		$this ->db ->select('crt.id,crt.isopen,crt.neighbor_id as dest_id,s.cityname,d.kindname');
		$this ->db ->from($this ->table_name .' as crt');
		$this ->db ->join('u_startplace as s', 's.id = crt.startplaceid' ,'left');
		$this ->db ->join('u_dest_base as d' ,'d.id = crt.neighbor_id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('crt.id' ,'desc');
		if ($page > 0) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		return $this ->db ->get() ->result_array();
	}
}