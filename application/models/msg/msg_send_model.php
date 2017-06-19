<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Msg_send_model extends MY_Model {
	protected  $table= 'msg_send';

	public function __construct()
	{
		parent::__construct ( $this->table );
		$this->db = $this->load->database ( 'msg' ,true);
	}
	
	/**
	 * @method 获取消息数据
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getMsgSendData(array $whereArr=array() ,$orderBy = 'ms.id desc')
	{
		$sql = 'select ms.* from msg_send as ms left join msg_send_people as sp on ms.id=sp.send_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取未读消息的数量
	 * @author jkr
	 */
	public function getUnreadMsgCount(array $whereArr)
	{
		$sql = 'select count(*) as count from msg_send as ms left join msg_send_people as sp on sp.send_id=ms.id '.$this->getWhereStr($whereArr);
		$countArr = $this ->db ->query($sql) ->row_array();
		return $countArr['count'];
	}
	
	/**
	 * @method 获取最新的5条消息，用于系统头部消息提示
	 * @author jkr
	 */
	public function getNewMsgData(array $whereArr)
	{
		$sql = 'select ms.* from msg_send as ms left join msg_send_people as sp on sp.send_id=ms.id '.$this->getWhereStr($whereArr).' order by ms.id desc limit 0,5';
		return $this ->db ->query($sql) ->result_array();
	}
	
	//获取消息信息
	public function getSendContent($sendid)
	{
		$sql = 'select s.*,c.type as content_type from msg_send as s left join msg_point as p on p.id = s.point_id left join msg_content as c on c.id=p.content_id where s.id='.$sendid;
		return $this ->db ->query($sql) ->row_array();
	}
	
}