<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-03-02
 * @author		zhangyunfa
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfgm_integral_roll_pic_model extends MY_Model
{
	private $table_name = 'cfgm_social_roll_pic';
	public function __construct()
	{
		parent::__construct ($this->table_name );
	}
	/**
	 * @method 获取手机端轮播图数据
	 * @author zhangyunfa
	 * @since 2017-03-02
	 * @param unknown $whereArr
	 */
	public function getRollPicData(array $whereArr=array())
	{
		$sql = 'select * from cfgm_social_roll_pic where type=1 and kind=9';
		return $this ->getCommonData($sql ,$whereArr ,'id desc');
	}
}