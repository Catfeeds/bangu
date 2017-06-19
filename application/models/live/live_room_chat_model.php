<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Live_room_chat_model extends APP_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	protected  $table= 'live_room_chat';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table );
	}
	
}