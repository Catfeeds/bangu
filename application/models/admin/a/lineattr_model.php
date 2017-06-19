<?php
/***
*深圳海外国际旅行社
*艾瑞可
*
*2015-3-30 下午3:42:59
*2015
*UTF-8
****/
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Lineattr_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}

	public function getLineattrTreeDate(){
		$query = $this->db->query('SELECT id,attrname AS name,pid FROM u_line_attr ORDER BY pid');
		$rows = $query->result_array();
		$treeStr = "[";
		$this->getJsonTree($treeStr,$rows,0,1,0);
		$treeStr=$treeStr."]";
		return $treeStr;
	}
	
	/**
	 * 获取目的地
	 * @param string $ids 数组IDS
	 * @return string
	 */
	public function getLineattr($ids = null){
		
		if(null!=$ids){
			$sql = 'SELECT id,attrname AS name,pid FROM u_line_attr WHERE id!=0 ';
			$sql.=" AND id IN (";
			$i=0;
			foreach($ids as $v){
				if(!empty($v)){
					if($i>0){
						$sql.=',';
					}
					$sql.=$v;
					$i++;	
				}
				
			}
			$sql.=" ) ORDER BY displayorder ";
			$query = $this->db->query($sql,$ids);
			$rows = $query->result_array();
		}
		return $rows;
	}
	
}