<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Msg_main_model extends MY_Model {
	protected  $table= 'msg_main';

	public function __construct()
	{
		parent::__construct ( $this->table );
		$this->db = $this->load->database ( 'msg' ,true);
	}
	
	/**
	 * @method 获取消息发送步骤
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getMainStep($code)
	{
		$sql = 'select s.*,m.code from msg_main as m left join msg_step as s on s.main_id=m.id where m.code="'.$code.'"';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取消息
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getMsgMainData(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select main.*,a.username as admin_name from msg_main as main left join bangu.u_admin as a on a.id=main.admin_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取步骤及发送消息内容
	 * @param unknown $main_id 标题ID
	 */
	public function getMainStepPoint($main_id)
	{
		$sql = 'select s.description,s.step,p.*,c.content,c.type from msg_step as s left join msg_point as p on p.step_id=s.id left join msg_content as c on c.id=p.content_id where s.main_id='.$main_id.' and c.isopen = 1 order by s.step asc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	
	/**
	 * @method 配置消息节点
	 * @param unknown $mainStepArr
	 */
	public function addMsgPoint($mainStepArr)
	{
		$this->db->trans_start();
		//删除之前配置的
		$sql = 'delete from msg_point where main_id='.$mainStepArr[0]['main_id'];
		$this ->db ->query($sql);
		$sql = 'delete from msg_step where main_id='.$mainStepArr[0]['main_id'];
		$this ->db ->query($sql);
		
		foreach($mainStepArr as $val)
		{
			$pointArr = $val['point'];
			unset($val['point']);
			//写入步骤表
			$this ->db ->insert('msg_step' ,$val);
			$step_id = $this ->db ->insert_id();
			//写入节点表
			foreach($pointArr as $v)
			{
				$v['step_id'] = $step_id;
				$this ->db ->insert('msg_point' ,$v);
			}
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
}