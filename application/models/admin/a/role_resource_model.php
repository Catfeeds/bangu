<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Role_resource_model extends MY_Model {
	
	/**
	 * 模型表名称
	 *
	 * @var String
	 */
	private $table_name = 'pri_roleresource';
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
}