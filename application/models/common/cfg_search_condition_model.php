<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * ===================================================================
 * @类别：搜索数据公共模型
 * @作者：何俊
 */
class Cfg_search_condition_model extends MY_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'cfg_search_condition';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
}