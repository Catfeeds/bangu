<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class App_share_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'u_app_share' );
	}
	
	/**
	 * 获取数据
	 * @author jkr
	 */
	public function getData($whereArr)
	{
		$sql = 'select * from u_app_share'.$this ->getWhereStr($whereArr).' order by id desc '.$this->getLimitStr();
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 获取目的地总数
	 * @param array $whereArr 搜索条件
	 */
	public function getNum($whereArr)
	{
		$sql = 'select count(*) as count from u_app_share'.$this ->getWhereStr($whereArr);
		$countArr = $this ->db ->query($sql) ->row_array();
		return $countArr['count'];
	}
}