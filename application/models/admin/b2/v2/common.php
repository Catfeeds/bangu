<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:00:11
 * @author		温文斌
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common extends MY_Model {

	public function __construct() {
		parent::__construct();
	}
        /*
         * @name: 供应商详情
         * @return: 一维数组
         */
	function supplier_detail($supplier_id){
		$sql = "SELECT * FROM u_supplier where id={$supplier_id}";
		$row=$this->db->query($sql)->row_array();
		return $row;
	}
        public function expert_detail($expert_id){
		$sql = 'SELECT	* FROM u_expert  where id='.$expert_id;
		return $this ->db ->query($sql) ->row_array();
	}
}