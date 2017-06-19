<?php
/**
 * 管家模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfgm_hot_dest_model extends MY_Model {

	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'cfgm_hot_dest';

	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	function e_result($whereArr, $orderby = "", $type='arr',$joinArr='',$fieldsArr="")
	{
		if(!empty($fieldsArr)){
			if (is_array($fieldsArr))
			{
				foreach($fieldsArr as $key => $value)
				{
					$this->db->select($value, FALSE);
				}
			}else{
				$this->db->select($fieldsArr);
			}
		}
		$this->db->where($whereArr);
		if(!empty($orderby)){
			$orderby = str_replace("@"," ",$orderby);
			$this->db->order_by($orderby);
		}
		if(!empty($joinArr)){
			$this->db->join($joinArr[0], $joinArr[1],$joinArr[2]);
		}
		$query = $this->db->get($this->table);
		if($type=='obj')return $query->result();
		elseif($type=='arr')return $query->result_array();
	}
}