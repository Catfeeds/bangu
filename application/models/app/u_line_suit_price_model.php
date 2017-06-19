<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_suit_price_model extends MY_Model {

	private $table_name = 'u_line_suit_price';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取线路的出发日期
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getLineSuieDate($whereArr ,$page=1 ,$num=10)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'="'.$val.'" and';
		}
		$whereStr = rtrim($whereStr ,'and');
		$limtStr = 'limit '.($page -1) * $num.','.$num;
		$sql = 'select day from u_line_suit_price where '.$whereStr.' group by day '.$limtStr;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取套餐详情
	 * @author jkr
	 * @since  2016-03-28
	 * @param unknown $whereArr
	 */
	public function getSuitPriceDetail(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'= "'.$val.'" and';
		}
		$sql = 'select sp.*,ls.unit,ls.suitname from u_line_suit_price as sp left join u_line_suit as ls on ls.id = sp.suitid where '.rtrim($whereStr,'and');
		return $this ->db ->query($sql) ->result_array();
	}
}