<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_insurance_model extends MY_Model {
	
	private $table_name = 'u_line_insurance';
	
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取线路的保险
	 * @param unknown $whereArr
	 */
	public function getLineInsurance($whereArr = array()) {
		$whereStr = ' li.status = 1 and ti.status = 1 and';
		if (is_array($whereArr)) {
			foreach($whereArr as $key =>$val) {
				$whereStr .= " $key = '$val' and";
			}
			$whereStr = rtrim($whereStr ,'and');
		}
		$sql = 'select ti.* from u_line_insurance AS li left join u_travel_insurance as ti on ti.id = li.insurance_id where '.$whereStr;
		return  $this ->db ->query($sql) ->result_array();
	}
}