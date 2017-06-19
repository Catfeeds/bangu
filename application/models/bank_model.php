<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2015-12-09
 * @author jiakairong
 * @method 银行卡管理
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Bank_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_bank_alipay' );
	}
	
	/**
	 * @method 获取银行卡数据，用于平台管理
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getBankData(array $whereArr ,$page=1 ,$num=10)
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			if (empty($val)) continue;
			if ($key == 'name')
			{
				$whereStr .= ' '.$key.' like "%'.$val.'%" and';
			}
			else 
			{
				$whereStr .= ' '.$key.'="'.$val.'" and';
			}
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$limitStr = ' limit '.($page-1)*$num.','.$num;
		$sql = 'select * from u_bank_alipay '.$whereStr.' order by id desc '.$limitStr;
		return $this ->db ->query($sql) ->result_array();
	}
}