<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Live_gift_model extends APP_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	protected  $table= 'live_gift';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取礼物数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getGiftData(array $whereArr ,$orderBy = 'gift_id desc')
	{
		$sql = 'select * from live_gift';
		return $this ->queryCommon($sql ,$whereArr , $this ->getLimitStr() ,'order by '.$orderBy);
	}
	/**
	 * @method 获取记录总数
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getCiftCount(array $whereArr)
	{
		$sql = 'select count(gift_id) as count from live_gift';
		return $this ->queryCommonRow($sql ,$whereArr);
	}
	/**
	 * @method 获取一个礼物的信息
	 * @author jkr
	 * @param  intval $id
	 */
	public function getGiftDetail($id)
	{
		$sql = 'select * from live_gift where gift_id ='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
}