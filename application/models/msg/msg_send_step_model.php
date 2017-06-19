<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Msg_send_step_model extends MY_Model {
	protected  $table= 'msg_send_step';

	public function __construct()
	{
		parent::__construct ( $this->table );
		$this->db = $this->load->database ( 'msg' ,true);
	}
	
	/**
	 * @method 获取消息步骤记录
	 * @param unknown $code 消息编号
	 * @param unknown $typeid 业务ID
	 */
	public function getSendStepData($code ,$typeid)
	{
		$sql = 'select * from msg_send_step where code="'.$code.'" and type_id='.$typeid;
		return $this ->db ->query($sql) ->result_array();
	}
}