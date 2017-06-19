<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-03-04
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfgm_index_roll_pic_model extends MY_Model
{
	private $table_name = 'cfgm_index_roll_pic';
	public function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取手机端轮播图数据
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getRollPicData(array $whereArr=array())
	{
		$sql = 'select * from cfgm_index_roll_pic';
		return $this ->getCommonData($sql ,$whereArr ,'id desc');
	}
}