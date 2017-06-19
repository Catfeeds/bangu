<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_limit_log_model extends MY_Model {
	protected  $table= 'b_limit_log';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取额度使用数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getLimitLogData(array $whereArr=array() ,$orderBy = 'addtime desc,id desc')
	{
		$sql = 'select log.* from b_limit_log as log  ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}

	
}