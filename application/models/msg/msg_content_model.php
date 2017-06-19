<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Msg_content_model extends MY_Model {
	protected  $table= 'msg_content';

	public function __construct()
	{
		parent::__construct ( $this->table );
		$this->db = $this->load->database ( 'msg' ,true);
	}
	
	/**
	 * @method 获取消息内容
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getMsgContentData(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select * from msg_content';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * 获取消息内容，用于配置消息节点
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getContentPoint(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select content.* from msg_content as content';
		
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
}