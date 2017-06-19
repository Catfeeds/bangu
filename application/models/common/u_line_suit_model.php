<?php
/**
 * 管家模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_suit_model extends MY_Model {

	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_line_suit';

	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}