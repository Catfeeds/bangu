<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Union_bank_model extends MY_Model {
	protected  $table= 'b_union_bank';

	public function __construct() {
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取银行卡信息
	 * @author jkr
	 */
	public function getUnionBankData(array $whereArr=array() ,$orderBy = 'ub.id desc')
	{
		$sql = 'select ub.*,u.union_name,a.realname as username from b_union_bank as ub left join b_union as u on u.id = ub.union_id left join u_admin as a on a.id = ub.admin_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}

	
}