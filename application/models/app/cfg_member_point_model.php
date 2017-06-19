<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * ===================================================================
 * @类别：用户积分配置公共模型
 * @作者：温文斌
 */
class Cfg_member_point_model extends MY_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'cfg_member_point';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
}