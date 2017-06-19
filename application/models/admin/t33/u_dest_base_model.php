<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_dest_base_model extends MY_Model {
	
	private $table_name = 'u_dest_base';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * 获取目的地
	 * @param string $ids 数组IDS
	 * @return string
	 */
	public function getDestinations($ids = null){
		if(null!=$ids){
			$sql = 'SELECT id,kindname AS name,pid FROM u_dest_base WHERE id!=0 ';
			$sql.=" AND id IN (";
			$i=0;
			foreach($ids as $v){
				if($i>0){
					$sql.=',';
				}
				$sql.=$v;
				$i++;
			}
			$sql.=" )";
			$query = $this->db->query($sql,$ids);
			$rows = $query->result_array();
		}
		return $rows;
	}
	
}