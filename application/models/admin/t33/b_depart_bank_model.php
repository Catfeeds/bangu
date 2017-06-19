<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_depart_bank_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_depart_bank' );
	}
	
	/**
	 * @method 获取营业部银行卡数据
	 * @author jkr
	 */
	public function getDepartBankData(array $whereArr=array() ,$orderBy = 'd.id desc')
	{
		$sql = 'select db.*,d.union_name,d.name as depart_name,d.status,d.id as departId from b_depart_bank as db right join b_depart as d on d.id = db.depart_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	public function getDepartBankRow($depart_id)
	{
		$sql = 'select db.*,d.union_name,d.name as depart_name,d.id as departId from b_depart as d left join b_depart_bank as db on db.depart_id = d.id where d.id = '.$depart_id;
		return $this ->db ->query($sql) ->row_array();
	}
}