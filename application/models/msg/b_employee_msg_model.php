<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_employee_msg_model extends MY_Model {
	protected  $table= 'b_employee_msg';

	public function __construct()
	{
		parent::__construct ( $this->table );
	}
	
	/**
	 * @method 获取旅行社的消息接收人
	 * @param unknown $code 消息编号
	 * @param unknown $step 消息步骤
	 */
	public function getUnionEmployee($union_id ,$role_id)
	{
		$sql = 'select em.employee_id from b_employee_msg as em left join b_employee as e on e.id=em.employee_id where em.role_id='.$role_id.' and e.union_id='.$union_id;
		return $this ->db ->query($sql) ->result_array();
	}
}