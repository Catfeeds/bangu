<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Contract_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_contract' );
	}
	
	/**
	 * @method 获取合同用章
	 * @author jkr
	 */
	public function getContractChapter()
	{
		$sql = 'select * from b_contract_chapter_bangu where id = 1';
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 旅游合同数据,用于平台管理
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getContractData (array $whereArr ,$orderBy = 'id desc')
	{
		$sql = 'select id,type,left(content,300) as content from u_contract';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
}