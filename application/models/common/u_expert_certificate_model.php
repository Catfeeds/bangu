<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_expert_certificate_model extends MY_Model {
	
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_expert_certificate';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}