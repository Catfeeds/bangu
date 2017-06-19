<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年6月23日09:28
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_hot_search_model extends MY_Model
{
	private $table_name = 'cfg_index_hot_search';
	function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取热搜词数据数据
	 * @since  2016-02-25
	 * @author jiakairong
	 */
	public function getHotSearchData(array $whereArr)
	{
		$sql = 'select * from cfg_index_hot_search';
		return $this ->getCommonData($sql ,$whereArr ,'id desc');
	}
}