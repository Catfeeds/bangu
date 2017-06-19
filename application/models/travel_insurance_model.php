<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Travel_insurance_model extends MY_Model {
	
	function __construct()
	{
		parent::__construct ( 'u_travel_insurance' );
	}
	/**
	 * @method 获取保险用于用户下单
	 * @author jkr
	 * @since  2016-04-05
	 * @param  array $whereArr 条件数组
	 */
	public function getLineInsurance(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'="'.$val.'" and';
		}
		$sql = 'select t.id as tid,t.insurance_name,t.insurance_date,t.min_date,t.insurance_price,t.settlement_price,t.simple_explain,t.description,d.description as dict_name from u_travel_insurance as t left join u_dictionary as d on d.dict_id = t.insurance_kind where '.rtrim($whereStr ,'and');
		return $this ->db ->query($sql) ->result_array();
	}
}