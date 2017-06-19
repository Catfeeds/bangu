<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Msg_point_model extends MY_Model {
	protected  $table= 'msg_point';

	public function __construct()
	{
		parent::__construct ( $this->table );
		$this->db = $this->load->database ( 'msg' ,true);
	}
	
	/**
	 * @method 获取消息节点的内容
	 * @param unknown $code 消息编号
	 * @param unknown $step 消息步骤
	 */
	public function getPointContent($code ,$step ,$belong)
	{
		$sql = 'select p.*,c.content,c.url,c.type,m.title,m.type as main_type from msg_main as m left join msg_step as s on s.main_id=m.id left join msg_point as p on p.step_id=s.id left join msg_content as c on c.id=p.content_id where m.code="'.$code.'" and s.step='.$step.' and p.belong ='.$belong.' and c.isopen=1';
		
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * 写入消息步骤记录表
	 * @param unknown $stepArr
	 * @param unknown $typeid
	 */
	public function insertSendStep($stepArr ,$typeid ,$name ,$key=0)
	{
		if (!empty($stepArr))
		{
			$num = count($stepArr);
			$time = date('Y-m-d H:i:s' ,time());
			$sql = 'insert into msg_send_step (`step`,`description`,`code`,`type_id`,`status`,`addtime`,`modtime`,`name`) values';
			foreach($stepArr as $k =>$v)
			{
				if ($num > 1 && $k<=$key)
				{
					$sql .= "({$v['step']},'{$v['description']}','{$v['code']}',$typeid,2,'$time','$time' ,'$name'),";
				}
				else
				{
					$sql .= "({$v['step']},'{$v['description']}','{$v['code']}',$typeid,0,'$time','$time' ,''),";
				}
			}
			$this ->db ->query(rtrim($sql,','));
		}
	}
}